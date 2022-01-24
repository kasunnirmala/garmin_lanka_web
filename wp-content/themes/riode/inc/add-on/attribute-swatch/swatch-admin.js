/**
 * Riode Swatch Admin Library
 */
(function (wp, $) {
	'use strict';

	window.Riode = window.Riode || {};
	Riode.admin = Riode.admin || {};

	/**
	 * Private Properties for Product Image Swatch Admin
	 */
	var file_frame, $btn;

	/**
	 * Product Image Swatch methods for Admin
	 */
	var SwatchAdmin = {
		/**
		 * Initialize Image Swatch for Admin
		 */
		init: function () {
			this.onAddImage    = this.onAddImage.bind(this);
			this.onRemoveImage = this.onRemoveImage.bind(this);
			this.onSelectImage = this.onSelectImage.bind(this);

			$(document.body)
				.on('click', '#swatch_product_options .button_upload_image', this.onAddImage)
				.on('click', '#swatch_product_options .button_remove_image', this.onRemoveImage)

			$('#swatch_product_options .riode-attribute-swatch-save').on('click', this.saveOptions)
		},

		/**
		 * Event handler on image selected
		 */
		onSelectImage: function () {
			var attachment = file_frame.state().get('selection').first().toJSON(),
				$img = $btn.siblings('img');
			$img.attr('src', attachment.url);
			$btn.siblings('input').val(attachment.id);
			file_frame.close();
		},

		/**
		 * Event handler on image added
		 */
		onAddImage: function (e) {
			$btn = $(e.currentTarget);

			// If the media frame already exists
			file_frame || (
				// Create the media frame.
				file_frame = wp.media.frames.downloadable_file = wp.media({
					title: 'Choose an image',
					button: {
						text: 'Use image'
					},
					multiple: false
				}),

				// When an image is selected, run a callback.
				file_frame.on('select', this.onSelectImage)
			);

			file_frame.open();
			e.preventDefault();
		},

		/**
		 * Event handler on image removed
		 */
		onRemoveImage: function (e) {
			var $btn = $(e.currentTarget),
				$img = $btn.siblings('img');
			$img.attr('src', riode_swatch_admin_vars.placeholder);
			$btn.siblings('input').val('');
			e.preventDefault();
		},
		/**
		 * Event handler on save
		 */
		saveOptions: function (e) {
			e.preventDefault();

			var $wrapper = $('#swatch_product_options'), swatch_options = {};

			$('#swatch_product_options .woocommerce_attribute').each(function() {
				var tax = $(this).attr('data-taxonomy');
				swatch_options[tax] = {};

				if ( 'default' != $(this).find('.swatch-type').val() ) {
					swatch_options[tax]['type'] = $(this).find('.swatch-type').val();
				}

				$(this).find('table tbody tr').each(function() {
					var $this = $(this),
						id = $(this).attr('data-term-id');

					if (!Number.isInteger(id)) {
						id = id.toLowerCase().replace('/\s+/', '_');
					}

					swatch_options[tax][id] = {};

					if ( $this.find('.riode-attr-label-input').val() && $this.find('.riode-attr-label-input').val() != $this.find('.riode-attr-label-input').attr('data-origin-value') ) {
						swatch_options[tax][id]['label'] = $this.find('.riode-attr-label-input').val();
					}
					if ( $this.find('.riode-color-picker').val() && $this.find('.riode-color-picker').val() != $this.find('.riode-color-picker').attr('data-origin-value') ) {
						swatch_options[tax][id]['color'] = $this.find('.riode-color-picker').val();
					}
					if ( $this.find('.upload_image_url').val() && $this.find('.upload_image_url').val() != $this.find('.upload_image_url').attr('data-origin-value') ) {
						swatch_options[tax][id]['image'] = $this.find('.upload_image_url').val();
					}
				})
			});

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
					url: riode_swatch_admin_vars.ajax_url,
					data: {
						action: "riode_save_product_swatch_options",
						nonce: riode_swatch_admin_vars.nonce,
						post_id: riode_swatch_admin_vars.post_id,
						product_type: riode_swatch_admin_vars.product_type,
						swatch_options: swatch_options
					},
					success: function () {
						$wrapper.unblock();
					}
				}
			);
		},
	}


	/**
	 * Product Image Admin Swatch Initializer
	 */
	Riode.admin.swatchAdmin = SwatchAdmin;

	$(document).ready(function () {
		Riode.admin.swatchAdmin.init();
	});
})(wp, jQuery);
