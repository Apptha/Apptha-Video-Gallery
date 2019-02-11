<?php
/**  
 * Video more page controller file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Including ContusVideomore model file to get database information. */
include_once ($frontModelPath . 'videomore.php'); 
/**
 * Check ContusMoreController class is exists
 */
if ( !class_exists ( 'ContusMoreController' ) ) {
  /**
   * Class is used to get data for video more pages
   *
   * @author user
   */
  class ContusMoreController extends ContusMore {
      /**
       * Function for the home thumb data.
       *
       * @param unknown $thumImageorder          
       * @param unknown $where          
       * @param unknown $pagenum          
       * @param unknown $dataLimit          
       * @return type <mixed int>
       */
      function home_thumbdata($thumImageorder, $where, $pagenum, $dataLimit) {
          /** Return more page thumb data with help of model */
          return $this->get_thumdata ( $thumImageorder, $where, $pagenum, $dataLimit );
      }
      
      /**
       * Function to get categories thumb data from plugin herlper
       */
      function home_categoriesthumbdata($pagenum, $dataLimit) {
        /** Set start and limit to fetch category thumbs */
        $pagenum  = isset ( $pagenum ) ? absint ( $pagenum ) : 1;
        /** Set pagination for videos more page */
        $offset   = ($pagenum - 1) * $dataLimit;
        /** Set the liimit */
        $limit    = $offset . ',' . $dataLimit;
        /** Call helper function to fetch playlist details */
        return getPlaylist (' playlist_order ASC ' , $limit);
      }
  
      /**
       * Fucntion to get search page thumb data
       *
       * @param unknown $thumImageorder          
       * @param unknown $pagenum          
       * @param unknown $dataLimit          
       */
      function home_searchthumbdata($thumImageorder, $pagenum, $dataLimit) {
          /** Return search page thumb data with help of model */
          return $this->get_searchthumbdata ( $thumImageorder, $pagenum, $dataLimit );
      }
      /**
       * Function to get video count
       *
       * @param unknown $playid          
       * @param unknown $userid          
       * @param unknown $thumImageorder          
       * @param unknown $where          
       */
      function countof_videos($playid, $userid, $thumImageorder, $where) {
          /** Return count of videos with help of model */
          return $this->get_countof_videos ( $playid, $userid, $thumImageorder, $where );
      }
      
      /**
       * Fucntion to get count for search videos
       *
       * @return type int
       */
      function countof_videosearch($thumImageorder) {
          /** Return video search count with help of model */
          return $this->get_countof_videosearch ( $thumImageorder );
      }
  /** contusMore class ends */
  }
/** Checking contusMore if ends */
} else {
  /** Else contusMore already exists */
  echo 'class contusMore already exists';
}
/** Including ContusVideomore view files to display data */
include_once ($frontViewPath . 'videomore.php'); 
include_once ($frontViewPath . 'videomorepage.php');
?>