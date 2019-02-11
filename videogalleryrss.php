<?php
/**
 * Rss admin-ajax  file
 * 
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Include plugin configuration file */
require_once (dirname ( __FILE__ ) . '/hdflv-config.php');
/** Variable Initialization for rss feed */
$where      = $tag_name = $vid = '';
$dataLimit  = 1000;
/** Get "uploads/videogallery" URL for rss feed*/
$uploadPath = getUploadDirURL();
/** Get images folder URL */
$_imagePath = getImagesDirURL();
/** Get task parameter from request */
$type       = filter_input ( INPUT_GET, 'task' );
/** Get vid parameter from request */
$vid        = intval(filter_input ( INPUT_GET, 'vid' ));
/** Create object for ContusVideoController class */
$contusOBJ  = new ContusVideoController ();
/** Check type vlaue and get relevant data from db */
switch ($type) {
    case 'recent' :
      /** Set thumb image order to fetch recent videos */
      $thumImageorder = ' w.vid DESC ';
      /** Get video detials for recent videos to generate feed */
      $TypeOFvideos   = $contusOBJ->home_thumbdata ( $thumImageorder, $where, $dataLimit );
      break;  
    case 'featured' :
      /** Set thumb image order and condition to fetch featured videos
       * Get video detials for featured videos to generate feed */
      $thumImageorder = ' w.ordering ASC ';
      $where          = ' AND w.featured=1 ';      
      $TypeOFvideos   = $contusOBJ->home_thumbdata ( $thumImageorder, $where, $dataLimit );
      break;
    case 'category' :
      /** Set thumb image order to fetch category videos */ 
      $pid = intval ( filter_input ( INPUT_GET, 'playid' ) );
      if ( !empty ($pid) ) {     
        $where = $pid ;
      }
      /** Get video detials for category videos to generate feed */
      $TypeOFvideos   = $contusOBJ->home_catthumbdata ( $where, $dataLimit );
      break;
    case 'video' :
      /** Set thumb image order and condition to fetch particular video details
       * Get video detials for particular video to generate feed */
      $thumbImageorder = ' w.vid ASC ';
      if ( !empty ($vid) ) {
        $where           = ' AND w.vid = ' . $vid;
      }      
      $TypeOFvideos = $contusOBJ->home_thumbdata ( $thumbImageorder, $where, $dataLimit );
      break;
    case 'popular' :
    default :
        /** Set thumb image order to fetch popular videos  
         * Get video detials for particular video to generate feed */
        $thumImageorder = ' w.hitcount DESC ';        
        $TypeOFvideos   = $contusOBJ->home_thumbdata ( $thumImageorder, $where, $dataLimit );
        break;
}

/** Check feed details are exist */
if(!empty($TypeOFvideos)) {
/** Call header function to set content type ,charset */
header ( 'Content-Type: ' . feed_content_type ( 'rss-http' ) . '; charset=' . get_option ( 'blog_charset' ), true );
/** Set XML version and other namesapce  */
echo '<?xml version="1.0" encoding="' . get_option ( 'blog_charset' ) . '"?' . '>';
/** RSS feed XML content starts */
?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/"
      xmlns:wfw="http://wellformedweb.org/CommentAPI/" 
      xmlns:dc="http://purl.org/dc/elements/1.1/" 
      xmlns:atom="http://www.w3.org/2005/Atom" 
      xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" 
      xmlns:slash="http://purl.org/rss/1.0/modules/slash/" 
      xmlns:media="http://search.yahoo.com/mrss/" 
      xmlns:gd="http://schemas.google.com/g/2005" 
      xmlns:yt="http://gdata.youtube.com/schemas/2007" 
      <?php do_action( 'rss2_ns' ); ?>> 
    <channel>
        <title> <?php bloginfo_rss ( 'name' ); 
        wp_title_rss ();  ?> </title>
        <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
        <link> <?php bloginfo_rss( 'url' ) ?> </link>
        <description> <?php bloginfo_rss( 'description' ) ?> </description>
        <lastBuildDate> <?php echo mysql2date( 'D, d M Y H:i:s +0000', get_lastpostmodified( 'GMT' ), false ); ?> </lastBuildDate>
        <language> <?php bloginfo_rss( 'language' ); ?> </language>
        <sy:updatePeriod> <?php echo apply_filters( 'rss_update_period', 'hourly' ) ; ?> </sy:updatePeriod>
        <sy:updateFrequency> <?php echo apply_filters( 'rss_update_frequency', '1' ) ; ?> </sy:updateFrequency>
    <?php do_action( 'rss2_head' ); 
              /** Looping through rss feed details */
              foreach ( $TypeOFvideos as $media ) {
                    /** Get file type for feed data */
                    $file_type  = $media->file_type;
                    /** Get file for feed data */
                    $videoUrl   = $media->file;
                    /** Get hitcount for feed data */
                    $views      = $media->hitcount;
                    /** Get post date for feed data */
                    $post_date  = $media->post_date;
                    /** Get video id for feed data */
                    $media_id   = $media->vid;
                    /** Check tags name are exist */
                    if (! empty ( $media->tags_name )) {
                      /** Get tags name for feed data */
                      $tag_name = $media->tags_name;
                    }
                    /** Get thumb image detail for feed */
                    $image      = getImagesValue ( $media->image, $file_type, $media->amazon_buckets, '');
                    /** Check video url is exist and file type is 2 */
                    if ($videoUrl != '' && $file_type == 2) {
                        /** Get video url detail for feed */
                        $videoUrl = $uploadPath . $videoUrl;
                    }
                    /** Display each video item result */ ?>
          <item>
                    <title> <?php echo  get_the_title( $media_id ); ?> </title>
                    <link> <?php echo get_permalink( $media_id ) ; ?> </link> 
                    <dc:creator> <![CDATA[ <?php echo strip_tags($media->display_name); ?> ]]> </dc:creator>
                    <media:group>
                        <media:category/>
                        <media:content url="<?php echo $videoUrl ; ?>" type="application/x-shockwave-flash" medium="video" isDefault="true" expression="full" />
                        <media:description type="plain" />
                        <media:keywords/>
                        <media:thumbnail url="<?php echo $image ; ?>"/>
                    </media:group>
                    <guid isPermaLink="false"><?php echo  get_permalink( $media_id ) ; ?></guid>
                    <description> <![CDATA[ <img src ="<?php echo $image ; ?>"/>
                    <?php echo strip_html_tags( $media->description); ?> ]]></description>
                    <pubDate><?php echo  $post_date ; ?></pubDate>
                    <category><?php echo strip_tags($media->playlist_name); ?></category>
                </item>          
    <?php  /** Looping through rss feed details ends */ 
        }
       /** Rss feed ends */?>
    </channel> 
</rss>
<?php } else {  
  /** If empty feed data is found then display message */
  echo 'Feed not found for the given URL';  
} ?> 