<?php global $portfolio_meta_data,$helper; ?>

<div class="portfolio_meta_images">
     <?php 
	 
	   $markup = " <ul class='extra_images clearfix'>
		  ";
		 $i =0;
		  foreach($portfolio_meta_data['slides'] as $slide)
		  {
			
			  if( $slide['src']!="") :
			  
			  if($slide['layout']=="full")
			{
				if($slide['media']=="" || $slide['media'] == "image" )
				 $src = $helper->imageDisplay( array( "src" => $slide['src'], "height" => "", "width" => $portfolio_meta_data['width'] ,"parent_wrap" => false , "advance_query" => "&amp;a=t;" ) );
				else if($slide['media']=="youtube" || $slide['media']=="vimeo")
							{
								$src = '<div class="wall-video">'.do_shortcode("[internalvideo height='500' width='".$portfolio_meta_data['width']."' ]".$slide['src']."[/internalvideo]").'</div>';  
		
							}
							
			}
			 else
			 { 
				 if($slide['media']=="" || $slide['media'] == "image" )
				 $src = $helper->imageDisplay( array( "src" => $slide['src'], "height" => $portfolio_meta_data['height'], "width" => 460 ,"parent_wrap" => false , "advance_query" => "&amp;a=t;" ) );
				 else if($slide['media']=="youtube" || $slide['media']=="vimeo")
							{
								$src = '<div class="wall-video">'.do_shortcode("[internalvideo height='500' width='460']".$slide['src']."[/internalvideo]").'</div>';  
		
							}
							
				 $i++;
			 }
			 $cl = '';
			 if($i%2==0 && $slide['layout']=="half") $cl = "norightmargin";
			 
			     $markup = $markup."<li class='".$slide['layout']." $cl'> $src  </li>";
		      endif;
		  }
		 
		
		  
		   $markup = $markup."</ul>";
		 echo  $markup;
		  
		
		 ?>
</div>