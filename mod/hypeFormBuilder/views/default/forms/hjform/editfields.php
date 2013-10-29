<?php

/**
 * Renders an HTML form for editing a list of fields contained with an hjForm
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

$form = elgg_extract('form', $vars, false);
$mode = elgg_extract('mode', $vars, 'beginner');
if ($form) {
	$fields = $form->getFields();

	$title = elgg_echo('hj:formbuilder:bodytitle');

	$params = array(
		'mode' => $mode,
		//'entity_guid' => $form->guid,
		'container_guid' => $form->guid,
		'list_class' => 'hj-form-admin-fields-list',
		'item_class' => 'hj-view-entity elgg-state-draggable',
		'target' => "hj-form-fields-$form->guid",
		'dom_order' => 'append'
	);

	$menu = elgg_view_menu('hjform', array(
		'entity' => $form,
		'mode' => $mode,
		'handler' => 'hjform',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
		'params' => $params
			));

	$menu = "<div class=\"clearfix\"><div class=\"hj-right hj-padding-ten\">$menu</div></div>";

	$params['list_id'] = $params['target'];

	$fields_view = elgg_view_entity_list($fields, $params);

	$sortable = "<div id=\"sortable-form-fields\">$fields_view</div>";
}

$header = "$title $menu";
$content = "$sortable";

$module = elgg_view_module('main', $header, $content);

echo $module;