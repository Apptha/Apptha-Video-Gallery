<?php
/** 
 * Ajax Playlist Controller.
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Including Playlist model file to get database information. */ 
include_once ($adminModelPath . 'ajaxplaylist.php');
/** Checks if the PlaylistController class has been defined starts */
if ( !class_exists ( 'AjaxPlaylistController' ) ) {  
  /**
   * AjaxPlaylistController class starts   
   */
  class AjaxPlaylistController extends AjaxPlaylistModel { 
        /**
         * Constructor function used to get parameters from request URL
         */
        public function __construct() {
            parent::__construct ();            
        }
        
        /**
         * This function is used to create a new playlist 
         * in add video page without refreshing the page
         * 
         * @param    string    $name 
         * @param    string    $media
         */
        public function hd_ajax_add_playlist( $name, $media) {
            global $wpdb;
            /** Get name from param */ 
            $p_name         = addslashes ( trim ( $name ) );
            /** sanitize name and get slug name */
            $p_slugname     = sanitize_title ( $name );
            $p_description  = '';            
            /** Query to get last palylist order from playlist table */
            $playlist_order   = getAllPlaylistCount ();            
            /** Query to get playlist name from playlist table if the given name is exist */
            $playlistname1    = 'SELECT playlist_name FROM ' . $wpdb->prefix . 'hdflvvideoshare_playlist WHERE playlist_name="' . $p_name . '"';
            $planame1         = $wpdb->get_row ( $playlistname1 );            
            /** Check the playlist name is already exist */
            if (count ( $planame1 ) > 0) {
                /** Display error message category already exist */
                render_error ( __ ( 'Failed, category name already exist', APPTHA_VGALLERY ) ) . $this->get_playlist_for_dbx ( $media );
                return;
            }            
            /** If new playlist name is exist, then create new data */ 
            if (! empty ( $p_name )) {   
                /** Set palylsit details as array */         
                $videoData = array ( 'playlist_name' => $p_name, 'playlist_desc' => $p_description, 'is_publish' => 1,
                  'playlist_order'    => $playlist_order, 'playlist_slugname' => $p_slugname ) ;
                /** Insert the new data array into playlist table */
                $insert_plist = $wpdb->insert ( $wpdb->prefix . 'hdflvvideoshare_playlist', $videoData );                
                /** Check data is insert into database */
                if ($insert_plist != 0) {
                    /** Display success message */
                    $this->render_message ( __ ( 'Category', APPTHA_VGALLERY ) . ' ' . $name . ' ' . __ ( 'added successfully', APPTHA_VGALLERY ) ) . $this->get_playlist_for_dbx ( $media );
                }
            }
            /** Return to new videos page */ 
            return;
        }
        
        /**
         * Fucntion to display the message while ajax playlist creation
         *  
         * @param unknown $message
         */
        public function render_message( $message ) { 
        /** Display message while ajax playlist creation */?>
          <div class="wrap"> <div class="fade updated" id="message" onclick="this.parentNode.removeChild( this )"> <p><strong><?php echo $message; ?></strong></p> </div></div> 
<?php }
        /**
         * Function to get all active playlist ID for our site
         */
        function getAllPlaylistID () {
            global $wpdb;
            /** Query to get all active playlist 
             * Return the playlist id's */
            return $wpdb->get_col ( 'SELECT pid FROM ' . $wpdb->prefix . 'hdflvvideoshare_playlist where is_publish=1' );
        }
        /**
         * Function to display Playlist table
         *  
         * @param unknown $mediaid
         */
        function displayPlaylist ($mediaid) {
            global $wpdb;
            $result   = $hiddenarray = array ();
            /** Get playlist id, order for the given video id */
            $checked_playlist = $wpdb->get_col ( 'SELECT playlist_id, sorder FROM '. $wpdb->prefix . 'hdflvvideoshare_playlist,'
                . $wpdb->prefix . 'hdflvvideoshare_med2play WHERE is_publish=1 AND '
                . $wpdb->prefix . 'hdflvvideoshare_med2play.playlist_id = pid AND '
                . $wpdb->prefix . 'hdflvvideoshare_med2play.media_id = "' . $mediaid . '"' );
            /** Check playlist count is  0 */
            if (count ( $checked_playlist ) == 0) {
              /** Set checked playlist array as 0 */
              $checked_playlist [] = 0;
            }
            /** Fetch all published playlist id from database */
            $playids = $this->getAllPlaylistID ();  
            /** Check play id's are exist */          
            if (is_array ( $playids )) {
              /** Looping through playlist details  */
              foreach ( $playids as $playid ) {
                /** Get play id and assign */
                $result [$playid] ['playid']  = $playid;
                /** Check play id is exist in checked array */
                $result [$playid] ['checked'] = in_array ( $playid, $checked_playlist );
                /** Get playlist name and anssign */
                $result [$playid] ['name']    = get_playlist_name ( $playid );
                /** Get sorting order for playlist */
                $result [$playid] ['sorder']  = $this->get_sortorder ( $playid, $mediaid );
              }
            }
            /** Display ajax playlist creation section starts */
            echo '<table>';
            foreach ( $result as $playlist ) {
                $hiddenarray [] = $playlist ['playid'];
                echo '<tr> <td style="font-size:11px">
                    <input value="' . $playlist ['playid'] . '" type="checkbox" name="playlist[]" id="playlist-' . $playlist ['playid'] . '"' . ($playlist ['checked'] ? ' checked="checked"' : '') . '/>
                    <label for="playlist-' . $playlist ['playid'] . '" class="selectit">' . esc_html ( $playlist ['name'] ) . '</label>
                   </td ></tr>';
            }
            echo '</table>';
            /** Display ajax playlist creation section ends */
            /** Set playlist id into hidden field */
            $comma_separated = implode ( ',', $hiddenarray );
            echo '<input type=hidden name=hid value = "' . $comma_separated . '" >';            
        }
        
        /**
         * Fucntion to get all playlists for our site
         */
        public function get_playlist() {        
            $mediaid  = '';
            /** Get video id from parameter */
            $videoId  = filter_input ( INPUT_GET, 'videoId' );
            /** Check video id is exist */
            if (isset ( $videoId )) {
              /** Set media details */
              $mediaid = $videoId;
            }
            /** Get playlist details and display it */
            $this->displayPlaylist ($mediaid);
        }
        
        /**
         * Get media playlist for the videos
         * 
         * @param   number    $mediaid          
         */
        public function get_playlist_for_dbx($mediaid) {
            $mediaid = ( int ) $mediaid;
            /** Get playlist details for the given media id and display it */
            $this->displayPlaylist ($mediaid);
        }
        
        /**
         * Fucntion to get playlist sort order change
         * 
         * @param   number  $mediaid          
         * @param   number  $pid     
         *      
         * @return  Ambigous <string, NULL>
         */
        public function get_sortorder( $pid, $mediaid = 0 ) {
            global $wpdb;            
            $mediaid  = ( int ) $mediaid;
            /** Get sorting order for the given video and return */
            return $wpdb->get_var ( 'SELECT sorder FROM ' . $wpdb->prefix . 'hdflvvideoshare_med2play WHERE media_id = ' . $mediaid . ' and playlist_id= ' .  $pid );
        }
   /** AjaxPlaylistController class ends */
  } 
/** Checks if the PlaylistController class has been defined ends */
}
/** Create object for PlaylistController class */
$ajaxplaylistOBJ  = new AjaxPlaylistController ();
/** Get playlsit name from request */
$playlist_name    = filter_input ( INPUT_GET, 'name' );
/** Check playlist name is exist */
if (isset ( $playlist_name )) {
    /** Call ajax fucntion to add playlist */
    return $ajaxplaylistOBJ->hd_ajax_add_playlist ( filter_input ( INPUT_GET, 'name' ), filter_input ( INPUT_GET, 'media' ) );
}
?>