<?php
/**  
 * Playlist Controller file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Including playlist view file to display playlist videos. */
include_once ($frontViewPath . 'playlist.php');
/** Check PlaylistController class is exists */
if ( !class_exists ( 'PlaylistController' ) ) {
    /**
     * Class is used to manage view and model
     * @author user
     */
class PlaylistController extends PlaylistView {
	/**
	 * userPlaylistTable property to store user playlist table name
	 * playlistUserId to store user playlist id
	 */
	public $userPlaylistTable;
	public $playlistUserId;
	/**
	 * Constructor is used to initialize class properties
	 */
	public function __construct($userId='') {
		global $wpdb;
		$this->userPlaylistTable = WVG_USER_PLAYLIST;
		$this->userPlaylistDetailTable = WVG_USER_PLAYLIST_DETAILS;
		$this->hdvideoshareTable = $wpdb->prefix.'hdflvvideoshare';
		$this->settingsTable = $wpdb->prefix.'hdflvvideoshare_settings';
		$this->playlistUserId = $userId;
		parent::__construct();
	}
	/**
	 * Function displayController call the displayView of default view
	 * This function display current user playlists with thumb image.
	 * This fuction display current user playlist video count
	 * Current user can view videos store on playlist by clicking required playlist thumb image.
	 * User can play required videos by clicking video thumb image.
	 * Current user can delete required single videos by clicking close icon on top right corner of video thumb image or
	 * user can delete all videos store on a playlist by clicking clear videos button.
	 * Current user can also delete a required playlist by clicking delete playlist button
	 * @return void 
	 */
	public function displayController() {
		$view = $this;
		$view->displayView();
	}
	/**
	 * Function currentUserPlaylistController call getCurrentUserPlaylistName
	 * This function is used to display current user playlist details and display playlist with thumb image
	 * and also it display videos count of each playlist.
	 * @param int $watchUserId user id
	 * @param int $videoId video id
	 * @return void
	 */
	public function currentUserPlaylistController($watchUserId,$videoId) {
		$this->getCurrentUserPlaylistName($watchUserId,$videoId);
	}
	/**
	 * Function storePlaylistController call createPlaylist method on model file
	 * This function is used to create a new playlist.
	 * This function add videos to this newly created playlist or existing playlist automatically.
	 * This function require user id to create playlist for this user
	 * This function require video to add this video to this plalist.
	 * This function require palylist name to create playlist
	 * @param int $watchUserId user id
	 * @param int $videoId video id
	 * @param string $playlistName playlist name
	 * @return void
	 */
	public function storePlaylistController($watchUserId,$videoId,$playlistName) {
		$this->createPlaylist($watchUserId,$videoId,$playlistName);
	}
	/**
	 * Function removePlaylistController call deletePlaylist method
	 * This function is used to delete a required video from required playlist
	 * This function require current user id to delete video
	 * This function require video id to remove
	 * This function require playlist id to remove this video from this playlist
	 * @param int $watchUserId user id
	 * @param int $videoId video id
	 * @param string $playlistId playlist id
	 * @return void 
	 */
	public function removePlaylistController($watchUserId,$videoId,$playlistId) {
		$this->deletePlaylist($watchUserId,$videoId,$playlistId);
	}
	/**
	 * Function insertPlaylistVideoController call insertPlaylistVideo method
	 * This function is used to insert a required video to required playlist
	 * This function require current user id to insert video
	 * This function require video id to insert
	 * This function require playlist id to insert this video from this playlist
	 * @param int $watchUserId user id
	 * @param int $videoId video id
	 * @param int $playlistId playlist id
	 * @return void
	 */
	public function insertPlaylistVideoController($watchUserId,$videoId,$playlistId) {
		$this->insertPlaylistVideo($watchUserId,$videoId,$playlistId);
	}
	/**
	 * Function getPlaylistVideosController call getPlaylistVideosByAjax
	 * This function is used to get required set of videos from required playlist
	 * This function append this set of videos to existing videos list on front page
	 * This function require user id to get videos
	 * This function require start offset to get required set of videos
	 * This function require playlist id to get video from this playlist
	 * @param int $userId user id
	 * @param int $startOffset start offset
	 * @param int $playlistId playlist id
	 * @return void
	 */
	public function getPlaylistVideosController($userId,$startOffset,$playlistId) {
		$this->getPlaylistVideosByAjax($userId,$startOffset,$playlistId);
	}
	/**
	 * Function clearPlaylistVideoController call deletePlaylist
	 * This function is used to delete a required video from required playlist
	 * This function require current user id to delete video
	 * This function require video id to remove
	 * This function require playlist id to remove this video from this playlist
	 * @param int $userId user id
	 * @param int $videoId video id
	 * @param int $playlistId playlist id
	 * @return void
	 */
	public function clearPlaylistVideoController($userId,$videoId,$playlistId) {
		$this->deletePlaylist($userId,$videoId,$playlistId);
	}
	/**
	 * Function getPlaylistbyOffsetController call getPlaylistbyOffset
	 * This function is used to get required set of current user playlist
	 * This function append this set of playlist to existing playlist list on front page
	 * This function require user id to get playlist
	 * This function require start offset to get required set of playlist
	 * @param int $userId user id
	 * @param int $startOffset start offset
	 * @return void
	 */
	public function getPlaylistbyOffsetController($userId,$startOffset) {
		$this->getPlaylistbyOffset($userId,$startOffset);
	}
	/**
	 * Function clearPlaylistController call clearPlaylist
	 * This function is used to delete a required playlist
	 * This function require current user id to delete playlist
	 * This function require playlist id to remove this playlist from the list of current user playlists
	 * @param int $userId user id
	 * @param int $playlistId playlist id
	 * @return void
	 */
	public function clearPlaylistController($userId,$playlistId) {
		$this->clearPlaylist($userId,$playlistId);
	}
	/**
	 * Function clearPlaylistVideosController call clearPlaylistVideos
	 * @param int $userId user id
	 * @param int $playlistId playlist id
	 * @return void
	 */
	public function clearPlaylistVideosController($userId,$playlistId) {
		clearPlaylistVideos($userId,$playlistId,$this);
	}
	/**
	 * Function updatePlaylistNameController call updatePlaylistName
	 * This function is used to update playlist name
	 * This function require user id
	 * This function require new playlist name to update
	 * This function require existing playlist name to check whether exists or not
	 * @param int $userId user id
	 * @param string $playlistName playlist name
	 * @param string $existingName existing playlist name
	 * @return void
	 */
	public function updatePlaylistNameController($userId,$playlistName,$existingName) {
		$this->updatePlaylistName($userId,$playlistName,$existingName);
	}
}
}