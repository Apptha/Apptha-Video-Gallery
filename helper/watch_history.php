<?php 
add_action( 'loop_start', 'watch_history_user' );
/**
 * Function call check_watch_history_user to insert new user to watch_history_users tables
 * @param $watch_user_id int current user id
 * @return null
 */
function watch_history_user() {
	if ( is_user_logged_in()) {
		$watch_user    =  wp_get_current_user();
		$watch_user_id = $watch_user->ID;
		check_watch_history_user($watch_user_id);
	}
}
/**
 * Function insert new user to watch_history_users tables
 * @param $watch_user_id int current user id
 * @return null
 */
function check_watch_history_user($watch_user_id) {
	global $wpdb;
	$watchStatus =  $wpdb->get_var($wpdb->prepare('SELECT watch FROM '.$wpdb->prefix.'hdflvvideoshare_watch_history_users WHERE userid=%d',$watch_user_id));
	if(empty($watchStatus)) {
		$data   = array('userid'=>$watch_user_id,'watch'=>1);
		$format = array('%d','%d');
		$wpdb->insert($wpdb->prefix.'hdflvvideoshare_watch_history_users',$data,$format);
		$_SESSION['watch']['status'] =  1;
	}
	else {
		$_SESSION['watch']['status'] =  $watchStatus;
	}
}
/**
 * Function to check channel user details
 * @param $userID int current user id
 * @return null
 */
function  checkChannelUserDetails($userID) {
	global $wpdb;
	$userDetails = get_user_by( 'id', $userID );
	$checkUser = $wpdb->get_var($wpdb->prepare('SELECT id FROM '.$wpdb->prefix.'hdflvvideoshare_channel WHERE user_id=%d',$userID));
	if(empty($checkUser)) {
		$userKey = md5($userDetails->user_login.$userID);
		$user_content = json_encode(array('profileImage'=>'','coverImage'=>'','description'=>''));
		$channelName = $userDetails->user_nicename;
		$data   = array('user_id'=>$userID,'user_name'=>$channelName,'user_key'=>$userKey,'user_content'=>$user_content,'channel_name'=>$channelName);
		$format = array('%d','%s','%s','%s','%s');
		$wpdb->insert($wpdb->prefix.'hdflvvideoshare_channel',$data,$format);
	}
}
/**
 * Function call insert_watch_history method when user view new video
 * Function call update_watch_history method when user view already watched video
 * @param int $uid user id
 * @param int $vid video id
 * @return null
 */
function check_watch_history($userID,$videoID) {
	global $wpdb;
	$allow = $status = $watchStatus = '';
	$status =  $wpdb->get_var($wpdb->prepare('SELECT id FROM '.$wpdb->prefix.'hdflvvideoshare_watch_history WHERE userid=%d AND vid=%d',$userID,$videoID));
	if(isset($_SESSION['watch']['status']) && $_SESSION['watch']['status'] == 1 ) {
		$allow = true;
	}
	else {
		$watchStatus =  $wpdb->get_var($wpdb->prepare('SELECT watch FROM '.$wpdb->prefix.'hdflvvideoshare_watch_history_users WHERE userid=%d',$userID));
	}
	if($watchStatus == 1) {
		$allow = true;
	}
	if(empty($status) && $allow == true) {
		insert_watch_history($userID,$videoID);
	}
	else {
		update_watch_history($userID,$videoID,$allow);
	}
}
/**
 * Function to insert current user watch history video details
 * @param int $uid user id
 * @param int $vid video id
 * @return null
 */
function insert_watch_history($userID,$videoID) {
	global $wpdb;
	$dateTime = date('Y-m-d H:i:s');
	$data   = array('userid'=>$userID,'vid'=>$videoID,'date'=>$dateTime);
	$format = array('%d','%d','%s');
	$wpdb->insert($wpdb->prefix.'hdflvvideoshare_watch_history',$data,$format);
}
/**
 * Function to update current user watch history video details
 * @param int $uid user id
 * @param int $vid video id
 * @param int $watchStatus watch history status
 * @return null
 */
function update_watch_history($userID,$videoID,$watchStatus) {
	global $wpdb;
	$date = date('Y-m-d H:i:s');
	$data = array('date'=>$date);
	$where = array('userid'=>$userID,'vid'=>$videoID);
	$format = array('%s');
	$whereFormat = array('%d','%d');
	if($watchStatus == true) {
		$wpdb->update($wpdb->prefix.'hdflvvideoshare_watch_history',$data,$where,$format,$whereFormat);
	}
}