<?php
/**
 * Wordpress video gallery plugin helper file.
* @category   Apptha
* @package    Contus video Gallery
* @version    2.9
* @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
* @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
*/

/**
 * Funtion to perform exit action
 * 
 * @param unknown $exitmsg
 */
function exitAction($exitmsg) {
    exit($exitmsg);  
}
/**
 * Funtion to define constant
 * 
 * @param unknown $vgConstantName
 * @param unknown $vgConstantValue
 */
function defineAction($vgConstantName, $vgConstantValue ) {
    /** Define the given constant name with the value */ 
    DEFINE($vgConstantName, $vgConstantValue);
}
/**
 * Funtion to get plugin folder name
 * 
 * @return Ambigous <>
 */
function getPluginFolderName () {
    /** Get plugin directory path */
    $dir           = dirname ( plugin_basename ( __FILE__ ) );
    /** Explode plugin name with the slash */ 
    $dirExp        = explode ( '/', $dir );
    /** return plugin folder name */
    return $dirExp [0];
}
/**
 * Funtion to get upload directory URL
 * 
 * @return string
 */
function getUploadDirURL() {
  /** Get WordPress upload directory URL */
    $upload_dir     = wp_upload_dir ();  
    /** Get "videogallery" directory URL */
    return $upload_dir ['baseurl'] . DS . 'videogallery' . DS;    
}
/**
 * Funtion to get upload directory path
 * 
 * @return string
 */
function getUploadDirPath() {
  /** Get uploads directory path */
  $upload_dir = wp_upload_dir ();
  /** Get "videogallery" directory path */
  return  $upload_dir ['basedir'] . DS . 'videogallery' . DS;
}
/**
 * Funtion to get plugin images directory URL
 * 
 * @return string
 */
function getImagesDirURL() {
    /** Return imgaes directory URL */ 
    return APPTHA_VGALLERY_BASEURL . 'images' . DS;
}
/**
 * Function to set xml header for player xml files.
 */
function xmlHeader () {
    /** Clear page */
    ob_clean ();
    /** Set XML content type */
    header ( 'content-type:text/xml;charset = utf-8' );
}
/**
 * Function to check whether SSL is enabled.
 * Based on that it returns protocol
 * 
 * @return string
 */ 
function getPluginProtocol() {
    /** Set default protocol as http */
    $protocolURL = 'http://';
    /** Check SSL is enabled */
    if (is_ssl ()) {
      /** If ssl is enabled, then set protocol as https */
      $protocolURL = 'https://';
    }  
    /** Return protocol value */
    return $protocolURL;
}
/**
 * Function to limit title, if it exceeds 30 character
 * Else display full title
 * 
 * @param unknown $title
 * @return Ambigous <string, unknown>
 */
function limitTitle ( $title ) {
  /** Get title from argument */
  $fullTitle = $title;
  /** check title character length exceeds 30 */
  if (strlen ( $title ) > 30) {
    /** If exceeds, the find substring upto 30 characters */
    $fullTitle = substr ( $title, 0, 30 ) . '..';
  }
  /** Return title */
  return $fullTitle;
}
/**
 * Fucntion to generate pagination values
 * 
 * @param unknown $total
 * @param unknown $limit
 * @param unknown $pageNum
 * @param unknown $type
 * @param unknown $params
 * @return string
 */
function paginateLinks ( $total, $limit, $pageNum, $type, $params ) {
    /** Set aruments for pagination */
    $argParams = add_query_arg ( 'pagenum', '%#%' );
    if( !empty($params)) {
      $argParams = add_query_arg ( $params ) ;
    } 
    /** Get number of pages */
    $numOfPages = ceil ( $total / $limit );
    /** Get pagination values */
    $pageLinks   = paginate_links (
        array ( 'base' => $argParams, 'format' => '', 'prev_text' => __ ( '&laquo;', 'aag' ),
          'next_text' => __ ( '&raquo;', 'aag' ), 'total' => $numOfPages, 'current' => $pageNum )
    );
    /** Check type is admin */
    $styleAdmin = '';
    if ($type == 'admin') {
      /** If type is admin, then apply css */
      $styleAdmin = 'style="margin: 1em 0"';
    }
    /** Check pagination value is exist */
    if ($pageLinks) {
        /** Return pagination values */
       return '<div class="tablenav"><div class="tablenav-pages" ' . $styleAdmin . ' >' . $pageLinks . '</div></div>';
    }
}
/**
 * Fcuntion to get video order from settings
 * 
 * @param unknown $recent_video_order
 * @return string
 */
function getVideoOrder ( $recent_video_order ) {
    /** Check recent video order type */
    switch ($recent_video_order){
      case 'hitcount': 
        /** Set thumb image order based on hicount */
        $thumImageorder = ' w.' . $recent_video_order . ' DESC '; 
        break; 
      case 'default':
        /** Set thumb image order based on ordering */
        $thumImageorder = ' w.ordering ASC ';
        break;
      case 'id': 
      default:
        /** Set thumb image order based on id */
        $thumImageorder   = ' w.vid DESC ';
        break;
    }
    /** Return thumb image order */
    return $thumImageorder;  
}
/**
 * Get rate count and calculate rate snippet and display if needs
 * 
 * @param unknown $rate
 * @param unknown $rateCount
 * @param unknown $action
 * @return number|string
 */
function getRatingValue ( $rate, $rateCount, $action ) {    
    $rateSnippet     = 0 ;
    /** Check rate and ratecount is exist */
    if (!empty($rate) && !empty($rateCount)) {
      /** If exist then calculate rateings value */
      $rateSnippet = round ( $rate / $rateCount );
    }
    /** Check action is calc */
    if ($action == 'calc') {
      /** If yes, then return ratings value alone */
      return $rateSnippet;
    } else {      
      /** Define rate star postions */
      $ratearray = array ( 'nopos1', 'onepos1', 'twopos1', 'threepos1', 'fourpos1', 'fivepos1' );
      /** Else display ratings value and return */
      return '<span class="ratethis1 ' . $ratearray [$rateSnippet] . '"></span>';
    }    
}

/**
 * Get views count and display it
 * 
 * @param unknown $hitCount
 * @return string
 */
function displayViews ( $hitCount ) {
    /** Defind language text for views, view text */
    $viewsLang      = __ ( 'Views', APPTHAVIDEOGALLERY );
    $viewLang       = __ ( 'View', APPTHAVIDEOGALLERY );
    /** Set view text as default */
    $viewlangText   = $viewLang;
    /** Check views count is grater than 1 */
    if ($hitCount > 1) {
      /** Set views text if count is  > 1 */
      $viewlangText = $viewsLang;
    }
    /** Return views display */
    return '<span class="video_views">' . $hitCount . '&nbsp;' . $viewlangText . '</span>';
}
/**
 * Fucntion to set image value based on file types
 * 
 * @param unknown $image
 * @param unknown $file_type
 * @param unknown $amazonBucket
 * @param unknown $type
 * @return Ambigous <string, unknown>
 */
function getImagesValue ( $image, $file_type, $amazonBucket, $type) {
    /** Get videogallery plugin images directoy path */
    $imagePath    = getImagesDirURL ();
    /** Get videogallery plugin upload directory path */
    $uploadPath   = getUploadDirURL ();
    /** GEt image name */
    $imageFileURL = $image;    
    /** If type is 1 then set defult image for preview image
     * Else set thumb defualt */
    if($type == 1) {
      $imageDefault  = $imagePath . 'noimage.jpg';
    } else {
      $imageDefault  = $imagePath . 'nothumbimage.jpg';
    }    
    /** If there is no thumb image for video */
    if ( $imageFileURL == '' ) {
        /** Set default image as thumb image */
        $imageFileURL    = $imageDefault;
    } else {
        /** Check file type is 2 or 5 */
        if ($file_type == 2 || $file_type == 5) {
            /**
             * Get thumb image full uploaded path 
             */
            $imageFileURL = $uploadPath . $imageFileURL;            
            /** For Amazon S3 Buckets images */
            if ($amazonBucket && strpos ( $image , '/' )) {
                /** Get thumb image bucket URL */
                $imageFileURL = $image;
            } 
        } 
    }    
    /** Return thumb image URL */
    return $imageFileURL ;
}
/**
 * Fucntion to set video, hdvideo value based on file types
 * 
 * @param unknown $videoFile
 * @param unknown $file_type
 * @param unknown $amazonBucket
 * @return Ambigous <string, unknown>
 */
function getVideosValue ( $videoFile, $file_type, $amazonBucket ) {
   /** Get upload directory URL */
    $uploadPath   = getUploadDirURL ();
    $videoFileURL = $videoFile;
    /** Check video file type is 2 */
    if ( $videoFileURL != '' && $file_type == 2 ) {
        /** Get video file uploaded path */
        $videoFileURL   = $uploadPath . $videoFile;
        /** Check bucket URL is exist */
        if ($amazonBucket && strpos ( $videoFile , '/' )) {
            /** Get bucket video URL */
            $videoFileURL = $videoFile;
        }
    }
    /** Return video URL */
    return $videoFileURL ;
}
/**
 * Detect mobile device
 * 
 * @return boolean
 */
function vgallery_detect_mobile() {
  /** Get protocol */
  $_SERVER ['ALL_HTTP'] = isset ( $_SERVER ['ALL_HTTP'] ) ? $_SERVER ['ALL_HTTP'] : '';
  $mobile_browser       = '0';
  /** Get user agent name */
  $agent                = strtolower ( $_SERVER ['HTTP_USER_AGENT'] );
  if (preg_match ( '/( up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom )/i', $agent )) {
    $mobile_browser ++;
  }
  if ((isset ( $_SERVER ['HTTP_ACCEPT'] )) && (strpos ( strtolower ( $_SERVER ['HTTP_ACCEPT'] ), 'application/vnd.wap.xhtml+xml' ) !== false)) {
    $mobile_browser ++;
  }
  if (isset ( $_SERVER ['HTTP_X_WAP_PROFILE'] )) {
    $mobile_browser ++;
  }
  if (isset ( $_SERVER ['HTTP_PROFILE'] )) {
    $mobile_browser ++;
  }
  /** Find substring in the user agent name*/
  $mobile_ua      = substr ( $agent, 0, 4 );
  /** Store available mobile user agent prefix in an array */
  $mobile_agents  = array ( 'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac', 'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco',
    'eric', 'hipt', 'inno', 'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-', 'maui', 'maxo', 'midp', 'mits',
    'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-', 'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox', 'qwap',
    'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar', 'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo',
    'teli', 'tim-', 'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp', 'wapr', 'webc', 'winw', 'xda', 'xda-'
  );
  /** Check the current user agen name is exist in the user agent array */
  if (in_array ( $mobile_ua, $mobile_agents )) {
    $mobile_browser ++;
  }
  if (strpos ( strtolower ( $_SERVER ['ALL_HTTP'] ), 'operamini' ) !== false) {
    $mobile_browser ++;
  }
  /** Pre-final check to reset everything if the user is on Windows */
  if (strpos ( $agent, 'windows' ) !== false) {
    $mobile_browser = 0;
  }
  /** But WP7 is also Windows, with a slightly different characteristic */
  if (strpos ( $agent, 'windows phone' ) !== false) {
    $mobile_browser ++;
  }
  /** If agent is detected then return true */
  if ($mobile_browser > 0) {
    return true;
  } 
  else {
  	return false;
  }
}
/**
 * Fucntion to remove script, embed, styles, object and html tags code in given text
 *
 * @param  string $text
 * @return string
 */
function strip_html_tags( $text ) {
  /** Remove invisible content
   * 
   * Add line breaks before and after blocks */
  $text = preg_replace( array('@<head[^>]*?>.*?</head>@siu','@<style[^>]*?>.*?</style>@siu','@<script[^>]*?.*?</script>@siu','@<object[^>]*?.*?</object>@siu',
    '@<embed[^>]*?.*?</embed>@siu','@<applet[^>]*?.*?</applet>@siu','@<noframes[^>]*?.*?</noframes>@siu','@<noscript[^>]*?.*?</noscript>@siu','@<noembed[^>]*?.*?</noembed>@siu',
    '@</?((address)|(blockquote)|(center)|(del))@iu','@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu','@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu','@</?((table)|(th)|(td)|(caption))@iu',
    '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu','@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu','@</?((frameset)|(frame)|(iframe))@iu'),
      array(' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0","\n\$0", "\n\$0",),$text );
  return strip_tags( $text );
}

/**
 * Function to get Youtube Video ID from the given youtube video URL
 * 
 * @param unknown $text
 * @return mixed
 */
function getYoutubeVideoID ( $text ) {
  /**
   * Match non-linked youtube URL in the wild. (Rev:20130823)
   * 
   * Required scheme. Either http or https.
   * Optional subdomain.
   * Group host alternatives.
   * Either youtu.be,
   * or youtube.com or
   * youtube-nocookie.com
   * followed by
   * Allow anything up to VIDEO_ID,
   * but char before ID is non-ID char.
   * End host alternatives.
   * $1: VIDEO_ID is exactly 11 chars.
   * Assert next char is non-ID or EOS.
   * Assert URL is not pre-linked.
   * Allow URL (query) remainder.
   * Group pre-linked alternatives.
   * Either inside a start tag,
   * or inside <a> element text contents.
   * End recognized pre-linked alts.
   * End negative lookahead assertion.
   * Consume any URL (query) remainder.
   */
    return preg_replace('~https?://(?:[0-9A-Z-]+\.)?(?:youtu\.be/| youtube(?:-nocookie)?\.com\S*[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:[\'"][^<>]*>| </a>))[?=&+%\w.-]*~ix', '$1', $text);
}
/**
 * Function to get dailymotion Video ID from the given video URL
 * 
 * @param unknown $text
 * @return multitype:
 */
function getDailymotionVideoID ( $text ) {
  /** Explode dailymotion video url with slash */
  $split      = explode ( '/', $text );
  /** Return dailymotion vieo id */
  return  explode ( '_', $split [4] );
}
/**
 * Function to get video duration using ffmpeg option
 * 
 * @param unknown $ffmpeg_path
 * @param unknown $videoFile
 * @return multitype:unknown number
 */
function getVideoDuration ( $ffmpeg_path, $videoFile ) {
  /** Get duration from video using ffmpeg option */
  ob_start ();
  /** Execute code to get duration using ffmpeg */
  passthru ( $ffmpeg_path . ' -i "' . $videoFile . '" 2>&1' );
  /** Get contents */
  $get_duration   = ob_get_contents ();
  ob_end_clean ();
  /** Preg match video duration and get results */
  $search         = '/Duration: (.*?),/';
  $duration       = preg_match ( $search, $get_duration, $matches, PREG_OFFSET_CAPTURE, 3 );
  /** Return video duration and matches */
  return array( $duration, $matches );
}
?>