<?php


$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];

require_once( $wp_url.'/wp-load.php' );
$type = $_GET["type"];  
?>



<!-- ============================================================================================================== -->
<!-- == LAYOUT BUILDER ============================================================================================ -->
<!-- ============================================================================================================== -->


<?php if($type=="layout") : ?>





<div class="wrap" id="editor_wrap">

  
  
    <div id="Metamorphosis" class="clearfix">
    
    
  
    <div class="canvas-holder">
     
          
    <form action="" method="post" enctype="multipart/form-data">
    
     <div id="general">
      	
        <div class="layout-bar clearfix">
           <label for="layout-select"> Select Column Layout </label>
           <select name="" class="layout-select">
                <option value="full_width">Full Width</option>
                
                <optgroup  label="2 Columns">
                <option value="1/2 - 1/2">1/2 - 1/2</option>
                <option value="1/4 - 3/4">1/4 - 3/4</option>
                <option value="3/4 - 1/4">3/4 - 1/4</option>
                <option value="1/3 - 2/3">1/3 - 2/3</option>
                <option value="2/3 - 1/3">2/3 - 1/3</option>
                <option value="1/5 - 4/5">1/5 - 4/5</option>
                <option value="4/5 - 1/5">4/5 - 1/5</option>
                </optgroup>
                
                <optgroup  label="3 Columns">
                <option value="1/2 - 1/4 - 1/4">1/2 - 1/4 - 1/4</option>
                <option value="1/4 - 1/2 - 1/4">1/4 - 1/2 - 1/4</option>
                <option value="1/4 - 1/4 - 1/2">1/4 - 1/4 - 1/2</option>
                <option value="1/3 - 1/3 - 1/3">1/3 - 1/3 - 1/3</option>
                </optgroup>
                
                <optgroup  label="Others">
                <option value="1/4 - 1/4 - 1/4 - 1/4">1/4 - 1/4 - 1/4 - 1/4</option>
                <option value="1/5 - 1/5 - 1/5 - 1/5 - 1/5">1/5 - 1/5 - 1/5 - 1/5 - 1/5</option>
                
                </optgroup>
          </select>
          <a href="" class="addlayout button-default">Add</a>
          <a href="" class="done_shortcode button-save">Insert To Editor</a>
          
          
        <span class="loader"></span>


        </div>
        <div class="canvas">
         </div>
      </div><!-- End of general tab -->
      
      <input type="hidden" class="shortcode_value" value="layout" />

  </form>
    </div>
     
    
    
    
    </div> 
 
</div>	<!--  End of Wrapper -->



<!-- ============================================================================================================== -->
<!-- == Button BUILDER ============================================================================================ -->
<!-- ============================================================================================================== -->

<?php elseif($type=="button") : ?>


<script type="text/javascript">
jQuery(function($){
	var tlightbox = jQuery("#TB_ajaxContent");
	$('#colorSelector').ColorPicker({
	color: '#0000ff',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		
		$('#colorSelector div').css('backgroundColor', '#' + hex);
		tlightbox.find('.preview-panel a').css('color', '#' + hex);
	  }
    });

    $('#bgcolorSelector').ColorPicker({
	color: '#0000ff',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#bgcolorSelector div').css('backgroundColor', '#' + hex);
		tlightbox.find('.preview-panel a').css({
			'backgroundColor': '#' + hex,
			'border': '#' + hex+" 1px solid" }
			);
	}
    });
	
	   tlightbox.find(".shortcode_border_radius").live('focusout',function(){
	
		  tlightbox.find('.preview-panel a').css({
		 "border-radius": $(this).val()+"px",
		 "-moz-border-radius": $(this).val()+"px",
		 "-webkit-border-radius": $(this).val()+"px"
	  });;
	});
	
	
	 tlightbox.find("#button-styler").live("change",function(){
		
	    tlightbox.find('.preview-panel a').removeClass(); 
    	tlightbox.find('.preview-panel a').addClass($(this).val());
	});


	});

</script>

<div class="shortcode-lightbox">

 <div class="top-panel clearfix">
 <a href="#" class="done_shortcode button-save"> Done </a>

 
  
            
 </div>
  <p class="preview-panel clearfix"> <span>Preview</span> 
            <a href="#" class="shade" style=""> Button </a>
   </p>
 
 
 <div class="hades_input clearfix">
     	<label for="">Enter Button Title</label>
 		<input type="text" value="" class="button_title" id="button_title" />
 </div>
 
  <div class="hades_input clearfix">
   <label for="text">Set Text color</label>
   <div class="colorSelector" id="colorSelector" ><div style="background-color:#fff"></div></div> 
   
  </div>
 
 
 <div class="hades_input clearfix">
   <label for="text">Set Background color</label>
   <div class="colorSelector" id="bgcolorSelector" ><div style="background-color:#111"></div></div> 
   
  </div>
 

    
 <div class="hades_input clearfix" >        
 	<label for="shortcode_border_radius">Border Radius(in numbers)</label>
	 <input type="text" name="" id="shortcode_border_radius" class="shortcode_border_radius" value="3" />
 </div> 
 
  <div class="hades_input clearfix">        
	 <label for="shortcode_link">Add your URL in here</label>
	 <input type="text" name="" id="shortcode_link" class="shortcode_link" value="http://" />
 </div> 
 
 <div class="hades_input clearfix">        
	 <label for="new_window_button">Open in New Window</label>
	 <div class="select-wrapper">
     	<select name="new_window_button" id="new_window_button">
        	<option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
     </div>
 </div>            
 
 
  <div class="hades_input clearfix">        
	 <label for="new_size_button">Button Size</label>
	 <div class="select-wrapper">
     	<select name="new_size_button" id="new_size_button">
        	<option value="small">Small</option>
            <option value="medium">Medium</option>
            <option value="big">Big</option>
        </select>
     </div>
 </div>  
 
 
</div>

<input type="hidden" class="shortcode_value" value="image" />

</div>

<?php elseif($type=="tables"):

global $wpdb;
$table_db_name = $wpdb->prefix . "megatables";
$tables = $wpdb->get_results("SELECT id,table_name FROM $table_db_name ",ARRAY_A);
$table_array = array();
 foreach($tables as $table )
 $table_array[$table['id']] = $table["table_name"];


 ?>
 
 <div class="top-panel">
 <select id="shortcode-contact-preview">
   <?php 
    $ex_sliders = unserialize(get_option(SN."_sliders"));
    $sliders = array();

if(!is_array($table_array)) $table_array = array("No Tables");

	 foreach($table_array as $key => $tb)
				   {
					  
					   echo "<option value='{$key}'>{$tb}</option>";
				   }
	         
   ?>
   </select>  <a href="#" class="done_shortcode button" > Done </a>
  <input type="hidden" class="shortcode_value" value="tables" />
 </div>
 
<?php elseif($type=="slider"): 
 
 global $wpdb;
$table_db_name = $wpdb->prefix . "tslidermanager";
$sliders =  $wpdb->get_results("SELECT * FROM $table_db_name ",ARRAY_A);


 ?>
 
 <div class="top-panel">
 <select id="shortcode-contact-preview">
   <?php 
  
if(!is_array($sliders)) $sliders = array("No Slider");


 foreach($sliders as $slider)
			   {
				    $options =  unserialize($slider['options']);
				   if($slider['id']!="1")
				   echo "<option value='{$slider[id]}'>{$options[title]}</option>";
			   }
			   

	         
   ?>
   </select>  <a href="#" class="done_shortcode button"> Done </a>
  <input type="hidden" class="shortcode_value" value="slider" />
 </div>


<?php elseif($type=="icons"): 


 ?>
 
 <div class="hades_input clearfix">
 
 <label for=""> Select Icon - </label>
    <div class="select-wrapper">
 	<select id="shortcode-contact-preview">
 		
       <option value="icon-glass">icon-glass</option>
       <option value="icon-music">icon-music</option>
       <option value="icon-search">icon-search</option>
       <option value="icon-envelope">icon-envelope</option>
       <option value="icon-heart">icon-heart</option>
       <option value="icon-star">icon-star</option>
       <option value="icon-star-empty">icon-star-empty</option>
       <option value="icon-user">icon-user</option>
       <option value="icon-film">icon-film</option>
       <option value="icon-th-large">icon-th-large</option>
       <option value="icon-th">icon-th</option>
       <option value="icon-th-list">icon-th-list</option>
       <option value="icon-ok">icon-ok</option>
       <option value="icon-remove">icon-remove</option>
       <option value="icon-zoom-in">icon-zoom-in</option>
       <option value="icon-zoom-out">icon-zoom-out</option>
       <option value="icon-off">icon-off</option>
       <option value="icon-signal">icon-signal</option>
       <option value="icon-cog">icon-cog</option>
       <option value="icon-trash">icon-trash</option>
       <option value="icon-home">icon-home</option>
       <option value="icon-file">icon-file</option>
       <option value="icon-time">icon-time</option>
       <option value="icon-road">icon-road</option>
       <option value="icon-download-alt">icon-download-alt</option>
       <option value="icon-download">icon-download</option>
       <option value="icon-upload">icon-upload</option>
       <option value="icon-inbox">icon-inbox</option>
       <option value="icon-play-circle">icon-play-circle</option>
       <option value="icon-repeat">icon-repeat</option>
       <option value="icon-refresh">icon-refresh</option>
       <option value="icon-list-alt">icon-list-alt</option>
       <option value="icon-lock">icon-lock</option>
       <option value="icon-flag">icon-flag</option>
       <option value="icon-headphones">icon-headphones</option>
       <option value="icon-volume-off">icon-volume-off</option>
       <option value="icon-volume-down">icon-volume-down</option>
       <option value="icon-volume-up">icon-volume-up</option>
       <option value="icon-qrcode">icon-qrcode</option>
       <option value="icon-barcode">icon-barcode</option>
       <option value="icon-tag">icon-tag</option>
       <option value="icon-tags">icon-tags</option>
       <option value="icon-book">icon-book</option>
       <option value="icon-bookmark">icon-bookmark</option>
       <option value="icon-print">icon-print</option>
       <option value="icon-camera">icon-camera</option>
       <option value="icon-font">icon-font</option>
       <option value="icon-bold">icon-bold</option>
       <option value="icon-italic">icon-italic</option>
       <option value="icon-text-height">icon-text-height</option>
       <option value="icon-text-width">icon-text-width</option>
       <option value="icon-align-left">icon-align-left</option>
       <option value="icon-align-center">icon-align-center</option>
       <option value="icon-align-right">icon-align-right</option>
       <option value="icon-align-justify">icon-align-justify</option>
       <option value="icon-list">icon-list</option>
       <option value="icon-indent-left">icon-indent-left</option>
       <option value="icon-indent-right">icon-indent-right</option>
       <option value="icon-facetime-video">icon-facetime-video</option>
       <option value="icon-picture">icon-picture</option>
       <option value="icon-pencil">icon-pencil</option>
       <option value="icon-map-marker">icon-map-marker</option>
       <option value="icon-adjust">icon-adjust</option>
       <option value="icon-tint">icon-tint</option>
       <option value="icon-edit">icon-edit</option>
       <option value="icon-share">icon-share</option>
       <option value="icon-check">icon-check</option>
       <option value="icon-move">icon-move</option>
       <option value="icon-step-backward">icon-step-backward</option>
       <option value="icon-fast-backward">icon-fast-backward</option>
       <option value="icon-backward">icon-backward</option>
       <option value="icon-play">icon-play</option>
       <option value="icon-pause">icon-pause</option>
       <option value="icon-stop">icon-stop</option>
       <option value="icon-forward">icon-forward</option>
       <option value="icon-fast-forward">icon-fast-forward</option>
       <option value="icon-step-forward">icon-step-forward</option>
       <option value="icon-eject">icon-eject</option>
       <option value="icon-chevron-left">icon-chevron-left</option>
       <option value="icon-chevron-right">icon-chevron-right</option>
       <option value="icon-plus-sign">icon-plus-sign</option>
       <option value="icon-minus-sign">icon-minus-sign</option>
       <option value="icon-remove-sign">icon-remove-sign</option>
       <option value="icon-ok-sign">icon-ok-sign</option>
       <option value="icon-question-sign">icon-question-sign</option>
       <option value="icon-info-sign">icon-info-sign</option>
       <option value="icon-screenshot">icon-screenshot</option>
       <option value="icon-remove-circle">icon-remove-circle</option>
       <option value="icon-ok-circle">icon-ok-circle</option>
       <option value="icon-ban-circle">icon-ban-circle</option>
       <option value="icon-arrow-left">icon-arrow-left</option>
       <option value="icon-arrow-right">icon-arrow-right</option>
       <option value="icon-arrow-up">icon-arrow-up</option>
       <option value="icon-arrow-down">icon-arrow-down</option>
       <option value="icon-share-alt">icon-share-alt</option>
       <option value="icon-resize-full">icon-resize-full</option>
       <option value="icon-resize-small">icon-resize-small</option>
       <option value="icon-plus">icon-plus</option>
       <option value="icon-minus">icon-minus</option>
       <option value="icon-asterisk">icon-asterisk</option>
       <option value="icon-exclamation-sign">icon-exclamation-sign</option>
       <option value="icon-gift">icon-gift</option>
       <option value="icon-leaf">icon-leaf</option>
       <option value="icon-fire">icon-fire</option>
       <option value="icon-eye-open">icon-eye-open</option>
       <option value="icon-eye-close">icon-eye-close</option>
       <option value="icon-warning-sign">icon-warning-sign</option>
       <option value="icon-plane">icon-plane</option>
       <option value="icon-calendar">icon-calendar</option>
       <option value="icon-random">icon-random</option>
       <option value="icon-comment">icon-comment</option>
       <option value="icon-magnet">icon-magnet</option>
       <option value="icon-chevron-up">icon-chevron-up</option>
       <option value="icon-chevron-down">icon-chevron-down</option>
       <option value="icon-retweet">icon-retweet</option>
       <option value="icon-shopping-cart">icon-shopping-cart</option>
       <option value="icon-folder-close">icon-folder-close</option>
       <option value="icon-folder-open">icon-folder-open</option>
       <option value="icon-resize-vertical">icon-resize-vertical</option>
       <option value="icon-resize-horizontal">icon-resize-horizontal</option>
        
 	</select>  </div> <a href="#" class="done_shortcode button-default" style="margin:0px 0 0 6px;float:left"> Done </a>
 
  
 </div>
 
 
 
 
 <div class="hades_input clearfix">
 	<label for=""> Icon Color  </label>
    <div class="select-wrapper">
    	<select name="" id="icon-color">
        	<option value="Black">Black</option>
            <option value="White">White</option>
        </select>
    </div>
 </div>
 
 <div class="preview-icon">
  <i class="icon-glass"></i>
 </div>
 
  <input type="hidden" class="shortcode_value" value="icons" />
  
<?php endif; ?> 









