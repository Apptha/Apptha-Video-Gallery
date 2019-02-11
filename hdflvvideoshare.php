<?php
/**
 * Plugin Name: Wordpress Video Gallery
 * Plugin URI: http://www.apptha.com/category/extension/Wordpress/Video-Gallery
 * Description: Widely favored by lot of customers! The hugest advantage of deploying WordPress Video Gallery is it can help to integrate, display, and set up video gallery on any WordPress page and it works great with the existing themes as well. Also, it is powered with social sharing facility which helps users to share awesome videos via popular social channels. Powered by Apptha.
 * Version: 3.0
 * Author: Apptha
 * Author URI: http://www.apptha.com
 * License: GPL2
 */
/** Define plugin directory URL */ 
define ( 'APPTHA_VGALLERY_BASEURL', plugin_dir_url ( __FILE__ ) );
/** Define plugin directory path */
define ( 'APPTHA_VGALLERY_BASEDIR', dirname ( __FILE__ ) );
/** Include plugin helper files */
include_once (APPTHA_VGALLERY_BASEDIR . '/helper/query.php');
include_once (APPTHA_VGALLERY_BASEDIR . '/helper/pluginHelper.php');
include_once (APPTHA_VGALLERY_BASEDIR . '/helper/widgetHelper.php');
include_once (APPTHA_VGALLERY_BASEDIR . '/helper/pluginMetaHelper.php');
include_once (APPTHA_VGALLERY_BASEDIR . '/helper/pluginAdminHelper.php');
include_once (APPTHA_VGALLERY_BASEDIR . '/helper/watch_history.php');
//include_once (APPTHA_VGALLERY_BASEDIR . '/helper/traithelper.php');
/** Define directory separator Constants */
defineAction ( 'DS', '/' );
/** Define plugin name Constants */
defineAction ( 'APPTHAVGALLERY', 'Video Gallery' );
/** Define language Constants */
defineAction ( 'APPTHA_VGALLERY', 'video_gallery' );
/** Define post type Constants */
defineAction ( 'APPTHAVIDEOGALLERY', 'videogallery' );
/** Define user cancel upload Constants */
defineAction ( 'USERCANCELUPLOAD', __( 'User Cancelled the upload') );
/** Load language files */
load_theme_textdomain ( APPTHA_VGALLERY, APPTHA_VGALLERY_BASEDIR . '/languages' );
global $wpdb;
/** Define plugin table names and post table */
defineAction ( 'HDFLVVIDEOSHARE', $wpdb->prefix . 'hdflvvideoshare' );
defineAction ( 'WVG_PLAYLIST', $wpdb->prefix . 'hdflvvideoshare_playlist' );
defineAction ( 'WVG_MED2PLAY', $wpdb->prefix . 'hdflvvideoshare_med2play' );
defineAction ( 'WVG_SETTINGS', $wpdb->prefix . 'hdflvvideoshare_settings' );
defineAction ( 'WVG_VGADS', $wpdb->prefix . 'hdflvvideoshare_vgads' );
defineAction ( 'WVG_TAGS', $wpdb->prefix . 'hdflvvideoshare_tags' );
defineAction ( 'WVG_CHANNEL', $wpdb->prefix . 'hdflvvideoshare_channel' );
defineAction ( 'WVG_CHANNEL_NOTIFICATION', $wpdb->prefix . 'hdflvvideoshare_channel_notification' );
defineAction ( 'WVG_CHANNEL_SUBSCRIBER', $wpdb->prefix . 'hdflvvideoshare_channel_subscribe' );
defineAction ( 'WVG_USER_PLAYLIST', $wpdb->prefix . 'hdflvvideoshare_user_playlist' );
defineAction ( 'WVG_USER_PLAYLIST_DETAILS', $wpdb->prefix . 'hdflvvideoshare_user_playlist_details' );
defineAction ( 'WVG_WATCH_HISTORY_DETAILS', $wpdb->prefix . 'hdflvvideoshare_watch_history' );
defineAction ( 'WVG_WATCH_HISTORY_USERS', $wpdb->prefix . 'hdflvvideoshare_watch_history_users' );
defineAction ( 'WVG_WATCH_LATER', $wpdb->prefix . 'hdflvvideoshare_watch_later' );
defineAction ( 'WVG_POSTS', $wpdb->posts );
defineAction ( 'WVG_VGOOGLEADSENSE', $wpdb->prefix . 'hdflvvideoshare_vgoogleadsense' );
$charset_collate      = '';
/** Get default WordPress charset */
if ( $wpdb->has_cap( 'collation' ) ) {
  /** Set charset for plugin tables */
  if ( ! empty($wpdb->charset ) ) {
    $charset_collate .= "DEFAULT CHARACTER SET $wpdb->charset";
  }
  if ( ! empty($wpdb->collate ) ) {
    $charset_collate .= " COLLATE $wpdb->collate";
  }
}
/** Define charset constants */
defineAction ( 'WVG_CHARSET_COLLATE', $charset_collate);
/** Declare global variables */
global $adminControllerPath, $adminModelPath, $adminViewPath, $frontControllerPath, $frontModelPath, $frontViewPath, $videomoreControllerFile;
/** Set admin ajax path */
$adminAjaxpath        = APPTHA_VGALLERY_BASEDIR . '/admin/ajax/';
/** Set admin controllers path */
$adminControllerPath  = APPTHA_VGALLERY_BASEDIR . '/admin/controllers/';
/** Set admin models path */
$adminModelPath       = APPTHA_VGALLERY_BASEDIR . '/admin/models/';
/** Set admin views path */
$adminViewPath        = APPTHA_VGALLERY_BASEDIR . '/admin/views/';
/** Set front controllers path */
$frontControllerPath  = APPTHA_VGALLERY_BASEDIR . '/front/controllers/';
/** Set front models path */
$frontModelPath       = APPTHA_VGALLERY_BASEDIR . '/front/models/';
/** Set front views path */
$frontViewPath        = APPTHA_VGALLERY_BASEDIR . '/front/views/';
/** Set videomore controller file path */
$videomoreControllerFile = $frontControllerPath . 'videomoreController.php';
/** Get widget file path from template */
$widgetPath           = get_template_directory () . '/html/widgets';
/** Set plugin name into session for banner player */
$_SESSION ['stream_plugin'] = getPluginFolderName();
/** Include Contus Videos widget files= */
includeWidgetfiles ( 'ContusVideosWidget.php' );
/** Include Video Category widget file */
includeWidgetfiles ( 'ContusVideoCategory.php' );
/** Include Video Search widget file */
includeWidgetfiles ( 'ContusVideoSearch.php' );
/** If banner widget file is exist then include banner widget file */
if (file_exists ( $widgetPath . '/contusBannerSlideshow.php' )) {
    include_once ($widgetPath . '/contusBannerSlideshow.php');
}
/** Add ction to register video gallery Plugin */
add_action ( 'init', 'videogallery_register' );
/**
 * Fucntion to create videogallery custom post plugin
 */
function videogallery_register() {
	ob_start();
/** Set values to register videogallery plugin */
    $labels = array (
        'name' => _x ( 'Contus Video Gallery', 'post type general name' ),
        'singular_name' => _x ( 'Video Gallery Item', 'post type singular name' ), 'add_new' => _x ( 'Add New', 'portfolio item' ), 
        'add_new_item' => __ ( 'Add New Video Gallery Item' ), 'edit_item' => __ ( 'Edit Video Gallery Item' ), 
        'new_item' => __ ( 'New Video Gallery Item' ), 'view_item' => __ ( 'View Video Gallery Item' ), 
        'search_items' => __ ( 'Search Video Gallery' ), 'not_found' => __ ( 'Nothing found' ), 
        'not_found_in_trash' => __ ( 'Nothing found in Trash' ), 'parent_item_colon' => ''
      );
/** Set arguments to register plugin */
    $args = array (
        'labels' => $labels, 'public' => true, 'publicly_queryable'=> true, 'show_ui' => false, 'query_var' => true, 'menu_icon' => getImagesDirURL() .'apptha.png',
        'rewrite' => true, 'capability_type' => 'post', 'hierarchical' => false, 'menu_position' => null, 'supports' => array ( 'title', 'editor', 'thumbnail', 'comments' ) );
/** Register custom post type for videogallery plugin */
    register_post_type ( 'videogallery', $args );
}
/** Add action to init videogallery plugin rules */
add_action ( 'init', 'add_my_rule' );
/**
 * Fucntion to add permalink rules for plugin pages
 */
function add_my_rule() {  
    global $wp;
/** Get more page id  */
    $morepage_id = morePageID ();
/** Set more pages URL */
    $morepageURL = 'index.php?page_id=' . $morepage_id;
/** If more parameter is exist, then rewrite URL */
    $wp->add_query_var ( 'more' );
    add_rewrite_rule ( '(.*)_videos', $morepageURL . '&more=$matches[1]', 'top' );
/** If playlist_name parameter is exist, then rewrite URL for category page */
    $wp->add_query_var ( 'playlist_name' );
    add_rewrite_rule ( 'categoryvideos\/(.*)', $morepageURL . '&playlist_name=$matches[1]', 'top' );
/** If user_name parameter is exist, then rewrite URL for user page */
    $wp->add_query_var ( 'user_name' );
    add_rewrite_rule ( 'user\/(.*)', $morepageURL . '&user_name=$matches[1]', 'top' );
/** If video_search parameter is exist, then rewrite URL for video search results page */
    $wp->add_query_var ( 'video_search' );
    add_rewrite_rule ( 'search/(.*)', $morepageURL . '&video_search=$matches[1]', 'top' );
}
/** Add action to init admin js, css files */
add_action ( 'admin_init', 'videogallery_admin_init' );
/**
 * Hook to add javascript and css file for admin
 */
function videogallery_admin_init() {
    global $wpdb;
    $db_version = 3.0;
    $vgOptions = get_option( 'video_gallery' );
    if ( false === $vgOptions || ! isset( $vgOptions['db_version'] ) || $vgOptions['db_version'] < $db_version ) {
        if ( ! is_array( $vgOptions ) ) {
                $vgOptions = array();
        }
        /** Call function to create channel tables */
        createChannelTables();
        /** Call function to create playlist tables */
        playlistTables();
        /** Call function to create watch history tables */
        watchHistoryTables();
        /** Call function to create watch later tables */
        watchLaterTables();
        /** Create required page for channel,playlist,watch later,watch history **/
        createPostPages(); 
        $query = 'ALTER TABLE ' . HDFLVVIDEOSHARE . ' MODIFY google_adsense_value INT( 3 ) NULL';
        $wpdb->query( $query );

        $query = 'ALTER TABLE ' . HDFLVVIDEOSHARE . ' MODIFY google_adsense INT( 3 ) NULL';
        $wpdb->query( $query );

        $query = 'ALTER TABLE ' . HDFLVVIDEOSHARE . ' MODIFY midrollads INT( 11 ) NULL';
        $wpdb->query( $query );

        $query = 'ALTER TABLE ' . HDFLVVIDEOSHARE . ' MODIFY imaad INT( 11 ) NULL';
        $wpdb->query( $query );

        $query = 'ALTER TABLE ' . HDFLVVIDEOSHARE . ' MODIFY prerollads VARCHAR(25) NULL';
        $wpdb->query( $query );

        $query = 'ALTER TABLE ' . HDFLVVIDEOSHARE . ' MODIFY postrollads VARCHAR(25) NULL';
        $wpdb->query( $query );
        
        $query = 'ALTER TABLE ' . WVG_VGADS . ' MODIFY impressionurl TEXT NULL';
        $wpdb->query( $query );
        
        $query = 'ALTER TABLE ' . WVG_VGADS . ' MODIFY clickurl TEXT NULL';
        $wpdb->query( $query );
        
        $query = 'ALTER TABLE ' . WVG_VGADS . ' CHANGE `file_path` `file_path` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL';
        $wpdb->query( $query );
        
        $query = 'ALTER TABLE ' . WVG_VGADS . ' CHANGE `title` `title` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL';
        $wpdb->query( $query );
        
        $vgOptions['db_version'] = $db_version;
        update_option( 'video_gallery', $vgOptions );
    }
/** Include default WordPress jquery and sortable js files */
    wp_enqueue_script ( 'jquery' );
    wp_enqueue_script ( 'jquery-ui-sortable' );    
/** Include plugin admin js file */
    wp_register_script ( 'videogallery_jscss', plugins_url ( 'admin/js/admin.min.js', __FILE__ ) );
    wp_enqueue_script ( 'videogallery_jscss' );
/** Include plugin sortorder js file */
    wp_register_script ( 'videogallery_sortablejs', plugins_url ( 'admin/js/vg_sortorder.js', __FILE__ ) );
    wp_enqueue_script ( 'videogallery_sortablejs' );    
/** Include plugin admin settings css file */
    wp_register_style ( 'videogallery_css1', plugins_url ( 'admin/css/adminsettings.min.css', __FILE__ ) );
    wp_enqueue_style ( 'videogallery_css1' );
}
/** Hook to add javascript and css file for site */
add_action ( 'wp_enqueue_scripts', 'videogallery_cssjs' );
/**
 * Function to add css file for front end
 */
function videogallery_cssjs() {
	wp_enqueue_script ( 'jquery' );
/** Check whether rtl is used */
    if (is_rtl ()) {
/** Include rtl css file */
        wp_register_style ( 'videogallery_css', plugins_url ( '/css/style.min.css', __FILE__ ) );
        wp_register_style ( 'videogallery_css_r', plugins_url ( '/css/rtl.css', __FILE__ ) );
        wp_enqueue_style ( 'videogallery_css_r' );
    } else {
/** Otherwise include plugin css file */
        wp_register_style ( 'videogallery_css', plugins_url ( '/css/style.min.css', __FILE__ ) );
    }
    wp_enqueue_style ( 'videogallery_css' );
/** Include fontend js file */
    wp_register_script ( 'videogallery_js', plugins_url ( '/js/script.min.js', __FILE__ ) );
    wp_enqueue_script ( 'videogallery_js' );
}
/**
 * Function playlistScript is used to include playlist script
 * This function is used to include script file for playlist concept at the footer
 * This function has pluginUrl variable that contain plugin base url
 * playlist script file access plugin baseUrl by using this variable.
 * wp_footer hook is used to call playlistScript method
 * @return void
 */
function playlistScript() {
	/**
	 * pluginUrl variable has plugin baseUrl
	 */
	?>
	<script type="text/javascript">
    var pluginUrl = '<?php echo APPTHA_VGALLERY_BASEURL;?>';
	</script>
	<?php 
	wp_register_script ( 'playlist_js', plugins_url ( '/js/playlist.min.js', __FILE__ ) );
	wp_enqueue_script ( 'playlist_js' );
}
add_action( 'wp_footer', 'playlistScript' );
/**
 * Fucntion to include js, css file for video detail page
 */
function videogallery_jcar_js_css() {
    wp_enqueue_script ( 'jquery' );
/** Include js, css files for jcarousel slider */
    wp_register_script ( 'videogallery_jcar_js', APPTHA_VGALLERY_BASEURL . 'js/jquery.jcarousel.pack.js' );
    wp_enqueue_script ( 'videogallery_jcar_js' );
    wp_register_style ( 'videogallery_jcar_css', APPTHA_VGALLERY_BASEURL . 'css/jquery.jcarousel.css' );
    wp_enqueue_style ( 'videogallery_jcar_css' );
    wp_register_style ( 'videogallery_jcar_skin_css', APPTHA_VGALLERY_BASEURL . 'css/skins.min.css' );
    wp_enqueue_style ( 'videogallery_jcar_skin_css' );  
/** Jquery ui add for tooltip */
    wp_register_script ( 'videogallery_jquery-ui_js', APPTHA_VGALLERY_BASEURL . 'js/jquery-ui.js' );
    wp_enqueue_script ( 'videogallery_jquery-ui_js' );
    wp_register_style ( 'videogallery_jquery_ui_css', APPTHA_VGALLERY_BASEURL . 'css/jquery-ui.min.css' );
    wp_enqueue_style ( 'videogallery_jquery_ui_css' );
    wp_register_script ( 'videogallery_jcar_init_js', APPTHA_VGALLERY_BASEURL . 'js/mycarousel.js' );
    wp_enqueue_script ( 'videogallery_jcar_init_js' );
}
/** Function to add meta details and og details for facebook */
add_action ( 'wp_head', 'add_meta_details', 1 );
/** 
 *Function to pause or resume watch history 
 *@return void 
 */
add_action ( 'wp_ajax_changehistorystatus', 'change_history_status' );
add_action ( 'wp_ajax_changehistorystatus', 'change_history_status' );
function change_history_status() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	$status = (isset($_REQUEST['status']) && $_REQUEST['status'] !='') ? strip_tags($_REQUEST['status']) : '';
	if(!empty($status)) {
		include_once ($frontControllerPath . 'watchhistorycontroller.php');
		$controllerObj = new WatchHistoryController();
		$controllerObj->update_watch_history_status($watchUserId,$status);
	}
}
add_action ( 'wp_ajax_clearhistory', 'clear_history_status' );
add_action ( 'wp_ajax_nopriv_clearhistory', 'clear_history_status' );
/**
 * Function to clear watch history
 * @return void
 */
function clear_history_status() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	include_once ($frontControllerPath . 'watchhistorycontroller.php');
	$controllerObj = new WatchHistoryController();
	$controllerObj->clear_watch_history($watchUserId);
}
add_action ( 'wp_ajax_clearwatchlater', 'clear_watch_later' );
add_action ( 'wp_ajax_nopriv_clearwatchlater', 'clear_watch_later' );
/**
 * Function to clear watch later
 * This function is used to clear all watch later videos of current user
 * This function has watchUserId variable to hold current user id
 * This function include watchlatercontroller file to get delete functionality
 * This function has controllerObj variable to hold watchLaterController object
 * This function call clear_watch_later method to delete watch later videos
 * wp_ajax hook is used to call clear_watch_later
 * @return void
 */
function clear_watch_later() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	include_once ($frontControllerPath . 'watchlatercontroller.php');
	$controllerObj = new WatchLaterController();
	$controllerObj->clear_watch_later($watchUserId);
}
add_action ( 'wp_ajax_clearhistorybyid', 'clear_history_by_id' );
add_action ( 'wp_ajax_nopriv_clearhistorybyid', 'clear_history_by_id' );
/**
 * Function to delete a watch history video
 * This function is used to delete a watch history video of current user
 * This function has watchUserId to hold current user id
 * This function has videoId to hold video id to delete
 * This function include watchhistorycontroller file to get delete functionality
 * This function has controllerObj variable to hold WatchHistoryController object
 * This function call clear_watch_history_video method to delete a watch history videos
 * wp_ajax hook is used to call clear_history_by_id
 * @return void
 */
function clear_history_by_id() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	$videoId = (isset($_POST['vid']) && $_POST['vid'] != '') ? intval($_POST['vid']) : '';
	if(!empty($videoId) && is_user_logged_in()) {
		include_once ($frontControllerPath . 'watchhistorycontroller.php');
		$controllerObj = new WatchHistoryController();
		$controllerObj->clear_watch_history_video($watchUserId,$videoId);
	}
}
add_action ( 'wp_ajax_clearwatchlaterbyid', 'clear_watch_later_by_id' );
add_action ( 'wp_ajax_nopriv_clearwatchlaterbyid', 'clear_watch_later_by_id' );
/**
 * Function to delete a watch later video
 * This function is used to delete a watch later video of current user
 * This function has watchUserId to hold current user id
 * This function has videoId to hold video id to delete
 * This function include watchlatercontroller file to get delete functionality
 * This function has controllerObj variable to hold WatchLaterController object
 * This function call clear_watch_later_video method to delete a watch later videos
 * wp_ajax hook is used to call clear_watch_later_by_id
 * @return void 
 */
function clear_watch_later_by_id() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	$videoId = (isset($_POST['vid']) && $_POST['vid'] != '') ? intval($_POST['vid']) : '';
	if(!empty($videoId) && is_user_logged_in()) {
		include_once ($frontControllerPath . 'watchlatercontroller.php');
		$controllerObj = new WatchLaterController();
		$controllerObj->clear_watch_later_video($watchUserId,$videoId);
	}
}
add_action ( 'wp_ajax_watchlater', 'watchLater' );
add_action ( 'wp_ajax_nopriv_watchlater', 'watchLater' );
/**
 * Function to insert watch later videos
 * This function is used to store a watch later video of current user
 * This function has watchUserId to hold current user id
 * This function has videoId to hold video id to store
 * This function include watchlatercontroller file to get insert functionality
 * This function has controllerObj variable to hold WatchLaterController object
 * This function call store_watch_later_videos method to store a watch later videos
 * wp_ajax hook is used to call watchLater
 * @return void
 */
function watchLater() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	$videoId = (isset($_POST['vid']) && $_POST['vid'] != '') ? intval($_POST['vid']) : '';
	if(!empty($videoId) && is_user_logged_in()) {
		include_once ($frontControllerPath . 'watchlatercontroller.php');
		$controllerObj = new WatchLaterController();
		$controllerObj->store_watch_later_videos($watchUserId,$videoId);
	}
	else {
		$redirectURL = get_site_url().'/wp-login.php?redirect_to='.urlencode($_SERVER['HTTP_REFERER']);
		echo json_encode(array('redirectURL'=>$redirectURL));
		exitAction('');
	}
}
add_action ( 'wp_ajax_changewatchlaterstatus', 'changeWatchLaterStatus' );
add_action ( 'wp_ajax_nopriv_changewatchlaterstatus', 'changeWatchLaterStatus' );
/**
 * Function to change watch later video status
 * This function is used to store a watch later video status of current user
 * This function has watchUserId to hold current user id
 * This function has videoId to hold video id to change video status
 * This function include watchlatercontroller file
 * This function has controllerObj variable to hold WatchLaterController object
 * This function call watchLaterStatusController method to change a watch later videos status
 * wp_ajax hook is used to call changeWatchLaterStatus
 * @return void
 */
function changeWatchLaterStatus() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	$videoId = (isset($_POST['vid']) && $_POST['vid'] != '') ? intval($_POST['vid']) : '';
	if(!empty($videoId) && is_user_logged_in()) {
		include_once ($frontControllerPath . 'watchlatercontroller.php');
		$controllerObj = new WatchLaterController();
		$controllerObj->watchLaterStatusController($watchUserId,$videoId);
	}
}
add_action ( 'wp_ajax_getHistoryVideo', 'getWatchHistoryVideoByOffset' );
add_action ( 'wp_ajax_nopriv_getHistoryVideo', 'getWatchHistoryVideoByOffset' );
/**
 * Function to get watch history videos and bind it to existing videos
 * This function is used to load a set of watch history videos of current user
 * This function has watchUserId to hold current user id
 * This function has $startOffset to hold start offset
 * This function has $checkOffset to hold offset to check existing offset
 * This function include watchhistorycontroller file
 * This function has controllerObj variable to hold WatchHistoryController object
 * This function call getWatchHistoryVideoDetailsByOffset method to load a set of watch later history videos
 * wp_ajax hook is used to call getWatchHistoryVideoByOffset
 * @return void
 */
function getWatchHistoryVideoByOffset() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	$startOffset = (isset($_POST['startoffset']) && $_POST['startoffset'] != '') ? intval($_POST['startoffset']) : '';
	$checkOffset = (isset($_SESSION['watchoffset'])) ? intval($_SESSION['watchoffset']) : '';
	if(!empty($startOffset) && is_user_logged_in() && $startOffset == $checkOffset) {
		include_once ($frontControllerPath . 'watchhistorycontroller.php');
		$controllerObj = new WatchHistoryController();
		$controllerObj->getWatchHistoryVideoDetailsByOffset($watchUserId,$startOffset);
	}
	else {
		echo json_encode(array());
		exitAction('');
	}
}
add_action ( 'wp_ajax_getplaylistvideos', 'get_playlist_videos' );
add_action ( 'wp_ajax_nopriv_getplaylistvideos', 'get_playlist_videos' );
/**
 * Function to get playlist videos and bind it to existing videos
 * This function is used to get playlist videos of current user
 * This function has watchUserId to hold current user id
 * This function has $startOffset to hold start offset
 * This function has $playlistId to hold playlist id
 * This function include playlistcontroller file
 * This function has controllerObj variable to hold PlaylistController object
 * This function call getPlaylistVideosController method to get playlist videos of current user
 * wp_ajax hook is used to call get_playlist_videos
 * @return void
 */
function get_playlist_videos() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userId  = get_current_user_id();
	$startOffset = (isset($_POST['startoffset']) && $_POST['startoffset'] != '') ? intval($_POST['startoffset']) : '';
	$playlistId = (isset($_POST['pid']) && $_POST['pid'] != '') ? intval($_POST['pid']) : '';
	if(!empty($startOffset) && is_user_logged_in() && !empty($playlistId)) {
		include_once ($frontControllerPath . 'playlistcontroller.php');
		$controllerObj = new PlaylistController();
		$controllerObj->getPlaylistVideosController($userId,$startOffset,$playlistId);
	}
	else {
		echo json_encode(array());
		exitAction('');
	}
}
add_action ( 'wp_ajax_clearplaylistvideo', 'clear_playlist_video' );
add_action ( 'wp_ajax_nopriv_clearplaylistvideo', 'clear_playlist_video' );
/**
 * Function to clear a playlist video
 * This function is used to clear playlist video of current user
 * This function has watchUserId to hold current user id
 * This function has $videoId to hold video id
 * This function has $playlistId to hold playlist id
 * This function include playlistcontroller file
 * This function has controllerObj variable to hold PlaylistController object
 * This function call clearPlaylistVideoController method to get playlist videos of current user
 * wp_ajax hook is used to call clear_playlist_video
 * @return void
 */
function clear_playlist_video() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userId  = get_current_user_id();
	$videoId = (isset($_POST['vid']) && $_POST['vid'] != '') ? intval($_POST['vid']) : '';
	$playlistId = (isset($_POST['pid']) && $_POST['pid'] != '') ? intval($_POST['pid']) : '';
	if(!empty($videoId) && is_user_logged_in() && !empty($playlistId)) {
		include_once ($frontControllerPath . 'playlistcontroller.php');
		$controllerObj = new PlaylistController();
		$controllerObj->clearPlaylistVideoController($userId,$videoId,$playlistId);
	}
	else {
		echo json_encode(array());
		exitAction('');
	}
}
add_action ( 'wp_ajax_clearplaylist', 'clear_playlist' );
add_action ( 'wp_ajax_nopriv_clearplaylist', 'clear_playlist' );
/**
 * Function to clear playlist
 * This function is used to clear playlist of current user
 * This function has watchUserId to hold current user id
 * This function has $playlistId to hold playlist id
 * This function include playlistcontroller file
 * This function has controllerObj variable to hold PlaylistController object
 * This function call clearPlaylistController method to clear playlist of current user
 * wp_ajax hook is used to call clear_playlist
 * @return void
 */
function clear_playlist() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userId  = get_current_user_id();
	$playlistId = (isset($_POST['pid']) && $_POST['pid'] != '') ? intval($_POST['pid']) : '';
	if(is_user_logged_in() && !empty($playlistId)) {
		include_once ($frontControllerPath . 'playlistcontroller.php');
		$controllerObj = new PlaylistController();
		$controllerObj->clearPlaylistController($userId,$playlistId);
	}
	else {
		echo json_encode(array());
		exitAction('');
	}
}
add_action ( 'wp_ajax_clearplaylistvideos', 'clear_playlist_videos' );
add_action ( 'wp_ajax_nopriv_clearplaylistvideos', 'clear_playlist_videos' );
/**
 * Function to clear all videos of required playlist
 * This function is used to clear all videos of a playlist of current user
 * This function has watchUserId to hold current user id
 * This function has $playlistId to hold playlist id
 * This function include playlistcontroller file
 * This function has controllerObj variable to hold PlaylistController object
 * This function call clearPlaylistVideosController method to clear all videos of a playlist of current user
 * wp_ajax hook is used to call clear_playlist_videos
 * @return void
 */
function clear_playlist_videos() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userId  = get_current_user_id();
	$playlistId = (isset($_POST['pid']) && $_POST['pid'] != '') ? intval($_POST['pid']) : '';
	if(is_user_logged_in() && !empty($playlistId)) {
		include_once ($frontControllerPath . 'playlistcontroller.php');
		$controllerObj = new PlaylistController();
		$controllerObj->clearPlaylistVideosController($userId,$playlistId);
	}
	else {
		echo json_encode(array());
		exitAction('');
	}
}
add_action ( 'wp_ajax_updateplaylistname', 'update_playlist_name' );
add_action ( 'wp_ajax_nopriv_updateplaylistname', 'update_playlist_name' );
/**
 * Function to update playlist name
 * This function is used to update playlist name of current user
 * This function has watchUserId to hold current user id
 * This function has $playlistName to hold playlist name
 * This function has $existingName to hold existing playlist name to check
 * This function include playlistcontroller file
 * This function has controllerObj variable to hold PlaylistController object
 * This function call updatePlaylistNameController method to update playlist name of current user
 * wp_ajax hook is used to call update_playlist_name
 * @return void
 */
function update_playlist_name() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userId  = get_current_user_id();
	$playlistName = (isset($_POST['pname']) && $_POST['pname'] != '') ? strip_tags($_POST['pname']) : '';
	$existingName = (isset($_POST['ename']) && $_POST['ename'] != '') ? strip_tags($_POST['ename']) : '';
	if(is_user_logged_in() && !empty($playlistName)) {
		include_once ($frontControllerPath . 'playlistcontroller.php');
		$controllerObj = new PlaylistController();
		$controllerObj->updatePlaylistNameController($userId,$playlistName,$existingName);
	}
	else {
		echo json_encode(array());
		exitAction('');
	}
}
add_action ( 'wp_ajax_getplaylistbyoffset', 'get_playlist_by_offset' );
add_action ( 'wp_ajax_nopriv_getplaylistbyoffset', 'get_playlist_by_offset' );
/**
 * Function to get playlist and bind it to existing playlist
 * This function is used to load a set of playlist of current user
 * This function has watchUserId to hold current user id
 * This function has startOffset to hold start offset
 * This function include playlistcontroller file
 * This function has controllerObj variable to hold PlaylistController object
 * This function call getPlaylistbyOffsetController method to load a set of playlist of current user
 * wp_ajax hook is used to call get_playlist_by_offset
 * @return void
 */
function get_playlist_by_offset() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userId  = get_current_user_id();
	$startOffset = (isset($_POST['startOffset']) && $_POST['startOffset'] != '') ? intval($_POST['startOffset']) : '';
	if(!empty($startOffset) && is_user_logged_in()) {
		include_once ($frontControllerPath . 'playlistcontroller.php');
		$controllerObj = new PlaylistController();
		$controllerObj->getPlaylistbyOffsetController($userId,$startOffset);
	}
	else {
		echo json_encode(array());
		exitAction('');
	}
}
add_action ( 'wp_ajax_getwatchlatervideo', 'getWatchLaterVideoByOffset' );
add_action ( 'wp_ajax_nopriv_getwatchlatervideo', 'getWatchLaterVideoByOffset' );
/**
 * Function to get watch later videos and bind it to existing videos
 * This function is used to load a set of watch later videos of current user
 * This function has watchUserId to hold current user id
 * This function has $startOffset to hold start offset
 * This function has $checkOffset to hold offset to check existing offset
 * This function include watchlatercontroller file
 * This function has controllerObj variable to hold WatchLaterController object
 * This function call getWatchLaterVideoDetailsByOffset method to load a set of watch later history videos
 * wp_ajax hook is used to call getWatchLaterVideoByOffset
 * @return void
 */
function getWatchLaterVideoByOffset() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	$startOffset = (isset($_POST['startoffset']) && $_POST['startoffset'] != '') ? intval($_POST['startoffset']) : '';
	$checkOffset = (isset($_SESSION['watchoffset'])) ? intval($_SESSION['watchoffset']) : '';
	if(!empty($startOffset) && is_user_logged_in() && $startOffset == $checkOffset) {
		include_once ($frontControllerPath . 'watchlatercontroller.php');
		$controllerObj = new WatchLaterController();
		$controllerObj->getWatchLaterVideoDetailsByOffset($watchUserId,$startOffset);
	}
	else {
		echo json_encode(array());
		exitAction('');
	}
}
add_action ( 'wp_ajax_getplaylist', 'getCurrentUserPlaylist' );
add_action ( 'wp_ajax_nopriv_getplaylist', 'getCurrentUserPlaylist' );
/**
 * Function to get current user playlist
 * This function is used to load videos of playlist
 * This function has watchUserId to hold current user id
 * This function has videoId to hold video id
 * This function include playlistcontroller file
 * This function has controllerObj variable to hold PlaylistController object
 * This function call currentUserPlaylistController method to load videos of playlist
 * wp_ajax hook is used to call getCurrentUserPlaylist
 * @return void
*/
function getCurrentUserPlaylist() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	$videoId = (isset($_POST['vid']) && $_POST['vid'] != '') ? intval($_POST['vid']) : '';
	if(!empty($videoId) && is_user_logged_in()) {
		include_once ($frontControllerPath . 'playlistcontroller.php');
		$controllerObj = new PlaylistController();
		$controllerObj->currentUserPlaylistController($watchUserId,$videoId);
	}
	else {
		$redirectURL = get_site_url().'/wp-login.php?redirect_to='.urlencode($_SERVER['HTTP_REFERER']);
		echo json_encode(array('redirectURL'=>$redirectURL));
		exitAction ( '' );
	}
}
add_action ( 'wp_ajax_storeplaylist', 'storePlaylist' );
add_action ( 'wp_ajax_nopriv_storeplaylist', 'storePlaylist' );
/**
 * Function to store playlist
 * This function is used to store playlist
 * This function has watchUserId to hold current user id
 * This function has videoId to hold video id
 * This function has playlistName to hold playlist name
 * This function include playlistcontroller file
 * This function has controllerObj variable to hold PlaylistController object
 * This function call storePlaylistController method to load videos of playlist
 * wp_ajax hook is used to call storePlaylist
 * @return void
 */
function storePlaylist() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	$videoId = (isset($_POST['vid']) && $_POST['vid'] != '') ? intval($_POST['vid']) : '';
	$playlistName = (isset($_POST['pname']) && $_POST['pname'] != '') ? strip_tags($_POST['pname']) : '';
	if(!empty($videoId) && is_user_logged_in()) {
		include_once ($frontControllerPath . 'playlistcontroller.php');
		$controllerObj = new PlaylistController();
		$controllerObj->storePlaylistController($watchUserId,$videoId,$playlistName);
	}
}
add_action ( 'wp_ajax_insertplaylistvideo', 'insertPlaylistVideo' );
add_action ( 'wp_ajax_nopriv_insertplaylistvideo', 'insertPlaylistVideo' );
/**
 * Function to insert playlist
 * This function is used to insert playlist of current user
 * This function has watchUserId to hold current user id
 * This function has videoId to hold video id
 * This function has playlistName to hold playlist name
 * This function include playlistcontroller file
 * This function has controllerObj variable to hold PlaylistController object
 * This function call insertPlaylistVideoController method to load videos of playlist
 * wp_ajax hook is used to call insertPlaylistVideo
 * @return void
*/
function insertPlaylistVideo() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	$videoId = (isset($_POST['vid']) && $_POST['vid'] != '') ? intval($_POST['vid']) : '';
	$playlistId = (isset($_POST['pid']) && $_POST['pid'] != '') ? intval($_POST['pid']) : '';
	if(!empty($videoId) && is_user_logged_in()) {
		include_once ($frontControllerPath . 'playlistcontroller.php');
		$controllerObj = new PlaylistController();
		$controllerObj->insertPlaylistVideoController($watchUserId,$videoId,$playlistId);
	}
}
add_action ( 'wp_ajax_removeplaylist', 'removePlaylist' );
add_action ( 'wp_ajax_nopriv_removeplaylist', 'removePlaylist' );
/**
 * Function to remove playlist
 * This function is used to remove playlist of current user
 * This function has watchUserId to hold current user id
 * This function has videoId to hold video id
 * This function has playlistId to hold playlist id
 * This function include playlistcontroller file
 * This function has controllerObj variable to hold PlaylistController object
 * This function call removePlaylistController method to load videos of playlist
 * wp_ajax hook is used to call removePlaylist
 * @return void
*/
function removePlaylist() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$watchUserId  = get_current_user_id();
	$videoId = (isset($_POST['vid']) && $_POST['vid'] != '') ? intval($_POST['vid']) : '';
	$playlistId = (isset($_POST['pid']) && $_POST['pid'] != '') ? strip_tags($_POST['pid']) : '';
	if(!empty($videoId) && is_user_logged_in()) {
		include_once ($frontControllerPath . 'playlistcontroller.php');
		$controllerObj = new PlaylistController();
		$controllerObj->removePlaylistController($watchUserId,$videoId,$playlistId);
	}
}
/**
 * Function getChannelUserID is used to get current user id or subscriber user id
 * This function is used to return channel user id(current user/subscriber user)
 * This function has refererURL to hold url 
 * This function has subscriberKey to hold subscriber key
 * This function has userID to hold user id
 * wp-ajax hook is used to call this function
 * @return int
 */
function getChannelUserID() {
	global $wpdb;
	$refererURL = (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !='') ? $_SERVER['HTTP_REFERER'] : '';
	if(strpos($refererURL,'ukey=') !== false ) {
		$subscriberKey = substr($refererURL,strrpos($refererURL,'=') + 1);
		$subscriber = true;
	}
	else {
		$subscriber = false;
	}
	if($subscriber == true ) {
		$userID = $wpdb->get_var($wpdb->prepare('SELECT user_id FROM '.WVG_CHANNEL.' WHERE user_key=%s',$subscriberKey));
	}
	else {
		$userID  = get_current_user_id();
	}
	return $userID;
}
add_action ( 'wp_ajax_channelimageupload', 'channel_image_upload' );
add_action ( 'wp_ajax_nopriv_channelimageupload', 'channel_image_upload' );
/**
 * Function to upload channel cover and profile images
 * This function is used to upload profile/cover images of current user
 * This function has userID to hold current user id
 * This function include channelcontroller file
 * This function has controllerObj variable to hold ChannelController object
 * This function call imageUploadController method to upload profile/cover images of current user
 * wp_ajax hook is used to call channel_image_upload
 * @return void
*/
function channel_image_upload() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
    $userID = getChannelUserID();
	if(is_user_logged_in()) {
		include_once ($frontControllerPath . 'channelcontroller.php');
		$controllerObj = new ChannelController();
		$controllerObj->imageUploadController($userID);
	}
}
add_action ( 'wp_ajax_croppingcoverimage', 'cropping_cover_image' );
add_action ( 'wp_ajax_nopriv_croppingcoverimage', 'cropping_cover_image' );
/**
 * Function to crop profile and cover images
 * This function is used to crop profile/cover images of current user
 * This function has userID to hold current user id
 * This function include channelcontroller file
 * This function has controllerObj variable to hold ChannelController object
 * This function call croppingCoverImageController method to crop profile/cover images of current user
 * wp_ajax hook is used to call cropping_cover_image
 * @return void
 */
function cropping_cover_image() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userID = getChannelUserID();
	if(is_user_logged_in()) {
		include_once ($frontControllerPath . 'channelcontroller.php');
		$controllerObj = new ChannelController();
		$controllerObj->croppingCoverImageController($userID);
	}
}
add_action ( 'wp_ajax_channeldescription', 'channel_description' );
add_action ( 'wp_ajax_nopriv_channeldescription', 'channel_description' );
/**
 * Function to store channel description and channel name
 * This function is used to update channel user name and description
 * This function has userID to hold current user id
 * This function has userName to hold channel name
 * This function has description to hold channel description
 * This function include channelcontroller file
 * This function has controllerObj variable to hold ChannelController object
 * This function call channelDescriptionController method to update channel user name and description
 * wp_ajax hook is used to call channel_description
 * @return void
 */
function channel_description() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$description = strip_tags((isset($_POST['channelDescription']) && $_POST['channelDescription'] !='') ? $_POST['channelDescription'] : '');
	$userName =trim(strip_tags((isset($_POST['userName']) && $_POST['userName'] !='') ? $_POST['userName'] : ''));
	$userID = getChannelUserID();
	if(is_user_logged_in()) {
		include_once ($frontControllerPath . 'channelcontroller.php');
		$controllerObj = new ChannelController();
		$controllerObj->channelDescriptionController($userID,$description,$userName);
	}
}
add_action ( 'wp_ajax_subscriberdetails', 'subscriber_details' );
add_action ( 'wp_ajax_nopriv_subscriberdetails', 'subscriber_details' );
/**
 * Function to get all subscriber details
 * This function is used to get subscriber details
 * This function include channelcontroller file
 * This function has controllerObj variable to hold ChannelController object
 * This function call subscriberDetails method to get subscriber details
 * wp_ajax hook is used to call subscriber_details
 * @return void
 */
function subscriber_details() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	if(is_user_logged_in()) {
		include_once ($frontControllerPath . 'channelcontroller.php');
		$controllerObj = new ChannelController();
		$controllerObj->subscriberDetails();
	}
}
add_action ( 'wp_ajax_savesubscriber', 'save_subscriber' );
add_action ( 'wp_ajax_nopriv_savesubscriber', 'save_subscriber' );
/**
 * Function to store subscriber details
 * This function is used to save subscriber details
 * This function has userID to hold user id
 * This function include channelcontroller file
 * This function has controllerObj variable to hold ChannelController object
 * This function call saveSubscriber method to save subscriber details
 * wp_ajax hook is used to call save_subscriber
 * @return void
 */
function save_subscriber() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userID = getChannelUserID();
	if(is_user_logged_in()) {
		include_once ($frontControllerPath . 'channelcontroller.php');
		$controllerObj = new ChannelController();
		$controllerObj->saveSubscriber($userID);
	}
}
add_action ( 'wp_ajax_mysubscriberdetails', 'mysubscriber_details' );
add_action ( 'wp_ajax_nopriv_mysubscriberdetails', 'mysubscriber_details' );
/**
 * Function to get my subscriber details
 * This function is used to get my subscriber details
 * This function has userID to hold user id
 * This function include channelcontroller file
 * This function has controllerObj variable to hold ChannelController object
 * This function call mySubscriberDetails method to get my subscriber details
 * wp_ajax hook is used to call mysubscriber_details
 * @return void
 */
function mysubscriber_details() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userID = getChannelUserID();
	if(is_user_logged_in()) {
		include_once ($frontControllerPath . 'channelcontroller.php');
		$controllerObj = new ChannelController();
		$controllerObj->mySubscriberDetails($userID);
	}
}
add_action ( 'wp_ajax_deletenotification', 'delete_notification' );
add_action ( 'wp_ajax_nopriv_deletenotification', 'delete_notification' );
/**
 * Function to delete user notification details
 * This function is used to delete subscriber notification
 * This function has userID to hold user id
 * This function include channelcontroller file
 * This function has controllerObj variable to hold ChannelController object
 * This function call deleteNotification method to delete subscriber notification
 * wp_ajax hook is used to call delete_notification
 * @return void
 */
function delete_notification() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userID = getChannelUserID();
	if(is_user_logged_in()) {
		include_once ($frontControllerPath . 'channelcontroller.php');
		$controllerObj = new ChannelController();
		$controllerObj->deleteNotification($userID);
	}
}
add_action ( 'wp_ajax_mychannelvideos', 'my_channel_videos' );
add_action ( 'wp_ajax_nopriv_mychannelvideos', 'my_channel_videos' );
/**
 * Function to get subscriber channel videos
 * This function is used to get user videos details
 * This function has userID to hold user id
 * This function include channelcontroller file
 * This function has controllerObj variable to hold ChannelController object
 * This function call channelMyVideos method to get user videos details
 * wp_ajax hook is used to call my_channel_videos
 * @return void
 */
function my_channel_videos() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userID = getChannelUserID();
	if(is_user_logged_in() && !empty($userID)) {
		include_once ($frontControllerPath . 'channelcontroller.php');
		$controllerObj = new ChannelController();
		$controllerObj->channelMyVideos($userID);
	}
}
add_action ( 'wp_ajax_closesubscribe', 'close_subscribe' );
add_action ( 'wp_ajax_nopriv_closesubscribe', 'close_subscribe' );
/**
 * Function to delete a subscriber details
 * This function is used to delete subscriber details
 * This function has userID to hold user id
 * This function include channelcontroller file
 * This function has controllerObj variable to hold ChannelController object
 * This function call closeSubscribe method to delete subscriber details
 * wp_ajax hook is used to call close_subscribe
 * @return void
 */
function close_subscribe() {
	global $frontControllerPath,$frontModelPath,$frontViewPath;
	$userID = getChannelUserID();
	if(is_user_logged_in()) {
		include_once ($frontControllerPath . 'channelcontroller.php');
		$controllerObj = new ChannelController();
		$controllerObj->closeSubscribe($userID);
	}
}
/** Player XML Action Starts Here 
 * Function to include config XML */
add_action ( 'wp_ajax_configXML', 'configxml_function' );
add_action ( 'wp_ajax_nopriv_configXML', 'configxml_function' );
function configxml_function() {
    require_once (dirname ( __FILE__ ) . '/configXML.php');
    exitAction ( '' );
}
/** Function to include MyextractXML */
add_action ( 'wp_ajax_myextractXML', 'myextractxml_function' );
add_action ( 'wp_ajax_nopriv_myextractXML', 'myextractxml_function' );
function myextractxml_function() {
    require_once (dirname ( __FILE__ ) . '/myextractXML.php');
    exitAction ( '' );
}
/** Fucntion to get google adsense settings for the corresponding video */
add_action ( 'wp_ajax_googleadsense', 'googleadsense_function' );
add_action ( 'wp_ajax_nopriv_googleadsense', 'googleadsense_function' );
function googleadsense_function() {
    global $wpdb;
    /** Get video id param for google adsense */
    $vid                = intval($_GET ['vid']);
    /** Select google adsense value for the given video id */ 
    $google_adsense_id  = $wpdb->get_var ( 'SELECT google_adsense_value FROM ' . HDFLVVIDEOSHARE . ' WHERE vid =' . $vid );
    /** Fetch google adsense value for the selected adsense id */
    $query              = $wpdb->get_var ( 'SELECT googleadsense_details FROM ' . WVG_VGOOGLEADSENSE . ' WHERE id= ' . $google_adsense_id );
    /** Unserialize google adsense data */
    $google_adsense     = unserialize ( $query );
    /** Sent ajax response and die */
    echo $google_adsense ['googleadsense_code'];
    exitAction ( '' );
}
/** Function to include MyadsXML */
add_action ( 'wp_ajax_myadsXML', 'myadsxml_function' );
add_action ( 'wp_ajax_nopriv_myadsXML', 'myadsxml_function' );
function myadsxml_function() {
    require_once (dirname ( __FILE__ ) . '/myadsXML.php');
    exitAction ( '' );
}
/** Function to include MymidrollXML */
add_action ( 'wp_ajax_mymidrollXML', 'mymidrollxml_function' );
add_action ( 'wp_ajax_nopriv_mymidrollXML', 'mymidrollxml_function' );
function mymidrollxml_function() {
    require_once (dirname ( __FILE__ ) . '/mymidrollXML.php');
    exitAction ( '' );
}
/** Function to include MyimaadsXML  */
add_action ( 'wp_ajax_myimaadsXML', 'myimaadsxml_function' );
add_action ( 'wp_ajax_nopriv_myimaadsXML', 'myimaadsxml_function' );
function myimaadsxml_function() {
    require_once (dirname ( __FILE__ ) . '/myimaadsXML.php');
    exitAction ( '' );
}
/** Function to include LanguageXML */
add_action ( 'wp_ajax_languageXML', 'languagexml_function' );
add_action ( 'wp_ajax_nopriv_languageXML', 'languagexml_function' );
function languagexml_function() {
    require_once (dirname ( __FILE__ ) . '/languageXML.php');
    exitAction ( '' );
}
/** Function to include Email */
add_action ( 'wp_ajax_email', 'email_function' );
add_action ( 'wp_ajax_nopriv_email', 'email_function' );
function email_function() {
    require_once (dirname ( __FILE__ ) . '/email.php');
    exitAction ( '' );
}
/** Function to increase Impression/Click count for ads */
add_action ( 'wp_ajax_impressionclicks', 'impressionclicks_function' );
add_action ( 'wp_ajax_nopriv_impressionclicks', 'impressionclicks_function' );
function impressionclicks_function() {
    global $wpdb;
    /** Get click parameter */
    $click  = $_GET ['click'];
    /** Get video id param to increase click /impression count */ 
    $vid    = intval($_GET ['id']);
    /** Check parameter is click or impression */
    if ($click != 'impression') {
      /** Get click count from db */
      $clickurl   = $wpdb->get_var ( 'SELECT clickurl FROM ' . WVG_VGADS . ' WHERE ads_id="' . intval ( $vid ) . '"' );
      /** Increase click count and update into db */
      $clickurl   = $clickurl + 1;
      $wpdb->update ( WVG_VGADS , array ( 'clickurl' => $clickurl ), array ( 'ads_id'   => intval ( $vid ) ) );
    } else {
      /** Get impression count from db */
      $impressionurl = $wpdb->get_var ( 'SELECT impressionurl FROM ' . WVG_VGADS . ' WHERE ads_id="' . intval ( $vid ) . '"' );
      /** Increase impression count and update into db */
      $impressionurl = $impressionurl + 1; 
      $wpdb->update ( WVG_VGADS , array ( 'impressionurl' => $impressionurl ), array ( 'ads_id'        => intval ( $vid ) ) );
    }
    exitAction ( '' );
}
/** Player XML Action Ends Here
 * Admin action Starts Here
 * 
 * Code for Ajax Playlist in Add video Page
 */
if (isset ( $_GET ['page'] ) && $_GET ['page'] == 'ajaxplaylist') {
    ob_start ();
    ob_clean ();
    /** Include ajaxcontroller file */
    global $adminControllerPath, $adminModelPath, $adminViewPath;
    include_once ($adminControllerPath . 'ajaxplaylistController.php');
    exitAction ( '' );
}
/** Function to include video upload file */
add_action ( 'wp_ajax_uploadvideo', 'video_files_uploads' );
add_action ( 'wp_ajax_nopriv_uploadvideo', 'video_files_uploads' );
function video_files_uploads() {
  global $adminAjaxpath;
  require_once ($adminAjaxpath . 'videoupload.php');
}
function isNumber($array_element) {
  return is_numeric($array_element);
}
/** Fucntion to perform Video / Playlist Sorting */
add_action ( 'wp_ajax_vg_sortorder', 'sortorder_function' );
function sortorder_function() {
   /** Varaibale initialization for sortorder action */
   if(!current_user_can('manage_options')) {
     return;
   } 
    global $wpdb;
    $listitemArray = array ();
    /** Get sorting list */
    $listitem         = $_POST ['listItem']; 
    $listitemArray    = array_filter($listitem, 'isNumber');
    if(!empty ($listitemArray)) { 
      /** Implode list item array into string */
      $ids      = implode ( ',', $listitemArray );
      /** Get page num and type */
      $pageNum  = intval($_GET ['pagenum']);
      $type     = intval($_GET ['type']);
      /** Check type is video or playlist */
      switch( $type ) {
          case 1:
            /** Update video ordering in database tables */
            $sql        = 'UPDATE `' . HDFLVVIDEOSHARE . '` SET `ordering` = CASE vid ';
            $endQuery   = ' END WHERE vid IN ( ' . $ids . ' )';
            break;
          case 2:
            /** Update playlist ordering in database tables */
            $sql        = 'UPDATE `' . WVG_PLAYLIST . '` SET `playlist_order` = CASE pid ';
            $endQuery   = ' END WHERE pid IN ( ' . $ids . ' )';
            break;
          default:
            break;
      }
      /** Calculate page values */
      if (!empty ( $pageNum )) {
        $page   = (20 * ( $pageNum - 1));
      }
      foreach ( $listitem as $key => $value ) {
        $listitems [$key + $page] = $value;
      }
      foreach ( $listitems as $position => $item ) {
        $sql    .= sprintf ( 'WHEN %d THEN %d ', $item, $position );
      }    
      $sql      .= $endQuery;
      $wpdb->query ( $sql );
    }
    exitAction ( '' );
}
/** Admin action Ends Here
 * 
 * Video Search Starts Here  */
$video_search = filter_input ( INPUT_GET, 'video_search' );
/** Get parmalink URL */
$wp_rewrite   = new WP_Rewrite ();
$link         = $wp_rewrite->get_page_permastruct ();
/** Check video search is exist */
if (! empty ( $video_search ) && ! empty ( $link )) {
  /** Convert non-sef URL to seo friendly URL for video serach */
  $location = home_url () . '/search/' . urlencode ( $video_search );
  /** Redirect to the search url */
  header ( "Location: $location", true, 301 );
  exitAction ( '' );
}
/** Video Search Ends Here 
 * 
 * Video Detail Page action Starts Here 
 * Fucntion to include rss file */
add_action ( 'wp_ajax_rss', 'rss_function' );
add_action ( 'wp_ajax_nopriv_rss', 'rss_function' );
function rss_function() {
  require_once (dirname ( __FILE__ ) . '/videogalleryrss.php');
  exitAction ( '' );
}
/** Fucntion to increase Video Hit count */
add_action ( 'wp_ajax_videohitcount', 'videohitcount_function' );
add_action ( 'wp_ajax_nopriv_videohitcount', 'videohitcount_function' );
function videohitcount_function() {
    /** Get video id from parameter for views count */
    $videoID         = intval($_GET ['vid']);
    watchedVideoHitCount($videoID,true);
}
/**
 * Function watchedVideoHitCount is used to increase video once user watched video
 * This function also used to add watched video to watch history table
 *  
 * @param  int      $videoID  video id
 * @param  boolean  $ajaxCall true/false
 * @return void
 */
function watchedVideoHitCount($videoID,$ajaxCall) {
	global $wpdb;
	/** Get hit count from database for given video id */
	$hitList     = $wpdb->get_row ( 'SELECT * FROM ' . HDFLVVIDEOSHARE . ' WHERE vid = "' . intval ( $videoID ) . '"' );
	/** Increase hit count and update into database */
	$hitInc      = $hitList->hitcount + 1;
	$wpdb->update ( HDFLVVIDEOSHARE, array ( 'hitcount' => intval ( $hitInc ) ), array ( 'vid'      => intval ( $videoID ) ) );
	$userID = get_current_user_id();
	if(is_user_logged_in()) {
		check_watch_history($userID,$videoID);
	}
	if($ajaxCall == true ) {
		exitAction ( '' );
	}
}
/** Function to calculate video rating count  */
add_action ( 'wp_ajax_ratecount', 'ratecount_function' );
add_action ( 'wp_ajax_nopriv_ratecount', 'ratecount_function' );
function ratecount_function() {
    global $wpdb;
    /** Get video id for rating */
    $vid      = intval($_GET ['vid']);
    /** Get rate parameter */
    $get_rate = intval($_GET ['rate']);
    /** Check whether the rate is not empty */
    if (! empty ( $get_rate )) {    
      /** Get video detials for the given video id */
      $ratecount  = $wpdb->get_row ( 'SELECT * FROM ' . HDFLVVIDEOSHARE . ' WHERE vid="' . intval ( $vid ) . '"' );
      /** Update rate value and rate count for the given video is */
      $wpdb->update ( HDFLVVIDEOSHARE , array ( 'rate'      => (intval ( $get_rate ) + $ratecount->rate), 'ratecount' => (1 + $ratecount->ratecount) ), 
                      array ('vid'       => intval ( $vid )) );
      /** Increase rate count and sent in ajax response */
      $rating     = $ratecount->ratecount + 1;
      echo $rating;
      exitAction ( '' );
    }
}
/** Send reportvideo function */
add_action ( 'wp_ajax_reportvideo', 'send_report' );
add_action ( 'wp_ajax_nopriv_reportvideo', 'send_report' );
function send_report() {
    global $wpdb, $current_user;
    /** Set report video email template path  */
    $emailTemplatePath  = APPTHA_VGALLERY_BASEURL . 'front/emailtemplate';
    /** Get slug id from parameters and get permalink URL */
    $slugId             = intval($_GET ['redirect_url']);
    $redirect_url       = get_video_permalink ( $slugId );
    /** Get report type from params */
    $reportvideotype    = $_GET ['reporttype'];
    /** Get admin email from WordPress options table */
    $admin_email        = get_option ( 'admin_email' );
    /** Get current user email id */
    $reporter_email     = $current_user->user_email;
    /** Get current user name */
    $sender_name        = $current_user->display_name;
    /** Get video title for the corresponding slug id */
    $video_title        = $wpdb->get_var ( 'SELECT name  FROM ' . HDFLVVIDEOSHARE . ' WHERE publish=1 AND slug=' . intval ( $slugId ) );
    /** Set subject for email */
    $subject            = $sender_name . ' report your video';
    /** Set headers (mime version, content type) for email */
    $headers            = "MIME-Version: 1.0" . "\r\n";
    $headers            .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    /** Set headers ( from email) for email */
    $headers            .= "From: " . "<" . $reporter_email . ">\r\n";
    /** Set headers ( to email) for email */
    $headers            .= "Reply-To: " . $reporter_email . "\r\n";
    /** Set headers ( return path ) for email */
    $headers            .= "Return-path: " . $reporter_email;   
    /** Get sfile contents from report video email template */
    $message            = file_get_contents ( $emailTemplatePath . '/reportvideo.html' );
    /** Replace all datas into the mail template */
    $message            = str_replace ( '{reporter_email}', $reporter_email, $message );
    $message            = str_replace ( '{report_type}', $message, $message );
    $message            = str_replace ( '{username}', $sender_name, $message );
    $message            = str_replace ( '{reportmsg}', $reportvideotype, $message );
    $message            = str_replace ( '{video_url}', $redirect_url, $message );
    $message            = str_replace ( '{video_title}', $video_title, $message );
    $message            = str_replace ( '{sender_name}', $sender_name, $message );
    /** Send video repot email to admin */
    if (@mail ( $admin_email, $subject, $message, $headers )) {
      echo "send";
    } else {
      echo "fail";
    }  
    exitAction ( '' );
}
/**
 * Youtube function Starts Here
 * Fucntion to get YouTube video title, description
 */
function youtubeurl() {
  /** Get Youtube video id from filepath param */
  $video_id         = addslashes ( trim ( $_GET ['filepath'] ) );
  /** Check Youtube video id is exist */
  if (! empty ( $video_id )) {
    /** Make an YouTube URl with the given id */
    $act[4] = 'http://www.youtube.com/watch?v=' . $video_id;
    /** Call function to get YouTube video details */
    $ydetails = hd_getsingleyoutubevideo( $video_id );
    /** If details exist */
    if ( $ydetails ) { 
      /** Get YouTube video title */
      $act[0] = $ydetails['items'][0]->snippet->title;
      /** Get YouTube video description */
      if ( isset( $ydetails['items'][0]->snippet->description ) ) { 
        $act[5] = $ydetails['items'][0]->snippet->description;
      }
    }
    else {
      /** Display error message if details are not fetched */
      render_error( __( 'Could not retrieve Youtube video information', APPTHA_VGALLERY ) );
    }
    return $act;
  }
}
/**
 * Function for get youtube media details
 * @param $youtube url.
 */
add_action ( 'wp_ajax_getyoutubedetails', 'admin_youtube_deatils' );
add_action ( 'wp_ajax_nopriv_getyoutubedetails', 'admin_youtube_deatils' );
function admin_youtube_deatils() {
    $act1 = youtubeurl ();
    echo json_encode ( $act1 );
    exitAction ( '' );
}
/** YouTube action Ends Here
 * Plugin installation / uninstallation action Starts Here
 * Function admin notice for plugin activation message deleted. 
 */
add_action ( 'admin_notices', 'videogallery_admin_notices' );
function videogallery_admin_notices() {
    /** Get adjustment settings option while plugin activation */
    $admin_notice_video_gallery   = get_option ( 'video_gallery_adjustment_instruction' );
    /** Get videogallery folder option while plugin activation */
    $admin_folder_video_gallery   = get_option ( 'video_gallery_folder_instruction' );
    /** Display instruction to adjust the settings while plugin activation */
    if ($admin_notice_video_gallery) {
      echo '<div id="message" class="updated"><p>To adjust the video gallery plugin setting please visit the link <strong><a href="' . admin_url ( 'admin.php?page=hdflvvideosharesettings' ) . '">Settings</a></strong>.</p></div>';
      /** Delete option once the information is displayed */
      delete_option ( 'video_gallery_adjustment_instruction' );
    }
    /** Get videogallery upload directory folder path */
    $uploadDirname = getUploadDirPath ();
    /** If folder is not exist then create folder */
    if( ! file_exists( $uploadDirname ) ) {
      /** If folder is not created then display error message */
      if(!wp_mkdir_p( $uploadDirname ) && $admin_folder_video_gallery) {
        echo '<div id="error" class="error"><p>Videogallery folder is not created in the folder path <strong>../wp-content/uploads/</strong></p></div>';
      }
    } else{
      /** If folder is created then delete error message */
      delete_option ( 'video_gallery_folder_instruction' );
    }
}
/** Function to Add videogallery menus list in wp admin */
add_action ( 'admin_menu', 'videogallery_addpages' );
function videogallery_addpages() {
    global $wpdb;
    /** Get player color settings from db  */
    $setting_member_upload  = getPlayerColorArray ();
    /** Set menu icon path */
    $menuIcon = getImagesDirURL() .'apptha.png';    
    /** Define menu constant */
    defineAction('VG_MENU', 'videogallery_menu');
    /** Add menu, videos page for member user */
    if (isset ( $setting_member_upload ['member_upload_enable'] ) && $setting_member_upload ['member_upload_enable'] == 1) {
        add_menu_page ( APPTHAVGALLERY, APPTHAVGALLERY, 'read', 'video', VG_MENU, $menuIcon );
        add_submenu_page ( 'video', APPTHAVGALLERY, 'All Videos', 'read', 'video', VG_MENU );
        add_submenu_page ( '', 'New Videos', '', 'read', 'newvideo', VG_MENU );
    } else {
        /** Add menu, videos page for admin */
        add_menu_page ( APPTHAVGALLERY, APPTHAVGALLERY, 'manage_options', 'video', VG_MENU, $menuIcon );
        add_submenu_page ( 'video', APPTHAVGALLERY, 'All Videos', 'manage_options', 'video', VG_MENU );
        add_submenu_page ( '', 'New Videos', '', 'manage_options', 'newvideo', VG_MENU );
    }
    /** Add menu, Categories page */
    add_submenu_page ( 'video', APPTHAVGALLERY, 'Categories', 'manage_options', 'playlist', VG_MENU );
    /** Add menu, Categories page */
    add_submenu_page ( 'video', APPTHAVGALLERY, 'Playlist', 'manage_options', 'userplaylist', VG_MENU );
    /** Add Ajax Category page */
    add_submenu_page ( '', APPTHAVGALLERY, 'Ajax Category', 'manage_options', 'ajaxplaylist', VG_MENU );
    /** Add New Category page */
    add_submenu_page ( '', 'New Category', '', 'manage_options', 'newplaylist', VG_MENU );
    /** Add menu, Video Ads page */
    add_submenu_page ( 'video', 'Video Ads', 'Video Ads', 'manage_options', 'videoads', VG_MENU );
    /** Add New Video Ads page */
    add_submenu_page ( '', 'New Videos', '', 'manage_options', 'newvideoad', VG_MENU );
    /** Add menu, Google AdSense page */
    add_submenu_page ( 'video', 'Google AdSense', 'Google AdSense', 'manage_options', 'googleadsense', VG_MENU );
    /** Add New Google AdSense page */
    add_submenu_page ( '', 'New Google AdSense', 'New Google AdSense', 'manage_options', 'addgoogleadsense', VG_MENU );
    /** Add Gallery Settings page */
    add_submenu_page ( 'video', 'GallerySettings', 'Settings', 'manage_options', 'hdflvvideosharesettings', VG_MENU );
    /** Add Video Gallery Instruction page */
    add_submenu_page ( '', ' Video Gallery Instruction', 'Video Gallery Instruction', 'menu_options', 'videogallery_instruction', VG_MENU );
}
/** Include installation file to create database */
require_once (APPTHA_VGALLERY_BASEDIR . '/install.php');
/** Activate hook for installatio file */
register_activation_hook ( __FILE__, 'videogallery_install' );
/** Get plugin main file path */
$plugin_main_file   = getPluginFolderName() . '/hdflvvideoshare.php';
/** If plugin is activated, then check the newly added columns are exist in database */
if (isset ( $_GET ['action'] ) && $_GET ['action'] == 'activate-plugin' && $_GET ['plugin'] == $plugin_main_file) {
  global $wpdb;
  $table_name           = HDFLVVIDEOSHARE;
  $table_settings       = WVG_SETTINGS;
  $table_playlist       = WVG_PLAYLIST;
  $table_ad             = WVG_VGADS;
  $charset_collate      = WVG_CHARSET_COLLATE ;
  $updateSlug = $updatestreamer_path = $updateislive = $updateratecount = $updaterate = $updateordering = $updatekeyApps = $updatekeydisqusApps = $player_colors = $playlist_open = $updatecolMore = $updateembedcode = $updatesubtitle_lang1 = $updatemember_id = $updatesubtitle_lang2 = $updatesrtfile1 = $updatesrtfile2 = $updatedefault_player = $updaterowMore = $showPlaylist = $updatecontentId = $updateimaadpath = $updatepublisherId = $updateimaadwidth = $updateimaadheight = $midroll_ads = $adsSkip = $adsSkipDuration = $relatedVideoView = $imaAds = $trackCode = $showTag = $ratingscontrol = $view_visible = $updateaddescription = $updateimaadType = $updateadtargeturl = $updateadclickurl = $updateadimpressionurl = $updateadmethod = $updateadtype = $updateispublish = $shareIcon = $updateimaad = $updateisplaylist_slugname = $categorydisplay = $tagdisplay = $updatechannels = $updatemidrollads = $volumecontrol = $playlist_auto = $progressControl = $imageDefault = $updatepublish = $updateadpublish = '';
  /** Video table Alter */ 
  $updateSlug           = add_column_if_not_exists ( "$table_name", 'slug', "TEXT $charset_collate NOT NULL" );
  $updatemidrollads     = add_column_if_not_exists ( "$table_name", 'midrollads', 'INT( 11 ) NULL DEFAULT 0' );
  $updateimaad          = add_column_if_not_exists ( "$table_name", 'imaad', 'INT( 11 ) NULL DEFAULT 0' );
  $updatestreamer_path  = add_column_if_not_exists ( "$table_name", 'streamer_path', "MEDIUMTEXT $charset_collate NOT NULL" );
  $updatepublish        = add_column_if_not_exists ( "$table_name", 'publish', 'INT( 11 ) NOT NULL DEFAULT 1' );
  $updateislive         = add_column_if_not_exists ( "$table_name", 'islive', 'INT( 11 ) NOT NULL' );
  $updateordering       = add_column_if_not_exists ( "$table_name", 'ordering', 'INT( 11 ) NOT NULL' );
  $updateratecount      = add_column_if_not_exists ( "$table_name", 'ratecount', 'INT( 25 ) NOT NULL DEFAULT 0' );
  $updaterate           = add_column_if_not_exists ( "$table_name", 'rate', 'INT( 25 ) NOT NULL DEFAULT 0' );
  $updateembedcode      = add_column_if_not_exists ( "$table_name", 'embedcode', 'LONGTEXT NOT NULL' );
  $updatesrtfile1       = add_column_if_not_exists ( "$table_name", 'srtfile1', 'varchar( 255 ) NOT NULL' );
  $updatesrtfile2       = add_column_if_not_exists ( "$table_name", 'srtfile2', 'varchar( 255 ) NOT NULL' );
  $updatesubtitle_lang1 = add_column_if_not_exists ( "$table_name", 'subtitle_lang1', 'MEDIUMTEXT NOT NULL' );
  $updatesubtitle_lang2 = add_column_if_not_exists ( "$table_name", 'subtitle_lang2', 'MEDIUMTEXT NOT NULL' );
  $updatemember_id      = add_column_if_not_exists ( "$table_name", 'member_id', 'INT( 3 ) NOT NULL' );
  $update_amazon_bucket = add_column_if_not_exists ( "$table_name", 'amazon_buckets', 'INT ( 1 ) NOT NULL DEFAULT 0' );
  $updategoogle_adsense = add_column_if_not_exists ( "$table_name", 'google_adsense', 'INT( 3 ) NULL' );
  $updategoogle_adsense_value = add_column_if_not_exists ( "$table_name", 'google_adsense_value', 'INT( 11 ) NULL' );  
  /** AD table Alter */ 
  $updateadpublish        = add_column_if_not_exists ( "$table_ad", 'publish', 'INT( 11 ) NOT NULL DEFAULT 1' );
  $updateaddescription    = add_column_if_not_exists ( "$table_ad", 'description', "TEXT $charset_collate NOT NULL" );
  $updateadtargeturl      = add_column_if_not_exists ( "$table_ad", 'targeturl', "TEXT $charset_collate NOT NULL" );
  $updateadclickurl       = add_column_if_not_exists ( "$table_ad", 'clickurl', "TEXT $charset_collate NOT NULL" );
  $updateadimpressionurl  = add_column_if_not_exists ( "$table_ad", 'impressionurl', "TEXT $charset_collate NOT NULL" );
  $updateadmethod         = add_column_if_not_exists ( "$table_ad", 'admethod', "TEXT $charset_collate NOT NULL" );
  $updateadtype           = add_column_if_not_exists ( "$table_ad", 'adtype', "TEXT $charset_collate NOT NULL" );
  $updateimaadwidth       = add_column_if_not_exists ( "$table_ad", 'imaadwidth', 'INT( 11 ) NULL' );
  $updateimaadheight      = add_column_if_not_exists ( "$table_ad", 'imaadheight', 'INT( 11 ) NULL' );
  $updateimaadpath        = add_column_if_not_exists ( "$table_ad", 'imaadpath', "TEXT $charset_collate NULL" );
  $updatepublisherId      = add_column_if_not_exists ( "$table_ad", 'publisherId', "TEXT $charset_collate NOT NULL" );
  $updatecontentId        = add_column_if_not_exists ( "$table_ad", 'contentId', "TEXT $charset_collate NOT NULL" );
  $updateimaadType        = add_column_if_not_exists ( "$table_ad", 'imaadType', 'INT( 11 ) NULL' );
  $updatechannels         = add_column_if_not_exists ( "$table_ad", 'channels', "varchar( 255 ) $charset_collate NOT NULL" );  
  /** Playlist table Alter */
  $updateispublish            = add_column_if_not_exists ( "$table_playlist", 'is_publish', 'INT( 11 ) NOT NULL DEFAULT 1' );
  $updateisplaylist_slugname  = add_column_if_not_exists ( "$table_playlist", 'playlist_slugname', "TEXT $charset_collate NOT NULL" );
  /**  Settings table Alter */
  $updatedefault_player = add_column_if_not_exists ( "$table_settings", 'default_player', 'INT( 11 ) NOT NULL DEFAULT 0' );
  $updatekeyApps        = add_column_if_not_exists ( "$table_settings", 'keyApps', "varchar( 50 ) $charset_collate NOT NULL" );
  $updaterowMore        = add_column_if_not_exists ( "$table_settings", 'rowMore', "varchar( 25 ) $charset_collate NOT NULL DEFAULT 2" );
  $updatecolMore        = add_column_if_not_exists ( "$table_settings", 'colMore', "varchar( 25 ) $charset_collate NOT NULL DEFAULT 4" );
  $updatekeydisqusApps  = add_column_if_not_exists ( "$table_settings", 'keydisqusApps', "varchar( 50 ) $charset_collate NOT NULL" );
  $player_colors        = add_column_if_not_exists ( "$table_settings", 'player_colors', "longtext $charset_collate NOT NULL" );
  $playlist_open        = add_column_if_not_exists ( "$table_settings", 'playlist_open', 'INT( 3 ) NOT NULL' );
  $showPlaylist         = add_column_if_not_exists ( "$table_settings", 'showPlaylist', 'INT( 3 ) NOT NULL' );
  $midroll_ads          = add_column_if_not_exists ( "$table_settings", 'midroll_ads', 'INT( 3 ) NULL' );
  $adsSkip              = add_column_if_not_exists ( "$table_settings", 'adsSkip', 'INT( 3 ) NOT NULL' );
  $adsSkipDuration      = add_column_if_not_exists ( "$table_settings", 'adsSkipDuration', 'INT( 15 ) NOT NULL' );
  $relatedVideoView     = add_column_if_not_exists ( "$table_settings", 'relatedVideoView', "varchar( 50 ) $charset_collate NOT NULL" );
  $imaAds               = add_column_if_not_exists ( "$table_settings", 'imaAds', 'INT( 3 ) NULL' );
  $trackCode            = add_column_if_not_exists ( "$table_settings", 'trackCode', "TEXT $charset_collate NOT NULL" );
  $showTag              = add_column_if_not_exists ( "$table_settings", 'showTag', 'INT( 3 ) NOT NULL' );
  $ratingscontrol       = add_column_if_not_exists ( "$table_settings", 'ratingscontrol', 'INT( 3 ) NOT NULL' );
  $tagdisplay           = add_column_if_not_exists ( "$table_settings", 'tagdisplay', 'INT( 3 ) NOT NULL' );
  $categorydisplay      = add_column_if_not_exists ( "$table_settings", 'categorydisplay', 'INT( 3 ) NOT NULL' );
  $view_visible         = add_column_if_not_exists ( "$table_settings", 'view_visible', 'INT( 3 ) NOT NULL' );
  $shareIcon            = add_column_if_not_exists ( "$table_settings", 'shareIcon', 'INT( 3 ) NOT NULL' );
  $volumecontrol        = add_column_if_not_exists ( "$table_settings", 'volumecontrol', 'INT( 3 ) NOT NULL DEFAULT 1' );
  $playlist_auto        = add_column_if_not_exists ( "$table_settings", 'playlist_auto', 'INT( 3 ) NOT NULL' );
  $progressControl      = add_column_if_not_exists ( "$table_settings", 'progressControl', 'INT( 3 ) NOT NULL DEFAULT 1' );
  $imageDefault         = add_column_if_not_exists ( "$table_settings", 'imageDefault', 'INT( 3 ) NOT NULL' );
  /** Call function to upgrade videos */
  upgrade_videos ();
}
/**
 * Function to declare the videogalery admin pages starts
 */
function videogallery_menu() {
    global $adminControllerPath, $adminModelPath, $adminViewPath;
    /** Get page parameter to display the corresponding admin pages */
    $adminPage = filter_input ( INPUT_GET, 'page' );
    /** Check page and display the plugin pages in admin  */
    switch ($adminPage) {        
        case 'playlist' :
        case 'newplaylist' :
        case 'userplaylist' :	
          include_once ($adminControllerPath . 'playlistController.php');
          break;
        case 'videoads' :
        case 'newvideoad' :
          include_once ($adminControllerPath . 'videoadsController.php');
          break;
        case 'hdflvvideosharesettings' :
          include_once ($adminControllerPath . 'videosettingsController.php');
          break;
        case 'googleadsense' :
        case 'addgoogleadsense' :
          include_once ($adminControllerPath . 'videogoogleadsenseController.php');
          break;
        case 'video' :
        case 'newvideo':
        default:
            include_once ($adminControllerPath . 'ajaxplaylistController.php');
            include_once ($adminControllerPath . 'videosController.php');
            include_once ($adminControllerPath . 'videosSubController.php');
            break;
    }
}
/** Admin section ends here
 * 
 * Front end section starts here
 * Include video home controller */ 
include_once $frontControllerPath . 'videohomeController.php';
/** Function declaration to replace videohome content with shortcode */
add_shortcode ( 'videohome', 'video_homereplace' );
/** Function declaration to replace videomore content with shortcode */
add_shortcode ( 'videomore', 'video_morereplace' );
/** Function declaration to replace hdvideo content with shortcode */
add_shortcode ( 'hdvideo', 'video_shortcodereplace' );
/** Function declaration to replace categoryvideothumb content with shortcode */
add_shortcode ( 'categoryvideothumb', 'video_moreidreplace' );
/** Function declaration to replace popularvideo content with shortcode */
add_shortcode ( 'popularvideo', 'video_popular_video_shortcode' );
/** Function declaration to replace recentvideo content with shortcode */
add_shortcode ( 'recentvideo', 'video_recent_video_shortcode' );
/** Function declaration to replace featuredvideo content with shortcode */
add_shortcode ( 'featuredvideo', 'video_featured_video_shortcode' );
/** Function declaration to replace watch_history content with shortcode */
add_shortcode ( 'watch_history', 'watch_history' );
/** Function declaration to replace watch_later content with shortcode */
add_shortcode ( 'watch_later', 'watch_later' );
/** Function declaration to replace showplaylist content with shortcode */
add_shortcode ( 'showplaylist', 'show_playlist' );
/** Function declaration to replace videochannel content with shortcode */
add_shortcode ( 'videochannel', 'video_channel' );
/**
 * Function to display watch history page
 * This function call watchController method to include watch history controller file
 * This function pass shortcode name ([watch_history]) as a parameter to watchController method
 * This function pass controller file name "watchhistorycontroller" as a parameter to watchController method
 * This function pass controller file class name "WatchHistoryController" as a parameter to watchController method
 * @return void
 */
function watch_history() {
	watch_history_user();
	watchController("[watch_history]",'watchhistorycontroller','WatchHistoryController');
}
/**
 * Function to display watch later page
 * This function call watchController method to include watch later controller file
 * This function pass shortcode name ([watch_later]) as a parameter to watchController method
 * This function pass controller file name "watchlatercontroller" as a parameter to watchController method
 * This function pass controller file class name "WatchLaterController" as a parameter to watchController method
 * @return void
 */
function watch_later() {
	watchController("[watch_later]",'watchlatercontroller','WatchLaterController');
}
/**
 * Function include controller file for watch later and watch history
 * This function is used to include controller file for watch later and watch history features
 * This function has  watch_history_page to hold current page details
 * This function has  link to hold current page permalink
 * This function include watch.min.css file
 * This function include watch script file
 * This function include watch history/watch later controller file
 * This function create object for watch history/watch later controller class
 * This function call displayController method on controller file
 * @return void
 */
function watchController($shortCode,$fileName,$controllerClassName) {
	global $frontControllerPath, $frontModelPath, $frontViewPath,$wpdb;
	$watch_history_page = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."posts WHERE post_content=%s AND post_status=%s",$shortCode,"publish"));
	if ( get_option('permalink_structure') ) {
		$link = get_site_url() . '/' .$watch_history_page[0]->post_name;
	}
	else {
		$link = $watch_history_page[0]->guid;
	}
	if(is_user_logged_in()) {
		wp_register_style ( 'watch_history', plugins_url ( 'css/watch.min.css', __FILE__ ) );
		wp_enqueue_style ( 'watch_history' );
		wp_register_script( 'watch_history_script', plugins_url ( 'js/watch.min.js', __FILE__ ) );
		wp_enqueue_script ( 'watch_history_script' );
		include_once ($frontControllerPath . $fileName.'.php');
		$controllerObj = new $controllerClassName();
		$controllerObj->displayController();
	}
	else {
		header('location:'.get_site_url().'/wp-login.php?redirect_to='.urlencode($link));
	}
}
/**
 * Function to display playlist page
 * This function is used to include controller file for watch later and watch history features
 * This function has playlist_page to hold current page details
 * This function has link to hold current page permalink
 * This function has userID to hold current user id
 * This function include watch.min.css file
 * This function include playlistscroll script file
 * This function include playlistcontroller controller file
 * This function create object for PlaylistController class
 * This function call displayController method on controller file
 * @return void
 */
function show_playlist($attr) {
	global $frontControllerPath, $frontModelPath, $frontViewPath,$wpdb;
	$playlist_page = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."posts WHERE post_content=%s AND post_status=%s","[showplaylist]","publish"));
	if ( get_option('permalink_structure') ) {
		$link = get_site_url() . '/' .$playlist_page[0]->post_name;
	}
	else {
		$link = $playlist_page[0]->guid;
	}
	if(!empty($attr['user'])) {
        $userID = get_user_by( 'login', $attr['user'] )->ID;
    }
    else {
    	$userID = '';
    }
	if(is_user_logged_in()) {
		wp_register_style ( 'watch_history', plugins_url ( 'css/watch.min.css', __FILE__ ) );
		wp_enqueue_style ( 'watch_history' );
    	wp_register_script ( 'playlistscroll_js', plugins_url ( '/js/playlistscroll.min.js', __FILE__ ) );
	    wp_enqueue_script ( 'playlistscroll_js' );
     	include_once ($frontControllerPath . 'playlistcontroller.php');
		$controllerObj = new PlaylistController($userID);
		$controllerObj->displayController();
	}
	else {
		header('location:'.get_site_url().'/wp-login.php?redirect_to='.urlencode($link));
	}
}
/**
 * Function to display channel page
 * This function is used to include controller file for watch later and watch history features
 * This function has channel_page to hold current page details
 * This function has link to hold current page permalink
 * This function has subscriberKey to hold subscriber key  
 * This function has subscriberID to hold subscriber id 
 * This function has userID to hold current user id
 * This function include channel.min.css file
 * This function include jquery-ui script file
 * This function include channelscript.min.js script file
 * This function include channel.min.js script file
 * This function include $wpdb script file
 * This function include channelcontroller controller file
 * This function create object for ChannelController class
 * This function call displayController method on controller file
 * @return void
 */
function video_channel() {
	global $frontControllerPath, $frontModelPath, $frontViewPath,$wpdb;
	$channel_page = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."posts WHERE post_content=%s AND post_status=%s","[videochannel]","publish"));
	if ( get_option('permalink_structure') ) {
		$link = get_site_url() . '/' .$channel_page[0]->post_name;
	}
	else {
		$link = $channel_page[0]->guid;
	}
	$subscriberKey = (isset($_REQUEST['ukey']) && $_REQUEST['ukey'] != '') ? strip_tags($_REQUEST['ukey']) : '';
    if(!empty($subscriberKey)) {
        $subscriberID = $wpdb->get_var($wpdb->prepare('SELECT user_id FROM '.WVG_CHANNEL.' WHERE user_key=%s',$subscriberKey));
    }
    if(!empty($subscriberID)) {
        $userID = $subscriberID;
        $subscriber = true;
    }
    else {
        $userID = get_current_user_id();
        $subscriber = false;
    }
	if(is_user_logged_in()) {
        checkChannelUserDetails($userID);
		wp_register_style ( 'channel_css', plugins_url ( 'css/channel.min.css', __FILE__ ) );
		wp_enqueue_style ( 'channel_css' );
		wp_register_script ( 'jquery-ui', plugins_url ( '/js/jquery-ui.js', __FILE__ ) );
		wp_enqueue_script ( 'jquery-ui' );
		wp_register_script ( 'channelscript_js', plugins_url ( '/js/channelscript.min.js', __FILE__ ) );
		wp_enqueue_script ( 'channelscript_js' );
		wp_register_script ( 'channel_js', plugins_url ( '/js/channel.min.js', __FILE__ ) );
		wp_enqueue_script ( 'channel_js' );
		wp_register_script ( 'channelvideo_js', plugins_url ( '/js/channelvideo.min.js', __FILE__ ) );
		wp_enqueue_script ( 'channelvideo_js' );
		include_once ($frontControllerPath . 'channelcontroller.php');
		$controllerObj = new ChannelController();
		$controllerObj->displayController($userID,$subscriber);
	}
	else {
		header('location:'.get_site_url().'/wp-login.php?redirect_to='.urlencode($link));
	}
}
add_action( 'user_register', 'after_register', 10, 1 );
/**
 * Function after_register is used to add registered user details on channel table
 * 
 * @param int $userID user id
 * @retur void
 */
function after_register( $userID ) {
    checkChannelUserDetails($userID);
}
/**
 * Function to display Plugin home page
 */
function video_homereplace () {
    global $frontControllerPath, $frontModelPath, $frontViewPath; 
    /** Include video home controller file */
    include_once ( $frontControllerPath . 'videohomeController.php' );
    /** Create object for ContusVideoView class */
    $pageOBJ            = new ContusVideoView ();
    /** Call function to display home page player, popular, recent, featured and home page category videos */
    $contentPlayer      = $pageOBJ->home_player ();
    $contentPopular     = $pageOBJ->home_thumb ( 'popular' );
    $contentRecent      = $pageOBJ->home_thumb ( 'recent' );    
    $contentFeatured    = $pageOBJ->home_thumb ( 'featured' );
    $contentCategories  = $pageOBJ->home_thumb ( 'cat' );    
    /** Return home page palyer and content */
    return $contentPlayer . $contentPopular . $contentRecent . $contentFeatured . $contentCategories;
}
/**
 * Function to display Plugin video details page
 */
function video_shortcodereplace ( $arguments = array() ) {
    global $frontControllerPath, $frontModelPath, $frontViewPath; 
    /** Include videoshort code controller file */   
    include_once ($frontControllerPath . 'videoshortcodeController.php');
    /** Call function to include video detial page js, css files */
    videogallery_jcar_js_css ();
    /** Create object for ContusVideoDetailView and call function display video detial page  */
    $pageOBJ        = new ContusVideoDetailView ();
    return $pageOBJ->hdflv_sharerender ( $arguments );
}
/**
 * Function to display content for category shortcode
 */
function video_moreidreplace ( $arguments = array() ) {
  global $wp_query, $videomoreControllerFile, $frontControllerPath, $frontModelPath, $frontViewPath;
  /** Get playlist id from short code */
  $playid   = absint ( $arguments ['id'] );
  $wp_query->query_vars ["playid"] = $playid;
  /** Include video more controller file and create object  */
  include_once ( $videomoreControllerFile );
  $videoOBJ = new ContusMorePageView ();
  /** Set more page name as categories by default */
  $more   = "categories";
  /** Check playlist id is exist */
  if (! empty ( $playid ) && $arguments ['type'] == 'category' ) {
    /** Set more page name as cat */
    $more   = 'cat';
  }
  if (! empty ( $playid ) && $arguments ['type'] == 'playlist' ) {
  	/** Set more page name as cat */
  	$more   = 'playlist';
  }
  /** Get rows, columns count from short code and display category videos */
  if (isset ( $arguments ['rows'] ) && isset ( $arguments ['cols'] )) {
    $contentvideoPlayer = $videoOBJ->video_more_pages ( $more, $arguments );
  } else {
    $contentvideoPlayer = $videoOBJ->video_more_pages ( $more, $arguments = array () );
  }
  /** Return more page content */
  return $contentvideoPlayer;
}
/**
 * Function to display content for Popular video shortcode
 */
function video_popular_video_shortcode ( $arguments = array () ) {
  global $videomoreControllerFile, $frontControllerPath, $frontModelPath, $frontViewPath;
  include_once ( $videomoreControllerFile );
  /** Create object for video more view class */
  $videoOBJ           = new ContusMorePageView ();
  /** Set more page name and display popular videos */
  $more               = 'popular';
  /** Return popular page content */
  return $videoOBJ->video_more_pages ( $more, $arguments );
}
/**
 * Function to display content for recent video short code
 */
function video_recent_video_shortcode ( $arguments = array () ) {
  global $videomoreControllerFile, $frontControllerPath, $frontModelPath, $frontViewPath;
  include_once ( $videomoreControllerFile );
  /** Create object for video more view class and set more page name */
  $videoOBJ           = new ContusMorePageView ();
  $more               = 'recent';
  /** Call fucntion and return recent page content */
  return $videoOBJ->video_more_pages ( $more, $arguments );
}
/**
 * Function to display content forr feature video short code
 */
function video_featured_video_shortcode ( $arguments = array () ) {
  global $videomoreControllerFile, $frontControllerPath, $frontModelPath, $frontViewPath;
  include_once ( $videomoreControllerFile );
  /** Create object for video more view class and set more name  */
  $videoOBJ           = new ContusMorePageView ();
  $more               = 'featured';
  /** Call function to get featured videos and return */
  return $videoOBJ->video_more_pages ( $more, $arguments );
}
/**
 * Function to display Plugin more page
 */
function video_morereplace ( $arguments = array () ) {
    global $videomoreControllerFile, $wp_query, $frontControllerPath, $frontModelPath, $frontViewPath;
    /** Get playlist id from param */
    $playid         = filter_input ( INPUT_GET, 'playid' );
    /** Get more name from param */
    $more           = &$wp_query->query_vars ['more'];
    /** Get playlist name from param */
    $playlist_name  = &$wp_query->query_vars ['playlist_name'];
    /** Check playlist name is exist */
    if (! empty ( $playlist_name )) {
      /**  Get playlist id */
      $playid       = get_playlist_id ( $playlist_name );
    }    
    /** Set playlist id into query */
    $wp_query->query_vars ['playid'] = $playid;    
    /** Get user id from param */    
    $userid     = filter_input ( INPUT_GET, 'userid' );
    /** Get user name from param */
    $user_name  = &$wp_query->query_vars ['user_name'];
    $user_name  = str_replace ( '%20', ' ', $user_name );
    /** Check user name is exist */
    if (! empty ( $user_name )) {
      /** Get user id for the given user name*/
      $userid   = get_user_id ( $user_name );
    }
    /** Set user id into query */
    $wp_query->query_vars ['userid'] = $userid;
    /** Include videomore controller and create object for view */
    include_once ( $videomoreControllerFile );
    $videoOBJ = new ContusMorePageView ();
    /** Set more page name as cat if playlist id exists */
    if (! empty ( $playid )) {
      $more   = 'cat';
    }
    /** Set more page name as user if user id exists */
    if (! empty ( $userid )) {
      $more   = 'user';
    }   
    /** Set more page name as categories if all-category exists */
    if ($more == 'all-category') {
      $more   = 'categories';
    }    
    /** Get video search param */
    $video_search = &$wp_query->query_vars ['video_search'];
    /** Set more page name as search if video search exists */
    if (! empty ( $video_search )) {
      $more       = 'search';
    }    
    /** Get video tags param */
    $videotag     = &$wp_query->query_vars ['video_tag'];
    /** Set more page name as tag if video tags exists */
    if (! empty ( $videotag )) {
      $more       = 'tag';
    }
    /** Call function to display more videos page */
    return $videoOBJ->video_more_pages ( $more, $arguments );
}
/** Register the uninstall hook */
register_uninstall_hook ( APPTHA_VGALLERY_BASEDIR . '/uninstall.php', 'videogallerypluginuninstall' );
add_action('init', 'vgStartSession', 1);
function vgStartSession() {
	if(!session_id()) {
		session_start();
	}
}
?>