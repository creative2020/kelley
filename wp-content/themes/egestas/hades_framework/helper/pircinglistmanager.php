<?php

class PricingListManager extends Loki {
	
	// init menu
	function __construct () { parent::__construct('Pricing Tables List','submenu','PLIST');  }
	
	// setup things before page loads
	function manager_admin_init(){	  parent::manager_admin_init();
	     if(isset($_GET['page']) && $_GET['page']=='PLIST') :
	   
	   
	  	global $wpdb;
	$table_db_name = $wpdb->prefix . "megatables";
	$flag = false;
	
	 if(isset($_POST["action"])&&$_POST["action"]=="edit"&&$_POST["type"]=="megatable")
		{
		 $edit_id = $_POST["edit_table_id"];  
		 header("Location: admin.php?page=PRICI&edit_id=$edit_id");
		 die;
		}
	
	
  	if(isset($_POST["action"])&&$_POST["action"]=="delete")
		{
	 	 $delete_id = $_POST["delete_table_id"];
	  	 $flag = $wpdb->query("DELETE FROM $table_db_name WHERE id='$delete_id' ");
		}
		  
	   wp_enqueue_script('jquery-ui-tabs');
	   wp_enqueue_script('jquery-ui-accordion');
	 //  wp_enqueue_script("admin-colorpicker",HURL."/js/colorpicker.js",array('jquery'),"1.0");
	   
	   endif;
	
	 }	
	
	// the markup
	
	function manager_admin_wrap(){	
	global $wpdb;
	$table_db_name = $wpdb->prefix . "megatables";
	$tables = $wpdb->get_results("SELECT id,table_name FROM $table_db_name ",ARRAY_A);
	
	
	?>
	
    <script type="text/javascript">
    
jQuery(document).ready(function($){
	
	var temp,i,j,obj;
	
	
	/*
	$( ".subpanel" ).accordion({
			autoHeight: false,
			navigation: true,
            collapsible: true
		});	 */
		
	var tabs = $( "#option-panel-tabs" ).tabs({
		
		
		add: function( event, ui ) {
			
		   $( ui.panel ).addClass('hades_section').append( $('.tab-clone').children().append() );
		 
		   $( ui.panel ).find('.slider_title').val($(ui.tab).find('span').html());
		   
		   
		   
		   $("#hades_option_form").append($( ui.panel ));
		}
		});	
	
	   
		   $(".delete_table").click(function(){
		$("#action").val("delete");
		$("#delete_table_id").val($(this).parent().find(".table_id").val());
		});	
	
	$(".edit_table").click(function(){
		$("#action").val("edit");
		$("#edit_table_id").val($(this).parent().find(".table_id").val());
		});		
});


    </script>
	
    
    <div class="hades_panel_wrap"> <!-- Panel Wrapper -->
		
         <div class="cbox success">
          <div class="cbox-head">yippie, you did it </div>
          <div class="cbox-body">
                <p> Slider Settings Saved !</p>
              
          </div>
        </div>
      
        
		<div class="hades_panel_head clearfix"> <!-- Panel Head -->
            <span class="tab-loading-icon"></span>
             
        </div> <!-- END of Panel Head -->
      
        
        <div class="hades_wrap slider-manager clearfix">  <!-- Panel -->
        	<div id="option-panel-tabs" class="clearfix">  <!-- Options Panel -->
        
                <ul id="themenav" class="clearfix">  <!-- Side Menu -->
                    <li><a href="#starter"> Pricing Table Manager </a></li>
                </ul>  <!-- End of Side Menu -->
       			
                
                <div id="panel-wrapper" class="clearfix">
                 
                <form method="post"  enctype="multipart/form-data" action="" class="clearfix" id="hades_option_form" >
                
                  
                  <div class='hades_section' id="starter"> 
                  	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Tables </a> </h3> 
                            <div class='hades_subpanel'>  
                              
                           
 <div id="tablemanager">
 
  
   <div class="table-body">
   
    <ul>
    <?php foreach($tables as $table ) { ?>
         <li>
         <div class="table-head collapsed table-lists"> <!-- Start of table head  -->
                    Table <?php  echo $table["table_name"] ?> (<span> use this in shortcodes to get this table </span>) - [megatables id="<?php  echo $table["id"]."<input type='hidden' value='$table[id]' name='".$table["id"]."' class='".$table["id"]."' /> "; ?>"/] 
                   <input type="submit" class=" edit_table" value="Edit" /><input type="submit" class=" delete_table" value="Remove" />
                </div> <!-- End of table head  -->
         </li>
     <?php } ?>    
         
     </ul>           
   
   </div><!-- End of Table body  -->
    
     
 </div> <!-- End of Table Manager  -->  
 <input type="hidden" value="delete" name="action" id="action"  />
 <input type="hidden" value="" name="delete_table_id" id="delete_table_id" />
 <input type="hidden" value="" name="edit_table_id" id="edit_table_id" />
  <input type="hidden" value="megatable" name="type" id="type" />                
                              
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
	   
	
	  
}

$options_panel = new PricingListManager();