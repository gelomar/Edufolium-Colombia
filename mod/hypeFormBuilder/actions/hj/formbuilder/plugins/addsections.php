<?php

$plugin = get_input('plugin');
$plugin_sections = get_input('plugin_sections');

$plugin_sections = implode(',', $plugin_sections);
set_plugin_setting('hj:framework:sections:'.$plugin, $plugin_sections, 'hypeFramework');

system_message('hj:formbuilder:addsections:success');

forward(REFERER);