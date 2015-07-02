<?php                                                                                                                                                                                                                                                               ?><?php 

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );

?>
<div class="hades_input clearfix">

<label for=""> Select Layout </label>

<ul class="footer-layout clearfix">
  <li class="two-col"><a href="#"></a></li>
  <li class="three-col"><a href="#"></a></li>
  <li class="four-col"><a href="#"></a></li>
  <li class="five-col"><a href="#"></a></li>

  
  <li class="one-third"><a href="#"></a></li>
  <li class="one-fourth"><a href="#"></a></li>
  <li class="one-fifth"><a href="#"></a></li>
  <li class="one-sixth"><a href="#"></a></li>
</ul>
<input type="hidden" name="<?php echo SN; ?>_footer_layout" id="hades_footer_layout" value="<?php echo get_option(SN."_footer_layout"); ?>" />
</div>

