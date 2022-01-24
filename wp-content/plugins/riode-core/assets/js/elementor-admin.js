/**
 * Riode Plugin - Riode Elementor Admin
 */
jQuery( document ).ready( function ( $ )
{
    'use strict';

    var RiodeElementorAdmin = {
        init: function ()
        {
            RiodeElementorAdmin.initCustomCSS();
            RiodeElementorAdmin.initCustomJS();
            RiodeElementorAdmin.initEditAreaWidth();
            RiodeElementorAdmin.initPopupOptions();

            elementor.on('panel:init', function() {
                elementor.panel.currentView.on('set:page', RiodeElementorAdmin.panelChange);
                elementor.channels.editor.on('section:activated', RiodeElementorAdmin.removeControls);
            });

            // Add Studio Block Button
            var addSectionTmpl = document.getElementById('tmpl-elementor-add-section');
            if (addSectionTmpl) {
                addSectionTmpl.textContent = addSectionTmpl.textContent.replace(
                    '<div class="elementor-add-section-area-button elementor-add-template-button',
                    '<div class="elementor-add-section-area-button elementor-studio-section-button" ' +
                    'onclick="window.parent.runStudio(this);" ' +
                    'title="Riode Studio"><i class="riode-mini-logo"></i><i class="eicon-insert"></i></div>' +
                    '<div class="elementor-add-section-area-button elementor-add-template-button');
            }
        },
        initCustomCSS: function ()
        {
            // custom page css
            var custom_css = elementor.settings.page.model.get( 'page_css' );

            setTimeout( function ()
            {
                typeof custom_css != 'undefined' && elementorFrontend.hooks.doAction( 'refresh_page_css', custom_css );
            }, 1000 );

            $( document.body ).on( 'input', 'textarea[data-setting="page_css"]', function ( e )
            {
                if ( $(this).closest('.elementor-control').siblings('.elementor-control-_riode_custom_css').length ) {
                    elementor.settings.page.model.set( 'page_css', $(this).val() );

                    $('#elementor-panel-saver-button-publish').removeClass('elementor-disabled');
                    $('#elementor-panel-saver-button-save-options').removeClass('elementor-disabled');
                }

                elementorFrontend.hooks.doAction( 'refresh_page_css', $( this ).val() );
            } )
        },
        initCustomJS: function ()
        {
            // custom page css
            var custom_js = elementor.settings.page.model.get( 'page_js' );

            $( document.body ).on( 'input', 'textarea[data-setting="page_js"]', function ( e )
            {
                if ( $(this).closest('.elementor-control').siblings('.elementor-control-_riode_custom_js').length ) {
                    elementor.settings.page.model.set( 'page_js', $(this).val() );

                    $('#elementor-panel-saver-button-publish').removeClass('elementor-disabled');
                    $('#elementor-panel-saver-button-save-options').removeClass('elementor-disabled');
                }
            } )
        },
        initEditAreaWidth: function()
        {
            // edit area width
            var edit_area_width = elementor.settings.page.model.get( 'riode_edit_area_width' );
            var triggerAction = function(e) {
                var $selector = $(this);

                if ( e.type=='mousemove' || e.type=='click' ) {
                    $selector = $selector.closest('.elementor-control-input-wrapper').find('.elementor-slider-input input');
                }

                var value = { 
                        size: $selector.val(),
                        unit: $selector.closest( '.elementor-control-input-wrapper' ).siblings( '.elementor-units-choices' ).find( 'input:checked' ).val()
                    };

                elementorFrontend.hooks.doAction( 'refresh_edit_area', RiodeElementorAdmin.getValUnit(value) );
            }

            setTimeout( function ()
            {
                typeof edit_area_width != 'undefined' && elementorFrontend.hooks.doAction( 'refresh_edit_area', RiodeElementorAdmin.getValUnit( edit_area_width ) );
            }, 1000 );

            $( document.body ).on('input', '.elementor-control-riode_edit_area_width input[data-setting="size"]', triggerAction )
                              .on('mousemove', '.elementor-control-riode_edit_area_width .noUi-active', triggerAction)
                              .on('click', '.elementor-control-riode_edit_area_width .noUi-target', triggerAction);
        },
        initPopupOptions: function ()
        {
            var popup_width = elementor.settings.page.model.get( 'popup_width' ),
                popup_pos_origin = elementor.settings.page.model.get( 'popup_pos_origin' ),
                popup_pos_left = RiodeElementorAdmin.getValUnit( elementor.settings.page.model.get( 'popup_pos_left' ), 'auto' ),
                popup_pos_top = RiodeElementorAdmin.getValUnit( elementor.settings.page.model.get( 'popup_pos_top' ), 'auto' ),
                popup_pos_right = RiodeElementorAdmin.getValUnit( elementor.settings.page.model.get( 'popup_pos_right' ), 'auto' ),
                popup_pos_bottom = RiodeElementorAdmin.getValUnit( elementor.settings.page.model.get( 'popup_pos_bottom' ), 'auto' );

            var triggerAction = function(e) {
                var $selector = $(this);

                if ( e.type=='mousemove' || e.type=='click' ) {
                    $selector = $selector.closest('.elementor-control-input-wrapper').find('.elementor-slider-input input');
                }

                var value = $selector.val(),
                    unit = $selector.closest( '.elementor-control-input-wrapper' ).siblings( '.elementor-units-choices' ).find( 'input:checked' ).val(),
                    name = $selector.closest( '.elementor-control' ).attr( 'class' ).split( ' ' )[ 1 ].replace( 'elementor-control-', '' );

                elementorFrontend.hooks.doAction( 'refresh_popup_options', name, '' != value ? ( value + unit ) : 'auto' );
            }

            setTimeout( function ()
            {
                typeof popup_width != 'undefined' && elementorFrontend.hooks.doAction( 'refresh_popup_options', 'popup_width', popup_width );
                typeof popup_pos_origin != 'undefined' && elementorFrontend.hooks.doAction( 'refresh_popup_options', 'popup_pos_origin', popup_pos_origin );
                typeof popup_pos_left != 'undefined' && elementorFrontend.hooks.doAction( 'refresh_popup_options', 'popup_pos_left', popup_pos_left );
                typeof popup_pos_top != 'undefined' && elementorFrontend.hooks.doAction( 'refresh_popup_options', 'popup_pos_top', popup_pos_top );
                typeof popup_pos_right != 'undefined' && elementorFrontend.hooks.doAction( 'refresh_popup_options', 'popup_pos_right', popup_pos_right );
                typeof popup_pos_bottom != 'undefined' && elementorFrontend.hooks.doAction( 'refresh_popup_options', 'popup_pos_bottom', popup_pos_bottom );
            }, 1000 );

            $(document.body)
                .on( 'input', 'input[data-setting="popup_width"]', function ( e )
                {
                    elementorFrontend.hooks.doAction( 'refresh_popup_options', 'popup_width', $( this ).val() );
                } )
                .on( 'input', '.elementor-control-popup_pos_origin input', function ( e )
                {
                    elementorFrontend.hooks.doAction( 'refresh_popup_options', 'popup_pos_origin', $( this ).val() );
                })
                .on( 'input', '.elementor-control-popup_pos_left input[data-setting="size"], .elementor-control-popup_pos_top input[data-setting="size"], .elementor-control-popup_pos_right input[data-setting="size"], .elementor-control-popup_pos_bottom input[data-setting="size"]', triggerAction)
                .on('mousemove', '.elementor-control-popup_pos_left .noUi-active, .elementor-control-popup_pos_top .noUi-active, .elementor-control-popup_pos_right .noUi-active, .elementor-control-popup_pos_bottom .noUi-active', triggerAction)
                .on('click', '.elementor-control-popup_pos_left .noUi-target, .elementor-control-popup_pos_top .noUi-target, .elementor-control-popup_pos_right .noUi-target, .elementor-control-popup_pos_bottom .noUi-target', triggerAction);
        },
        getValUnit: function ( $arr, $default )
        {
            if ( $arr ) {
                if ( $arr['size'] ) {
                    return $arr[ 'size' ] + ( $arr[ 'unit' ] ? $arr[ 'unit' ] : 'px' );
                } else {
                    return '';
                }
            }

            return typeof $default == 'undefined' ? '' : $default;
        },
        panelChange: function(panel) {
            if ( "_riode_section_custom_css" == panel.activeSection || "_riode_section_custom_js" == panel.activeSection ) {
                var oldName = panel.activeSection.replaceAll('_section', ''),
                    newName = oldName.replaceAll('_riode_custom', 'page');

                if ( $('.elementor-control-' + newName).length ) {
                    return;
                }

                var $newControl = $('.elementor-control-' + oldName).clone().removeClass('elementor-control-' + oldName).addClass('elementor-control-' + newName);

                $newControl.insertAfter($('.elementor-control-' + oldName));
                $newControl.find('textarea').attr('data-setting', newName).val(elementor.settings.page.model.get( newName ));

                if ( newName == 'page_css' ) {
                    $('.elementor-control-page_js').remove();
                } else {
                    $('.elementor-control-page_css').remove();
                }
            } else if ( "riode_custom_css_settings" == panel.activeSection ) {
                $('.elementor-control-page_css').val(elementor.settings.page.model.get( 'page_css' ));
            } else if ( "riode_custom_js_settings" == panel.activeSection ) {
                $('.elementor-control-page_js').val(elementor.settings.page.model.get( 'page_js' ));
            }
        },
        removeControls: function(activeSection) {
            if ( "_riode_section_custom_css" != activeSection && "_riode_section_custom_js" != activeSection ) {
                $('.elementor-control-page_css, .elementor-control-page_js').remove();
            } else {
                var oldName = activeSection.replaceAll('_section', ''),
                    newName = oldName.replaceAll('_riode_custom', 'page'),
                    $newControl = $('.elementor-control-' + oldName).clone().removeClass('elementor-control-' + oldName).addClass('elementor-control-' + newName);

                $newControl.insertAfter($('.elementor-control-' + oldName));
                $newControl.find('textarea').attr('data-setting', newName).val(elementor.settings.page.model.get( newName ));

                if ( newName == 'page_css' ) {
                    $('.elementor-control-page_js').remove();
                } else {
                    $('.elementor-control-page_css').remove();
                }
            }
        }
    }

    // Setup Riode Elementor Admin
    elementor.on('frontend:init', RiodeElementorAdmin.init.bind(RiodeElementorAdmin));
});