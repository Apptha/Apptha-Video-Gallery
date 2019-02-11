<?php
/**  
 * Watch Later Model file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
include_once(APPTHA_VGALLERY_BASEDIR.'/helper/watchhelper.php');
/** Check WatchLaterModel class is exists */
if ( !class_exists ( 'WatchLaterModel' ) ) {
    /**
     * Class is used to manage watch later data
     *
     * @author user
     */
class WatchLaterModel {
	/**
	 * WatchHelper trait is used to include commonly used functions on WatchLaterModel class
	 */
    /**
     * Function get_videos_status is used to return current user status
     * @param int $userId user id
     * @return int watch status
     */
	public function get_videos_status($userId) {
		global $wpdb;
	    $watchStatus =  $wpdb->get_col($wpdb->prepare('SELECT vid FROM '.$this->watchDetailsTable.' WHERE userid=%d AND status=%d',$userId,1));
		return $watchStatus;
	}
	/**
	 * Function getWatchLaterVideoDetails used to get required sets of watch later video details
	 * This function has userId to hold current user id 
     * This function has startOffset to hold start offset
     * This function has totalHistoryCount to hold current user total watch later videos count
     * This function has ratearray to hold video rate class to display video rate on front page
     * This function has videoArray to hold current user watch later video ids list as a array
     * This function has videoResults to hold current user watch latet video details
     * This function store current offset list in session
     * This function return next set of watch later videos detail as a json encoded format
     * This function has exit statement to stop flow
	 * @param int $userId user id
	 * @param int $startOffset start offset
	 * @return string watch history video details
	 */
	public function getWatchLaterVideoDetails($userId,$startOffset) {
		global $wpdb;
		$historyResult = array();
		/** totalHistoryCount to hold current user total watch later videos count */
		$totalHistoryCount = get_watch_video_count($userId,$this->watchDetailsTable,$this->hdvideoshareTable);
		/** statusArray to hold video ids */
		$statusArray = $wpdb->get_col($wpdb->prepare("SELECT vid FROM ".$this->watchDetailsTable." WHERE userid=%d AND status=%d ORDER BY date DESC",$userId,1));
		/** videoArray to hold current user watch later video ids list as a array */
		$videoArray = $wpdb->get_col($wpdb->prepare("SELECT vid FROM ".$this->watchDetailsTable." WHERE userid=%d ORDER BY date DESC",$userId));
		/** videoResults to hold current user watch latet video details */
		if(!empty($videoArray)) {
			$videoResults = $wpdb->get_results("SELECT * FROM ".$this->hdvideoshareTable." WHERE vid IN (".implode(',',$videoArray).") ORDER BY field(vid,".implode(',',$videoArray).") LIMIT 10 OFFSET ".$startOffset);
		}
		$historyResult = getVideoByAjax($videoResults,$statusArray,$this->thumbPath  . 'nothumbimage.jpg',$this->ratearray);
		$_SESSION['watchoffset'] = $_SESSION['watchoffset'] + count($videoResults);
		array_push($historyResult,$totalHistoryCount);
		echo json_encode($historyResult);
		exitAction('');
	}
	
	/**
	 * Function update_watch_later update watch later video status to 1
	 * This function has userId to hold current user id
     * This function has videoId to hold watch later video id
     * This function has dateTime to hold current time
     * This function change the status of watched video
     * This function return result as a json encoded format
     * This function uses update method to update watch video status
     * This function has exit statement to stop flow
	 * @param int $userId  user id
	 * @param int $videoId video id
	 * @return string if success checkResult is true if not success checkResult is false
	 */
	public function update_watch_later($userId,$videoId) {
		global $wpdb;
		/** dateTime to hold current time */
		$dateTime = date('Y-m-d H:i:s');
		/** data hold query details */
		$data = array('date'=>$dateTime,'status'=>1);
		/** where hold query condition */ 
		$where = array('userid'=>$userId,'vid'=>$videoId);
		/** format hold data format */
		$format = array('%s','%d');
		/** whereFormat hold where format */
		$whereFormat = array('%d','%d');
		/** checkResult has boolean value */
		$checkResult = $wpdb->update($this->watchDetailsTable,$data,$where,$format,$whereFormat);
		if($checkResult) {
			echo json_encode(array('checkResult'=>true));
		}
		else {
			echo json_encode(array('checkResult'=>false));
		}
		exitAction('');
	}
	/**
	 * Function to clear current user watch history
	 * This function has userId to hold current user id
	 * This function has table to hold watch later details table name
	 * This function has where variable as a array for query condition
     * This function delete all watch later details of current user
     * This function return delete result boolean value as a json encoded format
     * This function has exit statement to stop flow
	 * @param int $userId user id
	 * @return string if success checkResult is true if not success checkResult is false
	 */
	public function clear_watch_later_model($userId) {
		global $wpdb;
		/** table to hold table name */
		$table  = $this->watchDetailsTable;
		/** where hold query condition */
		$where  = array('userid'=>$userId);
		/** format hold data format */
		$format = array('%d');
		/** deleteResult has boolean value */
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
	 * Function to clear a watch later video
	 * This function has userId to hold current user id
	 * This function has videoId to hold watch later video id to delete
	 * This function has table to hold watch later details table name
	 * This function has where variable as a array for query condition
     * This function delete a watch later video of current user
     * This function return delete result boolean value as a json encoded format
     * This function has exit statement to stop flow
	 * @param int $userId user id
	 * @param int $videoId video id
	 * @return string if success checkResult is true if not success checkResult is false
	 */
	function clear_watch_later_video_model($userId,$videoId) {
	
		global $wpdb;
		/** table to hold table name */
		$table  = $this->watchDetailsTable;
		/** where hold query condition */
		$where  = array('userid'=>$userId,'vid'=>$videoId);
		/** format hold data format */
		$format = array('%d','%d');
		/** deleteResult has boolean value */
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
	 * Function call insert_watch_later method to insert new watch later video
	 * Function call update_watch_later method to update watch later video
	 * This function has userId to hold current user id
	 * This function has videoId to hold video id
	 * This function has status to hold video id
	 * This function check if status has video id if exist then it update video details
	 * or it insert video details as a new records
	 * This function has exit statement to stop flow
	 * @param int $userId user id
	 * @param int $videoId video id
	 * @return string if success checkResult is true if not success checkResult is false
	 */
	function store_watch_later_videos_model($userId,$videoId) {
		global $wpdb;
		$status = '';
		/** status has id value */
		$status =  $wpdb->get_var($wpdb->prepare('SELECT id FROM '.$this->watchDetailsTable.' WHERE userid=%d AND vid=%d',$userId,$videoId));
		if(empty($status)) {
			$this->insert_watch_later($userId,$videoId);
		}
		else {
			$this->update_watch_later($userId,$videoId);
		}
	}
	/**
	 * Function to insert current user watch later video details
	 * Function call update_watch_later method to update watch later video
	 * This function has userId to hold current user id
	 * This function has dateTime to hold current time
	 * This function has data variable to hold video and user detail to insert
	 * This function has videoId to hold video id
	 * This function insert video details as a new records
	 * This function has exit statement to stop flow
	 * @param int $userId user id
	 * @param int $videoId video id
	 * @return string if success checkResult is true if not success checkResult is false
	 */
	function insert_watch_later($userId,$videoId) {
		global $wpdb;
		/** dateTime to hold current time */
		$dateTime = date('Y-m-d H:i:s');
		/** data hold query details */
		$data   = array('userid'=>$userId,'vid'=>$videoId,'date'=>$dateTime,'status'=>1);
		/** format hold data format */
		$format = array('%d','%d','%s','%d');
		/** result has boolean value */
		$result = $wpdb->insert($this->watchDetailsTable,$data,$format);
		if($result) {
			echo json_encode(array('checkResult'=>true));
		}
		else {
			echo json_encode(array('checkResult'=>false));
		}
		exitAction('');
	}
	/**
	 * Function watchLaterStatusModel update watch later video status to -2
	 * Function call update_watch_later method to update watch later video
	 * This function has userId to hold current user id
	 * This function has data variable to hold status details
	 * This function has videoId to hold video id
	 * This function update video status
	 * This function has exit statement to stop flow
	 * @param int $userId user id
	 * @param int $videoId video id
	 * @return string if success checkResult is true if not success checkResult is false
	 */
	public function watchLaterStatusModel($userId,$videoId) {
		global $wpdb;
		/** dateTime to hold current time */
		$data = array('status'=> -2);
		/** where hold query condition */
		$where = array('userid'=>$userId,'vid'=>$videoId);
		/** format hold data format */
		$format = array('%d');
		/** whereFormat hold where format */
		$whereFormat = array('%d','%d');
		/** result has boolean value */
		$checkResult = $wpdb->update($this->watchDetailsTable,$data,$where,$format,$whereFormat);
		if($checkResult) {
			echo json_encode(array('checkResult'=>true));
		}
		else {
			echo json_encode(array('checkResult'=>false));
		}
		exitAction('');
	}
}
}