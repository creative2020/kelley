<?php

class Slidermanager extends Loki {
	
	// init menu
	function __construct () { parent::__construct('Slider Manager','submenu');  }
	
	// setup things before page loads
	function manager_admin_init(){	  parent::manager_admin_init();
	   global $wpdb;
	   $table_db_name = $wpdb->prefix . "tslidermanager";
	   
	   if(isset($_GET['page']) && $_GET['page']=='SLIDE') :
	   
	   if(isset($_POST["deletekey"]))
		{
		$del_key =  $_POST["deletekey"];
	    $flag = $wpdb->query("DELETE FROM $table_db_name WHERE id='$del_key' ");
		echo $flag;
		die();
		}
		
	   if(isset($_POST['action']))
		{
			$rows_updated = 'fail';
			$data = ($_POST['values']);
  			$key =  $_POST['key'];
			
			if(isset($key ))
			{
				$db_operation = $wpdb->update( $table_db_name, 
												array( 
												'id' => $key, 
												'slides' =>  serialize($data[0]), 
												'options' => serialize($data[1]), 
												
												 ) ,
												 array(  'id' => $key )
											  );
			}
			else 
			{
				$key = '';
				for ($i=0; $i<10; $i++) { 
				$d=rand(1,30)%2; 
				$key = $key. ( $d ? chr(rand(65,90)) : chr(rand(48,57))  ); 
				}
				$db_operation = $wpdb->insert( $table_db_name, 
												array( 
												'id' => $key, 
												'slides' =>  serialize($data[0]), 
												'options' => serialize($data[1]), 
												
												 ) 
											  );
			}
			echo $key;
			die();
		}
		
	  	
		  
	   wp_enqueue_script('jquery-ui-tabs');
	   wp_enqueue_script('jquery-ui-accordion');
	   wp_enqueue_script('jquery-ui-draggable');
	 //  wp_enqueue_script("admin-colorpicker",HURL."/js/colorpicker.js",array('jquery'),"1.0");
	   
	   endif;
	
	 }	
	
	// the markup
	
	function manager_admin_wrap(){	
	global $themename, $shortname, $options , $super_options,$helper;
	global $wpdb;
	$table_db_name = $wpdb->prefix . "tslidermanager";
	$sliders =  $wpdb->get_results("SELECT * FROM $table_db_name ",ARRAY_A);
	?>
	
    <script type="text/javascript">
    
jQuery(document).ready(function($){
	
	var temp,i,j,obj;
	var url = '<?php echo admin_url().'admin.php?page=SLIDE'; ?>';
	
	/*
	$( ".subpanel" ).accordion({
			autoHeight: false,
			navigation: true,
            collapsible: true
		});	 */
	 $('.colorpickerField1').ColorPicker({

	onSubmit: function(hsb, hex, rgb, el) {

		$(el).val(hex);

		$(el).ColorPickerHide();

	},

	onBeforeShow: function () {
       temp = this;
		$(this).ColorPickerSetColor(this.value);

	},
	
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(300);
		return false;
	},
	onChange: function (hsb, hex, rgb,el) {
		$(temp).val(hex);
		$(temp).parents('.hades_input').find('.colorSelector>div').css('backgroundColor', '#' + hex);
	}

})

.bind('keyup', function(){

	$(this).ColorPickerSetColor(this.value);

});	
	var tabs = $( "#option-panel-tabs" ).tabs({
		
		
		add: function( event, ui ) {
			
		   $( ui.panel ).addClass('hades_section').append( $('.tab-clone').children().append() );
		 
		   $( ui.panel ).find('.slider_title').val($(ui.tab).find('span').html());
		   
		    
		   
		   $("#hades_option_form").append($( ui.panel ));
		    
			$(  ui.tab ).css({'color':'#ffffff','text-shadow':'none'});
		    $(  ui.tab ).animate({ backgroundColor: "#1aa2e1" }, 200 , function(){  $(this).animate({  backgroundColor: "#fefefe" },400,function(){ $(this).removeAttr('style'); });   });
		   
		}
		});	
	$('.slider-body').tabs();
    
	$('.uploadarea a.edit-icon').live('click',function(e){
		e.preventDefault();
		$(this).toggleClass('minus-icon');
		$(this).parent().toggleClass('active');
		
		if( $(this).parent().find('.slider-body').is(':hidden') )
		$(this).parent().find('.slider-head').hide();
		
		
		$(this).parent().find('.slider-body').slideToggle('normal',function(){
			
			if($(this).is(':hidden')) $(this).prev().show();
			});
		
		});
	
	$('.uploadarea a.delete-icon').live('click',function(e){
		e.preventDefault();
		
		$(this).parent().slideUp('normal',function(){ $(this).remove(); });
		
		});	
	
	
	
	$('.slide-link').live('change',function(){
		
		temp =  $(this).parents('.input_wrapper') ;
		temp.find('.portfolio-wrapper , .events-wrapper, .post-wrapper , .custom_link').addClass('hide'); 
		switch($(this).val())
		{
			case 'custom' : temp.find('.custom_link').removeClass('hide'); break;
			case 'post' : temp.find('.post-wrapper').removeClass('hide'); break;
			case 'portfolio' : temp.find('.portfolio-wrapper').removeClass('hide'); break;
			case 'events' : temp.find('.events-wrapper').removeClass('hide'); break;
		}
		
		});
	
	$('.image_src').live('focusout',function(){ $(this).parent().find('img').attr('src',$(this).val()) });
	
	$('.save_tab').click(function(e){
		e.preventDefault(); $('.tab-loading-icon').animate({opacity:1},'slow');
		temp = [];
		var data = [];
		var mode = 'update',tempv;
		var key = $(this).parent().find('.key').val();
		
		parent = $(this).parents('.slider-panel');
		
		obj = $(this).parents('.hades_subpanel');
		obj.find('.uploadarea>li').each(function(i){
			var linkv,tempv = $(this).find('.slide-link').val()
			switch(tempv)
			{
				case 'none' : linkv = ''; break;
				case 'post' : linkv = $(this).find('.post').val(); break;
				case 'portfolio' : linkv = $(this).find('.portfolio').val(); break;
				case 'events' : linkv = $(this).find('.events').val(); break;
				case 'custom' : linkv = $(this).find('.custom_link').val(); break;
			}
			
			data[i] = { "image" : $(this).find('.image_src').val() , 'title' :   $(this).find('.slide-title').val()  , 'caption' :   $(this).find('.text').val() ,'link' : tempv+","+linkv , 'video' : $(this).find('.slide-video').val() , 'stage' : $(this).find('.slide-stage').val() , 'bgimage' : $(this).find('.slide-bgimage').val() , 'titlecolor' : $(this).find('.title-color').val() , 'titlebgcolor' : $(this).find('.title-bgcolor').val() , 'desccolor' : $(this).find('.desc-color').val() , 'descbgcolor' : $(this).find('.desc-bgcolor').val()  , 'titlex' : $(this).find('.title-x').val() , 'titley' : $(this).find('.title-y').val()   , 'textx' : $(this).find('.text-x').val() , 'texty' : $(this).find('.text-y').val() , 'imagex' : $(this).find('.image-x').val() , 'imagey' : $(this).find('.image-y').val() };
			
			});
		    
		temp[0] = data; 
		temp[1] = { width:obj.parents('.hades_section').find(".slider_width").val() , 
				    height:obj.parents('.hades_section').find(".slider_height").val() ,
					title :  obj.parents('.hades_section').find(".slider_title").val(),
					time :  obj.parents('.hades_section').find(".slider_time").val(),
					responsive :  obj.parents('.hades_section').find(".responsive_slider").val(),
					preloading :  obj.parents('.hades_section').find(".preloading_slider").val(),
					autoplay :  obj.parents('.hades_section').find(".autoplay_slider").val(),
					arrow_control :  obj.parents('.hades_section').find(".arrow_control_slider").val(),
					bullets_control :  obj.parents('.hades_section').find(".bullet_control_slider").val(),
					random_slides :  obj.parents('.hades_section').find(".random_slider").val(),
					slider_type :  obj.parents('.hades_section').find(".slider_type").val(),
					caption : obj.parents('.hades_section').find(".caption_slider").val(),
					styled : obj.parents('.hades_section').find(".styled_slider").val()
					
		            }
	
		 $.post(url,{ action:'save', values:temp , mode:mode ,key:key },function(data){
			
			$('.tab-loading-icon').animate({opacity:0},'slow');
			if(data!="")
			if(parent.find('.key').length==0)
			 parent.prepend("<input class='key' type='hidden' value="+data+" />");
			 $(".cbox").stop(true,true).fadeIn("normal",function(){
                      
                      $(".cbox").delay(2000).fadeOut('normal')
                      
                      });
					  
			});
			
		});	
	
	 var testname = true; 
	 $('#init_tab').click(function(e){
		 e.preventDefault();
		 testname = true; 
		 if(jQuery.trim($('.add_tab').val())=="")
		 {
			 $('.message').slideDown('normal',function(){ temp = this; setTimeout(function(){ $(temp).hide(); },2000); });
			 $('.add_tab').addClass('error'); return;
		 }
		 
		 
		 $("#themenav").find('li').each(function(){ 
		 
		 if(jQuery.trim($('.add_tab').val())==jQuery.trim($(this).find('span').html()) )
		 {
			 $('.message').slideDown('normal',function(){ temp = this; setTimeout(function(){ $(temp).hide(); },2000); });
			 $('.add_tab').addClass('error'); testname = false;
		 }
		 
		  });
		 
		 if(testname == false )  return; 
		 
		  $('.add_tab').removeClass('error');
		  
		 $('.tab-loading-icon').animate({opacity:1},'slow',function(){ $(this).animate({opacity:0},'slow'); });
		 temp = $('.add_tab').val().replace(' ','_').toLowerCase();
		 tabs.tabs( "add", "#" + temp, $('.add_tab').val() );
		 
		 })		
	
		$('.delete-tab').live("click",function(e){
		e.preventDefault();
		$('.tab-loading-icon').animate({opacity:1},'slow');
		var key  = $(this).parents('.hades_section').find('.key').val();
		
		$.post(url,{deletekey:key },function(data){
			$('.tab-loading-icon').animate({opacity:0},'slow');
			
			
				var index =  tabs.tabs( "option", "selected" );
				tabs.tabs( "remove", index );
		
			
			});
		});	
		
	$('#add_video').live('click',function(e){
		e.preventDefault();
		
		$(this).parent().next().slideDown('normal');
		
		
		});
		
	$('.add_video_slider').live('click',function(e){
		e.preventDefault();
		
		var url = $(this).prev().val();
		$(this).prev().val('')
		temp = jQuery('.clonable li').first().clone();
		temp.find('img').attr('src',$('#video_thumb_url').val());
		temp.find('input.image_src').val($('#video_thumb_url').val());
		temp.find('input.image_src').hide();
		temp.find('.editimage-icon').hide();
		temp.find('.stageoptions').hide();
		temp.find('.slide-title').after('<input class="slide-video" type="text" value="'+url+'">');
		$(this).parents('.hades_subpanel').find('.uploadarea').append(temp);
		$(this).parent().slideUp('normal');
		
		
		});
	
	$('.slider_type').live('change',function(){
		
		temp = $(this).parents('.hades_section');
		if($(this).val()=="Staged Slider")
		{
			
		 temp.find('.stageoptions').show();	
		 temp.find('.slider-body').tabs("option","disabled",[]);
		 
		}
		else
		{
			temp.find('.slider-body').tabs( "option", "disabled", [1, 2] );
			temp.find('.stageoptions').hide();
		}
		
		});

																						  														
	$('.uploadarea').sortable({  handle:'div.slider-head' });	
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
              
                <li><a href="#starter"> Add New Slideshow </a></li>
              
                <?php 
			   foreach($sliders as $slider)
			   {
				    $options =  unserialize($slider['options']);
				   if($slider['id']!="1")
				   echo  " <li><a href=\"#".strtolower(str_replace(" ","_",$options["title"]))."\"><span>$options[title] </span></a></li>";
			   }
			   ?>
                </ul>  <!-- End of Side Menu -->
       			
                
                <div id="panel-wrapper" class="clearfix">
                 
                <form method="post"  enctype="multipart/form-data" action="" class="clearfix" id="hades_option_form" >
                
                  
                  <div class='hades_section' id="starter"> 
                  	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'> &nbsp; </a> </h3> 
                            <div class='hades_subpanel'>  
                               <div class="information">
                              <p>
                          With our slider manager your able to create as many sliders as you need with different structures and formats. Only for the homepage we've got a fixed tab since we don't want anything to go wrong with it. There are a few functions inside the homepage slider which where not possible to recreate on the other pages and vice versa.
                          
                          
                         
                            
                            </p> 
                             <p> <a href="http://wptitans.com/doc/egestas/index.html" id="tour" target="_blank" class="button-default help-doc"> Read Documentation  </a>  </p> 
                            <div class="message warning_box">
                            	<p class="widget-content">Input Field cannot be empty  or have same name as existing Slideshow !</p>
                            </div>
                            
                            <div class="hades_input add_tab_pane clearfix">
                            	<input type="text" class="add_tab" /><a href="" class="button-default" id="init_tab">Add Slideshow</a>
                            </div>
                            
                              
                            </div>
                            </div>  
                        </div> 
                     </div> 
                  </div>
                  
                 
                 
                  <?php 
				  
				    foreach($sliders as $slider) :   if($slider['id']!="1") :  $slides = unserialize($slider['slides']); $options =  unserialize($slider['options']);  ?>
                   
                    <div class='hades_section' id="<?php echo strtolower(str_replace(" ","_",$options["title"])) ?>"> 
                    <div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Basic Settings</a> <span class="delete-tab"></span></h3> 
                            <div class='hades_subpanel clearfix'>  
                               
                                <div class="hades_input clearfix">
                                	<label for="">Enter Title</label>
                                     <input type="text" value="<?php echo $options["title"] ?>" class="slider_title" />
                                </div>
                             	<div class="hades_input clearfix">
                                	<label for="">Enter Width</label>
                                    <input type="text" class="slider_width" value="<?php echo $options['width']; ?>" />
                                     <div class="description">
                                    This <strong>will be ingored</strong> for Featured Sliders ( That are selected in pages/posts ) !
                                    </div>
                                </div>
                                <div class="hades_input clearfix">
                                	<label for="">Enter Height</label>
                                    <input type="text" class="slider_height" value="<?php echo $options['height']; ?>" />
                                </div>
                                 <div class="hades_input clearfix">
                                	<label for="">Enter Time in Seconds</label>
                                    <input type="text" class="slider_time" value="<?php echo $options['time']; ?>" />
                                </div>
                                  <div class="hades_input clearfix">
                                	<label for="">Slider Type</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="slider_type">
                                            <?php $t = array("Fade Slider" => "Fade Slider" ,'jQuery Slider' => 'jQuery Slider','Grid Wall'=> 'Grid Wall','Move Slider' => 'Move Slider',"Accordion Slider" => "Accordion Slider");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($options['slider_type']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                         </select>
                                    </div>
                                   
                                    
                                </div>
                                <div class="hades_input clearfix">
                                	<label for="">Responsive Slider</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="responsive_slider">
                                            <?php $t = array("true" => "Yes" ,"false" => "No");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($options['responsive']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                         </select>
                                    </div>
                                    
                                </div>
                                
                                
                                
                                <div class="hades_input clearfix">
                                	<label for="">Preloading</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="preloading_slider">
                                           <?php $t = array("true" => "Yes" ,"false" => "No");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($options['preloading']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                         </select>
                                    </div>
                                </div>
                               
                               <div class="hades_input clearfix">
                                	<label for="">Show Description</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="caption_slider">
                                             <?php $t = array("true" => "Yes" ,"false" => "No");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($options['caption']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                         </select>
                                    </div>
                                    <div class="description">
                                    	This option does not works for Grid Wall
                                    </div>
                                </div>
                                
                                <div class="hades_input clearfix">
                                	<label for="">AutoPlay</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="autoplay_slider">
                                             <?php $t = array("true" => "Yes" ,"false" => "No");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($options['autoplay']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                         </select>
                                    </div>
                                     <div class="description">
                                    	This option does not works for Grid Wall and Accordion Slider
                                    </div>
                                </div> 
                                
                                 <div class="hades_input clearfix">
                                	<label for="">Arrow Controls</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="arrow_control_slider">
                                            <?php $t = array("true" => "Yes" ,"false" => "No");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($options['arrow_control']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                         </select>
                                    </div>
                                     <div class="description">
                                    	This option does not works for Grid Wall and Accordion Slider
                                    </div>
                                </div>
                                
                                 <div class="hades_input clearfix">
                                	<label for="">Bullet Controls</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="bullet_control_slider">
                                            <?php $t = array("true" => "Yes" ,"false" => "No");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($options['bullets_control']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                         </select>
                                    </div>
                                    <div class="description">
                                    	This option does not works for Grid Wall and Accordion Slider
                                    </div>
                                </div>
                                   
                            </div>  
                        </div> 
                  	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Upload Media </a> </h3> 
                            <div class='hades_subpanel'>  
                            <div id="home-slider">
                            	<div class="slider-panel clearfix">
                                	
                                    <input type="hidden" value="<?php echo $slider['id']; ?>" class="key" />
                                    
                                	<a href="" class="button-default gallery_upload" title="Add To Slideshow"> Add Images </a>
                                    <a href="#thickbox-content" class="button-default"  id="add_video"> Add Video </a>
                                    <a href="" class="button-save save_tab"> Save </a>
                                </div>
                                 <div class="video-panel  clearfix">
                                		<input type="text" class="video_link hades_ui" placeholder="Add Video URL here.."  /><a href="" class="add_video_slider button-default" >Add Slide</a>
                                        <div class="video-info"> Only <strong>Fade Slider</strong> Supports Video ( Suported video sites -> Youtube & Vimeo ) </div>
                                </div>
                            	<ul class="uploadarea">
                                	<?php
									if(!is_array($slides))   $slides= array(); 	
									 foreach ( $slides as $s )
									 {
										 $this->generateSlide($s,$options['slider_type']);
									 }
									 ?>
                            	</ul>    
                            </div>
                            </div>  
                        </div> 
                     </div> 
                  </div>
                   
                   
                   <?php endif; endforeach; ?>
                
                <input type="hidden" name="action" value="save" />
               
                </form>
               </div>
                
               
       
        
   	    	</div>  <!-- End of Options Panel -->
        </div>  <!-- End of Panel -->
         
         
         
	</div> <!-- End of Panel Wrapper -->
		
    
    <div class="tab-clone hide">
    	<div class='hades_section' id="">  
                    <div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Basic Settings</a> <span class="delete-tab"></span> </h3> 
                            <div class='hades_subpanel clearfix'>  
                            <div class="hades_input clearfix">
                                	<label for="">Enter Title</label>
                                     <input type="text" value="" class="slider_title" />
                                </div>
                             	<div class="hades_input clearfix">
                                	<label for="">Enter Width</label>
                                    <input type="text" class="slider_width" value="980" />
                                      <div class="description">
                                    This <strong>will be ingored</strong> for Featured Sliders ( That are selected in pages/posts ) !
                                    </div>
                                </div>
                                <div class="hades_input clearfix">
                                	<label for="">Enter Height</label>
                                    <input type="text" class="slider_height" value="400" />
                                </div>
                                <div class="hades_input clearfix">
                                	<label for="">Enter Time in Seconds</label>
                                    <input type="text" class="slider_time" value="5" />
                                </div>
                                  <div class="hades_input clearfix">
                                	<label for="">Slider Type</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="slider_type">
                                            <?php $t = array("Fade Slider" => "Fade Slider" ,'jQuery Slider' => 'jQuery Slider','Grid Wall'=> 'Grid Wall','Move Slider' => 'Move Slider',"Accordion Slider" => "Accordion Slider");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                         </select>
                                    </div>
                                   
                                    
                                </div>
                                
                                <div class="hades_input clearfix">
                                	<label for="">Responsive Slider</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="responsive_slider">
                                            <option value="true">Yes</option>
                                            <option value="false">No</option>
                                         </select>
                                    </div>
                                     
                                </div>
                                
                                <div class="hades_input clearfix">
                                	<label for="">Preloading</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="preloading_slider">
                                            <option value="true">Yes</option>
                                            <option value="false"  selected='selected'>No</option>
                                         </select>
                                    </div>
                                </div>
                                
                                <div class="hades_input clearfix">
                                	<label for="">Show Description</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="caption_slider">
                                            <option value="true" selected='selected'>Yes</option>
                                            <option value="false"  >No</option>
                                         </select>
                                    </div>
                                    <div class="description">
                                    	This option does not works for Grid Wall and Accordion Slider
                                    </div>
                                </div>
                               
                                <div class="hades_input clearfix">
                                	<label for="">AutoPlay</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="autoplay_slider">
                                            <option value="true">Yes</option>
                                            <option value="false">No</option>
                                         </select>
                                    </div>
                                    <div class="description">
                                    	This option does not works for Grid Wall and Accordion Slider
                                    </div>
                                </div> 
                                
                                 <div class="hades_input clearfix">
                                	<label for="">Arrow Controls</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="arrow_control_slider">
                                            <option value="true">Yes</option>
                                            <option value="false">No</option>
                                         </select>
                                    </div>
                                    <div class="description">
                                    	This option does not works for Grid Wall and Accordion Slider
                                    </div>
                                </div>
                                
                                 <div class="hades_input clearfix">
                                	<label for="">Bullet Controls</label>
                                     <div class="select-wrapper">
                                        <select name="" id="" class="bullet_control_slider">
                                            <option value="true">Yes</option>
                                            <option value="false">No</option>
                                         </select>
                                    </div>
                                    <div class="description">
                                    	This option does not works for Grid Wall and Accordion Slider
                                    </div>
                                </div>
                                   
                            </div>  
                        </div> 
                  	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Upload Media </a> </h3> 
                            <div class='hades_subpanel'>  
                            <div id="home-slider">
                            	<div class="slider-panel clearfix">
                                	
                                   
                                    
                                	<a href="" class="button-default gallery_upload" title="Add To Slideshow"> Add Images </a>
                                    <a href="#thickbox-content" class="button-default" id="add_video"> Add Video </a>
                                    <a href="" class="button-save save_tab"> Save </a>
                                </div>
                                 <div class="video-panel  clearfix">
                                		<input type="text" class="video_link hades_ui" placeholder="Add Video URL here.."  /><a href="" class="add_video_slider button-default" >Add Slide</a>
                                        <div class="video-info"> Only <strong>Fade Slider</strong> Supports Video ( Suported video sites -> Youtube & Vimeo ) </div>
                                </div>
                            	<ul class="uploadarea">
                                	
                            	</ul>    
                            </div>
                            </div>  
                        </div> 
                     </div> 
                  </div>
    
    </div> 
     
        
    <div class="clonable hide">  
    <input type="hidden" value="<?php echo HURL.'/css/i/video-thumb.jpg';?>" id="video_thumb_url" />  
    <ul>
    <li class="clearfix">
                                        <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	<div class="slider-head clearfix">	
                                        	<img src="">	
                                    		 <p class="title">title here</p> 
                                    	</div>
                                        <div class="slider-body clearfix">
                                        	<ul class="ui-tabs clearfix">
                                        		<li><a href="#general">General</a></li>
                                        	
                                        	</ul>
                                            <div id="general" class="ui-tabs-panel clearfix">
                                            	
                                                
                                                  <div class="imagewrapper hades_input clearfix">
                                                	<span></span><img src="">
                                            	    <input type="text" class="image_src panel_upload" value="" /><a href="" title="Add To Slideshow" class="editimage-icon image_upload"></a> 	
                                                </div>
                                                
                                                <div class="input_wrapper hades_input clearfix">
                                                 	<input type="text" placeholder="Add Title" class="slide-title" />
                                                     
                                                     <div class="bgupload clearfix stageoptions">
                                                    		<input type="text" placeholder="Add Background Image" class="slide-bgimage " /><a href="" class="image_upload button-default">Upload Background Image</a>
                                                    </div>
                                                    
                                                    <textarea name="" id="" cols="30" rows="10" class="text" > Add Caption(HTML Supported) </textarea>
                                                    <div class="select-wrapper">
                                                    	<select name="" id="" class="slide-link">
                                                    		<option value="none">None</option>
                                                            <option value="post">Link To Post</option>
                                                            <option value="portfolio">Link To Portfolio</option>
                                                            <option value="custom">Custom Link</option>
                                                    	</select>
                                                    </div>
                                                    
                                                    
                                                    
                                                     <div class="select-wrapper hide post-wrapper">
                                                    	<select name="" id="" class="post">
                                                    		<?php 
															    $popPosts = new WP_Query();
																$popPosts->query('post_type=post&posts_per_page=-1'); 
																
																while ($popPosts->have_posts()) : $popPosts->the_post();  
																 
																  echo "<option value='".get_the_ID()."'>".get_the_title()."</option>";
																endwhile;
																wp_reset_query();
															?>
                                                    	</select>
                                                    </div>
                                                    
                                                    <div class="select-wrapper hide portfolio-wrapper">
                                                    	<select name="" id="" class="portfolio">
                                                    		<?php 
															    $popPosts = new WP_Query();
																$popPosts->query('post_type=portfolio&posts_per_page=-1'); 
																
																while ($popPosts->have_posts()) : $popPosts->the_post();  
																 
																  echo "<option value='".get_the_ID()."'>".get_the_title()."</option>";
																endwhile;
																wp_reset_query();
															?>
                                                    	</select>
                                                    </div>
                                                    
                                                     <div class="select-wrapper hide events-wrapper">
                                                    	<select name="" id="" class="events">
                                                    		<?php 
															    $popPosts = new WP_Query();
																$popPosts->query('post_type=events&posts_per_page=-1'); 
																
																while ($popPosts->have_posts()) : $popPosts->the_post();  
																 
																  echo "<option value='".get_the_ID()."'>".get_the_title()."</option>";
																endwhile;
																wp_reset_query();
															?>
                                                    	</select>
                                                    </div>
                                                    
                                                    <input type="text" value="http://" class="custom_link hide" />
                                                    
                                                </div>
                                                
                                            </div>
                                        
                                           
                                            
                                        </div>
                                    </li>
    </ul>
    </div>
	
	<?php
	  
	   }	  
	   
	 function generateSlide($slide, $slider_type)
	 {
		 global $helper;
		  $l = explode(',',$slide['link']);
		
		 ?>
         
         <li class="clearfix">
                                        <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	<div class="slider-head clearfix">	
                                        	<img src="<?php echo $slide['image']; ?>">	
                                    		 <p class="title"><?php echo $helper->getShortenContent(80,$slide['title']); ?></p> 
                                    	</div>
                                        <div class="slider-body clearfix">
                                        	<ul class="ui-tabs clearfix">
                                        		<li><a href="#general">General</a></li>
                                        	
                                        	</ul>
                                            <div id="general" class="ui-tabs-panel clearfix">
                                            	
                                                <div class="imagewrapper hades_input clearfix">
                                                	<span></span><img src="<?php echo $slide['image']; ?>">
                                            			
                                                  
                                                    <input type="text" class="image_src panel_upload" <?php   if(isset($slide['video'])) echo 'style="display:none"'; ?> value="<?php echo $slide['image']; ?>" />
                                                      <?php if(!isset($slide['video'])) : ?>      
                                                    <a href="" title="Add To Slideshow" class="editimage-icon image_upload"></a> 	
                                                    <?php endif ; ?>
                                               
                                                </div>
                                                
                                                <div class="input_wrapper hades_input clearfix">
                                                 	<input type="text" value="<?php echo stripslashes(trim($slide['title'])); ?>" class="slide-title"  />
                                                    <?php if(isset($slide['video'])) : ?>      
                                                   <input type="text" value="<?php echo trim($slide['video']); ?>" class="slide-video"  />	
                                                    <?php endif ; ?>
                                                    
                                                    
                                                    
                                                  
                                                    <div class=" bgupload clearfix stageoptions" <?php if($slider_type!="Staged Slider") echo 'style="display:none;"';  ?> >
                                                    		<input type="text" placeholder="Add Background Image" class="slide-bgimage" value="<?php echo trim($slide['bgimage']); ?>" /><a href="" class="image_upload button-default">Upload Background Image</a>
                                                    </div>
                                                    <textarea name="" id="" cols="30" rows="10" class="text" > <?php echo trim(stripslashes($slide['caption'])); ?> </textarea>
                                                    
                                                    
                                                    <div class="select-wrapper stageoptions" <?php if($slider_type!="Staged Slider") echo 'style="display:none;"';  ?> >
                                                    	<select name="" id="" class="slide-stage">
                                                        	<?php $t = array("leftstage" => "Left Image" ,"rightstage" => "Right Image","fullstage"=>'Custom Slide');
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($slide['stage']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                    		
                                                    	</select>
                                                    </div>
                                                  
                                                    
                                                    
                                                    <div class="select-wrapper">
                                                    	<select name="" id="" class="slide-link">
                                                        	<?php $t = array("none" => "None" ,"post" => "Link To Post"  ,"portfolio" => "Link To Portfolio"  ,"custom" => "Custom Link");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($l[0]==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                    		
                                                    	</select>
                                                    </div>
                                                    
                                                     <div class="select-wrapper <?php if($l[0]!="post") echo 'hide'; ?> post-wrapper">
                                                    	<select name="" id="" class="post">
                                                    		<?php 
															    $popPosts = new WP_Query();
																$popPosts->query('post_type=post&posts_per_page=-1'); 
																
																while ($popPosts->have_posts()) : $popPosts->the_post();  
																  if( $l[1] == get_the_ID() )
																  echo "<option selected='selected' value='".get_the_ID()."'>".get_the_title()."</option>";
																  else
																  echo "<option value='".get_the_ID()."'>".get_the_title()."</option>";
																endwhile;
																wp_reset_query();
															?>
                                                    	</select>
                                                    </div>
                                                    
                                                    <div class="select-wrapper <?php if($l[0]!="portfolio") echo 'hide'; ?> portfolio-wrapper">
                                                    	<select name="" id="" class="portfolio">
                                                    		<?php 
															    $popPosts = new WP_Query();
																$popPosts->query('post_type=portfolio&posts_per_page=-1'); 
																
																while ($popPosts->have_posts()) : $popPosts->the_post();  
																  if( $l[1] == get_the_ID() )
																  echo "<option selected='selected' value='".get_the_ID()."'>".get_the_title()."</option>";
																  else
																  echo "<option value='".get_the_ID()."'>".get_the_title()."</option>";
																endwhile;
																wp_reset_query();
															?>
                                                    	</select>
                                                    </div>
                                                    
                                                     <div class="select-wrapper <?php if($l[0]!="events") echo 'hide'; ?> events-wrapper">
                                                    	<select name="" id="" class="events">
                                                    		<?php 
															    $popPosts = new WP_Query();
																$popPosts->query('post_type=events&posts_per_page=-1'); 
																
																while ($popPosts->have_posts()) : $popPosts->the_post();  
																  if( $l[1] == get_the_ID() )
																  echo "<option selected='selected' value='".get_the_ID()."'>".get_the_title()."</option>";
																  else
																  echo "<option value='".get_the_ID()."'>".get_the_title()."</option>";
																endwhile;
																wp_reset_query();
															?>
                                                    	</select>
                                                    </div>
                                                    
                                                    <input type="text" value="<?php if($l[0]=="custom") echo $l[1]; else  echo 'http://'; ?>" class="custom_link  <?php if($l[0]!="custom") echo 'hide'; ?> "  />
                                                    
                                                </div>
                                                
                                            </div>
                                        
                                         
                                            
                                        </div>
                                    </li>
         
         <?php
	 }
	  
}

$options_panel = new Slidermanager();