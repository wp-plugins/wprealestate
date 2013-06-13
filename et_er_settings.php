<h2>WP Real Estate - Settings</h2>
<?php 
if ($_POST) {
	
	update_option('ET_RE_Currency', $_REQUEST['ET_RE_Currency']);
	update_option('et_re_agent_email', $_REQUEST['et_re_agent_email']);
	update_option('et_re_wg_bg_color', $_REQUEST['et_re_wg_bg_color']);
	echo '<strong>Options saved.</strong><br />
<br />';
}

if (get_option('et_re_wg_bg_color') == '') {
	$et_re_wg_bg_color = '#ccc';
} else {	
	$et_re_wg_bg_color = get_option('et_re_wg_bg_color');
}

if (get_option('et_re_agent_email') == '') {
	$et_re_agent_email = get_option('admin_email');;
} else {	
	$et_re_agent_email = get_option('et_re_agent_email');
}
?>
<form name="form1" method="post" action="">
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>More options coming soon...</td>
      <td><input type="submit" name="button" id="button" value="Save Options"></td>
    </tr>
    <tr>
      <td><a href="http://etechysolutions.com.my/wordpress-real-estate-plugin/" target="_blank">Suggest us more features</a></td>
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
<p>&nbsp;</p>
