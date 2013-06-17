<?php
function md_add_usr_action($first_name, $last_name, $user_name, $email_add, $phone, $course_details, $edu_level, $password, $usr_role) {
	global $PluginName, $wpdb;
	
	$user_id = username_exists( $user_name );
	
	 if ( !$user_id ) {
	  #$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
	  $username_id = wp_insert_user( array ('user_pass' => $password, 'user_login' => $user_name, 'user_email' => $email_add) ) ;
	  /*
	  //Send Welcome Email
	  $from = 'noreply@modulates.com';
	  $subject = 'Welcome to Modulates.com';
	  
	  $welcome_message = '<p>Dear '.$fname.' '.$lname.',</p>
	  <p>We at Modulates consider every one of our clients the most important person in the world. Our professional support team and staff will provide you with answers to your questions for your video testimonials.</p>
	  <p>We are committed to making your experience with Modulates convenient, memorable and enjoyable.</p>
	  <p>Our Frequently Asked Questions (FAQ) directory will provide you answers, information, and contacts that will enhance your experience with Modulates at your fingertips 24/7.</p>
	  <p>Modulates video recording platform, features, hosting, support, social media and other programs are among the finest in the world. Likewise we intend to make our client experiences unmatched anywhere.</p>
	  <p>Below is your login information</p>
	  <p>Username: '.$user_name.'<br>
		Password: '.$random_password.'<br>
		Member area: '.home_url( "/login/" ) .'</p>
		<p>You can make payment online using the following URL <a href="https://www.modulates.com/pay/?pid='.$plan.'&uid='.$username_id.'">https://www.modulates.com/pay/?pid='.$plan.'&uid='.$username_id.'</a>.</p>
	  <p>The entire Modulates team thanks you for joining our program.</p>
	  <p><a href="http://www.modulates.com">Modulates.com</a></p>';
	  
	  #sendmail('Modulates.com', $user_email,$from,$subject,$welcome_message);
	  */
	  // Add custom fields with user data
	  
	  update_user_meta( $username_id, 'first_name', $first_name );
update_user_meta( $username_id, 'last_name', $last_name );
update_user_meta( $username_id, 'phone', $phone );
update_user_meta( $username_id, 'course_details', $course_details );
update_user_meta( $username_id, 'edu_level', $edu_level );
update_user_meta( $username_id, 'credits', 0 );

	  $user_role = new WP_User( $username_id );
	  $user_role->set_role($usr_role);
	  	return $username_id;
	 } else {
		 return 0;
	 }
	
	return $output_result;
}
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

function GetJobStatusByID($id) {
	switch ($id) {
    case 1:
        $jStatus = 'Under Review';
        break;
    case 2:
        $jStatus = 'Accepted and Awaiting Payment';
        break;
    case 3:
        $jStatus = 'Processing';
        break;
    case 4:
        $jStatus = 'Completed';
        break;
    case 5:
        $jStatus = 'Revising';
        break;
	default:
		$jStatus = 'NA';
	}
return $jStatus;
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


