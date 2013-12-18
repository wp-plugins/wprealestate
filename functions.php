<?php
function str_makerand($minlength, $maxlength, $useupper, $usespecial, $usenumbers)
{
$charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
if ($useupper) $charset .= "abcdefghijklmnopqrstuvwxyz";
if ($usenumbers) $charset .= "0123456789";
if ($usespecial) $charset .= "~@#$%^*()_+-={}|]["; // Note: using all special characters this reads: "~!@#$%^&*()_+`-={}|\\]?[\":;'><,./";
if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength);
else $length = mt_rand ($minlength, $maxlength);
for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
return $key;
}
function update_custom_meta($postID, $newvalue, $field_name) {
	global $PluginDirName, $PluginName, $wpdb, $FullPluginDirURL;
// To create new meta
if(!get_post_meta($postID, $field_name)){
add_post_meta($postID, $field_name, $newvalue);
}else{
// or to update existing meta
update_post_meta($postID, $field_name, $newvalue);
}
}
function sendmail($from_name, $to,$from,$subject,$msg){
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= "From: " . $from . "<".$from.">" . "\r\n";
mail($to,$subject,$msg,$headers);
}
add_action('init', 'et_er_do_output_buffer');
function et_er_do_output_buffer() {
        ob_start();
}
function et_feed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'property');
	return $qv;
}
add_filter('request', 'et_feed_request');
function property_advanced_search_form( $atts ){
$wpcf_fields = get_option('wpcf-fields');
$et_re_adv_flds = get_option('et_re_adv_flds');
?>
<style>
.advnc_option {
	display:none;
}
.advnc {
	outline:none !important;
}
</style>
<div class="cstmsearch">
        <div class="cstmsearch_frm_c">
            
            <div class="cstmsearch_frm">
            <?php $et_re_pg_pro_list = get_option('et_re_pg_pro_list');?>
<form id="advncsrc" class="pfs frmshow" method="post" action="<?php echo get_permalink($et_re_pg_pro_list); ?>">
                <label>Keywords</label>
            	<input name="sbpn" onfocus="if (this.value == 'Search Property') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search Property';}" class="cstm_f_large" id="sbpn" value="Search Property" />
                <div class="clr"></div>
                <?php 
				if($et_re_adv_flds != ""){
				if (in_array("p_list_type", $et_re_adv_flds)) {?>
				<label>Listing Type</label>
                <select name="p_list_type" class="cstm_s" id="p_list_type">
                  <option value="-1">All</option>
                  <option value="Sale">For Sale</option>
                  <option value="Rent">For Rent</option>
  </select>              
                <div class="rspbreak"></div>
        <?php } ?>
                <?php if (in_array("p_type", $et_re_adv_flds)) {?>
				<label>Property Type</label>
                <select name="p_type" class="cstm_s" id="p_type">
                	<option value="">Any</option>
                    <?php
					$get_property_type = get_option('et_re_property_type');
					if($get_property_type!=""){
						if (strpos($get_property_type,',') !== false) {
							$arr_property_type_text = explode(',',$get_property_type);
							$arr_property_type_text = array_reverse($arr_property_type_text);
							foreach($arr_property_type_text as $propertytype){
					?>
							<option value="<?php echo $propertytype; ?>"><?php echo $propertytype; ?></option>
					<?php
							}
						} else {
					?>
							<option value="<?php echo $get_property_type; ?>"><?php echo $get_property_type; ?></option>
					<?php
						}
					}
					?>
        		</select>              
                <div class="rspbreak"></div>
        <?php } ?>
        <?php if (in_array("p_size", $et_re_adv_flds)) {?>
<label class="labelbig">Floor Area (Built-in)</label>
                <select name="p_minsize" class="cstm_s_big" id="p_minsize" style="width:60px;">
                    <option selected="selected" value="">Min</option>
                    <option value="200">200 sqft (18 sqm)</option>
                    <option value="500">500 sqft (46 sqm)</option>
                    <option value="750">750 sqft (70 sqm)</option>
                    <option value="1000">1,000 sqft (93 sqm)</option>
                    <option value="1200">1,200 sqft (112 sqm)</option>
                    <option value="1500">1,500 sqft (139 sqm)</option>
                    <option value="2000">2,000 sqft (186 sqm)</option>
                    <option value="2500">2,500 sqft (232 sqm)</option>
                    <option value="3000">3,000 sqft (279 sqm)</option>
                    <option value="4000">4,000 sqft (372 sqm)</option>
                    <option value="5000">5,000 sqft (465 sqm)</option>
                    <option value="7500">7,500 sqft (697 sqm)</option>
                    <option value="10000">10,000 sqft (929 sqm)</option>
                </select>
                <select name="p_maxsize" class="cstm_s_big" id="p_maxsize" style="width:60px;">
                    <option selected="selected" value="">Max</option>
                    <option value="200">200 sqft (18 sqm)</option>
                    <option value="500">500 sqft (46 sqm)</option>
                    <option value="750">750 sqft (70 sqm)</option>
                    <option value="1000">1,000 sqft (93 sqm)</option>
                    <option value="1200">1,200 sqft (112 sqm)</option>
                    <option value="1500">1,500 sqft (139 sqm)</option>
                    <option value="2000">2,000 sqft (186 sqm)</option>
                    <option value="2500">2,500 sqft (232 sqm)</option>
                    <option value="3000">3,000 sqft (279 sqm)</option>
                    <option value="4000">4,000 sqft (372 sqm)</option>
                    <option value="5000">5,000 sqft (465 sqm)</option>
                    <option value="7500">7,500 sqft (697 sqm)</option>
                    <option value="10000">10,000 sqft (929 sqm)</option>
                </select>
                <div class="rspbreak"></div>
                <?php } ?>
                <?php if (in_array("p_location", $et_re_adv_flds)) {?>
<label>Location</label>
                <select name="p_location" class="cstm_s" id="p_location">
                    <option selected="selected" value="">Any</option>
                    <?php
					foreach($wpcf_fields['location']['data']['options'] as $propertytype => $key){
						echo '<option value="'.$key['value'].'">'.$key['title'].'</option>';
					}
					?>
                </select>
                <div class="rspbreak"></div>
                <?php } ?>
                <?php if (in_array("p_price", $et_re_adv_flds)) {?>
<label class="labelbig">Price </label>
				<input style="width:50px;" type="text" name="p_minprice" id="p_minprice" maxlength="7" />
                <input style="width:50px;" type="text" name="p_maxprice" id="p_maxprice" maxlength="7" />
                <div class="rspbreak"></div>
                <?php } ?>
                <?php if (in_array("p_bedrooms", $et_re_adv_flds)) {?>
<label>Bedrooms</label>
                <select name="p_bedrooms" class="cstm_s" id="p_bedrooms">
                    <option selected="selected" value="">Any</option>
                    <?php $bd = 0;
for ($bd = 1; $bd <= 20; $bd++) { ?>
    <option <?php if ($et_er_bedroom == $bd) {?> selected="selected"<?php }?>><?php echo $bd; ?></option>
    <?php } ?>
                </select>
                <div class="rspbreak"></div>
                <?php } ?>
                <?php if (in_array("p_bathrooms", $et_re_adv_flds)) {?>
                <label>Bathrooms</label>
                <select name="p_bathrooms" class="cstm_s" id="p_bathrooms">
                    <option selected="selected" value="">Any</option>
                    <?php $bt = 0;
for ($bt = 1; $bt <= 20; $bt++) { ?>
    <option <?php if ($et_er_bathroom == $bt) {?> selected="selected"<?php }?>><?php echo $bt; ?></option>
    <?php } ?>
                </select>
                <div class="rspbreak"></div>
                <?php } ?>
                <?php if (in_array("p_furnishing", $et_re_adv_flds)) {?>
				<label>Furnishing</label>
                <select name="p_furnishing" class="cstm_s" id="p_furnishing">
                	<option selected="selected" value=""></option>
                    <option>Not Applicable</option>
                    <option>Unfurnished</option>
                    <option>Semi Furnished</option>
                    <option>Fully Furnished</option>
            	</select>
                <div class="rspbreak"></div>
                <?php } ?>
                <?php if (in_array("p_cons_year", $et_re_adv_flds)) {?>
<label class="labelbig">Year Constructed</label>
                <select name="p_constructed_min" class="cstm_s_big" id="p_constructed_min" style="width:60px;">
                    <option selected="selected" value="">Min</option>
                    <?php 
					$yr = date('Y');
					for ($x=1960; $x<=$yr; $x++){
						echo '<option value="'.$x.'">'.$x.'</option>';
					}
					?>
                </select>
                <select name="p_constructed_max" class="cstm_s_big" id="p_constructed_max" style="width:60px;">
                    <option selected="selected" value="">Max</option>
                    <?php 
					$yr = date('Y');
					for ($x=1960; $x<=$yr; $x++){
						echo '<option value="'.$x.'">'.$x.'</option>';
					}
					?>
                </select>
                <div class="rspbreak"></div>
                <?php } ?>                
                <?php if (in_array("p_tenure", $et_re_adv_flds)) {?>
<label>Tenure</label>
                <select name="p_tenure" class="cstm_s" id="p_tenure">
                    <option selected="selected" value="">Any</option>
                    <option>Freehold</option>
                    <option>Leasehold</option>
                    <?php
					foreach($wpcf_fields['development-tenure']['data']['options'] as $propertytype => $key){
						echo '<option value="'.$key['value'].'">'.$key['title'].'</option>';
					}
					?>
            </select>
                <div class="rspbreak"></div>
                <?php } ?>
                <?php if (in_array("p_city", $et_re_adv_flds)) {?>
                <label>City</label>
                <input name="p_city" class="cstm_f_large" id="p_city" value="" />
                <div class="rspbreak"></div>
                <?php }
				}?>
                <input id="cstm_submit" type="submit" value="SEARCH" />
            <input name="adv_frm" type="hidden" id="adv_frm" value="1" />
<div style="clear:both;"></div>
            </form>
            </div>
        </div>    
    </div>
<?php
}
add_shortcode( 'WP_RE_ADVANCED_SEARCH', 'property_advanced_search_form' );
function get_page_ID_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}
/*function result_adv_search() {
}*/
add_filter('widget_text', 'do_shortcode');
/*add_action('wp_ajax_my_action', 'ajx_call_back');
function ajx_call_back() {
	global $wpdb; // this is how you get access to the database
	update_option('ET_RE_Currency', $_POST['ET_RE_Currency']);
	update_option('et_re_agent_email', $_POST['et_re_agent_email']);
	update_option('et_re_wg_bg_color', $_POST['et_re_wg_bg_color']);
	update_option('et_re_pp_listing', $_POST['et_re_pp_listing']);
	$pg_id_adv = get_page_ID_by_slug($_POST['adv_page']);
	update_option('et_re_pg_pro_list', $pg_id_adv);
	echo '<strong>Options saved.</strong>';
	die(); // this is required to return a proper result
}*/