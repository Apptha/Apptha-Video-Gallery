<?php
/**  
 * Playlist View file.
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Including Playlist Model file to store or retrieve playlist details. */
include_once ($frontModelPath . 'playlist.php');
/** Check PlaylistView class is exists */
if ( !class_exists ( 'PlaylistView' ) ) {
    /**
     * Class is used to display playlist data
     *
     * @author user
     */
class PlaylistView extends PlaylistModel {
	/**
	 * playlistDetails property to store user playlist details
	 */
	public $playlistDetails;
	/**
	 * Constructor is used to initialize class properties
	 */
	public function __construct() {
		$this->thumbPath = APPTHA_VGALLERY_BASEURL . 'images' . DS;
		$this->ratearray = array ( 'nopos1', 'onepos1', 'twopos1', 'threepos1', 'fourpos1', 'fivepos1' );
		$this->closeButtonPath = APPTHA_VGALLERY_BASEURL.'images/wclose1.png';
	}
	/**
	 * Function displayView load the playlist default template file
	 * @return void
	 */
	public function displayView() {
		$userId = (!empty($this->playlistUserId)) ? $this->playlistUserId : '';
		if($userId == '') {
			$userId = get_current_user_id();
		}
		$this->playlistId = (isset($_REQUEST['pid']) && $_REQUEST['pid'] != '') ? intval($_REQUEST['pid']) : '';
		if(!empty($this->playlistId) && !empty($userId)) {
			$startOffset = 0;
			$this->videoDetails = getPlaylistVideoDetails($userId,$this->playlistId,$startOffset,$this);
   		    $this->playlistName = getPlaylistName($userId,$this->playlistId,$this);
		}
		elseif(empty($this->playlistId) && !empty($userId)) {
			$startOffset = 0;
			$this->playlistDetails = getPlaylistDetails($userId,$startOffset,$this);
			$this->playlistCount = getTotalPlaylistCount($userId,$this);
		}
		else {
			echo 'login';
		}
			$this->displayTemplate();
	}
	/**
	 * Function displayTemplate is used to call getPlaylistTemplate to display playlist or call getPlaylistVideoTemplate to display playlist video
	 * Function displayController call the displayView of default view
	 * This function display current user playlists with thumb image.
	 * This fuction display current user playlist video count
	 * Current user can view videos store on playlist by clicking required playlist thumb image.
	 * User can play required videos by clicking video thumb image.
	 * Current user can delete required single videos by clicking close icon on top right corner of video thumb image or
	 * user can delete all videos store on a playlist by clicking clear videos button.
	 * Current user can also delete a required playlist by clicking delete playlist button
	 * @return string
	 */
	public function displayTemplate() {
		$output = '';
		$output .= '<div class="playlistTemplateOuterBox">';
		if(empty($this->playlistId)) {
			$output.= $this->getPlaylistTemplate();
		}
		else {
			$output.= $this->getPlaylistVideoTemplate();
		}
		$output.='</div>';
		echo $output; 
	}
	/**
	 * Function getPlaylistVideoTemplate is used to display current user playlist videos
	 * @return string
	 */
	public function getPlaylistVideoTemplate() {
		$playlistCount = $this->playlistVideoCount;
		$videoOutput = '';
		$videoOutput .='<div class="playlistTemplateContainer" >
		<div class="playlistContainerBox">';
		$videoOutput .='
		<div class="playlistDetailElement">
		<p class="playlistNameElement" data-playlistname="'.$this->playlistName.'"><span class="spanForPlaylist">'.$this->playlistName.'</span>
		<span class="spanForEditName"><img src="'.$this->thumbPath .'edit3.gif" title="Edit playlist title" style="width:24px !important;height:24px !important;cursor:pointer"></span>
		</p>';
		
		if(!empty($this->playlistName)) {
			$videoOutput .='<span class="deletePlaylistButton" data-plid="'.$this->playlistId.'" style="margin-right:5px" title="'.__( 'Delete Playlist', APPTHA_VGALLERY ).'">'.__( 'Delete Playlist', APPTHA_VGALLERY ).'</span>';
		}
		
		if(!empty($this->videoDetails)) {
			$videoOutput .='<span class="clearPlaylistButton" data-plid="'.$this->playlistId.'" title="'.__( 'Clear Videos', APPTHA_VGALLERY ).'">'.__( 'Clear Videos', APPTHA_VGALLERY ).'</span>';
		}
				
		$videoOutput .='</div>
		</div>
		<div class="watchVideoContainer playlistScrollData" data-plid="'.$this->playlistId.'" data-setaction ="playlistvideos" data-totalvideocount="'.$playlistCount.'" data-loaderthumb = "'.$this->thumbPath.'">';
		
		if(!empty($this->videoDetails)) {
			$videoOutput .= getVideosHelper('playlist',$this->videoDetails,$this->thumbPath . 'nothumbimage.jpg',$this->ratearray,$this->closeButtonPath);
		}
		else {
			$videoOutput .='<div class="watchVideo">
        <p class="noWatchFound">'.__( 'No Videos Found', APPTHA_VGALLERY ).'</p>
        </div>';
		}
                $videoOutput .='</div></div>';
		return $videoOutput;
	}
	/**
	 * Function getPlaylistTemplate is used to display current user playlist list
	 * @return string
	 */
	public function getPlaylistTemplate() {
		$playlistOutput = '';
		$playlistCount = $this->playlistCount;
		if(empty($this->playlistDetails) ) {
			$playlistOutput.='<p class="playlistNotFound">'.__( 'No playlist found', APPTHA_VGALLERY ).'</p>';
			return $playlistOutput;
		}
		$playlistOutput .='<div class="playlistTemplateContainer playlistScrollData" data-setaction ="playlist" data-totalvideocount="'.$playlistCount.'" data-loaderthumb = "'.$this->thumbPath.'">';
		foreach($this->playlistDetails as $playlistDetail) {
			$playlistVideoLink = add_query_arg('pid',$playlistDetail["playlistId"]);
			if(empty($playlistDetail["thumb"])) {
				$playlistDetail["thumb"] = $this->thumbPath.'nothumbimage.jpg';
			}
			$playlistOutput.='<div class="playlistTemplateBox" data-pid='.$playlistDetail["playlistId"].'>
			<div class="playlistImgBox">
			<a class="playlistVideoLinkElement" href="'.$playlistVideoLink.'"><img src="'.$playlistDetail["thumb"].'" class="plalylistThumbImage" title="'.$playlistDetail["playlistName"].'"></a>
			</div>
			<p class="playlistVideoCountBox">'.$playlistDetail["count"].' videos</p>
			<a class="playlistVideoLinkElement" href="'.$playlistVideoLink.'" title="'.$playlistDetail["playlistName"].'"><p class="playlistNameBox">'.$playlistDetail["playlistName"].'</p></a>
			</div>';
		}
                $playlistOutput.='</div>';
		return $playlistOutput;
	}

}
}