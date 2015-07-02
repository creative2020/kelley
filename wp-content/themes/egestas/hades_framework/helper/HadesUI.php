<?php
/* 
===================================================================================

   Author      - WPTitans
   Description - Base Class for Creating Admin Panels UI.
   Version     - 1.1
   
   Class functions index -
   
   1.  createHadesSelect
   2.  createHadesSlider
   3.  createHadesToggle
   4.  createHadesTextbox
   5.  createHadesTextarea
   
=================================================================================== */

if(!defined('HPATH'))
die(' The File cannot be accessed directly ');


if(!class_exists('HadesUI')) {

class HadesUI 
{
	
	public function createHadesSelect($meta_value,$class='')
    {
	?>
    <div class="hades_input clearfix <?php echo $class ?>">
      <label for="<?php echo $meta_value['id']; ?>"><?php echo $meta_value['name']; ?></label>
      <div class="select-wrapper clearfix">
          <select name="<?php echo $meta_value['id']; ?>" id="<?php echo $meta_value['id']; ?>">
          <?php foreach ($meta_value['options'] as $option) { ?>
          
          <option <?php 
          if (get_option( $meta_value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
          </select>
      </div>
     <?php if($meta_value['desc']!="") echo " <div class=\"description\"> ". $meta_value['desc'] ."</div>"; ?>
      </div>
      <?php
     
	  }


    public function createHadesSlider($meta_value,$class='')
	{
		?>
	<div class="hades_input clearfix <?php echo $class ?>">
	  <label for="<?php echo $meta_value['id']; ?>"><?php echo $meta_value['name']; ?></label>
	  <div class="hades_slider" ></div>
	  <input type="hidden" class="slider-val"  value="<?php if ( get_option( $meta_value['id'] ) != "") { echo stripslashes(get_option( $meta_value['id'])  ); } else { echo $meta_value['std']; } ?>" />
	  <input type="hidden" class="max-slider-val"  value="<?php if($meta_value["max"]=="") echo 500; else echo $meta_value["max"]; ?>" />
	   
	  <input name="<?php echo $meta_value['id']; ?>" id="<?php echo $meta_value['id']; ?>" type="text" value="<?php if ( get_option( $meta_value['id'] ) != "") { echo stripslashes(get_option( $meta_value['id'])  ); } else { echo $meta_value['std']; } ?>"class='slider-text' /><h6 class="slider-suffix"><?php if(isset( $value['suffix'])) echo $value['suffix']; ?></h6>
	    <?php if($meta_value['desc']!="") echo " <div class=\"description\"> ".$meta_value['desc']."</div>"; ?>
	  </div>
	<?php
	}

public function createHadesColorpicker($meta_value,$class='')
    {
	?>
    <div class="hades_input clearfix  <?php echo $meta_value['parentClass']." ".$class; ?>">
								<label for="<?php echo $meta_value['id']; ?>"><?php echo $meta_value['name']; ?></label>
                <div class="colorSelector" ><div style="background-color:#<?php if ( get_option( $meta_value['id'] ) != "") { echo stripslashes(get_option( $meta_value['id'])  ); } else { echo $meta_value['std']; } ?>"></div></div><input type="text"  name="<?php echo $meta_value['id']; ?>" id="<?php echo $meta_value['id']; ?>" class="colorpickerField1 width-small" value="<?php if ( get_option( $meta_value['id'] ) != "") { echo stripslashes(get_option( $meta_value['id'])  ); } else { echo $meta_value['std']; } ?>" />
             
               
                <?php if($meta_value['desc']!="") echo " <div class=\"description\"> ".  $meta_value['desc'] ."</div>"; ?>
 						    </div>
      <?php
     
	  }
	public function createHadesToggle($meta_value,$class='')
	{
		?>
	  <div class="hades_input clearfix  <?php echo $class ?>">
		  <label><?php echo $meta_value['name']; 
		  if(get_option($meta_value['id'])!="")
		  { $checker = get_option($meta_value['id']); }
		  else
		  { $checker = $meta_value['std'];  }
		  ?></label>
		  
		  
		  
		  <div class="radio">
		  <input type="radio" name="<?php echo $meta_value['id']; ?>" id="<?php echo $meta_value['id']; ?>1"  
		  <?php  if($checker=="true") echo "checked=\"checked\""; ?> value="true" /><label for="<?php echo $meta_value['id']; ?>1">ON</label>
		  <input type="radio" name="<?php echo $meta_value['id']; ?>" id="<?php echo $meta_value['id']; ?>2" 
		  <?php  if($checker=="false") echo "checked=\"checked\""; ?>  value="false"/><label for="<?php echo $meta_value['id']; ?>2">OFF</label>
		  </div>
		  
		  
		  
		  
		   <?php if($meta_value['desc']!="") echo " <div class=\"description\"> ".  $meta_value['desc'] ."</div>"; ?>
	  </div>
	<?php
	}


	public function createHadesTextbox($meta_value,$class='')
	{
		?>
	  <div class="hades_input clearfix  <?php echo $class ?>">
		  <label for="<?php echo $meta_value['id']; ?>"><?php echo $meta_value['name']; ?></label>
		  <input name="<?php echo $meta_value['id']; ?>" id="<?php echo $meta_value['id']; ?>" type="<?php echo $meta_value['type']; ?>" value="<?php if ( get_option( $meta_value['id'] ) != "") { echo stripslashes(get_option( $meta_value['id'])  ); } else { echo $meta_value['std']; } ?>" />
		  
		   <?php if($meta_value['desc']!="") echo " <div class=\"description\"> ". $meta_value['desc']."</div>"; ?>
	  </div>
	<?php
	}

	public function createHadesTextarea($meta_value,$class='')
	{
		?>
	  <div class="hades_input clearfix  <?php echo $class ?>">
										<label for="<?php echo $meta_value['id']; ?>"><?php echo $meta_value['name']; ?></label>
										<textarea name="<?php echo $meta_value['id']; ?>" type="<?php echo $meta_value['type']; ?>" cols="" rows=""><?php if ( get_option( $meta_value['id'] ) != "") { echo stripslashes(get_option( $meta_value['id']) ); } else { echo $meta_value['std']; } ?></textarea>
										  <?php if($meta_value['desc']!="") echo " <div class=\"description\"> ".  $meta_value['desc']."</div>"; ?>
									 </div>
	<?php
	}
	



}

}