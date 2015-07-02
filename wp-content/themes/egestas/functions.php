<?php 

/*

Author - WPTitans
File Function - Main file for inovking all functions in WP

*/

load_theme_textdomain('h-framework',get_template_directory() .'/lang'); // Localization Support

$locale = get_locale();
$locale_file = get_template_directory() ."/lang/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);
	
/* ================================================================================== */
/* == Init SuperLoader ============================================================== */
/* ================================================================================== */

define('HPATH',get_template_directory() .'/hades_framework');
define('HURL',get_template_directory_uri().'/hades_framework');
define('PATH',get_template_directory() );
define('URL',get_template_directory_uri());

require_once(HPATH.'/helper/superloader.php');

