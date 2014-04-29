<?php
/*
Plugin Name: WP Real Estate
Plugin URI: http://etechysolutions.com.my/wordpress-real-estate-plugin/
Description: Real estate agents and property owners who wish to list and sell properties online. Translation friendly.
Author: HozyAli
Version: 4.1
Author URI: https://plus.google.com/u/0/+HuzaifaAli/posts
Text Domain: wp-realestate
Domain Path: /languages
*/
$PluginName = 'WPRealEstate';
$upload_dir = wp_upload_dir();
define( 'ET_RE_PATH', plugin_dir_path(__FILE__) );
define( 'ET_RE_URL', plugin_dir_url(__FILE__) );
define( 'ET_RE_Currency', get_option('ET_RE_Currency') );

function Activation_register() {
	add_option('ET_RE_Currency', '$');
	add_option('et_re_wg_bg_color', '#ccc');
	add_option('et_re_pp_listing', '10');
	add_option('et_re_property_type', 'Office,Apartment,Land');
	$et_re_adv_flds = array( '0' => 'p_list_type', '1' => 'p_type', '2' => 'p_bedrooms', '3' => 'p_bathrooms' );
	add_option('et_re_adv_flds', $et_re_adv_flds);
	add_option('p_list_sidebar', 1);
	add_option('p_detail_sidebar', 1);
	add_option('p_num_slider_pics', 10);
	add_option('p_share_buttons', 1);
}
register_activation_hook( __FILE__, 'Activation_register' );

function et_er_scroller_script() {
	wp_enqueue_script(
		'et_er_scroller_script',
		ET_RE_URL . '/js/jquery.flexslider-min.js',
		array( 'jquery' )
	);
}
add_action( 'wp_enqueue_scripts', 'et_er_scroller_script' );

function et_er_wp_style() {
        wp_register_style('custom_wp_admin_css', plugins_url( 'css/styles.css' , __FILE__ ), false, '1.0.0');
        #wp_register_style('custom_wp_bt_css', plugins_url( 'bootstrap/css/bootstrap.css' , __FILE__ ), false, '1.0.0');
        #wp_register_style('custom_wp_bt_rs_css', plugins_url( 'bootstrap/css/bootstrap-responsive.css' , __FILE__ ), false, '1.0.0');
		wp_register_style('jquery-flexi-slider', plugins_url( 'css/flexslider.css' , __FILE__ ), false, '1.0.0');

        wp_enqueue_style('custom_wp_admin_css');
        #wp_enqueue_style('custom_wp_bt_css');
        #wp_enqueue_style('custom_wp_bt_rs_css');
		wp_enqueue_style('jquery-flexi-slider');
}
add_action( 'wp_enqueue_scripts', 'et_er_wp_style' );

function et_er_wp_admin_style() {
        wp_register_style('custom_wp_admin_css', plugins_url( 'css/styles.css' , __FILE__ ), false, '1.0.0');
        wp_enqueue_style('custom_wp_admin_css');
}
add_action( 'admin_enqueue_scripts', 'et_er_wp_admin_style' );

//Load language files
function wp_realestate_load_plugin_textdomain() {
	load_plugin_textdomain( 'wp-realestate', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'wp_realestate_load_plugin_textdomain' );

function wp_property_custom_init() {
  $labels = array(
    'name' => __( 'Properties', 'wp-realestate' ),
    'singular_name' => 'Property',__( 'Properties', 'wp-realestate' ),
    'add_new' => __( 'Add New', 'wp-realestate' ),
    'add_new_item' => __( 'Add New Property', 'wp-realestate' ),
    'edit_item' => __( 'Edit Property', 'wp-realestate' ),
    'new_item' => __( 'New Property', 'wp-realestate' ),
    'all_items' => __( 'All Properties', 'wp-realestate' ),
    'view_item' => __( 'View Property', 'wp-realestate' ),
    'search_items' => __( 'Search Properties', 'wp-realestate' ),
    'not_found' =>  __( 'No properties found', 'wp-realestate' ),
    'not_found_in_trash' => __( 'No property found in Trash', 'wp-realestate' ), 
    'menu_name' => __( 'Properties', 'wp-realestate' )
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
  
require_once('library/property-images-metabox.php');  
}
add_action( 'init', 'wp_property_custom_init' );

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
<input name="SearchProperty" type="submit" value="<?php _e( 'Search Property', 'wp-realestate' ); ?>" />
<input name="page_id" type="hidden" value="<?php echo $et_re_pg_pro_list; ?>" />
</form>
<?php
}
class SearchWidget extends WP_Widget {
	function SearchWidget() {
		// Instantiate the parent object
		parent::__construct( false, __( 'Property Search', 'wp-realestate' ) );
	}
	function widget( $args, $instance ) {
		
$et_re_pg_pro_list = get_option('et_re_pg_pro_list');?>
<form method="get" action="<?php echo get_permalink($et_re_pg_pro_list); ?>">
<div style="text-align:center; margin-top:20px; margin-bottom:10px; padding:5px; background:<?php echo get_option('et_re_wg_bg_color'); ?>">
  <h2><?php _e( 'Property Search', 'wp-realestate' ); ?></h2>
    <?php _e( 'Keyword', 'wp-realestate' ); ?>:
  <input name="key" type="text" id="key" style="width:150px;" value="<?php echo $_REQUEST['key']; ?>" /><br />
 
 
    <input id="searchsubmit" type="submit" value="<?php _e( 'Search Property', 'wp-realestate' ); ?>" />
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
#add_action( 'widgets_init', 'myplugin_register_widgets' );
include ET_RE_PATH.'functions.php';
function et_er_AdminMenu() {
	global $PluginDirName, $PluginName, $et_re_settings_page;
	$et_re_heom_page = add_menu_page($PluginName." Configuration", $PluginName, 'edit_themes', $PluginName."Home", 'et_er_HomeView');
	$et_re_pro_type = add_submenu_page( $PluginName."Home", __( 'Property Type', 'wp-realestate' ), __( 'Property Type', 'wp-realestate' ), 'edit_themes', $PluginName."PropertyType", 'et_er_property_type' );
	$et_re_settings_page = add_submenu_page( $PluginName."Home", __( 'Settings', 'wp-realestate' ), __( 'Settings', 'wp-realestate' ), 'edit_themes', $PluginName."Settings", 'et_er_settings' );
	
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
		'name'                       => _x( 'Facilities', 'Taxonomy General Name', 'wp-realestate' ),
		'singular_name'              => _x( 'Facility', 'Taxonomy Singular Name', 'wp-realestate' ),
		'menu_name'                  => __( 'Facility', 'wp-realestate' ),
		'all_items'                  => __( 'All Facilities', 'wp-realestate' ),
		'parent_item'                => __( 'Parent Facility', 'wp-realestate' ),
		'parent_item_colon'          => __( 'Parent Facility:', 'wp-realestate' ),
		'new_item_name'              => __( 'New Facility Name', 'wp-realestate' ),
		'add_new_item'               => __( 'Add New Facility', 'wp-realestate' ),
		'edit_item'                  => __( 'Edit Facility', 'wp-realestate' ),
		'update_item'                => __( 'Update Facility', 'wp-realestate' ),
		'separate_items_with_commas' => __( 'Separate facilities with commas', 'wp-realestate' ),
		'search_items'               => __( 'Search facilities', 'wp-realestate' ),
		'add_or_remove_items'        => __( 'Add or remove facilities', 'wp-realestate' ), 
		'choose_from_most_used'      => __( 'Choose from the most used facilities', 'wp-realestate' ),
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
		'name'                       => _x( 'Property Types', 'Taxonomy General Name', 'wp-realestate' ),
		'singular_name'              => _x( 'Property Type', 'Taxonomy Singular Name', 'wp-realestate' ),
		'menu_name'                  => __( 'Property Type', 'wp-realestate' ),
		'all_items'                  => __( 'All Property Types', 'wp-realestate' ),
		'parent_item'                => __( 'Parent Property Type', 'wp-realestate' ),
		'parent_item_colon'          => __( 'Parent Property Type:', 'wp-realestate' ),
		'new_item_name'              => __( 'New Property Type', 'wp-realestate' ),
		'add_new_item'               => __( 'Add New Property Type', 'wp-realestate' ),
		'edit_item'                  => __( 'Edit Property Type', 'wp-realestate' ),
		'update_item'                => __( 'Update Property Type', 'wp-realestate' ),
		'separate_items_with_commas' => __( 'Separate property types with commas', 'wp-realestate' ),
		'search_items'               => __( 'Search property types', 'wp-realestate' ),
		'add_or_remove_items'        => __( 'Add or remove property types', 'wp-realestate' ),
		'choose_from_most_used'      => __( 'Choose from the most used property types', 'wp-realestate' ),
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
		update_option('p_pro_id_display', $_REQUEST['p_pro_id_display']);
		update_option('p_num_slider_pics', $_REQUEST['p_num_slider_pics']);
		update_option('p_share_buttons', $_REQUEST['p_share_buttons']);
	
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
				$result['error'] = '<strong>'.__( 'Already exists.', 'wp-realestate' ).'</strong>';
			} else {
				update_option('et_re_property_type', $get_property_type.','.$property_type_text);
			}
		} else {
			if($property_type_text == $get_property_type){
				$result['error'] = '<strong>'.__( 'Already exists.', 'wp-realestate' ).'</strong>';;	
			} else {
				update_option('et_re_property_type', $property_type_text);
			}
		}
		
		if($result['error']==""){
		
		$result['ui'] = '';
		$result['ui'] .= '<tr class="et_et_'.$property_type_text.'">';
		$result['ui'] .= '<td width="80%">'.$property_type_text.'</td>';
		$result['ui'] .= '<td width="10%"><a id="p_delete" class="button" href="javascript:p_delete(\''.$property_type_text.'\');">'.__( 'Delete', 'wp-realestate' ).'</a></td>';
		$result['ui'] .= '</tr>';
		
		$result['pass'] = '<strong>'.__( 'Property Type Saved.', 'wp-realestate' ).'</strong>';
		
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
		$result['pass'] = '<strong>'.__( 'Property Type Removed.', 'wp-realestate' ).'</strong>';
		
		}
		
		echo json_encode($result);
	}
	
	if($do=='customize_advanced_search'){
		$adv_fld = $_REQUEST['adv_fld'];
		update_option('et_re_adv_flds', $adv_fld);
		echo '<p><strong>'.__( 'Options Saved.', 'wp-realestate' ).'</strong></p>';
	}
	
	die();
}
add_action('wp_ajax_update_et_options', 'et_re_ajax_process');

add_filter('page_template', 'new_view_template');
function new_view_template($single) {
	$et_re_pg_pro_list = get_option('et_re_pg_pro_list');
    global $wp_query, $post;
/* Checks for single template by post type */
if ($post->ID == 45 ){
    if(file_exists(ET_RE_PATH. '/tpl_property_view2.php'))
        return ET_RE_PATH . '/tpl_property_view2.php';
}
    return $single;
}
