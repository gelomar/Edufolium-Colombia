hypeFormBuilder is part of the hypeJunction plugin bundle

This plugin is released under a GPL compatible license, as a courtesy of hypeJunction Club
Release of this plugin available at elgg.org might not always correspond to the latest stable release available at www.hypeJunction.com


PLUGIN DESCRIPTION
------------------
hypeFormBuilder is a fully-featured, PHP and AJAX powered tool, designed to simplify the process of building and modifying forms. 
hypeFormBuilder creates an administrator interface that lets you:
1) Create new forms, which can be accessed by your visitors and users through a direct URL
2) Create forms, which can be embeded into your site using Elgg API (elgg_view_entity();)
3) Easily modify pre-defined forms used by hypeJunction plugins
4) Track form submissions using administrator-accessible pages and notifications

Main features:
1) Create public or restricted forms
2) Add various form fields (text, longtext, dropdown, checkboxes, radio, date, file etc)
3) Easily modify input types and values
4) Easily rearrange order of fields in a form
5) Specify whether submission results should be sent via a notification, sent to river, and if comments should be allowed
6) Disable fields for input
7) Add required fields

REQUIREMENTS
------------
1) Elgg 1.8.3+
2) hypeFramework 1.8.5+

INTEGRATION / COMPATIBILITY
---------------------------
1) hypeFormBuilder integrates with most hypeJunction plugins that use forms.
2) Other plugins can integrate with hypeFormBuilder to create new input / output types (e.g. location, embed, etc)

INSTALLATION
------------
1) Unzip hypeFramework and hypeFormBuilder into your mod/ folder
2) Enable hypeFramework in your administrator control panel
3) Enable hypeFormBuilder in your administrator control panel
4) To start working with hypeFormBuilder, go to Administration -> Manage hJ -> Form Builder
5) As you enable other hypeJunction plugins, new forms will appear in the dropdown list

UPGRADING FROM PREVIOUS VERSION
-------------------------------
-- Disable all hype plugins, except hypeFramework
-- Disable hypeFramework
-- Backup your database and files
-- Remove all hype plugins from your server and upload the new version
-- Enable hypeFramework
-- Enable other hype plugins

USER GUIDE
----------
By default, you will see the administrator interface in a beginner mode, which has only some of the available features. To switch to advanced mode add ?mode=advanced to the url (e.g. /admin/hj/formbuilder?mode=advanced)

1) Create a new form (or select an existing form from the dropdown list)
    - Form Title : name of the form as it will appear on the front-end; passed through elgg_echo, so can be translated
    - Form Description : description of the form or introduction to appear under the form title
    - Action : relative path to the action, which will fire once the form is submitted. The default action of 'action/hjform/submit' can be used to store forms in your system and receive notifications when the new form is submitted
    - Method : POST or GET method used to pass the form details to the server
    - Encryption Type : encryption method used to pass forms to the server
    - Apply PHP eval() : enabling this feature will allow you to use PHP function(); and array(); definitions to specify default field values, field options, and field options_values
    - Additional CSS classes : any CSS classes you would like to use on your form
    - Form visibility : set the access level for your form
2) Once the form is saved you will see two new identifiers:
    - URL : direct url to your form. The form is rendered via a page_handler and can therefore be used as a standalone tool to collect data
    - GUID : unique Elgg identifier. Can be used within your plugins via elgg_view_entity();
3) Each form must have a set of Fields. Creating fields is quite straightforward:
    - Click on New field. A form will appear. Specify the following details:
        - Input Type : one of the input types pre-defined in Elgg. This uses Elgg's view system to render the type of input required within the form
        - Field Name : name of the field used by the action to process field data. Must NOT contain spaces. Names within the same form can NOT repeat each other
        - Field Label : label to be displayed with the field. Rendered via elgg_echo() call, and can therefore be used in various language translations
        - Field Value : default value. If PHP eval() is enabled, can be a string, array or function, e.g.  elgg_get_logged_in_user_entity()->email;  or  'hello'; MUST end with semincolon (;)
        - Field Class : user-defined classes to be applied to the field
        - Mandatory Field : if set to Yes, the user will be prompted to fill in the details if missing
        - Disable Field : if set to Yes, some fields will not be available for editing and will only contain the default value
        - Options : PHP eval() must be turned on for this to work. Set the value as   array('option1', 'option2' etc);  or  call a predefined function
        - Opitons_values : PHP eval() must be turned on for this to work. Set the value as   array('value1' => 'label1', 'value2' => 'label2' etc);  or  call a predefined function
4) You can change the order of fields by dragging and dropping them to the appropriate place

WARNINGS / NOTES
----------------
1) Input Type FILE will only be available to logged in users. Public use of the input causes a Fatal Exception
2) Input Type CHECKBOX can only accept Options array (it does not support options_values)

BUG REPORTS
-----------
Bugs and feature requests can be submitted at:
http://hypeJunction.com/trac