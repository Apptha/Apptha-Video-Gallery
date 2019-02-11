<?php
/**
 *  Video Ad Controller.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Including videoad model file for getting database information. */
include_once ($adminModelPath . 'videoad.php');
/** Checks if the VideoadController class has been defined starts */
if ( !class_exists ( 'VideoadController' ) ) {   
  /**
   * VideoadController class starts
   */
  class VideoadController extends VideoadModel {      
      /**
       * VideoadController Constructor starts
       */
      public function __construct() { 
        parent::__construct ();
        /** Get videoadsadd parameter from request URL */
        $this->_addnewVideoad       = filter_input ( INPUT_POST, 'videoadsadd' );
        /** Get status parameter from request URL */
        $this->_status              = filter_input ( INPUT_GET, 'status' );
        /** Get videoadsearchbtn parameter from request URL */
        $this->_searchBtn           = filter_input ( INPUT_POST, 'videoadsearchbtn' );
        /** Get videoadssearchQuery parameter from request URL */
        $this->_videoadsearchQuery  = filter_input ( INPUT_POST, 'videoadssearchQuery' );
        /** Get update parameter from request URL */
        $this->_update              = filter_input ( INPUT_GET, 'update' );
        /** Get add parameter from request URL */
        $this->_add                 = filter_input ( INPUT_GET, 'add' );
        /** Get del parameter from request URL */
        $this->_del                 = filter_input ( INPUT_GET, 'del' );
        /** Get order parameter from request URL */
        $this->_orderDirection      = filter_input ( INPUT_GET, 'order' );
        /** Get orderby parameter from request URL */
        $this->_orderBy             = filter_input ( INPUT_GET, 'orderby' );
      } 
      
      /**
       * Function for adding video starts
       */
      public function add_newvideoad() {       
          /** Check video ad status is exists */
          if (isset ( $this->_status )) {
            /** Update video ad status in database */
            $this->status_update ( $this->_videoadId, $this->_status );
          }          
          /** Check whether to add or update video ad  */
          if (isset ( $this->_addnewVideoad )) {            
              /** Get videoadname parameter from request URL */          
              $videoadName      = filter_input ( INPUT_POST, 'videoadname' );
              /** Get videoimaadwidth parameter from request URL */
              $videoadwidth     = filter_input ( INPUT_POST, 'videoimaadwidth' );
              /** Get videoimaadheight parameter from request URL */
              $videoadheight    = filter_input ( INPUT_POST, 'videoimaadheight' );
              /** Get imaadpath parameter from request URL */
              $videoimaadpath   = filter_input ( INPUT_POST, 'imaadpath' );
              /** Get publisherId parameter from request URL */
              $publisherId      = filter_input ( INPUT_POST, 'publisherId' );
              /** Get contentId parameter from request URL */
              $contentId        = filter_input ( INPUT_POST, 'contentId' );
              /** Get imaadType parameter from request URL */
              $imaadType        = filter_input ( INPUT_POST, 'imaadType' );
              /** Get channels parameter from request URL */
              $channels         = filter_input ( INPUT_POST, 'channels' );
              /** Get description parameter from request URL */
              $description      = filter_input ( INPUT_POST, 'description' );
              /** Get targeturl parameter from request URL */
              $targeturl        = filter_input ( INPUT_POST, 'targeturl' );
              /** Get clickurl parameter from request URL */
              $clickurl         = filter_input ( INPUT_POST, 'clickurl' );
              /** Get impressionurl parameter from request URL */
              $impressionurl    = filter_input ( INPUT_POST, 'impressionurl' );
              /** Get admethod parameter from request URL */
              $admethod         = filter_input ( INPUT_POST, 'admethod' );
              /** Get adtype parameter from request URL */
              $adtype           = filter_input ( INPUT_POST, 'adtype' );
              /** Get videoadfilepath parameter from request URL */
              $videoadpath  = filter_input ( INPUT_POST, 'videoadfilepath' );
              /** Get videoadpublish parameter from request URL */
              $videoadPublish   = filter_input ( INPUT_POST, 'videoadpublish' ); 
              /** Get normalvideoform-value parameter from request URL */
              $videoadFilepath  = filter_input ( INPUT_POST, 'normalvideoform-value' );
              /** Get video ad path or URL */
              if ( empty ( $videoadpath ) && !empty($videoadFilepath)) {
                $image_path       = getUploadDirURL();
                /** Check whether the video ad path is URL or uploaded video */
                if (isset($videoadFilepath) && strpos ( $videoadFilepath ,'/')) {
                  $videoadpath = $videoadFilepath;
                } else {
                  /** Get full path for uploaded ad videos */
                  $videoadpath = $image_path . $videoadFilepath;
                }
              } 
              
              if(!empty($publisherId)) {
                $adtype = '';
              }
              
              /** Store parameter values into single array */
              $videoadData = array ( 'title' => $videoadName, 'description' => $description, 'targeturl' => $targeturl, 'clickurl' => $clickurl, 'impressionurl' => $impressionurl, 
                'file_path' => $videoadpath, 'adtype' => $adtype, 'admethod' => $admethod, 'imaadwidth' => $videoadwidth, 'imaadheight' => $videoadheight, 
                'imaadpath' => $videoimaadpath, 'publisherId' => $publisherId, 'contentId' => $contentId, 'imaadType' => $imaadType, 'channels' => $channels, 'publish' => $videoadPublish );
              /** Set data format for the video ad fields */
              $videoadDataformat = array ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%d', '%s', '%d' );
              /** Check video ad id exist */
              if ($this->_videoadId) { 
                /** Update for video ad if id exist */
                $updateflag = $this->videoad_update ( $videoadData, $videoadDataformat, $this->_videoadId );
                /** Redirect to the corresponding video ad page after update is done */
                $this->redirectAdsPage ( $updateflag, 'update', '' );
              }      
              else { 
                /** Adding new video ad */ 
                $addflag = $this->insert_videoad ( $videoadData, $videoadDataformat );
                /** Redirect to the video ads page after update is done */
                $this->redirectAdsPage ( $addflag, 'add', '' );
              }
          }
      }
      
     /**
      * Function to redirect to video ads page after done the action
      * 
      * @param unknown $statusFlag
      * @param unknown $action
      * @param unknown $type
      */
      function redirectAdsPage ( $statusFlag, $action, $type ) {
        /** Redirect to video ads page based on the status */
        if (! $statusFlag && $action != 'status') {
          /** For video ads unsuccess action */
          if($action == 'update') {
            $url = 'admin.php?page=videoads&videoadId=' . $this->_videoadId . '&' . $action .'=0';
          } else{
            $url = 'admin.php?page=videoads&' . $action .'=0';
          }
        } else {
          /** For video ads success action */
          if($action == 'update') {
            $url = 'admin.php?page=videoads&videoadId=' . $this->_videoadId . '&' . $action .'=1';
          } else{
            $url = 'admin.php?page=videoads&' . $action .'=1';
          }
        }
        /** Check action is status for video ads */
        if ($action == 'status') {
          if ( $type == 1) {
            $url = 'admin.php?page=videoads&' . $action .'=1';
          } else {
            $url = 'admin.php?page=videoads&' . $action .'=0';
          }
        }
        /** Redirect to the given url in video ad section */
        echo '<script>window.open( "' . $url . '","_top",false )</script>';
      }
  
      /**
       * Function to order videoad data based on the fields
       */ 
      public function videoad_data() {
          /** Store order by fileds into single array */
          $orderBy = array ('id', 'title', 'path', 'publish' );
          $order = 'id';          
          /** Check order by filed is exist within an array */
          if (isset ( $this->_orderBy ) && in_array ( $this->_orderBy, $orderBy )) {
            $order = $this->_orderBy;
          }
          /** Based on the selection assign order filed */
          switch ($order) {
            case 'id' :
              $order = 'ads_id';
              break;            
            case 'title' :
              $order = 'title';
              break;            
            case 'publish' :
              $order = 'publish';
              break;            
            default :
              $order = 'ads_id';
          }
          /** Call function to order grid data based on the selection */
          return $this->get_videoaddata ( $this->_videoadsearchQuery, $this->_searchBtn, $order, $this->_orderDirection );
      }
      
      /**
       * Displaying database message function for Video Ads page starts
       *
       * @return string
       */
      public function get_message() {
        $adsresult = '';
        $type = 'Video Ads';
        /** Check video ad publish is success */
        if ($this->_status == '1') {
          $adsresult = set_message( $type, __ ('Published', APPTHA_VGALLERY ));
        }
        /** Check video ad publish is unsuccess */
        if( $this->_status == '0') {
          $adsresult =  set_message( $type,__ ('Unpublished', APPTHA_VGALLERY ));
        }
        /** Check video ad add action is success */
        if ($this->_add == '1') {
          $adsresult = set_message( $type, __ ('Added', APPTHA_VGALLERY ));
        }      
        /** Check video ad update is success */
        if($this->_update == '1') {
          $adsresult = set_message( $type, __ ('Updated', APPTHA_VGALLERY ));
        } 
        /** Check video ad update is unsuccess */
        if($this->_update == '0' ) {
          $adsresult = set_message( $type, __ ('Not Updated', APPTHA_VGALLERY ));
        }        
        /** Check video ad delete is success */
        if ( $this->_del == '1') {
          $adsresult = set_message( $type, __ ( 'Deleted', APPTHA_VGALLERY ));
        }
        return $adsresult;
      }
  
      /**
       * Function to delete, publish or unpublish the video ad
       */ 
      public function get_delete() {
          /** Get videoadapply from request URL */
          $videoadApply       = filter_input ( INPUT_POST, 'videoadapply' );
          /** Get videoadactionup from request URL */
          $videoadActionup    = filter_input ( INPUT_POST, 'videoadactionup' );
          /** Get videoadactiondown from request URL */
          $videoadActiondown  = filter_input ( INPUT_POST, 'videoadactiondown' );
          /** Get videoad_id from request URL */
          $videoadcheckId     = filter_input ( INPUT_POST, 'videoad_id', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY );
          /** Get selected video ad id's array and combine */
          if (is_array ( $videoadcheckId )) {
             $videoadId = implode ( ',', $videoadcheckId );
          }
          /** Check apply action is done */
          if (isset ( $videoadApply ) && !empty($videoadId) ) {
            /** Check video ad delete action is done */
            if ($videoadActionup == 'videoaddelete' || $videoadActiondown == 'videoaddelete') {
                  /** Call function to delete video ad  */
                  $deleteflag = $this->videoad_delete ( $videoadId );
                  /** Redirect to video ads page after delete record */
                  $this->redirectAdsPage ( $deleteflag, 'del', '' );
            } elseif ($videoadActionup == "videoadpublish" || $videoadActiondown == 'videoadpublish' ) {
                 /** Check video ad publish action is done and call function to publish data */
                  $publishflag = $this->videoad_multipublish ( $videoadId );
                  /** Redirect to video ads page after publish record */
                  $this->redirectAdsPage ( $publishflag, 'status', '1' );
            } else{
                  /** Check video ad unpublish action is done  */
                  if ($videoadActionup == "videoadunpublish" || $videoadActiondown == "videoadunpublish") {
                      /** Call function to publish data */                  
                      $unpublishflag = $this->videoad_multiunpublish ( $videoadId );
                      /** Redirect to video ads page after unpublish record */
                      $this->redirectAdsPage ( $unpublishflag, 'status', '0' );
                  }
            }
        /** Check apply action ends */
         }
      }
   /** VideoadController class ends */  
  }
/** Checks if the VideoadController class has been defined ends */  
} 

/** Creating object for VideoadController class */
$videoadOBJ = new VideoadController (); 
/** Assign class variables into local variables */
$videoadId = $videoadOBJ->_videoadId;
$searchMsg = $videoadOBJ->_videoadsearchQuery;
$searchBtn = $videoadOBJ->_searchBtn;
/** Call function with VideoadController object */
$videoadOBJ->add_newvideoad ();
/** Call function to delete video ad data */
$videoadOBJ->get_delete ();
/** Call function to display video ads data in grid section */
$gridVideoad    = $videoadOBJ->videoad_data ();
/** Call function to count video ads data */
$videoad_count  = $videoadOBJ->videoad_count ( $searchMsg, $searchBtn );
/** Call function to edit video ads data */
if (! empty ( $videoadId )) {
    $videoadEdit = $videoadOBJ->videoad_edit ( $videoadId );
} else {
    $videoadEdit = '';
}
/** Call function to get message for the corresponding action */
$displayMsg = $videoadOBJ->get_message ();
/** Fetch page parameter from the request URL */
$adminPage = filter_input ( INPUT_GET, 'page' );
/** Include grid or add new video ad page based on the request */
switch ($adminPage) {  
    case 'newvideoad':
      require_once (APPTHA_VGALLERY_BASEDIR . DS . 'admin/views/videoads/addvideoads.php');
      break;
    case 'videoads':
    default:
      require_once (APPTHA_VGALLERY_BASEDIR . DS . 'admin/views/videoads/videoads.php');
      break;
}
?>    