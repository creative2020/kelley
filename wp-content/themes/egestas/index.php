<?php

global $wpdb; $table_db_name = $wpdb->prefix . "tslidermanager";
$slider = $wpdb->get_row("SELECT * FROM $table_db_name where id='1' ",ARRAY_A); $slides = unserialize($slider['slides']); $options =  unserialize($slider['options']);
if( !is_array($slides) ) $slides = array(); 	

get_header();  
?>   

<div id="page-starter" class="skeleton">


<?php if( count($slides) > 0 && $options['slider_type']!="none" ) : // If Slides are Empty Dont show it ~~` ?>

<div id="home-slider"> <!--  Parent Slider Container -->
  <div class="inner-slider-wrapper thunder_listener " data-filter="bg"> <!--  Inner Slider Container -->
    <div class=" clearfix  "> <!--   Slider Container -->
        
        
    <?php 
	
	
	
	$options['width'] = 960;
	$options['height'] = 420;
	$floatable ='';
	
	
	$home_slider = new Orion($slides,$options);

			
	echo '<div class="homepage-slider '.$floatable .'">'.$home_slider->getSlider()."</div>";
	
	?>
       
    </div> <!--  End of Parent Slider Container -->
  </div> <!--  End of Parent Slider Container -->
</div> <!-- End of Parent Slider Container -->

<?php endif; ?>

</div> <!-- End of Starter  -->



<div class="home-template-area full-width" id="main-content">
	<?php 
	 $helper->titanGenerator(1); // This function is in helper.php file in hades_framework -> helper folder ~~
	?>
</div>


<?php get_footer(); ?>
      