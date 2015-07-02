<?php
/*
Template Name: Portfolio 3 Column Page Template
*/
?>

<?php
// == Layout Calculation =========================================

$layout =    get_post_meta($post->ID,'_sidebar',true);
$layout =  "full-width" ; // ~~ For pages existing prior to theme activation should have full width by default ~  

$sidebar1 =    get_post_meta($post->ID,'_dynamic_sidebar',true);
$sidebar2 =    get_post_meta($post->ID,'_dynamic_sidebar2',true);


$content_width = '';
$width = 312;
 $height = 200;
switch($layout)
 { 
   case "hasLeftSidebar" :
   case "hasRightSidebar" :  $content_width = 'two-third-width'; $width = 120; $height = 90; break;
   case "hasDoubleSidebar" :

 }
$categories = (!is_array(get_post_meta($post->ID,"_portfolio_filter",true)) ) ? false : get_post_meta($post->ID,"_portfolio_filter",true);
$live =  (trim(get_post_meta($post->ID,"_live_filter",true))=="") ? "No" : get_post_meta($post->ID,"_live_filter",true);

$meta_filters =  ( trim(get_post_meta($post->ID,"_meta_filter",true))=="") ? "none" : get_post_meta($post->ID,"_meta_filter",true);
$order =  ( trim(get_post_meta($post->ID,"_order",true))=="") ? "none" : get_post_meta($post->ID,"_order",true);



$portfolio_options = array(
							'items_limit' => 9,
							'content_limit' =>  250,
    				  	    'categories' => $categories,
							'meta_filters' => $meta_filters,
							'order' => $order,
							'width' => $width ,
							'height' => $height,
							'meta_data' => false,
							'clear' => 3,
							'label' => 'portfolio-item-3-',
							'lightbox' => $super_options[SN.'_portfolio_enable_thumbnail']
						  );


get_header(); ?>   

<?php  if(have_posts()): while(have_posts()) : the_post(); ?>

<div class="page-wrapper">

<div class="title thunder_listener" data-filter="bg" data-headings-filter="cr bbr">
     	<div class="skeleton">
        	<h1 class="custom-font"><?php the_title(); ?></h1> 
            
           
        </div>
   	 </div>
 <?php  if($super_options[SN."_breadcrumbs_enable"]=="true" && !is_front_page()) $helper->breadcrumbs(); ?> <!-- The breadcrumb for the theme -->
  <?php if($live!="No") : ?>   <div class="portfolio-taxonomy  thunder_listener clearfix" data-filter="bg bbr" data-link-filter="cr">
        
       
   	 <div class="skeleton">
     		<ul class="clearfix">
    			<li class="active"><a href="#" data-check="all"><?php _e('All','h-framework'); ?></a></li>
   				<?php  wp_list_categories("&title_li=&taxonomy=portfoliocategories");  ?> 
  		  </ul>
     </div>
    	
    </div> <?php endif; ?>

<div class=" page content skeleton  <?php echo $hasSidebar; ?> clearfix portfolio-template "> <!-- Start of loop -->
   
    <div class="<?php echo $layout ?> " id="main-content">
 
     <div class="portfolio-three-column clearfix filterable thunder_listener" data-link-filter="cr" data-headings-filter="bg">
     	<?php get_template_part('includes/loop','portfolio'); ?>
     </div>
    
     <?php $helper->pagination(); ?> 
       
    </div>
     <?php  
	  wp_reset_query();
	  if($layout!="full-width") {  $first_sidebar = false; get_sidebar(); }  
	 ?> 

</div></div>

<?php endwhile; endif; ?> <!-- End of loop -->

<?php get_footer(); ?>
      