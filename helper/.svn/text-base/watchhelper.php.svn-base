<?php
/**  
 * Watch History and Watch Later common functions file.
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/**
 * WatchHepler traint contains all commonly used functions for both watch history and watch later functionality
 * Trait is used to include commonly used function on class as a simple inheritance
 */
	/**
	 * Function get_watch_video_details used to get first sets of watch history video details
	 * This function has userId to hold current user id
	 * This function has videoArray variable to hold video ids
	 * This function has videoResults to hold video results
	 * This function return video details
	 * @param int $userId user id
	 * @return object watch history/later video details
	 */
	function get_watch_video_details($userId,$watchTable,$hdvideoshareTable) {
		global $wpdb;
		$videoArray = $wpdb->get_col($wpdb->prepare("SELECT vid FROM ".$watchTable." WHERE userid=%d ORDER BY date DESC",$userId));
		if(!empty($videoArray)) {
			$videoResults = $wpdb->get_results("SELECT * FROM ".$hdvideoshareTable." WHERE vid IN (".implode(',',$videoArray).") ORDER BY field(vid,".implode(',',$videoArray).") LIMIT 10 OFFSET 0");
		}
		if(isset($_SESSION['watchoffset']) && $_SESSION['watchoffset'] != '') {
			unset($_SESSION['watchoffset']);
		}
		$_SESSION['watchoffset'] = count($videoResults);
		return $videoResults;
	}
	/**
	 * Function get_watch_video_count is used to count total watch history video count of current user
	 * This function has userId to hold current user id
	 * This function has videoArray variable to hold video ids
	 * This function has videoResults to hold video results
	 * This function return total count
	 * @param int $userId user id
	 * @return int watch history/later video count
	 */
	function get_watch_video_count($userId,$watchTable,$hdvideoshareTable) {
		global $wpdb;
		$videoArray = $wpdb->get_col($wpdb->prepare("SELECT vid FROM ".$watchTable." WHERE userid=%d ORDER BY date DESC",$userId));
		if(!empty($videoArray)) {
			$videoResults = $wpdb->get_results("SELECT * FROM ".$hdvideoshareTable." WHERE vid IN (".implode(',',$videoArray).")");
		}
		return count($videoResults);
	}
	/**
	 * Function getWatchLaterVideoIds is used to get all watch later video id of current user
	 * This function has userId to hold current user id
	 * This function has result to hold video ids
	 * This function return video ids as a array
	 * @param int $userId user id
	 * @return array watch later video id
	 */
	function getWatchLaterVideoIds($userId,$watchTable) {
		global $wpdb;
		$result = $wpdb->get_col($wpdb->prepare("SELECT vid FROM ".$watchTable." WHERE userid=%d AND status=%d",$userId,1));
		return $result;
	}
	/**
	 * Function getVideos return playlist video element content to display
	 * This function has videoName to hold video name
	 * This function has videoDescription to hold video description
	 * This function has videoRate to hold video rate
	 * This function has videoRateCount to hold video rate count
	 * This function has videoUrl to hold video url
	 * This function has videoHitcount to hold video hit count
	 * This function has videoImage to hold video thumb image
	 * This function has file_type  to hold video file type
	 * This function has image_path to hold image base url
	 * This function has videoStar to hold int value
	 * This function has videoOutput to hold html content to display video thumb on front page
	 * This function return html content to display video thumb on front page
	 * @return string
	 */
	function getVideosHelper($viewName,$videoDetailsArray,$noThumbImage,$rateArrays,$closeButtonPath) {
		$videoOutput='';
		foreach($videoDetailsArray as $videoDetails) {
			$videoName = $videoDetails->name;
			$videoDescription = ($videoDetails->description !='') ? $videoDetails->description : 'No description';
			$videoRate = $videoDetails->rate;
			$videoRateCount = $videoDetails->ratecount;
			$videoUrl  = get_video_permalink ( $videoDetails->slug );
			$videoHitcount = $videoDetails->hitcount;
			$videoImage = $videoDetails->image;
			$file_type  = $videoDetails->file_type;
			$image_path = APPTHA_VGALLERY_BASEURL;
			if($videoRateCount !=0 ) {
				$videoStar = round ( $videoRate / $videoRateCount );
			}
			else {
				$videoStar = 0;
			}
			if ($videoImage == '') {
				$thumbImage = $noThumbImage;
			}
			if (($file_type == 2 || $file_type == 5) && !empty($videoImage)) {
				$sitePath = get_site_url().'/wp-content/uploads/videogallery/';
				$thumbImage = $image_path . $videoImage;
				$thumbImage = $sitePath . $videoImage;
			}
			if ($file_type == 1 ) {
				$thumbImage = $videoImage;
			}
			$videoOutput.='<div class="watchVideo">
            <div class="watchThumb">
            <a href="'.$videoUrl.'" target="_blank"><img style="height:100px !important;"src="'.$thumbImage.'" title="'.$videoName.'"></a>
            <p class="watchRateBox">
            <span class="watchContentCount">'.$videoHitcount.' views</span>
            <span class="ratethis1 '.$rateArrays[$videoStar].' watchContentRate"></span>
            </p>
            </div>
            <div class="watchContent">
            <h3 class="watchContentTitle"><a href="'.$videoUrl.'" target="_blank" title="'.$videoName.'">'.$videoName.'</a></h3>
            <p class="watchContentDescription">'.$videoDescription.'</p>
            </div>';
			if($viewName == 'playlist') {
				$videoOutput.='<span class="watchVideoCloseButton" onclick="clearPlaylistVideo(this,'.$videoDetails->vid.')"><img src="'.$closeButtonPath.'" title="Delete video"></span>';
			}
            else {
            	$videoOutput.='<span class="watchVideoCloseButton" onclick="clearSingleVideo(this,'.$videoDetails->vid.')"><img src="'.$closeButtonPath.'" title="Delete video"></span>';
            }
            $videoOutput.='</div>';
		}
		return $videoOutput;
	}
	/**
	 * Function getVideos return playlist video element content to display
	 * This function has videoName to hold video name
	 * This function has videoDescription to hold video description
	 * This function has videoRate to hold video rate
	 * This function has videoRateCount to hold video rate count
	 * This function has videoUrl to hold video url
	 * This function has videoHitcount to hold video hit count
	 * This function has videoImage to hold video thumb image
	 * This function has file_type  to hold video file type
	 * This function has image_path to hold image base url
	 * This function has videoStar to hold int value
	 * This function has result to hold video details as a array
	 * This function return video details as a array without status property when statusArray arguments is empty or 
	 * return video details as a array with status property
	 * @return string
	 */
	function getVideoByAjax($videoResults,$statusArray='',$noThumbImage,$ratearrays) {
		foreach($videoResults as $videoDetail) {
			/** videoName to hold video name */
			$videoName = $videoDetail->name;
			/** videoDescription to hold video description */
			$videoDescription = ($videoDetail->description !='') ? $videoDetail->description : 'No description';
			/** videoRate to hold video rate */
			$videoRate = $videoDetail->rate;
			/** videoRateCount to hold video rate count */
			$videoRateCount = $videoDetail->ratecount;
			/** videoUrl to hold video url */
			$videoUrl  = get_video_permalink ( $videoDetail->slug );
			/** videoHitcount to hold video hit count */
			$videoHitcount = $videoDetail->hitcount;
			/** videoImage to hold video thumb image */
			$videoImage = $videoDetail->image;
			/** file_type  to hold video file type */
			$file_type  = $videoDetail->file_type;
			/** image_path to hold image base url */
			$image_path = APPTHA_VGALLERY_BASEURL;
			if($videoRateCount != 0 ) {
				/** videoStar to hold int value */
				$videoStar = round ( $videoRate / $videoRateCount );
			}
			else {
				$videoStar = 0;
			}
			if ($videoImage == '') {
				/** thumbImageto hold thumb image url */
				$thumbImage = $noThumbImage;
			}
			if (($file_type == 2 || $file_type == 5) && !empty($videoImage)) {
				/** thumbImageto hold thumb image url */
				$sitePath = get_site_url().'/wp-content/uploads/videogallery/';
				$thumbImage = $sitePath . $videoImage;
			}
			if ($file_type == 1 ) {
				/** thumbImageto hold thumb image url */
				$thumbImage = $videoImage;
			}
			if(empty($statusArray)) {
				$result[] = array('vid' => $videoDetail->vid,'name' =>$videoName,'url' => $videoUrl,'hitcount' =>$videoHitcount,'rate' => $ratearrays[$videoStar],'thumb' => $thumbImage,'description' =>$videoDescription);
			}
			else {
				$result[] = array('vid' => $videoDetail->vid,'name' =>$videoName,'url' => $videoUrl,'hitcount' =>$videoHitcount,'rate' => $ratearrays[$videoStar],'thumb' => $thumbImage,'description' =>$videoDescription,'status' =>(in_array($videoDetail->vid,$statusArray)) ? 1 : -2);
			}
		}
		return $result;
	}