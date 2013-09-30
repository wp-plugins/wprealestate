<h2>WP Real Estate - Property Type</h2>
<style>
.tbl_property_type tr td{
	padding:5px;
}
</style>
<script>

function p_delete(text){
	jQuery(".ajxrsp").html('<div align="center"><img width="30" src="<?php echo ET_RE_URL; ?>images/ajax_loader.gif" /></div>').fadeIn();
	jQuery.ajax({
		type: "POST",
		dataType: 'json',
		url: "<?php echo ET_RE_URL; ?>ajax.php?do=delete_property_type",
		data: 'delete_property_type=' + text,
		success: function(result){
			if(result['error']!=""){
				jQuery(".ajxrsp").html(result['error']).delay(1000).fadeOut();
			} else if(result['pass']!=""){
				jQuery(".ajxrsp").html(result['pass']).delay(1000).fadeOut();
			}
			if(result['ui']!=""){
				jQuery(".et_et_"+result['ui']).remove();
			}
		}
	});
}

jQuery(document).ready(function(){
	jQuery("#p_submit").click(function(){
		if( jQuery("#property_type_text").val()==""){
			jQuery(".ajxrsp").html('Enter Property Type.').fadeIn();
		} else {
			jQuery(".ajxrsp").html('<div align="center"><img width="30" src="<?php echo ET_RE_URL; ?>images/ajax_loader.gif" /></div>').fadeIn();
			jQuery.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo ET_RE_URL; ?>ajax.php?do=update_property_type",
				data: 'property_type_text=' + jQuery("#property_type_text").val(),
				success: function(result){
					if(result['error']!=""){
						jQuery(".ajxrsp").html(result['error']).delay(1000).fadeOut();
					} else if(result['pass']!=""){
						jQuery(".ajxrsp").html(result['pass']).delay(1000).fadeOut();
					}
					if(result['ui']!=""){
						jQuery(".tbl_property_type").prepend(result['ui']);
					}
				}
			});
		}
		return false;
	});
});

</script>
<input id="property_type_text" type="text" name="property_type" /> <a id="p_submit" class="button button-primary" href="">Add Property Type</a>
<div class="ajxrsp"></div>
<table class="tbl_property_type" width="40%" border="0" cellspacing="0" cellpadding="0">
<?php
$get_property_type = get_option('et_re_property_type');
if($get_property_type!=""){
	if (strpos($get_property_type,',') !== false) {
		$arr_property_type_text = explode(',',$get_property_type);
		$arr_property_type_text = array_reverse($arr_property_type_text);
		foreach($arr_property_type_text as $propertytype){
			echo '<tr class="et_et_'.$propertytype.'">';
			echo '<td width="80%">'.$propertytype.'</td>';
			echo '<td width="10%"><a id="p_delete" class="button" href="javascript:p_delete(\''.$propertytype.'\');">Delete</a></td>';
			echo '</tr>';
		}
	} else {
		echo '<tr class="et_et_'.$propertytype.'">';
		echo '<td width="80%">'.$get_property_type.'</td>';
		echo '<td width="10%"><a id="p_delete" class="button" href="javascript:p_delete(\''.$get_property_type.'\');">Delete</a></td>';
		echo '</tr>';
	}
}

?>
</table>