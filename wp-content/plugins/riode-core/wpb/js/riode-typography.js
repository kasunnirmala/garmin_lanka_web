/**
 * Riode Typography
 *
 * @since 1.1.0
 */
jQuery('.riode-wpb-typography-container .riode-wpb-typography-toggle').on('click', function (e) {
    var $this = jQuery(this);
    $this.parent().toggleClass('show');
    $this.next().slideToggle(300);
});
jQuery(document.body).on('change', '.riode-wpb-typography-container .riode-vc-font-family', function (e) {
    var $this = jQuery(this),
        $control = $this.closest('.riode-wpb-typography-container'),
        $form = $control.next(),
        $variants = $control.find('.riode-vc-font-variants'),
        $status = $control.find('.riode-wpb-typography-toggle p'),
        font = $this.val(),
        variants = $this.find('option[value="' + font + '"]').data('variants'),
        html = '';

    variants.forEach(item => {
        html += '<option value="' + item + '">' + item + '</option>';
    });
    $variants.html(html);

    var data = {
        family: $this.val(),
        variant: $variants.val(),
        size: $control.find('.riode-vc-font-size').val(),
        line_height: $control.find('.riode-vc-line-height').val(),
        letter_spacing: $control.find('.riode-vc-letter-spacing').val(),
        text_transform: $control.find('.riode-vc-text-transform').val()
    };

    $form.val(JSON.stringify(data));

    $status.text(data.family + ' | ' + data.variant + ' | ' + data.size);
}).on('change', '.riode-wpb-typography-container .riode-vc-font-variants, .riode-wpb-typography-container .riode-vc-font-size, .riode-wpb-typography-container .riode-vc-letter-spacing, .riode-wpb-typography-container .riode-vc-line-height, .riode-wpb-typography-container .riode-vc-text-transform', function (e) {
    var $this = jQuery(this),
        $control = $this.closest('.riode-wpb-typography-container'),
        $status = $control.find('.riode-wpb-typography-toggle p'),
        $form = $control.next();

    var data = {
        family: $control.find('.riode-vc-font-family').val(),
        variant: $control.find('.riode-vc-font-variants').val(),
        size: $control.find('.riode-vc-font-size').val(),
        line_height: $control.find('.riode-vc-line-height').val(),
        letter_spacing: $control.find('.riode-vc-letter-spacing').val(),
        text_transform: $control.find('.riode-vc-text-transform').val()
    };

    $form.val(JSON.stringify(data));
    $status.text(data.family + ' | ' + data.variant + ' | ' + data.size);
});