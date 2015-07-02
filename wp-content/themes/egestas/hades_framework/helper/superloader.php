<?php
/* 
  =================================================================
  ~~ File that Initates Hades Framework ===========================
  =================================================================
  
  ~~ Works on Hades V3 Framework only.
*/


$themename = 'Egestas';
$sn = $shortname = "ULT";
define('SN',$shortname);
define('THEMENAME',$themename);

$options = array();  // Options array
$super_options = array(); // precaching of get options variables.


// == Load All necessary classes for the Hades Framework ================================

//include_once('megamenu.php');
include_once('CustomPost.php');
include_once('metabox.php');
include_once('helper.php');
include_once(HPATH.'/option_panel/options.php');
include_once('class_admin_panel_maker.php');   	// Base Class for creating panels
include_once('class_slider.php');



	

/* ============================================================ */
/* == Load Options Panel ====================================== */
/* ============================================================ */

include('options_panel.php'); // == ~~ Required for all sub menus to be created ~~
include('titan_editor.php');  // == ~~ Template Builder ~~
include('slidermanager.php'); // == ~~ Slider Manager  ~~
require('sidebar_manager.php'); // == ~~ Sidebar Manager ~~

require(HPATH.'/helper/installer/init.php'); 

require(HPATH.'/helper/widgets.php'); // == ~~ Widgets ~~


require(HPATH.'/helper/shortcodes.php'); // == ~~ Shortcodes ~~