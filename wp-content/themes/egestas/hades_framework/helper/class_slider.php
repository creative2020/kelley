<?php

/* ======================================================================= */
/* == Slider Maker ================================================== */
/* ======================================================================= */

/* 

Author - WPTitans
Code Name - Orion
Version - 2.2
Description - Creates all types of sliders you name it :P .

*/

if(!defined('HPATH'))
die(' The File cannot be accessed directly ');

if(!class_exists('Orion')) {

// == Class defination begins	=====================================================
  class Orion {
	  
	  private $slides;
	  private $markup;
	  private $options; 
	  
	 
	   // == Constructor ==============================================================
      function __construct($slides,$options ){ 
	  
		
		$this->slides = $slides;
		$this->options = $options;

		
	
	    switch($options['slider_type']) {
		case "Fade Slider"   :  $this->createFadeSlider(); break;
		case "Move Slider"   :  $this->createMoveSlider(); break;
		
		case "Accordion Slider" :  $this->createAccordionSlider(); break;
		case "jQuery Slider" :  $this->createjQuerySlider(); break;
		case "Image Gallery" : $this->createImageGallery(); break;
		case "Grid Wall" : $this->createGridWall(); break;
		}
	
	  }
	
	  
	  function createFadeSlider() {
		  global $helper;
		  
		  $o = $this->options;
		  $width = $o['width'];
		  $height = $o['height'];
		  
		  $exStyled = '';

		  
		  $markup = " <div class='qSlider $exStyled ' data-filter='bg br'  data-headings-filter=\"cr\" data-text-filter=\"cr\" data-button-filter='bg cr bgh crh' ><ul class='slides fadeSlider '  data-width='$o[width]' data-height='$o[height]' data-time='".( 1000 * (int)($o['time']) )."' data-responsive='$o[responsive]' data-preloading='$o[preloading]' data-autoplay='$o[autoplay]' data-arrows='$o[arrow_control]' data-bullets='$o[bullets_control]' >
		  ";
		 
		  foreach($this->slides as $slide)
		  {
			  $s_title =''; $s_desc = '';$desc = '';
			   $p_test = true;
			   if(trim($slide['title'])!="")
			  $s_title = " <h2 class='custom-font'>".$slide["title"]." </h2>";
			  
			   if(trim($slide['caption'])!="")
			  $s_desc = " <p>".$helper->format($slide["caption"],false,true,false)."</p>";
			  
			   $l = explode(',',$slide['link']);
			    if($l[0]=="custom") $l = $l[1];
			  else if ( $l[0]=="none")  $p_test = false;
			  else $l = get_permalink($l[1]);
			  
			  $more ='';
			  
			  if($p_test) $more = "<a class='more thunder_button' href='$l'> More </a>";
			  
			  if($o['caption']=="true")
			  $desc = stripslashes("<div class='desc'  data-link-filter=\"bg cr\"  data-headings-filter=\"cr\" data-text-filter=\"cr\"> $s_title <div class='inner-slider-content'> $s_desc  $more </div></div> ");
			  
			 
			  
			
			  
			 
			 
			  
			 if(isset($slide['video']))
			 {
				  $src = "<a href='$l'>".do_shortcode("[video height=".($height)." width='$width' ]{$slide[video]}[/video]").'</a>';
				  $desc = '';
			 }
			 else 
			 $src = $helper->imageDisplay( array( "src" => $slide['image'], "height" => $height, "width" => $width ,"link" => $l , "lightbox" => false , "parent_wrap" => $p_test , "imageAttr" => "alt='$slide[title]'","advance_query" => "&amp;a=t") );
			   
			   $markup = $markup."<li> $src $desc </li>";
		  }
		 
		
		  
		   $markup = $markup."</ul></div>";
		   $this->markup = $markup;
		  
		  }
		  
		  
		  
		 function createMoveSlider() {
		  global $helper;
		  
		  $o = $this->options;
		  $width = $o['width'];
		  $height = $o['height'];
		  
		  $exStyled = '';

		  
		  $markup = " <div class='mSlider $exStyled ' data-filter='bg br'  data-headings-filter=\"cr\" data-text-filter=\"cr\" data-button-filter='bg cr bgh crh' ><ul class='slides moveSlider '  data-width='$o[width]' data-height='$o[height]' data-time='".( 1000 * (int)($o['time']) )."' data-responsive='$o[responsive]' data-preloading='$o[preloading]' data-autoplay='$o[autoplay]' data-arrows='$o[arrow_control]' data-bullets='$o[bullets_control]' >
		  ";
		 
		  foreach($this->slides as $slide)
		  {
			  $s_title =''; $s_desc = '';$desc = '';
			   $p_test = true;
			   if(trim($slide['title'])!="")
			  $s_title = " <h2 class='custom-font'>".$slide["title"]." </h2>";
			  
			   if(trim($slide['caption'])!="")
			  $s_desc = " <p>".$helper->format($slide["caption"],false,true,false)."</p>";
			  
			   $l = explode(',',$slide['link']);
			    if($l[0]=="custom") $l = $l[1];
			  else if ( $l[0]=="none")  $p_test = false;
			  else $l = get_permalink($l[1]);
			  
			  $more ='';
			  
			  if($p_test) $more = "<a class='more thunder_button' href='$l'> More </a>";
			  
			  if($o['caption']=="true")
			  $desc = stripslashes("<div class='desc'  data-link-filter=\"bg cr\"  data-headings-filter=\"cr\" data-text-filter=\"cr\"> $s_title <div class='inner-slider-content'> $s_desc  $more </div></div> ");
			  
			 
			  
			
			  
			 
			 
			  
			 if(isset($slide['video']))
			 {
				  $src = "<a href='$l'>".do_shortcode("[video height=".($height)." width='$width' ]{$slide[video]}[/video]").'</a>';
				  $desc = '';
			 }
			 else 
			 $src = $helper->imageDisplay( array( "src" => $slide['image'], "height" => $height, "width" => $width ,"link" => $l , "lightbox" => false , "parent_wrap" => $p_test , "imageAttr" => "alt='$slide[title]'","advance_query" => "&amp;a=t") );
			   
			   $markup = $markup."<li> $src $desc </li>";
		  }
		 
		
		  
		   $markup = $markup."</ul></div>";
		   $this->markup = $markup;
		  
		  }  
		  
	  
	    function createGridWall() {
		  global $helper;
		  
		  $o = $this->options;
		  $width = $o['width'];
		  $height = $o['height'];
		  
		  $exStyled = '';

		  
		  $markup = " <div class='gridSlider $exStyled ' >
		 <a href='' class='prev'></a>  <a href='' class='next'></a> <div class='inner-grid-wrapper'>  ";
		 
	
		 $series = array(
		 	array ( 117,95,125,105,356 ) ,
			array ( 600,120,80 ) ,
			array ( 436,124,100,140 ) ,
			array ( 200,200,200,200 ) ,
			array ( 160,160,200,100,179 ) ,
			array ( 401,401 ) ,
			array ( 250,250,300 ) ,
			array ( 117,95,125,105,356 ) ,
			array ( 600,120,80 ) ,
			array ( 436,124,100,140 ) ,
			array ( 200,200,200,200 ) ,
			array ( 160,160,200,100,179 ) ,
			array ( 400,400 ) ,
			array ( 250,250,300 ) ,
			array ( 117,95,125,105,356 ) ,
			array ( 600,120,80 ) ,
			array ( 436,124,100,140 ) ,
			array ( 200,200,200,200 ) ,
			array ( 160,160,200,100,179) ,
			array ( 400,400 ) ,
			array ( 250,250,300 ) ,
			
			
		 );
		 
		 $count = count($this->slides);
		
	$j=0; $k =0 ; $test = false;
	 $markup = $markup. "<div class='image-set'>";
	 foreach ( $series as $row)
	 {
		 if( $k>=3 && $j<=$count-1 ) {
			 $markup = $markup. "</div><div class='image-set'>";
		 	 $k = 0;
		 }
	  
		if($j<=$count-1 ) $markup = $markup. "<ul class='clearfix'>";
			  
		
		  for($i=0;$i<count($row);$i++)
		  {
			  if($j>=$count) 
			  {
				  break;
				 
			  }
			  $p_test = true;
			  $l = explode(',',$this->slides[$j]['link']);
			  if($l[0]=="custom") $l = $l[1];
			  else if ( $l[0]=="none")  $p_test = false;
			  else $l = get_permalink($l[1]);
			  
			  
		      $src = $helper->imageDisplay( array( "src" => $this->slides[$j]['image'], "height" => 147, "width" => $row[$i] ,"link" => $l , "lightbox" => false , "parent_wrap" => $p_test , "imageAttr" => "alt=''","advance_query" => "&amp;a=t" , "hoverable" => $p_test ) );
			   
			   $markup = $markup."<li> $src  </li>";
		 $j++; 
		  
		  }
		  
		if($j<=$count-1)  $markup = $markup. "</ul>";
		
		$k++;
		  
	 }
		 
		  
		   $markup = $markup."</ul></div></div></div>";
		   $this->markup = $markup;
		  
		  }
		  	  
		  
	
	  function createImageGallery() {
		  global $helper;
		  
		  $o = $this->options;
		  $width = $o['width'];
		  $height = $o['height'];
		  
		  $exStyled = '';
		  if($o['styled']=="true")  {
			    $exStyled = $exStyled .' sliderstyled';
		    	 $options['width'] = (int) $options['width'] - 8;
		  }
		  
		  
		
		  $markup = "
		  
		  <script type='text/javascript' src='".URL."/sprites/js/galleria.1.2.7.js'></script>
		  <script type='text/javascript' src='".URL."/sprites/js/galleria-theme/galleria.classic.js'></script>
		  <script type='text/javascript'>
		 	jQuery(function($){
				 $('.galleria').galleria({ responsive:true });
				});
		  </script> 
		  <div class='galleria clearfix' style='height:580px;width:100%'> ";
		 
		  foreach($this->slides as $slide)
		  {
			  
			  $l = explode(',',$slide['link']);
			  
			  if($l[0]=="custom") $l = $l[1];
			  else if ( $l[0]=="none")  $p_test = false;
			  else $l = get_permalink($l[1]);
			
			 $src = $helper->imageDisplay( array( "src" => $slide['image'], "height" => 50, "width" => 50 ,"link" =>  $slide['image'] , "lightbox" => false , "imageAttr" => 'data-title="'.stripslashes($slide["title"]).' alt="'.$slide['title'].'"  data-description="'.stripslashes($slide["caption"]).'"' , "advance_query" => "&amp;a=t") );
			   
			   $markup = $markup." $src ";
		  }
		 
	
		  
		   $markup = $markup."</div>";
		   $this->markup = $markup;
		  
		  }
	  	  
	  
	  
	  function createjQuerySlider() {
		  global $helper;
		  
		  $o = $this->options;
		  $width = $o['width'];
		  $height = $o['height'];
		  
		  $exStyled = '';
		  if($o['styled']=="true")   $exStyled = $exStyled .' sliderstyled';
		  
		  
		  
		  $markup = " <div class='soleaSlider $exStyled' style='width:{$o[width]}px;height:{$o[height]}px;'  data-filter='bg br'  data-headings-filter=\"cr\" data-text-filter=\"cr\" data-button-filter='bg cr bgh crh'><ul class='slides jquerySlider' style='width:{$o[width]}px;height:{$o[height]}px;'  data-width='$o[width]' data-height='$o[height]' data-time='".( 1000 * (int)($o['time']) )."' data-responsive='$o[responsive]' data-preloading='$o[preloading]' data-autoplay='$o[autoplay]' data-arrows='$o[arrow_control]' data-bullets='$o[bullets_control]' data-random='$o[random]'>
		  ";
		 
	
		 
		 
		   foreach($this->slides as $slide)
		  {
			  $s_title =''; $s_desc = '';$desc = '';
			   $p_test = true;
			   if(trim($slide['title'])!="")
			  $s_title = " <h2 class='custom-font'>".$slide["title"]." </h2>";
			  
			  if(trim($slide['caption'])!="")
			 $s_desc = " <p>".$helper->format($slide["caption"],false,true,false)."</p>";
			  
			  if($o['caption']=="true")
			  $desc = stripslashes("<div class='desc'> $s_title $s_desc </div> ");
			  
			  $l = explode(',',$slide['link']);
			  
			  if($l[0]=="custom") $l = $l[1];
			  else if ( $l[0]=="none")  $p_test = false;
			  else $l = get_permalink($l[1]);
			  
			  $src = $helper->imageDisplay( array( "advance_query" => "&amp;a=t" , "src" => $slide['image'], "height" => $height, "width" => $width ,"link" => $l , "lightbox" => false , "parent_wrap" => $p_test  , "imageAttr" => " alt='$slide[title]' " ) );
			   $markup = $markup."<li> <div class='image-wrap'>$src</div> $desc </li>";
		  }
		 
		 
		 
		
		  
		   $markup = $markup."</ul></div>";
		   $this->markup = $markup;
		  
		  }
	
	
	  function createAccordionSlider() {
		   global $helper;
		  
		$o = $this->options;
		  $width = $o['width'];
		  $height = $o['height'];
		
		  $markup = " <div class='accordion-wrapper '  data-filter='bg br'  data-headings-filter=\"cr\" data-text-filter=\"cr\" data-button-filter='bg cr bgh crh'  ><ul class='accordion' style='width:{$width}px;height:{$height}px;' id='$id'>
		  ";
		 $swidth =  round( $width * 0.75 );
		  
		  foreach($this->slides as $slide)
		  {
			    $s_title =''; $s_desc = '';$desc = '';
			   $p_test = true;
			   if(trim($slide['title'])!="")
			  $s_title = " <h2 class='custom-font'>".$slide["title"]." </h2>";
			  
			   if(trim($slide['caption'])!="")
			  $s_desc = " <p>".$helper->format($slide["caption"],false,true,false)."</p>";
			  
			   $l = explode(',',$slide['link']);
			    if($l[0]=="custom") $l = $l[1];
			  else if ( $l[0]=="none")  $p_test = false;
			  else $l = get_permalink($l[1]);
			  
			  $more ='';
			 
			  
			  if($p_test) $more = "<a class='more thunder_button' href='$l'> More </a>";
			  
			  if($o['caption']=="true")
			  $desc = stripslashes("<div class='desc'  data-link-filter=\"bg cr\"  data-headings-filter=\"cr\" data-text-filter=\"cr\"> $s_title <div class='inner-slider-content'> $s_desc  $more </div></div> ");
			  $src = $helper->imageDisplay( array( "src" => $slide['image'], "height" => $height, "width" => $swidth ,"link" => $l , "lightbox" => false , "parent_wrap" => false , "imageAttr" => "alt='$slide[title]'", "advance_query" => "&amp;a=t" ) );
			  
			  $markup = $markup."<li> $src $desc </li>";
		  }
		  
		  
		   $markup = $markup."</ul> </div>";
		   $this->markup = $markup;
		  }
		  	   
	  public function getSlider()
	  {
		  return $this->markup; 
	  }
	  
	   } // == End of Class ==========================
  
}

