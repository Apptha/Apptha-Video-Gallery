<?php
/**
  Name: Wordpress Video Gallery
  URI: http://www.apptha.com/category/extension/Wordpress/Video-Gallery
  Description: Wordpress Video Gallery Uninstall file.
  Version: 2.9
  Author: Apptha
  Author URI: http://www.apptha.com
  License: GPL2
 */

/**
 * Function to delete plugin , 
 * delate created table for install the plugin.
 */

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exitAction('');

//drop a custom db table
global $wpdb;
/** Delete content from post table */
/** Delete video home page content */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_content = "[videohome]"' );
/** Delete videomore page content  */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_content = "[videomore]"' );
/** Delete videogallery page content */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_content = "[videogallery]"' );
/** Delete main player page  */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_content = "[HDFLV_mainplayer]"' );
/** Delete old main page content */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_content = "[contusHome]"' );
/** Delete old more page content */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_content = "[contusMore]"' );
/** Delete old video page content */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_content = "[contusVideo]"' );
/** Delete old channel page content */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_content = "[videochannel]"' );
/** Delete old playlist page content */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_content = "[showplaylist]"' );
/** Delete old watch history page content */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_content = "[watch_history]"' );
/** Delete old watch later content */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_content = "[watch_later]"' );
/** Delete videogallery video posts */
$wpdb->query ( ' DELETE FROM ' . $wpdb->prefix . 'posts WHERE post_type = "videogallery"' );
/** Delete plugin tables */
/** Delete video table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare' );
/** Delete video ads table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_vgads' );
/** Delete video tags table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_tags' );
/** Delete plugin settings table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_settings' );
/** Delete playlist table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_playlist' );
/** Delete media table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_med2play' );
/** Delete google adsense table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_vgoogleadsense' );
/** Delete channel table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_channel' );
/** Delete chanel notification table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_channel_notification'  );
/** Delete channel subscribe table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_channel_subscribe' );
/** Delete playlist table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_user_playlist' );
/** Delete user playlist details table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_user_playlist_details' );
/** Delete watch history details table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_watch_history' );
/** Delete watch history user table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_watch_history_users' );
/** Delete watch later table */
$wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_watch_later' );
/**
 * Check if #__hdflvvideoshare_language is exists,
 * If exist then delete table
 */
$table_language   = $wpdb->prefix . 'hdflvvideoshare_language';  
foreach ( $wpdb->get_results ( 'SHOW TABLES;', ARRAY_N ) as $row ) {
  if ($row [0] == $table_language) {
    $lfound   = true;
  }
} 
if ($lfound) {
    /** Delete language table for old version plugin */
    $wpdb->query ( ' DROP TABLE ' . $wpdb->prefix . 'hdflvvideoshare_language' );
}
delete_option( 'video_gallery' );
?>