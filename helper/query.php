<?php
/**
 * Wordpress video gallery helper file.
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/**
 * Get video id based on the post id
 * 
 * @return Ambigous <int, NULL>
 */
function pluginVideoID () {
  global $wpdb;  
  /** Query to return video id */
  return $wpdb->get_var ( 'SELECT vid FROM ' . $wpdb->prefix . 'hdflvvideoshare WHERE slug="' . intval ( get_the_ID () ) . '"' );
}
/**
 * Get video details from database for the given video id
 * 
 * @param unknown $videoID
 * @return Ambigous <object, NULL>
 */
function videoDetails ( $videoID, $type ) {
    global $wpdb; 
    /** Query to select video detials */ 
    $query = 'SELECT distinct( t1.vid ),t1.*, t2.playlist_id
                  FROM ' . $wpdb->prefix . 'hdflvvideoshare AS t1
                  LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play AS t2 ON t2.media_id = t1.vid
                  LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist AS t3 ON t3.pid = t2.playlist_id
                  LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_tags AS t4 ON t1.vid = t4.media_id ';
    /** Check if related video slider */
    if ($type == 'related') {
      $query .= ' LEFT JOIN ' . $wpdb->posts . ' s ON s.ID=t1.slug ';
    }                  
    $query .=  ' WHERE t1.publish=1 AND t3.is_publish=1 AND t1.vid=' . intval ( $videoID ) . ' LIMIT 1';
    /** Return video details */
    return $wpdb->get_row ( $query );
}
/**
 * Get playlist details from database for the given playlist id
 *
 * @param unknown $videoID
 * @return Ambigous <object, NULL>
 */
function playlistDetails ( $playID ) {
  global $wpdb;
  /** Query to get particular playlist details */
  return $wpdb->get_row ( 'SELECT playlist_name,playlist_slugname FROM ' . $wpdb->prefix . 'hdflvvideoshare_playlist WHERE pid="' . intval ( $playID ) . '"' );
}
/**
 * Function to get video ad details
 * 
 * @param unknown $type
 * @param unknown $limit
 * @return Ambigous <object, NULL>
 */
function getVideoAdDetails ( $type, $limit ) {
  /** Get $wpdb varaible */
  global $wpdb;
  /** Set limit in query */
  $limitQuery       = '';
  if( $limit ) {
    $limitQuery   = ' LIMIT ' . $limit ;
  }
  /** Get published ads from db */
  $selectPlaylist   = "SELECT * FROM " . $wpdb->prefix . "hdflvvideoshare_vgads WHERE admethod = '" . $type . "' AND publish=1 " . $limitQuery;
  /** Return video ads */
  return $wpdb->get_results ( $selectPlaylist );
}
/**
 * Get playlist ID from slug name
 * 
 * @param unknown $play_name
 * @return Ambigous <string, NULL>
 */
function get_playlist_id ( $play_name ) {
  global $wpdb;
  return $wpdb->get_var ( 'SELECT pid FROM ' . $wpdb->prefix . 'hdflvvideoshare_playlist WHERE playlist_slugname="' . $play_name . '" AND is_publish=1 LIMIT 1' );
}
/**
 * Get playlist Name from Playlist id
 * 
 * @param unknown $play_id
 * @return Ambigous <string, NULL>
 */
function get_playlist_name ( $play_id ) {
  global $wpdb;
  return $wpdb->get_var ( 'SELECT playlist_name FROM ' . $wpdb->prefix . 'hdflvvideoshare_playlist WHERE pid="' . $play_id . '" AND is_publish=1 LIMIT 1' );
}
/**
 * Function to get all playlist
 * 
 * @param unknown $orderby
 * @param unknown $limit
 * @return Ambigous <object, NULL>
 */
function getPlaylist ($orderby , $limit) {
  global $wpdb;
  /** Set order by and limit values in query */
  $orderQuery = $limitQuery = '';
  if( $orderby ) {
    $orderQuery   = ' ORDER BY ' . $orderby . ' ';
  }
  if( $limit ) {
    $limitQuery     = ' LIMIT ' . $limit;
  }
  /** Get all playlist details from db */
  return $wpdb->get_results ( 'SELECT * FROM ' . $wpdb->prefix . 'hdflvvideoshare_playlist WHERE is_publish=1 ' . $orderQuery . $limitQuery );
}
/**
 * Fucntion to get category thumb videos fro video home ,more pages
 * 
 * @param unknown $pid
 * @param unknown $limit
 * @param unknown $thumImageorder
 * @param object
 */
function getCatVideos ($pid, $limit, $thumImageorder) {
  global $wpdb;
  $limitQuery = '';
  if($limit) {
    $limitQuery = ' LIMIT ' . $limit;
  }
  /** Query to get video details for particular playlist */
  $sql = 'SELECT s.guid,w.* FROM ' . $wpdb->prefix . 'hdflvvideoshare as w 
      LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_med2play as m ON m.media_id = w.vid 
      LEFT JOIN ' . $wpdb->prefix . 'hdflvvideoshare_playlist as p on m.playlist_id = p.pid 
      LEFT JOIN ' . $wpdb->prefix . 'posts s ON s.ID=w.slug 
      WHERE w.publish=1 and p.is_publish=1 and m.playlist_id=' . intval( $pid ) . ' GROUP BY w.vid ORDER BY ' . $thumImageorder . $limitQuery;
  /** Return category videos */
  return $wpdb->get_results( $sql );
}
/**
 * Function to get count of all active playlist
 * 
 * @return Ambigous <int, NULL>
 */
function getPlaylistCount () {
  global $wpdb;
  /** Get active playlist count from playlsit table */
  return $wpdb->get_var ( 'SELECT count( pid ) FROM ' . $wpdb->prefix . 'hdflvvideoshare_playlist WHERE is_publish=1' );
}
/**
 * Get playlist count to increase ordering while adding new playlist
 * 
 * @return Ambigous <int, NULL>
 */
function getAllPlaylistCount () {
  global $wpdb;
  /** REturn active, inactive playlist counts */
  return $wpdb->get_var ( 'SELECT COUNT( pid ) FROM ' . $wpdb->prefix . 'hdflvvideoshare_playlist' );
}
/**
 * Get videos count to increase ordering while adding new videos
 * 
 * @return Ambigous <int, NULL>
 */
function getAllVideosCount () {
  global $wpdb;
  /** Return count for all videos */
  return $wpdb->get_var ( 'SELECT COUNT( vid ) FROM ' . $wpdb->prefix . 'hdflvvideoshare' );
}
/**
 * Get user id from username
 * 
 * @param unknown $user_name          
 * @return Ambigous <string, NULL>
 */
function get_user_id ( $user_name ) {
    global $wpdb;    
    /** Return user id */
    return $wpdb->get_var ( 'SELECT ID FROM ' . $wpdb->users . ' WHERE display_name="' . $user_name . '" LIMIT 1' );
}
/**
 * Get User Name from ID
 * 
 * @param unknown $user_name          
 * @return Ambigous <string, NULL>
 */
function get_user_name ( $user_id ) {
    global $wpdb; 
    /** Return user name */   
    return $wpdb->get_var ( 'SELECT display_name FROM ' . $wpdb->users . ' WHERE ID="' . $user_id . '" LIMIT 1' );     
}
/**
 * Get video home page id from database
 * 
 * @return Ambigous <int, NULL>
 */
function videoHomePageID () {
  global $wpdb;
  /** Return video home page id */
  return $wpdb->get_var ( "SELECT ID FROM " . $wpdb->prefix . "posts WHERE post_content LIKE '%[videohome]%' AND post_status='publish' AND post_type='page' LIMIT 1" );
}
/**
 * Get more page id from database
 * 
 * @return Ambigous <int, NULL>
 */
function morePageID () {
  global $wpdb;
  /** Return video more page id */
  return $wpdb->get_var ( "SELECT ID FROM " . $wpdb->prefix . "posts WHERE post_content LIKE '%[videomore]%' AND post_status='publish' AND post_type='page' LIMIT 1" );
}
/**
 * Check whether permalink enabled or not
 * 
 * @return Ambigous <string, NULL>
 */
function getPermalink () {
    global $wp_rewrite;   
    /** Return permalink  */
    return $wp_rewrite->get_page_permastruct ();
}
/**
 * Get video link
 * 
 * @param unknown $postid
 * @return string
 */
function get_video_permalink( $postid ) {
    /** GEt permalink and post details */
    $link           = getPermalink ();
    $postDetails    = get_post ( $postid );
    
    if (! empty ( $link )) { 
      /** Return SEO video URL if permalink enabled */ 
      return home_url() . '/' . $postDetails->post_type . '/' . $postDetails->post_name . '/';
    } else { 
      /** Return Non SEO video URL if permalink disabled  */
      return htmlspecialchars_decode($postDetails->guid);
    }
}

/**
 * Get playlist permalink
 * 
 * @param unknown $morepageid
 * @param unknown $playlist_id
 * @param unknown $slug_name
 * @return string
 */
function get_playlist_permalink($morepageid, $playlist_id, $slug_name) {

    $link = getPermalink ();    
    /** Return SEO playlist URL if permalink enabled */
    if (! empty ( $link )) {  
      return home_url() . '/categoryvideos/' . $slug_name . '/';
    } else {  
      /** Return Non SEO playlist URL if permalink disabled */
      return home_url() . '/?page_id=' . $morepageid . '&amp;playid=' . $playlist_id;
    }
}
/**
 * Get User permalink
 * 
 * @param unknown $morepageid
 * @param unknown $userid
 * @param unknown $username
 * @return string
 */
function get_user_permalink($morepageid, $userid, $username) {

    $link = getPermalink ();  
    if (! empty ( $link )) {  
      /** Return SEO playlist URL if permalink enabled */
      return home_url() . '/user/' . $username . '/';
    } else { 
      /** Return Non SEO playlist URL if permalink disabled */
      return home_url() . '/?page_id=' . $morepageid . '&amp;userid=' . $userid;
    }
}
/**
 * Get more page permalink
 * 
 * @param unknown $morepageid
 * @param unknown $morePage
 * @return string
 */
function get_morepage_permalink($morepageid, $morePage) {

  $link   = getPermalink ();
  if (! empty ( $link )) {
    /** Return SEO more page URL if permalink enabled  */
    if (isset ( $morePage )) {
      $type   = $morePage;
      /** Check more page is popular / recent  / featured / categories/ random  */
      switch ($type) {
        case 'popular' :
          /** Set popular page url */
            $location = home_url () . '/popular_videos/';
            break;
        case 'featured' :
          /** Set featured page url */
            $location = home_url () . '/featured_videos/';
            break;
        case 'random' :
          /** Set random page url */
            $location = home_url () . '/random_videos/';
            break;
        case 'categories' :
          /** Set categories page url */
            $location = home_url () . '/all-category_videos/';
            break;
        case 'recent' :
        default:
          /** Set recent page url */
            $location = home_url () . '/recent_videos/';
            break;
      }
    }
    /** Return more pages URL */
    return $location;
  } else {
    /** Return Non SEO more page URL if permalink disabled */
    return home_url () . '/?page_id=' . $morepageid . '&amp;more=' . $morePage;
  }
}
/**
 * Funtion to get plugin settings
 * 
 * @return object
 */
function getPluginSettings() {
    global $wpdb;  
    /** Return plugin settings data */
    return $wpdb->get_row ( 'SELECT * FROM ' . $wpdb->prefix . 'hdflvvideoshare_settings WHERE settings_id="1"' );
}
/**
 * Function to get related videos count from settings
 * 
 * @return object
 */
function get_related_video_count () {    
  /** Get player color */    
    $playerColors   = getPlayerColorArray ();
    /** Return relate video count */ 
    return $playerColors ['related_video_count'];
}
/**
 * Function to get player_colors count from settings
 * 
 * @return object
 */
function getPlayerColorArray () {
    $playerColor    = getPluginSettings ();
    /** Return player color values */
    return unserialize($playerColor->player_colors);
}
?>