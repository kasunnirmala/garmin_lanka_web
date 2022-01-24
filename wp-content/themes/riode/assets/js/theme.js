/**
 * Riode Theme Library
 */
'use strict';
window.Riode || (window.Riode = {});

/**
 * Riode Base
 */
(function ($) {
	// Properties & Status
	Riode.$window = $(window);
	Riode.$body = $(document.body);
	Riode.status = 'loading';

	// Detect Internet Explorer
	Riode.isIE = navigator.userAgent.indexOf("Trident") >= 0;
	// Detect Edge
	Riode.isEdge = navigator.userAgent.indexOf("Edge") >= 0;
	// Detect Mobile
	Riode.isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

	// Canvas Size
	Riode.canvasWidth = window.innerWidth;
	Riode.resizeTimeStamp = 0;
	Riode.resizeChanged = false;
	Riode.scrollbarSize = -1;

	Riode.defaults = {};
	riode_vars.sales_popup && (Riode.defaults.sales_popup_start = riode_vars.sales_popup.start ? parseInt(riode_vars.sales_popup.start) * 1000 : 5000);
	riode_vars.sales_popup && (Riode.defaults.sales_popup_interval = riode_vars.sales_popup.interval ? parseInt(riode_vars.sales_popup.interval) * 1000 : 60000);
	Riode.defaults.popup = {
		removalDelay: 350,
		callbacks: {
			beforeOpen: function () {
				var scrollBarWidth = window.innerWidth - document.body.clientWidth;
				$('.sticky-content.fixed').css('margin-right', scrollBarWidth);
				$('html').css('margin-right', scrollBarWidth).css('overflow-y', 'hidden');
				$('.sticky-icon-links').css('margin-right', scrollBarWidth);
				$('body').css('overflow-x', 'visible');
				$('.mfp-wrap').css('overflow', 'hidden auto');
			},
			close: function () {
				$('html').css('overflow-y', '').css('margin-right', '');
				$('body').css('overflow-x', 'hidden');
				$('.sticky-icon-links').css('margin-right', '');
				$('.mfp-wrap').css('overflow', '');
				$('.sticky-content.fixed').css('margin-right', '');
			}
		},
	}

	// Shop Page
	Riode.enableStickyToolbox = riode_vars.shop_toolbox_sticky;

	/**
	 * @function call		Make a macro task
	 * @param {function} fn  	Callback function
	 * @param {number} delay 	Delay time
	 */
	Riode.call = function (fn, delay) {
		riode_vars.resource_split_tasks || delay ? setTimeout(fn, delay) : fn();
	}

	/**
	 * @function byId			Get dom element by id
	 * @param {string} id
	 * @return {HTMLElement
	 */
	Riode.byId = function (id) {
		return document.getElementById(id);
	}

	/**
	 * @function byTag				Get dom elements by tagName
	 * @param {string} tagName
	 * @param {HTMLElement} root 	This can be omitted.
	 * @return {HTMLCollection}
	 */
	Riode.byTag = function (tagName, root) {
		return root ? root.getElementsByTagName(tagName) : document.getElementsByTagName(tagName);
	}

	/**
	 * @function byClass			Get dom elements by className
	 * @param {string} className
	 * @param {HTMLElement} root 	This can be omitted.
	 * @return {HTMLCollection}
	 */
	Riode.byClass = function (className, root) {
		return root ? root.getElementsByClassName(className) : document.getElementsByClassName(className);
	}

	/**
	 * @function $						Get jQuery object
	 * @param {string|jQuery} selector	Selector
	 * @param {string|jQuery} find		Find
	 * @return {jQuery|Object}			jQuery Object or {each: $.noop}
	 */
	Riode.$ = function (selector, find) {
		if (typeof selector == 'string' && typeof find == 'string') {
			return $(selector + ' ' + find);
		}
		if (selector instanceof jQuery) {
			if (typeof find == 'undefined') {
				return selector;
			}
			return selector.find(find);
		}
		if (typeof selector == 'undefined' || !selector) {
			return $(find);
		}
		if (typeof find == 'undefined') {
			return $(selector);
		}
		return $(selector).find(find);
	}


	/**
	 * @function getCache
	 */
	Riode.getCache = function () {
		return localStorage[riode_vars.riode_cache_key] ? JSON.parse(localStorage[riode_vars.riode_cache_key]) : {};
	}

	/**
	 * @function setCache
	 * @param {mixed} cache
	 */
	Riode.setCache = function (cache) {
		localStorage[riode_vars.riode_cache_key] = JSON.stringify(cache);
	}

	/**
	 * @function requestTimeout
	 * @param {function} fn
	 * @param {number} delay
	 */
	Riode.requestTimeout = function (fn, delay) {
		var handler = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame;
		if (!handler) {
			return setTimeout(fn, delay);
		}
		delay || (delay = 0);
		var start, rt = new Object();

		function loop(timestamp) {
			if (!start) {
				start = timestamp;
			}
			var progress = timestamp - start;
			progress >= delay ? fn() : rt.val = handler(loop);
		};

		rt.val = handler(loop);
		return rt;
	}

	/**
	 * @function requestInterval
	 * @param {function} fn
	 * @param {number} step
	 * @param {number} timeOut
	 */
	Riode.requestInterval = function (fn, step, timeOut) {
		var handler = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame;
		if (!handler) {
			if (!timeOut)
				return setTimeout(fn, timeOut);
			else
				return setInterval(fn, step);
		}
		var start, last, rt = new Object();
		function loop(timestamp) {
			if (!start) {
				start = last = timestamp;
			}
			var progress = timestamp - start;
			var delta = timestamp - last;
			if (!timeOut || progress < timeOut) {
				if (delta > step) {
					rt.val = handler(loop);
					fn();
					last = timestamp;
				} else {
					rt.val = handler(loop);
				}
			} else {
				fn();
			}
		};
		rt.val = handler(loop);
		return rt;
	}

	/**
	 * @function deleteTimeout
	 * @param {number} timerID
	 */
	Riode.deleteTimeout = function (timerID) {
		if (!timerID) {
			return;
		}
		var handler = window.cancelAnimationFrame || window.webkitCancelAnimationFrame || window.mozCancelAnimationFrame;
		if (!handler) {
			return clearTimeout(timerID);
		}
		if (timerID.val) {
			return handler(timerID.val);
		}
	}

	var debounce = function (func, threshold, execAsap) {
		var timeout;
		return function debounced() {
			var obj = this, args = arguments;
			function delayed() {
				execAsap || func.apply(obj, args);
				timeout = null;
			}

			if (timeout)
				Riode.deleteTimeout(timeout);
			else if (execAsap)
				func.apply(obj, args);

			timeout = Riode.requestTimeout(delayed, threshold || 100);
		};
	};

	/**
	 * @function $.fn.smartresize
	 */
	$.fn.smartresize = function (fn) {
		fn ? this.get(0).addEventListener('resize', debounce(fn), { passive: true }) : this.trigger('smartresize');
	};

	/**
	 * @function $.fn.smartscroll
	 */
	$.fn.smartscroll = function (fn) {
		fn ? this.get(0).addEventListener('scroll', debounce(fn), { passive: true }) : this.trigger('smartscroll');
	};

	/**
	 * @function parseOptions	Parse options string to object
	 * @param {string} options	Options string
	 * @return {object}
	 */
	Riode.parseOptions = function (options) {
		return 'string' == typeof options ? JSON.parse(options.replace(/'/g, '"').replace(';', '')) : {};
	}

	/**
	 * @function isOnScreen
	 * @param {HTMLElement} el
	 * @param {number} dx
	 * @param {number} dy
	 */
	Riode.isOnScreen = function (el, dx, dy) {
		var a = window.pageXOffset,
			b = window.pageYOffset,
			o = el.getBoundingClientRect(),
			x = o.left + a,
			y = o.top + b,
			ax = typeof dx == 'undefined' ? 0 : dx,
			ay = typeof dy == 'undefined' ? 0 : dy;

		return y + o.height + ay >= b &&
			y <= b + window.innerHeight + ay &&
			x + o.width + ax >= a &&
			x <= a + window.innerWidth + ax;
	}

	/**
	 * @function filter
	 * @param {function} func_name
	 * @param {any} args
	 */
	Riode.filter = function (func_name, args) {
		var events = $._data($(document)[0], 'events');
		if (events[func_name]) {
			return events[func_name][0].handler.call(this, args);
		}
		return args[0];
	}
})(jQuery);

/**
 * Riode Plugin - Appear
 */
(function () {
	var checks = [],
		timerId = false,
		one;

	var checkAll = function () {
		for (var i = checks.length; i--;) {
			one = checks[i];
			if (Riode.isOnScreen(one.el, one.options.accX, one.options.accY)) {
				one.fn.call(one.el, one.data);
				checks.splice(i, 1);
			}
		}
	};

	/**
	 * @function appear
	 * 
	 * @param {HTMLElement} el DOM Element to appear
	 * @param {function} fn    Callback function
	 * @param {object} options Options
	 */
	Riode.appear = function (el, fn, options) {
		var settings = {
			data: undefined,
			accX: 0,
			accY: 0
		};

		if (options) {
			options.data && (settings.data = options.data);
			options.accX && (settings.accX = options.accX);
			options.accY && (settings.accY = options.accY);
		}

		checks.push({ el: el, fn: fn, options: settings });
		if (!timerId) {
			timerId = setTimeout(checkAll, 100);
		}
	}

	window.addEventListener('scroll', checkAll, { passive: true });
	window.addEventListener('resize', checkAll, { passive: true });
	jQuery(window).on('appear.check', checkAll);
})();

/**
 * Riode Functions
 */
(function ($) {
	/**
	 * @function addHtmlClass
	 *
	 */
	Riode.addHtmlClass = function () {
		Riode.$('html').addClass(('ontouchstart' in document) ? 'touchable' : 'untouchable');
	}

	/**
	 * @function fitVideoSize
	 *
	 * @requires fitVids
	 * @param {string} selector
	 */
	Riode.fitVideoSize = function (selector) {
		if ($.fn.fitVids) {
			var $selector = (typeof $selector == 'undefined' ? $('.fit-video') : Riode.$(selector).find('.fit-video'));

			$selector.each(function () {
				var $this = $(this),
					$video = $this.find('video'),
					w = $video.attr('width'),
					h = $video.attr('height'),
					cw = $this.outerWidth();

				$video.css({ width: cw, height: cw / w * h });

				if (window.wp.mediaelement) {
					window.wp.mediaelement.initialize();
				}

				$this.fitVids();
			})

			if ($selector.closest('.grid').length > 0) {
				setTimeout(function () {
					Riode.isotopes('.grid');
				}, 200)
			}

			Riode.status == 'loading' &&
				window.addEventListener('resize', function () {
					$('.fit-video').fitVids();
				}, { passive: true });
		}
	}

	/**
	 * @function isotopes
	 *
	 * @requires isotope
	 * @requires imagesLoaded
	 * @param {string} selector,
	 * @param {object} options
	 */
	Riode.isotopes = function (selector, options) {
		if ($.fn.imagesLoaded && $.fn.isotope) {
			Riode.$(selector).each(function () {
				if (!this.classList.contains('grid-float')) {
					_isotopeSort('', $(this));

					var $this = $(this),
						settings = $.extend(
							true,
							{},
							Riode.isotopeOptions,
							Riode.parseOptions(this.getAttribute('data-grid-options')),
							options ? options : {},
							this.classList.contains('masonry') ? { horizontalOrder: true } : {}
						);

					if (settings.masonry.columnWidth && !$this.children(settings.masonry.columnWidth).length) {
						delete settings.masonry.columnWidth;
					}

					Object.setPrototypeOf(this, HTMLElement.prototype);
					$this.children().each(
						function () {
							Object.setPrototypeOf(this, HTMLElement.prototype);
						}
					)

					$this.imagesLoaded(function () {
						$this.isotope(settings);
						'undefined' != typeof elementorFrontend && $this.trigger('resize.waypoints');
					});
				}
			});

			Riode.$window.on('resize', _isotopeSort);
		}
	}
	Riode.isotopeOptions = {
		itemsSelector: '.grid-item',
		layoutMode: 'masonry',
		percentPosition: true,
		masonry: {
			columnWidth: '.grid-space'
		},
		getSortData: {
			order: '[data-creative-order] parseInt',
			order_xl: '[data-creative-order-xl] parseInt',
			order_lg: '[data-creative-order-lg] parseInt',
			order_md: '[data-creative-order-md] parseInt',
			order_sm: '[data-creative-order-sm] parseInt',
		},
	}

	var _isotopeSort = function (e, $selector) {
		var $grid = $selector ? $selector : $('.grid');
		$grid.length && $grid.each(function (e) {
			if (!$(this).attr('data-creative-breaks') || $(this).hasClass('float-grid')) {
				return;
			}

			$(this).children('.grid-item').css({ 'animation-fill-mode': 'none', '-webkit-animation-fill-mode': 'none' });

			var width = window.innerWidth,
				breaks = JSON.parse($(this).attr('data-creative-breaks')),
				cur_break = $(this).attr('data-current-break'),
				breakspoints = Object.keys(breaks);

			for (var i = breakspoints.length - 1; i >= 0; i--) {
				if (i == breakspoints.length - 1 && width >= breaks[breakspoints[i]]) {
					width = '';
					break;
				}
				if (i == 0 && width < breaks[breakspoints[i]]) {
					width = breakspoints[i];
					break;
				}
				if (width >= breaks[breakspoints[i - 1]] && width < breaks[breakspoints[i]]) {
					width = breakspoints[i];
					break;
				}
			}

			if (width == cur_break) {
				return;
			}

			if ($(this).data('isotope')) {
				$(this).isotope(
					{
						sortBy: 'order' + (width ? '_' + width : ''),
					}
				);
				$(this).isotope('layout');
			} else {
				var options = $(this).attr('data-grid-options');
				if (undefined == options) {
					options = {};
					options['sortBy'] = 'order' + (width ? '_' + width : '');
				} else {
					options = JSON.parse(options);
					options['sortBy'] = 'order' + (width ? '_' + width : '');
				}
				$(this).attr('data-grid-options', JSON.stringify(options));
			}
			$(this).attr('data-current-break', width);
		});
	}

	/**
	 * @function stickySidebar
	 *
	 * @requires themeSticky
	 * @param {string} selector
	 */
	Riode.stickySidebar = function (selector) {
		if ($.fn.themeSticky) {
			Riode.$(selector).each(
				function () {
					var $this = $(this),
						aside = $this.closest('.sidebar'),
						options = Riode.stickySidebarOptions,
						top = 0;
					(aside.length ? aside : $this.parent()).addClass('sticky-sidebar-wrapper');
					$('.sticky-sidebar > .filter-actions').length || $('.sticky-content.fix-top').each(function (e) {
						if ($(this).hasClass('sticky-toolbox')) {
							return;
						}

						var $fixed = $(this).hasClass('fixed');

						top += $(this).addClass('fixed').outerHeight();
						if ($('#wpadminbar').length > 0) {
							top += $('#wpadminbar').outerHeight();
						}
						$fixed || $(this).removeClass('fixed');
					});

					options['padding']['top'] = top + 20;
					$this.themeSticky($.extend({}, options, Riode.parseOptions($this.attr('data-sticky-options'))));
					$this.trigger('recalc.pin');

					// issue: tab change of single product's tab in summary sticky sidebar
					Riode.$window.on(
						'riode_complete',
						function () {
							$this.on(
								'click',
								'.nav-link',
								function () {
									setTimeout(
										function () {
											$this.trigger('recalc.pin');
										}
									);
								}
							);
						}
					);
				}
			);
		}
	}

	Riode.refreshLayouts = function () {
		Riode.$window.trigger('update_lazyload');
		$('.sticky-sidebar').trigger('recalc.pin');
	}

	Riode.stickySidebarOptions = {
		autoInit: true,
		minWidth: 991,
		containerSelector: '.sticky-sidebar-wrapper',
		autoFit: true,
		activeClass: 'sticky-sidebar-fixed',
		padding: {
			top: 0,
			bottom: 0
		},
	};

	/**
	 * @function lazyLoad
	 *
	 * @requires jQuery.lazyload
	 * @param {jQuery|string} selector
	 */
	Riode._lazyload_force = function (el) {
		var src = el.getAttribute('data-lazy');
		if (el.classList.contains('d-lazyload')) {
			var srcset = el.getAttribute('data-lazyset');
			srcset && (el.setAttribute('srcset', srcset), el.removeAttribute('data-lazyset'));
			el.style['padding-top'] = '';
			src && el.setAttribute('src', src);
			el.classList.remove('d-lazyload');
		} else {
			if (el.classList.contains('d-lazy-back')) {
				el.classList.remove('d-lazy-back');
			} else {
				el.removeAttribute('data-lazy-back');
			}
			src && (el.style['background-image'] = 'url(' + src + ')');
		}
		el.removeAttribute('data-lazy');
	}
	Riode._lazyload_options = {
		effect: 'fadeIn',
		data_attribute: 'lazy',
		data_srcset: 'lazyset',
		effect_speed: 400,
		failure_limit: 1000,
		event: 'scroll update_lazyload',
		load: function () {
			if (this.classList.contains('d-lazyload')) {
				this.style['padding-top'] = '';
				this.classList.remove('d-lazyload');
			} else {
				this.classList.remove('d-lazy-back');
				if (this.classList.contains('elementor-element-populated') || this.classList.contains('elementor-section')) {
					this.style['background-image'] = '';
				}
			}
		}
	}
	Riode.lazyLoad = function (selector) {
		if ($.fn.lazyload) {
			Riode.$(selector, '.d-lazyload').add(Riode.$(selector, '.d-lazy-back')).add(Riode.$(selector, '[data-lazy-back]'))
				.filter(function () {
					return !$(this).closest('.owl-carousel').length && 'undefined' != $(this).data('lazy');
				})
				.lazyload(Riode._lazyload_options);
		}
	}
	$('.sidebar-content').on('scroll', function () {
		Riode.$window.trigger('update_lazyload');
	});

	/**
	 * @function initPriceSlider
	 */
	Riode.initPriceSlider = function () {
		if ($.fn.slider) {
			$('input#min_price, input#max_price').hide();
			$('.price_slider, .price_label').show();

			var min_price = $('.price_slider_amount #min_price').data('min'),
				max_price = $('.price_slider_amount #max_price').data('max'),
				step = $('.price_slider_amount').data('step') || 1,
				current_min_price = $('.price_slider_amount #min_price').val(),
				current_max_price = $('.price_slider_amount #max_price').val();

			$('.price_slider:not(.ui-slider)').slider({
				range: true,
				animate: true,
				min: min_price,
				max: max_price,
				step: step,
				values: [current_min_price, current_max_price],
				create: function () {
					$('.price_slider_amount #min_price').val(current_min_price);
					$('.price_slider_amount #max_price').val(current_max_price);
					$(document.body).trigger('price_slider_create', [current_min_price, current_max_price]);
				},
				slide: function (event, ui) {

					$('input#min_price').val(ui.values[0]);
					$('input#max_price').val(ui.values[1]);

					$(document.body).trigger('price_slider_slide', [ui.values[0], ui.values[1]]);
				},
				change: function (event, ui) {

					$(document.body).trigger('price_slider_change', [ui.values[0], ui.values[1]]);
				}
			});
		}
	}

	/**
	 * @function doLoading
	 * Show loading overlay
	 * @param {string|jQuery} selector 
	 * @param {string} type This can be omitted.
	 */
	Riode.doLoading = function (selector, type) {
		var $selector = Riode.$(selector);
		if (typeof type == 'undefined') {
			$selector.append('<div class="d-loading"><i></i></div>');
		} else if (type == 'small') {
			$selector.append('<div class="d-loading small"><i></i></div>');
		} else if (type == 'simple') {
			$selector.append('<div class="d-loading small"></div>');
		}

		if ('static' == $selector.css('position')) {
			Riode.$(selector).css('position', 'relative');
		}
	}
	/**
	 * @function endLoading
	 * Hide loading overlay
	 * @param {string|jQuery} selector 
	 */
	Riode.endLoading = function (selector) {
		Riode.$(selector).find('.d-loading').remove();
		Riode.$(selector).css('position', '');
	}

	/**
	 * @function lazyLoadMenu
	 */
	Riode.lazyLoadMenu = function () {
		// lazyload menu
		var lazyMenus = $('.lazy-menu').map(function () {
			return this.getAttribute('id').slice(5); // remove prefix 'menu-'
		}).get();

		// If lazy menu exists
		if (lazyMenus && lazyMenus.length) {

			// Function to change loaded menu
			function changeLoadedMenu(menuId, menuContent) {
				var $submenus = $(Riode.byId('menu-' + menuId)).removeClass('lazy-menu').children('li');
				$(menuContent).filter('li').each(function () {
					var $newli = $(this),
						$oldli = $submenus.eq($newli.index());
					$oldli.children('ul').remove();
					$oldli.append($newli.children('ul'));
				});
			}

			// Cache
			// var cache = Riode.getCache(),
			var cache = {},
				cachedMenus = cache.menus ? cache.menus : {},
				nonCachedMenus = [];

			// Check if latest menu cache exists
			if (riode_vars.lazyload_menu && cache.menus && cache.menuLastTime && riode_vars.menu_last_time &&
				parseInt(cache.menuLastTime) >= parseInt(riode_vars.menu_last_time)) {

				for (var id in lazyMenus) {
					var menuId = lazyMenus[id];
					if (cachedMenus[menuId]) {
						changeLoadedMenu(menuId, cachedMenus[menuId]);
					} else {
						nonCachedMenus.push(menuId);
					}
				}
			} else {
				// no cache
				nonCachedMenus = lazyMenus;
			}

			// Fetch menus from server 
			if (nonCachedMenus.length) {
				$.ajax({
					type: 'POST',
					url: riode_vars.ajax_url,
					dataType: 'json',
					data: {
						action: "riode_load_menu",
						menus: nonCachedMenus,
						nonce: riode_vars.nonce,
						load_menu: true,
					},
					success: function (menus) {
						if (menus) {
							for (var menuId in menus) {
								changeLoadedMenu(menuId, menus[menuId]);
								cachedMenus[menuId] = (menus[menuId]);
							}
						}
						Riode.menu && Riode.menu.addToggleButtons('.collapsible-menu li');
						'function' == typeof Riode.showEditPageTooltip && Riode.showEditPageTooltip();

						// save menu cache
						cache.menus = cachedMenus;
						cache.menuLastTime = riode_vars.menu_last_time;
						Riode.setCache(cache);

						Riode.$window.trigger('recalc_menus');
					}
				});
			}
		}
	}

	/**
	 * @function disableMobileAnimations
	 */
	Riode.disableMobileAnimations = function () {
		if (Riode.$body.hasClass('riode-disable-mobile-animation') && window.innerWidth < 768) {
			$('.elementor-invisible').removeAttr('data-settings').removeData('settings').removeClass('elementor-invisible')
				.add($('.appear-animate').removeClass('appear-animate'))
		}
	}

	/**
	 * Hash Scroll 
	 * 
	 * @since 1.4.0
	 */
	Riode.SectionScroll = {
		initialize: function () {
			this.events();
			return this;
		},
		getTarget: function (href) {
			if ('#' == href || href.endsWith('#')) {
				return false;
			}
			var target;

			if (href.indexOf('#') == 0) {
				target = $(href);
			} else {
				var url = window.location.href;
				url = url.substring(url.indexOf('://') + 3);
				if (url.indexOf('#') != -1)
					url = url.substring(0, url.indexOf('#'));
				href = href.substring(href.indexOf('://') + 3);
				href = href.substring(href.indexOf(url) + url.length);
				if (href.indexOf('#') == 0) {
					target = $(href);
				}
			}
			return target;
		},
		events: function () {
			var self = this,
				adminBarHeight = 0,
				stickyHeaderHeight = 0;

			if ($('#wpadminbar').length > 0) {
				adminBarHeight = $('#wpadminbar').outerHeight();
			}

			$('.sticky-content.fix-top').each(function () {
				stickyHeaderHeight += this.offsetHeight;
			});

			$('.menu-item > a[href*="#"]').on('click', function (e) {
				e.preventDefault();

				var $this = $(this),
					href = $this.attr('href'),
					target = self.getTarget(href);

				if (0 !== $this.closest('.elementor-section').length) {
					return;
				}

				if (target && target.get(0)) {
					var $parent = $this.parent();

					var scroll_to = target.offset().top - stickyHeaderHeight - adminBarHeight;

					$('html, body').stop().animate({
						scrollTop: scroll_to
					}, 600, 'linear', function () {
						$parent.siblings().removeClass('active');
						$parent.addClass('active');
					});
				} else if (('#' != href) && !$this.hasClass('nolink')) {
					window.location.href = $this.attr('href');
				}
			});

			var $menu_items = $('.menu-item > a[href*="#"]');
			$menu_items.each(function () {
				var rootMargin = '-20% 0px -79.9% 0px',
					isLast = $(this).parent().is(':last-child');
				if (isLast) {
					var obj = document.getElementById(this.hash.replace('#', ''));
					if (obj && document.body.offsetHeight - obj.offsetTop < window.innerHeight) {
						var ratio = (window.innerHeight - document.body.offsetHeight + obj.offsetTop) / window.innerHeight * 0.8;
						ratio = Math.round(ratio * 100);
						rootMargin = '-' + (20 + ratio) + '% 0px -' + (79.9 - ratio) + '% 0px';
					}
				}
				var callback = function () {
					if (this && typeof this[0] != 'undefined' && this[0].id) {
						$('.menu-item > a[href*="#' + this[0].id + '"]').parent().addClass('active').siblings().removeClass('active');
					}
				};
				self.scrollSpyIntObs(this.hash, callback, {
					rootMargin: rootMargin,
					thresholds: 0
				}, true, isLast, true, $menu_items, $(this).parent().index());
			});

			return self;
		},

		/**
		 * Scroll Spy with IntersectionObserver
		 * 
		 * @since 1.4.0
		 */
		scrollSpyIntObs: function (selector, functionName, intObsOptions, alwaysObserve, isLast, firstLoad, $allItems, index) {
			if (typeof IntersectionObserver == 'undefined') {
				return this;
			}
			var obj = document.getElementById(selector.replace('#', ''));
			if (!obj) {
				return this;
			}

			var self = this;

			var intersectionObserverOptions = {
				rootMargin: '0px 0px 200px 0px'
			}

			if (Object.keys(intObsOptions).length) {
				intersectionObserverOptions = $.extend(intersectionObserverOptions, intObsOptions);
			}

			var observer = new IntersectionObserver(function (entries) {

				for (var i = 0; i < entries.length; i++) {
					var entry = entries[i];
					if (entry.intersectionRatio > 0) {
						if (typeof functionName === 'string') {
							var func = Function('return ' + functionName)();
						} else {
							var callback = functionName;

							callback.call($(entry.target));
						}
					} else {
						if (firstLoad == false) {
							if (isLast) {
								$allItems.filter('[href*="' + entry.target.id + '"]').parent().prev().addClass('active').siblings().removeClass('active');
							}
						}
						firstLoad = false;

					}
				}
			}, intersectionObserverOptions);

			observer.observe(obj);

			return this;
		},
	}

})(jQuery);

/**
 * Riode Theme Setup
 */
(function ($) {
	Riode.initLayout = function () {
		Riode.fitVideoSize();									// Fit Video Size
		Riode.isotopes('.grid');								// Masonry Layout
		Riode.stickySidebar('.sticky-sidebar');					// Sticky Sidebar
		Riode.lazyLoad();										// Lazy Load
		Riode.lazyLoadMenu();									// Lazy Load Menu
		Riode.byClass('price_slider').length && $.fn.slider && Riode.initPriceSlider();

		Riode.status == 'loading' && (Riode.status = 'load');
		Riode.$window.trigger('riode_load');
		riode_vars.resource_after_load ?
			Riode.call(Riode.initAsync) :
			Riode.initAsync();

		// yith wishlist pro compatibility
		Riode.$(document).trigger('yith_infs_added_elem');
	}

	$(window).on('load', function () {
		Riode.$body.addClass('loaded');
		Riode.addHtmlClass();
		if ($.fn.imagesLoaded && typeof Riode.skeleton === 'function') {
			riode_vars.resource_after_load ?
				Riode.call(function () {
					Riode.skeleton($('.skeleton-body'), Riode.initLayout);
				}) :
				Riode.skeleton($('.skeleton-body'), Riode.initLayout);
		} else {
			riode_vars.resource_after_load ?
				Riode.call(Riode.initLayout) :
				Riode.initLayout();
		}
		Riode.SectionScroll.initialize();
	});

	Riode.disableMobileAnimations();

	// Checking Slide Animate.
	$('.owl-carousel').each(function () {
		var $this = $(this),
			$anim_items = $this.children().find('.elementor-invisible, .appear-animate');
		if (0 < $anim_items.length) {
			$this.addClass('animation-slider');
			$anim_items.addClass('slide-animate');
			$anim_items.each(function () {
				var $this = $(this);
				var pre = $this.data('settings');
				$this.removeClass('appear-animate');
				var settings = {
					'_animation_name': pre._animation ? pre._animation : pre.animation,
					'_animation_delay': Number(pre._animation_delay)
				};
				$this.data('settings', settings);
				$this.attr('data-settings', JSON.stringify(settings));
			});
		}
	});

})(jQuery);