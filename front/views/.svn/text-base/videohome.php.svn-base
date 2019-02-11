<?php
/**  
 * Video home and short code [videohome] view file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
global $playlistElement;
$playlistElement = 1;
/**
 * ContusHomeVideoView class is exist
 */
if (! class_exists ( 'ContusHomeVideoView' )) {
  /**
   * ContusHomeVideoView class is used to display category thumbs in home page
   *
   * @author user
   */
  class ContusHomeVideoView extends ContusVideoController {
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
     * ContusHomeVideoView constructor starts
     */
    public function __construct() {
      parent::__construct ();
      /**
       * Call plugin helper function
       * to get plugin settings
       * and more page id */
      $this->_settingsData    = getPluginSettings ();
      $this->_player_colors   = unserialize ( $this->_settingsData->player_colors );
      $this->_mPageid         = morePageID ();
      /** Get video id from request URL for home page */
      $this->_vId           = absint ( filter_input ( INPUT_GET, 'vid' ) );
      /** Get pid from request URL for home page */
      $this->_pId           = absint ( filter_input ( INPUT_GET, 'pid' ) );
      /** Get pagenum from request URL for home page */
      $this->_pagenum       = filter_input ( INPUT_GET, 'pagenum' );
      /** Get Category column count from settings */
      $this->_colCat        = $this->_settingsData->colCat;
      /** Get featured videos data */
      $this->_featuredvideodata = $this->home_featuredvideodata ();
      /** Get WordPress admin URL */
      $this->_site_url      = get_site_url ();
      /** Get WordPress site URL */
      $this->_siteURL       = home_url ();
      /** Set banner player swf path */
      $this->_bannerswfPath     = APPTHA_VGALLERY_BASEURL . 'hdflvplayer' . DS . 'hdplayer_banner.swf';
      /** Set plugin player swf path */
      $this->_swfPath           = APPTHA_VGALLERY_BASEURL . 'hdflvplayer' . DS . 'hdplayer.swf';
      /**
       * Get protocol URL,
       * uploads / videogallery
       * and plugin images directory path
       * from plugin helper
       */
      $this->_imagePath         = getImagesDirURL ();
      $this->_pluginProtocol    = getPluginProtocol ();
      $this->_uploadPath        = getUploadDirURL ();
    }
    
    /**
     * Function for get the video from category based.
     *
     * @global type $wpdb
     * @param type $CountOFVideos
     * @param type $TypeOFvideos
     * @param type $pagenum
     * @param type $dataLimit
     * @param type $category_page
     * @return $category_videos
     */
    function categorylist($CountOFVideos, $TypeOFvideos, $pagenum, $dataLimit, $category_page, $thumImageorder) {
      global $wpdb;
      $userId = get_current_user_id();
      $watchLaterVideoIds = getWatchLaterVideoIds($userId,$this->watchDetailsTable);
      $div       = '';
      /** Calculating page number for home page category videos */
      $pagenum   = isset ( $pagenum ) ? absint ( $pagenum ) : 1;
      $div       .= '<style scoped> .video-block { margin-left:' . $this->_settingsData->gutterspace . 'px !important;float:left;} </style>';
      foreach ( $TypeOFvideos as $catList ) {
        /** Get video details for particular playlist */
        $playLists      = getCatVideos($catList->pid, $dataLimit, $thumImageorder);
        /** Get count of home page category videos */
        $playlistCount  = count ( $playLists );    
        /** Get count of video assigned in this category. */
        $category_video = $wpdb->get_results ( 'SELECT * FROM ' . $wpdb->prefix . 'hdflvvideoshare_med2play as m LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist as p on m.playlist_id = p.pid
                                                      WHERE m.playlist_id=' . intval ( $catList->pid ) . ' AND p.is_publish=1' );
        /** Get count of videos for category */
        $video_count    = count ( $category_video );   
        /** Display home page category title */ 
        $div    .= '<div class="titleouter"> <h4 class="more_title">' . $catList->playlist_name . '</h4></div>';    
        if (! empty ( $playlistCount )) {
          $inc    = 1;
          /** Video container starts */
          $div    .= '<ul class="video-block-container">'; 
          /** Dsplay videos for category */
          foreach ( $playLists as $playList ) {
          	$this->watchLaterHelper($playList,$watchLaterVideoIds);
          	/** Display home cat thumb image */   
            $div .= '<li class="video-block"><div class="video-thumbimg"><a href="' . $this->guid . '"><img src="' . $this->imageFea . '" alt="" class="imgHome" title=""></a>';
            /** Display video duration */
            if ($this->duration) {
              $div  .= '<span class="video_duration">' . $this->duration . '</span>';
            }
            $div   .= '<span class="watchlaterIcon" '.$this->clickEvent.' ><img class="watchlaterImg" style="width:24px !important;height:24px !important;" src="'.$this->watchLaterImg.'" title="'.$this->watchLaterTitle.'"></span>
            		<span class="playlistIcon" data-vid = '.$this->videoId.'><img class="playlistIconImg" style="width:24px !important;height:24px !important;" src="'.$this->playlistImg.'" title="Add to playlist"></span>';
            
            /** Display home cat video name */ 
            $div  .= '</div><div class="vid_info"><a href="' . $this->guid . '" title="' . $playList->name . '" class="videoHname"><span>' .  limitTitle ( $playList->name ) . '</span></a>';
            /** Rating for home category video */
            if ($this->_settingsData->ratingscontrol == 1) {
              $div      .= getRatingValue ( $playList->rate, $playList->ratecount, '' );
            }
            /** Show views count for home page category videos */
            if ($this->_settingsData->view_visible == 1) {
              $div .= displayViews ( $playList->hitcount );
            }
            $div  .= '</div></li>';    
            if (($inc % $this->_colCat) == 0 && $inc != 0) {
              /** Column count */
              $div .= '</ul><div class="clear"></div><ul class="video-block-container">';
            }
            $inc ++;
          }
          $div    .= '</ul>';    
          /** Video category thumb based on gallery setting rows, cols */
          $colF       = $this->_settingsData->colCat;
          $rowF       = $this->_settingsData->rowCat;
          $CatLimit   = $colF * $rowF;    
          if ( $video_count > $CatLimit ) {
            /** Get more videos permalink for home cat videos */
            $more_playlist_link   = get_playlist_permalink ( $this->_mPageid, $catList->pid, $catList->playlist_slugname );
            /** Display more videos link for home categories */
            $div    .= '<a class="video-more" href="' . $more_playlist_link . '">' . __ ( 'More&nbsp;Videos', APPTHA_VGALLERY ) . '</a>';
          } else {
            $div    .= '<div align="clear"> </div>';
          }
        } else {
          /** If there is no video for category */
          $div    .= '<div class="titleouter">' . __ ( 'No Videos for this Category', APPTHA_VGALLERY ) . '</div>';
        }
      }    
      $div .= '<div class="clear"></div>'; 
      /** Check tha page is category page */   
      if ($category_page != 0) {
        /** Pagination starts
         * Call helper function to get pagination values for category videos */
        $div .= paginateLinks ($CountOFVideos, $category_page, $pagenum, '', '' );
      }
      return $div;
    }
  /** ContusHomeVideoView class ends */
  }
/** ContusHomeVideoView class is exist ends */
}

/** Check ContusVideoView class is exist  */
if (! class_exists ( 'ContusVideoView' )) {
  /**
   * ContusVideoView class is used to display home page player and thumbnails
   * 
   * @author user
   */
  class ContusVideoView extends ContusHomeVideoView {
      /**
       * Show video players
       */
      function home_player() {
          /** Varaiable Initialization for home page display */
          $videoUrl = $videoId = $thumb_image = $homeplayerData = $file_type = $baseref = $showplaylist = $windo = '';
          /** Get settings data from constructor */
          $settingsData   = $this->_settingsData;
          /** Get featured videos for home page player */
          if (! empty ( $this->_featuredvideodata [0] )) {
            $homeplayerData = $this->_featuredvideodata [0];
          }
          if (! empty ( $homeplayerData )) {
              /** Get home page player video details  */
              $videoId      = $homeplayerData->vid;
              $videoUrl     = $homeplayerData->file;
              $file_type    = $homeplayerData->file_type;
              $video_title  = $homeplayerData->name; 
              $thumb_image  = getImagesValue ($homeplayerData->image, $file_type, $homeplayerData->amazon_buckets, '');
          }
          /** Call query helper to detect mobile or browser */
          $mobile = vgallery_detect_mobile ();
          /** Home Page Player starts */
          $div      = '<div> <style type="text/css" scoped> .video-block {margin-left:' . $settingsData->gutterspace . 'px !important; float:left;} </style>';
          $div      .= ' <script> var baseurl = "' . $this->_site_url . '"; </script>';
          $baseref  .= '&amp;featured=true';
          if (! empty ( $this->_vId )) {
              $baseref  .= '&amp;vid=' . $this->_vId;
          }
          /** Show / hide the video title of the home page players */        
          $div      .= '<div id="mediaspace" class="mediaspace" style="color: #666;">';
          if (isset ( $this->_player_colors ['showTitle'] ) && $this->_player_colors ['showTitle']) {
              $div  .= '<script type="text/javascript">function current_video( vid, title ){ document.getElementById("video_title").innerHTML = title; }</script>';
              $div  .= '<h3 id="video_title" style="width:' . $settingsData->width . ';text-align: left;"  class="more_title">';
              /** Display for video title in mobile */
              if ( $mobile ) {
                  $div .= $video_title;
              }
              $div  .= '</h3>';
          }
          $div      .= '<div id="flashplayer" class="videoplayer">';
          /**
           * Check player is enabled
           * If yes then assgin plugin player path 
           * Else assign banner player path 
           */
          $swf      = $this->_swfPath;
          if ($settingsData->default_player == 1) {
              $swf            = $this->_bannerswfPath;
              $showplaylist   = '&amp;showPlaylist=true';
          }
          /** Check embed code method or not  */
          if ($file_type == 5 && ! empty ( $homeplayerData->embedcode )) {
              $div              .= str_replace ( 'width=', 'width="' . $settingsData->width . '"', stripslashes ( $homeplayerData->embedcode ) );
              $div              .= '<script> current_video( ' . $homeplayerData->vid . ',"' . $homeplayerData->name . '" ); </script>';
          } else {
            /** Check mobile device is detect */
            if ($mobile) {
                if ((preg_match ( '/vimeo/', $videoUrl )) && ($videoUrl != '')) {
                    /** Iframe code for vimeo videos */
                    $vresult    = explode ( '/', $videoUrl );
                    $div        .= '<iframe width="100%" height="' . $settingsData->height . '" type="text/html" src="' . $this->_pluginProtocol . 'player.vimeo.com/video/"' . $vresult [3] . '" frameborder="0"></iframe>';
                } elseif (strpos ( $videoUrl, 'youtube' ) > 0) {
                    /** Iframe code for youtube videos */
                    $videoId1   = getYoutubeVideoID ( $videoUrl );
                    $div='<div id="player"></div><script>var tag = document.createElement("script");tag.src = "https://www.youtube.com/iframe_api";var firstScriptTag = document.getElementsByTagName("script")[0];firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);var player;function onYouTubeIframeAPIReady() {player = new YT.Player("player", {width: "100%",videoId: "'.$videoId1.'",playerVars: {"rel": 0,"showinfo":0,"modestbranding":0},events: {"onStateChange": onPlayerStateChange}});}var done = false;function onPlayerStateChange(event) {if (event.data == YT.PlayerState.PLAYING && !done) {currentVideoP('.$videoId.');done = true;}}</script>';
                } elseif (strpos ( $videoUrl, 'dailymotion' ) > 0) { 
                    /** Iframe code for dailymotion videos */ 
                    $split_id = getDailymotionVideoID ( $videoUrl );
                    $video    = $this->_pluginProtocol . 'www.dailymotion.com/embed/video/' . $split_id [0];
                    $div ='<script src="http://api.dmcdn.net/all.js"></script><div id="player"></div><script>var player = DM.player(document.getElementById("player"),{video: "'.$split_id[0].'",width: "100%",params: {html: 0,wmode: "opaque"},events: {playing: function(){onPlayerStateChange();}}});var done = false;function onPlayerStateChange(){if (!done) {currentVideoP('.$videoId.');done = true;}}</script>';
                } else if (strpos ( $videoUrl, 'viddler' ) > 0) { 
                    /** Iframe code for viddler videos */ 
                    $imgstr     = explode ( '/', $videoUrl );
                    $div='<script type="text/javascript" src="//static.cdn-ec.viddler.com/js/arpeggio/v3/build/main-built.js"></script><div id="my-player"></div><script>var embed = new ViddlerEmbed({videoId: "'.$imgstr [4].'",width: "100%",target: "#my-player"});var done = false;embed.manager.events.on("videoPlayer:play", function() {if (!done) {currentVideoP('.$videoId.');done = true;}});</script>';
                } else {
                    if ($file_type == 4) { 
                        $streamer   = str_replace ( 'rtmp://', 'http://', $homeplayerData->streamer_path );
                        $videoUrl   = $streamer . '_definst_/mp4:' . $videoUrl . '/playlist.m3u8';
                    } else {
                        $videoUrl = getVideosValue ( $videoUrl, $file_type, $homeplayerData->amazon_buckets );
                    }
                    $div          .= '<video width="100%" height="' . $settingsData->height . '" id="video" poster="' . $thumb_image . '"   src="' . $videoUrl . '" autobuffer controls onerror="failed( event )">' . __ ( 'Html5 Not support This video Format.', APPTHA_VGALLERY ) . '</video>';
                }
            } else {
                /** If browser is detect then play videos via flash player using embed code */
                $div            .= '<embed id="player" src="' . $swf . '"  flashvars="baserefW=' . $this->_siteURL . $baseref . $showplaylist . '&amp;mtype=playerModule" width="' . $settingsData->width . '" height="' . $settingsData->height . '"   allowFullScreen="true" allowScriptAccess="always" type="application/x-shockwave-flash" wmode="transparent" />';
            }
          }
          $div        .= '</div>';
          /** Get user agent */
          $useragent  = $_SERVER ['HTTP_USER_AGENT'];
          if (strpos ( $useragent, 'Windows Phone' ) > 0) {
            $windo    = 'Windows Phone';
          }
          /** Section to notify not support video format */ 
          $div        .= '<script>  var txt =  navigator.platform ;  var windo = "' . $windo . '";  function failed( e ) { if( txt =="iPod"|| txt =="iPad" || txt == "iPhone" || windo=="Windows Phone" || txt == "Linux armv7l" || txt == "Linux armv6l" ) { alert( "' . __ ( 'Player doesnot support this video.', APPTHA_VGALLERY ) . '" ); } } </script>';
          $div        .= '<div id="video_tag" class="views"></div> </div>';
          return       $div . '</div>';
       }
      
      /**
       * Function to display  recent ,feature ,category and popular video in home page after player
       *  
       * @param unknown $type
       * @return Ambigous <$category_videos, string>|string
       */      
       function home_thumb($type) {
       	global $playlistElement;

        /** Check homeVideo function is exists */
        if (!function_exists ( 'homeVideo' )) {
          $TypeSet = $recent_video_order = $class = $divOutput = '';          
          $player_colors      = $this->_player_colors;
          $recent_video_order = $player_colors ['recentvideo_order'];
          /** Get popular, recent, featured  video settings status and row, column values
           * Get home page category video settings status and row, column values
           * Call function to display home page category videos */
          $where          = '';
          switch ($type) {
              case 'popular' : 
                $TypeSet        = $this->_settingsData->popular; 
                $rowF             = $this->_settingsData->rowsPop;
                $colF             = $this->_settingsData->colPop;
                $dataLimit        = $rowF *  $colF;
                $thumImageorder = 'w.hitcount DESC';
                $typename       = __ ( 'Popular', APPTHA_VGALLERY );
                $type_name      = $morePage = 'popular';
                break;            
              case 'recent' :
                $TypeSet        = $this->_settingsData->recent; 
                $rowF             = $this->_settingsData->rowsRec;
                $colF             = $this->_settingsData->colRec;
                $dataLimit        = $rowF *  $colF;
                $thumImageorder = 'w.vid DESC';
                $typename       = __ ( 'Recent', APPTHA_VGALLERY );
                $type_name      = $morePage = 'recent';
                break;            
              case 'featured' :
                $TypeSet          = $this->_settingsData->feature;
                $rowF             = $this->_settingsData->rowsFea;
                $colF             = $this->_settingsData->colFea;
                $dataLimit        = $rowF *  $colF;
                $where            = ' AND w.featured=1 ';              
                $thumImageorder   = getVideoOrder ( $recent_video_order );                 
                $typename         = __ ( 'Featured', APPTHA_VGALLERY );
                $type_name        =  $morePage = 'featured';
                break;            
              case 'cat' :
                if ($this->_settingsData->homecategory == 1) {
                  $category_page  = $this->_settingsData->category_page;
                  $rowF           = $this->_settingsData->rowCat;
                  $colF           = $this->_settingsData->colCat;
                  $dataLimit      = $rowF *  $colF;                
                  $thumImageorder = getVideoOrder ( $recent_video_order );
                  $typename       = __ ( 'Video Categories', APPTHA_VGALLERY );
                }
                break;
              default:
                break;
          }  
          if ($type == 'popular' ||  $type == 'recent' ||  $type == 'featured' ) {
              /** Get home page thumb data and get count of videos */
              $TypeOFvideos     = $this->home_thumbdata ( $thumImageorder, $where, $dataLimit );
              $CountOFVideos    = $this->countof_home_thumbdata ( $thumImageorder, $where );
          }
          if ($type == 'cat') {
              /** Get home page category thumb data and get count of videos */
              $TypeOFvideos   = $this->home_categoriesthumbdata ( $this->_pagenum, $category_page );
              $CountOFVideos  = getPlaylistCount ();
              /** Call function to display category videos in home page */
              return $this->categorylist ( $CountOFVideos, $TypeOFvideos, $this->_pagenum, $dataLimit, $category_page, $thumImageorder );
          }
          if ( $TypeSet ) { 
              /** Display thumbnail block strats */
              $divOutput      = '<div class="video_wrapper" id="' . $type_name . '_video">';
              $divOutput      .= '<style type="text/css" scoped> .video-block {margin-left:' . $this->_settingsData->gutterspace . 'px !important;float:left;}  </style>';
              
              if (! empty ( $TypeOFvideos )) {
              	$userId = get_current_user_id();
              	$watchLaterVideoIds = getWatchLaterVideoIds($userId,$this->watchDetailsTable);
                  /** Display videos title in home page */ 
                  $divOutput .= '<h2 class="video_header">' . $typename . ' ' . __ ( 'Videos', APPTHA_VGALLERY ) . '</h2>';
                  $videolist = 0;
                    foreach ( $TypeOFvideos as $video ) {
                      /** Get video duration, image, filetype, slug, video id,
                       * video name, view and rate count */
                      $videoId                    = $video->vid;
                      $duration [$videolist]      = $video->duration;
                      $file_type                  = $video->file_type;
                      $guid [$videolist]          = get_video_permalink ( $video->slug );
                      $imageFea [$videolist]      = getImagesValue ($video->image, $file_type, $video->amazon_buckets, '');
                      $nameF [$videolist]         = $video->name;
                      $ratecount [$videolist]     = $video->ratecount;
                      $rate [$videolist]          = $video->rate;
                      $hitcount [$videolist]      = $video->hitcount;
                      /** Get playlist id, name and slugname */
                      $playlist_id [$videolist]   = $video->pid;
                      $fetched [$videolist]       = $video->playlist_name;
                      $fetched_pslug [$videolist] = $video->playlist_slugname;                      
                      $videolist ++;
                  }        
       
                  /** Code to display thumbs for popular / recent and featured videos */
                  $divOutput    .= '<div class="video_thumb_content">';
                  $divOutput    .= '<ul class="video-block-container">';
                  $playlistImg = APPTHA_VGALLERY_BASEURL.'images/playlist.png';
                  $playlistCreateImg = APPTHA_VGALLERY_BASEURL.'images/playlist_create.png';
                  $playlistSearchImg = APPTHA_VGALLERY_BASEURL.'images/playlist_search.png';
                  /** Display video list container */
                  for($videolist = 0; $videolist < count ( $TypeOFvideos ); $videolist ++) {  
                  	$videoId =  $TypeOFvideos[$videolist]->vid;
                  	if(in_array($videoId,$watchLaterVideoIds)) {
                  		$watchLaterImg = APPTHA_VGALLERY_BASEURL.'images/accepted.png';
                  		$watchLaterTitle = 'Added to Watch Later';
                	}
                  	else {
                  		$watchLaterImg = APPTHA_VGALLERY_BASEURL.'images/watchlater2.png';
                  		$watchLaterTitle = 'Add to Watch Later';
                  		$clickEvent = 'onclick="watchLater('.$videoId.',this)"';
                  	}
                  	$class = '<div class="clear"></div>';                      
                      if (($videolist % $colF) == 0 && $videolist != 0) { 
                        $divOutput  .= '</ul><div class="clear"></div><ul class="video-block-container">';
                      }                      
                      $divOutput    .= '<li class="video-block">';
                      /** Video thumb image display block starts */
                      $divOutput    .= '<div  class="video-thumbimg"><a href="' . $guid [$videolist] . '"><img src="' . $imageFea [$videolist] . '" alt="' . $nameF [$videolist] . '" class="imgHome" title="' . $nameF [$videolist] . '" /></a>';
                      if ($duration [$videolist]) {
                        $divOutput  .= '<span class="video_duration" >' . $duration [$videolist] . '</span>';
                      }
                      $divOutput    .= '
                      		<span class="watchlaterIcon" '.$clickEvent.' ><img class="watchlaterImg" style="width:24px !important;height:24px !important;" src="'.$watchLaterImg.'" title="'.$watchLaterTitle.'"></span>
                      		<span class="playlistIcon" data-vid = '.$videoId.'><img class="playlistIconImg" style="width:24px !important;height:24px !important;" src="'.$playlistImg.'" title="Add to playlist"></span>';		
  
                      /** Display video details block starts */
                      $divOutput    .= '</div><div class="vid_info"><a title="' . $nameF [$videolist] . '" href="' . $guid [$videolist] . '" class="videoHname"><span>' . limitTitle ( $nameF [$videolist] ) . '</span></a>';
                      $divOutput    .= '';
                      if ($fetched [$videolist] != '' && ($this->_settingsData->categorydisplay == 1)) {
                        $playlist_url   = get_playlist_permalink ( $this->_mPageid, $playlist_id [$videolist], $fetched_pslug [$videolist] );
                        /** Display output videos */
                        $divOutput            .= '<a class="playlistName"  href="' . $playlist_url . '"><span>' . $fetched [$videolist] . '</span></a>';
                      }
                      /** Display rating for video home page */
                      if ($this->_settingsData->ratingscontrol == 1) {
                          $divOutput        .= getRatingValue ( $rate [$videolist], $ratecount [$videolist] , '' );
                      }
                      /** Display views for video home page */
                      if ($this->_settingsData->view_visible == 1) {
                        $divOutput          .= displayViews ( $hitcount [$videolist] );
                      }
                      /** Display video details block ends */ 
                      $divOutput .= '</div> </li>';
                  }
                  $divOutput     .= '</ul></div> <div class="clear"></div>';
                  /** Code to display more videos link for featured / popular/ recent videos */
                  if ($dataLimit < $CountOFVideos) { 
                      $more_videos_link = get_morepage_permalink ( $this->_mPageid, $morePage );
                      /** Display more title for category */
                      $divOutput    .= '<span class="more_title" ><a class="video-more" href="' . $more_videos_link . '">' . __ ( 'More&nbsp;Videos', APPTHA_VGALLERY ) . '&nbsp;&#187;</a></span>';
                      $divOutput    .= '<div class="clear"></div>';
                  } 
                  /** View more to the right */
                  if ($dataLimit == $CountOFVideos) {
                      $divOutput    .= '<div style="float:right"></div>';
                  }
              } else {
                $divOutput    .= __ ( 'No', APPTHA_VGALLERY ) . ' ' . $typename . ' ' . __ ( 'Videos', APPTHA_VGALLERY );
              }
              $divOutput    .= '</div>';
          }          
 
          return $divOutput;
        }
      } 
  /** End contusVideo class */ 
  } 
/** ContusVideoView class is exist */
} else {
  echo 'class ContusVideoView already exists';
}
?>