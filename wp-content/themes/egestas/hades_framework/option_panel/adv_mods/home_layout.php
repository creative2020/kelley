<?php 

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );
$SN = get_option("SN");
?>
<div class="hades_input">

<label for=""> Select Layout </label>

<ul class="home-layout clearfix">
  <li class="full-width"><a href="#"></a></li>
  <li class="hasLeftSidebar"><a href="#"></a></li>
  <li class="hasRightSidebar"><a href="#"></a></li>
</ul>
<input type="hidden" name="<?php echo SN;?>_home_layout" id="<?php echo SN;?>_home_layout" value="<?php echo get_option("{$SN}_home_layout"); ?>" />
<p><em>When you change the layout option here, you need to make sure that the all Content Sections are <strong>disabled</strong>. Then just populate a <a href="<?php echo admin_url(); ?>/widgets.php">sidebar</a> with the widgets you want to show and select it at <strong>Home Sidebar</strong>.The content on the left or right will be added through the WYSIWYG editor down below</em></p>
</div>


