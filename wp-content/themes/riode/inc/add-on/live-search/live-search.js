/**
 * Riode Plugin - LiveSearch
 * 
 * @requires jquery.autocomplete
 */
'use strict';
window.Riode || (window.Riode = {});

(function ($) {
	function LiveSearch(e, $selector) {
		if (!$.fn.devbridgeAutocomplete) {
			return;
		}

		if ('undefined' == typeof $selector) {
			$selector = $('.search-wrapper');
		} else {
			$selector = $selector;
		}

		$selector.each(function () {
			var $this = $(this),
				isFullscreen = $this.hasClass('hs-fullscreen'),
				$searchResult = $this.find('.search-results'),
				appendTo = isFullscreen ? $searchResult : $this.find('.live-search-list'),
				searchCat = $this.find('.cat'),
				postType = $this.find('input[name="post_type"]').val(),
				serviceUrl = riode_vars.ajax_url + '?action=riode_ajax_search&nonce=' +
					riode_vars.nonce + (postType ? '&post_type=' + postType : ''),
				flag = true,
				template = '<div class="search-product skel-pro-search2"></div>',
				skeleton = template.repeat(21);


			if (isFullscreen) {
				var renderProduct = function (item, query) {
					var html = '';
					html = '<a href="' + item.url + '">';
					if (item.img) {
						html += '<img class="search-image" src="' + item.img + '" width="219" height="219">';
					} else {
						html += '<img class="search-image" src="' + riode_vars.placeholder_img + '" width="219" height="219">';
					}
					html += '<div class="search-info">';
					html += '<div class="search-name">' + (query ? item.value.replace(query, '<b>' + query + '</b>') : item.value) + '</div>';
					if (item.price) {
						html += '<span class="search-price">' + item.price + '</span>';
					}
					html += '</div></a>';
					return html;
				};
				$this.find('.btn-search').on('click', function (e) {
					if (!$this.hasClass('viewall')) {
						e.preventDefault();
					}
					riode_vars.skeleton_screen && $searchResult.addClass('skeleton-body full-screen');
					appendTo.html(riode_vars.skeleton_screen ? skeleton : '<div class="d-loading"><i></i></div>');
					$this.find('.search-action .btn').css('display', 'none');

					$.ajax({
						type: 'GET',
						url: serviceUrl,
						data: {
							query: $this.find('input[type="search"]').val(),
							posts_per_page: 21,
							cat: searchCat.length ? searchCat.val() : 0
						},
						success: function (response) {
							$searchResult.removeClass('skeleton-body');
							appendTo.html('');
							var products = response['suggestions'],
								pages = response['pages'],
								html = '';
							if (products.length) {
								products.forEach(function (item, index) {
									html += '<div class="search-product">' + renderProduct(item, $this.find('input[type="search"]').val()) + '</div>';
								});
								if (($this.hasClass('fs-default') || $this.hasClass('fs-loadmore')) && pages > 1) {
									$this.find('.search-action .btn').css('display', 'block')
										.attr('current', 1);
								} else {
									$this.find('.search-action .btn').css('display', 'none');
								}
								if (($this.hasClass('fs-infinite'))) {
									if (pages == 1) {
										appendTo.attr('current', 'end');
									} else {
										appendTo.attr('current', 1);
									}
								}
							} else {
								html = '<div class="no-result"><p>' + riode_vars.texts.live_search_error + '</p><i class="d-icon-gift"></i></div>';
								$this.find('.search-action .btn').css('display', 'none');
							}
							appendTo.html(html);
							if ($this.hasClass('fs-infinite')) {
								flag = true;
							}
						}
					});
				})
				// View All or Load More
				$this.find('.search-action .btn').on('click', function (e) {
					var $button = $(this);
					e.preventDefault();
					if ($this.hasClass('fs-default')) {
						$this.find('form').submit();
					} else if ($this.hasClass('fs-loadmore')) {
						var current = $button.attr('current'),
							label = $button.html();
						$button.html('loading...');
						riode_vars.skeleton_screen && $searchResult.addClass('skeleton-body full-screen');
						appendTo.append(riode_vars.skeleton_screen ? skeleton : '');
						$.ajax({
							type: 'GET',
							url: serviceUrl,
							data: {
								query: $this.find('input[type="search"]').val(),
								posts_per_page: 21,
								current_page: current,
								cat: searchCat.length ? searchCat.val() : 0
							},
							success: function (response) {
								var products = response['suggestions'],
									pages = response['pages'],
									html = '';
								if (riode_vars.skeleton_screen) {
									appendTo.find('.skel-pro-search2').each(function (index) {
										if (index < products.length) {
											$(this).html(renderProduct(products[index], $this.find('input[type="search"]').val()))
												.removeClass('skel-pro-search2');
										} else {
											$(this).remove();
										}
									});
								} else {
									products.forEach(function (item, index) {
										html += '<div class="search-product">' + renderProduct(item, $this.find('input[type="search"]').val()) + '</div>';
									});
									appendTo.append(html);
								}

								if (pages > (Number(current) + 1)) {
									$this.find('.search-action .loadmore').css('display', 'block')
										.attr('current', Number(current) + 1);
								} else {
									$this.find('.search-action .loadmore').css('display', 'none');
								}

								$button.html(label);
								$searchResult.removeClass('skeleton-body');
							}
						});
					}
				});
				// Infinite Scroll
				if ($this.hasClass('fs-infinite')) {
					$searchResult.parent().on('scroll', function (e) {
						var scrollPos = $searchResult[0].clientHeight - this.clientHeight - this.scrollTop;
						if (flag && scrollPos < 10) {
							var current = appendTo.attr('current');
							flag = false;
							if ('end' != current) {
								riode_vars.skeleton_screen && $searchResult.addClass('skeleton-body full-screen');
								appendTo.append(riode_vars.skeleton_screen ? skeleton : '<div class="d-loading"><i></i></div>');
								$.ajax({
									type: 'GET',
									url: serviceUrl,
									data: {
										query: $this.find('input[type="search"]').val(),
										posts_per_page: 21,
										current_page: current,
										cat: searchCat.length ? searchCat.val() : 0
									},
									success: function (response) {
										var products = response['suggestions'],
											pages = response['pages'],
											html = '';
										if (riode_vars.skeleton_screen) {
											appendTo.find('.skel-pro-search2').each(function (index) {
												if (index < products.length) {
													$(this).html(renderProduct(products[index], $this.find('input[type="search"]').val()))
														.removeClass('skel-pro-search2');
												} else {
													$(this).remove();
												}
											});
										} else {
											appendTo.find('.d-loading').remove();
											products.forEach(function (item, index) {
												html += '<div class="search-product">' + renderProduct(item, $this.find('input[type="search"]').val()) + '</div>';
											});
											appendTo.append(html);
										}

										if (pages > (Number(current) + 1)) {
											appendTo.attr('current', Number(current) + 1);
										} else {
											appendTo.attr('current', 'end');
										}

										$searchResult.removeClass('skeleton-body');
										flag = true;
									}
								});
							}
						}
					})
				}
			} else {
				$this.find('input[type="search"]').devbridgeAutocomplete({
					minChars: 3,
					appendTo: appendTo,
					triggerSelectOnValidInput: true,
					serviceUrl: serviceUrl,
					onSearchStart: function () {
						riode_vars.skeleton_screen && $this.addClass('skeleton-body');
						appendTo.children().eq(0)
							.html(riode_vars.skeleton_screen ? '<div class="skel-pro-search"></div><div class="skel-pro-search"></div><div class="skel-pro-search"></div>' : '<div class="d-loading"><i></i></div>')
							.css({ position: 'relative', display: 'block' });
					},
					onSelect: function (item) {
						if (item.id != -1) {
							window.location.href = item.url;
						}
					},
					onSearchComplete: function (q, suggestions) {
						$this.removeClass('skeleton-body');
						if (!suggestions.length) {
							appendTo.children().eq(0).hide();
						}
					},
					beforeRender: function (container) {
						$(container).removeAttr('style');
					},
					formatResult: function (item, currentValue) {
						var pattern = '(' + $.Autocomplete.utils.escapeRegExChars(currentValue) + ')',
							html = '';
						if (item.img) {
							html += '<img class="search-image" src="' + item.img + '">';
						}
						html += '<div class="search-info">';
						html += '<div class="search-name">' + item.value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') + '</div>';
						if (item.price) {
							html += '<span class="search-price">' + item.price + '</span>';
						}
						html += '</div>';

						return html;
					}
				});

				if (searchCat.length) {
					var searchForm = $this.find('input[type="search"]').devbridgeAutocomplete();
					searchCat.on('change', function (e) {
						if (searchCat.val() && searchCat.val() != '0') {
							searchForm.setOptions({
								serviceUrl: serviceUrl + '&cat=' + searchCat.val()
							});
						} else {
							searchForm.setOptions({
								serviceUrl: serviceUrl
							});
						}

						searchForm.hide();
						searchForm.onValueChange();
					});
				}
			}
		});
	}

	Riode.liveSearch = LiveSearch;
	$(window).on('riode_complete', Riode.liveSearch);
})(jQuery);