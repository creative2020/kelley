<?php

// == Layout Calculation =========================================

$layout =    get_post_meta($post->ID,'_sidebar',true);

$sidebar1 =    get_post_meta($post->ID,'_dynamic_sidebar',true);
$sidebar2 =    get_post_meta($post->ID,'_dynamic_sidebar2',true);

$titan_template =    get_post_meta($post->ID,'_titan_template',true);
$featured_media =    get_post_meta($post->ID,'_featured_media',true);
if($featured_media=="") $featured_media  = "featured-image";

$video_link  =    get_post_meta($post->ID,'_video_link',true);
 

$content_width = '';



$content_width = '';
$width = 960; $height = 450;
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

get_header(); ?>   

<?php  if(have_posts()): while(have_posts()) : the_post(); ?>

<div class="page-wrapper">
  <div class="title thunder_listener" data-filter="bg" data-headings-filter="cr bbr">
     	<div class="skeleton">
        	<h1 class="custom-font"><?php the_title(); ?></h1> 
            
           
        </div>
   	 </div>
    <?php  if($super_options[SN."_breadcrumbs_enable"]=="true" && !is_front_page()) $helper->breadcrumbs(); ?> <!-- The breadcrumb for the theme --> 
<div class=" page content skeleton  <?php echo $layout; ?> single-post clearfix"> <!-- Start of loop -->
    
       
   
    
      <?php   if($layout=="hasDoubleSidebar") { $first_sidebar = true;  get_sidebar(); }    ?> 
   
   
    <div class="<?php echo $content_width; ?> " id="main-content" >
     
    
    
    
     <?php 
	  
	 
	  
	    if ($super_options[SN.'_featured_image'] !="false" && $featured_media == "featured-image" && (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :
		
			$id = get_post_thumbnail_id();
		    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		    echo '<div class="single-image thunder_listener preload" data-image-filter="bg cr" data-filter="tbr"><span class="date thunder_image">'.do_shortcode("[post_date format='F j, Y'/]").'</span>'.$helper->imageDisplay( array( "src"=> $ar[0] ,"height" => "" , "width" => $width , "parent_wrap" => false ,"imgclass" => "" ) ).'</div>';  
		
	  elseif(  $featured_media=="video" ) : 
     		
			echo '<div class="single-video">'.do_shortcode("[internalvideo height='500' width='960' ]{$video_link}[/internalvideo]").'</div>';  
			
			
     elseif( $featured_media!="" && $featured_media!="none" && $featured_media != "featured-image" && $featured_media != "video") : 
     		 get_template_part('includes/slideshow');
       endif ?>
     
     <?php if( $titan_template=="" || $titan_template=="none" ) : ?>
     
     
  
    <?php echo "<div class='single-post-content thunder_listener' data-text-filter='cr' data-link-filter='cr crh'>"; 
	the_content(); echo "</div>";
	 
	 else :
	 
			 get_template_part('includes/titan_template');
	 
	 endif;
	 
	 ?>
     
   
        
      <?php if($super_options[SN."_author_bio"]=="" || $super_options[SN."_author_bio"]=="true") { ?>                    
      <div id="authorbox" class="clearfix thunder_listener" data-filter="tbr" data-headings-filter="cr" data-text-filter="cr">  
      <div class="author-avatar">
      
      <?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '80' ); }?>  
      </div>
      <div class="authortext">   
      <h3 class="custom-font">About the author</h3>
      <p><?php the_author_meta('description'); ?></p>  
      </div>  
      </div>
      <?php }?>  
      
      
       <div class="single-project-nav clearfix  thunder_listener" data-filter="bg tbr tbr bbr" data-link-filter="cr crh">
         <?php $prev_post = get_adjacent_post(false,'',true) ; if($prev_post) echo "<a class='nav-p' href='".get_permalink($prev_post->ID)."'><span class='portfolio-previous'></span>&lsaquo; ".get_the_title($prev_post->ID)."</a>"; ?>
         <?php $next_post = get_adjacent_post(false,'',false) ;if($next_post)  echo "<a class='nav-n' href='".get_permalink($next_post->ID)."'> ".get_the_title($next_post->ID)." &rsaquo;<span class='portfolio-next'></span></a>"; ?> 
     </div>  
     
     
        <?php if($super_options[SN."_popular"]=="true") : ?>    
        
         <div class="relate-posts-wrapper thunder_listener"  data-link-filter="cr crh">
         
      <?php if($super_options[SN.'_related_posts_title']!="") : ?> 
     <h3 class="related-posts-title custom-font"><?php echo $super_options[SN.'_related_posts_title']; ?></h3><?php endif; ?>  
      <ul class="clearfix related-posts" >
      <?php 
      $tags = wp_get_post_tags($post->ID);
      if ($tags) {
      $tag_ids = array();
      foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
      $args=array(
      'tag__in' => $tag_ids,
      'post__not_in' => array($post->ID),
      'posts_per_page'=>$super_options[SN."_popular_no"]
	  
      );
      }
      
      
      $popPosts = new WP_Query( $args );
      
      while ($popPosts->have_posts()) : $popPosts->the_post();  $more = 0;?>
      
      <li class="clearfix" >
      <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>
      <div class="image">
     <?php
	 
	 $id = get_post_thumbnail_id();
		    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		    echo $helper->imageDisplay( array( "src"=> $ar[0] ,"height" => 100 , "width" => 135 , "lightbox" => false, 'link' => get_permalink() ,"imgclass" => "thunder_image" ) );
			?>
     
      <h3 class="custom-font"><a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a></h3>
      </div><!--image-->
      <?php endif; ?>
      </li>
      
      <?php endwhile; ?>
      
      <?php wp_reset_query(); ?>
      
      </ul>
           
     <?php endif; ?>
     </div>
     
      
       <?php if($super_options[SN."_fb_comments"]!="false") : ?>
      <div class="fb_comments_template">
     		
            <div id="fb-root"></div>
			<script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=165111413574616";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            
            
            <div class="fb-comments" data-href="<?php the_permalink();?>" data-num-posts="2" data-width="<?php echo $width-40; ?>" ></div>
            
      </div>
      <?php endif; ?>
      
      
      
      <?php if($super_options[SN."_posts_comments"]!="false") : ?>
      <div id="comments_template" class="clearfix thunder_listener" data-text-filter="cr" data-headings-filter="cr" data-button-filter="cr bg crh bgh" >
      <?php comments_template(); ?>
      </div>
      <?php endif; ?>

    
   </div>
   
     
   
   <?php   if($layout!="full-width") {  $first_sidebar = false; get_sidebar(); }     ?> 
  </div>      
</div>

<?php endwhile; endif; ?> <!-- End of loop -->

<?php get_footer(); ?>
      