<?php
/**  
 * Video home front end model file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
include_once(APPTHA_VGALLERY_BASEDIR.'/helper/watchhelper.php');
/** Checks the ContusVideo class has been defined if starts */
if ( !class_exists ( 'ContusVideo' ) ) {
  /**
   * ContusVideo class starts
   * 
   * @author user
   */ 
  class ContusVideo {
  	/**
  	 * WatchHelper trait is used to include commonly used functions on ContusVideo class
  	 */
    /**
     * ContusVideo constructor  is used to initalize
     */  
    public function __construct () { 
        /** Set prefix and table name */
        global $wpdb;
        $this->_wpdb            = $wpdb;
        /** Set Videoshare table prefix */
        $this->_videoinfotable  = $this->_wpdb->prefix . 'hdflvvideoshare';
        $this->watchDetailsTable = WVG_WATCH_LATER;
    }
      
    /**
     * Function to get video details
     * 
     * @param unknown $vid
     * @return multitype:
     */
    public function get_video_detail($vid) {
    	/** Connect to DB in WP */
        global $wpdb;
        /** Get the admin view */
        $adminView  = filter_input ( INPUT_GET, 'adminview' );
        $published = '';
        /** Check wheather the view is from admin
         * Check the status is published */
        if( !$adminView ){
        	$published = 'AND w.publish=1 ';
        }
        /** Get related videos count from settings 
         * If value is not given in settings, 
         * assign default value as 100 */      
        $related_video_count    = get_related_video_count ();
        /** Check the related video count is empty
         * If empty then set it into 100 */
        if (empty ( $related_video_count )) {
            $related_video_count  = 100;
        }
        /** Get video details for the given video id */
        $select         = 'SELECT distinct w.vid,w.*,s.guid FROM ' . $wpdb->prefix . 'hdflvvideoshare w  
             LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid 
             LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id  
             LEFT JOIN ' . $wpdb->prefix . 'posts s ON s.ID=w.slug 
             WHERE w.vid="' . $vid . '"' . $published . ' AND p.is_publish=1 GROUP BY w.vid';        
        $themediafiles  = $wpdb->get_results ( $select );
        if( !$adminView ){
        /** Get playlist id for the given video id */
        $getPlaylist    = $wpdb->get_results ( 'SELECT playlist_id FROM ' . $wpdb->prefix . 'hdflvvideoshare_med2play WHERE media_id="' . intval ( $vid ) . '" LIMIT 1' );
        
        /** Get playlist id and related videos 
         * Looping details */
        foreach ( $getPlaylist as $getPlaylists ) {
            /** Getting playlist id */
            if ($getPlaylists->playlist_id != '') {
                $playlist_id = $getPlaylists->playlist_id;
            } else {
                /** Else dsiplay no videos is here message */
                echo 'No videos is  here';
            }   
            /** Fetch video detials for the given video id */         
            $fetch_video = 'SELECT distinct w.vid FROM ' . $wpdb->prefix . 'hdflvvideoshare w  
                 LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid  
                 LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id  
                 WHERE ( m.playlist_id = "' . $playlist_id . '" 
                 AND m.media_id = w.vid AND w.file_type!=5 AND p.pid=m.playlist_id AND m.media_id != "' . intval ( $vid ) . '"  
                 AND w.publish=1 AND p.is_publish=1  ) GROUP BY w.vid order by w.vid DESC LIMIT ' . $related_video_count;
            $fetched = $wpdb->get_results ( $fetch_video );            
            /** Array rotation to autoplay the videos correctly */ 
            $arr1 = array ();
            $arr2 = array ();
            /** Check count of videos and split into two array */          
            if (count ( $fetched ) > 0) {
                foreach ( $fetched as $r ) {
                    if ($r->vid > $themediafiles [0]->vid) { 
                        /** Storing greater values in an array for home page */ 
                        $query = 'SELECT distinct w.vid,w.*,s.guid FROM ' . $wpdb->prefix . 'hdflvvideoshare w 
                            LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid 
                            LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id 
                            LEFT JOIN ' . $wpdb->prefix . 'posts s ON s.ID=w.slug 
                            WHERE ( w.vid=' . $r->vid . ' AND m.media_id != "' . intval ( $vid ) . '" AND w.file_type!=5  
                            AND w.publish=1 AND p.is_publish=1  ) GROUP BY w.vid';                        
                        $arrGreat = $wpdb->get_row ( $query );
                        $arr1 [] = $arrGreat;
                    } else { 
                        /** Storing lesser values in an array for home page  */
                        $query = 'SELECT distinct w.vid,w.*,s.guid FROM ' . $wpdb->prefix . 'hdflvvideoshare w  
                             LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid  
                             LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id  
                             LEFT JOIN ' . $wpdb->prefix . 'posts s ON s.ID=w.slug 
                             WHERE ( w.vid=' . $r->vid . ' AND m.media_id != "' . intval ( $vid ) . '" AND w.file_type!=5  
                             AND w.publish=1 AND p.is_publish=1  ) GROUP BY w.vid';                        
                        $arrLess = $wpdb->get_row ( $query );
                        $arr2 [] = $arrLess;
                    }
                }
            }
            /** Merge all results to display */
            $themediafiles = array_merge ( $themediafiles, $arr1, $arr2 );
        }
       }
        /** Return video and related video details */
        return $themediafiles;
    }
  
    /**
     * Function to get playlist detail
     *
     * @global type $wpdb
     * @param type $pid          
     * @param type $type          
     * @return type $themediafiles
     */
    public function video_pid_detail($pid, $type, $number_related_video) {
        global $wpdb;
        /** Set query to get video details for the given playlist id */
        $select   = ' SELECT w.*,s.guid,m.playlist_id,u.display_name,u.ID FROM ' . $wpdb->prefix . 'hdflvvideoshare w';
        $select   .= ' LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid';
        $select   .= ' LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id';
        $select   .= ' LEFT JOIN ' . $wpdb->prefix . 'posts s ON s.ID=w.slug';
        $select   .= ' LEFT JOIN ' . $wpdb->users . ' u ON u.ID=w.member_id';
        $select   .= ' WHERE ( m.playlist_id = "' . intval ( $pid ) . '"';
        /** Set condition for query */
        $where  = '';
        if ($type === 'playxml') {
          $where  = 'AND w.file_type!=5';
        } 
        /** Set group and order by values */
        $select   .= ' AND m.media_id = w.vid ' . $where . ' AND w.publish=1 AND p.is_publish=1 ) GROUP BY w.vid ';
        $select   .= ' ORDER BY w.vid ASC LIMIT ' . $number_related_video;
        /** Return video details based on playlist id */ 
        return $wpdb->get_results ( $select );
    }
    
    /**
     * Function get feature video player details. 
     * If not feature videos then fetch recent videos
     *
     * @return type array
     */
    public function get_featuredvideodata() {
        global $wpdb;
        /** Get related videos count */
        $related_video_count = get_related_video_count ();
        /** If related video count is empty then set default value as 100 */
        if (empty ( $related_video_count )) {
            $related_video_count = 10;
        }
        /** Query to fetch featured videos */
        $query      = 'SELECT distinct w.*,s.guid,p.playlist_name,u.display_name FROM ' . $this->_videoinfotable . ' w   
             LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid 
             LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id  
             LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug 
             LEFT JOIN ' . $wpdb->users . ' u ON u.ID = w.member_id 
             WHERE featured=1 AND publish=1 AND p.is_publish=1 GROUP BY w.vid ORDER BY ordering ASC LIMIT ' . $related_video_count;
        $feature    = $this->_wpdb->get_results ( $query );
        /** If feature videos are not exist then fetch recent videos */
        if (! $feature) {
            $query    = 'SELECT distinct w.*,s.guid,p.playlist_name,u.display_name FROM ' . $this->_videoinfotable . ' w  
                 LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid 
                 LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id 
                 LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug 
                 LEFT JOIN ' . $wpdb->users . ' u ON u.ID = w.member_id 
                 WHERE publish=1 AND p.is_publish=1 GROUP BY w.vid ORDER BY ordering ASC LIMIT ' . $related_video_count;
            $feature  = $this->_wpdb->get_results ( $query );
        }   
        /** Return featured video details */     
        return $feature;
    }
  
    /**
     * Function for get all feature video banners
     *
     * @return type banners
     */
    public function get_featuredvideodata_banner() {
        global $wpdb;
        /** Query to get videos for banner palyer */
        $query = 'SELECT distinct w.*,s.guid FROM ' . $this->_videoinfotable . ' w 
             LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid 
             LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id 
             LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug 
             WHERE featured=1 and publish=1 AND p.is_publish=1 GROUP BY w.vid ORDER BY vid ASC LIMIT 0,4';
        /** Return featured video details for banner player */
        return $this->_wpdb->get_results ( $query );
    }
    
    /**
     * Function for getting thumb details for home page category section
     *
     * @global type $wpdb
     * @param type $thumImageorder          
     * @param type $dataLimit          
     */
    public function get_home_catthumbdata( $where, $dataLimit ) {
        global $wpdb; 
          /** Query to fetch category thumbs */
          $query = 'SELECT s.guid, w.*,p.playlist_name, u.display_name FROM ' . $wpdb->prefix . 'hdflvvideoshare as w   
               LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play as m ON m.media_id = w.vid 
               LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist as p on m.playlist_id = p.pid  
               LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug 
               LEFT JOIN ' . $wpdb->users . ' u ON u.ID = w.member_id 
               WHERE w.publish=1 AND p.is_publish=1 AND m.playlist_id=' . intval ( $where ) . '  
               GROUP BY w.vid ORDER BY w.ordering asc LIMIT ' . $dataLimit;
          /** Return video home cat thumb details */
          return $this->_wpdb->get_results ( $query );
    }
  
    /**
     * Function for getting thumb details for home page
     *
     * @param type $thumImageorder          
     * @param type $where          
     * @param type $dataLimit          
     */
    public function get_thumdata($thumImageorder, $where, $dataLimit) {
        global $wpdb;
        /** Query to get popular/ recent / featured videos */
        $query = 'SELECT distinct w.*,s.guid,s.ID,p.playlist_name,p.pid,p.playlist_slugname FROM ' . $this->_videoinfotable . ' w 
             LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid  
             LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id  
             LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug 
             WHERE w.publish=1 AND p.is_publish=1 ' . $where . ' GROUP BY w.vid ORDER BY ' . $thumImageorder . ' LIMIT ' . $dataLimit;
        /** Return home page video details */
        return $this->_wpdb->get_results ( $query );
    }
    
    /**
     * Function get countof thumbdata
     *
     * @param type $thumImageorder          
     * @param type $where          
     */
    public function get_countof_thumdata($thumImageorder, $where) {
        global $wpdb;
        /** Query to count popular/ recent / featured videos */
        $query = 'SELECT w.vid FROM ' . $this->_videoinfotable . ' w  
             LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid  
             LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id  
             LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug 
             WHERE w.publish=1 AND p.is_publish=1 ' . $where . ' GROUP BY w.vid ORDER BY ' . $thumImageorder;
        /** Return count of home page videos */
        return count ( $this->_wpdb->get_results ( $query ) );
    }
  
    /**
     * Function for get playlist xml dat
     *
     * @param type $getVid          
     * @param type $thumImageorder          
     * @param type $where          
     * @param type $numberofvideos          
     */
    public function get_playxmldata($getVid, $thumImageorder, $where, $numberofvideos) {
        global $wpdb;
        $videoid  = $getVid;
        /** Get video detais for the given vid */
        $query    = 'SELECT distinct w.*,s.guid,p.playlist_name,p.pid FROM ' . $this->_videoinfotable . ' w  
             LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid 
             LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id   
             LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug 
             WHERE w.publish=1 AND p.is_publish=1 AND w.vid=' . $videoid . ' GROUP BY w.vid';
        $rows     = $this->_wpdb->get_results ( $query );
        /** If count is more than zero then fetch related videos */
        if (count ( $rows ) > 0) {
          $query    = 'SELECT distinct w.*,s.guid,p.playlist_name,p.pid FROM ' . $this->_videoinfotable . ' w  
               LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid 
               LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id 
               LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug 
               WHERE w.publish=1 AND p.is_publish=1 ' . $where . ' AND w.vid != ' . $videoid . ' 
               GROUP BY w.vid ORDER BY ' . $thumImageorder . ' LIMIT ' . ($numberofvideos - 1);
          $playlist = $this->_wpdb->get_results ( $query );
          $arr1   = array ();
          $arr2   = array ();
        /** If count is more than 0, then loop through video detials */
        if (count ( $playlist ) > 0) {
          foreach ( $playlist as $r ) {
            if ($r->vid > $rows [0]->vid) { 
              /** Storing greater values in an array */ 
              $query    = 'SELECT distinct w.*,s.guid,p.playlist_name,p.pid FROM ' . $this->_videoinfotable . ' w  
                   LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid 
                   LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id 
                   LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug 
                   WHERE w.publish=1 AND p.is_publish=1 AND w.vid=' . $r->vid;
              $arrGreat = $this->_wpdb->get_row ( $query );
              $arr1 []  = $arrGreat;
            } else { 
              /** Storing lesser values in an array */ 
              $query   = 'SELECT distinct w.*,s.guid,p.playlist_name,p.pid FROM ' . $this->_videoinfotable . ' w 
                   LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play m ON m.media_id = w.vid 
                   LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist p ON p.pid=m.playlist_id 
                   LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=w.slug 
                   WHERE w.publish=1 AND p.is_publish=1 AND w.vid=' . $r->vid;
              $arrLess = $this->_wpdb->get_row ( $query );
              $arr2 [] = $arrLess;
            }
          }
        }
        /** Merge results and return to play videos */
        return array_merge ( $rows, $arr1, $arr2 );
      } 
    }
   
  /** ContusVideo class ends */
  }
/** Checking ContusVideo exist if ends */
} 
