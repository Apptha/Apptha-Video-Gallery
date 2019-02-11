<?php
/**  
 * Watch Later View file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Including ContusWatchalaterModel view file to store or retrieve watch later details. */
include_once ($frontModelPath . 'watchlater.php');
/**
 * This page load the watch later template file
 * User can watch required videos later by storing that videos on watch later section
 * User can view watch later icon once they mouse over the video thumb image and if he/she click that icon then this function 
 * add that video to watch later section.
 * Function display all watch later videos on watch later page
 * User can delete a required watch later videos by clicking close icon on top right corner of thumb image
 * User can delete all watch later videos by clicking clear videos button
 * This function also display watched icon once if user watched a video on watch later page.
 */
/** Check ContusWatchLaterView class is exists */
if ( !class_exists ( 'WatchLaterView' ) ) {
    /**
     * Class is used to display watch later data
     *
     * @author user
     */
class WatchLaterView extends WatchLaterModel {
	
	public function __construct() {
		$this->thumbPath = APPTHA_VGALLERY_BASEURL . 'images' . DS;
		$this->ratearray = array ( 'nopos1', 'onepos1', 'twopos1', 'threepos1', 'fourpos1', 'fivepos1' );
		$this->closeButtonPath = APPTHA_VGALLERY_BASEURL.'images/wclose1.png';
	}
	/**
	 * Function displayView load the watch later default template file
	 * @return void
	 */
	public function displayView() {
		global $frontViewPath;
		$userId = get_current_user_id();
		$model = $this;
		$this->watchLaterDetails = get_watch_video_details($userId,$this->watchDetailsTable,$this->hdvideoshareTable);
		$this->watchLaterVideosStatus = $model->get_videos_status($userId);
		$this->watchLaterCount   = get_watch_video_count($userId,$this->watchDetailsTable,$this->hdvideoshareTable);
		$this->showTemplate();
	}
	/**
	 * This function allow user to view watch later videos
	 * User can watch required videos later by storing that videos on watch later section
	 * User can view watch later icon once they mouse over the video thumb image and if he/she click that icon then this function 
	 * add that video to watch later section.
	 * Function display all watch later videos on watch later page
	 * User can delete a required watch later videos by clicking close icon on top right corner of thumb image
	 * User can delete all watch later videos by clicking clear videos button
	 * This function also display watched icon once if user watched a video on watch later page.
	 */
	public function showTemplate() {
		$output='';
		$output = '<div class="watchOuterBox" style="box-sizing:border-box;">
        <div class="watchInnerBox">';
		if(count($this->watchLaterDetails) > 0 ) {
			$output .='<div class="watchButtonContainer"><button class="clearButton watchButton" id="clearButton" title="'.__( 'Clear Watch Later', APPTHA_VGALLERY ).'">'.__( 'Clear Watch Later', APPTHA_VGALLERY ).'</button></div>';
		}
		$output .='<div class="watchVideoContainer" data-setaction ="later" data-totalvideocount="'.$this->watchLaterCount.'" data-loaderthumb = "'.$this->thumbPath.'">';
		
		if(count($this->watchLaterDetails) > 0 ) {
			$output .= $this->getVideos();
		}
		else {
			$output .='<div class="watchVideo">
        <p class="noWatchFound">'.__( 'No Videos Found', APPTHA_VGALLERY ).'</p>
        </div>';
		}
		$output.='</div></div></div>';
		echo $output;
	}
	/**
	 * Function getVideos return watch later video element content to display
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
	 * @return string watch later video details
	 */
	public function getVideos() {
		$watchLaterVideoOutput='';
		foreach($this->watchLaterDetails as $watchLaterDetail) {
			/** videoName to hold video name */
			$videoName = $watchLaterDetail->name;
			/** videoDescription to hold video description */
			$videoDescription = ($watchLaterDetail->description !='') ? $watchLaterDetail->description : 'No description';
			/** videoRate to hold video rate */
			$this->videoRate = $watchLaterDetail->rate;
			/** videoRateCount to hold video rate count */
			$this->videoRateCount = $watchLaterDetail->ratecount;
			/** videoUrl to hold video url */
			$videoUrl  = get_video_permalink ( $watchLaterDetail->slug );
			/** videoHitcount to hold video hit count */
			$videoHitcount = $watchLaterDetail->hitcount;
			/** videoImage to hold video thumb image */
			$this->videoImage = $watchLaterDetail->image;
			/** file_type  to hold video file type */
			$this->file_type  = $watchLaterDetail->file_type;
			/** image_path to hold image base url */
			$this->image_path = APPTHA_VGALLERY_BASEURL;	
			$this-> getVideoCount();		
			$watchLaterVideoOutput.='<div class="watchVideo">
            <div class="watchThumb">';
			if(in_array($watchLaterDetail->vid,$this->watchLaterVideosStatus)) {
				$watchLaterVideoOutput.='<a class="watchLinkElement" id="watchLinkElement" href="'.$videoUrl.'" target="_blank" onclick="changeWatchLaterVideoStatus('.$watchLaterDetail->vid.',this)">';
			}
			else {
				$watchLaterVideoOutput.='<a href="'.$videoUrl.'" target="_blank">';
			}
			$watchLaterVideoOutput.='<img style="height:100px !important;"src="'.$this->thumbImage.'" title="'.$videoName.'">';
			if(!in_array($watchLaterDetail->vid,$this->watchLaterVideosStatus)) {
				$watchLaterVideoOutput.='<span class="videoWatchedBox">Watched</span>';
			}
			$watchLaterVideoOutput.='</a><p class="watchRateBox">
            <span class="watchContentCount">'.$videoHitcount.' views</span>
            <span class="ratethis1 '.$this->ratearray[$this->videoStar].' watchContentRate"></span>
            </p>
            </div>
            <div class="watchContent">
            <h3 class="watchContentTitle">';
			if(in_array($watchLaterDetail->vid,$this->watchLaterVideosStatus)) {
				$watchLaterVideoOutput.='<a href="'.$videoUrl.'" target="_blank" onclick="changeWatchLaterVideoStatus('.$watchLaterDetail->vid.',this)" title="'.$videoName.'">'.$videoName.'</a>';
			}
			else {
				$watchLaterVideoOutput.='<a href="'.$videoUrl.'" target="_blank" title="'.$videoName.'">'.$videoName.'</a>';
			}
			$watchLaterVideoOutput.='</h3>
            <p class="watchContentDescription">'.$videoDescription.'</p>
            </div>
            <span class="watchVideoCloseButton" onclick="clearSingleVideo(this,'.$watchLaterDetail->vid.')"><img src="'.$this->closeButtonPath.'" title="Delete video"></span>
            </div>';
		}
		return $watchLaterVideoOutput;
	}
	/**
	 * Function getVideoCount is used to get video rateCount
	 * @return void
	 */
	public function getVideoCount() {
		if($this->videoRateCount !=0 ) {
			/** videoStar to hold int value */
			$this->videoStar = round ( $this->videoRate / $this->videoRateCount );
		}
		else {
			$this->videoStar = 0;
		}
		if ($this->videoImage == '') {
			/** thumbImageto hold thumb image url */
			$this->thumbImage = $this->thumbPath . 'nothumbimage.jpg';
		}
		if (($this->file_type == 2 || $this->file_type == 5) && !empty($this->videoImage)) {
			/** thumbImageto hold thumb image url */
			$sitePath = get_site_url().'/wp-content/uploads/videogallery/';
			$this->thumbImage = $this->image_path . $this->videoImage;
			$this->thumbImage = $sitePath . $this->videoImage;
		}
		if ($this->file_type == 1 ) {
			/** thumbImageto hold thumb image url */
			$this->thumbImage = $this->videoImage;
		}
	}
}
}