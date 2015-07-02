<?php

// == Layout Calculation =========================================

$layout =    get_post_meta($post->ID,'_sidebar',true);
$layout = (trim($layout)=="") ? "full-width" : $layout; // ~~ For pages existing prior to theme activation should have full width by default ~  

$sidebar1 =    get_post_meta($post->ID,'_dynamic_sidebar',true);
$sidebar2 =    get_post_meta($post->ID,'_dynamic_sidebar2',true);

$titan_template =    get_post_meta($post->ID,'_titan_template',true);
$featured_media =    get_post_meta($post->ID,'_featured_media',true);
if($featured_media=="") $featured_media = "none";



$video_link  =    get_post_meta($post->ID,'_video_link',true);
 
$content_width = '';
$width = 1020;  $height = 450;
switch($layout)
 { 
   case "full-width" : $width = 1020; break;
   case "hasLeftSidebar" :
   case "hasRightSidebar" :  $content_width = 'two-third-width'; $width = 690; break;
   case "hasDoubleSidebar" :
   case "hasDoubleRightSidebar" : 
   case "hasDoubleLeftSidebar" :  $content_width = 'one-third-width';  $width = 480; break;
   default : 
        // Layout Calculate for Default Option also ===
  		$layout = $super_options[SN.'_page_layout'];
		 switch($layout)
		 { 
		   case "hasLeftSidebar" :
		   case "hasRightSidebar" :  $content_width = 'two-third-width'; $width = 650; break;
		   case "hasDoubleSidebar" :
		   case "hasDoubleRightSidebar" : 
		   case "hasDoubleLeftSidebar" :  $content_width = 'one-third-width';  $width = 480; break;
		 }
 
 }



get_header(); ?>   


 

  <div class="page-wrapper">
<div class="title thunder_listener" data-filter="bg" data-headings-filter="cr bbr">
     	<div class="skeleton">
        	<h1 class="custom-font"><?php the_title(); ?></h1> 
            
           
        </div>
   	 </div>

 <?php  if($super_options[SN."_breadcrumbs_enable"]=="true" && !is_front_page()) $helper->breadcrumbs(); ?> <!-- The breadcrumb for the theme -->
 
    <?php if( $titan_template!="" && $titan_template!="none" ) :  
	
	echo "<div class='titan-template'>";
	  get_template_part('includes/titan_template');
    echo '</div>';	  
	 else : ?>
     
    
	 
			
	 
	 <?php  if(have_posts()): while(have_posts()) : the_post(); ?>
     
<div class="skeleton page content   <?php echo $layout; ?> clearfix"> <!-- Start of loop -->
    
    
   
 

      <?php   if($layout=="hasDoubleSidebar") { $first_sidebar = true;  get_sidebar(); }    ?> 
   
   
    <div class="<?php echo $content_width; ?> thunder_listener" id="main-content" data-text-filter="cr" data-link-filter="cr crh" data-headings-filter="cr" >
     
   
      <?php 
	  
	 
	  
	    if ($featured_media == "featured-image" && (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :
		
			$id = get_post_thumbnail_id();
		    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		    echo '<div class="single-image">'.$helper->imageDisplay( array( "src"=> $ar[0] ,"height" => 350 , "width" => $width , "parent_wrap" => false ) ).'</div>';  
		
	   elseif(  $featured_media=="video" ) : 
     		
			echo '<div class="single-video">'.do_shortcode("[video height=".($width/2+50)." width='$width' ]{$video_link}[/video]").'</div>';  
			
	  elseif( $featured_media!="" && $featured_media!="none" && $featured_media!="featured-image" && $featured_media!="video" ) : 
     		 get_template_part('includes/slideshow');
       endif; ?>
     
 
     
    
     <?php echo "<div class='page-content'>"; the_content(); echo "</div>"; ?>
   
     <?php   if($super_options[SN."_page_comments"]=="true") :  ?>
     	 <div id="comments_template">
      		<?php comments_template(); ?>
     	 </div>
       <?php endif; ?>  
      
   </div>
   
   
   
   <?php   if($layout!="full-width") {  $first_sidebar = false; get_sidebar(); }     ?> 

</div>
</div>

<?php endwhile; endif; ?> <!-- End of loop -->
<?php endif; ?>


<?php get_footer(); ?>
      