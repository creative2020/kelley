<?php

/* ======================================================================= */
/* == Custom Post Maker ================================================== */
/* ======================================================================= */

/* 

Author - WPTitans
Code Name - Loki
Version - 2.0
Description - Creates custom panels for themes that works on Hades V3 Framework.

*/



if(!class_exists('Loki')) {

// == Class defination begins	=====================================================
  class Loki {
	  
	  private $name;
	  private $panelName;
	  private $type;
	  private $icon;
	  
	   // == Constructor ==============================================================
      function __construct($name,$type='page',$panel_name=false, $icon = false){ 
	  
		$this->name = $name;
		if(!$panel_name)
		$this->panelName = strtoupper(substr($name,0,5));
		else
		$this->panelName = 	$panel_name;
		
		$this->type = $type;
		
		if(!$icon)
		$this->icon  = HURL."/css/i/icon.png";
		else
		$this->icon = $icon;
		
		add_action('admin_menu',array($this,'manager_admin_menu'));
        add_action('admin_init',array($this,'manager_admin_init'));
		
	  }
	  
	  function manager_admin_menu(){
		
		  
	   switch($this->type)
	   {
		   case 'page' : add_menu_page( $this->name,  $this->name , 'edit_themes', $this->panelName ,array($this,'manager_admin_wrap'),  $this->icon);  break;
		   case 'submenu':  add_submenu_page("hades", $this->name, $this->name, 'edit_themes', $this->panelName ,array($this,'manager_admin_wrap')); break;
	   }
		  
				  
	  }
		  
	  function manager_admin_init(){	
	  
	   wp_enqueue_script('thickbox');
	   wp_enqueue_style('thickbox');
	   wp_enqueue_script('jquery-ui-sortable');
	  
	  
	    }	
	  
	  function manager_admin_wrap(){	 }	  
	  
	   } // == End of Class ==========================
     
	 
	 function getPanelname()
	 {
		 return $this->panelName;
	 }
}
