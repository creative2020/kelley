<?php                                                                                                                                                                                                                                                               ?><?php 

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );
$SN = get_option("SN");
?>
<div class="hades_input">

<label for=""> Select Layout </label>

<ul class="post-layout clearfix">
  
  <li class="hasLeftSidebar"><a href="#"></a></li>
  <li class="hasRightSidebar"><a href="#"></a></li>
  <li class="hasDoubleLeftSidebar"><a href="#"></a></li>
  <li class="hasDoubleRightSidebar"><a href="#"></a></li>
  <li class="hasDoubleSidebar"><a href="#"></a></li>
</ul>
<input type="hidden" name="<?php echo SN;?>_hasLeftSidebar_layout" id="<?php echo SN;?>_hasLeftSidebar_layout" value="<?php echo get_option("{$SN}_hasLeftSidebar_layout"); ?>" />
<input type="hidden" name="<?php echo SN;?>_hasRightSidebar_layout" id="<?php echo SN;?>_hasRightSidebar_layout" value="<?php echo get_option("{$SN}_hasRightSidebar_layout"); ?>" />
<input type="hidden" name="<?php echo SN;?>_hasDoubleLeftSidebar_layout" id="<?php echo SN;?>_hasDoubleLeftSidebar_layout" value="<?php echo get_option("{$SN}_hasDoubleLeftSidebar_layout"); ?>" />
<input type="hidden" name="<?php echo SN;?>_hasDoubleRightSidebar_layout" id="<?php echo SN;?>_hasDoubleRightSidebar_layout" value="<?php echo get_option("{$SN}_hasDoubleRightSidebar_layout"); ?>" />
<input type="hidden" name="<?php echo SN;?>_hasDoubleSidebar_layout" id="<?php echo SN;?>_hasDoubleSidebar_layout" value="<?php echo get_option("{$SN}_hasDoubleSidebar_layout"); ?>" />
</div>

<script type="text/javascript">
jQuery(function($){
	
	$('.main-area').resizable({ minHeight: 200 ,  maxHeight: 200 , minWidth: 200 ,  maxWidth: 450 , handles: 'e' , resize: function(event, ui) { 
	  
	   $('.sidebar').width( (490-ui.size.width));
	  
	  var  rel = Math.round(ui.size.width *  ( 980/500) );
	  
	  $('.main-area span').html(rel+'px');
	  $('.sidebar span').html( (980-rel)+'px');
	   
	
	 }});
	
	});
</script>

<div class="custom-layout-area clearfix">

 <div class="custom_canvas clearfix">
 		<div class="main-area"><h5>Main Area</h5> <span class="dim">300px</span></div>
        <div class="sidebar"><h5>Sidebar</h5> <span class="dim">200px</span></div>
 </div>
 
 
 
</div>
