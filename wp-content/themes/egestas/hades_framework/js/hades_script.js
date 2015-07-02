
/*
*

Author - Abhin Sharma (WPTitans)
This code cannot be used anywhere without the permission of the Author.

*
*/

/* ========================================================================================================= */	
/* == Options Panel JS  Code =============================================================================== */	
/* ========================================================================================================= */

jQuery(document).ready(function($){
	
	$( "#option-panel-tabs" ).tabs();	
    
});




jQuery(function($) {
	
  
	
		   var SN = jQuery('#option-panel-tabs').data('shortname');	   
	
	var temp,radio = $(".radio"),path = $("#option_path").val();
	var loading_icon = $(".ajax_icon");
	
    
    
	$(".button-save").click(function(e){
	$(".cbox").css('display','none');
    var ed,home_content;

		
	loading_icon.css("visibility","visible").animate({ opacity: 1 },"slow");
		
		 
		$.post( path , {  action:"save", vfi : $('#verficiation').val() , values: $("#hades_option_form").serializeArray()  },
			  function(data){
				
				
				 loading_icon.animate({ opacity: 0 },"slow", function(){
                 
					  $(this).css("visibility","hidden");
					 
                      $(".cbox").fadeIn("slow",function(){
                      
                      setTimeout(function(){ $(".cbox").fadeOut('fast') },2000);
                      
                      });
					 
					 });
				  }
			  );
		
	
	return false;
	});
	
	
	
	 $(".panel-reset").click(function(e){
		 $(".reset-form").submit();
		 e.preventDefault();
		 });


	
    var post_layout = $("#"+SN+"_post_layout").val();
   
    
	if(post_layout=="")
	post_layout = ".post-layout .full-width";
	else
   post_layout = ".post-layout ."+post_layout;
    
     
    
	$(post_layout).addClass('active');
   
     var page_layout = $("#"+SN+"_page_layout").val();
	if(page_layout=="")
	page_layout = ".page-layout .full-width";
	else
    page_layout = ".page-layout ."+page_layout;
    
	$(page_layout).addClass('active');
    
	
    
    
	var footer_layout = $("#hades_footer_layout").val();
	if(footer_layout=="")
	footer_layout = "two-col";
	
	$(".footer-layout").find("."+footer_layout).addClass('active');
	
	var plain_theme = $("#hades_plain_theme").val();
	if(plain_theme=="")
	plain_theme = "azure";
	
	$("#visual_plain_panel ").find("."+plain_theme).addClass('active');
	
	
	
	$( ".hades_input .hades_slider" ).each(function(){
		temp = $(this);
		temp.slider({
				value: parseInt(temp.parent().find(".slider-val").val()),
				min: 0,
				max:  parseInt(temp.parent().find(".max-slider-val").val()),
				
				slide: function( event, ui ) {
					$(this).parent().find(".slider-text").val(ui.value);
				}
			});
		
		});
	
   
	

$("input[name="+SN+"_blurb_button_link]").click(function(){ temp = ($(this).val());
  $('.blurb-options').hide();
  switch(temp)
  {
	  case "Link to a page": $(".b-link").show(); break;
	  case "Custom link": $(".b-custom").show(); break;
	  case "Open in lightbox":$(".b-lightbox").show();  break;
  }

 });

 $('.blurb-options , .h-options').hide();
$("input[name="+SN+"_blurb_button_link]").each(function(){
	
 if($(this).is(":checked"))	
  switch($(this).val())
  {
	  case "Link to a page": $(".b-link").show(); break;
	  case "Custom link": $(".b-custom").show(); break;
	  case "Open in lightbox":$(".b-lightbox").show();  break;
  }
	
	});

$("input[name="+SN+"_stage_option]").each(function(){
	
 if($(this).is(":checked"))	
  switch($(this).val())
  {
	 case "Slider": $(".h-slider").show(); break;
	  case "Static Image": $(".h-upload").show(); break;
	  case "Title": $(".h-title").show(); break;
	  case "Half Stage": $(".h-staged").show(); break;
  }
	
	});
	
	
$("input[name="+SN+"_stage_option]").click(function(){ temp = ($(this).val());
  $('.h-options').hide();
  switch(temp)
  {
	  case "Slider": $(".h-slider").show(); break;
	  case "Static Image": $(".h-upload").show(); break;
	  case "Title": $(".h-title").show(); break;
	  case "Half Stage": $(".h-staged").show(); break;
  }



 });




$(window).load(function(){
	
	 $("#editorcontainer").contents().find("iframe").height(320);

	
	});

$(".home-layout li a").click(function(e){
	$(".home-layout li").removeClass('active');
	$("#"+SN+"_home_layout").val($(this).parent().attr('class'));
	$(this).parent().addClass('active'); 
	
	e.preventDefault();
	});

$(".post-layout li a,.page-layout li a").click(function(e){
	
    $(this).parents('div.hades_input').find('ul li').removeClass('active');
	
    $(this).parents('div.hades_input').find('input[type=hidden]').val($(this).parent().attr('class'));
	$(this).parent().addClass('active'); 
	
	e.preventDefault();
	});
    
    
$(".footer-layout li a").click(function(e){
	$(".footer-layout li").removeClass('active');
	$("#hades_footer_layout").val($(this).parent().attr('class'));
	$(this).parent().addClass('active'); 
	
	e.preventDefault();
	});


$("#visual_plain_panel ul li a").click(function(e){
	
	$("#visual_plain_panel li").removeClass('active');
	$("#hades_plain_theme").val($(this).attr('href'));
	$(this).parent().addClass('active'); 
	
	e.preventDefault();
	});  


 
});

