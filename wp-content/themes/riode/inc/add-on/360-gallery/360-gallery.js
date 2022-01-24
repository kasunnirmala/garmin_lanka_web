/**
 * Riode Dependent Plugin - Product360Gallery
 *
 */

'use strict';

window.Riode || ( window.Riode = {} );

( function ( $ ) {

	var Product360Gallery = {
		openPopup: function(e) {
			e.preventDefault();

			var data = $(this).siblings('.riode-360-gallery-data').html();

			Riode.popup(
				{
					type: 'inline',
					mainClass: "riode-360-gallery-wrapper mfp-fade",
					preloader: false,
					items: {
						src: '<div class="riode-360-gallery-wrapper nav-bar-framed" style="max-width: 80rem;">' + data + '</div>'
					},
					callbacks: {
						open: function() {
							Riode.degree360('.mfp-content .riode-360-gallery-wrapper');
						},
						beforeClose: function () {
							this.container.empty();
						}
					}
				}
			);
		}
	};

	Riode.Product360Gallery = Product360Gallery;

	Riode.$window.on( 'riode_complete', function () {
		$('.woocommerce-product-gallery .riode-360-gallery-viewer').on('click', Riode.Product360Gallery.openPopup );
	} );
} )( jQuery );
