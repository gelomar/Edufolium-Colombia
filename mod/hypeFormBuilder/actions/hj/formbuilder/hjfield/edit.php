<?php
/**
 * Action to render an HTML form to edit an instanceof hjField
 * 
 * @package hypeJunction
 * @subpackage hypeFramework
 * @category Forms
 * @category Admin Interface
 * 
 * @uses int hjForm::$guid NULL|INT GUID of an hjForm containing hjField
 * @uses int hjField:$guid NULL|INT GUID of an hjField we are editing
 * 
 * @return json
 */
?><?php

admin_gatekeeper();
elgg_set_context('admin');

$params = get_input('params');
$form_guid = $params['container_guid'];
$field_guid = $params['entity_guid'];

$mode = get_input('mode', 'beginner');

if (!$form_guid &&
        !$field_guid) {
    return true;
}
if ($field_guid) {
    $field = get_entity($field_guid);
    $form = $field->getContainerEntity();
}

if ($form_guid) {
    $form = get_entity($form_guid);
}

if ($field) {
    $output['data'] = elgg_view("forms/hjfield/$mode", array(
        'field' => $field,
        'form' => $form,
		'params' => $params
            ));
} else {
    $output['data'] = "<li class=\"{$params['item_class']}\">" . elgg_view("forms/hjfield/$mode", array(
        'form' => $form,
		'params' => $params
            ));
}
$json = json_encode($output);
print($json);
return true;