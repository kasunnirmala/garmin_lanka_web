/**
 * Riode Dependent Plugin - ReviewFeeling
 */

'use script';

window.Riode || (window.Riode = {});

(function ($) {
	var ReviewFeeling = {
		/**
		 * Initialize
		 */
		init: function () {
			// Register events.
			$('body')
				.on('click', '.comment-text .feeling .btn', ReviewFeeling.changeFeeling);
		},

		changeFeeling: function(e) {

			var $this = $(this),
				modes = [];

			if ( $this.hasClass('like') ) {
				if ( $this.hasClass('active') ) {
					modes.push('remove_like');
				} else {
					if ( $this.siblings('.unlike').hasClass('active') ) {
						modes.push('remove_unlike');
					}
					modes.push('add_like');
				}
			} else if ( $this.hasClass('unlike') ) {
				if ( $this.hasClass('active') ) {
					modes.push('remove_unlike');
				} else {
					if ( $this.siblings('.like').hasClass('active') ) {
						modes.push('remove_like');
					}
					modes.push('add_unlike');
				}
			}

			Riode.doLoading($this.parent('.feeling'), 'small');

			$.ajax(
				{
					type: 'POST',
					dataType: 'json',
					url: riode_review_feeling_vars.ajax_url,
					data: {
						action: "riode_comment_feeling",
						nonce: riode_review_feeling_vars.nonce,
						modes: modes,
						comment_id: $(this).closest('.comment_container').attr('id').replace('comment-', '')
					},
					success: function (response) {
						var $like = $this.parent().children('.like'),
							$unlike = $this.parent().children('.unlike');

						$like.find('.count').text(response.data.like);
						$unlike.find('.count').text(response.data.unlike);

						if ( -1 != modes.indexOf('remove_like') ) {
							$like.removeClass('active');
						} else if ( -1 != modes.indexOf('remove_unlike') ) {
							$unlike.removeClass('active');
						}

						if ( -1 != modes.indexOf('add_like') ) {
							$like.addClass('active');
						} else if ( -1 != modes.indexOf('add_unlike') ) {
							$unlike.addClass('active');
						}

						Riode.endLoading($this.parent('.feeling'));
					}
				}
			);
		}
	}

	Riode.ReviewFeeling = ReviewFeeling;

	Riode.$window.on('riode_complete', function () {
		Riode.ReviewFeeling.init();
	});
})(jQuery);