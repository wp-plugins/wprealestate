<?php
/*
Plugin Name: WP Real Estate
Plugin URI: http://etechysolutions.com.my/wordpress-real-estate-plugin/
Description: Specially for real estate agents and people who are willing to list their property listing on their own site.
Author: Etechy Solutions SDN BHD
Version: 1.0
Author URI: http://www.etechysolutions.com.my/
*/

$PluginName = 'WPRealEstate';
define( 'ET_RE_Currency', 'RM' );
$upload_dir = wp_upload_dir();
define( 'ET_RE_PATH', plugin_dir_path(__FILE__) );
define( 'ET_RE_URL', plugins_url('/etechyrealestate') );

function et_er_scroller_script() {
	wp_enqueue_script(
		'et_er_scroller_script',
		ET_RE_URL . '/js/jquery.flexslider-min.js',
		array( 'jquery' )
	);
}

add_action( 'wp_enqueue_scripts', 'et_er_scroller_script' );

function et_er_wp_admin_style() {
        wp_register_style('custom_wp_admin_css', plugins_url( 'css/styles.css' , __FILE__ ), false, '1.0.0');
		wp_register_style('jquery-flexi-slider', plugins_url( 'css/flexslider.css' , __FILE__ ), false, '1.0.0');
		#wp_register_style('jquery-ui-timepicker-addon', get_template_directory_uri().'/admin/jquery-ui-timepicker-addon.css', false, '1.0.0');
        wp_enqueue_style('custom_wp_admin_css');
		wp_enqueue_style('jquery-flexi-slider');
		#wp_enqueue_style('jquery-ui-timepicker-addon');
}
add_action( 'admin_enqueue_scripts', 'et_er_wp_admin_style' );
add_action( 'wp_enqueue_scripts', 'et_er_wp_admin_style' );

function codex_custom_init() {
  $labels = array(
    'name' => 'Properties',
    'singular_name' => 'Property',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Assignment',
    'edit_item' => 'Edit Property',
    'new_item' => 'New Property',
    'all_items' => 'All Properties',
    'view_item' => 'View Property',
    'search_items' => 'Search Properties',
    'not_found' =>  'No properties found',
    'not_found_in_trash' => 'No property found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Properties'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'property' ),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
  ); 

  register_post_type( 'property', $args );
  
/* Code to add Multiple Featured images into propery 
* Added by Poorvi Nagar 
* Dated : 04/19/2013
*/
 // code start from here 
require_once('library/property-images-metabox.php');

// code ends here  
  
  
  
  
}
add_action( 'init', 'codex_custom_init' );


add_action( 'add_meta_boxes', 'AssignmentCustomBox' );

/* Adds a box to the main column on the Post and Page edit screens */
function AssignmentCustomBox() {
    add_meta_box( 
        'myplugin_sectionid',
        __( 'Property Details', $PluginName ),
        'property_custom_box',
        'property' , 'side', 'high'
    );
}

//Custom box for assignments
/* Prints the box content */
function property_custom_box( $post ) {
	
	$mypostid = $post->ID;
	
	$et_er_property_name = stripslashes(get_post_meta($mypostid, 'et_er_property_name', true));
	$et_er_adtype = stripslashes(get_post_meta($mypostid, 'et_er_adtype', true));
	$et_er_type = stripslashes(get_post_meta($mypostid, 'et_er_type', true));
	$et_er_built_size = stripslashes(get_post_meta($mypostid, 'et_er_built_size', true));
	$et_er_land_size = stripslashes(get_post_meta($mypostid, 'et_er_land_size', true));
	$et_er_price = stripslashes(get_post_meta($mypostid, 'et_er_price', true));
	$et_er_bedroom = stripslashes(get_post_meta($mypostid, 'et_er_bedroom', true));
	$et_er_bathroom = stripslashes(get_post_meta($mypostid, 'et_er_bathroom', true));
	$et_er_furnishing = stripslashes(get_post_meta($mypostid, 'et_er_furnishing', true));
	$et_er_tenure = stripslashes(get_post_meta($mypostid, 'et_er_tenure', true));
	$et_er_date_vacant = stripslashes(get_post_meta($mypostid, 'et_er_date_vacant', true));
	$et_er_area_location = stripslashes(get_post_meta($mypostid, 'et_er_area_location', true));
	$et_er_address = stripslashes(get_post_meta($mypostid, 'et_er_address', true));
	$et_er_zipcode = stripslashes(get_post_meta($mypostid, 'et_er_zipcode', true));
	$et_er_city = stripslashes(get_post_meta($mypostid, 'et_er_city', true));
	$et_er_facilities_exp = stripslashes(get_post_meta($mypostid, 'et_er_facilities', true));
	#$et_er_facilities = explode(",", $et_er_facilities_exp);
	#$et_er_facilities = array($et_er_facilities_exp);
	wp_nonce_field( plugin_basename( __FILE__ ), $PluginName );
	
	?>
<div class="AdmfrmLabel">
  <label for="et_er_adtype">List Type</label>
</div>
<div class="AdmfrmFld">
  <select id="et_er_adtype" name="et_er_adtype" class="AdmFrmList">
    <option <?php if ($et_er_adtype == 'Sale') {?> selected="selected"<?php }?>>Sale</option>
    <option <?php if ($et_er_adtype == 'Rent') {?> selected="selected"<?php }?>>Rent</option>
  </select>
</div>
<br style="clear:both;" />

<div class="AdmfrmLabel">
  <label for="et_er_property_name">Property Name</label>
</div>
<div class="AdmfrmFld">
<input name="et_er_property_name" type="text" id="et_er_property_name" value="<?php echo $et_er_property_name; ?>" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_type">Property Type</label>
</div>
<div class="AdmfrmFld">
  <select id="et_er_type" name="et_er_type" class="AdmFrmList">
    <option <?php if ($et_er_type == 'Apartment') {?> selected="selected"<?php }?>>Apartment</option>
    <option <?php if ($et_er_type == 'Condominium') {?> selected="selected"<?php }?>>Condominium</option>
    <option <?php if ($et_er_type == 'Terrace Link') {?> selected="selected"<?php }?>>Terrace Link</option>
    <option <?php if ($et_er_type == 'Semi Detached') {?> selected="selected"<?php }?>>Semi Detached</option>
    <option <?php if ($et_er_type == 'Bungalow') {?> selected="selected"<?php }?>>Bungalow</option>
    <option <?php if ($et_er_type == 'Office') {?> selected="selected"<?php }?>>Office</option>
    <option <?php if ($et_er_type == 'Shop') {?> selected="selected"<?php }?>>Shop</option>
    <option <?php if ($et_er_type == 'Factory') {?> selected="selected"<?php }?>>Factory</option>
    <option <?php if ($et_er_type == 'Land') {?> selected="selected"<?php }?>>Land</option>
  </select>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_built_size">Built upto</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_built_size" type="text" id="et_er_built_size" value="<?php echo $et_er_built_size; ?>" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_land_size">Land area</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_land_size" type="text" id="et_er_land_size" value="<?php echo $et_er_land_size; ?>" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_price">Price</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_price" type="text" id="et_er_price" value="<?php echo $et_er_price; ?>" />
</div>
<br style="clear:both;" />

<div class="AdmfrmLabel">
  <label for="et_er_bedroom">Bedroom</label>
</div>
<div class="AdmfrmFld">
  <select id="et_er_bedroom" name="et_er_bedroom" class="AdmFrmList">
    <option>Not Applicable</option>
    <?php $bd = 0;
for ($bd = 1; $bd <= 20; $bd++) { ?>
    <option <?php if ($et_er_bedroom == $bd) {?> selected="selected"<?php }?>><?php echo $bd; ?></option>
    <?php } ?>
  </select>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_bathroom">Bathroom</label>
</div>
<div class="AdmfrmFld">
  <select id="et_er_bathroom" name="et_er_bathroom" class="AdmFrmList">
    <option>Not Applicable</option>
    <?php $bt = 0;
for ($bt = 1; $bt <= 20; $bt++) { ?>
    <option <?php if ($et_er_bathroom == $bt) {?> selected="selected"<?php }?>><?php echo $bt; ?></option>
    <?php } ?>
  </select>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_furnishing">Furnishing</label>
</div>
<div class="AdmfrmFld">
  <select name="et_er_furnishing" id="et_er_furnishing" class="AdmFrmList">
    <option <?php if ($et_er_furnishing == 'Not Applicable') {?> selected="selected"<?php }?>>Not Applicable</option>
    <option <?php if ($et_er_furnishing == 'Unfurnished') {?> selected="selected"<?php }?>>Unfurnished</option>
    <option <?php if ($et_er_furnishing == 'Semi Furnished') {?> selected="selected"<?php }?>>Semi Furnished</option>
    <option <?php if ($et_er_furnishing == 'Fully Furnished') {?> selected="selected"<?php }?>>Fully Furnished</option>
  </select>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_tenure">Tenure</label>
</div>
<div class="AdmfrmFld">
  <select name="et_er_tenure" id="et_er_tenure" class="AdmFrmList">
    <option <?php if ($et_er_tenure == 'Not Applicable') {?> selected="selected"<?php }?>>Not Applicable</option>
    <option <?php if ($et_er_tenure == 'Freehold') {?> selected="selected"<?php }?>>Freehold</option>
    <option <?php if ($et_er_tenure == 'Leasehold') {?> selected="selected"<?php }?>>Leasehold</option>
  </select>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_date_vacant">Date Available</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_date_vacant" type="text" id="et_er_date_vacant" value="<?php echo $et_er_date_vacant; ?>" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_area_location">Area / Location</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_area_location" type="text" id="et_er_area_location" value="<?php echo $et_er_area_location; ?>" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_address">Address</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_address" type="text" id="et_er_address" value="<?php echo $et_er_address; ?>" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_zipcode">Zip Code</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_zipcode" type="text" id="et_er_zipcode" value="<?php echo $et_er_zipcode; ?>" />
</div><br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_city">City</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_city" type="text" id="et_er_city" value="<?php echo $et_er_city; ?>" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_facilities">Facilities</label>
</div>
<div class="AdmfrmFld">
  <table border="0" cellspacing="2" cellpadding="2">
    <tbody>
      <tr>
        <td>
        <label>
            <input type="checkbox" id="facilities1" value="Swimming pool" name="et_er_facilities[]" <?php if (preg_match('/Swimming pool/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            Swimming pool</label>
            </td>
        <td><label>
            <input type="checkbox" id="facilities2" value="Gymnasium" name="et_er_facilities[]" <?php if (preg_match('/Gymnasium/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            Gymnasium</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" id="facilities4" value="Squash court" name="et_er_facilities[]" <?php if (preg_match('/Squash court/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            Squash court</label></td>
        <td><label>
            <input type="checkbox" id="facilities5" value="Mini market" name="et_er_facilities[]" <?php if (preg_match('/Mini market/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            Mini market</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" id="facilities7" value="Playground" name="et_er_facilities[]" <?php if (preg_match('/Playground/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            Playground</label></td>
        <td><label>
            <input type="checkbox" id="facilities8" value="Jogging track" name="et_er_facilities[]" <?php if (preg_match('/Jogging track/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            Jogging track</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" id="facilities10" value="Balcony or Patio" name="et_er_facilities[]" <?php if (preg_match('/Balcony or Patio/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            Balcony or Patio</label></td>
        <td><label>
            <input type="checkbox" id="facilities11" value="Cable TV" name="et_er_facilities[]" <?php if (preg_match('/Cable TV/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            Cable TV</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" id="facilities3" value="Tennis court" name="et_er_facilities[]" <?php if (preg_match('/Tennis court/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            Tennis court</label></td>
        <td><label>
            <input type="checkbox" id="facilities6" value="Covered parking" name="et_er_facilities[]" <?php if (preg_match('/Covered parking/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            Covered parking</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" id="facilities9" value="24hrs security" name="et_er_facilities[]" <?php if (preg_match('/24hrs security/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            24hrs security</label></td>
        <td><label>
            <input type="checkbox" id="facilities12" value="Internet broadband" name="et_er_facilities[]" <?php if (preg_match('/Internet broadband/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
            Internet broadband</label></td>
      </tr>
      <tr>
        <td><label><input type="checkbox" id="facilities13" value="Barbecue Area" name="et_er_facilities[]" <?php if (preg_match('/Barbecue Area/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
          Barbecue Area</label></td>
        <td><label><input type="checkbox" id="facilities14" value="Access Card System" name="et_er_facilities[]" <?php if (preg_match('/Access Card System/',$et_er_facilities_exp)) {?>checked="checked"<?php }?>>
          Access Card System</label></td>
      </tr>
    </tbody>
  </table>
</div>
<br style="clear:both;" />
<?php
}


add_action( 'save_post', 'SavePropertyInfo' );

function SavePropertyInfo($postID){

	global $wpdb;
	// called after a post or page is saved
	if($parent_id = wp_is_post_revision($postID))
	{
	$postID = $parent_id;
	}	
		if ($_POST['et_er_property_name']) {
		update_custom_meta($postID, addslashes($_POST['et_er_property_name']), 'et_er_property_name');
		}
		if ($_POST['et_er_adtype']) {
		update_custom_meta($postID, addslashes($_POST['et_er_adtype']), 'et_er_adtype');
		}
		if ($_POST['et_er_type']) {
		update_custom_meta($postID, addslashes($_POST['et_er_type']), 'et_er_type');
		}
		if ($_POST['et_er_built_size']) {
		update_custom_meta($postID, addslashes($_POST['et_er_built_size']), 'et_er_built_size');		
		}
		if ($_POST['et_er_land_size']) {
		update_custom_meta($postID, addslashes($_POST['et_er_land_size']), 'et_er_land_size');		
		}
		if ($_POST['et_er_price']) {
		update_custom_meta($postID, addslashes($_POST['et_er_price']), 'et_er_price');		
		}
		if ($_POST['et_er_bedroom']) {
		update_custom_meta($postID, addslashes($_POST['et_er_bedroom']), 'et_er_bedroom');		
		}
		if ($_POST['et_er_bathroom']) {
		update_custom_meta($postID, addslashes($_POST['et_er_bathroom']), 'et_er_bathroom');		
		}
		if ($_POST['et_er_furnishing']) {
		update_custom_meta($postID, addslashes($_POST['et_er_furnishing']), 'et_er_furnishing');		
		}
		if ($_POST['et_er_tenure']) {
		update_custom_meta($postID, addslashes($_POST['et_er_tenure']), 'et_er_tenure');		
		}
		if ($_POST['et_er_date_vacant']) {
		update_custom_meta($postID, addslashes($_POST['et_er_date_vacant']), 'et_er_date_vacant');		
		}
		if ($_POST['et_er_area_location']) {
		update_custom_meta($postID, addslashes($_POST['et_er_area_location']), 'et_er_area_location');		
		}
		if ($_POST['et_er_address']) {
		update_custom_meta($postID, addslashes($_POST['et_er_address']), 'et_er_address');		
		}
		if ($_POST['et_er_zipcode']) {
		update_custom_meta($postID, addslashes($_POST['et_er_zipcode']), 'et_er_zipcode');		
		}
		if ($_POST['et_er_city']) {
		update_custom_meta($postID, addslashes($_POST['et_er_city']), 'et_er_city');		
		}
		if ($_POST['et_er_facilities']) {
			$et_er_facilities_imp = implode(", ", $_POST['et_er_facilities']); 
		update_custom_meta($postID, addslashes($et_er_facilities_imp), 'et_er_facilities');		
		}	
}

function plug_uploadify() {
        wp_register_style('updfy_css', plugins_url( 'uploadify/uploadifive.css' , __FILE__ ), false, '1.0.0');
        wp_register_script('updfy_js', plugins_url( 'uploadify/jquery.uploadifive.min.js' , __FILE__, array( 'jquery' ) ), false, '1.0.0');
        wp_enqueue_style('updfy_css');
        wp_enqueue_script('updfy_js');
}

/* Filter the single_template with our custom function*/
add_filter('single_template', 'PropertyViewTemplate');

function PropertyViewTemplate($single) {
    global $wp_query, $post;

/* Checks for single template by post type */
if ($post->post_type == "property"){
    if(file_exists(ET_RE_PATH. '/tpl_property_view.php'))
        return ET_RE_PATH . '/tpl_property_view.php';
}
    return $single;
}

add_filter('page_template', 'PropertyListingTemplate');

function PropertyListingTemplate($single) {
    global $wp_query, $post;

/* Checks for single template by post type */
if ($post->post_name == "property-listing"){
    if(file_exists(ET_RE_PATH. '/tpl_property_list.php'))
        return ET_RE_PATH . '/tpl_property_list.php';
}
    return $single;
}

function SearchWidget2() { ?>	
<form method="get" action="<?php home_url('/property-listing'); ?>">
Keywords: <input type="text" style="width:200px;" value="<?php echo $_REQUEST['cid']; ?>" /><br />
<input name="SearchProperty" type="submit" value="Search Property" />
</form>
<?php
}

class SearchWidget extends WP_Widget {

	function SearchWidget() {
		// Instantiate the parent object
		parent::__construct( false, 'Property Search' );
	}

	function widget( $args, $instance ) {
		?>	
<form method="get" action="<?php echo home_url('/property-listing'); ?>">
<div style="text-align:center; margin-top:20px; background:#06F">
  <h2>Property Search</h2>
    Keyword:
  <input name="key" type="text" id="key" style="width:150px;" value="<?php echo $_REQUEST['key']; ?>" /><br />
  Property: 
 <select id="cid" name="cid" class="AdmFrmList" style="width:150px;">
    <option <?php if ($_REQUEST['cid'] == '') {?> selected="selected"<?php }?> value="">All</option>
    <option <?php if ($_REQUEST['cid'] == 'Apartment') {?> selected="selected"<?php }?>>Apartment</option>
    <option <?php if ($_REQUEST['cid'] == 'Condominium') {?> selected="selected"<?php }?>>Condominium</option>
    <option <?php if ($_REQUEST['cid'] == 'Terrace Link') {?> selected="selected"<?php }?>>Terrace Link</option>
    <option <?php if ($_REQUEST['cid'] == 'Semi Detached') {?> selected="selected"<?php }?>>Semi Detached</option>
    <option <?php if ($_REQUEST['cid'] == 'Bungalow') {?> selected="selected"<?php }?>>Bungalow</option>
    <option <?php if ($_REQUEST['cid'] == 'Office') {?> selected="selected"<?php }?>>Office</option>
    <option <?php if ($_REQUEST['cid'] == 'Shop') {?> selected="selected"<?php }?>>Shop</option>
    <option <?php if ($_REQUEST['cid'] == 'Factory') {?> selected="selected"<?php }?>>Factory</option>
    <option <?php if ($_REQUEST['cid'] == 'Land') {?> selected="selected"<?php }?>>Land</option>
  </select><br />
    <input id="searchsubmit" type="submit" value="Search Property" />
  
</div>
</form>
<?php
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
	}

	function form( $instance ) {
		// echo 
	}
}

function myplugin_register_widgets() {
	register_widget( 'SearchWidget' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );

include ET_RE_PATH.'functions.php';
?>
