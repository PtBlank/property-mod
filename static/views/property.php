<?php get_header(); ?>           


<?php 
      if($property['property_type']=='complex'){
        echo '<link rel="stylesheet" type="text/css" href="/wp-content/plugins/wp-property/static/styles/complexjc.css">';
        }
      else {
        echo '<link rel="stylesheet" type="text/css" href="/wp-content/plugins/wp-property/static/styles/unitjc.css">';
        }
?>

      
<?php the_post(); ?>
  
    <script type="text/javascript">          

    var map;

    var marker;

    var infowindow;


    jQuery(document).ready(function() {



      if(typeof jQuery.fn.fancybox == 'function') {

        jQuery("a.fancybox_image, .gallery-item a").fancybox({
          'type': "image",
          
          'transitionIn'  :  'elastic',

          'transitionOut'  :  'elastic',

          'speedIn'    :  600,

          'speedOut'    :  200,

          'overlayShow'  :  false

        });



      initialize_this_map();


    });





  function initialize_this_map() {

    <?php if($coords = WPP_F::get_coordinates()) : ?>

    var myLatlng = new google.maps.LatLng(<?php echo $coords['latitude']; ?>,<?php echo $coords['longitude']; ?>);

    var myOptions = {

      zoom: <?php echo (!empty($wp_properties['configuration']['gm_zoom_level']) ? $wp_properties['configuration']['gm_zoom_level'] : 13); ?>,

      center: myLatlng,

      mapTypeId: google.maps.MapTypeId.ROADMAP

    }



    map = new google.maps.Map(document.getElementById("property_map"), myOptions);

    infowindow = new google.maps.InfoWindow({

      content: '<?php echo WPP_F::google_maps_infobox($post); ?>',

      maxWidth: 500

    });

      marker = new google.maps.Marker({

      position: myLatlng,

      map: map,

      title: '<?php echo addslashes($post->post_title); ?>',

      icon: '<?php echo apply_filters('wpp_supermap_marker', '', $post->ID); ?>'
    });



    google.maps.event.addListener(infowindow, 'domready', function() {

    document.getElementById('infowindow').parentNode.style.overflow='hidden';

    document.getElementById('infowindow').parentNode.parentNode.style.overflow='hidden';

    document.getElementById('infowindow').parentNode.parentNode.parentNode.classList.add('scrollable');



   });



   setTimeout("infowindow.open(map,marker);",1);



    <?php endif; ?>

  }
           


  </script>
  

  <div id="container" class="<?php echo (!empty($post->property_type) ? $post->property_type . "_container" : ""); ?>">

    <div id="content" role="main" class="property_content">

      <div id="post-<?php the_ID(); ?>"<?php post_class(); ?>>

      <div class="building_title_wrapper">
      
        <?php if ($post->property_type == 'complex') : ?>
          <h1 class="property-title entry-title"><?php echo $post->post_title ; 
          endif;          
          ?></h1> 
      </div>

      <div class="entry-content">
        
          <div class="wpp_the_content"><?php @the_content(); ?></div>
        
        <?php if ($post->property_type<>'complex') : ?>
          <div class="wpp_the_content"><b>In Building: </b><a href="<?php echo $post->parent_link; ?>"><b><?php echo $post->parent_title; ?></b></a></div>
          <br>
        <?php endif; ?>


        <?php if ( empty($wp_properties['property_groups']) || $wp_properties['configuration']['property_overview']['sort_stats_by_groups'] != 'true' ) : ?>
        <?php endif; ?>
    
<!-- The line below paints the list of attributes -->
         
         <?php
         if($property['property_type']=='complex') : ?> 
         <dt>
         <li class="property_location"><span class="attribute">Address<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['location']; ?></span></li>
         <li class="property_region"><span class="attribute">Region<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['region']; ?></span></li>
         <li class="property_phone-number"><span class="attribute">Phone<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['phone_number']; ?></span></li>
         <li class="property_email"><span class="attribute">Email<span class="wpp_colon">:</span></span><span class="value"><?php echo "<a href='mailto:".$property['email']."'>".$property['email']."</a>"; ?></span></li>
         <li class="property_office"><span class="attribute">M-F Office Hours<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['office_hours']; ?></span></li>
         <li class="property_weekend"><span class="attribute">Weekend Office Hours<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['weekend_hours']; ?></span></li>
         <li class="property_access"><span class="attribute">Access Hours<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['access_hours']; ?></span></li>
         <li class="property_features"><span class="attribute">Building Features<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['features']; ?></span></li>         
		 		 
         <?php
         elseif($property['property_type']=='unit') : ?>
         <li class="property_unit-size"><span class="attribute">Unit Size<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['unit_size']; ?></span></li>
         <li class="property_price"><span class="attribute">Monthly Rent<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['price']; ?></span></li>
         <li class="property_location"><span class="attribute">Address<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['location']; ?></span></li>
         <li class="property_region"><span class="attribute">Region<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['region']; ?></span></li>
         <li class="property_phone-number"><span class="attribute">Phone<span class="wpp_colon">:</span></span><span class="value"><?php echo $property['phone_number']; ?></span></li>
         <li class="property_email"><span class="attribute">Email<span class="wpp_colon">:</span></span><span class="value"><?php echo "<a href='mailto:".$property['email']."'>".$property['email']."</a>"; ?></span></li>           
         
         <?php endif; ?>

         </dl>          
<!-- End attribute painting -->

        <?php
        if($property['complex_name']=='Bend') : ?>
			<a target="_blank" href="https://ustorebend.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>
        <?php
        elseif($property['complex_name']=='Albany') : ?>
			<a target="_blank" href="https://ustorealbany.sim.syrasoft.com"><button class="pay_button">Pay Rent Online</button></a>			
        <?php
		elseif($property['complex_name']=='Central City') : ?>
			<a target="_blank" href="https://ustorecentralcity.sim.syrasoft.com"><button class="pay_button">Pay Rent Online</button></a>			
		<?php
		elseif($property['complex_name']=='Rose Quarter') : ?>
			<a target="_blank" href="https://ustorerosequarter.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>						
		<?php
		elseif($property['complex_name']=='Milwaukie') : ?>
			<a target="_blank" href="https://ustoremilwaukie.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>					
		<?php
		elseif($property['complex_name']=='West') : ?>
			<a target="_blank" href="https://ustorewest.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>			
		<?php
		elseif($property['complex_name']=='Silverdale') : ?>
			<a target="_blank" href="https://ustoreridgetop.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>
		<?php
		elseif($property['complex_name']=='Scappoose') : ?>
			<a target="_blank" href="https://ustorescappoose.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>				
		<?php
		elseif($property['complex_name']=='St Helens') : ?>
			<a target="_blank" href="https://ustoresthelens.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>				
		<?php
		elseif($property['complex_name']=='Woodland') : ?>
			<a target="_blank" href="http://ustorewoodland.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>			
		<?php
		elseif($property['complex_name']=='Kent') : ?>
			<a target="_blank" href="http://ustorekent.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>				
		<?php
		elseif($property['complex_name']=='Dundee') : ?>
			<a target="_blank" href="http://ustoredundee.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>
		<?php
		elseif($property['complex_name']=='Renton') : ?>
		<a target="_blank" href="http://ustorerenton.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>			
		<?php
		elseif($property['complex_name']=='Newport') : ?>
		<a target="_blank" href="http://ustorenewport.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>				
		<?php
		elseif($property['complex_name']=='Springfield') : ?>
		<a target="_blank" href="http://ustorespringfield.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>
		<?php
		elseif($property['complex_name']=='Eugene') : ?>
		<a target="_blank" href="http://ustoreeugene.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>
		<?php
		elseif($property['complex_name']=='Shelton') : ?>
		<a target="_blank" href="http://ustoreshelton.sim.syrasoft.com/"><button class="pay_button">Pay Rent Online</button></a>
		
		<?php endif; ?>

<!-- Begin the map section -->
   <?php
      echo do_shortcode('[tabby title="Map"]');
      ?>   
        <?php if(WPP_F::get_coordinates()): ?>


          <div id="property_map" style="width:100%; height:450px"></div>


        <?php endif; ?>



        <?php if(class_exists('WPP_Inquiry')): ?>

          <h2><?php _e('Interested?','wpp') ?></h2>

          <?php WPP_Inquiry::contact_form(); ?>

        <?php endif; ?>

<!-- End map section -->  

<!-- Begin featured units sections -->
    <?php
    $buildname = $property['complex_name'];
    $buildname = str_replace (" ","_","$buildname");
     
    if($property['property_type'] == 'complex') :
      echo do_shortcode('[tabby title="Featured Units"]');
      echo do_shortcode('[property_overview pagination=off sort_by=price sorter=off template=vacant_units complex_name='.$buildname.' property_type=unit available=Y]'); 
   ?>
    <?php endif; ?>
   <!-- End featured units section -->
  
  <?php
      echo do_shortcode('[tabbyending]'); ?>  

      </div><!-- .entry-content -->


    </div><!-- #post-## -->



    </div><!-- #content -->
    
  </div><!-- #container -->


<?php

  // Primary property-type sidebar.

  if ( is_active_sidebar( "wpp_sidebar_" . $post->property_type ) ) : ?>



    <div id="primary" class="widget-area <?php echo "wpp_sidebar_" . $post->property_type; ?>" role="complementary">

      <ul class="xoxo">

        <?php dynamic_sidebar( "wpp_sidebar_" . $post->property_type ); ?>

      </ul>

    </div><!-- #primary .widget-area -->


<?php endif; ?>


 <?php get_footer(); ?>