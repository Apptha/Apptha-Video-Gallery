<?php
/**  
 * Video admin model file.
 * Save  video , multi publsh , delete video , feature video update , get gallery setting etc.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Checks the VideoSubModel class has been defined if starts  */
if (! class_exists ( 'VideoSubModel' )) {
  /**
   * VideoSubModel class starts
   *
   * @author user
   */
  class VideoSubModel {
    /**
     * VideoModel contructor starts
     */
    public function __construct() {
      /**
       * Set prefix, video, settings and posts table
       * Get video id from param */
      global $wpdb;
      $this->_wpdb        = $wpdb;
      $this->_videotable  = $this->_wpdb->prefix . 'hdflvvideoshare';
      $this->_posttable   = $this->_wpdb->prefix . 'posts';
      $this->_videoId     = absint ( filter_input ( INPUT_GET, 'videoId' ) );
      /** Get current user details and user id */
      $current_user       = wp_get_current_user ();
      $this->member_id    = $current_user->ID;
      $this->_videosettingstable  = $this->_wpdb->prefix . 'hdflvvideoshare_settings';
    }
    
    /**
     * Function to update status / featured of videos
     *
     * @param unknown $videoId
     * @param unknown $status
     * @param unknown $feaStatus
     * @return unknown
     */
    public function status_update($videoId, $status, $feaStatus) {
      /** Check status value is exists */
      if (isset ( $status )) {
        /** Perform video publish, unpublish action */
        $result = $this->_wpdb->update ( $this->_videotable, array ( 'publish' => $status ), array ( 'vid' => $videoId ) );
      }
      /** Check feaStatus value is exist */ 
      if (isset ( $feaStatus )) {
          /** Perform featured, unfeatured action */
        $result = $this->_wpdb->update ( $this->_videotable, array ( 'featured' => $feaStatus ), array ( 'vid' => $videoId ) );
      } 
      /** Return result after perform the status and featured videos update */
      return $result;
    }
    
    /**
     * Function to get search video results
     *
     * @param unknown $searchValue
     * @param unknown $searchBtn
     * @param unknown $order
     * @param unknown $orderDirection
     */
    public function get_videodata($searchValue, $searchBtn, $order, $orderDirection) {
      global $wpdb;
      /** Get current user role and current user
       * Get player color settings and user allowed method */
      $current_user = wp_get_current_user ();
      $userDetails  = get_user_by( 'id',  $current_user->ID );
      if(isset($userDetails->roles)) {
        $user_role    = $userDetails->roles[0];
      }

      $player_colors = getPlayerColorArray();
      $user_allowed_method = explode ( ',', $player_colors ['user_allowed_method'] );
      
      /** Get file types and check whether the method is enabled in user upload option */
      $fileType = '';   
      /** Get file type for YouTube action */
      $fileType .= $this->getfileTypes($fileType, 'c', $user_allowed_method, '1');
      /** Get file type for upload action */
      $fileType .= $this->getfileTypes($fileType, 'y', $user_allowed_method , '2');
      /** Get file type for embed action */
      $fileType .= $this->getfileTypes($fileType, 'embed', $user_allowed_method, '5');
      /** Get file type for URL action */
      $fileType .= $this->getfileTypes($fileType, 'url', $user_allowed_method, '3');
      /** Get file type for rtmp action */
      $fileType .= $this->getfileTypes($fileType, 'rmtp', $user_allowed_method, '4');
      /** Get page number and filter option values
       * Set query to select video id */
      $pagenum = absint ( filter_input ( INPUT_GET, 'pagenum' ) );
      if (empty ( $pagenum )) {
        $pagenum = 1;
      }
      $orderFilterlimit = filter_input ( INPUT_GET, 'filter' );
      $query = 'SELECT DISTINCT ( a.vid ) FROM ' . $this->_videotable . ' a  LEFT JOIN ' . $wpdb->users . ' u ON u.ID=a.member_id  LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play p  ON p.media_id=a.vid LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist pl ON pl.pid=p.playlist_id WHERE pl.is_publish=1';
      /** If search action is done set condition based on name , description
       * Check user role is admin. If not check member id and filetype  */
      if (isset ( $searchBtn )) {
        $query .= ' AND ( a.name LIKE %s OR a.description LIKE %s )';
      }
      if ($user_role != 'administrator') {
        $query .= ' AND a.member_id=%d AND a.file_type IN(' . $fileType . ')';
      }
      /** Set order by values based on direction */
      if (! isset ( $orderDirection )) {
        $query .= ' ORDER BY ' . $order . ' DESC';
      } else {
        $query .= ' ORDER BY ' . $order . ' ' . $orderDirection;
      }
      /** Set query based on search values and user role */
      if (isset ( $searchBtn ) && $user_role != 'administrator') {
        $query = $this->_wpdb->prepare ( $query, '%' . $searchValue . '%', '%' . $searchValue . '%', $current_user->ID );
      } else if ($user_role != 'administrator' && ! isset ( $searchBtn )) {
        $query = $this->_wpdb->prepare ( $query, $current_user->ID );
      } else if (isset ( $searchBtn )) {
        $query = $this->_wpdb->prepare ( $query, '%' . $searchValue . '%', '%' . $searchValue . '%' );
      } else {
        $query = $query;
      }
      /** Get results to display in all videos section and check filter limit. 
       * If it is not set then display 20 values as default  */
      $total = count ( $this->_wpdb->get_results ( $query ) );
      if (! empty ( $orderFilterlimit ) && $orderFilterlimit !== 'all') {
        $limit = $orderFilterlimit;
      } else if ($orderFilterlimit === 'all') {
        $limit = $total;
      } else {
        $limit = 20;
      }
      $offset = ($pagenum - 1) * $limit;
      /** Get user name with video details to display */
      $sqlQuery = 'SELECT DISTINCT ( a.vid ),a.*,u.display_name FROM ' . $this->_videotable . ' a  LEFT JOIN ' . $wpdb->users . ' u ON u.ID=a.member_id LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play p ON p.media_id=a.vid LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist pl ON pl.pid=p.playlist_id WHERE pl.is_publish=1 ';    
      if (isset ( $searchBtn )) {
        $sqlQuery .= ' AND ( a.name LIKE %s OR a.description LIKE %s )';
      }
      if ($user_role != 'administrator') {
        $sqlQuery .= ' AND a.member_id =%d AND a.file_type IN(' . $fileType . ')';
      }
      if (! isset ( $orderDirection )) {
        $sqlQuery .= ' ORDER BY ' . $order . ' DESC';
      } else {
        $sqlQuery .= ' ORDER BY ' . $order . ' ' . $orderDirection;
      }
      /** Get the limit to show */
      $sqlQuery .= ' LIMIT ' . $offset . ', ' . $limit;    
      /** Search results if not administrator */
      if (isset ( $searchBtn ) && $user_role != 'administrator') {
        $sqlQuery = $this->_wpdb->prepare ( $sqlQuery, '%' . $searchValue . '%', '%' . $searchValue . '%', $current_user->ID );
      }/** Search not available and not administrator */
       else if ($user_role != 'administrator' && ! isset ( $searchBtn )) {
        $sqlQuery = $this->_wpdb->prepare ( $sqlQuery, $current_user->ID );
      }/** Search resuts */ 
      else if (isset ( $searchBtn )) {
        $sqlQuery = $this->_wpdb->prepare ( $sqlQuery, '%' . $searchValue . '%', '%' . $searchValue . '%' );
      } else {
        $sqlQuery = $sqlQuery;
      }
      return $this->_wpdb->get_results ( $sqlQuery );
    }
   /** VideoSubModel class ends */
  }
  /** VideoSubModel class has been defined if ends */
}

/** Checks the VideoPageSubModel class has been defined if starts */
if (! class_exists ( 'VideoPageSubModel' )) {
  /**
   * VideoPageSubModel class starts
   *
   * @author user
   */
  class VideoPageSubModel extends VideoSubModel {
    /**
     * Function to get videos
     *
     * @param unknown $searchValue
     * @param unknown $searchBtn
     * @return number
     */
    public function video_count($searchValue, $searchBtn) {
      global $wpdb;
      /** Get current user role and current user */
      $current_user = wp_get_current_user ();
      /** Get current user id */
      $userDetails  = get_user_by( 'id',  $current_user->ID );
      if(isset($userDetails->roles)) {
         $user_role    = $userDetails->roles[0];
      }
      /** Query to fetch video id based on search, menbers */
      $sql = 'SELECT DISTINCT ( a.vid ) FROM ' . $this->_videotable . ' a
         LEFT JOIN ' . $wpdb->users . ' u ON u.ID=a.member_id
         LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_med2play p ON p.media_id=a.vid
         LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_playlist pl ON pl.pid=p.playlist_id WHERE pl.is_publish=1';
      /** Check search action is done. If yes then set condition */
      if (isset ( $searchBtn )) {
        $sql .= ' AND ( name LIKE %s OR description LIKE %s  )';
      }
      /** Check user is admin. If not then set condition */
      if ($user_role != 'administrator') {
        $sql .= ' AND member_id=%d';
      }    
      /** Get current user is not admin and search query available */
      if (isset ( $searchBtn ) && $user_role != 'administrator') {
        $sql = $this->_wpdb->prepare ( $sql, '%' . $searchValue . '%', '%s' . $searchValue . '%', $current_user->ID );
      } 
       /** Get current user is not admin and search query not available */
       else if ($user_role != 'administrator' && ! isset ( $searchBtn )) {
        $sql = $this->_wpdb->prepare ( $sql, $current_user->ID );
      } 
      /** Search videos from query */
      else if (isset ( $searchBtn )) {
        $sql = $this->_wpdb->prepare ( $sql, '%' . $searchValue . '%', '%' . $searchValue . '%' );
      } else {
        $sql = $sql;
      }
      /** Get video details to display */
      $result = $this->_wpdb->get_results ( $sql );
      return count ( $result );
    }
    /**
     * Function to unlink the given file 
     * 
     * @param type $filePath
     */
    function unlinkFile ( $filePath ) {
        /** Get upload directory path to unlink file */
        $uploadPath = getUploadDirPath ();
        /** Check file value is exist */
        if($filePath ) {
            /** Delete the given file */
            unlink ( $uploadPath . $filePath);
        }
    }
    /**
     * Function to delete video.
     *
     * @param unknown $videoId
     * @return Ambigous <number, false, boolean, mixed>
     */
    public function video_delete($videoId) {
      /** Get slug id for the given video id */
      $slug = $this->_wpdb->get_col ( "SELECT slug FROM " . $this->_videotable . "  WHERE vid IN (" . "$videoId" . ")" );
      /** Implode slug id's */
      $slugid = implode ( ",", $slug );
      /** Get video details for the given video id  */
      $query = "SELECT file,file_type,image,opimage,srtfile1,srtfile2 FROM " . $this->_videotable . " WHERE vid IN (" . "$videoId" . ")";
      $file_details = $this->_wpdb->get_results ( $query );
      /** Looping through video details */
      foreach ( $file_details as $file_detail ) {
        /** If video is uploaded video, then get file path and delete */
        if ($file_detail->file_type == 2) {
          /** Unlink the uploaded video file */
           $this->unlinkFile ($file_detail->file);
          /** Unlink uploaded thumb timage */
          $this->unlinkFile ($file_detail->image);
          /** Unlink uploaded preview image */
          $this->unlinkFile ($file_detail->opimage);
        }
        /** If srt file1 is uploaded then delete it */
        /** Unlink subtitle1 file */
            $this->unlinkFile ($file_detail->srtfile1);
        /** If srt fil2 is uploaded then delete it */
        /** Unlink subtitle2 file */
        $this->unlinkFile ( $file_detail->srtfile2 );
      }
      /** Delete videos from videos table */
      $query = "DELETE FROM " . $this->_videotable . "  WHERE vid IN (" . "$videoId" . ")";
      $this->_wpdb->query ( $query );
      /** Delete  corresponding posts in posts table  */    
      $query = "DELETE FROM " . $this->_posttable . "  WHERE ID IN (" . "$slugid" . ")";
      /** execute delete query */
      return $this->_wpdb->query ( $query );
    }
  }
}                
/** Checks the VideoModel class has been defined if starts */
if (! class_exists ( 'VideoModel' )) {
  /**
   * VideoModel class starts
   * 
   * @author user
   */
  class VideoModel extends VideoPageSubModel {  
    /**
     * Function to insert video
     * 
     * @param unknown $videoData
     * @return unknown
     */
    public function insert_video($videoData) {  
        /** Get last post id to insert new data */
        $post_id                  = $this->_wpdb->get_var ( 'SELECT ID FROM ' . $this->_posttable . ' order by ID desc' );
        /** Insert video data into videos table */
        if ($this->_wpdb->insert ( $this->_videotable, $videoData )) {
            /** Get last inserted id and generate short code  */
            $last_insert_video_id = $this->_wpdb->insert_id;
            $post_content         = '[hdvideo id=' . $this->_wpdb->insert_id . ']';
            /** Increase post id */
            $post_id              = $post_id + 1;
            /** Generate post detials for the inserted video */
            $postsData            = array ( 'post_author'   => $this->member_id, 'post_content'  => $post_content,
              'post_title'    => $videoData ['name'], 'post_excerpt'  => '', 'post_status'   => 'publish',
              'comment_status'        => 'open', 'ping_status'   => 'closed', 'post_password' => '',
              'post_name'     => sanitize_title ( $videoData ['name'] ), 'post_date'     => date ( 'Y-m-d H:i:s' ),
              'post_date_gmt' => date ( 'Y-m-d H:i:s' ), 'to_ping'       => '', 'pinged'        => '',
              'post_modified' => date ( 'Y-m-d H:i:s' ), 'post_parent'   => 0, 'menu_order'    => '0',
              'post_type'     => 'videogallery', 'post_modified_gmt'     => date ( 'Y-m-d H:i:s' ),
              'post_content_filtered' => '', 'post_mime_type'=> '', 'comment_count' => '0'  );
            
            /** Check video id is not exists */
            if (empty ( $this->_videoId )) {
                /** Default wordpress method for add post data */
                $post_ID  = wp_insert_post ( $postsData );
            }
            /** Set post url and update into post table 
             * Then update post id into videos table in slug column */
            $guid       = home_url() . '/?post_type=videogallery&p=' . $post_ID;
            $this->_wpdb->update ( $this->_posttable, array ('guid' => $guid ), array ('ID' => $post_ID) );
            $this->_wpdb->update ( $this->_videotable, array ('slug' => $post_ID ), array ('vid' => $last_insert_video_id) );
            /** Return last inserted video id */
            return $last_insert_video_id;
        }
    } 
  
    /**
     * Function to update video starts
     * 
     * @param unknown $videoData
     * @param unknown $videoId
     */
    public function video_update($videoData, $videoId) { 
        /** Update new video detials into corresponding videos  */
        $this->_wpdb->update ( $this->_videotable, $videoData, array ( 'vid' => $videoId ) );
        /** Fetch slug from videos table for the updated video */
        $slug_id        = $this->_wpdb->get_var ( 'SELECT slug FROM ' . $this->_videotable . ' WHERE vid =' . $videoId );
        /** If slug id is not empty */
        if (! empty ( $slug_id )) {
          /** Set post detials to update */
          $post_content = '[hdvideo id=' . $videoId . ']';
          $postsData    = array (
            'post_author'     => $this->member_id,
            'post_excerpt'    => '',
            'post_status'     => 'publish',
            'post_content'    => $post_content,
            'post_title'      => $videoData ['name'],
            'comment_status'  => 'open',
            'ping_status'     => 'closed',
            'post_password'   => '',
            'post_parent'     => 0,
            'menu_order'      => '0',
            'post_name'       => sanitize_title ( $videoData ['name'] ),
            'to_ping'         => '',
            'pinged'          => '',
            'post_modified'   => date ( 'Y-m-d H:i:s' ),
            'post_modified_gmt'     => date ( 'Y-m-d H:i:s' ),
            'post_content_filtered' => '',
            'post_type'       => 'videogallery',
            'post_mime_type'  => '',
            'comment_count'   => '0',
            'ID'              => $slug_id 
          );
          /**
           * Update post details for the updated video
           */
          wp_update_post ( $postsData );
          /**
           * Generate post url and update into post table
           * Then update slug itno videos table
           */
          $guid = home_url() . '/?post_type=videogallery&p=' . $slug_id;
          $this->_wpdb->update ( $this->_posttable, array ( 'guid' => $guid ), array ( 'ID' => $slug_id ) );
          $this->_wpdb->update ( $this->_videotable, array ( 'slug' => $slug_id ), array ( 'vid' => $videoId ) );
        }
        return;
    } 
    
  /**
   * Function to get file types for query
   * 
   * @param unknown $fileType
   * @param unknown $method
   * @param unknown $user_allowed_method
   * @param unknown $value
   * @return Ambigous <string, unknown>
   */
  public function getfileTypes( $fileType, $method, $user_allowed_method, $value) { 
    $file_type = '';
    /**
     * Check selected method is exist in user allowed method     
     */
    if (in_array ( $method , $user_allowed_method )) {
      if($fileType == '') { 
        /**
         * If file type is empty then set file type
         */
        $file_type = $value;
      } else{
        /**
         * If file type is exist then concatinate with the existing data
         */
        $file_type = $file_type . ','. $value;
      }
    } 
    return $file_type;
  }
  
  /**
   * Function to get playlist details
   * 
   * @param unknown $vid
   * @return unknown
   */
  public function get_playlist_detail($vid) { 
    global $wpdb;
    /**
     * Query to get playlist detials for the given video id
     */
    return $this->_wpdb->get_results ( 'SELECT t3.playlist_name,t3.pid' . ' FROM ' . $wpdb->prefix . 'hdflvvideoshare_playlist AS t3' . ' LEFT JOIN  ' . $wpdb->prefix . 'hdflvvideoshare_med2play AS t2' . ' ON t3.pid = t2.playlist_id' . ' WHERE t3.is_publish=1 AND t2.media_id="' . intval ( $vid ) . '"' );
  }
  
  /**
   * Function to edit video details
   * 
   * @param unknown $videoId
   */
  public function video_edit($videoId) {
    global $current_user, $wpdb;
    /**
     * Check video id is exist and current user have permission to edit videos 
     */
    if (isset ( $videoId ) && ! current_user_can ( 'manage_options' )) {
      /**
       * Get current user id
       */
      $user_id = $current_user->ID;
      /**
       * Count the videos for the current user
       */
      $video_count = $wpdb->get_var ( 'SELECT count( * ) FROM ' . $this->_videotable . ' WHERE vid = ' . $videoId . ' and member_id = ' . $user_id );
      /**
       * If count is 0, then return with error message
       */
      if ($video_count == 0) {
        wp_die ( __ ( 'You do not have permission to access this page.' ) );
      }
    } 
    /**
     * Fetch video details to edit
     */
    return $this->_wpdb->get_row ( 'SELECT a.*,b.tags_name FROM ' . $this->_videotable . ' as a LEFT JOIN ' . $this->_wpdb->prefix . 'hdflvvideoshare_tags b ON b.media_id=a.vid WHERE a.vid =' . $videoId );
  } 
  
  
  /**
   * Function for multiple video featured
   * 
   * @param unknown $videoId          
   */
  public function video_multifeatured($videoId) {
    /**
     * Query to set featured as mulitple videos
     */
    $query = 'UPDATE ' . $this->_videotable . ' SET `featured`=1 WHERE vid IN (' . $videoId . ')';
    return $this->_wpdb->query ( $query );
  }
  /**
   * Function for multiple video publish
   * 
   * @param unknown $videoId          
   */
  public function video_multipublish($videoId) {
    /**
     * Query to publish mulitple videos
     */
    $query = 'UPDATE ' . $this->_videotable . ' SET `publish`=1 WHERE vid IN (' . $videoId . ')';
    return $this->_wpdb->query ( $query );
  }
  /**
   * Function for multiple video unfeatured
   * 
   * @param unknown $videoId          
   */
  public function video_multiunfeatured($videoId) {
    /**
     * Query to set unfeatured as mulitple videos
     */
    $query = 'UPDATE ' . $this->_videotable . ' SET `featured`=0 WHERE vid IN (' . $videoId . ')';
    return $this->_wpdb->query ( $query );
  }
  /**
   * Function for multiple video unpublish
   * 
   * @param unknown $videoId          
   */
  public function video_multiunpublish($videoId) {
    /**
     * Query to unpublish mulitple videos
     */
    $query = 'UPDATE ' . $this->_videotable . ' SET `publish`=0 WHERE vid IN (' . $videoId . ')';
    return $this->_wpdb->query ( $query );
  }
  /**
   * VideoModel class ends
   */
  }
  /**
   * VideoModel class has been defined if ends
   */
}