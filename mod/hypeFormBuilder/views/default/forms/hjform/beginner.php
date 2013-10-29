<?php
/**
 * Renders an HTML hjForm edit form
 * 
 * @package hypeJunction
 * @subpackage hypeFormBuilder
 * @category Forms
 * @category Admin Interface
 * 
 * @uses hjForm 
 * 
 * @return string HTML
 */
?><?php

admin_gatekeeper();

if (isset($vars['form'])) {
    $form = $vars['form'];
    $url_hint = sprintf(
            elgg_echo('hj:formbuilder:hint:form_url'), elgg_view('output/url', array(
                'value' => $form->getURL(),
                'target' => '_blank')
            ));
    $submissions_hint = sprintf(
            elgg_echo('hj:formbuilder:hint:submissions_url'), elgg_view('output/url', array(
                'value' => elgg_normalize_url("hjform/submissions/$form->guid"),
                'target' => '_blank')
            ));
    $guid_hint = sprintf(
            elgg_echo('hj:formbuilder:hint:form_guid'), $form->guid);

    $module_title = $form->title;

    
} else {
    $form->guid = NULL;
    $form->action = 'action/framework/entities/save';
    $form->method = 'POST';
    $form->enctype = 'multipart/form-data';
    $form->subject_entity_type = 'object';
    $form->subject_entity_subtype = 'hjformsubmission';
    $module_title = elgg_echo('hj:formbuilder:newform');
}

// Define dropdown fields with options
$form_enctype_options = array('multipart/form-data', 'application/x-www-form-urlencoded', 'text/plain');
$form_method_options = array('POST', 'GET');

$title_label = elgg_echo('hj:formbuilder:label:form_title');
$title_input = elgg_view('input/text', array(
    'name' => 'form_title',
    'value' => $form->title,
    'class' => 'mandatory'
        ));

$label_label = elgg_echo('hj:formbuilder:label:form_label');
$label_input = elgg_view('input/text', array(
    'name' => 'form_label',
    'value' => $form->label,
    'class' => 'mandatory'
        ));

$section_label = elgg_echo('hj:formbuilder:label:section');
$section_input = elgg_view('input/text', array(
    'name' => 'form_section_beginner',
    'value' => $form->subject_entity_subtype
        ));


$description_label = elgg_echo('hj:formbuilder:label:form_description');
$description_input = elgg_view('input/longtext', array(
    'name' => 'form_description',
    'value' => $form->description,
    'class' => 'elgg-input-longtext'
        ));

//$action_label = elgg_echo('hj:formbuilder:label:form_action');
$action_input = elgg_view('input/hidden', array(
    'name' => 'form_action',
    'value' => $form->action,
    'class' => 'mandatory',
        ));
//$action_hint = elgg_echo('hj:formbuilder:hint:form_action');

//$method_label = elgg_echo('hj:formbuilder:label:form_method');
$method_input = elgg_view('input/hidden', array(
    'name' => 'form_method',
    'value' => $form->method,
    //'options' => $form_method_options
        ));

//$enctype_label = elgg_echo('hj:formbuilder:label:form_enctype');
$enctype_input = elgg_view('input/hidden', array(
    'name' => 'form_enctype',
    'value' => $form->enctype,
    //'options' => $form_enctype_options
        ));

//$eval_label = elgg_echo('hj:formbuilder:label:form_eval');
//$eval_input = elgg_view('input/dropdown', array(
//    'name' => 'form_eval',
//    'options_values' => array(true => 'Yes', false => 'No'),
//    'value' => $form->eval
//));
//$eval_hint = elgg_echo('hj:formbuilder:hint:form_eval');

$on_submit_keys = (array(
    'notify_admins',
    'add_to_river',
    'comments_on',
    'ajaxify'
        ));

foreach ($on_submit_keys as $key) {
    if ($form->$key)
        $on_submit_options[] = $key;
}
$on_submit_label = elgg_echo('hj:formbuilder:label:on_submit');
$on_submit_input = elgg_view('input/checkboxes', array(
    'name' => 'form_on_submit',
    'value' => $on_submit_options,
    'options' => array(
        elgg_echo('hj:formbuilder:notify_admins') => 'notify_admins',
        elgg_echo('hj:formbuilder:add_to_river') => 'add_to_river',
        elgg_echo('hj:formbuilder:comments_on') => 'comments_on',
        elgg_echo('hj:formbuilder:submitviajax') => 'ajaxify'
    )
        ));

//$entity_type_label = elgg_echo('hj:formbuilder:label:container_type');
$entity_type_input = elgg_view('input/hidden', array(
    'name' => 'subject_entity_type',
    'value' => $form->subject_entity_type,
        ));
$entity_subtype_input = elgg_view('input/hidden', array(
    'name' => 'subject_entity_subtype',
    'value' => $form->subject_entity_subtype,
        ));
//$class_label = elgg_echo('hj:formbuilder:label:form_class');
$class_input = elgg_view('input/hidden', array(
    'name' => 'form_class',
    'value' => $form->class
        ));

$access_label = elgg_echo('hj:formbuilder:label:form_access');
$access_input = elgg_view('input/access', array('name' => 'access_id', 'value' => $form->access_id));

$guid_input = elgg_view('input/hidden', array('name' => 'e', 'value' => $form->guid));
$guid_input .= elgg_view('input/hidden', array('name' => 'params', 'value' => json_encode($vars['params'])));

$submit_input = elgg_view('input/submit', array('value' => elgg_echo('save')));

//if ($form->guid) {
//    $delete_button = elgg_view('output/url', array(
//        'text' => elgg_echo('delete'),
//        'href' => "action/framework/entities/delete?e=$form->guid",
//        'is_action' => true,
//        'class' => 'elgg-button hj-menu-button',
//            ));
//}


$form_body = <<<HTML
    <div>
        $url_hint
    </div>
    <div>
        $submissions_hint
    </div>
    <div>
        $guid_hint
    </div>
    <div>
        <label for="form_title">$title_label</label>
            $title_input
    </div>
    <div>
        <label for="form_title">$label_label</label>
            $label_input
    </div>
    <div>
        <label for="form_title">$section_label</label>
            $section_input
    </div>
    <div>
        <label for="form_title">$description_label</label>
            $description_input
    </div>
    <div>
        <label for="form_action">$action_label</label>
            $action_input
            <div>$action_hint</div>
    </div>
    <div>
        <label for="form_action">$on_submit_label</label><br />
            $on_submit_input
    </div>
    <div>
        <label for="form_method">$method_label</label>
            $method_input
    </div>
    <div>
        <label for="form_enctype">$enctype_label</label>
            $enctype_input
    </div>
    <div>
        <label for="form_eval">$eval_label</label>
            $eval_input
            <div>$eval_hint</div>
    </div>
    <div>
        <label for="form_class">$class_label</label>
            $class_input
    </div>
    <div>
        <label for="form_class">$entity_type_label</label>
            $entity_type_input <br />
            $entity_subtype_input
    </div>
    <div>
        <label for="form_access">$access_label</label>
            $access_input
    </div>
    $security_input
    $guid_input
    $event_input
    <div>
        $submit_input
        $delete_button
    </div>
HTML;

$module_body = elgg_view('input/form', array(
    'body' => $form_body,
    'action' => 'action/hjform/save',
    'js' => 'onsubmit="return hj.formbuilder.fieldcheck.init($(this));"'
        ));

echo elgg_view_module('inline', $module_title, $module_body);