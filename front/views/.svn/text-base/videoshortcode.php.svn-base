<?php
/**
 * Video detail and short tags view file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */

/**
 * Check ContusVideoShortcodeView class exists
 */
if (! class_exists ( 'ContusVideoShortcodeView' )) {
  /**
   * ContusVideoShortcodeView class starts
   * 
   * @author user
   */
    class ContusVideoShortcodeView extends ContusVideoShortcodeController {
        /**
         * ContusVideoShortcodeView constructor function
         */
        public function __construct() {
            parent::__construct ();
            /** Get current video id 
             * and report send response  */
            $this->_vId             = absint ( filter_input ( INPUT_GET, 'vid' ) );
            $this->_reportsent      = filter_input ( INPUT_POST, 'report_send' );
            
            /** Get post type, page post type 
             * and  video more page id */
            $this->_post_type       = filter_input ( INPUT_GET, 'post_type' );
            $this->_page_post_type  = get_post_type( get_the_ID () );
            $this->_mPageid         = morePageID ();
            
            /** Get plugin site URL, 
             * plugin images directory URL, 
             * upload directory URL 
             * and swf file URL   */
            $this->_site_url        = get_site_url ();
            $this->_imagePath       = getImagesDirURL ();
            $this->_uploadPath      = getUploadDirURL ();
            $this->_swfPath         = APPTHA_VGALLERY_BASEURL . 'hdflvplayer' . DS . 'hdplayer.swf';
            
            /** Function to check
             * whether the SSL is enabled in site */
            $this->_protocolURL     = getPluginProtocol();
            /** Object for home page controller */
            $this->_contOBJ         = new ContusVideoController ();
            
        }

        /**
         * Fucntion to display views, posted on details
         * 
         * @param unknown $show_added_on
         * @param unknown $videogalleryviews
         * @param unknown $no_views
         * @param unknown $post_date
         * @param unknown $hitcount
         * @return string
         */
        function displayViewsPostedON ($show_added_on, $videogalleryviews, $no_views, $post_date, $hitcount){
          $output   = $plugin_css = NULL;
          /** check whther it is short code */
          if ($this->_post_type !== APPTHAVIDEOGALLERY && $this->_page_post_type !== APPTHAVIDEOGALLERY) {
            /** If yes then assign css class name */
            $plugin_css = 'shortcode';
          }
          /** Code to video page information block */
          $output .= '<div class="video-page-container ' . $plugin_css . '"><div class="vido_info_container"><div class="video-page-info ' . $no_views . '">';
          if (($this->_post_type === APPTHAVIDEOGALLERY || $this->_page_post_type === APPTHAVIDEOGALLERY ) && $show_added_on == 1 ) {
            /** Code to display posted on under player */
              $output .= '<div class="video-page-date"><strong>' . __ ( 'Posted&nbsp;on', APPTHA_VGALLERY ) . '&nbsp;:&nbsp;</strong><span>' . date_i18n ( get_option ( 'date_format' ), strtotime ( $post_date ) ) . '</span></div>';
          }
          /** Check views count is enabled */
          if ($videogalleryviews) {
            /** Display views count under player */
            $output .= '<div class="video-page-views"><strong>' . __ ( 'Views', APPTHA_VGALLERY ) . '&nbsp;:&nbsp;</strong><span>' . $hitcount . '</span></div>';
          }
          /** Return views and posted on content */ 
          return $output;
        }        
        
    /** ContusVideoShortcodeView class ends */
    } 
/** Check ContusVideoShortcodeView class exists if ends */
} else {
    /** Display message ContusVideoShortcodeView exists */
    echo 'class ContusVideoShortcodeView already exists';
}


class ContusCategoryAdsenseDisplay extends ContusVideoShortcodeView {
  /**
   * Fucntion to display category name
   *
   * @param unknown $vid
   * @return string
   */
  function displayCategory( $vid ) {
    $output   =  $playlistname = NULL;
    $incre = 0;
    /** Get Playlist detail */
    $playlistData   = $this->playlist_detail ( $vid );
    /** Display playlist name under player */
    $output   .= '<div class="video-page-category"><strong>' . __ ( 'Category', APPTHA_VGALLERY ) . '&nbsp;:&nbsp;</strong>';
    foreach ( $playlistData as $playlist ) {
      /** Get playlist page URL */
      $playlist_url   = get_playlist_permalink ( $this->_mPageid, $playlist->pid, $playlist->playlist_slugname );
      /** Check more than one playlist is exists */
      if ($incre > 0) {
        /** Display mulitple playlists */
        $playlistname   .= ',&nbsp;' . '<a href="' . $playlist_url . '">' . str_replace ( ' ', '&nbsp;', $playlist->playlist_name ) . '</a>';
      } else {
        /** Display single playlists */
        $playlistname   .= '<a href="' . $playlist_url . '">' . str_replace ( ' ', '&nbsp;', $playlist->playlist_name ) . '</a>';
      }
      $incre ++;
    }
    /** Return playlist content to display */
    return $output . $playlistname . '</div>';
  }
  
  /**
   * Fucntion to display google adsense
   *
   * @param unknown $width
   * @param unknown $vid
   * @param unknown $videoid
   * @return string
   */
  function displayGoogleAdsense ($width, $vid, $videoid) {
    $ropen = 0;
    /** Get height & width for google adsense */
    if ($width > 468) {
      $adstyle = "margin-left: -234px;";
    } else {
      $margin_left = ($width - 100) / 2;
      $adwidth = ($width - 100);
      $adstyle = "width:" . $adwidth . "px;margin-left: -" . $margin_left . "px;";
    }
     
    /** Display google adsense */
    $output   .= '<div id="lightm"  style="' . $adstyle . 'height:76px;position:absolute;display:none;background:none !important;background-position: initial initial !important;background-repeat: initial initial !important;bottom: 60px;left: 50%;">
                        <span id="divimgm" >
                          <img alt="close" id="closeimgm" src="' . APPTHA_VGALLERY_BASEURL . '/images/close.png" style="z-index: 10000000;width:48px;height:12px;cursor:pointer;top:-12px;" onclick="googleclose();"  />
                        </span>
                        <iframe  height="60" width="' . ($width - 100) . '" scrolling="no" align="middle" id="IFrameName" src="" name="IFrameName" marginheight="0" marginwidth="0" class="iframe_frameborder" ></iframe>
                        </div>
                        </div>';
    /** Get google adsense details for this video */
    $details  = $this->get_video_google_adsense_details ( $vid );
    $details1 = unserialize ( $details->googleadsense_details );
    /** Get close ad seconds */
    $closeadd = $details1 ['adsenseshow_time'];
    if (isset ( $details1 ['adsense_option'] ) && $details1 ['adsense_option'] == 'always_show') {
      $closeadd = 0;
    }
    /** Get adsense reopen seconds */
    if (isset ( $details1 ['adsense_reopen'] ) && $details1 ['adsense_reopen'] == '1') {
      $ropen  = $details1 ['adsense_reopen_time'];
    }
    /** Assign close ad , reopen values in script variable */
    $output   .= '<script type="text/javascript">
                          var pagepath  = "' . $this->_site_url . '/wp-admin/admin-ajax.php?action=googleadsense&vid=' . $videoid . '";
                          var closeadd = ' . $closeadd * 1000 . ';
                          var ropen = ' . $ropen * 1000 . ';
                        </script> <script src="' . APPTHA_VGALLERY_BASEURL . 'js/googlead.js" type="text/javascript"></script>';
    return $output;
  }
}

/** Check ContusSocialCommentView class exists */
if (! class_exists ( 'ContusSocialCommentView' )) {
  /**
   * ContusSocialCommentView class
   * 
   * @author user
   */
  class ContusSocialCommentView extends ContusCategoryAdsenseDisplay {
    /**
     * Function to display social icons under the player
     *
     * @param unknown $fbAPIKey
     * @param unknown $videodescription
     * @param unknown $video_thumb
     * @param unknown $video_title
     * @param unknown $vid
     * @return string
     */
    public function displaySocialIcons ( $fbAPIKey, $videodescription, $video_thumb, $video_title ) {
      /** Get current page URL and attach random numbers with URL */
      $current_url    = $this->_protocolURL . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'] . '?random=' . rand ( 0, 100 );
      $blog_title     = get_bloginfo ( 'name' );
      /** Share URL for fshare button */
      $url_fb = 'http://www.facebook.com/dialog/feed?app_id=' . $fbAPIKey . '&description=' . urlencode ( $videodescription ) . '&picture=' . urlencode ( $video_thumb ) . '&name=' . urlencode ( $video_title ) . '&message=Comments&link=' . urlencode ( $current_url ) . '&redirect_uri=' . urlencode ( $current_url );
      /** Facebook / Twitter / Google Plus
       * share icon display starts here */
      /** Return social icons content */
      return '<div class="video-socialshare">
                          <div class="floatleft" style=" margin-right: 9px; "> <a href="' . $url_fb . '" class="fbshare" id="fbshare" title="Facebook" target="_blank" ></a> </div>
                          <div class="floatleft ttweet" >
                              <a href="https://twitter.com/share" class="twitter-share-button" text="Twitter" data-count="none" data-url="' . $current_url . '" data-via="' . $blog_title . '" data-text="' . $video_title . '">' . __ ( 'Tweet', APPTHA_VGALLERY ) . '</a>
                              <script> !function( d,s,id ){var js,fjs=d.getElementsByTagName( s )[0];if( !d.getElementById( id ) ){js=d.createElement( s );js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore( js,fjs );}}( document,"script","twitter-wjs" ); </script>
                          </div>
                          <div class="floatleft gplusshare" >
                              <script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
                              <div class="g-plusone" data-size="medium" data-count="false"></div>
                          </div>';
    }
    
    /**
     * Function to display video comment section
     *
     * @param unknown $configXML
     * @return string $output
     */
    public function videoComments ( $configXML ) {
      $output   = NULL;
      if ($this->_post_type === APPTHAVIDEOGALLERY || $this->_page_post_type === APPTHAVIDEOGALLERY) {
        /**
         * Check below cases and display comment option based on this
         *
         * Case 0 : Default Comment
         * Case 1 : Fb Comment
         * Case 2 : Disqus Comment
         */
        switch ($configXML->comment_option) {
          case 0 :
            /** Display default comment */
            $output .= '<style type="text/css">#respond,#comments #respond,#comments.comments-area, #disqus_thread, .comments-link{ display: none!important; } </style>';
            break;
          case 2 :
            /** Display Facebook comment */
            $output .= '<style type="text/css">#respond,#comments #respond,#comments.comments-area, #disqus_thread, .comments-link{ display: none!important; } </style>';
            $output .= '<div class="clear"></div> <h2 class="related-videos">' . __ ( 'Post Your Comments', APPTHA_VGALLERY ) . '</h2> <div id="fb-root"></div>
                            <script> ( function( d, s, id ) { var js, fjs = d.getElementsByTagName( s )[0]; if ( d.getElementById( id ) ) return; js = d.createElement( s ); js.id = id;
                                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=' . $configXML->keyApps . '"; fjs.parentNode.insertBefore( js, fjs ); }( document, "script", "facebook-jssdk" ) ); </script>';
            $output .= '<div class="fb-comments" data-href="' . get_permalink () . '" data-num-posts="5"></div>';
            break;
          case 3 :
            /** Display disqus comment */
            $output .= '<style type="text/css">#comments #respond,#comments.comments-area, .comments-link{ display: none!important; } </style>';
            $output .= '<div id="disqus_thread"></div>
                         <script type="text/javascript">var disqus_shortname = "' . $configXML->keydisqusApps . '";
                                ( function() {var dsq = document.createElement( "script" ); dsq.type = "text/javascript"; dsq.async = true;dsq.src = "http://"+ disqus_shortname + ".disqus.com/embed.js";( document.getElementsByTagName( "head" )[0] || document.getElementsByTagName( "body" )[0] ).appendChild( dsq );} )();
                         </script> <noscript>' . __ ( 'Please enable JavaScript to view the', APPTHA_VGALLERY ) . ' <a href="http://disqus.com/?ref_noscript">' . __ ( 'comments powered by Disqus.', APPTHA_VGALLERY ) . '</a> </noscript>
                         <a href="http://disqus.com" class="dsq-brlink">' . __ ( 'comments powered by', APPTHA_VGALLERY ) . ' <span class="logo-disqus">' . __ ( 'Disqus', APPTHA_VGALLERY ) . '</span></a>';
            break;
          default :
            break;
        }
      }
      return $output;
    }
  /** ContusVideoShortcodeView class ends */
  }
/** Check ContusVideoShortcodeView class exists if ends */
}
?>