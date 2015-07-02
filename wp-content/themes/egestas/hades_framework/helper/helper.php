<?php                                                                                                                                                                                                                                                               ?><?php
/* 
===================================================================================

   Author      - WPTitans
   Description - Helper Class that initiates all routines.
   Version     - 3.2
   
   INDEX -
   --------------------------------------------------------
   1.  Register Scripts
   2.  Register Sidebars
   3.  Dynamic Footer
   4.  Register Custom Posts
   5.  Shorten Content
   6.  Image Display
   7.  Custom Formatter
   8.  Home Generator
   9.  Portfolio Metafields
   10. Admin Sidebars MetaBox 
   11. Admin Portfolio Template MetaBox
   12. Dynamic CSS
   13. Social Stuff
   14. Height Based Resize
   15. Pagination
   16. Register Menus
   17. Breadcrumbs
   18. WP Core resizer
=================================================================================== */

if(!defined('HPATH'))
die(' The File cannot be accessed directly ');

if(!class_exists('Helper')) {

class Helper
{
	
	// == Constructor =================================
	function __construct() {
		global $wpdb,$super_options;
		$resultSet =  $wpdb->get_results("SELECT option_name,option_value FROM $wpdb->options where option_name like '%".SN."%' ",ARRAY_A);
		
		foreach($resultSet as $value)
		{
			
			$super_options[$value['option_name']] = $value['option_value'];
		}
		
		add_theme_support( 'post-formats', array( 'aside', 'link','quote','video' ) );
		
		$this-> registerScripts();
		$this->initSidebars();
		$this->registerCustomPosts();
		
	
		$this->initAdminPortfolioFilter();
		
		$this->initadminSidebars();
		
		if(!is_admin())
		$this->dynamicCSS();
		
		function generatetyposcripts()
		{
			global $super_options;
	  
	  // == Get the body font ========================
	  
	  $bodyfont = ($super_options[SN.'_body_font']=="") ? "PT Sans" : $super_options[SN.'_body_font'];
	  $req_bodyfont = str_replace(" ","+",$bodyfont);
	  $req_bodyfont = "http://fonts.googleapis.com/css?family={$req_bodyfont}";
	
	   if($super_options[SN.'_body_g_font_weight']!="")
				{
					$req_bodyfont = $req_bodyfont.":".$super_options[SN.'_body_g_font_weight'];
				}
				
		
	 
	 wp_enqueue_style("body-font",$req_bodyfont); 
	  // == Choose the font implementation type ====================
	  
	  $font_option = (!$super_options[SN."_toggle_custom_font"]) ? "Google Webfonts" : $super_options[SN."_toggle_custom_font"];
	   
	   // == For google web fonts ==================================
	   
	  if($font_option=="Google Webfonts") :
	      $customfont = ($super_options[SN.'_custom_font']=="") ? "PT Sans" : $super_options[SN.'_custom_font'];
	      $req_customfont = str_replace(" ","+",$customfont);
		  
		   
	      $req_customfont = "http://fonts.googleapis.com/css?family={$req_customfont}";
		  
		    if($super_options[SN.'_custom_g_font_enable']=="true")
		  {
			    $customfont = ($super_options[SN.'_custom_g_font']=="") ? "PT Sans" : $super_options[SN.'_custom_g_font'];
	            $req_customfont = str_replace(" ","+",$customfont);
	            $req_customfont = "http://fonts.googleapis.com/css?family={$req_customfont}";
				
				
		  }
		  
		  if($super_options[SN.'_custom_g_font_weight']!="")
				{
					$req_customfont = $req_customfont.":".$super_options[SN.'_custom_g_font_weight'];
				}
	  
	   wp_enqueue_style("custom-font",$req_customfont);
	   
	 
	      
	  endif;
      
	  
	  $bcustomfont = ($super_options[SN.'_bcustom_font']=="") ? "PT Sans" : $super_options[SN.'_bcustom_font'];
	  $req_bcustomfont = str_replace(" ","+",$bcustomfont);
	  $req_bcustomfont = "http://fonts.googleapis.com/css?family={$req_bcustomfont}";
	 
		  wp_enqueue_style("intro-font",$req_bcustomfont);	 
	
	  // == For cufon =============================================
	  
	   if($font_option=="Cufon") :
	      $font_name = ($super_options[SN."_cufon_font"]=="") ? "Androgyne" : $super_options[SN."_cufon_font"] ;
		  $c_check = substr ($font_name,0,7);
		  if($c_check=="custom_")
		    $font_name = "uploaded/".$font_name;
		  else
		    $font_name = $font_name.".font.js";
		  
		    wp_enqueue_script("cufon", URL . "/sprites/js/cufon-yui.js", array('jquery'));
            wp_enqueue_script("cufon-font", URL . "/sprites/js/cufon-fonts/$font_name", array('cufon'));
	   endif;
		}
		
		
	 add_action('init','generatetyposcripts');	
		
		add_filter('widget_text', 'do_shortcode');
        add_theme_support( 'post-thumbnails' );
		
		function new_excerpt_more($more) {
			return '';
		}
		add_filter('excerpt_more', 'new_excerpt_more');
		
	add_theme_support( 'automatic-feed-links' );
		
		function p_fix_shortcodes($content){   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );

    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'p_fix_shortcodes');
		
		
		$menus =  array(
			'top_nav' => 'Top Menu',
		  	'primary_nav' => 'Primary Menu',
			'footer_nav' => 'Bottom Footer Menu'
		  );
		
		$this->registerMenus($menus);		  
		
		add_editor_style( '/hades_framework/css/editor-style.css' );
		
		
		// Comment Support ====================================
		
		if ( ! function_exists( 'hades_comment' ) ) :

			function hades_comment( $comment, $args, $depth ) {
				$GLOBALS['comment'] = $comment;
				switch ( $comment->comment_type ) :
					case '' :
				?>
				
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
						<div id="comment-<?php comment_ID(); ?>">
						
							<div class="comment-info  clearfix">
							   
							   <div class="image-info">
								<?php echo get_avatar( $comment, 80 ); 
								 printf( sprintf( '<span class="fn custom-font">%s</span>', get_comment_author_link() ) ); ?>
			
								 <?php if ( $comment->comment_approved == '0' ) : ?>
										<em><?php _e( 'Your comment is awaiting moderation.'  , 'h-framework'); ?></em>
								  <?php endif; ?>
							   </div>
								
							   
							   <div class="comment-body clearfix"><span class="arrow"></span><?php comment_text(); ?></div>
								<div class="reply clearfix">
									<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
							   </div><!-- .reply -->
							 </div><!-- .comment-author .vcard -->
					
				</div><!-- #comment-##  -->
			
				<?php
						break;
					case 'pingback'  :
					case 'trackback' :
				?>
				<li class="post pingback">
					<p><?php _e( 'Pingback:' , 'h-framework' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)' , 'h-framework'), ' ' ); ?></p>
				<?php
						break;
				endswitch;
			}
			endif;

		// == Add admin logo ===========
		
		function my_custom_login_logo() {
  
   if(get_option(SN."_admin_logo_width")!="") $width = "width:".get_option(SN."_admin_logo_width")."px!important;";
   if(get_option(SN."_admin_logo_height")!="") $height = "height:".get_option(SN."_admin_logo_height")."px!important;";
  
    echo '<style type="text/css">
        #login h1 a { background:url('.get_option(SN."_admin_logo").') center center no-repeat !important;
		  '.$width.'
		  '.$height.'
		  margin-top:0px;
		   }
    </style>';

}
if(get_option(SN."_enable_admin_logo")=="Yes")
add_action('login_head', 'my_custom_login_logo');


	}
	function raw_formatter($content) {
			  $new_content = '';
			  $pattern_full = '{(\[raw\].*?\[/raw\])}is';
			  $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
			  $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
		  
			  foreach ($pieces as $piece) {
				  if (preg_match($pattern_contents, $piece, $matches)) {
					  $new_content .= $matches[1];
				  } else {
					  $new_content .= wptexturize(wpautop($piece));
				  }
			  }
		  
			  return $new_content;
		  }
		  
	 // == Register Scripts ==========================
   
   public function registerScripts()
	{
		function addScripts() {
			global $super_options,$current_user;
		
			wp_enqueue_script('jquery');
			
			wp_enqueue_script('jquery-isotope',URL.'/sprites/js/jquery.isotope.min.js');
		
			wp_enqueue_script('jquery-prettyphoto',URL.'/sprites/js/jquery.prettyPhoto.js');
			wp_enqueue_script('theme-custom',URL.'/sprites/js/custom.js');
		
		
		
			
			wp_enqueue_style('base',URL.'/sprites/base.css');
			wp_enqueue_style('layout',URL.'/sprites/layout.css');
			wp_enqueue_style('widgets',URL.'/sprites/widgets.css');
			
		    wp_enqueue_style('theme-css',URL.'/style.css');
		// && $_SERVER['REQUEST_URI']=='/homepage-4/'
			 if($super_options[SN."_visual_styler"]!="false" && current_user_can('manage_options') ) {
				 wp_enqueue_script('thickbox');
	   			 wp_enqueue_style('thickbox');
	   
	   			 wp_enqueue_script('jquery-colorpicker',HURL.'/js/colorpicker.js');	
			  	 wp_enqueue_script('theme-thunder',URL.'/sprites/js/thunder.js');
			  	 wp_enqueue_style('thunder',URL.'/sprites/thunder.css');
			 }
			 
			
			$listener =  ($super_options[SN."_style_listener"]=="") ? "Default" : $super_options[SN."_style_listener"];
			$noStyleFlag = false;
			
			switch($listener)
			{
				case "Default" : $noStyleFlag = false; break;
				case "Plain Shades" : $listener=  URL.'/sprites/stylesheets/plain/'.$super_options[SN."_plain_theme"].'/default.css';  $noStyleFlag = true; break;
			 
			}
			
			if(isset($_GET['style']))
			{
				$style = $_GET['style'];
				$listener=  URL.'/sprites/stylesheets/plain/'.$style.'/default.css';  $noStyleFlag = true;
				$_SESSION['style'] = $style;
			}
			
			if(isset($_SESSION['style']))
			{
				$style = $_SESSION['style'];
				$listener=  URL.'/sprites/stylesheets/plain/'.$style.'/default.css';  $noStyleFlag = true;
				
			}
			
			if($noStyleFlag)
			wp_enqueue_style('color-style',$listener);
			
			
		if($super_options[SN.'_mobile_view']!="false")	wp_enqueue_style('responsive-css',URL.'/sprites/responsive.css');
			
		
			}
		 
		 function addAdminScripts() {
		wp_enqueue_script('jquery-ui-datepicker',HURL."/js/jquery.ui.datepicker.min.js","jquery-ui-core",false);
			wp_enqueue_script('jquery-global',HURL.'/js/global.js');
			wp_enqueue_style('global-css',HURL.'/css/global.css');
			wp_enqueue_script('jquery-colorpicker',HURL.'/js/colorpicker.js');
			
			
			}
				
		 if(!is_admin())	
		add_action('init','addScripts');	
        else
		add_action('admin_init','addAdminScripts');	 
		
		
	}	
  
  // == Register Sidebars ===========================
  
  function initSidebars()
  {
    $homebar = array(
  'name' => 'Blog Sidebar',
  'id' => 'blog_sidebar',
  'description' => 'Widgets in this area will be shown in the right blog sidebar.',
  'before_widget' => '<div class="sidebar-wrap clearfix">',
  'after_widget' => '</div>',
  'before_title' => '<h3 class="custom-font heading">',
  'after_title' => '</h3>',
	);
	
	$footer_mobile = array(
	  'name' =>  "Footer Mobile",
	  'id' => 'footer_mobile',
	  'description' => 'Widgets will be shown in the Footer for Mobile Devices.',
	  'before_widget' => '<div class="footer-wrap clearfix">',
	  'after_widget' => '</div>',
	 'before_title' => '<h3 class="custom-font footer-heading">',
	  'after_title' => '</h3>',
	);
	
	
	$sidebars = array($homebar,$footer_mobile);
	
	if(function_exists('register_sidebar')){
		
		foreach($sidebars as $sidebar)
		register_sidebar($sidebar);
	
	} 
	
	 $this->registerDynamicFooter();

	  global $super_options;
	  
	  
	 
	  $dynamic_active_sidebars = unserialize($super_options[SN."_active_sidebars"]);
	 
      if(!is_array($dynamic_active_sidebars)) $dynamic_active_sidebars = array();
	  
	  foreach($dynamic_active_sidebars as  $widget)
	  {
		 $tid = strtolower ( str_replace(" ","_",trim($widget)) );
		 $temp_widget = array(
		
		'name' => $widget,
		'description' => __('This is a dynamic sidebar','h-framework'),
		'before_widget' => '<div class="dynamic-wrap sidebar-wrap clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="custom-font heading">',
		'after_title' => '</h3>',
		);
	  register_sidebar($temp_widget);
	  }
	  
  
  }
  
  // == Dynamic Footer =================================
  
	 
	 function registerDynamicFooter() {
		 
		 $footer_layout = get_option(SN."_footer_layout");
		
		 $count = 2;
		 switch($footer_layout)
		 {
			 case "two-col" : $count = 2 ; break;
			 case "three-col" : $count = 3 ; break;
			 case "four-col" : $count = 4 ; break;
			 case "five-col" : $count = 5 ; break;
			 case "six-col" : $count = 6 ; break;
			 case "one-third" : $count = 2 ; break;
			 case "one-fourth" : $count = 2 ; break;
			 case "one-fifth" : $count = 2 ; break;
			 case "one-sixth" : $count = 2 ; break;
			 

		 }
		 
		for($i=1;$i<=$count;$i++)
		 {
		   $sidebar = array(
						'name' => ("Footer Column $i"),
						'description' => 'Widgets will be shown in the footer.',
						'before_widget' => '<div class="footer-wrap clearfix">',
						'after_widget' => '</div>',
						'before_title' => '<h3 class="custom-font footer-heading">',
						'after_title' => '</h3>',
					  );	 
           
		   register_sidebar($sidebar);
		   
		 }
   }
   
   // == Register Custom Posts ================================
   
   function registerCustomPosts()
   {
	   $labels = array(
					  'name' => _x("Portfolios", 'post type general name','h-framework'),
					  'singular_name' => _x("Portfolio", 'post type singular name','h-framework'),
					  'add_new' => _x("Add New", 'portfolio','h-framework'),
					  'add_new_item' => __("Add New Portfolio",'h-framework','h-framework'),
					  'edit_item' => __("Edit Portfolio",'h-framework'),
					  'new_item' => __("New Portfolio",'h-framework'),
					  'all_items' => __("All Portfolio",'h-framework'),
					  'view_item' => __("View Portfolio",'h-framework'),
					  'search_items' => __("Search Portfolio",'h-framework'),
					  'not_found' =>  __("Not Found",'h-framework'),
					  'not_found_in_trash' => __("Not Found in Trash",'h-framework'), 
					  'parent_item_colon' => "",
					  'menu_name' => __("Portfolio",'h-framework')
				  
					);

 		$args = array(
					  'labels' => $labels,
					  'description' => __("Add your Portfolio here",'h-framework'),
					  'public' => true,
					  'publicly_queryable' => true,
					  'show_ui' => true,
					  'exclude_from_search' => false,
					  'query_var' => true,
					  'rewrite' => TRUE,
					  'menu_icon' => HURL."/css/i/cicon.png",
					  'rewrite' => true,
					  'capability_type' => 'post',
					  '_edit_link' => 'post.php?post=%d',
					  'rewrite' => array(
                        'slug' => "portfolio" ,
                        'with_front' => FALSE,
                        ),
					  'hierarchical' => false,
					  'menu_position' => null,
					  'supports' =>array('title','editor','author','thumbnail','comments')
					  );
	   $portfolio = new CustomPost("portfolio",$args,"Portfolio Categories");
	   $this->addSlidable();
	 
	    	   
   }
  
  
   /// == Add Slides Module =========================================
  
  function addSlidable(){
	  
	  
	  add_action("admin_init", "portfolio_admin_init");
	  
	  function portfolio_admin_init(){
		   add_meta_box("exportfolio_credits_meta", "Upload Extra Projects Images", "exportfolio_credits_meta", "portfolio", "normal", "high");
		   add_meta_box("exportfolio_credits_meta", "Upload Extra Projects Images", "exportfolio_credits_meta", "events", "normal", "high");
		 }
	  
	  
	  
	  function exportfolio_credits_meta() {
	      global $post;
	      $custom = get_post_custom($post->ID);
	      
		  if(isset($custom["gallery_items"][0]))
		 {
			  $slides = unserialize($custom["gallery_items"][0]);
	 	  if(!$slides) $slides = array();
		 }
		 else  $slides = array();
		 
	      ?>
	  
	    <div id="hades_gallery" class="slideable">
	 	  
	      <div class="toppanel clearfix">
	          <a href="#" id="addslide" class="button-save"><?php _e('Add item','h-framework'); ?></a>
	      </div>
	      <div class="slider-lists">
	      <ul>
			  <?php  foreach($slides as $slide) { if(trim($slide['src'])!="") : ?>
              <li class="clearfix contract">
              
              
              <div class="slide-head">
              <a href="#" class="move-icon"></a>
              <a href="#" class="max-slide-button edit-icon slide-toggle-button"><?php _e('Expand','h-framework'); ?></a>
              <a href="#" class="delete-slide-button removeslide"><?php _e('Delete','h-framework'); ?></a>
              
             
              
              </div>
              <div class="slide-body">
              
              <div class="image-slide">
              <div class="separator clearfix">
              
              <div class="clearfix">
              <label for=""><?php _e('Upload Image/Media Link:','h-framework'); ?></label>
              <input type="text" class="" name="imagesrc[]" value="<?php echo $slide['src'] ?>" />
              <a href="#" class="image_upload button-default" title="Add to Slideshow"><?php _e('Upload','h-framework'); ?></a>
              </div>
              
              <div class="clearfix">
            		<label for=""  class="alignright"><?php _e('Layout:','h-framework'); ?></label>
                    <div class="select-wrapper">
                    <select id="" name="imagelayout[]">
                    	<?php 
							$ar = array("full" => "Full Width" , "half" => "Half Width" );
							foreach($ar as $key => $value)
							{
								if($slide['layout']==$key) echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';		
								else  echo '<option value="'.$key.'">'.$value.'</option>';		
							}
						?>
                    </select>  
                    </div>
              </div>
              
               <div class="clearfix">
            		<label for=""  class="alignright"><?php _e('Media Type:','h-framework'); ?></label>
                    <div class="select-wrapper">
                    <select id="" name="media[]">
                    	<?php 
							$ar = array("image" => "Image" , "youtube" => "Youtube", "vimeo" => "Vimeo" );
							foreach($ar as $key => $value)
							{
								if($slide['media']==$key) echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';		
								else  echo '<option value="'.$key.'">'.$value.'</option>';		
							}
						?>
                    </select>  
                    </div>
              </div>
              
              
              
              </div>     
             
              </div>
              </div>
              
           
              <input type="hidden" name="slide_type[]" value="upload" class="slide_type" />
              </li>
	      <?php endif; } ?>
	      </ul>
          
          
          
           <ul class="cloneable hide">
			
              <li class="clearfix contract">
              
              
              <div class="slide-head">
              <a href="#" class="move-icon"></a>
              <a href="#" class="max-slide-button edit-icon slide-toggle-button"><?php _e('Expand','h-framework'); ?></a>
              <a href="#" class="delete-slide-button removeslide"><?php _e('Delete','h-framework'); ?></a>
              
             
              
              </div>
              <div class="slide-body">
              
              <div class="image-slide">
              <div class="separator clearfix">
              
              <div class="clearfix">
              <label for=""><?php _e('Upload Image/Media Link:','h-framework'); ?></label>
              <input type="text" class="" name="imagesrc[]" value="" />
              <a href="#" class="image_upload button-default" title="Add to Slideshow"><?php _e('Upload','h-framework'); ?></a>
             </div>
             
              <div class="clearfix">
            		<label for="" class="alignright"><?php _e('Layout:','h-framework'); ?></label>
                    <div class="select-wrapper"> <select id="" name="imagelayout[]">
                    	<?php 
							$ar = array("full" => "Full Width" , "half" => "Half Width" );
							foreach($ar as $key => $value)
							 echo '<option value="'.$key.'">'.$value.'</option>';		
							
						?>
                    </select>  </div>
              </div>
             
             
              <div class="clearfix">
            		<label for="" class="alignright"><?php _e('Media Type:','h-framework'); ?></label>
                    <div class="select-wrapper">
                    <select id="" name="media[]">
                    	<?php 
							$ar = array("image" => "Image" , "youtube" => "Youtube", "vimeo" => "Vimeo" );
							foreach($ar as $key => $value)
							{
								 echo '<option value="'.$key.'">'.$value.'</option>';		
							}
						?>
                    </select>  
                    </div>
              </div>
              
               
             
              </div>     
             
              </div>
              </div>
              
           
              <input type="hidden" name="slide_type[]" value="upload" class="slide_type" />
              </li>
	    
	      </ul>
	  
	    </div>
	  </div>
	   <?php
	  }
	  
	  add_action('save_post', 'exportfolio_save_details');
	  
	  function exportfolio_save_details(){
	  global $post;
	  if(isset($_POST['slide_type'])) {
	  
	  $slides = array();
	  
	  foreach ( $_POST['slide_type'] as $key => $value )
	  {
	  $urlimage = $_POST['imagesrc'][$key];
	  $ilink =  $_POST['link_src'][$key];
	  $ilayout=  $_POST['imagelayout'][$key];
	   $media =  $_POST['media'][$key];
	  
	  
	  $slides[] = array(
	  'src' => $urlimage,
	  'link' => $ilink ,
	  'type' => $value,
	  'title' => '',
	  'media' => $media,
	  'layout' => $ilayout
	  );
	  
	  
	  
	  }
	  
	  update_post_meta($post->ID, "gallery_items", $slides);
	  update_post_meta($post->ID, "gallery_column", $_POST['gallery_column']);
	  }
	 
	  }
	  
	  function add_exportfolio_scripts()
	  {
	  wp_enqueue_script('jquery-ui-core');
	  wp_enqueue_script('jquery-ui-sortable');
	  
	  }
	  
	  add_action('admin_init','add_exportfolio_scripts');
	
   } 	
   
  // == Shorten Content ===================================
  
  public function getShortenContent($num,$content,$trailing='...') {
	
	$limit = $num+1;
  
	  $scontent = str_split($content);
	  $length = count($scontent);
	  if ($length>=$num) {
		  $scontent = array_slice( $scontent, 0, $num);
		  $scontent = implode("",$scontent).$trailing;
		  return $scontent;
		} else {
		  return $content;
		}
	}
 
 // == Image Display ======================================
 
 public function imageDisplay( $options )
	{
	  global $super_options;
	  extract( array_merge(  array( "src" => NULL , "height" => 300 , "width" => 600 , "lightbox" => false , 'parent_wrap' => true , "hoverable" => false , "advance_query" => false , "gallery" => false  , "link" =>'' , "title" => '' , 'crop' => '' , 'class' => '', 'imageAttr' => '' , 'imgclass' => '' ) ,$options ) );
	  $o_src =  $src;
	  $src = $this->getMUFix($src); 
	    
	  $rel = '';
	  
	
	  
	  if($hoverable)	$hoverable = '<span class="hover-image"> <small></small> </span>';
	  if($lightbox) {  $link = $o_src;  $lightbox = 'lightbox'; } 
	  if($gallery)    $rel = 'rel=prettyPhoto[pp_gal]';
	  
	  if($super_options[SN."_image_resize"]=="Timthumb") :
	  
	  if($advance_query) $advance_query = "&amp;".$advance_query; 
	   
	  $zc_opt = ($super_options[SN."_timthumb_zc"]=="") ? "Hard Resize" : trim($super_options[SN."_timthumb_zc"]) ;
	  $zc = 0;
	  switch($zc_opt)
	  {
		  case "Hard Resize" : $zc = 0; break;
		  case "Smart crop and resize" : $zc = 1; break;
		  case "Resize Proportionally" : $zc = 0; $height =''; break;
		  
	  }
	  
	  if($crop!='') $zc = $crop; 
	 
	  $image =    "  $hoverable  <img class='".$imgclass."' $imageAttr src='".URL."/timthumb.php?src=".urlencode($src)."&amp;h=$height&amp;w=$width&amp;zc=$zc${advance_query}'    />";
	 
	 elseif($super_options[SN."_image_resize"]=="none") :
	 $image =    "  $hoverable  <img class='".$imgclass."' $imageAttr src='".$src."'  width='$width' height='$height'   />";
	 
	 elseif($super_options[SN."_image_resize"]=="Wordpress Core resizer") :
		
		
		$cr_img = $this->wp_resize(NULL,$src,$width,$height);
		
		$image = "  $hoverable  <img $imageAttr class='".$imgclass."' src='".($cr_img["url"])."'    />";
	
	 endif;
	 
	 
	 
	  if($parent_wrap) $image = "<a href='$link' class='$lightbox imageholder $class' title='$title'> $image </a>";		 				 
			 
	  return $image;
	}
	
 
 
 // == WP Core resizer ==================
	
	public function wp_resize($attach_id = null, $img_url = null, $width, $height, $crop = true) {

   if($img_url){

        $file_path = parse_url($img_url);
        $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

        $orig_size = getimagesize($file_path);

        $image_src[0] = $img_url;
        $image_src[1] = $orig_size[0];
        $image_src[2] = $orig_size[1];
    }

    $file_info = pathinfo($file_path);
    $extension = '.'. $file_info['extension'];

    // the image path without the extension
    $no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];

    $cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;

  

        // no cache files - let's finally resize it
        $new_img_path = image_resize($file_path, $width, $height, $crop);
        $new_img_size = getimagesize($new_img_path);
        $new_img = str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);

        // resized output
        $vt_image = array (
            'url' => $new_img,
            'width' => $new_img_size[0],
            'height' => $new_img_size[1]
        );

        return $vt_image;
   
   
  

}	
 
 // == MU Fix ===================================
	
	public function getMUFix($src){
	   
	   global $super_options;
	  
	  $resize_opt = trim($super_options[SN."_image_resize"]);
	  
	  
	  $theImageSrc = $src;
                          global $blog_id;
                          if (isset($blog_id) && $blog_id > 0) {
                          $imageParts = explode('/files/', $theImageSrc);
                          if (isset($imageParts[1])) {
                              $theImageSrc = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
							   if($resize_opt=="Wordpress Core resizer") return  '/wp-content'.$theImageSrc;	
                          }
						 	
                      }	
					  
	if($resize_opt=="Wordpress Core resizer") return  $src;		
	  		  
	return $theImageSrc;				  
		}   
			
 // == Custom Formatter ======================
   
   public function format($content,$strip_tags = false,$shortcode=true,$autop=true){
	    $content = 	stripslashes($content);
	    
		if($shortcode) $content = do_shortcode( $content  ); 
	    $content = preg_replace('#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content);
	  
	   if($strip_tags) $content = strip_tags($content);
	   if($autop) $content = $this->raw_formatter($content);
			 
	   return $content;
	   
	   }		

public function generateToolKit()
{
	?>
	
  

<!-- ========================== Visual Panel Code == -->
<div class="thunder_wrapper"> <a href="" id="save-th-settings" data-url="<?php echo HURL."/helper/event_listener.php";?>" >Save</a>
	<a href="" id="delete-th-settings" data-url="<?php echo HURL."/helper/event_listener.php";?>">Delete</a>
    <ul class="nav nav-tabs" id="thundertabs">
  <li class="active" id="thome" ><a href="#thhome">Home</a></li>
  <li id="ttext" ><a href="#thtext">Text</a></li>
  <li id="tlist" ><a href="#thlist">List</a></li>
  <li id="tlinks"><a href="#thlinks">Links</a></li>
   <li id="theadings"><a href="#thheadings">Headings</a></li>
   <li id="timage"><a href="#thimage">Image</a></li>
   <li id="tbutton"><a href="#thbutton">Button</a></li>
  <li id="tsubmenu"><a href="#thsubmenu">Button</a></li>
</ul>
 
<div class="tab-content">
  <div class="tab-pane active" id="thhome">
    
    		<div class="hades_input clearfix thunder-option-available bgi">
                                          <label for="#bgi">Background Image</label>
                                           <div class="upload_wrapper clearfix"  >
                                      		<input name="" id="bgi" type="text" value="" class="panel_upload" data-attr="background-image"/>
                                      		<a href="#" class="image_upload button-default" title="" data-url="<?php echo admin_url()."/media-upload.php"; ?>">Upload Image</a>
                                      </div>
             </div>
             
             <div class="hades_input clearfix thunder-option-available bgp">
             		<label for="#bgp">Background Position</label>
                    <select name="" id="" data-attr="background-position">
                    	<option value="top left">Top Left</option>
                        <option value="top right">Top Right</option>
                        <option value="top center">Top Center</option>
                        <option value="center center">Center Center</option>
                        <option value="right center">Left Center</option>
                         <option value="left center">Right Center</option>
                        <option value="bottom left">Bottom Left</option>
                        <option value="bottom center">Bottom Center</option>
                        <option value="bottom right">Bottom Right</option>
                    </select>
             </div>
             
              <div class="hades_input clearfix thunder-option-available bgr">
             		<label for="#bgr">Background Repeat</label>
					  <select name="" id="" data-attr="background-repeat" >
                    	<option value="repeat">Repeat</option>
                        <option value="no-repeat">No Repeat</option>
                        <option value="repeat-x">Repeat X</option>
                        <option value="repeat-y">Repeat Y</option>
                        
                    </select>
             </div>
             
              
  			 <div class="hades_input clearfix thunder-option-available cr">
                                          <label for="#thc"> Color</label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
    		 <div class="hades_input clearfix thunder-option-available bg">
                                          <label for="#thbg">Background Color</label>
                                       
                                          <div class="colorSelector" data-attr="background-color" ><div style="background-color:#fff"></div></div>
                                         
                                         
             </div>
             
              <div class="hades_input clearfix thunder-option-available br">
                                          <label for="#thbbr"> Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-color" ><div style="background-color:#fff"></div></div>
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available bbr">
                                          <label for="#thbbr">Bottom Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-bottom-color" ><div style="background-color:#fff"></div></div>
                                         
             </div>
             
             
              <div class="hades_input clearfix thunder-option-available sbbr">
                                          <label for="#thc"> Bottom Border Color</label>
                                        
                                          <div class="colorSelector" data-attr="border-bottom-color"><div style="background-color:#fff"></div></div>
              </div>
             
             
             
              <div class="hades_input clearfix thunder-option-available tbr">
                                          <label for="#thbbr">Top Border Color</label>
                                         
                                          <div class="colorSelector"  data-attr="border-top-color"><div style="background-color:#fff"></div></div>
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available rbr">
                                          <label for="#thrbr">Right Border Color</label>
                                        
                                          <div class="colorSelector"  data-attr="border-right-color"><div style="background-color:#fff"></div></div>
                                       
             </div>
             
              <div class="hades_input clearfix thunder-option-available lbr">
                                          <label for="#thlbr">Left Border Color</label>
                                         
                                          <div class="colorSelector"  data-attr="border-left-color"><div style="background-color:#fff"></div></div>
              </div>
              
              
              
              
  
  </div>
   <div class="tab-pane" id="thlist">
  		  <div class="hades_input clearfix thunder-option-available cr">
                                          <label for="#thc"> Color</label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
    		 <div class="hades_input clearfix thunder-option-available bg">
                                          <label for="#thbg">Background Color</label>
                                       
                                          <div class="colorSelector" data-attr="background-color" ><div style="background-color:#fff"></div></div>
                                         
                                         
             </div>
             
             <div class="hades_input clearfix thunder-option-available br">
                                          <label for="#thbbr"> Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-color" ><div style="background-color:#fff"></div></div>
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available bbr">
                                          <label for="#thbbr">Bottom Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-bottom-color" ><div style="background-color:#fff"></div></div>
                                         
             </div>
             
             
              <div class="hades_input clearfix thunder-option-available tbr">
                                          <label for="#thbbr">Top Border Color</label>
                                         
                                          <div class="colorSelector"  data-attr="border-top-color"><div style="background-color:#fff"></div></div>
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available rbr">
                                          <label for="#thrbr">Right Border Color</label>
                                        
                                          <div class="colorSelector"  data-attr="border-right-color"><div style="background-color:#fff"></div></div>
                                       
             </div>
             
              <div class="hades_input clearfix thunder-option-available lbr">
                                          <label for="#thlbr">Left Border Color</label>
                                         
                                          <div class="colorSelector"  data-attr="border-left-color"><div style="background-color:#fff"></div></div>
                                         
             </div>
  </div>
  <div class="tab-pane" id="thtext">
  		 <div class="hades_input clearfix thunder-option-available cr">
                                          <label for="#thc"> Color</label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
    		 <div class="hades_input clearfix thunder-option-available bg">
                                          <label for="#thbg">Background Color</label>
                                       
                                          <div class="colorSelector" data-attr="background-color" ><div style="background-color:#fff"></div></div>
                                         
                                         
             </div>
             
              <div class="hades_input clearfix thunder-option-available br">
                                          <label for="#thbbr"> Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-color" ><div style="background-color:#fff"></div></div>
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available bbr">
                                          <label for="#thbbr">Bottom Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-bottom-color" ><div style="background-color:#fff"></div></div>
                                         
             </div>
             
             
              <div class="hades_input clearfix thunder-option-available tbr">
                                          <label for="#thbbr">Top Border Color</label>
                                         
                                          <div class="colorSelector"  data-attr="border-top-color"><div style="background-color:#fff"></div></div>
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available rbr">
                                          <label for="#thrbr">Right Border Color</label>
                                        
                                          <div class="colorSelector"  data-attr="border-right-color"><div style="background-color:#fff"></div></div>
                                       
             </div>
             
              <div class="hades_input clearfix thunder-option-available lbr">
                                          <label for="#thlbr">Left Border Color</label>
                                         
                                          <div class="colorSelector"  data-attr="border-left-color"><div style="background-color:#fff"></div></div>
                                         
             </div>
  </div>
  <div class="tab-pane" id="thlinks">
  			  <div class="hades_input clearfix thunder-option-available cr">
                                          <label for="#cr"> Color</label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available crh">
                                          <label for="#crh"> Hover Color </label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available crma">
                                          <label for="#crma"> Active Color </label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
             <div class="hades_input clearfix thunder-option-available cra">
                                          <label for="#cra"> Active Color </label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
             <div class="hades_input clearfix thunder-option-available bga">
                                          <label for="#bga"> Active Background Color </label>
                                        
                                          <div class="colorSelector" data-attr="background-color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
             <div class="hades_input clearfix thunder-option-available bbra">
                                          <label for="#cra"> Active/Hover Border Bottom Color </label>
                                        
                                          <div class="colorSelector" data-attr="border-bottom-color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
             
    		 <div class="hades_input clearfix thunder-option-available bg">
                                          <label for="#thbg">Background Color</label>
                                       
                                          <div class="colorSelector" data-attr="background-color" ><div style="background-color:#fff"></div></div>
                                         
                                         
             </div>
             
              <div class="hades_input clearfix thunder-option-available br">
                                          <label for="#thbbr"> Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-color" ><div style="background-color:#fff"></div></div>
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available bbr">
                                          <label for="#thbbr">Bottom Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-bottom-color" ><div style="background-color:#fff"></div></div>
                                         
             </div>
             
             
              <div class="hades_input clearfix thunder-option-available tbr">
                                          <label for="#thbbr">Top Border Color</label>
                                         
                                          <div class="colorSelector"  data-attr="border-top-color"><div style="background-color:#fff"></div></div>
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available rbr">
                                          <label for="#thrbr">Right Border Color</label>
                                        
                                          <div class="colorSelector"  data-attr="border-right-color"><div style="background-color:#fff"></div></div>
                                       
             </div>
             
              <div class="hades_input clearfix thunder-option-available lbr">
                                          <label for="#thlbr">Left Border Color</label>
                                         
                                          <div class="colorSelector"  data-attr="border-left-color"><div style="background-color:#fff"></div></div>
                                         
             </div>
             
               <div class="hades_input clearfix thunder-option-available bgh">
                                          <label for="#thbg">Background Hover Color</label>
                                       
                                          <div class="colorSelector" data-attr="background-color" ><div style="background-color:#fff"></div></div>
               </div>
               
       
                 
                 
             
  </div>
  <div class="tab-pane" id="thsubmenu">
  			  <div class="hades_input clearfix thunder-option-available cr">
                                          <label for="#cr"> Color</label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available crh">
                                          <label for="#crh"> Hover Color </label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
           
    		 <div class="hades_input clearfix thunder-option-available bg">
                                          <label for="#thbg">Background Color</label>
                                       
                                          <div class="colorSelector" data-attr="background-color" ><div style="background-color:#fff"></div></div>
                                         
                                         
             </div>
        
              <div class="hades_input clearfix thunder-option-available list-bbr">
                                          <label for="#thbbr">Links Bottom Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-bottom-color" ><div style="background-color:#fff"></div></div>
                                         
             </div>
          
             
              <div class="hades_input clearfix thunder-option-available rbr">
                                          <label for="#thrbr">Right Border Color</label>
                                        
                                          <div class="colorSelector"  data-attr="border-right-color"><div style="background-color:#fff"></div></div>
                                       
             </div>
        
       
                 
                 
             
  </div>
  
  <div class="tab-pane" id="thheadings">
  			  <div class="hades_input clearfix thunder-option-available cr">
                                          <label for="#thc"> Color</label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
    		 <div class="hades_input clearfix thunder-option-available bg">
                                          <label for="#thbg">Background Color</label>
                                       
                                          <div class="colorSelector" data-attr="background-color" ><div style="background-color:#fff"></div></div>
                                         
                                         
             </div>
             
              <div class="hades_input clearfix thunder-option-available br">
                                          <label for="#thbbr"> Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-color" ><div style="background-color:#fff"></div></div>
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available bbr">
                                          <label for="#thbbr">Bottom Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-bottom-color" ><div style="background-color:#fff"></div></div>
                                         
             </div>
             
             
              <div class="hades_input clearfix thunder-option-available tbr">
                                          <label for="#thbbr">Top Border Color</label>
                                         
                                          <div class="colorSelector"  data-attr="border-top-color"><div style="background-color:#fff"></div></div>
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available rbr">
                                          <label for="#thrbr">Right Border Color</label>
                                        
                                          <div class="colorSelector"  data-attr="border-right-color"><div style="background-color:#fff"></div></div>
                                       
             </div>
             
              <div class="hades_input clearfix thunder-option-available lbr">
                                          <label for="#thlbr">Left Border Color</label>
                                         
                                          <div class="colorSelector"  data-attr="border-left-color"><div style="background-color:#fff"></div></div>
                                         
             </div>
  </div>
  
  
   <div class="tab-pane" id="thbutton">
  			  <div class="hades_input clearfix thunder-option-available cr">
                                          <label for="#cr"> Color</label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available crh">
                                          <label for="#crh"> Hover Color </label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
             
             
    		 <div class="hades_input clearfix thunder-option-available bg">
                                          <label for="#thbg">Background Color</label>
                                       
                                          <div class="colorSelector" data-attr="background-color" ><div style="background-color:#fff"></div></div>
                                         
                                         
             </div>
             
             <div class="hades_input clearfix thunder-option-available bgh">
                                          <label for="#thbg">Background Hover Color</label>
                                       
                                          <div class="colorSelector" data-attr="background-color" ><div style="background-color:#fff"></div></div>
                                         
                                         
             </div>
             
              <div class="hades_input clearfix thunder-option-available br">
                                          <label for="#thbbr"> Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-color" ><div style="background-color:#fff"></div></div>
                                        
             </div>
             
             <div class="hades_input clearfix thunder-option-available brh">
                                          <label for="#thbbr"> Border Hover Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-color" ><div style="background-color:#fff"></div></div>
                                        
             </div>
             
              
  </div>
  
  
   <div class="tab-pane" id="thimage">
  			  <div class="hades_input clearfix thunder-option-available cr">
                                          <label for="#cr"> Color</label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
              <div class="hades_input clearfix thunder-option-available crh">
                                          <label for="#crh"> Hover Color </label>
                                        
                                          <div class="colorSelector" data-attr="color"><div style="background-color:#fff"></div></div>
                                         
                                        
             </div>
             
             
             
    		 <div class="hades_input clearfix thunder-option-available bg">
                                          <label for="#thbg">Background Color</label>
                                       
                                          <div class="colorSelector" data-attr="background-color" ><div style="background-color:#fff"></div></div>
                                         
                                         
             </div>
             
             <div class="hades_input clearfix thunder-option-available bgh">
                                          <label for="#thbg">Background Hover Color</label>
                                       
                                          <div class="colorSelector" data-attr="background-color" ><div style="background-color:#fff"></div></div>
                                         
                                         
             </div>
             
              <div class="hades_input clearfix thunder-option-available br">
                                          <label for="#thbbr"> Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-color" ><div style="background-color:#fff"></div></div>
                                        
             </div>
             
             <div class="hades_input clearfix thunder-option-available brh">
                                          <label for="#thbbr"> Border Hover Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-color" ><div style="background-color:#fff"></div></div>
                                        
             </div>
             
                <div class="hades_input clearfix thunder-option-available bbr">
                                          <label for="#thbbr">Bottom Border Color</label>
                                         
                                          <div class="colorSelector" data-attr="border-bottom-color" ><div style="background-color:#fff"></div></div>
                                         
             </div>
             
             
               <div class="hades_input clearfix thunder-option-available tbr">
                                          <label for="#thbbr">Top Border Color</label>
                                         
                                          <div class="colorSelector"  data-attr="border-top-color"><div style="background-color:#fff"></div></div>
                                        
             </div>
             
             
  </div>
  
</div>


</div>
<!-- =================== End of Visual Panel Code == -->
	
	<?php
}

 // == Home Generator =======================
 public	 function fcmp($a, $b){    return strcmp($b['factor'], $a['factor']); } // for starting date
	public  function eecmp($a, $b){    return strcmp($b['efactor'], $a['efactor']); } // for ending date
	public  function phcmp($a, $b){    return strcmp($b['pfactor'], $a['pfactor']); } // for published date
 public function titanGenerator($id)
 {
	 global $wpdb;
	 $table_db_name = $wpdb->prefix . "teditor";
	 $table = $wpdb->get_row("SELECT * FROM $table_db_name where id='$id' ",ARRAY_A);
	 
	 $layout = unserialize($table['layout']);
	 if( !is_array($layout) ) $layout = array(); 
	 
     $beginClear = false; $hasLayout = ' skeleton ';
				  
	 foreach($layout as $element)
	 {
		 if(! is_array($element[1]) ) $element[1]['Layout'] = '';
		 
		
		 if( isset($element[1]['Layout']) && trim($element[1]['Layout'])!="" && trim($element[1]['Layout'])!="none" && !$beginClear )
		 {
		 $beginClear = true; $hasLayout = 'layout_element';
		  echo "<div class='clearfix skeleton'>"; 
		 }
		 
		  
		 switch($element[0])
		 {
			   case 'scrollable-post' : 
		   
		    $data = $element[1]; ?>
		 
          <div  class="clearfix latest-scrollable-posts isScrollable thunder_listener <?php echo $data['Layout'].' '.$hasLayout; ?>" data-headings-filter="cr bbr" data-text-filter="cr" data-image-filter="bbr">
         
         <a href="" class="scrollable-prev"></a> 
         <a href="" class="scrollable-next"></a>
         
          <div class="desc thunder_image">
                  	  <h3 class=" custom-font"><?php echo  stripslashes( $data['title'] ) ; ?></h3>
                      <p  class="custom-font "><?php echo  stripslashes( $data['description'] ) ; ?></p>
          </div>
                 
                   
         <div class="scrollable">
           <div class="items">
			<?php 
            $post_type = $data['post_type'];
         $opts = array(
			
			'post_type' => $post_type, 
			'posts_per_page' => $data['no_of_posts'],
			 'tax_query' =>  array(
							   array(
										'taxonomy' => 'post_format',
										'field' => 'slug',
										'terms' => array('post-format-quote','post-format-aside','post-format-video','post-format-link'),
										'operator' => 'NOT IN'
									)
							)
			);
			
			if($post_type=="post") $opts['category_name'] = $data['category'];
			else  if(isset($opts['portfoliocategories']))
			{
				
				 $opts['portfoliocategories'] = $data['category'];
				  $opts['tax'] = $data['portfoliocategories'];
			}
			
			$popPosts = new WP_Query($opts);
			
			$w = 960; $h = 420;
			
			switch($data['Layout'])
			{
				case 'two_third' : case 'two_third_last' : $w = 625; $h = 400; break;
				case 'one_third' : case 'one_third_last': $w = 293; $h = 400; break;
				case 'one_half' : case 'one_half_last': $w = 455; $h = 400; break;
				case 'three_fourth' : case 'three_fourth_last': $w = 710; $h = 400; break;
				case 'one_fourth' : case 'one_fourth_last': $w = 210; $h = 400; break;
			}
           
            $i =0;
            
			while ($popPosts->have_posts()) : $popPosts->the_post();  $more = 0;  ?>
             <div class="post-block">
             	
                  
              <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>
  
                  <div class="image">
                  <?php 
                  $id = get_post_thumbnail_id();
                  $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
                 
				  if($data['link_type']=="post")
				  	echo $this->imageDisplay( array( "src" => $ar[0] , "height" => $h , "width" => $w , "lightbox" => false , "link" => get_permalink() , "advance_query" => "&amp;a=t;" , 'title' => get_the_title()))." <a class='hover' href=\"".get_permalink()."\"><span></span></a>"; 
				  else
				  	echo $this->imageDisplay( array( "src" => $ar[0] , "height" => $h , "width" => $w , "link" =>  $ar[0] , "advance_query" => "&amp;a=t;"  , 'title' => get_the_title()))." <a href=\"".$ar[0]."\"  title='".get_the_title()."' class='lightbox hover'><span class='zoom'></span></a>"; 
                
				  ?> 
                 
                  
                  </div><!--image-->
                  <?php  endif; ?>
                 
             </div>     
              <?php $i++;  endwhile; ?>
            </div>
            </div>  
            
        
          </div>
		  <?php break;
		  
			
			 
			case 'slider' : 
		 	$data = $element[1];
			 $table_db_name = $wpdb->prefix . "tslidermanager";
			 $slider = $wpdb->get_row("SELECT * FROM $table_db_name where id='".$data["id"]."' ",ARRAY_A); 
			

			
			 $slides = unserialize($slider['slides']); 
			 $options =  unserialize($slider['options']);
			
			 
						 
			 
			 if( !is_array($slides) ) $slides = array(); 
			
			 $pslider =  new Orion($slides,$options);
			 echo '<div class="titan_slider thunder_listener '.  $data['Layout'].' '.$hasLayout.'" data-filter="bg" ><div class=" ">'.$pslider->getSlider()."</div></div>";	
		 
			break;
			case 'pricing-table' : 
			$data = $element[1];
						 echo '<div class="pricing-section '. $data['Layout'].' '.$hasLayout.' "> '.$this->raw_formatter(do_shortcode("[megatables id='".$data['id']."' /]"))."</div>";	
		 
			break;
			case 'two-columns' : 
			$i=0;
			echo ' <div class="home-page-two-columns editor-cols thunder_listener" data-filter="bg bgi bgri bgp bbr" data-text-filter="cr" data-link-filter="cr" data-headings-filter="cr bbr" data-list-filter="cr"  ><div class=" skeleton clearfix"><div class="column-inner-wrapper clearfix">';
			
			$layouts = explode(",",$element[2]);
			$cw = 470; 
			foreach($element[1] as $column)
			{
				$ch = 150;
				switch($layouts[$i])
				{
					case "one_half" :  case "one_half_last" :  $cw =470; $ch = 200;  break;
					case "one_third" : case "one_third_last"  :  $cw =300; $ch = 191; break;
					case "one_fourth" :  case "one_fourth_last"  :  $cw =255;  break;
					case "two_third" :  case "two_third_last" :  $cw =638; $ch = 155;  break;
					case "three_fourth" :  case "three_fourth" :  $cw =724;  break;
					case "one_fifth" :  case "one_fifth_last"  :  $cw =163;  break;
					case "four_fifth" :  case "four_fifth_last"  :  $cw =770;  break;
					default: $cw = 470;

				}
				
				?>
                
               
                
				<div class="<?php  echo $layouts[$i]; ?> layout_element clearfix">
          
				   
                    
                    
                    <div class="description <?php if($column['img_src']!="" && $column['behavior']=="top_image") echo 'hasImage' ; ?>">
                       <div class="intro-fancy-title">
                          	<?php if($column['img_src']!="" && $column['behavior']=="icon") : echo "<img src='".$column['img_src']."' alt='logo'/>"; endif; ?>
                          
                          
                         <div class="clearfix">
						    <?php if($column['title']!="") : ?>  <h2 class="custom-font"><?php echo $this->format($column['title'],false,false,false); ?></h2>  <?php endif; ?>  
                          	<?php if($column['subtitle']!="") : ?>  <h6 class="custom-font"><?php echo $this->format($column['subtitle'],false,false,false); ?></h6>  <?php endif; ?>  
                          </div>
                        </div>
                        <div class="column-content">
                             
                    <?php if($column['img_src']!="" && $column['behavior']=="top_image") : echo '<div class="col-image">'.$this->imageDisplay(array( "src" => $column['img_src'] , "width" => 189 , "height" => 126 , "parent_wrap" => false , "advance_query" => "&amp;a=t;"))."</div>"; endif; ?>
                    
							<?php echo $this->format($column['text']); ?>
                        </div>
                    </div>
                </div>
				
				<?php
				$i++;
			}
			echo '</div></div></div>';
			break;
		  
		  
		  case 'three-columns' : 
			$i=0;
			echo ' <div class="home-page-three-columns editor-cols thunder_listener " data-filter="bg bgi bgri bgp bbr" data-text-filter="cr" data-link-filter="cr" data-headings-filter="cr bbr" ><div class="skeleton clearfix"><div class="column-inner-wrapper clearfix">';
			$layouts = explode(",",$element[2]); $cw = 300;
			foreach($element[1] as $column)
			{
				switch($layouts[$i])
				{
					case "one_half" :  case "one_half_last" :  $cw =470;  break;
					case "one_third" : case "one_third_last"  :  $cw =340;  break;
					case "one_fourth" :  case "one_fourth_last"  :  $cw =215;  break;
					case "two_third" :  case "two_third" :  $cw =638;  break;
					case "three_fourth" :  case "three_fourth" :  $cw =724;  break;
					case "one_fifth" :  case "one_fifth_last"  :  $cw =163;  break;
					case "four_fifth" :  case "four_fifth_last"  :  $cw =770;  break;
					default: $cw = 300;

				}
				
				?>
                
               
                
				<div class="<?php echo $layouts[$i]; ?> layout_element clearfix">
          
					    
                  
                    
                    
                    <div class="description <?php if($column['img_src']!="" && $column['behavior']=="top_image") echo 'hasImage' ; ?>">
                
                    
                    
                        <div class="intro-fancy-title">
                          	<?php if($column['img_src']!="" && $column['behavior']=="icon") : echo "<img src='".$column['img_src']."' alt='logo'/>"; endif; ?>
                            <?php if($column['img_src']!="" && $column['behavior']=="top_image") : echo '<div class="col-image">'.$this->imageDisplay(array( "src" => $column['img_src'] , "width" => 60 , "height" => 60 , "parent_wrap" => false , "advance_query" => "&amp;a=t;"))."</div>"; endif; ?>
                          
                         <div class="clearfix">
						    <?php if($column['title']!="") : ?>  <h2 class="custom-font"><?php echo $this->format($column['title'],false,false,false); ?></h2>  <?php endif; ?>  
                          	<?php if($column['subtitle']!="") : ?>  <h6 class="custom-font"><?php echo $this->format($column['subtitle'],false,false,false); ?></h6>  <?php endif; ?>  
                          </div>
                        </div>
                        
                        
                        <div class="column-content">
                            <?php echo $this->format($column['text']); ?>
                        </div>
                    </div>
                    
                </div>
				
				<?php
				$i++;
			}
			echo '</div></div></div>';
			break;
		
		 case 'four-columns' : 
			$i=0;
			echo ' <div class="home-page-four-columns editor-cols thunder_listener" data-filter="bg bgi bgri bgp bbr" data-text-filter="cr" data-link-filter="cr" data-headings-filter="cr bbr"  ><div class="skeleton clearfix"><div class="column-inner-wrapper clearfix">';
			foreach($element[1] as $column)
			{
				?>
                
               
                
				<div class="one_fourth<?php if($i==count($element[1])-1) echo '_last'; ?> layout_element clearfix">
                
                	    
                    <?php if($column['img_src']!="" && $column['behavior']=="top_image") : echo '<div class="col-image">'.$this->imageDisplay(array( "src" => $column['img_src'] , "width" => 60 , "height" => 60 , "parent_wrap" => false , "advance_query" => "&amp;a=t;"))."</div>"; endif; ?>
                    
          
                    <div class="description <?php if($column['img_src']!="" && $column['behavior']=="top_image") echo 'hasImage' ; ?>">
                    
					
                       <div class="intro-fancy-title">
                          	<?php if($column['img_src']!="" && $column['behavior']=="icon") : echo "<img src='".$column['img_src']."' alt='logo'/>"; endif; ?>
                          
                          
                         <div class="clearfix">
						    <?php if($column['title']!="") : ?>  <h2 class="custom-font"><?php echo $this->format($column['title'],false,false,false); ?></h2>  <?php endif; ?>  
                          	<?php if($column['subtitle']!="") : ?>  <h6 class="custom-font"><?php echo $this->format($column['subtitle'],false,false,false); ?></h6>  <?php endif; ?>  
                          </div>
                        </div>
                        
                        <div class="column-content">
                            <?php echo $this->format($column['text']); ?>
                        </div>
                    </div>
                </div>
				
				<?php
				$i++;
			}
			echo '</div></div></div>';
			break;
		  
		 case 'full-width' : 
		$data = $element[1];
		  ?>
		  <div class="full-width-text "><div class=" skeleton clearfix"> <?php  echo $this->format($data['text']); ?> </div></div>
		  <?php
		 
		 break; 		
		 
		 case 'full-width-divider' : 
		  ?>
		 <div class="separator thunder_listener" data-filter="tbr"> <?php  if($element[1]=="icon") echo '<a href="">'.__("BACK TO TOP","h-framework").'</a>'; ?>  </div>
		  <?php
		 break; 
		 
		 case 'intro-text' : 
		 $data = $element[1];
		 ?>
        
         <div class="blurb-wrapper  <?php echo $data['Layout'].' '.$hasLayout; ?> thunder_listener" data-filter="bg bgi bgr bgp" data-text-filter="cr" data-headings-filter="cr" data-button-filter="bg bgh cr crh"  > <!-- Blurb Wrapper -->
           <div class=" clearfix">
            <div class="inner-blurb-wrapper clearfix>">
            
            <div class="text_area">
           			 <h3 class="blurb-text"><?php echo $this->format($data['title'],false,false,false); ?></h3>
            		 <p class="blurb-secondary-text custom-font"><?php echo $this->format($data['text'],false,false,false); ?></p>
            </div>    
               
               
               <?php if($data['link']!="") : ?>
                    <p class="blurb-button">
                        <a href="<?php echo $data['link']; ?>" class="custom-font thunder_button"><?php echo stripslashes($data['label']); ?></a>
                    </p>
               <?php endif ?>     
              
            </div>
        </div> <!-- Blurb Wrapper Ends -->
		 </div>
		 <?php
		 
		 break;
		 
		  case 'custom-post' : $data = $element[1]; ?>
		  <div class=" latest-home-posts clearfix <?php echo $data['Layout'].' '.$hasLayout; ?> thunder_listener" data-link-filter="cr crh" data-headings-filter="cr" data-text-filter="cr" data-button-filter="cr crh bg bgh" data-image-filter="bbr">
          <div  class="clearfix posts-wrapper " >
           
           <h3 class="custom-font"><?php echo stripslashes($data['title']); ?></h3>
           
			<?php 
            $post_type = $data['post_type'];
           
			$popPosts = new WP_Query(array(
			
			'post_type' => $post_type, 
			'posts_per_page' => $data['no_of_posts'],
			 'tax_query' =>  array(
							   array(
										'taxonomy' => 'post_format',
										'field' => 'slug',
										'terms' => array('post-format-quote','post-format-aside','post-format-video','post-format-link'),
										'operator' => 'NOT IN'
									)
							)
			));
			
            $i = 1;
            
			while ($popPosts->have_posts()) : $popPosts->the_post();  $more = 0;  ?>
              <div class="post-item">
              <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>
  					  <h3 class="custom-font"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="meta-info thunder_image custom-font clearfix"><?php  echo do_shortcode("[post_date format='F d, Y']"); ?></p> 
              
                  <div class="image">
                  <?php 
                  $id = get_post_thumbnail_id();
                  $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
                  
				   if($data['no_of_posts']=="post")
				  	echo $this->imageDisplay( array( "src" => $ar[0] , "height" => 50 , "width" => 70 , "lightbox" => false , "link" => get_permalink() )); 
				  else
				  	echo $this->imageDisplay( array( "src" => $ar[0] , "height" => 50 , "width" => 70 , "link" =>  $ar[0] )); 
				  
                  ?> 
               
                  </div><!--image-->
              <?php endif; ?>
              
               
                  <div class="desc"><?php if($data['excerpt']=="yes") echo $this->getShortenContent(80,strip_shortcodes( strip_tags(get_the_content()) )); ?></div>
                
                  
              </div>
			<?php $i++; endwhile; ?>
	
        
         <?php if($data['link']!="") : ?>
                    <p class="more-button">
                        <a href="<?php echo $data['link']; ?>" class="custom-font thunder_button"><?php echo stripslashes($data['label']); ?></a>
                    </p>
               <?php endif ?>     
               
		  </div>
          	</div>
		  <?php break;
		 
		  
		   case 'custom-info-post' : $data = $element[1]; ?>
		    <div  class="clearfix latest-info-posts thunder_listener" data-filter="bg bgi bgp bgr" >
          
            <div class="skeleton clearfix " >
            <div class="info clearfix thunder_listener" data-headings-filter="cr" data-text-filter="cr" data-button-filter="bg cr bgh crh">
               <h2 class="title"> <span class="tail"></span> <span class="curl"></span> <?php echo $this->format($data['title'],false,false,false); ?> </h2>
               <div class="description">
                 <?php echo $this->format($data['description']); ?>
               </div>
               
            
          <?php if(trim($data['button_label'])!="") : ?> <a href="<?php echo $this->format($data['button_link'],false,false,false); ?>" class="main-button thunder_button" ><?php echo $this->format($data['button_label'],false,true,false); ?></a> <?php endif; ?>
           
           </div>
           
           
        
           <div class="info-post-items thunder_listener"   data-text-filter="cr" data-link-filter="cr" data-image-filter="bg br">
			<?php 
            $post_type = $data['post_type'];
         
			
			$popPosts = new WP_Query(array(
			
			'post_type' => $post_type, 
			'posts_per_page' => 6,
			 'tax_query' =>  array(
							   array(
										'taxonomy' => 'post_format',
										'field' => 'slug',
										'terms' => array('post-format-quote','post-format-aside','post-format-video','post-format-link'),
										'operator' => 'NOT IN'
									)
							)
			));
			
           
            $i =0;
            
			while ($popPosts->have_posts()) : $popPosts->the_post();  $more = 0;  ?>
             <div class="post-block <?php if($i==3) $i=0; echo 'post-block'.$i; ?>">
              <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>
  
                  <div class="image thunder_image">
                  <?php 
                  $id = get_post_thumbnail_id();
                  $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
				 
				  if($data['link_type']=="post")
				  	echo $this->imageDisplay( array( "src" => $ar[0] , "height" => 160 , "width" => 200 , "lightbox" => false , "link" => get_permalink()  , 'title' => get_the_title()))." <a class='hover' href=\"".get_permalink()."\"><span></span></a>"; 
				  else
				  	echo $this->imageDisplay( array( "src" => $ar[0] , "height" => 160 , "width" => 200 , "link" =>  $ar[0]  , 'title' => get_the_title()))." <a title='".get_the_title()."' href=\"".$ar[0]."\" class='lightbox hover'><span class='zoom'></span></a>"; 
                  ?> 
                  
                  </div><!--image-->
                   <?php  endif; ?>
                  <div class="desc">
                  	  <h3 class="custom-font"><a href="<?php the_permalink(); ?>"><?php echo $this->getShortenContent(60,strip_shortcodes( get_the_title() )); ?></a></h3>
                      <p class="meta-info clearfix"><?php   echo $this->getShortenContent(53,strip_shortcodes( strip_tags(get_the_content()) )); ?></p> 
          
                  
                  </div>
             </div>     
              <?php $i++;  endwhile; ?>
            </div>
           
            
        </div>
          </div>
		  <?php break;
		
		case 'twitter' : $data = $element[1];   ?> 
		
        <div class="twitter-wrapper <?php echo $data['Layout'].' '.$hasLayout; ?> thunder_listener" data-text-filter="cr" data-link-filter="cr">
         <h3 class="custom-font"><?php echo $data['title']; ?></h3>
        <div class="twitter ">
       <?php
        
        $tdata = twitter($data['tweets'], $data['username']);
        if($tdata) {
        echo '<ul>';
		
		foreach($tdata->tweets as $tweet)
		 echo "<li>".$tweet."</li>"; 
		
		echo'</ul>';
		}
        
        ?>
        
        
        
        </div>
        
        </div>
		
		<?php
		break;
		 
		
		case 'page-post-content' : 
		
		$data = $element[1];
		$postid = $data['id'];
		 $d =  get_post($postid); echo '<div class="home-page-content thunder_listener" data-filter="bg" data-text-filter="cr" data-headings-filter="cr" data-link-filter="cr crh"><div class="skeleton clearfix">'.$this->format($d->post_content)."</div></div>" ; break;	
			
			
				
		 }
		 
		  if( isset($element[1]['Layout']) &&  strpos ($element[1]['Layout'],"_last" ) ) 
		  {
			   $beginClear = false; $hasLayout = ' skeleton ';
			  echo "</div>";
		  }
	 }
 }

  // == Admin Sidebars MetaBox ==========================
   
   function initadminSidebars()
   {

 // == Init Titan Editor Template	 
 

	  
	  add_action("admin_init", "sidebar_admin_init");
	  
	  function sidebar_admin_init(){
		  
		   global $wpdb;
		  add_meta_box("exsidebar_credits_meta", "Layout Details", "exsidebar_credits_meta", "events", "normal", "high");
	      add_meta_box("exsidebar_credits_meta", "Layout Details", "exsidebar_credits_meta", "portfolio", "normal", "high");
		  add_meta_box("exsidebar_credits_meta", "Layout Details", "exsidebar_credits_meta", "post", "normal", "high");
		  add_meta_box("exsidebar_credits_meta", "Layout Details", "exsidebar_credits_meta", "page", "normal", "high");
		//  add_meta_box("exsidebar_credits_meta", "Layout Details", "exsidebar_credits_meta", "events", "normal", "high");
	  }
	  
	  
	  
	  function exsidebar_credits_meta() {
	      global $post,$super_options;
	    $sidebar =  get_post_meta($post->ID,"_sidebar",true);
		$dy =  get_post_meta($post->ID,"_dynamic_sidebar",true);
		$dy2 =  get_post_meta($post->ID,"_dynamic_sidebar2",true);
		
		$titan_template =  get_post_meta($post->ID,"_titan_template",true);
		$featured_media =  get_post_meta($post->ID,"_featured_media",true);
	    $video_link =  get_post_meta($post->ID,"_video_link",true);
	   
	   
	    if( $sidebar=="")  
		{
			if($post->post_type=="post")
			$sidebar = $super_options[SN.'_post_layout'];
			else
			$sidebar = $super_options[SN.'_page_layout'];
		}
		if( $featured_media=="")  $featured_media = "featured-image";
	    if( $dy=="")  $dy = "Blog Sidebar";
		if( $dy2=="")  $dy2 = "Blog Sidebar";
		
		 global $wpdb;
	 $table_db_name = $wpdb->prefix . "teditor";
	 $templates =  $wpdb->get_results("SELECT id,title FROM $table_db_name ",ARRAY_A);
	 
	 $table_db_name = $wpdb->prefix . "tslidermanager";
	 $sliders =  $wpdb->get_results("SELECT * FROM $table_db_name ",ARRAY_A);
	
	
	
	      ?>
	  
	    <div class="hades-layout clearfix" >
	 	  
          <div id="supersidebars">
          <h2> <?php _e('Page Layout','h-framework'); ?> </h2>
            <ul class="clearfix">
              <li class="full-width">
                <label for="full-width"></label><input type="radio" id="full-width" name="super_sidebar" value="full-width" <?php if($sidebar=="full-width") echo "checked='checked'"; ?> /></li>
              <li class="hasLeftSidebar">
                <label for="hasLeftSidebar"></label><input type="radio" id="hasLeftSidebar" name="super_sidebar" value="hasLeftSidebar" <?php if($sidebar=="hasLeftSidebar") echo "checked='checked'"; ?> /></li>
              <li class="hasRightSidebar">
                <label for="hasRightSidebar"></label><input type="radio" id="hasRightSidebar" name="super_sidebar" value="hasRightSidebar" <?php if($sidebar=="hasRightSidebar") echo "checked='checked'"; ?> /></li>
             
            
            </ul>
           
           <h2> <?php _e('Select Sidebar','h-framework'); ?> </h2> 
            
            <?php 
			 $active_sidebars = get_option(SN."_active_sidebars");
			
			?>
           
        <div class="hades_input clearfix">
        
          <label for="dynamic_sidebar"> <?php _e('Sidebar','h-framework'); ?> </label>
         <div class="select-wrapper"> 
        <select name="dynamic_sidebar" id="dynamic_sidebar">
       
        <?php 
		if(!is_array($active_sidebars)) $active_sidebars = array();
		$active_sidebars[] = "Blog Sidebar";
		
		foreach($active_sidebars as $bar)
		{
			if( $dy == $bar )
			echo "<option selected='selected' value='$bar'>{$bar}</option>";
			else
			echo "<option value='$bar'>{$bar}</option>";
		}
		
		?>
        </select>
        </div>
        
        </div>
        
        <?php if($post->post_type!="portfolio" && $post->post_type!="events") : ?> 
          <div class="hades_input clearfix">
        
          <label for="dynamic_sidebar2"> <?php _e('Sidebar 2','h-framework'); ?> </label>
         <div class="select-wrapper"> 
        <select name="dynamic_sidebar2" id="dynamic_sidebar2">
       
        <?php 
		
		foreach($active_sidebars as $bar)
		{
			if( $dy2 == $bar )
			echo "<option selected='selected' value='$bar'>{$bar}</option>";
			else
			echo "<option value='$bar'>{$bar}</option>";
		}
		
		?>
        </select>
        </div>
      
        </div>
          <?php endif; ?>
         <div class="hades_input clearfix">
        
          <label for="dynamic_sidebar2"> <?php _e('Titan Template ( It will override Content from Editor )','h-framework'); ?> </label>
         <div class="select-wrapper"> 
        <select name="titan_template" id="titan_template">
       	<option value='none'>None</option>
        <?php 
		
		foreach($templates as $template)
		{
			if( $titan_template == $template['id'] )
			echo "<option selected='selected' value='$template[id]'>".$template['title']."</option>";
			else
			echo "<option value='$template[id]'>".$template['title']."</option>";
		}
		
		?>
        </select>
        </div>
        
        </div>
        
       <?php  if( $post->post_type!="events") :  ?>
       
         <div class="hades_input clearfix">
        
          <label for="dynamic_sidebar2"> <?php _e('Select Featued Media','h-framework'); ?> </label>
         <div class="select-wrapper"> 
        <select name="featured_media" id="featured_media">
      
        <?php 
		$media = array( "none" => "None" , "featured-image" => "Featured Image" ,"video" => "Video");
		
		
		
		foreach($sliders as $slider)
		{
			if($slider['id']!="1") :
				$op = unserialize($slider['options']);
				$media[$slider['id']]  = $op["title"];
			endif;
		}
		
		
		
		
		foreach($media as $key => $item)
		{
			
				if( $featured_media == $key )
					echo "<option selected='selected' value='$key'>{$item}</option>";
				else
					echo "<option value='$key'>{$item}</option>";
			
		}
	
		
		
		 
		?>
        </select>
        </div>
        
        </div>    
        <?php endif; ?>
        
         <div class="hades_input clearfix">
        
          <label for="dynamic_sidebar2"> <?php _e('Video Link ( To activate select video in featured media)','h-framework'); ?> </label>
          <input type="text" value="<?php echo $video_link ?>" name="video_link" />
            
          </div>
        
	    </div>
        
        </div>
	   <?php
	  }
	  
	  add_action('save_post', 'exsidebar_save_details');
	  
	  function exsidebar_save_details(){
	  global $post;
	  if(isset($_POST["super_sidebar"]))
	  update_post_meta($post->ID,"_sidebar",$_POST["super_sidebar"]);
	  if(isset($_POST["dynamic_sidebar"]))
	  update_post_meta($post->ID,"_dynamic_sidebar",$_POST["dynamic_sidebar"]);
	  
	  if(isset($_POST["dynamic_sidebar2"]))
	  update_post_meta($post->ID,"_dynamic_sidebar2",$_POST["dynamic_sidebar2"]);
	  
	  if(isset($_POST["titan_template"]))
	  update_post_meta($post->ID,"_titan_template",$_POST["titan_template"]);
	  
	   if(isset($_POST["featured_media"]))
	  update_post_meta($post->ID,"_featured_media",$_POST["featured_media"]);
	  
	  if(isset($_POST["video_link"]))
	  update_post_meta($post->ID,"_video_link",$_POST["video_link"]);
	  
	  }
	  
	
   }
   
   
   // == Admin Portfolio Template MetaBox ==========================
   
   function initAdminPortfolioFilter()
   {
	 
	  
	  add_action("admin_init", "portfoliofilter_admin_init");
	  
	  function portfoliofilter_admin_init(){  add_meta_box("portfoliofilter_credits_meta", "Portfolio Filters", "portfoliofilter_credits_meta", "page", "normal", "low"); 		 }
	  function portfoliofilter_credits_meta() {
	      global $post;
	    $meta_filter =  get_post_meta($post->ID,"_meta_filter",true);
		$fl =  get_post_meta($post->ID,"_portfolio_filter",true);
		$live =  get_post_meta($post->ID,"_live_filter",true);
		$order =  get_post_meta($post->ID,"_order",true);
	  if($order =="") $order  ="ASC";	
	  if($live=="") $live = "yes";
	  if(!is_array($fl)) $fl = array();
	 
	 
	      ?>
	  
	    <div class="hades-layout" >
	 	  
          <div id="portfolio-filters">
        
         <div class="hades_input clearfix">
        
       		 <label for="portfolio_filter"> <?php _e('Select Categories to include( If empty all categories will be included)','h-framework'); ?> </label>
        		
                <div  class="btn-group checks" data-toggle="buttons-checkbox">
                	 <?php 
                           
                            $temp = get_terms('portfoliocategories');
                          
						
							$terms  = array();
							
							foreach($temp as $t)
							{
								$terms[$t->slug] = $t->name;
							
							}
							
							$i = 0;
							
                            foreach($terms as $key => $term)
                            {
                               if( in_array($key,$fl) )
                                echo "<label for='check{$i}' class='btn active'>{$term}</label><input type='checkbox' value='$key' id='check{$i}' name=\"portfolio_filter[]\" checked='checked' >";
                              else
                               echo "<label for='check{$i}' class='btn'>{$term}</label><input type='checkbox' value='$key' id='check{$i}' name=\"portfolio_filter[]\" >";
							   
							   $i++;
                            }
                            
                   	  ?><input type="hidden" name="portfolio_filter[]" value="" />
                </div>
         
        </div>
        
        
        <div class="hades_input clearfix">
        
       		 <label for="portfolio_filter"> <?php _e('Select Order','h-framework'); ?> </label>
        		
                <div  class="btn-group radio-f" data-toggle="buttons-radio">
               
                	 <?php 
                          
							
							$terms  = array("none" => "None","title" => "Title","date" => "Date","rand"=>"Random","author"=>"Author");
							
							
							
							$i = 2230;
							
                            foreach($terms as $key => $term)
                            {
                               if( $key == $meta_filter )
                                echo "<label for='check{$i}' class='btn active'>{$term}</label><input type='radio' value='$key' id='check{$i}' name=\"meta_filter\" checked='checked' >";
                              else
                               echo "<label for='check{$i}' class='btn'>{$term}</label><input type='radio' value='$key' id='check{$i}' name=\"meta_filter\" >";
							   
							   $i++;
                            }
                            
                   	  ?> 
                </div>
         
        </div>
        
        
        <div class="hades_input clearfix">
        	<label for="order"> Order by - </label>
            <div class="radio">
            	<label for="order1">Ascending</label><input type="radio" id="order1" name="order" value="ASC" <?php if($order=="ASC") echo 'checked="checked"'; ?> />
                <label for="order2">Descending</label><input type="radio" id="order2" name="order" value="DESC" <?php if($order=="DESC") echo 'checked="checked"'; ?> />
            </div>
         	
        </div>
        
        
        <div class="hades_input clearfix">
        	<label for="live_filter"> Live Animated Filtering Yes/No </label>
            <div class="radio">
            	<label for="live_filter1">Yes</label><input type="radio" id="live_filter1" name="live_filter" value="Yes" <?php if($live=="Yes") echo 'checked="checked"'; ?> />
                <label for="live_filter2">No</label><input type="radio" id="live_filter2" name="live_filter" value="No" <?php if($live=="No") echo 'checked="checked"'; ?> />
            </div>
         	
        </div>
            
            
            
          </div>
        
	    </div>
	   <?php
	  }
	  
	  add_action('save_post', 'portfoliofilter_save_details');
	  
	  function portfoliofilter_save_details(){
	  global $post;
	    
		
		
		
		if(isset($_POST["meta_filter"]))   update_post_meta($post->ID,"_meta_filter",$_POST["meta_filter"]);
		if(isset($_POST["portfolio_filter"]))   update_post_meta($post->ID,"_portfolio_filter",$_POST["portfolio_filter"]);
		if(isset($_POST["live_filter"]))   update_post_meta($post->ID,"_live_filter",$_POST["live_filter"]);
		if(isset($_POST["order"]))   update_post_meta($post->ID,"_order",$_POST["order"]);
	 
	  }
	  
	
   }
   	
    // == Dynamic CSS ================================
  
  function dynamicCSS() {
	  
	 
	 // == Custom Google web font ==================================
	 	
		 	
	
	  
	  // Adding dynamic css and js through wp head ===============================
	  
	  function nestedFunc()
	  {
		  global $super_options;
		  
		  // == Body font options ===============
		  $bodyfont = ($super_options[SN.'_body_font']=="") ? "PT Sans" : $super_options[SN.'_body_font'];
		  $body_font_unit = "px" ;
		  $body_bd_size = ($super_options[SN.'_bd_size']=="") ? "12" : $super_options[SN.'_bd_size'];
		  $body_body_font_style = ($super_options[SN.'_body_font_style']=="") ? "normal" : $super_options[SN.'_body_font_style'];
		  // == Custom font css code ==============
		  $font_option = (!$super_options[SN."_toggle_custom_font"]) ? "Google Webfonts" : $super_options[SN."_toggle_custom_font"];
		  
		  $introfont = ($super_options[SN.'_bcustom_font']=="") ? "PT Sans" : $super_options[SN.'_bcustom_font'];
		  
		  if($font_option=="Google Webfonts") :
		  
		  $customfont = ($super_options[SN.'_custom_font']=="") ? "PT Sans" : $super_options[SN.'_custom_font'];
		  $customfont = ".custom-font , #menu-bar .menu>li>a {  font-family: '".$customfont."', sans-serif; }";
		  
		  if($super_options[SN.'_custom_g_font_enable']=="true")
		  {
		    $customfont = ($super_options[SN.'_custom_g_font']=="") ? "PT Sans" : $super_options[SN.'_custom_g_font'];
		    $customfont = ".custom-font  {  font-family: '".$customfont."', sans-serif; }";
		  }
		  endif;
		   
		  // == Cufon Call ===========================
		  
		  if($font_option=="Cufon") :
		    $script = "<script type='text/javascript'>
	        	Cufon.replace('.custom-font');
		   		 </script> ";
	         echo $script;
		  endif;
		  
		  $h1 = $super_options[SN."_h1_font_size"];
		  $h1 = (!$h1) ? "36px" : $h1."px"; 
		  
		  $h2 =  $super_options[SN."_h2_font_size"];
		  $h2 = (!$h2) ? "32px" : $h2."px"; 
		  
		  $h3 =  $super_options[SN."_h3_font_size"];
		  $h3 = (!$h3) ? "28px" : $h3."px"; 
		  
		  $h4 =  $super_options[SN."_h4_font_size"];
		  $h4 = (!$h4) ? "24px" : $h4."px"; 
		  
		  $h5 =  $super_options[SN."_h5_font_size"];
		  $h5 = (!$h5) ? "18px" : $h5."px"; 
		  
		  $h6 =  $super_options[SN."_h6_font_size"];
		  $h6 = (!$h6) ? "12px" : $h6."px"; 
		  
		  $blog_posts_size =  $super_options[SN."_blog_post_size"];
		  $blog_posts_size = (!$blog_posts_size) ? "19px" : $blog_posts_size."px";
		  
		   $fblog_posts_size =  $super_options[SN."_fblog_post_size"];
		  $fblog_posts_size = (!$fblog_posts_size) ? "19px" : $fblog_posts_size."px";
		  
		  $single_post_size =  $super_options[SN."_single_post_size"];
		  $single_post_size = (!$single_post_size) ? "21px" : $single_post_size."px";
		  
		 $portfolio3_title_size =  (!$super_options[SN."_portfolio3_title_size"]) ? "18px" : $super_options[SN."_portfolio3_title_size"]."px";
		 $single_title_size =  (!$super_options[SN."_single_title_size"]) ? "18px" : $super_options[SN."_single_title_size"]."px";
		  
		  $portfolio_single_title_size =  (!$super_options[SN."_portfolio1_title_size"]) ? "18px" : $super_options[SN."_portfolio1_title_size"]."px";
		
		  
		  
		  
		  
		  $dyanmic_css = $super_options[SN."_custom_css"];
		  
		 
		  
		  // Thunder mutation code ========================
		  
		  $visual_matrix = unserialize($super_options[SN.'_visual_matrix']);
		  if(!is_array($visual_matrix)) $visual_matrix = array();
		  
		  $dy_css_code = '';
		  
		
		  foreach ( $visual_matrix as $element  )
		  {
			  $subelements = $element['props'];
			  $temp = '';
		       
			 //  print_r($props);	   
			   
			   if(!is_array($subelements)) $subelements = array();
			   
			   foreach($subelements as $element)
			   {
					
					foreach($element as $prop)
			  		 {
					 
					   $dy_css_code =  $dy_css_code ." $prop[element] { $prop[property] : $prop[value]; } \n\n ";   
				
			   		  }
			   }
			     
			
		  }
		
		  $code = "<style type='text/css'> 
						body , .content {  font-family: '".$bodyfont."', Helvetica , Arial , sans-serif; 
						font-size:{$body_bd_size}{$body_font_unit}; 
						font-style:{$body_body_font_style}; 
						
						}
						
						
							
					.blurb-text , .twitter p , .qSlider .desc h2 , .soleaSlider .desc h2, .desc-show h2 , .kwicks .desc h2,  .custom-title  { font-family: '".$introfont."', Helvetica , Arial , sans-serif;  }	
						$customfont
						
						
						
						/* == ~~ This is the dynamic CSS ==================== */
						$dyanmic_css
						/* == ~~ End of dynamic CSS ========================= */
						
						 .content h1 { font-size:$h1;   }
						 .content h2 { font-size:$h2;  } 
						 .content h3 { font-size:$h3;  }
						 .content h4 { font-size:$h4; }
						 .content h5 { font-size:$h5;  }
						 .content h6 { font-size:$h6; } 
						 
						  div.blog-template ul.posts li div.description h2.custom-font  a { font-size:$blog_posts_size;  }
						  div.default-blog-template  ul.posts li div.description h2.custom-font  a { font-size:$fblog_posts_size;  }
						   
						 .single-post div.title  h1 { font-size:$single_post_size;  }
						 
						 div.portfolio-template div.portfolio-three-column  ul.posts li h2.custom-font a { font-size:$portfolio3_title_size;  }
						 
						 .single-portfolio h1.title { font-size:$single_title_size; }
						 $dy_css_code
			  	  </style>" ;
		  
		  echo $code;
	  }
	  add_action('wp_head','nestedFunc',10,1);
	  
	  
	  }	 
  
  
    // == Social Stuff =====================
  
  function socialStuff() {
	  global $super_options;
	   $option = (!$super_options[SN.'_social_set_style']) ? "Style 1" :  $super_options[SN.'_social_set_style']; ?>


<?php switch($option) { case "Style 1" : ?>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e1030e64fcdf96b"></script>
<!-- AddThis Button END -->

<?php break;  case "Style 2" : ?>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e1ab8527e22cf18"></script>
<!-- AddThis Button END -->
<?php break;  case "Style 3" : ?>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e1ab85c4609993a"></script>
<!-- AddThis Button END -->
<?php break;  case "Style 4" : ?>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_google_plusone"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e1ab864700d5749"></script>
<!-- AddThis Button END -->
<?php break;  case "Style 5" : ?>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a href="http://www.addthis.com/bookmark.php?v=250&amp;pubid=xa-4e1ab86d72fcad27" class="addthis_button_compact">Share</a>
<span class="addthis_separator">|</span>
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e1ab86d72fcad27"></script>
<!-- AddThis Button END -->
<?php break;  case "Style 6" : ?>
<!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pubid=xa-4e1ab8776cec852d"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e1ab8776cec852d"></script>
<!-- AddThis Button END -->
<?php break;  case "Style 7" : ?>
<!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pubid=xa-4e1ab87e56d51201"><img src="http://s7.addthis.com/static/btn/sm-share-en.gif" width="83" height="16" alt="Bookmark and Share" style="border:0"/></a>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e1ab87e56d51201"></script>
<!-- AddThis Button END -->
<?php break;  case "Style 8" : ?>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e1ab886685d8c35"></script>
<!-- AddThis Button END -->
<?php break;  } 
	  
	  }	 


// == Height Based Resize =====================================


function hpresize($max_width,$max_height,$width,$height)
{
	$ratioh = $max_height/$height; 
	$ratiow = $max_width/$width; 
	$ratio = min($ratioh, $ratiow); 
	// New dimensions 
	$width = intval($ratiow*$width); 
	$height = intval($ratiow*$height); 
	return array( "width" => $width , "height" => $height  );
}


// == Pagination =====================================

 function pagination($pages = '', $range = 2)
  {
	  global $super_options;
	  
	  $pagination_type = trim($super_options[SN."_pagination"]);
	
	if($pagination_type=="numbers") :     
  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination clearfix thunder_listener' data-link-filter=\"bg cr crh bgh bga\" data-filter='tbr'><ul  class=\"clearfix\">";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li class='active'><a>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</ul></div>\n";
     }
	 
	 endif;
	 
	 if($pagination_type=="next/previous") :
	 
	 echo '<div class="pagination clearfix thunder_listener lpager" data-link-filter="bg cr crh bgh" data-filter="tbr"><ul class="clearfix">
	 
	 <li>';
	 
	 
	 previous_posts_link("&lt;"); 
	 echo '</li><li>';
	 next_posts_link("&gt;"); 
	 
	 echo '</li></ul></div>';
	 
	 endif;
	 
}
	
  // == Register Menus =====================================================	  
	
 public function registerMenus($menus)
	{
		

		  if ( function_exists( 'register_nav_menus' ) ) {
			 
			  register_nav_menus($menus);
		  }
	}
	
 // == Breadcrumbs ==========================================================
 
 
 	public function breadcrumbs()
	{
		global $super_options;
		 $delimiter = $super_options[SN."_breadcrumb_delimiter"];
  $home =  $super_options[SN."_breadcrumb_home_label"];; // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div id="breadcrumbs" class="thunder_listener" data-filter="bg bbr cr" data-link-filter="cr"><div class="inner-breadcrumbs-wrapper skeleton clearfix">';
 
    global $post;
    $homeLink = home_url();
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . __('Archive by category ','h-framework').'"' . single_cat_title('', false) . '"' . $after;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
		
        $slug = $post_type->rewrite;
        $ylink = $homeLink.'/'.$slug.'/';
		if($slug['slug']=="portfolio")
   		{
			 $terms  = get_the_terms($post->ID,'portfoliocategories'); 
				 if ( !empty( $terms ) ) {
		  			$out = '';
					foreach ( $terms as $c )
						$out = $c;
						
				}
				$ylink = get_term_link($out, 'portfoliocategories');
		}
		
		if($out)
		echo '<a href="' .$ylink . '">' . $out->name . '</a> ' . $delimiter . ' ';
        
		echo $before . get_the_title() . $after;
		
		
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . __('Search results for ','h-framework').'"' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . __('Posts tagged','h-framework').' "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . __( 'Articles posted by ','h-framework') . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . __('Error 404','h-framework') . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page','h-framework') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div></div>';
 
  }
	}	
		  
} // End of Class

}

$helper = new Helper();


// == Create databases ======================================================




function teditor_install () {
   global $wpdb;
   $teditor_db_version = "0.1";

   $table_name = $wpdb->prefix . "teditor";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . " (
	  id varchar(40) NOT NULL ,
	  title varchar(500),
	  layout LONGTEXT,
	  options text,
	  UNIQUE KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
	  
	  $alter_charset = "ALTER TABLE $table_name CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	  $wpdb->query($alter_charset);
	  
	  $inp = "INSERT INTO $table_name values('1','Home','','')";
	  dbDelta($inp);
	  
      add_option("teditor_db_version", $teditor_db_version);

   }
   else
   {
	   $installed_ver = get_option( "teditor_db_version" );

   if( $installed_ver != "0.1" ) {

     $sql = "CREATE TABLE " . $table_name . " (
	  id varchar(40) NOT NULL ,
	  title varchar(500),
	  layout LONGTEXT,
	  options text,
	  UNIQUE KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
	  $alter_charset = "ALTER TABLE $table_name CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	  $wpdb->query($alter_charset);
	 

      update_option( "teditor_db_version", $teditor_db_version);
  }
   }
}


function tslider_manager_install () {
   global $wpdb;
   $tslidermanager = "0.1";

   $table_name = $wpdb->prefix . "tslidermanager";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . " (
	  id varchar(40) NOT NULL ,
	  slides LONGTEXT,
	  options text,
	  UNIQUE KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
	  
	  $alter_charset = "ALTER TABLE $table_name CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	  $wpdb->query($alter_charset);
	  
	  $inp = "INSERT INTO $table_name values('1','','')";
	  dbDelta($inp);
	  
      add_option("tslidermanager_db_version", $tslidermanager);

   }
   else
   {
	   $installed_ver = get_option( "tslidermanager_db_version" );

   if( $installed_ver != "0.1" ) {

     $sql = "CREATE TABLE " . $table_name . " (
	  id varchar(40) NOT NULL ,
	  slides LONGTEXT,
	  options text,
	  UNIQUE KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
	  $alter_charset = "ALTER TABLE $table_name CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	  $wpdb->query($alter_charset);
	 

      update_option( "tslidermanager_db_version", $tslidermanager);
  }
   }
}
// ====== Twitter Functions =====================================


function twitter($tweet_count, $username)
    {
        if ( empty($username) ) return;
        
        $tweets = get_transient('home_tweets_widget');
   //     if ( !$tweets )
//	{
	    return fetch_tweets($tweet_count, $username);
//	}
 //       return $tweets;
    }
    
     function fetch_tweets($tweet_count, $username)
    {
	$tweets = wp_remote_get("https://api.twitter.com/1/statuses/user_timeline.json?screen_name=$username");
	
	$tweets = @json_decode($tweets['body']);

	// An error retrieving from the Twitter API?
	if ( isset($tweets->error) ) return false;

	$data = new StdClass();
	$data->username = $username;
	$data->tweet_count = 1;

	foreach($tweets as $tweet) {
	    if ( $tweet_count-- === 0 ) break;
	    $data->tweets[] = filter_tweet( $tweet->text );
	}

	set_transient('home_tweets_widget', $data, 60 * 5); // five minutes
	return $data;
    }

     function filter_tweet($tweet)
    {
        // Username links
        $tweet = preg_replace('/(http[^\s]+)/im', '<a href="$1">$1</a>', $tweet);
        $tweet = preg_replace('/@([^\s]+)/i', '<a href="http://twitter.com/$1">@$1</a>', $tweet);
        // URL links
        return $tweet;
    }



// == Hook to trigger some modules on theme activation ========================= 


function my_theme_activate() {
   
   update_option("SN",SN);
   teditor_install (); // ~~ ======== install Titan Editor DB ~~
  tslider_manager_install(); // ~~ ======== install Slider manager DB ~~
   
   header("Location: admin.php?page=hades&action=save&activation=true");
   
   
}

wp_register_theme_activation_hook('Hades_Plus', 'my_theme_activate');

function wp_register_theme_activation_hook($code, $function) {
    $optionKey="theme_is_activated_" . $code;
    if(!get_option($optionKey)) {
        call_user_func($function);
        update_option($optionKey , 1);
    }
}

 function my_theme_deactivate() {
    // code to execute on theme deactivation
 }

wp_register_theme_deactivation_hook('Hades_Plus', 'my_theme_deactivate');
function wp_register_theme_deactivation_hook($code, $function) {
     $GLOBALS["wp_register_theme_deactivation_hook_function" . $code]=$function;
     $fn=create_function('$theme', ' call_user_func($GLOBALS["wp_register_theme_deactivation_hook_function' . $code . '"]); delete_option("theme_is_activated_' . $code. '");');
     add_action("switch_theme", $fn);
}
    
