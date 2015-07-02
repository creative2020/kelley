<?php

class PricingManager extends Loki {
	
	// init menu
	function __construct () { parent::__construct('Pricing Tables','submenu');  }
	
	// setup things before page loads
	function manager_admin_init(){	  parent::manager_admin_init();
	     if(isset($_GET['page']) && $_GET['page']=='PRICI') :
	   
	   
	  	
		  
	   wp_enqueue_script('jquery-ui-tabs');
	   wp_enqueue_script('jquery-ui-accordion');
	 //  wp_enqueue_script("admin-colorpicker",HURL."/js/colorpicker.js",array('jquery'),"1.0");
	   
	   endif;
	
	 }	
	
	// the markup
	
	function manager_admin_wrap(){	
	global $wpdb;
	$table_db_name = $wpdb->prefix . "megatables";
	
	if(isset($_POST["action"])&&$_POST["action"]=="save")
	{
		
			$table_id = $_POST["table_id"];
			$table_name = $_POST["table_name"];
			$table_title = $_POST["table_title"];
			
			$featured_index = $_POST["featured_index"];
			$plan_name = $_POST["plan_name"];
			$plan_pricing = $_POST["plan_pricing"];
			
			$plan_currency =   $_POST["plan_pricing_symbol"] ;
			$plan_pricing_suffix = $_POST["plan_pricing_suffix"];
			$plan_link = $_POST["plan_link"];
			$class_name = $_POST["class_name"];
			$feature_list = $_POST["feature_value"];
			$columns = array();
			$i =1;
			while(isset($_POST["column{$i}"]))
			{
			  $columns[] = $_POST["column{$i}"];
			  $i++;
			}
			$rows_updated = false;
			$rows_affected = false;
		 if(!isset($_GET['edit_id'])) {
			 
		 $rows_affected = $wpdb->insert( $table_db_name, 
		      array( 
			  'id' => $table_id, 
			  'table_name' => $table_name, 
			  'table_title' => $table_title,
			  'plan_name' => serialize($plan_name), 
			  'plan_pricing' => serialize($plan_pricing),
			  'plan_pricing_symbol' =>   $plan_currency,
			  'plan_link' => serialize($plan_link),
			  'class_name' => $class_name,
			  'feature_value' => serialize($feature_list),
			  'featured_index' => $featured_index,
			  'columns' => serialize($columns),
			  'plan_pricing_suffix' => serialize($plan_pricing_suffix)
			  
			   ) 
			
			  ); 
		/*	  echo "<pre>";
			  print_r(   array( 
			  'id' => $table_id, 
			  'table_name' => $table_name, 
			  'table_title' => $table_title,
			  'plan_name' => serialize($plan_name), 
			  'plan_pricing' => serialize($plan_pricing),
			  'plan_pricing_symbol' =>   $plan_currency,
			  'plan_link' => ($plan_link),
			  'class_name' => $class_name,
			  'feature_value' => serialize($feature_list),
			  'featured_index' => $featured_index,
			  'columns' => ($columns),
			  'plan_pricing_suffix' => ($plan_pricing_suffix)
			  
			   ) );
			  echo "</pre>"; */
		 }
		 else
		 {
			
		     $table_id = $_GET['edit_id'];
		
			 $rows_updated = $wpdb->update( $table_db_name, 
		      array( 
			  'id' => $table_id, 
			  'table_name' => $table_name, 
			  'table_title' => $table_title,
			  'plan_name' => serialize($plan_name), 
			  'plan_pricing' => serialize($plan_pricing),
			  'plan_pricing_symbol' =>   $plan_currency,
			  'class_name' => $class_name,
			  'plan_link' => serialize($plan_link),
			  'featured_index' => $featured_index,
			  'feature_value' => serialize($feature_list),
			  'columns' => serialize($columns),
			  'plan_pricing_suffix' => serialize($plan_pricing_suffix)
			   ) ,
			   array(
			    'id' => $table_id, 
			   )
			
			  ); 
			
		 }
			if($rows_affected) 
			echo "<div id=\"message\" class=\"updated fade\"><p>Table added <strong> use this ID $table_id to retrive this table.</strong></p></div>";
			if($rows_updated) 
			echo "<div id=\"message\" class=\"updated fade\"><p>Table updated <strong> ID - $table_id .</strong></p></div>";
		
	}
	$key = '';
	for ($i=0; $i<10; $i++) { 
    $d=rand(1,30)%2; 
    $key = $key. ( $d ? chr(rand(65,90)) : chr(rand(48,57))  ); 
} 
$i =0;
	
	
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
	
	var id,j,i,temp,columncount = 1,input_object= '',counter=1,
	table = $(".table-data>table"),
	titlerows = table.find("thead tr"),
	tablerows = table.find("tbody tr");
	
	columncount = titlerows.children("th").length-1;
			
	
	$(".addcolumn").live('click',function(e){
		
		counter++;
		$("#featured_index").append("<option value='"+(columncount+1)+"'>"+(columncount+1)+"</option>");
		
		titlerows.append("<th scope='col' class='column"+counter+" relative'>Column "+counter+"<a href='#' class='delete-column'></a></th>");
		
		tablerows.not(tablerows.eq(3)).append("<td><input type='text'></td>");
		tablerows.eq(3).append("<td><textarea></textarea></td>");
		
		resetTable();
		e.preventDefault();
		});
		
		
	$(".addrow").live('click',function(e){
		
		temp ='';
		for(i=0;i<columncount;i++)
		{
			
			temp = temp + "<td><input type='text' name='column"+(i+1)+"[]' class='column"+(i+1)+"' ></td>";
		}
		table.find("tbody").append("<tr><td><div class='relative'>Row<a href='#' class='delete-row'></a></div></td>"+temp+"</tr>");
		
		resetTable();
		e.preventDefault();
		
		});
	
	$(".planname").live("focusout",function(){
		temp = $(this);
		if(jQuery.trim(temp.val())!="")
		titlerows.find("th").eq(temp.parent().index()).html(temp.val()+"<a href='#' class='delete-column'></a>");
		//titlerows.eq(temp.parent().index()-1).html(temp.val());
		
		});
	
	
	
	$(".delete_table").click(function(){
		$("#action").val("delete");
		$("#delete_table_id").val($(this).parent().find(".table_id").val());
		});	
	
	$(".edit_table").click(function(){
		$("#action").val("edit");
		$("#edit_table_id").val($(this).parent().find(".table_id").val());
		});		
	
	$(".delete-row").live("click",function(e){
		$(this).parents("tr").remove();
		tablerows = table.find("tbody tr");
		
		
		e.preventDefault();
		});
	
	$(".delete-column").live("click",function(e){
		
		
		counter--;
		var index = $(this).parent().index();
		$(this).parent().remove();
		$("#featured_index").find("option").last().remove();
		tablerows.each(function(){ $(this).find("td").eq(index).remove(); });
		resetTable();
		
		
		e.preventDefault();
		});
			
	var row,column,cell;
	
function resetTable()
{
	titlerows = table.find("thead tr");
	tablerows = table.find("tbody tr");
	columncount = titlerows.children("th").length-1;
	
	tablerows.first().find("input[type=text]").attr('name',"plan_name[]").addClass('planname');
	tablerows.eq(1).find("input[type=text]").attr('name',"plan_pricing[]").addClass('planprice');
	tablerows.eq(2).find("input[type=text]").attr('name',"plan_link[]").addClass('planlink');
	tablerows.eq(3).find("textarea").attr('name',"plan_pricing_suffix[]").addClass('plan_pricing_suffix');
	tablerows.eq(4).find("input[type=text]").attr('name',"feature_value[]").addClass('planlink');
		
	tablerows.each(function(i){
	   
	   row = $(this);
	   if(i>4)
	   row.find("td").each(function(j){
		   
		   cell = $(this);
		   cell.find('input[type=text],textarea').attr("name","column"+j+"[]");
		   
		   });
		
		
		
		});
}
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
                        	<h3 class='subtitle-heading'> <a href='#'>Pricing table creator</a> </h3> 
                            <div class='hades_subpanel'>  
                              
                           
 <div id="tablemanager">
 
  
   
   
    <ul>
      <?php  if(!isset($_GET['edit_id'])) : ?>
            <li class="clearfix">
                <div class="table-head expand"> <!-- Start of table head  -->
                    Table ID (<span> use this in shortcode to get this table </span>) - [megatables id="<?php echo $key."<input type='hidden' value='$key' name='table_id' class='table_id' /> "; ?>" /] 
                    
                      <input type="submit" value="Save" class="button-save">
                </div> <!-- End of table head  -->
                <div class="table-panel"> <!-- Start of table panel  -->
                    
                    <div class="settings-panel clearfix"> <!-- Start of settings panel  -->
                          <ul>
                            <li class="text-titles">
                              <div>
                                <div class="clearfix "><label for="table_name">Table Name</label><input type="text" id="table_name" name="table_name" class="hades_ui"></div>
                                <div class="clearfix"><label for="table_title">Table Title</label><input type="text" id="table_title" name="table_title" class="hades_ui"></div>
                              </div>
                            </li>
                            
                            <li  class="select-set">
                            <div class="clearfix ">
                            <label for="table_featured">Featured</label>
                              <div class="select-wrapper">
                                 <select  name="featured_index" id="featured_index">
                                     <option value="-1">none</option>
                                     <option value="1">1</option>
                                 </select>
                              </div> 
                              </div>
                              <div class=" clearfix">  
                              <label for="plan_pricing_symbol">Currency</label>   
                              <div class="select-wrapper">
                                  
                               <select name="plan_pricing_symbol" id="plan_pricing_symbol">
                                 <option value="$" selected='selected'>$</option>
                                 <option value="&euro;">&euro;</option>
                                 <option value="&yen;">&yen;</option>
                                 <option value="&pound;">&pound;</option>
                                 <option value="Rs">Rs</option>
                                 <option value="HRK">HRK</option>
                                 <option value="PLN">PLN</option>
                             	</select>
                             	
                            </div>
                            </div>
                            </li>
                            <li class="button-set">
                            <div>
                            <a href="#" class="button-default addrow">Add row</a>
                            <a href="#" class="button-default addcolumn">Add Column</a>
                            </div>
                            
                            
                            
                            </li>
                          </ul>
                    </div> <!-- End of settings panel  -->
                    
                    <div class="table-data">
                    <table  class="widefat  " cellspacing="0">
                        <thead>
                          <tr>
                            <th scope="col">Features</th>
                            <th scope="col">Column 1<a href='#' class='delete-column'></a></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Plan Name*</td>
                            <td><input type="text" name="plan_name[]" class="planname"></td>
                          </tr>
                          <tr>
                            <td>Pricing*</td>
                             <td><input type="text" name="plan_pricing[]"></td>
                          </tr>
                          <tr>
                            <td>Link*</td>
                             <td><input type="text" name="plan_link[]"></td>
                          </tr>
                           <tr>
                            <td>Descritpion*</td>
                             <td><textarea name="plan_pricing_suffix[]" id="" cols="30" rows="10"></textarea></td>
                          </tr>
                          <tr>
                            <td>Button Label*</td>
                             <td><input type="text" name="feature_value[]" value="Book Now"></td>
                          </tr>
                          
                        </tbody>
                    </table>
                   </div> 
                </div> <!-- End of table panel  -->
                
            </li>
      <?php else: 
	 $key =  $edit_id = $_GET["edit_id"];
	 $table = $wpdb->get_row("SELECT * FROM $table_db_name where id='$edit_id' ",ARRAY_A);
	
	$features = unserialize($table["feature_value"]);
	
	$plan_name  = unserialize($table["plan_name"]);
	$plan_pricing = unserialize($table["plan_pricing"]);
	$plan_link = unserialize($table["plan_link"]);
	$currency = $table["plan_pricing_symbol"];
	$columns =  unserialize($table["columns"]);
	$featured_index  = $table["featured_index"];
	$plan_pricing_suffix = unserialize($table["plan_pricing_suffix"]);
	$column_count =0;
	
	$column_count=  count($plan_name);
	
	if(!is_array($plan_pricing_suffix))
	$plan_pricing_suffix = array();
	
	  ?>
      
       <li class="clearfix">
                <div class="table-head expand"> <!-- Start of table head  -->
                     Table ID (<span> use this in shortcode to get this table </span>) - [megatables id="<?php echo $key."<input type='hidden' value='$key' name='table_id' class='table_id' /> "; ?>" /] 
                   
                      <input type="submit" value="Save" class="button-save">
                </div> <!-- End of table head  -->
                <div class="table-panel"> <!-- Start of table panel  -->
                    
                    <div class="settings-panel clearfix"> <!-- Start of settings panel  -->
                          <ul>
                            <li class="text-titles">
                              <div>
                                <div class="clearfix "><label for="table_name">Table Name</label><input type="text" class="hades_ui" id="table_name" name="table_name" value="<?php echo $table["table_name"]; ?>" /></div>
                                <div class="clearfix "><label for="table_title">Table Title</label><input type="text" class="hades_ui" id="table_title" name="table_title"  value="<?php echo $table["table_title"]; ?>" /></div>
                              </div>
                            </li>
                            
                            <li class="select-set">
                              <div class="clearfix ">
                            <label for="table_featured">Featured</label>
                              <div class="select-wrapper">
                                 <select  name="featured_index" id="featured_index">
                                 <option value="-1">none</option>
                                     <?php $arr = count($columns);
								   
								   for($i=1;$i<=$column_count;$i++)
								   {
									   if($i==$featured_index)
									  echo "<option value='$i' selected=\"selected\">$i</option>";
									   else
									   echo "<option value='$i'>$i</option>";
								    ?>
                                  
                                  
                                  
                                  <?php } ?>
                                 </select></div></div>
                                   <div class="clearfix"><label for="plan_pricing_symbol">Currency </label> 
                                     <div class="select-wrapper">
                                   <select name="plan_pricing_symbol" id="plan_pricing_symbol">            <?php $arr = array("$","€","¥","£","Rs","HRK","PLN");
								   
								   foreach($arr as $val)
								   {
									   if($val==$currency)
									  echo "<option value='$val' selected=\"selected\">$val</option>";
									   else
									   echo "<option value='$val'>$val</option>";
								    ?>
                                  
                                  
                                  
                                  <?php } ?>
                             </select></div>
                               
                              </div>
                            </li>
                            <li class="button-set">
                            <div>
                            <a href="#" class="button-default addrow">Add row</a>
                            <a href="#" class="button-default addcolumn">Add Column</a>
                            </div>
                            
                            
                            
                            </li>
                          </ul>
                    </div> <!-- End of settings panel  -->
                    
                    <div class="table-data">
                    <table  class="widefat" cellspacing="0">
                        <thead>
                          <tr>
                            <th scope="col">Features</th>
                            <?php $i=0; foreach($plan_name as $val) : ?><th scope="col" class='column<?php echo ++$i; ?> relative'><?php echo $val; ?><a href='#' class='delete-column'></a></th>
                            <?php endforeach;  echo " <input type='hidden' name='column_count'  id='column_count' value='$i' />"; ?>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Plan Name*</td>
                             <?php foreach($plan_name as $val) : ?> <td><input type="text" name="plan_name[]" class="planname" value="<?php echo stripslashes($val); ?>" /></td>
                            <?php endforeach; ?>
                           
                          </tr>
                          <tr>
                            <td>Pricing*</td>
                            <?php foreach($plan_pricing as $val) : ?> 
                             <td><input type="text" name="plan_pricing[]" value="<?php echo $val; ?>" />
                             
                              <?php endforeach; ?>
                             </td>
                          </tr>
                          <tr>
                            <td>Link*</td>
                             <?php foreach($plan_link as $val) : ?> 
                             <td><input type="text" name="plan_link[]" value="<?php echo $val; ?>" /></td>
                               <?php endforeach; ?>
                          </tr>
                           <tr>
                            <td>Description*</td>
                             <?php foreach($plan_pricing_suffix as $val) : ?> 
                                  <td>    <textarea name="plan_pricing_suffix[]" id="" cols="30" rows="10"><?php echo stripslashes($val); ?></textarea>
                             </td>
                               <?php endforeach; ?>
                             
                              <tr>
                            <td>Button Label*</td>
                            
                            <?php if(!is_array($features)) $features =array('','','','',''); foreach($features as $val) : ?> 
                             <td><input type="text" name="feature_value[]" value="<?php echo $val; ?>" />
                             
                              <?php endforeach; ?>
                             </td>
                          </tr>  
                               
                          </tr>
                          
                          <?php  for($i=0;$i<count($columns[0]);$i++) : ?>
                             <tr><td><div class='relative'>Row<a href='#' class='delete-row'></a></div></td>
                             
                              <?php   for($j=0;$j<count($columns);$j++)  { ?>
                              <td><input type='text' name='column<?php echo $j+1; ?>[]' class='column<?php echo $j+1; ?>' value="<?php echo stripslashes($columns[$j][$i]); ?>" ></td>
                              <?php  } ?>
                              
                             </tr>
                          <?php  endfor; ?>
                        </tbody>
                    </table>
                   </div> 
                </div> <!-- End of table panel  -->
               
            </li>
      
      
      <?php endif; ?>
     </ul>           
   
  
    
    </div> 

 
                              
                              
                              
                            </div>  
                        </div> 
                     </div> 
                  </div>
                  
                
                <input type="hidden" name="action" value="save" class="button-save" />
               
                </form>
               </div>
                
               
       

        
   	    	</div>  <!-- End of Options Panel -->
        </div>  <!-- End of Panel -->
         
         
         
	</div> <!-- End of Panel Wrapper -->
		
   
	
	<?php
	  
	   }	  
	   
	
	  
}

$options_panel = new PricingManager();