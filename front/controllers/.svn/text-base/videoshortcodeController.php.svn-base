<?php
/**  
 * Video detail and short tags controller file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Including ContusVideoShortcode model file to get database information. */
include_once ($frontModelPath . 'videoshortcode.php');
/** Check ContusVideoShortcodeController class is exists */
if ( !class_exists ( 'ContusVideoShortcodeController' ) ) {
    /**
     * Class is used to get data for video home page
     *
     * @author user
     */
    class ContusVideoShortcodeController extends ContusShortcode {
        /**
         * Function get the video detail.
         *
         * @param   int    $vid          
         * @return  mixed  videodetails
         */
        function short_video_detail($vid, $number_related_video) {
            /** Return paricular video details with help of model */
            return $this->getshort_video_detail ( $vid, $number_related_video);
        }
        
        /**
         * Function to get videos playlist details.
         *
         * @param   int     $vid  
         * @return  mixed   playlistdetails   
         */
        function playlist_detail($vid) {
            /** Return paricular playlist details with help of model */
            return $this->get_playlist_detail ( $vid );
        }
        
        /**
         * Fucntion to get related videos for details page 
         * 
         * @param unknown $vid
         * @param unknown $playlist_id
         * @param unknown $Limit
         * @return object
         */
        function relatedVideosDetails ( $vid, $playlist_id, $Limit ) {
          /** Return related video details with help of model */
          return $this->getRelatedVideosDetails ( $vid, $playlist_id, $Limit );
        }
        
        /**
         * Function  google adsense detail for  video.
         * 
         * @param unknown $vid
         * @return object
         */
        public function get_video_google_adsense_details($vid){
          return $this->get_googleads_detail($vid);
        }
    /** ContusVideo shortcode class ends */
    }
/** Checking ContusVideo class if ends */
} else {
    /** Else display ContusVideoShortcodeController exists message */ 
    echo 'Class ContusVideoShortcodeController already exists';
}
/** Including ContusVideo shortcode view files. */
include_once ($frontViewPath . 'videoshortcode.php'); 
include_once ($frontViewPath . 'videodetailpage.php');
?>