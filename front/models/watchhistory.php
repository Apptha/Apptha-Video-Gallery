<?php
/**  
 * Watch History Model file.
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
include_once(APPTHA_VGALLERY_BASEDIR.'/helper/watchhelper.php');
/** Check WatchHistoryModel class is exists */
if ( !class_exists ( 'WatchHistoryModel' ) ) {
    /**
     * Class is used to manage watch history data
     *
     * @author user
     */
class WatchHistoryModel {
	/**
	 * WatchHelper trait is used to include commonly used functions on WatchHistoryModel class
	 */
    /**
     * Function get_watch_history_status is used to return current user status
     * This function has userId to hold current user id
     * This function has watchStatus to hold watch status
     * This function return watch history status(pause/resume)
     * This function has exit statement to stop flow
     * @param int $userId user id
     * @return int watch status
     */
	public function get_watch_history_status($userId) {
		global $wpdb;
		/** watchStatus to hold watch status */
	    $watchStatus =  $wpdb->get_var($wpdb->prepare('SELECT watch FROM '.WVG_WATCH_HISTORY_USERS.' WHERE userid=%d',$userId));
		return $watchStatus;
	}
	/**
	 * Function get_watch_history_details used to get required sets of watch history video details
	 * This function has userId to hold current user id
     * This function has startOffset to hold start offset
     * This function has totalHistoryCount to hold current user total videos count
     * This function has ratearray to hold video rate class to display video rate on front page
     * This function has videoArray to hold current user video ids list as a array
     * This function has videoResults to hold current user video details
     * This function store current offset list in session
     * This function return next set of videos detail as a json encoded format
     * This function has exit statement to stop flow
	 * @param int $userId user id
	 * @param int $startOffset start offset
	 * @return string watch history video details
	 */
	public function getWatchHistoryVideoDetails($userId,$startOffset) {
		global $wpdb;
		$historyResult = array();
		/** totalHistoryCount to hold current user total videos count */
		$totalHistoryCount = get_watch_video_count($userId,$this->watchDetailsTable,$this->hdvideoshareTable);
	    /** videoArray to hold current user video ids list as a array */
		$videoArray = $wpdb->get_col($wpdb->prepare("SELECT vid FROM ".WVG_WATCH_HISTORY_DETAILS." WHERE userid=%d ORDER BY date DESC",$userId));
		if(!empty($videoArray)) {
			/** videoResults to hold current user video details */
			$videoResults = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."hdflvvideoshare WHERE vid IN (".implode(',',$videoArray).") ORDER BY field(vid,".implode(',',$videoArray).") LIMIT 10 OFFSET ".$startOffset);
		}
		$historyResult = getVideoByAjax($videoResults,'',$this->thumbPath  . 'nothumbimage.jpg',$this->ratearray);
		$_SESSION['watchoffset'] = $_SESSION['watchoffset'] + count($videoResults);
		array_push($historyResult,$totalHistoryCount);
		echo json_encode($historyResult);
		exitAction('');
	}
	
	/**
	 * Function update watch history status to 1 to resume watch history video details
	 * Function update watch history status to -2 to pause watch history video details
	 * This function has userId to hold current user id
     * This function has watchStatus to hold watch history status
     * This function store current status in session
     * This function return resume status details as a json encoded format or
     * it return pause status details as a json encoded format
	 * @param int    $userid  user id
	 * @param string $watch_status pause or resume
	 * @return string json_encoded string 
	 */
	public function update_watch_history_status_model($userId,$watchStatus) {
		global $wpdb;
		if(isset($_SESSION['watch']['status']) && $_SESSION['watch']['status'] !='') {
			unset($_SESSION['watch']['status']);
		}
		if($watchStatus == 'pause') {
			$_SESSION['watch']['status'] = -2;
			$status = -2;
	
		}
		if($watchStatus == 'resume') {
			$_SESSION['watch']['status'] = 1;
			$status = 1;
		}
		/** data hold query details */
		$data = array('watch'=>$status);
		/** where hold query condition */
		$where = array('userid'=>$userId);
		/** format hold data format */
		$format = array('%d');
		/** where format hold where data format */
		$whereFormat = array('%d');
		/** deleteResult hold boolean value */
		$checkResult = $wpdb->update(WVG_WATCH_HISTORY_USERS,$data,$where,$format,$whereFormat);
		if($checkResult && $status == -2 ) {
			/** buttonName hold string data */
			$buttonName = __( 'Resume Watch History', APPTHA_VGALLERY );
			/** buttonClassName hold string data */
			$buttonClassName = 'resumeButton';
			/** buttonCallBack hold string data */
			$buttonCallBack  = 'resume';
		}
		if($checkResult && $status == 1 ) {
			/** buttonName hold string data */
			$buttonName = __( 'Pause watch history', APPTHA_VGALLERY );
			/** buttonClassName hold string data */
			$buttonClassName = 'pauseButton';
			/** buttonCallBack hold string data */
			$buttonCallBack  = 'pause';
		}
		if($checkResult) {
			echo json_encode(array('checkResult' => true,'buttonName' => $buttonName,'status' => $watchStatus,'buttonClassName' => $buttonClassName,'buttonCallBack' => $buttonCallBack ));
			exitAction('');
		}
		else {
			echo json_encode(array('checkResult' => false ));
			exitAction('');
		}
	}
	/**
	 * Function to clear current user watch history
	 * This function has userId to hold current user id
	 * This function has table to hold watch history details table name
	 * This function has where variable as a array for query condition
     * This function delete all watch history details of current user
     * This function return delete result boolean value as a json encoded format
	 * @param int $userId user id
	 * @return string if success checkResult is true if not success checkResult is false
	 */
	public function clear_watch_history_model($userId) {
		global $wpdb;
		/** table to hold watch history details table name */
		$table  = WVG_WATCH_HISTORY_DETAILS;
		/** where hold where format */
		$where  = array('userid'=>$userId);
		/** format hold data format */
		$format = array('%d');
		/** deleteResult hold boolean value */
		$deleteResult = $wpdb->delete( $table, $where, $format );
		if($deleteResult) {
			echo json_encode(array('checkResult' => true));
			exitAction('');
		}
		else {
			echo json_encode(array('checkResult' => false));
			exitAction('');
		}
	}
	/**
	 * Function to clear a watch history video
	 * This function has userId to hold current user id
	 * This function has videoId to hold video id to delete
	 * This function has table to hold watch history details table name
	 * This function has where variable as a array for query condition
     * This function delete a watch history video of current user
     * This function return delete result boolean value as a json encoded format
	 * @param int $userId user id
	 * @param int $videoId video id
	 * @return string if success checkResult is true if not success checkResult is false
	 */
	function clear_watch_history_video_model($userId,$videoId) {
		global $wpdb;
		/** table to hold watch history details table name */
		$table  = WVG_WATCH_HISTORY_DETAILS;
		/** where hold query condition */
		$where  = array('userid'=>$userId,'vid'=>$videoId);
		/** format hold data format */
		$format = array('%d','%d');
		/** deleteResult hold boolean value */
		$deleteResult = $wpdb->delete( $table, $where, $format );
		if($deleteResult) {
			echo json_encode(array('checkResult' => true));
			exitAction('');
		}
		else {
			echo json_encode(array('checkResult' => false));
			exitAction('');
		}
	}
}
}