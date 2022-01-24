/**
 * Riode Dependent Plugin - ProductVideoThumbnail
 *
 */

'use strict';

window.Riode || ( window.Riode = {} );

( function ( $ ) {

	var ProductVideoThumbnail = {
		openVideoPopup: function(e) {
			e.preventDefault();

			var data = $(this).siblings('.riode-video-thumbnail-data').html();

			Riode.popup(
				{
					type: 'inline',
					mainClass: "riode-video-popup-wrapper mfp-fade",
					preloader: false,
					items: {
						src: '<div class="riode-video-popup-wrapper" style="max-width: 80rem;">' + data + '</div>'
					},
					callbacks: {
						open: function() {
							Riode.AjaxLoadPost.fitVideos($('.riode-video-popup-wrapper'), false);
						},
						beforeClose: function () {
							this.container.empty();
						}
					}
				}
			);
		}
	};

	Riode.ProductVideoThumbnail = ProductVideoThumbnail;

	Riode.$window.on( 'riode_complete', function () {
		$('.woocommerce-product-gallery .riode-video-thumbnail-viewer').on('click', Riode.ProductVideoThumbnail.openVideoPopup );
	} );
} )( jQuery );
