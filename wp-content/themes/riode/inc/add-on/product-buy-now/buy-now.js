/**
 * Riode Plugin - Product Buy Now
 * 
 * @instance single
 */
'use strict';
window.Riode || ( window.Riode = {} );

( function ( $ ) {
    var BuyNow = {
        /**
         * Register event for buy now button
         */
        init: function () {
            var self = this;

            // Initialize buy now action
            Riode.$body.find( 'form.cart' ).on( 'click', '.product-buy-now', function ( e ) {
                e.preventDefault();
                self.buyNow( e.target );
            } );

            // If variable product, disable Buy Now button until choose attribute
            Riode.$body.find( '.variations_form' ).on( 'hide_variation', function ( e ) {
                e.preventDefault();
                self.disableBuyNow();
            } );

            // Enable Buy Now button soon after choose attribute
            Riode.$body.find( '.variations_form' ).on( 'show_variation', function ( e, variation, purchasable ) {
                e.preventDefault();
                self.enableBuyNow( variation, purchasable );
            } );
        },
        buyNow: function ( el ) {
            var $form = $( el ).closest( 'form.cart' ),
                is_disabled = $( el ).hasClass( 'disabled' );

            if ( is_disabled ) {
                Riode.scrollToFixedContent($(el).closest('.variations_form').offset().top, 400);
            } else {
                $form.append( '<input type="hidden" value="true" name="buy_now" />' );
                $form.find( '.single_add_to_cart_button' ).trigger( 'click' );
            }
        },
        disableBuyNow: function ( e ) {
            $( '.variations_form' ).find( '.product-buy-now' ).addClass( 'disabled' );
        },
        enableBuyNow: function ( variation, purchasable ) {
            if ( purchasable ) {
                $( '.variations_form' ).find( '.product-buy-now' ).removeClass( 'disabled' );
            } else {
                $( '.variations_form' ).find( '.product-buy-now' ).addClass( 'disabled' );
            }
        }
    };

    Riode.BuyNow = BuyNow;

    Riode.$window.on( 'riode_complete', function () {
        Riode.BuyNow.init();
    } )
} )( jQuery );