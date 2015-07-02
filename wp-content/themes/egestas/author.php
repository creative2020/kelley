<?php

// == Layout Calculation =========================================


$layout =  "hasRightSidebar" ; // ~~ For pages existing prior to theme activation should have full width by default ~  

$sidebar1 =    "Blog Sidebar";
$sidebar2 =    get_post_meta($post->ID,'_dynamic_sidebar2',true);
 
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



$categories = false;

$blog_options = array(
							'items_limit' => 6,
							'content_limit' =>  (int)$super_options[SN."_posts_excerpt_limit"],
    				  	    'categories' => $categories,
							'width' => $width ,
							'height' => $height,
							'meta_data' => $super_options[SN.'_blog_meta_enable'],
							'clear' => 1,
							'label' => 'blog-item-1-',
							'lightbox' => $super_options[SN.'_enable_thumbnail']
						  );

get_header();



 ?>  



<div class="page-wrapper">
<div class="title thunder_listener" data-filter="bg" data-headings-filter="cr bbr">
     	<div class="skeleton">
        	<h1 class="custom-font"><?php printf( __( 'Author Archives: %s', 'h-framework' ), $curauth->display_name ); ?></h1> 
        </div>
   	 </div>


<div class=" page content skeleton  <?php echo $layout; ?> clearfix blog-template "> <!-- Start of loop -->
    
    
    
    <div class="<?php echo $content_width ?> " id="main-content">
   
   
   
     <div class="clearfix" >
     	
        
        <?php

		
?>
            
		 <ul class="clearfix posts">
          <?php 
	
	       if ( have_posts() ) : while ( have_posts() ) : the_post();
		    
            $more = 0;
			if($counter==0 )
			{
				$counter = $blog_options['clear']; 
				//echo "<li class='separator clearfix'></li>";
			}
			$o ='';
			if($testflag){  $o ='oddBG'; $testflag = false;  }
			else { $o =''; $testflag = true; }
			
		 $format = get_post_class('',$post->ID);
			
	      ?>
          
          
           <li class="clearfix <?php echo $o ?>">
                 <?php 
				
			
                
				// == Default Post =========================================================================
				
			 $featured_media = "featured-image" ; 
				 if ($featured_media == "featured-image" && (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :
		
					 $id = get_post_thumbnail_id();
	          	     $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
					 
					
					
					 
	    	         echo '<div class="imageholder-wrapper clearfix"><span class="date">'.do_shortcode("[post_date format='F j, Y'/]").'</span>'.$helper->imageDisplay(array( "src" => $ar[0] , "height" =>"" , "width" => 300 , "link" => $link,  "lightbox" => $blog_options['lightbox'] ,"advance_query" => "&amp;a=t" ,"class" => " thunder_image "))."</div>";  
					
				 endif;
				
				?>
             
                        
                  <div class="description clearfix ">
                       
                          
						<?php if($blog_options['meta_data']=="true") : ?> 
	 						<div class="extras clearfix"> 
								<div class="extras-info custom-font">
 									<?php echo $helper->format($super_options[SN.'_blog_meta'],false,true,false);  ?></a>  
  								</div>
  							</div>
	
						<?php endif; ?>
                      <h2 class="custom-font"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
                     <?php if(get_option(SN."_blog_excerpt")!="true") : ?>  
                       <p>
                        <?php
						   $more = 1;
                      $content = get_the_content('');
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $helper->getShortenContent( $blog_options['content_limit'] ,  strip_tags( $content  ) ); ?>
                     
                      </p>
                      <?php else :
                    echo do_shortcode(get_the_excerpt()); endif; ?>
                     
                       
                 </div>
                <a href="<?php the_permalink(); ?>" class="read-more custom-font thunder_button"> <?php if($super_options[SN.'_more_label']!= "" ) echo $super_options[SN.'_more_label']; ?> </a>
                
              
                 
                 
                </li>

          <?php  $counter--; endwhile; else:
              echo  '<h4>'.__("No posts yet !",'h-framework').'</h4>';
            endif;
        	?>
     </ul>
        
        
        
     </div>
     
       <?php $helper->pagination(); ?> 
        
    </div>
     <?php  
	  wp_reset_query();
	 if($layout!="full-width") {  $first_sidebar = false; get_sidebar(); }  
	 ?> 

</div>
</div>

<?php get_footer(); ?>