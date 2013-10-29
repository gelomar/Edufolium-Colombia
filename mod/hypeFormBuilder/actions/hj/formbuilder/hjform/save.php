<?php
/**
 * Saves hjForm properties
 * 
 * @package hypeJunction
 * @subpackage hypeFormBuilder
 * @category Forms
 * @category Admin Interface
 * 
 * @uses int   hjForm::$guid   NULL|INT GUID of an hjForm we are editing
 */
?><?php
// Is this a new hjForm?
if (!$form_guid = get_input('e')) {
    $form_guid = NULL;
}
$mode = get_input('mode', 'beginner');

// Let's save all the data we have received
$form = new hjForm($form_guid);
$form->title = get_input('form_title');
$form->label = get_input('form_label');
$form->description = get_input('form_description');
//$form->container_guid = get_input('container_guid'); //@todo Add Group support?
$form->action = get_input('form_action');
$form->method = get_input('form_method');
$form->enctype = get_input('form_enctype');
$form->class = get_input('form_class');
$form->subject_entity_type = get_input('subject_entity_type');
$form->subject_entity_subtype = get_input('subject_entity_subtype');
$on_submit = get_input('form_on_submit');

// Hack to process checkboxes
$on_submit_keys = (array(
    'notify_admins',
    'add_to_river',
    'comments_on',
    'ajaxify'
        ));
foreach ($on_submit_keys as $key) {
    $form->$key = in_array($key, $on_submit);
}
$form->access_id = get_input('access_id');

$section = get_input('form_section_beginner');
if ($section) {
    $section = strtolower(str_replace(' ', '', $section));
    $form->subject_entity_subtype = $section;
    //$form->ajaxify = true;
}
//@todo Create protected forms?
//$form->protected = get_input('protected');

if ($form->save()) {
    system_message(elgg_echo('hj:formbuilder:form:savesuccess'));
    forward("admin/hj/formbuilder?e={$form->guid}&mode={$mode}");
} else {
    register_error(elgg_echo('hj:formbuilder:form:saveerror'));
    forward(REFERER);
}