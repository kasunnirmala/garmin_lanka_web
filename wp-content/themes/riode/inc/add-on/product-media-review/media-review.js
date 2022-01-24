/**
 * Riode Dependent Plugin - CommentWithMedia
 */

'use script';

window.Riode || (window.Riode = {});

(function ($) {
    var CommentWithMedia = {
        /**
         * Initialize
         * @since 1.0
         */
        init: function () {
            // Add enctype to comment form to upload file
            $('form.comment-form').attr('enctype', 'multipart/form-data');

            // Register events.
            $('body')
                .on('click', '.review-medias img, .review-medias figure', CommentWithMedia.openLightBox)
                .on('change', '.comment-form .review-medias input[type="file"]', CommentWithMedia.uploadMedia)
                .on('click', '.comment-form .review-medias .btn-remove', CommentWithMedia.removeMedia);
        },

        uploadMedia: function(e) {
            if ( ! $(this)[0].files.length ) {
                return;
            }

            var $this = $(this),
                file = $(this)[0].files[0],
                reader = new FileReader(),
                $control = $this.closest('.file-input');

            if ( file.size > riode_media_review.max_size ) {
                $this.val('');
                alert(riode_media_review.texts.max_size_alert);
                return;
            }

            var URL = window.URL || window.webkitURL;
            var src = URL.createObjectURL( file );

            if ( src ) {
                if ( $control.hasClass('image-input') ) {
                    $control.find('.file-input-wrapper').css('background-image', 'url(' + src + ')');
                } else if ( $control.hasClass('video-input') ) {
                    $control.find('video').attr('src', src);
                }
            }
        },

        removeMedia: function(e) {
            var $this = $(this),
                $fileInput = $this.closest('.file-input');

            $fileInput.removeClass('invalid-media');
            $fileInput.find('input[type="file"]').val('');
            $fileInput.find('.file-input-wrapper').css('background-image', '');
            $fileInput.find('video').attr('src', '');
        },

        openLightBox: function (e) {
            e.preventDefault();
            if ( 'IMG' == e.target.tagName ) {
                var $media = $(e.currentTarget);
                var medias = $media.parent().children().map(function () {
                    var $this = $(this);

                    if ( 'IMG' == this.tagName ) {
                        return {
                            src: this.getAttribute('data-img-src'),
                            w: 800,
                            h: 900,
                            title: this.getAttribute('alt') || ''
                        };
                    }
                }).get();

                if (typeof PhotoSwipe !== 'undefined') {
                    var pswpElement = $('.pswp')[0];
                    var photoSwipe = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, medias, {
                        index: $media.index(),
                        closeOnScroll: false
                    });

                    // show media at first.
                    photoSwipe.listen('afterInit', function () {
                        photoSwipe.shout('initialZoomInEnd');
                    })
                    photoSwipe.init();
                }
            } else if ( 'FIGURE' == e.target.tagName ) {
                Riode.popup({
                    items: {
                        src: '<video src="' + $(e.target).find('video').attr('src') + '" autoplay loop controls>',
                        type: 'inline'
                    },
                    mainClass: 'mfp-video-popup'
                }, 'video');
            }
        }
    }

    Riode.CommentWithMedia = CommentWithMedia;

    Riode.$window.on('riode_complete', function () {
        Riode.CommentWithMedia.init();
    });
})(jQuery);