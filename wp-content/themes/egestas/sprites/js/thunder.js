jQuery(function($){


	
var temp,i,k,j,obj,super_parent = $('.bg-texture'), listener = $('.thunder_listener'),str, icon = $('div.thunder_ext_icon'), current_listener , prop ='',picker;

var sections = $('.hades_input') ,   panel = $('.thunder_wrapper');
var inputs = sections.find('input[type=text]');

var hometab = $('#thhome'),listtab = $('#thlist'),linktab = $('#thlinks'),texttab = $('#thtext'),headingstab = $('#thheadings'),buttontab = $('#thbutton'),imagetab = $('#thimage'), submenutab = $('#thsubmenu');

//listener.removeClass('thunder_listener');
$('.thunder_ext_icon').click(function(e){
	e.preventDefault();
	$('div.thunder_wrapper').animate({left:-330},'normal'); 
	});
	
var dom_path = '';	

  $('#thundertabs a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
 
$('div.hades_input select').change(function(){
	  $(current_listener).css($(this).data('attr'),$(this).val());
	});

  
	var queryable,hades_media_function = {
	override:false,	
	window : parent,
	// Override upload function
	hades_uploader: function()
		{
			window.default_send_to_editor = window.send_to_editor;
			window.send_to_editor = function(html)
     		{   
			   
				 if(hades_media_function.override==true) {
		          	imgurl = jQuery('img', html).attr('src');
                	
					if(temp.prev('.panel_upload').length>0)
					{
					temp.prev().val(imgurl);
					temp.parents('.hades_input').find('img').attr('src',imgurl);	
					
					}
					else if(temp.prev('input').length>0)
					temp.prev().val(imgurl);
					
					hades_media_function.override = false;
					
					 $(current_listener).css("background-image", "url("+imgurl+")");
					
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
		    tb_show('', $(this).data('url')+'?type=image&amp;width=650&amp;height=500&amp;TB_iframe=true');
		  
			
			});
		
		},
	
		
		
		
	}
	
hades_media_function.hades_uploader();
hades_media_function.bind_upload();
	  	  
listener.bind({
	
	'mouseenter' : function(event) { 
								
								 temp = $(this); 
								 str = getDOMPATH(this,true); 
								 
							//	 if(!temp.is(current_listener))
							//	 temp.addClass('outline-element');
								 dom_path = str;
								// console.log(str);
								 
								
								 
  								  
								  
								}   ,
	'mouseleave' : function(event) {
								temp = $(this); 
						if($(current_listener).is(temp))
								return false;
								},
								 
	'click' : function(event) {
		
		                       sections.hide();
							    
								sections.find('div.colorSelector>div').css('background-color','transparent');
							   
							   sections.removeClass('thunder-option-available');
							   
							   current_listener = this;
							   str = getDOMPATH(current_listener,true); 
							  
							  	event.stopImmediatePropagation();// console.log(str);
								
								
								
								var defaults = 'bg cr br';
								
								var styles = ($(current_listener).attr('style'));
								
								$(current_listener).css({ 'display' : 'block' , 'visibility' : 'visible' , 'opacity' : 1});
								
								if($(current_listener).data('filter')) {
							    defaults =  $(current_listener).data('filter');
								
							    filter = defaults.split(' ');
							   
								for(var i=0;i<filter.length;i++) 
								{
									hometab.find("."+filter[i]).addClass('thunder-option-available').show();
									
								}
								$('#thome').show(); 
								
								}
								else
								$('#thome').hide();
								
								
								defaults = 'cr';
								
								if($(current_listener).data('link-filter')) {
							    defaults =  $(current_listener).data('link-filter');
								
							    filter = defaults.split(' ');
							   
								for(var i=0;i<filter.length;i++) 
								linktab.find("."+filter[i]).addClass('thunder-option-available').show();
								
								defaults = 'cr';
								
								$('#tlinks').show();
								}
								else
								$('#tlinks').hide();
								
								
								if($(current_listener).data('submenu-filter')) {
							    defaults =  $(current_listener).data('submenu-filter');
								
							    filter = defaults.split(' ');
							   
								for(var i=0;i<filter.length;i++) 
								submenutab.find("."+filter[i]).addClass('thunder-option-available').show();
								
								defaults = 'cr';
								
								$('#tsubmenu').show();
								}
								else
								$('#tsubmenu').hide();
								
								
								
								if($(current_listener).data('list-filter')){
							    defaults =  $(current_listener).data('list-filter');
								
							    filter = defaults.split(' ');
							   
								for(var i=0;i<filter.length;i++) 
								listtab.find("."+filter[i]).addClass('thunder-option-available').show();
								
								$('#tlist').show();
								}
								else
								$('#tlist').hide();
								
								
								defaults = '';
								
								if($(current_listener).data('text-filter')) {
							    defaults =  $(current_listener).data('text-filter');
								
							    filter = defaults.split(' ');
							   
								for(var i=0;i<filter.length;i++) 
								texttab.find("."+filter[i]).addClass('thunder-option-available').show();
								
								$('#ttext').show();
								}
								else
								$('#ttext').hide();
								
								defaults = '';
								
								if($(current_listener).data('headings-filter')) {
							    defaults =  $(current_listener).data('headings-filter');
								
							    filter = defaults.split(' ');
							   
								for(var i=0;i<filter.length;i++) 
								headingstab.find("."+filter[i]).addClass('thunder-option-available').show();
								
								$('#theadings').show();
								}
								else
								$('#theadings').hide();
								
  								
								if($(current_listener).data('image-filter')) {
							    defaults =  $(current_listener).data('image-filter');
								
							    filter = defaults.split(' ');
							   
								for(var i=0;i<filter.length;i++) 
								imagetab.find("."+filter[i]).addClass('thunder-option-available').show();
								
								defaults = 'cr';
								
								$('#timage').show();
								}
								else
								$('#timage').hide();
								
								
								if($(current_listener).data('button-filter')) {
							    defaults =  $(current_listener).data('button-filter');
								
							    filter = defaults.split(' ');
							   
								for(var i=0;i<filter.length;i++) 
								buttontab.find("."+filter[i]).addClass('thunder-option-available').show();
								
								defaults = 'cr';
								
								$('#tbutton').show();
								}
								else
								$('#tbutton').hide();
								
								var test = false;
								$('div.thunder_wrapper').animate({left:0},'normal');
								$('#thundertabs').children('li').each(function(){
									
									if( jQuery(this).is(':visible') && test==false )
									{
										$(this).children('a').tab('show'); test=true;
									}
									
									
									});
								inputs.val('');
								
								reveseEngineer();
							//	$(current_listener).addClass('elefocused');
							//	$('div.thoverlay').fadeIn('normal');
							   }
	
	});


 $('.colorSelector').ColorPicker({

	onSubmit: function(hsb, hex, rgb, el) {

		$(el).val(hex);

		$(el).ColorPickerHide();

	},

	onBeforeShow: function () {
       picker = this;
	

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
		
		var ch = ($(picker).parents('div.tab-pane').attr('id'));
		
		$(picker).parents('.hades_input').find('.colorSelector>div').css('backgroundColor', '#' + hex);
		
		var cr = getCorrectFormat($(picker).data('attr'),hex);
	
		switch(ch)
		{ 
			case "thhome" :  
			if($(picker).parent().hasClass('sbbr'))
			$(current_listener).find('.skeleton').css($(picker).data('attr'), cr);  
			else
			$(current_listener).css($(picker).data('attr'), cr); break;
			case "thlinks" : 
			if($(picker).parent().hasClass('bbra'))
			$(current_listener).find('.current-menu-item a , .current_page_item a').css($(picker).data('attr'), cr);  
			else if($(picker).parent().hasClass('bga'))
			$(current_listener).find('li.active a').css($(picker).data('attr'), cr);  
			else
			$(current_listener).find('a').css($(picker).data('attr'), cr); break;
			case "thtext" :  $(current_listener).css($(picker).data('attr'), cr);   $(current_listener).find('p,span,div,strong').css($(picker).data('attr'), cr);  break;
			case "thlist" :   $(current_listener).find('li').css($(picker).data('attr'), cr);  break;
			case "thheadings" :   $(current_listener).find('h1,h2,h3,h4,h5,h6').css($(picker).data('attr'), cr);  break;
			case "thimage" :   $(current_listener).find('.thunder_image').css($(picker).data('attr'), cr);  break;
			case "thbutton" :   $(current_listener).find('.thunder_button').css($(picker).data('attr'), cr);  break;
			case "thsubmenu" :   
								if($(picker).parent().hasClass('cr') || $(picker).parent().hasClass('crh'))
			  								$(current_listener).find('.sub-menu li a').css($(picker).data('attr'), cr);  
								else if($(picker).parent().hasClass('list-bbr'))			
									$(current_listener).find('.sub-menu li').css($(picker).data('attr'), cr);  
								else
											$(current_listener).find('.sub-menu').css($(picker).data('attr'), cr);  
								
								break;

		}
		
	
	
	
	}

})

.bind('keyup', function(){

	$(this).ColorPickerSetColor(this.value);

});


function getCorrectFormat(attr,hex) {
	
	switch(attr)
	{
		case 'color' : return "#"+hex;
		case 'background-color' : return "#"+hex; break;
		
		case 'border-top-color' :
		case 'border-bottom-color' : 
		case 'border-left-color' : 
		case 'border-right-color'  :
		case 'border-color' : return "#"+hex; break;
		
	}
	
	}
	
function getShortFormat(property) {
	
	switch(property)
	{
		case 'color' : return "cr";
		case 'background-color' : return "bg"; break;
		case "background-position" : return "bgp"; break;
		case "background-image" : return "bgi"; break;
		case "background-repeat" : return "bgr"; break;
		case 'border-top-color' : return "tbr";  break;
		case 'border-bottom-color' :  return "bbr"; break;
		case 'border-left-color' :  return "lbr"; break;
		case 'border-right-color'  : return "rbr"; break;
		case 'border-color' : return "br"; break;
		
	}
	
	}	

function getDOMPATH(ele,tags)
{
	   var rightArrowParents = [];
	   
	   
	   var entry = ele.tagName.toLowerCase();
	   
	  
	   if ( ele.id ) entry += "#"+ele.id;
	   else if (ele.className ) {
            entry += "." + jQuery.trim( (ele.className).replace(/\s{2,}/g,' ')   ).replace(/ /g, '.');
        }
		
      
	   
	    rightArrowParents.push(entry);
	
	$(ele).parents().not('html').each(function() {
          entry = this.tagName.toLowerCase();
		
           if(this.tagName!="LI" && this.tagName!="BODY") {
		   if ( this.id ) entry += "#"+this.id;
         else if (this.className && this.className!="clearfix" ) {
            entry += "." + jQuery.trim( (this.className).replace(/\s{2,}/g,' ')  ).replace(/ /g, '.');
		 }
        }
        rightArrowParents.push(entry);
    });
	
    rightArrowParents.reverse();
    var temp = rightArrowParents.join(" ");
	temp = temp.replace('..', '.');	
	//console.log(temp);
		return temp;
}

// Save the setting
var tempval;


function reveseEngineer()
{
	var k = getDOMPATH(current_listener,true); $('#save-th-settings').addClass('saving');
	$.post($('#save-th-settings').data('url') , {  key: k , values : 'retrieve' } , 
	
	function(data){ 
	// console.log(data);
			$('#save-th-settings').removeClass('saving');
	if(data=='First Time') return;
	
	var values = jQuery.parseJSON(data);
	//console.log(values.props);
	$.each(values.props,function(){
		
		for(i=0;i<this.length;i++) {
			
		temp = this[i];
		//console.log ( temp.tab+" "+temp.shortname+" "+temp.value);
		switch(temp.shortname)
	  	{
		case 'cr' : $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'cra' : $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'bga' : $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'crma' : $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'crh' : $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'bgh' : $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'bg' : $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case "bgp" :  
					$(temp.tab).find('.'+temp.shortname).find("select option").removeAttr('selected'); 
					$(temp.tab).find('.'+temp.shortname).find("select option[value='"+temp.value+"']").attr("selected", "selected"); break;
		case "bgi" :$(temp.tab).find('.'+temp.shortname+" .panel_upload").val( (temp.value).replace('url(','').replace(')','') );  break;
		case "bgr" : $(temp.tab).find('.'+temp.shortname).find("select option").removeAttr('selected'); 
					$(temp.tab).find('.'+temp.shortname).find("select option[value='"+temp.value+"']").attr("selected", "selected"); break;
		case 'tbr' :  $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'bbr' :  $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'lbr' :  $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'rbr'  : $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'br' :   $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'list-bbr' :   $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'sbbr' :   $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		case 'bbra' :   $(temp.tab).find('.'+temp.shortname+" div.colorSelector>div").css('background-color',temp.value); break;
		}
		
		}

		});
	 
	 });
}


$('#save-th-settings').click(function(e){
	
	var k = getDOMPATH(current_listener,true);
	$(this).addClass('saving');
//	console.log(getDOMPATH( $(current_listener).find('a')[0] ) );
	
	var set = new Array(); j =0;
	
	if($('#thome').is(':visible'))
	{
		//console.log(getDOMPATH(current_listener,true)  );
		var attrs = new Array();
		i=0;
		$('#thhome').find('div.thunder-option-available').each(function(){
			obj = $(this);
			
			if($(this).hasClass('sbbr'))
			 {
				 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" .skeleton " , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thlinks" ,"shortname" : "sbbr"}; 
			 } 
			else if(obj.find('div.colorSelector').length>0) { 
				tempval = obj.find('div.colorSelector');
				temp = tempval.children('div').css('background-color');
				
			}
			else if($(this).find('select').length>0)
			{
				tempval = $(this).find('select');
				temp = tempval.val();
			}
			else
			{
				tempval = $(this).find('input[type=text]');
				temp = "url("+tempval.val()+")";
			}
			
			//console.log(temp);
			if(temp!="" && temp!="transparent"  && temp!="rgba(0, 0, 0, 0)")
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true) , "property" : tempval.data('attr') , "value" : temp , "tab" : "#thhome" ,"shortname" : getShortFormat(tempval.data('attr')) }; 
			});
			//console.log(attrs);
			set[j++] = attrs;
	}
	
	if($('#tlinks').is(':visible'))
	{
		var attrs = new Array();
		i=0;
		$('#thlinks').find('div.thunder-option-available').each(function(){
			 
			 tempval = $(this).find('div.colorSelector');
			
			if(tempval.children('div').css('background-color')!="" && tempval.children('div').css('background-color')!="transparent" && tempval.children('div').css('background-color')!="rgba(0, 0, 0, 0)" ) {
			
			if($(this).hasClass('crh'))
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" a:hover" , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color'), "tab" : "#thlinks" ,"shortname" : "crh" }; 
		    else if($(this).hasClass('crma'))
			 {
				 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" li.current_page_item a" , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thlinks" ,"shortname" : "crma"}; 
				 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" li.current-menu-ancestor a" , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thlinks" ,"shortname" : "crma"}; 
			 }
			 else if($(this).hasClass('bbra'))
			 {
				 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" li.current_page_item a" , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thlinks" ,"shortname" : "bbra"}; 
				 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" li.current-menu-ancestor a" , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thlinks" ,"shortname" : "bbra"}; 
				  attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" li:hover a" , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thlinks" ,"shortname" : "bbra"}; 
				
			 }
			else if($(this).hasClass('cra'))
			 {
				 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" li.active a " , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thlinks" ,"shortname" : "cra"}; 
			 } 
			 else if($(this).hasClass('bga'))
			 {
				 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" li.active a " , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thlinks" ,"shortname" : "bga"}; 
			 } 
			 else if($(this).hasClass('bgh'))
			 {
				 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" li:hover a " , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thlinks" ,"shortname" : "bgh"}; 
			 }  
			else
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" a" , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thlinks" ,"shortname" : getShortFormat(tempval.data('attr'))};  
			 	 
			}
			
			});
			
			set[j++] = attrs;
	}
	
	
	if($('#tsubmenu').is(':visible'))
	{
		var attrs = new Array();
		i=0;
		$('#thsubmenu').find('div.thunder-option-available').each(function(){
			 
			 tempval = $(this).find('div.colorSelector');
			
			if(tempval.children('div').css('background-color')!="" && tempval.children('div').css('background-color')!="transparent" && tempval.children('div').css('background-color')!="rgba(0, 0, 0, 0)" ) {
			
			if($(this).hasClass('crh'))
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" .sub-menu li a:hover" , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color'), "tab" : "#thsubmenu" ,"shortname" : "crh" }; 
		    else if($(this).hasClass('cr'))
			 {
				 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" .sub-menu li a" , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color'), "tab" : "#thsubmenu" ,"shortname" : "cr" }; 
			 }
			else if($(this).hasClass('list-bbr'))
			 {
				 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" .sub-menu li " , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thsubmenu" ,"shortname" : "list-bbr"}; 
			 } 
			else
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" .sub-menu " , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thsubmenu" ,"shortname" : getShortFormat(tempval.data('attr'))};  
			 	 
			}
			
			});
			
			set[j++] = attrs;
	}
	
	
	if($('#tlist').is(':visible'))
	{
		var attrs = new Array();
		i=0;
		$('#thlist').find('div.thunder-option-available').each(function(){
			 
			tempval = $(this).find('div.colorSelector');
			if(tempval.children('div').css('background-color')!=""&& tempval.children('div').css('background-color')!="rgba(0, 0, 0, 0)" && tempval.children('div').css('background-color')!="transparent") 
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true) +" li", "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color')  , "tab" : "#thlist" ,"shortname" : getShortFormat(tempval.data('attr'))}; 
			});
			set[j++] = attrs;
	}
	
	if($('#theadings').is(':visible'))
	{
		var attrs = new Array();
		i=0;
		$('#thheadings').find('div.thunder-option-available').each(function(){
			 
			tempval = $(this).find('div.colorSelector');
			
			if(tempval.children('div').css('background-color')!="" && tempval.children('div').css('background-color')!="transparent"&& tempval.children('div').css('background-color')!="rgba(0, 0, 0, 0)" ) {
			
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true) +" h1", "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thheadings" ,"shortname" : getShortFormat(tempval.data('attr')) }; 
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true) +" h2", "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color')  , "tab" : "#thheadings" ,"shortname" : getShortFormat(tempval.data('attr')) }; 
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true) +" h3", "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color')  , "tab" : "#thheadings" ,"shortname" : getShortFormat(tempval.data('attr')) }; 
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true) +" h4", "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color')  , "tab" : "#thheadings" ,"shortname" : getShortFormat(tempval.data('attr')) }; 
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true) +" h5", "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color')  , "tab" : "#thheadings" ,"shortname" : getShortFormat(tempval.data('attr')) }; 
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true) +" h6", "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color')  , "tab" : "#thheadings" ,"shortname" : getShortFormat(tempval.data('attr')) }; 
			 
			}
			 
			});
			set[j++] = attrs;
	}
	
	
if($('#ttext').is(':visible'))
	{
		var attrs = new Array();
		i=0;
		$('#thtext').find('div.thunder-option-available').each(function(){
			 
			tempval = $(this).find('div.colorSelector');
			
			
			if(tempval.children('div').css('background-color')!="" && tempval.children('div').css('background-color')!="transparent"&& tempval.children('div').css('background-color')!="rgba(0, 0, 0, 0)" ) {
							 attrs[i++] = { "element" : getDOMPATH(current_listener,true) +" p", "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thtext" ,"shortname" : getShortFormat(tempval.data('attr')) }; 
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true) +" div", "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color'), "tab" : "#thtext" ,"shortname" : getShortFormat(tempval.data('attr'))  }; 
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true) +" span", "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thtext" ,"shortname" : getShortFormat(tempval.data('attr')) }; 
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true) +" strong", "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color'), "tab" : "#thtext" ,"shortname" : getShortFormat(tempval.data('attr'))  }; 
			 
			}
			 
			 });
	
			
			set[j++] = attrs;
	}
	
	
if($('#tbutton').is(':visible'))
	{
		var attrs = new Array();
		i=0;
		$('#thbutton').find('div.thunder-option-available').each(function(){
			 
			 tempval = $(this).find('div.colorSelector');
		
			if($(this).hasClass('crh'))
			{
				if(tempval.children('div').css('background-color')!="" && tempval.children('div').css('background-color')!="transparent"&& tempval.children('div').css('background-color')!="rgba(0, 0, 0, 0)" )
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" .thunder_button:hover " , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thbutton" ,"shortname" : "crh" };
			}
			 else if($(this).hasClass('bgh'))
			 {
				 if(tempval.children('div').css('background-color')!="" && tempval.children('div').css('background-color')!="transparent"&& tempval.children('div').css('background-color')!="rgba(0, 0, 0, 0)" )
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" .thunder_button:hover " , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thbutton" ,"shortname" : "bgh" }; 
			 }
		   else
		   {
			  if(tempval.children('div').css('background-color')!="" && tempval.children('div').css('background-color')!="transparent"&& tempval.children('div').css('background-color')!="rgba(0,0,0,0)" )
			    attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" .thunder_button" , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thbutton" ,"shortname" : getShortFormat(tempval.data('attr')) };  
		   }
			
			
			});
			
			set[j++] = attrs;
	}
	
if($('#timage').is(':visible'))
	{
		var attrs = new Array();
		i=0;
		$('#thimage').find('div.thunder-option-available').each(function(){
			 
			 tempval = $(this).find('div.colorSelector');
			
			if(tempval.children('div').css('background-color')!="" && tempval.children('div').css('background-color')!="transparent"&& tempval.children('div').css('background-color')!="rgba(0,0,0,0)" )
			 attrs[i++] = { "element" : getDOMPATH(current_listener,true)+" .thunder_image" , "property" : tempval.data('attr') , "value" : tempval.children('div').css('background-color') , "tab" : "#thimage" ,"shortname" : getShortFormat(tempval.data('attr'))};  
			 	 
			
			
			});
			
			set[j++] = attrs;
	}
			
	
	
	
	$.post($(this).data('url') , {  key: k , values : set } , 
	
	function(data){ 
	 
	$('div.thunder_wrapper').animate({left:-330},'normal');
	$('#save-th-settings').removeClass('saving');
	 
	 });
	 
	 
	e.preventDefault();
	});

$('a#delete-th-settings').click(function(e){
	$(this).addClass('deleting');
	var k = getDOMPATH(current_listener,true);
	$.post($(this).data('url') , {  key: k , values : 'release' } , 
	
	function(data){ 
	
	$('a#delete-th-settings').removeClass('deleting');
	 setTimeout("location.reload(true);",500);
	 });
		e.preventDefault();
	});
	
	
	})