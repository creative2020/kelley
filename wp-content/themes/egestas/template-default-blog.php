<?php
/*
Template Name: Default Blog Template
*/
?>
<?php

// == Layout Calculation =========================================

$layout =    get_post_meta($post->ID,'_sidebar',true);
$layout = (trim($layout)=="") ? "hasRightSidebar" : $layout; // ~~ For pages existing prior to theme activation should have full width by default ~  

$sidebar1 =    get_post_meta($post->ID,'_dynamic_sidebar',true);
$sidebar2 =    get_post_meta($post->ID,'_dynamic_sidebar2',true);

$titan_template =    get_post_meta($post->ID,'_titan_template',true);
$featured_media =    get_post_meta($post->ID,'_featured_media',true);
$video_link  =    get_post_meta($post->ID,'_video_link',true);
 
$content_width = '';
$width = 1020;  $height = 450;
switch($layout)
 { 
   case "full-width" : $width = 1020; break;
   case "hasLeftSidebar" :
   case "hasRightSidebar" :  $content_width = 'two-third-width'; $width = 680; break;
   case "hasDoubleSidebar" :
   case "hasDoubleRightSidebar" : 
   case "hasDoubleLeftSidebar" :  $content_width = 'one-third-width';  $width = 480; break;
   default : 
        // Layout Calculate for Default Option also ===
  		$layout = $super_options[SN.'_page_layout'];
		 switch($layout)
		 { 
		   case "hasLeftSidebar" :
		   case "hasRightSidebar" :  $content_width = 'two-third-width'; $width = 680; break;
		   case "hasDoubleSidebar" :
		   case "hasDoubleRightSidebar" : 
		   case "hasDoubleLeftSidebar" :  $content_width = 'one-third-width';  $width = 480; break;
		 }
 
 }



$categories = (trim(get_post_meta($post->ID,"_category",true))=="") ? false : get_post_meta($post->ID,"_category",true);


$blog_options = array(
							'items_limit' => $super_options[SN."_posts_item_limit"],
							'content_limit' =>  (int)$super_options[SN."_posts_excerpt_limit"],
    				  	    'categories' => $categories,
							'width' => 650 ,
							'height' => "",
							'meta_data' => $super_options[SN.'_blog_meta_enable'],
							'clear' => 1,
							'label' => 'blog-item-1-',
							'lightbox' => $super_options[SN.'_enable_thumbnail']
						  );

get_header(); ?>  


<?php  if(have_posts()): while(have_posts()) : the_post(); ?>

<div class="page-wrapper">
  <div class="title thunder_listener" data-filter="bg" data-headings-filter="cr bbr">
     	<div class="skeleton">
        	<h1 class="custom-font"><?php the_title(); ?></h1> 
            
           
        </div>
   	 </div>
 <?php  if($super_options[SN."_breadcrumbs_enable"]=="true" && !is_front_page()) $helper->breadcrumbs(); ?> <!-- The breadcrumb for the theme -->
 
<div class="skeleton page content  skeleton <?php echo $layout; ?> clearfix default-blog-template "> <!-- Start of loop -->
    
    <?php   if($layout=="hasDoubleSidebar") { $first_sidebar = true;  get_sidebar(); }    ?> 
    
    <div class="<?php echo $content_width ?> " id="main-content">
   
      <?php 
	   if ($featured_media == "featured-image" && (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :
		
			$id = get_post_thumbnail_id();
		    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		    echo '<div class="single-image">'.$helper->imageDisplay( array( "src"=> $ar[0] ,"height" => 350 , "width" => $width , "parent_wrap" => false ) ).'</div>';  
		
	   elseif(  $featured_media=="video" ) : 
     		
			echo '<div class="single-video">'.do_shortcode("[video height=".($width/2+50)." width='$width' ]{$video_link}[/video]").'</div>';  
			
	  elseif( $featured_media!="" && $featured_media!="none" && $featured_media!="featured-image" && $featured_media!="video" ) : 
     		 get_template_part('includes/slideshow');
       endif ?>
   
	 <?php the_content(); ?>
     
  
     	<?php get_template_part('includes/loop'); ?>
         <?php $helper->pagination(); ?> 
     
     
     
        
    </div>
     <?php  
	  wp_reset_query();
	 if($layout!="full-width") {  $first_sidebar = false; get_sidebar(); }  
	 ?> 

</div>
</div>
<?php endwhile; endif; ?> <!-- End of loop -->

<?php get_footer(); ?>
      