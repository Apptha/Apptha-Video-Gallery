<?php
/**  
 * Video googleadsense view file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

$page = $adsense_code = $adsense_option = $adsense_reopen = $adsense_reopen_time = $adsenseshow_time = $adsense_status = $pageLinks = '';
/** Get google adsense page url */
$url  = get_site_url () . '/wp-admin/admin.php?page=googleadsense';
if (isset ( $_GET ['pagenum'] )) {
  $page = '&pagenum=' . $_GET ['pagenum'];
}
/** Get google adsense page url with page value */
$selfurl = get_site_url () . '/wp-admin/admin.php?page=googleadsense' . $page;
/** Display google adsense page starts */
?>
<div class="apptha_gallery">
<?php /** Call function to display admin tabs in playlist page */
      echo displayAdminTabs ( 'gads' ) ; ?>  
      <?php /** Display adsense page title and icon */ ?>
    <div class="wrap"> 
        <h2 class="option_title"> <?php echo '<img src="' . getImagesDirURL() .'google_adsense.png" alt="move" width="30"/>'; ?> 
            <?php esc_attr_e( 'Google AdSense', APPTHA_VGALLERY ); ?> 
            <a class="button-primary" href="<?php echo get_site_url() ; ?>/wp-admin/admin.php?page=addgoogleadsense">
            <?php esc_attr_e('Add New',APPTHA_VGALLERY);?></a> 
        </h2>
<?php /** Display status for the performed action */
    echo displayStatusMeassage ( $displayMsg );
    /** Get adsense page order filed, direction */
    $orderField = filter_input ( INPUT_GET, 'order' ); 
    $direction = isset ( $orderField ) ? $orderField : ''; 
    $reverse_direction = ($direction == 'DESC' ? 'ASC' : 'DESC'); 
    
    /** Check search button value is exists */
    if (isset ( $searchBtn )) { 
    /** Display search results message */ ?> 
          <div class="updated below-h2"> 
      <?php $url = get_site_url () . '/wp-admin/admin.php?page=videogoogleadsense'; 
          if (count ( $gridVideoad )) { 
            echo  count ( $gridVideoad ) . '    Search Result( s ) for "' . $searchMsg . '".&nbsp&nbsp&nbsp<a href="' . $url . '" >Back to Video Ads List</a>'; 
          } else { 
              echo 'No Search Result( s ) for "' . $searchMsg . '".&nbsp&nbsp&nbsp<a href="' . $url . '" >Back to Video Ads List</a>'; 
          } ?> 
          </div> 
<?php } 
      /** Display search form to search google adsense details */
?>   <form name="videoads" action="" method="post" class="admin_video_search alignright" onsubmit="return prodttagsearch();"> 
          <p class="search-box"> 
              <input type="text" name="videoadssearchQuery" id="videoadssearchQuery" value="<?php echo $searchMsg ; ?>"> 
              <?php echo '<script>document.getElementById( "videoadssearchQuery" ).value="' . $searchMsg . '"</script>'; ?> 
              <input type="hidden" name="page" value="videoads"> 
              <input type="submit" name="videoadsearchbtn" class="button" value="Search Google Ads"> 
          </p> 
      </form>
<?php /** Search form display ends */ ?>
      <form name="videogoogleadsfrm" action="" method="post" onsubmit="return VideogoogleaddeleteIds();"> 
          <?php /** Display filter option at top of the gid section */ ?>
          <div class="alignleft actions"> 
              <?php /** Call function to display filter option 
              * at top of the google adsense grid sction */
                    echo adminFilterDisplay ( 'videogooglead',  'up' ); ?> 
          </div> 
<?php /** Get values for pagination */
      $limit   = 20; 
      $pagenum  = absint ( filter_input ( INPUT_GET, 'pagnum' ) ); 
      if (empty ( $pagenum )) { 
        $pagenum = 1; 
      } 
      /** Get total adsense count */
      $total    = $videoad_count; 
      
      /** Get pagination from helper for google adsense grid view */
      echo paginateLinks ( $total, $limit, $pagenum, 'admin', '' );
      
      /** Set order by URL based on adsense id to order the google adsense data */
      $adIDURL  = get_site_url() .'/wp-admin/admin.php?page=googleadsense&orderby=id&order='. $reverse_direction ;
      /** Set order by URL based on adsense title to order the google adsense data */
      $titleURL = get_site_url() .'/wp-admin/admin.php?page=googleadsense&orderby=googleadsense_title&order='. $reverse_direction;
      /** Set order by URL based on adsense status to order the google adsense data */
      $statusURL = get_site_url() .'/wp-admin/admin.php?page=googleadsense&orderby=publish&order='. $reverse_direction;
      
      /** Display google adsense details in grid view */
      ?><div style="clear: both;"></div> 
              <table class="wp-list-table widefat fixed posts" cellspacing="0">
              <?php /** Display head title section starts */ ?> 
                  <thead> 
                      <tr>
                          <?php /** Display header adsense id section */ ?>
                          <th scope="col" class="manage-column column-cb check-column" style=""> <input type="checkbox" name="" id="manage-column-video-1"> </th> 
                          <th scope="col"  style="" class="manage-column column-id sortable desc">
                              <a href="<?php echo $adIDURL;?>"> 
                              <span><?php esc_attr_e( 'ID', APPTHA_VGALLERY ); ?>
                              </span><span class="sorting-indicator"></span></a>
                          </th> 
                          <?php /** Display header adsense title section */ ?>
                          <th scope="col" class="manage-column column-name sortable desc" style=""> 
                              <a href="<?php echo $titleURL; ?>"> 
                              <span><?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span></a>
                          </th> 
                          <?php /** Display header adsense status section */ ?>
                          <th style="" scope="col" class="manage-column column-publish sortable desc" >
                              <a href="<?php echo $statusURL; ?>">
                              <span><?php esc_attr_e( 'Publish', APPTHA_VGALLERY ); ?></span>
                              <span class="sorting-indicator"></span></a>
                          </th> 
                      </tr> 
                  </thead> 
                  <?php /** Display head title section ends */ 
                  /** Display footer title section starts */ ?>
                  <tfoot> 
                      <tr> 
                          <?php /** Display footer adsense checkbox section */ ?>
                          <th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" name="" id="manage-column-video-1"> </th> 
                          <?php /** Display footer adsense id section */ ?>
                          <th scope="col" class="manage-column column-id sortable desc" style="">
                              <a href="<?php echo get_site_url() ; ?>/wp-admin/admin.php?
                              page=videoads&orderby=id&order=<?php echo $reverse_direction ; ?>"> 
                              <span><?php esc_attr_e( 'ID', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> </a>
                          </th>
                          <?php /** Display footer adsense title section */ ?>
                          <th scope="col" class="manage-column column-name sortable desc"><a> <span><?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?></span> </a> </th>
                          <?php /** Display footer adsense publish section */ ?> 
                          <th scope="col" class="manage-column column-publish sortable desc" style="">
                              <a href="<?php echo  get_site_url(); ?>/wp-admin/admin.php?
                              page=googleadsense&orderby=publish&order=<?php echo $reverse_direction ; ?>">
                              <span><?php esc_attr_e( 'Publish', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> </a>
                          </th> 
                      </tr> 
                  </tfoot>
                   <?php /** Display footer title section ends */ 
                   /** Display adsense details body section starts */ ?>
                  <tbody id="the-list" class="list:tag"> 
               <?php /** Looping google adsense details to display in grid section */
                      foreach ( $gridVideoad as $videoAdview ) { 
                          /** unserialize adsense details */
                          $googleadsense_details = unserialize ( $videoAdview->googleadsense_details );
                          /** Get adsense title */
                          if (isset ( $googleadsense_details ['googleadsense_title'] )) { 
                            /** Check adsense title is exists */
                            $adsense_code = $googleadsense_details ['googleadsense_title']; 
                          }
                          /** Check adsense option is exists */
                          if (isset ( $googleadsense_details ['adsense_option'] )) {
                            /** Get adsense option */
                            $adsense_option = $googleadsense_details ['adsense_option'];
                          }
                          /** Check adsense reopen option exists */
                          if (isset ( $googleadsense_details ['adsense_reopen'] )) {
                            /** Get adsense reopen option */
                            $adsense_reopen = $googleadsense_details ['adsense_reopen'];
                          }
                          /** Check adsense reopen time is exists */
                          if (isset ( $googleadsense_details ['adsense_reopen_time'] )) {
                            /** Get adsense reopen time */
                            $adsense_reopen_time = $googleadsense_details ['adsense_reopen_time'];
                          }
                          /** Check adsense showtime is exists */
                          if (isset ( $googleadsense_details ['adsenseshow_time'] )) {
                            /** Get adsense showtime  */
                            $adsenseshow_time = $googleadsense_details ['adsenseshow_time'];
                          }
                          /** Check adsense status is exists */
                          if (isset ( $googleadsense_details ['publish'] )) {
                            /** Get adsense status  */
                            $adsense_status = $googleadsense_details ['publish'];
                          }
                          
                          /** Set image for publish / unpublish image  based on the value */
                          $image = 'deactivate.jpg';
                          if ($adsense_status == 1) {
                              $adsense_status = 0;
                              $image = 'activate.jpg';
                          } else {
                              $image = 'deactivate.jpg';
                              $adsense_status = 1;
                          } 
                          $gadsIDURL      = get_site_url() .'/wp-admin/admin.php?page=addgoogleadsense&videogoogleadId='. $videoAdview->id;
                          $gadsStatusURL  = get_site_url() .'/wp-admin/admin.php?page=addgoogleadsense&videogoogleadId='. $videoAdview->id . '&status=' .$adsense_status;
                          
                          /** Display google adsense data */?>
                      <tr> 
                          <?php /** Display checkbox for google adsense */?>
                          <th scope="row" class="check-column"><input type="checkbox" name="videogooglead_id[]" value="<?php echo  $videoAdview->id ; ?>"></th> 
                          <?php /** Display google adsense id */?>
                          <td class="column-id">
                              <a title="Edit <?php echo  $videoAdview->id ; ?>" 
                              href="<?php echo $gadsIDURL; ?>">
                              <?php echo $videoAdview->id; ?></a> 
                              <div class="row-actions">
                          </td> 
                          <?php /** Display google adsense code */?>
                          <td class="column-name"> 
                          <?php if (strlen ( $adsense_code ) > 50) {
                                  $adsense_code = substr ( $adsense_code, 0, 50 ) . '&hellip;';
                              } else {
                                  $adsense_code = $adsense_code;
                              } ?>
                              <a title="Edit <?php echo $videoAdview->id ; ?>" 
                              href="<?php echo $gadsIDURL; ?> ">
                              <?php echo $adsense_code; ?></a> 
                              <div class="row-actions"> 
                          </td> 
                          <?php /** Display google adsense status */?>
                          <td class="column-publish" id="videoad-publish-icon">
                              <a title="<?php if ( $adsense_status == 0 ) { 
                                  esc_attr_e( 'Unpublish' ); 
                              } else { 
                                  esc_attr_e( 'Publish' ); 
                              } ?>" 
                              href="<?php echo $gadsStatusURL; ?>"> 
                              <img src="<?php echo getImagesDirURL() . $image ?>" /> </a>
                          </td> 
                      </tr> <?php }
                      /**
                       * If adsense datials not exist, 
                       * then display not found message
                       */
                      if (count ( $gridVideoad ) == 0) { ?>
                      <tr class="no-items"> 
                          <td class="column-id"></td> 
                          <td class="colspanchange" colspan="3"><?php esc_attr_e('No Google AdSense Found.' , APPTHA_VGALLERY );?></td> 
                      </tr> 
                      <?php } ?> 
                  </tbody> 
              </table>
              <div style="clear: both;"></div>
              
              <?php /** Display filter option at end of the frid */ ?> 
              <div class="alignleft actions" style="margin-top: 10px;"> 
                  <?php /** Call function 
                     * to display filter option  
                     * at top of the google adsense grid sction */
                    echo adminFilterDisplay ( 'videogooglead',  'down' ); ?> 
              </div> 
       <?php /**
              * Display pagination dropdown 
              * at end of the gird  
              */
              echo paginateLinks ( $total, $limit, $pagenum, 'admin', '' ); ?> 
        </form> 
    </div> 
<?php /** Display google adsense page ends */ ?>
</div>