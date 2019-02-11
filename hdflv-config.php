<?php
/**
 * Name: Wordpress Video Gallery Plugin 
 * URI: http://www.apptha.com/category/extension/Wordpress/Video-Gallery 
 * Description: Wordpress Video Gallery plugin config file. 
 * Version: 2.9 
 * Author: Apptha 
 * Author URI: http://www.apptha.com 
 * License: GPL2
 */

/**
 * Bootstrap file for getting the ABSPATH constant to wp-load.php
 * This is requried when a plugin requires access not via the admin screen.
 * If the wp-load.php file is not found, then an error will be displayed
 * wp-content\plugins\contus-video-gallery\hdflv-config.php
 * Define the server path to the file wp-config here, if you placed WP-CONTENT outside the classic file structure
 */
$path = '';
/**
 * Check whether the default WordPress 
 * load path is defined 
 */
if (! defined ( 'WP_LOAD_PATH' )) {
    /**
     * Classic root path if wp-content and plugins is below wp-config.php
     * It should be end with a trailing slash
     */ 
    $classic_root = dirname ( dirname ( dirname ( dirname ( __FILE__ ) ) ) ) . '/';
    /**
     * Define wp-load.php file path
     * If it is not found then die with the message 
     */
    if (file_exists ( $classic_root . 'wp-load.php' )) {
      define ( 'WP_LOAD_PATH', $classic_root );
    } else {      
        if (file_exists ( $path . 'wp-load.php' )) {
            define ( 'WP_LOAD_PATH', $path );
        } else { 
            exitAction ( 'Could not find the file' );
        }
    }
}
/** Let's load WordPress */
require_once (WP_LOAD_PATH . 'wp-load.php');
?>