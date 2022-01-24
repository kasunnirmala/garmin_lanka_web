/**
 * Riode Dropdown
 * 
 * @since 1.1.0
 */
jQuery('.riode-wpb-dropdown-container .riode-responsive-toggle').on('click', function (e) {
    var $this = jQuery(this);
    $this.parent().toggleClass('show');
});
if (undefined == riode_core_vars.wpb_editor || undefined == riode_core_vars.wpb_editor.riode_dropdown_included || true != riode_core_vars.wpb_editor.riode_dropdown_included) {
    jQuery(document.body).on('click', '.riode-wpb-dropdown-container .riode-responsive-span li', function (e) {
        var $this = jQuery(this),
            $dropdown = $this.closest('.riode-responsive-dropdown'),
            $toggle = $dropdown.find('.riode-responsive-toggle'),
            $control = $dropdown.parent(),
            $input = $control.find('.riode-wpb-dropdown');
        // Actions
        $this.addClass('active').siblings().removeClass('active');
        $dropdown.removeClass('show');
        $toggle.html($this.html());

        // Trigger
        var $sizeControl = jQuery('#vc_screen-size-control'),
            $uiPanel = $this.closest('.vc_ui-panel-window');
        if ($sizeControl.length > 0) {
            $sizeControl.find('[data-size="' + $this.data('size') + '"]').click();
        }
        if ($uiPanel.length > 0) {
            $uiPanel.find('.riode-responsive-span [data-width="' + $this.data('width') + '"]').trigger('responsive_changed');
        }

        // Responsive Data
        var width = $this.data('width');
        $control.data('width', width);
        $input.val($input.data(width) ? $input.data(width) : '');
    }).off('responsive_changed', '.riode-wpb-dropdown-container .riode-responsive-span li').on('responsive_changed', '.riode-wpb-dropdown-container .riode-responsive-span li', function (e) {
        var $this = jQuery(this),
            $dropdown = $this.closest('.riode-responsive-dropdown'),
            $toggle = $dropdown.find('.riode-responsive-toggle'),
            $control = $dropdown.parent(),
            $input = $control.find('.riode-wpb-dropdown');
        // Actions
        $this.addClass('active').siblings().removeClass('active');
        $dropdown.removeClass('show');
        $toggle.html($this.html());

        // Responsive Data
        var width = $this.data('width');
        $control.data('width', width);
        $input.val($input.data(width) ? $input.data(width) : '');
    }).on('change', '.riode-wpb-dropdown', function (e) {
        var $this = jQuery(this),
            $control = $this.parent(),
            $form = $control.next();
        if (undefined == $control.data('width')) {
            $this.data('xl', $this.val());
        } else {
            $this.data($control.data('width'), $this.val());
        }

        // Set Data
        if ($this.hasClass('simple-value')) {
            $form.val($this.val());
        } else {
            $form.val(JSON.stringify($this.data()));
        }
    })
    if (undefined == riode_core_vars.wpb_editor) {
        riode_core_vars.wpb_editor = {
            riode_dropdown_included: true,
        }
    } else {
        riode_core_vars.wpb_editor.riode_dropdown_included = true;
    }
}