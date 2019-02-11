<?php
/**
  Name: Wordpress Video Gallery
  URI: http://www.apptha.com/category/extension/Wordpress/Video-Gallery
  Description: Wordpress Video Gallery page meta details file.
  Version: 2.9
  Author: Apptha
  Author URI: http://www.apptha.com
  License: GPL2
 */

/**
 * Function to display admin tabs
 * 
 * @param unknown $section
 * @return string
 */
function displayAdminTabs ( $section ) {
  /** Check whether the tab is playlist / ads / gads / settings and videos and set styles */
  switch( $section ) {
      case 'userplaylist' :
          /** Set playlist tab is active */
          $userplaylist = 'nav-tab-active';
          $video = $ads = $settings = $gads = $playlist = '';
          break;
      case 'playlist' :
       	  /** Set playlist tab is active */
          $playlist = 'nav-tab-active';
          $video = $ads = $settings = $gads = '';
          break;
      case 'ads' :
          /** Set ads tab is active */
          $ads = 'nav-tab-active';
          $video = $playlist = $settings = $gads = '';
          break;
      case 'gads' :
          /** Set google ads tab is active */
          $gads = 'nav-tab-active';
          $video = $playlist = $settings = $ads = '';
          break;
      case 'settings' :
          /** Set settings tab is active */
          $settings = 'nav-tab-active';
          $video = $playlist = $gads = $ads = '';
          break;
      case 'videos' :
      default:
          /** Set videos tab is active */
          $video = 'nav-tab-active';
          $playlist = $ads = $settings = $gads = '';
          break;
  }
  /** Display admin tabs for plugin */
  return '<h2 class="nav-tab-wrapper">
    <a href="?page=video" class="nav-tab ' . $video . ' "> '. __( 'All Videos', APPTHA_VGALLERY ) . '</a>
    <a href="?page=playlist" class="nav-tab ' . $playlist .'">' .__( 'Categories', APPTHA_VGALLERY ) . '</a> 
    		<a href="?page=userplaylist" class="nav-tab ' . $userplaylist .'">' .__( 'Playlist', APPTHA_VGALLERY ) . '</a> 
    <a href="?page=videoads" class="nav-tab ' . $ads . '">' . __( 'Video Ads', APPTHA_VGALLERY ) . '</a> 
    <a href="?page=hdflvvideosharesettings" class="nav-tab ' . $settings . ' ">'. __( 'Settings', APPTHA_VGALLERY ) .'</a> 
    <a href="?page=googleadsense" class="nav-tab '. $gads .'">'. __( 'Google AdSense', APPTHA_VGALLERY ) .'</a> 
  </h2>'; 
}

/**
 * Fucntion to display status when action is done
 * 
 * @param string $displayMsg
 */
function displayStatusMeassage ( $displayMsg ) {
    /** Check meassage is received */
    if ( $displayMsg ) {
        /** Display the meassage and return */
        return '<div class="updated below-h2"> <p> '.  $displayMsg . '</p> </div>';
    }
}

/**
 * Function to display filter option in playlist / video ads and google adsense page
 * 
 * @param unknown $name
 * @param unknown $position
 * @return string
 */
function adminFilterDisplay ( $name,  $position ) {
  $content = '';   
  /** Set filter action name */
  $filterName   = $name . 'action' . $position;
  /** Set filter action publish name */
  $publishVal   = $name . 'publish';
  /** Set filter action unublish name */
  $unpublishVal = $name . 'unpublish';
  /** Set filter action delete name */
  $deleteVal    = $name . 'delete';
  /** Set apply button name */
  $applyName    = $name . 'apply';
  
  /** Check whether the page is google adsense page */
  $content = '<option value="' . $publishVal . '">' . __( 'Publish',APPTHA_VGALLERY) . '</option>
  <option value="' . $unpublishVal . '">'. __( 'Unpublish', APPTHA_VGALLERY ) .'</option>';
  
  /** Display filter option in plugin admin pages */ 
  return '<select name="' . $filterName .'" id="' . $filterName . '">
                  <option value="-1" selected="selected"> ' . __( 'Bulk Actions', APPTHA_VGALLERY ) . '</option>
                  <option value="' . $deleteVal . '">' . __( 'Delete', APPTHA_VGALLERY ) . '</option>'
                      . $content . '
                  </select> 
                  <input type="submit" name="' . $applyName . '"  class="button-secondary action" value="' . __( 'Apply', APPTHA_VGALLERY ) . '"> ';
} 
/**
 * Fucntion to get TouTube data from remote URL
 *
 * @param unknown $url
 * @return unknown
 */
function hd_getyoutubepage( $url ) {
  /** Get information from remote URL */
  $apidata = wp_remote_get($url);
  /** return fetched information */
  return wp_remote_retrieve_body($apidata);
}
/**
 * Video Detail Page action Ends Here
 *
 * Function for adding video ends
 *
 * @param unknown $youtube_media
 * @return void|unknown
 */
function hd_getsingleyoutubevideo( $youtube_media ) {
  /** Check YouTube video id is exist */
  if ( $youtube_media == '' ) {
    /** If not then return empty */
    return;
  }
  /** Get YouTube Api key form settings */
  $setting_youtube = getPlayerColorArray();
  $youtube_api_key = $setting_youtube['youtube_key']; 
  /** Check Api key is applied in settings */
  if( !empty($youtube_api_key)) {
    /** Get URL to get Youtube video details */
    $url = 'https://www.googleapis.com/youtube/v3/videos?id='.$youtube_media.'&part=contentDetails,snippet,statistics&key='.$youtube_api_key;
    /** Call function to get detila from the given URL */
    $video_details =  hd_getyoutubepage( $url ); 
    /** Decode json data and get details */
    $decoded_data = json_decode($video_details);
    /** return YouTube video details */
    return get_object_vars($decoded_data); 
  } else{
    /** If key is not applied, then dipslya error message */
    render_error( __( 'Could not retrieve Youtube video information. API Key is missing', APPTHA_VGALLERY ) );
  }
  exitAction ('');
}

/**
 * Function to set message starts
 *
 * @return multitype:string
 */
function set_message ( $type, $msg ) {
  /** Return status based on the performed action in all videos page */
  return $type . ' ' . $msg . ' '. __ ( 'Successfully ...', APPTHA_VGALLERY ) ;
}
?>