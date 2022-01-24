/**
 * Riode Theme Async Library
 */
'use strict';

/**
 * Riode Functions
 */
(function ($) {
	if (!String.prototype.endsWith) {
		String.prototype.endsWith = function (search, this_len) {
			if (this_len === undefined || this_len > this.length) {
				this_len = this.length;
			}
			return this.substring(this_len - search.length, this_len) === search;
		};
	}

	Riode.initTemplate = function ($template) {
		Riode.lazyLoad($template);
		Riode.slider($template.find('.owl-carousel'));
		Riode.isotopes($template.find('.grid'));
		Riode.shop.initProducts($template);
		Riode.call(function () {
			Riode.$window.trigger('riode_loadmore riode_loadmore');
		}, 300);
	}

	Riode.loadTemplate = function ($template) {
		var html = '',
			orignal_split = riode_vars.resource_split_tasks;
		riode_vars.resource_split_tasks = 0; // run carousel immediately

		$template.children('.load-template').each(function () {
			html += this.text;
		})
		if (html) {
			$template.html(html);
			Riode.skeleton($('.skeleton-body'), function () {
				Riode.initTemplate($template);
			});
		} else {
			$template.children('.loaded-template').each(function () {
				html += this.text;
			});
			if (html) {
				$template.html(html);
				Riode.initTemplate($template);
			}
		}

		riode_vars.resource_split_tasks = orignal_split;
	}

	Riode.saveTemplate = function ($template) {
		var html = '';
		$template.find('.owl-carousel').each(function () {
			var owl = $(this).data('owl.carousel');
			owl && owl.destroy();
		});
		$template.find('.grid:not(:grid-float)').each(function () {
			var isotope = $(this).data('isotope');
			isotope && isotope.destroy();
		});
		$template.find('.star-rating > .tooltiptext').remove();
		$template.children().each(function () {
			html += this.outerHTML;
		});
		$template.html('<script type="text/template" class="loaded-template">' + html + '</script>');
	}

	Riode.windowResized = function (timeStamp) {
		if (timeStamp == Riode.resizeTimeStamp) {
			return Riode.resizeChanged;
		}

		if (Riode.canvasWidth != window.innerWidth) {
			Riode.resizeChanged = true;
		} else {
			Riode.resizeChanged = false;
		}

		Riode.canvasWidth = window.innerWidth;
		Riode.resizeTimeStamp = timeStamp;

		return Riode.resizeChanged;
	}

	/**
	 * @function setCookie
	 * Set cookie
	 * @param {string} name Cookie name
	 * @param {string} value Cookie value
	 * @param {number} exdays Expire period
	 */
	Riode.setCookie = function (name, value, exdays) {
		var date = new Date();
		date.setTime(date.getTime() + (exdays * 24 * 60 * 60 * 1000));
		document.cookie = name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
	}

	/**
	 * Set cookie
	 * @param {string} name Cookie name
	 * @return {string} Cookie value
	 */
	Riode.getCookie = function (name) {
		var n = name + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; ++i) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(n) == 0) {
				return c.substring(n.length, c.length);
			}
		}
		return "";
	}

	/**
	 * @function scrollTo
	 */
	Riode.scrollTo = function (arg, duration) {
		var _duration = typeof duration == 'undefined' ? 600 : duration;
		var offset = typeof arg == 'number' ? arg : Riode.$(arg).offset().top;
		$('html,body').stop().animate({ scrollTop: offset }, _duration);
	}

	/**
	 * @function scrollToFixedContent
	 */
	Riode.scrollToFixedContent = function (arg, duration) {
		var stickyTop = 0,
			toolbarHeight = $('#wp-toolbar').parent().length ? $('#wp-toolbar').parent().outerHeight() : 0;

		if ($('#wp-toolbar').length && 'none' != $('#wp-toolbar').parent().css('display')) {
			toolbarHeight = 0;
		}

		$('.sticky-content.fix-top').each(function () {
			if ($(this).hasClass('toolbox-top')) {
				var pt = $(this).css('padding-top').slice();
				if (pt.length > 2) {
					stickyTop -= Number(pt.slice(0, -2));
				}
				return;
			}

			var fixed = $(this).hasClass('fixed');

			stickyTop += $(this).addClass('fixed').outerHeight();

			fixed || $(this).removeClass('fixed');
		})

		Riode.scrollTo(arg - stickyTop - toolbarHeight, duration);
	}

	/**
	 * Add param to url
	 * @param {string} href
	 * @param {string} name
	 * @param {mixed} value
	 * @return {string} Url Added
	 */
	Riode.addUrlParam = function (href, name, value) {
		var url = document.createElement('a'), s, r;
		url.href = decodeURIComponent(decodeURI(href));
		s = url.search;

		if (0 <= s.indexOf(name + '=')) {
			if (value) {
				r = s.replace(new RegExp(name + '=[^&]*'), name + '=' + value);
			} else {
				r = s.replace(new RegExp(name + '=[^&]*'), '');
			}
		} else {
			r = (s.length && 0 <= s.indexOf('?')) ? s : '?';
			r.endsWith('?') || (r += '&');
			r += name + '=' + value;
		}

		href = href.replace(s, '') + r.replace(/&+/, '&');

		if (0 <= href.indexOf('#')) {
			var m = href.match(/#.*\?/i);

			if (m) {
				m = m[0].substr(0, m[0].length - 1);

				href = href.replace(m, '') + m;
				console.log(href);
			}
		}
		return href;
	}

	/**
	 * Remove param from url
	 * @param {string} href
	 * @param {string} name
	 * @return {string} Url Removed
	 */
	Riode.removeUrlParam = function (href, name) {
		var url = document.createElement('a'), s, r;
		url.href = decodeURI(href);
		s = url.search;
		if (0 <= s.indexOf(name + '=')) {
			r = s.replace(new RegExp(name + '=[^&]*'), '').replace(/&+/, '&').replace('?&', '?');
			r.endsWith('&') && (r = r.substr(0, r.length - 1));
			r.endsWith('?') && (r = r.substr(0, r.length - 1));
		} else {
			r = s;
		}
		return href.replace(s, '') + r;
	}

	/**
	 * @function showMore
	 * 
	 * @param {string} selector
	 */
	Riode.showMore = function (selector) {
		Riode.$(selector).after('<div class="d-loading relative"><i></i></div>');
	}

	/**
	 * @function hideMore
	 * 
	 * @param {string} selector
	 */
	Riode.hideMore = function (selector) {
		Riode.$(selector).children('.d-loading').remove();
	}

	/**
	 * @function countTo
	 * 
	 * @requires jQuery.countTo
	 * @param {string} selector
	 */
	Riode.countTo = function (selector) {
		if ($.fn.countTo) {
			Riode.$(selector).each(function () {
				Riode.appear(this, function () {
					var $this = $(this);
					setTimeout(function () {
						$this.countTo({
							onComplete: function () {
								$this.addClass('complete');
							}
						});
					}, 300);
				})
			});
		}
	}

	/**
	 * @function countdown
	 *
	 * @requires countdown
	 * @param {string} selector
	 */
	Riode.countdown = function (selector) {
		if ($.fn.countdown) {
			Riode.$(selector).each(function () {
				var $this = $(this),
					untilDate = $this.attr('data-until'),
					compact = $this.attr('data-compact'),
					dateFormat = (!$this.attr('data-format')) ? 'DHMS' : $this.attr('data-format'),
					newLabels = (!$this.attr('data-labels-short')) ?
						['Years', 'Months', 'Weeks', 'Days', 'Hours', 'Minutes', 'Seconds'] :
						['Years', 'Months', 'Weeks', 'Days', 'Hours', 'Mins', 'Secs'],
					newLabels1 = (!$this.attr('data-labels-short')) ?
						['Year', 'Month', 'Week', 'Day', 'Hour', 'Minute', 'Second'] :
						['Year', 'Month', 'Week', 'Day', 'Hour', 'Min', 'Sec'];

				$this.data('countdown') && $this.countdown('destroy');

				if ($(this).hasClass('user-tz')) {
					$this.countdown({
						until: (!$this.attr('data-relative')) ? new Date(untilDate) : untilDate,
						format: dateFormat,
						padZeroes: true,
						compact: compact,
						compactLabels: [' y', ' m', ' w', ' days, '],
						timeSeparator: ' : ',
						labels: newLabels,
						labels1: newLabels1,
						serverSync: new Date($(this).attr('data-time-now'))
					})
				} else {
					$this.countdown({
						until: (!$this.attr('data-relative')) ? new Date(untilDate) : untilDate,
						format: dateFormat,
						padZeroes: true,
						compact: compact,
						compactLabels: [' y', ' m', ' w', ' days, '],
						timeSeparator: ' : ',
						labels: newLabels,
						labels1: newLabels1
					});
				}
			});
		}
	}

	/**
	 * @function parallax
	 * Initialize Parallax Background
	 * @requires themePluginParallax
	 * @param {string} selector
	 */
	Riode.parallax = function (selector, options) {
		if ($.fn.themePluginParallax) {
			Riode.$(selector).each(function () {
				var $this = $(this);
				$this.themePluginParallax(
					$.extend(true, Riode.parseOptions($this.attr('data-parallax-options')), options)
				);
			});
		}
	}

	// Show loading overlay when $.fn.block is called
	var funcBlock = $.fn.block;
	$.fn.block = function (opts) {
		this.append('<div class="d-loading"><i></i></div>');
		funcBlock.call(this, opts);
		return this;
	}

	// Hide loading overlay when $.fn.block is called
	var funcUnblock = $.fn.unblock;
	$.fn.unblock = function (opts) {
		funcUnblock.call(this, opts);
		this.is('.processing') || this.parents('.processing').length || this.children('.d-loading').remove();
		Riode.shop.initAlertAction();
		return this;
	}

	/**
	 * @function stickyContent
	 * Init Sticky Content
	 * @param {string, Object} selector
	 * @param {Object} settings
	 */
	Riode.stickyContent = function (selector, settings) {
		var $stickyContents = Riode.$(selector),
			options = $.extend({}, Riode.stickyDefaultOptions, settings),
			scrollPos = window.pageYOffset;

		if (0 == $stickyContents.length) return;

		var isStickyDevice = function () {
			if (options.devices) {
				return (window.innerWidth >= 1200 && window.innerWidth <= 20000 && options.devices.xl) ||
					(window.innerWidth >= 992 && window.innerWidth <= 1199 && options.devices.lg) ||
					(window.innerWidth >= 768 && window.innerWidth <= 991 && options.devices.md) ||
					(window.innerWidth >= 576 && window.innerWidth <= 767 && options.devices.sm) ||
					(window.innerWidth >= 320 && window.innerWidth <= 575 && options.devices.xs);

			}
			return (window.innerWidth >= options.minWidth && window.innerWidth <= options.maxWidth);
		}

		var setTopOffset = function ($item) {
			var offset = (window.innerWidth > 600 && $('#wp-toolbar').length) ? $('#wp-toolbar').parent().outerHeight() : 0,
				index = 0;

			if ($('#wp-toolbar').length && 'none' == $('#wp-toolbar').parent().css('display')) {
				offset = 0;
			}

			$('.sticky-content.fixed.fix-top').each(function () {
				var top = $(this)[0].offsetHeight;
				// if sticky header has toggle dropdown menu, increase top
				if ($(this).find('.toggle-menu.show-home').length) {
					top += $(this).find('.toggle-menu .dropdown-box')[0].offsetHeight;
				}

				offset += top;
				index++;
			});
			$item.data('offset-top', offset);
			$item.data('z-index', options.maxIndex - index);
		}

		var setBottomOffset = function ($item) {
			var offset = 0,
				index = 0;
			$('.sticky-content.fixed.fix-bottom').each(function () {
				offset += $(this)[0].offsetHeight;
				index++;
			});
			$item.data('offset-bottom', offset);
			$item.data('z-index', options.maxIndex - index);
		}

		var wrapStickyContent = function ($item, height) {
			if (isStickyDevice()) {
				$item.wrap('<div class="sticky-content-wrapper"></div>');
				$item.parent().css('height', height + 'px');
				$item.data('is-wrap', true);
			}
		}

		var initStickyContent = function (e) {
			$stickyContents.each(function (index) {
				var $item = $(this);

				if (options.devices) {
					$item.addClass('sticky-content fix-top');
				}
				if ($item.parents('.sticky-content').length) {
					$item.removeClass('sticky-content fix-top fix-bottom');
					return;
				}

				if (!$item.data('is-wrap')) {
					var height = $item.removeClass('fixed').outerHeight(true), top;
					wrapStickyContent($item, height);
					top = $item.offset().top + height;

					// if sticky header has toggle dropdown menu, increase top
					if ($item.find('.toggle-menu.show-home').length) {
						top += $item.find('.toggle-menu .dropdown-box')[0].offsetHeight;
					}

					$item.data('top', top);
				} else {
					if (!isStickyDevice()) {
						$item.unwrap('.sticky-content-wrapper');
						$item.data('is-wrap', false);
					}
				}
			});
		}

		var refreshStickyContent = function (e) {
			$stickyContents.each(function (index) {
				var $item = $(this),
					showContent = true;
				if (options.scrollMode) {
					showContent = scrollPos > window.pageYOffset;
					scrollPos = window.pageYOffset;
				}
				if (window.pageYOffset > (false == options.top ? $item.data('top') : options.top) && isStickyDevice()) {
					if ($item.hasClass('fix-top')) {
						undefined == $item.data('offset-top') && setTopOffset($item);
						$item.css('margin-top', ($('.sticky-header.fixed').length ? $('.sticky-header.fixed').outerHeight() : 0) + $item.data('offset-top') + 'px');
					} else if ($item.hasClass('fix-bottom')) {
						undefined == $item.data('offset-bottom') && setBottomOffset($item);
						$item.css('margin-bottom', $item.data('offset-bottom') + 'px');
					}
					$item.css({ 'transition': 'opacity .5s', 'z-index': $item.data('z-index') });
					if ('0px' == $item.css('margin-left') && '0px' == $item.css('margin-right')) {
						var ml = $('.page-wrapper').css('margin-left'),
							mr = $('.page-wrapper').css('margin-right');

						$item.css({ 'margin-left': ml, 'margin-right': mr });
					}
					if (options.scrollMode) {
						if ((showContent && $item.hasClass('fix-top')) || (!showContent && $item.hasClass('fix-bottom'))) {
							$item.addClass('fixed');
						} else {
							$item.removeClass('fixed');
							$item.css('margin', '');
						}
					} else {
						$item.addClass('fixed');
					}
					options.hide && $item.parent('.sticky-content-wrapper').css('display', '');
				} else {
					$item.removeClass('fixed');
					$item.css('margin', '');
					$item.css('z-index', '');
					options.hide && $item.parent('.sticky-content-wrapper').css('display', 'none');
				}
			});
		}

		var resizeStickyContent = function (e) {
			if (Riode.windowResized(e.timeStamp)) {
				$stickyContents.removeData('offset-top')
					.removeData('offset-bottom')
					.removeClass('fixed')
					.css('margin', '')
					.css('z-index', '');

				Riode.call(function () {
					initStickyContent();
					refreshStickyContent();
				});
			}
		}

		Riode.call(initStickyContent, 550);
		Riode.call(refreshStickyContent, 560);

		Riode.call(function () {
			window.addEventListener('scroll', refreshStickyContent, { passive: true });
			Riode.$window.on('resize', resizeStickyContent);
		}, 700);

	}
	Riode.stickyDefaultOptions = {
		minWidth: 992,
		maxWidth: 20000,
		top: false,
		hide: false, // hide when it is not sticky.
		maxIndex: 1039, // maximum z-index of sticky contents
		scrollMode: false
	}


	/**
	 * @function alert
	 * Register events for alert
	 * @param {string} selector
	 */
	Riode.alert = function (selector) {
		Riode.$body.on('click', selector + ' .btn-close', function (e) {
			e.preventDefault();
			$(this).closest(selector).fadeOut(function () {
				$(this).remove();
			});
		});
	}


	/**
	 * @function accordion
	 * Register events for accordion
	 * @param {string} selector
	 */
	Riode.accordion = function (selector) {
		Riode.$body.on('click', selector, function (e) {
			var $this = $(this),
				$body,
				$parent = $this.closest('.accordion');

			if ('#' == $this.attr('href')) {
				$body = $this.closest('.card').find('.card-body');
			} else {
				$body = $this.closest('.card').find('#' == $this.attr('href')[0] ? $this.attr('href') : '#' + $this.attr('href'));
			}

			e.preventDefault();

			if (0 === $parent.find(".collapsing").length &&
				0 === $parent.find(".expanding").length) {

				if ($body.hasClass('expanded')) {
					if (!$parent.hasClass('radio-type'))
						slideToggle($body);

				} else if ($body.hasClass('collapsed')) {

					if ($parent.find('.expanded').length > 0) {
						if (Riode.isIE) {
							slideToggle($parent.find('.expanded'), function () {
								slideToggle($body);
							});

						} else {
							slideToggle($parent.find('.expanded'));
							slideToggle($body);
						}
					} else {
						slideToggle($body);
					}
				}
			}
		});

		var riode_sticky_sidebar = $('.sticky-sidebar');

		// define slideToggle method
		var slideToggle = function ($wrap, callback) {
			var $header = $wrap.closest('.card').find(selector);

			if ($wrap.hasClass("expanded")) {
				$header
					.removeClass("collapse")
					.addClass("expand");
				$wrap
					.addClass("collapsing")
					.slideUp(300, function () {
						$wrap.removeClass("expanded collapsing").addClass("collapsed");
						callback && callback();
						if (riode_sticky_sidebar.length) {
							riode_sticky_sidebar.trigger('recalc.pin');
						}
					})

			} else if ($wrap.hasClass("collapsed")) {
				$header
					.removeClass("expand")
					.addClass("collapse");
				$wrap
					.addClass("expanding")
					.slideDown(300, function () {
						$wrap.removeClass("collapsed expanding").addClass("expanded");
						callback && callback();
						if (riode_sticky_sidebar.length) {
							riode_sticky_sidebar.trigger('recalc.pin');
						}
					})
			}
		};
	}

	/**
	 * @function floatSVG
	 * @param {string|jQuery} selector 
	 * @param {object} options
	 */
	Riode.floatSVG = (function () {
		function FloatSVG(svg, options) {
			this.$el = $(svg);
			this.set(options);
			this.start();
		}

		FloatSVG.prototype.set = function (options) {
			this.options = $.extend({
				delta: 15,
				speed: 10,
				size: 1,
			}, typeof options == 'string' ? JSON.parse(options) : options);
		}

		FloatSVG.prototype.getDeltaY = function (dx) {
			return Math.sin(2 * Math.PI * dx / this.width * this.options.size) * this.options.delta;
		}

		FloatSVG.prototype.start = function () {
			this.update = this.update.bind(this);
			this.timeStart = Date.now() - parseInt(Math.random() * 100);
			this.$el.find('path').each(function () {
				$(this).data('original', this.getAttribute('d').replace(/([\d])\s*\-/g, '$1,-'));
			});

			window.addEventListener('resize', this.update, { passive: true });
			window.addEventListener('scroll', this.update, { passive: true });
			Riode.$window.on('check_float_svg', this.update);
			this.update();
		}

		FloatSVG.prototype.update = function () {
			var self = this;

			if (this.$el.length && Riode.isOnScreen(this.$el[0])) {
				Riode.requestTimeout(function () {
					self.draw();
				}, 16);
			}
		}

		FloatSVG.prototype.draw = function () {
			var self = this,
				_dx = (Date.now() - this.timeStart) * this.options.speed / 200;
			this.width = this.$el.width();
			if (!this.width) {
				return;
			}
			this.$el.find('path').each(function () {
				var dx = _dx, dy = 0;
				this.setAttribute('d', $(this).data('original')
					.replace(/M([\d|\.]*),([\d|\.]*)/, function (match, p1, p2) {
						if (p1 && p2) {
							return 'M' + p1 + ',' + (parseFloat(p2) + (dy = self.getDeltaY(dx += parseFloat(p1)))).toFixed(3);
						}
						return match;
					})
					.replace(/([c|C])[^A-Za-z]*/g, function (match, p1) {
						if (p1) {
							var v = match.slice(1).split(',').map(parseFloat);
							if (v.length == 6) {
								if ('C' == p1) {
									v[1] += self.getDeltaY(_dx + v[0]);
									v[3] += self.getDeltaY(_dx + v[2]);
									v[5] += self.getDeltaY(dx = _dx + v[4]);
								} else {
									v[1] += self.getDeltaY(dx + v[0]) - dy;
									v[3] += self.getDeltaY(dx + v[2]) - dy;
									v[5] += self.getDeltaY(dx += v[4]) - dy;
								}
								dy = self.getDeltaY(dx);

								return p1 + v.map(function (v) {
									return v.toFixed(3);
								}).join(',');
							}
						}
						return match;
					})
				);
			});

			this.update();
		}

		return function (selector) {
			Riode.$(selector).each(function () {
				var $this = $(this), float;
				if (this.tagName == 'svg') {
					float = $this.data('float-svg');
					if (float) {
						float.set($this.attr('data-float-options'));
					} else {
						$this.data('float-svg', new FloatSVG(this, $this.attr('data-float-options')));
					}
				}
			})
		};
	})()

	/**
	 * Initialize floating elements
	 * 
	 * @since 1.2.0
	 * @param {string|jQuery} selector
	 * @return {void}
	 */
	Riode.initFloatingElements = function (selector) {
		if ($.fn.parallax) {
			var $selectors = '';

			if (selector) {
				$selectors = selector;
			} else {
				$selectors = $('[data-plugin="floating"]');
			}

			$selectors.each(function (e) {
				var $this = $(this);
				if ($this.data('parallax')) {
					$this.parallax('disable');
					$this.removeData('parallax');
					$this.removeData('options');
				}
				if ($this.hasClass('elementor-element')) {
					$this.children('.elementor-widget-container, .elementor-container, .elementor-widget-wrap').addClass('layer').attr('data-depth', $this.attr('data-floating-depth'));
				} else {
					$this.children('.layer').attr('data-depth', $this.attr('data-floating-depth'));
				}
				$this.parallax($this.data('options'));
			});
		}
	}

	/**
	 * Initialize skrollr elements
	 * 
	 * @since 1.2.0
	 * @param {string|jQuery} selector
	 * @param {string} action
	 * @return {void}
	 */
	Riode.initSkrollrElements = function (selector, action) {
		if (Riode.isMobile) {
			return;
		}

		if (typeof skrollr == 'undefined') {
			return;
		}

		var $selectors = '';

		if (selector) {
			$selectors = selector;
		} else {
			$selectors = $('[data-plugin="skrollr"]');
		}

		$selectors.removeAttr('data-bottom-top data-top data-center-top').css({});
		if (skrollr.get()) {
			skrollr.get().destroy();
		}

		if (action == 'destroy') {
			$selectors.removeAttr('data-plugin data-options');
			return;
		}

		$selectors.each(function (e) {
			var $this = $(this),
				options = {},
				keys = [];

			if ($(this).attr('data-options')) {
				options = JSON.parse($(this).attr('data-options'));
				keys = Object.keys(options);
			}

			if ('object' == typeof options && (keys = Object.keys(options)).length) {
				keys.forEach(function (key) {
					$this.attr(key, options[key]);
				})
			}
		});

		if ($selectors.length) {
			skrollr.init({ forceHeight: false, smoothScrolling: true });
		}
	}

	/**
	 * Initalize keydown events
	 */

	Riode.initKeyDown = function () {
		var $fullSearchElement = $('.hs-fullscreen'),
			$offCanvasElement = $('.offcanvas-type');

		if ($fullSearchElement.length || $offCanvasElement.length) {
			document.
				addEventListener('keydown', function (e) {
					var keyName = e.key;
					if ('Escape' == keyName) {
						if ($('.offcanvas-type').hasClass('opened')) {
							$('.offcanvas-type').removeClass('opened');
						}
						if ($fullSearchElement.length) {
							$('.hs-fullscreen').removeClass('show');
							$('body').css('overflow', '');
							$('body').css('margin-right', '');
						}
					}
				});
		}
	}

	Riode.initStickyResponsive = function () {
		var $stickyItem = $('[data-sticky-options]')

		$stickyItem.each(function () {
			var $this = $(this),
				$stickyOptions = '';
			if ($this.data('sticky-options')) {
				$stickyOptions = $this.data('sticky-options');
				Riode.stickyContent($this, $stickyOptions);
			}
		});
	}

	/**
	 * @function showEditPageTooltip
	 */
	Riode.showEditPageTooltip = function ($selector) {
		var riode_init_builder_tooltip = function ($obj) {

			$obj.find('.riode-edit-link').each(function () {
				var $this = $(this),
					title = $this.data('title');
				$this.next('.riode-block').addClass('riode-has-edit-link').tooltip({
					html: true,
					template: '<div class="tooltip riode-tooltip-wrap" role="tooltip"><div class="arrow"></div><div class="tooltip-inner riode-tooltip"></div></div>',
					trigger: 'manual',
					title: '<a href="' + $this.data('link') + '">' + title + '</a>',
					delay: 300
				});
				var tooltipData = $this.next('.riode-block').data('bs.tooltip');
				$(tooltipData.element).on('mouseenter.bs.tooltip', function (e) {
					tooltipData._enter(e);
				});
				$(tooltipData.element).on('mouseleave.bs.tooltip', function (e) {
					tooltipData._leave(e);
				});
			});
		};
		riode_init_builder_tooltip($(document.body));
		$(document.body).on('mouseenter mouseleave', '.tooltip[role="tooltip"]', function (e) {
			var $element = $('.riode-block[aria-describedby="' + $(this).attr('id') + '"]');
			if ($element.length && $element.data('bs.tooltip')) {
				var fn_name = 'mouseenter' == e.type ? '_enter' : '_leave';
				$element.data('bs.tooltip')[fn_name](false, $element.data('bs.tooltip'));
			}
		});
	}

	/**
	 * @function tab
	 * Register events for tab
	 * @param {string} selector
	 */
	Riode.tab = function (selector) {

		Riode.$body

			// tab nav link
			.on('click', '.tab .nav-link', function (e) {
				var $this = $(this);
				e.preventDefault();

				if (!$this.hasClass("active")) {
					var href = $this.attr('href');
					var $panel = '#' == href ?
						$this.closest('.nav').siblings('.tab-content').children('.tab-pane').eq($this.parent().index()) :
						$(('#' == href.substring(0, 1) ? '' : '#') + href),
						$activePanel = $panel.siblings('.active');

					Riode.loadTemplate($panel);
					$panel.parent().hasClass('tab-templates') && Riode.saveTemplate($activePanel);

					Riode.slider($panel.find('.owl-carousel'));

					$activePanel.removeClass('in active');
					$panel.addClass('active in');

					$panel.find('.owl-carousel .owl-dots .owl-dot').eq(0).addClass('active');

					$this.parent().siblings().children('.active').removeClass('active');
					$this.addClass('active');
				}
			})
	}

	/**
	 * @function degree360
	 * Register events for 360 degree
	 * @param {string} selector
	 */
	Riode.degree360 = function (selector) {
		if (!$.fn.ThreeSixty) {
			return;
		}

		if (typeof selector == 'undefined') {
			selector = '.riode-360-gallery-wrapper';
		}

		Riode.$body.find(selector).each(function () {
			var images = $(this).find('.riode-360-gallery-wrap').attr('data-srcs').split(','),
				$degree_viewport = $(this);

			$degree_viewport.addClass('not_loaded');

			$degree_viewport.ThreeSixty(
				{
					totalFrames: images.length, // Total no. of image you have for 360 slider
					endFrame: images.length, // end frame for the auto spin animation
					currentFrame: images.length - 1, // This the start frame for auto spin
					imgList: $degree_viewport.find('.riode-360-gallery-wrap'), // selector for image list
					progress: '.riode-degree-progress-bar', // selector to show the loading progress
					imgArray: images, // path of the image assets
					height: $degree_viewport.children('.post-div').length ? '' : 500,
					width: $degree_viewport.outerWidth(),
					navigation: true
				}
			);

			$degree_viewport.find('.riode-360-gallery-wrap').imagesLoaded(
				function () {
					setTimeout(function () {
						$degree_viewport.removeClass('not_loaded').addClass('loaded');
						$degree_viewport.find('.nav_bar').removeClass('hide');
					}, 200);
				}
			);
		});
	}

	/**
	 * @function playableVideo
	 * 
	 * @param {string} selector
	 */
	Riode.playableVideo = function (selector) {
		$(selector + ' .video-play').on('click', function (e) {
			var $video = $(this).closest(selector);
			if ($video.hasClass('playing')) {
				$video.removeClass('playing')
					.addClass('paused')
					.find('video')[0].pause();
			} else {
				$video.removeClass('paused')
					.addClass('playing')
					.find('video')[0].play();
			}
			e.preventDefault();
		});
		$(selector + ' video').on('ended', function () {
			$(this).closest('.post-video').removeClass('playing');
		});
	}


	/**
	 * @function appearAnimate
	 * 
	 * @requires appear
	 * @param {string} selector
	 */
	Riode.appearAnimate = function (selector) {
		Riode.$(selector).each(function () {
			var el = this;
			Riode.appear(el, function () {
				if (el.classList.contains('appear-animate')) {
					var settings = Riode.parseOptions(el.getAttribute('data-settings')),
						duration;

					if (el.classList.contains('animated-slow')) {
						duration = 2000;
					} else if (el.classList.contains('animated-fast')) {
						duration = 750;
					} else {
						duration = 1000;
					}

					if (undefined != settings._animation_duration) {
						duration = settings._animation_duration;
					}
					Riode.call(function () {
						el.style['animation-duration'] = duration + 'ms';
						el.style['animation-delay'] = settings._animation_delay + 'ms';
						el.style['transition-property'] = 'visibility, opacity';
						el.style['transition-duration'] = '0s';
						el.style['transition-delay'] = settings._animation_delay + 'ms';

						el.classList.add(settings._animation);
						el.classList.add('appear-animation-visible');
						setTimeout(
							function () {
								el.style['transition-property'] = '';
								el.style['transition-duration'] = '';
								el.style['transition-delay'] = '';
							},
							settings._animation_delay ? settings._animation_delay + 500 : 500
						);
					});
				}
			});
		});

		Riode.$window.trigger('resize.waypoints');
	}
	Riode.animationOptions = {
		name: 'fadeIn',
		duration: '1.2s',
		delay: '.2s'
	};

	var videoIndex = {
		youtube: 'youtube.com',
		vimeo: 'vimeo.com/',
		gmaps: '//maps.google.',
		hosted: ''
	}
	/**
	 * @function initPopups
	 */
	Riode.initPopups = function () {
		// Register "Play Video" Popup
		$('.btn-video-iframe').on('click', function (e) {
			e.preventDefault();
			Riode.popup({
				items: {
					src: '<video src="' + videoIndex[$(this).data('video-source')] + $(this).attr('href') + '" autoplay loop controls>',
					type: 'inline'
				},
				mainClass: 'mfp-video-popup'
			}, 'video');
		});

		// Open Popup
		$('body > .popup').each(function (e) {
			var options = JSON.parse($(this).attr('data-popup-options')),
				$this = $(this);
			if ('scroll' == options.popup_on) {
				$(window).one('scroll', function () {
					setTimeout(function () {
						if (!Riode.getCookie('hideNewsletterPopup')) {
							Riode.popup({
								items: {
									src: $this[0]
								},
								callbacks: {
									open: function () {
										$('html').css('overflow-y', 'hidden');
										$('body').css('overflow-x', 'visible');
										$('.mfp-wrap').css('overflow', 'hidden auto');
										$('.sticky-content.fixed').css('margin-right', window.innerWidth - document.body.clientWidth);
										$('.hs-fullscreen.show').removeClass('show');

										$(this)[0].container.css({ 'animation-duration': options.popup_duration, 'animation-timing-function': 'linear' });

										$(this)[0].container.addClass(options.popup_animation + ' animated');

										$('.mfp-newsletter-popup .popup').css('display', '');
									},
									ajaxContentAdded: function () {
										var $popupContainer = $(this)[0].container.find('.popup');
										// Contact Form 7 Compatibility
										Riode.initWPCF7($popupContainer);
									}
								}
							}, 'firstpopup');
						}
					}, 1000 * options.popup_within);
				})
			}
		})

		// Popup on click event
		$('.show-popup').on('click', function () {
			var cls = $(this).attr('class').split(' '),
				id = -1;

			id = cls[cls.indexOf('show-popup') + 1].replace('popup-id-', '');

			Riode.popup({
				ajax: {
					settings: {
						data: {
							action: 'riode_print_popup',
							nonce: riode_vars.nonce,
							popup_id: id
						}
					}
				},
				callbacks: {
					afterChange: function () {
						this.container.html('<div class="mfp-content"></div><div class="mfp-preloader"><div class="popup-template"><div class="d-loading"><i></i></div></div></div>');
						this.contentContainer = this.container.children('.mfp-content');
						this.preloader = false;
					},
					beforeClose: function () {
						this.container.empty();
					},
					ajaxContentAdded: function () {
						var self = this,
							$popupContainer = $(this)[0].container.find('.popup'),
							options = JSON.parse($popupContainer.attr('data-popup-options'));

						self.contentContainer.next('.mfp-preloader').css('max-width', $popupContainer.css('max-width'));
						self.contentContainer.next('.mfp-preloader').remove();

						$('html').css('overflow-y', 'hidden');
						$('body').css('overflow-x', 'visible');
						$('.mfp-wrap').css('overflow', 'hidden auto');
						$('.sticky-content.fixed').css('margin-right', window.innerWidth - document.body.clientWidth);

						$('.mfp-popup-template .popup').css('display', '');

						$(this)[0].container.css({ 'animation-duration': options.popup_duration, 'animation-timing-function': 'linear' });

						$(this)[0].container.addClass(options.popup_animation + ' animated');

						// Contact Form 7 Compatibility
						Riode.initWPCF7($popupContainer);
					}
				}
			}, 'popup_template');
		})
	}


	Riode.initSalesPopup = function () {
		if (riode_vars.sales_popup && window.Worker) {
			/*setTimeout(function () {
				var message = riode_vars.sales_popup.title,
					products = JSON.parse(riode_vars.sales_popup.products),
					current = 0;

				function openSalesPopup() {
					var link = products[current].link,
						image = products[current].image,
						title = products[current].title,
						date = products[current].date;

					Riode.minipopup.open({
						content: '<div class="minipopup-box"><h4 class="minipopup-title">' + message +
							'</h4><div class="product product-list-sm mb-0"><figure class="product-media"><a href="' + link + '"><img src="' + image + '" alt="' + title +
							'"></a></figure><div class="product-detail"><a href="' + link + '" class="product-title">' + title + '</a><h6 class="date">' + date + '</h6></div></div></div>'
					}, function ($box) {
						// Riode.shop.ratingTooltip($box);
					});
					current = (current + 1) % products.length;
				}

				if (products.length) {
					openSalesPopup();
					setInterval(openSalesPopup, Riode.defaults.sales_popup_interval);
				}
			}, Riode.defaults.sales_popup_start);*/
			var message = riode_vars.sales_popup.title;
			function openSalesPopup(product) {
				var link = product.link,
					image = product.image,
					title = product.title,
					date = product.date;

				Riode.minipopup.open({
					content: '<div class="minipopup-box"><h4 class="minipopup-title">' + message +
						'</h4><div class="product product-list-sm mb-0"><figure class="product-media"><a href="' + link + '"><img src="' + image + '" alt="' + title +
						'"></a></figure><div class="product-detail"><a href="' + link + '" class="product-title">' + title + '</a><h6 class="date">' + date + '</h6></div></div></div>'
				}, function ($box) {
					// Riode.shop.ratingTooltip($box);
				});
			}

			var worker = new Worker(riode_vars.sales_popup.themeuri + '/inc/add-on/sales-popup/worker.js');
			worker.onmessage = function (e) {
				if (e.data && e.data.title) {
					openSalesPopup(e.data);
				}
			};
			worker.postMessage({ init: true, start: Riode.defaults.sales_popup_start, ajaxurl: riode_vars.ajax_url, nonce: riode_vars.nonce, interval: Riode.defaults.sales_popup_interval });
		}
	}


	Riode.initScrollTopButton = function () {
		// register scroll top button
		var $scrollTop = $('.scroll-top');

		if (!$scrollTop.length) {
			return;
		}

		$scrollTop.on('click', function (e) {
			Riode.scrollTo(0);
			e.preventDefault();
		})

		var refreshScrollTop = function () {
			if (window.pageYOffset > 400) {
				$scrollTop.addClass('show');
			} else {
				$scrollTop.removeClass('show');
			}
		}

		Riode.call(refreshScrollTop, 500);
		window.addEventListener('scroll', refreshScrollTop, { passive: true });
	}

	Riode.initScrollTo = function () {
		var target = window.location.hash,
			$target = $(document.getElementById(target.slice(1)));
		if (target && -1 == target.indexOf('?') && $target.length > 0) {
			Riode.scrollToFixedContent($target.offset().top, 400);
		}

		Riode.$body.on('click', '.scroll-to', function (e) {
			var target = $(this).attr('href');
			if (target.indexOf('#') == 0) {
				e.preventDefault();
				Riode.scrollToFixedContent($(target).offset().top, 400);
			} else {
				var url = window.location.href.split('/');

				url[url.length - 1] = '';
				url = url.join('/');

				if (target.indexOf(url) == 0) {
					target = target.substring(url.length);

					if (target.indexOf('#') == 0) {
						e.preventDefault();
						Riode.scrollToFixedContent($(target).offset().top, 400);
					}
				}
			}
		})
	}

	/**
	 * @function initContactForms
	 */
	Riode.initContactForms = function () {
		$('.wpcf7-form [aria-required="true"]').prop('required', true);
	}

	/**
	 * @function initSearchForm
	 */
	Riode.initSearchForm = function () {
		var $search = $('.hs-toggle');

		$search.find('.search-toggle').on('click', function (e) {
			e.preventDefault();
		})

		if (('ontouchstart' in document)) {
			$search.find('.search-toggle')
				.on('click', function (e) {
					$search.toggleClass('show');
				});
			$('body').on('click', function (e) {
				$search.removeClass('show');
			})
			$search.on('click', function (e) {
				e.stopPropagation();
			})
		} else {
			$search.find('.form-control')
				.on('focusin', function (e) {
					$search.addClass('show');
				})
				.on('focusout', function (e) {
					$search.removeClass('show');
				});
		}

		var $fullSearch = $('.hs-fullscreen');
		$fullSearch.find('.search-toggle').on('click touchstart', function (e) {
			var scrollBarWidth = window.innerWidth - document.body.clientWidth;
			$(this).closest('.hs-fullscreen').toggleClass('show');
			$('body').css('overflow', 'hidden');
			$('body').css('margin-right', scrollBarWidth + 'px');
			e.preventDefault();
		});
		$fullSearch.find('.search-form-close').add('.close-overlay').on('click', function (e) {
			$(this).closest('.hs-fullscreen').toggleClass('show');
			$('body').css('overflow', '');
			$('body').css('margin-right', '');
			e.preventDefault();
		});
		$(window).on('resize', function () {
			$('body').css('overflow', '');
			$('body').css('margin-right', '');
		});
	}

	/**
	 * @function initReadingProgressBar
	 */
	Riode.initReadingProgressBar = function () {
		var $progressBar = $('.rpb-wrapper .rpb');
		$(window).on('scroll', function () {
			var scrollPos = Number(window.scrollY) / Number($('body').outerHeight() - window.innerHeight);
			$progressBar.css('width', scrollPos * 100 + '%');
			$progressBar.css('transition', 'width .3s');
		});
	}

	/**
	 * @function initHotspot
	 */
	Riode.initHotspot = function () {
		Riode.$body.on('click', '.hotspot-wrapper .hotspot', function (e) {
			if ('' == $(this).attr('href') || '#' == $(this).attr('href')) {
				e.preventDefault();
			}
		});
	}

	/**
	 * @function initDismissButton
	 * @since 1.4.0
	 */
	Riode.initDismissButton = function () {
		Riode.$body.on('click', '.dismiss-widget .dismiss-button', function (e) {
			e.preventDefault();

			var $widget = $(this).closest('.dismiss-widget'),
				options = $(this).attr('data-options');

			if (options) {
				options = JSON.parse(options);
			} else {
				options = {};
			}

			if (undefined != options.animation) {
				var css = '';

				if (!options.animation_duration) {
					options.animation_duration = 400;
				}
				css += (options.animation_duration / 1000) + 's ';

				if (options.animation_delay) {
					css += (options.animation_delay / 1000) + 's ';
				}

				css += options.animation;

				$widget.css('animation', css);
				setTimeout(function () {
					$widget.remove();
				}, Number(options.animation_duration) + Number(options.animation_delay));
			} else {
				$widget.fadeOut();
			}

			if (!riode_vars.preview.length && options['cookie_enable']) {
				$.ajax({
					type: 'POST',
					url: riode_vars.ajax_url,
					data: {
						action: "riode_set_cookie_dismiss_widget",
						nonce: riode_vars.nonce,
						widget_id: $(this).attr('data-widget-id'),
						expire: options['cookie_expire'] ? options['cookie_expire'] : 7
					},
					dataType: 'json',
					success: function (response) {
						if (!response) {
							return;
						}
					}
				});
			}
		});
	}


	/**
	 * @function initElementor
	 */
	Riode.initElementor = function () {
		if ('undefined' != typeof elementorFrontend) {
			elementorFrontend.waypoint($('.elementor-counter-number'), function () {
				var $this = $(this),
					data = $this.data(),
					decimalDigits = data.toValue.toString().match(/\.(.*)/);

				if (decimalDigits) {
					data.rounding = decimalDigits[1].length;
				}

				$this.numerator(data);
			});
		}
	}

	/**
	 * @function initVideoPlayer
	 * @param selector 
	 */
	Riode.initVideoPlayer = function (selector) {
		if (typeof selector == 'undefined') {
			selector = '.btn-video-player';
		}
		Riode.$(selector).on('click', function (e) {
			var video_banner = $(this).closest('.video-banner');
			if (video_banner.length && video_banner.find('video').length) {
				var video = video_banner.find('video');
				video = video[0];

				if (video_banner.hasClass('playing')) {
					video_banner.removeClass('playing').addClass('paused');
					video.pause();
				} else {
					video_banner.removeClass('paused').addClass('playing');
					video.play();
				}
			}

			if (video_banner.find('.parallax-background').length > 0) {
				video_banner.find('.parallax-background').css('z-index', '-1');
			}
			e.preventDefault();
		})
		Riode.$(selector).closest('.video-banner').find('video').on('playing', function () {
			$(this).closest('.video-banner').removeClass('paused').addClass('playing');
		})
		Riode.$(selector).closest('.video-banner').find('video').on('ended', function () {
			$(this).closest('.video-banner').removeClass('playing').addClass('paused');
		})
	}

	/**
	 * @function initDokanSearch
	 * 
	 * @since 1.1.0
	 */
	Riode.initDokanSearch = function () {
		var $input = $('#dokan-store-listing-filter-form-wrap .store-search-input');

		if ($input.length > 0) {
			var $form = $input.closest('#dokan-store-listing-filter-form-wrap'),
				$submit = $form.find('#apply-filter-btn');
			$input.on('keydown', function (e) {
				if ('Enter' == e.key) {
					$input.trigger('change');
					$submit.trigger('click');
					e.preventDefault();
				}
			});
		}
	}

	/**
	 * @function initWPCF7
	 * 
	 * @since 1.4.1
	 */
	Riode.initWPCF7 = function ($popupContainer) {
		// Contact Form 7 Compatibility
		if ($popupContainer.find('.wpcf7-form').length) {
			wpcf7.init($popupContainer.find('.wpcf7-form')[0]);
		}
	}

})(jQuery);
/**
 * Riode Plugin - AjaxLoadPosts
 * - Ajax load for products and posts in archive pages and widgets
 * - Ajax filter products and posts
 * - Load more by button or infinite scroll
 * - Ajax pagination
 * - Compatibility with YITH WooCommerce Ajax Navigation
 */
(function ($) {
	/**
	 * @class AjaxLoadPost
	 */
	var AjaxLoadPost = {
		isShop: riode_vars.shop_ajax ? $('body').hasClass('product-archive-layout') : false,
		isBlog: riode_vars.blog_ajax ? $('body').hasClass('post-archive-layout') : false,
		scrollWrappers: false,

		init: function () {

			AjaxLoadPost.isShop && Riode.$body
				.on('click', '.widget_product_categories a', this.filterByCategory)             // Product Category
				.on('click', '.toolbox .product-filters a', this.filterByCategory)              // Product Category in Toolbox
				.on('click', '.widget_product_tag_cloud a', this.filterByLink)                  // Product Tag Cloud
				.on('click', '.riode-price-filter a', this.filterByLink)                        // DND - Price Filter
				.on('click', '.woocommerce-widget-layered-nav a', this.filterByLink)            // Filter Products by Attribute
				.on('click', '.widget_price_filter .button', this.filterByPrice)                // Filter Products by Price
				.on('click', '.widget_rating_filter a', this.filterByRating)                    // Filter Products by Rating
				.on('click', '.filter-clean', this.filterByLink)                                // Reset Filter
				.on('click', '.toolbox-show-type .btn-showtype', this.changeShowType)           // Change Show Type
				.on('change', '.toolbox-show-count .count', this.changeShowCount)               // Change Show Count
				.on('click', '.yith-woo-ajax-navigation a', this.saveLastYithAjaxTrigger)       // Compatibility with YITH ajax navigation
				.on('change', '.sidebar select.dropdown_product_cat', this.filterByCategory)

			AjaxLoadPost.isBlog && Riode.$body
				.on('click', '.widget_categories a', this.filterPostsByLink)
				.on('click', '.widget_tag_cloud a', this.filterPostsByLink)
				.on('click', '.post-archive .blog-filters a', this.filterPostsByLink)

			Riode.$body
				.on('click', '.btn-load', this.loadmoreByButton)                                    // Load by button
				.on('click', '.pagination a', this.loadmoreByPagination)                            // Load by pagination
				.on('click', '.nav-filters .nav-filter', this.filterWidgetByCategory)               // Load by Nav Filter
				.on('click', '.filter-categories a', this.filterWidgetByCategory)                   // Load by Categories Widget's Filter

			Riode.$window.on('riode_complete riode_loadmore', this.startScrollLoad);                // Load by infinite scroll

			// Orderby
			if (AjaxLoadPost.isShop) {
				$('.toolbox .woocommerce-ordering')
					.off('change', 'select.orderby')
					.on('change', 'select.orderby', function (e) {
						AjaxLoadPost.loadPage(Riode.addUrlParam(location.href, 'orderby', this.value));
					});
			} else {
				Riode.$body
					.on('change', '.toolbox-show-count .count', this.changeShowCountPage)			// Change Show Count when ajax disabled
					.on('change', '.sidebar select.dropdown_product_cat', this.changeCategory); 	// Change category by dropdown
			}


			if (typeof yith_wcan != 'undefined') {
				// YITH AJAX Navigation Plugin Compatibility
				$(document)
					.on('yith-wcan-ajax-loading', this.loadingPage)
					.on('yith-wcan-ajax-filtered', this.loadedPage);
				// YITH WCAN Compatibility in shop pages.
				$('.yit-wcan-container').each(function () {
					$(this).parent('.product-archive').length || $(this).children('.products').addClass('ywcps-products').unwrap();
				});

				yith_wcan.container = '.product-archive .products';
			}
		},
		filterPostsByLink: function (e) {
			// If link's toggle is clicked, return
			if ((e.target.tagName == 'I' || e.target.classList.contains('toggle-btn'))
				&& e.target.parentElement == e.currentTarget) {
				return;
			}

			var $link = $(e.currentTarget);

			if ($link.is('.nav-filters .nav-filter')) {
				$link.closest('.nav-filters').find('.nav-filter').removeClass('active');
				$link.addClass('active')
			} else if ($link.hasClass('active') || $link.parent().hasClass('current-cat')) {
				return;
			}

			var $container = $('.post-archive .posts');

			if (!$container.length) {
				return;
			}

			if (AjaxLoadPost.isBlog && AjaxLoadPost.doLoading($container, 'filter')) {
				e.preventDefault();
				var url = Riode.addUrlParam(e.currentTarget.getAttribute('href'), 'only_posts', 1);
				$.get(decodeURIComponent(decodeURI(url.replace(/\/page\/(\d*)/, ''))), function (res) {
					res && AjaxLoadPost.loadedPage(0, res, url);
				});
			}
		},
		filterByPrice: function (e) {
			e.preventDefault();
			var url = location.href,
				minPrice = $(e.currentTarget).siblings('#min_price').val(),
				maxPrice = $(e.currentTarget).siblings('#max_price').val();
			minPrice && (url = Riode.addUrlParam(url, 'min_price', minPrice));
			maxPrice && (url = Riode.addUrlParam(url, 'max_price', maxPrice));
			AjaxLoadPost.loadPage(url);
		},
		filterByRating: function (e) {
			var match = e.currentTarget.getAttribute('href').match(/rating_filter=(\d)/);
			if (match && match[1]) {
				e.preventDefault();
				AjaxLoadPost.loadPage(Riode.addUrlParam(location.href, 'rating_filter', match[1]));
			}
		},
		filterByLink: function (e) {
			e.preventDefault();
			var href = e.currentTarget.getAttribute('href'),
				type = $('.btn-showtype.active').hasClass('d-icon-mode-list') ? 'list' : 'grid';
			AjaxLoadPost.loadPage(Riode.addUrlParam(href, 'showtype', type));
		},
		filterByCategory: function (e) {
			e.preventDefault();

			var url;
			if (e.type == 'change') { // Dropdown's event
				if (!this.value) {
					return;
				}
				url = riode_vars.pages.shop + 'product-category/' + this.value;

			} else { // Link's event
				// If link's toggle is clicked, return
				if (e.target.parentElement == e.currentTarget) {
					return;
				}

				// If it's active, return
				var $link = $(e.currentTarget);
				if ($link.hasClass('active') || $link.parent().hasClass('current-cat')) {
					return;
				}
				url = $link.attr('href');
			}

			var type = $('.toolbox-show-type .btn-showtype.active').hasClass('d-icon-mode-list');
			AjaxLoadPost.loadPage(Riode.addUrlParam(url, 'showtype', (type ? 'list' : 'grid')));
		},
		saveLastYithAjaxTrigger: function (e) {
			AjaxLoadPost.lastYithAjaxTrigger = e.currentTarget;
		},
		changeShowType: function (e) {
			e.preventDefault();
			if (!this.classList.contains('active')) {
				var type = this.classList.contains('d-icon-mode-list') ? 'list' : 'grid';
				$('.product-archive .products').data('loading_show_type', type) // For skeleton screen
				$(this).parent().children().toggleClass('active');              // Toggle active class
				AjaxLoadPost.loadPage(Riode.addUrlParam(location.href, 'showtype', type));

				$('.yith-woo-ajax-navigation a').each(function () {
					var $this = $(this),
						href = $this.attr('href');

					$this.attr('href', Riode.addUrlParam(href, 'showtype', type));
				});
			}
		},
		changeShowCount: function (e) {
			AjaxLoadPost.loadPage(Riode.addUrlParam(location.href, 'count', this.value));
		},

		/**
		 * Event handler to change show count for non ajax mode.
		 * 
		 * @since 1.2.0
		 * @param {Event} e 
		 */
		changeShowCountPage: function (e) {
			if (this.value) {
				location.href = Riode.addUrlParam(location.href.replace(/\/page\/\d*/, ''), 'count', this.value);
			}
		},

		/**
		 * Event handler to change category by dropdown
		 * 
		 * @since 1.2.0
		 * @param {Event} e 
		 */
		changeCategory: function (e) {
			location.href = this.value ? Riode.addUrlParam(riode_vars.home_url, 'product_cat', this.value) : riode_vars.shop_url;
		},

		/**
		 * @function refreshWidget
		 * @param {string} widgetSelector
		 * @param {jQuery} $newContent 
		 */
		refreshWidget: function (widgetSelector, $newContent) {
			var newWidgets = $newContent.find('.sidebar ' + widgetSelector),
				oldWidgets = $('.sidebar ' + widgetSelector);

			oldWidgets.length && oldWidgets.each(function (i) {
				newWidgets.eq(i).length && (this.innerHTML = newWidgets.eq(i).html());
			});
		},
		refreshButton: function ($wrapper, $newButton, options) {
			var $btn = $wrapper.siblings('.btn-load');

			if (typeof options != 'undefined') {
				if (typeof options == 'string' && options) {
					options = JSON.parse(options);
				}
				if (!options.args || options.max > options.args.paged) {
					if ($btn.length) {
						$btn[0].outerHTML = $newButton.length ? $newButton[0].outerHTML : '';
					} else {
						$newButton.length && $wrapper.after($newButton);
					}
					return;
				}
			}

			$btn.remove();
		},
		loadPage: function (url) {
			AjaxLoadPost.loadingPage();
			url = decodeURIComponent(decodeURI(url.replace(/\/page\/(\d*)/, '')));
			$.get(Riode.addUrlParam(url, 'only_posts', 1), function (res) {
				res && AjaxLoadPost.loadedPage(0, res, url);
			});
		},
		loadingPage: function (e) {
			var $container = $('.product-archive .products');

			if ($container.length) {
				if (e && e.type == 'yith-wcan-ajax-loading') {
					$container.removeClass('yith-wcan-loading').addClass('product-filtering');
				}
				if (AjaxLoadPost.doLoading($container, 'filter')) {
					Riode.scrollToFixedContent(
						($('.toolbox-top').length ? $('.toolbox-top') : $container).offset().top - 20,
						400
					);
				}
			}
		},
		loadedPage: function (e, res, url, loadmore_type) {
			var $res = $(res);
			$res.imagesLoaded(function () {

				var $container, $newContainer, $newToolbox, $toolbox;

				// Update browser history (IE doesn't support it)
				if (url && !Riode.isIE && loadmore_type != 'button' && loadmore_type != 'scroll') {
					history.pushState({ pageTitle: res && res.pageTitle ? '' : res.pageTitle }, "", Riode.removeUrlParam(url, 'only_posts'));
				}

				if (typeof loadmore_type == 'undefined') {
					loadmore_type = 'filter';
				}

				if (AjaxLoadPost.isBlog) {
					$container = $('.post-archive .posts');
					$newContainer = $res.find('.post-archive .posts');
				} else if (AjaxLoadPost.isShop) {
					$container = $('.product-archive .products');
					$newContainer = $res.find('.product-archive .products');

					// For Subcategories Page
					$toolbox = $('.toolbox');
					$newToolbox = $res.find('.toolbox');
					if (0 == $newToolbox.length) {
						$toolbox.css('display', 'none');
					} else {
						$toolbox.css('display', '');
					}
				}

				// Change content and update status.
				// When loadmore by button, scroll or pagination is performing, function 'loadmore' performs this.
				if (loadmore_type == 'filter') {
					$container.html($newContainer.html());
					AjaxLoadPost.endLoading($container, loadmore_type);

					// Update Loadmore
					if ($newContainer.attr('data-load')) {
						$container.attr('data-load', $newContainer.attr('data-load'));
					} else {
						$container.removeAttr('data-load');
					}
				}

				// Change page title bar
				if ($('.page-title-bar').length) { // Classic Page Title Bar
					$('.page-title-bar').html($res.find('.page-title-bar').length ? $res.find('.page-title-bar').html() : '');
				} else { // PTB Block
					var block_html = $res.filter('.ptb-block').length ? $res.filter('.ptb-block').html() : '';
					if (block_html) {
						$('.ptb-block').html(block_html);
					}
				}

				// Blog Archive

				if (AjaxLoadPost.isBlog) {

					// Update Loadmore - Button
					AjaxLoadPost.refreshButton($container, $newContainer.siblings('.btn-load'), $container.attr('data-load'));

					// Update Loadmore - Pagination
					var $pagination = $container.siblings('.pagination'),
						$newPagination = $newContainer.siblings('.pagination');
					if ($pagination.length) {
						$pagination[0].outerHTML = $newPagination.length ? $newPagination[0].outerHTML : '';
					} else {
						$newPagination.length && $container.after($newPagination);
					}

					// Update sidebar widgets
					AjaxLoadPost.refreshWidget('.widget_categories', $res);
					AjaxLoadPost.refreshWidget('.widget_tag_cloud', $res);

					// Update nav filter
					var $newNavFilters = $res.find('.post-archive .nav-filters');
					$newNavFilters.length && $('.post-archive .nav-filters').html($newNavFilters.html());

					// Init posts
					AjaxLoadPost.fitVideos($container, true);
					Riode.slider('.post-media-carousel');

				} else if (AjaxLoadPost.isShop) {
					var $parent = $('.product-archive'),
						$newParent = $res.find('.product-archive');

					// If new content is empty, show woocommerce info.
					if (!$newContainer.length) {
						$container.empty().append($res.find('.woocommerce-info'));
					}

					// Update Toolbox Title
					var $newTitle = $res.find('.main-content .toolbox .title');
					$newTitle.length && $('.main-content .toolbox .title').html($newTitle.html());

					// Update nav filter
					var $newNavFilters = $res.find('.main-content .toolbox .nav-filters');
					$newNavFilters.length && $('.main-content .toolbox .nav-filters').html($newNavFilters.html());

					// Update Show Count
					if (typeof loadmore_type != 'undefined' && (loadmore_type == 'button' || loadmore_type == 'scroll')) {
						var $span = $('.main-content .woocommerce-result-count > span');
						if ($span.length) {
							var newShowInfo = $span.html(),
								match = newShowInfo.match(/\d+\–(\d+)/);
							if (match && match[1]) {
								var last = parseInt(match[1]) + $newContainer.children().length,
									match = newShowInfo.replace(/\d+\–\d+/, '').match(/\d+/);
								$span.html(match && match[0] && last == match[0] ? riode_vars.texts.show_info_all.replace('%d', last) : newShowInfo.replace(/(\d+)\–\d+/, '$1–' + last));
							}
						}
					} else {
						var newShowInfo = $res.find('.woocommerce-result-count').html();
						if (typeof newShowInfo == 'undefined') {
							$('.main-content .woocommerce-result-count').html('').addClass('empty');
						} else {
							$('.main-content .woocommerce-result-count').html(newShowInfo).removeClass('empty');
						}
					}

					// Update Toolbox Pagination
					var $toolboxPagination = $parent.siblings('.toolbox-pagination'),
						$newToolboxPagination = $newParent.siblings('.toolbox-pagination');
					if (!$toolboxPagination.length) {
						$newToolboxPagination.length && $parent.after($newToolboxPagination);
					} else {

						// Update Loadmore - Pagination
						var $pagination = $parent.siblings('.toolbox-pagination').find('.pagination'),
							$newPagination = $newParent.siblings('.toolbox-pagination').find('.pagination');
						if ($pagination.length) {
							$pagination[0].outerHTML = $newPagination.length ? $newPagination[0].outerHTML : '';
						} else {
							$newPagination.length && $parent.siblings('.toolbox-pagination').append($newPagination);
						}
					}

					// Update Loadmore - Button
					AjaxLoadPost.refreshButton($parent, $newParent.siblings('.btn-load'), $container.attr('data-load'));

					// Update Sidebar Widgets
					if (loadmore_type == 'filter') {
						AjaxLoadPost.refreshWidget('.riode-price-filter', $res);

						AjaxLoadPost.refreshWidget('.widget_rating_filter', $res);
						Riode.shop.ratingTooltip('.widget_rating_filter')

						AjaxLoadPost.refreshWidget('.widget_price_filter', $res);
						Riode.initPriceSlider();

						AjaxLoadPost.refreshWidget('.widget_product_categories', $res);

						// Refresh Filter Products by Attribute Widgets
						AjaxLoadPost.refreshWidget('.woocommerce-widget-layered-nav ', $res);

						if (!e || e.type != "yith-wcan-ajax-filtered") {
							// Refresh YITH Ajax Navigation Widgets
							AjaxLoadPost.refreshWidget('.yith-woo-ajax-navigation', $res);
						} else {
							yith_wcan && $(yith_wcan.result_count).show();
							var $last = $(AjaxLoadPost.lastYithAjaxTrigger);
							$last.closest('.yith-woo-ajax-navigation').is(':hidden') && $last.parent().toggleClass('chosen');
							$('.sidebar .yith-woo-ajax-navigation').show();
						}

						// Keep sub categories menu open after refresh sidebar
						if ($('.current-cat-parent ul').length) {
							$('.current-cat-parent ul').css('display', 'block');
						}
					}

					if (!$container.hasClass('skeleton-body')) {
						if ($container.data('loading_show_type')) {
							$container.toggleClass('list-type-products', 'list' == $container.data('loading_show_type'));
							$container.attr('class',
								$container.attr('class').replace(/row|cols\-\d|cols\-\w\w-\d/g, '').replace(/\s+/, ' ') +
								$container.attr('data-col-' + $container.data('loading_show_type'))
							);
							$('.main-content-wrap > .sidebar.closed').length && Riode.shop.switchColumns(false);
						}
					}

					// Remove loading show type.
					$container.removeData('loading_show_type');

					// Init products
					Riode.shop.initProducts($container);

					$container.removeClass('product-filtering');
				}

				$container.removeClass('skeleton-body load-scroll');
				$newContainer.hasClass('load-scroll') && $container.addClass('load-scroll');

				// Sidebar Widget Compatibility
				Riode.menu.initCollapsibleWidgetToggle();

				// Isotope Refresh
				if ($container.hasClass('grid')) {
					Riode.isotopes($container);
				}

				// Update Loadmore - Scroll
				Riode.call(AjaxLoadPost.startScrollLoad, 50);

				// Refresh layouts
				Riode.call(Riode.refreshLayouts);
			});
		},
		canLoad: function ($wrapper, type) {
			// check max
			if (type == 'button' || type == 'scroll') {
				var load = $wrapper.attr('data-load');
				if (load) {
					var options = JSON.parse($wrapper.attr('data-load'));
					if (options && options.args && options.max <= options.args.paged) {
						return false;
					}
				}
			}

			// If it is loading or active, return
			if ($wrapper.hasClass('loading-more') || $wrapper.hasClass('skeleton-body') || $wrapper.siblings('.d-loading').length) {
				return false;
			}

			return true;
		},
		doLoading: function ($wrapper, type) {
			if (!AjaxLoadPost.canLoad($wrapper, type)) {
				return false;
			}

			// "Loading start" effect
			if (riode_vars.skeleton_screen && $wrapper.closest('.product-archive, .post-archive').length) {
				// Skeleton screen for archive pages
				var count = 12,
					template = '';

				if ($wrapper.closest('.product-archive').length) {
					count = parseInt(Riode.getCookie('riode_count'));
					if (!count) {
						var $count = $('.main-content .toolbox-show-count .count');
						$count.length && (count = $count.val());
					}
					count || (count = 12);
				} else if ($wrapper.closest('.post-archive').length) {
					$wrapper.children('.grid-space').remove();
					count = riode_vars.posts_per_page;
				}

				if ($wrapper.hasClass('products')) {
					var skelType = $wrapper.hasClass('list-type-products') ? 'skel-pro skel-pro-list' : 'skel-pro';
					if ($wrapper.data('loading_show_type')) {
						skelType = 'list' == $wrapper.data('loading_show_type') ? 'skel-pro skel-pro-list' : 'skel-pro';
					}
					template = '<li class="product-wrap"><div class="' + skelType + '"></div></li>';
				} else {
					template = '<div class="post-wrap"><div class="' + ($wrapper.hasClass('list-type-posts') ? 'skel-post-list' : 'skel-post') + '"></div></div>';
				}

				// Empty wrapper
				if (type == 'page' || type == 'filter') {
					$wrapper.html('');
				}

				if ($wrapper.data('loading_show_type')) {
					$wrapper.toggleClass('list-type-products', 'list' == $wrapper.data('loading_show_type'));
					$wrapper.attr('class',
						$wrapper.attr('class').replace(/row|cols\-\d|cols\-\w\w-\d/g, '').replace(/\s+/, ' ') +
						$wrapper.attr('data-col-' + $wrapper.data('loading_show_type'))
					);
					$('.main-content-wrap > .sidebar.closed').length && Riode.shop.switchColumns(false);
				}

				if (Riode.isIE) {
					var tmpl = '';
					while (count--) { tmpl += template; }
					$wrapper.addClass('skeleton-body').append(tmpl);
				} else {
					$wrapper.addClass('skeleton-body').append(template.repeat(count));
				}
			} else {
				// Widget or not skeleton in archive pages
				if (type == 'button' || type == 'scroll') {
					Riode.showMore($wrapper);
				} else {
					Riode.doLoading($wrapper.parent());
				}
			}

			// Scroll to wrapper's top offset
			if (type == 'page') {
				Riode.scrollToFixedContent(($('.toolbox-top').length ? $('.toolbox-top') : $wrapper).offset().top - 20, 400);
			}

			if ($wrapper.data('isotope')) {
				$wrapper.isotope('destroy');
			}

			$wrapper.addClass('loading-more');

			return true;
		},
		endLoading: function ($wrapper, type) {
			// Clear loading effect
			if (riode_vars.skeleton_screen && $wrapper.closest('.product-archive, .post-archive').length) { // shop or blog archive
				if (type == 'button' || type == 'scroll') {
					$wrapper.find('.skel-pro,.skel-post').parent().remove();
				}
			} else {
				if (type == 'button' || type == 'scroll') {
					Riode.hideMore($wrapper.parent());
				} else {
					Riode.endLoading($wrapper.parent());
				}
			}
			$wrapper.removeClass('loading-more');
		},
		filterWidgetByCategory: function (e) {
			var $filter = $(e.currentTarget);

			e.preventDefault();

			// If this is filtered by archive page's toolbox filter or this is active now, return.
			if ($filter.is('.toolbox .nav-filter') || $filter.is('.post-archive .nav-filter') || $filter.hasClass('active')) {
				return;
			}

			// Find Wrapper
			var filterNav, $wrapper, filterCat = $filter.attr('data-cat');

			filterNav = $filter.closest('.nav-filters');
			if (filterNav.length) {
				$wrapper = filterNav.parent().find(filterNav.hasClass('product-filters') ? '.products' : '.posts');
			} else {
				filterNav = $filter.closest('.filter-categories');
				if (filterNav.length) {
					if ($filter.closest('.elementor-section').length) {
						$wrapper = $filter.closest('.elementor-section').find('.products[data-load]').eq(0);
					} else if ($filter.closest('.wpb_row').length) {
						$wrapper = $filter.closest('.wpb_row').find('.products[data-load]').eq(0);
					}
				}
			}

			$wrapper.length &&
				AjaxLoadPost.loadmore({
					wrapper: $wrapper,
					page: 1,
					type: 'filter',
					category: filterCat,
					onStart: function () {
						// Toggle active button class
						filterNav.length && (
							filterNav.find('a').removeClass('active'),
							filterNav.find('.product-category').removeClass('active'),
							$filter.addClass('active'),
							$filter.closest('.product-category').addClass('active')
						);
					}
				})
		},

		/**
		 * Event handler for ajax loading by bytton
		 */
		loadmoreByButton: function (e) {
			var $btn = $(e.currentTarget); // This will be replaced with new html of ajax content.
			e.preventDefault();

			AjaxLoadPost.loadmore({
				wrapper: $btn.siblings('.product-archive').length ? $btn.siblings('.product-archive').find('.products') : $btn.siblings('.products, .posts'),
				page: '+1',
				type: 'button',
				onStart: function () {
					$btn.addClass('loading').blur().html(riode_vars.texts.loading)
				},
				onFail: function () {
					$btn.text(riode_vars.texts.loadmore_error).addClass('disabled');
				}
			});
		},

		/**
		 * Event handler for ajax loading by infinite scroll
		 */
		startScrollLoad: function () {
			AjaxLoadPost.scrollWrappers = $('.load-scroll');
			if (AjaxLoadPost.scrollWrappers.length) {
				AjaxLoadPost.loadmoreByScroll();
				Riode.$window.off('scroll resize', AjaxLoadPost.loadmoreByScroll);
				window.addEventListener('scroll', AjaxLoadPost.loadmoreByScroll, { passive: true });
				window.addEventListener('resize', AjaxLoadPost.loadmoreByScroll, { passive: true });
			}
		},

		loadmoreByScroll: function ($scrollWrapper) {
			var target = AjaxLoadPost.scrollWrappers,
				loadOptions = target.attr('data-load'),
				maxPage = 1,
				curPage = 1;

			if (loadOptions) {
				loadOptions = JSON.parse(loadOptions);
				maxPage = loadOptions.max;
				if (loadOptions.args.paged) {
					curPage = loadOptions.args.paged;
				}
			}

			if (curPage >= maxPage) {
				return;
			}

			$scrollWrapper && $scrollWrapper instanceof jQuery && (target = $scrollWrapper);

			// load more
			target.length && AjaxLoadPost.canLoad(target, 'scroll') && target.each(function () {
				var rect = this.getBoundingClientRect();
				if (rect.top + rect.height > 0 &&
					rect.top + rect.height < window.innerHeight) {
					AjaxLoadPost.loadmore({
						wrapper: $(this),
						page: '+1',
						type: 'scroll',
						onDone: function ($result, $wrapper, options) {
							// check max
							if (options.max && options.max <= options.args.paged) {
								$wrapper.removeClass('load-scroll');
							}
							// continue loadmore again
							Riode.call(AjaxLoadPost.startScrollLoad, 50);
						},
						onFail: function (jqxhr, $wrapper) {
							$wrapper.removeClass('load-scroll');
						}
					});
				}
			});

			// remove loaded wrappers
			AjaxLoadPost.scrollWrappers = AjaxLoadPost.scrollWrappers.filter(function () {
				var $this = $(this);
				$this.children('.post-wrap,.product-wrap').length || $this.removeClass('load-scroll');
				return $this.hasClass('load-scroll');
			});
			AjaxLoadPost.scrollWrappers.length || (
				window.removeEventListener('scroll', AjaxLoadPost.loadmoreByScroll),
				window.removeEventListener('resize', AjaxLoadPost.loadmoreByScroll)
			)
		},

		fitVideos: function ($wrapper, fitVids) {
			// Video Post Refresh
			if ($wrapper.find('.fit-video').length) {
				var defer_mecss = (function () {
					var deferred = $.Deferred();
					if ($('#wp-mediaelement-css').length) {
						deferred.resolve();
					} else {
						$(document.createElement('link')).attr({
							id: 'wp-mediaelement-css',
							href: riode_vars.ajax_url.replace('wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/wp-mediaelement.min.css'),
							media: 'all',
							rel: 'stylesheet'
						}).appendTo('body').on(
							'load',
							function () {
								console.log('defer_mecss loaded');
								deferred.resolve();
							}
						);
					}
					return deferred.promise();
				})();
				var defer_mecss_legacy = (function () {
					var deferred = $.Deferred();
					if ($('#mediaelement-css').length) {
						deferred.resolve();
					} else {
						$(document.createElement('link')).attr({
							id: 'mediaelement-css',
							href: riode_vars.ajax_url.replace('wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelementplayer-legacy.min.css'),
							media: 'all',
							rel: 'stylesheet'
						}).appendTo('body').on(
							'load',
							function () {
								-('defer_mecss_legacy loaded');
								deferred.resolve();
							}
						);
					}
					return deferred.promise();
				})();
				var defer_mejs = (function () {
					var deferred = $.Deferred();

					if (typeof window.wp.mediaelement != 'undefined') {
						deferred.resolve();
					} else {

						$('<script>var _wpmejsSettings = { "stretching": "responsive" }; </script>').appendTo('body');

						var defer_mejsplayer = (function () {
							var deferred = $.Deferred();

							$(document.createElement('script')).attr('id', 'mediaelement-core-js').appendTo('body').on(
								'load',
								function () {
									console.log('defer_mejsplayer loaded');

									deferred.resolve();
								}
							).attr('src', riode_vars.ajax_url.replace('wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelement-and-player.min.js'));

							return deferred.promise();
						})();
						var defer_mejsmigrate = (function () {
							var deferred = $.Deferred();

							setTimeout(function () {
								$(document.createElement('script')).attr('id', 'mediaelement-migrate-js').appendTo('body').on(
									'load',
									function () {
										console.log('defer_mejsmigrate loaded');

										deferred.resolve();
									}
								).attr('src', riode_vars.ajax_url.replace('wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/mediaelement-migrate.min.js'));
							}, 100);

							return deferred.promise();
						})();
						$.when(defer_mejsplayer, defer_mejsmigrate).done(
							function (e) {
								$(document.createElement('script')).attr('id', 'wp-mediaelement-js').appendTo('body').on(
									'load',
									function () {
										console.log('defer_mejs loaded');
										deferred.resolve();
									}
								).attr('src', riode_vars.ajax_url.replace('wp-admin/admin-ajax.php', 'wp-includes/js/mediaelement/wp-mediaelement.min.js'));
							}
						);
					}

					return deferred.promise();
				})();
				var defer_fitvids = (function () {
					var deferred = $.Deferred();
					if ($.fn.fitVids) {
						deferred.resolve();
					} else {
						$(document.createElement('script')).attr('id', 'jquery.fitvids-js').appendTo('body').on(
							'load',
							function () {
								console.log('defer_fitvids loaded');
								deferred.resolve();
							}
						).attr('src', riode_vars.assets_url + '/vendor/jquery.fitvids/jquery.fitvids.min.js');
					}
					return deferred.promise();
				})();
				$.when(defer_mecss, defer_mecss_legacy, defer_mejs, defer_fitvids).done(
					function (e) {
						if (fitVids) {
							Riode.call(function () {
								Riode.fitVideoSize($wrapper);
							}, 200);
						}
					}
				);
			}
		},

		/**
		 * Event handler for ajax loading by pagination
		 */
		loadmoreByPagination: function (e) {
			var $btn = $(e.currentTarget); // This will be replaced with new html of ajax content

			if (!$(document.body).hasClass('post-archive-layout') && !$(document.body).hasClass('product-archive-layout')) {
				return;
			}

			e.preventDefault();

			var $pagination = $btn.closest('.toolbox-pagination').length ? $btn.closest('.toolbox-pagination') : $btn.closest('.pagination');

			AjaxLoadPost.loadmore({
				wrapper: $pagination.siblings('.product-archive').length ?
					$pagination.siblings('.product-archive').find('.products') :
					$pagination.siblings('.products, .posts'),

				page: $btn.hasClass('next') ? '+1' :
					($btn.hasClass('prev') ? '-1' : $btn.text()),
				type: 'page',
				onStart: function ($wrapper, options) {
					Riode.doLoading($btn.closest('.pagination'), 'simple');
				}
			});
		},

		/**
		 * @function loadmore
		 * Load more ajax content
		 * 
		 * @param {object} params
		 * @return {boolean}
		 */
		loadmore: function (params) {
			if (!params.wrapper ||
				1 != params.wrapper.length ||
				!params.wrapper.attr('data-load') ||
				!AjaxLoadPost.doLoading(params.wrapper, params.type)) {
				return false;
			}

			// Get wrapper
			var $wrapper = params.wrapper;

			// Get options
			var options = JSON.parse($wrapper.attr('data-load'));
			options.args = options.args || {};
			if (!options.args.paged) {
				options.args.paged = 1;

				// Get correct page number at first in archive pages
				if ($wrapper.closest('.product-archive, .post-archive').length) {
					var match = location.pathname.match(/\/page\/(\d*)/);
					if (match && match[1]) {
						options.args.paged = parseInt(match[1]);
					}
				}
			}
			if ('filter' == params.type) {
				options.args.paged = 1;
				if (params.category) {
					options.args.category = params.category; // filter category
				} else if (options.args.category) {
					delete options.args.category; // do not filter category
				}
			} else if ('+1' === params.page) {
				++options.args.paged;
			} else if ('-1' === params.page) {
				--options.args.paged;
			} else {
				options.args.paged = parseInt(params.page);
			}

			// Get ajax url
			var url = riode_vars.ajax_url;
			if ($wrapper.closest('.product-archive, .post-archive').length) { // shop or blog archive
				var pathname = location.pathname;
				if (pathname.endsWith('/')) {
					pathname = pathname.slice(0, pathname.length - 1);
				}
				if (pathname.indexOf('/page/') >= 0) {
					pathname = pathname.replace(/\/page\/\d*/, '/page/' + options.args.paged);
				} else {
					pathname += '/page/' + options.args.paged;
				}

				url = Riode.addUrlParam(location.origin + pathname + location.search, 'only_posts', 1);
				if (options.args.category && options.args.category != '*') {
					url = Riode.addUrlParam(url, 'product_cat', category);
				}
			}

			// Add product-page param to set current page for pagination
			if ($wrapper.hasClass('products') && !$wrapper.closest('.product-archive').length) {
				url = Riode.addUrlParam(url, 'product-page', options.args.paged);
			}

			// Get ajax data
			var data = {
				action: $wrapper.closest('.product-archive, .post-archive').length ? '' : 'riode_loadmore',
				nonce: riode_vars.nonce,
				props: options.props,
				args: options.args,
			};
			if (params.type == 'page') {
				data.pagination = 1;
			}

			// Before start loading
			params.onStart && params.onStart($wrapper, options);

			// Do ajax
			$.post(url, data)
				.done(function (result) {
					// In case of posts widget's pagination, result's structure will be {html: '', pagination: ''}.
					var res_pagination = '';
					if ($wrapper.hasClass('posts') && !$wrapper.closest('.post-archive').length && params.type == 'page') {
						result = JSON.parse(result);
						res_pagination = result.pagination;
						result = result.html;
					}

					// In other cases, result will be html.
					var $result = $(result),
						$content;

					$result.imagesLoaded(function () {

						// Get content, except posts widget
						if ($wrapper.closest('.product-archive').length) {
							$content = $result.find('.product-archive .products');
						} else if ($wrapper.closest('.post-archive').length) {
							$content = $result.find('.post-archive .posts');
						} else {
							$content = $wrapper.hasClass('products') ? $result.find('.products') : $result;
						}

						// Change status and content
						if (params.type == 'page' || params.type == 'filter') {
							if ($wrapper.data('owl.carousel')) {
								$wrapper.data('owl.carousel').destroy();
								$wrapper.data('slider-layout') && $wrapper.addClass($wrapper.data('slider-layout').join(' '));
							}
							$wrapper.data('isotope') && $wrapper.data('isotope').destroy();
							$wrapper.empty();
						}

						if (!$wrapper.hasClass('posts') || $wrapper.closest('.post-archive').length) {
							// Except posts widget, update max page and class
							var max = $content.attr('data-load-max');
							if (max) {
								options.max = parseInt(max);
							}
							// $wrapper.attr('class', $content.attr('class'));
							$wrapper.append($content.children());

							// After products have been added, update products max sales value.
							var $max_sales = $wrapper.children('.products-max-sales');
							if ($max_sales.length) {
								if ($max_sales.eq(0).attr('data-value') > $max_sales.eq(1).attr('data-value')) {
									$max_sales.eq(1).remove();
								} else {
									$max_sales.eq(0).remove();
								}
							}
						} else {
							// For posts widget
							$wrapper.append($content);
						}

						// Update wrapper status.
						$wrapper.attr('data-load', JSON.stringify(options));

						if ($wrapper.closest('.product-archive').length) {
							AjaxLoadPost.loadedPage(0, result, url, params.type);
						} else if ($wrapper.closest('.post-archive').length) {
							AjaxLoadPost.loadedPage(0, result, url, params.type);
						} else {
							// Change load controls for widget

							var loadmore_type = params.type == 'filter' ? options.props.loadmore_type : params.type;

							if (loadmore_type == 'button') {
								AjaxLoadPost.refreshButton($wrapper, $result.find('.btn-load'), options);

							} else if (loadmore_type == 'page') {
								var $pagination = $wrapper.parent().find('.pagination')
								var $newPagination = $wrapper.hasClass('posts') ? $(res_pagination) : $result.find('.pagination');
								if ($pagination.length) {
									$pagination[0].outerHTML = $newPagination.length ? $newPagination[0].outerHTML : '';
								} else {
									$newPagination.length && $wrapper.after($newPagination);
								}

							} else if (loadmore_type == 'scroll') {
								$wrapper.addClass('load-scroll');
								if (params.type == 'filter') {
									Riode.call(function () {
										AjaxLoadPost.loadmoreByScroll($wrapper);
									}, 50);
								}
							}
						}

						// Init products and posts
						$wrapper.hasClass('products') && Riode.shop.initProducts($wrapper);
						$wrapper.hasClass('posts') && AjaxLoadPost.fitVideos($wrapper, true);

						// Refresh layouts
						if ($wrapper.hasClass('grid')) {
							$wrapper.removeData('isotope');
							Riode.isotopes($wrapper);
						}
						if ($wrapper.hasClass('owl-carousel')) {
							Riode.slider($wrapper);
						}

						params.onDone && params.onDone($result, $wrapper, options);

						// If category filter is not set in widget and loadmore has been limited to max, remove data-load attribute
						if (!$wrapper.hasClass('filter-products') &&
							!($wrapper.hasClass('products') && $wrapper.parent().siblings('.nav-filters').length) &&
							options.max && options.max <= options.args.paged && 'page' != params.type) {
							$wrapper.removeAttr('data-load');
						}

						AjaxLoadPost.endLoading($wrapper, params.type);
						params.onAlways && params.onAlways(result, $wrapper, options);
						Riode.refreshLayouts();
					});
				}).fail(function (jqxhr) {
					params.onFail && params.onFail(jqxhr, $wrapper);
					AjaxLoadPost.endLoading($wrapper, params.type);
					params.onAlways && params.onAlways(result, $wrapper, options);
				});

			return true;
		}
	}
	Riode.initAjaxLoadPost = function () {
		AjaxLoadPost.init();
		Riode.AjaxLoadPost = AjaxLoadPost;
	}
})(jQuery);
/**
 * Riode Plugin - Menu
 */
(function ($) {

	// Private Properties

	function showMobileMenu(e) {
		var $mmenuContainer = $('.mobile-menu-wrapper .mobile-menu-container');
		Riode.$body.addClass('mmenu-active');
		e.preventDefault();

		function initMobileMenu() {
			Riode.liveSearch && Riode.liveSearch('', $('.mobile-menu-wrapper .search-wrapper'));
			Riode.menu.addToggleButtons('.mobile-menu li');
		}

		if (!$mmenuContainer.find('.mobile-menu').length) {
			var cache = Riode.getCache(cache);

			// check cached mobile menu.
			if (cache.mobileMenu && cache.mobileSearch &&
				cache.mobileMenuLastTime && riode_vars.menu_last_time &&
				parseInt(cache.mobileMenuLastTime) >= parseInt(riode_vars.menu_last_time)) {

				// fetch mobile menu from cache
				$mmenuContainer.append(cache.mobileSearch + cache.mobileMenu);
				initMobileMenu();
			} else {
				// fetch mobile menu from server
				Riode.doLoading($mmenuContainer);
				$.post(riode_vars.ajax_url, {
					action: "riode_load_mobile_menu",
					nonce: riode_vars.nonce,
					load_mobile_menu: true,
				}, function (result) {
					var html = '',
						$result = $(result),
						$menus = $result.find('nav'),
						$search = $result.find('.search-wrapper'),
						type = $(result).find('.nav-wrapper').attr('data-menu-arrange');

					$mmenuContainer.css('height', '');
					Riode.endLoading($mmenuContainer);

					// Add mobile menu search
					$mmenuContainer.append($search);

					// Add mobile menu
					if ($menus.length > 1 && type == 'tab') {
						// Add mobile menu tab
						var html = '<div class="tab tab-nav-simple tab-nav-boxed">',
							i, id;

						html += '<ul class="nav nav-tabs nav-fill" role="tablist">';
						for (i = 0; i < $menus.length; i++) {
							id = $menus[i].className.replace(' ', '-');
							html += '<li class="nav-item"><a class="nav-link' + (i == 0 ? ' active' : '') + '" href="#' + id + '">' + $menus[i].className.replace('-', ' ') + '</a></li>';
						}
						html += '</ul>';

						html += '<div class="tab-content">';
						for (i = 0; i < $menus.length; i++) {
							id = $menus[i].className.replace(' ', '-');
							html += '<div class="tab-pane' + (i == 0 ? ' active in' : '') + '" id="' + id + '">' + $menus[i].childNodes[0].outerHTML + '</div>';
						}
						html += '</div>';

						html += '</div>';
						$mmenuContainer.append(html);
					} else {
						$menus.length && (html = $menus[0].outerHTML);
						$mmenuContainer.append($menus);
					}

					initMobileMenu();

					// save mobile menu cache
					cache.mobileMenuLastTime = riode_vars.menu_last_time;
					cache.mobileMenu = html;
					cache.mobileSearch = $search.length ? $search[0].outerHTML : '';
					Riode.setCache(cache);
				});
			}
		}
	}

	function hideMobileMenu(e) {
		if (e && e.type && 'resize' == e.type && !Riode.windowResized(e.timeStamp)) {
			return;
		}
		e.preventDefault();
		Riode.$body.removeClass('mmenu-active');
	}

	var initMenuPosition = function () {
		function recalcMenuPosition() {
			$('.vertical-menu > li ul').add('.horizontal-menu > li ul').each(function () {
				if ($(this).hasClass('megamenu')) {
					return;
				}

				var $this = $(this),
					o = $this.offset(),
					left = o.left,
					outerWidth = $this.outerWidth();

				if ($this.parent().parent().hasClass('mp-left')) {
					$this.attr('left', left);
					if (left < 0) {
						$this.removeClass('mp-left');
						$this.addClass('mp-right');
					} else {
						$this.addClass('mp-left');
					}
				} else {
					var offset = (left + outerWidth) - (window.innerWidth - 20);
					if (offset > 0) {
						$this.addClass('mp-left');
					} else {
						$this.removeClass('mp-left');
					}
				}
			});
		}

		recalcMenuPosition();
		Riode.$window.on('resize recalc_menus', recalcMenuPosition);
	}

	var initMegaMenu = function () {
		// calc megamenu position
		function recalcMenuPosition() {
			// $('nav .menu .megamenu, .menu > li > ul').each(function () {
			$('nav .menu .megamenu').each(function () {
				$(this).css('margin-left', '').css('margin-right', '');

				var $this = $(this),
					o = $this.offset(),
					left = o.left,
					outerWidth = $this.outerWidth(),
					right = left + outerWidth,
					windowWidth = $(window).width();

				if ($this.hasClass('full-megamenu')) {
					$this.css("margin-left", (windowWidth - outerWidth) / 2 - left + 'px');
				} else {
					if (left < 20) {
						var offset = 20 - left;
						if ($this.hasClass('mp-right')) {
							$this.css("margin-right", '-' + offset + 'px');
						} else {
							$this.css("margin-left", offset + 'px');
						}
					}

					if (right > windowWidth - 20) {
						var offset = right - (windowWidth - 20);
						if ($this.hasClass('mp-right')) {
							$this.css("margin-left", offset + 'px');
						} else {
							$this.css("margin-left", '-' + offset + 'px');
						}
					}
				}
			});
		}
		recalcMenuPosition();
		Riode.$window.on('resize recalc_menus', recalcMenuPosition);
	}

	var Menu = {
		init: function () {
			this.initMenu();
			this.initFilterMenu();
			this.initToggleDropdownMenu();
			this.initCollapsibleWidget();
			this.initCollapsibleWidgetToggle();
		},
		initMenu: function ($selector) {

			if (typeof $selector == 'undefined') {
				$selector = '';
			}

			// no link
			Riode.$body.on('click', $selector + ' .nolink', function (e) {
				e.preventDefault();
			});

			// mobile menu
			$('.mobile-menu-toggle').on('click', showMobileMenu);
			$('.mobile-menu-overlay').on('click', hideMobileMenu);
			$('.mobile-menu-close').on('click', hideMobileMenu);
			window.addEventListener('resize', hideMobileMenu, { passive: true });

			this.addToggleButtons($selector + ' .collapsible-menu li');

			// megamenu
			initMegaMenu();
			initMenuPosition();

			// lazyload menu image
			riode_vars.lazyload && Riode.call(function () {
				$('.megamenu .d-lazyload').add('.megamenu .d-lazy-back').add('.megamenu [data-lazy-back]').each(function () {
					Riode._lazyload_force(this);
				})
			});
		},
		addToggleButtons: function (selector) {
			Riode.$(selector).each(function () {
				if (this.classList.contains('menu-item-has-children') && this.firstElementChild && (!this.firstElementChild.lastElementChild || !this.firstElementChild.lastElementChild.classList.contains('toggle-btn'))) {
					var span = document.createElement('span');
					span.className = "toggle-btn";
					this.firstElementChild.appendChild(span);
				}
			});
		},
		initFilterMenu: function () {
			Riode.$body.on('click', '.with-ul > a i, .menu .toggle-btn, .mobile-menu .toggle-btn', function (e) {
				var $this = $(this);
				$this.parent().siblings(':not(.count)').slideToggle(300).parent().toggleClass("show");
				setTimeout(function () {
					$this.closest('.sticky-sidebar').trigger('recalc.pin');
				}, 320);
				e.preventDefault();
			});
		},
		initToggleDropdownMenu: function ($selector) {
			if (typeof $selector == 'undefined') {
				$selector = 'body';
			}

			// cat dropdown
			var $menu = $($selector + ' .toggle-menu');
			$menu.length && $menu.each(function () {
				var $m = $(this),
					$box = $m.find('.dropdown-box');
				if ($box.length) {
					var top = -1,
						lastPosition = -1;
					if ($m.hasClass('show-home')) {
						top = $('.main').offset().top + $box[0].offsetHeight;
					}
					if (window.innerWidth < 992) {
						$m.removeClass('show');
					} else {
						if (window.pageYOffset < top) {
							$m.hasClass('show-home') && $m.addClass('show');
						} else if (lastPosition < top) {
							$m.hasClass('show-home') && $m.removeClass('show');
						}

						lastPosition = window.pageYOffset;
					}
					var initShowDropdown = function () {
						if (window.innerWidth >= 992) {
							if (window.pageYOffset < top) {
								$m.hasClass('show-home') && $m.addClass('show');
							} else if (lastPosition < top) {
								$m.hasClass('show-home') && $m.removeClass('show');
							}

							lastPosition = window.pageYOffset;
						}
					};
					window.addEventListener('scroll', initShowDropdown, { passive: true });
					window.addEventListener('resize', initShowDropdown, { passive: true });
					$('.dropdown-menu-toggle').on("click", function (e) {
						e.preventDefault();
					})
					$m.on("mouseover", function (e) {
						if (window.pageYOffset > top && window.innerWidth >= 992) {
							$m.addClass('show');
						}
					})
					$m.on("mouseleave", function (e) {
						if (window.pageYOffset > top && window.innerWidth >= 992) {
							$m.removeClass('show');
						}
					})

					if ($m.hasClass('with-sidebar')) {
						var $sidebar = $('.col-lg-3.sidebar');
						if ($sidebar.length) {
							$m.find('.menu').css('width', $sidebar.width());

							// set category menu's width same as sidebar.
							Riode.$window.on('resize', function () {
								$m.find('.menu').css('width', $sidebar.width());
							});

							if (window.innerWidth >= 992) {
								if (window.pageYOffset < top) {
									$m.hasClass('show-home') && $m.addClass('show');
								} else if (lastPosition < top) {
									$m.hasClass('show-home') && $m.removeClass('show');
								}

								lastPosition = window.pageYOffset;
							}
						}
					}
				}
			});
		},
		initCollapsibleWidgetToggle: function (selector) {
			$('.widget .product-categories li').add('.sidebar .widget.widget_categories li').each(function () { // updated(47(
				if (this.lastElementChild && this.lastElementChild.tagName === 'UL') {
					var i = document.createElement('i');
					i.className = "fas fa-chevron-down";
					this.classList.add('with-ul');
					this.firstElementChild.appendChild(i);
				}
			});
			Riode.$('undefined' == typeof selector ? '.sidebar .widget-collapsible .widget-title' : selector)
				.each(function () {
					var $this = $(this);
					if ($this.closest('.top-filter-widgets').length ||
						$this.closest('.toolbox-horizontal').length ||  // if in shop pages's top-filter sidebar
						$this.siblings('.owl-carousel').length) {
						return;
					}
					// generate toggle icon
					if (!$this.children('.toggle-btn').length) {
						var span = document.createElement('span');
						span.className = 'toggle-btn';
						this.appendChild(span);
					}
				});
		},
		initCollapsibleWidget: function () {
			// slideToggle
			Riode.$body.on('click', '.sidebar .widget-collapsible .widget-title', function (e) {
				var $this = $(e.currentTarget);

				if ($this.closest('.top-filter-widgets').length ||
					$this.closest('.toolbox-horizontal').length ||  // if in shop pages's top-filter sidebar
					$this.siblings('.owl-carousel').length ||
					$this.hasClass('sliding')) {
					return;
				}
				var $content = $this.siblings('*:not(script):not(style)');
				$this.hasClass("collapsed") || $content.css('display', 'block');
				$this.addClass("sliding");
				$content.slideToggle(300, function () {
					$this.removeClass("sliding");
					Riode.$window.trigger('update_lazyload');
					$('.sticky-sidebar').trigger('recalc.pin');
				});
				$this.toggleClass("collapsed");
			});
		}
	}

	Riode.menu = Menu;
})(jQuery);
/**
 * Riode Plugin - Popup
 * 
 * @requires magnificPopup
 * @instance multiple
 */
(function ($) {

	function Popup(options, preset) {
		return this.init(options, preset);
	}

	// Public Properties

	Popup.presets = {
		'login': {
			type: 'ajax',
			mainClass: "mfp-login mfp-fade",
			tLoading: '<div class="login-popup"><div class="d-loading"><i></i></div></div>',
			preloader: true,
			items: {
				src: riode_vars.ajax_url,
			},
			ajax: {
				settings: {
					method: 'post',
					data: {
						action: 'riode_account_form',
						nonce: riode_vars.nonce
					}
				}, cursor: 'mfp-ajax-cur' // CSS class that will be added to body during the loading (adds "progress" cursor)
			}
		},
		'video': {
			type: 'iframe',
			mainClass: "mfp-fade",
			preloader: false,
			closeBtnInside: false
		},
		'firstpopup': {
			type: 'inline',
			mainClass: 'mfp-popup-template mfp-newsletter-popup mfp-flip-popup',
			callbacks: {
				beforeClose: function () {
					// if "do not show" is checked
					$('.mfp-newsletter-popup .popup .hide-popup input[type="checkbox"]').prop('checked') && Riode.setCookie('hideNewsletterPopup', true, 7);
					jQuery(this)[0].container.css({ 'animation-duration': '', 'animation-timing-function': '' });
				}
			}
		},
		'popup_template': {
			type: 'ajax',
			mainClass: "mfp-popup-template mfp-flip-popup",
			tLoading: '<div class="popup-template"><div class="d-loading"><i></i></div></div>',
			preloader: true,
			items: {
				src: riode_vars.ajax_url,
			},
			ajax: {
				settings: {
					method: 'post',
				}, cursor: 'mfp-ajax-cur' // CSS class that will be added to body during the loading (adds "progress" cursor)
			}
		},
	}

	Popup.prototype.init = function (options, preset) {
		var mpInstance = $.magnificPopup.instance;
		// if something is already opened, retry after 5seconds
		if (mpInstance.isOpen) {
			if (mpInstance.content) {
				var retry = this.init.bind(this);
				setTimeout(function () {
					retry(options, preset);
				}, 5000);
			} else {
				$.magnificPopup.close();
			}
		} else {
			// if nothing is opened, open new
			$.magnificPopup.open(
				$.extend(true, {},
					Riode.defaults.popup,
					preset ? Popup.presets[preset] : {},
					options
				)
			);
		}
	}

	Riode.Popup = Popup;
	Riode.popup = function (options, preset) {
		return new Popup(options, preset);
	}
})(jQuery);


/**
 * Riode Plugin - Sidebar
 * 
 * @instance multiple
 * 
 * Sidebar active class will be added to body tag : "sidebar class" + "-active"
 */
(function ($) {

	function Sidebar(name) {
		return this.init(name);
	}

	// Private Properties
	var is_mobile = window.innerWidth < 992;

	var onResizeNavigationStyle = function () {
		if (window.innerWidth < 992 && !is_mobile) {
			this.$sidebar.find('.sidebar-content, .filter-clean').removeAttr('style');
			this.$sidebar.find('.sidebar-content').attr('style', '');
			this.$sidebar.siblings('.toolbox').children(':not(:first-child)').removeAttr('style');
		} else if (window.innerWidth >= 992) {
			if (!this.$sidebar.hasClass('closed') && is_mobile) {
				this.$sidebar.addClass('closed')
				this.$sidebar.find('.sidebar-content').css('display', 'none');
			}
		}
		is_mobile = window.innerWidth < 992;
	}

	// Public Properties

	Sidebar.prototype.init = function (name) {
		var self = this;

		self.name = name;
		self.$sidebar = $('.' + name);
		self.isNavigation = false;

		// If sidebar exists
		if (self.$sidebar.length) {
			Riode.$window.on('resize', function (e) {
				if (Riode.windowResized(e.timeStamp)) {
					Riode.$body.removeClass(name + '-active');
					$('.page-wrapper, .sticky-content').css({ 'margin-left': '', 'margin-right': '' });
				}
			});

			// Keep sub categories menu open after refresh sidebar
			if ($('.current-cat-parent ul').length) {
				$('.current-cat-parent ul').css('display', 'block');
			}

			// Register toggle event
			self.$sidebar.find('.sidebar-toggle, .sidebar-toggle-btn')
				.add('.' + name + '-toggle')
				.on('click', function (e) {
					self.toggle();
					e.preventDefault();
					Riode.$window.trigger('update_lazyload');
					$('.sticky-sidebar').trigger('recalc.pinleft', [400]);
					$(this).blur();
				});

			// Register close event
			self.$sidebar.find('.sidebar-overlay, .sidebar-close')
				.on('click', function (e) {
					e.stopPropagation();
					self.toggle();
					e.preventDefault();
					$('.sticky-sidebar').trigger('recalc.pinleft', [400]);
				});

			// ESC shortkey for toggle event
			document.
				addEventListener('keydown', function (e) {
					var keyName = e.key;
					if ('Escape' == keyName) {
						Riode.$body
							.removeClass(self.name + '-active');
						$('.page-wrapper').css({ 'margin-left': '', 'margin-right': '' });
						$('.sticky-content.fixed').css({ 'transition': '', 'margin-left': '', 'margin-right': '' });
						setTimeout(function () {
							$('.sticky-content.fixed').css('transition', '');
						}, 400);
					}
				});

			// check if navigation style
			self.isNavigation = self.$sidebar.hasClass('top-sidebar') &&
				self.$sidebar.parent().hasClass('toolbox-wrap');

			if (self.isNavigation) {
				onResizeNavigationStyle = onResizeNavigationStyle.bind(this);
				Riode.$window.on('resize', onResizeNavigationStyle);

				if ($.cookie && 'true' == $.cookie('riode_horizontal_filter') && window.innerWidth >= 992) {
					$('.top-sidebar-toggle').trigger('click');
				}
			}
		}
		return false;
	}

	Sidebar.prototype.toggle = function (e) {
		var self = this;

		// if fixed sidebar
		if (window.innerWidth >= 992 && self.$sidebar.hasClass('sidebar-fixed')) {
			// is closed ?
			var isClosed = self.$sidebar.hasClass('closed');

			isClosed && Riode.call(Riode.refreshLayouts, 300);

			// if navigation style's sidebar
			if (self.isNavigation) {

				isClosed || self.$sidebar.find('.filter-clean').hide();

				self.$sidebar.siblings('.toolbox').children(':not(:first-child)').fadeToggle('fast');

				self.$sidebar
					.find('.sidebar-content')
					.stop()
					.animate(
						{
							'height': 'toggle',
							'margin-bottom': isClosed ? 'toggle' : -6
						}, function () {
							$(this).css('margin-bottom', '');
							isClosed && self.$sidebar.find('.filter-clean').fadeIn('fast');
						}
					);

				if ($.cookie) {
					$.cookie('riode_horizontal_filter', isClosed);
				}

				// finally, toggle fixed sidebar
				self.$sidebar.toggleClass('closed');
			} else {
				if (!self.$sidebar.hasClass('controllable-sidebar')) {
					return;
				}

				// if shop sidebar
				if (self.$sidebar.hasClass('shop-sidebar') && 'top-sidebar' != self.name) {
					Riode.shop.switchColumns(isClosed);
				}

				// finally, toggle fixed sidebar
				self.$sidebar.toggleClass('closed');
			}

		} else {
			var c_width = document.body.clientWidth,
				s_width = $('.' + self.name + ' .sidebar-content').outerWidth(),
				opened = Riode.$body.hasClass(self.name + '-active');

			self.$sidebar.find('.sidebar-overlay .sidebar-close').css('margin-left', - (window.innerWidth - document.body.clientWidth));

			// activate sidebar
			Riode.$body
				.toggleClass(self.name + '-active')
				.removeClass('closed');

			if (opened) {
				$('.page-wrapper').css({ 'margin-left': '', 'margin-right': '' });
				$('.sticky-content.fixed').css({ 'transition': 'opacity .5s, margin .4s', 'margin-left': '', 'margin-right': '' });
				setTimeout(function () {
					$('.sticky-content.fixed').css('transition', 'opacity .5s');
				}, 400);
			} else {
				Riode.call(Riode.refreshLayouts, 300);

				var offset = c_width - Number(riode_vars.container) - s_width,
					ml = 1 * s_width,
					mr = -1 * s_width,
					items = $('.page-wrapper').attr('data-left-fixed') ? $('.page-wrapper').attr('data-left-fixed').split(',') : [],
					add_w = 0;

				items.length & items.forEach(function (value, index) {
					add_w += $(value).outerWidth();
				});

				if ('right-sidebar' == self.name) {
					ml = -1 * s_width;
					mr = 1 * s_width;
					items = $('.page-wrapper').attr('data-right-fixed') ? $('.page-wrapper').attr('data-right-fixed').split(',') : [];
				}


				if (Riode.$body.hasClass('center-with-sidebar')) {
					if (Number(riode_vars.container) + s_width + add_w < c_width) {
						ml = ml > 0 ? ml / 2 + add_w : ml / 2;
						mr = mr > 0 ? mr / 2 + add_w : mr / 2;
					} else {
						ml = ml > 0 ? ml + add_w : ml;
						mr = mr > 0 ? mr + add_w : mr;
					}
				} else {

				}

				$('.page-wrapper').css({ 'margin-left': ml, 'margin-right': mr });
				$('.sticky-content.fixed').css({ 'transition': 'opacity .5s, margin .4s', 'margin-left': ml, 'margin-right': mr });
				setTimeout(function () {
					$('.sticky-content.fixed').css('transition', 'opacity .5s');
				}, 400);
			}

			// issue
			if (window.innerWidth >= 1200 && Riode.$body.hasClass('center-with-sidebar')) {
				$('.owl-carousel').trigger('refresh.owl.carousel');
			}
		}
	}

	Riode.Sidebar = Sidebar;
	Riode.sidebar = function (name) {
		return new Sidebar().init(name);
	}
})(jQuery);

/**
 * Riode Plugin - MiniPopup
 * 
 * @instance single
 */
(function ($) {
	// Private Properties

	var timerInterval = 200;
	var $area;
	var offset = 0;
	var boxes = [];
	var timers = [];
	var isPaused = false;
	var timerId = false;

	var timerClock = function () {
		if (isPaused) {
			return;
		}
		for (var i = 0; i < timers.length; ++i) {
			(timers[i] -= timerInterval) <= 0 && this.close(i--);
		}
	}

	// Public Properties

	var Minipopup = {
		space: 20,
		defaults: {
			// info
			content: '',
			// option
			delay: 4000, // milliseconds
		},

		init: function () {
			// init area
			var area = document.createElement('div');
			area.className = "minipopup-area";
			$(Riode.byClass('page-wrapper')).append(area);

			$area = $(area);
			$area.on('click', '.btn-close', function (e) {
				self.close($(this).closest('.minipopup-box').index());
			});

			// bind methods
			this.close = this.close.bind(this);
			timerClock = timerClock.bind(this);
		},

		open: function (options, callback) {
			var self = this,
				settings = $.extend(true, {}, self.defaults, options),
				$box;

			$box = $(settings.content);

			// open
			$box.find("img").on('load', function () {
				setTimeout(function () {
					$box.addClass('show');
				}, 300);
				if ($box.offset().top - window.pageYOffset < 0) {
					self.close();
				}
				$box.on('mouseenter', function () {
					self.pause();
				});
				$box.on('mouseleave', function (e) {
					self.resume();
				});

				$box[0].addEventListener('touchstart', function (e) {
					self.pause();
					e.stopPropagation();
				}, { passive: true });

				Riode.$body[0].addEventListener('touchstart', function () {
					self.resume();
				}, { passive: true });

				$box.on('mousedown', function () {
					$box.css('transform', 'translateX(0) scale(0.96)');
				});
				$box.on('mousedown', 'a', function (e) {
					e.stopPropagation();
				});
				$box.on('mouseup', function () {
					self.close(boxes.indexOf($box));
				});
				$box.on('mouseup', 'a', function (e) {
					e.stopPropagation();
				});

				boxes.push($box);
				timers.push(settings.delay);

				(timers.length > 1) || (
					timerId = setInterval(timerClock, timerInterval)
				);

				callback && callback($box);
			}).on('error', function () {
				$box.remove();
			});
			$box.appendTo($area);
		},

		close: function (indexToClose) {
			var self = this,
				index = ('undefined' === typeof indexToClose) ? 0 : indexToClose,
				$box = boxes.splice(index, 1)[0];

			if ($box) {
				// remove timer
				timers.splice(index, 1)[0];

				// remove box
				$box.css('transform', '').removeClass('show');
				self.pause();

				setTimeout(function () {
					var $next = $box.next();
					if ($next.length) {
						$next.animate({
							'margin-bottom': -1 * $box[0].offsetHeight - 20
						}, 300, 'easeOutQuint', function () {
							$next.css('margin-bottom', '');
							$box.remove();
						});
					} else {
						$box.remove();
					}
					self.resume();
				}, 300);

				// clear timer
				boxes.length || clearTimeout(timerId);
			}
		},

		pause: function () {
			isPaused = true;
		},

		resume: function () {
			isPaused = false;
		}
	}

	Riode.minipopup = Minipopup;

})(jQuery);
/**
 * Riode Plugin - Product Gallery
 * 
 * @requires OwlCarousel
 * @requires $.fn.wc_product_gallery
 * @requires ImagesLoaded (only quickview needs)
 * @instance multiple
 */
(function ($) {

	function ProductGallery($el) {
		return this.init($el);
	}

	// Private 

	var firstScrollTopOnSticky = true;

	var thumbsSliderOptions = {
		margin: 0,
		items: 4,
		dots: false,
		nav: true,
		navText: [],
		rtl: Riode.$body.hasClass('rtl')
	}

	var setupThumbs = function (self) {
		// members for thumbnails
		self.$thumbs = self.$wc_gallery.find('.product-thumbs');
		self.$thumbsDots = self.$thumbs.children();
		self.isVertical = self.$thumbs.parent().parent().hasClass('pg-vertical');

		// if vertical gallery
		if (self.isVertical) {
			self.$thumbsWrap = self.$thumbs.parent();

			// register events
			self.$thumbsWrap.children('.thumb-up').on('click', function (e) {
				if (self.thumbsIsVertical) {
					self.$thumbs.css('top', self.thumbsTop = Math.min(self.thumbsTop + self.dotHeights[0], 0));
					checkThumbs(self);
				}
			});

			self.$thumbsWrap.children('.thumb-down').on('click', function (e) {
				if (self.thumbsIsVertical) {
					self.$thumbs.css('top', self.thumbsTop = Math.max(
						self.$thumbsWrap[0].offsetHeight + self.thumbSpace - self.dotsHeight,
						self.thumbsTop - self.dotHeights[0]
					));
					checkThumbs(self);
				}
			});
		}

		self.$thumbsDots.on('click', function () {
			if ($(this).children('.riode-video-thumbnail-viewer, .riode-360-gallery-viewer').length) {
				return;
			}

			var $this = $(this),
				index = ($this.parent().filter(self.$thumbs).length ? $this : $this.parent()).index();
			self.$slider.data('owl.carousel').to(index);
		});

		// refresh thumbs
		refreshThumbs(self);

		self.isVertical && window.addEventListener('resize', function () {
			refreshThumbs(self);
		}, { passive: true });
	}

	/**
	 * @function checkThumbs        Check thumbs nav state and set active thumb
	 * @param {object} self         ProductGallery instance
	 * @param {number} showIndex    Index to set active
	 */
	var checkThumbs = function (self, showIndex) {
		var wrapHeight = self.$thumbsWrap[0].offsetHeight + self.thumbSpace;
		if (typeof showIndex == 'undefined') {
			showIndex = -1;
		}

		// show active
		if (showIndex >= 0) {
			var offset = self.thumbsTop;
			for (var i = 0; i < showIndex; ++i) {
				offset += self.dotHeights[i];
			}
			if (offset < 0) { // if above
				self.$thumbs.css('top', self.thumbsTop -= offset);
			} else {
				offset += self.dotHeights[showIndex] - wrapHeight;
				if (offset > 0) { // if below
					self.$thumbs.css('top', self.thumbsTop -= offset);
				}
			}
		}
		var thumbsBottom = self.thumbsTop + self.dotsHeight;

		// check nav
		self.$thumbsWrap.children('.thumb-up').toggleClass('disabled', self.thumbsTop >= -4);
		self.$thumbsWrap.children('.thumb-down').toggleClass('disabled', thumbsBottom <= wrapHeight + 4);

		// if thumbs is above than top and also bottom
		if (self.thumbsTop < 0 && thumbsBottom < wrapHeight) {
			self.$thumbs.css('top', self.thumbsTop = Math.min(self.thumbsTop + wrapHeight - thumbsBottom, 0));
		}
	}

	var refreshThumbs = function (self) {
		if (typeof self.$thumbs == 'undefined') {
			return;
		}

		var oldIsVertical = 'undefined' == typeof self.thumbsIsVertical ? false : self.thumbsIsVertical; // is vertical?
		self.thumbsIsVertical = self.isVertical && window.innerWidth >= 992;

		// enable vertical product gallery thumbs.
		if (self.thumbsIsVertical) {

			// active slide number
			var current = -1;

			// disable thumbs carousel
			if (self.$thumbs.hasClass('owl-carousel')) {
				var carousel = self.$thumbs.data('owl.carousel'),
					cnt = carousel.items().length;
				current = (carousel.current() - carousel.clones().length / 2 + cnt) % cnt;
				self.$thumbs.trigger('destroy.owl.carousel').removeClass('owl-carousel');
			}

			// calculate top, space, dot height for vertical thumb
			oldIsVertical || (self.thumbsTop = parseInt(self.$thumbs.css('top')));
			self.thumbSpace = parseInt(self.$thumbsDots.eq(0).css('margin-bottom'));

			self.dotsHeight = 0;
			self.dotHeights = self.$thumbsDots.map(function () {
				self.dotsHeight += this.offsetHeight + self.thumbSpace;
				// self.dotsHeight += this.getBoundingClientRect().height + self.thumbSpace;
				return this.offsetHeight + self.thumbSpace;
			}).get();

			// enable thumbs vertical nav
			setTimeout(function () { checkThumbs(self, current); }, 200); // call after .2s because of owl auto height transition

		} else {
			// if not vertical, remove top property
			oldIsVertical && 'undefined' != typeof self.thumbsTop && self.thumbsTop && self.$thumbs.css('top', '');

			// enable thumbs carousel
			if (!self.$thumbs.hasClass('owl-carousel')) {
				self.$thumbs
					.addClass('owl-carousel row cols-4 gutter-no')
					.on('initialized.owl.carousel', function () {
						this.classList.remove('row');
						this.classList.remove('cols-4');
						this.classList.remove('gutter-no');
					}).owlCarousel($.extend(true, {
						startPosition: self.$thumbs.children('.active').index()
					}, thumbsSliderOptions));
			}
		}
	}

	var onClickImageFull = function (e) {
		var $btn = $(e.currentTarget);

		e.preventDefault();

		// Default or horizontal type
		if ($btn.closest('.product-single-carousel').length) {
			$btn.closest('.product-single-carousel').find('.active a').click();
		} else {
			$btn.prev('a').click();
		}
	}

	// Public Properties

	ProductGallery.prototype.init = function ($wc_gallery) {
		var self = this;

		// if woocommmerce product gallery is undefined, create it
		typeof $wc_gallery.data('product_gallery') == 'undefined' && $wc_gallery.wc_product_gallery();
		this.$wc_gallery = $wc_gallery;
		this.wc_gallery = $wc_gallery.data('product_gallery');

		// Remove woocommerce zoom triggers
		$('.woocommerce-product-gallery__trigger').remove();

		// Add full image trigger, and init zoom
		this.$slider = $wc_gallery.find('.product-single-carousel');
		if (this.$slider.length) {
			this.initThumbs(); // init thumbs together for single slider

		} else {
			this.$slider = this.$wc_gallery.find('.product-gallery-carousel');
			if (this.$slider.length) {
				this.$slider.on('initialized.owl.carousel', this.initZoom.bind(this));  // gallery slider

			} else { // other types
				this.initZoom();
			}
		}

		// Prevent going to image link
		$wc_gallery
			.off('click', '.woocommerce-product-gallery__image a')
			.on('click', function (e) { e.preventDefault() });
		$wc_gallery.closest('.product:not(.product-quickview):not(.product-widget)').length &&
			$wc_gallery.on('click', '.woocommerce-product-gallery__image a', this.openImageFull.bind(this));

		// init slider after load, such as quickview
		if ('complete' === Riode.status) {
			self.$slider && self.$slider.length && Riode.slider(self.$slider);
		}

		Riode.$window.on('riode_complete', function () {
			setTimeout(self.initAfterLazyload.bind(self), 200);
		})
	}

	ProductGallery.prototype.initAfterLazyload = function () {
		this.currentPostImageSrc = this.$wc_gallery.find('.wp-post-image').attr('src');
	}

	ProductGallery.prototype.initThumbs = function () {
		var self = this;

		// init thumbs
		this.$slider
			.on('initialized.owl.carousel', function (e) {
				// init thumbnails
				setupThumbs(self);

				self.initZoom();
			}).on('translate.owl.carousel', function (e) {
				if ($(this).closest('.product-single').hasClass('product-quickview')) {
					return;
				}
				var index = (e.item.index - $(e.currentTarget).find('.cloned').length / 2 + e.item.count) % e.item.count;
				self.$thumbsDots.removeClass('active').eq(index).addClass('active');
				self.thumbsIsVertical || self.$thumbs.data('owl.carousel').to(index); // if thumb carousel
				self.thumbsIsVertical && checkThumbs(self, index);

			}).on('translated.owl.carousel', function (e) {
				self.thumbsIsVertical && setTimeout(function () {
					checkThumbs(self, (e.item.index - $(e.currentTarget).find('.cloned').length / 2 + e.item.count) % e.item.count);
				}, 200); // call after .2s because of owl auto height transition
			});
	}

	ProductGallery.prototype.openImageFull = function (e) {
		if (e.target.classList.contains('zoomImg')) {
			return;
		}
		if (wc_single_product_params.photoswipe_options) {
			e.preventDefault();

			var carousel = this.$wc_gallery.find('.product-single-carousel, .product-gallery-carousel').data('owl.carousel');

			// Carousel Type
			if (carousel) {
				var count = carousel.items().length - carousel.clones().length;
				wc_single_product_params.photoswipe_options.index = ($(e.currentTarget).closest('.owl-item').index() - carousel.clones().length / 2 + count) % count;
			}

			this.wc_gallery.openPhotoswipe(e);
		}
	}

	ProductGallery.prototype.initZoomImage = function (zoomTarget) {
		if (riode_vars.single_product.zoom_enabled) {
			var width = zoomTarget.children('img').attr('data-large_image_width'),
				// zoom option
				zoom_options = $.extend({
					touch: false
				}, riode_vars.single_product.zoom_options);

			if ('ontouchstart' in document.documentElement) {
				zoom_options.on = 'click';
			}

			zoomTarget.trigger('zoom.destroy').children('.zoomImg').remove();

			// zoom
			if ('undefined' != typeof width && zoomTarget.width() < width) {
				zoomTarget.zoom(zoom_options);

				// show zoom on hover
				setTimeout(function () {
					zoomTarget.find(':hover').length && zoomTarget.trigger('mouseover');
				}, 100);
			}
		}
	}

	ProductGallery.prototype.changePostImage = function (variation) {

		var $image = this.$wc_gallery.find('.wp-post-image');

		// Has post image been changed?
		if ($image.hasClass('d-lazyload') || this.currentPostImageSrc == $image.attr('src')) {
			return;
		} else {
			this.currentPostImageSrc = $image.attr('src');
		}

		// Recalculate vertical thumbs
		var self = this;
		this.$wc_gallery.imagesLoaded(function () {
			refreshThumbs(self);
		})

		// Add found class to form, change nav thumbnail image on found variation
		var $postThumbImage = this.$wc_gallery.find('.product-thumbs img').eq(0),
			$gallery = this.$wc_gallery.find('.product-gallery');

		if ($postThumbImage.length) {
			if (typeof variation != 'undefined') {
				if ('reset' == variation) {
					$postThumbImage.wc_reset_variation_attr('src')
					$postThumbImage.wc_reset_variation_attr('alt');
				} else {
					$postThumbImage.wc_set_variation_attr('src', variation.image.gallery_thumbnail_src)
					$postThumbImage.wc_set_variation_attr('alt', variation.image.alt);
				}
			} else {
				$postThumbImage.wc_set_variation_attr('src', this.currentPostImageSrc)
				$postThumbImage.wc_set_variation_attr('alt', $image.attr('alt'));
			}
		}

		// Refresh zoom
		this.initZoomImage(this.$wc_gallery.find('.wp-post-image').parent());

		// Refresh if masonry layout or carousel
		$gallery.data('isotope') && $gallery.imagesLoaded(function () {
			$gallery.data('isotope').layout();
		});

		var carousel = $gallery.children('.product-single-carousel,.product-gallery-carousel').data('owl.carousel');
		carousel && (carousel.refresh(), carousel.to(0));

		if (!firstScrollTopOnSticky) {
			// If sticky, go to top;
			var $product = this.$wc_gallery.closest('.product');
			if ($product.hasClass('sticky-info') || $product.hasClass('sticky-both')) {
				Riode.scrollTo(this.$wc_gallery, 400);
			}
		}
		firstScrollTopOnSticky = false;
	}

	ProductGallery.prototype.initZoom = function () {
		if (riode_vars.single_product.zoom_enabled) {
			var self = this;

			// show image full toggler
			if (this.$slider.length && this.$slider.hasClass('product-single-carousel')) {

				// if not quickview, widget
				this.$wc_gallery.closest('.product-quickview').length ||
					this.$wc_gallery.closest('.product-widget').length ||
					// if default or horizontal type, show only one
					this.$slider.append('<button class="product-image-full d-icon-zoom"></button>');

			} else {
				// if not quickview, widget
				this.$wc_gallery.closest('.product-quickview').length ||
					this.$wc_gallery.closest('.product-widget').length ||
					this.$wc_gallery.find('.woocommerce-product-gallery__image > a').each(function () {
						$(this).after('<button class="product-image-full d-icon-zoom"></button>')
					});
			}

			// zoom images
			this.$wc_gallery.find('.woocommerce-product-gallery__image > a').each(function () {
				self.initZoomImage($(this));
			});
		}
	}

	/**
	 * @function productGallery
	 * @param {string|jQuery} selector
	 */
	Riode.productGallery = function (selector) {
		$.fn.wc_product_gallery &&
			Riode.$(selector).each(function () {
				var $this = $(this);
				$this.data('riode_product_gallery', new ProductGallery($this));
			});
	}

	Riode.initProductGallery = function () {
		// Register events
		Riode.$window.on('riode_complete', function () {
			// image lightbox toggle
			Riode.$body.on('click', '.product-image-full', onClickImageFull);
		});
	}
})(jQuery);
/**
* Riode Plugin - Product Single
 *
* @requires OwlCarousel
* @requires ImagesLoaded (only quickview needs)
* @instance multiple
 */
(function ($) {

	function ProductSingle($el) {
		return this.init($el);
	}

	// Private Properties

	var onSingleAddToCartAjax = function (e) {
		var $btn = $(e.currentTarget),
			$product = $btn.closest('.product-single');

		if (0 == $product.length ||
			$product.hasClass('product-type-external') ||
			$product.hasClass('product-type-grouped')) {
			return;
		}

		e.preventDefault();

		var $form = $btn.closest('form');
		if ($form.hasClass('d-loading')) {
			return;
		}

		var variation_id = $form.find('input[name="variation_id"]').val(),
			product_id = variation_id ? $form.find('input[name="product_id"]').val() : $btn.val(),
			quantity = $form.find('input[name="quantity"]').val(),
			data = {
				action: 'riode_add_to_cart',
				product_id: variation_id ? variation_id : product_id,
				quantity: quantity
			};
		if (variation_id) {
			var $variations = $form.find('.variations select');
			if ($variations.length) {
				$variations.each(function () {
					var name = $(this).data('attribute_name'),
						val = $(this).val();
					if (name && val) {
						data[name] = val;
					}
				});
			}
		}

		Riode.doLoading($btn, 'small');
		$btn.removeClass('added');

		// Trigger event.
		Riode.$body.trigger('adding_to_cart', [$btn, data]);

		$.ajax({
			type: 'POST',
			url: riode_vars.ajax_url,
			data: data,
			dataType: 'json',
			success: function (response) {
				if (!response) {
					return;
				}
				if (response.error && response.product_url) {
					location = response.product_url;
					return;
				}

				// Redirect to cart option
				if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
					location = wc_add_to_cart_params.cart_url;
					return;
				}

				// trigger event
				$(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $btn]);

				// show minipopup box
				var link = $form.attr('action'),
					image = $product.find('.wp-post-image').attr('src'),
					title = $product.find('.product_title').text(),
					price = variation_id ? $form.find('.woocommerce-variation-price .price').html() : $product.find('.price').html(),
					count = $form.find('.qty').val();

				price || (price = $product.find('.price').html());
				Riode.minipopup.open({
					content: '<div class="minipopup-box"><h4 class="minipopup-title">' + riode_vars.texts.added_to_cart + '</h4><div class="product product-list-sm"><figure class="product-media"><a href="' + link + '"><img src="' + image + '"></img></a></figure><div class="product-details"><a class="product-title" href="' + link + '">' + title + '</a><span class="count">' + count + '</span> x <span class="price">' + price + '</span></div></div><div class="minipopup-footer"><a href="' + riode_vars.pages.cart + '" class="btn btn-block btn-outline btn-primary btn-viewcart">' + riode_vars.texts.view_cart + '</a><a href="' + riode_vars.pages.checkout + '" class="btn btn-block btn-primary btn-viewcheckout">' + riode_vars.texts.view_checkout + '</a></div></div>'
				});
			},
			complete: function () {
				Riode.endLoading($btn);
			}
		});
	}

	var onClickListVariation = function (e) {
		var $btn = $(e.currentTarget);
		if ($btn.hasClass('disabled')) {
			return;
		}
		if ($btn.hasClass('active')) {
			$btn.removeClass('active')
				.parent().next().val('').change();
		} else {
			$btn.addClass('active').siblings().removeClass('active');
			$btn.parent().next().val($btn.attr('name')).change();
		}
	}

	var onClickResetVariation = function (e) {
		$(e.currentTarget).closest('.variations_form').find('.active').removeClass('active');
	}

	var onToggleResetVariation = function () {
		var $reset = $(Riode.byClass('reset_variations', this));
		$reset.css('visibility') == 'hidden' ? $reset.hide() : $reset.show();
	}

	var onFoundVariation = function (e, variation) {
		var $product = $(e.currentTarget).closest('.product'),
			gallery = $product.find('.woocommerce-product-gallery').data('riode_product_gallery');
		gallery && gallery.changePostImage(variation);

		// Display sale countdown of matched variation.
		var $counter = $product.find('.countdown-variations');
		if ($counter.length) {
			if (variation && variation.is_purchasable && variation.riode_date_on_sale_to) {
				var $countdown = $counter.find('.product-countdown');
				if ($countdown.data('until') != variation.riode_date_on_sale_to) {
					$countdown.data('until', variation.riode_date_on_sale_to).attr('data-until', variation.riode_date_on_sale_to);
					Riode.countdown($countdown, { until: new Date(variation.riode_date_on_sale_to) });
				}
				$counter.slideDown();
			} else {
				$counter.slideUp();
			}
		}
	}

	var onResetVariation = function (e) {
		var $product = $(e.currentTarget).closest('.product');
		var gallery = $(e.currentTarget).closest('.product').find('.woocommerce-product-gallery').data('riode_product_gallery');

		gallery && gallery.changePostImage('reset');
		$product.find('.countdown-variations').slideUp();
	}

	var onUpdateVariation = function () {
		var $form = $(this);
		$form.find('.product-variations>button').addClass('disabled');

		// Loop through selects and disable/enable options based on selections.
		$form.find('select').each(function () {
			var $this = $(this);
			var $buttons = $this.closest('.variations > *').find('.product-variations');
			$this.children('.enabled').each(function () {
				$buttons.children('[name="' + this.getAttribute('value') + '"]').removeClass('disabled');
			});
			$this.children(':selected').each(function () {
				$buttons.children('[name="' + this.getAttribute('value') + '"]').addClass('active');
			});
		});
	}

	// Public Properties
	ProductSingle.prototype.init = function ($el) {
		this.$product = $el;

		// gallery
		$el.find('.woocommerce-product-gallery').each(function () {
			Riode.productGallery($(this));
		})

		// variation        
		$('.reset_variations').hide().removeClass('d-none');

		// after load, such as quickview
		if ('complete' === Riode.status) {
			// variation form
			$.fn.wc_variation_form &&
				typeof wc_add_to_cart_variation_params !== 'undefined' &&
				this.$product.find('.variations_form').wc_variation_form();

			// quantity input
			Riode.quantityInput(this.$product.find('.qty'));

			// countdown
			Riode.countdown(this.$product.find('.product-countdown'));
		}

		// sticky cart
		this.stickyCartForm(this.$product.find('.product-sticky-content'));
	}

	/**
	 * @function stickyCartForm
	 * @param {string|jQuery} selector 
	 */
	ProductSingle.prototype.stickyCartForm = function (selector) {
		var $stickyForm = Riode.$(selector),
			option = {},
			$product = $stickyForm.closest('.product'),
			titleEl = $product.find('.product_title').eq(0)[0],
			$image = $product.find('.woocommerce-product-gallery .wp-post-image').eq(0),
			imgsrc = riode_vars.lazyload ? $image.attr('data-lazy') : $image.attr('src');

		// prepare sticky form
		$stickyForm.find('.quantity').before(
			'<div class="sticky-product-details">' +
			($image.length ? '<figure><img src="' + imgsrc + '" width="' + $image.attr('width') + '" height="' + $image.attr('height') + '" alt="' + $image.attr('alt') + '"></figure>' : '') +
			'<div>' +
			(titleEl ? titleEl.outerHTML.replace('<h1', '<h3').replace('h1>', 'h3>').replace('product_title', 'product-title') : '') +
			'<div class="product-info"></div></div>'
		);
		$stickyForm.find('.product-info')
			.append($product.find('p.price').clone())
			.append($product.find('.summary .star-rating').eq(0).clone());

		// if sticky-info type, calculate top position correctly
		if ($product.find('.summary').parent().hasClass('sticky-sidebar')) {
			var $gallery = $product.find('.product-gallery');
			option.top = $gallery.offset().top + $gallery[0].offsetHeight;
		}

		Riode.stickyContent($stickyForm, option);
	}

	/**
	 * @function productSingle
	 * @param {string|jQuery} selector 
	 */
	Riode.productSingle = function (selector) {
		Riode.$(selector).each(function () {
			var $this = $(this);
			$this.data('riode_product_single', new ProductSingle($this));
		});
	}

	/**
	 * @function initReview
	 * @since 1.4.0
	 */
	Riode.initReview = function (selector) {
		// Offcanvas review form
		Riode.$body.on('click', '.submit-review-toggle', function (e) {
			e.preventDefault();
			Riode.$body.find('.review-form-section').toggleClass('opened');
		}).on('click', '.review-form-section .btn-close', function (e) {
			e.preventDefault();
			Riode.$body.find('.review-form-section').removeClass('opened');
		}).on('click', '.review-form-section .offcanvas-overlay', function (e) {
			Riode.$body.find('.review-form-section').removeClass('opened');
		});
	}

	/**
	 * @function initProductSingle
	 */
	Riode.initProductSingle = function (selector) {
		if (typeof selector == 'undefined') {
			selector = '';
		}

		// Initialize woocommerce single product again for compatiblity with skeleton
		if (riode_vars.skeleton_screen) {

			// init - wc product gallery
			$.fn.wc_product_gallery &&
				$(selector + ' .woocommerce-product-gallery').each(function () {
					var $this = $(this);
					typeof $this.data('product_gallery') == 'undefined' && $this.wc_product_gallery();
				})

			// init - wc tab
			$('.wc-tabs-wrapper, .woocommerce-tabs').trigger('init');

			// init - wc rating
			$(selector + ' #rating').trigger('init');

			// init - variation form
			$.fn.wc_variation_form &&
				typeof wc_add_to_cart_variation_params !== 'undefined' &&
				$(selector + ' .variations_form').each(function () {
					// Single Product Widget
					if ($(this).parent('.products-flipbook').length || $(this).closest('.product-single-wrap').length) {
						return;
					}
					if (Riode.status != 'load' || $(this).closest('.summary').length) {
						$(this).wc_variation_form();
					}
				});
		} else {
			$('.woocommerce-tabs.accordion').trigger('init');
		}

		// Single product page
		Riode.productSingle(selector + '.product-single');
		Riode.initProductGallery();
		Riode.initReview();

		// Register events
		Riode.$window.on('riode_complete', function () {
			// Ajax add to cart event handler for single product (e.g. quickview)
			Riode.$body.on('click', '.product-quickview .single_add_to_cart_button:not(.disabled),.product-widget .single_add_to_cart_button:not(.disabled)', onSingleAddToCartAjax);

			// Variation
			Riode.$body.on('click', '.variations .product-variations button', onClickListVariation)
				.on('click', '.reset_variations', onClickResetVariation)
				.on('check_variations', '.variations_form', onToggleResetVariation)
				.on('found_variation', '.variations_form', onFoundVariation)
				.on('reset_image', '.variations_form', onResetVariation)
				.on('update_variation_values', '.variations_form', onUpdateVariation)

				// Guide Link
				.on('click', '.guide-link', function (e) {
					if ($(this).closest('.product-quickview').length) {
						return;
					}
					e.preventDefault();
					var target = this.getAttribute('href');

					if ($(target + '>a').length) {
						$(target + '>a').click();
					}

					if (target.indexOf('#') == 0) {
						e.preventDefault();
						Riode.scrollToFixedContent($(target).offset().top, 400);
					}
				});

			// Sticky Variable Add to Cart
			if ($('.product-sticky-content').closest('.variations_form').length) {
				var $form = $('.product-sticky-content').closest('.variations_form');

				$form.off('click', '.single_add_to_cart_button');
				$form.on('click', '.single_add_to_cart_button', function () {
					if ($(this).is('.disabled')) {
						event.preventDefault();

						if ($(this).closest('.product-sticky-content').hasClass('fixed')) {
							Riode.scrollToFixedContent($(this).closest('.variations_form').offset().top, 400);

							return;
						}

						if ($(this).is('.wc-variation-is-unavailable')) {
							window.alert(wc_add_to_cart_variation_params.i18n_unavailable_text);
						} else if ($(this).is('.wc-variation-selection-needed')) {
							window.alert(wc_add_to_cart_variation_params.i18n_make_a_selection_text);
						}
					}
				})
			}

			if (-1 != location.hash.toLowerCase().indexOf('tab-title-riode_pa_block_')) {
				$(location.hash + '>a').click();
			}
		})
	}

	// Init data tab accordion
	Riode.$body
		.on('init', '.woocommerce-tabs.accordion', function () {

			var $tabs = $(this),
				hash = location.hash,
				url = location.href;

			setTimeout(function () {
				if (hash.toLowerCase().indexOf('comment-') >= 0 || hash === '#reviews' || hash === '#tab-reviews') {
					$tabs.find('.reviews_tab a').click();
				} else if (url.indexOf('comment-page-') > 0 || url.indexOf('cpage=') > 0) {
					$tabs.find('.reviews_tab a').click();
				} else if (hash === '#tab-additional_information') {
					$tabs.find('.additional_information_tab a').click();
				} else {
					$tabs.find('.card:first-child > .card-header a').click();
				}
			}, 100);
		})
})(jQuery);
/**
 * Riode Plugin - Shop
 * 
 * @requires Minipopup
 * @requires noUiSlider
 * @instance single
 */
(function ($) {

	// Private Properties

	var initSelectMenu = function () {
		// show selected attributes after loading
		$('.toolbox-horizontal .shop-sidebar .widget .chosen').each(function (e) {
			if ($(this).find('a').attr('href') == window.location.href) {
				return;
			}

			$('<a href="#" class="select-item">' + $(this).find('a').text() + '<i class="d-icon-times"></i></a>')
				.insertBefore('.toolbox-horizontal + .select-items .filter-clean')
				.attr('data-type', $(this).closest('.widget').attr('id').split('-').slice(0, -1).join('-'))
				.data('link_id', $(this).closest('.widget').attr('id'))
				.data('link_idx', $(this).index());

			$('.toolbox-horizontal + .select-items').fadeIn();
		})

		// show or hide select menu
		Riode.$body
			.on('click', '.toolbox-horizontal .shop-sidebar .widget-title, .riode-filters .select-ul-toggle', function (e) {
				// close all select menu
				$(this).parent().siblings().removeClass('opened');
				$(this).parent().toggleClass('opened');
				e.stopPropagation();
			})

			// if click is happend outside of select menu, hide it
			.on('click', function (e) {
				$('.toolbox-horizontal .shop-sidebar .widget, .riode-filters .select-ul').removeClass('opened');
			})

			// if select item is clicked
			.on('click', '.toolbox-horizontal .shop-sidebar .widget a', function (e) {
				var $this = $(this);

				if ($this.closest('.widget').hasClass('yith-woo-ajax-reset-navigation')) {
					return;
				}

				if ($(this).parent().hasClass('chosen')) {
					$('.toolbox-horizontal + .select-items .select-item').filter(function (i, el) {
						return $(el).data('link_id') == $this.closest('.widget').attr('id') && $(el).data('link_idx') == $this.closest('li').index();
					}).fadeOut(function () {
						$(this).remove();

						// if only clean all button remains
						if ($('.select-items').children().length < 2) {
							$('.select-items').hide();
						}
					})
				} else {
					var type = $this.closest('.widget').attr('id').split('-').slice(0, -1).join('-');

					if ('riode-price-filter' == type) {
						$('.toolbox-horizontal + .select-items').find('[data-type="riode-price-filter"]').remove();
						$this.closest('li').addClass('chosen').siblings().removeClass('chosen');
					}

					$('<a href="#" class="select-item">' + $(this).text() + '<i class="d-icon-times"></i></a>')
						.insertBefore('.toolbox-horizontal + .select-items .filter-clean')
						.hide().fadeIn()
						.attr('data-type', type)
						.data('link_id', $this.closest('.widget').attr('id'))
						.data('link_idx', $this.closest('li').index()); // link to anchor

					// if only clean all button remains
					if ($('.select-items').children().length >= 2) {
						$('.select-items').show();
					}
				}
			})
			.on('click', '.toolbox-horizontal + .select-items .select-item', function (e) {
				e.preventDefault();
				$('.toolbox-horizontal .shop-sidebar #' + $(this).data('link_id')).find('li').eq($(this).data('link_idx')).children('a').trigger('click');
			})
			.on('click', '.toolbox-horizontal + .select-items .filter-clean', function (e) {
				e.preventDefault();

				$(this).parent('.select-items').fadeOut(function () {
					$(this).children('.select-item').remove();
				})
			})

			// if riode filter's filter item is clicked
			.on('click', '.riode-filters .select-ul a', function (e) {
				e.preventDefault();
				e.stopPropagation();

				if ('or' == $(this).closest('.riode-filter').attr('data-filter-query')) {
					$(this).closest('li').toggleClass('chosen');
				} else {
					$(this).closest('li').toggleClass('chosen').siblings().removeClass('chosen');
				}

				var $btn_filter = $(this).closest('.riode-filters').find('.btn-filter'),
					link = $btn_filter.attr('href'),
					$filters = $(this).closest('.riode-filters');
				link = link.split('/');
				link[link.length - 1] = '';

				$filters.length && $filters.find('.riode-filter').each(function (index) {
					var chosens = $(this).find('.chosen');

					if (chosens.length) {
						var values = [],
							attr = $(this).attr('data-filter-attr');

						chosens.each(function () {
							values.push($(this).attr('data-value'));
						})

						link[link.length - 1] += 'filter_' + attr + '=' + values.join(',') + '&query_type_' + attr + '=' + $(this).attr('data-filter-query') + (index != $filters.length ? '&' : '');
					}
				});

				link[link.length - 1] = '?' + link[link.length - 1];
				$btn_filter.attr('href', link.join('/'));
			});
	}

	/**
	 * Ajax add to cart for variation products
	 * 
	 * @since 1.4.0
	 */
	var initProductsAttributeAction = function () {
		Riode.$body
			.on('click', '.product-variation-wrapper button', function (e) {
				var $this = $(this),
					$variation = $this.parent(),
					$wrapper = $this.closest('.product-variation-wrapper'),
					attr = 'attribute_' + String($variation.data('attr')),
					variationData = $wrapper.data('product_variations'),
					attributes = $wrapper.data('product_attrs'),
					attrValue = $this.attr('name'),
					$price = $wrapper.closest('.product-loop').find('.price'),
					priceHtml = $wrapper.data('price');

				if ($this.hasClass('disabled')) {
					return;
				}

				$this.toggleClass('active').siblings().removeClass('active');

				var suitableData = variationData,
					matchedData = variationData;

				// Get Attributes
				if (undefined == attributes) {
					attributes = [];
					$wrapper.find('.product-variations').each(function () {
						attributes.push('attribute_' + String($(this).data('attr')));
					});
					$wrapper.data('product_attrs', attributes);
				}

				// Save HTML
				if (undefined == priceHtml) {
					priceHtml = $price.html();
					$wrapper.data('price', priceHtml);
				}


				// Update Matched Array
				if (attrValue == $wrapper.data(attr)) {
					$wrapper.removeData(attr);
					let tempArray = [];
					variationData.forEach(function (item, index) {
						var flag = true;
						attributes.forEach(function (attr_item) {
							if (undefined != $wrapper.data(attr_item) && $wrapper.data(attr_item) != item['attributes'][attr_item] && "" != item['attributes'][attr_item]) {
								flag = false;
							}
						});
						if (flag) {
							tempArray.push(item);
						}
					});

					matchedData = tempArray;
				} else {
					$wrapper.data(attr, attrValue);
					let tempArray = [];
					variationData.forEach(function (item, index) {
						var flag = true;
						attributes.forEach(function (attr_item) {
							if (undefined != $wrapper.data(attr_item) && $wrapper.data(attr_item) != item['attributes'][attr_item] && "" != item['attributes'][attr_item]) {
								flag = false;
							}
						});
						if (flag) {
							tempArray.push(item);
						}
					});

					matchedData = tempArray;
				}

				var showPrice = true;
				attributes.forEach(function (attr_item) {
					if (attr != attr_item || (attr_item == attr && undefined == $wrapper.data(attr))) {
						let $variation = $wrapper.find('.' + attr_item.slice(10) + ' > *:not(.guide-link)');

						$variation.each(function () {
							var $this = $(this);
							if (!$this.hasClass('select-box')) {
								$this.addClass('disabled');
							} else {
								$this.find('option').css('display', 'none');
							}
						})

						variationData.forEach(function (item) {
							let flag = true;
							attributes.forEach(function (atr_item) {
								if (undefined != $wrapper.data(atr_item) && attr_item != atr_item && item['attributes'][atr_item] != $wrapper.data(atr_item) && "" != item['attributes'][atr_item]) {
									flag = false;
								}
							});
							if (true == flag) {
								if ("" == item['attributes'][attr_item]) {
									$variation.removeClass('disabled');
									$variation.each(function () {
										var $this = $(this);
										if (!$this.hasClass('select-box')) {
											$this.removeClass('disabled');
										} else {
											$this.find('option').css('display', '');
										}
									})
								} else {
									$variation.each(function () {
										var $this = $(this);
										if (!$this.hasClass('select-box')) {
											if ($this.attr('name') == item['attributes'][attr_item]) {
												$this.removeClass('disabled');
											}
										} else {
											$this.find('option').each(function () {
												var $this = $(this);
												if ($this.attr('value') == item['attributes'][attr_item] || $this.attr('value') == '') {
													$this.css('display', '');
												}
											});
										}
									});
								}
							}
						});
					}
					if (undefined == $wrapper.data(attr_item)) {
						showPrice = false;
					}
				});

				if (true == showPrice && 1 == matchedData.length) {
					$price.closest('.product-loop').data('variation', matchedData[0]['variation_id']);
					$price.html($(matchedData[0]['price_html']).html());
					var $product = $price.closest('.product-loop'),
						$cart = $product.find('.add_to_cart_button')
						.removeClass('product_type_variable')
							.addClass('product_type_simple'),
						$qty = $product.find('.quantity');

					$cart.html($cart.data('simple-label'));

					if ($qty.length > 0) {
						$qty.css('display', 'inline-flex');
					}
				} else {
					$price.html(priceHtml);
					var $product = $price.closest('.product-loop'),
						$cart = $product.removeData('variation')
						.find('.add_to_cart_button')
						.removeClass('product_type_simple')
							.addClass('product_type_variable'),
						$qty = $product.find('.quantity');

					$cart.html($cart.data('variable-label'));

					if ($qty.length > 0) {
						$qty.css('display', '');
					}
				}
			})
			.on('change', '.product-variation-wrapper select', function (e) {
				var $this = $(this),
					$variation = $this.parent(),
					$wrapper = $this.closest('.product-variation-wrapper'),
					attr = $this.data('attribute_name'),
					variationData = $wrapper.data('product_variations'),
					attributes = $wrapper.data('product_attrs'),
					attrValue = $this.val(),
					$price = $wrapper.closest('.product-loop').find('.price'),
					priceHtml = $wrapper.data('price');


				var suitableData = variationData,
					matchedData = variationData;

				// Get Attributes
				if (undefined == attributes) {
					attributes = [];
					$wrapper.find('.product-variations').each(function () {
						attributes.push('attribute_' + String($(this).data('attr')));
					});
					$wrapper.data('product_attrs', attributes);
				}

				// Save HTML
				if (undefined == priceHtml) {
					priceHtml = $price.html();
					$wrapper.data('price', priceHtml);
				}


				// Update Matched Array
				if ("" == attrValue) {
					$wrapper.removeData(attr);
					let tempArray = [];
					variationData.forEach(function (item, index) {
						var flag = true;
						attributes.forEach(function (attr_item) {
							if (undefined != $wrapper.data(attr_item) && $wrapper.data(attr_item) != item['attributes'][attr_item] && "" != item['attributes'][attr_item]) {
								flag = false;
							}
						});
						if (flag) {
							tempArray.push(item);
						}
					});

					matchedData = tempArray;
				} else {
					$wrapper.data(attr, attrValue);
					let tempArray = [];
					variationData.forEach(function (item, index) {
						var flag = true;
						attributes.forEach(function (attr_item) {
							if (undefined != $wrapper.data(attr_item) && $wrapper.data(attr_item) != item['attributes'][attr_item] && "" != item['attributes'][attr_item]) {
								flag = false;
							}
						});
						if (flag) {
							tempArray.push(item);
						}
					});

					matchedData = tempArray;
				}

				var showPrice = true;
				attributes.forEach(function (attr_item) {
					if (attr != attr_item || (attr_item == attr && undefined == $wrapper.data(attr))) {
						let $variation = $wrapper.find('.' + attr_item.slice(10) + ' > *');

						$variation.each(function () {
							var $this = $(this);
							if (!$this.hasClass('select-box')) {
								$this.addClass('disabled');
							} else {
								$this.find('option').css('display', 'none');
							}
						});

						variationData.forEach(function (item) {
							let flag = true;
							attributes.forEach(function (atr_item) {
								if (undefined != $wrapper.data(atr_item) && attr_item != atr_item && item['attributes'][atr_item] != $wrapper.data(atr_item) && "" != item['attributes'][atr_item]) {
									flag = false;
								}
							});
							if (true == flag) {
								if ("" == item['attributes'][attr_item]) {
									$variation.removeClass('disabled');
									$variation.each(function () {
										var $this = $(this);
										if (!$this.hasClass('select-box')) {
											$this.removeClass('disabled');
										} else {
											$this.find('option').css('display', '');
										}
									});
								} else {
									$variation.each(function () {
										var $this = $(this);
										if (!$this.hasClass('select-box')) {
											if ($this.attr('name') == item['attributes'][attr_item]) {
												$this.removeClass('disabled');
											}
										} else {
											$this.find('option').each(function () {
												var $this = $(this);
												if ($this.attr('value') == item['attributes'][attr_item] || $this.attr('value') == '') {
													$this.css('display', '');
												}
											});
										}
									});
								}
							}
						});
					}
					if (undefined == $wrapper.data(attr_item)) {
						showPrice = false;
					}
				});

				if (true == showPrice && 1 == matchedData.length) {
					$price.closest('.product-loop').data('variation', matchedData[0]['variation_id']);
					$price.html($(matchedData[0]['price_html']).html());
					var $product = $price.closest('.product-loop'),
						$cart = $product.find('.add_to_cart_button')
						.removeClass('product_type_variable')
							.addClass('product_type_simple'),
						$qty = $product.find('.quantity');

					$cart.html($cart.data('simple-label'));

					if ($qty.length > 0) {
						$qty.css('display', 'inline-flex');
					}
				} else {
					$price.html(priceHtml);
					var $product = $price.closest('.product-loop'),
						$cart = $product.removeData('variation')
						.find('.add_to_cart_button')
						.removeClass('product_type_simple')
							.addClass('product_type_variable'),
						$qty = $product.find('.quantity');

					$cart.html($cart.data('variable-label'));

					if ($qty.length > 0) {
						$qty.css('display', '');
					}
				}
			})

			.on('click', '.product-loop.product-type-variable .add_to_cart_button', function (e) {
				var $this = $(this),
					$variations = $this.closest('.product').find('.product-variation-wrapper'),
					attributes = $variations.data('product_attrs'),
					$product = $this.closest('.product-loop');

				if (undefined != $product.data('variation')) {
					let data = {
						action: "riode_add_to_cart",
						product_id: $product.data('variation'),
						quantity: 1
					};
					attributes.forEach(function (item) {
						data[item] = $variations.data(item);
					});
					$.ajax(
						{
							type: 'POST',
							dataType: 'json',
							url: riode_vars.ajax_url,
							data: data,
							success: function (response) {
								$(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $this]);
							}
						}
					);
					e.preventDefault();
				}
			});
	}

	var initProductsQuickview = function () {
		var quickviewType = riode_vars.quickview_type || 'loading',
			popuploadingType = !riode_vars.skeleton_screen && riode_vars.product_quickview_popup_loading == 'skeleton' ? 'loading' : riode_vars.product_quickview_popup_loading,
			offcanvasloadingType = !riode_vars.skeleton_screen && riode_vars.product_quickview_offcanvas_loading == 'skeleton' ? 'loading' : riode_vars.product_quickview_offcanvas_loading;

		Riode.$body.on('click', '.btn-quickview', function (e) {
			e.preventDefault();

			var $this = $(this),
				ajax_data = {
					action: 'riode_quickview',
					product_id: $this.data('product')
				};


			if (riode_vars.skeleton_screen && ((quickviewType == 'popup' && popuploadingType == 'skeleton') || (quickviewType == 'offcanvas' && offcanvasloadingType == 'skeleton'))) {
				Riode.popup({
					type: 'ajax',
					mainClass: 'mfp-product mfp-fade' + (quickviewType == 'offcanvas' ? ' mfp-offcanvas' : ''),
					items: {
						src: riode_vars.ajax_url
					},
					ajax: {
						settings: {
							method: 'POST',
							data: ajax_data
						},
						cursor: 'mfp-ajax-cur', // CSS class that will be added to body during the loading (adds "progress" cursor)
						tError: '<div class="alert alert-warning alert-dark alert-round alert-inline">' + riode_vars.texts.popup_error + '<button type="button" class="btn btn-link btn-close"><i class="close-icon"></i></button></div>'
					},
					preloader: false,
					callbacks: {
						afterChange: function () {
							var skeletonTemplate;
							if (riode_vars.skeleton_screen) {
								if (quickviewType == 'offcanvas') {
									skeletonTemplate = '<div class="product skeleton-body';
									skeletonTemplate += '"><div class="skel-pro-gallery"></div><div class="skel-pro-summary"></div></div>';
								} else {
									skeletonTemplate = '<div class="product skeleton-body row"><div class="col-md-6';
									skeletonTemplate += '"><div class="skel-pro-gallery"></div></div><div class="col-md-6"><div class="skel-pro-summary"></div></div></div>';
								}
							} else {
								skeletonTemplate = '<div class="product product-single"><div class="d-loading"><i></i></div></div>';
							}
							this.container.html('<div class="mfp-content"></div><div class="mfp-preloader">' + skeletonTemplate + '</div>');
							this.contentContainer = this.container.children('.mfp-content');
							this.preloader = false;
						},
						beforeClose: function () {
							// this.container.empty();
						},
						ajaxContentAdded: function () {
							var self = this;
							this.wrap.imagesLoaded(function () {
								Riode.productSingle('.mfp-product .product-single');
							});
							setTimeout(function () {
								self.contentContainer.next('.mfp-preloader').remove();
								Riode.shop.ratingTooltip('.mfp-product');
							}, 300);
						}
					}
				});
			} else if (quickviewType == 'popup' && popuploadingType == 'zoom' && !$this.closest('.wishlist-items-wrapper').length) {

				$.post(riode_vars.ajax_url, ajax_data).done(function (data) {
					$(data).imagesLoaded(function () {
						if ($.magnificPopup.instance.isOpen && $.magnificPopup.instance.content) {
							$('.mfp-animated-image').remove();
							var $mfp = $('.mfp-quickview-zoom').addClass('mfp-product');
							$.magnificPopup.instance.content.find('.product-single')[0].outerHTML = data;
							$.magnificPopup.instance.items[0].img = $.magnificPopup.instance.currItem.img = $mfp.find('.product-gallery .wp-post-image');
							Riode.productSingle('.mfp-product .product-single');
							Riode.shop.ratingTooltip('.mfp-product');
						}
					})
				});

				$this.data('magnificPoup') ||
					$this
						.attr('data-mfp-src', $this.closest('.product').find('img').eq(0).attr('src'))
						.magnificPopup({
							type: 'image',
							mainClass: 'mfp-with-zoom mfp-quickview-zoom mfp-product',
							preloader: false,
							zoom: {
								enabled: true,
								opener: function () {
									return $this.closest('.product').find('.product-media img:first-child');
								}
							},
							callbacks: {
								beforeOpen: Riode.defaults.popup.callbacks.beforeOpen,
								open: function () {
									this.items[0] && this.items[0].img
										.wrap('<div class="product-single product-quickview product row product-quickview-loading"><div class="col-md-6"></div><div class="col-md-6"><div class="d-loading"><i></i></div></div></div>');
								},
								close: Riode.defaults.popup.callbacks.close
							}
						});
				$this.magnificPopup('open');

			} else {
				if ($this.closest('.wishlist-items-wrapper').length) {
					Riode.doLoading(e.currentTarget, 'small');
				}
				Riode.doLoading($this.closest('.product').find('.product-media'));
				// Get ajax content
				$.post(riode_vars.ajax_url, ajax_data).done(function (data) {
					$(data).imagesLoaded(function () {
						Riode.popup({
							type: 'inline',
							mainClass: 'mfp-product mfp-fade ' + (quickviewType == 'offcanvas' ? 'mfp-offcanvas' : 'mfp-anim'),
							items: {
								src: data
							},
							callbacks: {
								open: function () {
									var self = this;
									function finishLoad() {
										self.wrap.addClass('mfp-anim-finish');
									}

									setTimeout(finishLoad, 316);

									Riode.productSingle('.mfp-product .product-single');
									Riode.shop.ratingTooltip('.mfp-product');
								}
							}
						})
						Riode.endLoading($this.closest('.product').find('.product-media'));
						if ($this.closest('.wishlist-items-wrapper').length) {
							Riode.endLoading(e.currentTarget, 'small');
						}
					})
				});
			}
		});
	}

	var initProductsCartAction = function () {
		Riode.$body
			// Before product is added to cart
			.on('click', '.add_to_cart_button:not(.product_type_variable)', function (e) {
				$('.minicart-icon').addClass('adding');
				Riode.doLoading(e.currentTarget, 'small');
			})

			// Off Canvas cart type
			.on('click', '.cart-offcanvas .cart-toggle', function (e) {
				$(this).closest('.cart-dropdown').toggleClass('opened');
				e.preventDefault();
			})
			.on('click', '.cart-offcanvas .btn-close', function (e) {
				e.preventDefault();
				$(this).closest('.cart-dropdown').removeClass('opened');
			})
			.on('click', '.cart-offcanvas .cart-overlay', function (e) {
				$(this).closest('.cart-dropdown').removeClass('opened');
			})

			// After product is added to cart
			.on('added_to_cart', function (e, fragments, cart_hash, $thisbutton) {

				var $product = $thisbutton.closest('.product');

				// remove newly added "view cart" button.
				$thisbutton.next('.added_to_cart').remove();

				// if not product single, then open minipopup
				if (!$product.hasClass('product-single')) {
					var link, image, title, price, html, valid = false;

					if ($product.length) { // inside product element
						link = $product.find('.product-media .woocommerce-loop-product__link').attr('href');
						image = $product.find('.product-media img:first-child').attr('src');
						title = $product.find('.woocommerce-loop-product__title a').text();
						price = $product.find('.price').html();
						valid = true;
					} else {
						$product = Riode.filter('riode_minicart_popup_product', [{}, $thisbutton]);
						if (Object.keys($product).length) {
							link = $product['link'];
							image = $product['image'];
							title = $product['title'];
							price = $product['price'];
							valid = true;
						}
					}

					if (valid) {
						html = '<div class="minipopup-box"><h4 class="minipopup-title">' + riode_vars.texts.added_to_cart + '</h4><div class="product product-list-sm"><figure class="product-media"><a href="' + link + '"><img src="' + image + '"></img></a></figure><div class="product-details"><a class="product-title" href="' + link + '">' + title + '</a><span class="count">' + $thisbutton.data('quantity') + '</span> x <span class="price">' + price + '</span></div></div><div class="minipopup-footer"><a href="' + riode_vars.pages.cart + '" class="btn btn-block btn-outline btn-primary btn-viewcart">' + riode_vars.texts.view_cart + '</a><a href="' + riode_vars.pages.checkout + '" class="btn btn-block btn-primary btn-viewcheckout">' + riode_vars.texts.view_checkout + '</a></div></div>';

						Riode.minipopup.open({
							content: html
						});
					}
				}

				$('.minicart-icon').removeClass('adding');
			})
			.on('added_to_cart ajax_request_not_sent.adding_to_cart', function (e, f, c, $thisbutton) {
				if (typeof $thisbutton !== 'undefined') {
					Riode.endLoading($thisbutton);
				}
			})
			.on('wc_fragments_refreshed', function (e, f) {
				Riode.quantityInput('.shop_table .qty');

				setTimeout(function () {
					$('.sticky-sidebar').trigger('recalc.pin');
				}, 400);
			})

			// Refresh cart table when cart item is removed
			.off('click', '.widget_shopping_cart .remove')
			.on('click', '.widget_shopping_cart .remove', function (e) {
				e.preventDefault();
				var $this = $(this);
				var cart_id = $this.data("cart_item_key");

				$.ajax(
					{
						type: 'POST',
						dataType: 'json',
						url: riode_vars.ajax_url,
						data: {
							action: "riode_cart_item_remove",
							nonce: riode_vars.nonce,
							cart_id: cart_id
						},
						success: function (response) {
							var this_page = location.toString(),
								item_count = $(response.fragments['div.widget_shopping_cart_content']).find('.mini_cart_item').length;

							this_page = this_page.replace('add-to-cart', 'added-to-cart');
							$(document.body).trigger('wc_fragment_refresh');

							// Block widgets and fragments
							if (item_count == 0 && ($('body').hasClass('woocommerce-cart') || $('body').hasClass('woocommerce-checkout'))) {
								$('.page-content').block();
							} else {
								$('.shop_table.cart, .shop_table.review-order, .updating, .cart_totals').block();
							}

							// Unblock
							$('.widget_shopping_cart, .updating').stop(true).unblock();

							// Cart page elements
							if (item_count == 0 && ($('body').hasClass('woocommerce-cart') || $('body').hasClass('woocommerce-checkout'))) {
								$('.page-content').load(
									this_page + ' .page-content:eq(0) > *',
									function () {
										$('.page-content').unblock();
									}
								);
							} else {
								$('.shop_table.cart').load(
									this_page + ' .shop_table.cart:eq(0) > *',
									function () {
										$('.shop_table.cart').unblock();
										Riode.quantityInput('.shop_table .qty');
									}
								);

								$('.cart_totals').load(
									this_page + ' .cart_totals:eq(0) > *',
									function () {
										$('.cart_totals').unblock();
									}
								);

								// Checkout page elements
								$('.shop_table.review-order').load(
									this_page + ' .shop_table.review-order:eq(0) > *',
									function () {
										$('.shop_table.review-order').unblock();
									}
								);
							}
						}
					}
				);
				return false;
			})
			// Removing cart item from minicart
			.on('click', '.remove_from_cart_button', function (e) {
				Riode.doLoading($(this).closest('.mini_cart_item'), 'small');
			});
	}

	var initProductsWishlistAction = function () {
		var updateMiniWishList = function () {
			var $wishlist = $('.wishlist'),
				$minilist = $('.mini-basket-dropdown .widget_wishlist_content');

			if (!$wishlist.length) {
				return;
			}

			if ($minilist.length && !$minilist.children('.d-loading').length) {
				Riode.doLoading($minilist, 'small');
			}

			$.ajax({
				url: riode_vars.ajax_url,
				data: {
					action: 'riode_update_mini_wishlist'
				},
				type: 'post',
				success: function (data) {
					if ($wishlist.find('.wish-count').length) {
						$wishlist.find('.wish-count').text($(data).find('.wish-count').text());
					}
					if ($minilist.length) {
						$minilist.html($(data).find('.widget_wishlist_content').html());
					}
				}
			});
		};

		Riode.$body
			// Add item to wishlist
			.on('click', '.add_to_wishlist', function (e) {
				Riode.doLoading($(e.currentTarget).closest('.yith-wcwl-add-to-wishlist'), 'small');
			})
			// Remove item from wishlist
			.on('click', '.yith-wcwl-add-to-wishlist .delete_item', function (e) {
				Riode.doLoading($(e.currentTarget).closest('.yith-wcwl-add-to-wishlist'), 'small');
			})
			// Remove from wishlist if item is already in wishlist
			// .on('click', '.yith-wcwl-wishlistexistsbrowse a, .yith-wcwl-wishlistaddedbrowse a', function (e) {
			// 	if (!$(this).closest('.product-loop').length && $(this).closest('.product-single').length && typeof e.originalEvent != 'undefined') {
			// 		return;
			// 	}

			// 	var $link = $(e.currentTarget),
			// 		$wcwlWrap = $link.closest('.yith-wcwl-add-to-wishlist'),
			// 		product_id = $wcwlWrap.data('fragment-ref'),
			// 		fragmentOptions = $wcwlWrap.data('fragment-options'),
			// 		data = {
			// 			action: yith_wcwl_l10n.actions.remove_from_wishlist_action,
			// 			remove_from_wishlist: product_id,
			// 			fragments: fragmentOptions,
			// 			from: 'theme'
			// 		};


			// 	if (!$wcwlWrap.children('.d-loading').length) {
			// 		Riode.doLoading($wcwlWrap, 'small');
			// 	}
			// 	$.ajax({
			// 		url: yith_wcwl_l10n.ajax_url,
			// 		data: data,
			// 		method: 'post',
			// 		complete: function () {
			// 			Riode.endLoading($wcwlWrap);
			// 		},
			// 		success: function (data) {
			// 			if (fragmentOptions.in_default_wishlist) {
			// 				delete fragmentOptions.in_default_wishlist;
			// 				$wcwlWrap.attr(JSON.stringify(fragmentOptions));
			// 			}
			// 			$wcwlWrap.removeClass('exists');
			// 			$wcwlWrap.find('.yith-wcwl-wishlistexistsbrowse').addClass('yith-wcwl-add-button').removeClass('yith-wcwl-wishlistexistsbrowse');
			// 			$wcwlWrap.find('.yith-wcwl-wishlistaddedbrowse').addClass('yith-wcwl-add-button').removeClass('yith-wcwl-wishlistaddedbrowse');
			// 			$link.attr('href', location.href + '?post_type=product&amp;add_to_wishlist=' + product_id);
			// 			$link.attr('data-product-id', product_id);
			// 			$link.attr('data-product-type', fragmentOptions.product_type);
			// 			$link.attr('title', riode_vars.texts.add_to_wishlist);
			// 			$link.attr('data-title', riode_vars.texts.add_to_wishlist);
			// 			$link.addClass('add_to_wishlist single_add_to_wishlist');
			// 			$link.html('<span>' + riode_vars.texts.add_to_wishlist + '</span>');
			// 			Riode.$body.trigger('removed_from_wishlist');
			// 		}
			// 	});
			// 	e.preventDefault();
			// })
			.on('added_to_wishlist', function (e) {
				updateMiniWishList();
			})
			.on('removed_from_wishlist', function () {
				updateMiniWishList();
			})
			.on('added_to_cart', function (e, fragments, cart_hash, $button) {
				if ($button.closest('#yith-wcwl-form').length) {
					updateMiniWishList();
				}
			})
			.on('click', '.wishlist-dropdown .wishlist-item .remove_from_wishlist', function (e) {
				e.preventDefault();

				var id = $(this).attr('data-product_id'),
					$product = $('.yith-wcwl-add-to-wishlist.add-to-wishlist-' + id),
					$table = $('.wishlist_table #yith-wcwl-row-' + id + ' .remove_from_wishlist');

				Riode.doLoading($(this).closest('.widget_wishlist_content'), 'small');

				if ($product.length) {
					$product.find('a').trigger('click');
				} else if ($table.length) {
					$table.trigger('click');
				} else {
					$.ajax({
						url: yith_wcwl_l10n.ajax_url,
						data: {
							action: yith_wcwl_l10n.actions.remove_from_wishlist_action,
							remove_from_wishlist: id,
							from: 'theme'
						},
						method: 'post',
						success: function (data) {
							updateMiniWishList();
							Riode.$body.trigger('removed_from_wishlist');
						}
					});
				}
			})
			.on('click', '.wishlist-offcanvas > .wishlist', function (e) {
				$(this).closest('.wishlist-dropdown').toggleClass('opened');
				e.preventDefault();
			})
			.on('click', '.wishlist-offcanvas .btn-close', function (e) {
				e.preventDefault();
				$(this).closest('.wishlist-dropdown').removeClass('opened');
			})
			.on('click', '.wishlist-offcanvas .wishlist-overlay', function (e) {
				$(this).closest('.wishlist-dropdown').removeClass('opened');
			});
	}

	var initProductsYithCompare = function () {

		if ('undefined' == typeof yith_woocompare) {
			return;
		}

		// Redefine "add to compare" function because they do not use async ajax.
		$(document)
			.off('click', '.product a.compare:not(.added)')
			.on('click', '.product a.compare:not(.added)', function (e) {
				e.preventDefault();

				var button = $(this),
					data = {
						action: yith_woocompare.actionadd,
						id: button.data('product_id'),
						context: 'frontend'
					},
					widget_list = $('.yith-woocompare-widget ul.products-list');

				Riode.doLoading(button, 'small');

				// increase compare count
				$('.compare-open .compare-count').each(function () {
					this.innerHTML = parseInt(this.innerHTML) + 1;
				});

				// do ajax
				$.ajax({
					type: 'post',
					url: yith_woocompare.ajaxurl.toString().replace('%%endpoint%%', yith_woocompare.actionadd),
					data: data,
					dataType: 'json',
					success: function (response) {

						Riode.endLoading(button);

						button.addClass('added')
							.attr('href', response.table_url)
							.text(yith_woocompare.added_label);

						// add the product in the widget
						widget_list.html(response.widget_table);

						if (yith_woocompare.auto_open == 'yes')
							$('body').trigger('yith_woocompare_open_popup', { response: response.table_url, button: button });
					}
				});
			});

		// decrease compare count
		Riode.$body.on('yith_woocompare_open_popup', function () {
			setTimeout(function () {
				if (Riode.$body.find('iframe').length) {
					var childWindow = Riode.$body.find('iframe')[0].contentWindow;
					if (childWindow.jQuery) {
						childWindow.jQuery(childWindow).on('yith_woocompare_product_removed', function () {
							$('.compare-open .compare-count').each(function () {
								this.innerHTML = Math.max(0, parseInt(this.innerHTML) - 1);
							});
						});
					}
				}
			}, 1000);
		});
	}

	var initPreOrder = function () {
		if (riode_vars.pre_order) {
			var cartBtnLabel = $('.single_add_to_cart_button').html();
			$(document).on('found_variation', '.variations_form', function (e, args) {
				var $btn = $(this).find('.single_add_to_cart_button');

				cartBtnLabel = $btn.html();
				$btn.html(args.riode_pre_order ? args.riode_pre_order_label : cartBtnLabel);
				args.riode_pre_order_date &&
					$(this).find('.woocommerce-variation-description').append(args.riode_pre_order_date);
			}).on('reset_data', '.variations_form', function () {
				$(this).find('.single_add_to_cart_button').html(cartBtnLabel);
			});
		}
	};

	var initSubpages = function () {
		// Refresh sticky sidebar on shipping calculator in cart page
		Riode.$body.on('click', '.shipping-calculator-button', function (e) {
			var btn = e.currentTarget;
			setTimeout(function () {
				$(btn).closest('.sticky-sidebar').trigger('recalc.pin');
			}, 400);
		})
	}

	function _lazyloadProductsTabImages() {
		if ($.fn.lazyload) {
			Riode.$('.elementor-widget-riode_widget_products_tab .d-lazyload').lazyload(Riode._lazyload_options);
		}
	}

	// Public Properties

	var Shop = {
		init: function () {
			this.removerId = 0;

			// Functions for products
			initProductsQuickview();
			initProductsCartAction();
			initProductsWishlistAction();
			initProductsAttributeAction();

			// initProductsYithCompare();
			_lazyloadProductsTabImages();

			// Single Product
			initPreOrder(); // on Skeleton_loaded -> initPreOrder();

			// Functions for shop page
			initSelectMenu();
			initSubpages();

			// Functions for Alert
			this.initAlertAction();
			Riode.call(this.initProducts.bind(this), 500);
		},

		/**
		 * @function initProducts
		 * 
		 * @param {HTMLElement|jQuery|string} selector
		 * 
		 * Initialize products
		 */
		initProducts: function (selector) {
			this.ratingTooltip(selector);
			this.initProductType(selector);
			this.calcSalesProgress(selector);

			Riode.quantityInput('.qty');
			$('input.qty').off('change', this.handleQTY).on('change', this.handleQTY);

			// YITH Wishlist widget
			Riode.$(document).trigger('yith_infs_added_elem');
		},

		/**
		 * @function ratingTooltip
		 * 
		 * @param {HTMLElement|jQuery|string} selector
		 * 
		 * Find all .star-rating from selector, and initialize tooltip.
		 */
		ratingTooltip: function (selector) {
			var ratingHandler = function () {
				var res = this.firstElementChild.getBoundingClientRect().width / this.getBoundingClientRect().width * 5;
				this.lastElementChild.innerText = res ? res.toFixed(2) : res;
			}

			Riode.$(selector, '.star-rating').each(function () {
				if (!this.lastElementChild.classList.contains('tooltiptext')) {
					var span = document.createElement('span');
					span.classList.add('tooltiptext');
					span.classList.add('tooltip-top');

					this.appendChild(span);
					this.addEventListener('mouseover', ratingHandler);
					this.addEventListener('touchstart', ratingHandler, { passive: true });
				}
			});
		},

		/**
		 * @function calcSalesProgress
		 *
		 * calcs each product's sales progress bar width
		 *
		 * @since 1.4.0
		 */
		calcSalesProgress: function (selector) {
			var totalSales = Riode.$(selector, '.products-max-sales:last-child');

			if (!totalSales.length) {
				return;
			}

			totalSales = totalSales.attr('data-value');

			Riode.$(selector, '.sales-progress .count-now').each(function () {
				$(this).css('width', ($(this).attr('data-sales') / totalSales * 100) + '%');
			});
		},

		initProductType: function (selector) {
			// Init popup type
			Riode.$(selector, '.product-popup .product-details').each(function (e) {
				var $this = $(this),
					hidden_height = $this.find('.product-hide-details').outerHeight(true);

				$this.height($this.height() - hidden_height);
			});

			Riode.$(selector, '.product-popup')
				.on('mouseenter touchstart', function (e) {
					var $this = $(this),
						hidden_height = $this.find('.product-hide-details').outerHeight(true);

					// if boxed product
					$this.find('.product-details').css('transform', 'translateY(' + ($this.hasClass('product-boxed') ? 11 - hidden_height : -hidden_height) + 'px)');
					$this.find('.product-hide-details').css('transform', 'translateY(' + (-hidden_height) + 'px)');
				})
				.on('mouseleave touchleave', function (e) {

					var $this = $(this);

					$this.find('.product-details').css('transform', 'translateY(0)');
					$this.find('.product-hide-details').css('transform', 'translateY(0)');
				});
		},

		initAlertAction: function () {
			this.removerId && clearTimeout(this.removerId);
			this.removerId = setTimeout(function () {
				$('.woocommerce-page .main-content .alert .btn-close').not(':hidden').click();
			}, riode_vars.wc_alert_remove);
		},

		handleQTY: function () {
			var $obj = $(this);
			if ($obj.closest('.quantity').next('.add_to_cart_button[data-quantity]').length) {
				var count = $obj.val();
				if (count) {
					$obj.closest('.quantity').next('.add_to_cart_button[data-quantity]').attr('data-quantity', count);
				}
			}
		},

		switchColumns: function (isClosed) {
			// change columns
			var $wrapper = $('.main-content .products');
			if ($wrapper.length) {
				if ($wrapper.hasClass('list-type-products')) {

					// if list type, toggle 2 cols or 1 col
					$wrapper.toggleClass('row cols-xl-2', !isClosed);

				} else {

					// if grid type
					var cnt_xl = $wrapper.attr('class').match(/cols-xl-(\d)/),
						cnt_lg = $wrapper.attr('class').match(/cols-lg-(\d)/),
						cnt = $wrapper.attr('class').match(/cols-\w*-*(\d)/);

					if (null == cnt_lg) {
						cnt_lg = ['', cnt[1]];
					}
					if (null == cnt_xl) {
						cnt_xl = ['', cnt_lg[1]];
					}

					if (isClosed) { // when open
						$wrapper.removeClass('cols-xl-' + cnt_xl[1] + ' cols-lg-' + cnt_lg[1]);
						$wrapper.addClass('cols-xl-' + (Number(cnt_xl[1]) - 1) + ' cols-lg-' + (Number(cnt_lg[1]) - 1));
					} else { // when close
						$wrapper.removeClass('cols-xl-' + cnt_xl[1] + ' cols-lg-' + cnt_lg[1]);
						$wrapper.addClass('cols-xl-' + (Number(cnt_xl[1]) + 1) + ' cols-lg-' + (Number(cnt_lg[1]) + 1));
					}
				}
			}
		}
	}

	Riode.shop = Shop;
})(jQuery);



/**
 * Riode Plugin - Account
 * 
 * @requires popup
 */
(function ($) {
	var Account = {
		init: function () {
			if (!Riode.$body.hasClass('woocommerce-account')) { // disable login/register popup in my account page
			        this.launchPopup();
			}
			this.checkValidation();
		},

		// Launch login form popup for both login and register buttons
		launchPopup: function () {
			$('.header .account > a').on('click', function (e) {
				if (this.classList.contains('logout')) {
					return;
				}

				e.preventDefault();

				var isRegister = this.classList.contains('register');
				Riode.popup({
					callbacks: {
						afterChange: function () {
							this.container.html('<div class="mfp-content"></div><div class="mfp-preloader"><div class="login-popup"><div class="d-loading"><i></i></div></div></div>');
							this.contentContainer = this.container.children('.mfp-content');
							this.preloader = false;
						},
						beforeClose: function () {
							this.container.empty();
						},
						ajaxContentAdded: function () {
							var self = this;
							if (isRegister) {
								this.wrap.find('[href="signup"]').click();
							}

							setTimeout(function () {
								self.contentContainer.next('.mfp-preloader').remove();
							}, 200);
						}
					}
				}, 'login');
			});
		},

		// Check if user input validation
		checkValidation: function () {
			$('body').on('submit', '#customer_login form', function (e) {
				var $form = $(this), isLogin = $form[0].classList.contains('login');
				if (riode_vars.recaptcha) {
					if (!$('.g-recaptcha-response').val()) {
						$form.find('p.submit-status').html(riode_vars.recaptcha_msg).removeClass('loading');
						// $('#recaptcha-accessible-status').html(riode_vars.recaptcha_msg);
						$form.find('.anr_captcha_field_div').append('<p class="mb-0" style="color:red;">' + riode_vars.recaptcha_msg + '</p>');
						$form.find('.anr_captcha_field_div').css({
							"border": "1px solid red",
							"padding": "10px"
						});

						setTimeout(function () {
							$form.find('.anr_captcha_field_div').find('p.mb-0').remove();
							$form.find('.anr_captcha_field_div').css({
								"border-width": "0px",
								"padding": "0px"
							});
						}, 5000);
						e.preventDefault();
						return;
					}
				}

				$form.find('p.submit-status').show().text('Please wait...').addClass('loading');
				$form.find('button[type=submit]').attr('disabled', 'disabled');
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: riode_vars.ajax_url,
					data: $form.serialize() + '&action=riode_account_' + (isLogin ? 'signin' : 'signup') + '_validate',
					success: function (data) {
						$form.find('p.submit-status').html(data.message.replace('/<script.*?\/script>/s', '')).removeClass('loading');
						$form.find('button[type=submit]').prop('disabled', false);
						if (data.loggedin === true) {
							var link = riode_vars.my_account_page_link;
							location.href = link;
						}
					}
				});
				e.preventDefault();
			});
		}
	}

	Riode.account = Account;
})(jQuery);



/**
 * Riode Plugin - Slider
 * 
 * @requires OwlCarousel
 * @instance multiple
 */
(function ($) {

	function Slider($el, options, owlItem) {
		// Is mobile slider disabled?
		Riode.disableMobileSlider = Riode.$body.hasClass('riode-disable-mobile-slider') && ('ontouchstart' in document) && (Riode.$window.width() < 1200);

		if (Riode.disableMobileSlider && ($el.hasClass('products') || $el.hasClass('posts') || $el.hasClass('image-gallery'))) {
			$el.children().each(function () {
				$(this).wrap('<div class="owl-item"></div>');
			});

			$el.addClass('mobile-slider');

			var offset = $el.children().eq(0).outerWidth();
			$el.scrollLeft(offset / 2);

			owlLazyload.call($el, true);

			return;
		}

		return this.init($el, options, owlItem);
	}

	// Private Properties
	var onInitialize = function (e) {
		var i,
			$el = $(e.currentTarget);

		var match = this.getAttribute('class').match(/row|gutter\-\w\w|cols\-\d|cols\-\w\w-\d/g);
		if (match) {
			$(this).data('slider-layout', match)
			this.setAttribute('class', this.getAttribute('class').replace(/row|gutter\-\w\w|cols\-\d|cols\-\w\w-\d/g, '').replace(/\s+/, ' '));
		}

		if (this.classList.contains("animation-slider")) {
			var els = this.children,
				len = els.length;
			for (var i = 0; i < len; ++i) {
				els[i].setAttribute('data-index', i + 1);
			}
		}
	}
	var onInitialized = function (e) {
		var els = this.firstElementChild.firstElementChild.children,
			i,
			len = els.length;
		for (i = 0; i < len; ++i) {
			if (!els[i].classList.contains('active')) {
				var animates = Riode.byClass('appear-animate', els[i]),
					j,
					alen = animates.length;
				for (j < 0; j < alen; ++j) {
					animates[j].classList.remove('appear-animate');
				}
			}
		}

		// Video
		var $el = $(e.currentTarget);
		$el.find('video')
			.removeAttr('style')
			.on('ended', function () {
				var $this = $(this);
				if ($this.closest('.owl-item').hasClass('active')) {
					if (true === $el.data('owl.carousel').options.autoplay) {
						if (false === $el.data('owl.carousel').options.loop && ($el.data().children - 1) === $el.find('.owl-item.active').index()) {
							this.loop = true;
							try {
								this.play();
							} catch (e) {
								logMyErrors(e);
							}
						}
						$el.trigger('next.owl.carousel');
						$el.trigger('play.owl.autoplay');
					} else {
						this.loop = true;
						try {
							this.play();
						} catch (e) {
							logMyErrors(e);
						}
					}
				}
			});

		$(document).trigger('click');

		owlLazyload.call(this);
	}

	var onTranslated = function (e) {
		$(window).trigger('appear.check');

		// Video Play
		var $el = $(e.currentTarget),
			$activeVideos = $el.find('.owl-item.active video');

		$el.find('.owl-item:not(.active) video').each(function () {
			if (!this.paused) {
				$el.trigger('play.owl.autoplay');
			}
			this.pause();
			this.currentTime = 0;
		});

		if ($activeVideos.length) {
			if (true === $el.data('owl.carousel').options.autoplay) {
				$el.trigger('stop.owl.autoplay');
			}
			$activeVideos.each(function () {
				try {
					this.paused && this.play();
				} catch (e) {
					logMyErrors(e);
				}
			});
		}

		owlLazyload.call(this);
	}
	var onSliderInitialized = function (e) {
		var self = this,
			$el = $(e.currentTarget);

		// carousel content animation
		$el.find('.owl-item.active .slide-animate').each(function () {
			var $animation_item = $(this),
				settings = $animation_item.data('settings'),
				duration,
				delay = settings._animation_delay ? settings._animation_delay : 0,
				aniName = settings._animation_name;

			if ($animation_item.hasClass('animated-slow')) {
				duration = 2000;
			} else if ($animation_item.hasClass('animated-fast')) {
				duration = 750;
			} else {
				duration = 1000;
			}

			$animation_item.css('animation-duration', duration + 'ms');

			duration = duration ? duration : 750;

			var temp = Riode.requestTimeout(function () {
				$animation_item.addClass(aniName);

				$animation_item.addClass('show-content');
				self.timers.splice(self.timers.indexOf(temp), 1)
			}, (delay ? delay : 0));
		});
	}

	function owlLazyload(e, mobile) {
		if ($.fn.lazyload || true === mobile) {
			var $this = $(this);
			$this.find('.d-lazyload').add($this.find('.d-lazy-back')).add($this.find('[data-lazy-back]')).filter(function () {
				return !$(this).data('_lazyload_init');
			}).data('_lazyload_init', 1).each(function () {
				$(this).lazyload(Riode._lazyload_options);
			});
		}
	}

	var onSliderResized = function (e) {
		$(e.currentTarget).find('.owl-item.active .slide-animate').each(function () {
			var $animation_item = $(this);
			$animation_item.addClass('show-content');
			$animation_item.css('animation-name', '');
			$animation_item.css('animation-duration', '');
			$animation_item.css('animation-delay', '');
		});
	}

	var onSliderTranslate = function (e) {
		var self = this,
			$el = $(e.currentTarget);
		self.translateFlag = 1;
		self.prev = self.next;
		$el.find('.owl-item .slide-animate').each(function () {
			var $animation_item = $(this),
				settings = $animation_item.data('settings');
			$animation_item.removeClass(settings._animation_name);
			$animation_item.removeClass('animated appear-animation-visible');
			$animation_item.removeClass('elementor-invisible appear-animate');
		});
	}

	var onSliderTranslated = function (e) {
		var self = this,
			$el = $(e.currentTarget);

		if (1 == self.translateFlag) {
			self.next = $el.find('.owl-item').eq(e.item.index).children().attr('data-index');
			$el.find('.show-content').removeClass('show-content');

			if (self.prev != self.next) {
				/* clear all animations that are running. */
				if ($(this).hasClass("animation-slider")) {
					for (var i = 0; i < self.timers.length; i++) {
						Riode.deleteTimeout(self.timers[i]);
					}
					self.timers = [];
				}
				$el.find('.owl-item.active .slide-animate').each(function () {
					var $animation_item = $(this),
						settings = $animation_item.data('settings'),
						duration,
						delay = settings._animation_delay ? settings._animation_delay : 0,
						aniName = settings._animation_name;

					if ($animation_item.hasClass('animated-slow')) {
						duration = 2000;
					} else if ($animation_item.hasClass('animated-fast')) {
						duration = 750;
					} else {
						duration = 1000;
					}

					$animation_item.css('animation-duration', duration + 'ms');
					$animation_item.css('animation-delay', delay + 'ms');
					$animation_item.css('transition-property', 'visibility, opacity');
					$animation_item.css('transition-duration', duration + 'ms');
					$animation_item.css('transition-delay', delay + 'ms');

					$animation_item.addClass(aniName);

					if ($animation_item.hasClass('maskLeft')) {
						$animation_item.css('width', 'fit-content');
						var width = $animation_item.width();
						$animation_item.css('width', 0).css(
							'transition',
							'width ' + (duration ? duration : 750) + 'ms linear ' + (delay ? delay : '0s'));
						$animation_item.css('width', width);
					}

					duration = duration ? duration : 750;
					$animation_item.addClass('show-content');

					var temp = Riode.requestTimeout(function () {
						$animation_item.css('transition-property', '');
						$animation_item.css('transition-delay', '');
						$animation_item.css('transition-duration', '');

						self.timers.splice(self.timers.indexOf(temp), 1)
					}, (delay ? (delay + 200) : 200));
					self.timers.push(temp);
				});
			} else {
				$el.find('.owl-item').eq(e.item.index).find('.slide-animate').addClass('show-content');
			}
			self.translateFlag = 0;
		}
	}

	// Public Properties

	Slider.defaults = {
		responsiveClass: true,
		navText: [],
		checkVisible: false,
		items: 1,
		smartSpeed: navigator.userAgent.indexOf("Edge") > -1 ? 200 : 300,
		autoplaySpeed: navigator.userAgent.indexOf("Edge") > -1 ? 200 : 1000
	}

	Slider.presets = {
		'intro-slider': {
			animateIn: 'fadeIn',
			animateOut: 'fadeOut'
		},
		'product-single-carousel': {
			dots: false,
			nav: true,
		},
		'rotate-slider': {
			dots: false,
			nav: true,
			loop: true,
			items: 1,
			animateIn: '',
			animateOut: ''
		},
		'product-gallery-carousel': {
			dots: true,
			nav: false,
			margin: 20,
			items: 1,
			responsive: {
				576: {
					items: 2
				},
				768: {
					items: 3,
					dots: false,
					nav: true
				},
			},
		},
		'products-flipbook': {
			onInitialized: function () {
				function stopDrag(e) {
					var $target = $(e.target);
					if ($target.closest('.product-single-carousel.owl-drag').length || $target.closest('.product-gallery-carousel.owl-drag').length || $target.closest('.product-thumbs.owl-drag').length) {
						e.stopPropagation();
					}
				}
				this.$stage.children().on('mousedown', stopDrag).on('touchstart', stopDrag);
			}
		}
	}

	Slider.addPreset = function (className, options) {
		this.presets[className] = options;
		return this;
	}

	Slider.prototype.init = function ($el, options, owlItem) {
		this.timers = [];
		this.translateFlag = 0;
		this.prev = 1;
		this.next = 1;

		var classes = $el.attr('class').split(' '),
			settings = $.extend(true, {}, Slider.defaults);

		// extend preset options
		classes.forEach(function (className) {
			var preset = Slider.presets[className];
			preset && $.extend(true, settings, preset);
		});


		// floating svg compatibility
		$el.find('.float-svg').length && $el.on('translated.owl.carousel', function (e) {
			Riode.$window.trigger('check_float_svg');
		})

		// extend user options
		$.extend(true, settings, Riode.parseOptions($el.attr('data-owl-options')), options);

		// for rtl
		if (Riode.$body.hasClass('rtl')) {
			settings.rtl = true;
		}

		onSliderInitialized = onSliderInitialized.bind(this);
		onSliderTranslate = onSliderTranslate.bind(this);
		onSliderTranslated = onSliderTranslated.bind(this);

		// init
		$el.on('initialize.owl.carousel', onInitialize)
			.on('initialized.owl.carousel', onInitialized)
			.on('resized.owl.carousel', owlLazyload)
			.on('translated.owl.carousel', onTranslated);

		// if animation slider
		$el.hasClass('animation-slider') &&
			$el.on('initialized.owl.carousel', onSliderInitialized)
				.on('resized.owl.carousel', onSliderResized)
				.on('translate.owl.carousel', onSliderTranslate)
				.on('translated.owl.carousel', onSliderTranslated);

		var $videos = $el.find('video');
		$videos.each(function () {
			this.loop = false;
		});

		// if lazyload
		$el.owlCarousel(settings);
		$el.trigger('to.owl.carousel', [owlItem, 0]);
	}

	Riode.slider = function (selector, options, owlItem, vcPreview) {
		if (typeof vcPreview == 'undefined') {
			vcPreview = false;
		}
		if (typeof owlItem == 'undefined') {
			owlItem = 0;
		}
		Riode.$(selector).each(function () {
			var $this = $(this);
			// if in passive tab
			if (selector == '.owl-carousel') {
				var $pane = $this.closest('.tab-pane');
				if ($pane.length && !$pane.hasClass('active') && $pane.closest('.elementor-widget-riode_widget_products_tab').length) {
					return;
				}
			}
			if (vcPreview == true)
				new Slider($this, options, owlItem);
			else
				Riode.call(function () {
					new Slider($this, options, owlItem);
				});
		});
	}
})(jQuery);

/**
 * Riode Plugin - QuantityInput
 */
(function ($) {

	function QuantityInput($el) {
		return this.init($el);
	}

	// Private Properteis

	function preventDefault(e) {
		e.preventDefault();
	}

	// Public Properties

	QuantityInput.min = 1;
	QuantityInput.max = 1000000;

	QuantityInput.prototype.init = function ($el) {
		var self = this;

		self.$minus = false;
		self.$plus = false;
		self.$value = false;
		self.value = false;

		// Bind Events
		self.startIncrease = self.startIncrease.bind(self);
		self.startDecrease = self.startDecrease.bind(self);
		self.stop = self.stop.bind(self);

		// Variables
		self.min = parseInt($el.attr('min'));
		self.max = parseInt($el.attr('max'));

		self.min || ($el.attr('min', self.min = QuantityInput.min))
		self.max || ($el.attr('max', self.max = QuantityInput.max))

		// Add DOM elements and event listeners
		self.$value = $el.val(self.value = Math.max(parseInt($el.val()), 1));
		self.$minus = $el.prevAll('button').on('click', preventDefault);
		self.$plus = $el.next().on('click', preventDefault);

		if ('ontouchstart' in document) {
			self.$minus.on('touchstart', self.startDecrease)
			self.$plus.on('touchstart', self.startIncrease)
		} else {
			self.$minus.on('mousedown', self.startDecrease)
			self.$plus.on('mousedown', self.startIncrease)
		}

		Riode.$body.on('mouseup', self.stop)
			.on('touchend', self.stop);
	}

	QuantityInput.prototype.startIncrease = function (e) {
		var self = this;
		self.value = self.$value.val();
		self.value < self.max && (self.$value.val(++self.value), self.$value.trigger('change'));
		self.increaseTimer = Riode.requestTimeout(function () {
			self.speed = 1;
			self.increaseTimer = Riode.requestInterval(function () {
				self.$value.val(self.value = Math.min(self.value + Math.floor(self.speed *= 1.05), self.max));
			}, 50);
		}, 400);
	}

	QuantityInput.prototype.stop = function (e) {
		(this.increaseTimer || this.decreaseTimer) && this.$value.trigger('change');
		this.increaseTimer && (Riode.deleteTimeout(this.increaseTimer), this.increaseTimer = 0);
		this.decreaseTimer && (Riode.deleteTimeout(this.decreaseTimer), this.decreaseTimer = 0);
	}

	QuantityInput.prototype.startDecrease = function (e) {
		var self = this;
		self.value = self.$value.val();
		self.value > self.min && (self.$value.val(--self.value), self.$value.trigger('change'));
		self.decreaseTimer = Riode.requestTimeout(function () {
			self.speed = 1;
			self.decreaseTimer = Riode.requestInterval(function () {
				self.$value.val(self.value = Math.max(self.value - Math.floor(self.speed *= 1.05), self.min));
			}, 50);
		}, 400);
	}

	Riode.QuantityInput = QuantityInput;
	Riode.quantityInput = function (selector) {
		Riode.$(selector).each(function () {
			var $this = $(this);
			// if not initialized
			$this.data('quantityInput') ||
				$this.data('quantityInput', new QuantityInput($this));
		});
	}
})(jQuery);


/**
 * Currency Switcher
 * 
 * @since 1.4.2
 */
(function ($) {

	Riode.currencySwitcher = {
		init: function () {

			this.events();

			return this;
		},

		events: function () {
			var self = this;

			// wcml currency switcher
			$('body').on('click', '.wcml-switcher li', function () {
				if ($(this).parent().attr('disabled') == 'disabled')
					return;
				var currency = $(this).attr('rel');
				self.loadCurrency(currency);
			});

			// woocommerce currency switcher
			$('body').on('click', '.woocs-switcher li', function () {
				if ($(this).parent().attr('disabled') == 'disabled')
					return;
				var currency = $(this).attr('rel');
				self.loadWoocsCurrency(currency);
			});

			return self;
		},

		loadCurrency: function (currency) {
			$('.wcml-switcher').attr('disabled', 'disabled');
			$('.wcml-switcher').append('<li class="loading"></li>');
			var data = { action: 'wcml_switch_currency', currency: currency };
			$.ajax({
				type: 'post',
				url: riode_vars.ajax_url,
				data: {
					action: 'wcml_switch_currency',
					currency: currency
				},
				success: function (response) {
					$('.wcml-switcher').removeAttr('disabled');
					$('.wcml-switcher').find('.loading').remove();
					window.location = window.location.href;
				}
			});
		},

		loadWoocsCurrency: function (currency) {
			$('.woocs-switcher').attr('disabled', 'disabled');
			$('.woocs-switcher').append('<li class="loading"></li>');
			var l = window.location.href;
			l = l.split('?');
			l = l[0];
			var string_of_get = '?';
			woocs_array_of_get.currency = currency;

			if (Object.keys(woocs_array_of_get).length > 0) {
				jQuery.each(woocs_array_of_get, function (index, value) {
					string_of_get = string_of_get + "&" + index + "=" + value;
				});
			}
			window.location = l + string_of_get;
		},

		removeParameterFromUrl: function (url, parameter) {
			return url
				.replace(new RegExp('[?&]' + parameter + '=[^&#]*(#.*)?$'), '$1')
				.replace(new RegExp('([?&])' + parameter + '=[^&]*&'), '$1');
		}
	};

})(jQuery);

/**
 * jQuery easing
 */
jQuery.extend(jQuery.easing, {
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c * (t /= d) * (t - 2) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
		return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c * ((t = t / d - 1) * t * t * t * t + 1) + b;
	}
});

/**
 * Riode Theme Async Setup
 */
(function ($) {
	// Initialize Method which runs asynchronously after document has been loaded
	Riode.initAsync = function () {
		Riode.appearAnimate('.appear-animate');            // Runs appear animations
		Riode.minipopup.init();                            // Initialize minipopup
		Riode.stickyContent('.sticky-content:not(.mobile-icon-bar):not(.sticky-toolbox)');            // Initialize sticky content
		Riode.stickyContent('.mobile-icon-bar', {
			minWidth: 0,
			maxWidth: 767,
			top: 150,
			hide: true,
			scrollMode: true,
			maxIndex: 1038,
		});
		if (Riode.enableStickyToolbox) {
			Riode.stickyContent('.sticky-toolbox', {            // Initialize sticky toolbox
				minWidth: 0,
				maxWidth: 767,
				scrollMode: true
			});
		}
		Riode.shop.init();                                 // Initialize shop
		Riode.initProductSingle();                         // Initialize single product
		Riode.slider('.owl-carousel');                     // Initialize slider
		Riode.sidebar('left-sidebar');                     // Initialize left sidebar
		Riode.sidebar('right-sidebar');                    // Initialize right sidebar
		Riode.sidebar('top-sidebar');                      // Initialize top sidebar
		Riode.quantityInput('.qty');                       // Initialize quantity input
		Riode.playableVideo('.post-video');                // Initialize playable video
		Riode.accordion('.card-header > a');               // Initialize accordion
		Riode.tab('.nav-tabs');                            // Initialize tab
		Riode.degree360('.riode-360-gallery-wrapper');     // Initialize 360 degree
		Riode.alert('.alert');                             // Initialize alert
		Riode.parallax('.parallax');                       // Initialize parallax
		Riode.countTo('.count-to');                        // Initialize countTo
		Riode.countdown('.product-countdown, .countdown'); // Initialize countdown
		Riode.menu.init();                                 // Initialize menus
		Riode.initPopups();                                // Initialize popups: login, register, play video, newsletter popup
		Riode.account.init();                              // Initialize account popup
		Riode.initSalesPopup();                            // Initialize minipopup for purchased event
		Riode.initScrollTopButton();                       // Initialize scroll top button.
		Riode.initScrollTo();                              // Initialize scroll top button.
		Riode.initContactForms();                          // Initialize contact forms
		Riode.initSearchForm();                            // Initialize search form
		Riode.initVideoPlayer();                           // Initialize VideoPlayer
		Riode.initAjaxLoadPost();                          // Initialize AjaxLoadPost
		Riode.initDokanSearch();                           // Initialize Dokan Store Filter
		Riode.initReadingProgressBar();                    // Initialize Reading Progress Bar
		Riode.initHotspot();
		Riode.initDismissButton();

		Riode.initElementor();                             // Compatibility with Elementor
		Riode.floatSVG('.float-svg');                      // Floating SVG
		Riode.initFloatingElements();                      // Initialize floating elements
		Riode.initSkrollrElements();                       // Initialize skrollr elements
		Riode.initKeyDown();                               // Initialize keydown events

		Riode.initStickyResponsive();

		Riode.currencySwitcher.init();			// Initialize CurrencySwitcher Events

		/* only for loged in with admin-role */
		Riode.showEditPageTooltip();

		// Refresh layouts
		setTimeout(function () {
			Riode.$window.trigger('update_lazyload');
		}, 300);

		// Setup Events
		Riode.$window.on('resize', Riode.onResize);

		// Complete!
		Riode.status == 'load' && (Riode.status = 'complete');
		Riode.$window.trigger('riode_complete');
	}
})(jQuery);

jQuery(window).on('load', function () {
	jQuery('body > .popup').each(function (e) {
		var options = JSON.parse(jQuery(this).attr('data-popup-options')),
			$this = jQuery(this);
		if ('load' === options.popup_on) {
			setTimeout(function () {
				if (!Riode.getCookie('hideNewsletterPopup')) {
					$this.imagesLoaded(function () {
						Riode.popup({
							items: {
								src: $this[0]
							},
							callbacks: {
								open: function () {
									jQuery('.hs-fullscreen.show').removeClass('show');
									jQuery(this)[0].container.css({ 'animation-duration': options.popup_duration, 'animation-timing-function': 'linear' });
									jQuery(this)[0].container.addClass(options.popup_animation + ' animated');

									jQuery('.mfp-newsletter-popup .popup').css('display', '');
								},
								ajaxContentAdded: function () {
									var $popupContainer = $(this)[0].container.find('.popup');
									// Contact Form 7 Compatibility
									Riode.initWPCF7($popupContainer);
								}
							}
						}, 'firstpopup');
					});
				}
			}, 1000 * options.popup_within);
		}
	});
});
