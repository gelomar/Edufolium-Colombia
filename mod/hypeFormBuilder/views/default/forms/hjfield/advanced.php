<?php

/**
 * Renders an HTML hjField edit form
 * 
 * @package hypeJunction
 * @subpackage hypeFormBuilder
 * @category Forms
 * @category Admin Interface
 * 
 * @uses hjForm 
 * @uses hjField
 * 
 * @return string HTML
 */
?><?php

admin_gatekeeper();

if (!isset($vars['form'])) {
    return true;
} else {
    $form = $vars['form'];
}

if (isset($vars['field'])) {
    $field = $vars['field'];
    $module_title = $field->title;
} else {
    $field->guid = NULL;
    $field->input_type = 'text';
    $module_title = elgg_echo('hj:formbuilder:newfieldform');
}

// Define dropdown fields with options
$field_type_options = hj_formbuilder_get_input_types_array();

$type_label = elgg_echo('hj:formbuilder:label:field_type');
$type_input = elgg_view('input/dropdown', array(
    'name' => 'field_type',
    'value' => $field->input_type,
    'options' => $field_type_options,
    'class' => 'mandatory'
        ));

$name_label = elgg_echo('hj:formbuilder:label:field_name');
$name_input = elgg_view('input/text', array(
    'name' => 'field_name',
    'value' => $field->name,
    'class' => 'mandatory'
        ));

$label_label = elgg_echo('hj:formbuilder:label:field_label');
$label_input = elgg_view('input/text', array(
    'name' => 'field_title',
    'value' => $field->title,
    'class' => 'mandatory'
        ));

$value_label = elgg_echo('hj:formbuilder:label:field_value');
$value_input = elgg_view('input/text', array(
    'name' => 'field_value',
    'value' => $field->value,
        ));
$value_hint = elgg_echo('hj:formbuilder:hint:field_value');

$class_label = elgg_echo('hj:formbuilder:label:field_class');
$class_input = elgg_view('input/text', array(
    'name' => 'field_class',
    'value' => $field->class,
        ));

if ($field->mandatory) {
    $mandatory_value = 1;
} else {
    $mandatory_value = 0;
}
$mandatory_label = elgg_echo('hj:formbuilder:label:field_mandatory');
$mandatory_input = elgg_view('input/radio', array(
    'name' => 'field_mandatory',
    'value' => $mandatory_value,
    'options' => array('Yes' => 1, 'No' => 0)
        ));

if ($field->disabled) {
    $disabled_value = 1;
} else {
    $disabled_value = 0;
}
$disabled_label = elgg_echo('hj:formbuilder:label:field_disabled');
$disabled_input = elgg_view('input/radio', array(
    'name' => 'field_disabled',
    'value' => $disabled_value,
    'options' => array('Yes' => 1, 'No' => 0)
        ));

/**
 * @todo make this more user friendly by adding text fields for individual options
 */
$options_label = elgg_echo('hj:formbuilder:label:field_options');
$options_input = elgg_view('input/text', array(
    'name' => 'field_options',
    'value' => $field->options,
        ));
$options_hint = elgg_echo('hj:formbuilder:hint:field_options');

/**
 * @todo make this more user friendly by adding text fields for individual options and values
 */
$options_values_label = elgg_echo('hj:formbuilder:label:field_options_values');
$options_values_input = elgg_view('input/longtext', array(
    'name' => 'field_options_values',
    'value' => $field->options_values,
    'class' => 'elgg-input-longtext'
        ));

//$access_label = elgg_echo('hj:formbuilder:label:form_access');
//$access_input = elgg_view('input/access');

$guid_input = elgg_view('input/hidden', array('name' => 'e', 'value' => $field->guid));
$guid_input .= elgg_view('input/hidden', array('name' => 'params', 'value' => json_encode($vars['params'])));
$f_input = elgg_view('input/hidden', array('name' => 'c', 'value' => $form->guid));
if ($field->guid) {
    $event = 'update';
} else {
    $event = 'create';
}
$event_input = elgg_view('input/hidden', array('name' => 'ev', 'value' => $event));

$submit_input = elgg_view('input/submit', array('value' => elgg_echo('save')));

$form_body = <<<HTML
    <div>
        <label for="field_type">$type_label</label>
            $type_input
    </div>
    <div>
        <label for="field_name">$name_label</label>
            $name_input
    </div>
    <div>
        <label for="field_label">$label_label</label>
            $label_input
            <div>$label_hint</div>
    </div>

    <div>
        <label for="field_value">$value_label</label>
            $value_input
            <div>$options_hint</div>
    </div>
    <div>
        <label for="field_class">$class_label</label>
            $class_input
    </div>
    <div>
        <label for="field_mandatory">$mandatory_label</label>
            $mandatory_input
    </div>
    <div>
        <label for="field_disabled">$disabled_label</label>
            $disabled_input
    </div>    
    <div>
        <label for="field_options">$options_label</label>
            $options_input
            <div>$options_hint</div>
    </div>
    <div>
        <label for="field_options_values">$options_values_label</label>
            $options_values_input
            <div>$options_hint</div>
    </div>    
    $guid_input
    $f_input
    $event_input
    <div>
        $submit_input
    </div>
HTML;

if (!$field->guid) {
    $target .= "#hj-section-hjform";
} else {
    $target .= "#elgg-object-{$field->guid}";
}

$module_body = elgg_view('input/form', array(
'body' => $form_body,
 'action' => 'action/hjfield/save',
 'class' => 'hj-ajaxed-save',
 'target' => "$target",
 'js' => 'onsubmit="return hj.formbuilder.fieldcheck.init($(this));"'
));

echo elgg_view_module('inline', $module_title, $module_body);