    elgg.provide('hj.formbuilder.base');

    /**
     * On document load we want to trigger a change of the dropdown field
     */
    hj.formbuilder.base.init = function() {
        $('select[name="e"]')
        .live('change.ajaxLoadOnChange', hj.formbuilder.base.onChange)
        .trigger('change.ajaxLoadOnChange');
    }
    
    hj.formbuilder.base.onChange = function(event) {
        var formGuid = $(this).val();
        var mode = $('input[name="mode"]').val();
        var form_object = $('#hj-formbuilder-container-form');
        var form_object_fields = $('#hj-formbuilder-container-fields');
        
        var loader = '<div class="hj-ajax-loader hj-loader-circle"></div>';
        form_object.html(loader);
        form_object_fields.html(loader);
        
        elgg.action('hjform/edit', {
            data : {
                   e : formGuid,
                   mode : mode
            },
            success : function (data) {
                form_object.html(data.output['form-object']);
                form_object_fields.html(data.output['data']);
                hj.formbuilder.sortable.init();
                elgg.trigger_hook('success', 'hj:framework:ajax');
            }
        });
    }

    elgg.register_hook_handler('init', 'system', hj.formbuilder.base.init, 800);