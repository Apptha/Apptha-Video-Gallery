<?php
/**  
 * Video more view file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Check ContusMoreView class is exist */
if ( !class_exists ( 'ContusMoreView' )) {
  /**
   * ContusMoreView class is used to display home page player and thumbnails
   *
   * @author user
   */
  class ContusMoreView extends ContusMoreController {   
    /**
     * ContusMoreView constructor starts
     */
    public function __construct() {
        parent::__construct ();
        global $wp_query;
        /**
         * Call plugin helper function
         * to get plugin settings
         * and more page id 
         * for more pages
         */
        $this->_settingsData          = getPluginSettings (); 
        $this->_player_colors         = unserialize ( $this->_settingsData->player_colors );
        $this->_recent_video_order    = $this->_player_colors ['recentvideo_order'];
        $this->_mPageid       = morePageID ();
        /**
         * Get video id , playlist id,
         * page number and userid
         * from request URL
         */
        $this->_vId           = absint ( filter_input ( INPUT_GET, 'vid' ) ); 
        $this->_pagenum       = absint ( filter_input ( INPUT_GET, 'pagenum' ) ); 
        $this->_playid        = &$wp_query->query_vars ['playid'];
        $this->_userid        = &$wp_query->query_vars ['userid'];
        /** Get search keyword */ 
        $searchVal            = str_replace ( ' ', '%20', __ ( 'Video Search ...', APPTHA_VGALLERY ) );
        if(!empty($wp_query->query_vars) && isset($wp_query->query_vars ['video_search'])) {
            $video_search         = $wp_query->query_vars ['video_search'];
            if ($video_search !== $searchVal) {
                $video_search       = $video_search;
            } else {
                $video_search       = '';
            }
            /** Get serach value */
            $this->_video_search  = stripslashes ( urldecode ( $video_search ) );
        }
        /**
         * Get row, column for more
         * videos from settings
         */        
        $this->_rowF          = $this->_settingsData->rowMore;
        $this->_colF          = $this->_settingsData->colMore; 
        $this->_perMore       = $this->_rowF * $this->_colF;
        /**
         * Get row, column for category 
         * videos from settings
         * and calculate total values
         */
        $this->_colCat        = $this->_settingsData->colCat; 
        $this->_rowCat        = $this->_settingsData->rowCat; 
        $this->_perCat        = $this->_colCat * $this->_rowCat;
        /**
         * Get plugin images directory path
         * and upload path 
         * from plugin helper
         */
        $this->_imagePath     = getImagesDirURL();
    }   
    
    /**
     * Function to get videos for 
     * recent, feature, random, popular,
     * user and category page     
     *
     * @parem   $type     
     */
    function getTypeOfVideos ( $type, $arguments ) {
        $type_name  = $TypeOFvideos = $CountOFVideos = $typename = $morePage = $where = '';
        /** Check if short code is uesed */
        if (isset ( $arguments ['rows'] ) && isset ( $arguments ['cols'] )) {
          /** Get row, column value from shortcode */
            $dataLimit    = $arguments ['rows'] * $arguments ['cols'];
        } else if ( $type == 'cat') {
          /** Check the page is category page */
          /** Get datalimit for category page from settings */ 
            $dataLimit      = $this->_perCat;
        } else {
          /** Get data limit for more pages from settings */
            $dataLimit      = $this->_perMore;
        }
        /** Get recent video order */
        $default_order  = getVideoOrder ( $this->_recent_video_order );
        switch ($type) {
            case 'popular' :
                $thumImageorder = ' w.hitcount DESC ';
                $typename       = __ ( 'Popular', APPTHA_VGALLERY );
                $type_name      = 'popular';
                $morePage       = '&more=pop';
                $TypeOFvideos   = $this->home_thumbdata ( $thumImageorder, $where, $this->_pagenum, $dataLimit );
                $CountOFVideos  = $this->countof_videos ( '', '', $thumImageorder, $where );
                break;
            case 'recent' :
                $typename       = __ ( 'Recent', APPTHA_VGALLERY );
                $thumImageorder = ' w.vid DESC ';
                $type_name      = 'recent';
                $morePage       = '&more=rec';
                $TypeOFvideos   = $this->home_thumbdata ( $thumImageorder, $where, $this->_pagenum, $dataLimit );
                $CountOFVideos  = $this->countof_videos ( '', '', $thumImageorder, $where );
                break;
            case 'random' :
                $thumImageorder = ' rand() ';                
                $type_name      = 'random';
                $typename       = __ ( 'Random', APPTHA_VGALLERY );
                $morePage       = '&more=rand';
                $TypeOFvideos   = $this->home_thumbdata ( $thumImageorder, $where, $this->_pagenum, $dataLimit );
                $CountOFVideos  = $this->countof_videos ( '', '', $thumImageorder, $where );
                break;
            case 'featured' :
                $where          = 'AND w.featured=1';
                $thumImageorder = getVideoOrder ( $this->_recent_video_order );
                $typename       = __ ( 'Featured', APPTHA_VGALLERY );
                $morePage       = '&more=fea';
                $type_name      = 'featured';
                $TypeOFvideos   = $this->home_thumbdata ( $thumImageorder, $where, $this->_pagenum, $dataLimit );
                $CountOFVideos  = $this->countof_videos ( '', '', $thumImageorder, $where );
                break;
            case 'cat' : 
                $thumImageorder = absint ( $this->_playid );
                $typename       = __ ('Category', APPTHA_VGALLERY );
                $type_name      = 'Category';
                $morePage       = '&playid=' . $thumImageorder;
                $TypeOFvideos   = $this->home_catthumbdata ( $thumImageorder, $this->_pagenum, $dataLimit, $default_order );
                $CountOFVideos  = $this->countof_videos ( absint ( $this->_playid ), '', $thumImageorder, $where );
                break;
            case 'playlist' :
               	$thumImageorder = absint ( $this->_playid );
               	$typename       = __ ('Playlist', APPTHA_VGALLERY );
               	$type_name      = 'Playlist';
               	$morePage       = '&playid=' . $thumImageorder;
               	$TypeOFvideos   = $this->home_playlistthumbdata( $thumImageorder, $this->_pagenum, $dataLimit, $default_order );
               	$CountOFVideos  = $this->home_countplaylistthumbdata ( $thumImageorder );
               	break;
            case 'user' : 
                $thumImageorder = $this->_userid;            
                $typename       = __ ('User', APPTHA_VGALLERY );
                $type_name      = 'User';
                $morePage       = '&userid=' . $thumImageorder;
                $TypeOFvideos   = $this->home_userthumbdata ( $thumImageorder, $this->_pagenum, $dataLimit );
                $CountOFVideos  = $this->countof_videos ( '', $this->_userid, $thumImageorder, $where );
                break;
            default: break;
        } 
        /** Return video details for more pages */
        return array ( $TypeOFvideos, $CountOFVideos, $typename, $type_name, $morePage, $dataLimit );
    }
}
/** Check ContusMoreView class is exist if ends */
} else {
  /** Display contusMore exists message */
  echo 'class contusMore already exists';
}
    
/** This class is used to get category and search results 
 * Display the category page results
 */ 
class MoreCategoryView extends ContusMoreView {
	/**
	 * Include videoHelper trait to include commonly used function for watch later functinality
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
    /**
     * Function to get videos for search 
     * and more videos page
     *
     * @parem   $type
     */
    function getSearchCategoryVideos ( $type ) {
       /** Get current page number for search, video more pages */
        $pagenum        = $this->_pagenum;
        if (empty ( $pagenum )) {
          $pagenum      = 1;
        }
        /** Check hether the page is videomore page or search page */
        switch ($type) {   
          case 'search' :
            $dataLimit      = $this->_perMore;
            $thumImageorder   = str_replace ( '%20', ' ', $this->_video_search );
            if ($this->_video_search == __ ( 'Video Search ...', APPTHA_VGALLERY )) {
                $thumImageorder = '';
            }
            $TypeOfSearchvideos   = $this->home_searchthumbdata ( $thumImageorder, $pagenum, $dataLimit );
            $CountOfSearchVideos  = $this->countof_videosearch ( $thumImageorder );
            break;
          case 'categories' :
          default :
            $dataLimit      = $this->_perCat;        
            $default_order  = getVideoOrder ( $this->_recent_video_order );            
            $TypeOfCatvideos   = $this->home_categoriesthumbdata ( $pagenum, $dataLimit );
            $CountOfCatVideos  = getPlaylistCount ();
            break;
        }
        /** Check current page is search page */
        if ($type == 'search') {
          /** Call function to display search results */ 
            return $this->searchlist ( $thumImageorder, $CountOfSearchVideos, $TypeOfSearchvideos, $this->_pagenum, $dataLimit );
        } else if ($type == 'categories') {
          /** Call function to display videomore results */
            return $this->categorylist ( $CountOfCatVideos, $TypeOfCatvideos, $this->_pagenum, $dataLimit, $default_order );
        } else {
            return $this->categorylist ( $CountOfCatVideos, $TypeOfCatvideos, $this->_pagenum, $dataLimit, $default_order );
        }
    }
      
    /**
     * Function to display category thumbs 
     * 
     * @param unknown $CountOfCatVideos
     * @param unknown $TypeOfCatvideos
     * @param unknown $pagenum
     * @param unknown $dataLimit
     * @param unknown $default_order
     * @return string
     */
    function categorylist($CountOfCatVideos, $TypeOfCatvideos, $pagenum, $dataLimit, $default_order) {
        global $wpdb;
        $userId = get_current_user_id();
        $watchLaterVideoIds = getWatchLaterVideoIds($userId,$this->watchDetailsTable);
        $div        = '';
        /** Calculating page number for category videos */
        $pagenum    = absint ( $pagenum ) ? absint ( $pagenum ) : 1; 
        $div        .= '<style> .video-block { margin-left:' . $this->_settingsData->gutterspace . 'px !important; } </style>';
        foreach ( $TypeOfCatvideos as $catList ) { 
            /** Fetch videos for every category
             * Get more page id */ 
            $playLists      = getCatVideos ($catList->pid, $dataLimit,  $default_order);
            $moreName       = morePageID ();
            $playlistCount  = count ( $playLists );
            $div      .= '<div class="titleouter"> <h4 class="clear more_title">' . $catList->playlist_name . '</h4></div>';
            if (! empty ( $playlistCount )) {
                $i      = 0;
                $inc    = 1;
                $div    .= '<ul class="video-block-container">';
                foreach ( $playLists as $playList ) {
                	$this->watchLaterHelper($playList,$watchLaterVideoIds);
                    /** To display the category videos thumb image and video duration  */
                    $div    .= '<li class="video-block"><div class="video-thumbimg"><a href="' . $this->guid . '" title="' . $playList->name . '" ><img src="' . $this->imageFea . '" alt="" class="imgHome" title="" /></a>';

                 if (!empty($this->duration) && $this->duration != '0:00') {
                        $div  .= '<span class="video_duration">' . $this->duration . '</span>';
                    }
                    $div     .= '<span class="watchlaterIcon" '.$this->clickEvent.' ><img class="watchlaterImg" style="width:24px !important;height:24px !important;" src="'.$this->watchLaterImg.'" title="'.$this->watchLaterTitle.'"></span>
                    		    <span class="playlistIcon" data-vid = '.$this->videoId.'><img class="playlistIconImg" style="width:24px !important;height:24px !important;" src="'.$this->playlistImg.'" title="Add to playlist"></span>';
                    /** To display playlist name as linkable */
                    $div    .= '</div><div class="vid_info"><h5><a href="' . $this->guid . '" class="videoHname" title="' . $playList->name . '">' . limitTitle ( $playList->name ) . '</a></h5>';                  
                    if ($this->_settingsData->categorydisplay == 1) {
                        $div  .= '<a class="playlistName" href="' . $playlist_more_link . '"><span>' . $catList->playlist_name . '</span></a>';
                    }
                    if ($this->_settingsData->ratingscontrol == 1) {
                       /** Rating starts here
                        * for category videos */
                        $div  .= getRatingValue ( $playList->rate, $playList->ratecount, '' ); 
                    }
                    
                    /** Views starts here for category videos */ 
                    if ($this->_settingsData->view_visible == 1) {
                        $div  .= displayViews($playList->hitcount); 
                    }                    
                    $div   .= '</div></li>';
                    if ($i > ($this->_perCat - 2)) {
                      break;
                    } else {
                        $i = $i + 1;
                    }
                    if (($inc % $this->_colCat) == 0 && $inc != 0) { 
                        $div  .= '</ul><div class="clear"></div><ul class="video-block-container">';
                    }
                    $inc ++;
                }
                $div      .= '</ul>';
                /** Calculate datalimit for video more page */
                if ( $this->_rowCat && $this->_colCat ) {
                    $dataLimit = $this->_perCat;
                } else if ( $this->_rowCat || $this->_colCat ) {
                  $dataLimit = '';
                } else {
                    $dataLimit = 8;
                }
                /** Display more videos link for category thumbs  */
                if (($playlistCount > $dataLimit)) {
                    $div .= '<a class="video-more" href="' . $playlist_more_link . '">' . __ ( 'More&nbsp;Videos', APPTHA_VGALLERY ) . '</a>';
                } else {
                    $div .= '<div align="clear"> </div>';
                }
            } else {
                /** If there is no video for category */
                $div .= '<div class="titleouter">' . __ ( 'No&nbsp;Videos&nbsp;for&nbsp;this&nbsp;Category', APPTHA_VGALLERY ) . '</div>';
            }
        }      
        $div .= '<div class="clear"></div>';
        /** Pagination starts - Call helper function to get pagination values for categories */
        if($dataLimit != 0) { 
            $div .= paginateLinks ($CountOfCatVideos, $dataLimit, $pagenum, '', '' );
        }  
        /** Pagination ends */
        /** Display videmore page content */       
        echo $div;
    }     
} 


/**
 *  This class is used to display the search page results
 */
class MoreSearchView extends MoreCategoryView {
  /**
   * Include videoHelper trait to include commonly used function for watch later functinality
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
  /**
   * Function to display search results
   *
   * @param unknown $video_search
   * @param unknown $CountOfSearchVideos
   * @param unknown $TypeOfSearchvideos
   * @param unknown $pagenum
   * @param unknown $dataLimit
   * @return string
   */
  function searchlist($video_search, $CountOfSearchVideos, $TypeOfSearchvideos, $pagenum, $dataLimit) {
    $div        = '';
    $userId = get_current_user_id();
    $watchLaterVideoIds = getWatchLaterVideoIds($userId,$this->watchDetailsTable);
    /**
     * Calculating page number
     * for search videos
     */
    $pagenum    = isset ( $pagenum ) ? absint ( $pagenum ) : 1;
    $div        .= '<div class="video_wrapper" id="video_search_result"><h3 class="entry-title">' . __ ( 'Search Results', APPTHA_VGALLERY ) . ' - ' . $video_search . '</h3>';
    $div        .= '<style> .video-block { margin-left:' . $this->_settingsData->gutterspace . 'px !important; } </style>';
    /** Fetch videos based on search  */
    if (! empty ( $TypeOfSearchvideos )) {
      $inc    = 0;
      $div    .= '<ul class="video-block-container">';
      foreach ( $TypeOfSearchvideos as $playList ) {
      	$this->watchLaterHelper($playList,$watchLaterVideoIds);         
        if (($inc % $this->_colF) == 0 && $inc != 0) {
          /** Column count for search page */
          $div  .= '</ul><div class="clear"></div><ul class="video-block-container">';
        }
        /** Display search videos
         * thumb and duration */
        $div    .= '<li class="video-block"><div class="video-thumbimg"><a href="' . $this->guid . '" title="' . $playList->name . '"><img src="' . $this->imageFea . '" alt="" class="imgHome" title="" /></a>';
        if (!empty($this->duration) && $this->duration != '0:00') {
          $div .= '<span class="video_duration">' . $this->duration . '</span>';
        }
        $div   .= '<span class="watchlaterIcon" '.$this->clickEvent.' ><img class="watchlaterImg" style="width:24px !important;height:24px !important;" src="'.$this->watchLaterImg.'" title="'.$this->watchLaterTitle.'"></span>
        		   <span class="playlistIcon" data-vid = '.$this->videoId.'><img class="playlistIconImg" style="width:24px !important;height:24px !important;" src="'.$this->playlistImg.'" title="Add to playlist"></span>';
  
        /** Display video title, playlist name and link  */
        $div    .= '</div><div class="vid_info"><a href="' . $this->guid . '" class="videoHname" title="' . $playList->name . '" >' . limitTitle ( $playList->name ) . '</a>';
        if (! empty ( $playList->playlist_name )) {
          $playlist_url = get_playlist_permalink ( $this->_mPageid, $playList->pid, $playList->playlist_slugname );
          $div  .= '<a class="playlistName" href="' . $playlist_url . '">' . $playList->playlist_name . '</a>';
        }
        /** Rating starts here
         * for search videos */
        if ($this->_settingsData->ratingscontrol == 1) {
          $div  .= getRatingValue( $playList->rate, $playList->ratecount, '' );
        }
        if ($this->_settingsData->view_visible == 1) {
          /** Views starts here
           * for search videos */
          $div    .= displayViews ( $playList->hitcount );
        }
        $div .= '</div></li>';
        $inc ++;
      }
      $div  .= '</ul>';
    } else {
      /** If there is no video
       * for search result */
      $div  .= '<div>' . __ ( 'No&nbsp;Videos&nbsp;Found', APPTHA_VGALLERY ) . '</div>';
    }
    $div .= '</div> <div class="clear"></div>';
    /** Pagination starts
     * Call helper function
     * to get pagination values */
    if($dataLimit != 0) {
      $div .= paginateLinks ($CountOfSearchVideos, $dataLimit, $pagenum, '', '' );
    }
    echo $div;
    /** Search result function ends  */
  }
}
?>