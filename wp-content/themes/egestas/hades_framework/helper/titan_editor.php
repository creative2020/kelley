<?php

class TitanEdior extends Loki {
	
	// init menu
	function __construct () { parent::__construct('Layout Builder','submenu');  }
	
	// setup things before page loads
	function manager_admin_init(){	  parent::manager_admin_init();
	  
	   if(isset($_GET['page']) && $_GET['page']=='LAYOU') :
	   
	   global $wpdb;
	   $table_db_name = $wpdb->prefix . "teditor";
	
	   wp_enqueue_script('jquery-ui-tabs');
	  
		if(isset($_POST["deletekey"]))
		{
		$del_key =  $_POST["deletekey"];
	    $flag = $wpdb->query("DELETE FROM $table_db_name WHERE id='$del_key' ");
		echo $flag;
		die();
		}
		
		if(isset($_POST['action']))
		{
			$db_operation = 'fail';
			$data = ($_POST['values']);
  			$title =  $_POST['layout'];
			$mode =  $_POST['mode'];
			$key =  $_POST['key'];
			
			
			
			if(isset($key ))
			{
				$db_operation = $wpdb->update( $table_db_name, 
												array( 
												'id' => $key , 
												'title' => $title, 
												'layout' => serialize($data), 
												'options' => $mode, 
												 ) ,
												 array(  'id' => $key  )
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
												'id' => $key , 
												'title' => $title, 
												'layout' => serialize($data), 
												'options' => $mode, 
												 )  
											  );
			}
			
			echo $key;
			
			die();
		}
		
		
	   endif;
	
	 }	
	
	// the markup
	
	function manager_admin_wrap(){	
	global  $super_options ,$wpdb;
	$table_db_name = $wpdb->prefix . "teditor";
	$templates =  $wpdb->get_results("SELECT id,title FROM $table_db_name ",ARRAY_A);
	
	
	?>
	
    <script type="text/javascript">
  
jQuery(document).ready(function($){
	
	var temp,i,j,obj,parent;
	var url = '<?php echo admin_url().'admin.php?page=LAYOU'; ?>';
	var loc = "<?php echo HURL; ?>/helper/shortcode_listener.php";

	var tabs = $( "#option-panel-tabs" ).tabs({
		
		
		add: function( event, ui ) {
			
		   $( ui.panel ).addClass('hades_section').append( $('.tab-clone').children().append() );
		 
		   $( ui.panel ).find('.layout_title').val($(ui.tab).find('span').html());
		   
		   $("#hades_option_form").append($( ui.panel ));
		    
			$(  ui.tab ).css({'color':'#ffffff','text-shadow':'none'});
		    $(  ui.tab ).animate({ backgroundColor: "#1aa2e1" }, 200 , function(){  $(this).animate({  backgroundColor: "#fefefe" },400,function(){ $(this).removeAttr('style'); });   });
			
		}
		});	
	$('.canvas-area a.edit-icon').live('click',function(e){
		e.preventDefault();
		$(this).toggleClass('minus-icon');
		$(this).parents('li').toggleClass('active');
		
		$(this).parent().next().slideToggle('normal');
		
		});
	
	$('.canvas-area a.delete-icon').live('click',function(e){
		e.preventDefault();
		
		$(this).parents('li').slideUp('normal',function(){ $(this).remove(); });
		
		});	
	
	$('.slider-body ').sortable({ placeholder: 'ui-state-highlight' });
	
	$('.canvas-area').sortable({   stop: function(event, ui) {  $(ui.item).parents('.hades_subpanel').find('.save_tab').trigger('click'); } ,  placeholder: 'ui-state-highlight' });
    
	
	$('.add_element').click(function(e){
		$('.tab-loading-icon').animate({opacity:1},'fast',function(){ $(this).animate({opacity:0},'slow'); });
		e.preventDefault();
		obj = $(this).parent().find('select.element_selector').val();
		
		temp = $('.clonable').find('.'+obj).clone();
		
		$(this).parents('.hades_subpanel').find('.canvas-area').append(temp);
		
		$(this).parents('.hades_subpanel').find('.slider-body ').sortable({ placeholder: 'ui-state-highlight' });
		
		});
	
	var data = Array();
	
	$('.save_tab').click(function(e){
		e.preventDefault();
		
		data = Array();
		
		$('.tab-loading-icon').animate({opacity:1},'slow');
		parent = $(this).parents('.editor-panel');
		var layout = parent.find('.layout_title').val();
		var mode = parent.find('.mode').val();
		var key  = parent.find('.key').val();
		
		
		$(this).parents('.hades_subpanel').find('.canvas-area').find('li').each(function(i){
		   
		   temp = [ $(this).find('.elements').val() ];
		   
		   if($(this).hasClass('columns'))
		   {
			   var row = [];
			    $(this).find('.col').each(function(i){
				 
				  row[i] = { 'title' : $(this).find('.title').val(),'subtitle' : $(this).find('.subtitle').val(),'behavior' : $(this).find('.image_behavior').val(), 'text' : $(this).find('.text').val(),'img_src' : $(this).find('.img_src').val()  }
				  
				});	
				
				temp[1] = row;
				temp[2] = $(this).find('.propotional').val();
		   }
		   else if($(this).hasClass('full-width-textarea'))
		   {
			  temp[1] =  { 'text' : $(this).find('textarea').val() } ;
		   }
		   else if ($(this).hasClass('full-width-divider'))
		   {
			   temp[1] =  $(this).find('select').val() ;
		   }
		    else if ($(this).hasClass('intro-text'))
		   {
			   temp[1] =  { 'title' : $(this).find('.title').val(),'text' : $(this).find('.text').val(), 'label' : $(this).find('.label').val(),'link' : $(this).find('.link').val() , 'Layout' :  $(this).find('.layout').val() }
		   }
		   else if( $(this).hasClass('custom-post') || $(this).hasClass('scrollable-post') )
		   {
			   temp[1] =  { 'title' : $(this).find('.title').val(),'description' : $(this).find('.description').val(),'no_of_posts' : $(this).find('.no_of_posts').val(), 'category' : $(this).find('.category').val(),'excerpt' : $(this).find('.excerpt').val(),'post_type' : $(this).find('.post_type').val() ,'button_label' : $(this).find('.button_label').val() ,'button_link' : $(this).find('.button_link').val() , 'link_type' : $(this).find('.link_type').val() , 'Layout' :  $(this).find('.layout').val() , 'label' : $(this).find('.label').val(),'link' : $(this).find('.link').val()}
		   }
		   else if( $(this).hasClass('custom-info-post')  )
		   {
			  temp[1] =  { 'title' : $(this).find('.title').val(),'description' : $(this).find('.description').val(), 'excerpt' : $(this).find('.excerpt').val(),'post_type' : $(this).find('.post_type').val() ,'button_label' : $(this).find('.button_label').val() ,'button_link' : $(this).find('.button_link').val() , 'link_type' : $(this).find('.link_type').val() }
		   }
		   else if( $(this).hasClass('twitter') )
		   {
			   temp[1] =  { 'title' : $(this).find('.title').val(),'username' : $(this).find('.username').val(), 'tweets' : $(this).find('.tweets').val() , 'Layout' :  $(this).find('.layout').val() }
		   }
		   else if ( $(this).hasClass('page-post-content') )
		   {
			   temp[1] =    { 'id' :  $(this).find('.page-content').val() , 'Layout' :  $(this).find('.layout').val() }; 
		   }
		    else if ( $(this).hasClass('slider') )
		   {
			   temp[1] =  { 'id' : $(this).find('.slider_id').val() , 'Layout' :  $(this).find('.layout').val() };
		   } 
		   else if ( $(this).hasClass('pricing-table') )
		   {
			   temp[1] =  { 'id' :  $(this).find('.pricing_id').val() , 'Layout' :  $(this).find('.layout').val() }; 
			   
		   }
		    else if ( $(this).hasClass('testimonials') )
		   {
			   temp[1] =  { 'title' : $(this).find('.title').val(),  'no_of_posts' : $(this).find('.no_of_posts').val(), 'category' : $(this).find('.category').val(), 'text' : $(this).find('.text').val() }
			   
		   }
		    else if ( $(this).hasClass('events') )
		   {
			   temp[1] =  { 'title' : $(this).find('.title').val() }
			   
		   }
		   
			
			
			data[i] =  temp ;
			
			});
		
		
		
		$.post(url,{ action:'save', values:data , layout:layout , mode:mode ,key:key },function(data){
			$('.tab-loading-icon').animate({opacity:0},'slow');
			
			
			if(data!="")
			if(parent.find('.key').length==0)
			 parent.prepend("<input class='key' type='hidden' value="+data+" />");
			 $(".cbox").stop(true,true).fadeIn("normal",function(){  $(".cbox").delay(2000).fadeOut('normal')     });
					  
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
		 
		 
		 temp = $('.add_tab').val().replace(' ','_').toLowerCase();
		 tabs.tabs( "add", "#" + temp, $('.add_tab').val() );
		 
		 });	
		 
	$('.delete-tab').live("click",function(e){
		e.preventDefault();
		$('.tab-loading-icon').animate({opacity:1},'slow');
		var key  = $(this).parents('.hades_options').find('.key').val();
		
		$.post(url,{deletekey:key },function(data){
			$('.tab-loading-icon').animate({opacity:0},'slow');
			
			
				var index =  tabs.tabs( "option", "selected" );
				tabs.tabs( "remove", index );
		
			
			});
		});	 
		var textarea = null;
	$('.insert_shortcode').live('change',function(){
		
		temp = $(this).val();
		textarea = $(this).parent().next();
		switch(temp)
		{
			case "icon":    tb_show('Insert Shortcode',"#TB_inline"); 
							 jQuery("#TB_ajaxContent").load(loc+"?type=icons");
										jQuery("#TB_ajaxContent").css({ 
										  
										  width: jQuery("#TB_ajaxContent").parent().width()-30,
										  height: jQuery("#TB_ajaxContent").parent().height()-40
										});
							 break;
							 
			case "image":   
		                  
						 $(this).parent().parent().find('.image_upload').trigger('click');
						
					
							 break;				 
			case "button" :   tb_show('Insert Shortcode',"#TB_inline"); 
		 jQuery("#TB_ajaxContent").load(loc+"?type=button");
					jQuery("#TB_ajaxContent").css({ 
					  
					  width: jQuery("#TB_ajaxContent").parent().width(),
					  height: jQuery("#TB_ajaxContent").parent().height()-30,
                      margin: 0 , padding: 0 , overflow:"auto"
					 }); break;		
		   	case "video" :    textarea.insertAtCaret("[titanvideo width='300' height='250' /]your url here[/titanvideo]");  break;						 
			case "quote": textarea.insertAtCaret("[titanquotes]your quote here[/titanquotes]");  break;						 
            case "quote_left":  textarea.insertAtCaret("[titanquote_left]your quote here[/titanquote_left]");  break;						 
            case "quote_right":  textarea.insertAtCaret("[titanquote_right]your quote here[/titanquote_right]");  break;				 
            case "pre":textarea.insertAtCaret("[titanpre]YOUR CODE HERE[/titanpre]");  break;		
			
			case "error":textarea.insertAtCaret("[titanerror_box title='your title']YOUR MESSAGE HERE[/titanerror_box]");  break;		
            case "warning":textarea.insertAtCaret("[titanwarning_box title='your title']YOUR MESSAGE HERE[/titanwarning_box]");  break;		
            case "success":textarea.insertAtCaret("[titansuccess_box title='your title']YOUR MESSAGE HERE[/titansuccess_box]");  break;			
            case "info":textarea.insertAtCaret("[titaninformation_box title='your title']YOUR MESSAGE HERE[/titaninformation_box]");  break;		
            case "tooltip":textarea.insertAtCaret('[titantooltip tip_data="your title" ] your text [/titantooltip]');  break;		
            case "popover":textarea.insertAtCaret('[titanpopover title="your title" data="your popver content here" ]your text here[/titanpopover]');  break;		
           case "tabs":textarea.insertAtCaret('[titantabs][titantab title="your tab1 title"] your content here... [/titantab][/titantabs]');  break;		
           case "accordion" :textarea.insertAtCaret('[titanaccordion][titansection  title="your tab1 title" collapse="false" ] your content here...  [/titansection][/titanaccordion]');  break;		
           case "toggle" :textarea.insertAtCaret('[titantoggle  title="your tab1 title" collapse="false" ] your content here...  [/titantoggle]');  break;		
           case "map" :textarea.insertAtCaret("[titanmap address='' width='300' height='' /]");  break;		
           case "twitter" :textarea.insertAtCaret('[titantweet name="yourusername" hashtags="test1,test2,test3" text="exicting offers" type="none" /]');  break;		
           case "facebook" :textarea.insertAtCaret('[titanfacebook layout="standard"/]');  break;		
           case "google" :textarea.insertAtCaret('[titangoogle size="small"/]');  break;		
           case "digg" :textarea.insertAtCaret('[titandigg size="Compact"]');  break;		
           case "stumble" :textarea.insertAtCaret('[titanstumbleupon layout=1 /]');  break;		
           case "pinfollow" :textarea.insertAtCaret('[titanpinterestfollow  user=""  /]');  break;		
           case"pinpin" :textarea.insertAtCaret('[titanpinterest on_url="" to_url="" /]');  break;		
                                                             
							 
		}
		
		});	
	
	$(".done_shortcode").die('click');
	$(".done_shortcode").live("click",function(e){
		  e.preventDefault();
		 
		  if($(".shortcode_value").val()=="image")
		  {
			   var temp = jQuery("#TB_ajaxContent"),button = "[titanbutton radius='"+$("#shortcode_border_radius").val()+"px' background='"+rgb2hex(temp.find("#bgcolorSelector>div").css("background-color"))+"'  border='"+rgb2hex(temp.find("#bgcolorSelector>div").css("background-color"))+"' color='"+rgb2hex(temp.find("#colorSelector>div").css("background-color"))+"' link='"+temp.find("#shortcode_link").val()+"' window='"+temp.find("#new_window_button").val()+"' size='"+temp.find("#new_size_button").val()+"'] "+temp.find("#button_title").val()+" [/titanbutton] ";
			   
			 textarea.insertAtCaret(button);
		  }
		 
		    else if($(".shortcode_value").val()=="icons")
		   {
			     var temp = jQuery("#TB_ajaxContent"),form = "[titanicon name='"+temp.find("#shortcode-contact-preview").val()+"' color='"+temp.find("#icon-color").val()+"' /] ";
			     textarea.insertAtCaret(form);
		   }
		
		  
		  
			tb_remove();
		
		});	

	
});


    </script>
	
    
    <div class="hades_panel_wrap"> <!-- Panel Wrapper -->
		
         <div class="cbox success">
          <div class="cbox-head">yippie, you did it  </div>
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
                <li><a href="#starter"> Quick Start </a></li>
               <li class="slider" ><a href="#home_page"> Home Page </a></li>
               
               <?php 
			   foreach($templates as $template)
			   {
				   if($template['id']!="1")
				   echo  " <li><a href=\"#".strtolower(str_replace(" ","_",$template["title"]))."\"> <span>$template[title]</span> </a></li>";
			   }
			   ?>
               
                </ul>  <!-- End of Side Menu -->
       			
                
                <div id="panel-wrapper" class="clearfix">
                 
                <form method="post"  enctype="multipart/form-data" action="" class="clearfix" id="hades_option_form" >
                
                  
                  <div class='hades_section' id="starter"> 
                  	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>&nbsp;</a> </h3> 
                            <div class='hades_subpanel'>  
                               <div class="information">
                              <p>
                              Layout Editor allows you to create components on the fly. For more information read the documentation by following the link below.

                            </p>
                           
                            
                            <p> <a href="http://wptitans.com/doc/egestas/index.html" id="tour" target="_blank" class="button-default help-doc"> Read Documentation  </a>  </p> 
                            
                            
                           
                            
                            
                            <div class="message warning_box">
                            	<p class="widget-content">Input Field cannot be empty  or have same name as existing Slideshow !</p>
                            </div>
                            
                            <div class="hades_input add_tab_pane clearfix">
                            	<input type="text" class="add_tab" /><a href="" class="button-default" id="init_tab">Add Template</a>
                            </div>
                              
                            </div>
                            </div>  
                        </div> 
                     </div> 
                  </div>
                   <div class='hades_section' id="home_page"> 
                  	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Builder </a>  </h3> 
                            <div class='hades_subpanel'>  
                            
                            <div class="editor-panel clearfix">
                            	<input type="hidden" value="Home" class="layout_title" />
                                <input type="hidden" value="update" class="mode" />
                                 <input type="hidden" value="1" class="key" />  
                               
                                 
                                 <div class="hades_input clearfix layout_element">
                                	  <label for="">Select Element </label>
                                  	  <div class="select-wrapper clearfix">
                                		  <select name="" class="element_selector">
                                          	 <option value="full-width-textarea">Full Width Text Section</option>
                                             
                                             <option value="two-column">Two Column Section</option>
                                             <option value="three-column">Three Column Section</option>
                                             <option value="four-column">Four Column Section</option>
                                             
                                             <option value="full-width-divider">Divider</option>
                                             <option value="intro-text">Intro Text Section</option>
                                             <option value="custom-post">Post Section</option>
                                             <option value="twitter">Twitter Section</option>
                                              <option value="scrollable-post">Scrollable Section</option>
                                             <option value="pricing-table">Pricing Table Section</option>
                                             
                                             <option value="slider">Slider Widget</option>
                                             <option value="page-post-content">Page Content</option>
                                          </select>
                                  	 </div>
                                 	 <a href="" class="button-default add_element">Add Element</a>   
                                     <a href="" class="button-save save_tab">Save</a>   
                                 </div>
                                 
                            </div>
                            
                             <ul class="canvas-area clearfix">
                             	<?php   $this->contentGenerator(1); ?>
                             </ul>
                              
                            
                            
                            </div>  
                        </div> 
                     </div> 
                  </div>
                 
                  
                  <?php 
				  
				   foreach($templates as $template) :   if($template['id']!="1") : ?>
                   
                    <div class='hades_section' id="<?php echo strtolower(str_replace(" ","_",$template["title"])) ?>"> 
                  	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Builder </a> <span class="delete-tab"></span>  </h3> 
                            <div class='hades_subpanel'>  
                            
                            <div class="editor-panel clearfix">
                            	<input type="hidden" value="<?php echo $template["title"] ?>" class="layout_title" />
                                <input type="hidden" value="update" class="mode" />
                                 <input type="hidden" value="<?php echo $template["id"] ?>" class="key" />  
                                
                                 
                                 <div class="hades_input clearfix layout_element">
                                	  <label for="">Select Element </label>
                                  	  <div class="select-wrapper clearfix">
                                		  <select name="" class="element_selector">
                                          	 <option value="full-width-textarea">Full Width Text Section</option>
                                             
                                             <option value="two-column">Two Column Section</option>
                                             <option value="three-column">Three Column Section</option>
                                             <option value="four-column">Four Column Section</option>
                                             
                                             <option value="full-width-divider">Divider</option>
                                             <option value="intro-text">Intro Text Section</option>
                                             <option value="custom-post">Post Section</option>
                                             <option value="twitter">Twitter Section</option>
                                              <option value="scrollable-post">Scrollable Section</option>
                                             <option value="pricing-table">Pricing Table Section</option>
                                             
                                             <option value="slider">Slider Widget</option>
                                             <option value="page-post-content">Page Content</option>
                                          </select>
                                  	 </div>
                                 	 <a href="" class="button-default add_element">Add Element</a>   
                                     <a href="" class="button-save save_tab">Save</a>   
                                 </div>
                                 
                            </div>
                            
                             <ul class="canvas-area clearfix">
                             	<?php   $this->contentGenerator($template['id']); ?>
                             </ul>
                              
                            
                            
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
	
    
    
    
    <div class="hide tab-clone">
    	          	<div class='hades_options'>	 
                    	<div class='subpanel'> 
                        	<h3 class='subtitle-heading'> <a href='#'>Builder </a> <span class="delete-tab"></span> </h3> 
                            <div class='hades_subpanel'>  
                            
                             <div class="editor-panel clearfix">
                            	<input type="hidden" value="Home" class="layout_title" />
                                <input type="hidden" value="update" class="mode" />
                              
                                 
                                 <div class="hades_input clearfix layout_element">
                                	  <label for="">Select Element </label>
                                  	  <div class="select-wrapper clearfix">
                                		  <select name="" class="element_selector">
                                          	 <option value="full-width-textarea">Full Width Text Section</option>
                                             
                                             <option value="two-column">Two Column Section</option>
                                             <option value="three-column">Three Column Section</option>
                                             <option value="four-column">Four Column Section</option>
                                             
                                             <option value="full-width-divider">Divider</option>
                                             <option value="intro-text">Intro Text Section</option>
                                             <option value="custom-post">Post Section</option>
                                             <option value="twitter">Twitter Section</option>
                                              <option value="scrollable-post">Scrollable Section</option>
                                             <option value="pricing-table">Pricing Table Section</option>
                                             
                                             <option value="slider">Slider Widget</option>
                                             <option value="page-post-content">Page Content</option>
                                          </select>
                                  	 </div>
                                 	 <a href="" class="button-default add_element">Add Element</a>   
                                     <a href="" class="button-save save_tab">Save</a>   
                                 </div>
                                 
                            </div>
                            
                             <ul  class="canvas-area clearfix">  </ul>
                              
                            
                            
                            </div>  
                        </div> 
                    
    </div>
    
    	
        
    <div class="clonable hide">    
    <ul>
  		  <li class="clearfix full-width-textarea">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Full Width Text </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        
                                      		
                                             
                                            <div> 
                                      		<a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	  
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                        	<textarea name="text" id="" cols="30" rows="10" class="hades_ui">Enter text ( HTML and Shortcodes Supported )</textarea></div>
                                        	<input type="hidden" value="full-width" name="elements" class="elements" />
                                        </div>
                                    </li>
                             
  		  <li class="clearfix columns two-column">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Two Column Widget </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <div class="hades_input clearfix">
                                            <label for="">Layout Proportion</label>
                                            	<div class="select-wrapper clearfix">
                                                	  
                                                      <select name="propotional" id="" class="propotional">
                                                         
                                                         <option value="one_half,one_half_last">1/2 : 1/2</option>
                                                         <option value="one_third,two_third_last">1/3 : 2/3</option>
                                                         <option value="two_third,one_third_last">2/3 : 1/3</option>
                                                         <option value="one_fourth,three_fourth_last">1/4 : 3/4</option>
                                                         <option value="three_fourth,one_fourth_last">3/4 : 1/4</option>
                                                         <option value="one_fifth,four_fifth_last">1/5 : 4/5</option>
                                                         <option value="four_fifth,one_fifth_last">4/5 : 1/5</option>
                                                         
                                                      </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col clearfix">
                                              <h4>Column 1</h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                         <option value="none">None</option>
                                                         <option value="icon">Icon</option>
                                                         <option value="top_image">Top Image</option>
                                                         
                                                      </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                              		<input type="hidden" name="img_src" class="img_src" value="" /><img src="" class="hide" />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="Enter Title" />
                                                 <input type="text" name="title" class="hades_ui subtitle" placeholder="Enter Subtitle" />
                                                 <div>
                                                <a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	  
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text">Enter text ( HTML and Shortcodes Supported )</textarea>
                                                </div>
                                              </div>
                                              
                                            </div>
                                            
                                            <div class="col clearfix">
                                              <h4>Column 2</h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                     	 <option value="none">None</option>
                                                         <option value="icon">Icon</option>
                                                         <option value="top_image">Top Image</option>
                                                         
                                                      </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                              		<input type="hidden" name="img_src" class="img_src" value="" /><img src="" class="hide" />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="Enter Title" />
                                                <input type="text" name="title" class="hades_ui subtitle" placeholder="Enter Subtitle" /> <div>
                                                <a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	  
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text">Enter text ( HTML and Shortcodes Supported )</textarea>
                                                </div>
                                              </div>
                                              
                                            </div>
                                            
                                            
                                        	<input type="hidden" value="two-columns" name="elements" class="elements" />
                                        </div>
                                        
                                        
                                    </li>
        <li class="clearfix columns  three-column">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Three Column Widget </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	 <div class="hades_input clearfix">
                                              <label for="">Layout Proportion</label>
                                            	<div class="select-wrapper clearfix">
                                                	 
                                                      <select name="propotional" id="" class="propotional">
                                                         
                                                         <option value="one_third,one_third,one_third_last">1/3 : 1/3 :1/3</option>
                                                         <option value="one_half,one_fourth,one_fourth_last">1/2 : 1/4 : 1/4</option>
                                                         <option value="one_fourth,one_half,one_fourth_last">1/4 : 1/2 : 1/4</option>
                                                         <option value="one_fourth,one_fourth,one_half_last">1/4 : 1/4 : 1/2</option>
                                                         
                                                      </select>
                                                </div>
                                            </div>
                                           <div class="col clearfix">
                                              <h4>Column 1</h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                      <option value="none">None</option>
                                                         <option value="icon">Icon</option>
                                                         <option value="top_image">Top Image</option>
                                                         
                                                      </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                              		<input type="hidden" name="img_src" class="img_src" value="" /><img src="" class="hide" />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="Enter Title" />
                                                <input type="text" name="title" class="hades_ui subtitle" placeholder="Enter Subtitle" /><div>
                                                <a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	  
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text">Enter text ( HTML and Shortcodes Supported )</textarea>
                                                </div>
                                              </div>
                                              
                                            </div>
                                            
                                           <div class="col clearfix">
                                              <h4>Column 2</h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                      <option value="none">None</option>
                                                         <option value="icon">Icon</option>
                                                         <option value="top_image">Top Image</option>
                                                         
                                                      </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                              		<input type="hidden" name="img_src" class="img_src" value="" /><img src="" class="hide" />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="Enter Title" />
                                                <input type="text" name="title" class="hades_ui subtitle" placeholder="Enter Subtitle" /><div>
                                                <a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	  
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text">Enter text ( HTML and Shortcodes Supported )</textarea>
                                                </div>
                                              </div>
                                              
                                            </div>
                                            
                                            <div class="col clearfix">
                                              <h4>Column 3</h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                      <option value="none">None</option>
                                                         <option value="icon">Icon</option>
                                                         <option value="top_image">Top Image</option>
                                                         
                                                      </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                              		<input type="hidden" name="img_src" class="img_src" value="" /><img src="" class="hide" />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="Enter Title" />
                                                <input type="text" name="title" class="hades_ui subtitle" placeholder="Enter Subtitle" /><div>
                                                <a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	  
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text">Enter text ( HTML and Shortcodes Supported )</textarea>
                                                </div>
                                              </div>
                                              
                                            </div>
                                            
                                            
                                         	<input type="hidden" value="three-columns" name="elements" class="elements" />
                                        </div>
                                        
                                        
                                        
                                        
                                    </li>
         <li class="clearfix columns four-column">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Four Column Widget </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                           <div class="col clearfix">
                                              <h4>Column 1</h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                      	 <option value="none">None</option>
                                                         <option value="icon">Icon</option>
                                                         <option value="top_image">Top Image</option>
                                                         
                                                      </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                              		<input type="hidden" name="img_src" class="img_src" value="" /><img src="" class="hide" />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="Enter Title" />
                                                <input type="text" name="title" class="hades_ui subtitle" placeholder="Enter Subtitle" />
                                                <div>
                                                <a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	  
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text">Enter text ( HTML and Shortcodes Supported )</textarea>
                                                </div>
                                                
                                              </div>
                                              
                                            </div>
                                             <div class="col clearfix">
                                              <h4>Column 2</h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                      	 <option value="none">None</option>
                                                         <option value="icon">Icon</option>
                                                         <option value="top_image">Top Image</option>
                                                         
                                                      </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                              		<input type="hidden" name="img_src" class="img_src" value="" /><img src="" class="hide" />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="Enter Title" />
                                                <input type="text" name="title" class="hades_ui subtitle" placeholder="Enter Subtitle" />
                                                <div>
                                                <a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	  
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text">Enter text ( HTML and Shortcodes Supported )</textarea>
                                                </div>
                                              </div>
                                              
                                            </div>
                                            
                                            <div class="col clearfix">
                                              <h4>Column 3</h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                      	 <option value="none">None</option>
                                                         <option value="icon">Icon</option>
                                                         <option value="top_image">Top Image</option>
                                                         
                                                      </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                              		<input type="hidden" name="img_src" class="img_src" value="" /><img src="" class="hide" />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="Enter Title" />
                                                <input type="text" name="title" class="hades_ui subtitle" placeholder="Enter Subtitle" />
                                                <div>
                                                <a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	  
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text">Enter text ( HTML and Shortcodes Supported )</textarea>
                                                </div>
                                              </div>
                                              
                                            </div>
                                            
                                          <div class="col clearfix">
                                              <h4>Column 4</h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                      	 <option value="none">None</option>
                                                         <option value="icon">Icon</option>
                                                         <option value="top_image">Top Image</option>
                                                         
                                                      </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                              		<input type="hidden" name="img_src" class="img_src" value="" /><img src="" class="hide" />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="Enter Title" />
                                                <input type="text" name="title" class="hades_ui subtitle" placeholder="Enter Subtitle" />
                                                 <div>
                                                <a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	  
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text">Enter text ( HTML and Shortcodes Supported )</textarea>
                                                </div>
                                              </div>
                                              
                                            </div>
                                            
                                        	<input type="hidden" value="four-columns" name="elements" class="elements" />
                                        </div>
                                        
                                        
                                        
                                        
                                    </li>                                    
                                    
                                     <li class="clearfix full-width-divider">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Divider </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	<div class="select-wrapper clearfix">
                                                      <select name="" id="">
                                                      	 <option value="none">None</option>
                                                         <option value="icon">To Top Icon</option>
                                                         <option value="none">None</option>
                                                      </select>
                                                </div>
                                             <input type="hidden" value="full-width-divider" name="elements" class="elements" />   
                                        </div>
                                    </li>
                                    
                                     <li class="clearfix intro-text">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Intro Text </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    		 <div class="select-wrapper">
                                             
                                             
                                            	<select name="" id="" class="layout">
                                                	  <option value="none">Full Width</option>
                                                     <?php $t = array("one_half" => "1/2" ,"one_half_last" => "1/2 Last"  ,"one_third" => "1/3" ,"one_third_last" => "1/3 Last" ,"two_third" => "2/3" ,"two_third_last" => "2/3 Last", "one_fourth" => "1/4" , "one_fourth_last" => "1/4 Last" , "three_fourth" => "3/4" , "three_fourth_last" => "3/4 Last"    );
														 $str = '';
														 foreach($t as $key => $opt)
														 $str = $str. " <option value=\"{$key}\">$opt</option>";
														
														  echo $str;
														  ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	<textarea name="" id="" cols="30" class="title" rows="10"></textarea>
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Text</label>
                                            	<textarea name="" id="" cols="30" class="text" rows="10"></textarea>
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Button Label</label>
                                            	<input type="text" class="label" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Button Link</label>
                                            	<input type="text" class="link" />
                                            </div>
                                            
                                            <input type="hidden" value="intro-text" name="elements" class="elements" />
                                        </div>
                                    </li>
                                    
                                    <li class="clearfix testimonials">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Testimonial Widget </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	<input type="text" class="title" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Text</label>
                                            	<textarea name="" id="" cols="30" class="text" rows="10"></textarea>
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter number of Posts</label>
                                            	<input type="text" class="no_of_posts" />
                                            </div>
                                            
                                             <div class="hades_input clearfix">
                                            	<label for="">Enter Testimonial Group SLUG not name to filter</label>
                                            	<input type="text" class="category" />
                                            </div>
                                            
                                         
                                            
                                            <input type="hidden" value="testimonials" name="elements" class="elements" />
                                        </div>
                                    </li>
                                    
                                    <li class="clearfix events">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Latest Events Widget </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	<input type="text" class="title" />
                                            </div>
                                            
                                         
                                            
                                            <input type="hidden" value="events" name="elements" class="elements" />
                                        </div>
                                    </li>
                                    
                                    
                                     <li class="clearfix custom-post">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Posts </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                             <div class="select-wrapper">
                                            	<select name="" id="" class="layout">
                                                	<option value="one_half">1/2</option>
                                                    <option value="one_half_last">1/2 Last</option>
                                                    <option value="one_third">1/3</option>
                                                    <option value="one_third_last">1/3 Last</option>
                                                    <option value="two_third">2/3</option>
                                                    <option value="two_third_last">2/3 Last</option>
                                                    <option value="one_fourth">1/4</option>
                                                    <option value="one_fourth_last">1/4 Last</option>
                                                    <option value="three_fourth">3/4</option>
                                                    <option value="three_fourth_last">3/4 Last</option>
                                                </select>
                                            </div>
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	<input type="text" class="title" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter number of Posts</label>
                                            	<input type="text" class="no_of_posts" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Exerpt</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="excerpt">
                                                       <option value="yes">Yes</option>
                                                       <option value="no">No</option>
                                                   </select>
                                               </div>
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Select Post Type</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="post_type">
                                                       <option value="post">Post</option>
                                                       <option value="portfolio">Portfolio</option>
                                                      
                                                   </select>
                                               </div>
                                            </div>
                                            
                                                  
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Button Label</label>
                                            	<input type="text" class="label" value=""  />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Button Link</label>
                                            	<input type="text" class="link"  value="" />
                                            </div>
                                            
                                            
                                          <input type="hidden" value="custom-post" name="elements" class="elements" />
                                            
                                            
                                        </div>
                                    </li>
                                    
                                    <li class="clearfix custom-info-post">
                                        
                                        <div class="slider-head clearfix">	
                                        	<h3> Custom Information Posts </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                             <div class="select-wrapper">
                                            	<select name="" id="" class="layout">
                                                	<option value="one_half">1/2</option>
                                                    <option value="one_half_last">1/2 Last</option>
                                                    <option value="one_third">1/3</option>
                                                    <option value="one_third_last">1/3 Last</option>
                                                    <option value="two_third">2/3</option>
                                                    <option value="two_third_last">2/3 Last</option>
                                                    <option value="one_fourth">1/4</option>
                                                    <option value="one_fourth_last">1/4 Last</option>
                                                    <option value="three_fourth">3/4</option>
                                                    <option value="three_fourth_last">3/4 Last</option>
                                                </select>
                                            </div>
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        
                                    	 <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	<input type="text" class="title" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter description</label>
                                            	<textarea class="description" name="" id="" cols="30" rows="10"></textarea>
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Exerpt</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="excerpt">
                                                       <option value="yes">Yes</option>
                                                       <option value="no">No</option>
                                                   </select>
                                               </div>
                                            </div>
                                             <div class="hades_input clearfix">
                                            	<label for="">Link Type</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="link_type">
                                                        <?php $t = array("lightbox" => "Open In Lightbox" ,"post" => "Link to Post");
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
                                            	<label for="">Select Post Type</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="post_type">
                                                       <option value="post">Post</option>
                                                       <option value="portfolio">Portfolio</option>
                                                       
                                                   </select>
                                               </div>
                                            </div>
                                          
                                          	 <div class="hades_input clearfix">
                                            	<label for="">Enter Button Label</label>
                                            	<input type="text" class="button_label" />
                                            </div>
                                            
                                            	 <div class="hades_input clearfix">
                                            	<label for="">Enter Button Link</label>
                                            	<input type="text" class="button_link" />
                                            </div>
                                              
                                          
                                            <input type="hidden" value="custom-info-post" name="elements" class="elements" />
                                            
                                        </div>
                                    </li>
                                    
                                     <li class="clearfix scrollable-post">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Scrollable Post </h3>
                                            
                                            <div class="select-wrapper">
                                            	<select name="" id="" class="layout">
                                                    <option value="none">Full Width</option>
                                                	<option value="one_half">1/2</option>
                                                    <option value="one_half_last">1/2 Last</option>
                                                    <option value="one_third">1/3</option>
                                                    <option value="one_third_last">1/3 Last</option>
                                                    <option value="two_third">2/3</option>
                                                    <option value="two_third_last">2/3 Last</option>
                                                    <option value="one_fourth">1/4</option>
                                                    <option value="one_fourth_last">1/4 Last</option>
                                                    <option value="three_fourth">3/4</option>
                                                    <option value="three_fourth_last">3/4 Last</option>
                                                </select>
                                            </div>
                                            
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                           
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	<input type="text" class="title" />
                                            </div>
                                            
                                               <div class="hades_input clearfix">
                                            	<label for="">Enter description</label>
                                            	<textarea class="description" name="" id="" cols="30" rows="10"></textarea>
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter number of Posts</label>
                                            	<input type="text" class="no_of_posts" />
                                            </div>
                                            
                                             <div class="hades_input clearfix">
                                            	<label for="">Enter category SlUG not name</label>
                                            	<input type="text" class="category" />
                                            </div>
                                            <div class="hades_input clearfix">
                                            	<label for="">Exerpt</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="excerpt">
                                                       <option value="yes">Yes</option>
                                                       <option value="no">No</option>
                                                   </select>
                                               </div>
                                            </div>
                                             <div class="hades_input clearfix">
                                            	<label for="">Link Type</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="link_type">
                                                        <?php $t = array("lightbox" => "Open In Lightbox" ,"post" => "Link to Post");
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
                                            	<label for="">Select Post Type</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="post_type">
                                                       <option value="post">Post</option>
                                                       <option value="portfolio">Portfolio</option>
                                                   </select>
                                               </div>
                                            </div>
                                            
                                         
                                          <input type="hidden" value="scrollable-post" name="elements" class="elements" />  
                                            
                                        </div>
                                    </li>
                                    
                                     <li class="clearfix twitter">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Twitter </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                             <div class="select-wrapper">
                                            	<select name="" id="" class="layout">
                                                    <option value="none">Full Width</option>
                                                	<option value="one_half">1/2</option>
                                                    <option value="one_half_last">1/2 Last</option>
                                                    <option value="one_third">1/3</option>
                                                    <option value="one_third_last">1/3 Last</option>
                                                    <option value="two_third">2/3</option>
                                                    <option value="two_third_last">2/3 Last</option>
                                                    <option value="one_fourth">1/4</option>
                                                    <option value="one_fourth_last">1/4 Last</option>
                                                    <option value="three_fourth">3/4</option>
                                                    <option value="three_fourth_last">3/4 Last</option>
                                                </select>
                                            </div>
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	<input type="text" class="title" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter username</label>
                                            	<input type="text" class="username" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter number of tweets</label>
                                            	<input type="text" class="tweets" />
                                            </div>
                                            
                                           
                                            <input type="hidden" value="twitter" name="elements"  class="elements"/>
                                        </div>
                                    </li>
                                    
                                     <li class="clearfix pricing-table">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Pricing Table </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a> 
                                             <div class="select-wrapper">
                                            	<select name="" id="" class="layout">
                                                    <option value="none">Full Width</option>
                                                	<option value="one_half">1/2</option>
                                                    <option value="one_half_last">1/2 Last</option>
                                                    <option value="one_third">1/3</option>
                                                    <option value="one_third_last">1/3 Last</option>
                                                    <option value="two_third">2/3</option>
                                                    <option value="two_third_last">2/3 Last</option>
                                                    <option value="one_fourth">1/4</option>
                                                    <option value="one_fourth_last">1/4 Last</option>
                                                    <option value="three_fourth">3/4</option>
                                                    <option value="three_fourth_last">3/4 Last</option>
                                                </select>
                                            </div>
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                           <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="pricing_id">
                                                       <?php
													 
													 $table_db_name = $wpdb->prefix . "megatables";
													 $tables =  $wpdb->get_results("SELECT * FROM $table_db_name ",ARRAY_A);
													 
													 foreach($tables as $table)
														{
														
															
																	echo "<option value='$table[id]'>".$table["table_name"]."</option>";
															
														}
													 ?>
                                                   </select>
                                               </div>
                                            <input type="hidden" value="pricing-table" name="elements" class="elements" />
                                        </div>
                                    </li>
                                    
                                     <li class="clearfix slider">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Slider Widget </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                             <div class="select-wrapper">
                                            	<select name="" id="" class="layout">
                                                    <option value="none">Full Width</option>
                                                	<option value="one_half">1/2</option>
                                                    <option value="one_half_last">1/2 Last</option>
                                                    <option value="one_third">1/3</option>
                                                    <option value="one_third_last">1/3 Last</option>
                                                    <option value="two_third">2/3</option>
                                                    <option value="two_third_last">2/3 Last</option>
                                                    <option value="one_fourth">1/4</option>
                                                    <option value="one_fourth_last">1/4 Last</option>
                                                    <option value="three_fourth">3/4</option>
                                                    <option value="three_fourth_last">3/4 Last</option>
                                                </select>
                                            </div>
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                           <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="slider_id" >
                                                     <?php
													 
													 $table_db_name = $wpdb->prefix . "tslidermanager";
													 $sliders =  $wpdb->get_results("SELECT * FROM $table_db_name ",ARRAY_A);
													 
													 foreach($sliders as $slider)
														{
															if($slider['id']!="1") :
																$op = unserialize($slider['options']);
																echo "<option value='$slider[id]'>".$op['title']."</option>";
															endif;
														}
													 ?>
                                                   </select>
                                               </div>
                                            <input type="hidden" value="slider" name="elements" class="elements" />
                                        </div>
                                    </li>
                                    
                                      <li class="clearfix page-post-content">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Page Content </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                           
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                           <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="page-content">
                                                       <?php 
															    $popPosts = new WP_Query();
																$popPosts->query('post_type=page&posts_per_page=-1'); 
																
																while ($popPosts->have_posts()) : $popPosts->the_post();  
																
																  echo "<option value='".get_the_ID()."'>".get_the_title()."</option>";
																endwhile;
																wp_reset_query();
															?>
                                                   </select>
                                               </div>
                                            <input type="hidden" value="page-post-content" name="elements" class="elements" />
                                        </div>
                                    </li>
    </ul>
    </div>
	
	<?php
	  
	   }	  
	
	
	public function contentGenerator($id)
 {
	 global $wpdb;
	 $table_db_name = $wpdb->prefix . "teditor";
	 $table = $wpdb->get_row("SELECT * FROM $table_db_name where id='{$id}' ",ARRAY_A);
	 
	 $layout = unserialize($table['layout']);
	  if( !is_array($layout) ) $layout = array(); 
	 foreach($layout as $element)
	 {
		 
		  
		 switch($element[0])
		 {
	
		   case 'pricing-table' : ?>
			
             <li class="clearfix pricing-table">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Pricing Table </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                             <div class="select-wrapper">
                                             
                                             
                                            	<select name="" id="" class="layout">
                                                	  <option value="none">Full Width</option>
                                                     <?php $t = array("one_half" => "1/2" ,"one_half_last" => "1/2 Last"  ,"one_third" => "1/3" ,"one_third_last" => "1/3 Last" ,"two_third" => "2/3" ,"two_third_last" => "2/3 Last", "one_fourth" => "1/4" , "one_fourth_last" => "1/4 Last" , "three_fourth" => "3/4" , "three_fourth_last" => "3/4 Last"    );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['Layout']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                </select>
                                            </div>
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                           <div class="select-wrapper clearfix">
                                                     <select name="" id="" class="pricing_id">
                                                     <?php
													 echo 'ID is ' . $element[1];
													 $table_db_name = $wpdb->prefix . "megatables";
													 $tables =  $wpdb->get_results("SELECT * FROM $table_db_name ",ARRAY_A);
													 
													 foreach($tables as $table)
														{
														
																
																if( $element[1] == $table['id'] )
																	echo "<option selected='selected' value='$table[id]'>".$table['table_name']."</option>";
																else
																	echo "<option value='$table[id]'>".$table['table_name']."</option>";
															
														}
													 ?>
                                                   </select>
                                               </div>
                                            <input type="hidden" value="pricing-table" name="elements" class="elements" />
                                        </div>
                                    </li>
			
            <?php
			break;  	 
			 
			case 'slider' : $data  = $element[1]; ?>
			
             <li class="clearfix slider">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Slider Widget </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a> 
                                             <div class="select-wrapper">
                                             
                                             
                                            	<select name="" id="" class="layout">
                                                	  <option value="none">Full Width</option>
                                                     <?php $t = array("one_half" => "1/2" ,"one_half_last" => "1/2 Last"  ,"one_third" => "1/3" ,"one_third_last" => "1/3 Last" ,"two_third" => "2/3" ,"two_third_last" => "2/3 Last", "one_fourth" => "1/4" , "one_fourth_last" => "1/4 Last" , "three_fourth" => "3/4" , "three_fourth_last" => "3/4 Last"    );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['Layout']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                </select>
                                            </div> 
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                           <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="slider_id" >
                                                     <?php
													 
													 $table_db_name = $wpdb->prefix . "tslidermanager";
													 $sliders =  $wpdb->get_results("SELECT * FROM $table_db_name ",ARRAY_A);
													 
													 foreach($sliders as $slider)
														{
															if($slider['id']!="1") :
																$op = unserialize($slider['options']);
																
																
																
																if(  $data['id'] == $slider['id'] )
																	echo "<option selected='selected' value='$slider[id]'>".$op["title"]."</option>";
																else
																	echo "<option value='$slider[id]'>".$op["title"]."</option>";
															endif;
														}
													 ?>
                                                   </select>
                                               </div>
                                            <input type="hidden" value="slider" name="elements" class="elements" />
                                        </div>
                                    </li>
			
            <?php
			break; 
		 	case 'two-columns' : 
			$i=0;
			
			?> 
			
             <li class="clearfix columns two-column">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Two Column Widget </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                             <div class="hades_input clearfix">  <label for="">Layout Proportion</label>
                                            	<div class="select-wrapper clearfix">
                                                	
                                                      <select name="propotional" id="" class="propotional">
                                                        
                                                          <?php $t = array("one_half,one_half_last" => "1/2 : 1/2" ,"one_third,two_third_last" => "1/3 : 2/3" ,"two_third,one_third_last" => "2/3 : 1/3" 
														  ,"one_fourth,three_fourth_last" => "1/4 : 3/4","three_fourth,one_fourth_last" => "3/4 : 1/4"
														  ,"one_fifth,four_fifth_last" => "1/5 : 4/5","four_fifth,one_fifth_last" => "4/5 : 1/5"
														  );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($element[2]==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														 echo $str;
														  ?>
                                                      </select>
                                                </div>
                                            </div>
                                            <?php
											foreach($element[1] as $column)
											{
												?>
												 <div class="col clearfix">
                                              <h4>Column <?php echo $i+1; ?></h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                         <?php $t = array("none" => "None","icon" => "Icon" ,"top_image" => "Top Image");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($column['behavior']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														 echo $str;
														  ?>
                                                       </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                                      <input type="hidden" name="img_src" class="img_src" value="<?php echo $column['img_src'] ?>" /><img src="<?php echo $column['img_src'] ?>"  />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="<?php echo stripslashes($column['title']) ?>" />
                                                <input type="text" name="title" class="hades_ui subtitle" value="<?php echo stripslashes($column['subtitle']) ?>" />
                                                 <div><a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	 
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text"><?php echo stripslashes($column['text']) ?></textarea></div>
                                              </div>
                                              
                                            </div>
												
												<?php
												$i++;
											} ?>
                                           
                                        	<input type="hidden" value="two-columns" name="elements" class="elements" />
                                        </div>
                                    </li>
         <?php	break;
		  
		  
		  case 'three-columns' : 
			$i=0; ?>
			 <li class="clearfix columns three-column">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Three Column Widget </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	 <div class="hades_input clearfix"><label for="">Layout Proportion</label>
                                            	<div class="select-wrapper clearfix">
                                                	  
                                                      <select name="propotional" id="" class="propotional">
                                                         
														  <?php $t = array(
														  					"one_third,one_third,one_third_last" => "1/3 : 1/3 :1/3" ,
																			"one_half,one_fourth,one_fourth_last" => "1/2 : 1/4 : 1/4" ,
																			"one_fourth,one_half,one_fourth_last" => "1/4 : 1/2 : 1/4" ,
																			"one_fourth,one_fourth,one_half_last" => "1/4 : 1/4 : 1/2" );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($element[2]==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														 echo $str;
														  ?>
                                                      </select>
                                                </div>
                                            </div>
                                            <?php
											foreach($element[1] as $column)
											{
												?>
												 <div class="col clearfix">
                                              <h4>Column <?php echo $i+1; ?></h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                        <?php $t = array("none" => "None","icon" => "Icon" ,"top_image" => "Top Image");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($column['behavior']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                         
                                                      </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                                      <input type="hidden" name="img_src" class="img_src" value="<?php echo $column['img_src'] ?>" /><img src="<?php echo $column['img_src'] ?>"  />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="<?php echo stripslashes($column['title']) ?>" /> 
                                                <input type="text" name="title" class="hades_ui subtitle" value="<?php echo stripslashes($column['subtitle']) ?>" />
                                                <div><a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	 
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text"><?php echo stripslashes($column['text']) ?></textarea></div>
                                              </div>
                                              
                                            </div>
												
												<?php
												$i++;
											} ?>
                                           
                                             
                                        	<input type="hidden" value="three-columns" name="elements" class="elements" />
                                        </div>
                                        
                                        
                                    </li> <?php
			
			break;
		
		 case 'four-columns' : 
		$i=0; ?>
			 <li class="clearfix columns four-column">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Four Column Widget </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <?php
											foreach($element[1] as $column)
											{
												?>
												 <div class="col clearfix">
                                              <h4>Column <?php echo $i+1; ?></h4>
                                              <div class="clearfix">
                                                <div class="select-wrapper clearfix">
                                                      <select name="image_behavior" id="" class="image_behavior">
                                                        <?php $t = array("none" => "None","icon" => "Icon" ,"top_image" => "Top Image");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($column['behavior']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                      </select>
                                                </div>
                                                
                                                <p class="clearfix">
                                                      <input type="hidden" name="img_src" class="img_src" value="<?php echo $column['img_src'] ?>" /><img src="<?php echo $column['img_src'] ?>"  />
                                             		<a href="" class="button-default image_upload" title="Add To Column">Upload Image</a>
                                                </p>
                                               
                                              </div>
                                              <div class="clearfix">
                                                <input type="text" name="title" class="hades_ui title" value="<?php echo stripslashes($column['title']) ?>" /> 
                                                <input type="text" name="title" class="hades_ui subtitle" value="<?php echo stripslashes($column['subtitle']) ?>" />
                                                <div><a href="" class="image_upload hide"></a>
                                                <div class="select-wrapper clearfix">
                                                	 
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                              	<textarea name="text" id="" cols="30" rows="10" class="hades_ui text"><?php echo stripslashes($column['text']) ?></textarea></div>
                                              </div>
                                              
                                            </div>
												
												<?php
												$i++;
											} ?>
                                           
                                             
                                        	<input type="hidden" value="four-columns" name="elements" class="elements" />
                                        </div>
                                        
                                        
                                    </li> <?php break;
		  
		 case 'full-width' : 
		$data  = $element[1];
		  ?>
          
          <li class="clearfix full-width-textarea">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Full Width Text </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix "> <a href="" class="image_upload hide"></a>
                                        <div class="select-wrapper clearfix">
                                                	 
                                                      <select name="" id="" class="insert_shortcode">
                                                         
                                                         <option value="none">Insert Shortcodes/Media</option>
<option value="image">Insert Image</option>
                                                         
                                                         <option value="icon">Icons</option> 	
                                                         <option value="button">Button</option>
                                                         <option value="video">Video(Youtube/Vimeo)</option>
                                                        
                                                         <optgroup label="Typography">
                                                           <option value="quote">Quote</option>
                                                           <option value="quote_left">Quote Left</option>
                                                           <option value="quote_right">Quote Right</option>
                                                           <option value="pre">PRE</option>
                                                         </optgroup>
                                                        
                                                        
                                                        <optgroup label="UI">
                                                          <option value="error">Error Box</option>
                                                          <option value="warning">Warning Box</option>
                                                          <option value="success">Success Box</option>
                                                          <option value="info">Information Box</option>
                                                          <option value="tooltip">Tooltip</option>
                                                          <option value="popover">PopUps</option>
                                                        </optgroup>
                                                        
                                                           <optgroup label="Widgets">
                                                          <option value="tabs">Tabs</option>
                                                          <option value="accordion">Accordion</option>
                                                          <option value="toggle">Toggle</option>
                                                          <option value="map">Google Map</option>
                                                        
                                                        </optgroup>
                                                        
                                                        
                                                          <optgroup label="Social Buttons">
                                                          <option value="twitter">Twitter</option>
                                                          <option value="facebook">Facebook</option>
                                                          <option value="google">Google+</option>
                                                          <option value="digg">Digg</option>
                                                          <option value="stumble">StumbleUpon</option>
                                                          <option value="pinfollow">Pinterest Follow</option>
                                                          <option value="pinpin">Pinterest Pin</option>
                                                             
                                                        
                                                        </optgroup>
                                                        
                                                      </select>
                                                </div>
                                                
                                        	<textarea name="text" id="" cols="30" rows="10" class="hades_ui"> <?php echo stripslashes($data['text']); ?></textarea>
                                        	<input type="hidden" value="full-width" name="elements" class="elements" />
                                        </div>
                                    </li>
          
		  <?php
		 
		 break; 		
		 
		 case 'full-width-divider' : 
		  ?>
		  <li class="clearfix full-width-divider">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Divider </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	<div class="select-wrapper clearfix">
                                                      <select name="" id="">
                                                        <?php $t = array("icon" => "To Top Icon" ,"none" => "None");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($element[1]==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                          
                                                      </select>
                                                </div>
                                             <input type="hidden" value="full-width-divider" name="elements" class="elements" />   
                                        </div>
                                    </li>
		  <?php
		 break; 
		 
		 case 'intro-text' : 
		 $data = $element[1];
		
		 ?>
           <li class="clearfix intro-text">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Intro Text </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a> 
                                             <div class="select-wrapper">
                                             
                                             
                                            	<select name="" id="" class="layout">
                                                	  <option value="none">Full Width</option>
                                                     <?php $t = array("one_half" => "1/2" ,"one_half_last" => "1/2 Last"  ,"one_third" => "1/3" ,"one_third_last" => "1/3 Last" ,"two_third" => "2/3" ,"two_third_last" => "2/3 Last", "one_fourth" => "1/4" , "one_fourth_last" => "1/4 Last" , "three_fourth" => "3/4" , "three_fourth_last" => "3/4 Last"    );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['Layout']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                </select>
                                            </div> 
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	 <textarea name="" id="" cols="30" class="title" rows="10"><?php  echo stripslashes($data['title']); ?></textarea>
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Text</label>
                                            	<textarea name="" id="" cols="30" class="text" rows="10"><?php  echo stripslashes($data['text']); ?></textarea>
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Button Label</label>
                                            	<input type="text" class="label" value="<?php  echo stripslashes($data['label']); ?>"  />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Button Link</label>
                                            	<input type="text" class="link"  value="<?php echo stripslashes( $data['link']); ?>" />
                                            </div>
                                            
                                            <input type="hidden" value="intro-text" name="elements" class="elements" />
                                        </div>
                                    </li>
		 
		 <?php
		 
		 break;
		 
		  case 'custom-post' : $data = $element[1]; ?>
		            <li class="clearfix custom-post">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Posts </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                             <div class="select-wrapper">
                                             
                                             
                                            	<select name="" id="" class="layout">
                                                	  <option value="none">Full Width</option>
                                                     <?php $t = array("one_half" => "1/2" ,"one_half_last" => "1/2 Last"  ,"one_third" => "1/3" ,"one_third_last" => "1/3 Last" ,"two_third" => "2/3" ,"two_third_last" => "2/3 Last", "one_fourth" => "1/4" , "one_fourth_last" => "1/4 Last" , "three_fourth" => "3/4" , "three_fourth_last" => "3/4 Last"    );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['Layout']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                </select>
                                            </div>
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	<input type="text" class="title" value="<?php echo stripslashes($data['title']); ?>" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter number of Posts</label>
                                            	<input type="text" class="no_of_posts" value="<?php echo $data['no_of_posts']; ?>" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Exerpt</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="excerpt">
                                                        <?php $t = array("yes" => "Yes" ,"no" => "No");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['excerpt']==$key)
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
                                            	<label for="">Select Post Type</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="post_type">
                                                          <?php $t = array("post" => "Post" ,"portfolio" => "Portfolio" );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['post_type']==$key)
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
                                            	<label for="">Enter Button Label</label>
                                            	<input type="text" class="label" value="<?php  echo stripslashes($data['label']); ?>"  />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Button Link</label>
                                            	<input type="text" class="link"  value="<?php echo stripslashes( $data['link']); ?>" />
                                            </div>
                                              
                                        
                                            <input type="hidden" value="custom-post" name="elements" class="elements" />
                                            
                                            
                                        </div>
                                        
                                        
                                    </li>
        
		  
		  <?php break;
		   case 'scrollable-post' :   $data = $element[1]; ?>
		     <li class="clearfix scrollable-post">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Scrollable Posts </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>
                                              <div class="select-wrapper">
                                             
                                             
                                            	<select name="" id="" class="layout">
                                                	  <option value="none">Full Width</option>
                                                     <?php $t = array("one_half" => "1/2" ,"one_half_last" => "1/2 Last"  ,"one_third" => "1/3" ,"one_third_last" => "1/3 Last" ,"two_third" => "2/3" ,"two_third_last" => "2/3 Last", "one_fourth" => "1/4" , "one_fourth_last" => "1/4 Last" , "three_fourth" => "3/4" , "three_fourth_last" => "3/4 Last"    );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['Layout']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                </select>
                                            </div>
                                              
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	<input type="text" class="title" value="<?php echo $data['title']; ?>"  />
                                            </div>
                                            
                                               <div class="hades_input clearfix">
                                            	<label for="">Enter description</label>
                                            	<textarea class="description" name="" id="" cols="30" rows="10"><?php echo stripslashes($data['description']); ?></textarea>
                                            </div>
                                            
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter number of Posts</label>
                                            	<input type="text" class="no_of_posts" value="<?php echo $data['no_of_posts']; ?>" />
                                            </div>
                                            
                                             <div class="hades_input clearfix">
                                            	<label for="">Enter category SLUG not name</label>
                                            	<input type="text" class="category" value="<?php echo $data['category']; ?>" />
                                            </div>
                                            
                                             <div class="hades_input clearfix">
                                            	<label for="">Exerpt</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="excerpt">
                                                        <?php $t = array("yes" => "Yes" ,"no" => "No");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['excerpt']==$key)
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
                                            	<label for="">Link Type</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="link_type">
                                                        <?php $t = array("lightbox" => "Open In Lightbox" ,"post" => "Link to Post");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['link_type']==$key)
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
                                            	<label for="">Select Post Type</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="post_type">
                                                          <?php $t = array("post" => "Post" ,"portfolio" => "Portfolio" );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['post_type']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                   </select>
                                               </div>
                                            </div>
                                           
                                           
                                        
                                            
                                             
                                          <input type="hidden" value="scrollable-post" name="elements" class="elements" />
                                            
                                            
                                        </div>
                                    </li>
           <?php break;
		  
		   case 'custom-info-post' : $data = $element[1]; ?>
		 <li class="clearfix custom-info-post">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Custom Info Posts </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                              <div class="select-wrapper">
                                             
                                             
                                            	<select name="" id="" class="layout">
                                                	  <option value="none">Full Width</option>
                                                     <?php $t = array("one_half" => "1/2" ,"one_half_last" => "1/2 Last"  ,"one_third" => "1/3" ,"one_third_last" => "1/3 Last" ,"two_third" => "2/3" ,"two_third_last" => "2/3 Last", "one_fourth" => "1/4" , "one_fourth_last" => "1/4 Last" , "three_fourth" => "3/4" , "three_fourth_last" => "3/4 Last"    );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['Layout']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                </select>
                                            </div>
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	<input type="text" class="title" value="<?php echo stripslashes($data['title']); ?>" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter description</label>
                                            	<textarea class="description" name="" id="" cols="30" rows="10"><?php echo stripslashes($data['description']); ?></textarea>
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Exerpt</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="excerpt">
                                                        <?php $t = array("yes" => "Yes" ,"no" => "No");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['excerpt']==$key)
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
                                            	<label for="">Link Type</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="link_type">
                                                        <?php $t = array("lightbox" => "Open In Lightbox" ,"post" => "Link to Post");
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['link_type']==$key)
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
                                            	<label for="">Select Post Type</label>
                                            	 <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="post_type">
                                                          <?php $t = array("post" => "Post" ,"portfolio" => "Portfolio" );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['post_type']==$key)
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
                                            	<label for="">Enter Button Label</label>
                                            	<input type="text" class="button_label" value="<?php echo stripslashes($data['button_label']); ?>"  />
                                            </div>
                                            
                                            	 <div class="hades_input clearfix">
                                            	<label for="">Enter Button Link</label>
                                            	<input type="text" class="button_link" value="<?php echo stripslashes($data['button_link']); ?>"  />
                                            </div>
                                            
                                          <input type="hidden" value="custom-info-post" name="elements" class="elements" />
                                            
                                            
                                        </div>
                                    </li>
		  <?php break;
		
		case 'twitter' : $data = $element[1];   ?> 
		
       <li class="clearfix twitter">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Twitter </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                              <div class="select-wrapper">
                                             
                                             
                                            	<select name="" id="" class="layout">
                                                	  <option value="none">Full Width</option>
                                                     <?php $t = array("one_half" => "1/2" ,"one_half_last" => "1/2 Last"  ,"one_third" => "1/3" ,"one_third_last" => "1/3 Last" ,"two_third" => "2/3" ,"two_third_last" => "2/3 Last", "one_fourth" => "1/4" , "one_fourth_last" => "1/4 Last" , "three_fourth" => "3/4" , "three_fourth_last" => "3/4 Last"    );
														 $str = '';
														 foreach($t as $key => $opt)
														 {
															 if($data['Layout']==$key)
															 $str = $str. " <option value=\"{$key}\" selected='selected'>$opt</option>";
															 else
															 $str = $str. " <option value=\"{$key}\">$opt</option>";
															 
														 }
														  echo $str;
														  ?>
                                                </select>
                                            </div>
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter Title</label>
                                            	<input type="text" class="title" value="<?php echo stripslashes($data['title']); ?>" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter username</label>
                                            	<input type="text" class="username" value="<?php echo $data['username']; ?>" />
                                            </div>
                                            
                                            <div class="hades_input clearfix">
                                            	<label for="">Enter number of tweets</label>
                                            	<input type="text" class="tweets"  value="<?php echo $data['tweets']; ?>"/>
                                            </div>
                                            
                                           
                                            <input type="hidden" value="twitter" name="elements"  class="elements"/>
                                        </div>
                                    </li>
		
		<?php break;
		
		case 'page-post-content' : 
		?>
         <li class="clearfix page-post-content">
                                        
                                    	<div class="slider-head clearfix">	
                                        	<h3> Page Content </h3>
                                            <a href="" class="delete-icon"></a> <a href="" class="edit-icon"></a>  
                                            
                                    	</div>
                                        <div class="slider-body clearfix ">
                                        	
                                           <div class="select-wrapper clearfix">
                                                    <select name="" id="" class="page-content">
                                                       <?php 
															    $popPosts = new WP_Query();
																$popPosts->query('post_type=page&posts_per_page=-1'); 
																$data = $element[1];
																$postid = $data['id'];
																while ($popPosts->have_posts()) : $popPosts->the_post();  
																  if( $postid == get_the_ID() )
																  echo "<option selected='selected' value='".get_the_ID()."'>".get_the_title()."</option>";
																  else
																  echo "<option value='".get_the_ID()."'>".get_the_title()."</option>";
																endwhile;
																wp_reset_query();
															?>
                                                   </select>
                                               </div>
                                            <input type="hidden" value="page-post-content" name="elements" class="elements" />
                                        </div>
                                    </li>
         <?php
		break;
				
		 }
	 }
 }
   
}

$titan_editor = new TitanEdior();