<?php 

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );
require_once( PATH.'/hades_framework/helper/HadesUI.php' );
$ui = new HadesUI();

$stylePath =  PATH."/sprites/stylesheets/plain";
$styleUrl = URL."/sprites/stylesheets/plain";

$get_styles = scandir($stylePath);

?>



<div id="visual_plain_panel">

<?php 
/*
 global $wpdb;
 $output = $wpdb->get_results("SELECT option_name,option_value FROM $wpdb->options WHERE option_name like '".SN."%'",ARRAY_A );
 $output = json_encode($output);
 $output = base64_encode($output);	
 echo "<textarea> $output </textarea>"; 
	
*/


$style_input   = array( 
				  "name" => "Style Type",
				  "desc" => "select the layout for blog template.",
				  "id" => $shortname."_style_listener",
				  "type" => "select",
				  "options" => array("Default","Plain Shades"),
				  "std" => "Default"
				   );	

$ui->createHadesSelect( $style_input);	

 ?>
 
<ul class="clearfix">
  
  <?php $i=0; foreach($get_styles as $styles) : if($i>1) {?>
  
  <li class="<?php echo $styles; ?>">
     <a href="<?php echo $styles; ?>">
      <img src="<?php echo $styleUrl."/".$styles."/snapshot.jpg"; ?>" alt="">
      <span><?php echo $styles; ?></span></a>
  </li>
  
  <?php } $i++; endforeach; ?>
  <input type="hidden" name="<?php echo SN; ?>_plain_theme" id="hades_plain_theme" value="<?php echo get_option(SN.'_plain_theme'); ?>" />
</ul>

</div>