<?php

/* ======================================================================= */
/* == Shortcodes ========================================================= */
/* ======================================================================= */

/* 

Author - WPTitans
Description - Contains all the shortcodes used by the hades framework. Use index to search.

== Index =====================
------------------------------

1. Google Map
2. Layouts


==============================

*/

// == Layout =======================================

function layoutMaker($atts , $content , $code)
{
	global $helper;
	$hasLast = strpos($code,"_last");
	if($hasLast)
	$add = "<div class='clearfix'></div>";
	else
	$add ='';
	return "<div class='$code clearfix layout_element'> ". titanShorcodeformat( $content )." </div> $add";
	
}
add_shortcode("one_half","layoutMaker");
add_shortcode("one_half_last","layoutMaker");
add_shortcode("one_third","layoutMaker");
add_shortcode("one_third_last","layoutMaker");
add_shortcode("two_third","layoutMaker");
add_shortcode("two_third_last","layoutMaker");
add_shortcode("one_fourth","layoutMaker");
add_shortcode("one_fourth_last","layoutMaker");
add_shortcode("three_fourth","layoutMaker");
add_shortcode("three_fourth_last","layoutMaker");
add_shortcode("one_fifth","layoutMaker");
add_shortcode("one_fifth_last","layoutMaker");
add_shortcode("four_fifth","layoutMaker");
add_shortcode("four_fifth_last","layoutMaker");
add_shortcode("one_sixth","layoutMaker");
add_shortcode("one_sixth_last","layoutMaker");
add_shortcode("five_sixth","layoutMaker");
add_shortcode("five_sixth_last","layoutMaker");

function inertanltitanshortcodes_video($atts,$content)
{
	extract(
	shortcode_atts(array(  
        "width" => "300",
		"height" => "250"
		
    ), $atts)); 
	
	
	global $wp_embed;
	$content = trim($content);
	
	if(strpos($content,'youtube'))
	{
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $content, $match);
		$temp = "<iframe title=\"YouTube video player\" width=\"{$width}\" height=\"{$height}\" src=\"http://www.youtube.com/embed/{$match[1]}?wmode=Opaque\" frameborder=\"0\" allowfullscreen ></iframe>";
	}
	else
	{
		$content = str_replace("https://",'',$content);
		$content = explode("/",$content);
		
		$temp = "<iframe title=\"Vimeo video player\" width=\"{$width}\" height=\"{$height}\" src=\"http://player.vimeo.com/video/{$content[1]}?wmode=Opaque\" frameborder=\"0\" ></iframe>";
	}
	
  
	return $temp;
}


add_shortcode("internalvideo","inertanltitanshortcodes_video");

// === Blog shortcodes ============================================================

function functionpost_author_posts_link($atts)
{
	global $post,$author;
	
	
	return "<a href='".get_author_posts_url(get_the_author_meta( 'ID' ))."'>".get_the_author()."</a>";
}


add_shortcode("post_author_posts_link","functionpost_author_posts_link");


function functionpost_date($atts)
{
	global $post,$author;
	extract(
	shortcode_atts(array( 
		 "format"  => "l, F d S, Y"
		
    ), $atts)); 
	
	return get_the_time($format);
}


add_shortcode("post_date","functionpost_date");


function functionpost_time($atts)
{
	global $post,$author;
	extract(
	shortcode_atts(array( 
		 "format"  => "g:i a"
		
    ), $atts)); 
	
	return get_the_time($format);
}


add_shortcode("post_time","functionpost_time");


function functionpost_tags($atts)
{
	global $post,$author;
	
	$posttags = get_the_tags($post->ID);

	$str = '';
		if ($posttags) {
			$i=0;
		  foreach($posttags as $tag) {
			
			if($i==0)
			$str = $str. '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>'; 
			else
			$str = $str. ' , <a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>'; 
			
			$i++;
		  }
		}

	
	return $str ;
}


add_shortcode("post_tags","functionpost_tags");


function functionpost_comments($atts)
{
	global $post,$author;
	
	ob_start();
	 comments_number( __('no Comments','h-framework'), __('one Comment','h-framework'), '%'.__(' Comments','h-framework') );
	 $temp = ob_get_contents();
    ob_end_clean();
	
return '<a class="single-comment" href="'.get_permalink().'#comment" >'.$temp.'</a>';
}




add_shortcode("post_comments","functionpost_comments");


function functionpost_comments_number($atts)
{
	global $post,$author;
	
	
	
return '<a class="single-comment" href="'.get_permalink().'#comment" >'.get_comments_number( $post->ID ).'</a>';
}




add_shortcode("post_comments_number","functionpost_comments_number");

function functionpost_categories($atts)
{
	global $post,$author;
	
	$cats = get_the_category( $post->ID );
 $str = '';
 $i =0;
  foreach($cats as $c)
  {
	  if($i==count($cats)-1)
	  $str = $str .'<a href="'.get_category_link($c->term_id ).'">'.$c->cat_name.'</a>'; 
	  else
	  $str =$str . '<a href="'.get_category_link($c->term_id ).'">'.$c->cat_name.'</a> ,'; 
	  
	  $i++;
  }
 return $str;
}


add_shortcode("post_categories","functionpost_categories");


// == Titan Slider =======================================

function sliderMaker($atts)
{
	extract(
	  shortcode_atts(array(  
	    "id"=>"",
		"width" => 500 ,
		"height" => 500
	    ), $atts));
	
	global $wpdb;
	
	$table_db_name = $wpdb->prefix . "tslidermanager";
	$slider = $wpdb->get_row("SELECT * FROM $table_db_name where id='$id' ",ARRAY_A); 
				 
				
	 $slides = unserialize($slider['slides']); 
	 $options =  unserialize($slider['options']);
	 
	 if($width!="")
	 $options['width'] = $width;
	 
	 if($height!="")
	 $options['height'] = $height;
	 
	 if( !is_array($slides) ) $slides = array(); 
	
	 $shortcodeslider =  new Orion($slides,$options);
	 return $shortcodeslider->getSlider();	
}
add_shortcode('titan_slider','sliderMaker');

// == Recent Posts ========