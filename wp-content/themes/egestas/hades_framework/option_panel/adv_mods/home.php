<?php

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );

add_action( 'init', 'my_plugin_init' );
function my_plugin_init() {
		wp_enqueue_script( 'word-count' );
		wp_enqueue_script('post');
		wp_enqueue_script('editor-functions');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('tiny_mce');
		
		if ( user_can_richedit() )
			wp_enqueue_script('editor');
		add_thickbox();
		wp_enqueue_script('media-upload');
}

$SN = get_option("SN");
?>

<div class="home-editor-wrapper clearfix">
<div id="postdivrich" class="postarea clearfix">
			<?php wp_editor(stripslashes(get_option('hades_home_text')), $id = 'content', $prev_id = 'title', $media_buttons = true, $tab_index = 2); ?>
</div>

<input type="hidden" value="" name="hades_home_text" id="hades_home_text" />
<p><em>Populate this editor only when you've deactivated all content sections. html and shortcocdes are acceptable, this section works just the same as the normal way of editing and writing.</em></p>
</div>

