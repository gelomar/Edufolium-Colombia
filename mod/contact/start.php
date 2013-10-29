<?php

function contact_init() 
		{
		global $CONFIG;
		
		//add_menu(elgg_echo('Contact Us!'), $CONFIG->wwwroot . "mod/contact");
		}
		
	register_elgg_event_handler('init','system','contact_init');

?>