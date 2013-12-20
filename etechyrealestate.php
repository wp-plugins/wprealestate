<?php
/*
Plugin Name: WP Real Estate
Plugin URI: http://etechysolutions.com.my/wordpress-real-estate-plugin/
Description: Real estate agents and property owners who wish to list and sell properties online.
Author: Etechy Solutions
Version: 2.8
Author URI: http://www.etechy101.com/
*/
$PluginName = 'WPRealEstate';
$upload_dir = wp_upload_dir();
define( 'ET_RE_PATH', plugin_dir_path(__FILE__) );
define( 'ET_RE_URL', plugin_dir_url(__FILE__) );
function Activation_register() {
	add_option('ET_RE_Currency', '$');
	add_option('et_re_wg_bg_color', '#ccc');
	add_option('et_re_pp_listing', '10');
	add_option('et_re_property_type', 'Office,Apartment,Land');
	$et_re_adv_flds = array( '0' => 'p_list_type', '1' => 'p_type', '2' => 'p_bedrooms', '3' => 'p_bathrooms' );
	add_option('et_re_adv_flds', $et_re_adv_flds);
	add_option('p_list_sidebar', 1);
	add_option('p_detail_sidebar', 1);
}
register_activation_hook( __FILE__, 'Activation_register' );
define( 'ET_RE_Currency', get_option('ET_RE_Currency') );
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
function wp_property_custom_init() {
  $labels = array(
    'name' => 'Properties',
    'singular_name' => 'Property',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Property',
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
add_action( 'init', 'wp_property_custom_init' );
add_action( 'add_meta_boxes', 'PropertyCustomBox' );
/* Adds a box to the main column on the Post and Page edit screens */
function PropertyCustomBox() {
    add_meta_box( 
        'myplugin_sectionid',
        __( 'Property Details', $PluginName ),
        'property_custom_box',
        'property' , 'side', 'high'
    );
}
//Custom box for Properties
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
	$et_er_cons_year = stripslashes(get_post_meta($mypostid, 'p_cons_year', true));
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
<input name="et_er_property_name" type="text" id="et_er_property_name" value="<?php echo $et_er_property_name; ?>" size="14" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_type">Property Type</label>
</div>
<div class="AdmfrmFld">
  <select id="et_er_type" name="et_er_type" class="AdmFrmList">
    <?php
	$get_property_type = get_option('et_re_property_type');
	if($get_property_type!=""){
		if (strpos($get_property_type,',') !== false) {
			$arr_property_type_text = explode(',',$get_property_type);
			$arr_property_type_text = array_reverse($arr_property_type_text);
			foreach($arr_property_type_text as $propertytype){
	?>
			<option <?php if ($et_er_type == $propertytype) {?> selected="selected"<?php }?>><?php echo $propertytype; ?></option>
    <?php
			}
		} else {
	?>
			<option <?php if ($et_er_type == $get_property_type) {?> selected="selected"<?php }?>><?php echo $get_property_type; ?></option>
    <?php
		}
	}
	?>
  </select>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_built_size">Built upto</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_built_size" type="text" id="et_er_built_size" value="<?php echo $et_er_built_size; ?>" size="14" />
  <br />
Only numbers</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_land_size">Land area</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_land_size" type="text" id="et_er_land_size" value="<?php echo $et_er_land_size; ?>" size="14" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_price">Price</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_price" type="text" id="et_er_price" value="<?php echo $et_er_price; ?>" size="14" />
  <br />
  Only numbers
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
  <label for="et_er_tenure">Cons. Year</label>
</div>
<div class="AdmfrmFld">
  <select name="p_cons_year" class="cstm_s_big" id="p_cons_year">
    <option <?php if ($et_er_cons_year == 'Not Applicable') {?> selected="selected"<?php }?>>Not Applicable</option>
                    <?php 
					$yr = date('Y');
					for ($x=1960; $x<=$yr; $x++){ ?>
						<option value="<?php echo $x; ?>" <?php if ($et_er_cons_year == $x) { ?> selected="selected" <?php } ?>><?php echo $x; ?></option>
					<?php } ?>
                </select>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_date_vacant">Date Available</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_date_vacant" type="text" id="et_er_date_vacant" value="<?php echo $et_er_date_vacant; ?>" size="14" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_area_location">Area / Location</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_area_location" type="text" id="et_er_area_location" value="<?php echo $et_er_area_location; ?>" size="14" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_address">Address</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_address" type="text" id="et_er_address" value="<?php echo $et_er_address; ?>" size="14" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_zipcode">Zip Code</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_zipcode" type="text" id="et_er_zipcode" value="<?php echo $et_er_zipcode; ?>" size="14" />
</div><br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_city">City</label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_city" type="text" id="et_er_city" value="<?php echo $et_er_city; ?>" size="14" />
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
		} else {
		update_custom_meta($postID, '0', 'et_er_built_size');
		}
		if ($_POST['et_er_land_size']) {
		update_custom_meta($postID, addslashes($_POST['et_er_land_size']), 'et_er_land_size');		
		} else {
		update_custom_meta($postID, '0', 'et_er_land_size');
		}
		if ($_POST['et_er_price']) {
		update_custom_meta($postID, addslashes($_POST['et_er_price']), 'et_er_price');		
		} else {
		update_custom_meta($postID, '0', 'et_er_price');
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
		} else {
		update_custom_meta($postID, '0', 'et_er_date_vacant');
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
		if ($_POST['p_cons_year']) {
		update_custom_meta($postID, addslashes($_POST['p_cons_year']), 'p_cons_year');		
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
	$et_re_pg_pro_list = get_option('et_re_pg_pro_list');
    global $wp_query, $post;
/* Checks for single template by post type */
if ($post->ID == $et_re_pg_pro_list ){
    if(file_exists(ET_RE_PATH. '/tpl_property_list.php'))
        return ET_RE_PATH . '/tpl_property_list.php';
}
    return $single;
}
function SearchWidget2() {  ?>	
<?php $et_re_pg_pro_list = get_option('et_re_pg_pro_list');?>
<form method="get" action="<?php echo get_permalink($et_re_pg_pro_list); ?>">
Keywords: <input type="text" style="width:200px;" value="<?php echo $_REQUEST['cid']; ?>" /><br />
<input name="SearchProperty" type="submit" value="Search Property" />
<input name="page_id" type="hidden" value="<?php echo $et_re_pg_pro_list; ?>" />
</form>
<?php
}
class SearchWidget extends WP_Widget {
	function SearchWidget() {
		// Instantiate the parent object
		parent::__construct( false, 'Property Search' );
	}
	function widget( $args, $instance ) {
		
$et_re_pg_pro_list = get_option('et_re_pg_pro_list');?>
<form method="get" action="<?php echo get_permalink($et_re_pg_pro_list); ?>">
<div style="text-align:center; margin-top:20px; margin-bottom:10px; padding:5px; background:<?php echo get_option('et_re_wg_bg_color'); ?>">
  <h2>Property Search</h2>
    Keyword:
  <input name="key" type="text" id="key" style="width:150px;" value="<?php echo $_REQUEST['key']; ?>" /><br />
 
 
    <input id="searchsubmit" type="submit" value="Search Property" />
  <input name="page_id" type="hidden" value="<?php echo $search_page_id; ?>" />
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
function et_er_AdminMenu() {
	global $PluginDirName, $PluginName, $et_re_settings_page;
	$et_re_heom_page = add_menu_page($PluginName." Configuration", $PluginName, 'edit_themes', $PluginName."Home", 'et_er_HomeView');
	$et_re_pro_type = add_submenu_page( $PluginName."Home", "Property Type", "Property Type", 'edit_themes', $PluginName."PropertyType", 'et_er_property_type' );
	$et_re_settings_page = add_submenu_page( $PluginName."Home", "Settings", "Settings", 'edit_themes', $PluginName."Settings", 'et_er_settings' );
	
}
add_action('admin_menu', 'et_er_AdminMenu');

function et_er_HomeView() {
	global $PluginName, $wpdb;
	#echo '<br /><h1>Welcome to WP Real Estate</h1>';
	include 'et_re_home.php';
}
function et_er_settings() {
	global $PluginName, $wpdb;
	include 'et_er_settings.php';
}
function et_er_property_type() {
	global $PluginName, $wpdb;
	include 'et_er_property_type.php';
}
function et_er_protypes() {
	global $PluginName, $wpdb;
	include 'et_er_settings.php';
}
// Register Custom Taxonomy
function custom_taxonomy_facilities()  {
	$labels = array(
		'name'                       => _x( 'Facilities', 'Taxonomy General Name', 'et_er' ),
		'singular_name'              => _x( 'Facility', 'Taxonomy Singular Name', 'et_er' ),
		'menu_name'                  => __( 'Facility', 'et_er' ),
		'all_items'                  => __( 'All Facilities', 'et_er' ),
		'parent_item'                => __( 'Parent Facility', 'et_er' ),
		'parent_item_colon'          => __( 'Parent Facility:', 'et_er' ),
		'new_item_name'              => __( 'New Facility Name', 'et_er' ),
		'add_new_item'               => __( 'Add New Facility', 'et_er' ),
		'edit_item'                  => __( 'Edit Facility', 'et_er' ),
		'update_item'                => __( 'Update Facility', 'et_er' ),
		'separate_items_with_commas' => __( 'Separate facilities with commas', 'et_er' ),
		'search_items'               => __( 'Search facilities', 'et_er' ),
		'add_or_remove_items'        => __( 'Add or remove facilities', 'et_er' ),
		'choose_from_most_used'      => __( 'Choose from the most used facilities', 'et_er' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'facility', 'property', $args );
}
// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_facilities', 0 );
// Register Custom Taxonomy
function tax_property_type()  {
	$labels = array(
		'name'                       => _x( 'Property Types', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Property Type', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Property Type', 'text_domain' ),
		'all_items'                  => __( 'All Property Types', 'text_domain' ),
		'parent_item'                => __( 'Parent Property Type', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Property Type:', 'text_domain' ),
		'new_item_name'              => __( 'New Property Type', 'text_domain' ),
		'add_new_item'               => __( 'Add New Property Type', 'text_domain' ),
		'edit_item'                  => __( 'Edit Property Type', 'text_domain' ),
		'update_item'                => __( 'Update Property Type', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate property types with commas', 'text_domain' ),
		'search_items'               => __( 'Search property types', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove property types', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used property types', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                       => 'propertytypes',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'propertytype', 'property', $args );
}
// Hook into the 'init' action
#add_action( 'init', 'tax_property_type', 0 );

function et_re_load_scripts( $hook ) {
	global $PluginDirName, $PluginName, $et_re_settings_page;
	
	/*if ( $hook != $et_re_settings_page )
	return;*/
	
	wp_enqueue_script('etre_ajax', plugin_dir_url(__FILE__).'js/et_re_ajax.js', array('jquery') );	
	wp_localize_script('etre_ajax', 'etre_vars', array(
		'etre_nonce' => wp_create_nonce('etre_nonce')
		));
	
}
add_action('admin_enqueue_scripts', 'et_re_load_scripts');

function et_re_ajax_process() { 

if ( !isset( $_POST['etre_nonce'] ) || !wp_verify_nonce(($_POST['etre_nonce']), 'etre_nonce' ))
die('Permission denied...');
	
	$do = $_POST['do'];
	
	if($do == 'update_et_options'){	
		update_option('ET_RE_Currency', $_REQUEST['ET_RE_Currency']);
	
		update_option('et_re_agent_email', $_REQUEST['et_re_agent_email']);
	
		update_option('et_re_wg_bg_color', $_REQUEST['et_re_wg_bg_color']);
		update_option('et_re_pp_listing', $_REQUEST['et_re_pp_listing']);
		update_option('p_list_sidebar', $_REQUEST['p_list_sidebar']);
		update_option('p_detail_sidebar', $_REQUEST['p_detail_sidebar']);
	
		$pg_id_adv = get_page_ID_by_slug($_REQUEST['adv_page']);
		update_option('et_re_pg_pro_list', $pg_id_adv); 
	
		echo '<p><strong>Options saved.</strong></p>';
	}
	
	if($do=='update_property_type'){
		
		$result = array(
			'error' => '',
			'ui' => '',
			'pass' => ''
		);
		
		$property_type_text = $_POST['property_type_text'];
		
		$get_property_type = get_option('et_re_property_type');
		
		if($get_property_type!=""){
			$arr_property_type_text = explode(',',$get_property_type);
			if (in_array($property_type_text, $arr_property_type_text)) {
				$result['error'] = '<strong>Already exists</strong>';
			} else {
				update_option('et_re_property_type', $get_property_type.','.$property_type_text);
			}
		} else {
			if($property_type_text == $get_property_type){
				$result['error'] = '<strong>Already exists</strong>';	
			} else {
				update_option('et_re_property_type', $property_type_text);
			}
		}
		
		if($result['error']==""){
		
		$result['ui'] = '';
		$result['ui'] .= '<tr class="et_et_'.$property_type_text.'">';
		$result['ui'] .= '<td width="80%">'.$property_type_text.'</td>';
		$result['ui'] .= '<td width="10%"><a id="p_delete" class="button" href="javascript:p_delete(\''.$property_type_text.'\');">Delete</a></td>';
		$result['ui'] .= '</tr>';
		
		$result['pass'] = '<strong>Property type saved.</strong>';
		
		}
		
		echo json_encode($result);
	}
	
	if($do=='delete_property_type'){
		
		$result = array(
			'error' => '',
			'ui' => '',
			'pass' => ''
		);
		
		$delete_property_type = $_POST['delete_property_type'];
		$get_property_type = get_option('et_re_property_type');
		
		if (strpos($get_property_type,',') !== false) {
			
			$update_property_type = explode(',',$get_property_type);
			unset($update_property_type[$delete_property_type]);
			foreach($update_property_type as $key => $one){
				if($one == $delete_property_type){
					unset($update_property_type[$key]);
				}
			}
			
			$update_property_type = implode(',',$update_property_type);
			
			update_option('et_re_property_type', $update_property_type);
			
		} else {
			update_option('et_re_property_type', '');
		}
		
		if($result['error']==""){
		
		$result['ui'] = $delete_property_type;
		$result['pass'] = '<strong>Property type deleted.</strong>';
		
		}
		
		echo json_encode($result);
	}
	
	if($do=='customize_advanced_search'){
		$adv_fld = $_REQUEST['adv_fld'];
		update_option('et_re_adv_flds', $adv_fld);
		echo '<p><strong>Options saved.</strong></p>';
	}
	
	die();
}
add_action('wp_ajax_update_et_options', 'et_re_ajax_process');