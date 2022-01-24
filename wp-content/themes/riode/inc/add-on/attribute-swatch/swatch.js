/**
 * Riode Plugin - Product Swatch
 * 
 * @instance single
 */
'use strict';
window.Riode || (window.Riode = {});

(function ($) {

	var Swatch = {
		init: function () {
			Riode.$body
				// Archive product
				.on('click', 'li>.product .product-variations>button', function (e) {
					var $btn = $(e.currentTarget);
					if (!$btn.closest('.product').hasClass('product-single')) {
						Swatch.previewArchive($btn);
					}
				})

				// Single product
				.on('click', '.product-single .product-variations > button', function (e) {
					var $btn = $(e.currentTarget);
					setTimeout(function () {
						Swatch.previewSingle($btn);
					}, 50)
				});
		},

		previewArchive: function ($btn) {
			if ($btn.hasClass('disabled')) {
				return;
			}
			var isActive = $btn.hasClass('active');

			$btn.closest('.product-variations').children('button').removeClass('active');

			isActive || $btn.addClass('active');

			if ($btn.data('image')) {
				var $img = $btn.closest('.product').find('.product-media img:first-child');
				if (isActive) {
					$img
						.attr('src', $img.data('origin-src'))
						.attr('srcset', $img.data('origin-srcset'));
				} else {
					var match = $btn.data('image').match(/src="([^"]*)"/);
					if (match && match.length == 2) {
						$img.data('origin-src') || $img.data('origin-src', $img.attr('src'));
						$img.attr('src', match[1]);
					}
					match = $btn.data('image').match(/srcset="([^"]*)"/);
					if (match && match.length == 2) {
						$img.data('origin-srcset') || $img.data('origin-srcset', $img.attr('srcset'));
						$img.attr('srcset', match[1]);
					}
				}
			}
		},

		previewSingle: function ($btn) {
			var $form = $btn.closest('.variations_form'),
				variationImage = $form.attr('current-image');

			// If no variation is matched
			if (!variationImage) {
				var $product = $btn.closest('.product');

				// if deactive image, find active image button
				if (!$btn.hasClass('active')) {
					$btn = $form.find('.image.active').eq(0);
				}

				if ($btn.length && $btn.hasClass('active')) {
					// activate swatch image
					var swatchImageHtml = $btn.attr('data-image');
					if (swatchImageHtml) {
						var $product_img = $product.find('.wp-post-image'),
							$swatchImage = $(swatchImageHtml);

						$product_img.wc_set_variation_attr('src', $swatchImage.attr('src'));
						$product_img.wc_set_variation_attr('height', $swatchImage.attr('height'));
						$product_img.wc_set_variation_attr('width', $swatchImage.attr('width'));
						$product_img.wc_set_variation_attr('srcset', $swatchImage.attr('srcset'));
						$product_img.wc_set_variation_attr('sizes', $swatchImage.attr('sizes'));
						$product_img.wc_set_variation_attr('title', $swatchImage.attr('title'));
						$product_img.wc_set_variation_attr('data-caption', $swatchImage.attr('data-caption'));
						$product_img.wc_set_variation_attr('alt', $swatchImage.attr('alt'));
						$product_img.wc_set_variation_attr('data-src', $swatchImage.attr('data-src'));
						$product_img.wc_set_variation_attr('data-large_image', $swatchImage.attr('data-large_image'));
						$product_img.wc_set_variation_attr('data-large_image_width', $swatchImage.attr('data-large_image_width'));
						$product_img.wc_set_variation_attr('data-large_image_height', $swatchImage.attr('data-large_image_height'));
					}
				} else {
					// reset
					$form.wc_variations_image_reset();
				}

				// refresh gallery
				$product.find('.woocommerce-product-gallery').data('riode_product_gallery').changePostImage();
			}
		},
	};

	Riode.Swatch = Swatch;

	Riode.$window.on('riode_complete', function () {
		Riode.Swatch.init();
	})
})(jQuery);