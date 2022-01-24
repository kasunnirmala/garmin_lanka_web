/**
 * Riode Responsive
 *
 * @since 1.1.0
 */
jQuery('.riode-wpb-responsive > li > span').on('click', function (e) {
    var $this = jQuery(this),
        $control = $this.closest('.riode-wpb-responsive-container'),
        $form = $control.next();

    $this.toggleClass('hide');

    // Set Data
    $control.data($this.parent().data('width'), $this.hasClass('hide'));

    $form.val(JSON.stringify($control.data()));
})