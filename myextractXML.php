<?php
/**  
 * Video player myextract xml file for video details and related  video settings.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Include config file for playlist xml */ 
require_once (dirname ( __FILE__ ) . '/hdflv-config.php');
/** Variable Decalration and set defualt values */
$banner   = 0;
$islive   = $streamer = $videoPreview = $videotag = $postroll_id = $featured =  '';
$singleVideodata = array();
/** Create object for Videohome view class */
$pageOBJ  = new ContusVideoView ();
/** Create object for Videohome controller class */ 
$contOBJ  = new ContusVideoController ();
/** Get video ID  from video home view */
$getVid   = $pageOBJ->_vId;
/** Get playlist ID from video home view */
$getPid   = $pageOBJ->_pId; 
/**
 * Get number of videos from URL
 * If it is empty then get related videos count from settings
 */ 
$numberofvideos = filter_input ( INPUT_GET, 'numberofvideos' ); 
if (empty ( $numberofvideos )) {
    $numberofvideos = get_related_video_count ();
}
/** If number of videos are empty then set default value as 4 */
if (empty ( $numberofvideos )) {
    $numberofvideos = 4;
}
/** Get featured from URL */
$featured = filter_input ( INPUT_GET, 'featured' );
/** Get adminview from URL */
$adminView = filter_input ( INPUT_GET, 'adminview' );
/** Get type from URL */
$type = filter_input ( INPUT_GET, 'type' );
/** Check whether banner player is used */
if (! empty ( $numberofvideos ) && ! empty ( $type )) {
    $banner = 1;
}
/** Check type parameter */
if (! empty ( $type ) && $type == 1) { 
    /** If type is 1 then, set thumbimage order and condition for popular videos */  
    $thumImageorder   = 'w.hitcount DESC';
    $where            = '';
    /** Fetch popular video details */
    $singleVideodata = $contOBJ->home_playxmldata ( $getVid, $thumImageorder, $where, $numberofvideos );
} else if (! empty ( $type ) && $type == 2) { 
    /** If type is 2 then, set thumbimage order and condition for recent videos */
    $thumImageorder   = 'w.vid DESC';
    $where            = '';
    /** Fetch recent video details */
    $singleVideodata  = $contOBJ->home_playxmldata ( $getVid, $thumImageorder, $where, $numberofvideos );    
} else if (! empty ( $type ) && $type == 3) {
    /** If type is 2 then, set thumbimage order and condition for featured videos */
    $thumImageorder = 'w.ordering ASC';
    $where = 'AND w.featured=1';
    /** Fetch featured video details */
    $singleVideodata = $contOBJ->home_playxmldata ( $getVid, $thumImageorder, $where, $numberofvideos );    
} else if (! empty ( $getVid )) {
    /** If video id is exist then, fetch particular video detail */
    $singleVideodata = $contOBJ->video_detail ( $getVid );     
} else if (! empty ( $getPid )) {
    /** If playlist id is exist then, fetch video details for particular playlist */
    $singleVideodata = $contOBJ->video_Pid_detail ( $getPid, 'playxml', $numberofvideos );    
} else { 
    /** Else fetch featured videos by default */
    if($featured) {
      $singleVideodata = $pageOBJ->_featuredvideodata;
    }
}

/** Get setting values from helper */
$settingsContent      = getPluginSettings ();
/** Get plugin "uploads/ videogallery" directory URL */
$uploadPath = getUploadDirURL();
/** Get images directory path */
$pageOBJ->_imagePath  = getImagesDirURL();
/** Set default value for playlist autoplay */
$ap   = 'false';
/** Check playlist autoplay and set value */
if ($settingsContent->playlistauto == 1) {
  $ap = 'true';
} 
/** Set content type and char set for playlist xml */
header ( 'content-type:text/xml;charset = utf-8' );
/** Set XML version and encoding */
echo '<?xml version = "1.0" encoding = "utf-8"?>';
/** Playlist XML starts */
echo '<playlist autoplay = "' . $ap . '" random = "false">';
/** Looping all video details */ 
foreach ( $singleVideodata as $media ) {
  $fbPath     = $duration = '';
  /** Get video file type */
  $file_type  = $media->file_type;
  /**
   * Check video file type is 5. 
   * If not then get video details
   */
  if ($file_type != 5) {
      /** Get file from video details */
      $videoUrl       = $media->file;
      /** Get hd file from video details */
      $hdvideoUrl     = $media->hdfile;
      /** Get video id from video details */
      $vidoeId        = $media->vid;
      /** Get hitcount from video details */
      $views          = $media->hitcount;
      /** Get video duration */
      if (! empty ( $media->duration ) && $media->duration != '0:00') {
        $duration     = $media->duration;
      }
      /** Get guid if banner player is not exist  */
      if ($banner != 1) {
        $fbPath       = $media->guid;
      }    
      /** Get thumb image detail */
      $image          = getImagesValue ( $media->image, $file_type, $media->amazon_buckets, '' );      
      /** Get preview image detail */
      $opimage        = getImagesValue ( $media->opimage, $file_type, $media->amazon_buckets, 1);      
      /** Get video url detail for upload method */ 
      $videoUrl       = getVideosValue ( $media->file, $file_type, $media->amazon_buckets );      
      /** Get HD video url detail for upload method */ 
      $hdvideoUrl     = getVideosValue ( $media->hdfile, $file_type, $media->amazon_buckets );
      /** Check file type is rtmp */
      if ($file_type == 4) {
          /** Get RTMP streamer path and islive option */
          $streamer = $media->streamer_path;
          $islive   = ($media->islive == 1) ? 'true' : 'false';
      }    
      /** Get subtitle1 value */ 
      $subtitle1  = $media->srtfile1;
      /** Get subtitle2 value */
      $subtitle2  = $media->srtfile2;
      /**  Check subtitle1 and subtitle 2 is exist */
      if (! empty ( $subtitle1 ) && ! empty ( $subtitle2 )) {
          /** If both files exist then get full path for two files */
          $subtitle = $uploadPath . $subtitle1 . ',' . $uploadPath . $subtitle2;
      } else if (! empty ( $subtitle1 )) {
          /** If subtitle1 file is exist then get full path for that */
          $subtitle = $uploadPath . $subtitle1;
      } else if (! empty ( $subtitle2 )) {
          /** If subtitle2 file is exist then get full path for that */
          $subtitle = $uploadPath . $subtitle2;
      } else {
        /** If subtitle1, subtitle2 file is not exist then set empty values */
        $subtitle = '';
      }      
      
      /** Set pre roll ads as false and id to 0 by default */
      $preroll      = ' allow_preroll = "false"';
      $preroll_id   = ' preroll_id = "0"';
      
      /** Check pre roll option is enabled in settings page */ 
      /** Check preroll is enabled for particular video */
      if ($settingsContent->preroll != 1 && $media->prerollads != 0) {
              /** Set true and pass pre roll video id */
              $preroll    = ' allow_preroll = "true"';
              $preroll_id = ' preroll_id = "' . $media->prerollads . '"';
      } 
         
      /** Set midroll ad as false */
      $midroll = ' allow_midroll = "false"';
      /**  Check midroll is enabled for particular video */
      if ($media->midrollads != 0) {
        /** Set midroll ad as true */
          $midroll = ' allow_midroll = "true"';
      } 
           
      /** Set ima ad as false */
      $imaad = ' allow_ima = "false"';
      /**  Check ima ad is enabled for particular video */
      if ($media->imaad != 0) {
        /** Set ima ad as true */
          $imaad = ' allow_ima = "true"';
      }   

      /** Set post roll ads as false and id to 0 by default */
      $postroll = ' allow_postroll = "false"';
      $postroll_id = ' postroll_id = "0"';
      /** Check post roll option is enabled in settings page */ 
      /** Check post roll is enabled for particular video */
      if ($settingsContent->postroll != 1 && $media->postrollads != 0) {
        /** Set true and pass post roll video id */
              $postroll = ' allow_postroll = "true"';
              $postroll_id = ' postroll_id = "' . $media->postrollads . '"';
      }
            
      /** Check download allowed or not */ 
      $individualdownload = $media->download;
      /** Check file type is not custom url and download option is enabled */
      if ((((isset ( $individualdownload [0] ) && $individualdownload [0] == 1) || (isset ( $individualdownload ) && $individualdownload == 1)))) {
          if( $file_type != 3) {
            $download = 'true';
          }    
      } else {
            $download = 'false';
      } 
      
      /** Generate playlist XML content */
      echo '<mainvideo views="' . $views . '"  subtitle ="' . $subtitle . '"  duration="' . $duration . '"  streamer_path="' . $streamer . '"  
              video_isLive="' . $islive . '"  video_id = "' . htmlspecialchars ( $vidoeId ) . '"  fbpath = "' . $fbPath . '" 
              video_url = "' . htmlspecialchars ( $videoUrl ) . '"  video_hdpath = "' . $hdvideoUrl . '"  allow_download = "' . $download . '"  
              thumb_image = "' . htmlspecialchars ( $image ) . '"  preview_image = "' . htmlspecialchars ( $opimage ) . '"  
              copylink = "" ' . $midroll . ' ' . $imaad . ' ' . $postroll . ' ' . $preroll . ' ' . $postroll_id . ' ' . $preroll_id . '>
                  
                  <title> <![CDATA[' . strip_tags ( $media->name ) . ']]> </title> 
                  <tagline targeturl=""> <![CDATA[' . strip_tags ( $media->description ) . ']]> </tagline> 
            </mainvideo>';
    }
}
/** Playlist XML end here */
echo '</playlist>';
?>