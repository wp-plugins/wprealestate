<?php
get_header();
global $post;
the_post();
if ($_POST) {
	$inq_msg = 'An inquiry received from your site '.bloginfo('name').'<br /><br />';
	$inq_msg .= 'Property URL: '.get_permalink($post->ID).'<br />';
	$inq_msg .= 'Name: '.$_REQUEST['inq_name'].'<br />';
	$inq_msg .= 'Phone: '.$_REQUEST['inq_email'].'<br />';
	$inq_msg .= 'Email: '.$_REQUEST['inq_phone'].'<br />';
	$inq_msg .= 'Message: '.$_REQUEST['inq_message'].'<br />';
	$inq_msg .= 'User IP: '.$_SERVER['REMOTE_ADDR'].'<br />';
	#wp_mail(bloginfo('admin_email'), 'message from '.bloginfo('name'), $inq_msg);
	sendmail($_REQUEST['inq_name'], bloginfo('admin_email'), $_REQUEST['inq_email'], 'Message from '.bloginfo('name'),$inq_msg);
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
<div id="PropertyMainDiv">

<div class="SpacerDiv"></div>
<h1><?php the_title(); ?></h1>
<div class="SpacerDiv"></div>
<h3 class="address"><?php echo get_post_meta($post->ID, 'et_er_address', true).', '.get_post_meta($post->ID, 'et_er_area_location', true).', '.get_post_meta($post->ID, 'et_er_city', true).' '.get_post_meta($post->ID, 'et_er_zipcode', true); ?></h3>
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
<div id="carousel" class="flexslider">
  <ul class="slides">
    <?php foreach ($property_imgs as $img_id) { ?>
    <li>
      <?php echo wp_get_attachment_image($img_id); ?>
    </li>
    <?php } ?>
    
    <!-- items mirrored twice, total of 12 -->
  </ul>
</div>
</div>

<span class='st_fblike_hcount' displayText='Facebook Like'></span>
<span class='st_twitter_hcount' displayText='Tweet'></span>
<span class='st_googleplus_hcount' displayText='Google +'></span>
<span class='st_sharethis_hcount' displayText='ShareThis'></span>
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
<div class="SpecLabel">
Property Type:<br>
Price / Monthly Rent:<br>
Built up:<br />
Land area:<br>
Bedroom:<br>
Bathroom:<br>
Furnishing:<br>
Tenure:<br>
Date Available:<br>
Facilities:<br>
</div>
<div class="SpecInfo">
<?php
echo get_post_meta($post->ID, 'et_er_type', true).'<br>'; 
echo ET_RE_Currency.get_post_meta($post->ID, 'et_er_price', true).'<br>'; 
echo get_post_meta($post->ID, 'et_er_built_size', true).'<br>'; 
echo get_post_meta($post->ID, 'et_er_land_size', true).'<br>'; 
echo get_post_meta($post->ID, 'et_er_bedroom', true).'<br>'; 
echo get_post_meta($post->ID, 'et_er_bathroom', true).'<br>'; 
echo get_post_meta($post->ID, 'et_er_furnishing', true).'<br>'; 
echo get_post_meta($post->ID, 'et_er_tenure', true).'<br>'; 
echo get_post_meta($post->ID, 'et_er_date_vacant', true).'<br>'; 
echo get_post_meta($post->ID, 'et_er_facilities', true).'<br>'; 
?>
</div>
</div>
<div class="SpacerDiv"></div>
<div class="SpacerDiv"></div>
<div id="ProDescription">
<div class="heading">Description</div>
<?php the_content(); ?></div>
<div class="SpacerDiv"></div>
<div class="SpacerDiv"></div>
<div id="divAgent"></div>
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
<?php
get_footer();
?>