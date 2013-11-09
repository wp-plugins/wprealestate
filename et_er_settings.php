<div class="wrap">
<h2>WP Real Estate - Settings</h2>
<?php 
if (get_option('et_re_wg_bg_color') == '') {
	$et_re_wg_bg_color = '#ccc';
} else {	
	$et_re_wg_bg_color = get_option('et_re_wg_bg_color');
}
if (get_option('et_re_agent_email') == '') {
	$et_re_agent_email = get_option('admin_email');
} else {	
	$et_re_agent_email = get_option('et_re_agent_email');
}
if (get_option('et_re_pg_pro_list') <> '') {
	$et_re_pg_pro_list = get_option('et_re_pg_pro_list');
}
if (get_option('et_re_pp_listing') == '') {
	$et_re_pp_listing = '10';
} else {	
	$et_re_pp_listing = get_option('et_re_pp_listing');
}
if (get_option('et_re_adv_flds') == '') {
	$et_re_adv_flds = array( '0' => 'p_list_type', '1' => 'p_type', '2' => 'p_bedrooms', '3' => 'p_bathrooms' );
} else {	
	$et_re_adv_flds = get_option('et_re_adv_flds');
}

$p_list_sidebar = get_option('p_list_sidebar');
$p_detail_sidebar = get_option('p_detail_sidebar');
?>

<div class="ajxrsp" id="et_re_output_div"></div>
<form id="form1" name="form1" method="POST" action="">
  <table width="600" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="250"><label for="ET_RE_Currency">Currency Symbol</label></td>
      <td width="339">
      <input name="ET_RE_Currency" type="text" id="ET_RE_Currency" value="<?php echo get_option('ET_RE_Currency'); ?>"></td>
    </tr>
    <tr>
      <td>Agent Inquiry Email</td>
      <td><input name="et_re_agent_email" type="text" id="et_re_agent_email" value="<?php echo $et_re_agent_email; ?>" /></td>
    </tr>
    <tr>
      <td>Search widget bg color</td>
      <td><input name="et_re_wg_bg_color" type="text" id="et_re_wg_bg_color" value="<?php echo $et_re_wg_bg_color; ?>" /></td>
    </tr>
    <tr>
      <td>Property Listing Page</td>
      <td>
	  <select name="adv_page" id="adv_page">
	  <?php 
	  $args_pages = array(
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => 'page',
	'post_status'      => 'publish' ); 
	
	  $myposts = get_posts($args_pages);
	  foreach ( $myposts as $post ) :  ?>
	<option value="<?php echo $post->post_name; ?>" <?php if ($post->ID == $et_re_pg_pro_list) {?> selected="selected"<?php } ?>><?php echo $post->post_title; ?></option>
<?php endforeach; ?>
</select></td>
    </tr>
    <tr>
      <td>Number of listing per page</td>
      <td><input name="et_re_pp_listing" type="text" id="et_re_pp_listing" value="<?php echo $et_re_pp_listing; ?>" /></td>
    </tr>
    <tr>
      <td>Sidebar in property listing page?</td>
      <td><label for="p_list_sidebar"></label>
        <select name="p_list_sidebar" id="p_list_sidebar">
          <option value="1" <?php if ($p_list_sidebar == 1) {?> selected="selected"<?php } ?>>Yes</option>
          <option value="0" <?php if ($p_list_sidebar == 0) {?> selected="selected"<?php } ?>>Full Width</option>
        </select></td>
    </tr>
    <tr>
      <td>Sidebar in property detail page?</td>
      <td><label for="p_detail_sidebar"></label>
        <select name="p_detail_sidebar" id="p_detail_sidebar">
          <option value="1" <?php if ($p_detail_sidebar == 1) {?> selected="selected"<?php } ?>>Yes</option>
          <option value="0" <?php if ($p_detail_sidebar == 0) {?> selected="selected"<?php } ?>>No</option>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>More options coming soon...</td>
      <td><input type="submit" name="button" id="et_re_submit" value="Save Options" class="button-primary">
      <img src="<?php echo admin_url( '/images/wpspin_light.gif' );?>" class="waiting" style="display:none;" id="et_re_loading" />
      </td>
    </tr>
    <tr>
      <td><a href="http://www.etechysolutions.com.my/wordpress-real-estate-plugin/" target="_blank">Suggest us more features</a></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<br />
<div class="ajxrsp" id="et_re_output_div_2"></div>
<form id="form2" name="form2" method="post" action="">
  <table width="465" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td><h3>Customize Advanced Search <em>(Mark what you want to show)</em></h3></td>
    </tr>
    <tr>
      <td width="459"><input type="checkbox" name="adv_fld3" id="adv_fld3" disabled="disabled" /> Property Title <em>(Required)</em></td>
    </tr>
    <tr>
      <td>      
      <input name="adv_fld[]" type="checkbox" id="adv_fld[]" value="p_list_type" <?php if (in_array("p_list_type", $et_re_adv_flds)) {?> checked="checked"<?php } ?> />
        <label for="adv_fld"></label>
Listing Type (Sale/Rent)</td>
    </tr>
    <tr>
      <td>
      <input name="adv_fld[]" type="checkbox" id="adv_fld[]" value="p_type" <?php if (in_array("p_type", $et_re_adv_flds)) {?> checked="checked"<?php } ?> />
      Property Type</td>
    </tr>
    <tr>
      <td>
      <input name="adv_fld[]" type="checkbox" id="adv_fld[]" value="p_price" <?php if (in_array("p_price", $et_re_adv_flds)) {?> checked="checked"<?php } ?> /> 
        Price Range</td>
    </tr>
    <tr>
      <td><input name="adv_fld[]" type="checkbox" id="adv_fld[]" value="p_size" <?php if (in_array("p_size", $et_re_adv_flds)) {?> checked="checked"<?php } ?> />
        Size Range</td>
    </tr>
    <tr>
      <td><input name="adv_fld[]" type="checkbox" id="adv_fld[]" value="p_bedrooms" <?php if (in_array("p_bedrooms", $et_re_adv_flds)) {?> checked="checked"<?php } ?> />
        Bedrooms</td>
    </tr>
    <tr>
      <td><input name="adv_fld[]" type="checkbox" id="adv_fld[]" value="p_bathrooms" <?php if (in_array("p_bathrooms", $et_re_adv_flds)) {?> checked="checked"<?php } ?> />
        Bathrooms</td>
    </tr>
    <tr>
      <td><input name="adv_fld[]" type="checkbox" id="adv_fld[]" value="p_furnishing" <?php if (in_array("p_furnishing", $et_re_adv_flds)) {?> checked="checked"<?php } ?> /> 
        Furnishing
</td>
    </tr>
    <tr>
      <td><input name="adv_fld[]" type="checkbox" id="adv_fld[]" value="p_tenure" <?php if (in_array("p_tenure", $et_re_adv_flds)) {?> checked="checked"<?php } ?> />
Tenure </td>
    </tr>
    <tr>
      <td>
      
      </td>
    </tr>
    <tr>
      <td><input name="adv_fld[]" type="checkbox" id="adv_fld[]" value="p_cons_year" <?php if (in_array("p_cons_year", $et_re_adv_flds)) {?> checked="checked"<?php } ?> />
        Construction Year</td>
    </tr>
    <tr>
      <td><input name="adv_fld[]" type="checkbox" id="adv_fld[]" value="p_city" <?php if (in_array("p_city", $et_re_adv_flds)) {?> checked="checked"<?php } ?> />
        City</td>
    </tr>
    <tr>
      <td><input type="submit" name="button2" id="et_re_sv_search" value="Save" class="button-primary" /> <img src="<?php echo admin_url( '/images/wpspin_light.gif' );?>" class="waiting" style="display:none;" id="et_re_loading2" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input name="frm" type="hidden" id="frm" value="2" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</div>