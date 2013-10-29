<?php
    // Load Elgg engine
    include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
 
    // make sure only logged in users can see this page	
    //gatekeeper();
 
    // set the title
    $title = "We wanna hear your feedback!";
 
    // start building the main column of the page
    $area1 = elgg_view_title($title);
 
    // Add the form to this section
    $area1 .= elgg_view("contact/contactform");
 
    // layout the page
  	$body = elgg_view('contact/contactform', array('content' => $area1));

    // draw the page

	echo  elgg_view_page($title, $body);

?>