<?php

class OptionsPanel extends Loki {
	
	// init menu
	function __construct () { parent::__construct('Options Panel','page','hades');  }
	
	// setup things before page loads
	function manager_admin_init(){	  parent::manager_admin_init();
	  global $themename, $shortname, $options , $super_options;
	   if(isset($_GET['page']) && $_GET['page']=='hades') :
	   
	   if (  isset($_GET['activation']))
		{
			
			
			foreach ($options as $value) 
			{
				if(!get_option($value['id']))
				update_option( $value['id'],  $value['std']  );
			}
				
			$appendable = '&activated=true';
			header("Location: admin.php?page=hades&saved=true{$appendable}#starter");
			die;
		}
	   
	   
	   if ( isset($_GET['page']) &&  $_GET['page'] == "hades" ) {
 		if ( isset($_REQUEST['action']) &&  'save' == $_REQUEST['action'] ) {
 			
			foreach ($options as $value) 
			update_option( $value['id'], $_REQUEST[ $value['id'] ] );
			
 			foreach ($options as $value) {
		
				if( isset( $_REQUEST[ $value['id'] ] ) ) { 
				update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); 
				} 
				else {				
				 delete_option( $value['id'] );
				}
			
		 }
 		header("Location: admin.php?page=hades&saved=true");
		die;
 	} 
	
	}
	   
	   
	   
	   wp_enqueue_script('jquery-ui-tabs');
	   wp_enqueue_script('jquery-ui-accordion');
	   wp_enqueue_script('jquery-ui-resizable',array('jquery','jquery-ui-core','jquery-ui-widget'), "1.0");
	  
	   wp_enqueue_script("hadesscript", HURL."/js/hades_script.js", array('jquery','jquery-ui-tabs','jquery-ui-slider'), "1.0");
	   wp_enqueue_script("admin-colorpicker",HURL."/js/colorpicker.js",array('jquery'),"1.0");
	   
	   wp_enqueue_style("themeoptions-css", HURL."/css/hades.css", false, "1.0", "all");
	  
	   
	   
	 
	   endif;
	
	 }	
	
	// the markup
	
	function manager_admin_wrap(){	
	global $themename, $shortname, $options , $super_options;
	?>
    

    
    <div class="hades_panel_wrap"> <!-- Panel Wrapper -->
		
         <div class="cbox success">
          <div class="cbox-head">yippie, you did it </div>
          <div class="cbox-body">
                <p> Theme Settings Saved !</p>
              
          </div>
        </div>
      
        
		<div class="hades_panel_head clearfix"> <!-- Panel Head -->
            
              <input type="hidden" value="<?php echo HURL."/helper/ajax.php" ?>" id="option_path" />
        </div> <!-- END of Panel Head -->
      
        
        <div class="hades_wrap clearfix">  <!-- Panel -->
        	<div id="option-panel-tabs" data-shortname="<?php echo SN; ?>">  <!-- Options Panel -->
        
                <ul id="themenav" class="clearfix">  <!-- Side Menu -->
                 
				<?php
                
                foreach ($options as $value)
                {
               	 if($value['type']=="section") { ?>
               		 <li>
             		   <a href="#<?php echo str_replace(" ","",$value['name']); ?>" id="menu_<?php echo str_replace(" ","",$value['name']); ?>"> 
             		  		 <?php echo $value['name']; ?>
             		   </a>
             		 </li>
                <?php  }  
                }
                ?>
                  <li>
             		   <a href="#starter" id="menu_starter"> 
             		  		Documentation
             		   </a>
                  </li>   
                </ul>  <!-- End of Side Menu -->
       			
                
                <div id="panel-wrapper" class="clearfix">
                
                <form method="post"  enctype="multipart/form-data" action="" class="clearfix" id="hades_option_form" >
                
                  <div class='hades_section' id="starter"> 
                  	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>How does this work? </a> </h3> 
                            <div class='hades_subpanel'>  
                            
                            <div class="information">
                            
                            
                            <h2>Welcome</h2>
                            
                            <?php if(isset($_GET['activated'])) : ?>

<div class="success_message show"><p> Welcome to <?php echo $themename; ?>, if you have a fresh install goto <a href="<?php echo get_admin_url()."admin.php?page=visual_import";?>"> Installer</a> located in side menu last menu item and set up site in matter of minutes. If you have already content present, be sure to read the docs and enjoy the theme. </p>  </div>		

<?php endif;?>

                            <p> If you have any questions that are beyond the scope of this help file, please feel free to visit<a href='http://wptitans.com/forum/'> our Support Forums </a>  and we will be more than willing to guide you through. Also when you've found a bug or any sort of issue, visiting the Support Forums is the fastest way to receive support. Thanks so much!
</p>
                           
                             <p> <a href="http://wptitans.com/doc/egestas/index.html" id="tour" target="_blank" class="button-default help-doc"> Read Documentation  </a>  </p> 
                            
                              
                            </div>
                           
                            </div>  
                        </div> 
                     </div> 
                  </div>
                  
                <?php 
               		 $newoptions  = $options; // php 4.4 fix
                	 $sidemenu_Flag = true; $description = '';
              	     foreach ($newoptions as $value) {
              
			  		 switch ( $value['type'] ) {
               			   
			   			 case "open":?> <?php $sidemenu_Flag = true;                 break; 
                		 case "close": $description = ''; ?> </div></div></div> <?php break;
						 case 'include' : include($value['std']); break;		 
                		 case 'custom' : echo ($value['std']);   break;	
                         case 'text': ?>
                
               						 <div class="hades_input clearfix  ">
               							 <label for="<?php echo $value['id']; ?>"><?php echo $value['name'] ; ?></label>
              							 <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( $super_options[$value['id']] != "") { echo stripslashes($super_options[$value['id']]  ); } else { echo $value['std']; } ?>" />
  
                						  <?php if($value['desc']!="") echo " <div class=\"description\"> ". $value['desc']."</div>"; ?>
                
                
                					 </div> <?php break;
                
					 
                		case 'upload' : ?>
                                      
                                      <div class="hades_input hades_image_upload clearfix "> 
                                      <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                                      
                                      <div class="upload_wrapper clearfix">
                                      		<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( $super_options[$value['id']] != "") { echo stripslashes($super_options[$value['id']]  ); } else { echo $value['std']; } ?>" class="panel_upload" />
                                      		<a href="#" class="image_upload button-default" title="">Upload Image</a>
                                      </div>
                                      
                                     <?php if($value['desc']!="") echo " <div class=\"description\"> ".  $value['desc']."</div>"; ?>
                                    <div class="clearfix"></div>
                                    <div class="clearfix image-panel">
                                    <img src="<?php if ( $super_options[$value['id']] != "") { echo stripslashes($super_options[$value['id']]  ); } else { echo $value['std']; } ?>" alt="<?php echo $value['name']; ?>" />
                                    
                                    </div>
                                    
                                      </div>   <?php break;		 
                
				
						case 'colorpickerfield' : ?>
                        
                                      <div class="hades_input clearfix  ">
                                          <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                                          <div class="colorSelector" ><div style="background-color:#<?php if ( $super_options[$value['id']] != "") { echo stripslashes($super_options[$value['id']]  ); } else { echo $value['std']; } ?>"></div></div>
                                          <input type="text"  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="colorpickerField1 width-small" value="<?php if ( $super_options[$value['id']] != "") { echo stripslashes($super_options[$value['id']]  ); } else { echo $value['std']; } ?>" />
                                      
                                          <?php if($value['desc']!="") echo " <div class=\"description\"> ". $value['desc'] ."</div>"; ?>
                                      </div>	<?php break;	
							 
               		   case 'slider': ?>
               
                                    <div class="hades_input clearfix  ">
                                 		 <label for="<?php echo $value['id']; ?>"><?php echo  $value['name'] ; ?></label>
                                		 <div class="hades_slider" ></div>
                                  
                                  		 <input type="hidden" class="slider-val"  value="<?php if ( $super_options[$value['id']] != "") { echo stripslashes($super_options[$value['id']]  ); } else { echo $value['std']; } ?>" />
                                  		 <input type="hidden" class="max-slider-val"  value="<?php if($value["max"]=="") echo 500; else echo $value["max"]; ?>" />
                                  		 <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( $super_options[$value['id']] != "") { echo stripslashes($super_options[$value['id']]  ); } else { echo $value['std']; } ?>"class='slider-text' /><h6 class="slider-suffix"><?php if(isset( $value['suffix'])) echo $value['suffix']; ?></h6>
                                		<?php if($value['desc']!="") echo " <div class=\"description\"> ".  $value['desc'] ."</div>"; ?>
                                  </div>  <?php break;
                
					  case 'textarea': ?>
								  <div class="hades_input clearfix  ">
									   <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					 				   <textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( $super_options[$value['id']] != "") { echo stripslashes($super_options[$value['id']] ); } else { echo $value['std']; } ?></textarea>
					   				   <?php if($value['desc']!="") echo " <div class=\"description\"> ".$value['desc']."</div>"; ?>
					  			  </div>  <?php break;
                
					  case 'select': ?>
                      
                                  <div class="hades_input clearfix   ">
                                	  <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                                  	  <div class="select-wrapper clearfix">
                                		  <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
												<?php foreach ($value['options'] as $key => $option) { ?>
                                                <option <?php $value['keyed'] = false;
                                                $tester = $option;
                                                if($value['keyed']) $tester = $key; 
                                                if (!$super_options[$value['id']]) {  if ( $value['std'] == $option)  echo 'selected="selected"'; }
                                                else if ($super_options[$value['id']] == $tester) { echo 'selected="selected"'; }
                                                
                                                if($value['keyed']) echo "value = '$key' ";  
                                                ?>
                                                ><?php echo $option; ?></option><?php } ?>
                                 		 </select>
                                  	 </div>
                                    <?php if($value['desc']!="") echo " <div class=\"description\"> ". $value['desc']."</div>"; ?>
                                 </div> <?php break;
                
				  
					  case "radio": ?>
                                <div class="hades_input clearfix   ">
                                
                                <label for="<?php echo $value['id']; ?>"><?php echo  $value['name']; ?></label>
                                
                                <div class="check-group">
                               		 <?php $temp = 0; foreach ($value['options'] as $option) {  $checked = ""; ?>
                               		 <p class='clearfix'>
                                	 <label for="<?php echo $value['id'].$temp; ?>"><?php echo $option; ?></label>
                                
                                	<?php
                             		  if(!$super_options[$value['id']]) { if(($value['std'])==$option){ $checked = "checked=\"checked\""; } }
                                	  else if($super_options[$value['id']]==$option){ $checked = "checked=\"checked\""; } else{ $checked = "";} ?>
                                
                                		<input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'].$temp++; ?>" value="<?php echo $option ?>" <?php echo $checked; ?> />   
                               		 </p>             
                                		<?php } ?>
                                </div>
                                
                                <?php if($value['desc']!="") echo " <div class=\"description\"> ".  $value['desc'] ."</div>"; ?>
                                </div>   <?php break; 
               
			   
					case "toggle": ?>
                              <div class="hades_input clearfix   ">
                              <label><?php echo $value['name']; 
                              if($super_options[$value['id']]!="")
                              { $checker = $super_options[$value['id']]; }
                              else
                              { $checker = $value['std'];  }
                              ?></label>
                              
                              <div class="radio">
                             	 <input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>1"  
                             	 <?php  if($checker=="true") echo "checked=\"checked\""; ?> value="true" /><label for="<?php echo $value['id']; ?>1">ON</label>
                             	 <input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>2" 
                             	 <?php  if($checker=="false") echo "checked=\"checked\""; ?>  value="false"/><label for="<?php echo $value['id']; ?>2">OFF</label>
                              </div>
                              <?php if($value['desc']!="") echo " <div class=\"description\"> ". $value['desc']."</div>"; ?>
							  </div> <?php break; 
                
                
                case "section":  ?>
              	  <div class="hades_section" id="<?php echo str_replace(" ","",$value['name']); $section_name = str_replace(" ","",$value['name']); ?>" ><!-- Start of the section  -->
                  <div class="hades_options"> <!-- Start of hades option  --> <?php break;
               
			    case "information" : echo "<div class='subpanel clearfix'>"; 
                $description = " <div class=\"hades_information\"><a href='#' class='info-icon'></a><p> ".$value["description"]."</p></div>"; ?>
                
                <?php
                break; 
                case "subtitle" : 		 
               		 echo '<h3 class="subtitle-heading"><a href="#panel">'.$value['name'].'</a></h3>';
               		 echo "<div class='hades_subpanel'  > "; 
                
				break;
                case "close_subtitle" :$sidemenu_Flag = false; ?> 
                
                <span class="top-panel clearfix">
               		 <input name="save" type="submit" value="Save changes" class="button-save" />  
               		   <span class="ajax_icon"></span>
                </span> 
                
                <?php echo "</div>"; break;					
               	 }
                }
                ?>
               		 <input type="hidden" name="action" value="save" />
                     <input type="hidden" name="verfication" id="verficiation" value="<?php echo md5(THEMENAME); ?>" />
               
                </form>
                <form method="post" class="reset-form">
                	<input type="hidden" name="action" value="reset" />
                </form>
                
                </div>
       
        
   	    	</div>  <!-- End of Options Panel -->
        </div>  <!-- End of Panel -->
         
         
         
	</div> <!-- End of Panel Wrapper -->
		
        
        
    
	
	<?php
	  
	   }	  
	  
}

$options_panel = new OptionsPanel();