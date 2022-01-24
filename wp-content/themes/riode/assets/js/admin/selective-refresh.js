jQuery(document).ready(function ($) {
	'use strict';

	var options = [
		'container', 'container_fluid', 'gutter_lg', 'gutter', 'gutter_sm',
		['site_type', 'screen_bg', 'content_bg', 'site_width', 'site_gap'],
		['breakpoint_tab', 'breakpoint_mob'],
		['primary_color', 'secondary_color', 'alert_color', 'dark_color', 'light_color'],
		['typo_default'],
		'typo_heading',
		'ptb_bg', 'ptb_height',
		'typo_ptb_title', 'typo_ptb_subtitle', 'typo_ptb_breadcrumb',
		['footer_skin', 'footer_bg', 'footer_link_color', 'footer_active_color', 'footer_bd_color', 'typo_footer', 'typo_footer_title', 'typo_footer_widget'],
		['top_button_size', 'top_button_pos'],
		['ft_padding', 'fm_padding', 'fb_padding', 'ft_divider', 'fm_divider', 'fb_divider'],
		'share_color',
		['typo_menu_skin1_ancestor', 'skin1_ancestor_gap', 'skin1_ancestor_padding', 'skin1_anc_bg', 'skin1_anc_active_bg', 'skin1_anc_active_color'],
		['typo_menu_skin1_content', 'skin1_con_bg', 'skin1_con_active_bg', 'skin1_con_active_color'],
		['typo_menu_skin1_toggle', 'skin1_toggle_padding', 'skin1_tog_bg', 'skin1_tog_active_bg', 'skin1_tog_active_color'],
		['typo_menu_skin2_ancestor', 'skin2_ancestor_gap', 'skin2_ancestor_padding', 'skin2_anc_bg', 'skin2_anc_active_bg', 'skin2_anc_active_color'],
		['typo_menu_skin2_content', 'skin2_con_bg', 'skin2_con_active_bg', 'skin2_con_active_color'],
		['typo_menu_skin2_toggle', 'skin2_toggle_padding', 'skin2_tog_bg', 'skin2_tog_active_bg', 'skin2_tog_active_color'],
		['typo_menu_skin3_ancestor', 'skin3_ancestor_gap', 'skin3_ancestor_padding', 'skin3_anc_bg', 'skin3_anc_active_bg', 'skin3_anc_active_color'],
		['typo_menu_skin3_content', 'skin3_con_bg', 'skin3_con_active_bg', 'skin3_con_active_color'],
		['typo_menu_skin3_toggle', 'skin3_toggle_padding', 'skin3_tog_bg', 'skin3_tog_active_bg', 'skin3_tog_active_color'],
		['custom_css', 'header_css'],
		'social_color',
		'search_width',
		['header_bg', 'typo_header', 'header_active_color'],
		['product_top_label_bg_color', 'product_sale_label_bg_color', 'product_stock_label_bg_color', 'product_new_label_bg_color', 'product_custom_label_bg_color']
	];
	var tooltips = [{
		target: '.header',
		text: 'Header',
		elementID: 'header_style',
		pos: 'center',
		type: 'section'
	}, {
		target: '.header .menu, .header .toggle-menu',
		text: 'Menu',
		elementID: 'nav_menus',
		pos: 'bottom',
		type: 'panel'
	}, {
		target: '.main-content .product-single .social-icons, .main-content .post-single .social-icons',
		text: 'Share',
		elementID: 'share',
		pos: 'bottom',
		type: 'section'
	}, {
		target: '.page-header',
		text: 'Page Title Bar',
		elementID: 'ptb_config',
		pos: 'bottom',
		type: 'section'
	}, {
		target: '.post-archive',
		text: 'Blog Archive',
		elementID: 'blog_archive',
		pos: 'top',
		type: 'section'
	}, {
		target: '.single .post-single',
		text: 'Single Post Page',
		elementID: 'blog_single',
		pos: 'top',
		type: 'section'
	}, {
		target: '.main-content > .products, .main-content > .yit-wcan-container > .products',
		text: 'Shop Page',
		elementID: 'woocommerce_product_catalog',
		pos: 'top',
		type: 'section'
	}, {
		target: '.single .product-single',
		text: 'Product Page',
		elementID: 'wc_single_product',
		pos: 'top',
		type: 'section'
	}, {
		target: '.products .product-wrap .product',
		text: 'Product Type',
		elementID: 'wc_product',
		pos: 'center',
		type: 'section'
	}, {
		target: '.products .category-wrap .product-category',
		text: 'Category Type',
		elementID: 'wc_category',
		pos: 'center',
		type: 'section'
	}, {
		target: '.footer',
		text: 'Footer',
		elementID: 'footer_general',
		pos: 'center',
		type: 'section'
	}, {
		target: '.footer .footer-top',
		text: 'Footer Top',
		elementID: 'footer_top',
		pos: 'top',
		type: 'section'
	}, {
		target: '.footer .footer-main',
		text: 'Footer Main',
		elementID: 'footer_main',
		pos: 'top',
		type: 'section'
	}, {
		target: '.footer .footer-bottom',
		text: 'Footer Bottom',
		elementID: 'footer_bottom',
		pos: 'top',
		type: 'section'
	}, {
		target: '#scroll-top',
		text: 'To Top',
		elementID: 'top_button_size',
		pos: 'top',
		type: 'control'
	}];

	// Add Selective Tooltips for footer widgets
	var count;
	count = getCustomize('ft_widgets').split('+').length;
	if (count > 1) {
		for (var i = 1; i <= count; i++) {
			tooltips.push({
				target: '.footer .footer-top>.row>[class*="col-"]:nth-child(' + i + ')',
				text: 'Footer Widget',
				elementID: 'sidebar-widgets-footer-top-widget-' + i,
				pos: 'center',
				type: 'section'
			});
		}
	}
	count = getCustomize('fm_widgets').split('+').length;
	if (count > 1) {
		for (var i = 1; i <= count; i++) {
			tooltips.push({
				target: '.footer .footer-main>.row>[class*="col-"]:nth-child(' + i + ')',
				text: 'Footer Widget',
				elementID: 'sidebar-widgets-footer-main-widget-' + i,
				pos: 'center',
				type: 'section'
			});
		}
	}
	count = getCustomize('fb_widgets').split('+').length;
	if (count > 1) {
		for (var i = 1; i <= count; i++) {
			tooltips.push({
				target: '.footer .footer-bottom>.row>[class*="col-"]:nth-child(' + i + ')',
				text: 'Footer Widget',
				elementID: 'sidebar-widgets-footer-bottom-widget-' + i,
				pos: 'center',
				type: 'section'
			});
		}
	}

	$.fn.riodeTooltip = function (options) {
		options.target = escape(options.target.replace(/"/g, ''));
		$('.riode-tooltip[data-target="' + options.target + '"]').remove();
		return $(this).each(function () {
			if ($(this).hasClass('riode-tooltip-initialized')) {
				return;
			}

			var $this = $(this),
				$tooltip = $('<div class="riode-tooltip" data-target="' + options.target + '" style="display: none; position: absolute; z-index: 9999;">' + options.text + '</div>').appendTo('body');
			$tooltip.data('triggerObj', $this);
			if (options.init) {
				$tooltip.data('initCall', options.init);
			}
			$this.on('mouseenter', function () {
				$tooltip.text(options.text);
				if (options.position == 'top') {
					$tooltip.css('top', $this.offset().top - $tooltip.outerHeight() / 2).css('left', $this.offset().left + $this.outerWidth() / 2 - $tooltip.outerWidth() / 2);
				} else if (options.position == 'bottom') {
					$tooltip.css('top', $this.offset().top + $this.outerHeight() - $tooltip.outerHeight() / 2).css('left', $this.offset().left + $this.outerWidth() / 2 - $tooltip.outerWidth() / 2);
				} else if (options.position == 'left') {
					$tooltip.css('top', $this.offset().top + $this.outerHeight() / 2 - $tooltip.outerHeight() / 2).css('left', $this.offset().left - $tooltip.outerWidth() / 2);
				} else if (options.position == 'right') {
					$tooltip.css('top', $this.offset().top + $this.outerHeight() / 2 - $tooltip.outerHeight() / 2).css('left', $this.offset().left + $this.outerWidth() - $tooltip.outerWidth() / 2);
				} else if (options.position == 'center') {
					$tooltip.css('top', $this.offset().top + $this.outerHeight() / 2 - $tooltip.outerHeight() / 2).css('left', $this.offset().left + $this.outerWidth() / 2 - $tooltip.outerWidth() / 2);
				}
				$tooltip.stop().fadeIn(100);
				$this.addClass('riode-tooltip-active');
			}).on('mouseleave', function () {
				$tooltip.stop(true, true).fadeOut(400);
				$this.removeClass('riode-tooltip-active');
			}).addClass('riode-tooltip-initialized');
		});
	}

	function initTooltipSection(e, $obj) {
		if (e.elementID && 'custom' != e.type) {
			if (!e.type) {
				e.type = 'section';
			}
			window.parent.wp.customize[e.type](e.elementID).focus();
			if (e.type == 'section' && window.parent.wp.customize[e.type](e.elementID).contentContainer) {
				window.parent.jQuery('body').trigger('initReduxFields', [window.parent.wp.customize[e.type](e.elementID).contentContainer]);
			} else if (e.type == 'control' && window.parent.wp.customize[e.type](e.elementID).container) {
				window.parent.jQuery('body').trigger('initReduxFields', [window.parent.wp.customize[e.type](e.elementID).container.closest('.control-section')]);
			}
		} else if ('custom' == e.type && e.elementID) {
			window.parent.wp.customize.section('riode_header_layouts').focus();
			var index = $(e.target, '.header-wrapper').index($obj),
				isMobile = $obj.closest('.visible-for-sm:visible').length ? true : false;
			$('.riode-header-builder .header-wrapper-' + (isMobile ? 'mobile' : 'desktop') + ' .header-builder-wrapper', window.parent.document).find('[data-id="' + e.elementID + '"]').eq(index).trigger('click');
		}
	}

	function initCustomizerTooltips($parent) {
		tooltips.forEach(function (e) {
			if ($(e.target).is($parent) || $parent.find($(e.target)).length) {
				e.type || (e.type = 'control');
				$(e.target).riodeTooltip({
					position: e.pos,
					text: e.text,
					target: e.target,
					init: function ($obj) {
						initTooltipSection(e, $obj);
					}
				});
			}
		});

		$(document.body).on('mouseenter', '.riode-tooltip', function () {
			$(this).stop(true, true).show();
			var obj = $(this).data('triggerObj');
			if (obj) {
				obj.addClass('riode-tooltip-active');
			}
		}).on('mouseleave', '.riode-tooltip', function () {
			$(this).stop().fadeOut(400);
			var obj = $(this).data('triggerObj');
			if (obj) {
				obj.removeClass('riode-tooltip-active');
			}
		}).on('click', '.riode-tooltip', function () {
			var initCall = $(this).data('initCall');
			if (initCall) {
				initCall.call(this, $(this).data('triggerObj'));
			}
		});
	}

	function initDynamicCSS() {
		var handles = ['riode-theme-shop', 'riode-theme-blog', 'riode-theme-shop-other', 'riode-theme-single-product', 'riode-theme-single-post'],
			h = 'riode-theme',
			style = '';

		handles.forEach(function (value, idx) {
			if ('riode-theme' != h) {
				return;
			}

			if ($('#' + value + '-inline-css').length) {
				h = value;
			}
		});

		style = $('#' + h + '-inline-css').text();

		var res_keys = style.matchAll(/\n(--rio-[^\: ]*)\:/g),
			res_values = style.matchAll(/\n--rio-[^\: ]*\: ([^\;]*)\;/g),
			keys = [],
			values = [],
			htmlStyle = $('html')[0].style;

		for (var key of res_keys) {
			keys.push(key[1]);
		}
		for (var value of res_values) {
			values.push(value[1]);
		}

		for (var i = 0; i < keys.length; i++) {
			htmlStyle.setProperty(keys[i], values[i]);
		}

		$('#' + h + '-inline-css').text('');
	}

	initCustomizerTooltips($('body'));
	initDynamicCSS();
	eventsInit();

	for (var i = 0; i < options.length; i++) {
		if (Array.isArray(options[i])) {
			var option = options[i];
		} else {
			var option = [options[i]];
		}

		for (var j = 0; j < option.length; j++) {
			wp.customize(option[j], function (e) {
				var event = option[0];
				e.bind(function (value) {
					$(document.body).trigger(event);
				});
			});
		}
	}

	function getCustomize(option) {
		var o = wp.customize(option);
		return o ? o.get() : '';
	}

	wp.customize.selectiveRefresh.bind('partial-content-rendered', function (placement) {
		if ('selective-single-related' == placement.partial.id) {
			Riode.owlCarousels($('.post-related .related-carousel'));
		}
		if ('selective-wc-shop' == placement.partial.id) {
			$(window).trigger('resize');
		}
		if ('selective-wc-product' == placement.partial.id) {
			Riode.owlCarousels();
		}

		initCustomizerTooltips($(placement.partial.params.selector));
	});

	function eventsInit() {
		var style = $('html')[0].style;

		$(document.body).on('container', function () {
			style.setProperty('--rio-container-width', getCustomize('container') + 'px');
			style.setProperty('--rio-container-width-max', getCustomize('container') - 1 + 'px');
		})
		$(document.body).on('container_fluid', function () {
			style.setProperty('--rio-container-fluid-width', getCustomize('container_fluid') + 'px');
			style.setProperty('--rio-container-fluid-width-max', getCustomize('container_fluid') - 1 + 'px');
		})
		$(document.body).on('gutter_lg', function () {
			style.setProperty('--rio-gutter-lg', (getCustomize('gutter_lg') / 2) + 'px');
		})
		$(document.body).on('gutter', function () {
			style.setProperty('--rio-gutter-md', (getCustomize('gutter') / 2) + 'px');
		})
		$(document.body).on('gutter_sm', function () {
			style.setProperty('--rio-gutter-sm', (getCustomize('gutter_sm') / 2) + 'px');
		})
		$(document.body).on('site_type', function () {
			var site_type = getCustomize('site_type');
			if ('full' != site_type) {
				riode_selective_background(style, 'site', getCustomize('screen_bg'));
				style.setProperty('--rio-site-width', getCustomize('site_width') + 'px');
				style.setProperty('--rio-site-margin', '0 auto');
				if ('boxed' == site_type) {
					style.setProperty('--rio-site-gap', '0 ' + getCustomize('site_gap') + 'px');
				} else {
					style.setProperty('--rio-site-gap', getCustomize('site_gap') + 'px');
				}
			} else {
				riode_selective_background(style, 'site', { 'background-color': '#fff' });
				style.setProperty('--rio-site-width', 'false');
				style.setProperty('--rio-site-margin', '0');
				style.setProperty('--rio-site-gap', '0');
			}

			riode_selective_background(style, 'page-wrapper', getCustomize('content_bg'));
		})
		$(document.body).on('primary_color', function () {
			style.setProperty('--rio-primary-color', getCustomize('primary_color'));
			style.setProperty('--rio-primary-color-hover', getLighten(getCustomize('primary_color')));
			style.setProperty('--rio-primary-color-op-80', getColorA(getCustomize('primary_color'), 0.8));
			style.setProperty('--rio-primary-color-op-90', getColorA(getCustomize('primary_color'), 0.9));
			style.setProperty('--rio-secondary-color', getCustomize('secondary_color'));
			style.setProperty('--rio-secondary-color-hover', getLighten(getCustomize('secondary_color')));
			style.setProperty('--rio-alert-color', getCustomize('alert_color'));
			style.setProperty('--rio-alert-color-hover', getLighten(getCustomize('alert_color')));
			style.setProperty('--rio-success-color', getCustomize('success_color'));
			style.setProperty('--rio-success-color-hover', getLighten(getCustomize('success_color')));
			style.setProperty('--rio-dark-color', getCustomize('dark_color'));
			style.setProperty('--rio-dark-color-hover', getLighten(getCustomize('dark_color')));
			style.setProperty('--rio-light-color', getCustomize('light_color'));
			style.setProperty('--rio-light-color-hover', getLighten(getCustomize('light_color')));
		})
		$(document.body).on('typo_default', function () {
			riode_selective_typography(style, 'body', getCustomize('typo_default'));
			style.setProperty('--rio-typo-ratio', getFontPixel(JSON.parse(getCustomize('typo_default'))['font-size']));
		})
		$(document.body).on('typo_heading', function () {
			riode_selective_typography(style, 'heading', getCustomize('typo_heading'));
		})
		$(document.body).on('ptb_bg', function () {
			riode_selective_background(style, 'ptb', getCustomize('ptb_bg'));
		})
		$(document.body).on('ptb_height', function () {
			style.setProperty('--rio-ptb-height', getCustomize('ptb_height') + 'px');
		})
		$(document.body).on('typo_ptb_title', function () {
			riode_selective_typography(style, 'ptb-title', getCustomize('typo_ptb_title'));
		})
		$(document.body).on('typo_ptb_subtitle', function () {
			riode_selective_typography(style, 'ptb-subtitle', getCustomize('typo_ptb_subtitle'));
		})
		$(document.body).on('typo_ptb_breadcrumb', function () {
			riode_selective_typography(style, 'ptb-breadcrumb', getCustomize('typo_ptb_breadcrumb'));
		})
		$(document.body).on('footer_skin', function () {
			var $footer_skin = getCustomize('footer_skin');

			style.removeProperty('--rio-footer-color');
			style.removeProperty('--rio-footer-bg-color');
			style.removeProperty('--rio-footer-bd-color');
			style.removeProperty('--rio-footer-link-color');
			style.removeProperty('--rio-footer-link-active-color');

			riode_selective_background(style, 'footer', getCustomize('footer_bg'));
			if (getCustomize('footer_link_color')) {
				style.setProperty('--rio-footer-link-color', getCustomize('footer_link_color'));
			} else {
				style.removeProperty('--rio-footer-link-color');
			}
			if (getCustomize('footer_active_color')) {
				style.setProperty('--rio-footer-link-active-color', getCustomize('footer_active_color'));
			}
			if (getCustomize('footer_bd_color')) {
				style.setProperty('--rio-footer-bd-color', getCustomize('footer_bd_color'));
			}
			riode_selective_typography(style, 'footer', getCustomize('typo_footer'));
			riode_selective_typography(style, 'footer-title', getCustomize('typo_footer_title'));
			riode_selective_typography(style, 'footer-widget', getCustomize('typo_footer_widget'));

			if ('dark' == $footer_skin) {
				if ('' == style.getPropertyValue('--rio-footer-color')) {
					style.setProperty('--rio-footer-color', 'var(--rio-body-color)');
				}
				if ('' == style.getPropertyValue('--rio-footer-bg-color')) {
					style.setProperty('--rio-footer-bg-color', 'var(--rio-dark-color)');
				}
				if ('' == style.getPropertyValue('--rio-footer-bd-color')) {
					style.setProperty('--rio-footer-bd-color', '#333');
				}
				if ('' == style.getPropertyValue('--rio-footer-link-color')) {
					style.setProperty('--rio-footer-link-color', '#999');
				}
				if ('' == style.getPropertyValue('--rio-footer-link-active-color')) {
					style.setProperty('--rio-footer-link-active-color', '#fff');
				}
			} else if ('light' == $footer_skin) {
				if ('' == style.getPropertyValue('--rio-footer-color')) {
					style.setProperty('--rio-footer-color', 'var(--rio-body-color)');
				}
				if ('' == style.getPropertyValue('--rio-footer-bg-color')) {
					style.setProperty('--rio-footer-bg-color', '#fff');
				}
				if ('' == style.getPropertyValue('--rio-footer-bd-color')) {
					style.setProperty('--rio-footer-bd-color', '#e1e1e1');
				}
				if ('' == style.getPropertyValue('--rio-footer-link-color')) {
					style.setProperty('--rio-footer-link-color', '#666');
				}
				if ('' == style.getPropertyValue('--rio-footer-link-active-color')) {
					style.setProperty('--rio-footer-link-active-color', 'var(--rio-primary-color)');
				}
			}
		})
		$(document.body).on('top_button_size', function () {
			style.setProperty('--rio-scroll-top-size', getCustomize('top_button_size'));
			if ('left' == getCustomize('top_button_pos')) {
				style.setProperty('--rio-scroll-top-left-position', '30px');
				style.setProperty('--rio-scroll-top-right-position', 'unset');
			} else {
				style.setProperty('--rio-scroll-top-left-position', 'unset');
				style.setProperty('--rio-scroll-top-right-position', '30px');
			}
		})
		$(document.body).on('ft_padding', function () {
			style.setProperty('--rio-footer-top-padding-top', getCustomize('ft_padding')['Padding-Top'] + 'px');
			style.setProperty('--rio-footer-top-padding-bottom', getCustomize('ft_padding')['Padding-Bottom'] + 'px');
			style.setProperty('--rio-footer-main-padding-top', getCustomize('fm_padding')['Padding-Top'] + 'px');
			style.setProperty('--rio-footer-main-padding-bottom', getCustomize('fm_padding')['Padding-Bottom'] + 'px');
			style.setProperty('--rio-footer-bottom-padding-top', getCustomize('fb_padding')['Padding-Top'] + 'px');
			style.setProperty('--rio-footer-bottom-padding-bottom', getCustomize('fb_padding')['Padding-Bottom'] + 'px');

			if (getCustomize('ft_divider')) {
				style.setProperty('--rio-footer-top-divider', '1px solid var(--rio-footer-bd-color)');
			} else {
				style.removeProperty('--rio-footer-top-divider');
			}

			if (getCustomize('fm_divider')) {
				style.setProperty('--rio-footer-main-divider', '1px solid var(--rio-footer-bd-color)');
			} else {
				style.removeProperty('--rio-footer-main-divider');
			}

			if (getCustomize('fb_divider')) {
				style.setProperty('--rio-footer-bottom-divider', '1px solid var(--rio-footer-bd-color)');
			} else {
				style.removeProperty('--rio-footer-bottom-divider');
			}
		})
		$(document.body).on('share_color', function () {
			style.setProperty('--rio-share-custom-color', getCustomize('share_color'));
		})
		$(document.body).on('typo_menu_skin1_ancestor', function () {
			var gap = getCustomize('skin1_ancestor_gap'),
				padding = getCustomize('skin1_ancestor_padding'),
				bg = getCustomize('skin1_anc_bg'),
				active_bg = getCustomize('skin1_anc_active_bg'),
				active_color = getCustomize('skin1_anc_active_color');

			style.setProperty('--rio-menu-skin1-ancestor-gap', gap + 'px');
			style.setProperty('--rio-menu-skin1-ancestor-padding', padding['Padding-Top'] + 'px ' + padding['Padding-Right'] + 'px ' + padding['Padding-Bottom'] + 'px ' + padding['Padding-Left'] + 'px');
			riode_selective_typography(style, 'menu-skin1-ancestor', getCustomize('typo_menu_skin1_ancestor'));
			if (bg) {
				style.setProperty('--rio-menu-skin1-ancestor-bg', bg);
			} else {
				style.removeProperty('--rio-menu-skin1-ancestor-bg');
			}
			if (active_bg) {
				style.setProperty('--rio-menu-skin1-ancestor-active-bg', active_bg);
			} else {
				style.removeProperty('--rio-menu-skin1-ancestor-active-bg');
			}
			if (active_color) {
				style.setProperty('--rio-menu-skin1-ancestor-active-color', active_color);
			} else {
				style.removeProperty('--rio-menu-skin1-ancestor-active-color');
			}
		})
		$(document.body).on('typo_menu_skin1_content', function () {
			var bg = getCustomize('skin1_con_bg'),
				active_bg = getCustomize('skin1_con_active_bg'),
				active_color = getCustomize('skin1_con_active_color');

			riode_selective_typography(style, 'menu-skin1-submenu', getCustomize('typo_menu_skin1_content'));
			if (bg) {
				style.setProperty('--rio-menu-skin1-submenu-bg', bg);
			} else {
				style.removeProperty('--rio-menu-skin1-submenu-bg');
			}
			if (active_bg) {
				style.setProperty('--rio-menu-skin1-submenu-active-bg', active_bg);
			} else {
				style.removeProperty('--rio-menu-skin1-submenu-active-bg');
			}
			if (active_color) {
				style.setProperty('--rio-menu-skin1-submenu-active-color', active_color);
			} else {
				style.removeProperty('--rio-menu-skin1-submenu-active-color');
			}
		})
		$(document.body).on('typo_menu_skin1_toggle', function () {
			var bg = getCustomize('skin1_tog_bg'),
				active_bg = getCustomize('skin1_tog_active_bg'),
				active_color = getCustomize('skin1_tog_active_color'),
				padding = getCustomize('skin1_toggle_padding');

			style.setProperty('--rio-menu-skin1-toggle-padding', padding['Padding-Top'] + 'px ' + padding['Padding-Right'] + 'px ' + padding['Padding-Bottom'] + 'px ' + padding['Padding-Left'] + 'px');
			riode_selective_typography(style, 'menu-skin1-toggle', getCustomize('typo_menu_skin1_toggle'));
			if (bg) {
				style.setProperty('--rio-menu-skin1-toggle-bg', bg);
			} else {
				style.removeProperty('--rio-menu-skin1-toggle-bg');
			}
			if (active_bg) {
				style.setProperty('--rio-menu-skin1-toggle-active-bg', active_bg);
			} else {
				style.removeProperty('--rio-menu-skin1-toggle-active-bg');
			}
			if (active_color) {
				style.setProperty('--rio-menu-skin1-toggle-active-color', active_color);
			} else {
				style.removeProperty('--rio-menu-skin1-toggle-active-color');
			}
		})
		$(document.body).on('typo_menu_skin2_ancestor', function () {
			var gap = getCustomize('skin2_ancestor_gap'),
				padding = getCustomize('skin2_ancestor_padding'),
				bg = getCustomize('skin2_anc_bg'),
				active_bg = getCustomize('skin2_anc_active_bg'),
				active_color = getCustomize('skin2_anc_active_color');

			style.setProperty('--rio-menu-skin2-ancestor-gap', gap + 'px');
			style.setProperty('--rio-menu-skin2-ancestor-padding', padding['Padding-Top'] + 'px ' + padding['Padding-Right'] + 'px ' + padding['Padding-Bottom'] + 'px ' + padding['Padding-Left'] + 'px');
			riode_selective_typography(style, 'menu-skin2-ancestor', getCustomize('typo_menu_skin2_ancestor'));
			if (bg) {
				style.setProperty('--rio-menu-skin2-ancestor-bg', bg);
			} else {
				style.removeProperty('--rio-menu-skin2-ancestor-bg');
			}
			if (active_bg) {
				style.setProperty('--rio-menu-skin2-ancestor-active-bg', active_bg);
			} else {
				style.removeProperty('--rio-menu-skin2-ancestor-active-bg');
			}
			if (active_color) {
				style.setProperty('--rio-menu-skin2-ancestor-active-color', active_color);
			} else {
				style.removeProperty('--rio-menu-skin2-ancestor-active-color');
			}
		})
		$(document.body).on('typo_menu_skin2_content', function () {
			var bg = getCustomize('skin2_con_bg'),
				active_bg = getCustomize('skin2_con_active_bg'),
				active_color = getCustomize('skin2_con_active_color');

			riode_selective_typography(style, 'menu-skin2-submenu', getCustomize('typo_menu_skin2_content'));
			if (bg) {
				style.setProperty('--rio-menu-skin2-submenu-bg', bg);
			} else {
				style.removeProperty('--rio-menu-skin2-submenu-bg');
			}
			if (active_bg) {
				style.setProperty('--rio-menu-skin2-submenu-active-bg', active_bg);
			} else {
				style.removeProperty('--rio-menu-skin2-submenu-active-bg');
			}
			if (active_color) {
				style.setProperty('--rio-menu-skin2-submenu-active-color', active_color);
			} else {
				style.removeProperty('--rio-menu-skin2-submenu-active-color');
			}
		})
		$(document.body).on('typo_menu_skin2_toggle', function () {
			var bg = getCustomize('skin2_tog_bg'),
				active_bg = getCustomize('skin2_tog_active_bg'),
				active_color = getCustomize('skin2_tog_active_color'),
				padding = getCustomize('skin2_toggle_padding');

			style.setProperty('--rio-menu-skin2-toggle-padding', padding['Padding-Top'] + 'px ' + padding['Padding-Right'] + 'px ' + padding['Padding-Bottom'] + 'px ' + padding['Padding-Left'] + 'px');
			riode_selective_typography(style, 'menu-skin2-toggle', getCustomize('typo_menu_skin2_toggle'));
			if (bg) {
				style.setProperty('--rio-menu-skin2-toggle-bg', bg);
			} else {
				style.removeProperty('--rio-menu-skin2-toggle-bg');
			}
			if (active_bg) {
				style.setProperty('--rio-menu-skin2-toggle-active-bg', active_bg);
			} else {
				style.removeProperty('--rio-menu-skin2-toggle-active-bg');
			}
			if (active_color) {
				style.setProperty('--rio-menu-skin2-toggle-active-color', active_color);
			} else {
				style.removeProperty('--rio-menu-skin2-toggle-active-color');
			}
		})
		$(document.body).on('typo_menu_skin3_ancestor', function () {
			var gap = getCustomize('skin3_ancestor_gap'),
				padding = getCustomize('skin3_ancestor_padding'),
				bg = getCustomize('skin3_anc_bg'),
				active_bg = getCustomize('skin3_anc_active_bg'),
				active_color = getCustomize('skin3_anc_active_color');

			style.setProperty('--rio-menu-skin3-ancestor-gap', gap + 'px');
			style.setProperty('--rio-menu-skin3-ancestor-padding', padding['Padding-Top'] + 'px ' + padding['Padding-Right'] + 'px ' + padding['Padding-Bottom'] + 'px ' + padding['Padding-Left'] + 'px');
			riode_selective_typography(style, 'menu-skin3-ancestor', getCustomize('typo_menu_skin3_ancestor'));
			if (bg) {
				style.setProperty('--rio-menu-skin3-ancestor-bg', bg);
			} else {
				style.removeProperty('--rio-menu-skin3-ancestor-bg');
			}
			if (active_bg) {
				style.setProperty('--rio-menu-skin3-ancestor-active-bg', active_bg);
			} else {
				style.removeProperty('--rio-menu-skin3-ancestor-active-bg');
			}
			if (active_color) {
				style.setProperty('--rio-menu-skin3-ancestor-active-color', active_color);
			} else {
				style.removeProperty('--rio-menu-skin3-ancestor-active-color');
			}
		})
		$(document.body).on('typo_menu_skin3_content', function () {
			var bg = getCustomize('skin3_con_bg'),
				active_bg = getCustomize('skin3_con_active_bg'),
				active_color = getCustomize('skin3_con_active_color');

			riode_selective_typography(style, 'menu-skin3-submenu', getCustomize('typo_menu_skin3_content'));
			if (bg) {
				style.setProperty('--rio-menu-skin3-submenu-bg', bg);
			} else {
				style.removeProperty('--rio-menu-skin3-submenu-bg');
			}
			if (active_bg) {
				style.setProperty('--rio-menu-skin3-submenu-active-bg', active_bg);
			} else {
				style.removeProperty('--rio-menu-skin3-submenu-active-bg');
			}
			if (active_color) {
				style.setProperty('--rio-menu-skin3-submenu-active-color', active_color);
			} else {
				style.removeProperty('--rio-menu-skin3-submenu-active-color');
			}
		})
		$(document.body).on('typo_menu_skin3_toggle', function () {
			var bg = getCustomize('skin3_tog_bg'),
				active_bg = getCustomize('skin3_tog_active_bg'),
				active_color = getCustomize('skin3_tog_active_color'),
				padding = getCustomize('skin3_toggle_padding');

			style.setProperty('--rio-menu-skin3-toggle-padding', padding['Padding-Top'] + 'px ' + padding['Padding-Right'] + 'px ' + padding['Padding-Bottom'] + 'px ' + padding['Padding-Left'] + 'px');
			riode_selective_typography(style, 'menu-skin3-toggle', getCustomize('typo_menu_skin3_toggle'));
			if (bg) {
				style.setProperty('--rio-menu-skin3-toggle-bg', bg);
			} else {
				style.removeProperty('--rio-menu-skin3-toggle-bg');
			}
			if (active_bg) {
				style.setProperty('--rio-menu-skin3-toggle-active-bg', active_bg);
			} else {
				style.removeProperty('--rio-menu-skin3-toggle-active-bg');
			}
			if (active_color) {
				style.setProperty('--rio-menu-skin3-toggle-active-color', active_color);
			} else {
				style.removeProperty('--rio-menu-skin3-toggle-active-color');
			}
		})
		$(document.body).on('custom_css', function () {
			if (!$('style#riode-preview-custom-inline-css').length) {
				$('<style id="riode-preview-custom-inline-css"></style>').insertAfter('#riode-preview-custom-css');
			}

			$('style#riode-preview-custom-inline-css').html(getCustomize('custom_css'));
		})
		$(document.body).on('social_color', function () {
			style.setProperty('--rio-social-custom-color', getCustomize('social_color'));
		})
		$(document.body).on('header_bg', function () {
			riode_selective_background(style, 'header', getCustomize('header_bg'));
			riode_selective_typography(style, 'header', getCustomize('typo_header'));
			style.setProperty('--rio-header-link-active-color', getCustomize('header_active_color'));
		})
		$(document.body).on('product_top_label_bg_color', function () {
			style.setProperty('--rio-product-top-label-color', getCustomize('product_top_label_bg_color'));
			style.setProperty('--rio-product-sale-label-color', getCustomize('product_sale_label_bg_color'));
			style.setProperty('--rio-product-stock-label-color', getCustomize('product_stock_label_bg_color'));
			style.setProperty('--rio-product-new-label-color', getCustomize('product_new_label_bg_color'));
		})
	}

	function riode_selective_background(style, id, bg) {
		if (bg['background-color']) {
			style.setProperty('--rio-' + id + '-bg-color', bg['background-color']);
		} else {
			style.removeProperty('--rio-' + id + '-bg-color');
		}

		if (bg['background-image']) {
			style.setProperty('--rio-' + id + '-bg-image', 'url(' + bg['background-image'] + ')');

			if (bg['background-repeat']) {
				style.setProperty('--rio-' + id + '-bg-repeat', bg['background-repeat']);
			}
			if (bg['background-position']) {
				style.setProperty('--rio-' + id + '-bg-position', bg['background-position']);
			}
			if (bg['background-size']) {
				style.setProperty('--rio-' + id + '-bg-size', bg['background-size']);
			}
			if (bg['background-attachment']) {
				style.setProperty('--rio-' + id + '-bg-attachment', bg['background-attachment']);
			}
		} else {
			style.removeProperty('--rio-' + id + '-bg-image');
			style.removeProperty('--rio-' + id + '-bg-repeat');
			style.removeProperty('--rio-' + id + '-bg-position');
			style.removeProperty('--rio-' + id + '-bg-size');
			style.removeProperty('--rio-' + id + '-bg-attachment');
		}
	}

	function riode_selective_typography(style, id, typo) {
		if (typo['font-family'] && 'inherit' != typo['font-family']) {
			style.setProperty('--rio-' + id + '-font-family', "'" + typo['font-family'] + "', sans-serif");

			if (!typo['variant']) {
				typo['variant'] = 400;
			}
		} else {
			style.removeProperty('--rio-' + id + '-font-family');
		}
		if (typo['variant']) {
			style.setProperty('--rio-' + id + '-font-weight', 'regular' == typo['variant'] ? 400 : typo['variant']);
		} else if ('heading' == id) {
			style.setProperty('--rio-' + id + '-font-weight', 600);
		} else {
			style.removeProperty('--rio-' + id + '-font-weight');
		}
		if (typo['font-size'] && '' != typo['font-size']) {
			style.setProperty('--rio-' + id + '-font-size', (Number(typo['font-size']) ? (typo['font-size'] + 'px') : typo['font-size']));
		} else {
			style.removeProperty('--rio-' + id + '-font-size');
		}
		if (typo['line-height'] && '' != typo['line-height']) {
			style.setProperty('--rio-' + id + '-line-height', typo['line-height']);
		} else {
			style.removeProperty('--rio-' + id + '-line-height');
		}
		if (typo['letter-spacing'] && '' != typo['letter-spacing']) {
			style.setProperty('--rio-' + id + '-letter-spacing', typo['letter-spacing']);
		} else {
			style.removeProperty('--rio-' + id + '-letter-spacing');
		}
		if (typo['text-transform'] && '' != typo['text-transform']) {
			style.setProperty('--rio-' + id + '-text-transform', typo['text-transform']);
		} else {
			style.removeProperty('--rio-' + id + '-text-transform');
		}
		if (typo['color'] && '' != typo['color']) {
			style.setProperty('--rio-' + id + '-color', typo['color']);
		} else {
			style.removeProperty('--rio-' + id + '-color');
		}
	}

	function getHSL(color) {
		color = Number.parseInt(color.slice(1), 16);
		var $blue = color % 256;
		color /= 256;
		var $green = color % 256;
		var $red = color = color / 256;

		var $min = Math.min($red, $green, $blue);
		var $max = Math.max($red, $green, $blue);

		var $l = $min + $max;
		var $d = Number($max - $min);
		var $h = 0;
		var $s = 0;

		if ($d) {
			if ($l < 255) {
				$s = $d / $l;
			} else {
				$s = $d / (510 - $l);
			}

			if ($red == $max) {
				$h = 60 * ($green - $blue) / $d;
			} else if ($green == $max) {
				$h = 60 * ($blue - $red) / $d + 120;
			} else if ($blue == $max) {
				$h = 60 * ($red - $green) / $d + 240;
			}
		}

		return [($h + 360) % 360, ($s * 100), ($l / 5.1 + 7)];
	}

	function getLighten(color) {
		var hsl = getHSL(color);
		return 'hsl(' + hsl[0] + ', ' + hsl[1] + '%, ' + hsl[2] + '%)';
	}

	function getColorA(color, opacity) {
		var hsl = getHSL(color);
		return 'hsl(' + hsl[0] + ', ' + hsl[1] + '%, ' + hsl[2] + '%, ' + opacity + ')';
	}

	function getFontPixel(value) {
		var val = Number(value);
		if (value.slice(-2) == 'px') {
			val = Number(value.slice(0, -2));
		} else if (value.slice(-3) == 'rem') {
			val = Number(value.slice(0, -3)) * 10;
		}

		return val / 14;
	}
})