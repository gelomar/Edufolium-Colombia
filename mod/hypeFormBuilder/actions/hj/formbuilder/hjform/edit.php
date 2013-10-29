<?php
/**
 * Responds to an AJAX call from views/default/admin/hj/formbuilder
 * Renders 2 blocks
 * 
 * @package hypeJunction
 * @subpackage hypeFormBuilder
 * @category Forms
 * @category Admin Interface
 * 
 * @uses int    hjForm::$guid   NULL|INT GUID of an hjForm we are trying to edit
 * @return json
 */
?><?php
// Set an admin context in case we are calling from xhr
admin_gatekeeper();
elgg_set_context('admin');

if (!$form_guid = get_input('e')) {
    $form_guid = NULL;
    $form = NULL;
} else {
    $form = get_entity($form_guid);
}

$mode = get_input('mode', 'beginner');

$form_edit = elgg_view("forms/hjform/$mode", array('form' => $form));

if ($form) {
    $form_fields_edit = elgg_view('forms/hjform/editfields', array('form' => $form, 'mode' => $mode));
} else {
    $form_fields_edit = elgg_echo('hj:formbuilder:defineformfirst');
}

$output['form-object'] = strval($form_edit);
$output['data'] = strval($form_fields_edit);

$json = json_encode($output);
print($json);
return true;