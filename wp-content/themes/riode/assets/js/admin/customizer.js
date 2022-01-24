(function (api, wp, $) {
    'use strict';
    $(document).ready(
        function () {
            // Go to panel on first load.
            var url = location.href,
                idPos = url.search('#');

            if (0 < idPos) {
                var target = url.substr(idPos + 1);
                if (typeof wp.customize['section'](target) == 'undefined') {
                    return;
                }
                setTimeout(function () {
                    wp.customize['section'](target).focus();
                }, 2000);
            }
            // Panel Nav
            $('body').on(
                'click', '[data-target]',
                function (e) {
                    e.preventDefault();
                    if ($(this).data('target')) {
                        var type = $(this).data('type') ? $(this).data('type') : 'section';
                        if (typeof wp.customize[type]($(this).data('target')) == 'undefined') {
                            return;
                        }
                        wp.customize[type]($(this).data('target')).focus();
                    }
                }
            );
            // Load other page for previewer
            var page_links = { blog_archive: '', blog_single: '', wc_single_product: '' };
            Object.keys(page_links).forEach(
                function (item) {
                    wp.customize.section(item) && wp.customize.section(item).expanded.bind(
                        function (t) {
                            if (!t) {
                                return;
                            }

                            var cur_url = wp.customize.previewer.previewUrl();

                            if (page_links[item]) {
                                if (page_links[item] != cur_url) {
                                    wp.customize.previewer.previewUrl.set(page_links[item]);
                                }
                            } else {
                                $.ajax(
                                    {
                                        url: customizer_admin_vars.ajax_url,
                                        data: {
                                            wp_customize: 'on',
                                            action: 'riode_customize_page_links',
                                            nonce: customizer_admin_vars.nonce,
                                            page_name: item
                                        },
                                        type: 'post',
                                        success: function (response) {
                                            page_links = response.data;

                                            if (page_links[item] != cur_url) {
                                                wp.customize.previewer.previewUrl(page_links[item]);
                                            }
                                        }
                                    }
                                ).fail(
                                    function (response) {
                                        console.log(response);
                                    }
                                );
                            }
                        }
                    );
                }
            )

            // Menu Labels
            $(document.body).on(
                'click',
                '#customize-control-cs_new_menu_label .btn-add-label',
                function (e) {
                    e.preventDefault();

                    var labels = get_menu_labels(),
                        new_text = $('#customize-control-cs_new_menu_label .label-text').val(),
                        new_color = $('#customize-control-cs_new_menu_label .riode-color-picker').val();

                    if (!new_text || !new_color) {
                        alert('Plase input label text and label color');
                    } else if (undefined != labels[new_text]) {
                        alert('This label already exists. Please add another one.');
                    } else {
                        $('#customize-control-cs_menu_labels select').children().prop('selected', false);
                        $('#customize-control-cs_menu_labels select').append('<option value="' + new_color + '" selected>' + new_text + '</option>');
                        set_menu_labels();
                        $('#customize-control-cs_new_menu_label .label-text, #customize-control-cs_new_menu_label .riode-color-picker').val('');
                        $('#customize-control-cs_new_menu_label .wp-color-result').css('background-color', '');
                        $('#customize-control-cs_menu_labels #label-select').trigger('change');
                    }
                }
            );

            $(document.body).on(
                'click',
                '#customize-control-cs_menu_labels .btn-change-label',
                function (e) {
                    e.preventDefault();

                    var new_text = $('#customize-control-cs_menu_labels .menu-label .label-text').val(),
                        new_color = $('#customize-control-cs_menu_labels .menu-label .riode-color-picker').val();

                    if (new_text && new_color) {
                        $('#customize-control-cs_menu_labels select option:selected').val(new_color).text(new_text);
                        set_menu_labels();
                    }
                }
            );

            $(document.body).on(
                'click',
                '#customize-control-cs_menu_labels .btn-remove-label',
                function (e) {
                    e.preventDefault();

                    var cur_text = $('#customize-control-cs_menu_labels select option:selected').text(),
                        cur_color = $('#customize-control-cs_menu_labels select option:selected').val();

                    if (cur_text && cur_color) {
                        $('#customize-control-cs_menu_labels select option[value=' + cur_color + ']').remove();
                        set_menu_labels();
                        $('#customize-control-cs_menu_labels select option').eq(0).prop('selected', true);
                        $('#customize-control-cs_menu_labels #label-select').trigger('change');
                    }
                }
            );

            $(document.body).on(
                'change',
                '#customize-control-cs_menu_labels #label-select',
                function (e) {
                    e.preventDefault();

                    $('#customize-control-cs_menu_labels .label-text').val($(this).find('option:selected').text());
                    $('#customize-control-cs_menu_labels .riode-color-picker').val($(this).val());
                    $('#customize-control-cs_menu_labels .wp-color-result').css('background-color', $(this).val());
                }
            );

            function get_menu_labels() {
                var labels = $('#customize-control-menu_labels input').val();
                if (labels) {
                    labels = JSON.parse(labels);
                } else {
                    labels = {};
                }
                return labels;
            }

            function set_menu_labels() {
                var $select = $('#customize-control-cs_menu_labels #label-select'),
                    $options = $select.children('option'),
                    labels = {};

                if ($options.length) {
                    $options.map(
                        function () {
                            labels[$(this).text()] = $(this).val();
                        }
                    )
                }

                $('#customize-control-menu_labels input').val(JSON.stringify(labels));
                $('#customize-control-menu_labels input').trigger('click');
            }

            $('input.riode-color-picker').wpColorPicker();

            $(document.body).on(
                'click',
                '#riode-import-options',
                function (e) {
                    e.preventDefault();

                    var $file_obj = $('#customize-control-import_src input');
                    if (!$file_obj.val()) {
                        alert('Please select source file.');
                        return;
                    }

                    if (!confirm("Are you sure to import another theme options? All current options will be overwritten.")) {
                        return;
                    }

                    if (!$file_obj[0].files || $file_obj[0].files.length < 1) {
                        alert('Please select source file.');
                        return;
                    }

                    var $this = $(this);
                    $(this).attr('disabled', 'disabled');

                    var formData = new FormData();
                    formData.append('wp_customize', 'on');
                    formData.append('action', 'riode_import_theme_options');
                    formData.append('nonce', customizer_admin_vars.nonce);
                    formData.append('file', $file_obj[0].files[0]);

                    $.ajax(
                        {
                            url: customizer_admin_vars.ajax_url,
                            data: formData,
                            type: 'post',
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                $this.prop('disabled', false);
                                alert('Theme options imported seccessfully. Please refresh this page to notice new options.');
                            }
                        }
                    ).fail(
                        function (response) {
                            alert('Something went wrong while importing theme options.');
                            console.log(response);
                        }
                    );
                }
            );

            // Reset Theme Options
            $(document.body).on(
                'click',
                '#riode-reset-options',
                function (e) {
                    e.preventDefault();

                    if (!confirm("Are you sure to reset all theme options?")) {
                        return;
                    }

                    $(this).attr('disabled', 'disabled');

                    $.ajax(
                        {
                            url: customizer_admin_vars.ajax_url,
                            data: {
                                wp_customize: 'on',
                                action: 'riode_reset_theme_options',
                                nonce: customizer_admin_vars.nonce
                            },
                            type: 'post',
                            success: function (response) {
                                window.location.reload();
                            }
                        }
                    ).fail(
                        function (response) {
                            console.log(response);
                        }
                    );
                }
            );

            // customize navigator
            $('.customize-pane-child .accordion-section-title .panel-title, .customize-pane-child .customize-section-title h3').append('<a href="#" class="section-nav-status" title="Customize Navigator"><i class="far fa-star"></i></a>');

            $('.customizer-nav-item').each(function () {
                if ('section' == $(this).data('type')) {
                    $('#sub-accordion-section-' + $(this).data('target') + ' .section-nav-status').addClass('active');
                } else {
                    $('#sub-accordion-panel-' + $(this).data('target') + ' .section-nav-status').addClass('active');
                }
            })
            // Navigator
            $(document.body).on('click', '.navigator-toggle', function (e) {
                e.preventDefault();
                $(this).closest('.customizer-nav').toggleClass('active');
            })

            $(document.body).on('click', '.customizer-nav-item', function (e) {
                e.preventDefault();
                window.parent.wp.customize[$(this).data('type')]($(this).data('target')).focus();
            })

            $(document.body).on('click', '.section-nav-status', function (e) {
                e.preventDefault();
            })

            $(document.body).on('click', '.accordion-section-title', function (e) {
            })

            $(document.body).on('click', '.section-nav-status:not(.disabled)', function (e) {
                var title = '',
                    target = '',
                    type = '';

                var pane = $(this).closest('.customize-pane-child');
                if (pane.hasClass('control-panel')) {
                    target = pane[0].id.replace('sub-accordion-panel-', '');
                    type = 'panel';
                } else {
                    target = pane[0].id.replace('sub-accordion-section-', '');
                    type = 'section';
                }
                $(this).addClass('disabled');
                $(this).toggleClass('active');

                if ($(this).hasClass('active')) {
                    if ($(this).closest('.customize-section-title').length) {
                        var section = $(this).closest('.customize-section-title'),
                            parent = section.find('.customize-action').text(),
                            current = section.find('h3').text().replace(parent, '');
                        var split_pos = parent.indexOf('▸');
                        if (-1 != split_pos) {
                            parent = parent.slice(split_pos + 1);
                        } else {
                            parent = '';
                        }
                    } else {
                        parent = '';
                        var current = $(this).closest('.panel-title').text();
                    }
                    if (parent) {
                        parent = parent + ' / ';
                    }
                    title = parent + current;

                    $('.customizer-nav-items').append('<li><a href="#" data-target="' + target + '" data-type="' + type + '" class="customizer-nav-item">' + title + '</a><a href="#" class="customizer-nav-remove"><i class="fas fa-trash"></i></a></li>');
                } else {
                    $('.customizer-nav-items .customizer-nav-item[data-target="' + target + '"]').parent().fadeOut(200).addClass('hidden');
                }
                $(this).removeClass('disabled');

                var saved = wp.customize.state('saved').get();
                if (saved) {
                    wp.customize.state('saved').set(false);
                }
            })

            $(document.body).on('click', '.customizer-nav-remove', function (e) {
                e.preventDefault();
                var li = $(this).closest('li'),
                    item = li.children('.customizer-nav-item');
                li.fadeOut(200).addClass('hidden');

                if ('section' == item.data('type')) {
                    $('#sub-accordion-section-' + item.data('target') + ' .section-nav-status').removeClass('active');
                } else {
                    $('#sub-accordion-panel-' + item.data('target') + ' .section-nav-status').removeClass('active');
                }

                var saved = wp.customize.state('saved').get();
                if (saved) {
                    wp.customize.state('saved').set(false);
                }
            })

            $('#customize-save-button-wrapper #save').on('click', function () {
                var navs = {};
                $('.customizer-nav-items li:not(.hidden) .customizer-nav-item').each(function () {
                    navs[$(this).data('target')] = [$(this).text(), $(this).data('type')];
                })
                $.ajax({
                    url: customizer_admin_vars.ajax_url,
                    data: { wp_customize: 'on', action: 'riode_save_customize_nav', nonce: customizer_admin_vars.nonce, navs: navs },
                    type: 'post',
                    dataType: 'json',
                    success: function (response) {
                    }
                });
            })

            $('.control-section')
                .on('click', '.tooltip-trigger', function (e) {
                    $('.tooltip-trigger').not(this).siblings('.tooltip-content').addClass('hidden');
                });
        }
    );
})(wp.customize, wp, jQuery);

/* Kirki Compatibility */
if (wp.customize && wp.customize.controlConstructor && wp.customize.controlConstructor['kirki-background']) {
    wp.customize.controlConstructor['kirki-background'] = wp.customize.controlConstructor['kirki-background'].extend(
        {
            initKirkiControl: function () {
                var control = this,
                    value = control.setting._value,
                    picker = control.container.find('.kirki-color-control');

                // Background-Control Init
                if (_.isUndefined(value['background-image'])) {
                    control.setting._value = {
                        'background-attachment': '',
                        'background-color': '',
                        'background-image': '',
                        'background-position': '',
                        'background-repeat': '',
                        'background-size': '',
                    };
                }

                // Hide unnecessary controls if the value doesn't have an image.
                if (_.isUndefined(value['background-image']) || '' === value['background-image']) {
                    control.container.find('.background-wrapper > .background-repeat').hide();
                    control.container.find('.background-wrapper > .background-position').hide();
                    control.container.find('.background-wrapper > .background-size').hide();
                    control.container.find('.background-wrapper > .background-attachment').hide();
                }

                // If we have defined any extra choices, make sure they are passed-on to Iris.
                if (!_.isUndefined(control.params.choices)) {
                    picker.wpColorPicker(control.params.choices);
                }

                // Tweaks to make the "clear" buttons work.
                setTimeout(
                    function () {
                        clear = control.container.find('.wp-picker-clear');
                        clear.on(
                            'click',
                            function () {
                                control.saveValue('background-color', '');
                            }
                        );
                    },
                    200
                );

                // Color.
                picker.wpColorPicker(
                    {
                        change: function () {
                            setTimeout(
                                function () {
                                    control.saveValue('background-color', picker.val());
                                },
                                100
                            );
                        }
                    }
                );

                // Background-Repeat.
                control.container.on(
                    'change',
                    '.background-repeat select',
                    function () {
                        control.saveValue('background-repeat', jQuery(this).val());
                    }
                );

                // Background-Size.
                control.container.on(
                    'change click',
                    '.background-size input',
                    function () {
                        control.saveValue('background-size', jQuery(this).val());
                    }
                );

                // Background-Position.
                control.container.on(
                    'change',
                    '.background-position select',
                    function () {
                        control.saveValue('background-position', jQuery(this).val());
                    }
                );

                // Background-Attachment.
                control.container.on(
                    'change click',
                    '.background-attachment input',
                    function () {
                        control.saveValue('background-attachment', jQuery(this).val());
                    }
                );

                // Background-Image.
                control.container.on(
                    'click',
                    '.background-image-upload-button',
                    function (e) {
                        var image = wp.media({ multiple: false }).open().on(
                            'select',
                            function () {

                                // This will return the selected image from the Media Uploader, the result is an object.
                                var uploadedImage = image.state().get('selection').first(),
                                    previewImage = uploadedImage.toJSON().sizes.full.url,
                                    imageUrl,
                                    imageID,
                                    imageWidth,
                                    imageHeight,
                                    preview,
                                    removeButton;

                                if (!_.isUndefined(uploadedImage.toJSON().sizes.medium)) {
                                    previewImage = uploadedImage.toJSON().sizes.medium.url;
                                } else if (!_.isUndefined(uploadedImage.toJSON().sizes.thumbnail)) {
                                    previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
                                }

                                imageUrl = uploadedImage.toJSON().sizes.full.url;
                                imageID = uploadedImage.toJSON().id;
                                imageWidth = uploadedImage.toJSON().width;
                                imageHeight = uploadedImage.toJSON().height;

                                // Show extra controls if the value has an image.
                                if ('' !== imageUrl) {
                                    control.container.find('.background-wrapper > .background-repeat, .background-wrapper > .background-position, .background-wrapper > .background-size, .background-wrapper > .background-attachment').show();
                                }

                                control.saveValue('background-image', imageUrl);
                                preview = control.container.find('.placeholder, .thumbnail');
                                removeButton = control.container.find('.background-image-upload-remove-button');

                                if (preview.length) {
                                    preview.removeClass().addClass('thumbnail thumbnail-image').html('<img src="' + previewImage + '" alt="" />');
                                }
                                if (removeButton.length) {
                                    removeButton.show();
                                }
                            }
                        );

                        e.preventDefault();
                    }
                );

                control.container.on(
                    'click',
                    '.background-image-upload-remove-button',
                    function (e) {

                        var preview,
                            removeButton;

                        e.preventDefault();

                        control.saveValue('background-image', '');

                        preview = control.container.find('.placeholder, .thumbnail');
                        removeButton = control.container.find('.background-image-upload-remove-button');

                        // Hide unnecessary controls.
                        control.container.find('.background-wrapper > .background-repeat').hide();
                        control.container.find('.background-wrapper > .background-position').hide();
                        control.container.find('.background-wrapper > .background-size').hide();
                        control.container.find('.background-wrapper > .background-attachment').hide();

                        if (preview.length) {
                            preview.removeClass().addClass('placeholder').html('No file selected');
                        } if (removeButton.length) {
                            removeButton.hide();
                        }
                    }
                );
            },
        }
    );
} else {
    alert('Kirki plugin is not installed. Please install it first to take a full control.');
}
