// JavaScript Document


var loc = jQuery('#hurl').attr('href');

var img_loc = loc+"/css/i/icon.png";
loc = loc + "/helper/shortcode_listener.php";
// Creates a new plugin class
tinymce.create('tinymce.plugins.button', {
    createControl: function(n, cm) 
                {
                    switch (n) {
            case 'button':
                var c = cm.createMenuButton('Shortcodes', {
   title : 'WPTitans Shortcode Editor',
    image : img_loc
});

c.onRenderMenu.add(function(c, m) {
    m.add({title : 'Shortcodes', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
    
    // == Layout Maker ===========================================
    
     m.add({title : 'Icon', onclick : function() { 
	 
	  tb_show('Insert Shortcode',"#TB_inline"); 
		 jQuery("#TB_ajaxContent").load(loc+"?type=icons");
					jQuery("#TB_ajaxContent").css({ 
					  
					  width: jQuery("#TB_ajaxContent").parent().width()-30,
					  height: jQuery("#TB_ajaxContent").parent().height()-40
					});
					
	  }});  
      
	 m.add({title : 'Layouts'
	 ,onclick:function(){
		  
		   tb_show('Insert Shortcode',"#TB_inline"); 
		 jQuery("#TB_ajaxContent").load(loc+"?type=layout");
					jQuery("#TB_ajaxContent").css({ 
					  
					  width: jQuery("#TB_ajaxContent").parent().width(),
					  height: jQuery("#TB_ajaxContent").parent().height()-30,
                      margin: 0 , padding: 0 , overflow:"auto"
					 });
		 }
	 });
	
    // == Button Maker ===========================================
    
	 m.add({title : 'Buttons'
	 ,onclick:function(){
		  
		   tb_show('Insert Shortcode',"#TB_inline"); 
		 jQuery("#TB_ajaxContent").load(loc+"?type=button");
					jQuery("#TB_ajaxContent").css({ 
					  
					  width: jQuery("#TB_ajaxContent").parent().width(),
					  height: jQuery("#TB_ajaxContent").parent().height()-30,
                      margin: 0 , padding: 0 , overflow:"auto"
					 });
		 }
	 });
	
    // == Video shortcode ========================================				
	
    m.add({title : 'Video', onclick : function() {  tinyMCE.activeEditor.selection.setContent("[video width='300' height='250' /]your url here[/video]")  }});
	
    // == Typography shortcode
    
    var sub3 = m.addMenu({title : 'Typography', onclick : function() {   }});

	sub3.add({title : 'Quotes', onclick : function() { tinyMCE.activeEditor.selection.setContent('[quotes]'+tinyMCE.activeEditor.selection.getContent()+"[/quotes]");  }});
	sub3.add({title : 'Quotes Left', onclick : function() { tinyMCE.activeEditor.selection.setContent('[quotes_left]'+tinyMCE.activeEditor.selection.getContent()+"[/quotes_left]");  }});
	sub3.add({title : 'Quotes Right', onclick : function() { tinyMCE.activeEditor.selection.setContent('[quotes_right]'+tinyMCE.activeEditor.selection.getContent()+"[/quotes_right]");  }});
    sub3.add({title : 'PRE', onclick : function() { tinyMCE.activeEditor.selection.setContent('[pre]'+tinyMCE.activeEditor.selection.getContent()+"[/pre]");  }});
    
    
    // == UI shortcode ========================================
    
    var sub4 = m.addMenu({title : 'UI', onclick : function() {   }});
		sub4.add({title : 'Error Box', onclick : function() {  tinyMCE.activeEditor.selection.setContent('[error_box title="your title" ]'+tinyMCE.activeEditor.selection.getContent()+"[/error_box]");  }});
		sub4.add({title : 'Warning Box', onclick : function() {  tinyMCE.activeEditor.selection.setContent('[warning_box title="your title"   ]'+tinyMCE.activeEditor.selection.getContent()+"[/warning_box]");  }});
		sub4.add({title : 'Success Box', onclick : function() {  tinyMCE.activeEditor.selection.setContent('[success_box title="your title"   ]'+tinyMCE.activeEditor.selection.getContent()+"[/success_box]");  }});
		sub4.add({title : 'Information Box', onclick : function() {  tinyMCE.activeEditor.selection.setContent('[information_box title="your title" ]'+tinyMCE.activeEditor.selection.getContent()+"[/information_box]");  }});
        sub4.add({title : 'Tooltip', onclick : function() {  tinyMCE.activeEditor.selection.setContent('[tooltip tip_data="your title" ]'+tinyMCE.activeEditor.selection.getContent()+"[/tooltip]");  }});
        sub4.add({title : 'popover', onclick : function() {  tinyMCE.activeEditor.selection.setContent('[popover title="your title" data="your popver content here" ]'+tinyMCE.activeEditor.selection.getContent()+"[/popover]");  }});
        sub4.add({title : 'Separator', onclick : function() {  tinyMCE.activeEditor.selection.setContent('[separator full=true /]');  }});
    
  // == WIDGETS shortcode =====================================
  
  var sub5 = m.addMenu({title : 'Widgets', onclick : function() {   }});
   sub5.add({title : 'Tabs', onclick : function() { tinyMCE.activeEditor.selection.setContent('[tabs][tab title="your tab1 title"] your content here... [/tab][/tabs]');   }});
    sub5.add({title : 'Accordion', onclick : function() { tinyMCE.activeEditor.selection.setContent('[accordion][section  title="your tab1 title" collapse="false" ] your content here...  [/section][/accordion]');   }});
     sub5.add({title : 'FAQ', onclick : function() { tinyMCE.activeEditor.selection.setContent('[faq][qasection  question="Question 1 ?"] answer here...  [/qasection][/faq]');   }});
     sub5.add({title : 'Toggle', onclick : function() { tinyMCE.activeEditor.selection.setContent('[toggle  title="your tab1 title" collapse="false" ] your content here...  [/toggle]');   }});
  sub5.add({title : 'Google Map', onclick : function() { tinyMCE.activeEditor.selection.setContent("[map address='' width='300' height='' /]");   }});  
  
    var sub6 = m.addMenu({title : 'Social', onclick : function() {   }});
    sub6.add({title : 'Twitter', onclick : function() { tinyMCE.activeEditor.selection.setContent('[tweet name="yourusername" hashtags="test1,test2,test3" text="exicting offers" type="none" /]');   }});
    sub6.add({title : 'Facebook', onclick : function() { tinyMCE.activeEditor.selection.setContent('[facebook layout="standard"/]');   }});
    sub6.add({title : 'Google+', onclick : function() { tinyMCE.activeEditor.selection.setContent('[google size="small"/]');   }});
    sub6.add({title : 'Digg', onclick : function() { tinyMCE.activeEditor.selection.setContent('[digg size="Compact"]');   }});
    sub6.add({title : 'StumbleUpon', onclick : function() { tinyMCE.activeEditor.selection.setContent('[stumbleupon layout=1 /]');   }});
     sub6.add({title : 'Pinterest Follow', onclick : function() { tinyMCE.activeEditor.selection.setContent('[pinterestfollow  user=""  /]');   }});
      sub6.add({title : 'Pinterest Follow Small', onclick : function() { tinyMCE.activeEditor.selection.setContent('[pinterestfollow_small user="" /]');   }});
       sub6.add({title : 'Pinterest Pin', onclick : function() { tinyMCE.activeEditor.selection.setContent('[pinterest on_url="" to_url="" /]');   }});    
 
 
   m.add({title : 'Pricing Tables', onclick : function() { 
	 
	  tb_show('Insert Shortcode',"#TB_inline"); 
		 jQuery("#TB_ajaxContent").load(loc+"?type=tables");
					jQuery("#TB_ajaxContent").css({ 
					  
					  width: jQuery("#TB_ajaxContent").parent().width()-30,
					  height: jQuery("#TB_ajaxContent").parent().height()-40
					});
					
	  }}); 
      
    
    m.add({title : 'Slideshow', onclick : function() { 
	 
	  tb_show('Insert Shortcode',"#TB_inline"); 
		 jQuery("#TB_ajaxContent").load(loc+"?type=slider");
					jQuery("#TB_ajaxContent").css({ 
					  
					  width: jQuery("#TB_ajaxContent").parent().width()-30,
					  height: jQuery("#TB_ajaxContent").parent().height()-40
					});
					
	  }});   
     
     
});


                // Return the new splitbutton instance
                return c;
        }

            
                    return null;
                }
});

// Register plugin
tinymce.PluginManager.add('button', tinymce.plugins.button);