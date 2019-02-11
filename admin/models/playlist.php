<?php
/**  
 * Video playlist admin model file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/**
 * Check PlaylistModel has been defined starts
 */
if ( !class_exists ( 'PlaylistModel' ) ) {
  /**
   * PlaylistModel class starts
   * 
   * @author user
   */
  class PlaylistModel {
      /**
       * PlaylistModel constructor
       */
      public function __construct() {
        global $wpdb;
        /** Get playlist id and set playlist table, prefix */
        $this->_wpdb = $wpdb;
        $this->_playlisttable = $this->_wpdb->prefix . 'hdflvvideoshare_playlist';
        $this->_playListId = absint ( filter_input ( INPUT_GET, 'playlistId' ) );
      }
      /**
       * Function to insert new playlist
       * 
       * @param unknown $playlsitData
       * @return int
       */
      public function insert_playlist($playlsitData) {
        /** Insert new playlist data */
        if ($this->_wpdb->insert ( $this->_playlisttable, $playlsitData )) {
          /** If data is inserted return last inserted playlist id */
          return $this->_wpdb->insert_id;
        }
      }
      /**
       * Fucntion to update the playlist details
       * 
       * @param unknown $playlistData
       * @param unknown $playlistId
       */
      public function playlist_update($playlistData, $playlistId) {
        /** Update playlist data and Return upate value */
        return $this->_wpdb->update ( $this->_playlisttable, $playlistData, array ( 'pid' => $playlistId ) );
      }
      /**
       * Fucntion to change status via ajax request
       * 
       * @param unknown $playlistId
       * @param unknown $status
       */
      public function status_update($playlistId, $status) {
          /** Update playlist status and return value */
        return $this->_wpdb->update ( $this->_playlisttable, array ('is_publish' => $status ), array ('pid' => $playlistId) );
      }
      /**
       * Get all playlists for grid layout.
       * 
       * @param unknown $searchValue
       * @param unknown $searchBtn
       * @param unknown $order
       * @param unknown $orderDirection
       */
      public function get_playlsitdata($searchValue, $searchBtn, $order, $orderDirection) {
        /** Get pagenum and calculate limit */
        $pagenum = absint ( filter_input ( INPUT_GET, 'pagenum' ) );
        if (empty ( $pagenum )) {
          $pagenum = 1;
        }
        $limit = 20;
        $offset = ($pagenum - 1) * $limit;
        /** Make a query to fetch playlist data  */
        $query = 'SELECT * FROM ' . $this->_playlisttable;
        /** Check search action is done */
        if (isset ( $searchBtn )) {
            /** Set query based on search action */
          $query .= ' WHERE playlist_name LIKE %s OR playlist_desc LIKE %s';
        }
        /** Set order by values to fetch playlist */
        if (! isset ( $orderDirection )) {
          /** Order by in descending order */
          $query .= ' ORDER BY ' . $order . ' DESC';
        } else {
          /** Order by based on given order */
          $query .= ' ORDER BY ' . $order . ' ' . $orderDirection;
        }
        /** Set limit values to fetch playlist */
        $query .= ' LIMIT ' . $offset . ', ' . $limit;
        /** Check if search action is done and set query */
        if (isset ( $searchBtn )) {
          $query = $this->_wpdb->prepare ( $query, '%' . $searchValue . '%', '%' . $searchValue . '%' );
        } else {
          $query = $query;
        }
        /** Get playlist details and return */
        return $this->_wpdb->get_results ( $query );
      }
      /**
       * Fucntion to get single playlistsdetails
       * 
       * @param unknown $playlistId
       */
      public function playlist_edit($playlistId) {
        /** Return playlsit details to edit palylist data */
        return $this->_wpdb->get_row ( 'SELECT * FROM ' . $this->_playlisttable . ' WHERE pid =' . $playlistId );
      }
      /**
       * Fucntion to get total playlists for paginations
       * 
       * @param unknown $searchValue
       * @param unknown $searchBtn
       */
      public function playlist_count($searchValue, $searchBtn) {
        /** Set select query to get playlist count */
        $query = 'SELECT COUNT( `pid` ) FROM ' . $this->_playlisttable;
        /** Check if search action is done and set  query based on search*/
        if (isset ( $searchBtn )) {
          $query .= ' WHERE playlist_name LIKE %s OR playlist_desc LIKE %s';
        }
        /** If yes, Query to display search results in playlist page
         * Else display all playlist details */
        if (isset ( $searchBtn )) {
          return $this->_wpdb->get_var ( $this->_wpdb->prepare ( $query, '%' . $searchValue . '%', '%' . $searchValue . '%' ) );
        } else {
          return $this->_wpdb->get_var ( $query );
        }
      }
      /**
       * Function to delete playlists
       * 
       * @param unknown $playListId
       */
      public function playlist_delete($playListId) {
        /** Return value after delete action is done */
        return $this->_wpdb->query ( 'DELETE FROM ' . $this->_playlisttable . '  WHERE pid IN ( ' . $playListId . ' )');        
      }
      /**
       * Function to publish multiple category 
       * 
       * @param unknown $videoId          
       */
      public function playlist_multipublish($playListId) {
        /** Return update status after perform playlist update action */
        return $this->_wpdb->query ( 'UPDATE ' . $this->_playlisttable . ' SET `is_publish`=1 WHERE pid IN (' . $playListId . ')');
      }
      /**
       * Function to unpublish multiple category 
       * 
       * @param unknown $videoId          
       */
      public function playlist_multiunpublish($playListId) {
        /** Return valye for publish status update */
        return $this->_wpdb->query ( 'UPDATE ' . $this->_playlisttable . ' SET `is_publish`=0 WHERE pid IN (' . $playListId . ')' );
      }
    /** PlaylistModel class ends */
  }
  /** Checking playlist model class exist if ends */
}
?>