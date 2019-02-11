<?php
/**
 * Video detail page view file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
/**
 * Check ContusRelatedVideoView class exists
 */
if (! class_exists ( 'ContusRelatedVideoView' )) {
  /**
   * ContusRelatedVideoView class
   * 
   * @author user
   */
  class ContusRelatedVideoView extends ContusSocialCommentView {
    /**
     * Function to display related videos slider in video detail page
     * 
     * @param unknown $vid
     * @param unknown $video_playlist_id
     * @param unknown $pluginflashvars
     * @param unknown $width
     * @param unknown $height
     * @return string
     */
    public function relatedVideoSlider ( $vid, $video_playlist_id, $pluginflashvars, $width, $height, $videodivId) {
      global $wpdb;
      $reavideourl = $player_div = $result = $output = '';
      $related1 = array  ();
      /** Get related videos count */
      $Limit    = get_related_video_count ();
      /** Check related videos count. If it is empty then assign default value as 100 */
      if (empty ( $Limit )) {
      	/** set limit as 100 */
        $Limit  = 100;
      } 
      /** Get video details for the current video id from helper */
      $vidDetails = videoDetails ( $vid, 'related' );
      if (! empty ( $vidDetails )) {
        $related1 = array ( $vidDetails );
        /** Get related videos for the given video id */
        $related = $this->relatedVideosDetails ( $related1 [0]->vid, $video_playlist_id, $Limit );
        /** Merge the current video, related video details */
        $related = array_merge ( $related1, $related );
      }
      if (! empty ( $related )) {
        $result = count ( $related );
      }
      if ($result < 4) {
        $output .= '<style>.jcarousel-next , .jcarousel-prev {display:none!important;}</style>';
      }
      /** Display related videos in slider */
      $output   .= '<div class="player_related_video"><h2 class="related-videos">' . __ ( 'Related Videos', APPTHA_VGALLERY ) . '</h2><div style="clear: both;"></div>';
      if ($result != '') {
        /** Slide display starts here */
        $output .= '<ul id="mycarousel" class="jcarousel-skin-tango">';
        /** Check for mobile platform */
        $mobile     = vgallery_detect_mobile ();
        /** Looping related video details */
        foreach ( $related as $relFet ) {
          $file_type  = $relFet->file_type;
          /** Get featured images list */
          $imageFea   = getImagesValue ($relFet->image, $file_type, $relFet->amazon_buckets, '');
          $reafile    = $relFet->file;
          $guid       = get_video_permalink ( $relFet->slug );
          /** Embed player code in detail page
           * Get width and height for player */
          if ($file_type == 5 && ! empty ( $relFet->embedcode )) {
          	/** Embed code for fearured 
          	 * Width for related videos */
            $relFetembedcode    = stripslashes ( $relFet->embedcode );
            $relFetiframewidth  = preg_replace ( array ( '/width="\d+"/i' ), array ( sprintf ( 'width="%d"', $width ) ), $relFetembedcode );
            if ($mobile === true) {
              /** Embed code type for mobile view */
              $player_values  = htmlentities ( $relFetiframewidth );
            } else {
              $player_values  = htmlentities ( preg_replace ( array ( '/height="\d+"/i' ), array ( sprintf ( 'height="%d"', $height ) ), $relFetiframewidth ) );
            }
          } else {
            /** Code for mobile device */
            if ($mobile) {
              /** Check for youtube video  */
              if ((strpos ( $reafile, 'youtube' ) > 0 )) {
                $reavideourl  = 'http://www.youtube.com/embed/' . getYoutubeVideoID ( $reafile );
                /** Generate youtube embed code for html5 player */
                $player_values = htmlentities ( '<iframe  width="100%" type="text/html" src="' . $reavideourl . '" frameborder="0"></iframe>' );
              } else if ($file_type != 5) {
                /** Check for upload, URL and RTMP videos */
                switch ( $file_type ) {
                  case 2:
                    $reavideourl = $this->_uploadPath . $reafile;
                    break;
                  case 4:
                    $streamer = str_replace ( 'rtmp://', 'http://', $media->streamer_path );
                    $reavideourl = $streamer . '_definst_/mp4:' . $reafile . '/playlist.m3u8';
                    break;
                  default: break;
                }
                /** Generate video code for html5 player */
                $player_values = htmlentities ( '<video width="100%" id="video" poster="' . $imageFea . '"   src="' . $reavideourl . '" autobuffer controls onerror="failed( event )">' . $htmlplayer_not_support . '</video>' );
              } else {
                $player_values = '';
              }
            } else {
              /** Flash player code */
              $player_values   = htmlentities ( '<embed src="' . $this->_swfPath . '" flashvars="' . $pluginflashvars . '&amp;mtype=playerModule&amp;vid=' . $relFet->vid . '" width="' . $width . '" height="' . $height . '" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" wmode="transparent">' );
            }
          }
          /** Check the post type is videogallery page */
          if ($this->_post_type === APPTHAVIDEOGALLERY || $this->_page_post_type === APPTHAVIDEOGALLERY) {
            $thumb_href   = 'href="' . $guid . '"';
          } else {
            $player_div   = 'mediaspace';
            $embedplayer  = "videogallery_change_player( '$player_values',$videodivId,'$player_div',$file_type,$relFet->vid,'$relFet->name' )";
            $thumb_href   = 'href="javascript:void( 0 );" onclick="' . $embedplayer . '"';
          }
          $output .= '<li><div  class="imgSidethumb"><a  title="' . $relFet->name . '" ' . $thumb_href . '><img src="' . $imageFea . '" alt="' . $relFet->name . '" class="related" /></a></div>';
          /** Display title under thumbnails */
          $output .= '<div class="vid_info"><span><a ' . $thumb_href . ' class="videoHname" title="' . $relFet->name . '">' . limitTitle ($relFet->name) . '</a></span></div>';
          $output .= '</li>';
        }
        $output .= '</ul>';
        /** Slide display ends here and if ends */
      }
      return $output . '</div>';
    }
    /** Check ContusRelatedVideoView class ends */
  }
/** Check ContusRelatedVideoView class exists if ends */  
}


/** Check ContusVideoDetailRatingView class exists */
if (! class_exists ( 'ContusVideoDetailRatingView' )) {
    /**
     * ContusVideoDetailRatingView class
     * 
     * @author user
     */
    class ContusVideoDetailRatingView extends ContusRelatedVideoView {
      /**
       * Function to display ratings in video detail page
       *
       * @param unknown $ratestar
       * @param unknown $ratecount
       * @param unknown $videodivId
       * @param unknown $vid
       * @param unknown $videoId
       * @return string
       */
      function displayRatings($ratestar, $ratecount, $videodivId, $vid, $videoId) {
        $output = NULL;
        /** Display rating content */
        $output   .= '<div class="video-page-rating">
                                    <div class="centermargin floatleft" >
                                        <div class="rateimgleft" id="rateimg" onmouseover="displayRating( 0 );" onmouseout="resetValue(' . $ratecount . ');" >
                                            <div id="a' . $videodivId . $vid . '" class="floatleft"></div>
                                            <ul class="ratethis " id="rate' . $videodivId . $vid . '" >
                                                <li class="one" >
                                                    <a title="1 Star Rating"  onclick="getRating( 1 );"  onmousemove="displayRating( 1 );" onmouseout="resetValue(' . $ratecount . ');">1</a>
                                                </li>
                                                <li class="two" >
                                                    <a onclick="getRating( 2 );"  title="2 Star Rating" onmousemove="displayRating( 2 );" onmouseout="resetValue(' . $ratecount . ');">2</a>
                                                </li>
                                                <li class="three" >
                                                    <a title="3 Star Rating" onmousemove="displayRating( 3 );" onclick="getRating( 3 );" onmouseout="resetValue(' . $ratecount . ');">3</a>
                                                </li>
                                                <li class="four" >
                                                    <a  title="4 Star Rating" onclick="getRating( 4 );" onmouseout="resetValue(' . $ratecount . ');" onmousemove="displayRating( 4 );">4</a>
                                                </li>
                                                <li class="five" >
                                                    <a title="5 Star Rating" onmouseout="resetValue(' . $ratecount . ');" onclick="getRating( 5 );"  onmousemove="displayRating( 5 );" >5</a>
                                                </li>
                                            </ul>
                                            <input type="hidden" name="videoid" id="videoid' . $videodivId . $vid . '" value="' . $vid . '" />
                                            <input type="hidden" value="" id="storeratemsg' . $videodivId . $vid . '" />
                                        </div>
                                        <div class="rateright-views floatleft" >
                                            <span  class="clsrateviews"  id="ratemsg' . $videodivId . $vid . '" onmouseover="displayRating( 0 );" onmouseout="resetValue(' . $ratecount . ');"> </span>
                                            <span  class="rightrateimg" id="ratemsg1' . $videodivId . $vid . '" onmouseover="displayRating( 0 );" onmouseout="resetValue(' . $ratecount . ');">  </span>
                                        </div>
                                    </div>
                                </div> ';
        $output   .= '<div class="clear"></div>'; 
        /** Assign site url into script variable */
        /** Assign videodiv id into script variable */
        /** Assign video id into script variable */
        $output   .= '<script type="text/javascript">
              var baseurl = "' . $this->_site_url . '";
              var adminurl = "' . admin_url() . '";
              var videodiv = "'. $videodivId .'";
              var videoid = "' . $vid . '";';
        /** Check if rate and count is exists */
        if (isset ( $ratestar ) && isset ( $ratecount )) {
          /** Call script function to get rate count */
          $output   .= 'rateCalc(' . $ratestar . ',' . $ratecount . ');';
        }
        /** Return rating content */
        return   $output . '</script>';
      }
   /** ContusVideoDetailRatingView class ends */ 
    }
/** Check ContusVideoDetailRatingView class exists if ends */
}

/**
 * ContusReportVideoView class starts
 * 
 * @author user 
 */
class ContusReportVideoView extends ContusVideoDetailRatingView {
  /**
   * Fucntion is used to display report video option under player
   *
   * @param unknown $embed_code
   * @param unknown $video_slug
   * @param unknown $currentUserEmail
   * @return string
   */
  function displayReportVideo ($embed_code, $video_slug, $currentUserEmail ){
    $output = NULL;
    /** Code to display report video section  */
    /** Display embed code */
    $output .= '<textarea onclick="this.select()" id="embedcode" name="embedcode" style="display:none;" rows="7" >' . $embed_code . '</textarea>
                                <input type="hidden" name="flagembed" id="flagembed" />';
    /** Display report video form */
    $output .= '<div id="report_video_response"></div><form name="reportform" id="reportform" style="display:none;" method="post" >';
    /** Display report video title */
    $output .= '<div class="report-video-title">Report this video</div>';
    $output .= '<img id="reportform_ajax_loader"  src="' . getImagesDirURL() .'ajax-loader.gif" />';
    /** Display the options in report video form */
    $output .= '<input type="radio" name="reportvideotype" id="reportvideotype" value="Violent or repulsive content">Violent or repulsive content<label class="reportvideotype" title="Violent or grapical content or content posted to shock viewers"></label><br>';
    $output .= '<input type="radio" name="reportvideotype" id="reportvideotype" value="Hateful or abusive content" >Hateful or abusive content<label class="reportvideotype" title="Content that promotes harted against protected groups, abuses vulnerable individuals , or enganges in cyberling"></label><br>';
    $output .= '<input type="radio" name="reportvideotype" id="reportvideotype" value="Harmful dangerous acts" >Harmful dangerous acts<label class="reportvideotype" title="Content  that includes acts that many results in  physical harm"></label><br>';
    $output .= '<input type="radio" name="reportvideotype" id="reportvideotype" value="Spam or misleading">Spam or misleading<label class="reportvideotype" title="Content that is massively posted or otherwise misleading in nature"></label><br>';
    $output .= '<input type="radio" name="reportvideotype" class="reportvideotype" id="reportvideotype" value="Child abuse">Child abuse<label class="reportvideotype" title="Content that includes sexual,predatory or abusive communication  towards minors"></label><br>';
    $output .= '<input type="radio" name="reportvideotype" class="reportvideotype" id="reportvideotype" value="Sexual content">Sexual content<label class="reportvideotype" title="Includes graphic sexual activity, nutity and other sexual content"></label><br>';
    /** Set slug id as hidden value for report video  option */
    $output .= '<input type="hidden" id="redirect_url" value="' . $video_slug . '" name="redirect_url" />';
    /** Set current user email as hidden value for report video  option */
    $output .= '<input type="hidden" id="reporter_email" value="' . $currentUserEmail . '" name="reporter_email" />';
    /** Display send button in report video form */
    $output .= '<input type="button" class="reportbutton" value="Send" onclick="return reportVideoSend();" name="reportsend" />';
    /** Display cancel button */
    $output .= '&nbsp;&nbsp;<input type="reset" onclick="return hideReportForm();" class="reportbutton" value="Cancel" id="ReportFormreset" style="margin: 2% 0;" name="reportclear" />';
    /** Return report video form content */
    return $output . '</form> <input type="hidden" name="reportvideo" id="reportvideo" />';
  }
} 

/** Check ContusVideoDetailView class exists  */
if (! class_exists ( 'ContusVideoDetailView' )) {
    /**
     * ContusVideoDetailView class starts
     * 
     * @author user
     */
    class ContusVideoDetailView extends ContusReportVideoView {
        /**
         * Function is used to display palyer and video information
         *
         * @param array $arguments          
         * @return unknown number string
         */
        function hdflv_sharerender($arguments = array()) {
            global $wpdb, $current_user;
            /** Variable initialization for ContusVideoDetailView */
            $output = $videourl = $imgurl = $vid = $playlistid = $homeplayerData = $rate = $no_views = $windo = $post_date = '';
            $video_playlist_id = $videoId = $hitcount = $show_posted_by = $show_added_on = $show_social_icon = $ratecount = $videodivId = 0;
            $fetched = array ();
            /** Get random number to attach */
            $videodivId = rand ();
            /** Check admin logged in */
            $isAdmin = absint ( filter_input ( INPUT_GET, 'admin' ) );
            /**  Query to get settings data from db */
            $configXML = getPluginSettings ();
            /** Generate flashvars detail 
             * for player starts here */
            $flashvars = $pluginflashvars = 'baserefW=' . home_url ();
            /**  Get width from settings */
            $width = $configXML->width;
            if (isset ( $arguments ['width'] ) && !empty($arguments ['width'])) {
                /** Get width from short code */
                $width = $arguments ['width'];
            }            
            /** Get height from settings */
            $height = $configXML->height;
            if (isset ( $arguments ['height'] ) && !empty( $arguments ['height']) ) { 
                /** Get height from short code */
                $height = $arguments ['height'];
            }
            /** Get playor colors, posted by, social icon, rss icon 
             * and related videos count from settings object */
            $player_color         = unserialize ( $configXML->player_colors );
            $show_posted_by       = $player_color ['show_posted_by'];
            $show_social_icon     = $player_color ['show_social_icon'];
            $show_rss_icon        = $player_color ['show_rss_icon'];
            $number_related_video = get_related_video_count ();
            /** If related video is not given in settings page,
             * then assign default value 100 */
            if (empty ( $number_related_video )) {
                $number_related_video = 100;
            }      
            /** Get show added on option from settings*/      
            if (isset ( $player_color ['show_added_on'] )) {
                $show_added_on        = $player_color ['show_added_on'];
            }
            /** Send report for video */
            if (isset ( $arguments ['id'] )) {
                /** Get video id from short code */
                $videodivId   .= $arguments ['id'];
                $vid          = $arguments ['id'];
            }        
            if (! empty ( $vid )) {
            	$wp_user    =  wp_get_current_user();
            	$wp_user_id = $wp_user->ID;
                /** Call function to get video details  */
                $homeplayerData   = $this->short_video_detail ( $vid, $number_related_video );
                $fetched []       = $homeplayerData;
            } 
            /** Store video details in variables */
            if (! empty ( $homeplayerData )) {
                /** Get video detials from model */
                $videoUrl           = $homeplayerData->file;
                $videoId            = $homeplayerData->vid;
                $video_title        = $homeplayerData->name;
                $video_slug         = $homeplayerData->slug;
                $video_file_type    = $homeplayerData->file_type;
                $video_playlist_id  = $homeplayerData->playlist_id;
                $description        = $homeplayerData->description;
                $tag_name           = $homeplayerData->tags_name;
                $hitcount           = $homeplayerData->hitcount;
                $uploadedby         = $homeplayerData->display_name;
                $uploadedby_id      = $homeplayerData->ID;
                $ratecount          = $homeplayerData->ratecount;
                $rate               = $homeplayerData->rate;
                $post_date          = $homeplayerData->post_date;
                $video_thumb        = getImagesValue ($homeplayerData->image, $video_file_type, $homeplayerData->amazon_buckets, '');              
            }
            /** Get playlist id from short code */
            if (isset ( $arguments ['playlistid'] )) {
            	/** Get video id */
                $videodivId   .= $arguments ['playlistid'];
                /** Get playlist id */
                $playlistid   = $arguments ['playlistid'];
                /** Set flash vars */
                $flashvars    .= '&amp;mtype=playerModule';
            }
            /** Check view is from admin */
            if(!empty($isAdmin)){
            	$flashvars      .= '&amp;adminview=true';
            }
            /** Generate flashvars detail for player starts here */
            if (! empty ( $playlistid ) && ! empty ( $vid )) {
                $flashvars      .= '&amp;pid=' . $playlistid . '&amp;vid=' . $vid;
            } elseif (! empty ( $playlistid )) {
                $flashvars      .= '&amp;pid=' . $playlistid . '&showPlaylist=true';
                $playlist_videos = $this->_contOBJ->video_pid_detail ( $playlistid, 'detailpage', $number_related_video );
                /** Get video details based on the playlist id */
                if (! empty ( $playlist_videos )) {
                    $videoId            = $playlist_videos [0]->vid;
                    $video_playlist_id  = $playlist_videos [0]->playlist_id;
                    $hitcount           = $playlist_videos [0]->hitcount;
                    $uploadedby         = $playlist_videos [0]->display_name;
                    $uploadedby_id      = $playlist_videos [0]->ID;
                    $ratecount          = $playlist_videos [0]->ratecount;
                    $rate               = $playlist_videos [0]->rate;
                    $fetched []         = $playlist_videos [0];
                }
            } else if ($this->_post_type !== APPTHAVIDEOGALLERY && $this->_page_post_type !== APPTHAVIDEOGALLERY) {
                $flashvars .= '&amp;vid=' . $vid . '&showPlaylist=false';
            } else {
                $flashvars .= '&amp;vid=' . $vid;
            }
            /** Set flashvars based on the short code arguments */
            if (isset ( $arguments ['flashvars'] )) {
                $flashvars .= '&amp;' . $arguments ['flashvars'];
            }
            if (! isset ( $arguments ['playlistid'] ) && isset ( $arguments ['id'] ) && $this->_post_type !== APPTHAVIDEOGALLERY && $this->_page_post_type !== APPTHAVIDEOGALLERY) {
              $flashvars .= '&amp;playlist_autoplay=false&amp;playlist_auto=false';
            }            
            /** Generate flashvars detail for player ends here */
            $player_not_support = __ ( 'Player doesnot support this video.', APPTHA_VGALLERY );
            $htmlplayer_not_support = __ ( 'Html5 Not support This video Format.', APPTHA_VGALLERY );
            $output   .= ' <script> var videoPage;                      
                      videoPage = "' . $this->_mPageid . '"; </script>';
            if (isset ( $arguments ['title'] ) && $arguments ['title'] == 'on') {
                $output .= '<h2 id="video_title' . $videodivId . '" class="videoplayer_title" ></h2>';
                $pluginflashvars .= $flashvars .= '&amp;videodata=current_video_' . $videodivId;
            }
            /** Player starts here */
            $output   .= '<div id="mediaspace' . $videodivId . '" class="videoplayer">';
            $mobile = vgallery_detect_mobile ();
            /** Embed player code */
            if ( isset ( $fetched ) && $fetched [0]->file_type == 5 && ! empty ( $fetched [0]->embedcode )) {
                $playerembedcode    = stripslashes ( $fetched [0]->embedcode );
                $playeriframewidth  = str_replace ( 'width=', 'width="' . $width . '"', $playerembedcode );
                if ($mobile) {
                    $output .= $playerembedcode;
                } else {
                    $output .= str_replace ( 'height=', 'height="' . $height . '"', $playeriframewidth );
                    watchedVideoHitCount($fetched [0]->vid,false);
                }
            } else if ($mobile) {
              /** Check mobile device is detected */
                /** Get video detail for HTML5 player
                 * Load video details */
                foreach ( $fetched as $media ) {
                    $videourl             = $media->file;
                    $file_type            = $media->file_type;
                    $imgurl               = getImagesValue ( $media->image, $file_type, $media->amazon_buckets, '');
                }
                /** Check file type youtube, viddler,dailymotion */
               if ($file_type == 3 || $file_type == 1) {
                    if (strpos ( $videourl, 'youtube' ) > 0) {
                        $videoid = getYoutubeVideoID ( $videourl );
                    $output='<div id="player"></div><script>var tag = document.createElement("script");tag.src = "https://www.youtube.com/iframe_api";var firstScriptTag = document.getElementsByTagName("script")[0];firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);var player;function onYouTubeIframeAPIReady() {player = new YT.Player("player", {width: "100%",videoId: "'.$videoid.'",playerVars: {"rel": 0,"showinfo":0,"modestbranding":0},events: {"onStateChange": onPlayerStateChange}});}var done = false;function onPlayerStateChange(event) {if (event.data == YT.PlayerState.PLAYING && !done) {currentVideoP('.$videoId.');done = true;}}</script>';
                    echo $output;
                        /** Generate youtube embed code for html5 player */
                    } else if (strpos ( $videourl, 'viddler' ) > 0) {
                        /** For viddler videos in URL method */
                        $imgstr       = explode ( '/', $videourl );
                        $viddler_id   = $imgstr [4];
                        $output='<script type="text/javascript" src="//static.cdn-ec.viddler.com/js/arpeggio/v3/build/main-built.js"></script><div id="my-player"></div><script>var embed = new ViddlerEmbed({videoId: "'.$viddler_id.'",width: "100%",target: "#my-player"});var done = false;embed.manager.events.on("videoPlayer:play", function() {if (!done) {currentVideoP('.$videoId.');done = true;}});</script>';
                    } elseif (strpos ( $videourl, 'dailymotion' ) > 0) {
                        /** For dailymotion videos in URL method */
                        $split_id     = getDailymotionVideoID ( $videourl );
                        $video        = $videourl =  $this->_protocolURL . 'www.dailymotion.com/embed/video/' . $split_id [0];
                        $output='<script src="http://api.dmcdn.net/all.js"></script><div id="player"></div><script>var player = DM.player(document.getElementById("player"),{video: "'.$split_id[0].'",width: "100%",params: {html: 0,wmode: "opaque"},events: {playing: function(){onPlayerStateChange();}}});var done = false;function onPlayerStateChange(){if (!done) {currentVideoP('.$videoId.');done = true;}}</script>';
                        echo $output;
                    } else {
                        $output       .= '<video width="100%" height="' . $height . '" id="video" poster="' . $imgurl . '"   src="' . $videourl . '" autobuffer controls onerror="failed( event )">' . $htmlplayer_not_support . '</video>';
                    }
                } else {
                    /** For uploaded videos, get video URL */
                    $video_url  = getVideosValue ( $videoFile, $file_type, $amazonBucket );
                    /** Check for RTMP videos */
                    if ($file_type == 4) {                        
                        $streamer   = str_replace ( 'rtmp://', 'http://', $media->streamer_path );
                        $video_url  = $streamer . '_definst_/mp4:' . $videourl . '/playlist.m3u8';
                    }
                    /** Generate video code for html5 player */
                    $output .= '<video width="100%" height="' . $height . '" id="video" poster="' . $imgurl . '"   src="' . $video_url . '" autobuffer controls onerror="failed( event )">' . $htmlplayer_not_support . '</video>';
                }
            } else {
                $output .= '<div id="flashplayer"><embed src="' . $this->_swfPath . '" flashvars="' . $flashvars . '" width="' . $width . '" height="' . $height . '" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" wmode="transparent"></div>';
                /** Google adsense code Start */ 
                if ($player_color ['googleadsense_visible'] == 1 && !( $mobile) && ($this->_post_type === APPTHAVIDEOGALLERY || $this->_page_post_type === APPTHAVIDEOGALLERY)) {
                  if($homeplayerData->google_adsense && $homeplayerData->google_adsense_value) {
                        $output .= '<div>';
                        /**
                         * Call function to dipaly google adsense on player
                         */
                         $output .= $this->displayGoogleAdsense ( $width, $vid, $homeplayerData->vid );
                  }
                }                
            }
            $output .= '</div>';
            /** End Google adsense End. */
            /** Get current user agent */
            $useragent = $_SERVER ['HTTP_USER_AGENT'];
            if (strpos ( $useragent, 'Windows Phone' ) > 0) {
                /** Check for windows phone */
                $windo = 'Windows Phone';
            }            
            /**  Check platform */
            /** Call script to display error message within player */
            $output .= '<script type="text/javascript">
                function current_video_' . $videodivId . '( video_id,d_title ){  
                    if( d_title == undefined ) { 
                      document.getElementById( "video_title' . $videodivId . '" ).innerHTML=""; 
                    } else { 
                      document.getElementById( "video_title' . $videodivId . '" ).innerHTML=""; 
                      document.getElementById( "video_title' . $videodivId . '" ).innerHTML=d_title; 
                    } 
                } var txt =  navigator.platform ; 
                var windo = "' . $windo . '"; 
                function failed( e ) { 
                    if( txt =="iPod"|| txt =="iPad" || txt == "iPhone" || windo=="Windows Phone" || txt == "Linux armv7l" || txt == "Linux armv6l" ) { 
                      alert( "' . $player_not_support . '" ); 
                    } 
                } </script>';
            /** Player ends here
             * Display description, views, tags, playlist names detail under player */
            if (isset ( $arguments ['views'] ) && $arguments ['views'] == 'on') {
                $videogalleryviews = true;
            } else {
                if (($this->_post_type === APPTHAVIDEOGALLERY || $this->_page_post_type === APPTHAVIDEOGALLERY) && $configXML->view_visible == 1) {
                    $videogalleryviews = true;
                } else {
                    $videogalleryviews = false;
                    $no_views = 'noviews';
                }
            }
            /** Call function to display view count, posted on details in video detail page   */
            $output   .= $this->displayViewsPostedON ($show_added_on, $videogalleryviews, $no_views, $post_date, $hitcount);
            /** Display user name under player */
            $output .= '<div class="clearfix"></div>';
            if ($this->_post_type === APPTHAVIDEOGALLERY || $this->_page_post_type === APPTHAVIDEOGALLERY) {
                $user_url = get_user_permalink ( $this->_mPageid, $uploadedby_id, $uploadedby );
                if ($show_posted_by) {
                    $output .= '<div class="video-page-username"><strong>' . __ ( 'Posted&nbsp;by', APPTHA_VGALLERY ) . '&nbsp;:&nbsp;</strong><a href="' . $user_url . '">' . $uploadedby . '</a></div>';
                }
                /** Display category name under player  */
                if ($configXML->categorydisplay == 1) {
                /** Category display function */
                   $output   .= $this->displayCategory( $vid );
                }
            }
            /**  Rating starts here for video details page  */
            if ($this->_post_type === APPTHAVIDEOGALLERY || ($this->_page_post_type === APPTHAVIDEOGALLERY)) {
                /** Set ratings control if enabled for player */
            	if ($configXML->ratingscontrol == 1) {
                    $ratingscontrol = true;
                } else {
                    $ratingscontrol = false;
                }
            } /** Set ratings control if enabled for video */
             else if (isset ( $arguments ['ratingscontrol'] ) && $arguments ['ratingscontrol'] == 'on') {
                $ratingscontrol = true;
            } else {
                $ratingscontrol = false;
            }
            /** Show ratings star avg */
            if ($ratingscontrol) {
                $ratestar = getRatingValue ( $rate, $ratecount, 'calc' );
                /** Display ratings under player */
                $output   .= $this->displayRatings ($ratestar, $ratecount, $videodivId, $vid, $videoId);
            }
            /** Rating ends here */
            $output   .= '</div>';
            
            if ($this->_post_type === APPTHAVIDEOGALLERY || $this->_page_post_type === APPTHAVIDEOGALLERY) {
                /** Display tag info */
                if (! empty ( $tag_name ) && $configXML->tagdisplay == 1) { 
                    $output   .= '<div class="video-page-tag"><strong>' . __ ( 'Tags', APPTHA_VGALLERY ) . '          </strong>: ' . $tag_name . ' ' . '</div>';
                }
                /** Check if video url is YouTube */
                if (strpos ( $videoUrl, 'youtube' ) > 0) {
                    $video_thumb  = $this->_protocolURL . 'img.youtube.com/vi/' . getYoutubeVideoID ( $videoUrl ) . '/hqdefault.jpg';
                }
                /** Display description */
            	if(!empty ($description)) {
					$removequotedescription = str_replace ( '"', '', $description );
					$videodescription = str_replace ( "'", '', $removequotedescription );
				}
				 /** Show blog content when description is not available */
				  else {
				  	$videodescription = get_bloginfo('name');
				}
				/** Check amazon s3 bucket is enabled */
                if ($fetched [0]->amazon_buckets == 1) {
                    $video_thumb = '';
                }
                /** Load rss url link */
                $rs_url     = $this->_site_url . '/wp-admin/admin-ajax.php?action=rss&type=video&vid=' . $vid;
                $rss_image  = getImagesDirURL() .'/rss_icon.png' ;
                /** Show social icons below player */
                if ($show_social_icon) {
                    /** Function to display social icons
                     * and rss icon */
                    $output .= $this->displaySocialIcons ( $configXML->keyApps, $videodescription,  $video_thumb, $video_title);
                    /** Show rss url link and image
                     * Build rss icon div */
                    if ($show_rss_icon) {
                      $output .= '<div class="floatleft rssfeed">&nbsp;&nbsp;<a href="' . $rs_url . '"><img src="' . $rss_image . '"></a></div>';
                    }
                    $output .= '</div>';
                    $output .= '<div class="clearfix">';
                }
                
                $output .= '<div class="video-cat-thumb">';
                /** Show rss icon enable / disable  */
                if ($show_rss_icon && ! $show_social_icon) {
                    $rs_url = $this->_site_url . '/wp-admin/admin-ajax.php?action=rss&type=video&vid=' . $vid;
                    $rss_image = getImagesDirURL() .'/rss_icon.png' ;
                    $output .= '<div class="video-socialshare"><div class="floatleft rssfeed">&nbsp;&nbsp;<a href="' . $rs_url . '"><img src="' . $rss_image . '"></a></div></div>';
                }
                /** Show or hide embed /iframe/report video option code for video detail page..  */
                if ($configXML->embed_visible == 1) {
                  $output .= '<a href="javascript:void( 0 )" onclick="enableEmbed();" class="embed" id="allowEmbed"><span class="embed_text">' . __ ( 'Embed&nbsp;Code', APPTHA_VGALLERY ) . '</span><span class="embed_arrow"></span></a>';
                }
                if (isset ( $player_color ['iframe_visible'] ) && ($player_color ['iframe_visible'])) {
                  $output .= '<a href="javascript::void(0);" onclick="view_iframe_code();" id="iframe_code" class="embed"><span class="embed_text">' . __ ( 'Iframe', APPTHA_VGALLERY ) . '</span><span class="embed_arrow"></span></a>';
                }
                if (isset ( $player_color ['report_visible'] ) && ($player_color ['report_visible'])) {
                  $output .= '<a href="javascript:void(0)" onclick="reportVideo();" class="embed" id="allowReport"><span class="embed_text">' . __ ( 'Report&nbsp;Video', APPTHA_VGALLERY ) . '</span><span class="embed_arrow"></span></a>';
                }
                /** Condition for embed code */
                if ($fetched [0]->file_type == 5 && ! empty ( $fetched [0]->embedcode )) {
                  $embed_code = stripslashes ( $fetched [0]->embedcode );
                } else {
                /** Display embed code */
                  $embed_code = '<embed src="' . $this->_swfPath . '" flashvars="' . $flashvars . '&amp;shareIcon=false&amp;email=false&amp;showPlaylist=false&amp;zoomIcon=false&amp;copylink=' . get_permalink () . '&amp;embedplayer=true" width="' . $width . '" height="' . $height . '" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" wmode="transparent">';
                }                
                
                /** Call fucntion to display report video option */
                $output .= $this->displayReportVideo($embed_code, $video_slug, $current_user->user_email);
                /** Load embed code */
                if ($fetched [0]->file_type == 5 && $fetched [0]->embedcode) {
                  $iframe_code = stripslashes ( $fetched [0]->embedcode );
                } else {
                	/** Load iframe code */
                  $iframe_code = '<iframe src="' . $this->_swfPath . '?' . $flashvars . '&amp;shareIcon=false&amp;email=false&amp;showPlaylist=false&amp;zoomIcon=false&amp;copylink=' . get_permalink () . '&amp;embedplayer=true" frameborder="0" width="' . $width . '" height="' . $height . '" ></iframe>';
                }
                
                $output .= '<textarea row="7" col="60" id="iframe-content" name="iframe-content" style="display:none;" onclick="this.select();">' . $iframe_code . '</textarea><input type="hidden" value="" id="iframeflag" name="iframeflag" />';
                /** Show /hide video description. */
                if ($configXML->showTag) {
                  $output .= '<div style="clear: both;"></div><div class="video-page-desc">' . apply_filters ( 'the_content', $description ) . '</div>';
                }
                $output .= '</div></div>';
            }
            $output .= '</div></div>';
            
            /** Enable/disable Related videos slider */
            $flag = 0;
            if( $vid  && isset ( $arguments ['playlistid'] ) && isset ( $arguments ['relatedvideos'])  && $arguments ['relatedvideos'] == 'on') {
              $flag = 1;
            }
            if ( $flag == 1 || ($this->_post_type === APPTHAVIDEOGALLERY || $this->_page_post_type === APPTHAVIDEOGALLERY) && $player_color ['show_related_video'] == 1 ) {
              /** Call function to display related videos slider */
              $output .= $this->relatedVideoSlider ( $vid, $video_playlist_id, $pluginflashvars, $width, $height, $videodivId );
            }
            /** To display video comments section */
            return $output . $this->videoComments($configXML);
        }  
    /** ContusVideoDetailView class ends  */
    } 
/** Check ContusVideoDetailView class exists if ends */
} else {
    /** Else display contusVideo exists message */
    echo 'class contusVideo already exists';
}
?>