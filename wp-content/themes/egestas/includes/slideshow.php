<?php global $wpdb,$helper,$featured_media,$width; ?>

<div class="page_featured_slider">
     <?php 
	 
	 	 $table_db_name = $wpdb->prefix . "tslidermanager";
		 $slider = $wpdb->get_row("SELECT * FROM $table_db_name where id='$featured_media' ",ARRAY_A); 
		 
		
		 $slides = unserialize($slider['slides']); 
		 $options =  unserialize($slider['options']);
		$options['width'] = $width;
		 
		 $options['slider_type'] = "Fade Slider";
		 
		 if( !is_array($slides) ) $slides = array(); 
		
		 $pslider =  new Orion($slides,$options);
		 echo $pslider->getSlider();	
		
		 ?>
</div>