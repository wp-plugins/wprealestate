<?php 
if ($_POST){
require_once "../../../wp-config.php";
	update_option('ET_RE_Currency', $_REQUEST['ET_RE_Currency']);
	update_option('et_re_agent_email', $_REQUEST['et_re_agent_email']);
	update_option('et_re_wg_bg_color', $_REQUEST['et_re_wg_bg_color']);
	echo '<strong>Options saved.</strong>';
}
?>
