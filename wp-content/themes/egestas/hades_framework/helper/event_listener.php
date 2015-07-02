<?php


$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];

require_once( $wp_url.'/wp-load.php' );

$key = $_POST['key'];
$values = $_POST['values'];

$us_k = str_replace(" ","_",trim($key));
$visual_matrix = get_option(SN.'_visual_matrix');

if(!is_array($visual_matrix)) $visual_matrix = array();

if($values=="retrieve")
{
	if (array_key_exists($us_k, $visual_matrix)) {
	 echo stripslashes(json_encode($visual_matrix[$us_k]));
 }
	else
	echo 'First Time';
	return;
}

if($values=="release") 
{
	if (array_key_exists($us_k, $visual_matrix)) {
	
	  unset($visual_matrix[$us_k]);
 	  echo update_option(SN.'_visual_matrix',$visual_matrix);
 
	}
	
	return;
}



if(!is_array($visual_matrix)) $visual_matrix = array();
if (array_key_exists($us_k, $visual_matrix)) {
	
  $visual_matrix[$us_k] = array( "dom_path" => $key , "props" => $values  );
  echo update_option(SN.'_visual_matrix',$visual_matrix);
 
}
else
{
	 $visual_matrix[$us_k] = array( "dom_path" => $key , "props" => $values  );
	echo update_option(SN.'_visual_matrix',$visual_matrix);
	

}

 