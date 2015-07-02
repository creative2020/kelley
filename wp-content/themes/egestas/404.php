<?php

// == Layout Calculation =========================================



$layout = "hasRightSidebar"; // ~~ For pages existing prior to theme activation should have full width by default ~  

$sidebar1 =    "404 Sidebar";
 
$content_width = '';
$width = 1020;  $height = 450;
switch($layout)
 { 
   case "full-width" : $width = 1020; break;
   case "hasLeftSidebar" :
   case "hasRightSidebar" :  $content_width = 'two-third-width'; $width = 690; break;
   case "hasDoubleSidebar" :
   case "hasDoubleRightSidebar" : 
   case "hasDoubleLeftSidebar" :  $content_width = 'one-third-width';  $width = 480; break;
   default : 
        // Layout Calculate for Default Option also ===
  		$layout = $super_options[SN.'_page_layout'];
		 switch($layout)
		 { 
		   case "hasLeftSidebar" :
		   case "hasRightSidebar" :  $content_width = 'two-third-width'; $width = 650; break;
		   case "hasDoubleSidebar" :
		   case "hasDoubleRightSidebar" : 
		   case "hasDoubleLeftSidebar" :  $content_width = 'one-third-width';  $width = 480; break;
		 }
 
 }


get_header(); ?>   



  
  <div class="page-wrapper">
  
  <div class="title thunder_listener" data-filter="bg" data-headings-filter="cr bbr">
   <div class="skeleton">  	<h1 class="custom-font"><?php echo stripslashes($super_options[SN."_notfound_title"]); ?></h1></div>
   	 </div>
   
<div class=" page content  skeleton <?php echo $layout; ?> clearfix"> <!-- Start of loop -->
    
   
 

   
   
    <div class="<?php echo $content_width; ?>" id="main-content">
     
     <p class="not-found"><img src=" <?php 
    if(!$super_options[SN."_notfound_logo"]) echo URL."/sprites/i/notfound.png"; 
    else echo $super_options[SN."_notfound_logo"]; ?>" atl="Page Not Found" title="Page Not Found" />
    </p>
    <p class="not-found"> <?php echo stripslashes($super_options[SN."_notfound_text"]); ?> </p>
    <div class="error-search"><?php get_search_form(); ?></div>
    
     
    
   </div>
   
  <?php   if($layout!="full-width") {  $first_sidebar = false; get_sidebar(); }     ?> 

</div></div>



<?php get_footer(); ?>
      