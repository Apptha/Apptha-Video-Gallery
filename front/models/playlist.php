<?php
/**  
 * Playlist Model file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
include_once(APPTHA_VGALLERY_BASEDIR.'/helper/watchhelper.php');
/** Check PlaylistModel class is exists */
if ( !class_exists ( 'PlaylistModel' ) ) {
    /**
     * Class is used to manage playlist data
     * @author user
     */
class PlaylistModel {
	/**
	 * WatchHelper trait is used to include commonly used functions on playlist
	 */
/**
 * Function getPlaylistVideosByAjax is used to get current user playlist videos and bind it existing videos
 * This function has userId to hold current user id
 * This function has startOffset arguments to hold start offset
 * This function has playlistId arguments to hold playlist id
 * This function call getPlaylistVideoDetails method to get required set of playlist video details
 * This function pass userid,playlistid,startoffset and current object as parameter to getPlaylistVideoDetails method
 * This function call getVideoByAjax to get required json details to bind next set of videos to existing videos
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $startOffset start offset
 * @param int $playlistId playlist id
 * @return array
 */
public function getPlaylistVideosByAjax($userId,$startOffset,$playlistId) {
		global $wpdb;
		$result = array();
		$videoResults = getPlaylistVideoDetails($userId,$playlistId,$startOffset,$this);
		if(empty($videoResults)) {
			echo json_encode(array());
			exitAction('');
		}
		$result = getVideoByAjax($videoResults,'',$this->thumbPath  . 'nothumbimage.jpg',$this->ratearray);
		array_push($result,$this->playlistVideoCount);
		echo json_encode($result);
		exitAction('');
}
/**
 * Function getPlaylistbyOffset is used to get current user playlist details and bind it to existing playlist details
 * This function has userId to hold current user id
 * This function has startOffset arguments to hold start offset
 * This function call getPlaylistDetails method to get required set of playlist details
 * This function pass userid,startoffset and current object as parameter to getPlaylistDetails method
 * This function call getTotalPlaylistCount to get total playlist count
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $startOffset start offset
 * @return array
 */
public function getPlaylistbyOffset($userId,$startOffset) {
	global $wpdb;
	$playlistDetails = getPlaylistDetails($userId,$startOffset,$this);
	$playlistCount = getTotalPlaylistCount($userId,$this);
	array_push($playlistDetails,$playlistCount);
	echo json_encode($playlistDetails);
	exitAction('');
}
/**
 * Function getCurrentUserPlaylistName is used to get current user playlist id and name
 * This function has userId to hold current user id
 * This function has videoId arguments to hold video id
 * This function has currentVideoPlaylistId to hold current video playlist id
 * This function has playlistArray to hold current video playlist details
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $videoId video id
 * @return array
 */
public function getCurrentUserPlaylistName($userId,$videoId) {
	global $wpdb;
	$currentVideoPlaylistId = $wpdb->get_col($wpdb->prepare('SELECT pid FROM '.$this->userPlaylistDetailTable.' WHERE userid=%d AND vid=%d',$userId,$videoId));
	$playlistArray = $wpdb->get_results($wpdb->prepare('SELECT id,playlist_name FROM '.$this->userPlaylistTable.' WHERE userid=%d GROUP BY playlist_name ORDER BY id asc',$userId));
	if(count($playlistArray) > 0 ) {
		echo json_encode(array('checkResult'=>true,'currentPlaylist'=>$currentVideoPlaylistId,'playlist'=>$playlistArray));
	}
	else {
		echo json_encode(array('checkResult'=>false));
	}
	exitAction('');
}
/**
 * Function createPlaylist is used to create new playlist
 * This function has userId to hold current user id
 * This function has videoId to hold video id
 * This function has playlistName to hold playlist name
 * This function has playlistLimit to hold playlist name
 * This function has playlistCount to hold total playlist count of current user
 * This function has checkPlaylist to hold playlist name to check whether playlist name exists or not
 * This function insert new playlist on playlist table
 * This function insert new video on newly created playlist
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $videoId video id
 * @param string $playlistName playlist name
 * @return array
 */
public function createPlaylist($userId,$videoId,$playlistName) {
	global $wpdb;
	$serializedPlaylistLimit =  unserialize($wpdb->get_var($wpdb->prepare('SELECT player_colors FROM '.$this->settingsTable,'')));
	if(!empty($serializedPlaylistLimit['playlist_count'])) {
		$playlistLimit = $serializedPlaylistLimit['playlist_count'];
	} else {
		$playlistLimit = 5;
	}
    $playlistCount =  getTotalPlaylistCount($userId,$this);
    if($playlistCount >= $playlistLimit ) {
    	echo json_encode(array('checkResult'=>false,'status'=>'limit'));
    	exitAction('');
    }
	$checkPlaylist = $wpdb->get_var($wpdb->prepare('SELECT playlist_name FROM '.$this->userPlaylistTable.' WHERE userid=%d AND playlist_name=%s',$userId,$playlistName));
	if(empty($checkPlaylist)) {
		$data   = array('userid'=>$userId,'playlist_name'=>$playlistName);
		$format = array('%d','%s');
		$result = $wpdb->insert($this->userPlaylistTable,$data,$format);
	}
	else {
		echo json_encode(array('checkResult'=>false,'status'=>'exist'));
		exitAction('');
	}
	$playlistId = $wpdb->insert_id;
	if($result) {
		$this->insertPlaylistVideo($userId,$videoId,$playlistId);
	}
	else {
		echo json_encode(array('checkResult'=>false));
		exitAction('');
	}
}
/**
 * Function insertPlaylist is used to insert playlist to database
 * This function has userId to hold current user id
 * This function has videoId to hold video id
 * This function has playlistName to hold playlist name
 * This function has checkPlaylist to hold playlist name to check whether playlist name exists or not
 * This function insert new video on required playlist
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $videoId video id
 * @param string $playlistName playlist name
 * @return array
 */
public function insertPlaylist($userId,$videoId,$playlistName) {
	global $wpdb;
	$checkPlaylist = $wpdb->get_var($wpdb->prepare('SELECT playlist_name FROM '.$this->userPlaylistTable.' WHERE userid=%d AND playlist_name=%s',$userId,$playlistName));
	$checkPlaylistVideo = $wpdb->get_var($wpdb->prepare('SELECT playlist_name FROM '.$this->userPlaylistDetailTable.' WHERE userid=%d AND vid=%d AND playlist_name=%s',$userId,$videoId,$playlistName));
    if(!empty($checkPlaylist) && empty($checkPlaylistVideo)) {
    	$this->insertPlaylistVideo($userId,$videoId,$playlistName);
    }
    else {
    	echo json_encode(array('checkResult'=>false));
    	exitAction('');
    }
}
/**
 * Function insertPlaylistVideo is used to insert playlist video to database
 * This function has userId to hold current user id
 * This function has videoId to hold video id
 * This function has playlistId to hold playlist id
 * This function insert new video on required playlist details
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $videoId video id
 * @param int $playlistId playlist id
 * @return array
 */
public function insertPlaylistVideo($userId,$videoId,$playlistId) {
	global $wpdb;
	$data   = array('userid'=>$userId,'vid'=>$videoId,'pid'=>$playlistId);
	$format = array('%d','%d','%s');
	$result = $wpdb->insert($this->userPlaylistDetailTable,$data,$format);
	if($result) {
		echo json_encode(array('checkResult'=>true));
	}
	else {
		echo json_encode(array('checkResult'=>false));
	}
	exitAction('');
}
/**
 * Function deletePlaylist is used to insert delete playlist
 * This function has userId to hold current user id
 * This function has videoId to hold video id
 * This function has playlistId to hold playlist id
 * This function delete required video on required playlist
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $videoId video id
 * @param int $playlistId playlist id
 * @return array
 */
public function deletePlaylist($userId,$videoId,$playlistId) {
    global $wpdb;
	$table  = $this->userPlaylistDetailTable;
	$where  = array('userid'=>$userId,'vid'=>$videoId,'pid'=>$playlistId);
	$format = array('%d','%d','%d');
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
 * Function updatePlaylistName is used to update playlist name
 * This function has userId to hold current user id
 * This function has playlistName to hold playlist name
 * This function has existingName to hold existing playlist name
 * This function update required playlist name
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param string $playlistName new playlist name
 * @param string $existingName existing playlist name
 * @return array
 */
public function updatePlaylistName($userId,$playlistName,$existingName) {
	global $wpdb;
	$checkPlaylist = $wpdb->get_var($wpdb->prepare("SELECT playlist_name FROM ".$this->userPlaylistTable." WHERE userid=%d AND playlist_name=%s",$userId,$playlistName));
	if(!empty($checkPlaylist)) {
		echo json_encode(array('checkResult'=>'exists'));
		exitAction('');
	}
	$tableName = $this->userPlaylistTable;
	$data = array('playlist_name'=> $playlistName );
	$where = array('userid'=>$userId,'playlist_name'=>$existingName);
	$format = array('%s');
	$whereFormat = array('%d','%s');
	$checkResult = $wpdb->update($tableName,$data,$where,$format,$whereFormat);
	if($checkResult) {
		echo json_encode(array('checkResult'=>true));
	}
	else {
		echo json_encode(array('checkResult'=>false));
	}
	exitAction('');
}
/**
 * Function clearPlaylist is used to delete all playlist of current user
 * This function has userId to hold current user id
 * This function has playlistId to hold playlist id
 * This function delete required playlist of current user
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $playlistId playlist id
 * @return array
 */
public function clearPlaylist($userId,$playlistId) {
    global $wpdb;
	$table  = $this->userPlaylistTable;
	$where  = array('userid'=>$userId,'id'=>$playlistId);
	$format = array('%d','%d');
	$result = $wpdb->delete( $table, $where, $format );
	$detailsTable  = $this->userPlaylistDetailTable;
	$where  = array('userid'=>$userId,'pid'=>$playlistId);
	$format = array('%d','%d');
	$wpdb->delete( $detailsTable, $where, $format );
	if($result) {
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
/**
 * Function getPlaylistVideoDetails is used to get first set of current user playlist videos
 * This function has userId to hold current user id
 * This function has playlistId to hold playlist id
 * This function has startOffset to hold start offset
 * This function has currentObj to hold current object
 * This function has videoIdArray to hold all video id of required playlist
 * This function has videoDetails to hold required video details
 * This function get required set of playlist vidoes
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $playlistId playlist id
 * @param int $startOffset start offset
 * @return array
 */
function getPlaylistVideoDetails($userId,$playlistId,$startOffset,$currentObj ) {
	global $wpdb;
	$videoIdArray = $wpdb->get_col($wpdb->prepare("SELECT vid FROM ".$currentObj->userPlaylistDetailTable." WHERE userid=%d AND pid=%d ORDER BY id desc",$userId,$playlistId));
	$currentObj->playlistVideoCount = count($videoIdArray);
	if(!empty($videoIdArray)) {
		$videoDetails = $wpdb->get_results("SELECT * FROM ".$currentObj->hdvideoshareTable." WHERE vid IN (".implode(',',$videoIdArray).") ORDER BY field(vid,".implode(',',$videoIdArray).") LIMIT 10 OFFSET ".$startOffset);
		return $videoDetails;
	}
	else {
		return '';
	}
}
/**
 * Function getTotalPlaylistCount is used to get current user playlist count
 * This function has userId to hold current user id
 * This function has currentObj to hold current object
 * This function has userPlaylistCount to hold current user playlist count
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @return int
 */
function getTotalPlaylistCount($userId,$currentObj) {
	global $wpdb;
	$userPlaylistCount = $wpdb->get_var($wpdb->prepare("SELECT count(userid) FROM ".$currentObj->userPlaylistTable.' WHERE userid=%d',$userId));
	return $userPlaylistCount;
}
/**
 * Function getPlaylistName is used to get current user playlist name
 * This function has userId to hold current user id
 * This function has playlistId to hold playlist id
 * This function has currentObj to hold current object
 * This function has result to hold playlist name
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $playlistId playlist id
 * @return string
 */
function getPlaylistName($userId,$playlistId,$currentObj) {
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("SELECT playlist_name FROM ".$currentObj->userPlaylistTable." WHERE id=%d AND userid=%d",$playlistId,$userId));
	return $result;
}
/**
 * Function getPlaylistDetails is used to get current user playlist details
 * This function has userId to hold current user id
 * This function has startOffset to hold start offset
 * This function has currentObj to hold current object
 * This function has userPlaylists to hold playlist details
 * This function has result to hold json details to load next set of playlist details on existing set of playlist details
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $startOffset start offset
 * @return array
 */
function getPlaylistDetails($userId,$startOffset,$currentObj) {
	global $wpdb;
	$result = '';
	$userPlaylists = $wpdb->get_results($wpdb->prepare("SELECT id,playlist_name FROM ".$currentObj->userPlaylistTable.' WHERE userid=%d ORDER BY id desc LIMIT 10 OFFSET '.$startOffset,$userId));
	foreach($userPlaylists as $userPlaylist) {
		$videoDetails = $wpdb->get_row($wpdb->prepare("SELECT vid,count(pid) as count FROM ".$currentObj->userPlaylistDetailTable." WHERE pid=%d ORDER BY id desc",$userPlaylist->id));
		if($videoDetails->count > 0 ) {
			$playlistThumbDetail = $wpdb->get_row($wpdb->prepare("SELECT file_type,image FROM ".$currentObj->hdvideoshareTable." WHERE vid=%d",$videoDetails->vid));
			$videoImage = $playlistThumbDetail->image;
			$file_type  = $playlistThumbDetail->file_type;
			if ($videoImage == '') {
				$PlaylistImg = $currentObj->thumbPath . 'nothumbimage.jpg';
			}
			if (($file_type == 2 || $file_type == 5) && !empty($videoImage)) {
				$sitePath = get_site_url().'/wp-content/uploads/videogallery/';
				$PlaylistImg = $sitePath . $videoImage;
			}
			if ($file_type == 1 ) {
				$PlaylistImg = $videoImage;
			}
			$result[] = array('playlistId'=>$userPlaylist->id,'playlistName'=>$userPlaylist->playlist_name,'count'=>$videoDetails->count,'thumb'=>$PlaylistImg);
		}
		else {
			$result[] = array('playlistId'=>$userPlaylist->id,'playlistName'=>$userPlaylist->playlist_name,'count'=>$videoDetails->count,'thumb'=>'');
		}
	}
	return $result;
}
/**
 * Function clearPlaylistVideos is used to delete all videos of required playlist
 * This function has userId to hold current user id
 * This function has playlistId to hold playlist id
 * This function has currentObj to hold current object
 * This function has clearPlaylistVideos to hold playlist details table name
 * This function has exit statement to stop flow
 * @param int $userId user id
 * @param int $playlistId playlist id
 * @return array
 */
function clearPlaylistVideos($userId,$playlistId,$currentObj) {
	global $wpdb;
	$detailsTable  = $currentObj->userPlaylistDetailTable;
	$where  = array('userid'=>$userId,'pid'=>$playlistId);
	$format = array('%d','%d');
	$deleteResult = $wpdb->delete( $detailsTable, $where, $format );
	if($deleteResult) {
		echo json_encode(array('checkResult' => true));
		exitAction('');
	}
	else {
		echo json_encode(array('checkResult' => false));
		exitAction('');
	}
}