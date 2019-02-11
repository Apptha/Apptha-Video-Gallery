<?php
/**  
 * Video more pages view file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Check ContusMorePageView class is exist */
if ( !class_exists ( 'ContusMorePageView' )) {
  /**
   * ContusMorePageView class is used to display home page player and thumbnails
   *
   * @author user
   */
  class ContusMorePageView extends MoreSearchView {
    /**
     * Fucntion to display more videos page title 
     * 
     * @param unknown $type_name
     * @param unknown $typename
     * @return string
     */
    function morePageTitle ( $type_name, $typename ) {
      $div = '';
      /** Check type name and get title for the more pages */
      switch( $type_name ) {
        case 'Category':
          /** Get playlsit name based on playl id */
          $playlist_name  = get_playlist_name ( intval ( absint ( $this->_playid ) ) );
          /** Display playlist title in category page*/
          $div            .= '<h2 class="titleouter" >' . $playlist_name . ' </h2>';
          break;
        case 'User':
          /** Get user name based on user id */
          $user_name      = get_user_name ( intval ( $this->_userid ) );
          /** Display user name in user videos page */ 
          $div            .= '<h2 >' . $user_name . ' </h2>';
          break;
        case 'popular': case 'recent': case 'random': case 'featured':
          /** Get current more type and display as page title */ 
          $div            .= '<h2 >' . $typename . ' ' . __ ( 'Videos', APPTHA_VGALLERY ) . ' </h2>';
          break;
        default:
          break;
      }
      /** Return more page title */ 
      return $div;
    }
    /**
     * Function to display
     * recent ,feature ,category, popular,
     * random, user and search pages
     *
     * @parem   $type
     * @parem   $arguments
     */
    function video_more_pages( $type, $arguments ) {
      $TypeOFvideos = $CountOFVideos = $typename = $type_name = $morePage = $dataLimit = $div = $pagenum ='';
      /** Check homeVideo function is exists */
      if ( !function_exists ( 'homeVideo' ) ) {
        if ($type == 'search' || $type == 'categories' || $type == '') {
          /** Get details for serach and videomore page */
          $this->getSearchCategoryVideos ( $type ) ;

        } else{
          /** Get details for other more pages */ 
          $moreResult = $this->getTypeOfVideos ( $type, $arguments ) ;
        }
        if ( !empty( $moreResult ) && isset( $moreResult )) {
          $TypeOFvideos   = $moreResult [0];
          $CountOFVideos  = $moreResult [1];
          $typename       = $moreResult [2];
          $type_name      = $moreResult [3];
          $morePage       = $moreResult [4];
          $dataLimit      = $moreResult [5];
        }
        if(isset($arguments ['cols'])){
        	$colF = $arguments ['cols'];
        }
        else{
        	$colF = $this->_colF;
        }
        $div        = '<div class="video_wrapper" id="' . $type_name . '_video"> <style type="text/css"> .video-block {  margin-left:' . $this->_settingsData->gutterspace . 'px !important; } </style>';
        /** Call function to display more video page title */ 
        $div        .= $this->morePageTitle ( $type_name, $typename );
        if (! empty ( $TypeOFvideos )) {
          $userId = get_current_user_id();
          $watchLaterVideoIds = getWatchLaterVideoIds($userId,$this->watchDetailsTable);
          $pagenum    = absint ( $this->_pagenum ) ? absint ( $this->_pagenum ) : 1;
          $videolist              = 0;
          foreach ( $TypeOFvideos as $video ) {
            $vidF [$videolist]      = $video->vid;
            $nameF [$videolist]     = $video->name;
            $hitcount [$videolist]  = $video->hitcount;
            $ratecount [$videolist] = $video->ratecount;
            $rate [$videolist]      = $video->rate;
            $duration [$videolist]  = $video->duration;
            $file_type              = $video->file_type;
            $guid [$videolist]      = get_video_permalink ( $video->slug );
            $imageFea [$videolist]  = getImagesValue ($video->image, $file_type, $video->amazon_buckets, '');
            if (! empty ( $this->_playid )) {
              $fetched [$videolist]       = $video->playlist_name;
              $fetched_pslug [$videolist] = $video->playlist_slugname;
              $playlist_id [$videolist]   = absint ( $this->_playid );
            } else {
              $getPlaylist = $this->_wpdb->get_row ( 'SELECT playlist_id FROM ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play WHERE media_id="' . intval ( $vidF [$videolist] ) . '"' );
              if (isset ( $getPlaylist->playlist_id )) {
                $playlist_id [$videolist]   = $getPlaylist->playlist_id;
                $fetPlay [$videolist]       = playlistDetails ($playlist_id [$videolist]);
                $fetched [$videolist]       = $fetPlay [$videolist]->playlist_name;
                $fetched_pslug [$videolist] = $fetPlay [$videolist]->playlist_slugname;
              }
            }
            $videolist ++;
          }
          $div .= '<div> <ul class="video-block-container">';
          /** Display thumbnails starts */
          for($videolist = 0; $videolist < count ( $TypeOFvideos ); $videolist ++) {
          	$videoId =  $TypeOFvideos[$videolist]->vid;
          	$playlistImg = APPTHA_VGALLERY_BASEURL.'images/playlist.png';
          	if(in_array($videoId,$watchLaterVideoIds)) {
          		$watchLaterImg = APPTHA_VGALLERY_BASEURL.'images/accepted.png';
          		$watchLaterTitle = 'Added to Watch Later';
          		$clickEvent='';
          	}
          	else {
          		$watchLaterImg = APPTHA_VGALLERY_BASEURL.'images/watchlater2.png';
          		$watchLaterTitle = 'Add to Watch Later';
          		$clickEvent = 'onclick="watchLater('.$videoId.',this)"';
          	}
            if (($videolist % $colF) == 0 && $videolist != 0) {
              $div    .= '</ul><div class="clear"></div><ul class="video-block-container">';
            }  
            /** Display thumb and duration */
            $div      .= '<li class="video-block"> <div  class="video-thumbimg"><a href="' . $guid [$videolist] . '" title="' . $nameF [$videolist] . '"><img src="' . $imageFea [$videolist] . '" alt="' . $nameF [$videolist] . '" class="imgHome" title="' . $nameF [$videolist] . '" /></a>';
            if (!empty($duration [$videolist]) && $duration [$videolist] != '0:00') {
              $div    .= '<span class="video_duration">' . $duration [$videolist] . '</span>';
            }
            $div    .= '<span class="watchlaterIcon" '.$clickEvent.' ><img class="watchlaterImg" style="width:24px !important;height:24px !important;" src="'.$watchLaterImg.'" title="'.$watchLaterTitle.'"></span>
                      	<span class="playlistIcon" data-vid = '.$videoId.'><img class="playlistIconImg" style="width:24px !important;height:24px !important;" src="'.$playlistImg.'" title="Add to playlist"></span>';
            /** Display duration ends and video title starts */
            $div      .= '</div> <div class="vid_info"><a href="' . $guid [$videolist] . '" title="' . $nameF [$videolist] . '" class="videoHname"><span>' . limitTitle ( $nameF [$videolist] ) . '</span></a>';
            /** Display playlist name starts here */
            if (! empty ( $fetched [$videolist] ) && ($this->_settingsData->categorydisplay == 1)) {
              $playlist_url   = get_playlist_permalink ( $this->_mPageid, $playlist_id [$videolist], $fetched_pslug [$videolist] );
              $div    .= '<a  class="playlistName"   href="' . $playlist_url . '"><span>' . $fetched [$videolist] . '</span></a>';
            }
            /** Rating starts here */
            if ($this->_settingsData->ratingscontrol == 1) {
              $div  .= getRatingValue ($rate [$videolist],$ratecount [$videolist],'');
            }
            /** Views starts here */
            if ($this->_settingsData->view_visible == 1) {
              $div .= displayViews ($hitcount [$videolist]);
            }
            $div       .= '</div></li>';
            /** Foreah ends */
          }
          $div         .= '</ul> </div> <div class="clear"></div>';
        } else {
          if ($type != 'search' && $type != 'categories' && $type != '') {
            if ($typename == 'Category') {
              /** Display no videos link for category page */
              $div     .= __ ( 'No', APPTHA_VGALLERY ) . '&nbsp;' . __ ( 'Videos', APPTHA_VGALLERY ) . '&nbsp;' . __ ( 'Under&nbsp;this&nbsp;Category', APPTHA_VGALLERY );
            } else {
              /** Display no videos link for other more pages */
              $div     .= __ ( 'No', APPTHA_VGALLERY ) . '&nbsp;' . $typename . '&nbsp;' . __ ( 'Videos', APPTHA_VGALLERY );
            }
          }
        }
        $div            .= '</div>';
        /** Pagination starts
         * Call helper function to get pagination values for more pages */
        if($dataLimit != 0) {
          $div .= paginateLinks ($CountOFVideos, $dataLimit, $pagenum, '', '' );
        }        
        return $div;
      }
    }   
  /** ContusMorePageView class ends */
  }
/** Check ContusMorePageView class is exist if ends */
} else {
  /** Display message ContusMorePageView exists */
  echo 'class ContusMorePageView already exists';
}
?>