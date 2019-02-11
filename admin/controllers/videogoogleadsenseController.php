<?php
/**
 * Video Google Adsense Controller.
 * 
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Including google adsense model file to get database information. */
include_once ($adminModelPath . 'videogoogleadsense.php');
/** Checks if the VideogoogleadsenseController class has been defined starts */
if ( !class_exists ( 'VideoadController' ) ) {
  /**
   * VideogoogleadsenseController class starts
   */
  class VideogoogleadsenseController extends VideogoogleadsenseModel {
      /**
       * Constructor function used to get parameters from request URL
       */
      public function __construct() { 
        parent::__construct ();
        /** Get videoadsadd param from request */
        $this->_addnewVideoad       = filter_input ( INPUT_POST, 'videoadsadd' );
        /** Get videoadsearchbtn param from request */
        $this->_searchBtn           = filter_input ( INPUT_POST, 'videoadsearchbtn' );
        /** Get videoadssearchQuery param from request */
        $this->_search              = filter_input ( INPUT_POST, 'videoadssearchQuery' );
        /** Get videoadssearchQuery param from request */
        $this->_videoadsearchQuery  = filter_input ( INPUT_POST, 'videoadssearchQuery' );
        /** Get status param from request */
        $this->_status              = filter_input ( INPUT_GET, 'status' );
        /** Get update param from request */
        $this->_update              = filter_input ( INPUT_GET, 'update' );
        /** Get add param from request */
        $this->_add                 = filter_input ( INPUT_GET, 'add' );
        /** Get del param from request */
        $this->_del                 = filter_input ( INPUT_GET, 'del' );
        /** Get order param from request */
        $this->_orderDirection      = filter_input ( INPUT_GET, 'order' );
        /** Get orderby param from request */
        $this->_orderBy             = filter_input ( INPUT_GET, 'orderby' );
        /** Get publish param from request */
        $this->_publish             = filter_input ( INPUT_GET, 'publish' );
        /** Get updatebutton param from request */
        $this->_settingsUpdate      = filter_input ( INPUT_POST, 'updatebutton' );
        /** Get videogoogleadId param from request */
        $this->_videogoogleadsenseId  = absint ( filter_input ( INPUT_GET, 'videogoogleadId' ) );
        /** Get videogoogleadId param from request */
        $this->_videogoogleadupdateId = absint ( filter_input ( INPUT_POST, 'videogoogleadId' ) );        
      } 
      
      /**
       *  Function to redirect to googleadsense page
       *  after done the action
       */
      function redirectGadsPage ( $statusFlag, $action, $type ) {
        /** Redirect to googleadsense page based on the status */
        if (! $statusFlag && $action != 'status' ) {
          /** For googleadsense unsuccess action */
          $url = 'admin.php?page=googleadsense&' . $action .'=0';
        } else {
          /** For googleadsense success action */
          $url = 'admin.php?page=googleadsense&' . $action .'=1';   
        }
        if ($action == 'status') {
          if ( $type == 1) {
            $url = 'admin.php?page=googleadsense&' . $action .'=1';
          } else {
            $url = 'admin.php?page=googleadsense&' . $action .'=0';
          }
        }
        /** Display status message for the admin action */
        echo '<script>window.open( "' . $url . '","_top",false )</script>';
      }
      
       /**
        * Function to get video google adsense details.
        */
        public function videoad_data() {
          /** Return edit details for adsense */
          return $this->videogoogleadsense_edit ( $this->_videogoogleadsenseId );
        }
  
        /**
         * Function get message for google adsense
         */
        public function get_message() {
          $adsType = 'Google adsense';
          $result = '';
          /** Check adsense add action is success */
          if ($this->_add == '1') {
            $result = set_message( $adsType, __ ('Added', APPTHA_VGALLERY ));
          }
          /** Check adsense add action is unsuccess */
          if ($this->_add == '0') {
            $result = set_message( $adsType, __ ('Not Added', APPTHA_VGALLERY ));
          }
          /** Check adsense publish action is success */
          if($this->_status == '1') {
            $result = set_message( $adsType, __ ( 'Published', APPTHA_VGALLERY ));
          }
          /** Check adsense update action is success */
          if($this->_update == '1') {
            $result = set_message( $adsType, __ ('Updated', APPTHA_VGALLERY ));
          }
          /** Check adsense update action is unsuccess */
          if($this->_update == '0' ) {
            $result = set_message( $adsType, __ ('Not Updated', APPTHA_VGALLERY ));
          }
          /** Check adsense unpublish action is success */
          if( $this->_status == '0') {
            $result =  set_message( $adsType, __ ('Unpublished', APPTHA_VGALLERY ));
          }
          /** Check adsense delete action is success */
          if ($this->_del == '1') {
            $result = set_message( $adsType,__ ('Deleted', APPTHA_VGALLERY ));
          }
          /** Check adsense delete action is unsuccess */
          if ($this->_del == '1') {
            $result = set_message( $adsType, __ ('Not Deleted', APPTHA_VGALLERY ));
          }
          return $result;
        }        
        
        /**
         * Function to add the video google adsense details
         */
        public function insert_googleadsense() {
          
          if ($this->_settingsUpdate) {            
              /** Get googleadsense_code from the request */
              $googleadsense          = filter_input ( INPUT_POST, 'googleadsense_code' );
              /** Get alway_open from the request */
              $googleadsensestaus     = filter_input ( INPUT_POST, 'alway_open' );
              /** Get adsense_show_second from the request */
              $googleadsenseshowtime  = filter_input ( INPUT_POST, 'adsense_show_second' );
              /** Get reopen from the request */
              $googleadsensereopen    = filter_input ( INPUT_POST, 'reopen' );
              /** Get adsense_reopen_second from the request */
              $adsense_reopen_second  = filter_input ( INPUT_POST, 'adsense_reopen_second' );
              /** Get status from the request */
              $publish                = filter_input ( INPUT_POST, 'status' );
              /** Get googleadsense_title from the request */
              $google_adsense_title   = filter_input ( INPUT_POST, 'googleadsense_title' );
              
              /** Store all parameters in single array */
              $videoadData = array (
                'googleadsense_code'  => $googleadsense, 'publish'  => $publish,'adsense_option' => $googleadsensestaus,
                'adsense_reopen'      => $googleadsensereopen,'adsense_reopen_time' => $adsense_reopen_second,
                'adsenseshow_time'    => $googleadsenseshowtime, 'googleadsense_title' => $google_adsense_title 
              );
              /** Serialize the form data and make an array */
              $videogoogleadData  = serialize ( $videoadData );            
              $videoData          = array ( 'googleadsense_details' => $videogoogleadData );
              /** Insert new data into google adsense table */
              $addFlag = $this->videogoogleadsense_insert ( $videoData );              
              /** Redirect to the google adsense page 
               * after inserting a record */
              $this->redirectGadsPage ( $addFlag, 'add', '');
          }
        }
        
        /**
         * Function to update googleadsense details.
         */
        public function update_googleadsense() {
            if ($this->_settingsUpdate) {
                /** Get googleadsense_code parameter for update */                
                $googleadsense          = filter_input ( INPUT_POST, 'googleadsense_code' );
                /** Get alway_open parameter for update */
                $googleadsensestaus     = filter_input ( INPUT_POST, 'alway_open' );
                /** Get adsense_show_second parameter for update */
                $googleadsenseshowtime  = filter_input ( INPUT_POST, 'adsense_show_second' );
                /** Get reopen parameter for update */
                $googleadsensereopen    = filter_input ( INPUT_POST, 'reopen' );
                /** Get adsense_reopen_second parameter for update */
                $adsense_reopen_second  = filter_input ( INPUT_POST, 'adsense_reopen_second' );
                /** Get status parameter for update */
                $publish                = filter_input ( INPUT_POST, 'status' );
                /** Get videogoogleadId parameter for update */
                $videogoogleadsenseId   = filter_input ( INPUT_POST, 'videogoogleadId' );
                /** Get googleadsense_title parameter for update */
                $google_adsense_title   = filter_input ( INPUT_POST, 'googleadsense_title' );
                
                /** Store all parameters in single array */
                $videoadData = array ( 'googleadsense_code'  => $googleadsense, 'publish' => $publish, 'adsense_option' => $googleadsensestaus,
                  'adsense_reopen'      => $googleadsensereopen, 'adsense_reopen_time' => $adsense_reopen_second,
                  'adsenseshow_time'    => $googleadsenseshowtime, 'googleadsense_title' => $google_adsense_title 
                );
                
                /** Serialize the form data and make an array */
                $videogoogleadData  = serialize ( $videoadData );
                $videoadData        = array ( 'googleadsense_details' => $videogoogleadData );
                $video_data_format  = array ( '%s' );
                
                /** Update data into google adsense table */
                $update = $this->videogoogleadsense_update ( $videogoogleadsenseId, $videoadData, $video_data_format );
                
                /** Redirect to the google adsense page after updating a record */
                $this->redirectGadsPage ( $update, 'update', '');
                exitAction ('');
            }
        }
        
        /**
         * Function to publish googleadsense details.
         */
        public function googleadsense_publish($googleadsenseId, $status) {
          /** Get parameters from the request */
          $details              = $this->videogoogleadsense_edit ( $googleadsenseId );          
          $serialize            = unserialize ( $details->googleadsense_details );
          $googleadsense_code   = $serialize ['googleadsense_code'];
          $googleadsense_title  = $serialize ['googleadsense_title'];
          $googleadsense_option = $serialize ['adsense_option'];
          $adsense_reopen       = $serialize ['adsense_reopen'];
          $adsense_reopen_time  = $serialize ['adsense_reopen_time'];
          $adsenseshow_time     = $serialize ['adsenseshow_time'];
          $status               = $status;
          
          /** Store all parameters in single array */
          $videoadData = array ( 'googleadsense_code'  => $googleadsense_code, 'publish' => $status, 'adsense_option' => $googleadsense_option,
            'adsense_reopen'      => $adsense_reopen,  'adsense_reopen_time' => $adsense_reopen_time,
            'adsenseshow_time'    => $adsenseshow_time, 'googleadsense_title' => $googleadsense_title 
          );
          
          /** Serialize the form data and make an array */
          $videogoogleadData = serialize ( $videoadData );
          $googleadsenseData = array ( 'googleadsense_details' => $videogoogleadData );
          $video_data_format = array ( '%s' );
          
          /** Update status into google adsense table */
          $update = $this->videogoogleadsense_update ( $googleadsenseId, $googleadsenseData, $video_data_format );
          if ($update) {
            switch ($status ) {
              case 0:
                $this->redirectGadsPage ( $update, 'status', '');
                break;
              case 1:
                $this->redirectGadsPage ( $update, 'status', '1');
                break;
              default:
                break;
            }
          } 
          exitAction ('');
        }
        
        /**
         * Function to order googleadsense details based on the selected fields.
         */
        public function googleadsenses() {
          /** Variable initailaization */
          $orderBy  = array ( 'id', 'publish' );
          $order    = 'id';
          /** Check whether the order by fileds are exist in the given array */
          if (isset ( $this->_orderBy ) && in_array ( $this->_orderBy, $orderBy )) {
            $order = $this->_orderBy;
          }          
          /** Assign order by filed based on the grid fields */
          switch ($order) {
            case 'id' :
              $order = 'id';
              break;
            case 'publish' :
              $order = 'googleadsense_details';
              break;
            case 'title' :
              $order = 'googleadsense_details';
              break;
            default :
              $order = 'id';
              break;
          }          
          /** Call funtion to order the grid data based on the selected filed  */
          return $this->get_videogoogleadsenses ( $this->_videoadsearchQuery, $this->_searchBtn, $order, $this->_orderDirection );
        }
        
        /**
         * Function to count googleadsense details
         */
        public function getgoogleadsensecount() {
          /** Return google adsense count */
          return $this->videogoogleadsensecount ( $this->_videoadsearchQuery, $this->_searchBtn );
        }
        
        /**
         * Function to order googleadsense details based on the selected fields.
         */
        public function deletegoogleadsense() {
              /** Variable Initailazation */
              $videogoogleadId    = '';
              
              /** Get videogoogleadapply parameter from the request for adsense */
              $videoadApply         = filter_input ( INPUT_POST, 'videogoogleadapply' );
              /** Get videogoogleadactionup parameter from the request */
              $videoadActionup      = filter_input ( INPUT_POST, 'videogoogleadactionup' );
              /** Get videogoogleadactionup parameter from the request */
              $videoadActiondown    = filter_input ( INPUT_POST, 'videogoogleadactiondown' );
              /** Get videogooglead_id parameter from the request */
              $videogoogleadcheckId = filter_input ( INPUT_POST, 'videogooglead_id', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY );
           
              if(is_array ( $videogoogleadcheckId )) {
                $videogoogleadId  = implode ( ',', $videogoogleadcheckId );
              }

              /** Check whether apply action is done */
              if (isset ( $videoadApply ) && !empty($videogoogleadId)) {                
                  /** Check if delete action is done */ 
                  if ($videoadActionup == 'videogoogleaddelete' || $videoadActiondown == 'videogoogleaddelete') {
                      $deleteflag       = $this->videogooglead_delete ( $videogoogleadId );
                      $this->redirectGadsPage ( $deleteflag, 'del', '');
                  }
                  if ($videoadActionup == 'videogoogleadpublish' || $videoadActiondown == 'videogoogleadpublish') {
                    $publishflag       = $this->videogooglead_publish ( $videogoogleadId );
                    $this->redirectGadsPage ( $publishflag, 'publish', '');
                  }
                  if ($videoadActionup == 'videogoogleadunpublish' || $videoadActiondown == 'videogoogleadunpublish') {
                  	$unpublishflag       = $this->videogooglead_unpublish ( $videogoogleadId );
                  	$this->redirectGadsPage ( $unpublishflag, 'unpublish', '');
                  } 
              }
        }
  /** VideogoogleadsenseController class ends */ 
  } 
/** Checking VideogoogleadsenseController if ends */
}

/** Creating object for the VideogoogleadsenseController class */
$videoadOBJ             = new VideogoogleadsenseController ();
/** Assign class variables into local variables */
$searchMsg              = $videoadOBJ->_videoadsearchQuery;
$videogoogleadsenseId   = $videoadOBJ->_videogoogleadsenseId;
$videogoogleadupdateId  = $videoadOBJ->_videogoogleadupdateId;
$videogooglead_del      = $videoadOBJ->_del;
$status                 = $videoadOBJ->_status;
/** Call function to pubish or unpublish google adsense data */
if ($videogoogleadsenseId && (isset ( $status ) && ($status == 0 || $status == 1))) {
  $videoadOBJ->googleadsense_publish ( $videogoogleadsenseId, $status );
}
/** Check if id exists then call function to update google adsense data 
 * Otherwise insert new google adsense data */
if ($videogoogleadupdateId) {
  $updateGoogleadsense  = $videoadOBJ->update_googleadsense ();
} else {
  $insert_adsense       = $videoadOBJ->insert_googleadsense ();
}
/** Call function to edit google adsense data */
if ($videogoogleadsenseId) {
  $editGoogleAdsense = $videoadOBJ->videoad_data ( $videogoogleadsenseId );
} else {
  $editGoogleAdsense = '';
}
/** Call function to delete google adsense data */
$videoadOBJ->deletegoogleadsense ();
/** Call function to get message for the corresponding action */
$displayMsg       = $videoadOBJ->get_message ();
/** Call function to display google adsense data in grid section */
$gridVideoad      = $videoadOBJ->googleadsenses ();
/** Call function to count google adsense data */
$videoad_count    = $videoadOBJ->getgoogleadsensecount ();
/** Fetch page parameter from the request URL */
$adminPage        = filter_input ( INPUT_GET, 'page' );
/** Include grid page or add new google ad page based on the request */
switch($adminPage){
  case 'addgoogleadsense':
    require_once (APPTHA_VGALLERY_BASEDIR . DS . 'admin/views/videogoogleadsense/videoaddgoogleadsense.php');
    break;
  case 'googleadsense':
  default:
    require_once (APPTHA_VGALLERY_BASEDIR . DS . 'admin/views/videogoogleadsense/videogoogleadsense.php');
    break;
}
?>