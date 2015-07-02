<?php


$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];

require_once( $wp_url.'/wp-load.php' );
$type = $_POST["type"];  

if($type=="vote")
{

	
	$y = (int)get_post_meta($_POST['id'],'_vote_yes',true);
	$y++;
	update_post_meta($_POST['id'],'_vote_yes',$y);
	
	
	echo $y;
	return;
}