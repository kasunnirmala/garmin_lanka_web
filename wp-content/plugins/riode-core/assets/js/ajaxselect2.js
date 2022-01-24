jQuery(window).on('elementor:init', function() {
    var $ = jQuery,
        riodeAjaxSelect2ControlView = elementor.modules.controls.BaseData.extend({
        onReady: function () {
            var self = this,
                $el = self.ui.select,
                url = $el.attr('data-ajax-url');

            $el.select2({
                ajax: {
                    url: url,
                    dataType: 'json',
                    data: function (params) {
                        var args = {
                            s: params.term
                        };
                        if (typeof $el.attr('multiple') == 'undefined') {
                            args['add_none'] = '1';
                        }
                        return args;
                    }
                },
                cache: true
            });
            var ids = (typeof self.getControlValue() !== 'undefined') ? self.getControlValue() : '';
            if (ids.isArray) {
                ids = self.getControlValue().join();
            }

            $.ajax({
                url: url,
                dataType: 'json',
                data: {
                    ids: String(ids)
                }
            }).then(function (res) {

                if (null !== res && res.results.length > 0) {
                    $.each(res.results, function (index, value) {
                        $el.append(new Option(value.text, value.id, true, true)).trigger('change');
                    });
                    $el.trigger({
                        type: 'select2:select',
                        params: {
                            data: res
                        }
                    });
                }
            });
        },
        onBeforeDestroy: function onBeforeDestroy() {
            if (this.ui.select.data('select2')) {
                this.ui.select.select2('destroy');
            }
            this.$el.remove();
        }
    });
    elementor.addControlView('riode_ajaxselect2', riodeAjaxSelect2ControlView);
});
