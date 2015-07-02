<?php 

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );

?>
<div class="hades_input">

<label for=""> Select Default Post Layout </label>

<ul class="post-layout clearfix">
  <li class="full-width"><a href="#"></a></li>
  <li class="hasLeftSidebar"><a href="#"></a></li>
  <li class="hasRightSidebar"><a href="#"></a></li>

</ul>
<input type="hidden" name="<?php echo SN;?>_post_layout" id="<?php echo SN;?>_post_layout" value="<?php echo get_option(SN."_post_layout"); ?>" />
</div>


<div class="hades_input">

<label for=""> Select Default Page Layout </label>

<ul class="page-layout clearfix">
  <li class="full-width"><a href="#"></a></li>
  <li class="hasLeftSidebar"><a href="#"></a></li>
  <li class="hasRightSidebar"><a href="#"></a></li>

</ul>
<input type="hidden" name="<?php echo SN;?>_page_layout" id="<?php echo SN;?>_page_layout" value="<?php echo get_option(SN."_page_layout"); ?>" />
</div>

