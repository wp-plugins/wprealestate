<?php
get_header();
$p_detail_sidebar = get_option('p_detail_sidebar');
global $post;
the_post();
if ($_POST) {
	
	if (get_option('et_re_agent_email') == '') {
	$et_re_agent_email = get_option('admin_email');;
} else {	
	$et_re_agent_email = get_option('et_re_agent_email');
}
	$inq_msg = 'An inquiry received from your site '.bloginfo('name').'<br /><br />';
	$inq_msg .= 'Property URL: '.get_permalink($post->ID).'<br />';
	$inq_msg .= 'Name: '.$_REQUEST['inq_name'].'<br />';
	$inq_msg .= 'Email: '.$_REQUEST['inq_email'].'<br />';
	$inq_msg .= 'Phone: '.$_REQUEST['inq_phone'].'<br />';
	$inq_msg .= 'Message: '.$_REQUEST['inq_message'].'<br />';
	$inq_msg .= 'User IP: '.$_SERVER['REMOTE_ADDR'].'<br />';
	#wp_mail(bloginfo('admin_email'), 'message from '.bloginfo('name'), $inq_msg);
	sendmail($_REQUEST['inq_name'], $et_re_agent_email, $_REQUEST['inq_email'], 'Message from '.bloginfo('name'),$inq_msg);
	wp_redirect( get_permalink($post->ID).'?msg=1');
	exit;
}
?>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "72af30ed-8290-4178-b5d1-3fdb0b5c43a3", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<script type="text/javascript">
jQuery(window).load(function() {
  // The slider being synced must be initialized first
  jQuery('#carousel').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 155,
    itemMargin: 5,
    asNavFor: '#slider'
  });
   
  jQuery('#slider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel"
  });
});
</script>
<div id="PropertyMainDiv" <?php if ($p_detail_sidebar == 1) { ?> style="width:612px;" <?php } ?>>
<div class="SpacerDiv"></div>
<h1><?php the_title(); ?></h1>
<div class="SpacerDiv"></div>
<h3 class="address">
<?php 
if (get_post_meta($post->ID, 'et_er_address', true)) {
	echo get_post_meta($post->ID, 'et_er_address', true).', '; 
}
if (get_post_meta($post->ID, 'et_er_area_location', true)) {
	echo get_post_meta($post->ID, 'et_er_area_location', true).', ';
}

	echo get_post_meta($post->ID, 'et_er_city', true).' '.get_post_meta($post->ID, 'et_er_zipcode', true); ?></h3>
<div class="SpacerDiv"></div>
<div class="ProPhotos">
<?php $property_imgs = get_property_images_ids(); ?>
<!-- Place somewhere in the <body> of your page -->
<div id="slider" class="flexslider">
  <ul class="slides">
    <?php foreach ($property_imgs as $img_id) { ?>
    <li>
      <?php echo wp_get_attachment_image($img_id, 'full'); ?>
    </li>
    <?php } ?>
    
    <!-- items mirrored twice, total of 12 -->
  </ul>
</div>
<?php $property_arr_size = count($property_imgs);
	if ($property_arr_size > 1) { ?>
	    <div id="carousel" class="flexslider">
  <ul class="slides">
    <?php
	foreach ($property_imgs as $img_id) { ?>
    <li>
      <?php echo wp_get_attachment_image($img_id); ?>
    </li>
    <?php } ?>
    
    <!-- items mirrored twice, total of 12 -->
  </ul>
</div>
<?php } ?>
</div>
<?php if (get_option('p_share_buttons') == 1) {?>
<span class='st_fblike_hcount' displayText='Facebook Like'></span>
<span class='st_twitter_hcount' displayText='Tweet'></span>
<span class='st_googleplus_hcount' displayText='Google +'></span>
<span class='st_sharethis_hcount' displayText='ShareThis'></span>
<?php } ?>
<div class="SpacerDiv"></div>
<div id="ProDescription">
<div class="heading">Details</div>
<div class="SpecLabel">
Property Name:<br>
Property Address:
</div>
<div class="SpecInfo">
<?php 
echo get_post_meta($post->ID, 'et_er_property_name', true).'<br>'; 
echo get_post_meta($post->ID, 'et_er_address', true).', '.get_post_meta($post->ID, 'et_er_area_location', true).', '.get_post_meta($post->ID, 'et_er_city', true).' '.get_post_meta($post->ID, 'et_er_zipcode', true); ?>
</div>
<div class="SpacerDiv"></div>

<div><div class="SpecLabel">Property Type: </div>

<div class="SpecInfo"><?php echo get_post_meta($post->ID, 'et_er_type', true).'<br />'; ?></div>
<?php if (get_post_meta($post->ID, 'et_er_price', true) <> '0') { ?>
<div class="SpecLabel">Price / Monthly Rent: </div>
<div class="SpecInfo"><?php echo get_post_meta($post->ID, 'et_er_price', true).'<br />'; ?></div>
<?php }
if (get_post_meta($post->ID, 'et_er_built_size', true) <> '0') { ?>
<div class="SpecLabel">Built up: </div>
<div class="SpecInfo"><?php echo get_post_meta($post->ID, 'et_er_built_size', true).'<br />'; ?></div>
<?php }
if (get_post_meta($post->ID, 'et_er_land_size', true) <> '0') { ?>
<div class="SpecLabel">Land area: </div>
<div class="SpecInfo"><?php echo get_post_meta($post->ID, 'et_er_land_size', true).'<br />'; ?></div>
<?php }
if (get_post_meta($post->ID, 'et_er_bedroom', true) <> 'Not Applicable') { ?>
<div class="SpecLabel">Bedroom: </div>
<div class="SpecInfo"><?php echo get_post_meta($post->ID, 'et_er_bedroom', true).'<br />'; ?></div>
<?php } 
if (get_post_meta($post->ID, 'et_er_bathroom', true) <> 'Not Applicable') { ?>
<div class="SpecLabel">Bathroom: </div>
<div class="SpecInfo"><?php echo get_post_meta($post->ID, 'et_er_bathroom', true).'<br />'; ?></div>
<?php }
if (get_post_meta($post->ID, 'et_er_furnishing', true) <> 'Not Applicable') { ?>
<div class="SpecLabel">Furnishing: </div>
<div class="SpecInfo"><?php echo get_post_meta($post->ID, 'et_er_furnishing', true).'<br />'; ?></div>
<?php } 
if (get_post_meta($post->ID, 'et_er_tenure', true) <> 'Not Applicable') { ?>
<div class="SpecLabel">Tenure: </div>
<div class="SpecInfo"><?php echo get_post_meta($post->ID, 'et_er_tenure', true).'<br />'; ?></div>
<?php } 
if (get_post_meta($post->ID, 'et_er_date_vacant', true) <> '0') { ?>
<div class="SpecLabel">Date Available: </div>
<div class="SpecInfo"><?php echo get_post_meta($post->ID, 'et_er_date_vacant', true).'<br />'; ?></div>
<?php } 
$terms = get_the_terms( $post->ID, 'facility' );
if ( $terms && ! is_wp_error( $terms ) ) {
	?>
<div class="SpecLabel">Facilities: </div>
<div class="SpecInfo"><?php the_terms( $post->ID, 'facility', '', ', ', ' ' ).'<br />'; ?></div>
<?php } ?>
</div>
<div class="SpacerDiv"></div>

</div>
<div class="SpacerDiv"></div>
<div class="SpacerDiv"></div>
<div id="ProDescription">
<div class="heading">Description</div>
<?php the_content(); ?></div>
<div class="SpacerDiv"></div>
<div class="SpacerDiv"></div>
<div id="divAgent"></div>
<!--<div id="ProDescription">
<div class="heading">Map</div>
<iframe src="https://www.google.com/maps/embed?location=London" width="600" height="450" frameborder="0" style="border:0"></iframe>
</div>-->
<div id="ProDescription">
<?php if ($_REQUEST['msg'] == 1) { ?>
<div style="color:#060; font-weight:bold; margin:5px;">Inquiry has been sent to the Agent</div>
<?php } ?>
<form name="inq_form" id="inq_form" method="post">
<div class="heading">Send an inquiry to the agent</div>
<div class="SpacerDiv"></div>
<div class="SpecLabel">Your Name*</div>
<div class="SpecInfo"><input name="inq_name" type="text"></div>
<div class="SpacerDiv"></div>
<div class="SpecLabel">Your Email</div>
<div class="SpecInfo"><input name="inq_email" type="text"></div>
<div class="SpacerDiv"></div>
<div class="SpecLabel">Your Phone*</div>
<div class="SpecInfo"><input name="inq_phone" type="text"></div>
<div class="SpacerDiv"></div>
<div class="SpecLabel">Message</div>
<div class="SpecInfo"><textarea name="inq_message"></textarea></div>
<div class="SpacerDiv"></div>
<div class="SpacerDiv"></div>
<div class="SpecLabel">&nbsp;</div>
<div class="SpecInfo"><input name="submit" type="submit" value="Send Inquiry"></div>
<div class="SpacerDiv"></div>
</form>
</div>
</div>
<?php 
if ($p_detail_sidebar == 1) {
get_sidebar();
} ?>
<?php get_footer(); ?>