<?php

/* ======================================================================= */
/* == Custom Box Maker =================================================== */
/* ======================================================================= */

/* 

Author - WPTitans
Code Name - Custom Box Maker
Version - 1.0
Description - Creates custom meta boxes for themes that works on Hades Plus Framework.

*/


if(!class_exists('TitanMetaBox')) {

// == Class defination begins	=====================================================
  class TitanMetaBox {
  
  private $metaData;
  private $name;
  private $page; 
  private $context; 
  private $priority;
  private $fields;
  private $tag;
  function __construct($title,$data)
  {
	
	$this->name = $title;
	$this->metaData = $data;
	$this->page = $data["post_type"];
	$this->context = $data["context"]; 
	$this->priority = $data["priority"];
	$this->fields = $data["input_fields"];
	$this->tag = trim(str_replace(" ","",$this->name)) ; 
	add_action( 'admin_init', array( &$this, 'add_custom_meta_box' ) );
	add_action( 'save_post', array( &$this, 'custom_save_data' ));
  }
  
  
  
  function add_custom_meta_box(){
	
	  
    	add_meta_box( 
		    $this->tag,
			$this->name , 
			array(&$this,"custom_html_wrap")  , 
			$this->page, 
			$this->context, 
			$this->priority );
	 }
	 
  function custom_html_wrap(){
	    global $post;
		$tag = $this->tag;
		$custom = get_post_meta($post->ID,$tag,true);
        echo '<input type="hidden" name="'.$tag.'" id="'.$tag.'" value="'.wp_create_nonce($tag).'" />';
      
		
	    $i = 0;
		$field = $this->fields;
	    for(;$i<count($field[0]);$i++)
	    {
			switch($field[0][$i])
			{
				case "text" : ?>  
				
                <div class="hades_input clearfix"><label for="<?php echo $field[2][$i]; ?>" style=""> <?php echo $field[1][$i]; ?> </label><input type="text" name="<?php echo $field[2][$i]; ?>" id="<?php echo $field[2][$i]; ?>" value="<?php 
				  if( get_post_meta($post->ID, $field[2][$i],true)!="") 
				    echo get_post_meta($post->ID, $field[2][$i],true); else echo $field[3][$i]; ?>" /></div>
				
				<?php break;
				
				case "datepicker" : ?>  
				
                <div class="hades_input clearfix"><label for="<?php echo $field[2][$i]; ?>" style=""> <?php echo $field[1][$i]; ?> </label><input type="text" name="<?php echo $field[2][$i]; ?>" id="<?php echo $field[2][$i]; ?>" value="<?php 
				  if( get_post_meta($post->ID, $field[2][$i],true)!="") 
				    echo get_post_meta($post->ID, $field[2][$i],true); else echo $field[3][$i]; ?>" class="ev_datepicker" /></div>
				
				<?php break;
				
				case "textarea" : ?>  
				
                <div class="hades_input clearfix"><label for="<?php echo $field[2][$i]; ?>"> <?php echo $field[1][$i]; ?> </label><textarea type="text" name="<?php echo $field[2][$i]; ?>" id="<?php echo $field[2][$i]; ?>"  ><?php 
				  if( get_post_meta($post->ID, $field[2][$i],true)!="") 
				    echo get_post_meta($post->ID, $field[2][$i],true); else echo $field[3][$i]; ?></textarea></div>
				
				<?php break;
				
				case "checkbox" : $options = explode(",",$field[3][$i]); ?>  
				
                <div class="hades_input clearfix">
                <label for="<?php echo $field[2][$i]; ?>"> <?php echo $field[1][$i]; ?> </label>
                    <div class="hades_radio clearfix">
                     
                    <?php $j =0; $checked = ''; $correct_option = get_post_meta($post->ID, $field[2][$i],true);
					
					if(!is_array($correct_option)) $correct_option = array();
					
					
					 foreach($options as $option) {
						
						if(in_array($option,$correct_option))
						$checked = 'checked="checked"';
						else
						$checked = '';
						
						echo '  <p class="clearfix"><label for="'.$field[2][$i].$j.'"> '.$option.' </label> <input type="checkbox" value="'.$option.'" name="'.$field[2][$i].'[]" id="'.$field[2][$i].$j.'" '.$checked.' /> </p>';
						$j++; } ?>
                    
                    </div>

                </div>
				
				<?php break;
				
				
				case "radio" : $options = explode(",",$field[3][$i]); ?>  
				
                <div class="hades_input clearfix">
                <label for="<?php echo $field[2][$i]; ?>"> <?php echo $field[1][$i]; ?> </label>
                    <div class="hades_radio">
                     
                  <?php $j =0; $checked = ''; $correct_option = get_post_meta($post->ID, $field[2][$i],true); foreach($options as $option) {
						
						if($correct_option==$option)
						$checked = 'checked="checked"';
						else
						$checked = '';
						
						echo '  <p class="clearfix"><label for="'.$field[2][$i].$j.'"> '.$option.' </label> <input type="radio" value="'.$option.'" name="'.$field[2][$i].'" id="'.$field[2][$i].$j.'" '.$checked.' /> </p>';
						$j++; } ?>
                    
                    </div>
                </div>
				
				<?php break;
				
				
				case "select" : $checked = ''; $correct_option = get_post_meta($post->ID, $field[2][$i],true);  $options = explode(",",$field[3][$i]); ?>  
				
                <div class="hades_input clearfix">
                <label for="<?php echo $field[2][$i]; ?>"> <?php echo $field[1][$i]; ?> </label><div class="select-wrapper">
                
                <select name="<?php echo $field[2][$i]; ?>" id="<?php echo $field[2][$i]; ?>">     
                    <?php $j =0; foreach($options as $option) {
						
						if($correct_option==$option)
						$checked = 'selected="selected"';
						else
						$checked = '';
						
						echo '  <option value="'.$option.'" '.$checked.' > '.$option.' </option>';
						$j++; } ?>
                    
               </select></div>
                </div>
				
				<?php break;
				
				case "image" : $options = explode(",",$field[3][$i]); ?>  
				  <div class="hades_input clearfix"><label for="<?php echo $field[2][$i]; ?>"> <?php echo $field[1][$i]; ?> </label><input type="text" name="<?php echo $field[2][$i]; ?>" id="<?php echo $field[2][$i]; ?>" value="<?php 
				  if( get_post_meta($post->ID, $field[2][$i],true)!="") 
				    echo get_post_meta($post->ID, $field[2][$i],true); else echo $field[3][$i]; ?>" /> <a href="#" class="button custom_upload_image_button"> Upload </a>  </div>
				<?php break;
				
				case "datepicker" : $options = explode(",",$field[3][$i]); ?>  
				  <div class="hades_input clearfix"><label for="<?php echo $field[2][$i]; ?>"> <?php echo $field[1][$i]; ?> </label><input type="text" name="<?php echo $field[2][$i]; ?>" id="<?php echo $field[2][$i]; ?>" value="<?php 
				  if( get_post_meta($post->ID, $field[2][$i],true)!="") 
				    echo get_post_meta($post->ID, $field[2][$i],true); else echo $field[3][$i]; ?>" class="datapicker" />   </div>
				<?php break;
				
				case "separator" : ?>  
				 <div class="mseparator clearfix"></div>
				<?php break;
				
				case "time" :
				$correct_option = get_post_meta($post->ID, $field[2][$i],true);
				$time = array("12:00 AM","12:15 AM","12:30 AM","12:45 AM","1:00 AM","1:15 AM","1:30 AM","1:45 AM","2:00 AM","2:15 AM","2:30 AM","2:45 AM","3:00 AM","3:15 AM","3:30 AM","3:45 AM","4:00 AM","4:15 AM","4:30 AM","4:45 AM","5:00 AM","5:15 AM","5:30 AM","5:45 AM","6:00 AM","6:15 AM","6:30 AM","6:45 AM","7:00 AM","7:15 AM","7:30 AM","7:45 AM","8:00 AM","8:15 AM","8:30 AM","8:45 AM","9:00 AM","9:15 AM","9:30 AM","9:45 AM","10:00 AM","10:15 AM","10:30 AM","10:45 AM","11:00 AM","11:15 AM","11:30 AM","11:45 AM","12:00 PM","12:15 PM","12:30 PM","12:45 PM","1:00 PM","1:15 PM","1:30 PM","1:45 PM","2:00 PM","2:15 PM","2:30 PM","2:45 PM","3:00 PM","3:15 PM","3:30 PM","3:45 PM","4:00 PM","4:15 PM","4:30 PM","4:45 PM","5:00 PM","5:15 PM","5:30 PM","5:45 PM","6:00 PM","6:15 PM","6:30 PM","6:45 PM","7:00 PM","7:15 PM","7:30 PM","7:45 PM","8:00 PM","8:15 PM","8:30 PM","8:45 PM","9:00 PM","9:15 PM","9:30 PM","9:45 PM","10:00 PM","10:15 PM","10:30 PM","10:45 PM","11:00 PM","11:15 PM","11:30 PM","11:45 PM");
				 ?> 
				 <div class="hades_input clearfix">
                  <label for="<?php echo $field[2][$i]; ?>"> <?php echo $field[1][$i]; ?> </label><div class="select-wrapper">
                  <select name="<?php echo $field[2][$i]; ?>" id="<?php echo $field[2][$i]; ?>">     
                    <?php $j =0; foreach($time as $option) {
						
						if($correct_option==$option)
						$checked = 'selected="selected"';
						else
						$checked = '';
						
						echo '  <option value="'.$option.'" '.$checked.' > '.$option.' </option>';
						$j++; } ?>
                </select></div>
				</div>
				<?php break;
				
				
				case "country" :
				$correct_option = get_post_meta($post->ID, $field[2][$i],true);
				$countries = array( "Afghanistan","Albania",	"Algeria",	"Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia",
		"Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia",	"Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso",	"Burundi","Cambodia","Cameroon","Canada","Cape Verde","Central African Republic","Chad","Chile","China","Colombi","Comoros","Congo (Brazzaville)","Congo","Costa Rica","Cote d'Ivoire","Croatia","Cuba",	"Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor (Timor Timur)",	"Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia",	"Ethiopia","Fiji","Finland","France",	"Gabon","Gambia, The","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea, North","Korea, South","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia",	"Maldives",	"Mali",	"Malta","Marshall Islands",	"Mauritania","Mauritius","Mexico","Micronesia","Moldova",	"Monaco","Mongolia","Morocco","Mozambique",	"Myanmar","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","Norway",	"Oman","Pakistan","Palau","Panama","Papua New Guinea",	"Paraguay",	"Peru","Philippines","Poland","Portugal",		"Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore",	"Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka","Sudan","Suriname","Swaziland",	"Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand",	"Togo",	"Tonga","Trinidad and Tobago",	"Tunisia",	"Turkey","Turkmenistan","Tuvalu","Uganda",	"Ukraine","United Arab Emirates",	"United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"
	);
				 ?> 
				 <div class="hades_input clearfix">
                  <label for="<?php echo $field[2][$i]; ?>"> <?php echo $field[1][$i]; ?> </label>
                  <select name="<?php echo $field[2][$i]; ?>" id="<?php echo $field[2][$i]; ?>">     
                    <?php $j =0; foreach($countries as $option) {
						
						if($correct_option==$option)
						$checked = 'selected="selected"';
						else
						$checked = '';
						
						echo '  <option value="'.$option.'" '.$checked.' > '.$option.' </option>';
						$j++; } ?>
                </select>
				</div>
				<?php break;
				
			}
		  
	    }
	 
	  
	 }	 
	
	function custom_save_data() {
		global $post;
		
		


		$i = 0;
		$field = $this->fields;
	    for(;$i<count($field[0]);$i++)
	    {
			if(isset($_POST[$field[2][$i]]))
			update_post_meta($post->ID, $field[2][$i] , $_POST[$field[2][$i]]);
		}
		
		}
	 
	 
	 } // == Class Ends ================================================================
  }
  
