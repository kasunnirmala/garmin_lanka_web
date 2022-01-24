/**
 * Riode Plugin - Riode Elementor Preview
 */
'use strict';

(function ($) {
    function get_creative_class($grid_item) {
        var ex_class = '';
        if (undefined != $grid_item) {
            ex_class = 'grid-item ';
            Object.entries($grid_item).forEach(function (item) {
                if (item[1]) {
                    ex_class += item[0] + '-' + item[1] + ' ';
                }
            })
        }
        return ex_class;
    }

    function gcd($a, $b) {
        while ($b) {
            var $r = $a % $b;
            $a = $b;
            $b = $r;
        }
        return $a;
    }

    function get_creative_grid_item_css($id, $layout, $height, $height_ratio) {
        if ('undefined' == typeof $layout) {
            return;
        }
        var $height_ary = ['h-1', 'h-1-2', 'h-1-3', 'h-2-3', 'h-1-4', 'h-3-4'];
        var $deno = [];
        var $numer = [];
        var $style = '';
        var $ws = { 'w': [], 'w-l': [], 'w-m': [], 'w-s': [] };
        var $hs = { 'h': [], 'h-l': [], 'h-m': [] };

        $style += '<style scope="">';
        $layout.map(function ($grid_item) {
            Object.entries($grid_item).forEach(function ($info) {
                if ('size' == $info[0]) {
                    return;
                }

                var $num = $info[1].split('-');
                if (undefined != $num[1] && -1 == $deno.indexOf($num[1])) {
                    $deno.push($num[1]);
                }
                if (-1 == $numer.indexOf($num[0])) {
                    $numer.push($num[0]);
                }

                if (('w' == $info[0] || 'w-l' == $info[0] || 'w-m' == $info[0] || 'w-s' == $info[0]) && -1 == $ws[$info[0]].indexOf($info[1])) {
                    $ws[$info[0]].push($info[1]);
                } else if (('h' == $info[0] || 'h-l' == $info[0] || 'h-m' == $info[0]) && -1 == $hs[$info[0]].indexOf($info[1])) {
                    $hs[$info[0]].push($info[1]);
                }
            });
        });
        Object.entries($ws).forEach(function ($w) {
            if (!$w[1].length) {
                return;
            }

            if ('w-l' == $w[0]) {
                $style += '@media (max-width: 991px) {';
            } else if ('w-m' == $w[0]) {
                $style += '@media (max-width: 767px) {';
            } else if ('w-s' == $w[0]) {
                $style += '@media (max-width: 575px) {';
            }

            $w[1].map(function ($item) {
                var $opts = $item.split('-');
                var $width = (undefined == $opts[1] ? 100 : (100 * $opts[0] / $opts[1]).toFixed(4));
                $style += '.elementor-element-' + $id + ' .grid-item.' + $w[0] + '-' + $item + '{flex:0 0 ' + $width + '%;width:' + $width + '%}';
            })

            if ('w-l' == $w[0] || 'w-m' == $w[0] || 'w-s' == $w[0]) {
                $style += '}';
            }
        });
        Object.entries($hs).forEach(function ($h) {
            if (!$h[1].length) {
                return;
            }

            $h[1].map(function ($item) {
                var $opts = $item.split('-'), $value;
                if (undefined != $opts[1]) {
                    $value = $height * $opts[0] / $opts[1];
                } else {
                    $value = $height;
                }
                if ('h' == $h[0]) {
                    $style += '.elementor-element-' + $id + ' .h-' + $item + '{height:' + $value.toFixed(2) + 'px}';
                    $style += '@media (max-width: 767px) {';
                    $style += '.elementor-element-' + $id + ' .h-' + $item + '{height:' + ($value * $height_ratio / 100).toFixed(2) + 'px}';
                    $style += '}';
                } else if ('h-l' == $h[0]) {
                    $style += '@media (max-width: 991px) {';
                    $style += '.elementor-element-' + $id + ' .h-l-' + $item + '{height:' + $value.toFixed(2) + 'px}';
                    $style += '}';
                    $style += '@media (max-width: 767px) {';
                    $style += '.elementor-element-' + $id + ' .h-l-' + $item + '{height:' + ($value * $height_ratio / 100).toFixed(2) + 'px}';
                    $style += '}';
                } else if ('h-m' == $h[0]) {
                    $style += '@media (max-width: 767px) {';
                    $style += '.elementor-element-' + $id + ' .h-m-' + $item + '{height:' + ($value * $height_ratio / 100).toFixed(2) + 'px}';
                    $style += '}';
                }
            })
        });
        var $lcm = 1;
        $deno.map(function ($value) {
            $lcm = $lcm * $value / gcd($lcm, $value);
        });
        var $gcd = $numer[0];
        $numer.map(function ($value) {
            $gcd = gcd($gcd, $value);
        });
        var $sizer = Math.floor(100 * $gcd / $lcm * 10000) / 10000;
        $style += '.elementor-element-' + $id + ' .grid' + '>.grid-space{flex: 0 0 ' + ($sizer < 0.01 ? 100 : $sizer) + '%;width:' + ($sizer < 0.01 ? 100 : $sizer) + '%}';
        $style += '</style>';
        return $style;
    }

    function initSlider($el) {
        var $customDots = '';
        if ($el.data('owl.carousel')) {
            if ($el.siblings('.slider-thumb-dots').length) {
                $customDots = $el.siblings('.slider-thumb-dots')[0].outerHTML;
            }
        }
        $el.data('owl.carousel') && $el.owlCarousel('destroy');
        $el.children('.owl-item').remove();
        Riode.slider($el);
    }

    var RiodeElementorPreview = {
        completed: false,
        fnArray: [],
        init: function () {
            var self = this;

            $('body').on('click', 'a', function (e) {
                e.preventDefault();
            })

            elementorFrontend.hooks.addAction('frontend/element_ready/column', function ($obj) {
                self.completed ? self.initColumn($obj) : self.fnArray.push({
                    fn: self.initColumn,
                    arg: $obj
                });
            });
            elementorFrontend.hooks.addAction('frontend/element_ready/section', function ($obj) {
                self.completed ? self.initSection($obj) : self.fnArray.push({
                    fn: self.initSection,
                    arg: $obj
                });
            });
            elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($obj) {
                self.completed ? self.initWidgetAddon($obj) : self.fnArray.push({
                    fn: self.initWidgetAddon,
                    arg: $obj
                });
            });

            elementorFrontend.hooks.addAction('refresh_page_css', function (css) {
                var $obj = $('style#riode_elementor_custom_css');
                if (!$obj.length) {
                    $obj = $('<style id="riode_elementor_custom_css"></style>').appendTo('head');
                }
                css = css.replace('/<script.*?\/script>/s', '');
                $obj.html(css).appendTo('head');
            });

            elementorFrontend.hooks.addAction('refresh_edit_area', function (width) {
                var $style = $('style#riode-edit-area-style');
                if (!$style.length) {
                    $('.elementor-edit-area').before('<style id="riode-edit-area-style"></style');
                    $style = $('style#riode-edit-area-style');
                }

                if ('' == width) {
                    $style.html('');
                } else {
                    $style.html('.elementor-edit-area > .elementor-section-wrap { max-width: calc(var(--rio-container-width) - 40px); margin: 0 auto; } .elementor-section-wrap > .elementor-section { max-width: ' + width + '; }');
                }
            });

            elementorFrontend.hooks.addAction('refresh_popup_options', function (option, value) {
                if ('popup_width' == option) {
                    $('.popup-container').css('max-width', value + 'px');
                }
                if ('popup_pos_origin' == option) {
                    $('.popup-container').removeClass('t-m t-mc t-c t-none').addClass(value);
                }
                if ('popup_pos_left' == option) {
                    $('.popup-container').css('left', value);
                }
                if ('popup_pos_top' == option) {
                    $('.popup-container').css('top', value);
                }
                if ('popup_pos_right' == option) {
                    $('.popup-container').css('right', value);
                }
                if ('popup_pos_bottom' == option) {
                    $('.popup-container').css('bottom', value);
                }
            });

            // redefine elementor js function to call function when 'custom SVG' option is changed for custom shape divider
            if (typeof elementorFrontend.elementsHandler.elementsHandlers.section[4] == 'function' && elementorFrontend.elementsHandler.elementsHandlers.section[4].prototype.buildSVG) {
                elementorFrontend.elementsHandler.elementsHandlers.section[4].prototype.onElementChange = function (propertyName) {
                    if (propertyName.match(/^shape_divider_(top|bottom)_custom$/)) {
                        this.buildSVG(propertyName.match(/^shape_divider_(top|bottom)_custom$/)[1]);
                        return;
                    }
                    var shapeChange = propertyName.match(/^shape_divider_(top|bottom)$/);
                    if (shapeChange) {
                        this.buildSVG(shapeChange[1]);
                        return;
                    }
                    var negativeChange = propertyName.match(/^shape_divider_(top|bottom)_negative$/);
                    if (negativeChange) {
                        this.buildSVG(negativeChange[1]);
                        this.setNegative(negativeChange[1]);
                    }
                }
                elementorFrontend.elementsHandler.elementsHandlers.section[4].prototype.buildSVG = function buildSVG(side) {
                    var baseSettingKey = 'shape_divider_' + side,
                        shapeType = this.getElementSettings(baseSettingKey),
                        $svgContainer = this.elements['$' + side + 'Container'];
                    $svgContainer.attr('data-shape', shapeType);

                    if (!shapeType) {
                        $svgContainer.empty(); // Shape-divider set to 'none'

                        return;
                    }

                    var fileName = shapeType;

                    if (this.getElementSettings(baseSettingKey + '_negative')) {
                        fileName += '-negative';
                    }

                    var svgURL = this.getSvgURL(shapeType, fileName);
                    if (shapeType != 'custom') {
                        jQuery.get(svgURL, function (data) {
                            $svgContainer.empty().append(data.childNodes[0]);
                        });
                    } else {
                        this.elements['$' + side + 'Container'].attr('data-negative', 'false');
                        var data = this.getElementSettings(baseSettingKey + '_custom');
                        var svgManager = elementor.helpers;
                        data = data.value;
                        if (!data.id) {
                            $svgContainer.empty();
                            return;
                        }

                        if (svgManager._inlineSvg.hasOwnProperty(data.id)) {
                            data && $svgContainer.empty().html(svgManager._inlineSvg[data.id]);
                            return;
                        }
                        svgManager.fetchInlineSvg(data.url, function (svgData) {
                            if (svgData) {
                                svgManager._inlineSvg[data.id] = svgData; //$( data ).find( 'svg' )[ 0 ].outerHTML;
                                svgData && $svgContainer.empty().html(svgData);
                                elementor.channels.editor.trigger('svg:insertion', svgData, data.id);
                            }
                        });
                    }
                    this.setNegative(side);
                }
            }
        },
        onComplete: function () {
            var self = this;
            self.completed = true;

            $('.riode-block[data-el-class]').each(function () {
                var $this = $(this);
                setTimeout(function () {
                    $this.addClass($this.attr('data-el-class')).removeAttr('data-el-class');
                }, 1000);
            });

            self.initWidgets();
            self.initGlobal();
            self.fnArray.forEach(function (obj) {
                if (typeof obj == 'function') {
                    obj.call();
                } else if (typeof obj == 'object') {
                    obj.fn.call(self, obj.arg);
                }
            });
        },
        initWidgets: function () {
            var riode_widgets = [
                'riode_widget_products.default',
                'riode_widget_categories.default',
                'riode_widget_posts.default',
                'riode_widget_imageslider.default',
                'riode_widget_single_product.default',
                'riode_sproduct_linked_products.default',
                'riode_sproduct_image.default',
                'riode_widget_products_tab.default',
                'riode_widget_products_single.default',
                'riode_widget_products_banner.default',
            ];


            // Widgets for posts
            riode_widgets.forEach(function (widget_name) {
                elementorFrontend.hooks.addAction('frontend/element_ready/' + widget_name, function ($obj) {
                    initSlider($obj.find('.owl-carousel'));
                    Riode.isotopes($obj.find('.grid'));
                });
            });

            // Widget for vendors
            elementorFrontend.hooks.addAction('frontend/element_ready/riode_widget_vendors.default', function ($obj) {
                initSlider($obj.find('.owl-carousel'));
            });

            // Widget for Testimonial
            elementorFrontend.hooks.addAction('frontend/element_ready/riode_widget_testimonial_group.default', function ($obj) {
                initSlider($obj.find('.owl-carousel'));
            });

            // Widget for countdown
            elementorFrontend.hooks.addAction('frontend/element_ready/riode_widget_countdown.default', function ($obj) {
                Riode.countdown($obj.find('.countdown'));
            });

            // Widget for SVG floating
            elementorFrontend.hooks.addAction('frontend/element_ready/riode_widget_floating.default', function ($obj) {
                Riode.floatSVG($obj.find('.float-svg'));
            });

            // Widget for 360 degree
            elementorFrontend.hooks.addAction('frontend/element_ready/riode_widget_360_degree.default', function ($obj) {
                Riode.degree360($obj.find('.riode-360-gallery-wrapper'));
            });

            elementorFrontend.hooks.addAction('frontend/element_ready/riode_sproduct_counter.default', function ($obj) {
                var $counterNumber = $obj.find('.elementor-counter-number');
                elementorFrontend.waypoint($counterNumber, function () {
                    var data = $counterNumber.data(),
                        decimalDigits = data.toValue.toString().match(/\.(.*)/);

                    if (decimalDigits) {
                        data.rounding = decimalDigits[1].length;
                    }

                    $counterNumber.numerator(data);
                });
            });

            // Single Product Image Widget Issue
            elementorFrontend.hooks.addAction('frontend/element_ready/riode_sproduct_image.default', function ($obj) {
                $obj.addClass('elementor-widget-theme-post-content');
            });

            elementorFrontend.hooks.addAction('frontend/element_ready/riode_widget_single_product.default', function ($obj) {
                $obj.addClass('elementor-widget-theme-post-content');
            });

            // Widget for banner
            elementorFrontend.hooks.addAction('frontend/element_ready/riode_widget_banner.default', function ($obj) {
                Riode.parallax($obj.find('.parallax'));
                Riode.appearAnimate('.appear-animate');
                jQuery(window).trigger('appear.check');

                $obj.find('.banner-item').each(function () {
                    var settings = $(this).data('floating');
                    if ('object' != typeof settings) {
                        if ($(this).children('.floating-wrapper').length) {
                            var $wrapper = $(this).children('.floating-wrapper');

                            if ($wrapper.data('plugin') == 'floating') {
                                if ($.fn.parallax) {
                                    Riode.initFloatingElements($wrapper);
                                } else {
                                    if (riode_elementor_vars.theme_assets_url) {
                                        $(document.createElement('script')).attr('id', 'jquery-floating').appendTo('body').attr('src', riode_elementor_vars.theme_assets_url + '/vendor/jquery.floating/jquery.floating.min.js').on('load', function () {
                                            Riode.initFloatingElements($wrapper);
                                        });
                                    }
                                }
                            } else if ($wrapper.data('plugin') == 'skrollr') {
                                if (typeof skrollr != 'object') {
                                    if (riode_elementor_vars.theme_assets_url) {
                                        $(document.createElement('script')).attr('id', 'skrollr').appendTo('body').attr('src', riode_elementor_vars.theme_assets_url + '/vendor/skrollr/skrollr.min.js').on('load', function () {
                                            Riode.initSkrollrElements();
                                        });
                                    }
                                }
                                if (typeof skrollr == 'object' && typeof skrollr.init == 'function') {
                                    Riode.initSkrollrElements();
                                }
                            }

                            return;
                        }
                        if ('object' != typeof settings) {
                            settings = {};
                        }
                    }
                    if (settings.floating) {
                        if (0 == settings.floating.indexOf('mouse_tracking')) {
                            $(this).children().wrap('<div class="layer"></div>');
                        }

                        $(this).children().wrap('<div class="floating-wrapper layer-wrapper elementor-repeater-item-wrapper"></div>');

                        RiodeElementorPreview.initWidgetAddon($(this).children('.floating-wrapper'), settings); // floating effect
                    }
                });
            });

            // Menu Widget
            elementorFrontend.hooks.addAction('frontend/element_ready/riode_widget_menu.default', function ($obj) {
                Riode.menu.initMenu('.elementor-element-' + $obj.attr('data-id'));
                Riode.menu.initToggleDropdownMenu('.elementor-element-' + $obj.attr('data-id'));
            });
        },
        initSection: function ($obj) {
            var $container = $obj.children('.elementor-container'),
                $row = 0 == $obj.find('.elementor-row').length ? $container : $container.children('.elementor-row');
            $obj.removeData('__parallax');

            this.initWidgetAddon($obj); // floating effect

            if ('parallax' == $row.data('class')) {
                $obj.addClass('background-none');
                $obj.addClass('parallax')
                    .attr('data-plugin', 'parallax')
                    .attr('data-image-src', $row.data('image-src'))
                    .attr('data-parallax-options', JSON.stringify($row.data('parallax-options')));
                Riode.parallax($obj);
            } else {
                $obj.removeClass('parallax');
                $obj.removeClass('background-none');
            }

            if ($row.hasClass('banner-fixed') && $row.hasClass('banner') && 'use_background' != $row.data('class')) {
                $obj.css('background', 'none');
            } else {
                $obj.css('background', '');
            }

            if ($row.hasClass('grid')) {
                $row.append('<div class="grid-space"></div>');
                Object.setPrototypeOf($row.get(0), HTMLElement.prototype);
                var timer = setTimeout(function () {
                    elementorFrontend.hooks.doAction('refresh_isotope_layout', timer, $row, true);
                });
            } else {
                $row.siblings('style').remove();
                $row.children('.grid-space').remove();
                $row.data('isotope') && $row.isotope('destroy');
            }

            // Slider 
            if ($row.hasClass('owl-carousel')) {
                if ($row.siblings('.slider-thumb-dots').length) {
                    $row.parent().addClass('flex-wrap');
                }
                if ($row.data('owl.carousel')) {
                    $row.trigger('refresh.owl.carousel');
                } else {
                    initSlider($row);
                }
            }

            // Accordion
            if ($row.hasClass('accordion')) {
                setTimeout(function () {
                    var $card = $row.children('.card').eq(0);
                    $card.find('.card-header a').toggleClass('collapse').toggleClass('expand');
                    $card.find('.card-body').toggleClass('collapsed').toggleClass('expanded');
                    $card.find('.card-header a').trigger('click');
                }, 300);
            }
        },
        initColumn: function ($obj) {
            var $row = 0 == $obj.closest('.elementor-row').length ? $obj.closest('.elementor-container') : $obj.closest('.elementor-row'),
                $column = $obj.children('.elementor-column-wrap'),
                $wrapper = 0 == $obj.closest('.elementor-row').length ? $row : $row.parent(),
                $classes = [];

            $column = 0 === $column.length ? $obj.children('.elementor-widget-wrap') : $column;

            this.initWidgetAddon($obj); // floating effect

            if ($column.hasClass('owl-carousel') && $column.siblings('.slider-thumb-dots').length) {
                $column.parent().addClass('flex-wrap');
            }

            if ($column.attr('data-css-classes')) {
                $classes = $column.attr('data-css-classes').split(' ');
            }

            if ($row.hasClass('grid')) { // Refresh isotope
                if (!$row.data('creative-preset')) {
                    $.ajax({
                        url: riode_elementor_vars.ajax_url,
                        data: {
                            action: 'riode_load_creative_layout',
                            nonce: riode_elementor_vars.wpnonce,
                            mode: $row.data('creative-mode'),
                        },
                        type: 'post',
                        async: false,
                        success: function (res) {
                            if (res) {
                                $row.data('creative-preset', res);
                            }
                        }
                    });
                }
                // Remove existing layout classes
                var cls = $obj.attr('class');
                cls = cls.slice(0, cls.indexOf("grid-item")) + cls.slice(cls.indexOf("size-"));
                $obj.attr('class', cls);
                $obj.removeClass('size-small size-medium size-large e');

                var preset = JSON.parse($row.data('creative-preset'));
                var item_data = $column.data('creative-item');
                var grid_item = {};

                if (undefined == preset[$obj.index()]) {
                    grid_item = { 'w': '1-4', 'w-l': '1-2', 'h': '1-3' };
                } else {
                    grid_item = preset[$obj.index()];
                }

                if (undefined != item_data['w']) {
                    grid_item['w'] = grid_item['w-l'] = grid_item['w-m'] = grid_item['w-s'] = item_data['w'];
                }
                if (undefined != item_data['w-l']) {
                    grid_item['w-l'] = grid_item['w-m'] = grid_item['w-s'] = item_data['w-l'];
                }
                if (undefined != item_data['w-m']) {
                    grid_item['w-m'] = grid_item['w-s'] = item_data['w-m'];
                }
                if (undefined != item_data['h'] && 'preset' != item_data['h']) {
                    if ('child' == item_data['h']) {
                        grid_item['h'] = '';
                    } else {
                        grid_item['h'] = item_data['h'];
                    }
                }
                if (undefined != item_data['h-l'] && 'preset' != item_data['h-l']) {
                    if ('child' == item_data['h-l']) {
                        grid_item['h-l'] = '';
                    } else {
                        grid_item['h-l'] = item_data['h-l'];
                    }
                }
                if (undefined != item_data['h-m'] && 'preset' != item_data['h-m']) {
                    if ('child' == item_data['h-m']) {
                        grid_item['h-m'] = '';
                    } else {
                        grid_item['h-m'] = item_data['h-m'];
                    }
                }

                var style = '<style>';
                Object.entries(grid_item).forEach(function (item) {
                    if ('h' == item[0] || 'size' == item[0] || !Number(item[1])) {
                        return;
                    }
                    if (100 % item[1] == 0) {
                        if (1 == item[1]) {
                            grid_item[item[0]] = '1';
                        } else {
                            grid_item[item[0]] = '1-' + (100 / item[1]);
                        }
                    } else {
                        for (var i = 1; i <= 100; ++i) {
                            var val = item[1] * i;
                            var val_round = Math.round(val);
                            if (Math.abs(Math.ceil((val - val_round) * 100) / 100) <= 0.01) {
                                var g = gcd(100, val_round);
                                var numer = val_round / g;
                                var deno = i * 100 / g;
                                grid_item[item[0]] = numer + '-' + deno;

                                // For Smooth Resizing of Isotope Layout
                                if ('w-l' == item[0]) {
                                    style += '@media (max-width: 991px) {';
                                } else if ('w-m' == item[0]) {
                                    style += '@media (max-width: 767px) {';
                                }

                                style += '.elementor-element-' + $row.closest('.elementor-section').attr('data-id') + ' .grid-item.' + item[0] + '-' + numer + '-' + deno + '{flex:0 0 ' + (numer * 100 / deno).toFixed(4) + '%;width:' + (numer * 100 / deno).toFixed(4) + '%}';

                                if ('w-l' == item[0] || 'w-m' == item[0]) {
                                    style += '}';
                                }
                                break;
                            }
                        }

                    }
                })
                style += '</style>';
                $row.before(style);

                $obj.addClass(get_creative_class(grid_item));

                // Set Order Data
                $obj.attr('data-creative-order', (undefined == $column.attr('data-creative-order') ? $obj.index() + 1 : $column.attr('data-creative-order')));
                $obj.attr('data-creative-order-lg', (undefined == $column.attr('data-creative-order-lg') ? $obj.index() + 1 : $column.attr('data-creative-order-lg')));
                $obj.attr('data-creative-order-md', (undefined == $column.attr('data-creative-order-md') ? $obj.index() + 1 : $column.attr('data-creative-order-md')));

                var layout = $row.data('creative-layout');
                if (!layout) {
                    layout = [];
                }
                layout[$obj.index()] = grid_item;
                $row.data('creative-layout', layout);
                $row.find('.grid-space').appendTo($row);
                Object.setPrototypeOf($obj.get(0), HTMLElement.prototype);
                var timer = setTimeout(function () {
                    elementorFrontend.hooks.doAction('refresh_isotope_layout', timer, $row);
                }, 300);
            }

            if (0 < $obj.find('.owl-carousel').length) {
                $obj.find('.elementor-widget-wrap > .elementor-background-overlay').remove();
            }
            this.completed && initSlider($obj.find('.owl-carousel')); // issue
            if ($row.hasClass('owl-carousel')) { // Slider
                initSlider($row);
            } else if ($wrapper.hasClass('tab')) { // Tab
                var title = $column.data('tab-title'),
                    icon = $column.data('tab-icon'),
                    icon_pos = $column.data('tab-icon-pos'),
                    content = $wrapper.find('.tab-content'),
                    html = '';

                if ($column.data('role') != 'tab-pane') {
                    return;
                }

                if (!$obj.parent().hasClass('tab-content')) {
                    content.append($obj);
                }
                if (icon && ('up' == icon_pos || 'left' == icon_pos)) {
                    html += '<i class="' + icon + '"></i>';
                }
                html += title;
                if (!title && !icon) {
                    html += 'Tab Title';
                }
                if (icon && ('down' == icon_pos || 'right' == icon_pos)) {
                    html += '<i class="' + icon + '"></i>';
                }
                $obj.addClass('tab-pane');
                $obj.attr('id', $obj.data('id'));
                var $links = $wrapper.children('ul.nav');
                if ($links.find('[pane-id="' + $obj.data('id') + '"]').length) {
                    var $nav = $links.find('[pane-id="' + $obj.data('id') + '"]');
                    $nav.removeClass('nav-icon-left nav-icon-right nav-icon-up nav-icon-down').addClass('nav-icon-' + icon_pos);
                    $nav.find('a').html(html);
                } else {
                    $links.append('<li class="nav-item ' + (icon ? 'nav-icon-' + icon_pos : '') + '" pane-id="' + $obj.data('id') + '"><a class="nav-link" data-toggle="tab" href="' + $obj.data('id') + '">' + html + '</a></li>');
                }
                var $first = $wrapper.find('ul.nav > li:first-child > a');
                if (!$first.hasClass('active') && 0 == $wrapper.find('ul.nav .active').length) {
                    $first.addClass('active');
                    $first.closest('ul.nav').next('.tab-content').find('.tab-pane:first-child').addClass('active');
                }
            } else if ($row.hasClass('accordion')) { // Accordion
                $obj.addClass('card');
                var $header = $obj.children('.card-header'),
                    $body = $obj.children('.card-body');

                $body.attr('id', $obj.data('id'));

                var title = $column.data('accordion-title');
                if (!title) {
                    title = 'undefined';
                }
                $header.html('<a href="' + $obj.data('id') + '"  class="collapse">' + ($body.attr('data-accordion-icon') ? '<i class="' + $body.attr('data-accordion-icon') + '"></i>' : '') + '<span class="title">' + title + '</span><span class="toggle-icon closed"><i class="' + $row.data('toggle-icon') + '"></i></span><span class="toggle-icon opened"><i class="' + $row.data('toggle-active-icon') + '"></i></span></a>'); // updated
            } else if ($row.hasClass('banner')) {  // Column Banner Layer
                var banner_class = $column.data('banner-class');
                if (banner_class) {
                    if (-1 == $classes.indexOf('t-c')) {
                        $obj.removeClass('t-c');
                    }
                    if (-1 == $classes.indexOf('t-m')) {
                        $obj.removeClass('t-m');
                    }
                    if (-1 == $classes.indexOf('t-mc')) {
                        $obj.removeClass('t-mc');
                    }
                    $obj.addClass(banner_class);
                }
                // $row.hasClass('parallax') && Riode.parallax($row);
            }
            if ($column.hasClass('banner-content')) { // Column 1 Layer Banner's Layer
                if ($column.attr('data-banner-class')) {
                    var classList = $obj[0].classList;
                    classList.forEach(function (item) {
                        if (-1 != item.indexOf('overlay-')) {
                            $obj.removeClass(item);
                        }
                    });

                    $obj.addClass($column.attr('data-banner-class'));
                    $column.removeAttr('data-banner-class');
                }
                if ($column.attr('data-wrap-class')) {
                    $column.wrap('<div class="' + $column.attr('data-wrap-class') + '"></div>');
                    $column.removeAttr('data-wrap-class')
                }
            } else {
                if (-1 == $classes.indexOf('banner')) {
                    $obj.removeClass('banner');
                }
                if (-1 == $classes.indexOf('banner-fixed')) {
                    $obj.removeClass('banner-fixed');
                }
            }
        },
        initWidgetAddon: function ($obj, settings) {
            var widget_settings;

            if ('undefined' == typeof settings) {
                widget_settings = this.widgetEditorSettings($obj.data('id'))
            } else {
                widget_settings = settings;
            }

            if ($obj.data('parallax')) {
                $obj.parallax('disable');
                $obj.removeData('parallax');
                $obj.removeData('options');
            }

            if (typeof Riode == 'object' && typeof Riode.initSkrollrElements == 'function') {
                Riode.initSkrollrElements($obj, 'destroy');
            }

            if ('object' == typeof widget_settings && widget_settings.floating) {
                var floating_settings = widget_settings.floating;

                if ( floating_settings.floating ) {
                    if (0 == floating_settings.floating.indexOf('mouse_tracking')) {
                        $obj.attr('data-plugin', 'floating');

                        var settings = {};

                        if ('yes' == floating_settings['m_track_dir']) {
                            settings['invertX'] = true;
                            settings['invertY'] = true;
                        } else {
                            settings['invertX'] = false;
                            settings['invertY'] = false;
                        }

                        if ('mouse_tracking_x' == floating_settings['floating']) {
                            settings['limitY'] = '0';
                        } else if ('mouse_tracking_y' == floating_settings['floating']) {
                            settings['limitX'] = '0';
                        }

                        $obj.attr('data-options', JSON.stringify(settings));
                        $obj.attr('data-floating-depth', floating_settings['m_track_speed']);

                        if ($.fn.parallax) {
                            Riode.initFloatingElements($obj);
                        } else {
                            if (riode_elementor_vars.theme_assets_url) {
                                $(document.createElement('script')).attr('id', 'jquery-floating-js').appendTo('body').attr('src', riode_elementor_vars.theme_assets_url + '/vendor/jquery.floating/jquery.floating.min.js').on('load', function () {
                                    Riode.initFloatingElements($obj);
                                });
                            }
                        }

                        return;
                    } else if (0 == floating_settings.floating.indexOf('skr_')) {
                        $obj.attr('data-plugin', 'skrollr');

                        var settings = {};

                        if (0 == floating_settings.floating.indexOf('skr_transform_')) {
                            switch (floating_settings.floating) {
                                case 'skr_transform_up':
                                    settings['data-bottom-top'] = 'transform: translate(0, ' + floating_settings.scroll_size + '%);';
                                    settings['data-' + floating_settings.scroll_stop] = 'transform: translate(0, -' + floating_settings.scroll_size + '%);';
                                    break;
                                case 'skr_transform_down':
                                    settings['data-bottom-top'] = 'transform: translate(0, -' + floating_settings.scroll_size + '%);';
                                    settings['data-' + floating_settings.scroll_stop] = 'transform: translate(0, ' + floating_settings.scroll_size + '%);';
                                    break;
                                case 'skr_transform_left':
                                    settings['data-bottom-top'] = 'transform: translate(' + floating_settings.scroll_size + '%, 0);';
                                    settings['data-' + floating_settings.scroll_stop] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0);';
                                    break;
                                case 'skr_transform_right':
                                    settings['data-bottom-top'] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0);';
                                    settings['data-' + floating_settings.scroll_stop] = 'transform: translate(' + floating_settings.scroll_size + '%, 0);';
                                    break;
                            }
                        } else if (0 === floating_settings.floating.indexOf('skr_fade_in')) {
                            switch (floating_settings.floating) {
                                case 'skr_fade_in':
                                    settings['data-bottom-top'] = 'transform: translate(0, 0); opacity: 0;';
                                    break;
                                case 'skr_fade_in_up':
                                    settings['data-bottom-top'] = 'transform: translate(0, ' + floating_settings.scroll_size + '%); opacity: 0;';
                                    break;
                                case 'skr_fade_in_down':
                                    settings['data-bottom-top'] = 'transform: translate(0, -' + floating_settings.scroll_size + '%); opacity: 0;';
                                    break;
                                case 'skr_fade_in_left':
                                    settings['data-bottom-top'] = 'transform: translate(' + floating_settings.scroll_size + '%, 0); opacity: 0;';
                                    break;
                                case 'skr_fade_in_right':
                                    settings['data-bottom-top'] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0); opacity: 0;';
                                    break;
                            }

                            settings['data-' + floating_settings.scroll_stop] = 'transform: translate(0%, 0%); opacity: 1;';
                        } else if (0 === floating_settings.floating.indexOf('skr_fade_out')) {
                            settings['data-bottom-top'] = 'transform: translate(0%, 0%); opacity: 1;';

                            switch (floating_settings.floating) {
                                case 'skr_fade_out':
                                    settings['data-' + floating_settings.scroll_stop] = 'transform: translate(0, 0); opacity: 0;';
                                    break;
                                case 'skr_fade_out_up':
                                    settings['data-' + floating_settings.scroll_stop] = 'transform: translate(0, -' + floating_settings.scroll_size + '%); opacity: 0;';
                                    break;
                                case 'skr_fade_out_down':
                                    settings['data-' + floating_settings.scroll_stop] = 'transform: translate(0, ' + floating_settings.scroll_size + '%); opacity: 0;';
                                    break;
                                case 'skr_fade_out_left':
                                    settings['data-' + floating_settings.scroll_stop] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0); opacity: 0;';
                                    break;
                                case 'skr_fade_out_right':
                                    settings['data-' + floating_settings.scroll_stop] = 'transform: translate(' + floating_settings.scroll_size + '%, 0); opacity: 0;';
                                    break;
                            }
                        } else if (0 === floating_settings.floating.indexOf('skr_flip')) {
                            switch (floating_settings.floating) {
                                case 'skr_flip_x':
                                    settings['data-bottom-top'] = 'transform: perspective(20cm) rotateY(' + floating_settings.scroll_size + 'deg)';
                                    settings['data-' + floating_settings.scroll_stop] = 'transform: perspective(20cm), rotateY(-' + floating_settings.scroll_size + 'deg)';
                                    break;
                                case 'skr_flip_y':
                                    settings['data-bottom-top'] = 'transform: perspective(20cm) rotateX(-' + floating_settings.scroll_size + 'deg)';
                                    settings['data-' + floating_settings.scroll_stop] = 'transform: perspective(20cm), rotateX(' + floating_settings.scroll_size + 'deg)';
                                    break;
                            }
                        } else if (0 === floating_settings.floating.indexOf('skr_rotate')) {
                            switch (floating_settings.floating) {
                                case 'skr_rotate':
                                    settings['data-bottom-top'] = 'transform: translate(0, 0) rotate(-' + (360 * floating_settings.scroll_size / 50) + 'deg);';
                                    break;
                                case 'skr_rotate_left':
                                    settings['data-bottom-top'] = 'transform: translate(' + (100 * floating_settings.scroll_size / 50) + '%, 0) rotate(-' + (360 * floating_settings.scroll_size / 50) + 'deg);';
                                    break;
                                case 'skr_rotate_right':
                                    settings['data-bottom-top'] = 'transform: translate(-' + (100 * floating_settings.scroll_size / 50) + '%, 0) rotate(-' + (360 * floating_settings.scroll_size / 50) + 'deg);';
                                    break;
                            }

                            settings['data-' + floating_settings.scroll_stop] = 'transform: translate(0, 0) rotate(0deg);';
                        } else if (0 === floating_settings.floating.indexOf('skr_zoom_in')) {
                            switch (floating_settings.floating) {
                                case 'skr_zoom_in':
                                    settings['data-bottom-top'] = 'transform: translate(0, 0) scale(' + (1 - floating_settings.scroll_size / 100) + '); transform-origin: center;';
                                    break;
                                case 'skr_zoom_in_up':
                                    settings['data-bottom-top'] = 'transform: translate(0, ' + (40 + floating_settings.scroll_size) + '%) scale(' + (1 - floating_settings.scroll_size / 100) + '); transform-origin: center;';
                                    break;
                                case 'skr_zoom_in_down':
                                    settings['data-bottom-top'] = 'transform: translate(0, -' + (40 + floating_settings.scroll_size) + '%) scale(' + (1 - floating_settings.scroll_size / 100) + '); transform-origin: center;';
                                    break;
                                case 'skr_zoom_in_left':
                                    settings['data-bottom-top'] = 'transform: translate(' + floating_settings.scroll_size + '%, 0) scale(' + (1 - floating_settings.scroll_size / 100) + '); transform-origin: center;';
                                    break;
                                case 'skr_zoom_in_right':
                                    settings['data-bottom-top'] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0) scale(' + (1 - floating_settings.scroll_size / 100) + '); transform-origin: center;';
                                    break;
                            }

                            settings['data-' + floating_settings.scroll_stop] = 'transform: translate(0, 0) scale(1);';
                        } else if (0 === floating_settings.floating.indexOf('skr_zoom_out')) {
                            switch (floating_settings.floating) {
                                case 'skr_zoom_out':
                                    settings['data-bottom-top'] = 'transform: translate(0, 0) scale(' + (1 + floating_settings.scroll_size / 100) + '); transform-origin: center;';
                                    break;
                                case 'skr_zoom_out_up':
                                    settings['data-bottom-top'] = 'transform: translate(0, ' + (40 + floating_settings.scroll_size) + '%) scale(' + (1 + floating_settings.scroll_size / 100) + '); transform-origin: center;';
                                    break;
                                case 'skr_zoom_out_down':
                                    settings['data-bottom-top'] = 'transform: translate(0, -' + (40 + floating_settings.scroll_size) + '%) scale(' + (1 + floating_settings.scroll_size / 100) + '); transform-origin: center;';
                                    break;
                                case 'skr_zoom_out_left':
                                    settings['data-bottom-top'] = 'transform: translate(' + floating_settings.scroll_size + '%, 0) scale(' + (1 + floating_settings.scroll_size / 100) + '); transform-origin: center;';
                                    break;
                                case 'skr_zoom_out_right':
                                    settings['data-bottom-top'] = 'transform: translate(-' + floating_settings.scroll_size + '%, 0) scale(' + (1 + floating_settings.scroll_size / 100) + '); transform-origin: center;';
                                    break;
                            }

                            settings['data-' + floating_settings.scroll_stop] = 'transform: translate(0, 0) scale(1);';
                        }

                        $obj.attr('data-options', JSON.stringify(settings));

                        if (typeof skrollr != 'object') {
                            if (riode_elementor_vars.theme_assets_url) {
                                $(document.createElement('script')).attr('id', 'jquery-skrollr-js').appendTo('body').attr('src', riode_elementor_vars.theme_assets_url + '/vendor/skrollr/skrollr.min.js').on('load', function () {
                                    Riode.initSkrollrElements();
                                });
                            }
                        }
                    }
                }
            }

            if (typeof skrollr == 'object' && typeof skrollr.init == 'function') {
                Riode.initSkrollrElements();
            }

            // Dismiss
            if (widget_settings.dismiss && widget_settings.dismiss.enabled) {
                $obj.addClass('dismiss-widget');

                var $dismiss_after;

                if ($obj.hasClass('elementor-section')) {
                    $dismiss_after = $obj.find('.elementor-column').eq(0);
                } else if ($obj.hasClass('elementor-column')) {
                    $dismiss_after = $obj.children().eq(0);
                } else {
                    $dismiss_after = $obj.find('.elementor-widget-container');
                }

                if (!$dismiss_after.siblings('.dismiss-button').length) {
                    var $dismiss = '<a href="#" class="btn btn-link dismiss-button dismiss-button-' + $obj.data('id') + '" data-options="' + JSON.stringify( 
                            {
                                'animation': widget_settings.dismiss.animation,
                                'animation_duration': widget_settings.dismiss.duration,
                                'animation_delay': widget_settings.dismiss.delay,
                                'cookie_enable': widget_settings.dismiss.cookie,
                                'cookie_expire': widget_settings.dismiss.cookie_expire,
                            }
                        ) + '"></a>';

                    $dismiss_after.before($dismiss);
                }
            }
        },
        widgetEditorSettings: function (widgetId) {
            var editorElements = null,
                widgetData = {};

            if (!window.elementor.hasOwnProperty('elements')) {
                return false;
            }

            editorElements = window.elementor.elements;

            if (!editorElements.models) {
                return false;
            }

            $.each(editorElements.models, function (index, obj) {
                if (widgetId == obj.id) {
                    widgetData = obj.attributes.settings.attributes;
                    return;
                }

                $.each(obj.attributes.elements.models, function (index, obj) {
                    if (widgetId == obj.id) {
                        widgetData = obj.attributes.settings.attributes;
                        return;
                    }

                    $.each(obj.attributes.elements.models, function (index, obj) {
                        if (widgetId == obj.id) {
                            widgetData = obj.attributes.settings.attributes;
                            return;
                        }

                        $.each(obj.attributes.elements.models, function (index, obj) {
                            if (widgetId == obj.id) {
                                widgetData = obj.attributes.settings.attributes;
                                return;
                            }

                            $.each(obj.attributes.elements.models, function (index, obj) {
                                if (widgetId == obj.id) {
                                    widgetData = obj.attributes.settings.attributes;
                                }

                            });

                        });
                    });

                });

            });

            var floating = {
                floating: widgetData['riode_floating'],
                m_track_dir: widgetData['riode_m_track_dir'],
                m_track_speed: 'object' == typeof widgetData['riode_m_track_speed'] && widgetData['riode_m_track_speed']['size'] ? widgetData['riode_m_track_speed']['size'] : 0.5,
                scroll_size: 'object' == typeof widgetData['riode_scroll_size'] && widgetData['riode_scroll_size']['size'] ? widgetData['riode_scroll_size']['size'] : 50,
                scroll_stop: 'undefined' == typeof widgetData['riode_scroll_stop'] ? 'center' : widgetData['riode_scroll_stop']
            };

            var dismiss = {};
            if ('yes' == widgetData['riode_cm_dismiss']) {
                dismiss.enabled = true;
                dismiss.animation = widgetData['riode_cm_dismiss_animation_out'];
                dismiss.duration = widgetData['riode_cm_dismiss_animation_duration'];
                dismiss.delay = widgetData['riode_cm_dismiss_animation_delay'];
                dismiss.cookie = widgetData['riode_cm_dismiss_cookie'] == 'yes';
                dismiss.cookie_expire = widgetData['riode_cm_dismiss_cookie_expire'];
            }

            return { floating: floating, dismiss: dismiss };
        },
        initGlobal: function () {
            elementor.channels.data.on('element:after:add', function (e) {
                var $obj = $('[data-id="' + e.id + '"]'),
                    $row = $obj.closest('.elementor-row'),
                    $column = 'widget' == e.elType ? $obj.closest('.elementor-widget-wrap') : false;
                if ('widget' == e.elType && $column.hasClass('owl-carousel')) {
                    initSlider($column);
                } else if ('column' == e.elType && 'owl' == $row.data('plugin')) {
                    $row.trigger('destroy.owl.carousel');
                } else if ('column' == e.elType && 'isotope' == $row.data('plugin')) {
                    $row.data('isotope') && $row.isotope('destroy');
                }
            });

            elementor.channels.data.on('element:before:remove', function (e) {
                var $obj = $('[data-id="' + e.id + '"]'),
                    $row = $obj.closest('.elementor-row'),
                    $column = 'widget' == e.attributes.elType ? $obj.closest('.elementor-widget-wrap') : false;
                if ('widget' == e.attributes.elType && $column.hasClass('owl-carousel')) {
                    initSlider($column);
                } else if ('column' == e.attributes.elType && 'owl' == $row.data('plugin')) {
                    var pos = $obj.parent('.owl-item:not(.cloned)').index() - ($row.find('.owl-item.cloned').length / 2);
                    $row.trigger('remove.owl.carousel', pos);
                } else if ('column' == e.attributes.elType && 'isotope' == $row.data('plugin')) {
                    $row.isotope('remove', $obj).isotope('layout');
                }
            });

            elementorFrontend.hooks.addAction('refresh_isotope_layout', function (timer, $selector, force) {
                if (undefined == force) {
                    force = false;
                }

                if (timer) {
                    clearTimeout(timer);
                }

                if (undefined == $selector) {
                    $selector = $('.elementor-element-editable').closest('.grid');
                }

                $selector.siblings('style').remove();
                $selector.parent().prepend(get_creative_grid_item_css(
                    $selector.closest('.elementor-section').data('id'),
                    $selector.data('creative-layout'),
                    $selector.data('creative-height'),
                    $selector.data('creative-height-ratio')));

                if (true === force) {
                    $selector.data('isotope') && $selector.isotope('destroy');
                    Riode.isotopes($selector);
                } else {
                    if ($selector.data('isotope')) {
                        $selector.removeAttr('data-current-break');
                        $selector.isotope('reloadItems');
                        $selector.isotope('layout');
                    } else {
                        Riode.isotopes($selector);
                    }
                }
                $selector.find('.owl-carousel').trigger('refresh.owl.carousel');
                $(window).trigger('resize');
            });
        }
    };

    /**
     * Setup RiodeElementorPreview
     */
    var componentInit = null;
    $(window).on('load', function () {
        componentInit = function () {
            var deferred = $.Deferred();
        if (typeof elementorFrontend != 'undefined' && typeof Riode != 'undefined') {
            if (elementorFrontend.hooks) {
                RiodeElementorPreview.init();
                    deferred.resolve();
            } else {
                elementorFrontend.on('components:init', function () {
                    RiodeElementorPreview.init();
                        deferred.resolve();
                });
            }
        }
            return deferred.promise();
        }();
        // Header and Footer Type preset
        if (window.top.riode_core_vars.template_type && (window.top.riode_core_vars.template_type == 'header' || window.top.riode_core_vars.template_type == 'footer')) {
            window.top.elementor.presetsFactory.getPresetSVG = function getPresetSVG(preset, svgWidth, svgHeight, separatorWidth) {
                var _ = window.top._;
                if (_.isEqual(preset, ['flex-1', 'flex-auto'])) {
                    var svg = document.createElement('svg');
                    var protocol = 'http';
                    svg.setAttribute('viewBox', '0 0 88.3 44.2');
                    svg.setAttributeNS(protocol + '://www.w3.org/2000/xmlns/', 'xmlns:xlink', protocol + '://www.w3.org/1999/xlink');
                    svg.innerHTML = '<rect fill="#D5DADF" width="73.8" height="44.2"></rect> <rect x="75.5" fill="#D5DADF" width="12.8" height="44.2"></rect> <text transform="matrix(1 0 0 1 8.5 25.9167)" fill="#A7A9AC" font-family="Segoe Script" font-size="12">For ' + window.top.riode_core_vars.template_type + '</text>'
                    return svg;
                }
                else if (_.isEqual(preset, ['flex-1', 'flex-auto', 'flex-1'])) {
                    var svg = document.createElement('svg');
                    var protocol = 'http';
                    svg.setAttribute('viewBox', '0 0 88.3 44.2');
                    svg.setAttributeNS(protocol + '://www.w3.org/2000/xmlns/', 'xmlns:xlink', protocol + '://www.w3.org/1999/xlink');
                    svg.innerHTML = '<rect fill="#D5DADF" width="35" height="44.2"></rect><rect x="53.4" fill="#D5DADF" width="35" height="44.2" ></rect><rect x="36.9" fill="#D5DADF" width="14.5" height="44.2"></rect><text transform="matrix(1 0 0 1 8.5 25.9167)" fill="#A7A9AC" font-family="Segoe Script" font-size="12">For ' + window.top.riode_core_vars.template_type + '</text>';
                    return svg;
                }
                else if (_.isEqual(preset, ['flex-auto', 'flex-1', 'flex-auto'])) {
                    var svg = document.createElement('svg');
                    var protocol = 'http';
                    svg.setAttribute('viewBox', '0 0 88.3 44.2');
                    svg.setAttributeNS(protocol + '://www.w3.org/2000/xmlns/', 'xmlns:xlink', protocol + '://www.w3.org/1999/xlink');
                    svg.innerHTML = '<rect fill="#D5DADF" width="11.5" height="44.2"></rect><rect x="59.2" fill="#D5DADF" width="29.2" height="44.2"></rect><rect x="13.7" fill="#D5DADF" width="43.5" height="44.2"></rect> <text transform="matrix(1 0 0 1 8.5 25.9167)" fill="#A7A9AC" font-family="Segoe Script" font-size="12">For ' + window.top.riode_core_vars.template_type + '</text></svg>'
                    return svg;
                }
                svgWidth = svgWidth || 100;
                svgHeight = svgHeight || 50;
                separatorWidth = separatorWidth || 2;

                var absolutePresetValues = this.getAbsolutePresetValues(preset),
                    presetSVGPath = this._generatePresetSVGPath(absolutePresetValues, svgWidth, svgHeight, separatorWidth);

                return this._createSVGPreset(presetSVGPath, svgWidth, svgHeight);
            }
        }


    });

    var onComplete = function () {
        var deferred = $.Deferred();
        $(window).on('riode_complete', function () {
            deferred.resolve();
        });
        return deferred.promise();
    }();

    $.when(componentInit, onComplete).done(function () {
        RiodeElementorPreview.onComplete();
    });
})(jQuery);