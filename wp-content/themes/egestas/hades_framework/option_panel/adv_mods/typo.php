<?php 
$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];

require_once( $wp_url.'/wp-load.php' );
require_once( get_template_directory().'/hades_framework/helper/HadesUI.php' );
$ui = new HadesUI();

$google_webfonts =  array("Aclonica","Acme","Alice","Allan","Allerta","Allerta Stencil","Abril Fatface","Amaranth","Andada","Anonymous Pro","Anton","Antic","Antic Slab","Arimo","Artifika","Arvo","Averia Sans Libre","Bentham","Bevan","Belleza","Brawler","Bree Serif","Buda","Cabin","Cardo","Cousine","Cabin","Copse","Crimson Text","Cuprum","Cantarell","Coustard","Condiment","Dancing Script","Damion","Droid Serif","Droid Sans Mono","Droid Sans","Dorsa","Esteban","Exo","Francois One","Kreon","Kaushan Script","Gruppo","Gochi Hand","Inconsolata","Imprima","Lobster","Lobster Two","Lato","Josefin Slab","Josefin Sans","Marvel","Mate","Marck Script","Maiden Orange","Maven Pro","Merriweather","Merienda One","Montez","News Cycle","Nova Round","Nova Script","Nova Slim","Nobile","Open Sans","Open Sans Condensed","Oleo Script","Oswald","Overlock","Old Standard TT","PT Sans Narrow","Playfair Display","PT Sans","PT Serif","Pacifico","Philosopher","Questrial","Rosario","Rokkitt","Shanti","Tangerine","Terminal Dosis Light","Terminal Dosis","Tenor Sans","Tienne","Tinos","Ubuntu","Ubuntu Condensed","Vollkorn","Yanone Kaffeesatz","Yellowtail");

 $gf = array( 
					    "name" => "Google Web Font",
						"desc" => "When you've decided to go for Google Web Fonts then you need to select your font for the headings here.",
						"id" => $shortname."_gcustom_font",
						"type" => "select",
						"options" =>  $google_webfonts,
						"std" => "Droid Sans"
								);



$body_font_lists_safe = array("Arial","Georgia","Lucida Sans","Lucida Grande","Verdana","Helvetica","Helvetica Neue","Tahoma");
$body_font_lists = array_merge($body_font_lists_safe,$google_webfonts);

$body_font =   array( 
						"name" => "Body Font",
						"desc" => "Select the main font used all over the site.",
						"id" => $shortname."_body_font",
						"type" => "select",
						"options" => $body_font_lists,
						"std" => "Droid Sans"
								);



$cfonts = get_option(SN."_custom_fonts",array());
$cufon_fonts = array("Acid","akaDora","Colaborate","Delicious","DistrictThin","GeosansLight");

 
 if(is_array($cfonts))
	foreach($cfonts as $font)
	{
		$cufon_fonts[] = $font;
	}

 								
 
?>

<div class="panel hdv_typo">
<script type="text/javascript">
jQuery(function($){
	
	var font='',source = $("#gfont-frame").attr("src");

	$(".hbody_f select").change(function(){
		 font = jQuery.trim($(this).val());
		$("#gfont-frame").attr("src",source+font+"&fontsize="+$(".hbody_s input[type=text]").val());
		});
		
	$(".hcustom_f select").change(function(){
		 font = jQuery.trim($(this).val());
		$("#tfont-frame").attr("src",source+font+"&fontsize=18");
		});	
	
	$(".hcufon_f select").change(function(){
		 font = jQuery.trim($(this).val());
		$("#tfont-frame").attr("src",source+font+"&fontsize=18&cufon=true&path=<?php echo get_template_directory_uri()?>/sprites/js");
		});
	
	

				
	$(".hbody_s input[type=text]").focusout(function(){
		
		$("#gfont-frame").attr("src",source+font+"&fontsize="+$(this).val());
	
		});
	
	$(".hwebfont_f input[type=text]").focusout(function(){
		 font = jQuery.trim($(this).val());
		$("#tfont-frame").attr("src",source+font+"&fontsize=18");
	
		});	
	
	
	$(".hbody_s").find(".hades_slider").bind( "slidechange", function(event, ui) {
       $("#gfont-frame").attr("src",source+font+"&fontsize="+ui.value); });
		
});

</script>





<div class="preview-font">
  <iframe id="gfont-frame" src="<?php echo HURL; ?>/option_panel/adv_mods/gfont_input.php?font=" width="100%" height="130">
 
  </iframe>
 </div>
 
<?php 
        
       $ui->createHadesSelect($body_font,'hbody_f'); 
      
	   $ui->createHadesSlider( array( 
						"name" => "Body Font size",
						"desc" => "Select the body font size used all over the site.",
						"id" => $shortname."_bd_size",
						"type" => "slider",
						"std" => "12",
						"max" => 24,
						"suffix" => "px"
								),'hbody_s'); 
		 $ui->createHadesSelect( array( 
				  "name" => "Font Style",
				  "desc" => "select font style for the body.",
				  "id" => $shortname."_body_font_style",
				  "type" => "select",
				  "options" => array("normal","italic","oblique"),
				  "std" => "px"
				));						
	 	/*
		$ui->createHadesColorpicker(array( 
				  "name" => "Color Picker",
				  "desc" => "Your able to change the color.",
				  "id" => $shortname."_color",
				  "type" => "colorpickerfield",
				  "std" => "333333"
				  ));	*/				
								?>

  <div class="preview-font">
  <iframe id="tfont-frame" src="<?php echo HURL; ?>/option_panel/adv_mods/gfont_input.php?font=" width="100%" height="130">
 
  </iframe>
 </div>
 
 
 <?php 
 
   $ui->createHadesSelect(  array( 
						"name" => "Google Web font or Cufon Font for Titles",
						"desc" => "In here your able to switch between Google Fonts and Cufon Fonts. Be aware that this option is only made for titles and such. Body font is managed by google web font or websafe fonts",
						"id" => $shortname."_toggle_custom_font",
						"type" => "select",
						"std" => "Google Webfonts",
						"options" => array( "Google Webfonts","Cufon","None" )
					  ));	
					  
	$ui->createHadesSelect(  array( 
						"name" => "Cufon Font",
						"desc" => "When you've decided to go for Cufon Fonts then you need to select your font for the headings here.<strong>Note this is for titles only, if you want to use this font in your tags add class 'custom-font'.</strong>",
						"id" => $shortname."_cufon_font",
						"type" => "select",
						"options" =>  $cufon_fonts,
						"std" => "Androgyne"
								),'hcufon_f');					  
					  
	$ui->createHadesSelect( array( 
					    "name" => "Google Web Font",
						"desc" => "When you've decided to go for Google Web Fonts then you need to select your font for the headings here.",
						"id" => $shortname."_custom_font",
						"type" => "select",
						"options" =>  $google_webfonts,
						"std" => "Droid Sans"
								),'hcustom_f'); 			   
 
   $ui->createHadesSelect( array( 
					    "name" => "Intro Text Title Font",
						"desc" => "When you've decided to go for Google Web Fonts then you need to select your font for the headings here.",
						"id" => $shortname."_bcustom_font",
						"type" => "select",
						"options" =>  $google_webfonts,
						"std" => "Droid Sans"
								),'hcustom_f'); 
								
   $ui->createHadesToggle( array( 
						"name" => "Custom Google Web Font On/Off",
						"desc" => "Don't like the fonts we've selected and want to use a different one then activate this option and enter the name of the font below",
						"id" => $shortname."_custom_g_font_enable",
						"type" => "toggle",
						"std" => "false"
					  )); 	
					  
			  
					  
	$ui->createHadesTextbox(  array( 
						"name" => "Enter font name for Titles",
						"desc" => "you can select the fonts from <a href='http://www.google.com/webfonts'>here</a> , just enter the name of the font.",
						"id" => $shortname."_custom_g_font",
						"type" => "text",
						"std" => "",
								),'hwebfont_f'); 								
 
	$ui->createHadesTextbox(  array( 
						"name" => "Enter font weights for Titles",
						"desc" => "you can weights supported by the font, use comma for multiple weights example 100,200.",
						"id" => $shortname."_custom_g_font_weight",
						"type" => "text",
						"std" => "",
								),'hwebfont_f'); 	
	
	$ui->createHadesTextbox(  array( 
						"name" => "Enter font weights for Body",
						"desc" => "you can weights supported by the font, use comma for multiple weights example 100,200.",
						"id" => $shortname."_body_g_font_weight",
						"type" => "text",
						"std" => "",
								),'hwebfont_f'); 												
								
 ?>

 

</div>