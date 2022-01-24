/**
 * Riode Product Data Addons Admin Library
 */
(function (wp, $) {
    'use strict';

    window.Riode = window.Riode || {};
    Riode.admin = Riode.admin || {};


    var productDataAddons = {
        init: function () {
            var self = this;

            // Datepicker fields
            $( '#riode_virtual_buy_time' ).datepicker({
                defaultDate:     '',
                dateFormat:      'yy-mm-dd',
                numberOfMonths:  1,
                showButtonPanel: true,
                maxDate: new Date()
            });

            $('#riode_image_change_hover, #riode_virtual_buy_time, #riode_virtual_buy_time_text').on('change', self.requireSave);
            $('#riode_add_custom_label, .delete').on('click', self.requireSave);
            $('#riode_data_addons .riode-data-addon-save').on('click', self.saveOptions);

            $('.riode_custom_labels .color-picker').wpColorPicker();
            $('#riode_add_custom_label').on('click', self.addLabel);
            $('.riode_custom_labels').on('click', '.delete', self.removeLabel);
            self.sortableLabels();
        },

        /**
         * Require save
         */
        requireSave: function () {
            $('#riode_data_addons .riode-data-addon-save').prop('disabled', false);
        },

        /**
         * Add a custom label
         */
        addLabel: function () {
            var form = $(this).closest('.form-field');
            form.siblings('.wc-metabox-template').clone().show().appendTo(form.find('.wc-metaboxes'));

            if ($.fn.wpColorPicker) {
                form.find('.color-picker').addClass('riode-color-picker');
                form.find('input.riode-color-picker').wpColorPicker();
            }
        },

        /**
         * Remove a custom label
         */
        removeLabel: function (e) {
            e.preventDefault();
            $(this).closest('.wc-metabox').remove();
        },

        /**
         * Sortable Custom Labels
         */
        sortableLabels: function () {
            // Attribute ordering.
            $('.riode_custom_labels .wc-metaboxes').sortable(
                {
                    items: '.wc-metabox',
                    cursor: 'move',
                    axis: 'y',
                    handle: 'h3',
                    scrollSensitivity: 40,
                    forcePlaceholderSize: true,
                    helper: 'clone',
                    opacity: 0.65,
                    placeholder: 'wc-metabox-sortable-placeholder',
                    start: function (event, ui) {
                        ui.item.css('background-color', '#f6f6f6');
                    },
                    stop: function (event, ui) {
                        ui.item.removeAttr('style');
                    }
                }
            );
        },

        /**
         * Event handler on save
         */
        saveOptions: function (e) {
            e.preventDefault();

            var custom_labels = [],
                $wrapper = $('#riode_data_addons');

            $('.riode_custom_labels').find('.wc-metabox').each(
                function () {
                    var each = {};
                    each.label = $(this).find('.label_text').val();
                    each.bgColor = $(this).find('[name="label_bgcolor"]').val();
                    if (each.label) {
                        custom_labels.push(each);
                    }
                }
            )

            $wrapper.block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });

            $.ajax(
                {
                    type: 'POST',
                    dataType: 'json',
                    url: riode_product_data_addon_vars.ajax_url,
                    data: {
                        action: "riode_save_product_data_addon_options",
                        nonce: riode_product_data_addon_vars.nonce,
                        post_id: riode_product_data_addon_vars.post_id,
                        image_change_hover: $('#riode_image_change_hover').val(),
                        virtual_buy_time: $('#riode_virtual_buy_time').val(),
                        virtual_buy_time_text: $('#riode_virtual_buy_time_text').val(),
                        custom_labels: custom_labels
                    },
                    success: function () {
                        $wrapper.unblock();
                    }
                }
            );
        },
    }
    /**
     * Product Data Addons Initializer
     */
    Riode.admin.productDataAddons = productDataAddons;

    $(document).ready(function () {
        Riode.admin.productDataAddons.init();
    });
})(wp, jQuery);
