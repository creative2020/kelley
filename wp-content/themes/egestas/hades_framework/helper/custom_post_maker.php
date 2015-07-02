<?php

class CustomPostsMaker extends Loki {
	
	// init menu
	function __construct () { parent::__construct('Custom Post','submenu','CUST');  }
	
	// setup things before page loads
	function manager_admin_init(){	  parent::manager_admin_init();
	  global $wpdb;
	   if(isset($_GET['page']) && $_GET['page']=='CUST') :
	  
	  	$table_db_name = $wpdb->prefix . "maker";
	 
	 if(isset($_GET['delete'])&&isset($_GET['page'])&&$_GET['page']=="CUST") :
	  
	  $delete_id = $_GET["delete"];
	  $flag = $wpdb->query("DELETE FROM $table_db_name WHERE id='$delete_id' ");
	  	header("Location: admin.php?page=CUST&deleted=true");
		die; 
	 endif;
	 
	  if(isset($_GET['makersingle'])&&isset($_GET['page'])&&$_GET['page']=="CUST") :
	  
	  $filename = "single-".$_GET['makersingle'].".php";
	  $single_file = get_template_directory() ."/single.php";
	  $custom_single_file = get_template_directory() ."/".$filename;
	  copy($single_file,$custom_single_file);
   	  endif;
	 
	 
	 if(isset($_POST['action']) &&isset($_GET['page'])&& $_GET['page']=="CUST" ) :
	 
	 
	 
	  $db_row = array();
	  if(!is_array($_POST['slide'])) $_POST['slide'] = array();
	  
	  foreach ( $_POST['slide'] as $key => $value )
			{
				
				$options = array(
				'taxonomy' =>   $_POST['taxonomy'][$key]
				);
				$title = $_POST['name'][$key];
				
				$labels = array(
					  'name' => _x($_POST['name'][$key], 'post type general name'),
					  'singular_name' => _x($_POST['singular_name'][$key], 'post type singular name'),
					  'add_new' => _x($_POST['add_new'][$key], 'book'),
					  'add_new_item' => ($_POST['add_new_item'][$key]),
					  'edit_item' => ($_POST['edit_item'][$key]),
					  'new_item' => ($_POST['new_item'][$key]),
					  'all_items' => ($_POST['all_items'][$key]),
					  'view_item' => ($_POST['view_item'][$key]),
					  'search_items' => ($_POST['search_items'][$key]),
					  'not_found' =>  ($_POST['not_found'][$key]),
					  'not_found_in_trash' => ($_POST['not_found_in_trash'][$key]), 
					  'parent_item_colon' => $_POST['parent_item_colon'][$key],
					  'menu_name' => ($_POST['menu_name'][$key])
				  
					);
					
					if($_POST['publicly_queryable'][$key]=="true")
					$publicly_queryable = true;
					else
					$publicly_queryable = false;
					
					if($_POST['exclude_from_search'][$key]=="true")
					$exclude_from_search = true;
					else
					$exclude_from_search = false;
					
					$supports = array();
					
					if($_POST['title'][$key]=="on")
					$supports[] = "title";
					
					if($_POST['editor'][$key]=="on")
					$supports[] = "editor";
					
					if($_POST['author'][$key]=="on")
					$supports[] = "author";
					
					if($_POST['thumbnail'][$key]=="on")
					$supports[] = "thumbnail";
					
					if($_POST['excerpt'][$key]=="on")
					$supports[] = "excerpt";
					
					if($_POST['trackbacks'][$key]=="on")
					$supports[] = "trackbacks";
					
					if($_POST['custom_fields'][$key]=="on")
					$supports[] = "custom-fields";
					
					if($_POST['comments'][$key]=="on")
					$supports[] = "comments";
					
					if($_POST['revisions'][$key]=="on")
					$supports[] = "revisions";
					
					
					 $args = array(
					  'labels' => $labels,
					  'description' => $_POST['description'][$key],
					  'public' => true,
					  'publicly_queryable' => $publicly_queryable,
					  'show_ui' => true,
					  'exclude_from_search' => $exclude_from_search,
					  'query_var' => true,
					  'rewrite' => TRUE,
					  'menu_icon' => $_POST['menu_icon'][$key],
					  'rewrite' => true,
					  'capability_type' => 'post',
					  '_edit_link' => 'post.php?post=%d',
					 'rewrite' => array(
    'slug' => trim(str_replace(" ","",strtolower(strtolower($title)))) ,
    'with_front' => FALSE,
  ),
					  'hierarchical' => false,
					  'menu_position' => null,
					  'supports' => $supports
					  ); 
				
				$db_row = array(
				'id' => uniqid(),
				'options' => serialize($options),
				'title' => $title,
				'custom_post' => serialize($args),
				'custom_fields' => ''
				);
			
				
			 if(!isset($_POST['update'][$key]))	
			 $rows_affected = $wpdb->insert($table_db_name,$db_row);  	
			 else	 
			 $rows_affected = $wpdb->update($table_db_name,$db_row,
			   array(
			    'id' => $_POST['update'][$key], 
			   ));  	
				
		
			}
	 
	// echo "<pre>"; print_r($db_row); echo "</pre>";
    
	header("Location: admin.php?page=CUST&saved=true");
		die; 
	
	 endif;
	 

	   wp_enqueue_script('jquery-ui-tabs');
	   endif;
	
	 }	
	
	// the markup
	
	function manager_admin_wrap(){	
	global $themename, $shortname, $options , $super_options, $wpdb;
	
	?>
	<script type="text/javascript">
	
	jQuery(function($){
		
		var postSlide = $(".custom-list li.hide:first").clone().removeClass('hide');
		
		$(".custom-list li.hide").remove();
		$('.delete').live('click',function(e){ $(this).parents("li").fadeOut('normal',function(){ $(this).remove();  }); return false; });
		
		$('.heading .button').live('click',function(e){ e.stopImmediatePropagation(); });
		
	    $('.custom-list h4.heading').live("click",function(){ $(this).next().slideToggle('normal'); });
	
		$('#create_post').click(function(e){
			var temp = $('#custom_post_name').val();
			
			if(jQuery.trim(temp)=="")
			{
			    $('#custom_post_name').addClass("error-state");
			    return;
			}
			else
			    $('#custom_post_name').removeClass("error-state");
			
			    $('#custom_post_name').val('');
			
				var clone = 	postSlide.clone();
				clone.find('.custom_post_label').html(temp);
				clone.find('input[type=text]').each(function(){
				
				if($(this).hasClass('no_change')) return;
				
				if($(this).hasClass('suffix'))
				    $(this).val( $(this).val() + temp  );
				else if($(this).hasClass('preffix'))
				    $(this).val(  temp +$(this).val()  );
				else if($(this).hasClass('taxonomy'))
				    $(this).val( temp+" Category"  );
				else
				{
				    if( !$(this).hasClass('no_change'))
				    $(this).val( temp  );
				}
		   
		  
		});
		
		
		
	  	  $(".custom-list").append(clone);
		
		});
		
		$(".hseparator").each(function(){ $(this).prev().css('border','none'); });
		
		$(".listen_title").live("focusout",function(){ $(this).parents("li").find(".custom_post_label").html($(this).val()) });
		
	
	$(".hades_input input, .hades_input  textarea").live("focusin",
 function()
 {
    this.select();
  
 }
);

$(".hades_input input, .hades_input  textarea").live("mouseup",function(e){
        e.preventDefault();
});

$(".custom-list").sortable();
	var tabs = $( "#option-panel-tabs" ).tabs({
		
		
		add: function( event, ui ) {
			
		   $( ui.panel ).addClass('hades_section').append( $('.tab-clone').children().append() );
		 
		   $( ui.panel ).find('.slider_title').val($(ui.tab).find('span').html());
		   
		   
		   
		   $("#hades_option_form").append($( ui.panel ));
		}
		});		
		});
	
	</script>
	
    <?php if( isset($_GET['saved'])) echo "<div class='alert show'><p>Custom Types Saved </p> </div>"; ?>
     <?php if( isset($_GET['deleted'])) echo "<div class='alert show'><p>Custom Types Deleted </p> </div>"; ?>
    
     
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
                    <li><a href="#starter"> Custom Post Manager </a></li>
                </ul>  <!-- End of Side Menu -->
       			
                
                <div id="panel-wrapper" class="clearfix">
                 
                <form method="post"  enctype="multipart/form-data" action="" class="clearfix" id="hades_option_form" >
                
                  
                  <div class='hades_section' id="starter"> 
                  	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Add Custom Post  </a> </h3> 
                            <div class='hades_subpanel'>  
                              
                            
      <div class="hades-panel hades_input clearfix">
       
       <label for="custom_post_name"> Enter Custom Post Name </label>
       <input type="text" value="" id="custom_post_name" > 
        
       <a href="#" class="button-default" id="create_post" > Create </a> 
        <input type="submit" value="Save" class="button-save" name="action" />
        
      </div>
      <div class="hades-panel-body">
     
      
      <ul class='custom-list'>
      <!-- =============================================================================== -->
      <!-- == Clonable List Item ========================================================= -->
      <!-- =============================================================================== -->
      
        <li class='clearfix hide '> 
          
          <h4 class="heading"> <span class="custom_post_label"> Custom Post </span> details <a href="#" class="button delete"> DELETE</a> </h4>
          
          <div class="custom-post">
          
          
            <div class="hades_input clearfix">
              <label for=""> Name ( in general ) </label>
              <input type="text" class="name listen_title" name="name[]" />
              <p class="tooltip">
                Enter the Custom Posts Type name, generally in plural form.
              </p>
            </div>
            
            
            <div class="hades_input clearfix">
              <label for=""> Single Entity Label :</label>
              <input type="text" class="singular_name" name="singular_name[]" />
              <p class="tooltip">
                Enter here the label which will be used when you want to refer to single entity.
              </p>
            </div>
            
             <div class="hades_input clearfix">
              <label for=""> Add New Label :</label>
              <input type="text" class="add_new no_change" name="add_new[]" value="Add New" />
              <p class="tooltip">
                This is the default label for add new.
              </p>
            </div>
            
             <div class="hades_input clearfix">
              <label for=""> All Items Label :</label>
              <input type="text" class="all_items suffix" name="all_items[]" value="All " />
              <p class="tooltip">
                This refers to the all items label in left menu ( ex: All Posts).
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Add New Item Label :</label>
              <input type="text" class="add_new_item suffix"  name="add_new_item[]" value="Add New " />
              <p class="tooltip">
                This refers to the add new post type like Add New Page.
              </p>
            </div>
            
             <div class="hades_input clearfix">
              <label for=""> Edit Item Label :</label>
              <input type="text" class="edit_item suffix" name="edit_item[]" value="Edit " />
              <p class="tooltip">
                This refers to the title appearing on edit page.
              </p>
            </div>
          
            <div class="hades_input clearfix">
              <label for=""> New Item Label :</label>
              <input type="text" class="new_item suffix" name="new_item[]" value="New " />
              <p class="tooltip">
                This refers to the title appearing on new page.
              </p>
            </div>
            
             <div class="hades_input clearfix">
              <label for=""> View Item Label :</label>
              <input type="text" class="view_item suffix" name="view_item[]" value="View " />
              <p class="tooltip">
                This refers to the title appearing on view page.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Search Items Label :</label>
              <input type="text" class="search_items suffix" name="search_items[]" value="Search " />
              <p class="tooltip">
                Default label on search pages.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Not Found :</label>
              <input type="text" class="not_found no_change" name="not_found[]" value="Not Found "/>
              <p class="tooltip">
                Label to be displayed on not found text.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Not Found in Trash :</label>
              <input type="text" class="not_found_in_trash no_change" name="not_found_in_trash[]" value="Not Found in Trash" />
              <p class="tooltip">
                label to be displayed if no query is returned in trash.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Parent Item Colon :</label>
              <input type="text" class="parent_item_colon no_change" name="parent_item_colon[]" value="" />
              <p class="tooltip">
                The parent text.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Menu Name :</label>
              <input type="text" class="menu_name suffix" name="menu_name[]" value="" />
              <p class="tooltip">
                The menu name text.
              </p>
            </div>
            
            <div class="hseparator clearfix"></div>
            
            <div class="hades_input clearfix">
              <label for=""> description :</label>
              <textarea class="description" name="description[]" ></textarea>
              <p class="tooltip">
                You can add some information regarding custom post type.
              </p>
            </div>
            
             <div class="hades_input clearfix">
            
              <label for=""> Publicly Queryable :</label>
              <div class="select-wrapper">
              <select name="publicly_queryable[]" id="">
                <option value="true"> Yes </option>
                <option value="false"> No </option>
               </select>
               </div>
              <p class="tooltip">
                query_posts queries should be allowed.
              </p>
            </div>
            
            
             <div class="hades_input clearfix">
              <label for=""> Exclude from search :</label>
               <div class="select-wrapper">
               <select name="exclude_from_search[]" id="">
                <option value="true"> Yes </option>
                <option value="false"> No </option>
               </select>
               </div>
              <p class="tooltip">
               exclude from search results.
              </p>
            </div>
            
             <div class="hades_input clearfix">
              <label for=""> Menu Icon :</label>
              <input type="text" class="menu_icon no_change" name="menu_icon[]" />
              <a href="#" class="button-default image_upload" title="Set As Icon" > Upload </a>
              <p class="tooltip">
                Upload your icon for custom post if empty WP default post icon will show.
              </p>
            </div>
            
            
              <div class="hades_input clearfix">
              <label for=""> Supports :</label>
              <div class="hades_radio">
                  <p class="custom-block">
                      <label for="title"> Title </label>
                      <input type="checkbox" id="title" name="title[]" checked="checked" />
                  </p>
                   <p class="custom-block">
                      <label for="editor"> Editor </label>
                      <input type="checkbox" id="editor" name="editor[]" checked="checked" />
                  </p>
                   <p class="custom-block">
                      <label for="author"> Author </label>
                      <input type="checkbox" id="author" name="author[]" checked="checked" />
                  </p>
                   <p class="custom-block">
                      <label for="thumbnail"> Thumbnail </label>
                      <input type="checkbox" id="thumbnail" name="thumbnail[]" checked="checked"/>
                  </p>
                  <p class="custom-block">
                      <label for="excerpt_c"> Excerpt </label>
                      <input type="checkbox" id="excerpt_c" name="excerpt[]" checked="checked"/>
                  </p>
                   <p class="custom-block">
                      <label for="trackbacks_c"> Trackbacks </label>
                      <input type="checkbox" id="trackbacks_c" name="trackbacks[]" checked="checked"/>
                  </p>
                   <p class="custom-block">
                      <label for="custom_fields"> Custom Fields </label>
                      <input type="checkbox" id="custom_fields" name="custom_fields[]" checked="checked" />
                  </p>
                   <p class="custom-block">
                      <label for="comments"> Comments </label>
                      <input type="checkbox" id="comments" name="comments[]" checked="checked" />
                  </p>
                    <p class="custom-block">
                      <label for="revisions"> Revisions </label>
                      <input type="checkbox" id="revisions" name="revisions[]"  checked="checked"/>
                  </p>
                 
                 
              </div>
              <p class="tooltip">
               exclude from search results.
              </p>
            </div>
            
            <div class="hseparator"></div>
            
            <div class="hades_input clearfix">
              <label for=""> Taxonomy  :</label>
              <input type="text" class="taxonomy" name="taxonomy[]" />
              <p class="tooltip">
                Enter the category label. For multiple taxonomies use comma to separate.
              </p>
            </div>
       
          </div> 
                  
          <input type="hidden" name="slide[]" />
        </li>
        
        <?php 
		$table_db_name = $wpdb->prefix . "maker";
		$dynamic_posts = $wpdb->get_results("SELECT * FROM $table_db_name ",ARRAY_A);
		
		      $i =0;
              foreach($dynamic_posts as $post) :
			  
			    $o = unserialize($post['options']);
				$c = unserialize($post['custom_post']);
				$l = $c['labels'];
				
				 
			   ?>
            <li class='clearfix'> 
          
          <h4 class="heading"> <span class="custom_post_label"> <?php echo $post['title']; ?> </span> details <a href="<?php echo admin_url()."admin.php?page=CUST&delete=".$post["id"];?>" class="button deletepost"> DELETE</a> 
        
          <a href="<?php echo admin_url()."admin.php?page=CUST&makersingle=".trim(str_replace(" ","",strtolower(strtolower($post['title'])))); ?>" class="button createsingle"> Create <?php echo $post['title']; ?> Page </a> </h4>
          
          <div class="custom-post hide">
          
          
            <div class="hades_input clearfix">
              <label for=""> Name (in general) </label>
              <input type="text" class="name listen_title" name="name[]" value="<?php echo $post['title']; ?>" />
              <p class="tooltip">
                Enter the Custom Posts Type name, generally in plural form.
              </p>
            </div>
            
            
            <div class="hades_input clearfix">
              <label for=""> Single Entity Label:</label>
              <input type="text" class="singular_name" name="singular_name[]"  value="<?php echo $l['singular_name']; ?>" />
              <p class="tooltip">
                Enter the label which will be used to refer to single entity.
              </p>
            </div>
            
             <div class="hades_input clearfix">
              <label for=""> Add New Label:</label>
              <input type="text" class="add_new no_change" name="add_new[]" value="<?php echo $l['add_new']; ?>"  />

              <p class="tooltip">
                This is the default label for add new.
              </p>
            </div>
            
             <div class="hades_input clearfix">
              <label for=""> All Items Label:</label>
              <input type="text" class="all_items suffix" name="all_items[]" value="<?php echo $l['all_items']; ?>"  />
              <p class="tooltip">
                This refers to the all items label in left menu (ex: All Posts).
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Add New Item Label:</label>
              <input type="text" class="add_new_item suffix"  name="add_new_item[]" value="<?php echo $l['add_new_item']; ?>"  />
              <p class="tooltip">
                This refers to the add new post type (ex: Add New Page).
              </p>
            </div>
            
             <div class="hades_input clearfix">
              <label for=""> Edit Item Label:</label>
              <input type="text" class="edit_item suffix" name="edit_item[]" value="<?php echo $l['edit_item']; ?>"  />
              <p class="tooltip">
                The title appearing on edit page.
              </p>
            </div>
          
            <div class="hades_input clearfix">
              <label for=""> New Item Label:</label>
              <input type="text" class="new_item suffix" name="new_item[]" value="<?php echo $l['new_item']; ?>"  />
              <p class="tooltip">
                The title appearing on new page.
              </p>
            </div>
            
             <div class="hades_input clearfix">
              <label for=""> View Item Label:</label>
              <input type="text" class="view_item suffix" name="view_item[]" value="<?php echo $l['view_item']; ?>"  />
              <p class="tooltip">
                The title appearing on view page.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Search Items Label:</label>
              <input type="text" class="search_items suffix" name="search_items[]" value="<?php echo $l['search_items']; ?>"  />
              <p class="tooltip">
                Default label on search pages.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Not Found:</label>
              <input type="text" class="not_found no_change" name="not_found[]" value="<?php echo $l['not_found']; ?>" />
              <p class="tooltip">
                Label to be displayed on not found text.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Not Found in Trash:</label>
              <input type="text" class="not_found_in_trash no_change" name="not_found_in_trash[]" value="<?php echo $l['not_found_in_trash']; ?>"  />
              <p class="tooltip">
                Label to be displayed if no query is returned in trash.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Parent Item:</label>
              <input type="text" class="parent_item_colon no_change" name="parent_item_colon[]" value="<?php echo $l['parent_item_colon']; ?>"  />
              <p class="tooltip">
                The parent text.
              </p>
            </div>
            
            <div class="hades_input clearfix">
              <label for=""> Menu Name:</label>
              <input type="text" class="menu_name suffix" name="menu_name[]" value="<?php echo $l['menu_name']; ?>"  />
              <p class="tooltip">
                The menu name text.
              </p>
            </div>
            
            <div class="hseparator clearfix"></div>
            
            <div class="hades_input clearfix">
              <label for=""> description:</label>
              <textarea class="description" name="description[]" ><?php echo $c["description"]; ?></textarea>
              <p class="tooltip">
                You can add some information regarding custom post type.
              </p>
            </div>
            
            <div class="hades_input clearfix">
            
              <label for=""> Publicly Queryable:</label>
              <select name="publicly_queryable[]" id="">
             <?php  $opti = array("true"=>"Yes" , "false"=>"No");
			  
			  if($c['publicly_queryable']) {
				   echo "<option value='true' selected='selected' > Yes </option> ";
				   echo "<option value='false'> No </option> ";
			  }
			  else {
				    echo "<option value='true'> Yes </option> ";
				   echo "<option value='false' selected='selected' > No </option> ";
				   }
			    ?>
               </select>
              <p class="tooltip">
                query_posts queries should be allowed.
              </p>
            </div>
            
            
             <div class="hades_input clearfix">
              <label for=""> Exclude from search:</label>
               <select name="exclude_from_search[]" id="">
                <?php  $opti = array("true"=>"Yes" , "false"=>"No");
			  
			  if($c['exclude_from_search']) {
				   echo "<option value='true' selected='selected' > Yes </option> ";
				   echo "<option value='false'> No </option> ";
			  }
			  else {
				    echo "<option value='true'> Yes </option> ";
				   echo "<option value='false' selected='selected' > No </option> ";
				   }
			    ?>
               </select>
              <p class="tooltip">
               Exclude from search results.
              </p>
            </div>
            
             <div class="hades_input clearfix">
              <label for=""> Menu Icon:</label>
              <input type="text" class="menu_icon no_change" name="menu_icon[]" value='<?php echo $c['menu_icon']; ?>' />
              <a href="#" class="button-default image_upload" title="Set as Icon"> Upload </a>
              <p class="tooltip">
                Upload your icon for custom post if empty WP default post icon will show.
              </p>
            </div>
            
             <?php 
			 
			 $supports = $c["supports"];
			 
			 ?>
              <div class="hades_input clearfix">
              <label for=""> Supports:</label>
              <div class="hades_radio">
                  <p class="custom-block">
                      <label for="title"> Title </label>
                      <input type="checkbox" id="title" name="title[]" <?php if(in_array("title",$supports)) echo 'checked="checked"'; ?> />
                  </p>
                   <p class="custom-block">
                      <label for="editor"> Editor </label>
                      <input type="checkbox" id="editor" name="editor[]" <?php if(in_array("editor",$supports)) echo 'checked="checked"'; ?> />
                  </p>
                   <p class="custom-block">
                      <label for="author"> Author </label>
                      <input type="checkbox" id="author" name="author[]" <?php if(in_array("author",$supports)) echo 'checked="checked"'; ?> />
                  </p>
                   <p class="custom-block">
                      <label for="thumbnail"> Thumbnail </label>
                      <input type="checkbox" id="thumbnail" name="thumbnail[]" <?php if(in_array("thumbnail",$supports)) echo 'checked="checked"'; ?> />
                  </p>
                  <p class="custom-block">
                      <label for="excerpt_c"> Excerpt </label>
                      <input type="checkbox" id="excerpt_c" name="excerpt[]" <?php if(in_array("excerpt",$supports)) echo 'checked="checked"'; ?> />
                  </p>
                   <p class="custom-block">
                      <label for="trackbacks_c"> Trackbacks </label>
                      <input type="checkbox" id="trackbacks_c" name="trackbacks[]" <?php if(in_array("trackbacks",$supports)) echo 'checked="checked"'; ?> />
                  </p>
                   <p class="custom-block">
                      <label for="custom_fields"> Custom Fields </label>
                      <input type="checkbox" id="custom_fields" name="custom_fields[]" <?php if(in_array("custom-fields",$supports)) echo 'checked="checked"'; ?> />
                  </p>
                   <p class="custom-block">
                      <label for="comments"> Comments </label>
                      <input type="checkbox" id="comments" name="comments[]" <?php if(in_array("comments",$supports)) echo 'checked="checked"'; ?> />
                  </p>
                    <p class="custom-block">
                      <label for="revisions"> Revisions </label>
                      <input type="checkbox" id="revisions" name="revisions[]" <?php if(in_array("revisions",$supports)) echo 'checked="checked"'; ?> />
                  </p>
                 
                 
              </div>
              <p class="tooltip">
              Select the options you want in the custom post type.
              </p>
            </div>
            
            <div class="hseparator"></div>
            
            <div class="hades_input clearfix">
              <label for=""> Taxonomy:</label>
              <input type="text" class="taxonomy" name="taxonomy[]" value="<?php echo $o['taxonomy']; ?>" />
              <p class="tooltip">
                 Enter the category label. For multiple taxonomies use comma to separate.
              </p>
            </div>
       
          </div> 
                  
          <input type="hidden" name="slide[]" />
          <input type="hidden" name="update[]" value="<?php echo $post["id"]; ?>" />
        </li>
        <?php $i++; endforeach; ?>
      </ul>
     
   
      
      </div>
     
     
     
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
	 
	  public function initDynamicPosts()
	  {
		global $wpdb;
		$table_db_name = $wpdb->prefix . "maker";
		$dynamic_posts = $wpdb->get_results("SELECT * FROM $table_db_name ",ARRAY_A);
		// == Dyanmic post types =============================


    if(!is_array($dynamic_posts)) $dynamic_posts = array();
 
	  foreach($dynamic_posts as $post)
	 {
		 $c = unserialize($post['custom_post']);
		 $title = $post["title"];
		 $o = unserialize($post['options']);
		
		  $custom_obj[]  = new CustomPost($title,$c,$o["taxonomy"]);
	 }
		
		} 

}

$c = new CustomPostsMaker();
$c->initDynamicPosts();
