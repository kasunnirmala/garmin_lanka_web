/**
 * Riode Button Group
 * 
 * @since 1.1.0
 */
jQuery('.riode-wpb-button-group .riode-responsive-toggle').on('click', function (e) {
    var $this = jQuery(this);
    $this.parent().toggleClass('show');
});

if (undefined == riode_core_vars.wpb_editor || undefined == riode_core_vars.wpb_editor.riode_button_group_included || true != riode_core_vars.wpb_editor.riode_button_group_included) {
    jQuery(document.body).on('click', '.riode-wpb-button-group .riode-responsive-span li', function (e) {
        var $this = jQuery(this),
            $dropdown = $this.closest('.riode-responsive-dropdown'),
            $toggle = $dropdown.find('.riode-responsive-toggle'),
            $control = $dropdown.parent(),
            $form = $control.next();
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
        var width = $this.data('width'),
            values = $form.val();
        $control.data('width', width);

        if (values) {
            values = JSON.parse(values);
        } else {
            values = {};
        }

        $control.find('.options-wrapper li').removeClass('active');
        if (undefined != values[width]) {
            $control.find('.options-wrapper [attr-value="' + values[width] + '"]').addClass('active');
        }
    }).off('responsive_changed', '.riode-wpb-button-group .riode-responsive-span li').on('responsive_changed', '.riode-wpb-button-group .riode-responsive-span li', function (e) {
        var $this = jQuery(this),
            $dropdown = $this.closest('.riode-responsive-dropdown'),
            $toggle = $dropdown.find('.riode-responsive-toggle'),
            $control = $dropdown.parent(),
            $form = $control.next();
        // Actions
        $this.addClass('active').siblings().removeClass('active');
        $dropdown.removeClass('show');
        $toggle.html($this.html());

        // Responsive Data
        var width = $this.data('width'),
            values = $form.val();
        $control.data('width', width);

        if (values) {
            values = JSON.parse(values);
        } else {
            values = {};
        }

        $control.find('.options-wrapper li').removeClass('active');
        if (undefined != values[width]) {
            $control.find('.options-wrapper [attr-value="' + values[width] + '"]').addClass('active');
        }
    }).on('click', '.riode-wpb-button-group .options-wrapper li', function (e) {
        var $this = jQuery(this),
            value = $this.attr('attr-value'),
            $control = $this.closest('.riode-wpb-button-group'),
            $form = $control.next();

        if (undefined == $control.data('width')) {
            $form.val(value);
            $form.trigger('change');
        } else {
            values = $form.val();
            if (values) {
                values = JSON.parse(values);
            } else {
                values = {};
            }

            values[$control.data('width')] = value;
            $form.val(JSON.stringify(values));
            $form.trigger('change');
        }

        $this.addClass('active').siblings().removeClass('active');
    });
    if (undefined == riode_core_vars.wpb_editor) {
        riode_core_vars.wpb_editor = {
            riode_button_group_included: true,
        }
    } else {
        riode_core_vars.wpb_editor.riode_button_group_included = true;
    }
}