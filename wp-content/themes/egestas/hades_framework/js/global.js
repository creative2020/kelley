/*
*

Author - Abhin Sharma (WPTitans)
Description - Contains global functions

This code cannot be used anywhere without the permission of the Author.

*
*/

// Contains global js rountines for our themes. 

  jQuery.fn.extend({
insertAtCaret: function(myValue){
  return this.each(function(i) {
    if (document.selection) {
      //For browsers like Internet Explorer
      this.focus();
      sel = document.selection.createRange();
      sel.text = myValue;
      this.focus();
    }
    else if (this.selectionStart || this.selectionStart == '0') {
      //For browsers like Firefox and Webkit based
      var startPos = this.selectionStart;
      var endPos = this.selectionEnd;
      var scrollTop = this.scrollTop;
      this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
      this.focus();
      this.selectionStart = startPos + myValue.length;
      this.selectionEnd = startPos + myValue.length;
      this.scrollTop = scrollTop;
    } else {
      this.value += myValue;
      this.focus();
    }
  })
}
});
var hadesRountines = {
	
	showloadingIcon : function(){  jQuery('.ajax_loading_icon').css('visibility','visible').animate({opacity:1},'slow');  },
	hideloadingIcon : function(){  jQuery('.ajax_loading_icon').animate({opacity:0},'slow',function(){ $(this).css('visibility','hidden') });  }		
	
	};



;(function($){
	
	
	
	var temp,i,j,obj,queryable,hades_media_function = {
	override:false,	
	window : parent,
	// Override upload function
	hades_uploader: function()
		{
			window.default_send_to_editor = window.send_to_editor;
			window.send_to_editor = function(html)
     		{   
			   
				if(hades_media_function.override=='gallery_mode') {
		          	var button = temp ,uploadarea = temp.parents('.hades_subpanel').find(".uploadarea"), slider_type = temp.parents('.hades_section').find('.slider_type').val();
					if( ! jQuery.isArray(html) )
					{
					
					  var imgurl = jQuery('img', html).attr('src');
					  temp = jQuery('.clonable li').first().clone();
					  
					  temp.find('input.image_src').val(imgurl);
					  temp.find('img').attr('src',imgurl);
					 	  temp.find('.slider-body').tabs();
						  
					 if(slider_type=="Staged Slider")
					 {
			
					 temp.find('.stageoptions').show();	
					 temp.find('.slider-body').tabs("option","disabled",[]);
					 
					}
					else
					{
						temp.find('.slider-body').tabs( "option", "disabled", [1, 2] );
						temp.find('.stageoptions').hide();
					}
					 
				
					
					 temp.find('.pcanvas .ptitle').draggable({ containment: "parent" });		
				    temp.find('.pcanvas .ptext').draggable({ containment: "parent" });
		 		  temp.find('.pcanvas .pimage').draggable({ containment: "parent" });
		 			temp.find('.colorpickerField1').ColorPicker({

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
					  uploadarea.append(temp);
					
					}
					else
					{
						for(i=0;i<html.length;i++)
					    {
						  imgurl = html[i];
						  temp = jQuery('.clonable li').first().clone();
						  temp.find('img').attr('src',imgurl);
						  temp.find('input.image_src').val(imgurl);
						  uploadarea.append(temp);
						  
					    }
					  
					}
					
					hades_media_function.override = false;
		     	}  
     		   else if(hades_media_function.override==true) {
		          	imgurl = jQuery('img', html).attr('src');
                	
					if(temp.prev('.panel_upload').length>0)
					{
					temp.prev().val(imgurl);
					temp.parents('.hades_input').find('img').attr('src',imgurl);	
					
					}
					else if(temp.prev('input').length>0)
					temp.prev().val(imgurl);
					else
			    	{
						temp.prev().removeClass('hide').attr('src',imgurl);
						temp.parent().find('.img_src').val(imgurl);
						if(temp.parent().find('input[type=text]').length>0)
						temp.parent().find('input[type=text]').val(imgurl);
						else
						temp.parent().find('textarea').insertAtCaret('[img src="'+imgurl+'" /]');
						
						
					}
					hades_media_function.override = false;
		    		}
		       else {
				   	window.default_send_to_editor(html);
			        }
			
			window.tb_remove();
     	
     		};
		},
	
	bind_upload : function(){
		
		$('.image_upload').live('click',function(e){
			e.preventDefault();
			
			temp = jQuery(this); hades_media_function.override = true;
		    queryable = '';
		    
			if(temp.attr('title')!='') queryable = 'hades_label='+temp.attr('title')+'&amp;';
		    tb_show('', 'media-upload.php?'+queryable+'type=image&amp;width=650&amp;height=500&amp;TB_iframe=true');
		  
			
			});
		
		},
	
	gallery_upload : function(){
		
		$('.gallery_upload').live('click',function(e){
			e.preventDefault();
			
			temp = jQuery(this); hades_media_function.override = 'gallery_mode';
		    queryable = '';
		    
			if(temp.attr('title')!='') queryable = 'hades_label='+temp.attr('title')+'&amp;';
		    tb_show('', 'media-upload.php?'+queryable+'type=image&amp;width=650&amp;height=500&amp;TB_iframe=true');
		  
			
			});
		
		},	
	
	thickbox_override : function(){
		
		 var iframe = '';
			$('#TB_iframeContent').ready(function(){
			
				iframe = $(this).contents();
				if( iframe.find('.hades_insert_button_label').length > 0)
				{
					temp =  iframe.find('.hades_insert_button_label').val();
					iframe.find('.hades_insert_button_label').remove();
					iframe.find('td.savesend .button').val( temp );
					
				}
	
	
				if(iframe.find('#media-items').length>0)
				{
					iframe.find('#media-items').prepend('<div class="clearfix"><a href="" class="multi-hades-upload button"> Add to Slideshow </a> <span class="multi-label">Select the Images for Slideshow</span> </div>');
					$('.media-item').each(function(){ $(this).find('.filename').append('<input type="checkbox" value="'+$(this).find('img').attr('src')+'" name="upload_src[]" class="hades_multi_upload" />'); });
				}
				
				var uploadarea = $("#uploadarea");
				var multi_array = new Array() , k =0;
				$('.multi-hades-upload').live('click',function(e){
					e.preventDefault();
					
					  multi_array = new Array();
					 $('.filename  :checked').each(function() {
					   multi_array.push($(this).val());
					 });
					 
					 is_multiple =true;
					 window.parent.send_to_editor(multi_array);
					
					});
	
	
			});
	
		
		}			
		
		
	}
	
  
  jQuery(function(){
	  
	  
	  hades_media_function.hades_uploader();
	  hades_media_function.bind_upload();
	  hades_media_function.gallery_upload();
	//  hades_media_function.thickbox_override();
	 
      // == Admin Sidebar metaboxes code =====================
	 
	 $('#supersidebars ul li.'+$('#supersidebars ul li').find('input:checked').val()).addClass('active');
	 $('#supersidebars ul li').click(function(){ $('#supersidebars ul li').removeClass('active'); $(this).addClass('active'); });
	 
	
	 
	 	
	  });

})(jQuery);	 
// ~~ Misc Functions ~~ =================================================================

function rgb2hex(rgb){
 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
 return "#" +
  ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
  ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
  ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
}

jQuery(function($){

	
/* ========================================================================================================= */	
/* == Gallery Functionality ================================================================================ */	
/* ========================================================================================================= */
 
 if($("#exgallery_credits_meta").length>0 || $(".slideable").length>0) {
 
 // Make it before WP Editor
	$("#exgallery_credits_meta").insertBefore("#postdivrich");
	
	var temp,slide = $("#hades_gallery .cloneable>li:first").clone().removeClass('hide'),hgallery=$("#hades_gallery");
	
	hgallery.find("  .contract .slide-body").hide();
	hgallery.find( ".slider-lists>ul" ).sortable({
			placeholder: "drag-highlight"
		});
		
	hgallery.find("#addslide").click(function(e){
		    temp = slide.clone();
	    	$(".slider-lists>ul").append(temp);
		    e.preventDefault();
		});
		
	hgallery.find(".slide-toggle-button").live('click',function(e){
		temp = $(this);
		
		  $(this).parent().next().slideToggle('normal',function(){ 
	    		
		          temp.toggleClass('minus-icon');
		        
		 });
		e.preventDefault();
	});	
			
	hgallery.find(".removeslide").live("click",function(e){
		
		$(this).parents("li").remove();
		
		e.preventDefault();
		});		
	
 }
		

   
	});

