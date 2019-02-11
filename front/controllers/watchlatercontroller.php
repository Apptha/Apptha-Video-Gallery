<?php
/**  
 * Watch Later Controller file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/**
 * Trait contain commonly used function for watch later
 */
/** Including ContusWatchLaterView view file to display watch later videos. */
include_once ($frontViewPath . 'watchlater.php');
/** Check WatchLaterController class is exists */
if ( !class_exists ( 'WatchLaterController' ) ) {
    /**
     * Class is used to manage view and model
     *
     * @author user
     */
class WatchLaterController extends WatchLaterView {
	/**
	 * watchDetailsTable property store watch later table name
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
		$this->watchDetailsTable = WVG_WATCH_LATER;
		$this->hdvideoshareTable = $wpdb->prefix.'hdflvvideoshare';
		parent::__construct();
	}
	/**
	 * Function displayController call the displayView of default view
	 * This function allow user to view watch later videos
	 * User can watch required videos later by storing that videos on watch later section
	 * User can view watch later icon once they mouse over the video thumb image and if he/she click that icon then this function 
	 * add that video to watch later section.
	 * Function display all watch later videos on watch later page
	 * User can delete a required watch later videos by clicking close icon on top right corner of thumb image
	 * User can delete all watch later videos by clicking clear videos button
	 * This function also display watched icon once if user watched a video on watch later page.
	 * @return void
	 */
	public function displayController() {
		$view = $this;
		$view->displayView();  
	}
	/**
	 * Function getWatchLaterVideoDetailsByOffset call the getWatchLaterVideoDetails method in model
	 * to get required watch history video
	 * This function is used to get required set of videos
	 * This function append this set of videos to existing videos list on front page
	 * This function require user id to get videos
	 * This function require start offset to get required set of videos
	 * @param int $watchUserId user id
	 * @param int $startOffset start offset
	 * @return void
	 */
	public function getWatchLaterVideoDetailsByOffset($watchUserId,$startOffset) {
		$model = $this;
		$model->getWatchLaterVideoDetails($watchUserId,$startOffset);
	}
	/**
	 * Function clear_watch_later call clear_watch_later_model method to clear all watch later videos
	 * This function allow user to delete all watch later videos by clicking clear videos button
	 * This function require user id to delete watch later videos
	 * @param int $userId user id
	 * @return void
	 */
	public function clear_watch_later($userId) {
		$this->clear_watch_later_model($userId);
	}
	/**
	 * Function clear_watch_later_video call clear_watch_later_video_model method to clear a required watch later videos
	 * This function allow user to delete a required watch later videos by clicking close icon on top right corner of thumb image
	 * This function require user id to delete a watch later video
	 * This function require video id to delete a required video
	 * @param int $userId user id
	 * @return void
	 */
	public function clear_watch_later_video($userId,$videoId) {
		$this->clear_watch_later_video_model($userId,$videoId);
	}
	/**
	 * Function store_watch_later_videos call store_watch_later_videos_model to insert new watch later videos to database or 
	 * update existing watch later to database
	 * This function require user id to store watch later video
	 * This function require video id to store video on that video id
	 * @param int $watchUserId user id
	 * @param int $videoId video id 
	 * @return void
	 */
	public function store_watch_later_videos($watchUserId,$videoId) {
		$this->store_watch_later_videos_model($watchUserId,$videoId);
	}
	/**
	 * Function watchLaterStatusController call watchLaterStatusModel to update a watch later video status
	 * This function also display watched icon once if user watched a video on watch later page.
	 * This function require user id
	 * This function require video id to append watched image
	 * @param int $watchUserId user id
	 * @param int $videoId video id
	 * @return void
	 */
	public function watchLaterStatusController($watchUserId,$videoId) {
		$this->watchLaterStatusModel($watchUserId,$videoId);
	}
}
}