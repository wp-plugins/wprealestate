<?php get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$catproperty = $_REQUEST['cid'];
$pro_search = $_REQUEST['key'];
?>
<div id="PropertyMainDiv">
<h1>Property Listing <?php if ($catproperty) { echo '- '.$catproperty; } ?></h1>
<div class="SpacerDiv"></div>
<div class="SpacerDiv"></div>
  <?php

$args_property = array(
	'post_type'=> 'property',
	'posts_per_page' => 10,
	'paged' => $paged,
	's' => $pro_search,
	'meta_key'    => 'et_er_type',
	'meta_value'    => $catproperty
);

query_posts( $args_property );
if ( have_posts() ) : 

while ( have_posts() ) : the_post(); 
$pro_ad_type = get_post_meta(get_the_ID(), 'et_er_adtype', true);
?>

<div id="PropertyQuickView">
  <div class="QVImage">
  <?php $property_imgs = get_property_images_ids();?>
  <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> <?php echo wp_get_attachment_image($property_imgs['property_image1'], 'thumbnail'); ?></a>
</div>
<div class="QVProInfo">
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      Property ID: <?php the_ID(); ?><br>
      Built Up: <?php echo get_post_meta(get_the_ID(), 'et_er_built_size', true); ?><br>
      For <?php echo $pro_ad_type; ?> : <?php echo ET_RE_Currency.get_post_meta(get_the_ID(), 'et_er_price', true); ?><br>
      Bedrooms: <?php echo get_post_meta(get_the_ID(), 'et_er_bedroom', true); ?><br>
      Bathrooms: <?php echo get_post_meta(get_the_ID(), 'et_er_bathroom', true); ?><br>
      <div style="float:left; width:100px; bottom:0px;"><a href="<?php the_permalink(); ?>"><img src="<?php echo ET_RE_URL; ?>/images/view_details_button.gif" /></a></div>
  </div>
<br style="clear:both;" />
<div class="SpacerDiv"></div>
</div>
<!-- pagination -->
<?php 
$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages
) );
?>

<?php 
 endwhile;
else :
echo 'no results';
endif;
?>
</div>
<?php get_footer(); ?>