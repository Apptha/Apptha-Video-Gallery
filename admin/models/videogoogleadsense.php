<?php
/**  
 * Video videogoogleadsense model file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/**
 *  Checks the VideogoogleadsenseModel class has been defined if starts
 */
if ( !class_exists ( 'VideogoogleadsenseModel' ) ) {
  /**
   * VideogoogleadsenseModel class starts
   *
   * @author user
   */
    class VideogoogleadsenseModel {
        /**
         * VideogoogleadsenseModel constructor
         */
        public function __construct() {
            /**
             * Get google adsense id
             * Set prefix and adsense table name
             */
            global $wpdb;
            $this->_wpdb            = $wpdb;
            $this->_videoadtable    = $this->_wpdb->prefix . 'hdflvvideoshare_vgoogleadsense';
            $this->_videogoogleadId = absint ( filter_input ( INPUT_GET, 'videogoogleadsenseId' ) );
        }
        
        /**
         * Function to get all the google adsense detials.
         * 
         * @param unknown $searchValue
         * @param unknown $searchBtn
         * @param unknown $order
         * @param unknown $orderDirection
         */
        public function get_videogoogleadsenses($searchValue, $searchBtn, $order, $orderDirection) {
            /**
             * Get page num for google adsense and set limit
             */
            $pagenum      = absint ( filter_input ( INPUT_GET, 'pagenum' ) );
            if (empty ( $pagenum )) {
                $pagenum  = 1;
            }
            $limit        = 20;
            $offset       = ($pagenum - 1) * $limit;
            /**
             * Query to fetch google adsense details
             */
            $query        = "SELECT * FROM " . $this->_videoadtable;
            /**
             * If search action is done then set condition to fetch adsense data
             */
            if (isset ( $searchBtn )) {
              $query      .= ' WHERE googleadsense_details LIKE %s';
            }
            /**
             * Set order by values in adsense query
             */
            if (! isset ( $orderDirection )) {
              $query      .= ' ORDER BY ' . $order . ' DESC';
            } else {
              $query      .= ' ORDER BY ' . $order . ' ' . $orderDirection;
            }
            /**
             * Set limit values in adsense query
             */
            $query        .= ' LIMIT ' . $offset . ', ' . $limit;
            if (isset ( $searchBtn )) {
              $query      = $this->_wpdb->prepare ( $query, '%' . $searchValue . '%' );
            } else {
              $query      = $query;
            }
            /**
             * Return adsense data to display
             */
            return $this->_wpdb->get_results ( $query );
        }
        
        /**
         * Function to save googleadsense details
         * 
         * @param unknown $videogoogleadData
         */
        public function videogoogleadsense_insert($videogoogleadData) {
            /**
             * Insert adsense details
             */
            return $this->_wpdb->insert ( $this->_videoadtable, $videogoogleadData );
        }
        
        /**
         * Fucntion to update Google adsense details.
         * 
         * @param unknown $googleadsenseId
         * @param unknown $videoadData
         * @param unknown $videoadDataformat
         */
        public function videogoogleadsense_update($googleadsenseId, $videoadData, $videoadDataformat) {
            /**
             * Update Google adsense details.
             */
            return $this->_wpdb->update ( $this->_videoadtable, $videoadData, array ( 'id' => $googleadsenseId ), $videoadDataformat );
        }
        
        /**
         * Fucntion to edit google adsense details.
         */
        public function videogoogleadsense_edit($googleadsenseId) {
            /**
             * Get adsense details for the given adsense id
             */
            if (intval ( $googleadsenseId )) {
                return $this->_wpdb->get_row ( 'SELECT * FROM ' . $this->_videoadtable . ' WHERE id=' . $googleadsenseId );
            } else {
                return $this->_wpdb->get_row ( 'SELECT * FROM ' . $this->_videoadtable . ' WHERE id IN ' . $googleadsenseId );
            }
        }
        
        /**
         * Function to delete Google adsense
         * 
         * @param  $googlead_ids
         */
        public function videogooglead_delete($googlead_ids) {
            /** Delete google adsense detials */
            return $this->_wpdb->get_results ( "DELETE FROM " . $this->_videoadtable . " WHERE id IN($googlead_ids)" );
        }
        /**
         * Function to publish Google adsense
         *
         * @param  $googlead_ids
         */
        public function videogooglead_publish($googlead_ids) {
            /** Delete google adsense detials */
            $ids = explode ( ',', $googlead_ids );
            foreach ( $ids as $id ) {
              $find = '"publish";s:1:"0"';
              $replace = '"publish";s:1:"1"';
              $query = "update $this->_videoadtable set googleadsense_details = replace(googleadsense_details,'$find','$replace') where id = $id";
              $result = $this->_wpdb->get_results ( $query );
            }
            return $result;
        }
        /**
         * Function to unpublish Google adsense
         *
         * @param  $googlead_ids
         */
        public function videogooglead_unpublish($googlead_ids) {
          /**
           * Delete google adsense detials
           */
          $ids = explode ( ',', $googlead_ids );
          foreach ( $ids as $id ) {
            $find = '"publish";s:1:"1"';
            $replace = '"publish";s:1:"0"';
            $query = "update $this->_videoadtable set googleadsense_details = replace(googleadsense_details,'$find','$replace') where id = $id";
            $result = $this->_wpdb->get_results ( $query );
          }
          return $result;
        }
       
        
        /** Function to count all googleadsense */
        public function videogoogleadsensecount($searchBtn, $searchValue) {
            /** Query to count google adsense data */
            $query    = 'SELECT count(*) FROM ' . $this->_videoadtable;
            /** If search action is done then set condition for adsense  */
            if (isset ( $searchBtn )) {
              $query  .= ' WHERE googleadsense_details LIKE %s';
            }
            /** Making a search query to search google adsense details */
            if (isset ( $searchBtn )) {
              $query  = $this->_wpdb->prepare ( $query, '%' . $searchValue . '%' );
            } else {
              /** Else get all adsense count */
              $query  = $query;
            }
            return $this->_wpdb->get_var ( $query );
        }
        
        /**
         * Function to publishmultiple google adsense 
         * 
         * @param unknown $videogoogleadsenseId
         * @param unknown $videoadData
         */
        public function googlemultipublish($videogoogleadsenseId, $videoadData) {
            /**
             * Query to mulitple publish
             */
            return $this->_wpdb->update ( $this->_videoadtable, $videoadData, array ( 'id' => $videogoogleadsenseId ), $videoadDataformat );
        }
        
        /**
         * Function to unpublish multiple google adsense 
         * 
         * @param unknown $videoId          
         */
        public function googlemultiunpublish($videogoogleadsenseId, $videoadData) {
            /** Query to multiple unpublish  */
            return $this->_wpdb->update ( $this->_videoadtable, $videoadData, array ( 'id' => $videogoogleadsenseId ), $videoadDataformat );
        }
    /** VideogoogleadsenseModel class ends */
    }
/** Checks the VideogoogleadsenseModel class has been defined if starts */
}
?>