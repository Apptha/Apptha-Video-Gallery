<?php
/**  
 * Add Video Gallery to your website to showcase demos, Portfolio And Movie Trailers..
 * Get Video Players details , Related video for particular video player.
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Checks the ContusShortcode class has been defined if starts */
if ( !class_exists ( 'ContusShortcode' ) ) {
    /**
     * ContusShortcode class starts
     * 
     * @author user
     */ 
    class ContusShortcode { 
        /**
         * ContusShortcode constructor starts
         */
        public function __construct () {
            /** Get global variable and assign to class variable */
            global $wpdb;
            $this->_wpdb                = $wpdb;
            /** Set settings table with prefix */
            $this->_videosettingstable  = $this->_wpdb->prefix . 'hdflvvideoshare_settings';
            /** Set video table with prefix */
            $this->_videoinfotable      = $this->_wpdb->prefix . 'hdflvvideoshare';
        }
        
        /**
         * Function to get video details
         *
         * @global type $wpdb
         * @param type $vid          
         * @return type
         */
        public function getshort_video_detail ( $vid, $number_related_video ) {
            global $wpdb; 
            /** Chesk the related video is empty or not
             * If not empty then set as limit */
            if(!empty($number_related_video)) {
              $limit = $number_related_video; 
            } /** If related video is empty then set limit as 1 */ 
            else {
              $limit = 1;
            }
            /** Query to return particular video details */
            return  $this->_wpdb->get_row ( 'SELECT t1.vid,t5.ID,t5.display_name,t1.slug,t1.amazon_buckets,t1.post_date,
                t1.description,t4.tags_name,t1.name,t1.post_date,t1.publish,t1.google_adsense,t1.google_adsense_value,
                t1.image,t1.file,t1.hitcount,t1.ratecount,t1.file_type,t1.embedcode,t1.rate,t2.playlist_id,
                t3.playlist_name' . ' FROM ' . $this->_videoinfotable . ' AS t1' . ' 
                LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play AS t2' . ' ON t2.media_id = t1.vid' . ' 
                LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist AS t3' . ' ON t3.pid = t2.playlist_id' . ' 
                LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_tags AS t4' . ' ON t1.vid = t4.media_id' . ' 
                LEFT JOIN ' . $wpdb->users . ' AS t5' . ' ON t1.member_id = t5.ID' . ' 
                WHERE t1.publish=1 AND t3.is_publish=1 AND t1.vid="' . intval ( $vid ) . '" LIMIT ' . $limit );
        }
        
        /**
         * Function to get playlsit detials
         *
         * @global type $wpdb
         * @param type $vid          
         * @return type
         */
        public function get_playlist_detail ( $vid ) {
            global $wpdb;
            /** Query to return particular playlist details */
            return  $this->_wpdb->get_results ( 'SELECT t3.playlist_name,t3.pid,t3.playlist_slugname' . ' FROM ' . $wpdb->prefix . 'hdflvvideoshare_playlist AS t3' . '  
                 LEFT JOIN  ' . $wpdb->prefix . 'hdflvvideoshare_med2play AS t2' . ' ON t3.pid = t2.playlist_id' . ' 
                 WHERE t3.is_publish=1 AND t2.media_id="' . intval ( $vid ) . '"' );            
        }
        /**
         * Function google Adsense details based video selected.
         * 
         * @param unknown $vid
         * @return object
         */
        public function get_googleads_detail($vid){
          global $wpdb;
          /** Get google ad sense details */
          return $this->_wpdb->get_row("SELECT g.*,v.google_adsense FROM " 
              . $wpdb->prefix."hdflvvideoshare_vgoogleadsense g LEFT JOIN " . $wpdb->prefix."hdflvvideoshare v 
              ON g.id = v.google_adsense_value");	
        }
        /**
         * Fucntion to get realted videos for the given video id 
         * 
         * @param unknown $vid
         * @param unknown $playlist_id
         * @param unknown $Limit
         * @return object 
         */
        function getRelatedVideosDetails ( $vid, $playlist_id, $Limit ) {
          global $wpdb;
          /** Query to get realted videos based on the given video id */
          $select   = 'SELECT distinct( a.vid ),b.playlist_id,name,guid,description,file,hdfile,file_type,duration,embedcode,image,opimage,download,link,featured,hitcount,slug,
                        a.post_date,postrollads,prerollads,amazon_buckets FROM ' . $wpdb->prefix . 'hdflvvideoshare a
                        LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play b ON a.vid=b.media_id
                        LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=b.playlist_id
                        LEFT JOIN ' . $wpdb->prefix . 'posts s ON s.ID=a.slug
                        WHERE b.playlist_id=' . intval ( $playlist_id ) . ' AND a.publish=1 AND p.is_publish=1 AND a.vid NOT IN (' . $vid . ')
                        ORDER BY a.vid DESC LIMIT ' . $Limit;
          /** Return related videos results */
          return $wpdb->get_results ($select);
        }
    /** ContusShortcode model class ends */
    }
/** Checking contusShortcode model class if ends */
}
