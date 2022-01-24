/**
 * Riode Core Admin Library
 */
'use strict';
window.RC_Admin || (window.RC_Admin = {});

/**
 * Metabox Management
 * - initialize color picker
 * - show/hide metaboxes when post format is changed
 */
(function ($) {
    // Public Properties
    RC_Admin.Metabox = function () {
        var initColorPicker = function () {
            if ($.fn.wpColorPicker) {
                $('input.riode-color-picker').wpColorPicker();
            }
        };

        var changePostFormat = function () {
            var post_type = $('.editor-post-format select').val();

            if (post_type == 'video') {
                $('#featured_video').closest('.rwmb-field').removeClass('hidden');
                $('[name="supported_images"]').closest('.rwmb-field').addClass('hidden');
            } else {
                $('#featured_video').closest('.rwmb-field').addClass('hidden');
                $('[name="supported_images"]').closest('.rwmb-field').removeClass('hidden');
            }
        };

        setTimeout(function () {
            changePostFormat();
            initColorPicker();
        }, 100);

        $('body').on('change', '.editor-post-format select', changePostFormat);
    }
})(jQuery);


/**
 * Sidebar Manage
 * - register new sidebar
 * - remove registered sidebar
 */
(function ($) {
    RC_Admin.Sidebar = function () {
        var addSidebar = function () {
            var name = prompt("Widget Area Name"),
                slug = '',
                maxnum = -1,
                $this = $(this),
                sidebars = [];

            if (!name) {
                return;
            }

            $this.attr('disabled', 'disabled');

            slug = name.toLowerCase().replace(/(\W|_)+/g, '-');
            if ('-' == slug[0] && '-' == slug[slug.length - 1]) {
                slug = slug.slice(1, -1);
            } else if ('-' == slug[0]) {
                slug = slug.slice(1);
            } else if ('-' == slug[slug.length - 1]) {
                slug = slug.slice(0, -1);
            }

            $('#sidebar_table #the-list tr').each(function () {
                sidebars.push($(this).attr('id'));
            });

            if (sidebars) {
                sidebars.forEach(function (item) {
                    if (0 === item.indexOf(slug)) {
                        var num = item.replace(slug, '');

                        if ('' == num) {
                            maxnum = Math.max(maxnum, 0);
                        } else if (Number(num.slice(1))) {
                            maxnum = Math.max(maxnum, Number(num.slice(1)));
                        }
                    }
                })
            }

            if (maxnum >= 0) {
                slug = slug + '-' + (maxnum + 1);
                name = name + ' ' + (maxnum + 1);
            }

            $.ajax({
                url: riode_core_vars.ajax_url,
                data: {
                    action: 'riode_add_widget_area',
                    nonce: riode_core_vars.nonce,
                    name: name,
                    slug: slug
                },
                type: 'post',
                success: function (response) {
                    $('<tr id="' + slug + '" class="sidebar"><td class="title column-title"><a href="' + riode_core_vars.admin_url + 'widgets.php">' + name + '</a></td><td class="slug column-slug">' + slug + '</td><td class="remove column-remove"><a href="#">Remove</a></td></tr>')
                        .appendTo($('#sidebar_table tbody#the-list'))
                        .hide().fadeIn();

                    $this.prop('disabled', false);
                }
            }).fail(function (response) {
                console.log(response);
            });
        };

        var removeSidebar = function (e) {
            e.preventDefault();

            if (!confirm("Do you want to remove this sidebar and allocated widgets?")) {
                return;
            }

            var $this = $(this),
                slug = $this.closest('tr').find('.column-slug').text();

            $.ajax({
                url: riode_core_vars.ajax_url,
                data: {
                    action: 'riode_remove_widget_area',
                    nonce: riode_core_vars.nonce,
                    slug: slug
                },
                type: 'post',
                success: function (response) {
                    $this.closest('tr').fadeOut(function () {
                        $(this).remove();
                    });

                    $this.prop('disabled', false);
                }
            }).fail(function (response) {
                console.log(response);
            });
        };

        $('body').on('click', '#sidebar_table + #add_widget_area', addSidebar);
        $('body').on('click', '#sidebar_table .column-remove > a', removeSidebar);
    }
})(jQuery);


/**
 * Template Wizard
 * - show template wizard popup before you create a new template
 * - start from prebuilt template or blank
 */
(function ($) {
    RC_Admin.TemplateWizard = function () {
        var showTemplateWizard = function (e) {
            if (!$(this).closest('.riode-admin-panel-body.templates-builder').length) {
                return;
            }

            e.preventDefault();

            $.magnificPopup.open({
                type: 'inline',
                mainClass: "mfp-riode-template-type mfp-fade mfp-riode-admin-popup",
                preloader: false,
                removalDelay: 350,
                autoFocusLast: false,
                showCloseBtn: true,
                items: {
                    src: '#riode_template_type_popup'
                },
                callbacks: {
                    open: function () {
                        $('html').css('overflow', 'hidden');
                        $('body').css('overflow-x', 'visible');
                        $('.mfp-wrap').css('overflow', 'hidden auto');
                        $('#riode-new-template-id').add('#riode-new-template-type').add('#riode-new-template-name').val('');
                        $('.mfp-riode-template-type .template-name').val('');
                        setTimeout(function() {
                            $('.mfp-riode-template-type .template-name').focus();
                        }, 100);
                    },
                    close: function () {
                        $('html').css('overflow-y', '');
                        $('body').css('overflow-x', 'hidden');
                        $('.mfp-wrap').css('overflow', '');
                    }
                }
            });
        };

        var createNewTemplate = function (e) {
            var name = $('.mfp-riode-template-type .template-name').val();
            if (!name) {
                $('.mfp-riode-template-type .template-name').focus();
                return;
            }

            var page_builder = 'gutenberg';

            if ($('#riode-elementor-studio').is(':checked')) {
                page_builder = 'elementor';
            } else if ($('#riode-wpbakery-studio').is(':checked')) {
                page_builder = 'wpbakery';
            }

            $.ajax({
                url: riode_core_vars.ajax_url,
                data: {
                    action: 'riode_save_template',
                    nonce: riode_core_vars.nonce,
                    type: $('.mfp-riode-template-type .template-type').val(),
                    name: name,
                    template_id: $('#riode-new-template-id').val(),
                    template_type: $('#riode-new-template-type').val(),
                    template_category: $('.riode-new-template-form .template-type').val(),
                    page_builder: page_builder
                },
                type: 'post',
                success: function (response) {
                    var post_id = parseInt(response.data),
                        pattern = 'post.php?post=' + post_id + '&action=edit&post_type=riode_template';
                    if ($('#riode-elementor-studio').is(':checked')) {
                        pattern = 'post.php?post=' + post_id + '&action=elementor';
                    } else if ($('#riode-wpbakery-studio').is(':checked')) {
                        pattern = 'post.php?vc_action=vc_inline&post_id=' + post_id + '&post_type=riode_template';
                    }
                    window.location.href = $('.page-title-action')
                        .attr('href')
                        .replace(
                            'post-new.php?post_type=riode_template',
                            pattern
                        );
                }
            }).fail(function (response) {
                console.log(response);
            });
        };

        var triggerCreateAction = function (e) {
            if ('Enter' == e.key && $('.mfp-riode-template-type #riode-create-template-type').length) {
                $('.mfp-riode-template-type #riode-create-template-type').trigger('click');
                return;
            }
        };

        var moveInsideRiodePanel = function () {
            $('body').removeClass('hidden');
            $('#wpbody-content .wrap').prependTo($('#wpbody-content .riode-admin-panel-body.templates-builder'));
        }

        var disableOnlineTemplates = function (e) {
            if ('riode-gutenberg-studio' == $(this).attr('id')) {
                $('#riode-new-template-name').attr('style', 'pointer-events:none; opacity: .3; background-color: #f4f4f4;');
                $('#riode-new-studio-trigger').attr('style', 'pointer-events:none; opacity: .3;');
            } else {
                $('#riode-new-template-name').attr('style', '');
                $('#riode-new-studio-trigger').attr('style', '');
            }
        }

        moveInsideRiodePanel();

        $('body').on('click', '.page-title-action', showTemplateWizard);
        $('body').on('click', '.mfp-riode-template-type #riode-create-template-type', createNewTemplate);
        $('body').on('keydown', triggerCreateAction);
        $('body').on('click', '.editors input[type="radio"]', disableOnlineTemplates);
    }
})(jQuery);


/**
 * Template Conditions
 * - determine where to display this template
 */
(function ($) {
    RC_Admin.TemplateCondition = function () {
        var condition_template = '<li class="condition">' + ('popup' == riode_core_vars.template_type ? '<div class="condition-wrap condition-popup-on"><select><option value="load" selected>Page Load</option><option value="scroll">After Scroll</option></select></div><div class="condition-wrap condition-popup-within"><input type="number" placeholder="Delay Time (s)"></div>' : '') + '<a href="#" class="btn clone_condition"><i class="fas fa-copy"></i></a><a href="#" class="btn remove_condition"><i class="fas fa-times"></i></a></li>';

        var showConditionPopup = function (e) {
            e.preventDefault();

            if ('layout' == riode_core_vars.template_type || (riode_core_vars.template_conditions.length && !$('#riode_template_conditions_popup .conditions').attr('data-template-type'))) {
                var $conditions = $('#riode_template_conditions_popup .conditions');

                $conditions.html('');

                if ('layout' == riode_core_vars.template_type) {
                    riode_core_vars.post_id = $(this).closest('.layout-box').attr('id');
                    riode_core_vars.template_conditions = riode_core_vars.page_layouts[riode_core_vars.post_id]['condition'];
                }

                $conditions.attr('data-template-type', riode_core_vars.template_type);
                $conditions.attr('data-template-id', riode_core_vars.post_id);

                riode_core_vars.template_conditions.length && riode_core_vars.template_conditions.forEach(function (condition) {
                    $conditions.append(getHtmlFromCondition(condition));
                });
            }

            $.magnificPopup.open({
                type: 'inline',
                mainClass: "mfp-riode-template-type mfp-fade mfp-riode-admin-popup",
                preloader: false,
                removalDelay: 350,
                autoFocusLast: false,
                showCloseBtn: true,
                items: {
                    src: '#riode_template_conditions_popup'
                },
                callbacks: {
                    open: function () {
                        $('html').css('overflow', 'hidden');
                        $('body').css('overflow-x', 'visible');
                        $('.mfp-wrap').css('overflow', 'hidden auto');
                        $('#riode_template_conditions_popup').css('display', '');

                        searchConditionIds($('#riode_template_conditions_popup .ids-select'));
                    },
                    close: function () {
                        $('html').css('overflow-y', '');
                        $('body').css('overflow-x', 'hidden');
                        $('.mfp-wrap').css('overflow', '');
                    }
                }
            });
        };

        var addCondition = function (e) {
            $(condition_template).prepend($(getConditionSelectBox())).appendTo($(this).siblings('.conditions'));
            enableSaveButton();
        };

        var removeCondition = function (e) {
            e.preventDefault();
            var $condition = $(this).closest('.condition');
            $condition.next('.error').remove();
            $condition.remove();
            enableSaveButton();
        };

        var cloneCondition = function (e) {
            e.preventDefault();

            var $this = $(this),
                $origin = $this.closest('.condition'),
                $clone = $origin.clone();

            $clone.find('select').each(function () {
                $(this).val($origin.find('.' + $(this).closest('.condition-wrap').attr('class').replace(' ', '.') + ' select').val());
            })

            if ( $origin.next().hasClass('error') ) {
                $origin.next().after($clone);
            } else {
                $origin.after($clone);
            }
            
            $clone.find('.live-search-list .autocomplete-suggestions').remove();
            searchConditionIds($clone.find('.ids-select'));
            enableSaveButton();
        }

        var changeCategory = function () {
            var subcategory = getConditionSelectBox($(this).val()),
                $condition = $(this).closest('.condition');

            $condition.find('.condition-ids').remove();
            if (subcategory) {
                if ($condition.find('.condition-subcategory').length) {
                    $condition.find('.condition-subcategory').replaceWith($(subcategory));
                } else {
                    $condition.find('.condition-category').after($(subcategory));
                }
            } else {
                $condition.find('.condition-subcategory, .condition-ids').remove();
            }

            enableSaveButton();
        };

        var changeSubCategory = function () {
            var $condition = $(this).closest('.condition'),
                ids = getConditionSelectBox($condition.find('.condition-category select').val(), $(this).val());

            if (ids) {
                if ($condition.find('.condition-ids').length) {
                    $condition.find('.condition-ids').replaceWith($(ids));
                } else {
                    $condition.find('.condition-subcategory').after($(ids));
                }

                searchConditionIds($condition.find('.ids-select'));
            } else {
                $condition.find('.condition-ids').remove();
            }

            enableSaveButton();
        };

        var showIdsDropdown = function () {
            var $dropdown = $(this).siblings('.dropdown-box');
            $dropdown.toggleClass('show');

            if ($dropdown.hasClass('show')) {
                $dropdown.children('.form-control').focus();
            }

            enableSaveButton();
        };

        var enableSaveButton = function () {
            $('#riode-save-display-conditions').prop('disabled', false);
        };

        var saveConditions = function () {
            var conditions = [],
                $save_btn = $(this),
                $popup = $('#riode_template_conditions_popup');

            $popup.find('.condition').each(function () {
                var $this = $(this),
                    condition = {};

                $this.removeClass('duplicated');
                $this.next('.error').remove();

                condition.category = $(this).find('.condition-category select').val();

                if ($(this).find('.condition-subcategory').length) {
                    condition.subcategory = $(this).find('.condition-subcategory select').val();

                    if ($(this).find('.condition-ids').length) {
                        condition.id = { id: $(this).find('.ids-select-toggle').attr('data-id'), title: $(this).find('.ids-select-toggle').text() };
                    }
                }

                if ($(this).find('.condition-popup-on').length) {
                    condition.popup_on = $(this).find('.condition-popup-on select').val();
                }
                if ($(this).find('.condition-popup-within').length) {
                    condition.popup_within = $(this).find('.condition-popup-within input').val();
                }

                conditions.push(condition);
            })

            var duplications = [];

            if ( riode_core_vars.template_type == 'layout' ) {
                var keys = Object.keys(riode_core_vars.page_layouts);
                keys.forEach(function(key, idx) {
                    if ( key == riode_core_vars.post_id ) {
                        return;
                    }

                    var condition = riode_core_vars.page_layouts[key]['condition'];

                    if ( condition.length ) {
                        condition.forEach(function( c, idx ) {
                            var res = checkConditionExists(c, conditions);
                            if ( res != -1 ) {
                                duplications.push({
                                    'idx': res,
                                    'origin_slug': key,
                                    'origin_idx': idx,
                                    'origin_name': riode_core_vars.page_layouts[key]['name'],
                                    'edit_link': ''
                                });
                            }
                        })
                    }
                })
            } else {
                var keys = Object.keys(riode_core_vars.templates);

                if ( keys.length ) {
                    keys.forEach(function(key, idx) {
                        if ( key == riode_core_vars.post_id ) {
                            return;
                        }

                        if ( riode_core_vars.templates[key].conditions.length ) {
                            riode_core_vars.templates[key].conditions.forEach(function( c, idx ) {
                                var res = checkConditionExists(c, conditions);
                                if ( res != -1 ) {
                                    duplications.push({
                                        'idx': res,
                                        'origin_slug': key,
                                        'origin_idx': idx,
                                        'origin_name': riode_core_vars.templates[key].name,
                                        'edit_link': riode_core_vars.templates[key].edit_link
                                    });
                                }
                            })
                        }
                    })
                }
            }

            if ( duplications.length ) {
                var message = riode_core_vars.texts.condition_override,
                    list = '';

                duplications.forEach(function(item) {
                    var $item = $popup.find('.condition:nth-child(' + ( item['idx'] + 1 ) + ')');

                    list += riode_core_vars.texts.condition_duplicated_template.replace('%index%', (item['idx'] + 1)).replace('%name%', item['origin_name']) + '\n';
                })

                if ( ! confirm(message.replace('%list%', '\n\n' + list + '\n')) ) {
                    duplications.forEach(function(item) {
                        var $item = $popup.find('.condition:nth-child(' + ( item['idx'] + 1 ) + ')'),
                            after_temp = '<p class="error">' + riode_core_vars.texts.condition_duplicated + ( item['edit_link'] ? '<a href="' + item['edit_link'] + '" target="__blank">' : '<span>' ) + item['origin_name'] + ( item['edit_link'] ? '</a>' : '</span>' ) + '</p>';

                        $item.addClass('duplicated');
                        $item.after(after_temp);
                    })

                    return;
                }
            }

            $.ajax({
                url: riode_core_vars.ajax_url,
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'riode_save_conditions',
                    nonce: riode_core_vars.nonce,
                    conditions: conditions,
                    post_id: riode_core_vars.post_id,
                    duplications: duplications,
                    template_type: riode_core_vars.template_type,
                },
                success: function (response) {
                    if ('success' == response.result) {
                        $save_btn.attr('disabled', 'disabled');
                        riode_core_vars.template_conditions = conditions;

                        if (riode_core_vars.template_type == 'layout') {
                            riode_core_vars.page_layouts = response.page_layouts;
                        } else {
                            riode_core_vars.templates = response.templates;
                        }

                        if ('layout' == riode_core_vars.template_type) {
                            var layoutClass = 'layout-box';
                            conditions.forEach(function (item) {
                                if (undefined != item['category']) {
                                    layoutClass += (' ' + item['category']);

                                    if (undefined != item['subcategory']) {
                                        if (item['subcategory']) {
                                            layoutClass += (' ' + item['category'] + '-' + item['subcategory']);
                                        } else {
                                            layoutClass += (' ' + item['category'] + '-all');
                                        }
                                    }
                                }
                            });
                            $('#' + riode_core_vars.post_id).attr('class', layoutClass);
                            $('body').trigger('condition_updated');
                        }

                        $.magnificPopup.close();
                    } else {
                        alert(riode_core_vars.texts.condition_warning);
                    }
                },
                failure: function () {
                    alert(riode_core_vars.texts.condition_warning);
                }
            });
        }

        /** 
         * checks if current condition is in new conditions
         *
         * @since 1.4.0
         */
        var checkConditionExists = function( cur_condition, new_conditions ) {
            if ( new_conditions.length ) {
                for ( var i = 0; i < new_conditions.length; i++ ) {
                    if ( 'undefined' != typeof new_conditions[i]['id'] && 'undefined' != typeof cur_condition['id'] && new_conditions[i]['category'] == cur_condition['category'] && new_conditions[i]['subcategory'] == cur_condition['subcategory'] && new_conditions[i]['id']['id'] == cur_condition['id']['id'] ) {
                        return i;
                    }
                    if ( 'undefined' == typeof new_conditions[i]['id'] && 'undefined' == typeof cur_condition['id'] && 'undefined' != typeof new_conditions[i]['subcategory'] && 'undefined' != typeof cur_condition['subcategory'] && new_conditions[i]['category'] == cur_condition['category'] && new_conditions[i]['subcategory'] == cur_condition['subcategory'] ) {
                            return i;
                        }
                    if ( 'undefined' == typeof new_conditions[i]['subcategory'] && 'undefined' == typeof cur_condition['subcategory'] && 'undefined' != typeof new_conditions[i]['category'] && 'undefined' != typeof cur_condition['category'] && new_conditions[i]['category'] == cur_condition['category'] ) {
                        return i;
                    }
                }
            }

            return -1;
        }

        var getConditionPostType = function (category) {
            if ('entire' == category) {
                return 'all';
            } else if ('page' == category || 'error' == category) {
                return 'page';
            } else {
                return category.replace(/_archive$|_single$/, '');
            }
        };

        var getConditionArchiveSingle = function (category) {
            if ('archive' == category.slice(-7)) {
                return 'archive';
            } else if ('single' == category.slice(-6)) {
                return 'single';
            }
        };

        var getHtmlFromCondition = function (condition) {
            var $res = $(condition_template);

            $res.prepend($(getConditionSelectBox()));
            if (condition['category']) {
                $res.find('.condition-category select').val(condition['category']);
            }
            if (undefined != condition['subcategory']) {
                $res.find('.condition-category').after($(getConditionSelectBox(condition['category'])));
                $res.find('.condition-subcategory select').val(condition['subcategory']);
            }
            if (undefined != condition['id']) {
                $res.find('.condition-subcategory').after($(getConditionSelectBox(condition['category'], condition['subcategory'])));
                $res.find('.ids-select-toggle').attr('data-id', condition['id']['id']).text(condition['id']['title']);
            }

            if (undefined != condition['popup_on']) {
                $res.find('.condition-popup-on select').val(condition['popup_on']);
            }
            if (undefined != condition['popup_within']) {
                $res.find('.condition-popup-within input').val(condition['popup_within']);
            }

            return $res;
        }

        var getConditionSelectBox = function (category, subcategory) {
            var html = '',
                post_type = (undefined != category ? getConditionPostType(category) : false);

            if (undefined == category) {
                html += '<div class="condition-wrap condition-category"><select>';

                var types = Object.keys(riode_core_vars.condition_network);

                types.forEach(function (type, typeIdx) {
                    var cats = Object.keys(riode_core_vars.condition_network[type]);

                    html += '<optgroup label=' + type.toUpperCase() + '>';
                    cats.forEach(function (value, idx) {
                        html += '<option value="' + cats[idx] + '">' + riode_core_vars.condition_network[type][value]['name'] + '</option>';
                    });
                    html += '</optgroup>';
                });

                html += '</select></div>';

                return html;
            }

            if (false === post_type || !Object.keys(riode_core_vars.condition_network[post_type][category]['subcats']).length) {
                return html;
            } else if (undefined == subcategory) {
                html = '<div class="condition-wrap condition-subcategory"><select>';

                var subcats = Object.keys(riode_core_vars.condition_network[post_type][category]['subcats']);

                subcats.forEach(function (value, idx) {
                    html += '<option value="' + subcats[idx] + '">' + riode_core_vars.condition_network[post_type][category]['subcats'][value] + '</option>';
                });

                html += '</select></div>';

                return html;
            }

            if (subcategory) {
                var id = 0;
                if (-1 != ['child_page', 'child_category', 'child_product_cat'].indexOf(subcategory)) {
                    id = '';
                }
                html = '<div class="condition-wrap condition-ids"><div class="ids-select"><span class="ids-select-toggle" data-id="' + id + '">' + ('' === id || 'archive' != getConditionArchiveSingle(category) ? 'Select Details' : 'All') + '</span><div class="dropdown-box"><input type="hidden" name="post_type" value="' + post_type + '"><input type="hidden" name="taxonomy" value="' + subcategory + '"><input type="search" class="form-control" name="s" required="" autocomplete="off"><div class="live-search-list"></div></div>';
                html += '</div></div>';

                return html;
            }

            return html;
        }

        var searchConditionIds = function ($selector) {
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
                    appendTo = $this.find('.live-search-list'),
                    postType = $this.find('input[name="post_type"]').val(),
                    taxonomy = $this.find('input[name="taxonomy"]').val(),
                    serviceUrl = riode_core_vars.ajax_url + '?action=riode_template_ids_search&nonce=' +
                        riode_core_vars.nonce + (postType ? '&post_type=' + postType : '') + (taxonomy ? '&taxonomy=' + taxonomy : '');

                $this.find('input[type="search"]').each(function () {
                    if ($(this).siblings('.live-search-list').find('.autocomplete-suggestions').length) {
                        return;
                    }

                    $(this).on('keydown', function (e) {
                        if ("Enter" == e.key) {
                            $this.find('.ids-select-toggle').attr('data-id', 0).text('All');
                            $this.find('.dropdown-box').removeClass('show');
                        }
                    })

                    $(this).devbridgeAutocomplete({
                        minChars: 3,
                        appendTo: appendTo,
                        triggerSelectOnValidInput: false,
                        serviceUrl: serviceUrl,
                        onSearchStart: function (params) {
                        },
                        onSelect: function (item) {
                            if (item.id != -1) {
                                $this.find('.ids-select-toggle').attr('data-id', item.id).text(item.title).trigger('click');
                            }
                        },
                        onSearchComplete: function (q, suggestions) {
                            if (!suggestions.length) {
                                appendTo.children().eq(0).hide();
                            }
                        },
                        beforeRender: function (container) {
                            $(container).removeAttr('style');
                        },
                        formatResult: function (item, currentValue) {
                            return '<span class="ids-result" data-id="' + item.id + '">' + item.title + '</span>';
                        }
                    });
                });
            });
        }

        var beforeSavePost = function () {
            if (undefined == riode_core_vars.template_conditions || riode_core_vars.template_conditions.length == 0) {
                $('#riode-template-display-condition').trigger('click');
            }
        }

        $('body')
            // Show Condition Management Popup
            .on('click', '#riode-template-display-condition, .riode-admin-panel .layout-box .layout-action-condition', showConditionPopup)
            // Remove Condition
            .on('click', '#riode_template_conditions_popup .remove_condition', removeCondition)
            // Clone Condition
            .on('click', '#riode_template_conditions_popup .clone_condition', cloneCondition)
            // Add Condition
            .on('click', '#riode-add-display-condition', addCondition)
            // Change Conditions
            .on('change', '#riode_template_conditions_popup .condition-category select', changeCategory)
            .on('change', '#riode_template_conditions_popup .condition-subcategory select', changeSubCategory)
            .on('change', '#riode_template_conditions_popup .condition-popup-on select', enableSaveButton)
            .on('change', '#riode_template_conditions_popup .condition-popup-within input', enableSaveButton)
            // Save Conditions
            .on('click', '#riode-save-display-conditions', saveConditions);

        // Show/Hide Ids Search Dropdown
        $('body')
            .on('click', '#riode_template_conditions_popup .ids-select-toggle', showIdsDropdown)
            .on('click', '#riode_template_conditions_popup', function (e) {
                $(this).find('.ids-select .dropdown-box').removeClass('show');
            })
            .on('click', '#riode_template_conditions_popup .ids-select', function (e) {
                e.stopPropagation();
            });

        // Show condition popup when never saved before
        $('body')
            .on('click', '#elementor-panel-saver-button-publish', beforeSavePost);

        $('.vc_inline-shortcode-edit-form .vc_navbar-nav .vc_btn-save').on('click', beforeSavePost);
    }
})(jQuery);


/**
 * Page Builder Addons
 * - studio
 * - template condition
 * - edit area resize
 * - custom css & js ( only for elementor )
 */
(function ($) {
    RC_Admin.BuilderAddons = function () {
        var insertElementorAddons = function () {
            if ($(document.body).hasClass('elementor-editor-active') && typeof elementor != 'undefined') {
                // Riode Elementor Addons
                elementor.on('panel:init', function () {
                    var content = '<div id="riode-elementor-addons" class="elementor-panel-footer-tool tooltip-target"><span class="riode-elementor-addons-toggle" data-tooltip="' + riode_core_vars.texts.elementor_addon_settings + '"><i class="riode-mini-logo"></i></span><div class="dropdown-box"><ul class="options">';

                    if (riode_core_vars.builder_addons.length) {
                        riode_core_vars.builder_addons.forEach(function (value) {
                            if (value['elementor']) {
                                content += value['elementor'];
                            }
                        });
                    }

                    content += '</ul></div></div>';
                    $(content).insertAfter('#elementor-panel-footer-saver-preview')
                        .find('.riode-elementor-addons-toggle').tipsy({
                            gravity: 's',
                            title: function title() {
                                return this.getAttribute('data-tooltip');
                            }
                        });
                });

                elementor.on('document:loaded', function () {
                    $('body')
                        .on('click', '.riode-elementor-addons-toggle', function (e) {
                            $(this).siblings('.dropdown-box').toggleClass('show');
                        })
                        .on('click', function (e) {
                            $('#riode-elementor-addons .dropdown-box').removeClass('show');
                        })
                        .on('click', '#riode-elementor-addons', function (e) {
                            e.stopPropagation();
                        })
                        .on('click', '#riode-custom-css-js', function (e) { // open custom css & js code panel
                            $('#elementor-panel-footer-settings').click();
                            $('.elementor-tab-control-advanced a').click();
                        })
                        .on('click', '#riode-edit-area', function (e) { // open edit area resize panel
                            $('#elementor-panel-footer-settings').click();
                            $('.elementor-control-riode_edit_area .elementor-section-toggle').click();
                        })
                        .on('click', '#riode-popup-options', function (e) { // open popup options panel
                            $('#elementor-panel-footer-settings').click();
                            $('.elementor-control-riode_popup_settings .elementor-section-toggle').click();
                        })
                })
            }
        };

        var insertWPBAddons = function () {
            if ($(document.body).hasClass('vc_editor vc_inline-shortcode-edit-form') || $('#post-body #wpb_visual_composer').length) {
                // Riode WPBakery Addons

                var initPopupOptionsPanel = function () {
                    var changePopupOptions = function () {
                        if (!vc.$frame_body) {
                            vc.riode_popup_options_view.hide();
                            return;
                        }

                        var $wrapper = $(this).closest('.vc_ui-riode-panel'),
                            width = $wrapper.find('#vc_popup-width-field').val(),
                            transform = $wrapper.find('#vc_popup-transform-field').val(),
                            top = $wrapper.find('#vc_popup-position-top-field').val(),
                            right = $wrapper.find('#vc_popup-position-right-field').val(),
                            bottom = $wrapper.find('#vc_popup-position-bottom-field').val(),
                            left = $wrapper.find('#vc_popup-position-left-field').val();

                        vc.$frame_body.find('#main > .popup-container').removeClass('t-none t-mc t-c t-m').addClass(transform);
                        vc.$frame_body.find('#main > .popup-container').css({ maxWidth: (width ? String(width) + 'px' : '600px'), top: (top ? top : 'auto'), right: (right ? right : 'auto'), bottom: (bottom ? bottom : 'auto'), left: (left ? left : 'auto') });
                    };

                    vc.RiodePopupOptionsUIPanelEditor = vc.PostSettingsPanelView.vcExtendUI(vc.HelperPanelViewHeaderFooter).vcExtendUI(vc.HelperPanelViewResizable).vcExtendUI(vc.HelperPanelViewDraggable).vcExtendUI({
                        panelName: "riode_popup_options",
                        uiEvents: {
                            setSize: "setEditorSize",
                            show: "setEditorSize"
                        },
                        setSize: function () {
                            this.trigger("setSize")
                        },
                        setDefaultHeightSettings: function () {
                            this.$el.css("height", "70vh")
                        },
                        setEditorSize: function () {
                            this.editor.setSizeResizable()
                        }
                    });

                    vc.riode_popup_options_view = new vc.RiodePopupOptionsUIPanelEditor({
                        el: "#vc_ui-panel-riode-popup-options"
                    });

                    if (window.vc.ShortcodesBuilder) {
                        window.vc.ShortcodesBuilder.prototype.save = function (status) { // update WPB save function
                            var string = this.getContent(),
                                data = {
                                    action: "vc_save"
                                };
                            data.vc_post_custom_css = window.vc.$custom_css.val();
                            data.content = this.wpautop(string);
                            status && (data.post_status = status,
                                $(".vc_button_save_draft").hide(100),
                                $("#vc_button-update").text(window.i18nLocale.update_all)),
                                window.vc.update_title && (data.post_title = this.getTitle()
                                );

                            var $wrapper = $('#vc_ui-panel-riode-popup-options'),
                                width = $wrapper.find('#vc_popup-width-field').val(),
                                transform = $wrapper.find('#vc_popup-transform-field').val(),
                                top = $wrapper.find('#vc_popup-position-top-field').val(),
                                right = $wrapper.find('#vc_popup-position-right-field').val(),
                                bottom = $wrapper.find('#vc_popup-position-bottom-field').val(),
                                left = $wrapper.find('#vc_popup-position-left-field').val(),
                                animation = $wrapper.find('#vc_popup-animation-field').val(),
                                duration = $wrapper.find('#vc_popup-anim-duration-field').val(),
                                wrapper_class = $wrapper.find('#vc_popup-aclass-field').val();

                            data.riode_popup_options = {
                                width: (width ? width : 600),
                                top: (top ? top : 'auto'),
                                right: (right ? right : 'auto'),
                                bottom: (bottom ? bottom : 'auto'),
                                left: (left ? left : 'auto'),
                                transform: (transform ? transform : 't-mc'),
                                animation: animation,
                                anim_duration: (duration ? duration : 400),
                                wrapper_class: (wrapper_class ? wrapper_class : '')
                            };

                            this.ajax(data).done(function () {
                                window.vc.unsetDataChanged(),
                                    window.vc.showMessage(window.i18nLocale.vc_successfully_updated || "Successfully updated!")
                            });
                        };
                    }

                    $('body')
                        .on('click', '.riode-wpb-addons #riode-popup-options', function (e) {
                            e && e.preventDefault && e.preventDefault();
                            vc.riode_popup_options_view.render().show();
                        })
                        .on('click', '#vc_ui-panel-riode-popup-options .vc_ui-button[data-vc-ui-element="button-save"]', changePopupOptions);
                };

                var initEditAreaSizePanel = function () {
                    var changeEditArea = function () {
                        if (!vc.$frame_body) {
                            vc.riode_edit_area_size_view.hide();
                            return;
                        }

                        var $wrapper = $(this).closest('.vc_ui-riode-panel'),
                            width = $wrapper.find('#vc_edit-area-width-field').val();

                        vc.$frame_body.find('#vc_no-content-helper').parent().css({ maxWidth: (width == Number(width) ? String(width) + 'px' : width) });
                    };

                    vc.RiodeEditAreaSizeUIPanelEditor = vc.PostSettingsPanelView.vcExtendUI(vc.HelperPanelViewHeaderFooter).vcExtendUI(vc.HelperPanelViewResizable).vcExtendUI(vc.HelperPanelViewDraggable).vcExtendUI({
                        panelName: "riode_edit_area_size",
                        uiEvents: {
                            setSize: "setEditorSize",
                            show: "setEditorSize"
                        },
                        setSize: function () {
                            this.trigger("setSize")
                        },
                        setDefaultHeightSettings: function () {
                            this.$el.css("height", "70vh")
                        },
                        setEditorSize: function () {
                            this.editor.setSizeResizable()
                        }
                    });

                    vc.riode_edit_area_size_view = new vc.RiodeEditAreaSizeUIPanelEditor({
                        el: "#vc_ui-panel-riode-edit-area-size"
                    });

                    if (window.vc.ShortcodesBuilder) {
                        window.vc.ShortcodesBuilder.prototype.save = function (status) { // update WPB save function
                            var string = this.getContent(),
                                data = {
                                    action: "vc_save"
                                };
                            data.vc_post_custom_css = window.vc.$custom_css.val();
                            data.content = this.wpautop(string);
                            status && (data.post_status = status,
                                $(".vc_button_save_draft").hide(100),
                                $("#vc_button-update").text(window.i18nLocale.update_all)),
                                window.vc.update_title && (data.post_title = this.getTitle()
                                );

                            var $wrapper = $('#vc_ui-panel-riode-edit-area-size'),
                                width = $wrapper.find('#vc_edit-area-width-field').val();

                            data.riode_edit_area_width = width;

                            this.ajax(data).done(function () {
                                window.vc.unsetDataChanged(),
                                    window.vc.showMessage(window.i18nLocale.vc_successfully_updated || "Successfully updated!")
                            });
                        };
                    }

                    $('body')
                        .on('click', '.riode-wpb-addons #riode-edit-area', function (e) {
                            e && e.preventDefault && e.preventDefault();
                            vc.riode_edit_area_size_view.render().show();
                        })
                        .on('click', '#vc_ui-panel-riode-edit-area-size .vc_ui-button[data-vc-ui-element="button-save"]', changeEditArea);

                    $(window).on('vc_build', function () {
                        var width = $('#vc_ui-panel-riode-edit-area-size #vc_edit-area-width-field').val();

                        vc.$frame_body.find('#vc_no-content-helper').parent().css({ maxWidth: (width == Number(width) ? String(width) + 'px' : width) });
                    })
                };

                // Init Riode Panels
                if (riode_core_vars.wpb_preview_panels) {
                    Object.keys(riode_core_vars.wpb_preview_panels).forEach(function (key) {
                        $('#vc_ui-panel-row-layout').before($(riode_core_vars.wpb_preview_panels[key]));
                    })
                }

                if ($('.riode-wpb-addons #riode-popup-options').length) {
                    initPopupOptionsPanel();
                }
                if ($('.riode-wpb-addons #riode-edit-area').length) {
                    initEditAreaSizePanel();
                }
            }
        };

        insertElementorAddons();
        insertWPBAddons();
    }
})(jQuery);


/**
 * Page Layouts Dashboard
 * - add new page layout
 * - remove page layout
 * - clone page layout
 */
(function ($) {
    RC_Admin.PageLayouts = function () {
        var closePopup = function () {
            $.magnificPopup.close();
        }

        var changeLayoutName = function (e) {
            var $this = $(this);

            if ($this.val()) {
                $this.attr('value', $this.val());
            } else {
                $this.val(riode_core_vars.layout_labels.default_layout_name).attr('value', riode_core_vars.layout_labels.default_layout_name);
            }

            $.ajax({
                url: riode_core_vars.ajax_url,
                data: {
                    action: 'riode_change_layout_name',
                    nonce: riode_core_vars.nonce,
                    slug: $this.closest('.layout-box').attr('id'),
                    name: $this.val()
                },
                type: 'post',
                success: function (response) {
                    riode_core_vars.page_layouts[$this.closest('.layout-box').attr('id')]['name'] = $this.val();
                }
            }).fail(function (response) {
                console.log(response);
            });
        }

        var cloneLayout = function (e) {
            e.preventDefault();

            var $layout = $(this).closest('.layout-box');

            startLoading();

            $.ajax({
                url: riode_core_vars.ajax_url,
                data: {
                    action: 'riode_clone_layout',
                    nonce: riode_core_vars.nonce,
                    slug: $layout.attr('id'),
                },
                type: 'post',
                success: function (response) {
                    var $clone = $layout.clone(),
                        org_id = $layout.attr('id'),
                        org_name = $layout.find('.riode-layout-name').val();

                    $clone.attr('class', 'layout-box');

                    if ('global-layout' == org_id) {
                        $clone.find('.layout-action-clone')
                            .after($('<a href="#" class="layout-action layout-action-remove"><i class="far fa-trash-alt"></i></a>'))
                            .after($('<a href="#" class="layout-action layout-action-condition"><i class="fas fa-cog"></i></a>'));
                        $clone.find('.riode-layout-name').removeAttr('readonly');
                    }

                    $clone.attr('id', 'layout-' + (riode_core_vars.layout_counter++));
                    $clone.find('.riode-layout-name')
                        .attr('value', org_name + '-1')
                        .val(org_name + '-1');
                    $layout.after($clone);

                    riode_core_vars.page_layouts = response.data;
                    initFilterCounts();
                    endLoading();
                }
            }).fail(function (response) {
                console.log(response);
            });
        }

        var addLayout = function (e) {
            e.preventDefault();

            startLoading();

            $.ajax({
                url: riode_core_vars.ajax_url,
                data: {
                    action: 'riode_add_layout',
                    nonce: riode_core_vars.nonce,
                },
                type: 'post',
                success: function (response) {
                    $('.empty-layout').before($(response.data));
                    riode_core_vars.page_layouts['layout-' + riode_core_vars.layout_counter] = {
                        name: riode_core_vars.layout_labels.default_layout_name,
                        content: {},
                        condition: {}
                    };
                    riode_core_vars.layout_counter++;

                    endLoading();
                }
            }).fail(function (response) {
                console.log(response);
            });
        }

        var removeLayoutPopup = function (e) {
            e.preventDefault();

            var $content;

            if ($(this).hasClass('layout-action-remove')) {
                $content = $($('#riode_layout_remove_form').html());
            } else if ($(this).hasClass('layout-action-remove')) {
                $content = $($('#riode_layout_clone_form').html());
            }

            $content.attr('data-id', $(this).closest('.layout-box').attr('id'));

            $.magnificPopup.open({
                type: 'inline',
                mainClass: "mfp-fade mfp-riode-layout mfp-riode-admin-popup",
                preloader: false,
                removalDelay: 350,
                autoFocusLast: false,
                showCloseBtn: true,
                items: {
                    src: $content[0]
                },
                callbacks: {
                    open: function () {
                        $('html').css('overflow', 'hidden');
                        $('body').css('overflow-x', 'visible');
                        $('.mfp-wrap').css('overflow', 'hidden auto');
                    },
                    close: function () {
                        $('html').css('overflow-y', '');
                        $('body').css('overflow-x', 'hidden');
                        $('.mfp-wrap').css('overflow', '');
                    }
                }
            });
        }

        var removeLayout = function () {
            var slug = $(this).closest('.riode-layout-popup').attr('data-id');

            startLoading();

            $.ajax({
                url: riode_core_vars.ajax_url,
                data: {
                    action: 'riode_remove_layout',
                    nonce: riode_core_vars.nonce,
                    slug: slug
                },
                type: 'post',
                success: function (response) {
                    $('#' + slug).remove();
                    $.magnificPopup.close();

                    riode_core_vars.page_layouts = response.data;
                    initFilterCounts();
                    endLoading();
                }
            }).fail(function (response) {
                console.log(response);
            });
        }

        var startLoading = function () {
            $('.page-layouts').append('<div class="loading-overlay"><div class="loading-icon"></div></div>');
        }

        var endLoading = function () {
            $('.page-layouts').children('.loading-overlay').remove();
        }

        var startSaving = function ($box) {
            $box.find('.layout-header').append('<span class="status">' + riode_core_vars.layout_labels.saving_status + '</span>');
        }

        var endSaving = function ($box) {
            $box.find('.layout-header > span').remove();
        }

        var optionsPanel = function () {
            if ($(this).hasClass('main-content')) {
                return;
            }

            var $options = $($('#riode_layout_' + $(this).attr('data-part') + '_options_html').html()),
                layout_id = $(this).closest('.layout-box').attr('id'),
                part_id = $(this).attr('data-part');

            if ('global-layout' == layout_id && 'general' == part_id) {
                $options.find('#wrap [value=""]').remove();
            }

            if ('global-layout' == layout_id && 'general' == part_id) {
                $options.find('#reading_progress [value=""]').remove();
            }

            $options.appendTo($(this).closest('.layout-box').find('.part-options'));
            $(this).closest('.layout-box').find('.part-options').attr('data-part', part_id);

            if (typeof riode_core_vars.page_layouts[layout_id]['content'][part_id] == 'object') {
                Object.keys(riode_core_vars.page_layouts[layout_id]['content'][part_id]).forEach(function (key) {
                    setValue(key, $options, riode_core_vars.page_layouts[layout_id]['content'][part_id][key]);
                });
            }
            dealOptionCondition(null, $(this).closest('.layout-box').find('.part-options'));

            $(this).closest('.layout-box').addClass('open-options');
        }

        var closePanel = function (e) {
            e.preventDefault();

            if (!$(this).closest('.layout-box').hasClass('open-options')) {
                return;
            }

            $(this).closest('.layout-box').find('.part-options').attr('data-part', '').html('');
            $(this).closest('.layout-box').find('.layout-header .status').remove();
            $(this).closest('.layout-box').removeClass('open-options');
        }

        var triggerTooltip = function () {
            $(this).closest('.option').siblings().find('.tooltip-content').addClass('hidden');
            $(this).siblings('.tooltip-content').toggleClass('hidden');
        }

        var dealOptionCondition = function (e, $options) {
            if (typeof $options == 'undefined') {
                $options = $(this).closest('.part-options');
            }

            if ($(this).length) {
                var $this = $(this),
                    layout_id = $(this).closest('.layout-box').attr('id'),
                    part_id = $(this).closest('.part-options').attr('data-part'),
                    $options = $(this).closest('.part-options'),
                    option = {};

                $(this).closest('.part-options').find('.option').each(function () {
                    var $o = $(this).find('[id]');
                    option[$o.attr('id')] = getValue($o.attr('id'), $options);
                })

                startSaving($this.closest('.layout-box'));

                $.ajax({
                    url: riode_core_vars.ajax_url,
                    data: {
                        action: 'riode_save_option',
                        nonce: riode_core_vars.nonce,
                        layout_id: layout_id,
                        part_id: part_id,
                        option: option
                    },
                    type: 'post',
                    success: function (response) {
                        riode_core_vars.page_layouts[layout_id]['content'][part_id] = option;
                        if ('general' == $options.attr('data-part')) { // general part is set always
                            $options.siblings('.riode_layout').find('.layout-part.' + part_id).addClass('set');
                        } else if (option['id']) { // if id is changed
                            $options.siblings('.riode_layout').find('.layout-part.' + part_id).addClass('set');
                        } else { // custom cases
                            if (part_id == 'ptb' && (option['title'] || option['subtitle'])) {
                                $options.siblings('.riode_layout').find('.layout-part.' + part_id).addClass('set');
                            } else {
                                $options.siblings('.riode_layout').find('.layout-part.' + part_id).removeClass('set');
                            }
                        }
                        endSaving($this.closest('.layout-box'));
                    }
                }).fail(function (response) {
                    console.log(response);
                });
            }

            $options.find('[data-condition]').each(function () {
                var $this = $(this),
                    conditions = JSON.parse($(this).attr('data-condition')),
                    res = true;
                Object.keys(conditions).forEach(function (key) {
                    var value = getValue(key, $options);

                    if ('any' == conditions[key]) {
                        res = res && ('' != value) && ('-1' != value);
                    } else {
                        res = res && (conditions[key] == value);
                    }
                });

                if (res) {
                    $this.removeClass('hidden');
                } else {
                    $this.addClass('hidden');
                }
            });
        }

        var getValue = function (id, $options) {
            var $selector = $options.find('#' + id);

            if ($selector.is('select')) {
                return $selector.val();
            }
            if ($selector.attr('type') == 'checkbox') {
                return $selector.prop('checked');
            }
            return $selector.val();
        }

        var setValue = function (id, $options, value) {
            var $selector = $options.find('#' + id);

            if ($selector.is('select')) {
                $selector.val(value);
            }
            if ($selector.attr('type') == 'checkbox') {
                $selector.prop('checked', value == 'true' || value == true);
            }
            $selector.val(value);
        }

        var layoutFilter = function (e) {
            e.preventDefault();
            var $this = $(this),
                slug = $this.attr('href'),
                $wrapper = $this.closest('.riode-admin-panel-row').find('.page-layouts'),
                $filters = $this.closest('.riode-admin-panel-row').find('.page-layout-filter'),
                $layouts = $wrapper.children();

            $filters.removeClass('active');
            $this.parent().addClass('active');

            if ('entire' == slug) {
                $layouts.css('display', 'none');
                $layouts.fadeIn();
                $layouts.css('display', '');
            } else {
                $layouts.css('display', 'none');
                $wrapper.find('.' + slug)
                    .add('#global-layout')
                    .add('.empty-layout')
                    .add('.entire')
                    .fadeIn()
                    .css('display', '');
            }
        }

        var filterToggle = function (e) {
            e.preventDefault();

            var $this = $(this),
                $wrapper = $this.closest('.page-layout-filter'),
                $content = $wrapper.find('.children');

            if (!$content.hasClass('sliding')) {
                $content.addClass('sliding');
                $this.toggleClass('active');
                $content.slideToggle(400, function () {
                    $content.removeClass('sliding');
                });
            }
        }

        var initFilterCounts = function () {
            var $filters = $('.page-layout-filter');

            $filters.each(function () {
                var $this = $(this),
                    slug = $this.children('a').eq(0).attr('href'),
                    count = $('.' + slug).length,
                    $count = $this.find('.count');

                if ('entire' == slug) {
                    count = $('.layout-box').length - 1;
                }

                if (count > 0) {
                    if ($count.length > 0) {
                        $count.html(count);
                    } else {
                        $this.append('<span class="count" style="display: none;">' + count + '</span>');
                    }
                    $this.children('.count').fadeIn(300);
                }
            });
        }

        $('body')
            .on('click', '.riode-layout-popup .button-close', closePopup)
            // change layout name and slug
            .on('change', '.layout-box .riode-layout-name', changeLayoutName)
            // clone layout
            .on('click', '.layout-box .layout-action-clone', cloneLayout)
            // add layout
            .on('click', '.empty-layout .add-new-layout', addLayout)
            // remove layout
            .on('click', '.layout-box .layout-action-remove', removeLayoutPopup)
            .on('click', '.riode-layout-popup .button-remove-layout', removeLayout)
            // open options select panel
            .on('click', '.layout-box .layout-part', optionsPanel)
            // close options select panel
            .on('click', '.layout-box .layout-header .back', closePanel)
            // show/hide tooltip content
            .on('click', '.option .tooltip-trigger', triggerTooltip)
            // deal conditional options
            .on('change', '.option select, .option input', dealOptionCondition)
            // category filter
            .on('click', '.page-layout-filter > a', layoutFilter)
            .on('click', '.page-layout-filter .toggle', filterToggle)
            .on('condition_updated', initFilterCounts);

        initFilterCounts();
    }
})(jQuery);


/* Riode Core Admin Initialize */
jQuery(document).ready(function ($) {
    RC_Admin.Metabox();
    ('undefined' !== typeof riode_core_vars.sidebars) && RC_Admin.Sidebar();
    $('body').hasClass('post-type-riode_template') && RC_Admin.TemplateWizard();
    ('undefined' !== typeof riode_core_vars.condition_network) && RC_Admin.TemplateCondition();
    ('undefined' !== typeof riode_core_vars.builder_addons) && RC_Admin.BuilderAddons();
    $('body').hasClass('riode_page_riode_layout_dashboard') && RC_Admin.PageLayouts();
});