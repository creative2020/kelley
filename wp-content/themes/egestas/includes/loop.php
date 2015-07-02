<?php

global $blog_options,$paged,$more,$helper,$super_options,$width,$query_string;

/*							
	'items_limit' => $super_options[SN."_posts_item_limit"],
	'content_limit' =>  (int)$super_options[SN."_posts_excerpt_limit"],
	'categories' => $categories,
	'width' => $width ,
	'height' => $height,
	'meta_data' => true,
	'clear' => 2,
	'label' => 'blog-item-2-',
	'lightbox' => true						  
						 
*/						  

$limit = $cats = '';
						  			
if($blog_options['categories'])
{
	//portfoliocategories=test&
	$cats = "category_name=".$blog_options['categories']."&";
}


$counter = $blog_options['clear'];

if($blog_options['items_limit']) $limit = "posts_per_page=$blog_options[items_limit]";


 if(is_front_page())  $paged = get_query_var('page') ? get_query_var('page') : 1;
query_posts("{$cats}{$limit}&".'&paged='.$paged);
$testflag = false;		
?>
            
		 <ul class="clearfix posts thunder_listener"  data-text-filter="cr" data-link-filter="cr crh"  data-button-filter="cr crh" data-image-filter="tbr bg cr">
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
					 
					 if($blog_options['lightbox']=="false"){ $blog_options['lightbox'] =false; $link = get_permalink(); }
					 else { $blog_options['lightbox'] = true; $link = $ar[0]; }
					 
	    	         echo '<div class="imageholder-wrapper clearfix thunder_image"><span class="date thunder_image">'.do_shortcode("[post_date format='F j, Y'/]").'</span>'.$helper->imageDisplay(array( "src" => $ar[0] , "height" =>$blog_options['height'] , "width" => $blog_options['width'] , "link" => $link,  "lightbox" => $blog_options['lightbox'] ,"advance_query" => "&amp;a=t" ,"class" => "  "))."</div>";  
					
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
        