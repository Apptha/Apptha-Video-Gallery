<?php
/**
 * video setting model file to update the  setting for  video gallery.
 *  
 * @category Apptha
 * @package Contus video Gallery 
 * @version 2.9 
 * @author Apptha Team <developers@contus.in> 
 * @copyright Copyright (C) 2014 Apptha. All rights reserved. 
 * @license GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
/**
 * Check SettingsModel class is exist starts
 */
if ( !class_exists ( 'SettingsModel' )) {
    /**
     * SettingsModel class starts
     *
     * @author user
     */
    class SettingsModel {
        /**
         * SettingsModel constructor
         */
        public function __construct() {
            /**
             * Set prefix and settings table
             */
            global $wpdb;
            $this->_wpdb          = $wpdb;
            $this->_settingstable = $this->_wpdb->prefix . 'hdflvvideoshare_settings';
        }
        
        /**
         * Function for store setting data into database
         *
         * @param type $settingsdata          
         * @param type $settingsdataformat          
         */
        public function update_settings( $settingsdata, $settingsdataformat ) {
            /**
             * Query to update settings data
             */
            return $this->_wpdb->update ( $this->_settingstable, $settingsdata, array ( 'settings_id' => 1 ), $settingsdataformat );
        }
    /**
     * SettingsModel class ends
     */
    }
/**
 * Check SettingsModel class is exist ends
 */
}
?>