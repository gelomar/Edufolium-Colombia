<?php
/**
 * JavaScript helper to create sortable fields
 * 
 * @package hypeJunction
 * @subpackage hypeFormBuilder
 * @category Forms
 * @category Admin Interface
 * 
 */
?>
    elgg.provide('hj.formbuilder.sortable');

    /**
     * Initialize Sortable Fields
     */
    hj.formbuilder.sortable.init = function (hook, type, params, options) {
        $('#sortable-form-fields > ul').sortable({
            items:                'li.elgg-state-draggable',
            forcePlaceholderSize: true,
            placeholder:          'elgg-widget-placeholder',
            opacity:              0.8,
            revert:               500,
            stop:                 hj.formbuilder.sortable.moveField
        });
    }
    
    /**
     * Send index to an action
     */
    hj.formbuilder.sortable.moveField = function(e, ui) {
        var priorities = $('#sortable-form-fields > ul').sortable("toArray");
        elgg.action('action/framework/entities/move', {
            data: {
                priorities: priorities
            }
        });
    };
    
    /*
     * We need to reinitialize this lib on ajax success
     */
    elgg.register_hook_handler('success', 'hj:framework:ajax', hj.formbuilder.sortable.init);
