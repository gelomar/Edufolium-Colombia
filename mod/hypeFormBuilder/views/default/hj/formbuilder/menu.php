<?php
/**
 * Renders an admin controls menu for fields
 * 
 * @package hypeJunction
 * @subpackage hypeFormBuilder
 * @category Forms
 * @category Admin Interface
 * 
 * @uses hjField
 * @uses ElggEntity An entity that this field is trying to edit
 * 
 * @return string HTML
 */
?><?php
$field = elgg_extract('entity', $vars, false);
if (!$field) {
    return true;
}
$form = get_entity($field->container_guid);
$mode = elgg_extract('mode', $vars, 'beginner');

$params = hj_framework_extract_params_from_entity($field);
$metadata = elgg_view_menu('hjfield', array(
    'entity' => $field,
    'mode' => $mode,
    'sort_by' => 'priority',
    'class' => 'elgg-menu-hz',
	'params' => $params
        ));

$field_view .= <<<HTML
    <div class="clearfix"><span class="hj-right">
        $metadata
    </span></div>
HTML;

echo $field_view;