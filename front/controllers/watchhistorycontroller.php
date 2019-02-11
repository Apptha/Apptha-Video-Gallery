<?php
/**  
 * Watch History Controller file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/**
 * Trait contain commonly used function for watch history
 */
/** Including ContusWatchHistoryView view file to display watch history videos. */
include_once ($frontViewPath . 'watchhistory.php');
/** Check WatchHistoryController class is exists */
if ( !class_exists ( 'WatchHistoryController' ) ) {
    /**
     * Class is used to manage view and model
     *
     * @author user
     */
class WatchHistoryController extends WatchHistoryView {
	/**
	 * watchDetailsTable property store watch history table name
	 */
	public $watchDetailsTable;
	/**
	 * hdvideoshareTable property store hdflvvideoshare table name
	 */
	public $hdvideoshareTable;
	/**
	 * Constructor is used to initialize class properties
	 */
	public function __construct() {
		global $wpdb;
		$this->watchDetailsTable = WVG_WATCH_HISTORY_DETAILS;
		$this->hdvideoshareTable = $wpdb->prefix.'hdflvvideoshare';
		parent::__construct();
	}
	/**
	 * Function displayController call the displayView of default view
	 * This function is used to display current user watch history
	 * User can watch his/her watch history details with infinite scroll pagination features
	 * This function first display some sets of videos and then if user scroll down then it load another set of videos
	 * User can delete a required watch history videos by clicking close icon on top right corner of thumb image
	 * User can delete all watch history videos by clicking clear videos button
	 * User can pause watch history by clicking pause history button
	 * User can resume watch history by clicking resume history button 
	 * @return void
	 */
	public function displayController() {
		$view = $this;
		$view->displayView();  
	}
	/**
	 * Function getWatchHistoryVideoDetailsByOffset call the getWatchHistoryVideoDetails method in model
	 * to get required watch history video
	 * This function is used to get required set of videos
	 * This function append this set of videos to existing videos list on front page
	 * This function require user id to get videos
	 * This function require start offset to get required set of videos
	 * @param int $watchUserId user id
	 * @param int $startOffset start offset
	 * @return void
	 */
	public function getWatchHistoryVideoDetailsByOffset($watchUserId,$startOffset) {
		$model = $this;
		$model->getWatchHistoryVideoDetails($watchUserId,$startOffset);
	}
	/**
	 * Function update_watch_history_status update user watch history status
	 * This function is used to update watch history status whether to pause watch history or resume watch resume
	 * This function is used to get watched videos records if user click resume watch history button.
	 * This function is used to didn't get watched videos records if user click pause watch history button.
	 * This function require user id to update status
	 * This function require status to pause or resume watch history
	 * @param int $userid user id
	 * @param int $watch_status existing status
	 * @return void
	 */
	public function update_watch_history_status($userId,$watchStatus) {
		$this->update_watch_history_status_model($userId,$watchStatus);
	}
	/**
	 * Function clear_watch_history call clear_watch_history_model method to clear all history videos
	 * This function allow user to delete all watch history videos by clicking clear videos button
	 * This function require user id to delete watch history videos
	 * @param int $userId user id
	 * @return void
	 */
	public function clear_watch_history($userId) {
		$this->clear_watch_history_model($userId);
	}
	/**
	 * Function clear_watch_history_video call clear_watch_history_video_model method to clear a required history videos
	 * This function allow user to delete a required watch history videos by clicking close icon on top right corner of thumb image
	 * This function require user id to delete a watch history video
	 * This function require video id to delete a required video
	 * @param int $userId user id
	 * @return void
	 */
	public function clear_watch_history_video($userId,$videoId) {
		$this->clear_watch_history_video_model($userId,$videoId);
	}
}
}