<?php
/**
 * Renders a form submission page
 * 
 * @package hypeJunction
 * @subpackage hypeFormBuilder
 * @category Forms
 * @category User Interface
 * 
 * @uses int hjForm::$guid     NULL|INT GUID of an hjForm we are trying to edit
 * @return string HTML
 */
?><?php

elgg_load_js('hj.framework.ajax');

$limit = get_input('limit', 10);
$offset = get_input('offset', 0);

if (!$form_guid = get_input('f')) {
    $form_guid = NULL;
    $page_title = elgg_echo('hj:formbuilder:allforms');
    $options = array(
		'type' => 'object',
		'subtype' => 'hjformsubmission',
		'count' => true,
		'limit' => $limit,
		'offset' => $offset
	);

	$count = elgg_get_entities($options);
	$options['count'] = false;
	$submissions = elgg_get_entities($options);
} else {
    $form = get_entity($form_guid);
    $page_title = elgg_echo($form->getTitle());
    $options = array(
        'type' => $form->subject_entity_type,
        'subtype' => $form->subject_entity_subtype,
        'metadata_name' => 'data_pattern',
        'metadata_value' => $form_guid,
		'limit' => $limit,
		'offset' => $offset,
		'count' => true
            );

	$count = elgg_get_entities_from_metadata($options);
	$options['count'] = false;
	$submissions = elgg_get_entities_from_metadata($options);
}

$submissions = elgg_view_entity_list($submissions, array(
		'full_view' => true,
		'pagination' => true,
		'count' => $count,
		'limit' => $limit,
		'offset' => $offset
	));

$module_header = sprintf(elgg_echo('hj:formbuilder:formsubmissions'), $page_title);

$module = elgg_view_module('aside', $module_header, $submissions);
$page = elgg_view_layout('one_sidebar', array('content' => $module));

echo elgg_view_page($module_header, $page);