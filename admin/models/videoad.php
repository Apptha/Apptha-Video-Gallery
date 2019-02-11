<?php
/**  
 * Video videoad model file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/**
 * Checks the VideoadModel class has been defined if starts
 */
if (! class_exists ( 'VideoadModel' )) {
    /**
     * VideoadModel class starts
     * 
     * @author user
     */
    class VideoadModel { 
        /**
         * VideoadModel constructor
         */
        public function __construct() { 
          global $wpdb;
          /**
           * Set ads tbale and prefix
           * Get video ads id
           */
          $this->_wpdb          = $wpdb;
          $this->_videoadtable  = $this->_wpdb->prefix . 'hdflvvideoshare_vgads';
          $this->_videoadId     = absint ( filter_input ( INPUT_GET, 'videoadId' ) );
        }
        /**
         * Function for inserting video ad starts
         * 
         * @param unknown $videoadData
         * @param unknown $videoadDataformat
         */
        public function insert_videoad($videoadData, $videoadDataformat) { 
          /**
           * Insert video ads into database
           */
          if ($this->_wpdb->insert ( $this->_videoadtable, $videoadData, $videoadDataformat )) {
            return $this->_wpdb->insert_id;
          }
        } 
        /**
         * Function to update video ad 
         * 
         * @param unknown $videoadData
         * @param unknown $videoadDataformat
         * @param unknown $videoadId
         */
        public function videoad_update($videoadData, $videoadDataformat, $videoadId) { 
          /**
           * Update video ads into database
           */
          return $this->_wpdb->update ( $this->_videoadtable, $videoadData, array ( 'ads_id' => $videoadId  ), $videoadDataformat );
        } 
        /**
         * Function to update status of video ad 
         * 
         * @param unknown $videoadId
         * @param unknown $status
         */
        public function status_update($videoadId, $status) { 
          /**
           * Update video ads status into database
           */
          return $this->_wpdb->update ( $this->_videoadtable, array ( 'publish' => $status  ), array ( 'ads_id' => $videoadId  ) );
        } 
        /**
         * Function to get search video ad 
         * 
         * @param unknown $searchValue
         * @param unknown $searchBtn
         * @param unknown $order
         * @param unknown $orderDirection
         */
        public function get_videoaddata($searchVal, $searchBtn, $order, $orderDirection) { 
          /**
           * Get pagenumber and set limit  
           */
          $pagenum = filter_input ( INPUT_GET, 'pagenum' );
          if (empty ( $pagenum )) {
            $pagenum = 1;
          }
          $adLimit = 20;
          $offset = ($pagenum - 1) * $adLimit;
          /**
           * Query to fetch search video ads result
           */
          $sql = 'SELECT * FROM ' . $this->_videoadtable;
          
          if (isset ( $searchBtn )) {
            $sql .= ' WHERE title LIKE %s';
          }
          /**
           * Set oder by and limit values to get video ads
           */
          if (! isset ( $orderDirection )) {
            $sql .= ' ORDER BY ' . $order . ' DESC';
          } else {
            $sql .= ' ORDER BY ' . $order . ' ' . $orderDirection;
          }
          $sql .= ' LIMIT ' . $offset . ', ' . $adLimit;
          if (isset ( $searchBtn )) {
            $sql = $this->_wpdb->prepare ( $sql, '%' . $searchVal . '%' );
          } else {
            $sql = $sql;
          }
          return $this->_wpdb->get_results ( $sql );
          /**
           * Function for getting single video starts
           */
        } 
        /**
         * Function to get video ads count
         * 
         * @param unknown $searchValue
         * @param unknown $searchBtn
         */
        public function videoad_count($searchValue, $searchBtn) {
          /**
           * Query to get videos ad count
           */ 
          $query = 'SELECT COUNT( `ads_id` ) FROM ' . $this->_videoadtable;
          /**
           * Based on the title if serach action is done
           */
          if (isset ( $searchBtn )) {
            $query .= ' WHERE title LIKE %s';
          }
          if (isset ( $searchBtn )) {
            $query = $this->_wpdb->prepare ( $query, '%' . $searchValue . '%' );
          } else {
            /**
             * Else count all records
             */
            $query = $query;
          }
          return $this->_wpdb->get_var ( $query );
        }
        /**
         * Function to edit video ad details
         * 
         * @param unknown $videoadId
         */
        public function videoad_edit($videoadId) {
          /**
           * Query to edit particular video ad details
           */
          return $this->_wpdb->get_row ( 'SELECT * FROM ' . $this->_videoadtable . ' WHERE ads_id =' . $videoadId );
        } 
        /**
         * Function to delete video 
         * 
         * @param unknown $videoadId
         */
        public function videoad_delete($videoadId) { 
          /**
           * Query to delete particular video ad details
           */
          $query = 'DELETE FROM ' . $this->_videoadtable . '  WHERE ads_id IN ( ' . $videoadId . ' )';
          return $this->_wpdb->query ( $query );
        }
        /**
         * Function to publish multi video ads
         * 
         * @param unknown $videoadId
         */
        public function videoad_multipublish($videoadId) {
          /**
           * Query to publish multiple video ad details
           */
          $query = 'UPDATE ' . $this->_videoadtable . ' SET `publish`=1 WHERE ads_id IN (' . $videoadId . ')';
          return $this->_wpdb->query ( $query );
        }
        /**
         * Function to multiple unpublish video ads
         * 
         * @param unknown $videoId          
         */
        public function videoad_multiunpublish($videoadId) {
          /**
           * Query to publish multiple video ad details
           */
          $query = 'UPDATE ' . $this->_videoadtable . ' SET `publish`=0 WHERE ads_id IN (' . $videoadId . ')';
          return $this->_wpdb->query ( $query );
          /**
           * Function for deleting video ends
           */
        } 
    /**
     * VideoadModel class ends
     */
    }
/**
 * Checks the VideoadModel class has been defined if ends
 */ 
}
?>