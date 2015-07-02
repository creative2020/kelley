<?php

class MetaBoxPanel extends Loki {
	
	// init menu
	function __construct () { parent::__construct('MetaBox Maker','submenu','META');  }
	
	// setup things before page loads
	function manager_admin_init(){	  parent::manager_admin_init();
	 
	   if($_GET['page']=='META') :
	   
	  	if(isset($_POST['action'])) :
	 
	 $boxes = array();
	  $i=0;
	  
	  if(!is_array($_POST['slide'])) $_POST['slide'] = array();
	  
	  foreach ( $_POST['slide'] as $key => $value )
			{
				
				$fields = array(
				 
				
				   $_POST["field_element{$i}"],  
				   $_POST["field_label{$i}"] ,  
				   $_POST["field_name{$i}"] ,  
				   $_POST["field_values{$i}"]
				
				);
				
				$boxes[] = array(
				"name" => $_POST['name'][$key],
				"post_type" => $_POST['post_type'][$key],
				"context" => $_POST['context'][$key],
				"priority" => $_POST['priority'][$key],
				"input_fields" => $fields 
				);
				
			$i++; }
	
	
   
   update_option("hades_maker_meta",$boxes);
	
	 endif;
		
	   endif;
	
	 }	
	
	// the markup
	
	function manager_admin_wrap(){	
	
	?>
	
      <script type="text/javascript">
	
	jQuery(function($){
		
		var row = $(".clonable").clone();
		var postSlide = $(".custom-list li.hide:first").clone().removeClass('hide');
		$(".custom-list li.hide:first").remove();
		
		var len = $(".custom-list li").length ;
		
		$("#addfield").live("click",function(e){
			var clone = row.clone();
			var t =  $('.custom-list>li').index($(this).parents('li.clearfix'));
			clone.find('.field-element').attr("name","field_element"+(t)+"[]");
			clone.find('.field_label').attr("name","field_label"+(t)+"[]");
			clone.find('.field_name').attr("name","field_name"+(t)+"[]");
			clone.find('.field_values').attr("name","field_values"+(t)+"[]");
			
			$(this).parents('.ui-table').find("table tbody").append(clone);
			e.preventDefault();
			});
	   
		$(".delete-row").live("click",function(e){ $(this).parents("tr").fadeOut("fast",function(){ $(this).remove(); });  e.preventDefault(); });
		$(".listen_title").live("focusout",function(){ $(this).parents("li").find(".custom_post_label").html($(this).val()) });
		 $('.custom-list h4.heading').live("click",function(){ $(this).next().slideToggle('normal'); });
		 $('.mdelete-icon').live('click',function(e){ $(this).parents("li").fadeOut('normal',function(){ $(this).remove();  }); return false; });
		$(".field-element").live("change",function(){
			
			if($(this).val()=="radio"||$(this).val()=="checkbox"||$(this).val()=="select")
			$(this).parents("tr").find(".changelabel").html('To add multiple options use comma.');
			else
			$(this).parents("tr").find(".changelabel").html('Enter the default value ');
			
			});
		
		$('#create_meta').click(function(e){
			var clone = 	postSlide.clone();
			clone.find('.ui-table .field-element').attr("name","field_element"+(len)+"[]");
			clone.find('.ui-table .field_label').attr("name","field_label"+(len)+"[]");
			clone.find('.ui-table .field_name').attr("name","field_name"+(len)+"[]");
			clone.find('.ui-table .field_values').attr("name","field_values"+(len)+"[]");
			len++;
			
			$(".custom-list").append(clone);
		
		});	

		$(".hseparator").each(function(){ $(this).prev().css('border','none'); });
		
		$('.medit-icon').live('click',function(e){ e.preventDefault(); });
		
		});
	
	</script>
    
    
    <div class="hades_panel_wrap"> <!-- Panel Wrapper -->
		
         <div class="cbox success">
          <div class="cbox-head">yippie, you did it <a href="#" class="icon"></a> </div>
          <div class="cbox-body">
                <p> Theme Settings Saved !</p>
              
          </div>
        </div>
      
        
		<div class="hades_panel_head clearfix"> <!-- Panel Head -->
            <span class="tab-loading-icon"></span>
             
        </div> <!-- END of Panel Head -->
      
        
        <div class="hades_wrap clearfix">  <!-- Panel -->
        	<div id="option-panel-tabs">  <!-- Options Panel -->
        
                <ul id="themenav" class="clearfix">  <!-- Side Menu -->
                <li><a href="#starter"> MetaBox Manager </a></li>
              
                </ul>  <!-- End of Side Menu -->
       			
                
                <div id="panel-wrapper" class="clearfix">
                 
                <form method="post"  enctype="multipart/form-data" action="" class="clearfix" id="hades_option_form" >
                
                  
                  <div class='hades_section' id="starter"> 
                  	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Information</a> </h3> 
                            <div class='hades_subpanel'>  
                               <div class="information">
                              <p>
                            Need help with this section or is something not clear then please check out the docs first or visit our support forums for further assistance. We're not here to help you customize your theme but where always here to guide you through and fix any issues your experiencing.  
                            </p>
                            
                            <p><a href="" id="tour" class="button-default">Documentation</a> <a href="http://wptitans.com/forum/" target="_blank"id="tour" class="button-default">Support Forums</a></p> 
                            
                              
                            </div>
                            </div>  
                        </div> 
                        
                        <div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Manager</a> </h3> 
                            <div class='hades_subpanel'>  
                               <div class="information">
                              
                              
                              
                              
                              
                              
                              
      <div class="hades-panel clearfix">
       
     
        
       <a href="#" class="button-default" id="create_meta" > Create New Box </a> 
        <input type="submit" value="Save" class="button-save" name="action" />
        
      </div>
      <div class="hades-panel-body">
     
      
      <ul class='custom-list'>
      <!-- =============================================================================== -->
      <!-- == Clonable List Item ========================================================= -->
      <!-- =============================================================================== -->
      
        <li class='clearfix hide'> 
          
          <h4 class="heading"> <span class="custom_post_label"> Box </span> details <a href="" class="mdelete-icon"></a> <a href="" class="medit-icon"></a> </h4>
          
          <div class="custom-post">
          
          
            <div class="hades_input clearfix">
              <label for=""> Box Name  :</label>
              <input type="text" class="name listen_title" name="name[]" />
              <p class="tooltip">
               Enter the box title.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Post Type  :</label>

              <div class="select-wrapper"><select name="post_type[]" id="">
              <option value="post">post</option>
              <option value="page">page</option>
                <option value="portfolio">portfolio</option>
              
             
              </select></div>
              <p class="tooltip">
                Select the post type you want to add the meta box.
              </p>
            </div>
            
            
              <div class="hades_input clearfix">
              <label for=""> Position  :</label>
             <div class="select-wrapper"> <select name="context[]" id="">
              <option value="normal">Normal</option>
              <option value="side">Side</option>
              <option value="advance">Advanced</option>
            
              </select></div>
              <p class="tooltip">
                Select the position of the box
              </p>
            </div>
            
            
            <div class="hades_input clearfix">
              <label for=""> Priority :</label>
             <div class="select-wrapper"> <select name="priority[]" id="">
              <option value="high">High</option>
              <option value="core">Core</option>
              <option value="default">Default</option>
            
              </select></div>
              <p class="tooltip">
                Select the priority of the box
              </p>
            </div>
            
 <div class="hseparator"></div>
            
            <div class="ui-table">
             <div class="panel clearfix">
             <a href="#" class="button" id="addfield"> Add Field </a>
             </div>
             <table>
              <thead>
                <tr>
                  <th class="field">Field type</th>
                  <th class="field">Field Label</th>
                  <th class="field">Field Name <span>(will be used in get_post_meta())</span></th>
                  <th class="field">Options/Values <span>(Enter the default value)</span></th>
                </tr>
              </thead>
              <tbody>
              <tr>
                <td>
               <div class="select-wrapper"> <select name="field_element[]" id="" class="field-element">
                  <option value="text"> Textfield </option>
                  <option value="textarea"> Textarea </option>
                  <option value="checkbox"> Checkboxes </option>
                  <option value="radio"> Radio Buttons </option>
                  <option value="select"> Select </option>
                  <option value="image"> Image Upload </option>
                  
                </select></div>
                </td>
                <td>
                <input type="text" name="field_label[]" class="field_label" />
                </td>
                <td>
                <input type="text" name="field_name[]" class="field_name"/>
                </td>
                <td>
                <input type="text" name="field_values[]" class="field_values" />
                </td>
                <td><div class='delete-wrapper'><a href="#" class="delete-icon delete-tab">  </a></div></td>
              </tr>
              </tbody>
             </table>
            </div>
       
          </div> 
                  
          <input type="hidden" name="slide[]" />
        </li>
        
        <?php 
		
		$dynamic_posts = get_option("hades_maker_meta");
       if(!is_array($dynamic_posts)) $dynamic_posts = array();
  
		      $i =0;
              foreach($dynamic_posts as $post) :   ?>
         
       <li class='clearfix'> 
          
          <h4 class="heading"> <span class="custom_post_label"> <?php echo $post["name"]; ?> </span> details  <a href="" class="mdelete-icon"></a> <a href="" class="medit-icon"></a>   </h4>
          
          <div class="custom-post hide">
          
          
            <div class="hades_input clearfix">
              <label for=""> Box Name  :</label>
              <input type="text" class="name listen_title" name="name[]" value="<?php echo $post["name"]; ?>" />
              <p class="tooltip">
               Enter the box title.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Post Type  :</label>
              <div class="select-wrapper"><select name="post_type[]" id="">
              <?php 
			  
			  $opt = array("post"=>"post","page"=>"page","portfolio"=>"portfolio");
			  
			
			 foreach( $opt as $k => $o)
				{
					
					if(trim($k) == trim($post["post_type"]))
					echo "<option value='$k' selected='selected'>$o</option>";
					else
					echo "<option value='$k'>$o</option>";
				}
					
			  
			   ?>
              </select></div>
              <p class="tooltip">
                Select the post type you want to add the meta box.
              </p>
            </div>
            
            
              <div class="hades_input clearfix">
              <label for=""> Position  :</label>
              <div class="select-wrapper"><select name="context[]" id="">
               <?php  $opti = array("normal"=>"Normal" , "side"=>"Side" , "advance"=>"Advanced");
			 
			    foreach($opti as $k => $o)
				{
					if($k==$post["priority"])
					echo "<option value='$k' selected='selected'>$o</option>";
					else
					echo "<option value='$k'>$o</option>";
				}
				
			    ?>
              </select></div>
              <p class="tooltip">
                Select the position of the box
              </p>
            </div>
            
            
            <div class="hades_input clearfix"> 
              <label for=""> Priority :</label>
             <div class="select-wrapper"> <select name="priority[]" id="">
               <?php  $opti = array("high"=>"High" , "core"=>"Core" , "default"=>"Default");
			 
			    foreach($opti as $k => $o)
				{
					if($k==$post["priority"])
					echo "<option value='$k' selected='selected'>$o</option>";
					else
					echo "<option value='$k'>$o</option>";
				}
				
			    ?>
              </select></div>
              <p class="tooltip">
                Select the priority of the box
              </p>
            </div>
            
			<div class=" clearfix"> 
          
            <div class="ui-table">
             <div class="panel clearfix">
             <a href="#" class="button-default" id="addfield"> Add Field </a>
             </div>
             <table>
              <thead>
                <tr>
                  <th class="field">Field type</th>
                  <th class="field">Field Label</th>
                  <th class="field">Field Name<span>(will be used in get_post_meta())</span></th>
                  <th class="field">Options/Values <span>(Enter the default value)</span></th>
                </tr>
              </thead>
              <tbody>
              <tr>
               <?php 
			   
			   $fields = $post["input_fields"];
			   $options = array( "text" => "Textfield" , "textarea" => "Textarea" , "checkbox" => "Checkboxes","radio" => "Radio Buttons", "select" => "Select" , "image" => "Image Upload" );
			   $j = 0;
			   for(;$j<count($fields[0]);$j++)
			   {
				   
					  $trow =  "<td><div class='select-wrapper'><select class='field-element' name='field_element{$i}[]'>";
					  foreach($options as $k => $v) {
					  if($fields[0][$j]==$k)
					  $trow =  $trow."<option value='$k' selected='selected'>$v</option>";
					  else
					  $trow =  $trow."<option value='$k'>$v</option>";
					  
					  }
					  $trow =  $trow."</select></div></td> <td>
                <input type='text' name='field_label{$i}[]' class='field_label hades_ui' value='".$fields[1][$j]."' />
                </td><td>
                <input type='text' name='field_name{$i}[]' class='field_name hades_ui' value='".$fields[2][$j]."' />
                </td> <td>
                <input type='text' name='field_values{$i}[]' class='field_values hades_ui' value='".$fields[3][$j]."' />
                </td><td><div class='delete-wrapper'><a href=\"#\" class=\"delete-icon\">  </a></div></td>";
					  
					  
					  
					  $trow =  $trow."</tr>";
				   echo $trow;
			   }
			   
			   
			   ?>
              </tr>
              </tbody>
             </table>
            </div>
       
          </div> 
                  
          <input type="hidden" name="slide[]" />
        </li>
        <?php $i++; endforeach; ?>
      </ul>
     
   
      
      </div>
      
       <table class="hide">
         <tr class="clonable">
                <td>
                <div class="select-wrapper">
                <select name="field_element[]" id="" class="field-element">
                  <option value="text"> Textfield </option>
                  <option value="textarea"> Textarea </option>
                  <option value="checkbox"> Checkboxes </option>
                  <option value="radio"> Radio Buttons </option>
                  <option value="select"> Select </option>
                  <option value="image"> Image Upload </option>
                  
                </select>
                </div>
                </td>
                <td>
                <input type="text" name="field_label[]" class="field_label" />
                </td>
                <td>
                <input type="text" name="field_name[]" class="field_name"/>
                </td>
                <td>
                <input type="text" name="field_values[]" class="field_values" />
                </td>
                <td><a href="#" class="delete-tab"></a></td>
              </tr>
       </table>
                              
                              
                              
                              
                              
                            
                              
                            </div>
                            </div>  
                        </div> 
                        
                     </div> 
                  </div>
                   
                 
                
                <input type="hidden" name="action" value="save" />
               
                </form>
               </div>
                
               
       
        
   	    	</div>  <!-- End of Options Panel -->
        </div>  <!-- End of Panel -->
         
         
         
	</div> <!-- End of Panel Wrapper -->

	
	<?php
	  
	   }	  
	

   
}

$panel = new MetaBoxPanel();