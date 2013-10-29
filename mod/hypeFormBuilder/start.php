<?php

/* hypeFormBuilder
 * Provides an admin interface for form management
 * 
 * @package hypeJunction
 * @subpackage hypeFormBuilder
 * @category Forms
 * @author Ismayil Khayredinov <ismayil.khayredinov@gmail.com>
 * @copyright Copyrigh (c) 2011, Ismayil Khayredinov
 */
?>
<?php

elgg_register_event_handler('init', 'system', 'hj_formbuilder_init');

function hj_formbuilder_init() {
    $plugin = 'hypeFormBuilder';
    
    if (!elgg_is_active_plugin('hypeFramework')) {
        register_error(elgg_echo('hj:framework:disabled', array($plugin, $plugin)));
        disable_plugin($plugin);
    }
    
    $shortcuts = hj_framework_path_shortcuts($plugin);

    // Pick up the view from admin/hj/formbuilder
    elgg_register_admin_menu_item('administer', 'formbuilder', 'hj', 100);

    elgg_register_plugin_hook_handler('register', 'menu:hjform', 'hj_formbuilder_form_menu', 700);
    elgg_register_plugin_hook_handler('register', 'menu:hjfield', 'hj_formbuilder_field_menu', 700);

    // Base JS
    $hj_js_formbuilder = elgg_get_simplecache_url('js', 'hj/formbuilder/base');
    elgg_register_js('hj.formbuilder.base', $hj_js_formbuilder);

    // JS to sort fields
    $hj_js_sortable = elgg_get_simplecache_url('js', 'hj/formbuilder/sortable');
    elgg_register_js('hj.formbuilder.sortable', $hj_js_sortable);

    // CSS
    $hj_css = elgg_get_simplecache_url('css', 'hj/formbuilder/base');
    elgg_register_css('hj.formbuilder.base', $hj_css);

    // Register hjForm Actions
    elgg_register_action('hjform/edit', $shortcuts['actions'] . 'hj/formbuilder/hjform/edit.php', 'admin');
    elgg_register_action('hjform/save', $shortcuts['actions'] . 'hj/formbuilder/hjform/save.php', 'admin');

    // Register hjField Actions
    elgg_register_action('hjfield/edit', $shortcuts['actions'] . 'hj/formbuilder/hjfield/edit.php', 'admin');
    elgg_register_action('hjfield/save', $shortcuts['actions'] . 'hj/formbuilder/hjfield/save.php', 'admin');
    
    elgg_register_action('hjplugins/addsections', $shortcuts['actions'] . 'hj/formbuilder/plugins/addsections.php', 'admin');
    
    // Create a way to view forms via URL
    elgg_register_entity_url_handler('object', 'hjform', 'hj_formbuilder_hjform_url_handler');
    elgg_register_page_handler('hjform', 'hj_formbuilder_hjform_page_handler');
    elgg_register_page_handler('hjfield', 'hj_formbuilder_hjfield_page_handler');

    elgg_extend_view('admin/hj/sections/extend', 'hj/formbuilder/sections');
    
    elgg_load_library('hj:framework:forms');
}

/**
 *  Defines a default URL to handle hjForms
 * 
 * @param hjForm $entity 
 * @return str 
 */
function hj_formbuilder_hjform_url_handler($entity) {
    $friendly_title = elgg_get_friendly_title($entity->title);
    return "hjform/view/{$entity->guid}/$friendly_title";
}

/**
 *  Defines what page to include depending on the URL structure
 *  Concerns hjForms
 * 
 * @param array $page 
 */
function hj_formbuilder_hjform_page_handler($page) {
    elgg_load_css('hj.formbuilder.base');
    switch ($page[0]) {
        // page_handler to view the form
        case 'view' :
            elgg_set_page_owner_guid(elgg_get_site_entity()->guid);
            if (isset($page[1])) {
                set_input('f', $page[1]);
            } else {
                forward();
            }
            include elgg_get_plugins_path() . 'hypeFormBuilder/pages/formbuilder/hjform/view.php';
            break;

        // page_handler to submit the form
        case 'submissions' :
            if (!elgg_is_admin_logged_in()) {
				forward();
			}
            if (isset($page[1])) {
                set_input('f', $page[1]);
            }
            include elgg_get_plugins_path() . 'hypeFormBuilder/pages/formbuilder/hjform/submissions.php';
            break;
    }
    return true;
}

/**
 * Defines what pages to render depending on the URL structure
 * Concerns hjFields
 * 
 * @param type $page 
 */
function hj_formbuilder_hjfield_page_handler($page) {
    $entity = get_entity($page[1]);
    $container = get_entity($entity->container_guid);
    forward ("admin/hj/formbuilder?f=$container->guid");
    return true;
}

/**
 * Creates a hook for the form field edit menu
 * 
 * @param string $hook
 * @param string $type
 * @param array $return
 * @param array $params
 * @return array 
 */
function hj_formbuilder_form_menu($hook, $type, $return, $params) {

    $form = elgg_extract('entity', $params);
    $mode = elgg_extract('mode', $params, 'beginner');
	$data_options = hj_framework_json_query($params);

    // AJAXed Add Button
    $add = array(
        'name' => 'add',
        'title' => elgg_echo('hj:formbuilder:newfieldform'),
        'text' => elgg_view_icon('hj hj-icon-add') . '<span class="hj-icon-text">' . elgg_echo('hj:formbuilder:newfieldform') . '</span>',
        'href' => "action/hjfield/edit",
		'data-options' => htmlentities($data_options, ENT_QUOTES, 'UTF-8'),
        'is_action' => true,
        'rel' => 'fancybox',
        'id' => "hj-ajaxed-add-{$section}",
        'class' => "hj-ajaxed-add",
        'target' => "",
        'priority' => 200
    );
    $return[] = ElggMenuItem::factory($add);

    $delete = array(
        'name' => 'delete',
        'title' => elgg_echo('hj:forbuilder:deleteform'),
        'text' => elgg_view_icon('hj hj-icon-delete') . '<span class="hj-icon-text">' . elgg_echo('hj:formbuilder:deleteform') . '</span>',
        'href' => "action/framework/entities/delete?e={$form->guid}",
		'data_options' => htmlentities($data_options, ENT_QUOTES, 'UTF-8'),
        'is_action' => true,
        'confirm' => elgg_echo('question:areyousure'),
        'priority' => 900
    );
    $return[] = ElggMenuItem::factory($delete);

    return $return;
}

function hj_formbuilder_field_menu($hook, $type, $return, $params) {

    $entity = elgg_extract('entity', $params);
    $mode = elgg_extract('mode', $params, 'beginner');

	$params = hj_framework_json_query($params);
	$params = htmlentities($params, ENT_QUOTES, 'UTF-8');
	
    $edit = array(
        'name' => 'edit',
        'title' => elgg_echo('hj:framework:edit'),
        'text' => elgg_view_icon('hj hj-icon-edit'),
        'rel' => 'fancybox',
        'href' => "action/hjfield/edit",
		'data-options' => $params,
        'id' => "hj-ajaxed-edit-{$entity->guid}",
        'class' => "hj-ajaxed-edit",
        'target' => "#elgg-object-{$entity->guid}",
        'priority' => 800
    );
    $return[] = ElggMenuItem::factory($edit);

    $delete = array(
        'name' => 'delete',
        'title' => elgg_echo('hj:framework:delete'),
        'text' => elgg_view_icon('hj hj-icon-delete'),
        'href' => "action/framework/entities/delete?e={$entity->guid}",
		'data-options' => $params,
        'id' => "hj-ajaxed-remove-{$entity->guid}",
        'class' => 'hj-ajaxed-remove',
        'target' => "#elgg-object-{$entity->guid}",
        'priority' => 900,
    );
    $return[] = ElggMenuItem::factory($delete);
    return $return;
}