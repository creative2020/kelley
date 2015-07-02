<?php 
// == ~~ To use native variables global is required ================================
global $super_options,$helper ;        
?>



<div id="footer"  class="thunder_listener" data-filter="bg bgi bgp bgr" data-link-filter="cr crh" data-list-filter="bbr cr" data-text-filter="cr" data-headings-filter="cr bbr">
  <div class="inner-footer-wrapper">
   <div  class=" clearfix skeleton ">
   <?php  if($super_options[SN."_footer_widgets"]=="Yes") : ?>
    
    <div class="mobile_footer_widget">
      <?php 
	   echo '<div class="footer-cols  clearfix">';
		    dynamic_sidebar ("Footer Mobile"); 
       echo "</div>";
	  ?>
    </div>
      
     
     <?php 
	  $footer_layout = $super_options[SN."_footer_layout"];
	  switch($footer_layout)
	  {
	  case "two-col" : 
	  
					  echo '<div class="footer-cols  layout_element one_half clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  layout_element one_half_last clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>"; 
	  
	  break;
	  case "three-col" : 
	  
					  echo '<div class="footer-cols  layout_element one_third clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  layout_element one_third clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  layout_element one_third_last clearfix">';
					    dynamic_sidebar ("Footer Column 3"); 
					  echo "</div>"; 
	  
	  break;
	 case "four-col" : 
	 					
	  
					  echo '<div class="footer-cols  layout_element one_fourth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  layout_element one_fourth clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  layout_element one_fourth clearfix">';
					    dynamic_sidebar ("Footer Column 3"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  layout_element one_fourth_last clearfix">';
					    dynamic_sidebar ("Footer Column 4"); 
					  echo "</div>"; 
	  
	  break;
	  case "five-col" : 
	  
					  echo '<div class="footer-cols  layout_element one_fifth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  layout_element one_fifth clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  layout_element one_fifth clearfix">';
					    dynamic_sidebar ("Footer Column 3"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  layout_element one_fifth clearfix">';
					    dynamic_sidebar ("Footer Column 4"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  layout_element one_fifth_last clearfix">';
					    dynamic_sidebar ("Footer Column 5"); 
					  echo "</div>"; 
	  
	  break;
	  case "six-col" : 
	  
					  echo '<div class="footer-cols  layout_element one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  layout_element one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  layout_element one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 3"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  layout_element one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 4"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  layout_element one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 5"); 
					  echo "</div>";
					  
					  echo '<div class="footer-cols  layout_element one_sixth_last clearfix">';
					    dynamic_sidebar ("Footer Column 6"); 
					  echo "</div>"; 
	  
	  break;
	  
	  case "one-third" : 
	  
					  echo '<div class="footer-cols  layout_element one_third clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  layout_element two_third_last clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>"; 
	  
	  break;
	  case "one-fourth" : 
	  
					  echo '<div class="footer-cols  layout_element one_fourth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  layout_element three_fourth_last clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>"; 
	  
	  break;
	  case "one-fifth" : 
	  
					  echo '<div class="footer-cols  layout_element one_fifth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols layout_element four_fifth_last clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>"; 
	  
	   break;
	   case "one-sixth" : 
	  
					  echo '<div class="footer-cols  layout_element one_sixth clearfix">';
					    dynamic_sidebar ("Footer Column 1"); 
					  echo "</div>";
					 
					  echo '<div class="footer-cols  layout_element five_sixth_last clearfix">';
					    dynamic_sidebar ("Footer Column 2"); 
					  echo "</div>"; 
	  
	  break;
	 
	  
	  }
	 ?>
     
   
     <?php endif; ?>
     </div>
   </div>
   
   <div id="footer-menu"  class="thunder_listener" data-filter="bg" data-text-filter="cr" data-link-filter="cr crh" data-list-filter="lbr">
    <div  class=" clearfix skeleton  " >
   
             <p class="footer-text"><?php echo $helper->format($super_options[SN."_footer_text"],false,false,false); ?></p> 
             
             <?php  if( $super_options[SN."_footer_menu"]=="Yes") : 
                      if(function_exists("wp_nav_menu"))
                      {
                          wp_nav_menu(array(
                                      'theme_location'=>'footer_nav',
                                      'container'=>'ul',
                                      'depth' => 1,
									  'fallback_cb' => false
                                      )
                                      );
                      }
					  endif;
               ?>
      </div>  
   </div>
</div>



<?php  wp_footer();  ?>

<?php if($super_options[SN."_is_boxable"]!="false" && $super_options[SN."_is_boxable"]!="") echo '</div>' ; ?>

</div> </div><!-- End of SUPER WRAPPER -->
<script type="text/javascript">
<?php 
echo stripslashes($super_options[SN."_tracking_code"]);
?>
</script>
</body>
</html>
