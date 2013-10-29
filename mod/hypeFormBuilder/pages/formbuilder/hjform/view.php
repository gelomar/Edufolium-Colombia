<?php

/**
 * Renders a form view page
 * 
 * @package hypeJunction
 * @subpackage hypeFormBuilder
 * @category Forms
 * @category User Interface
 * 
 * @uses int hjForm::$guid     NULL|INT GUID of an hjForm we are trying to edit
 * @return string HTML
 */

$form_guid = get_input('f');
$form = get_entity($form_guid);

if (!elgg_is_logged_in()) {
	$owner_guid = 0;
	$container_guid = 0;
} else {
	$owner_guid = elgg_get_logged_in_user_guid();
	$container_guid = elgg_get_logged_in_user_guid();
}

$params = array(
	'container_guid' => $container_guid,
	'owner_guid' => $owner_guid,
	'access_id' => ACCESS_PRIVATE,
	'form_guid' => $form->guid,
	'ajaxify' => false,
	'full_view' => true

);

$form_view = elgg_view_entity($form, $params);
$page_title = elgg_echo($form->getTitle());

$page = elgg_view_layout('one_sidebar', array('content' => $form_view));

echo elgg_view_page($page_title, $page);