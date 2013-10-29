<?php

$plugin = elgg_extract('plugin', $vars, false);

if (!$plugin) {
    return true;
}

$form_body = '<label>' . elgg_echo('hj:formbuilder:admin:sections', array(elgg_echo('admin:hj:'.$plugin))) . '</label>';
$value = elgg_get_plugin_setting('hj:framework:sections:'.$plugin, 'hypeFramework');
$value = explode(',', $value);

$form_body .= elgg_view('input/checkboxes', array(
    'name' => 'plugin_sections',
    'value' => $value,
    'options' => hj_formbuilder_get_forms_as_sections(),
));

$form_body .= elgg_view('input/hidden', array(
    'name' => 'plugin',
    'value' => $plugin
));

$form_body .= elgg_view('input/submit', array('value' => elgg_echo('submit')));

$form = elgg_view('input/form', array(
    'body' => $form_body,
    'action' => 'action/hjplugins/addsections'
));

echo $form;