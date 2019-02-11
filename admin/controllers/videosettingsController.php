<?php
/**  
 * Video gallery admin setting controller file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Including video settings model file to get database information. */
include_once ($adminModelPath . 'videosetting.php');
/** Checks if the SettingsController class has been defined starts */
if ( !class_exists ( 'SettingsController' ) ) {  
    /**
     * SettingsController class starts
     */
    class SettingsController extends SettingsModel {      
        /** Class varaible decalration */
        public $_msg;
        public $_update;
        public $_extension;
        public $_settingsUpdate;
        /** 
         * SettingsController constructor function  
         */
        public function __construct() {
            parent::__construct ();
            /** Get update, updatebutton and extension parameters from request URL */
            $this->_update          = filter_input ( INPUT_GET, 'update' );
            $this->_settingsUpdate  = filter_input ( INPUT_POST, 'updatebutton' );
            $this->_extension       = filter_input ( INPUT_GET, 'extension' );
        }
        
        /**
         * Function is used to get player color data
         */
        public function getPlayerColorData () {
          /** Get sharepanel_up_BgColor,sharepanel_down_BgColor from request URL */
          $sharepanel_up_BgColor    = filter_input ( INPUT_POST, 'sharepanel_up_BgColor' );
          $sharepanel_down_BgColor  = filter_input ( INPUT_POST, 'sharepanel_down_BgColor' );
          /** Get sharepaneltextColor,sendButtonColor from request URL */
          $sharepaneltextColor      = filter_input ( INPUT_POST, 'sharepaneltextColor' );
          $sendButtonColor          = filter_input ( INPUT_POST, 'sendButtonColor' );
          /** Get sendButtonTextColor,textColor from request URL */
          $sendButtonTextColor      = filter_input ( INPUT_POST, 'sendButtonTextColor' );
          $textColor        = filter_input ( INPUT_POST, 'textColor' );
          /** Get skinBgColor,seek_barColor from request URL */
          $skinBgColor      = filter_input ( INPUT_POST, 'skinBgColor' );
          $seek_barColor    = filter_input ( INPUT_POST, 'seek_barColor' );
          /** Get buffer_barColor,skinIconColor from request URL */
          $buffer_barColor  = filter_input ( INPUT_POST, 'buffer_barColor' );
          $skinIconColor    = filter_input ( INPUT_POST, 'skinIconColor' );
          /** Get pro_BgColor,relatedVideoBgColor from request URL */
          $pro_BgColor      = filter_input ( INPUT_POST, 'pro_BgColor' );
          $relatedVideoBgColor = filter_input ( INPUT_POST, 'relatedVideoBgColor' );
          /** Get playButtonColor,playButtonBgColor from request URL */
          $playButtonColor  = filter_input ( INPUT_POST, 'playButtonColor' );
          $playButtonBgColor = filter_input ( INPUT_POST, 'playButtonBgColor' );
          /** Get playerButtonColor,playerButtonBgColor from request URL */
          $playerButtonColor = filter_input ( INPUT_POST, 'playerButtonColor' );
          $playerButtonBgColor = filter_input ( INPUT_POST, 'playerButtonBgColor' );
          /** Get scroll_barColor,scroll_BgColor from request URL */
          $scroll_barColor  = filter_input ( INPUT_POST, 'scroll_barColor' );
          $scroll_BgColor   = filter_input ( INPUT_POST, 'scroll_BgColor' );
          /** Get skinVisible,skin_opacity params from request URL */          
          $skinVisible  = filter_input ( INPUT_POST, 'skinVisible' );
          $skin_opacity = filter_input ( INPUT_POST, 'skin_opacity' );
          /** Get player color settings parameters fromrequest URL */
          /** Get subTitleColor,subTitleBgColor from request URL */
          $subTitleColor      = filter_input ( INPUT_POST, 'subTitleColor' );
          $subTitleBgColor    = filter_input ( INPUT_POST, 'subTitleBgColor' );
          /** Get subTitleFontFamily,subTitleFontSize from request URL */
          $subTitleFontFamily = filter_input ( INPUT_POST, 'subTitleFontFamily' );
          $subTitleFontSize   = filter_input ( INPUT_POST, 'subTitleFontSize' );
          /** enable/disable Social, RSS icons */
          $showSocialIcon   = filter_input ( INPUT_POST, 'showSocialIcon' );
          $show_rss_icon    = filter_input ( INPUT_POST, 'show_rss_icon' );
          /** show/hide posted by user name */
          $showPostedBy     = filter_input ( INPUT_POST, 'ShowPostBy' );
          /** show/hide related videos */
          $show_related_video     = filter_input ( INPUT_POST, 'show_related_video' );          
          /** get video thumb images order, related video count */
          $recent_video_order     = filter_input ( INPUT_POST, 'recent_video_order' );
          $related_video_count    = filter_input ( INPUT_POST, 'related_video_count' );
          $playlist_count    = filter_input ( INPUT_POST, 'playlist_count' );
          $report_visible = filter_input ( INPUT_POST, 'report_visible' );
          $iframe_visible = filter_input ( INPUT_POST, 'iframe_visible' );
          /** Enable/disable Added on in video detail page options */
          $show_added_on    = filter_input ( INPUT_POST, 'show_added_on' );
          /** show/hide video title */
          $show_title       = filter_input ( INPUT_POST, 'showTitle' );
          /** get youtube API key */
          $youtube_key = filter_input ( INPUT_POST, 'youtube_key' );
          $user_allowed_method = filter_input ( INPUT_POST, 'user_allowed_method', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
          if (! empty ( $user_allowed_method )) {
            $user_allowed_method = implode ( ',', $user_allowed_method );
          }
          /** Get user upload settings parameters fromrequest URL */
          $member_upload_enable = filter_input ( INPUT_POST, 'member_upload_enable' );
          $member_publish_enable = filter_input ( INPUT_POST, 'member_publish_enable' );
          $googleadsense_visible  = filter_input ( INPUT_POST, 'googleadsense_visible' );
          /** Get amazon_bucket_access_secretkey from request URL */
          $amazon_bucket_access_secretkey = filter_input ( INPUT_POST, 'amazon_bucket_access_secretkey' );
          /** Get amazon bucket settings parameters fromrequest URL */
          /** Get amazonbuckets_link,amazon_bucket_access_key from request URL */
          $amazonbuckets_link = filter_input ( INPUT_POST, 'amazonbuckets_link' );
          $amazon_bucket_access_key = filter_input ( INPUT_POST, 'amazon_bucket_access_key' );
          /** Get amazonbuckets_enable,amazonbuckets_name from request URL */
          $amazonbuckets_enable = filter_input ( INPUT_POST, 'amazonbuckets_enable' );
          $amazonbuckets_name = filter_input ( INPUT_POST, 'amazonbuckets_name' );
          
          /**  Store all play color parameters into single array */
          return array ('sharepanel_up_BgColor' => $sharepanel_up_BgColor,'sharepanel_down_BgColor' => $sharepanel_down_BgColor,'sharepaneltextColor' => $sharepaneltextColor,
              'sendButtonColor'  => $sendButtonColor,'sendButtonTextColor' => $sendButtonTextColor,'textColor' => $textColor, 'skinBgColor' => $skinBgColor, 'seek_barColor' => $seek_barColor,
              'buffer_barColor' => $buffer_barColor, 'skinIconColor' => $skinIconColor, 'pro_BgColor' => $pro_BgColor, 'relatedVideoBgColor' => $relatedVideoBgColor, 
              'playButtonColor' => $playButtonColor, 'playButtonBgColor' => $playButtonBgColor, 'playerButtonColor' => $playerButtonColor,'playerButtonBgColor' => $playerButtonBgColor,
              'scroll_barColor' => $scroll_barColor, 'scroll_BgColor' => $scroll_BgColor, 'skinVisible' => $skinVisible,'skin_opacity' => $skin_opacity,'subTitleColor' => $subTitleColor,
              'subTitleBgColor' => $subTitleBgColor, 'subTitleFontFamily'  => $subTitleFontFamily,'subTitleFontSize' => $subTitleFontSize, 'show_social_icon' => $showSocialIcon, 
              'show_rss_icon'  => $show_rss_icon, 'show_posted_by' => $showPostedBy,'show_related_video' => $show_related_video, 'recentvideo_order' => $recent_video_order, 
              'related_video_count' => $related_video_count,'playlist_count' => $playlist_count,'report_visible' => $report_visible, 'iframe_visible'  => $iframe_visible,'show_added_on' => $show_added_on,'showTitle' => $show_title,
              'youtube_key' => $youtube_key, 'user_allowed_method' => $user_allowed_method, 'member_upload_enable' => $member_upload_enable, 'member_publish_enable' => $member_publish_enable, 
              'googleadsense_visible' => $googleadsense_visible, 'amazon_bucket_access_secretkey'  => $amazon_bucket_access_secretkey, 'amazon_bucket_access_key'=> $amazon_bucket_access_key, 
              'amazonbuckets_link'=> $amazonbuckets_link, 'amazonbuckets_name'=> $amazonbuckets_name, 'amazonbuckets_enable'=> $amazonbuckets_enable);
          
        }
        
        /**
         * Function is used to get settings form data
         */
        public function getSettingsData () {
            /** Get frontend settings parameters from request URL
             * Get ffmpeg path, download, comment type, gutterspace */
            $gutterSpace    = filter_input ( INPUT_POST, 'gutterspace' );
            $ffmpegPath     = filter_input ( INPUT_POST, 'ffmpeg_path' );
            $downLoad       = filter_input ( INPUT_POST, 'download' );
            $commentOption  = filter_input ( INPUT_POST, 'comment_option' );
            /** Enable / disable embed, tag, category options */
            $embedVisible   = filter_input ( INPUT_POST, 'embed_visible' );
            $tagdisplay       = filter_input ( INPUT_POST, 'tagdisplay' );
            $categorydisplay  = filter_input ( INPUT_POST, 'categorydisplay' );
            /** Enable/disable show tag, shareIcon in video detail page options */
            $showTag          = filter_input ( INPUT_POST, 'showTag' );
            $shareIcon        = filter_input ( INPUT_POST, 'shareIcon' );
            /** Enable / disable view, ratings options */
            $view_visible   = filter_input ( INPUT_POST, 'view_visible' );
            $ratingscontrol = filter_input ( INPUT_POST, 'ratingscontrol' );
            /** Enable/disable popular, recent, featured, home page category video section */
            $homePopular    = filter_input ( INPUT_POST, 'popular' );
            $homeRecent     = filter_input ( INPUT_POST, 'recent' );
            $homeFeature    = filter_input ( INPUT_POST, 'feature' );
            $homeCategory   = filter_input ( INPUT_POST, 'homecategory' );
            $category_page  = filter_input ( INPUT_POST, 'category_page' );
            /** Get row, column for popular, recent, featured params from request URL */
            $rowsPop  = filter_input ( INPUT_POST, 'rowsPop' );
            $colPop   = filter_input ( INPUT_POST, 'colPop' );
            $rowsRec  = filter_input ( INPUT_POST, 'rowsRec' );
            $colRec   = filter_input ( INPUT_POST, 'colRec' );
            $rowsFea  = filter_input ( INPUT_POST, 'rowsFea' );
            $colFea   = filter_input ( INPUT_POST, 'colFea' );
            /** Get row, column for category, more pages params from request URL */
            $rowCat   = filter_input ( INPUT_POST, 'rowCat' );
            $colCat   = filter_input ( INPUT_POST, 'colCat' );
            $rowMore  = filter_input ( INPUT_POST, 'rowMore' );
            $colMore  = filter_input ( INPUT_POST, 'colMore' );
            /** Get logo settings parameters fromrequest URL */
            $logoTarget = filter_input ( INPUT_POST, 'logotarget' );
            $logopath   = filter_input ( INPUT_POST, 'logopathvalue' );
            $logoAlign  = filter_input ( INPUT_POST, 'logoalign' );
            $logoAlpha  = filter_input ( INPUT_POST, 'logoalpha' );
            $licenseKey = filter_input ( INPUT_POST, 'license' );
            /** Get palyer icon settings, playlist_open, showPlaylist parameters from request URL */
            $default_player = 0;
            $playlist_open  = filter_input ( INPUT_POST, 'playlist_open' );
            $showPlaylist   = filter_input ( INPUT_POST, 'showPlaylist' );
            /** Get playlist, autoplay, playlistauto, playlist_open params from request URL */
            $playList       = filter_input ( INPUT_POST, 'playlist' );
            $autoPlay       = filter_input ( INPUT_POST, 'autoplay' );
            $playListauto   = filter_input ( INPUT_POST, 'playlistauto' );
            $playlist_auto  = filter_input ( INPUT_POST, 'playlistauto' );         
            /** Get relatedVideoView, volumecontrol, progressControl, imageDefault params from request URL */
            $relatedVideoView = filter_input ( INPUT_POST, 'relatedVideoView' );
            $volumecontrol    = filter_input ( INPUT_POST, 'volumecontrol' );
            $progressControl  = filter_input ( INPUT_POST, 'progressControl' );
            $imageDefault     = filter_input ( INPUT_POST, 'imageDefault' );
            /** Get HD_default, timer, zoom, email params from request URL */
            $hdDefault        = filter_input ( INPUT_POST, 'HD_default' );
            $playerTimer      = filter_input ( INPUT_POST, 'timer' );
            $playerZoom       = filter_input ( INPUT_POST, 'zoom' );
            $shareEmail       = filter_input ( INPUT_POST, 'email' );
            /** Get skin_autohide, volume, fullscreen, keyApps params from request URL */
            $skinAutohide     = filter_input ( INPUT_POST, 'skin_autohide' );
            $volume           = filter_input ( INPUT_POST, 'volume' );
            $fullScreen       = filter_input ( INPUT_POST, 'fullscreen' );
            $keyApps          = filter_input ( INPUT_POST, 'keyApps' );
            /** Get keydisqusApps, width, height, stagecolor params from request URL */
            $keydisqusApps    = filter_input ( INPUT_POST, 'keydisqusApps' );
            $playerWidth      = filter_input ( INPUT_POST, 'width' );
            $playerHeight     = filter_input ( INPUT_POST, 'height' );
            $stageColor       = filter_input ( INPUT_POST, 'stagecolor' );
            /** Get normalscale, fullscreenscale, buffer params from request URL */
            $normalScale      = filter_input ( INPUT_POST, 'normalscale' );
            $fullScreenscale  = filter_input ( INPUT_POST, 'fullscreenscale' );
            $buffer           = filter_input ( INPUT_POST, 'buffer' );
            /** Get ad settings parameters fromrequest URL */
            /** Get preroll,postroll, midroll_ads,imaAds from request URL */
            $preRoll      = filter_input ( INPUT_POST, 'preroll' );
            $postRoll     = filter_input ( INPUT_POST, 'postroll' );
            $midroll_ads  = filter_input ( INPUT_POST, 'midroll_ads' );
            $imaAds       = filter_input ( INPUT_POST, 'imaAds' );
            /** Get trackCode, adsSkip, adsSkipDuration from request URL */
            $trackCode    = filter_input ( INPUT_POST, 'trackCode' );
            $adsSkip      = filter_input ( INPUT_POST, 'adsSkip' );
            $adsSkipDuration = filter_input ( INPUT_POST, 'adsSkipDuration' );
            /** Get player color data */
            $player_color = $this->getPlayerColorData ();
            /** Store all settings parameters into single array */
            $settingsData = array ('default_player'=> $default_player,'category_page'=> $category_page,'autoplay'=> $autoPlay, 'HD_default'=> $hdDefault,'playlistauto'=> $playListauto, 'keyApps'=> $keyApps,
                'keydisqusApps'=> $keydisqusApps, 'embed_visible'=> $embedVisible,'view_visible'=> $view_visible,'ratingscontrol'=> $ratingscontrol,'tagdisplay'=> $tagdisplay, 'categorydisplay' => $categorydisplay,
                'download'=> $downLoad,'timer'=> $playerTimer,'zoom'=> $playerZoom,'email'=> $shareEmail,'skin_autohide'=> $skinAutohide,'popular'=> $homePopular,'recent'=> $homeRecent,'feature'=> $homeFeature,
                'homecategory'=> $homeCategory,'width'=> $playerWidth,'height'=> $playerHeight,'stagecolor'=> $stageColor,'comment_option'=> $commentOption, 'logo_target'=> $logoTarget, 'logoalign'=> $logoAlign,
                'logoalpha'=> $logoAlpha,'ffmpeg_path'=> $ffmpegPath,'normalscale'=> $normalScale,'fullscreenscale' => $fullScreenscale, 'license'=> $licenseKey,'preroll'=> $preRoll,'postroll'=> $postRoll,
                'buffer'=> $buffer,'volume'=> $volume,'gutterspace'=> $gutterSpace, 'rowsPop'=> $rowsPop,'colPop'=> $colPop, 'rowsRec'=> $rowsRec,'colRec'=> $colRec,'rowsFea'=> $rowsFea,'colFea'=> $colFea,
                'rowCat'=> $rowCat, 'colCat'=> $colCat,'rowMore'=> $rowMore,'colMore'=> $colMore,'playlist'=> $playList, 'fullscreen'=> $fullScreen,'player_colors'=> serialize ( $player_color ), 
                'playlist_open'=> $playlist_open,'showPlaylist'=> $showPlaylist,'midroll_ads'=> $midroll_ads,'adsSkip'=> $adsSkip, 'adsSkipDuration' => $adsSkipDuration, 'relatedVideoView'=> $relatedVideoView,
                'imaAds'=> $imaAds,'trackCode'=> $trackCode,'showTag'=> $showTag,'shareIcon'=> $shareIcon,'volumecontrol'=> $volumecontrol, 'playlist_auto'=> $playlist_auto,'progressControl' => $progressControl,'imageDefault'=> $imageDefault );
            /** Call function to get logo path */
            $settingsData ['logopath'] = $this->uploadLogo ($logopath);
            return $settingsData;
        }
        
        /** 
         * Function for setting update  
         */
        public function update_settingsdata () {
          /** Check whether settings to update or not  */
          if (isset ( $this->_settingsUpdate )) {
            
            /** Check settings form data */
            $settingsData = $this->getSettingsData ();
            
            /** Store data formats into an array for all settings parameters */
            $settingsDataformat = array ( '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d','%d', '%d', '%d', 
              '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d','%d', '%s', '%d', '%d', '%d', '%d',
               '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', '%d', '%d', '%s', '%s','%s', '%s', '%s', '%d', '%d','%d', '%d', '%d', '%d', '%s'  );
            
            /** Call function to update settings data */
            $updateflag = $this->update_settings ( $settingsData, $settingsDataformat );     
            
            /** Check update action is done  
             * Redirect to settings page after updating data */
            if ($updateflag) { 
                $this->admin_redirect ( 'admin.php?page=hdflvvideosharesettings&update=1' );
            } else {
                $this->admin_redirect ( 'admin.php?page=hdflvvideosharesettings&update=0' );
            }
          }
        } 
  
        /** 
         * Function to upload logo image and get logo path
         * 
         * @param string $logopath
         * @return type
         */
        function uploadLogo ($logopath) {
            /** Get "videogallery" directory path from plugin helper */
            $uploadPath     = getUploadDirPath ();            
            /** Get logo file name and its type  */
            if (isset ( $_FILES ['logopath'] ['name'] ) && $_FILES ['logopath'] ['name'] != '') {              
                /** Store allowed file types into an array */
                $allowedExtensions  = array ( 'jpg', 'jpeg', 'png', 'gif' );
                $logoImage          = strtolower ( $_FILES ['logopath'] ['name'] );                
                /**
                 * Check whether the logo file type is exist in the allowed extensions
                 * If exist, move logo file to videogallery folder from temporary path
                 * Else display error message
                 */
                if ($logoImage && in_array ( end ( explode ( '.', $logoImage ) ), $allowedExtensions )) {
                    move_uploaded_file ( $_FILES ['logopath'] ['tmp_name'], $uploadPath . $_FILES ['logopath'] ['name'] );
                    /** Return uploaded logo file path */
                    return $_FILES ['logopath'] ['name'];
                } else {
                    /** If logo image is not exist or not valid extension then retur to settings page */
                    $this->admin_redirect ( 'admin.php?page=hdflvvideosharesettings&extension=1' );
                }
            } else {
                /** Return already uploaded logo path */
                return $logopath;
            }            
        }
      /**
       * Function redirect after save /update datas.
       *
       * @param type $url          
       */
      public function admin_redirect($url) {
        /** Display message after redirect to settings page */
          echo '<script>window.open( "' . $url . '","_top",false )</script>';
      }
  
      /**
       * Function for get setting data for view
       *
       * @return type $settings
       */
      public function settings_data() {
          /** Get settings data from model and return */ 
          return $this->get_settingsdata ();
      }
      
      /**
       * Function to show message  for setting update action
       * 
       * @return string $msg
       */
      public function get_message() { 
          /** Check settings update is success */ 
          switch ($this->_update) {
            case '1':
              /** Set settings update is success message */
              $this->_msg = __ ( 'Settings Updated  Successfully ...', APPTHA_VGALLERY );
              break;
            case '0':
              /** Set settings update is unsuccess message */
              $this->_msg = __ ( 'Settings Not Updated  Successfully ...', APPTHA_VGALLERY );
              break;
            default:
              $this->_msg = '';
              break;
          }
          
          if (isset ( $this->_extension ) && $this->_extension == 1) {
              /** Display allowed extension for logo file */
              $this->_msg = 'File Extensions : Allowed Extensions for image file [ jpg , jpeg , png ] only';
          }
          return $this->_msg;
      }
    /**  VideoadController class ends */
    }
/** Checks if the SettingsController class has been defined ends */
}
/** Creating object for VideoadController class  */
$settingsOBJ = new SettingsController ();
/** Call function to update settings data */
$settingsOBJ->update_settingsdata ();
/** Call function to display settings data from plugin helper */
$settingsGrid = getPluginSettings ();
/** Call function to display message */
$displayMsg   = $settingsOBJ->get_message ();
/** Get page parameter to include settings view */
$adminPage  = filter_input ( INPUT_GET, 'page' );
if ($adminPage == 'hdflvvideosharesettings') {
    require_once (APPTHA_VGALLERY_BASEDIR . DS . 'admin/views/videosetting.php');
}
?>