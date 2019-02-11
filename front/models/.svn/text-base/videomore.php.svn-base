<?php
/**  
 * Video more front end model file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
include_once(APPTHA_VGALLERY_BASEDIR.'/helper/watchhelper.php');
/** Checks the ContusMore class has been defined if starts */
if ( !class_exists ( 'ContusMore' ) ) {
    /**
     * ContusMore class starts
     *
     * @author user
     */
    class ContusMore {
    	/**
    	 * WatchHelper trait is used to include commonly used functions on ContusMore class
    	 */
        /**
         * ContusMore constructor is used to initalize
         */
        public function __construct() {
            /** Connect to db in WP */
            global $wpdb;
            $this->_wpdb                = $wpdb;
            /** Set prefix settings table*/
            $this->_videosettingstable  = $this->_wpdb->prefix . 'hdflvvideoshare_settings';
            /** Set prefix videos table*/
            $this->_videoinfotable      = $this->_wpdb->prefix . 'hdflvvideoshare';
            $this->watchDetailsTable = WVG_WATCH_LATER;
            $this->userPlaylistDetailsTable = WVG_USER_PLAYLIST_DETAILS;
        }
        
        /**
         * Function to get recent, feature, popular video for more pages.
         *
         * @param type $thumImageorder          
         * @param type $where          
         * @param type $pagenum          
         * @param type $dataLimit          
         * @return type array
         */
        public function get_thumdata($thumImageorder, $where, $pagenum, $dataLimit) {
            global $wpdb;
            /** Set limit for query */
            $pagenum  = ! empty ( $pagenum ) ? absint ( $pagenum ) : 1;
            /** Calculate offset for thumb display */
            $offset   = ($pagenum - 1) * $dataLimit;
            /** Query to get more videos page videos */
            return $this->_wpdb->get_results ('SELECT distinct w.*,s.guid,p.playlist_slugname,p.playlist_name FROM ' . $this->_videoinfotable . ' w   
                 LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid 
                 LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id  
                 LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug 
                 WHERE w.publish=1 AND p.is_publish=1 ' . $where . ' GROUP BY w.vid  
                 ORDER BY ' . $thumImageorder . ' LIMIT ' . $offset . ',' . $dataLimit );
        }        
        
        /**
         * Function for Search key word based video category
         *
         * @param type $thumImageorder          
         * @param type $pagenum          
         * @param type $dataLimit          
         * @return type
         */
        public function get_searchthumbdata($thumImageorder, $pagenum, $dataLimit) {
            global $wpdb;
            /** Set limit for serach query */
            $pagenum  = ! empty ( $pagenum ) ? absint ( $pagenum ) : 1;
            /** Set offset limit */
            $offset   = ($pagenum - 1) * $dataLimit;
            /** Query to get search results */
            $query    = 'SELECT t1.* FROM ' . $this->_wpdb->prefix . 'hdflvvideoshare AS t1  
                LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play AS t2 ON t2.media_id = t1.vid  
                LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist AS t3 ON t3.pid = t2.playlist_id 
                LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_tags AS t4 ON t4.media_id = t1.vid  
                LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=t1.slug 
                WHERE t3.is_publish=1 AND t1.publish=1';
            /** Set condition to search videos */
            $query  .= ' AND ( t4.tags_name LIKE %s OR t1.description LIKE %s OR t1.name LIKE %s )';
            $query  .= ' GROUP BY t1.vid  LIMIT ' . $offset . ',' . $dataLimit;
            $query  = $this->_wpdb->prepare ( $query, '%' . $thumImageorder . '%', '%' . $thumImageorder . '%', '%' . $thumImageorder . '%' );
            /** Return video search results */
            return $this->_wpdb->get_results ( $query );
        }
        
        /**
         * Funtion get Count of search keyword video count.
         *
         * @global type $wpdb
         * @param type $thumImageorder          
         * @return type $result
         */
        public function get_countof_videosearch($thumImageorder) {
            global $wpdb;
            /** Query to get search results count */
            $query    = 'SELECT t1.vid FROM ' . $wpdb->prefix . 'hdflvvideoshare AS t1  
                LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play AS t2 ON t2.media_id = t1.vid 
                LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist AS t3 ON t3.pid = t2.playlist_id 
                LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_tags AS t4 ON t4.media_id = t1.vid 
                LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=t1.slug WHERE t3.is_publish=1 AND t1.publish=1';
            /** Set condition to get search count */            
            $query    .= ' AND ( t4.tags_name LIKE %s OR t1.description LIKE %s OR t1.name LIKE %s )';
            $query    .= ' GROUP BY t1.vid ';
            $query    = $this->_wpdb->prepare ( $query, '%' . $thumImageorder . '%', '%' . $thumImageorder . '%', '%' . $thumImageorder . '%' );
            /** Return video search count */
            return count ( $wpdb->get_results ( $query ) );
        }
        
        /**
         * Function to get count of videos based on playlist id, user id and all videos
         *
         * @global type $wpdb
         * @param type $playid          
         * @param type $userid          
         * @param type $thumImageorder          
         * @param type $where          
         * @return type $result
         */
        public function get_countof_videos($playid, $userid, $thumImageorder, $where) {
            global $wpdb;
            /** Check play id is exists */
            if (! empty ( $playid )) {
              /** Count videos based on playlist id */
              $query  = 'SELECT count( * ) FROM ' . $wpdb->prefix . 'hdflvvideoshare as w  
                   LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play as m ON m.media_id = w.vid  
                   LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist as p on m.playlist_id = p.pid  
                   WHERE w.publish=1 and p.is_publish=1 and m.playlist_id=' . intval ( $thumImageorder );
              $result = $this->_wpdb->get_var ( $query );
            } else if (! empty ( $userid )) {
              /** Check user id is exists
               * Count videos based on user id */
              $query  = 'SELECT count( * ) FROM ' . $wpdb->prefix . 'hdflvvideoshare as w  
                   LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play as m ON m.media_id = w.vid  
                   LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist as p on m.playlist_id = p.pid  
                   LEFT JOIN ' . $wpdb->users . ' u ON u.ID=w.member_id 
                   WHERE w.publish=1 and p.is_publish=1 and u.ID=' . intval ( $thumImageorder );
              $result = $this->_wpdb->get_var ( $query );
            } else {
              /** Count all videos */
              $query  = 'SELECT count( w.vid ) FROM ' . $this->_videoinfotable . ' w  
                  LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid  
                  LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id  
                  WHERE w.publish=1 ' . $where . ' AND p.is_publish=1 GROUP BY w.vid ORDER BY ' . $thumImageorder;
              $result_count = $this->_wpdb->get_results ( $query );
              $result = count ( $result_count );
            }
            /** Return videos count */
            return $result;
        }
                
        /**
         * Function to get category thumb data
         *
         * @global type $wpdb
         * @param type $thumImageorder          
         * @param type $pagenum          
         * @param type $dataLimit          
         * @return type
         */
        public function home_catthumbdata($thumImageorder, $pagenum, $dataLimit, $default_order) {
            global $wpdb;
            /** Set limit for category videos */
            $pagenum  = ! empty ( $pagenum ) ? absint ( $pagenum ) : 1;
            $offset   = ($pagenum - 1) * $dataLimit;
            /** Query to get videos for particular category */
            return $this->_wpdb->get_results('SELECT s.guid,w.*,p.playlist_name,p.playlist_slugname FROM ' . $wpdb->prefix . 'hdflvvideoshare as w   
                 LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play as m ON m.media_id = w.vid 
                 LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist as p on m.playlist_id = p.pid  
                 LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug WHERE w.publish=1 AND p.is_publish=1 AND m.playlist_id=' . intval ( $thumImageorder ) . '   
                 GROUP BY w.vid ORDER BY ' . $default_order . ' LIMIT ' . $offset . ',' . $dataLimit );
        }
        
        /**
         * Function to get category thumb data
         *
         * @global type $wpdb
         * @param type $thumImageorder
         * @param type $pagenum
         * @param type $dataLimit
         * @return type
         */
        public function home_playlistthumbdata($thumImageorder, $pagenum, $dataLimit, $default_order) {
        	global $wpdb;
        	/** Set limit for category videos */
        	$pagenum  = ! empty ( $pagenum ) ? absint ( $pagenum ) : 1;
        	$offset   = ($pagenum - 1) * $dataLimit;
        	$videoIdArray = $wpdb->get_col($wpdb->prepare("SELECT vid FROM ".$this->userPlaylistDetailsTable." WHERE pid=%d ORDER BY id desc",$thumImageorder));
        	if(!empty($videoIdArray)) {
        		$videoDetails = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."hdflvvideoshare WHERE vid IN (".implode(',',$videoIdArray).") ORDER BY field(vid,".implode(',',$videoIdArray).") LIMIT " . $offset . "," . $dataLimit);
        		return $videoDetails;
        	}
        }
        
        public function home_countplaylistthumbdata($thumImageorder) {
        	global $wpdb;
        	$videoIdArray = $wpdb->get_col($wpdb->prepare("SELECT vid FROM ".$this->userPlaylistDetailsTable." WHERE pid=%d ORDER BY id desc",$thumImageorder));
        	return count($videoIdArray);
        }
        
        /**
         * Get thumb data for similar user created
         *
         * @global type $wpdb
         * @param type $thumImageorder          
         * @param type $pagenum          
         * @param type $dataLimit          
         * @return type $useradded video
         */
        public function home_userthumbdata($thumImageorder, $pagenum, $dataLimit) {
              global $wpdb;
              /** Set limit for user videos */
              $pagenum = ! empty ( $pagenum ) ? absint ( $pagenum ) : 1;
              $offset = ($pagenum - 1) * $dataLimit;
              /** Query to get videos for particular user */
              return $this->_wpdb->get_results( 'SELECT s.guid,w.*,p.playlist_name,p.playlist_slugname FROM ' . $wpdb->prefix . 'hdflvvideoshare as w   
                  LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play as m ON m.media_id = w.vid  
                  LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist as p on m.playlist_id = p.pid  
                  LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug  
                  LEFT JOIN ' . $wpdb->users . ' u ON u.ID=w.member_id WHERE w.publish=1 AND p.is_publish=1 AND u.ID=' . intval ( $thumImageorder ) . '  
                  GROUP BY w.vid ORDER BY w.ordering asc LIMIT ' . $offset . ',' . $dataLimit);
        }        
    /** contusMore class ends */
    }
/** Checking contusMore if ends */
}
