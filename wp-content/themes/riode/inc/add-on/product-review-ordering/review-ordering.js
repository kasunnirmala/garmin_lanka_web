/**
 * Riode Dependent Plugin - reviewOrdering
 */

'use script';

window.Riode || (window.Riode = {});

(function ($) {
	var ReviewOrdering = {
		/**
		 * Initialize
		 * @since 1.0
		 */
		init: function () {
			// Refresh page when order/filter option changes
			$('body')
				.on('change', '.woocommerce-Reviews .orderby', function(e) {
					ReviewOrdering.refreshPage( 'review_order', $(this).val() );
				})
				.on('click', '.woocommerce-Reviews .btn[name="review_filter"]', function(e) {
					ReviewOrdering.refreshPage( 'review_filter', $(this).attr('data-value') );
				});
		},

		refreshPage: function( name, value ) {
			var href = location.href;

			if ( window.location.hash ) {
				href = href.replace( window.location.hash, '#tab-reviews' );
			} else {
				href += '#tab-reviews';
			}
			window.location.href = Riode.addUrlParam(href, name, value);
		}
	}

	Riode.ReviewOrdering = ReviewOrdering;

	Riode.$window.on('riode_complete', function () {
		Riode.ReviewOrdering.init();
	});
})(jQuery);