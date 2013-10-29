<?php

/**
 * Action to save an instance of hjField contained in hjForm
 * 
 * @package hypeJunction
 * @subpackage hypeFormBuilder
 * @category Forms
 * @category Admin Interface
 * 
 * @uses int       hjForm:$guid      NULL|INT GUID of an hjForm containing hjField
 * @uses int       hjField:$guid     NULL|INT GUID of an hjField we are editing
 * 
 * @return void
 */
?><?php
admin_gatekeeper();
elgg_set_context('admin');

if (!$field_guid = get_input('e')) {
    $field_guid = NULL;
    $field = NULL;
} else {
    $field = get_entity($field_guid);
}

// hjFields must have a container as we need to map them back to the proper hjForm
if (!$field && !$container_guid = get_input('c')) {
    register_error(elgg_echo('hj:formbuilder:field:save:error'));
    forward(REFERER);
} elseif ($field) {
    $container_guid = $field->container_guid;
}
$container = get_entity($container_guid);

$mode = get_input('mode', 'beginner');

$field = new hjField($field_guid);
$field->title = get_input('field_name', 'field_' . rand(0, 1000));
$field->input_type = get_input('field_type', 'text');
$field->owner_guid = elgg_get_site_entity()->guid; // Fields are owned by the site
$field->container_guid = $container->guid; // Fields are contained by a Form
$field->name = get_input('field_name', 'field_name_' . rand(0, 1000));
$field->title = get_input('field_title', 'field_title_' . rand(0, 1000));
$field->value = get_input('field_value', '');
$field->class = get_input('field_class', '');
$field->mandatory = get_input('field_mandatory', false);
$field->disabled = get_input('field_disabled', false);
$field->options = get_input('field_options', 'array();');
$field->beginner_options = get_input('beginner_field_options', null);
$field->options_values = get_input('field_options_values', 'array();');
$field->access_id = $container->access_id;

if ($beginner_options = $field->beginner_options) {
    $options = explode(',', $beginner_options);
    switch ($field->input_type) {
        default :
            foreach ($options as $option) {
                $option_key = trim(strtolower($option));
                $option_value = trim($option);
                $options_values .= "\"$option_key\" => \"$option_value\",";
            }
            $options_values = "array($options_values);";
            $field->options_values = $options_values;
            break;
        case 'checkboxes' :
        case 'radio' :
            foreach ($options as $option) {
                $option_value = trim(strtolower($option));
                $option_label = trim($option);
                $options_values .= "\"$option_label\" => \"$option_value\",";
            }
            $options_values = "array($options_values);";
            $field->options = $options_values;
            break;
    }
    
}

if ($field->save()) {
    hj_framework_set_entity_priority($field);
    system_message(elgg_echo('hj:formbuilder:field:save:success'));
    if (elgg_is_xhr()) {
        $output['data'] = "<li id=\"elgg-object-$field->guid\">" . elgg_view_entity($field, array('full_view' => true)) . '</li>';
        print(json_encode($output));
        return true;
    }
    forward("admin/hj/formbuilder?e={$container->guid}&mode={$mode}");
} else {
    register_error(elgg_echo('hj:formbuilder:field:save:error'));
    forward(REFERER);
}