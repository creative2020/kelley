<?php

/* ======================================================================= */
/* == Widgets ============================================================ */
/* ======================================================================= */

/* 

Author - WPTitans
Description - Contains all the widgets used by the hades framework. Use index to search.

== Index =====================
------------------------------

1.  Google Map 
2.  Custom Box
3.  Twitter 
4.  Facebook Like
5.  Flickr 
6.  Super Post
7.  Ads 125 x 125px
8.  Ads 300px
9.  Mini Slideshow
10. Contact Form
11. Video 

==============================

*/

if(!defined('HPATH'))
die(' The File cannot be accessed directly ');

// == Google Map =====================

class GoogleMap extends WP_Widget {
	
	function GoogleMap() {
		 /* Widget settings. */
		 $widget_ops = array( 'classname' => 'GoogleMap', 'description' => __( 'Add google map.' ,'h-framework'));

		 /* Widget control settings. */
		 $control_ops = array( "width"=>200);
		 parent::WP_Widget(false,__( "Google map" ,'h-framework'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['title']= strip_tags($new_instance['title']); 
			$instance['map_width']= strip_tags($new_instance['map_width']); 
			$instance['map_height']= strip_tags($new_instance['map_height']); 
			$instance['address']= strip_tags($new_instance['address']); 
			return $instance;
	}
	function form($instance) {
		 
		$title = esc_attr($instance['title']);
		$width = esc_attr($instance['map_width']);
		$height = esc_attr($instance['map_height']);
		$address = esc_attr($instance['address']);
		
		if($width=="") $width = 300;
		if($height=="") $height = 250;
		?>
        
       
		<p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        <p> 
        <label for="<?php echo $this->get_field_id('map_width'); ?>"> <?php _e('Map Width','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('map_width'); ?>" name="<?php echo $this->get_field_name('map_width'); ?>" type="text" value="<?php echo $width; ?>" />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('map_height'); ?>"> <?php _e('Map Height','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('map_height'); ?>" name="<?php echo $this->get_field_name('map_height'); ?>" type="text" value="<?php echo $height; ?>" />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('address'); ?>"> <?php _e('Enter Address','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo $address; ?>" />
		</p>
        
     
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$title = esc_attr($instance['title']);
	$width = esc_attr($instance['map_width']);
	$height = esc_attr($instance['map_height']);
	$address = esc_attr($instance['address']);
	
	echo $before_widget;
		
	if($title!="")
	echo $before_title." ".$instance['title'].$after_title;
	
	echo '<div class="google-map" style="width:'.$width.'px;height:'.($height).'px;">
	          <iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.in/maps?q='.$address.'&amp;ie=UTF8&amp;hq=&amp;hnear='.$address.'&amp;gl=in&amp;z=11&amp;vpsrc=0&amp;output=embed">              </iframe>
		    </div>';
			
	echo $after_widget; 
		
		}
	
	

	}

add_action('widgets_init', create_function('', 'return
register_widget("GoogleMap");'));

// == Custom Box ============================

class CustomBoxWidget extends WP_Widget {
	
	function CustomBoxWidget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'CustomBox', 'description' => __(' Create a custom text box with read more link and image.','h-framework') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::WP_Widget(false,__("CustomBox",'h-framework'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['link']= $new_instance['link']; 
			$instance['label']= $new_instance['label']; 
			$instance['description']= $new_instance['description'];
			$instance['title']= strip_tags($new_instance['title']);
			$instance['intro_image_link']= strip_tags($new_instance['intro_image_link']);
			return $instance;
	}
	function form($instance) {
		 
		$link = esc_attr($instance['link']);
		$label = esc_attr($instance['label']);
		$description = $instance['description'];
		$title = esc_attr($instance['title']); 
		$intro_image_link = esc_attr($instance['intro_image_link']); 
		
		if(trim($label)=="") $label = 'more &rarr;';
		?>
    
       
       	 <p class="hades-custom ">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'h-framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>
         <div class="hades-custom ">
			<label for="<?php echo $this->get_field_id( 'intro_image_link' ); ?>"><?php _e('Intro Image Link: ( if empty image not will appear )', 'h-framework') ?></label>
            <div class="clearfix">
			<input class="widefat widget_text" id="<?php echo $this->get_field_id( 'intro_image_link' ); ?>" name="<?php echo $this->get_field_name( 'intro_image_link' ); ?>" value="<?php echo $instance['intro_image_link']; ?>" type="text" /> <a href="#" class="button image_upload" title="Add To Widget"> Upload </a>
            </div>
		</div>

		<!-- Embed Code: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Text', 'h-framework') ?></label>
			<textarea  class="widefat" style="height:200px;" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo  $instance['description']; ?></textarea>
		</p>
		
		 <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e('Link:( if empty link will not appear )', 'h-framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" type="text" />
		</p>
        
        <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e('Label for button', 'h-framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" value="<?php echo $instance['label']; ?>" type="text" />
		</p>
		
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$link = esc_attr($instance['link']);
	$label = esc_attr($instance['label']);
	$description = $instance['description'];
	$title = esc_attr($instance['title']); 
	$intro_image_link = esc_attr($instance['intro_image_link']); 
	
	echo $before_widget;
		if($title!="")
		echo $before_title." ".$instance['title'].$after_title;
		
	if(trim($intro_image_link)=="")
	$img = '';
	else
	$img = "<img src='{$intro_image_link}' alt='custom-box-image' />";
		
	echo " <div class='clearfix custom-box-content'> $img  ".wpautop($description)." </div>  ";
		
	if(trim($link)!="")
	echo "<a href='{$link}' class='more custom-font thunder_button'> $label </a>";
		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("CustomBoxWidget");'));

// == Twitter ================================================= 

class Twitter_Widget extends WP_Widget {
    function __construct() {
        $params = array(
	    'description' => 'Display and cache recent tweets to your readers.',
	    'name' => 'Display Your Tweets'
        );
        
        // id, name, params
        parent::__construct('Twitter_Widget', '', $params);
    }
    
    public function form($instance) {
        extract($instance);
        ?>
        
        <p>
	    <label for="<?php echo $this->get_field_id('title');?>">Title: </label>
	    <input type="text"
		class="widefat"
		id="<?php echo $this->get_field_id('title'); ?>"
		name="<?php echo $this->get_field_name('title'); ?>"
		value="<?php if ( isset($title) ) echo esc_attr($title); ?>" />
        </p>
        
        <p>
	    <label for="<?php echo $this->get_field_id('username'); ?>">Twitter Username:</label>
	    
	    <input class="widefat"
		type="text"
		id="<?php echo $this->get_field_id('username'); ?>"
		name="<?php echo $this->get_field_name('username'); ?>"
		value="<?php if ( isset($username) ) echo esc_attr($username); ?>" />
        </p>
        
        <p>
	    <label for="<?php echo $this->get_field_id('tweet_count'); ?>">
		<?php _e('Number of Tweets to Retrieve:','h-framework'); ?>
	    </label>
	     
	    <input
		type="number"
		class="widefat"
		style="width: 40px;"
		id="<?php echo $this->get_field_id('tweet_count');?>"
		name="<?php echo $this->get_field_name('tweet_count');?>"
		min="1"
		max="10"
		value="<?php echo !empty($tweet_count) ? $tweet_count : 5; ?>" />
        </p>
        <?php
    }
    
    // What the visitor sees...
    public function widget($args, $instance) {
	extract($instance);
        extract( $args );
        
        if ( empty($title) ) $title = 'Recent Tweets';
        
        $data = $this->twitter($tweet_count, $username);
        if ( false !== $data && isset($data->tweets) ) {
            echo $before_widget;
		echo $before_title;
		    echo $title;
		echo $after_title;

		echo '<ul class="latest-tweets"><li>' . implode('</li><li>', $data->tweets) . '</li></ul>';
            echo $after_widget;
        }
    }
    
    private function twitter($tweet_count, $username)
    {
        if ( empty($username) ) return;
        
        $tweets = get_transient('recent_tweets_widget');
        if ( !$tweets ||
	    $tweets->username !== $username ||
	    $tweets->tweet_count !== $tweet_count )
	{
	    return $this->fetch_tweets($tweet_count, $username);
	}
        return $tweets;
    }
    
    private function fetch_tweets($tweet_count, $username)
    {
	$tweets = wp_remote_get("https://api.twitter.com/1/statuses/user_timeline.json?screen_name=$username");
	
	if( is_wp_error( $tweets ) ) {
  			
			 
			 $data = new StdClass();
	$data->username = $username;
	$data->tweet_count = 1;
	$data->tweets[] = "Feeds Not Available !"; 
		}
   else { 
	$tweets = json_decode($tweets['body']);
   
	// An error retrieving from the Twitter API?
	if ( isset($tweets->error) ) return false;

	$data = new StdClass();
	$data->username = $username;
	$data->tweet_count = $tweet_count;

	foreach($tweets as $tweet) {
	    if ( $tweet_count-- === 0 ) break;
	    $data->tweets[] = $this->filter_tweet( $tweet->text );
	}

	set_transient('recent_tweets_widget', $data, 60 * 5); // five minutes
   }
	
	return $data;
    }

    private function filter_tweet($tweet)
    {
        // Username links
        $tweet = preg_replace('/(http[^\s]+)/im', '<a href="$1">$1</a>', $tweet);
        $tweet = preg_replace('/@([^\s]+)/i', '<a href="http://twitter.com/$1">@$1</a>', $tweet);
        // URL links
        return $tweet;
    }
    
}

// Here we gooooooo! (Mario voice)
add_action('widgets_init', 'register_Twitter_Widget');
function register_Twitter_Widget()
{
    register_widget('Twitter_Widget');
}

// == Facebook Like ==============================

class FBLike extends WP_Widget {
	
	function FBLike() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'FBLike', 'description' => __('Add facebook Like box to your sidebar.','h-framework') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200);
		 parent::WP_Widget(false,__("Facebook Like Box",'h-framework'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['fb_link']= strip_tags($new_instance['fb_link']); 
			$instance['width']= strip_tags($new_instance['width']);
			$instance['title']= strip_tags($new_instance['title']);
			$instance['show_friends']= $new_instance['show_friends'];
			$instance['fb_header']= $new_instance['fb_header'];
			$instance['fb_stream']= $new_instance['fb_stream'];
			
			 
			return $instance;
	}
	function form($instance) {
		 
		$fb = esc_attr($instance['fb_link']);
		$title = esc_attr($instance['title']);
		$width = $instance['width'];
		$friends = $instance['show_friends'];
		$header = $instance['fb_header'];
		$stream = $instance['fb_stream'];
		
		if($fb==""&&get_option("ami_fb_id"))
		$fb = get_option("ami_fb_id");
		
		
		 ?>
        
        
		<p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        <p> 
        <label for="<?php echo $this->get_field_id('fb_link'); ?>"> <?php _e('Add facebook page link','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('fb_link'); ?>" name="<?php echo $this->get_field_name('fb_link'); ?>" type="text" value="<?php echo $fb; ?>" />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('width'); ?>"> <?php _e('Width','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('show_friends'); ?>"> <?php _e('Show friends','h-framework'); ?> </label>
		<input id="<?php echo $this->get_field_id('show_friends'); ?>" name="<?php echo $this->get_field_name('show_friends'); ?>" type="checkbox" value="true" <?php if($friends) echo "checked='checked'"; ?> />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('fb_header'); ?>"> <?php _e('Show Head','h-framework'); ?> </label>
		<input id="<?php echo $this->get_field_id('fb_header'); ?>" name="<?php echo $this->get_field_name('fb_header'); ?>" type="checkbox" value="true" <?php if($header) echo "checked='checked'"; ?> />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('fb_stream'); ?>"> <?php _e('Show Stream','h-framework'); ?> </label>
		<input id="<?php echo $this->get_field_id('fb_stream'); ?>" name="<?php echo $this->get_field_name('fb_stream'); ?>" type="checkbox" value="true" <?php if($stream) echo "checked='checked'"; ?> />
		</p>
        
        
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
		$fb = esc_attr($instance['fb_link']);
		$title = esc_attr($instance['title']);
		$width = $instance['width'];
		$friends = $instance['show_friends'];
		$header= $instance['fb_header'];
		$stream= $instance['fb_stream'];
	
		echo $before_widget;
		if($title!="")
		echo $before_title." ".$instance['title'].$after_title;
		?>
		
        <div class="fb-widget">
        <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
        <fb:like-box href="<?php echo $fb; ?>" width="<?php echo $width; ?>" show_faces="<?php if($friends) echo $friends; else echo 'false'; ?>" stream="<?php if($stream) echo $stream; else echo 'false'; ?>" header="<?php if($header) echo $header; else echo 'false'; ?>"  ></fb:like-box>
        </div>
        
		<?php
			echo $after_widget; 
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("FBLike");'));



/* == Suport Post ============================== */


class SuperPost extends WP_Widget {
	
	function SuperPost() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'SuperPost', 'description' => __('Show Popular or Recent posts from Blog, Portfolio , Gallery and your dynamic custom posts.','h-framework') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200);
		 parent::WP_Widget(false,__("Super Posts",'h-framework'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['count']= strip_tags($new_instance['count']); 
			$instance['title']= strip_tags($new_instance['title']); 
			$instance['post_type']= strip_tags($new_instance['post_type']); 
			$instance['post_filter']= strip_tags($new_instance['post_filter']); 
			$instance['excerpt']= strip_tags($new_instance['excerpt']); 
			return $instance;
	}
	function form($instance) {
		 
		$count = esc_attr($instance['count']);
		$title = $instance['title'];
		$post_type = $instance['post_type'];	
		$post_filter = $instance['post_filter'];	
		$excerpt = $instance['excerpt'];	
	    $excerpt = trim($excerpt=="") ? 90 : $excerpt ;
		 ?>
        
        <p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('post_type'); ?>"> <?php _e('Post Type','h-framework'); ?> </label>
		<select name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>">
		 <?php 
		 $array = array("blog","portfolio","gallery");
		 foreach($array as $val){
		 
		 if($val==$post_type)
		 echo "<option value='$val' selected>$val</option>";
		 else
		 echo "<option value='$val'>$val</option>";
		 
		 }
		 ?>
        </select>
		</p>
        
         <p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('post_filter'); ?>"> <?php _e('Blog Posts Filter','h-framework'); ?> </label>
		<select name="<?php echo $this->get_field_name('post_filter'); ?>" id="<?php echo $this->get_field_id('post_filter'); ?>">
		 <?php 
		 $array = array("popular","recent","featured");
		 foreach($array as $val){
		 
		 if($val==$post_type)
		 echo "<option value='$val' selected>$val</option>";
		 else
		 echo "<option value='$val'>$val</option>";
		 
		 }
		 ?>
        </select>
		</p>
        
        
        <p class="hades-custom-media"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        
		<p class="hades-custom-media"> 
        <label for="<?php echo $this->get_field_id('count'); ?>"> <?php _e('Number of posts to display','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
		</p>
        
        <p class="hades-custom-media"> 
        <label for="<?php echo $this->get_field_id('excerpt'); ?>"> <?php _e('Enter excerpt Words Limit','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="text" value="<?php echo $excerpt; ?>" />
		</p>
		
           
       
        
        
<?php
		
		 }
	function widget($args, $instance) { 
	global $helper;
	global $more;
	extract($args); 
	$post_type = $instance['post_type'];	
	$post_filter = $instance['post_filter'];
	$excerpt = $instance['excerpt'];	
	$count = esc_attr($instance['count']);
	$title = esc_attr($instance['title']);
		
	echo $before_widget;
	if($title!="")
	echo $before_title." ".$instance['title'].$after_title;
		
		?>

   <ul class="widget-posts clearfix" >
                          
    <?php 
   
    
	if($post_type=="blog") $post_type = "post"; 
    $options = array(
			
			'post_type' => $post_type, 
			'posts_per_page' => $count,
			 'tax_query' =>  array(
							   array(
										'taxonomy' => 'post_format',
										'field' => 'slug',
										'terms' => array('post-format-quote','post-format-aside','post-format-video','post-format-link'),
										'operator' => 'NOT IN'
									)
							)
			);
    if($post_filter=="popular")
	$options["orderby"] = "comment_count";
	else if($post_filter=="recent")
	$options["orderby"] = "date";
	else if($post_filter=="featured")
	$options["tag"] = "featured"; 
	
	
	
	$popPosts = new WP_Query($options);
	
	
	
	
    while ($popPosts->have_posts()) : $popPosts->the_post();  $more = 0; ?>
    
    <li class="clearfix" >
    
     
      <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>
      <div class="image">
      <?php 
            $id = get_post_thumbnail_id();
            $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
            echo $helper->imageDisplay( array( "src" => $ar[0]  , "width" => 65 , "height" => 65 , "link"=> get_permalink() , "lightbox" => false , "imgclass" => "thunder_image" )  ); 
      ?>
      </div><!--image-->
      <?php endif; ?>
    
      <div class="description">
          <h5><a href="<?php the_permalink(); ?>"><?php $this->shortenContent(50,strip_shortcodes( get_the_title() )); ?></a></h5>
         <p class='clearfix'> <?php $this->shortenContent($excerpt,strip_tags(get_the_content())); ?></p>
         
      </div><!--details-->
    </li>
    
    <?php endwhile; ?>
    
    <?php wp_reset_query(); ?>

    </ul>
					
					
		<?php
			echo $after_widget; 
		
		}
		
	function shortenContent($num,$stitle) {
	
	$limit = $num+1;
	if (!strnatcmp(phpversion(),'5.2.10') >= 0) 
	$title = str_split($stitle);
	else
	$title = $this->str_split_php4_utf8($stitle);
	$length = count($title);
	if ($length>=$num) {
	    $title = array_slice( $title, 0, $num);
	    $title = implode("",$title)."...";
	    echo $title;
	  } else {
	    echo  $stitle;
	  }
	}
	
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("SuperPost");'));


/* == Contact Form Widget ======================= */

class ContactForm extends WP_Widget {
	
	function ContactForm() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ContactForm', 'description' => __( 'Create a quick contact form.','h-framework') );

		/* Widget control settings. */
		$control_ops = array( "width"=>200);
		 parent::WP_Widget(false,__( "Create Quick Contact Form" ,'h-framework'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['title']= strip_tags($new_instance['title']); 
			$instance['email']= strip_tags($new_instance['email']); 
			$instance['messsage']= strip_tags($new_instance['messsage']); 
			
			return $instance;
	}
	function form($instance) {
		 
		$title = esc_attr($instance['title']);
		$email = esc_attr($instance['email']);
	
		 ?>
        
       
		<p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        <p> 
        <label for="<?php echo $this->get_field_id('email'); ?>"> <?php _e('Email','h-framework'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" />
		</p>
  
        
     
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$title = esc_attr($instance['title']); 
	$email = $instance['email'];
	
	
	
	
		echo $before_widget; 
		
			if($title!="")
		echo $before_title." ".$instance['title'].$after_title;
		
		if(isset($_POST['qsubmit']))
	   {	
	    	
			$to = $_POST["email"];
			$msg = "Message from ".$_POST["qname"]." email ".$_POST["qemail"]." . Message : ".$_POST["qmsg"];
			
			wp_mail($to, 'Message', ''.$msg ); 
	   }
		?>
        <div class="dynamic_forms clearfix">
           
           
          <form action='<?php echo HURL."/helper/form_request.php" ?>' method='post' class="clearfix">
          <div class="alert alert-success hide clearfix">
          <a class="close" data-dismiss="alert">×</a>
          Message Sent ! 
          </div>
          <span class="ajax-loading-icon"></span>
          
           <div class='clearfix'>
              <input type="text" name="name" class="qname" placeholder="Enter name" />
              </div>
              <div class='clearfix'>
              <input type="text" name="email" class="qemail" placeholder="Enter email" />
             </div>
             <div class='clearfix'>
              <textarea name="qmsg" class="msg" rows="" cols="" placeholder="Message" ></textarea>
             </div>
           <input type='hidden' name='notify_email' value='<?php echo $email; ?>' class='notify_email' />
              <input type="submit" name="qsubmit" value="Send" class="d_submit custom-font" />
          </form>
        </div>
           
         
        
        <?php
		
		
		echo $after_widget; 
		
		}
	
	


	}

add_action('widgets_init', create_function('', 'return
register_widget("ContactForm");'));






class SocialSet extends WP_Widget {
	
	function SocialSet() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'SocialSet', 'description' => __('Creates a list with popular social sites.','h-framework') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::WP_Widget(false,__("SocialSet",'h-framework'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['title']= $new_instance['title']; 
			$instance['google']= $new_instance['google']; 
			$instance['linkedin']= $new_instance['linkedin']; 
			$instance['facebook']= $new_instance['facebook']; 
			$instance['twitter']= $new_instance['twitter']; 
			$instance['rss']= $new_instance['rss']; 
			$instance['dribbble']= $new_instance['dribbble']; 
			$instance['pininterest']= $new_instance['pininterest']; 
			
			
			return $instance;
	}
	function form($instance) {
		 
		$title = esc_attr($instance['title']);
		
		$google = esc_attr($instance['google']);
		$linkedin = esc_attr($instance['linkedin']);
		
		$facebook = esc_attr($instance['facebook']);
		$twitter = esc_attr($instance['twitter']);
		
		$rss = esc_attr($instance['rss']);
		$dribbble = esc_attr($instance['dribbble']);
		$pininterest = esc_attr($instance['pininterest']);
		
			
		?>
    
       
       	 <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'h-framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
        
         <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'google' ); ?>"><?php _e('Enter your Google Profile link:', 'h-framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'google' ); ?>" name="<?php echo $this->get_field_name( 'google' ); ?>" value="<?php echo $instance['google']; ?>" />
		</p>
        
         <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e('Enter your linkedin Profile link:', 'h-framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo $instance['linkedin']; ?>" />
		</p>
        
         <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('Enter your facebook Profile link:', 'h-framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" />
		</p>
        
         <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Enter your twitter Profile link:', 'h-framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" />
		</p>
        
         <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php _e('Enter your Feedburner link:', 'h-framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" value="<?php echo $instance['rss']; ?>" />
		</p>
        
         <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'pininterest' ); ?>"><?php _e('Enter your Pininterest Profile link:', 'h-framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'pininterest' ); ?>" name="<?php echo $this->get_field_name( 'pininterest' ); ?>" value="<?php echo $instance['pininterest']; ?>" />
		</p>
        
        <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'dribbble' ); ?>"><?php _e('Enter your dribbble Profile link:', 'h-framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'dribbble' ); ?>" name="<?php echo $this->get_field_name( 'dribbble' ); ?>" value="<?php echo $instance['dribbble']; ?>" />
		</p>
        
        <?php
 
 
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$title = esc_attr($instance['title']);
	$google = esc_attr($instance['google']);
	$linkedin = esc_attr($instance['linkedin']);
	
	$facebook = esc_attr($instance['facebook']);
	$twitter = esc_attr($instance['twitter']);
	
	$rss = esc_attr($instance['rss']);
	$dribbble = esc_attr($instance['dribbble']);
	$pininterest = esc_attr($instance['pininterest']);
    
	echo $before_widget;
	if($title!="")
		echo $before_title." ".$title .$after_title;
	?>
	
    
    <div class="social-set clearfix">
        <ul class="social-icons clearfix">
        	<?php if($facebook!="") : ?><li><a href="<?php echo $facebook ?>" class="fb" ><span class="def"></span><span class="hov"></span></a></li><?php endif; ?>
            <?php if($twitter!="") : ?><li><a href="<?php echo $twitter ?>" class="twitter" ><span class="def"></span><span class="hov"></span></a></li><?php endif; ?>
            <?php if($google!="") : ?><li><a href="<?php echo $google ?>" class="google" ><span class="def"></span><span class="hov"></span></a><?php endif; ?>
            <?php if($linkedin!="") : ?> <li><a href="<?php echo $linkedin ?>" class="linkedin" ><span class="def"></span><span class="hov"></span></a></li><?php endif; ?>
            <?php if($rss!="") : ?><li><a href="<?php echo $rss ?>" class="rss" ><span class="def"></span><span class="hov"></span></a></li><?php endif; ?>
            <?php if($dribbble!="") : ?><li><a href="<?php echo $dribbble ?>" class="dribbble" ><span class="def"></span><span class="hov"></span></a></li><?php endif; ?>
            <?php if($pininterest!="") : ?> <li><a href="<?php echo $frost ?>"  class="pininterest" ><span class="def"></span><span class="hov"></span></a></li><?php endif; ?>
        </ul>
    </div>
	
	<?php
	
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("SocialSet");'));


?>