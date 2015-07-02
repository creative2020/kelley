<?php

global $portfolio_options,$paged,$more,$helper;

/*							
	'items_limit' => $super_options[SN."_portfolio2_item_limit"],
	'content_limit' =>  (int)$super_options[SN."_portfolio2_limit"],
	'categories' => $categories,
	'meta_filters => $meta,
	'order' => $order,
	'width' => $width ,
	'height' => $height,
	'meta_data' => true,
	'clear' => 2,
	'label' => 'portfolio-item-2-',
	'lightbox' => true						  
						 
*/						  

$limit = $cats = '';
						  			
if($portfolio_options['categories'] && count($portfolio_options['categories']) > 0 )
{
	

	//portfoliocategories=test&
	 $cats = "tax=portfoliocategories&portfoliocategories=".implode(",",$portfolio_options['categories'])."&";
	
}


if($portfolio_options['meta_filters']!="none")
{
	$cats = $cats . "orderby=$portfolio_options[meta_filters]&";
}

$cats = $cats."order=$portfolio_options[order]&";

if(!isset($portfolio_options['desc'])) $portfolio_options['desc'] = true;

$counter = $portfolio_options['clear'];


if($portfolio_options['items_limit']) $limit = "posts_per_page=$portfolio_options[items_limit]";

query_posts("{$cats}{$limit}&post_type=portfolio".'&paged='.$paged);
$height_ar = array( 462 , 185 , 462 , 462 , 185  , 185 , 185 , 185, 185, 185 );
?>
            
		 <ul class="clearfix posts">
          <?php 
	  	$i =0 ;	
	        if ( have_posts() ) : while ( have_posts() ) : the_post();
		    $oddc = '';
            $more = 0;
			
		
			
			if( count($height_ar)-1==  $i) $i = 0;
			
			if($counter==0 )
			{
				
				
				$counter = $portfolio_options['clear']; 
			//	echo "<li class='separator clearfix'></li>";
			}
	      ?>
                <li class="clearfix <?php echo $portfolio_options['label'].''.$counter; 
				
				 $terms  = get_the_terms($post->ID,'portfoliocategories'); 
				 if ( !empty( $terms ) ) {
		  			$out = array();
					foreach ( $terms as $c )
						echo ' '.str_replace(' ','_',$c->name);
						
				}
				 ?>">
                 <?php 
				
				// $featured_media =    get_post_meta($post->ID,'_featured_media',true);
				  $featured_media = "featured-image" ; 
				
				 $video_link  =    get_post_meta($post->ID,'_video_link',true);
				 $height = $portfolio_options['height'] ; $width = $portfolio_options['width']; 
				
				 if ($featured_media == "featured-image" && (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :
		
					 $id = get_post_thumbnail_id();
	          	     $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
					  $lightbox = true;
					 if($portfolio_options['lightbox']=="false"){  $lightbox  =false; $link = get_permalink(); }
					 else { $lightbox = true; $link = $ar[0]; }
					 
	    	         echo '<div class="imageholder-wrapper clearfix">'.$helper->imageDisplay(array( "src" => $ar[0] , "height" => $height_ar[$i] , "width" => $portfolio_options['width'] , "link" => $link,  "lightbox" => $lightbox  ,'class' => ' thunder_image ' ))."<a class='hover  "; 
					 if($lightbox=="true") echo " lightbox "; echo " ' title='".get_the_title()."' href='$link' ><span class='zoom'></span>";
					 
					 
					  echo"</a></div>";  
					
				 endif;
			    ?>
               <h2 class="custom-font"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
                
                </li>
          <?php  $counter--; $i++;  endwhile; else:
              echo  '<h4>'.__("No posts yet !",'h-framework').'</h4>';
            endif;
        	?>
     </ul>
        