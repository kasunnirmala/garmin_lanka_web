/**
 * Riode Comment Media Admin Library
 * 
 * @since 1.4.0
 */
( function ( wp, $ ) {
	'use strict';

	window.RiodeCoreAdmin = window.RiodeCoreAdmin || {};

	/**
	 * Product Media Comment methods for Admin
	 */
	var CommentMediaAdmin = {

		/**
		 * Initialize Media Comment for Admin
		 */
		init: function () {
			this.onRemoveMedia = this.onRemoveMedia.bind( this );

			$( document.body ).on( 'click', '#riode-comment-medias-metabox .btn-remove', this.onRemoveMedia );
		},

		/**
		 * Event handler on media removed
		 */
		onRemoveMedia: function ( e ) {
			var images = [],
				videos = [],
				$this = $(e.target),
				$medias = $this.closest('.review-medias'),
				$imageIds = $medias.children('input.image-ids'),
				$videoIds = $medias.children('input.video-ids');

			$this.closest('.file-input').remove();

			$medias.children('.file-input').each(function() {
				if ( $(this).hasClass('image-input') ) {
					images.push( $(this).attr('data-id') );
				} else if ( $(this).hasClass('video-input') ) {
					videos.push( $(this).attr('data-id') );
				}
			});

			$imageIds.val( images.join(',') ).trigger( 'change' );
			$videoIds.val( videos.join(',') ).trigger( 'change' );
			e.preventDefault();
		},
	}


	/**
	 * Product Media Admin Swatch Initializer
	 */
	RiodeCoreAdmin.commentMedia = CommentMediaAdmin;

	$( document ).ready( function () {
		RiodeCoreAdmin.commentMedia.init();
	} );
} )( wp, jQuery );
