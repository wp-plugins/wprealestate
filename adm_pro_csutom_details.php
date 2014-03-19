<?php
// Property admin forms

add_action( 'add_meta_boxes', 'PropertyCustomBox' );
/* Adds a box to the main column on the Post and Page edit screens */
function PropertyCustomBox() {
    add_meta_box( 
        'myplugin_sectionid',
        __( 'Property Details', $PluginName ),
        'property_custom_box',
        'property' , 'normal', 'high'
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
	#$et_er_facilities_exp = stripslashes(get_post_meta($mypostid, 'et_er_facilities', true));
	$et_er_cons_year = stripslashes(get_post_meta($mypostid, 'p_cons_year', true));
	$et_er_unit_num = stripslashes(get_post_meta($mypostid, 'et_er_unit_num', true));
	$et_er_state = stripslashes(get_post_meta($mypostid, 'et_er_state', true));
	$et_er_rent_price = stripslashes(get_post_meta($mypostid, 'et_er_rent_price', true));
	$et_er_rent_tenure = stripslashes(get_post_meta($mypostid, 'et_er_rent_tenure', true));
	wp_nonce_field( plugin_basename( __FILE__ ), $PluginName );
	
	?>
    
<div> 
<h2>Location Details</h2>
<div class="AdmfrmLabel">
  <label for="et_er_property_name"><?php _e( 'Property Name', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
<input name="et_er_property_name" type="text" id="et_er_property_name" value="<?php echo $et_er_property_name; ?>" size="14" />
</div>
<br style="clear:both;" />

<div class="AdmfrmLabel">
  <label for="et_er_area_location"><?php _e( 'Area / Location', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_area_location" type="text" id="et_er_area_location" value="<?php echo $et_er_area_location; ?>" size="14" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_address"><?php _e( 'Unit #', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_unit_num" type="text" id="et_er_address" value="<?php echo $et_er_unit_num; ?>" size="14" />
</div>
<br style="clear:both;" />

<div class="AdmfrmLabel">
  <label for="et_er_address"><?php _e( 'Address', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_address" type="text" id="et_er_address" value="<?php echo $et_er_address; ?>" size="14" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_zipcode"><?php _e( 'Zip Code', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_zipcode" type="text" id="et_er_zipcode" value="<?php echo $et_er_zipcode; ?>" size="14" />
</div><br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_city"><?php _e( 'City', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_city" type="text" id="et_er_city" value="<?php echo $et_er_city; ?>" size="14" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_city"><?php _e( 'State', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_state" type="text" id="et_et_er_stater_city" value="<?php echo $et_er_state; ?>" size="14" />
</div>
<br style="clear:both;" />

</div>    
<div><h2>Property Information</h2>
<div class="AdmfrmLabel">
  <label for="et_er_adtype"><?php #echo 'tt'.basename( dirname( __FILE__ ) ) . '/languages/';
  _e( 'List Type', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <select id="et_er_adtype" name="et_er_adtype" class="AdmFrmList">
    <option <?php if ($et_er_adtype == 'Sale') {?> selected="selected"<?php }?>><?php _e( 'Sale', 'wp-realestate' ); ?></option>
    <option <?php if ($et_er_adtype == 'Rent') {?> selected="selected"<?php }?>><?php _e( 'Rent', 'wp-realestate' ); ?></option>
  </select>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_type"><?php _e( 'Property Type', 'wp-realestate' ); ?></label>
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
  <label for="et_er_built_size"><?php _e( 'Built upto (sq. ft)', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_built_size" type="text" id="et_er_built_size" value="<?php echo $et_er_built_size; ?>" size="14" />
  <span class="admnotes"><?php _e( 'Only numbers', 'wp-realestate' ); ?></span>
  </div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_land_size"><?php _e( 'Land area', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_land_size" type="text" id="et_er_land_size" value="<?php echo $et_er_land_size; ?>" size="14" />
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_price"><?php _e( 'Sale Price', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_price" type="text" id="et_er_price" value="<?php echo $et_er_price; ?>" size="14" />
  <span class="admnotes"><?php _e( 'Only numbers', 'wp-realestate' ); ?></span>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_rent_price"><?php _e( 'Rent Price', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_rent_price" type="text" id="et_er_rent_price" value="<?php echo $et_er_rent_price; ?>" size="14" />
    <select name="et_er_rent_tenure" id="et_er_rent_tenure" class="AdmFrmList">
    <option <?php if ($et_er_rent_tenure ==  __( 'Per Day', 'wp-realestate' )) {?> selected="selected"<?php }?>><?php _e( 'Per Day', 'wp-realestate' ); ?></option>
    <option <?php if ($et_er_rent_tenure == __( 'Per Week', 'wp-realestate' )) {?> selected="selected"<?php }?>><?php _e( 'Per Week', 'wp-realestate' ); ?></option>
    <option <?php if ($et_er_rent_tenure == __( 'Per Month', 'wp-realestate' )) {?> selected="selected"<?php }?>><?php _e( 'Per Month', 'wp-realestate' ); ?></option>
    <option <?php if ($et_er_rent_tenure == __( 'Per Year', 'wp-realestate' )) {?> selected="selected"<?php }?>><?php _e( 'Per Year', 'wp-realestate' ); ?></option>
  </select>

  <span class="admnotes"><?php _e( 'If available on rent also. Enter only numbers', 'wp-realestate' ); ?></span>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_bedroom"><?php _e( 'Bedroom', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <select id="et_er_bedroom" name="et_er_bedroom" class="AdmFrmList">
    <option><?php _e( 'Not Applicable', 'wp-realestate' ); ?></option>
    <?php $bd = 0;
for ($bd = 1; $bd <= 20; $bd++) { ?>
    <option <?php if ($et_er_bedroom == $bd) {?> selected="selected"<?php }?>><?php echo $bd; ?></option>
    <?php } ?>
  </select>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_bathroom"><?php _e( 'Bathroom', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <select id="et_er_bathroom" name="et_er_bathroom" class="AdmFrmList">
    <option><?php _e( 'Not Applicable', 'wp-realestate' ); ?></option>
    <?php $bt = 0;
for ($bt = 1; $bt <= 20; $bt++) { ?>
    <option <?php if ($et_er_bathroom == $bt) {?> selected="selected"<?php }?>><?php echo $bt; ?></option>
    <?php } ?>
  </select>
</div>
<br style="clear:both;" />
<div class="AdmfrmLabel">
  <label for="et_er_furnishing"><?php _e( 'Furnishing', 'wp-realestate' ); ?></label>
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
  <label for="et_er_tenure"><?php _e( 'Tenure', 'wp-realestate' ); ?></label>
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
  <label for="et_er_tenure"><?php _e( 'Cons. Year', 'wp-realestate' ); ?></label>
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
  <label for="et_er_date_vacant"><?php _e( 'Date Available', 'wp-realestate' ); ?></label>
</div>
<div class="AdmfrmFld">
  <input name="et_er_date_vacant" type="text" id="et_er_date_vacant" value="<?php echo $et_er_date_vacant; ?>" size="14" />
</div>
<br style="clear:both;" />

</div>    

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
		if ($_POST['et_er_unit_num']) {
		update_custom_meta($postID, addslashes($_POST['et_er_unit_num']), 'et_er_unit_num');		
		}
		if ($_POST['et_er_state']) {
		update_custom_meta($postID, addslashes($_POST['et_er_state']), 'et_er_state');		
		}
		/*if ($_POST['et_er_facilities']) {
			$et_er_facilities_imp = implode(", ", $_POST['et_er_facilities']); 
		update_custom_meta($postID, addslashes($et_er_facilities_imp), 'et_er_facilities');		
		}*/	
		if ($_POST['et_er_rent_price']) {
		update_custom_meta($postID, addslashes($_POST['et_er_rent_price']), 'et_er_rent_price');		
		}
		if ($_POST['et_er_rent_tenure']) {
		update_custom_meta($postID, addslashes($_POST['et_er_rent_tenure']), 'et_er_rent_tenure');		
		}
		
}	
