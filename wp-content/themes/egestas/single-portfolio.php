<?php

// == Layout Calculation =========================================

$layout =    get_post_meta($post->ID,'_sidebar',true);
$layout = "full-width" ; // ~~ For pages existing prior to theme activation should have full width by default ~  

$sidebar1 =    get_post_meta($post->ID,'_dynamic_sidebar',true);
$sidebar2 =    get_post_meta($post->ID,'_dynamic_sidebar2',true);

$titan_template =    get_post_meta($post->ID,'_titan_template',true);
$featured_media =    get_post_meta($post->ID,'_featured_media',true);


$video_link  =    get_post_meta($post->ID,'_video_link',true);
 
$content_width = '';
$width = 960; $height = 500;
switch($layout)
 { 
  case "full-width" : break;
   case "hasLeftSidebar" :
   case "hasRightSidebar" :  $content_width = 'two-third-width'; $width = 680; break;
 
   default : 
        // Layout Calculate for Default Option also ===
  		$layout = $super_options[SN.'_page_layout'];
		 switch($layout)
		 { 
		   case "hasLeftSidebar" :
		   case "hasRightSidebar" :  $content_width = 'two-third-width'; $width = 650; break;
		  
		 }
 
 }


$slides = get_post_meta($post->ID,"gallery_items",true);
if(!is_array($slides)) $slides = array();
$portfolio_meta_data = array(
 "slides" =>  $slides,
 "width" => $width, "height" =>  $height
); 

$likes = (int)get_post_meta($post->ID,'_vote_yes',true);


get_header(); ?>   

<?php  if(have_posts()): while(have_posts()) : the_post(); ?>


<div class="page-wrapper">
 <div class="title thunder_listener" data-filter="bg" data-headings-filter="cr bbr">
     	<div class="skeleton">
        	<h1 class="custom-font"><?php the_title(); ?></h1> 
            
           
        </div>
   	 </div>

 <?php  if($super_options[SN."_breadcrumbs_enable"]=="true" && !is_front_page()) $helper->breadcrumbs(); ?> <!-- The breadcrumb for the theme -->
     


<div class="skeleton page content single-portfolio  <?php echo $layout; ?> clearfix"> <!-- Start of loop -->
    
   
    
      <?php   if($layout=="hasDoubleSidebar") { $first_sidebar = true;  get_sidebar(); }    ?> 
   
   
    <div class="<?php echo $content_width; ?>" id="main-content">
     
    
     <div class="project-nav clearfix  thunder_listener"  data-link-filter="bg bgh">
         <a href="" class="info">Info</a>
         <a href="" class="like" data-url="<?php echo HURL."/helper/builder_listener.php";?>" data-id="<?php echo $post->ID; ?>"> <?php echo $likes; ?></a>
         <?php $prev_post = get_adjacent_post(false,'',true) ; if($prev_post) echo "<a class='nav-p' href='".get_permalink($prev_post->ID)."'><span class='portfolio-previous'></span>&lsaquo; </a>"; ?>
         <?php $next_post = get_adjacent_post(false,'',false) ;if($next_post)  echo "<a class='nav-n' href='".get_permalink($next_post->ID)."'> &rsaquo;<span class='portfolio-next'></span></a>"; ?> 
  
       
	 </div>  
     
     <ul class="thunder_listener" id="project-button" data-link-filter="bg bgh">
     	
        <li class="top" ><a href="#">Up</a></li>
     
     </ul>
     
     
        
     <div class=" single_portfolio_content thunder_listener " data-text-filter="cr">
     <?php the_content(); ?>
     </div>
     
      <?php 
	  
	

	    if ($featured_media == "featured-image" && (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :
		
			$id = get_post_thumbnail_id();
		    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		    
		    echo '<div class="single-image thunder_listener preload" data-image-filter="bg br">'.$helper->imageDisplay( array( "src"=> $ar[0] ,"height" => "" , "width" => $width , "parent_wrap" => false , "advance_query" => "&amp;a=t;" , 'imgclass' => ' thunder_image ' ) ).'</div>';  
		
		elseif(  $featured_media=="video" ) : 
     		
		echo '<div class="single-video">'.do_shortcode("[internalvideo height=".($height)." width='$width' ]{$video_link}[/internalvideo]").'</div>';  
		
		elseif  (  $featured_media!="video" && $featured_media!="featured-image" && $featured_media!="" && $featured_media!="none" && $featured_media!="slideshow" ):
		    get_template_part('includes/slideshow');
			
	endif;
     		 get_template_part('includes/slideshow-portfolio');
        ?>
     
     
      
      
    
    <div class="clearfix">
      <?php   if($super_options[SN."_portfolio_comments"]=="true") :  ?>
     	 <div id="comments_template">
      		<?php comments_template(); ?>
     	 </div>
      <?php endif; ?>
    </div>
   </div>
   
   
   
   <?php   if($layout!="full-width") {  $first_sidebar = false; get_sidebar(); }     ?> 

</div>
</div>


  
      
<?php endwhile; endif; ?> <!-- End of loop -->

<?php get_footer(); ?>
      