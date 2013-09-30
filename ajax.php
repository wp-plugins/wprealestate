<?php 

if ($_POST){

$do = $_REQUEST['do'];
require_once "../../../wp-config.php";

if($do=='update_settings'){
	update_option('ET_RE_Currency', $_REQUEST['ET_RE_Currency']);

	update_option('et_re_agent_email', $_REQUEST['et_re_agent_email']);

	update_option('et_re_wg_bg_color', $_REQUEST['et_re_wg_bg_color']);
	update_option('et_re_pp_listing', $_REQUEST['et_re_pp_listing']);

	$pg_id_adv = get_page_ID_by_slug($_REQUEST['adv_page']);
	update_option('et_re_pg_pro_list', $pg_id_adv);

	echo '<strong>Options saved.</strong>';
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

}

?>