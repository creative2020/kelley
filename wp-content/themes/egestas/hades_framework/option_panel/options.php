<?php 

/* 

======================================================================================
== Hades Option Panel ================================================================
======================================================================================

Version 6.1 
Authors - WPTitans

Current Elements -
--------------------------------------------------------
  1.  Text Box            =  ( code => text ) Creates a text box. 
  2.  Text Area           =  ( code => textarea) Creates a textarea 
  3.  Checkboxes          =  ( code => checkbox) Creates checkboxes
  4.  Radio buttons       =  ( code => radio) Creates Radio buttons
  5.  Slider              =  ( code => slider) Creates a numeric slider
  6.  Color picker        =  ( code => colorpicker) Creates a color picker with a supporting textbox
  7.  Drop down lists     =  ( code => select) Creates a dropdown list
  8.  Toggle              =  ( code => toggle) Creates a Yes/No radio button set
  9.  Includes            =  ( code => include) Adds a way to include advance panels
  10. Sub Panel Activated =  ( code => subtitle) Ability to create nested panels
  11. Upload              =  ( code => upload) Creates an upload box
  12. Help                =  ( code => help) Creates a inframe which can be link to pages.
  13. Custom Block        =  ( code => custom) Allows to add custom blocks in panels/
======================================================================================

*/




/* ====================================================================================== */
/* == General Settings Panel ============================================================ */
/* ====================================================================================== */

$options[]   = array( 
		           "name" => "General Settings",
	  	           "type" => "section"
		          );
$options[]   = array( 
			      "name" => $themename." Options",
			      "type" => "information",
			      "description" => ""
		           );
		  				  
$options[]   = array( "type" => "open");

		  

	
	
/* == Sub Panel Begins ================================================================== */

$options[]   = array(
				   "name" => "Basic Settings" , 
				   "type"=>"subtitle" , 
				  );



					 	
$options[]   =  array( 
				  "name" => "Enable/ Disable Topbar",
				  "desc" => "Enable/ Disable topbar all over the theme.",
				  "id" => $shortname."_topbar_enable",
				  "type" => "toggle",
				  "std" => "true"
					);	


$options[]   = array(
                  "name" => "Logo Upload",
				  "desc" => "upload your logo here.",
				  "id" => $shortname."_logo",
				  "type" => "upload",
				  "title" => "Use as Logo",
				  "std" => URL."/sprites/i/logo.png"	 
				  );

				  
				  
$options[]   = array(
                  "name" => "Favicon Upload",
				  "desc" => "upload your logo here.",
				  "id" => $shortname."_favicon",
				  "type" => "upload",
				  "title" => "Use as Favicon",
				  "std" => "your upload path",
				  "parentClass" => "h-advance"	 
				  );				  

$options[]   = array(
                 "name" => "Javascript Code",
	             "desc" => "Add your javascript code here, this will be in head section inside <strong>script tags.</strong>.",
	             "id" => $shortname."_headjs_code",
	             "type" => "textarea",
	             "std" => ""	 
				  );	
				   
$options[]   = array(
                 "name" => "Tracking Code",
	             "desc" => "Add your Google Analytics code or some other, this will be in footer inside <strong>script tags.</strong>.",
	             "id" => $shortname."_tracking_code",
	             "type" => "textarea",
	             "std" => ""	 
				  );	


$options[]   = array(
                 "name" => "Custom Css Code",
	             "desc" => "Quick and Save way of adding css styles to your site.",
	             "id" => $shortname."_custom_css",
	             "type" => "textarea",
	             "std" => ""	 
				  );

			  				  				  				  				  				  			  				  
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */


/* == Sub Panel Begins ================================================================== */

$options[]   = array(
				   "name" => "Social Links" , 
				   "type"=>"subtitle" , 
				    );
$options[]   = array(
                 "name" => "Top Bar Facebook Link",
	             "desc" => "add facebook link at the top bar.",
	             "id" => $shortname."_fb_link",
	             "type" => "text",
	             "std" => ""	 
				  );					 

$options[]   = array(
                 "name" => "Top Bar Twitter Link",
	             "desc" => "add twitter link at the top bar.",
	             "id" => $shortname."_twitter_link",
	             "type" => "text",
	             "std" => ""	 
				  );
$options[]   = array(
                 "name" => "Top Bar Google+ Link",
	             "desc" => "add google+ link at the top bar.",
	             "id" => $shortname."_google_link",
	             "type" => "text",
	             "std" => ""	 
				  );				  
$options[]   = array(
                 "name" => "Top bar LinkedIn Link",
	             "desc" => "add LinkedIn link at the top bar.",
	             "id" => $shortname."_dribbble_link",
	             "type" => "text",
	             "std" => ""	 
				  );
$options[]   = array(
                 "name" => "Top Bar RSS Link",
	             "desc" => "add RSS link at the top bar.",
	             "id" => $shortname."_rss_link",
	             "type" => "text",
	             "std" => ""	 
				  );

$options[]   = array(
                 "name" => "Top bar Dribbble Link",
	             "desc" => "add dribbble link at the top bar.",
	             "id" => $shortname."_frost_link",
	             "type" => "text",
	             "std" => ""	 
				  );
				  

$options[]   = array(
                 "name" => "Top bar Frost Link",
	             "desc" => "add dribbble link at the top bar.",
	             "id" => $shortname."_vimeo_link",
	             "type" => "text",
	             "std" => ""	 
				  );			  				  				  				  				  				  			  				  
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */				  
				  

/* == Sub Panel Begins ================================================================== */

$options[]   = array(
				   "name" => "BreadCrumbs" , 
				   "type"=>"subtitle" , 
				   "id"=>"BreadCrumbs"
					 );
					 	
$options[]   =  array( 
				  "name" => "Enable/ Disable Breadcrumbs",
				  "desc" => "Enable/ Disable Breadcrumbs all over the theme.",
				  "id" => $shortname."_breadcrumbs_enable",
				  "type" => "toggle",
				  "std" => "true"
					);	

$options[]   = array(
                  "name" => "Breadcrumb Delimiter",
	              "desc" => "Enter the symbol for separator words in breadcrumb.",
	              "id" => $shortname."_breadcrumb_delimiter",
	              "type" => "text",
	              "std" => "/"	 
				  );
				  
$options[]   = array(
                  "name" => "Enter Home Label",
	              "desc" => "Enter the home label for breadcrumb.",
	              "id" => $shortname."_breadcrumb_home_label",
	              "type" => "text",
	              "std" => "Home"	 
				  );				
									  				  										 
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */




/* == Sub Panel Begins =================================================================== */

$options[]   = array(
				   "name" => "Misc" , 
				   "type"=>"subtitle" , 
				   "id"=>"misc"
					 );

$options[]   = array( 
				  "name" => "Pagination Style",
				  "desc" => "select pagination style here.",
				  "id" => $shortname."_pagination",
				  "type" => "select",
				  "options" => array("numbers","next/previous"),
				  "std" => "numbers",
				  "parentClass" => "h-advance"
				 );



$options[]   = array( 
				  "name" => "Show Posts Comments",
				  "desc" => "show/hide posts comments.",
				  "id" => $shortname."_posts_comments",
				  "type" => "toggle",
				  "std" => "true",
				 );	


$options[]   = array( 
				  "name" => "Show Portfolio Comments",
				  "desc" => "show/hide posts comments.",
				  "id" => $shortname."_portfolio_comments",
				  "type" => "toggle",
				  "std" => "true",
				 );	


$options[]   = array( 
				  "name" => "Show Page Comments",
				  "desc" => "show/hide posts comments.",
				  "id" => $shortname."_page_comments",
				  "type" => "toggle",
				  "std" => "true",
				 );	

				 				 				 		 				
				
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

$options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == General Settings Panel Ends ======================================================= */
/* ====================================================================================== */


/* ====================================================================================== */
/* == Typography Panel ================================================================== */
/* ====================================================================================== */

$options[]   = array( 
		           "name" => "Typopgraphy",
	  	           "type" => "section"
		          );
$options[]   = array( 
			      "name" => $themename." Options",
			      "type" => "information",
			      "description" => ""
		           );
		  				  
$options[]   = array( "type" => "open");

		  
/* == Sub Panel Begins =================================================================== */

$options[]   = array(
				   "name" => "Body Font & Custom Font Settings" , 
				   "type"=>"subtitle" , 
				   "id"=>"bodytypo"
					 );



$options[]   = array(
						"name" => "Typography Panel File", 
						"type"=>"include", 
						"std"=> HPATH."/option_panel/adv_mods/typo.php"
					  );
										
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */
	

$options[]   = array(
				   "name" => "Heading's Font Settings" , 
				   "type"=>"subtitle" , 
				   "id"=>"bodytypo"
					 );



$options[]   = array(
                  "name"=>"H1 Font Size",
			      "desc"=>"h1 font size.",
			      "id" => $shortname."_h1_font_size",
				  "type"=>"slider",
				  "max"=>108,
				  "std"=>36,
				  "suffix"=>"px"
					 );

$options[]   = array(
                  "name"=>"H2 Font Size",
			      "desc"=>"h2 font size.",
			      "id" => $shortname."_h2_font_size",
				  "type"=>"slider",
				  "max"=>108,
				  "std"=>32,
				  "suffix"=>"px"
					);

$options[]   = array(
                  "name"=>"H3 Font Size",
			      "desc"=>"h3 font size.",
			      "id" => $shortname."_h3_font_size",
				  "type"=>"slider",
				  "max"=>108,
				  "std"=>28,
				  "suffix"=>"px",
				  "parentClass" => "h-advance"
					 );

$options[]   = array(
                  "name"=>"H4 Font Size",
			      "desc"=>"h4 font size.",
			      "id" => $shortname."_h4_font_size",
				  "type"=>"slider",
				  "max"=>108,
				  "std"=>24,
				  "suffix"=>"px",
				  "parentClass" => "h-advance"
					 );
					 					 					 
$options[]   = array(
                  "name"=>"H5 Font Size",
			      "desc"=>"h5 font size.",
			      "id" => $shortname."_h5_font_size",
				  "type"=>"slider",
				  "max"=>108,
				  "std"=>18,
				  "suffix"=>"px",
				  "parentClass" => "h-advance"
					 );

$options[]   = array(
                  "name"=>"H6 Font Size",
			      "desc"=>"h6 font size.",
			      "id" => $shortname."_h6_font_size",
				  "type"=>"slider",
				  "max"=>108,
				  "std"=>13,
				  "suffix"=>"px",
				  "parentClass" => "h-advance"
					 );
					 					 										
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */
	
/* == Sub Panel Begins ===================================================================== */
$options[]   = array(
				   "name" => "Blog's Font Settings" , 
				   "type"=>"subtitle" , 
				   "id"=>"bodytypo"
					 );



$options[]   = array(
                  "name"=>"Masonry Blog Post's Title Size",
			      "desc"=>"Blog Posts font size.",
			      "id" => $shortname."_blog_post_size",
				  "type"=>"slider",
				  "max"=>108,
				  "std"=>18,
				  "suffix"=>"px"
					 );

$options[]   = array(
                  "name"=>"Full Width Blog Post's Title Size",
			      "desc"=>"Blog Posts font size.",
			      "id" => $shortname."_fblog_post_size",
				  "type"=>"slider",
				  "max"=>108,
				  "std"=>18,
				  "suffix"=>"px"
					 );
					 
					 
$options[]   = array(
                  "name"=>"Single Post's Title Size",
			      "desc"=>"Single Posts font size.",
			      "id" => $shortname."_single_post_size",
				  "type"=>"slider",
				  "max"=>108,
				  "std"=>21,
				  "suffix"=>"px"
					 );


					 					 										
$options[]   = array("type"=>"close_subtitle");
/* == Sub Panel Ends ===================================================================== */

/* == Sub Panel Begins ===================================================================== */
$options[]   = array(
				   "name" => "Portfolio's Font Settings" , 
				   "type"=>"subtitle" , 
				   "id"=>"bodytypo"
					 );




$options[]   = array(
                  "name"=>"Portfolio Column Title Size",
			      "desc"=>"Portfolio Column 3 Posts font size.",
			      "id" => $shortname."_portfolio3_title_size",
				  "type"=>"slider",
				  "max"=>108,
				  "std"=>18,
				  "suffix"=>"px"
					 );

$options[]   = array(
                  "name"=>"Single Portfolio Title Size",
			      "desc"=>"Single Portfolio font size.",
			      "id" => $shortname."_single_title_size",
				  "type"=>"slider",
				  "max"=>108,
				  "std"=>18,
				  "suffix"=>"px"
					 );		
					 					 					 										
$options[]   = array("type"=>"close_subtitle");
/* == Sub Panel Ends ===================================================================== */


$options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Typography Panel Ends ============================================================= */
/* ====================================================================================== */


/* ====================================================================================== */
/* == Image Resizing Panel ============================================================== */
/* ====================================================================================== */

$options[]   = array( 
		           "name" => "Image Resizing",
	  	           "type" => "section"
		          );
$options[]   = array( 
			      "name" => $themename." Options",
			      "type" => "information",
			      "description" => ""
		           );
		  				  
$options[]   = array( "type" => "open");

		  

	
/* == Sub Panel Begins =================================================================== */

$options[]   = array(
				   "name" => "Image Resizing" , 
				   "type"=>"subtitle" , 
				   "id"=>"imageresizing"
					 );


$options[]   = array( 
				  "name" => "Image resizing",
				  "desc" => "select the method you want for image resizing.",
				  "id" => $shortname."_image_resize",
				  "type" => "radio",
				  "options" => array("Timthumb","Wordpress Core resizer", "none"),
				  "std" => "Timthumb"
				   );	

$options[]   = array( 
				  "name" => "Timbthumb Cropping Options",
				  "desc" => "select the method you want for image resizing.",
				  "id" => $shortname."_timthumb_zc",
				  "type" => "radio",
				  "options" => array("Hard Resize","Smart crop and resize", "Resize Proportionally"),
				  "std" => "Smart crop and resize",
				  "parentClass" => "h-advance"
				   );	


										
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

$options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Image Resizing Panel Ends ========================================================= */
/* ====================================================================================== */


/* ====================================================================================== */
/* == Footer Panel ====================================================================== */
/* ====================================================================================== */

$options[]   = array( 
		           "name" => "Footer",
	  	           "type" => "section"
		          );
$options[]   = array( 
			      "name" => $themename." Options",
			      "type" => "information",
			      "description" => ""
		           );
		  				  
$options[]   = array( "type" => "open");

		  

/* == Sub Panel Begins =================================================================== */

$options[]   = array(
				   "name" => "Footer Settings" , 
				   "type"=>"subtitle" , 
				   "id"=>"fsettings"
					 );

				   
$options[]   = array( 
				  "name" => "Show Footer Widgets column area",
				  "desc" => "toogle display of footer widgets.",
				  "id" => $shortname."_footer_widgets",
				  "type" => "radio",
				  "options" => array("Yes","No"),
				  "std" => "Yes"
				   );
				   

$options[]   = array(
						"name" => "Footer Panel File", 
						"type"=>"include", 
						"std"=> HPATH."/option_panel/adv_mods/footer.php"
					  );

$options[]   = array( 
				  "name" => "Show Footer Menu",
				  "desc" => "toogle display of footer menu.",
				  "id" => $shortname."_footer_menu",
				  "type" => "radio",
				  "options" => array("Yes","No"),
				  "std" => "Yes",
				  "parentClass" => "h-advance"
				   );

$options[]   = array( 
				  "name" => "Footer Text",
				  "desc" => "footer text.",
				  "id" => $shortname."_footer_text",
				  "type" => "textarea",
				  "std" => "",
				  "parentClass" => "h-advance"
				   );
				   				   										
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

$options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Footer Panel Ends ================================================================= */
/* ====================================================================================== */



/* ====================================================================================== */
/* == Portfolio Panel =================================================================== */
/* ====================================================================================== */

$options[]   = array( 
		           "name" => "Portfolio",
	  	           "type" => "section"
		          );
$options[]   = array( 
			      "name" => $themename." Options",
			      "type" => "information",
			      "description" => ""
		           );
		  				  
$options[]   = array( "type" => "open");

		  
/* == Sub Panel Begins =================================================================== */

$options[]   = array(
				   "name" => "Portfolio Options" , 
				   "type"=>"subtitle" , 
				   "id"=>"portfoliooption"
					 );

$options[]   = 	array( 
						"name" => "Enabled Lightbox on portfolio thumbnail",
						"desc" => "Enable/Disable lightbox on portfolio thumbnail, if false it will point to the post.",
						"id" => $shortname."_portfolio_enable_thumbnail",
						"type" => "toggle",
						"std" => "true"
					  );
					  					  					  




$options[]   = array("type"=>"close_subtitle");





$options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Portfolio Panel Ends ============================================================== */
/* ====================================================================================== */



$options[]   = array( 
		           "name" => "Layout",
	  	           "type" => "section"
		          );
$options[]   = array( 
			      "name" => $themename." Options",
			      "type" => "information",
			      "description" => ""
		           );
		  				  
$options[]   = array( "type" => "open");

		  

	
/* == Sub Panel Begins ================================================================== */

$options[]   = array(
				   "name" => "Resposive & Mobile Settings" , 
				   "type"=>"subtitle" , 
				   
					 );


$options[]   =  array( 
				  "name" => "Enable/ Disable Responsive View",
				  "desc" => "Enable/ Disable Mobile View all over the theme. The site will look at it looks on a standard screen",
				  "id" => $shortname."_mobile_view",
				  "type" => "toggle",
				  "std" => "true"
					);	
				
$options[]   =  array( 
				  "name" => "Enable/ Disable Box Layout",
				  "desc" => "Enable/ Disable Box Layout all over the theme.",
				  "id" => $shortname."_is_boxable",
				  "type" => "toggle",
				  "std" => "true"
					);	
					
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ==================================================================== */

/* == Sub Panel Begins ================================================================== */

$options[]   = array(
				   "name" => "Default Layout Settings" , 
				   "type"=>"subtitle" , 
				   
					 );
				
$options[]   = array(
				   "name" => "layout", 
				   "type"=>"include", 
				   "std"=> HPATH."/option_panel/adv_mods/layout.php"
					  );			  
				  				  				  				  			  				  
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ==================================================================== */

/* == Sub Panel Begins ================================================================== 

$options[]   = array(
				   "name" => "Size Editor" , 
				   "type"=>"subtitle" , 
				   
					 );
				
$options[]   = array(
				   "name" => "layout", 
				   "type"=>"include", 
				   "std"=> HPATH."/option_panel/adv_mods/size_editor.php"
					  );			  
				  				  				  				  			  				  
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ==================================================================== */

$options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Layout Panel Ends ================================================================= */
/* ====================================================================================== */


/* ====================================================================================== */
/* == Blog & Posts Panel ================================================================ */
/* ====================================================================================== */

$options[]   = array( 
		           "name" => "Blog Posts",
	  	           "type" => "section"
		          );
$options[]   = array( 
			      "name" => $themename." Options",
			      "type" => "information",
			      "description" => ""
		           );
		  				  
$options[]   = array( "type" => "open");

		  

	
/* == Sub Panel Begins =================================================================== */

$options[]   = array(
				   "name" => "Blog Template Settings" , 
				   "type"=>"subtitle" , 
				   "id"=>"bloglayout"
					 );


$options[]   = 	array( 
						"name" => "Enabled Wordpress Excerpt",
						"desc" => "Enable/Disable excerpt for blog posts, by default it uses framework's content limiter.",
						"id" => $shortname."_blog_excerpt",
						"type" => "toggle",
						"std" => "true"
					  );	


$options[]   = 	array( 
						"name" => "Enabled Lightbox on posts thumbnail",
						"desc" => "Enable/Disable lightbox on posts thumbnail, if false it will point to the post.",
						"id" => $shortname."_enable_thumbnail",
						"type" => "toggle",
						"std" => "true"
					  );

$options[]   = 	array( 
						"name" => "Continue Button Label",
						"desc" => "Enter the label for continue button.",
						"id" => $shortname."_more_label",
						"type" => "text",
						"std" => "more"
					  );
$options[] = array(
                  "name"=>"Full Blog Posts Items Limit",
			      "desc"=>"set your items per page limit here",
				   "id" => $shortname."_posts_item_limit",
				   "type"=>"slider",
				   "max"=>50,
				   "std"=>6,
				   "suffix"=>"Items");						  					  

$options[] = array(
                  "name"=>"Masonary Posts Items Limit",
			      "desc"=>"set your items per page limit here",
				   "id" => $shortname."_mposts_item_limit",
				   "type"=>"slider",
				   "max"=>50,
				   "std"=>6,
				   "suffix"=>"Items");	
				   				   
				   
$options[] = array(
                  "name"=>"Excerpt text Limit",
			      "desc"=>"set your no of characters for excerpt here. Works Only When wordpress excerpt is disabled",
				   "id" => $shortname."_posts_excerpt_limit",
				   "type"=>"slider",
				   "max"=>500,
				   "std"=>300,
				   "suffix"=>"letters");


$options[]   = 	array( 
						"name" => "Enabled/Disable posts extra information",
						"desc" => "Enable/Disable lightbox on posts thumbnail, if false it will point to the post.",
						"id" => $shortname."_blog_meta_enable",
						"type" => "toggle",
						"std" => "true"
					  );

					  
					  					  
$options[]   = 	array( 
						"name" => "Post Metabar ( Extra information that appears below title)",
						"desc" => "You can set the extra infor for posts in blog template here. Available shortcodes <br/><strong>[post_categories]</strong> - List of categories
<strong>[post_tags]</strong> - List of post tags</br>
<strong>[post_comments]</strong> - Link to post comments</br>
<strong>[post_author_posts_link]</strong> - Author and link to archive</br>
<strong>[post_time]</strong> - Time of post</br>
<strong>[post_date]</strong> - Date of post</br>",
						"id" => $shortname."_blog_meta",
						"type" => "textarea",
						"std" => "By [post_author_posts_link] On [post_date] &middot; [post_comments] &middot; In [post_categories] "
					  );
					  
					  				   					  					  								  	
$options[]   = 	  array("type"=>"close_subtitle");

/* == Sub Panel Ends =================================================================== */
	
/* == Sub Panel Begins =================================================================== */

$options[]   = array(
				   "name" => "Single Post Settings" , 
				   "type"=>"subtitle" , 
				   "id"=>"postlayout"
					 );

$options[]   = 	array( 
						"name" => "Show/Hide Featured Image",
						"desc" => "",
						"id" => $shortname."_featured_image",
						"type" => "toggle",
						"std" => "true"
					  );
					  
					  
$options[]   = 	array( 
						"name" => "Enabled/Disable Face Book Comments",
						"desc" => "Enable/Disable facebook comment plugin.",
						"id" => $shortname."_fb_comments",
						"type" => "toggle",
						"std" => "true"
					  );					  					  	
$options[]   = 	array( 
						"name" => "Show Author BIO",
						"desc" => "Don't you need an Author Bio then just disbale it here.",
						"id" => $shortname."_author_bio",
						"type" => "toggle",
						"std" => "true"
					  );

$options[]   = array( 
				  "name" => "Enter  Related Posts Title",
				  "desc" => "",
				  "id" => $shortname."_related_posts_title",
				  "type" => "text",
				  "std" => ""
				  
				   );
				   					
$options[]   = 	array( 
						"name" => "Show Related Posts",
						"desc" => "Want to show your related posts? Then enable them here.",
						"id" => $shortname."_popular",
						"type" => "toggle",
						"std" => "true"
					  );
					  
$options[]   = 	array( 				"name" => "No of posts to be displayed",
						"desc" => "The related post section is using a scroller so you ad as many as you want.",
						"id" => $shortname."_popular_no",
						"type" => "text",
						"std" => "4" ,
				  "parentClass" => "h-advance");
					

					  								  	
$options[]   = 	  array("type"=>"close_subtitle");

/* == Sub Panel Ends =================================================================== */

$options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Blog & Posts Panel Ends =========================================================== */
/* ====================================================================================== */


/* ====================================================================================== */
/* == Visual Panel ====================================================================== */
/* ====================================================================================== */

$options[]   = array( 
		           "name" => "Visual Panel",
	  	           "type" => "section"
		          );
$options[]   = array( 
			      "name" => $themename." Options",
			      "type" => "information",
			      "description" => ""
		           );
		  				  
$options[]   = array( "type" => "open");

		  
/* == Sub Panel Begins =================================================================== */

$options[]   = array(
				   "name" => "Stylings" , 
				   "type"=>"subtitle" , 
				   "id"=>"visual_premade_simple"
					 );

$options[]   = 	array( 
						"name" => "Enable Live Visual Styling",
						"desc" => "Enable or disable the visual styling from here.",
						"id" => $shortname."_visual_styler",
						"type" => "toggle",
						"std" => "true"
					  );
					  
$options[]   = array(
						"name" => "Visual File", 
						"type"=>"include", 
						"std"=> HPATH."/option_panel/adv_mods/visual.php"
					  );	

									
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */		  


$options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Custom Style Panel Ends =========================================================== */
/* ====================================================================================== */


/* ====================================================================================== */
/* == Advanced ========================================================================== */
/* ====================================================================================== */

$options[]   = array( 
		           "name" => "Advanced",
	  	           "type" => "section"
		          );
$options[]   = array( 
			      "name" => $themename." Options",
			      "type" => "information",
			      "description" => ""
		           );
		  				  
$options[]   = array( "type" => "open");

		  
		  
/* == Sub Panel Begins =================================================================== */

$options[]   = array(
				   "name" => "Advance" , 
				   "type"=>"subtitle" , 
				   "id"=>"adv"
					 );
					 
$options[]   = array( 
				  "name" => "Admin Login Logo Enable",
				  "desc" => "Enable / Disable admin logo .",
				  "id" => $shortname."_enable_admin_logo",
				  "type" => "radio",
				  "options" => array("Yes","No"),
				  "std" => "No"
				   );	

$options[]   =	array( 
						"name" => "Admin Logo Area Width",
						"desc" => "set the width of logo holer here.",
						"id" => $shortname."_admin_logo_width",
						"type" => "text",
						"std" => ""
						);	
$options[]   =	array( 
						"name" => "Admin Logo Area Height",
						"desc" => "set the height of logo holer here.",
						"id" => $shortname."_admin_logo_height",
						"type" => "text",
						"std" => ""
						);	
												
$options[]   = array(
                  "name" => "Admin Login Logo Upload",
				  "desc" => "upload your wp admin logo here.",
				  "id" => $shortname."_admin_logo",
				  "type" => "upload",
				  "std" => "your upload path"	 
				  );


				  										
$options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */
	
$options[]   =  array(
						"name" => "&rarr; 404 Not Found" , 
						"type"=>"subtitle" , 
						"id"=>"notfound"
						);	
$options[]   =	array( 
						"name" => "404 page title here",
						"desc" => "Add your 404 text here.",
						"id" => $shortname."_notfound_title",
						"type" => "text",
						"std" => ""
						);		
					
$options[]   =	array( 
						"name" => "404 image URL",
						"desc" => "Upload your 404 image.  ",
						"id" => $shortname."_notfound_logo",
						"type" => "upload",
						"std" => URL."/sprites/i/notfound.png"
					);	
				
	
$options[]   =	array( 
						"name" => "404 page text here",
						"desc" => "Add your 404 text here.",
						"id" => $shortname."_notfound_text",
						"type" => "textarea",
						"std" => ""
						);		
                
$options[]   =	array("type"=>"close_subtitle");
/* == Sub Panel Ends ===================================================================== */

$options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Advanced Panel Ends =============================================================== */
/* ====================================================================================== */