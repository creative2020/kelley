<?php

/* ======================================================================= */
/* == Custom Post Maker ================================================== */
/* ======================================================================= */

/* 

Author - WPTitans
Code Name - Custom Post Maker
Version - 1.0
Description - Creates custom posts for themes that works on Hades Plus Framework.

*/


if(!class_exists('CustomPost')) {

// == Class defination begins	=====================================================
  class CustomPost {
  
  private $posts_options;
  private $name;
  private $taxonomy;
  
  function __construct($title,$custom_type,$taxonomy)
  {
	 $this->posts_options = $custom_type;
//	echo "<pre>"; print_r($custom_type); echo "</pre>";
	
	 $this->name = trim(str_replace(" ","",strtolower(strtolower($title))));
	 
	 
	 if(trim($this->posts_options['menu_icon'])=="")
	 $this->posts_options['menu_icon']  = NULL;
	 
	 add_action('init', array($this,'custom_register'));
	// echo "<pre>"; print_r($option_ar); echo "</pre>";
	$this->taxonomy = explode(",",$taxonomy);
	
  }
  
  
  
  function custom_register(){
    
	
	register_post_type( $this->name , $this->posts_options );

  	foreach($this->taxonomy as $tax)
	register_taxonomy(trim(str_replace(" ","",strtolower($tax))), array($this->name), 
	array(
	"hierarchical" => true, 
	"labels" => array( 'name' => $tax  ) , 
	"singular_label" => "type", 
	
	"rewrite" => true));
	
	
	flush_rewrite_rules();
	 }
	 
	 } // == Class Ends ================================================================
  }
  
   