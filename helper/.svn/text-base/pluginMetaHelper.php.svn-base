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
 * Function definition to add og detail for facebook
 */
function add_meta_details() {
    global $wpdb;
    $tags_name = '';
    /** Get video id for meta details */
    $videoID  = pluginVideoID ();
    $output = '<script type="text/javascript">var baseurl = "' . site_url() . '";var adminurl = "' . admin_url() . '";</script>';
    /** If video is not empty then get video details */
    if (! empty ( $videoID )) {
        /** Get video details for given video id */
        $video_count  = videoDetails ( $videoID, '' );
        
        /** Check video details are exist */
        if (! empty ( $video_count )) { 
          /** Get video name  */
          $videoname    = $video_count->name;
          if(isset($video_count->tags_name)) {
            /** Get tags name  */
            $tags_name    = $video_count->tags_name;
          }
          /** Get swf file URL path  */
          $swfPath      = APPTHA_VGALLERY_BASEURL . 'hdflvplayer' . DS . 'hdplayer.swf';
          /** Get video page URL */
          $videoPageURL = get_video_permalink ( $video_count->slug );
          /** Get thumb description for og:description */
          $description      = get_bloginfo('name');
          if ($video_count->description) {
              $description  = $video_count->description;
          }
          /** Get rating value for rich snippet */
          $rateSnippet      = getRatingValue ( $video_count->rate, $video_count->ratecount, 'calc' );          
          /** Get thumb image for og:image */
          $imageFea         = getImagesValue ( $video_count->image, $video_count->file_type, $video_count->amazon_buckets, '');
          /** Check video url is YouTube */
          if (strpos ( $imageFea, 'youtube' ) > 0 || strpos ( $imageFea, 'ytimg' ) > 0) {
              /** Get YouTube video thumb image */
              $imgstr       = explode ( '/', $imageFea );
              $imageFea     = 'http://img.youtube.com/vi/' . $imgstr [4] . '/hqdefault.jpg';
          }    
          /** Add meta details in the page for current video */
          $output     .= '<meta name="description" content="' . strip_tags ( $description ) . '" />
              <meta name="keyword" content="' . $tags_name . '" />
              <link rel="image_src" href="' . $imageFea . '"/>
              <link rel="canonical" href="' . $videoPageURL . '"/>
              <meta property="og:image" content="' . $imageFea . '"/>
              <meta property="og:url" content="' . $videoPageURL . '"/>
              <meta property="og:title" content="' . $videoname . '"/>
              <meta property="og:description" content="' . strip_tags ( $description ) . '"/>
              <meta name="viewport" content="width=device-width"> ';    
          /** Check if SSL is enabled in site
           * If it is enbaled then add og:video, og:video:type, 
           * og:video:secure_url in meta details to play video in facebook */
          if (is_ssl () && $_SERVER ['SERVER_PORT'] == 443) {
            $output .= '<meta property="og:video:type" content="application/x-shockwave-flash" />
                <meta property="og:video" content="' . $swfPath . '?vid=' . $videoID . '&baserefW=' . APPTHA_VGALLERY_BASEURL . '&embedplayer=true" />
                <meta property="og:video:secure_url" content="' . $swfPath . '?vid=' . $videoID . '&baserefW=' . APPTHA_VGALLERY_BASEURL . '&embedplayer=true" />';
          }
          /** Set rich snippet details */        
          $output .= '<div id="video-container" class="" itemscope itemid="" itemtype="http://schema.org/VideoObject">';
          $output .= '<link itemprop="url" href="' . $videoPageURL . '"/>';
          $output .= '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
          $output .= '<meta itemprop="ratingValue" content="' . $rateSnippet . '"/>
                  <meta itemprop="ratingCount" content="' . $video_count->ratecount . '"/></div>
                  <div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
                  <meta itemprop="name" content="' . $videoname . '" />
                  <meta itemprop="thumbnail" content="' . $imageFea . '" />
                  <meta itemprop="description" content="' . strip_tags ( $description ) . '" />
              </div>
              <meta itemprop="image" content="' . $imageFea . '" />
              <meta itemprop="thumbnailUrl" content="' . $imageFea . '" />
              <meta itemprop="embedURL" content="' . $swfPath . '" />
              </div>';
        }
    }
    /** Display meta details */
    echo $output;
}
/**
 * Fucntion to include widget files
 *  
 * @param unknown $fileName
 */
function includeWidgetfiles ( $fileName ) {   
    /** Get widget path from template folder */
    $widgetPath           = get_template_directory () . '/html/widgets';
    /**
     * Check whether the widget file is exist in template
     * If exist the include files from template directory
     * Else include widget files from plugin root   
     */  
    if (file_exists ( $widgetPath . DS . $fileName )) {
      include_once ($widgetPath . DS . $fileName );
    } else {
      include_once ( APPTHA_VGALLERY_BASEDIR . DS . $fileName);
    }  
}
/**
 * Function to render error message
 * 
 * @param unknown $message
 */
function render_error($message) {
  /** Display error message */
  echo '<div class="wrap"> <h2>&nbsp;</h2> <div class="error" id="error"> <p> <strong>' . $message . '</strong> </p> </div></div>';
}
?>