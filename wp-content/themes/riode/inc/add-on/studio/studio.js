/**
 * Riode Studio Library
 */
'use strict';

(function ($) {

	var $addStudioSection = false; // Add studio block section when add is triggered

	$(document).ready(function () {
		if ($(document.body).hasClass('elementor-editor-active') && typeof elementor != 'undefined') {
			// Riode Elementor Studio
			window.runStudio = function (addButton) {
				$('#riode-elementor-panel-riode-studio').trigger('click');
				addButton && ($addStudioSection = $(addButton).closest('.elementor-add-section'));
			}
			elementor.on('document:loaded', setupStudioBlocks);
		} else {
			// New Template Studio
			setupStudioBlocks();
		}
	});

	function setupStudioBlocks() {

		if ($('.blocks-wrapper .blocks-list').length) {

			var filter_status = '',
				page_type = 'e';

			$(document.body).find('#wpb_visual_composer').length>0 && (page_type = 'w');
			$(document.body).hasClass('vc_inline-shortcode-edit-form') && (page_type = 'w');
			var riode_blocks_cur_page = 1;

			function wpbMergeContent(response,block_id) {
				if( response && response.content ) {
					if ( typeof vc != 'undefined' && vc.storage ) { // WPBakery backend editor
						vc.storage.append( response.content );
						vc.shortcodes.fetch( {
							reset: !0
						} ), _.delay( function () {
							window.vc.undoRedoApi.unlock();
						}, 50 );
					} else if ( window.vc_iframe_src ) { // WPBakery frontend editor
						var render_data = { action: 'vc_frontend_load_template', block_id: block_id, content: response.content, wpnonce: riode_studio.wpnonce, template_unique_id: '1', template_type: 'my_templates', vc_inline: true, _vcnonce: window.vcAdminNonce };
						if ( response.meta ) {
							render_data.meta = response.meta;
						}
						$.ajax( {
							url: window.vc_iframe_src.replace( /&amp;/g, '&' ),
							type: 'post',
							data: render_data,
							success: function ( html ) {
								var template, data;
								_.each( $( html ), function ( element ) {
									if ( 'vc_template-data' === element.id ) {
										try {
											data = JSON.parse( element.innerHTML );
										} catch ( err ) { }
									}
									if ( 'vc_template-html' === element.id ) {
										template = element.innerHTML;
									}
								} );
								if ( template && data ) {
									vc.builder.buildFromTemplate( template, data );
									vc.closeActivePanel();
								}
							},
						} );
					}
				}

				if ( response && response.meta ) {
					if( response.meta.page_css && $(".postbox-container #wpb_visual_composer").length > 0 ) {
						$('#vc_post-custom-css').val( $('#vc_post-custom-css').val() + response.meta.page_css );
						$('#vc_ui-panel-post-settings').css('display', 'none');
						$('#vc_post-settings-button').trigger('click');
						$('#vc_ui-panel-post-settings .vc_ui-panel-footer .vc_ui-button-fw').trigger('click');
						$('#vc_ui-panel-post-settings').css('display', '');
					}
					if( response.meta.page_js && $("#page_js").length > 0 ) {
						$("#page_js").val($("#page_js").val() + response.meta.page_js);
					}
					if ( window.vc_iframe_src ) {
						if ( typeof riode_studio[ 'meta_fields' ] == 'undefined' ) {
							riode_studio[ 'meta_fields' ] = {};
						}
						if ( response.meta.page_css ) {
							$('#vc_post-custom-css').val( $('#vc_post-custom-css').val() + response.meta.page_css );
							$('#vc_ui-panel-post-settings').css('display', 'none');
							$('#vc_post-settings-button').trigger('click');
							$('#vc_ui-panel-post-settings .vc_ui-panel-footer .vc_ui-button-fw').trigger('click');
							$('#vc_ui-panel-post-settings').css('display', '');
						}
						if ( response.meta.page_js ) {

							if ( typeof riode_studio[ 'meta_fields' ][ 'page_js' ] == 'undefined' )
								riode_studio[ 'meta_fields' ][ 'page_js' ] = '';
							if ( riode_studio[ 'meta_fields' ][ 'page_js' ].indexOf( response.meta.page_js ) === -1 )
								riode_studio[ 'meta_fields' ][ 'page_js' ] += response.meta.page_js;
						}
					}
				}
				if ( response && response.error ) {
					alert( response.error );
				}

			}
			function mergeContent(response) {
				if (response) {
					if (response.content) {
						var addID = function (content) {
							Array.isArray(content) &&
								content.forEach(function (item, i) {
									item.elements && addID(item.elements);
									item.elType && (content[i].id = elementor.helpers.getUniqueID());
								});
						};

						if (Array.isArray(response.content) && 1 == response.content.length) {
							if ('widget' == response.content[0].elType) {
								response.content = [{
									elType: 'section',
									elements: [{
										elType: 'column',
										elements: response.content
									}]
								}];
							} else if ('column' == response.content[0].elType) {
								response.content = [{
									elType: 'section',
									elements: response.content
								}];
							}
						}

						addID(response.content);

						// import studio block to end or add-section
						elementor.getPreviewView().addChildModel(response.content,
							$addStudioSection && $addStudioSection.parent().hasClass('elementor-section-wrap') ? (
								$addStudioSection.find('.elementor-add-section-close').trigger('click'), {
									at: $addStudioSection.index()
								}) : {}
						);

						// active save button or save elementor
						if (elementor.saver && elementor.saver.footerSaver && elementor.saver.footerSaver.activateSaveButtons) {
							elementor.saver.footerSaver.activateSaveButtons(document, 'publish');
						} else {
							$e.run('document/save/publish');
						}
					}
					if (response.meta) {
						for (var key in response.meta) {
							var value = response.meta[key].replace('/<script.*?\/script>/s', ''),
								key_data = elementor.settings.page.model.get(key);
							if (typeof key_data == 'undefined') {
								key_data = '';
							}
							if (!key_data || key_data.indexOf(value) === -1) {
								elementor.settings.page.model.set(key, key_data + value);
							}
							if ('page_css' == key) {
								elementorFrontend.hooks.doAction('refresh_page_css', key_data + value);
								$('textarea[data-setting="page_css"]').val(key_data + value);
							}
						}
					}
					if (response.error) {
						alert(response.error);
					}
				}
			}

			function showBlocks(e, cur_page, demo_filter) {
				e.preventDefault();

				// if still loading
				if ($('.blocks-wrapper').hasClass('loading')) {
					return false;
				}

				var $this = $(this);

				// if toggle is clicked
				if (e.target.tagName == 'I') { // Toggle children
					$this.siblings('ul').stop().slideToggle(200);
					$this.children('i').toggleClass('fa-chevron-down fa-chevron-up');
					return false;
				}

				// if active category is clicked
				if ($this.hasClass('active') && !$this.parent().hasClass('filtered') && (typeof cur_page == 'undefined' || cur_page == 1)) {
					return false;
				}

				var $list = $('.blocks-wrapper .blocks-list'),
					$categories = $('.blocks-wrapper .block-categories');

				// if top category is clicked
				if (typeof $this.data('filter-by') == 'undefined' && !$this.parent('.filtered').length) {
					if ($this.hasClass('all')) { // Show all categories
						$categories.removeClass('hide');
						$list.siblings('.coming-soon').remove();

					} else { // Show empty category
						$categories.addClass('hide');
						$list.isotope('remove', $list.children()).css('height', '');
						$list.siblings('.coming-soon').length || $list.before('<div class="coming-soon">' + riode_studio.texts.coming_soon + '</div>');
					}
					$('.blocks-wrapper .category-list a').removeClass('active');
					$this.addClass('active');
				} else {
					riode_blocks_cur_page = typeof cur_page == 'undefined' ? 1 : parseInt(cur_page, 10);

					if (riode_blocks_cur_page > 1) {
						if (!$categories.hasClass('hide')) {
							return;
						}
						$('.blocks-wrapper').addClass('infiniteloading');
					}

					if (!$categories.hasClass('hide')) {
						$list.isotope('remove', $list.children());
						$categories.addClass('hide');
					}

					$list.siblings('.coming-soon').remove();

					var cat = $this.data('filter-by'),
						loaddata = {
							action: 'riode_studio_filter_category',
							category_id: cat,
							wpnonce: riode_studio.wpnonce,
							page: riode_blocks_cur_page,
							type: page_type
						};

					if (typeof demo_filter != 'undefined') {
						loaddata.demo_filter = demo_filter;
					}
					if (!$(document.body).hasClass('elementor-editor-active') && !( $(document.body).hasClass('vc_inline-shortcode-edit-form') || $(document.body).find('#wpb_visual_composer').length>0 ) ) {
						loaddata.new_template = true;
					}
					if ($('.blocks-wrapper .block-category-favourites.active').length && riode_blocks_cur_page > 1) {
						loaddata.current_count = $list.data('isotope').items.length;
					}
					$('.blocks-wrapper').addClass('loading');

					$.ajax({
						url: ajaxurl,
						type: 'post',
						dataType: 'html',
						data: loaddata,
						success: function (response) {
							if ('error' == response) {
								$('.blocks-wrapper').removeClass('loading').removeClass('infiniteloading');
								return;
							}

							var $response = $(response);

							// demo filter
							if (typeof demo_filter != 'undefined') {
								var total_page = $response.filter('#total_pages').text();
								$this.data('total-page', total_page ? parseInt(total_page, 10) : 1);
								$response = $response.filter('.block');
							} else {
								$('.blocks-wrapper .btn').prop('disabled', false);
							}

							// first page
							if (riode_blocks_cur_page === 1) {
								$list.isotope('remove', $list.children());
							}

							// make category active
							$('.blocks-wrapper .category-list a').removeClass('active');
							$this.addClass('active');

							// layout
							$response.imagesLoaded(function () {
								$list.append($response).isotope('appended', $response).isotope('layout');
								$('.blocks-wrapper').removeClass('loading').removeClass('infiniteloading');
								$('.blocks-wrapper .blocks-section').trigger('scroll');
							});
						}
					}).fail(function () {
						alert(riode_studio.texts.loading_failed);
						$('.blocks-wrapper').removeClass('loading').removeClass('infiniteloading');
					});
				}
			}

			function importBlock(block_id, callback, $obj) {
				var jqxhr = $.ajax({
					url: ajaxurl,
					type: 'post',
					dataType: 'json',
					data: {
						action: 'riode_studio_import',
						block_id: block_id,
						wpnonce: riode_studio.wpnonce,
						type: page_type,
						mine: 'my' == $('.blocks-wrapper .category-list a.active').data('filter-by')
					},
					success: function (response) {
						if( page_type == 'e' ) {
							mergeContent(response);
						} else {
							wpbMergeContent(response, block_id);
						}
						$obj && $obj.addClass('imported');
					},
					failure: function () {
						alert(riode_studio.texts.importing_error);
					}
				});
				callback && jqxhr.always(callback);
			}

			function importBlockHandler(e) {
				e.preventDefault();
				var $this = $(this),
					$block = $this.closest('.block');
				$this.attr('disabled', 'disabled');
				$block.addClass('doing');

				importBlock($this.parent().data('id'), function () {
					$this.prop('disabled', false);
					$block.removeClass('doing');
				}, $block);
			}

			function selectBlock() {
				var $this = $(this),
					category = $(this).parent().data('category');

				if ( parseInt( category ) ) {
					if ( category == 8 ) {
						$('.riode-new-template-form .template-type').val('header');
					} else if ( category == 9 ) {
						$('.riode-new-template-form .template-type').val('footer');
					} else if ( category == 10 ) {
						$('.riode-new-template-form .template-type').val('product_layout');
					} else if ( category == 11 ) {
						$('.riode-new-template-form .template-type').val('popup');
					} else {
						$('.riode-new-template-form .template-type').val('block');
					}
				} else {
					$('.riode-new-template-form .template-type').val(category);
				}

				$('.blocks-wrapper .block.selected').removeClass('selected');
				$('#riode-new-template-id').val($this.parent().data('id'));
				if( $('.blocks-wrapper .block-category-my-templates.active').length )
					$('#riode-new-template-type').val( 'my' );
				else {
					if( $('#riode-elementor-studio').is(':checked') ) {
						$('#riode-new-template-type').val( 'e' );
					} else if( $('#riode-wpbakery-studio').is(':checked') ) {
						$('#riode-new-template-type').val( 'w' );
					}
				}
				$('#riode-new-template-name').val($this.closest('.block').addClass('selected').find('.block-title').text());
				closeStudio();
			}

			function favourBlock() {
				var $this = $(this),
					$block = $this.closest('.block').addClass('doing'),
					$list = $('.blocks-wrapper .blocks-list'),
					$count = $('.blocks-wrapper .block-category-favourites span'),
					favourdata = {
						action: 'riode_studio_favour_block',
						wpnonce: riode_studio.wpnonce,
						block_id: $this.parent().data('id'),
						type: page_type,
						active: $block.hasClass('favour') ? 0 : 1,
					};

				if ($('.blocks-wrapper .block-category-favourites.active').length) {
					favourdata.current_count = $list.data('isotope').items.length;
				}

				$.post(ajaxurl, favourdata, function (response) {
					$block.toggleClass('favour');

					var count = (parseInt($count.text().replace('(', '').replace(')', '')) + ($block.hasClass('favour') ? 1 : -1));
					$count.text('(' + count + ')').parent().data('total-page', Math.ceil(count / riode_studio.limit));

					if (typeof favourdata.current_count != 'undefined') {
						var $response = $(response);

						$list.isotope('remove', $block);
						if (response && response.trim()) {
							$list.append($response).isotope('appended', $response);
						}
						$list.isotope('layout');
						riode_blocks_cur_page = Math.ceil(favourdata.current_count / riode_studio.limit);
					}

				}).always(function () {
					$block.removeClass('doing');
				});
			}

			function saveMetaField(e) {
				if ( $('.postbox-container #wpb_visual_composer').length == 0 && riode_studio[ 'meta_fields' ] && vc_post_id ) {
					$.ajax( {
						url: ajaxurl,
						type: 'post',
						dataType: 'json',
						data: { action: 'riode_studio_save', post_id: vc_post_id, nonce: riode_studio.wpnonce, fields: riode_studio[ 'meta_fields' ] }
					} );
				}
			}
			function resetSelected() {
				$('.blocks-wrapper .block.selected').removeClass('selected');
				$('#riode-new-template-id').val('');
				$('#riode-new-template-type').val('');
				$('#riode-new-template-name').val('');
			}

			function changeFilter() {
				if (filter_status != $(this).val()) {
					$('.demo-filter .btn').prop('disabled', false);
				} else {
					$('.demo-filter .btn').attr('disabled', 'disabled');
				}
			}

			function doFilter(e, cur_page) {
				e.preventDefault();
				var $this = $(this),
					prefix = '',
					filter = [];
				if (typeof cur_page == 'undefined') {
					cur_page = 1;
				}
				filter_status = $this.closest('.demo-filter').find('.filter-select').val();

				if ($this.closest('.demo-filter').find('.filter-select').val()) {
					prefix = '';
					if( page_type == 'w' ) {
						prefix = 'wpb-';
					}
					filter[0] = prefix + $this.closest('.demo-filter').find('.filter-select').val();
				}

				if (filter.length) {
					$('.blocks-wrapper .filtered>a').trigger('click', [cur_page, filter]);
				} else {
					$('.blocks-wrapper .all').trigger('click');
				}
				$this.attr('disabled', 'disabled');
			}

			function openCategory(e) {
				if (this.getAttribute('data-category')) {
					$('.blocks-wrapper .block-category-' + this.getAttribute('data-category')).trigger('click');
				}
				e.preventDefault();
			}

			function closeStudio() {
				$('.blocks-wrapper').addClass('closed');
			}

			function openStudio(e) {
				e.preventDefault();
				if ($(this).hasClass('disabled')) {
					return false;
				}
				$(this).addClass('disabled');

				$('.blocks-wrapper img[data-original]').each(function () {
					$(this).attr('src', $(this).data('original'));
					$(this).removeAttr('data-original');
				});

				$('.blocks-wrapper').imagesLoaded(function () {
					$('#riode-elementor-panel-riode-studio, #wpb-riode-studio-trigger, #riode-new-studio-trigger').removeClass('disabled');
					$('.blocks-wrapper').removeClass('closed');
					setTimeout(function () {
						if (!$('.blocks-wrapper .blocks-list').hasClass('initialized')) {
							$('.blocks-wrapper .blocks-list').addClass('initialized').isotope({
								itemSelector: '.block',
								layoutMode: 'masonry'
							});

							$('.blocks-wrapper .blocks-section').on('scroll', function () {
								var $this = $(this),
									$wrapper = $this.closest('.blocks-wrapper');
								if ($wrapper.length) {
									var top = $this.children().offset().top + $this.children().height() - $this.offset().top - $this.height();

									if (top <= 10 && !$wrapper.hasClass('loading') && parseInt($wrapper.find('.category-list a.active').data('total-page'), 10) >= riode_blocks_cur_page + 1) {
										var filterBy = $wrapper.find('.category-list a.active').data('filter-by');
										if (parseInt(filterBy, 10) || 'blocks' == filterBy || '*' == filterBy || 'my' == filterBy) {
											$wrapper.find('.category-list a.active').trigger('click', [riode_blocks_cur_page + 1]);
										} else if ('all' != filterBy) {
											$wrapper.find('.demo-filter .btn').trigger('click', [riode_blocks_cur_page + 1]);
										}
									}
								}
							});

							$('.blocks-wrapper .blocks-section').trigger('scroll');
						}
						$('.blocks-wrapper .blocks-list').isotope('layout');
					}, 100);
				});
			}

			function confirmPageType(e) {
				if ( 'e' == riode_studio.page_type || 'w' == riode_studio.page_type ) {
					page_type = riode_studio.page_type;
				} else {
					var new_type = '';
					if( $('#riode-elementor-studio').is(':checked') ) {
						new_type = 'e';
					} else if ( $('#riode-wpbakery-studio').is(':checked') ) {
						new_type = 'w';
					}
					if (page_type != new_type) {
						page_type = new_type;

						$('.blocks-wrapper').addClass('loading');

						$.ajax({
							url: ajaxurl,
							type: 'post',
							dataType: 'html',
							data: {
								action: 'riode_studio_filter_category',
								wpnonce: riode_studio.wpnonce,
								page: 1,
								type: page_type,
								full_wrapper: true,
								new_template: true
							},
							success: function (response) {
								if ('error' != response) {
									var $response = $(response),
										$list = $('blocks-wrapper .blocks-list');

									$list.hasClass('initialized') && $list.isotope('remove', $list.children()).css('height', '');
									$('.blocks-wrapper .block-categories.hide').removeClass('hide');
									$('.blocks-wrapper .category-list').html($response.find('.category-list').html());
									$('.blocks-wrapper .filter-select').html($response.find('.filter-select').html());
								}
								$('.blocks-wrapper').removeClass('loading');
							}
						}).fail(function () {
							alert(riode_studio.texts.loading_failed);
							$('.blocks-wrapper').removeClass('loading');
						});
					}
				}
				openStudio.call(this, e);
			}

			function importStartTemplate() {
				riode_studio.start_template && importBlock(parseInt(riode_studio.start_template));
				if( riode_studio.start_template_content ) {
					if( 'e' == page_type ) {
						mergeContent(riode_studio.start_template_content);
					} else {
						wpbMergeContent(riode_studio.start_template_content);
					}
				}
			}

			$(document.body)
				.on('click', '.blocks-wrapper .category-list a', showBlocks)
				.on('click', '.blocks-wrapper .blocks-list .import', importBlockHandler)
				.on('click', '.blocks-wrapper .blocks-list .select', selectBlock)
				.on('click', '.blocks-wrapper .blocks-list .favourite', favourBlock)
				.on('click', '#riode-elementor-panel-riode-studio, #wpb-riode-studio-trigger', openStudio)
				.on('click', '#riode-new-studio-trigger', confirmPageType)
				.on('click', '.blocks-wrapper .mfp-close', closeStudio)
				.on('click', '.blocks-wrapper .block-category', openCategory)
				.on('click', '#vc_button-update', saveMetaField);
			$('.blocks-wrapper .demo-filter .filter-select').on('change', changeFilter);
			$('.blocks-wrapper .demo-filter .btn').on('click', doFilter);

			$('#riode-elementor-studio').on('change', resetSelected);

			importStartTemplate();
		}
	}
})(jQuery);