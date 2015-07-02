<?php

function add_media_label_header($_default_tabs)
		{	
			
			//change the label of the insert button
			if(isset($_GET['hades_label']))
			{	
				echo "<input type='hidden' class='hades_insert_button_label' value='".html_entity_decode($_GET['hades_label'])."' />";
			}
				return $_default_tabs;
		}


add_filter( 'media_upload_tabs', 'add_media_label_header' , 11);
	

function register_stylesheet($current_hook)
		{
				wp_enqueue_style(  'h_gallery_mode', HURL . '/css/mode.css' ); 
		}

add_filter( 'admin_enqueue_scripts', 'register_stylesheet', 10);	
