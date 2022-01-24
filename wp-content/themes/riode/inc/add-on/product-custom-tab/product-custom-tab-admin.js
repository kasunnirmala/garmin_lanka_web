/**
 * Riode Custom Tab Admin Library
 */
(function (wp, $) {
	'use strict';

	window.Riode = window.Riode || {};
	Riode.admin = Riode.admin || {};


	var ProductCustomTab = {
		init: function () {
			var self = this;
			$('#riode_custom_tab_title').on('change', self.requireSave);
			$('#riode_custom_tab_content').on('change', self.requireSave);
			$('#riode_custom_tab_title2').on('change', self.requireSave);
			$('#riode_custom_tab_content2').on('change', self.requireSave);
			setTimeout(function () {
				('undefined' != typeof tinymce) && tinymce.editors['riode_custom_tab_content'] &&
					tinymce.editors['riode_custom_tab_content'].on('change', self.requireSave);
				('undefined' != typeof tinymce) && tinymce.editors['riode_custom_tab_content2'] &&
					tinymce.editors['riode_custom_tab_content2'].on('change', self.requireSave);
			}, 1000);

			$('#riode_custom_tab_options .riode-custom-tab-save').on('click', self.saveOptions);
		},

		/**
		 * Require save
		 */
		requireSave: function () {
			$('#riode_custom_tab_options .riode-custom-tab-save').prop('disabled', false);
		},
        /**
         * Event handler on save
         */
		saveOptions: function (e) {
			e.preventDefault();

			var $wrapper = $('#riode_custom_tab_options');

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
					url: riode_product_custom_tab_vars.ajax_url,
					data: {
						action: "riode_save_product_tabs_options",
						nonce: riode_product_custom_tab_vars.nonce,
						post_id: riode_product_custom_tab_vars.post_id,
						custom_tab_title: $('#riode_custom_tab_title').val(),
						custom_tab_content: $('#wp-riode_custom_tab_content-wrap').hasClass('html-active') ? $('#riode_custom_tab_content').val() : tinymce.editors['riode_custom_tab_content'].getContent(),
						custom_tab_title2: $('#riode_custom_tab_title2').val(),
						custom_tab_content2: $('#wp-riode_custom_tab_content2-wrap').hasClass('html-active') ? $('#riode_custom_tab_content2').val() : tinymce.editors['riode_custom_tab_content2'].getContent()
					},
					success: function () {
						$wrapper.unblock();
					}
				}
			);
		},
	}
	/**
	 * Product Custom Tab Initializer
	 */
	Riode.admin.productCustomTab = ProductCustomTab;

	$(document).ready(function () {
		Riode.admin.productCustomTab.init();
	});
})(wp, jQuery);
