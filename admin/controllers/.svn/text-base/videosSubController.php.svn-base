<?php
/**  
 * Videos page sub Controller file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Checks if the VideosPageController class has been defined starts */
if ( !class_exists ( 'VideosPageController' ) ) {
  /** VideosPageController class starts */
  class VideosPageController extends VideoController {
    /**
     * Function to convert video duration into h:m:s format
     * 
     * @param unknown $sec
     * @return string
     */
    public function converttime($sec) {
      $hms    = $padHours = '';
      /** Calculate hours / minutes / seconds and return the values in h:m:s format */
      $hours  = intval ( intval ( $sec ) / 3600 );
      $hms    .= ($padHours) ? str_pad ( $hours, 2, '0', STR_PAD_LEFT ) . ':' : $hours . ':';
      if ($hms == '0:') {
        $hms  = '';
      }
      /** Calculate minutes */
      $minutes = intval ( ($sec / 60) % 60 );
      /** Condition if less than 9 mins */
      if( $minutes < 9 && $hms ) {
        $minutes = '0:' . $minutes;
      }
      $hms    .= str_pad ( $minutes, 1, '0', STR_PAD_LEFT ) . ':';
      /** Calculate seconds */
      $seconds = intval ( $sec % 60 );
      /** Return seconds */
      return $hms . str_pad ( $seconds, 2, '0', STR_PAD_LEFT );
    }
    
    /**
     * Function to add/delete and update playlist 
     * while adding new / edit videos
     * 
     * @param unknown $insertflag
     */
    public function addUpdatePlaylist ($insertflag) {
      $act_playlist = '';
      $old_playlist = array ();
      /** Get inserted video id */
      $video_aid    = $insertflag;
      /** Get hid, playlist parameters from the form request */
      $pieces               = explode ( ',', $_POST ['hid'] );
      if (! empty ( $_POST ['playlist'] )) {
        $act_playlist       = $_POST ['playlist'];
      }
      /** Check if video edit action is done and playlist id is exist */
      if ($this->_videoId && is_array ( $act_playlist )) {
        /** Get playlist id's for the corresponding video */
        $old_playlist     = $this->_wpdb->get_col ( ' SELECT playlist_id FROM ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play WHERE media_id =' . $this->_videoId );
        /** Pld playlist details */
        if (!empty( $old_playlist) && isset($old_playlist)) {
        	/** Get unique video details */
          $old_playlist   = array_unique ( $old_playlist );
        }    
        /** If old playlist is differ with new playlists, then remove the difference */
        $delete_list      = array_diff ( $old_playlist, $act_playlist );
        /** Check delete list is availabe */
        if ($delete_list) {
          /** Loop for deleting each video */
          foreach ( $delete_list as $del ) {
            $this->_wpdb->query ( ' DELETE FROM ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play WHERE playlist_id = ' . $del . ' AND media_id =' . $this->_videoId );
          }
        }    
        /** If new playlist is differ with old playlists, then add the difference */
        $add_list       = array_diff ( $act_playlist, $old_playlist );
        /** Get current video id */
        $currentVideoID = $this->_videoId;
      } /** If not video edit get current video id */
       else {
       	/** Check the playlist array */
        $checkResult = true;
      }
      if( $checkResult == true && ($video_aid && is_array ( $act_playlist ))) {
      		$add_list       = array_diff ( $act_playlist, array () );
      		$currentVideoID = $video_aid;
      }    
      /** Create new playlist */
      if ($add_list) {
        foreach ( $add_list as $new_list ) {
          $this->_wpdb->query ( ' INSERT INTO ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play ( media_id,playlist_id,sorder ) VALUES ( ' . $currentVideoID . ', ' . $new_list . ', 0 )' );
        }
      }
      $i = 0;
      /** Update playlist */
      foreach ( $pieces as $new_list ) {
        $this->_wpdb->query ( ' UPDATE ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play SET sorder= 0 WHERE media_id = ' . $currentVideoID . ' and playlist_id = ' . $new_list );
        $i ++;
      }
    }
    
    /**
     * Function to insert tags name into db
     * 
     * @param unknown $insertflag
     */
    public function insertTags ( $insertflag ) {
      /** Get tag params from the request */
      $tags_name            = filter_input ( INPUT_POST, 'tags_name' );
      /** Get seo name for tag params */
      $strip_tags_name      = strtolower ( stripslashes ( $tags_name ) );
      /** Strip tags in video name */
      $ambersand_tags_name  = preg_replace ( '/[&:\s]+/i', '-', $strip_tags_name );
      /** Strip braces in video name */
      $spl_tags_name        = preg_replace ( '/[#!@$%^.,:;\/&*(  ){}\"\'\[\]<>|?]+/i', '', $ambersand_tags_name );
      /** Strip tags and - */
      $seo_tags_name        = preg_replace ( '/---|--+/i', '-', $spl_tags_name );
      /**  Insert or update tag info into tags table */
      if($this->_videoId  && empty($insertflag) ) {
        /** Get video id from tags table */
        $insert_tags_name     = $this->_wpdb->get_var ( 'SELECT media_id FROM ' . $this->_wpdb->prefix . 'hdflvvideoshare_tags WHERE media_id =' . $this->_videoId );
        /** If video id is empty then insert new record into tags table
         * Else Update tags info for corresponding video id   */
        if (empty ( $insert_tags_name )) {
          /** Insert tag names seo title */
          $this->_wpdb->query ( 'INSERT INTO ' . $this->_wpdb->prefix . 'hdflvvideoshare_tags ( media_id,tags_name,seo_name ) VALUES ( ' . $this->_videoId . ', "' . $tags_name . '", "' . $seo_tags_name . '" )' );
        } else {
          $this->_wpdb->query ( 'UPDATE ' . $this->_wpdb->prefix . 'hdflvvideoshare_tags SET tags_name="' . $tags_name . '",seo_name="' . $seo_tags_name . '" WHERE media_id = ' . $this->_videoId );
        }
      } else {
        /** Insert tag name video name  */
        if (! empty ( $tags_name )) {
          $this->_wpdb->query ( 'INSERT INTO ' . $this->_wpdb->prefix . 'hdflvvideoshare_tags ( media_id,tags_name,seo_name ) VALUES ( ' . $insertflag . ', "' . $tags_name . '", "' . $seo_tags_name . '" )' );
        }
      }
    }
  /** VideosPageController class ends */
  }
/** Checks if the VideosPageController class has been defined ends */
}

/**  Checks if the VideosPageSubController class has been defined starts */
if ( !class_exists ( 'VideosPageSubController' ) ) {
  /** VideosPageSubController class starts */
  class VideosPageSubController extends VideosPageController {
    /**
     * Function to set subtitle values and perform add / update video action
     *
     * @param array $videoData
     */
    public function addUpdateVideoData ($videoData) {
      $subtitle1 = $subtitle2 = $new_subtitle1 = $new_subtitle2 = $sub_title1 = $sub_title2 = NULL;
      /** Get subtitle1form-value from params */
      $subtitle1 = filter_input ( INPUT_POST, 'subtitle1form-value' );
      /** Get subtitle2form-value from params */
      $subtitle2 = filter_input ( INPUT_POST, 'subtitle2form-value' );
      /** Get subtitle language1 values */
      $subtitle_lang1 = filter_input ( INPUT_POST, 'subtitle_lang1' );
      /** Get subtitle language2 values */
      $subtitle_lang2 = filter_input ( INPUT_POST, 'subtitle_lang2' );
      /** Store subtitle files, language into video data array */
      $videoData ['srtfile1']       = $subtitle1;
      $videoData ['subtitle_lang1'] = $subtitle_lang1;
      $videoData ['srtfile2']       = $subtitle2;
      $videoData ['subtitle_lang2'] = $subtitle_lang2;
      /** For video edit action */
      if ($this->_videoId) {
        /**
         * Get slug id from videos table
         * Update video details, slug for the corresponding video
         */
        $slug_id            = $this->_wpdb->get_var ( 'SELECT slug FROM ' . $this->_wpdb->prefix . 'hdflvvideoshare WHERE vid =' . $this->_videoId );
        $videoData ['slug'] = $slug_id; 
        $updateflag = $this->video_update ( $videoData, $this->_videoId );
        /**
         * Get current sub title values
         * Then rename srt files based on the video id
         * After that update sub title values into db
         */
        $new_subtitle1  = $this->renameSRTFiles ( $subtitle1, $subtitle_lang1, $sub_title1, '1');
        $new_subtitle2  = $this->renameSRTFiles ( $subtitle2, $subtitle_lang2, $sub_title2, '2');
        $this->_wpdb->query ( ' UPDATE ' . $this->_wpdb->prefix . 'hdflvvideoshare SET srtfile1= "' . $new_subtitle1 . '",srtfile2= "' . $new_subtitle2 . '" , subtitle_lang1="' . $subtitle_lang1 . '" ,  subtitle_lang2 ="' . $subtitle_lang2 . '"  WHERE vid = ' . $this->_videoId );
        /**
         * Call function to add / delete/ update playlist id from database
         * Uppdate tags table into db
         */
        $this->addUpdatePlaylist ('');
        $this->insertTags ('');
        /**
         * Update for video if ends
         * Redirect to update video page
         */
        $this->redirectVideosPage ( $updateflag, 'update', '');
      }
      else {
        /** Adding video else starts */
        $insertflag = $this->insert_video ( $videoData ); 
        /** Check video is inserted and id ix exist */
        if ($insertflag != 0) {
          /** Rename srt files in videogallery folder
           * Then update srt file values for corresponding videos in db */
          if (! empty ( $subtitle1 )) {
            /** Rename subtitle1 file */
            
            $new_subtitle1  = $insertflag . '_' . $subtitle_lang1 . '.srt';
            $sub_title1     = rename ( $this->_srt_path . $subtitle1, $this->_srt_path . $new_subtitle1);
            if(!$sub_title1) { 
              $new_subtitle1 = '';
            }
          }
          if (! empty ( $subtitle2 )) {
            /** Rename subtitle2 file */
            $new_subtitle2 = $insertflag . '_' . $subtitle_lang2 . '.srt';
            $sub_title2 = rename ( $this->_srt_path . $subtitle2, $this->_srt_path . $new_subtitle2 );
            if(!$sub_title2) {
              $new_subtitle2 = '';
            }
          }
          /** Execute update query to udpate srt file name in db */
          $this->_wpdb->query ( ' UPDATE ' . $this->_wpdb->prefix . 'hdflvvideoshare SET subtitle_lang1 = "' . $subtitle_lang1 . '" , subtitle_lang2 = "' . $subtitle_lang2 . '" , srtfile1= "' . $new_subtitle1 . '",srtfile2= "' . $new_subtitle2 . '" WHERE vid = ' . $insertflag );
          /** Call function to add data into tags table, playlist into media table */
          $this->insertTags ( $insertflag );
          /** Call function to update playlist */
          $this->addUpdatePlaylist ( $insertflag );
        }
        /**
         * Adding video else ends
         * Redirect to all videos page
         */
        $this->redirectVideosPage ( $insertflag, 'add', '');
      }
    }
    
    /**
     * Function to get video url based on amazon bucket
     * 
     * @param string $file
     * @return string $result
     */
    public function getAmazonURLOrUploadFile ( $file, $s3bucket_name ) {
      $result = ''; 
      if (! empty ( $file )) {
        /**
         * Check already the video have amazon bucket URL.
         * If not, then create bucket URL
         * for the uploaded video
         */
        if (strpos ( $file, '/' )) {
          $result = $file;
        } else { 
          /** Include s3 config file */
          if(file_exists(APPTHA_VGALLERY_BASEDIR . '/helper/s3_config.php')) { 
             include APPTHA_VGALLERY_BASEDIR . '/helper/s3_config.php';
          }
          /** Check object is exists and video is moved to bucket */
          if ($s3->putObjectFile ( $this->_srt_path . $file, $s3bucket_name, $file, S3::ACL_PUBLIC_READ )) {
            /** Get bucket URL for inserted video */
            $result = 'http://' . $s3bucket_name . '.s3.amazonaws.com/' . $file;
          }
        }
      }
      /** Return bucket URL to add into db */
      return $result;
    }
    
    /**
     * Function to renmae srt files while editing video
     * 
     * @param string $subtitle
     * @param string $subtitle_lang
     * @param string $sub_title
     * @return string $new_subtitle
     */
    public function renameSRTFiles ( $subtitle, $subtitle_lang, $sub_title, $val) {
      if (! empty ( $subtitle )) {
        $sub_title_path  = $this->_srt_path . $subtitle;
        /** Check if srt file is exist in uploaded folder 
         *  Rename the file with curernt video id */
        if (file_exists ( $sub_title_path ) && ( $subtitle != $new_subtitle )) {
          $new_subtitle   = $this->_videoId . '_' . $subtitle_lang . '.srt';
          rename ( $sub_title_path, $this->_srt_path . $new_subtitle );
        } else {
          $new_subtitle   = $sub_title;
        }
      } else {
        /** Else assign empty value */
        $new_subtitle     = '';
      }
      /** Return subtitle file name */
      return $new_subtitle;
    }
  /** VideosPageSubController class ends */    
  }
/** Checks if the VideosPageSubController class has been defined ends */
}

/** Checks if the VideosSubController class has been defined starts */
if ( !class_exists ( 'VideosSubController' ) ) {  
  /** VideoController class starts */
  class VideosSubController extends VideosPageSubController {
    /** Function for adding video and update status / featured. */
    public function add_newvideo() {
      /** Variable declaration and initialization */
      $match =  '';
      /** Assign youtube URL without id */
      $youtubeVideoURL = 'http://www.youtube.com/watch?v=';
      /** Check video status is exists  */ 
      if (isset ( $this->_status ) || isset ( $this->_featured )) {
        /** Call function to update video status */
          $this->status_update ( $this->_videoId, $this->_status, $this->_featured );
      }    
      /** Check whether to add / update video */
      if ($this->_addnewVideo) {
        /** Get video name parameters from the request */
        $videoName        = filter_input ( INPUT_POST, 'name' );
        /** Get video description parameters from the request */
        $videoDescription = filter_input ( INPUT_POST, 'description' );
        /** Get embed_code parameters from the request */
        $embedcode        = filter_input ( INPUT_POST, 'embed_code' );
        /** Get publish parameters from the request */
        $videoPublish     = filter_input ( INPUT_POST, 'publish' );
        /** Get feature parameters from the request */
        $videoFeatured        = filter_input ( INPUT_POST, 'feature' );
        /** Get download parameters from the request */
        $videoDownload        = filter_input ( INPUT_POST, 'download' );
        /** Get midrollads parameters from the request */
        $videomidrollads      = filter_input ( INPUT_POST, 'midrollads' );
        /** Get imaad parameters from the request */
        $videoimaad           = filter_input ( INPUT_POST, 'imaad' );
        /** Get postrollads parameters from the request */
        $videoPostrollads     = filter_input ( INPUT_POST, 'postrollads' );
        /** Get prerollads parameters from the request */
        $videoPrerollads      = filter_input ( INPUT_POST, 'prerollads' );
        /** Get googleadsense parameters from the request */
        $google_adsense       = filter_input ( INPUT_POST, 'googleadsense' );
        /** Get google_adsense_value parameters from the request */
        $google_adsense_value = filter_input ( INPUT_POST, 'google_adsense_value' );
        /**
         * Get member id from request.
         * If not get current user id
         */
        $member_id            = filter_input ( INPUT_POST, 'member_id' );
        if (empty ( $member_id )) {
          $current_user = wp_get_current_user ();
          $member_id    = $current_user->ID;
        }
        /** Get upload video form params */
        $video1 = filter_input ( INPUT_POST, 'normalvideoform-value' );
        /** Get upload hd video form params */
        $video2 = filter_input ( INPUT_POST, 'hdvideoform-value' );
        /** Get thumb image form params */
        $img1 = filter_input ( INPUT_POST, 'thumbimageform-value' );
        /** Get preview image form params */
        $img2 = filter_input ( INPUT_POST, 'previewimageform-value' );
        /**  Get streamer path option for rtmp streaming */
        $islive           = filter_input ( INPUT_POST, 'islive-value' );
        /**  Get is live option for rtmp streaming */
        $streamname       = filter_input ( INPUT_POST, 'streamerpath-value' );
        /** Get Youtube video url from request */
        $videoLinkurl     = filter_input ( INPUT_POST, 'youtube-value' );
        /** Set video duration */
        $duration = '0:00';
        /** Get video added method */
        $video_added_method = filter_input ( INPUT_POST, 'filetypevalue' );
        /** Get amazon bucket params */
        $amazon_buckets     = filter_input ( INPUT_POST, 'amazon_buckets' );
        /** Check youtbe / youtu.be / dailymotion / viddler video url is exists */
        if ($videoLinkurl != '') {
          /** Attach http with video url */
          if (preg_match ( '#https?://#', $videoLinkurl ) === 0) {
            $videoLinkurl = 'http://' . $videoLinkurl;
          }
          /** Remove spaces in video url */
          $act_filepath = addslashes ( trim ( $videoLinkurl ) );
        }
        if ($videoLinkurl != '' && $act_filepath != '') {
          /** Set file type 1 for YouTube/ viddler /dailymotion  */
          $file_type = '1';
          /** Check video url contains youtbe / youtu.be / dailymotion / viddler */
          if ( (strpos ( $act_filepath, 'youtube' ) > 0 ) || (strpos ( $act_filepath, 'youtu.be' ) > 0) ) {
            /** Get youtube video id from plugin helper */
            $youtubeVideoID  = getYoutubeVideoID ( $act_filepath );
            /** Get thumb URL for YouTube videos */
            $act_opimage  = $previewurl   = 'http://img.youtube.com/vi/' . $youtubeVideoID . '/maxresdefault.jpg';
            /** Get preview URL for YouTube videos */
            $act_image    = $img          = 'http://img.youtube.com/vi/' . $youtubeVideoID . '/mqdefault.jpg';
            /** Get YouTube video URL and fetch information  */
            $act_filepath = $youtubeVideoURL . $youtubeVideoID; 
            $ydetails = hd_getsingleyoutubevideo( $youtubeVideoID );
            /** Get youTube video duration */
            $youtube_time = $ydetails['items'][0]->contentDetails->duration;
            if(!empty($youtube_time)) {
                /** Convert duration into h:m:s format */
                $di = new DateInterval($youtube_time);
                $string = '';
                $min =  $di->i;
                if ($di->h > 0) {
                  $string .= $di->h.':';
                  /** Check if minutes is <= 9 while hours value is exist */ 
                  if($min <= 9 ){ 
                     $min = '0' . $min;
                  }
                }
                $duration = $string . $min . ':' .$di->s;
            }
          } else if (strpos ( $act_filepath, 'dailymotion' ) > 0) {
            /** Check video URL is dailymotion
             * If yes, then get id from the url and get thumb, preview image */
            $split_id     = getDailymotionVideoID ( $act_filepath );
            $img          = $act_image = $act_opimage = $previewurl = 'http://www.dailymotion.com/thumbnail/video/' . $split_id [0];
          } else if (strpos ( $act_filepath, 'viddler' ) > 0) {
            /** Check video url is viddler
             * If yes, then get id from the url and get thumb, preview image */
            $imgstr     = explode ( '/', $act_filepath );
            $img        = $act_image = $act_opimage = $previewurl = 'http://cdn-thumbs.viddler.com/thumbnail_2_' . $imgstr [4] . '_v1.jpg';
          } else {
            $img = '';
          }
        } else {
          /** Get video upload form value */
          $act_filepath1 = $_REQUEST ['normalvideoform-value'];
          /** Combine upload directory path and file name */
          $act_filepath1 = $this->_srt_path . $act_filepath1;
          /**
           * Check whether custom url option is used
           * If yes, then get video url, thumb url and remove spaces
           * Else, set video url, thumb url as empty
           */
          $act_filepath = $act_optimage = '';
          if (isset ( $_POST ['custom_url'] )) {
            $act_filepath = addslashes ( trim ( $_POST ['customurl'] ) );
            $act_optimage = addslashes ( trim ( 'thumb_' . $_POST ['custom_url'] ) );
          }
          /** Get ffmpeg settings value */
          $ffmpeg_path = $this->_settingsData->ffmpeg_path;
          /** Set file type as 2 for upload method */
          $file_type = '2';
          /** Get uploaded video duration from plugin helper using ffmpeg */
          $ffmpegResult = getVideoDuration ( $ffmpeg_path, $act_filepath1 );
          $duration     = $ffmpegResult [0];
          $matches      = $ffmpegResult [1];
          if (! empty ( $duration )) {
            /** Convert duration into hours:minutes format */
            $duration_array = explode ( ':', $matches [1] [0] );
            $sec            = ceil ( $duration_array [0] * 3600 + $duration_array [1] * 60 + $duration_array [2] );
            $duration       = $this->converttime ( $sec );
          }
        }
    
        /** If upload new image for existing video, then rename the images name */
        if ($this->_videoId) {
          $newImagePath             = $this->_srt_path . $img1;
          $newPreviewImagePath      = $this->_srt_path . $img2;
          $newThumbFileName         = explode ( '_', $img1 );
          $newPreviewThumbFileName  = explode ( '_', $img2 );
          /**
           * Check if added method is upload
           */
          if ($video_added_method == 2) {
            /**
             * Check thumb image is exst in the directory
             * If exit then rename the new thumb image with the video id
             */
            if (file_exists ( $newImagePath )) {
              $img1 = $this->_videoId . '_' . $newThumbFileName [1];
              rename ( $newImagePath, $this->_srt_path . $img1 );
            }
            if (file_exists ( $newPreviewImagePath ) && ! empty ( $newPreviewThumbFileName [1] )) {
              /**
               * Check preview image is exst in the directory
               * If exit then rename the new preview image with the video id
               */
              $img2 = $this->_videoId . '_' . $newPreviewThumbFileName [1];
              rename ( $newPreviewImagePath, $this->_srt_path . $img2 );
            }
          }    
          /**
           * Check if video added method is embed code
           */
          if ($video_added_method == 5) {
            $newThumbFileName = explode ( '_', $img1 );
            /**
             * Check image is exst in the directory
             * If exit then rename the new image with the video id
             */
            if (file_exists ( $newImagePath )) {
              $img1 = $img2 = $this->_videoId . '_' . $newThumbFileName [1];
              rename ( $newImagePath, $this->_srt_path . $img1 );
            }
          }
        }    
        /**
         * Get Amazon S3 bucket settings from database
         */
        $player_colors            = getPlayerColorArray ();
        /**
         * Check if bucket option is enabled and name is exist
         */
        if ($player_colors ['amazonbuckets_enable'] && $player_colors ['amazonbuckets_name']) {
            /**
             * Get bucket name
             */
            $s3bucket_name = $player_colors ['amazonbuckets_name'];
            /**
             * Check video is exist
             * If exist then get bucket video for uploaded videos
             */
            $video1 = $this->getAmazonURLOrUploadFile ( $video1, $s3bucket_name );
            /** Get bucket hd video for uploaded videos */
            $video2 = $this->getAmazonURLOrUploadFile ( $video2, $s3bucket_name );
            /** Get bucket thumb image for uploaded videos */
            $img1   = $this->getAmazonURLOrUploadFile ( $img1, $s3bucket_name );
            /** Get bucket preview image for uploaded videos */
            $img2   = $this->getAmazonURLOrUploadFile ( $img2, $s3bucket_name );
        }
        /** Get customurl parameter */
        $act_image = addslashes ( trim ( $_POST ['customurl'] ) );
        $act_hdpath = $act_name = $act_opimage = '';
        /** If video url is not empty then get image and preview image */
        if (! empty ( $act_filepath )) {
          /** Set file type 1 for YouTube, dailymotion and viddler videos */
          $file_type = '1';
          if (strpos ( $act_filepath, 'youtube' ) > 0 || strpos ( $act_filepath, 'youtu.be' ) > 0) {
            /**
             * Get Youtube video id
             * Based on that get video URL , image, preview image 
             */
            $match  = getYoutubeVideoID ( $act_filepath );
            $act_filepath = $youtubeVideoURL . $match;
            /** Get thumbimage for youtube video */
            $act_image = 'http://i3.ytimg.com/vi/' . $match . '/mqdefault.jpg';
            /** Get previewimage for youtube video */
            $act_opimage = 'http://i3.ytimg.com/vi/' . $match . '/maxresdefault.jpg';
            /** Call fucntion to get YouTube video information */
            $ydetails = hd_getsingleyoutubevideo( $match );
            if ( $ydetails ) {
              if ( $act_name == '' ){
                /** Get youtube video title */
                $act_name = addslashes( $ydetails['items'][0]->snippet->title);
              }
            }
            else {
              /** Else display error for youtube videos*/
              render_error( __( 'Could not retrieve Youtube video information', APPTHA_VGALLERY ) );
            }
          } else if (strpos ( $act_filepath, 'dailymotion' ) > 0) {
            /** Get dailymotion video id */
            $split_id = getDailymotionVideoID ( $act_filepath );
            /** Get dailymotion video and thumb url */
            $act_image = $act_opimage = 'http://www.dailymotion.com/thumbnail/video/' . $split_id [0];
          } else if (strpos ( $act_filepath, 'viddler' ) > 0) {
            /** Get viddler video id */
            $imgstr = explode ( '/', $act_filepath );
            /** Get viddler video thumb and preview image */
            $act_image = $act_opimage = 'http://cdn-thumbs.viddler.com/thumbnail_2_' . $imgstr [4] . '_v1.jpg';
          } else {
            $imgstr = '';
          }
        } else {
          if ($video1 != '') {
            $act_filepath = $video1;
          }
          if ($video2 != '') {
            $act_hdpath = $video2;
          }
          if ($img1 != '') {
            $act_image = $img1;
          }
          if ($img2 != '') {
            $act_opimage = $img2;
          }
        }
        /** Set filetype as 5 for embed method */
        if (! empty ( $embedcode )) {
          $video_added_method = $file_type = '5';
        }        
        /** Get video details for URL type videos */
        if ($video_added_method == 3) {
          $act_filepath = $_POST ['customurl'];
          $act_image    = $_POST ['customimage'];
          $act_opimage  = $_POST ['custompreimage'];
          $act_hdpath   = $_POST ['customhd'];
        }
        /** Get video details for rtmp videos */
        if (! empty ( $streamname )) {
          $file_type    = '4';
          /** Get filepath3 from params */
          $thumb_image  = filter_input ( INPUT_POST, 'filepath3' );
          $act_image    = $thumb_image;
          $act_opimage  = $thumb_image;
        }
        if ($video_added_method == 4) {
          /** Get custom url from params */ 
          $act_filepath = filter_input ( INPUT_POST, 'customurl' );
          /** Get customhd from params */
          $act_hdpath   = filter_input ( INPUT_POST, 'customhd' );
          /** Get customimage from params */
          $act_image    = filter_input ( INPUT_POST, 'customimage' );
          /** Get custompreimage from params */
          $act_opimage  = filter_input ( INPUT_POST, 'custompreimage' );
        }
        /** Store video form values into single array */
        $videoData = array ( 'name' => $videoName, 'description' => $videoDescription, 'embedcode' => $embedcode, 'file' => $act_filepath, 'file_type' => $video_added_method,
          'member_id' => $member_id, 'duration' => $duration, 'hdfile' => $act_hdpath, 'streamer_path' => $streamname, 'islive' => $islive,
          'image' => $act_image, 'opimage' => $act_opimage, 'link'  => $videoLinkurl, 'featured' => $videoFeatured, 'download' => $videoDownload,
          'postrollads' => $videoPostrollads, 'midrollads'  => $videomidrollads, 'imaad' => $videoimaad, 'prerollads' => $videoPrerollads,
          'publish'     => $videoPublish, 'google_adsense' => $google_adsense, 'google_adsense_value' => $google_adsense_value, 'amazon_buckets' => $amazon_buckets );
        /**
         * Get current date and assign default value
         * for srt files, language and slug
         */
        //$videoData ['post_date']  = date ( 'Y-m-d H:i:s' );
        if (empty ( $this->_videoId )) {
          $videoData ['ordering'] = getAllVideosCount ();
          $videoData ['slug']     = $videoData ['srtfile1'] = $videoData ['srtfile2'] = $videoData ['subtitle_lang1'] = $videoData ['subtitle_lang2'] = '';
        } 
        /** Call funtion to perform add / update action */
        $this->addUpdateVideoData ( $videoData);
      }
    }
  /** VideosSubController class ends  */
  }
/** Checks if the VideosSubController class has been defined ends */
}
/** Fetch page parameter from the request URL */
$adminPage = filter_input ( INPUT_GET, 'page' );
/** Include grid page or add video page based on the request */
switch( $adminPage) {
  case 'newvideo':
    require_once (APPTHA_VGALLERY_BASEDIR . DS . 'admin/views/video/addvideo.php');
    break;
  case 'video':
  default:
    require_once (APPTHA_VGALLERY_BASEDIR . DS . 'admin/views/video/video.php');
    break;
}