<?php
/*
Template Name: Sitemap Page Template
*/
?>

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

<?php  if(have_posts()): while(have_posts()) : the_post(); ?>
 
  <div class="title thunder_listener" data-filter="bg" data-headings-filter="cr bbr">
     	<div class="skeleton">
        	<h1 class="custom-font"><?php the_title(); ?></h1> 
            
           
        </div>
   	 </div>
   
<div class=" page content sitemap-template   <?php echo $layout; ?> clearfix"> <!-- Start of loop -->
    

 

      <?php   if($layout=="hasDoubleSidebar") { $first_sidebar = true;  get_sidebar(); }    ?> 
   
   
    <div class="<?php echo $content_width; ?>" id="main-content">
     
   
     <?php the_content();    ?>
 		
     <div class="clearfix skeleton">
      
      <div class="one_half layout_element">
     
     	 <h2 id="pages">Pages</h2>
              <ul>
              <?php
               wp_list_pages(   array( 'exclude' => '', 'title_li' => '' ) );
              ?>
              </ul>
         </div>     
        <div class="one_half_last layout_element">  
              <h2 id="posts"><?php _e('Posts','h-framework'); ?></h2>
              <ul class="cats">
			  <?php 
			  
			  $category_ids = get_all_category_ids();
	   	 	foreach($category_ids as $cat_id) {
  		$cat_name = get_cat_name($cat_id);
  		echo "<li> <h5 class='custom-font'> $cat_name </h5><ul class='subcats'>";
		 
			  $query = new WP_Query();
			 
			  $query->query('cat='.$cat_id.'');
			  while ($query->have_posts()) : $query->the_post();  
			 echo " <li><a href=\"".get_permalink()."\">". get_the_title()  ."  </a></li>";
		   endwhile; 
            
		echo "</ul></li>";
		
	}
			  
			  ?>
              </ul> 
     </div> </div>  
            
     <?php   if($super_options[SN."_page_comments"]=="true") :  ?>
     	 <div id="comments_template">
      		<?php comments_template(); ?>
     	 </div>
      <?php endif; ?>
   </div>
   
   
   
   <?php   if($layout!="full-width") {  $first_sidebar = false; get_sidebar(); }     ?> 

</div> </div>
  
  

<?php endwhile; endif; ?> <!-- End of loop -->

<?php get_footer(); ?>
      