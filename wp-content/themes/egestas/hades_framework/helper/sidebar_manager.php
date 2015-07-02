<?php

/* =================================================================== */
/* == Sidebar Manager ================================================ */
/* =================================================================== */

/*

Author - Abhin Sharma ( WPTitans )

*/



add_action('admin_init', 'sidebarmanager_add_init');
add_action('admin_menu', 'sidebarmanager_add_admin');

function sidebarmanager_add_admin() {
	 	add_submenu_page("hades","Sidebar Manager","Sidebar Manager", 'administrator',"sidebar_manager", 'sidebarmanager_admin');
}



function sidebarmanager_add_init() { 
    
	
  
	if(isset($_GET['page'])&&($_GET['page']=='sidebar_manager')){	
	wp_enqueue_script('jquery-ui-sortable');
	 wp_enqueue_script('jquery-ui-tabs');
	}
	


}



function sidebarmanager_admin() {
	  
	  if(!$_GET['page']=='sidebar_manager')
      return;
	  
	  if(isset($_POST["action"])&&$_GET['page']=="sidebar_manager")
	  {
		  $abars =  $_POST["active_sidebars"];
		      
	  	  update_option(SN."_active_sidebars", $abars);
		 
	  }
	 
	  $active_sidebars = get_option(SN."_active_sidebars");
	
	   
	  if(!is_array($active_sidebars))	  $active_sidebars = array();
	
	  
	  ?>
      
       <script type="text/javascript">
    jQuery(function($){
	$(".sidebarmanager .active-sidebars").sortable({ placeholder:'sidebar-holder' });

	
	$(".add-sidebar-button").click(function(e){
		e.preventDefault();
		if(jQuery.trim($("#sidebar_name").val())=="")
		return;
		
		 $(".active-sidebars").append(" <li><span>"+$("#sidebar_name").val()+"</span><input type=\"hidden\" value=\""+$("#sidebar_name").val()+"\" name=\"active_sidebars[]\" /> <a href=\"#\" class=\"delete\"></a></li>");
		 $("#sidebar_name").val("")
		});
	
		var tabs = $( "#option-panel-tabs" ).tabs({
		
		
		add: function( event, ui ) {
			
		   $( ui.panel ).addClass('hades_section').append( $('.tab-clone').children().append() );
		 
		   $( ui.panel ).find('.slider_title').val($(ui.tab).find('span').html());
		   
		   
		   
		   $("#hades_option_form").append($( ui.panel ));
		}
		});	
		
		$('.delete').live('click',function(){$(this).parent().fadeOut('fast',function(){ $(this).remove(); });  });
		
		});
    
		
		
    </script>
    
      <div class="hades_panel_wrap"> <!-- Panel Wrapper -->
		
         <div class="cbox success">
          <div class="cbox-head">yippie, you did it </div>
          <div class="cbox-body">
                <p> Slider Settings Saved !</p>
              
          </div>
        </div>
      
        <?php  if(isset($_POST["action"])) echo '<div class="alert show"><p><strong>Saved.</strong></p></div>'; ?>
        
        
		<div class="hades_panel_head clearfix"> <!-- Panel Head -->
            <span class="tab-loading-icon"></span>
             
        </div> <!-- END of Panel Head -->
      
        
        <div class="hades_wrap slider-manager clearfix">  <!-- Panel -->
        	<div id="option-panel-tabs" class="clearfix">  <!-- Options Panel -->
        
                <ul id="themenav" class="clearfix">  <!-- Side Menu -->
                    <li><a href="#starter"> Sidebar Manager </a></li>
                </ul>  <!-- End of Side Menu -->
       			
                
                <div id="panel-wrapper" class="clearfix">
                 
                <form method="post"  enctype="multipart/form-data" action="" class="clearfix" id="hades_option_form" >
                
                  
                  <div class='hades_section' id="starter"> 
                  	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Add Sidebars  </a> </h3> 
                            <div class='hades_subpanel'>  
                              
                              
                              <div class="sidebarmanager clearfix" >
    
                              <div id="side-panel-wrapper" class="clearfix">
                            
                             
                              
                              <div class="upload-area clearfix hades_input"> 
                              <label for="file_upload">Add Sidebar</label>
                              <input id="sidebar_name" name="sidebar_name" type="text" />
                              <a href='' class="add-sidebar-button button-default"> Add Sidebar </a>
                               <input name="save" type="submit" value="Save changes" class="button-save" />  
                              </div>
                              
                              <div class="manage-sidebars clearfix">
                              
                              <div class="active-wrapper clearfix">
                              <h4> Sidebars</h4> 
                              <ul class="active-sidebars">
                              <?php foreach($active_sidebars as $bars) : 
                              
                              echo "<li><a href='#' class='delete' /></a><input type='hidden' name='active_sidebars[]' value='".$bars."'/> <span> ".$bars." </span> </li>";
                              
                              endforeach; ?>
                              </ul>
                              </div>
                               </div>
                              <input type="hidden" value="save" name="action" />
                              
                              </div></div>
                              
                            </div>  
                        </div> 
                     </div> 
                  </div>
                  
                
                
               
                </form>
               </div>
                
               
       

        
   	    	</div>  <!-- End of Options Panel -->
        </div>  <!-- End of Panel -->
         
         
         
	</div> <!-- End of Panel Wrapper -->
		
  
	  
      
	  <?php
	
	
	 }