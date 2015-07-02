<?php

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );

// == Set all setings =====================

function setData()
{
	setMenus();
	setDemoOptions();
	setWidgets();
	setMedia();
//	setMediaContent();
}

// == Set media ==========================================

function setMedia()
{
	 $p_slides =   array ( 
	   "src" => URL."/sprites/i/demo.png",
	   "link" => "",  "description" => "" , "type" => "upload" , "media" => "image" , "layout" => "full" ,
	   "title" => "" );
	 
	  $la = array('full','half','half','full','full','half','half','full','half','half','full','full','half','half','full','half','half','full','full','half','half','full','half','half','full','full','half','half');
	 $i=0;
	 
	 
	 $path = wp_upload_dir(); 
     $cstatus =   copy( PATH."/sprites/i/demo.png",  $path['path'].'/demo.png'  );
	 $filename = $path['path'].'/demo.png';
	 
	 $wp_filetype = wp_check_filetype(basename($filename), null );
	 $attachment = array(
	   'guid' => $wp_upload_dir['baseurl'] . _wp_relative_upload_path( $filename ), 
	   'post_mime_type' => $wp_filetype['type'],
	   'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
	   'post_content' => '',
	   'post_status' => 'inherit'
	);
	$attach_id = wp_insert_attachment( $attachment, $filename );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
    wp_update_attachment_metadata( $attach_id, $attach_data );
	
	
	
	 $wp_query = new WP_Query("post_type=portfolio&posts_per_page=-1");
	 
	 while ( $wp_query->have_posts() ) : $wp_query->the_post();
	 
	 $no = rand(2,7);
	 $portfolio_slides = array();
	 for($i=0;$i<$no;$i++)
    {
		  $p_slides['layout'] = $la[$i];
		 $portfolio_slides[] = $p_slides;
	}
	 
	 $id =  get_the_ID();
	 
	 
	   
	 update_post_meta($id,"gallery_items",$portfolio_slides);
	   update_post_meta($id,"_featured_media","featured-image");
     set_post_thumbnail($id,   $attach_id );
	
	endwhile;  
	
	 $wp_query = new WP_Query("post_type=post&posts_per_page=-1");
	 
	 while ( $wp_query->have_posts() ) : $wp_query->the_post();
	 
	 $id =  $post->ID;
	 set_post_thumbnail($id,   $attach_id );
	
	endwhile;  	
	

	
}

// == Set Widgets =========================================
function setWidgets()
{

$sidebars = get_option("sidebars_widgets");

$sidebars["sidebar-1"] = array("search-2", "tag_cloud-2","recent-comments-2");



$sidebars["sidebar-2"] = array ( "twitter_widget-2" , "customboxwidget-4" );
$sidebars["sidebar-3"] = array (  "categories-2");
$sidebars["sidebar-4"] = array (  "superpost-2");
$sidebars["sidebar-5"] = array (  "links-2");
$sidebars["sidebar-6"] = array (  "twitter_widget-3" );
$sidebars["sidebar-7"] = array (  "categories-3");
$sidebars["sidebar-8"] = array (  "customsidemenu-2");
$sidebars["sidebar-9"] = array (  "customsidemenu-3");
$sidebars["sidebar-10"] = array (  "customsidemenu-4");
$sidebars["sidebar-11"] = array (  "customboxwidget-5");
      
update_option("sidebars_widgets",$sidebars);


$feature = get_option("widget_superpost");	
$feature[2] =  array
        (
            "count" => 2,
            "title" => "Recent work",
            "post_type" => "portfolio",
			"post_filter" => "recent",
			"excerpt" => "90"
			
         );
$feature[3] =  array
        (
            "count" => 2,
            "title" => "Latest Events",
            "post_type" => "events",
			"post_filter" => "recent",
			"excerpt" => "90"
         );		 
$feature["_multiwidget"] =   1 ;
update_option("widget_superpost",$feature);

$search = get_option("widget_search");	
$search[2] =array("title" => "");
$search["_multiwidget"] =   1 ;
update_option("widget_search",$search);


$twitter = get_option("widget_twitter_widget");	
$twitter[2] =array("title" => "Latest from Twitter" , "username" => "WPTitan", "tweet_count" => 3);
$twitter["_multiwidget"] =   1 ;

$twitter[3] =array("title" => "Latest from Twitter" , "username" => "WPTitan", "tweet_count" => 3);

update_option("widget_twitter_widget",$twitter);


$customsidemenu = get_option("widget_customsidemenu");	
$customsidemenu[2] =array("title" => "" , "menu_id" => "sidebar-menu-1");
$customsidemenu[3] =array("title" => "" , "menu_id" => "sidebar-menu-1");
$customsidemenu[4] =array("title" => "" , "menu_id" => "sidebar-menu-1");
$customsidemenu["_multiwidget"] =   1 ;
update_option("widget_customsidemenu",$customsidemenu);


$categories = get_option("widget_categories");	
$categories[2] =array("title" => "Categories" , "count" => "1", "hierarchical" => "0" , "dropdown" =>"0");
$categories[3] =array("title" => "Categories" , "count" => "1", "hierarchical" => "0" , "dropdown" =>"0");
$categories["_multiwidget"] =   1 ;
update_option("widget_categories",$categories);		
		
	
$links = get_option("widget_links");	
$links[2] = array( "images" => 1 , "name" => 1 , "description" =>  0 ,"rating" => 0, "category" => 0);
$links["_multiwidget"] =   1 ;
update_option("widget_links",$links);		

$tags = get_option("widget_tag_cloud");	
$tags[2] = array( "title" => "Tags " , "taxonomy" => "post_tag");
$tags["_multiwidget"] =   1 ;
update_option("widget_tag_cloud",$tags);	



$custom_box = get_option("widget_customboxwidget");	
$custom_box[3] =array(
	"link" => "#",
	"description" => "Duis vitae pharetra lorem. Etiam quis mauris felis. Quisque id magnat libero aliquet iaculis. Suspendisse mollis sodales sapien. Sed eleifend enim libero.
Vestibulum accumsan tristique massa, ac aliquam augue volutpat eget. Donec justo eros, gravida tristique ornare sit amet, rhoncus a leo.",
	"title" => "Vestibulum accumsan tristique massa, ac aliquam augue volutpat eget. ",
	"intro_image_link" => "",
	"label" => "Continue"
	);

$custom_box[4] =array(
	"link" => "#",
	"description" => "Duis vitae pharetra lorem. Etiam quis mauris felis. Quisque id magnat libero aliquet iaculis. Suspendisse mollis sodales sapien. Sed eleifend enim libero.
Vestibulum accumsan tristique massa, ac aliquam augue volutpat eget. Donec justo eros, gravida tristique ornare sit amet, rhoncus a leo.",
	"title" => "Vestibulum accumsan tristique massa, ac aliquam augue volutpat eget. Donec justo eros, gravida tristique ornare sit amet, rhoncus a leo. Nulla facilisi. Integer rutrum nisl eros. Proin eget turpis nec magna porta blandit sit amet vel dolor.",
	"intro_image_link" => "",
	"label" => "Continue"
	);
 			 
$custom_box[5] =array(
	"link" => "#",
	"description" => "Duis vitae pharetra lorem. Etiam quis mauris felis. Quisque id magnat libero aliquet iaculis. Suspendisse mollis sodales sapien. Sed eleifend enim libero.
Vestibulum accumsan tristique massa, ac aliquam augue volutpat eget. Donec justo eros, gravida tristique ornare sit amet, rhoncus a leo.",
	"title" => "Vestibulum accumsan tristique massa, ac aliquam augue volutpat eget. Donec justo eros, gravida tristique ornare sit amet, rhoncus a leo. Nulla facilisi. Integer rutrum nisl eros. Proin eget turpis nec magna porta blandit sit amet vel dolor.",
	"intro_image_link" => "",
	"label" => "Continue"
	);			  			 
$custom_box["_multiwidget"] =   1 ;
update_option("widget_customboxwidget",$custom_box);


}
function setMenus()
{
	$gmes = "Menus ";
	global $wpdb;
    $table_db_name = $wpdb->prefix . "terms";
    $rows = $wpdb->get_results("SELECT * FROM $table_db_name where  name='Main Menu' OR name='Footer Menu' OR name='Top Menu'",ARRAY_A);
    $menu_ids = array();
	foreach($rows as $row)
	$menu_ids[$row["name"]] = $row["term_id"] ; 

	set_theme_mod( 'nav_menu_locations', array_map( 'absint', array(  'top_nav' => $menu_ids["Top Menu"] , 'primary_nav' =>$menu_ids['Main Menu'] ,'footer_nav' => $menu_ids['Footer Menu'] ) ) );
	
	$items = wp_get_nav_menu_items( $menu_ids['Main Menu']); 
	
	$i = 0;
	foreach($items as $item)
	{
		if($item->title=="Home")
		{
			$item->url = home_url();
		}
		if($item->title=="Mega Menu")
		{
			update_post_meta($item->ID,"menu-item-megamenu-".$item->ID,"on");
			update_post_meta($item->ID,"menu-item-megamenu-layout-".$item->ID,"column");
		}
		if($item->title=="Powered by WPTitans")
		{
			update_post_meta($item->ID,"menu-item-textbox-".$item->ID,"<p>Ut ut egestas mi. Suspendisse scelerisque ante mattis est condimentum at hendrerit massa volutpat. Morbi dapibus feugiat ipsum, a mattis velit pharetra in.</p><p>
Aliquam mattis egestas sapien eu eleifend. Maecenas condimentum euismod libero, in egestas ipsum venenatis pharetra.</p>");
			update_post_meta($item->ID,"menu-item-enable-textbox-".$item->ID,"on");
		
		}
		if($item->title=="About Egestas")
		{
			update_post_meta($item->ID,"menu-item-textbox-".$item->ID,"<p>Ut ut egestas mi. Suspendisse scelerisque ante mattis est condimentum at hendrerit massa volutpat. Morbi dapibus feugiat ipsum, a mattis velit pharetra in.</p><p>
Aliquam mattis egestas sapien eu eleifend. Maecenas condimentum euismod libero, in egestas ipsum venenatis pharetra.</p>");
			update_post_meta($item->ID,"menu-item-enable-textbox-".$item->ID,"on");
		
		}
		
	}
	
}

// == Set Media Content ==============================================

function setMediaContent() {

 $gmes = "Media Items ( portfolios and galleries ) ";
	 
	  $p_slides =   array ( 
	   "src" => URL."sprites/i/demo.png",
	   "link" => "",  "description" => "" , "type" => "upload" , "media" => "image" , "layout" => "full" ,
	   "title" => "" );
	 
	  $cstatus =   copy( PATH."/images/demo.png",  $wp_url  );
	 
	 $la = array('full','half','half','full','full','half','half');
	 $i=0;
	  $wp_query = new WP_Query("post_type=portfolio&posts_per_page=-1");
	 
	  while ( $wp_query->have_posts() ) : $wp_query->the_post();
	 
		   $no = rand(2,7);
		   $portfolio_slides = array();
		   for($i=0;$i<$no;$i++)
		   $portfolio_slides[] = $p_slides;
	     
		 if($i>=count($la)) $i=0;
	   
	   $p_slides['layout'] = $la[$i++];
	   
		   $id =  get_the_ID();
		   update_post_meta($id,"gallery_items",$portfolio_slides);
		    update_post_meta($id,"_featured_media","featured-image");
	 
		   if($cstatus) {
		   
		   $filename = "demo.png";
		   $wp_filetype = wp_check_filetype(basename($filename), null );
		   $attachment = array(
		   'post_mime_type' => $wp_filetype['type'],
		   'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
		   'post_content' => '',
		   'post_status' => 'inherit'
			);
			$attach_id = wp_insert_attachment( $attachment, $filename, $id );
			
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			
			$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			set_post_thumbnail($id,   $attach_id );
		   }
	 
	 
	endwhile;
	
	
}

// == Enable Demo Content ===========================

function setDemoContent()
{
	if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
	require_once ABSPATH . 'wp-admin/includes/import.php';
    $importer_error = false;
	
	if ( !class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if ( file_exists( $class_wp_importer ) )
		{
			require_once($class_wp_importer);
		}
		else
		{
			$importer_error = true;
		}
    }
	
	if ( !class_exists( 'WP_Import' ) ) {
	  $class_wp_import = HPATH . '/helper/installer/importer/wordpress-importer.php';
	  if ( file_exists( $class_wp_import ) )
	  require_once($class_wp_import);
	  else
	  $importerError = true;
	  
    }

	  if($importer_error)
	  {
		  die("Error in import :(");
	  }
	  else
	  {
		  if ( class_exists( 'WP_Import' )) 
		  {
			  include_once('importer/odin-import-class.php');
		  }
		  
		  
		  if(!is_file(HPATH."/helper/installer/dummy.xml"))
		  {
			  echo "The XML file containing the dummy content is not available or could not be read in <pre>".HPATH."</pre><br/> You might want to try to set the file permission to chmod 777.<br/>If this doesn't work please use the wordpress importer and import the XML file from hades_framework -> mods -> odin folder , dummy.xml manually <a href='/wp-admin/import.php'>here.</a>";
		  }
		  else
		  {
	  
			  $wp_import = new odin_wp_import();
			  $wp_import->fetch_attachments = true;
			  $wp_import->import(HPATH."/helper/installer/dummy.xml");
			  $wp_import->saveOptions();
			
		  }
	  }
   
   
    
}


function setDemoOptions() {

$theme_options = " W3sib3B0aW9uX25hbWUiOiJVTFRfaG9tZV9zdHlsZSIsIm9wdGlvbl92YWx1ZSI6IkZ1bGwgV2lkdGggU2xpZGVyIn0seyJvcHRpb25fbmFtZSI6IlVMVF90b3BiYXJfZW5hYmxlIiwib3B0aW9uX3ZhbHVlIjoidHJ1ZSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfbG9nbyIsIm9wdGlvbl92YWx1ZSI6Imh0dHA6XC9cL2VnZXN0YXMud3B0aXRhbnMuaXRcL2ZpbGVzXC8yMDEyXC8xMFwvbG9nby5wbmcifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2Zhdmljb24iLCJvcHRpb25fdmFsdWUiOiJodHRwOlwvXC9lZ2VzdGFzLndwdGl0YW5zLml0XC9maWxlc1wvMjAxMlwvMTBcL2Zhdmljb24ucG5nIn0seyJvcHRpb25fbmFtZSI6IlVMVF90X2F1ZyIsIm9wdGlvbl92YWx1ZSI6IkF1Z3VzdCJ9LHsib3B0aW9uX25hbWUiOiJVTFRfdF9zZXAiLCJvcHRpb25fdmFsdWUiOiJTZXB0ZW1iZXIifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3Rfb2N0Iiwib3B0aW9uX3ZhbHVlIjoiT2N0b2JlciJ9LHsib3B0aW9uX25hbWUiOiJVTFRfdF9ub3YiLCJvcHRpb25fdmFsdWUiOiJOb3ZlbWJlciJ9LHsib3B0aW9uX25hbWUiOiJVTFRfdF9kZWMiLCJvcHRpb25fdmFsdWUiOiJEZWNlbWViZXIifSx7Im9wdGlvbl9uYW1lIjoiVUxUX21vYmlsZV92aWV3Iiwib3B0aW9uX3ZhbHVlIjoidHJ1ZSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfYmxvZ19leGNlcnB0Iiwib3B0aW9uX3ZhbHVlIjoiZmFsc2UifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3NpbmdsZV90aXRsZV9zaXplIiwib3B0aW9uX3ZhbHVlIjoiMTYifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2ltYWdlX3Jlc2l6ZSIsIm9wdGlvbl92YWx1ZSI6IlRpbXRodW1iIn0seyJvcHRpb25fbmFtZSI6IlVMVF90aW10aHVtYl96YyIsIm9wdGlvbl92YWx1ZSI6IlNtYXJ0IGNyb3AgYW5kIHJlc2l6ZSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfZm9vdGVyX3dpZGdldHMiLCJvcHRpb25fdmFsdWUiOiJZZXMifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2Zvb3Rlcl9tZW51Iiwib3B0aW9uX3ZhbHVlIjoiWWVzIn0seyJvcHRpb25fbmFtZSI6IlVMVF9mb290ZXJfdGV4dCIsIm9wdGlvbl92YWx1ZSI6Ilx1MDBhOSAyMDEyIHdwdGl0YW5zLmNvbSB8IDxhIGhyZWY9XFxcIlxcXCI+Rm9sbG93IHVzIG9uIFR3aXR0ZXI8XC9hPiB8IDxhIGhyZWY9XFxcIiNcXFwiPkxpa2UgdXMgb24gZmFjZWJvb2s8XC9hPlxyXG4ifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3BvcnRmb2xpb19lbmFibGVfdGh1bWJuYWlsIiwib3B0aW9uX3ZhbHVlIjoidHJ1ZSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfcG9ydGZvbGlvMV9pdGVtX2xpbWl0Iiwib3B0aW9uX3ZhbHVlIjoiNiJ9LHsib3B0aW9uX25hbWUiOiJVTFRfcG9ydGZvbGlvMl9pdGVtX2xpbWl0Iiwib3B0aW9uX3ZhbHVlIjoiNiJ9LHsib3B0aW9uX25hbWUiOiJVTFRfcG9ydGZvbGlvM19pdGVtX2xpbWl0Iiwib3B0aW9uX3ZhbHVlIjoiNDAifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3BvcnRmb2xpbzRfaXRlbV9saW1pdCIsIm9wdGlvbl92YWx1ZSI6IjYifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3BvcnRmb2xpbzFfbGltaXQiLCJvcHRpb25fdmFsdWUiOiIyNTAifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3BvcnRmb2xpbzJfbGltaXQiLCJvcHRpb25fdmFsdWUiOiIyNTAifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3BvcnRmb2xpbzNfbGltaXQiLCJvcHRpb25fdmFsdWUiOiIyNTAifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3BvcnRmb2xpbzRfbGltaXQiLCJvcHRpb25fdmFsdWUiOiIyNTAifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3JlbGF0ZWRfcHJvamVjdHNfdGl0bGUiLCJvcHRpb25fdmFsdWUiOiIifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3JlbGF0ZWRfcHJvamVjdHNfc3VidGl0bGUiLCJvcHRpb25fdmFsdWUiOiIifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3BvcnRmb2xpb19tZXRhX2ZpZWxkcyIsIm9wdGlvbl92YWx1ZSI6IiJ9LHsib3B0aW9uX25hbWUiOiJVTFRfY3VzdG9tX2Zvcm1hdF9lbmFibGUiLCJvcHRpb25fdmFsdWUiOiJ0cnVlIn0seyJvcHRpb25fbmFtZSI6IlVMVF9ldmVudF9mb3JtYXQiLCJvcHRpb25fdmFsdWUiOiJ5LW0tZCJ9LHsib3B0aW9uX25hbWUiOiJVTFRfY3VzdG9tX2Zvcm1hdCIsIm9wdGlvbl92YWx1ZSI6ImogUyAsIEYgeSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfZXZlbnRfc29ydGluZyIsIm9wdGlvbl92YWx1ZSI6IlN0YXJ0aW5nIERhdGUoREVTQykifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2V2ZW50c19tZXRhX2ZpZWxkcyIsIm9wdGlvbl92YWx1ZSI6IiJ9LHsib3B0aW9uX25hbWUiOiJVTFRfcmVsYXRlZF9ldmVudHNfdGl0bGUiLCJvcHRpb25fdmFsdWUiOiIifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3JlbGF0ZWRfZXZlbnRzX3N1YnRpdGxlIiwib3B0aW9uX3ZhbHVlIjoiIn0seyJvcHRpb25fbmFtZSI6IlVMVF90X2phbiIsIm9wdGlvbl92YWx1ZSI6IkphbnVhcnkifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3RfZmViIiwib3B0aW9uX3ZhbHVlIjoiRmVicnVhcnkifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3RfbWFyIiwib3B0aW9uX3ZhbHVlIjoiTWFyY2gifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3RfYXByIiwib3B0aW9uX3ZhbHVlIjoiQXByaWwifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3RfbWF5Iiwib3B0aW9uX3ZhbHVlIjoiTWF5In0seyJvcHRpb25fbmFtZSI6IlVMVF90X2p1bmUiLCJvcHRpb25fdmFsdWUiOiJKdW5lIn0seyJvcHRpb25fbmFtZSI6IlVMVF90X2p1bHkiLCJvcHRpb25fdmFsdWUiOiJKdWx5In0seyJvcHRpb25fbmFtZSI6IlVMVF9oZWFkanNfY29kZSIsIm9wdGlvbl92YWx1ZSI6IiJ9LHsib3B0aW9uX25hbWUiOiJVTFRfdHJhY2tpbmdfY29kZSIsIm9wdGlvbl92YWx1ZSI6IiJ9LHsib3B0aW9uX25hbWUiOiJVTFRfY3VzdG9tX2NzcyIsIm9wdGlvbl92YWx1ZSI6IiJ9LHsib3B0aW9uX25hbWUiOiJVTFRfZmJfbGluayIsIm9wdGlvbl92YWx1ZSI6IiMifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3R3aXR0ZXJfbGluayIsIm9wdGlvbl92YWx1ZSI6IiMifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2dvb2dsZV9saW5rIiwib3B0aW9uX3ZhbHVlIjoiIyJ9LHsib3B0aW9uX25hbWUiOiJVTFRfZHJpYmJibGVfbGluayIsIm9wdGlvbl92YWx1ZSI6IiMifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3Jzc19saW5rIiwib3B0aW9uX3ZhbHVlIjoiIyJ9LHsib3B0aW9uX25hbWUiOiJVTFRfZnJvc3RfbGluayIsIm9wdGlvbl92YWx1ZSI6IiMifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3ZpbWVvX2xpbmsiLCJvcHRpb25fdmFsdWUiOiIjIn0seyJvcHRpb25fbmFtZSI6IlVMVF9icmVhZGNydW1ic19lbmFibGUiLCJvcHRpb25fdmFsdWUiOiJ0cnVlIn0seyJvcHRpb25fbmFtZSI6IlVMVF9icmVhZGNydW1iX2RlbGltaXRlciIsIm9wdGlvbl92YWx1ZSI6IlwvIn0seyJvcHRpb25fbmFtZSI6IlVMVF9icmVhZGNydW1iX2hvbWVfbGFiZWwiLCJvcHRpb25fdmFsdWUiOiJIb21lIn0seyJvcHRpb25fbmFtZSI6IlVMVF9wYWdpbmF0aW9uIiwib3B0aW9uX3ZhbHVlIjoibnVtYmVycyJ9LHsib3B0aW9uX25hbWUiOiJVTFRfcG9zdHNfY29tbWVudHMiLCJvcHRpb25fdmFsdWUiOiJ0cnVlIn0seyJvcHRpb25fbmFtZSI6IlVMVF9wb3J0Zm9saW9fY29tbWVudHMiLCJvcHRpb25fdmFsdWUiOiJmYWxzZSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfcGFnZV9jb21tZW50cyIsIm9wdGlvbl92YWx1ZSI6ImZhbHNlIn0seyJvcHRpb25fbmFtZSI6IlVMVF9oMV9mb250X3NpemUiLCJvcHRpb25fdmFsdWUiOiIyOCJ9LHsib3B0aW9uX25hbWUiOiJVTFRfaDJfZm9udF9zaXplIiwib3B0aW9uX3ZhbHVlIjoiMjQifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2gzX2ZvbnRfc2l6ZSIsIm9wdGlvbl92YWx1ZSI6IjIwIn0seyJvcHRpb25fbmFtZSI6IlVMVF9oNF9mb250X3NpemUiLCJvcHRpb25fdmFsdWUiOiIxNiJ9LHsib3B0aW9uX25hbWUiOiJVTFRfaDVfZm9udF9zaXplIiwib3B0aW9uX3ZhbHVlIjoiMTIifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2g2X2ZvbnRfc2l6ZSIsIm9wdGlvbl92YWx1ZSI6IjEwIn0seyJvcHRpb25fbmFtZSI6IlVMVF9ibG9nX3Bvc3Rfc2l6ZSIsIm9wdGlvbl92YWx1ZSI6IjE4In0seyJvcHRpb25fbmFtZSI6IlVMVF9zaW5nbGVfcG9zdF9zaXplIiwib3B0aW9uX3ZhbHVlIjoiMzAifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3BvcnRmb2xpbzFfdGl0bGVfc2l6ZSIsIm9wdGlvbl92YWx1ZSI6IjE4In0seyJvcHRpb25fbmFtZSI6IlVMVF9wb3J0Zm9saW8yX3RpdGxlX3NpemUiLCJvcHRpb25fdmFsdWUiOiIxOCJ9LHsib3B0aW9uX25hbWUiOiJVTFRfcG9ydGZvbGlvM190aXRsZV9zaXplIiwib3B0aW9uX3ZhbHVlIjoiMTEifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3BvcnRmb2xpbzRfdGl0bGVfc2l6ZSIsIm9wdGlvbl92YWx1ZSI6IjE4In0seyJvcHRpb25fbmFtZSI6IlVMVF9lbmFibGVfdGh1bWJuYWlsIiwib3B0aW9uX3ZhbHVlIjoidHJ1ZSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfbW9yZV9sYWJlbCIsIm9wdGlvbl92YWx1ZSI6IlJlYWQgbW9yZSBcdTIwM2EifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3Bvc3RzX2l0ZW1fbGltaXQiLCJvcHRpb25fdmFsdWUiOiI0In0seyJvcHRpb25fbmFtZSI6IlVMVF9wb3N0c19leGNlcnB0X2xpbWl0Iiwib3B0aW9uX3ZhbHVlIjoiMTM5In0seyJvcHRpb25fbmFtZSI6IlVMVF9ibG9nX21ldGFfZW5hYmxlIiwib3B0aW9uX3ZhbHVlIjoidHJ1ZSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfZmJfY29tbWVudHMiLCJvcHRpb25fdmFsdWUiOiJmYWxzZSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfYmxvZ19tZXRhIiwib3B0aW9uX3ZhbHVlIjoiW3Bvc3RfY29tbWVudHNdIGluIFtwb3N0X2NhdGVnb3JpZXNdIGJ5ICBbcG9zdF9hdXRob3JfcG9zdHNfbGlua10ifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2ZlYXR1cmVkX2ltYWdlIiwib3B0aW9uX3ZhbHVlIjoidHJ1ZSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfYXV0aG9yX2JpbyIsIm9wdGlvbl92YWx1ZSI6InRydWUifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3BvcHVsYXIiLCJvcHRpb25fdmFsdWUiOiJ0cnVlIn0seyJvcHRpb25fbmFtZSI6IlVMVF9wb3B1bGFyX25vIiwib3B0aW9uX3ZhbHVlIjoiNCJ9LHsib3B0aW9uX25hbWUiOiJVTFRfc29jaWFsX3NldCIsIm9wdGlvbl92YWx1ZSI6InRydWUifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3NvY2lhbF9zZXRfc3R5bGUiLCJvcHRpb25fdmFsdWUiOiJTdHlsZSAxIn0seyJvcHRpb25fbmFtZSI6IlVMVF92aXN1YWxfc3R5bGVyIiwib3B0aW9uX3ZhbHVlIjoidHJ1ZSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfZW5hYmxlX2FkbWluX2xvZ28iLCJvcHRpb25fdmFsdWUiOiJObyJ9LHsib3B0aW9uX25hbWUiOiJVTFRfYWRtaW5fbG9nb193aWR0aCIsIm9wdGlvbl92YWx1ZSI6IjE1NCJ9LHsib3B0aW9uX25hbWUiOiJVTFRfYWRtaW5fbG9nb19oZWlnaHQiLCJvcHRpb25fdmFsdWUiOiI5OSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfYWRtaW5fbG9nbyIsIm9wdGlvbl92YWx1ZSI6Imh0dHA6XC9cL2VnZXN0YXMud3B0aXRhbnMuaXRcL2ZpbGVzXC8yMDEyXC8xMFwvbG9nby5wbmcifSx7Im9wdGlvbl9uYW1lIjoiVUxUX25vdGZvdW5kX3RpdGxlIiwib3B0aW9uX3ZhbHVlIjoiNDA0IHBhZ2Ugbm90IGZvdW5kIn0seyJvcHRpb25fbmFtZSI6IlVMVF9ub3Rmb3VuZF9sb2dvIiwib3B0aW9uX3ZhbHVlIjoiaHR0cDpcL1wvZWdlc3Rhcy53cHRpdGFucy5pdFwvZmlsZXNcLzIwMTJcLzEwXC80MDQucG5nIn0seyJvcHRpb25fbmFtZSI6IlVMVF9ub3Rmb3VuZF90ZXh0Iiwib3B0aW9uX3ZhbHVlIjoiV2VcXCdyZSBzb3JyeSBidXQgdGhlIHBhZ2UgeW91ciBsb29raW5nIGZvciBpcyBubyBsb25nZXIgaGVyZSwgcGxlYXNlIG1vdmUgb24uIFRoYW5rcy4ifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2JvZHlfZm9udCIsIm9wdGlvbl92YWx1ZSI6IlVidW50dSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfYmRfc2l6ZSIsIm9wdGlvbl92YWx1ZSI6IjEyIn0seyJvcHRpb25fbmFtZSI6IlVMVF9ib2R5X2ZvbnRfc3R5bGUiLCJvcHRpb25fdmFsdWUiOiJub3JtYWwifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3RvZ2dsZV9jdXN0b21fZm9udCIsIm9wdGlvbl92YWx1ZSI6Ikdvb2dsZSBXZWJmb250cyJ9LHsib3B0aW9uX25hbWUiOiJVTFRfY3Vmb25fZm9udCIsIm9wdGlvbl92YWx1ZSI6IkFjaWQifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2N1c3RvbV9mb250Iiwib3B0aW9uX3ZhbHVlIjoiS3Jlb24ifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2JjdXN0b21fZm9udCIsIm9wdGlvbl92YWx1ZSI6IkJyZWUgU2VyaWYifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2N1c3RvbV9nX2ZvbnRfZW5hYmxlIiwib3B0aW9uX3ZhbHVlIjoiZmFsc2UifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2N1c3RvbV9nX2ZvbnQiLCJvcHRpb25fdmFsdWUiOiIifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2N1c3RvbV9nX2ZvbnRfd2VpZ2h0Iiwib3B0aW9uX3ZhbHVlIjoiNDAwLDcwMCJ9LHsib3B0aW9uX25hbWUiOiJVTFRfYm9keV9nX2ZvbnRfd2VpZ2h0Iiwib3B0aW9uX3ZhbHVlIjoiIn0seyJvcHRpb25fbmFtZSI6IlVMVF9mb290ZXJfbGF5b3V0Iiwib3B0aW9uX3ZhbHVlIjoiZml2ZS1jb2wifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3Bvc3RfbGF5b3V0Iiwib3B0aW9uX3ZhbHVlIjoiIn0seyJvcHRpb25fbmFtZSI6IlVMVF9wYWdlX2xheW91dCIsIm9wdGlvbl92YWx1ZSI6IiJ9LHsib3B0aW9uX25hbWUiOiJVTFRfc3R5bGVfbGlzdGVuZXIiLCJvcHRpb25fdmFsdWUiOiJQbGFpbiBTaGFkZXMifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3BsYWluX3RoZW1lIiwib3B0aW9uX3ZhbHVlIjoiamFwYW4ifSx7Im9wdGlvbl9uYW1lIjoiVUxUX3JlbGF0ZWRfcG9zdHNfdGl0bGUiLCJvcHRpb25fdmFsdWUiOiJSZWxhdGVkIFBvc3RzIn0seyJvcHRpb25fbmFtZSI6IlVMVF9pc19ib3hhYmxlIiwib3B0aW9uX3ZhbHVlIjoidHJ1ZSJ9LHsib3B0aW9uX25hbWUiOiJVTFRfbXBvc3RzX2l0ZW1fbGltaXQiLCJvcHRpb25fdmFsdWUiOiI4In0seyJvcHRpb25fbmFtZSI6IlVMVF9hY3RpdmVfc2lkZWJhcnMiLCJvcHRpb25fdmFsdWUiOiJhOjI6e2k6MDtzOjc6XCJjb250YWN0XCI7aToxO3M6MTE6XCI0MDQgU2lkZWJhclwiO30ifSx7Im9wdGlvbl9uYW1lIjoiVUxUX2ZibG9nX3Bvc3Rfc2l6ZSIsIm9wdGlvbl92YWx1ZSI6IjI0In1d ";

$theme_options = base64_decode($theme_options);	
//$theme_options = str_replace("DAD","VIT",$theme_options);
$input = json_decode($theme_options,true);

	
foreach($input as $key => $val)
update_option($val["option_name"],$val["option_value"]);


 
$force_option = array(
SN.'_admin_logo' => "",
SN."_enable_admin_logo" => "No",
SN."_active_sidebars" =>  array ( "Page Sidebar Right	" ,"Left Sidebar	","Right Sidebar" , "Portfolio Sidebar"),
SN."_logo" => URL."/sprites/i/logo.png",
SN."_notfound_logo" =>  URL."/sprites/i/notfound.png",
SN."_notfound_title" => "Oeps, you've done something wrong here",
SN."_notfound_text" => "Page not found, try searching below",

);
	
	
global $wpdb;
// == ~~ Populate Editor ==============
 
$table_db_name = $wpdb->prefix . "teditor";
$farray = array("editor_query.txt");


$wpdb->query("DELETE FROM $table_db_name  ");

	
foreach($farray as $fname) {
$file = HPATH."/helper/installer/$fname";
$fh = fopen($file, 'r');
$super_query = fread($fh, filesize($file));
$wpdb->query("INSERT INTO $table_db_name $super_query");
}



// == ~~ Populate Slider Manager ==============

	 
$table_db_name = $wpdb->prefix . "tslidermanager";
$farray = array("slider_query.txt");


$wpdb->query("DELETE FROM $table_db_name ");
	
foreach($farray as $fname) {
$file = HPATH."/helper/installer/$fname";
$fh = fopen($file, 'r');
$super_query = fread($fh, filesize($file)); //$super_query = preg_replace('@((www|http://)[^ ]+)(.png|.jpg)@', URL."/sprites/i/demo.png", $super_query);
$wpdb->query("INSERT INTO $table_db_name $super_query");
}

$sliders =  $wpdb->get_results("SELECT * FROM $table_db_name ",ARRAY_A);

foreach($sliders as $slider)
{
	 $slides = unserialize($slider['slides']);
	 $new_slides = array();
	 foreach($slides as   $slide)
	 {
		 $new_slide = $slide;
		 $new_slide['image'] = URL."/sprites/i/demo.png";
		 $new_slides[] = $new_slide;
	 }
	 $wpdb->update( $table_db_name, 
												array( 
												'id' => $slider['id'], 
												'slides' =>  serialize($new_slides), 
												'options' => $slider['options'], 
												
												 ) ,
												 array(  'id' =>  $slider['id'])
											  );
}

	
}

