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
 * videoHelper traint contains all commonly used functions for both watch later functionality
 */
	/**
	 * Function to get watch later video details for home and more page videos
	 * This function has videoId to hold video id
	 * This function has playlistImg to hold video playlist thumb image
	 * This function has watchLaterImg to hold watch Later thumb img
	 * This function has watchLaterTitle to hold watch Later Title
	 * This function has clickEvent to hold click event
	 * This function has duration  to hold video duration 
	 * This function has file_type  to hold video file_type 
	 * This function has guid  to hold video guid url
	 * This function has imageFea to hold imageFea
	 * @return void
	 */
	function watchLaterHelper($playList,$watchLaterVideoIds) {
		/** videoId to hold video id */
      	$this->videoId =  $playList->vid;
      	/** playlistImg to hold video playlist thumb image */
      	$this->playlistImg = APPTHA_VGALLERY_BASEURL.'images/playlist.png';
      	if(in_array($this->videoId,$watchLaterVideoIds)) {
      		/** watchLaterImg to hold watch Later thumb img */
      		$this->watchLaterImg = APPTHA_VGALLERY_BASEURL.'images/accepted.png';
      		/** watchLaterTitle to hold watch Later Title */
      		$this->watchLaterTitle = 'Added to Watch Later';
      		/** clickEvent to hold click event */
      		$this->clickEvent = '';
      	}
      	else {
      		/** watchLaterImg to hold watch Later thumb img */
      		$this->watchLaterImg = APPTHA_VGALLERY_BASEURL.'images/watchlater2.png';
      		/** watchLaterTitle to hold watch Later Title */
      		$this->watchLaterTitle = 'Add to Watch Later';
      		/** clickEvent to hold click event */
      		$this->clickEvent = 'onclick="watchLater('.$this->videoId.',this)"';
      	}
      	/** duration  to hold video duration  */
        $this->duration     = $playList->duration;
        /** file_type  to hold video file_type */
        $this->file_type    = $playList->file_type;
        /** guid  to hold video guid url */
        $this->guid         = get_video_permalink ( $playList->slug );
        /** imageFea to hold imageFea */
        $this->imageFea     = getImagesValue ($playList->image, $this->file_type, $playList->amazon_buckets, '');
	}