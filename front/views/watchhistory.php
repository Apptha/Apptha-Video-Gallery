<?php
/**  
 * Watch History View file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Including ContusWatchHistoryModel view file to store or retrieve watch history details. */
include_once ($frontModelPath . 'watchhistory.php');
/** Check WatchHistoryView class is exists */
/**
 * This page load the watch history template file
 * User can watch his/her watch history details with infinite scroll pagination features
 * This function first display some sets of videos and then if user scroll down then it load another set of videos
 * User can delete a required watch history videos by clicking close icon on top right corner of thumb image
 * User can delete all watch history videos by clicking clear videos button
 * User can pause watch history by clicking pause history button
 * User can resume watch history by clicking resume history button 
 */
if ( !class_exists ( 'WatchHistoryView' ) ) {
    /**
     * Class is used to display watch history data
     *
     * @author user
     */
class WatchHistoryView extends WatchHistoryModel {
	
	public function __construct() {
		$this->thumbPath = APPTHA_VGALLERY_BASEURL . 'images' . DS;
		$this->ratearray = array ( 'nopos1', 'onepos1', 'twopos1', 'threepos1', 'fourpos1', 'fivepos1' );
		$this->closeButtonPath = APPTHA_VGALLERY_BASEURL.'images/wclose1.png';
	}
	/**
	 * Function displayView load the watch history default template file
	 * @return void
	 */
	public function displayView() {
		global $frontViewPath;
		$userId = get_current_user_id();
		$model = $this;
		$this->videoDetails = get_watch_video_details($userId,$this->watchDetailsTable,$this->hdvideoshareTable);
		$this->watchHistoryStatus  = $model->get_watch_history_status($userId);
		$this->watchHistoryCount   = get_watch_video_count($userId,$this->watchDetailsTable,$this->hdvideoshareTable);
		$this->showTemplate();
	}
	/**
	 * This function is used to display current user watch history
	 * User can watch his/her watch history details with infinite scroll pagination features
	 * This function first display some sets of videos and then if user scroll down then it load another set of videos
	 * User can delete a required watch history videos by clicking close icon on top right corner of thumb image
	 * User can delete all watch history videos by clicking clear videos button
	 * User can pause watch history by clicking pause history button
	 * User can resume watch history by clicking resume history button 
	 * @return string
	 */
	public function showTemplate() {
		$output = '';
		$output = '<div class="watchOuterBox" style="box-sizing:border-box;">
        <div class="watchInnerBox">
        <div class="watchButtonContainer">';
		if($this->watchHistoryStatus == 1 ) {
			$output .='<button class="pauseButton watchButton" id="pauseButton" onclick="changeWatchHistoryStatus('."'pause'".')" title="'.__( 'Pause watch history', APPTHA_VGALLERY ).'">'.__( 'Pause watch history', APPTHA_VGALLERY ).'</button>';
		}
		if($this->watchHistoryStatus == -2 ) {
			$output .='<button class="resumeButton watchButton" id="resumeButton" onclick="changeWatchHistoryStatus('."'resume'".')" title="'.__( 'Resume Watch History', APPTHA_VGALLERY ).'">'.__( 'Resume Watch History', APPTHA_VGALLERY ).'</button>';
		}
		if(count($this->videoDetails) > 0 ) {
			$output .='<button class="clearButton watchButton" id="clearButton" title="'.__( 'Clear Watch History', APPTHA_VGALLERY ).'">'.__( 'Clear Watch History', APPTHA_VGALLERY ).'</button>';
		}
		$output .='</div><div class="watchVideoContainer" data-setaction ="history" data-totalvideocount="'.$this->watchHistoryCount.'" data-loaderthumb = "'.$this->thumbPath.'">';
		
		if(count($this->videoDetails) > 0 ) {
			$output .= getVideosHelper('history',$this->videoDetails,$this->thumbPath . 'nothumbimage.jpg',$this->ratearray,$this->closeButtonPath);
		}
		else {
			$output .='<div class="watchVideo">
        <p class="noWatchFound">'.__( 'No Videos Found', APPTHA_VGALLERY ).'</p>
        </div>';
		}
		$output.='</div></div></div>';
		echo $output;
	}
}
}