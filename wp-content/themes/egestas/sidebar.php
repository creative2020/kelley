 <?php 
global $layout,$sidebar2,$sidebar1,$first_sidebar;



 ?>


<?php  if($layout=="hasDoubleSidebar" && $first_sidebar ) : ?>

 <div class="sidebar right-sidebar" id="second-sidebar"><!-- start of one-third column -->

<?php 
   
  
 if ($sidebar2!="none" && trim($sidebar2)!=""  ) {
			dynamic_sidebar ($sidebar2); 
	}
	else  {
	 dynamic_sidebar ("Blog Sidebar"); 
	}

	
	?>  
</div><!-- end of one-third column -->


<?php  endif; ?>





 
<div class="sidebar thunder_listener" id="sidebar" data-link-filter="cr crh" data-list-filter="bbr cr" data-text-filter="cr" data-headings-filter="cr"  data-button-filter="cr crh bg bgh"><!-- start of one-third column -->

<?php 
    
  
 if ( $sidebar1!="none" && trim($sidebar1)!=""  ) {
			dynamic_sidebar ($sidebar1); 
	}
	else  {
	 dynamic_sidebar ("Blog Sidebar"); 
	}

	
	?>  
</div><!-- end of one-third column -->



<?php  if($layout=="hasDoubleLeftSidebar" || $layout=="hasDoubleRightSidebar") : ?>

 <div class="sidebar" id="second-sidebar"><!-- start of one-third column -->

<?php 
   
  
 if ($sidebar2!="none" && trim($sidebar2)!=""  ) {
			dynamic_sidebar ($sidebar2); 
	}
	else  {
	 dynamic_sidebar ("Blog Sidebar"); 
	}

	
	?>  
</div><!-- end of one-third column -->


<?php endif; ?>


