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
/**
 * Including videos model file to get database information.
 */
include_once ($adminModelPath . 'video.php');
/** Checks if the VideoController class has been defined starts */
if ( !class_exists ( 'VideoController' ) ) {  
  /**
   * VideoController class starts
   */
  class VideoController extends VideoModel {  
      /**
       * Constructor function used to get parameters from request URL
       */
      public function __construct() {
        parent::__construct ();
        global $wpdb;
        $this->_wpdb              = $wpdb;
        /** Get videosearchQuery param for videos */
        $this->_videosearchQuery  = filter_input ( INPUT_POST, 'videosearchQuery' );
        /** Get add_video param for videos */
        $this->_addnewVideo       = filter_input ( INPUT_POST, 'add_video' );
        /** Get status param for videos */
        $this->_status            = filter_input ( INPUT_GET, 'status' );
        /** Get videosearchbtn param for videos */
        $this->_searchBtn         = filter_input ( INPUT_POST, 'videosearchbtn' );
        /** Get update param for videos */
        $this->_update            = filter_input ( INPUT_GET, 'update' );
        /** Get add param for videos */
        $this->_add               = filter_input ( INPUT_GET, 'add' );
        /** Get del param for videos */
        $this->_del               = filter_input ( INPUT_GET, 'del' );
        /** Get featured param for videos */
        $this->_featured          = filter_input ( INPUT_GET, 'featured' );
        /** Get order param for videos */
        $this->_orderDirection    = filter_input ( INPUT_GET, 'order' );
        /** Get orderby param for videos*/
        $this->_orderBy           = filter_input ( INPUT_GET, 'orderby' );
        /** Set order by fields as array */
        $orderBy = array ( 'id', 'title', 'author', 'category', 'fea', 'publish', 'date', 'ordering' );
        $this->_order = '';
        /** Get order by fields nad direction for videos */
        if (isset ( $this->_orderBy ) && in_array ( $this->_orderBy, $orderBy )) {
          $this->_order = $this->_orderBy;
        } else{
          $this->_orderDirection = 'DESC';
        }
        /** Get plugin settings date */
        $this->_settingsData      = getPluginSettings ();
        $this->_player_colors   = unserialize ( $this->_settingsData->player_colors );
        /** Get upload directory path */
        $this->_srt_path          = getUploadDirPath ();
        $this->_adminorder_direction =  $this->_player_colors ['recentvideo_order'];
      }
      
      /**
       * Getting video data function starts
       */
      public function video_data() {
        /** Check order by value and set order fields */
        switch ($this->_order) {
          /** Sort videos in order by title */
          case 'title' :
            $this->_order = 'name';
            break;
            /** Sort videos in order by author */
          case 'author' :
            $this->_order = 'u.display_name';
            break;
            /** Sort videos in order by category */
          case 'category' :
            $this->_order = 'pl.playlist_name';
            break;
            /** Sort videos in order by featured */
          case 'fea' :
            $this->_order = 'featured';
            break;
            /** Sort videos in order by date */
          case 'date' :
            $this->_order = 'post_date';
            break;
            /** Sort videos in order by publish status */
          case 'publish' :
            $this->_order = 'publish';
            break;
            /** Sort videos in order by ordering */
          case 'ordering' :
            $this->_order = 'ordering';
            break;
            /** Sort videos in order by video ids */
          case 'id':
          default :
            $this->_order = 'vid';
        }
        /** Get video details based on the order fields and return */
        return $this->get_videodata ( $this->_videosearchQuery, $this->_searchBtn, $this->_order, $this->_orderDirection );
      }
      
      /**
       * Function to redirect to videos page after done the action
       * 
       * @param unknown $statusFlag
       * @param unknown $action
       * @param unknown $type
       */
      public function redirectVideosPage ( $statusFlag, $action, $type ) {
        /** Redirect to videos page based on the status */
        if (! $statusFlag && $action != 'status' && $action == 'featured' ) {
          /** For videos unsuccess action */
          /** Check action is update */
          if($action == 'update') {
            /** If yes redirect URL with video id */
            $url = 'admin.php?page=video&videoId=' . $this->_videoId . '&' . $action .'=0';
          } else{
            /** Else redirect videos page URL with 0 */
            $url = 'admin.php?page=video&' . $action .'=0';
          }
        } else {
          /** For videos success action */
          if($action == 'update') {
            $url = 'admin.php?page=video&videoId=' . $this->_videoId . '&' . $action .'=1';
          } else{
            $url = 'admin.php?page=video&' . $action .'=1';
          }
        }
        /** Check action is stauts or featured */
        if ($action == 'status' || $action == 'featured') {
          /** Check type is 1 nad redirect videos page URL with value 1 */
          if ( $type == 1) {
            $url = 'admin.php?page=video&' . $action .'=1';
          } else {
              /** Redirect URL with the value 0 */
            $url = 'admin.php?page=video&' . $action .'=0';
          }
        }
        /** Display video status message */
        echo '<script>window.open( "' . $url . '","_top",false )</script>';
      }
      
      /**
       * Displaying database message function for publish / unpublish / featured / unfeatured action
       *
       * @return string
       */
      public function getStatusMessage() {
          $result = '';
          $videoType = 'Video';
          /** Check video featured action is success */
          if (isset ( $this->_featured ) && $this->_featured == '1') {
            $result = set_message( $videoType, __ ( 'set as a Featured Video', APPTHA_VGALLERY ));
          }
          /** Check video unfeatured action is success */
          if( $this->_featured == '0') {
            $result =  set_message( $videoType, __ ( 'set as Unfeatured Video', APPTHA_VGALLERY ));
          }
          /** Check video publish action is success */
          if (isset ( $this->_status ) && $this->_status == '1') {
            $result = set_message( $videoType, __ ( 'Published', APPTHA_VGALLERY ));
          }
          /** Check video unpublish action is success */
          if( $this->_status == '0') {
            $result =  set_message( $videoType, __ ( 'Unublished', APPTHA_VGALLERY ));
          }
          return $result;
      }
      
      /**
       * Displaying database message function for add / update / delete action
       *
       * @return string
       */
      public function get_message() {
        $result = '';
        /** Check video add action is success */
        if ($this->_add == '1') {
          $result = set_message( $videoType, __ ( 'Added', APPTHA_VGALLERY ));
        }
        /** Check video update action is success */
        if($this->_update == '1') {
          $result = set_message( $videoType, __ ( 'Updated', APPTHA_VGALLERY ));
        } 
        /** Check video update action is fail */
        if($this->_update == '0' ) {
            $result = set_message( $videoType, __ ( 'Not Updated', APPTHA_VGALLERY ));
        }
        /** Check video delete action is success */
        if (isset ( $this->_del ) && $this->_del == '1') {
          $result = set_message( $videoType, __ ( 'Deleted', APPTHA_VGALLERY ));
        }
        /** Get message for publish / unpublish / featured action  */
        $result1 = $this->getStatusMessage();
        if($result1) {
          $result = $result1;
        }
        return $result;
      }
      
      
      /**
       * Bulk Action Publish, Featured, Delete, Unfeatured, Unpublish function
       */
      public function get_delete() {
        /** Get the action which is done in videos page */
        /** Get videoapply param for videos page */
        $videoApply       = filter_input ( INPUT_POST, 'videoapply' );
        /** Get videoactionup param for videos page */
        $videoActionup    = filter_input ( INPUT_POST, 'videoactionup' );
        /** Get videoactiondown param for videos page */
        $videoActiondown  = filter_input ( INPUT_POST, 'videoactiondown' );
        /** Get video_id param for videos page */
        $videocheckId     = filter_input ( INPUT_POST, 'video_id', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY );
        /** Get selected videos array and combine */
        $videoId = (is_array($videocheckId)?implode ( ',', $videocheckId ):"");
        /** Check apply button is done */
        if (isset ( $videoApply ) && !empty($videoId)) {
          if ($videoActionup == 'videodelete' || $videoActiondown == 'videodelete') {
              $deleteflag = $this->video_delete ( $videoId );
              $this->redirectVideosPage ( $deleteflag, 'del', '');
          } elseif ($videoActionup == "videopublish" || $videoActiondown == 'videopublish') {
                $publishflag = $this->video_multipublish ( $videoId );
                $this->redirectVideosPage ( $publishflag, 'status', '1');
          } elseif ($videoActionup == "videounpublish" || $videoActiondown == "videounpublish") {
                $unpublishflag = $this->video_multiunpublish ( $videoId );
                $this->redirectVideosPage ( $unpublishflag, 'status', '0');
          } elseif ($videoActionup == "videofeatured" || $videoActiondown == 'videofeatured') {
                $publishflag = $this->video_multifeatured ( $videoId );
                $this->redirectVideosPage ( $publishflag, 'featured', '1');
          } else {
              if ($videoActionup == "videounfeatured" || $videoActiondown == "videounfeatured") {
                $publishflag = $this->video_multiunfeatured ( $videoId );
                $this->redirectVideosPage ( $publishflag, 'featured', '0');
              }
          }
        /** Check apply button if ends */
        }
      }
  /** VideoController class ends */
  }
}
