<?php
/**
 * Video ad view file.
 * 
 *  @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
$imaadpath = $videoAdFile = '';
/** Display video ads page starts */
?>
<div class="apptha_gallery">
<?php /** Call function to display admin tabs in playlist page */
echo displayAdminTabs ( 'ads' );
/** Display video ads page title and icon */
?> 
    <div class="wrap"> 
        <h2 class="option_title"> <?php echo '<img src="' .getImagesDirURL() .'vid_ad.png" alt="move" width="30"/>'; ?> 
        <?php esc_attr_e( 'Manage Video Ads', APPTHA_VGALLERY ); ?> 
        <a class="button-primary" href="<?php echo  get_site_url() ; ?>/wp-admin/admin.php?page=newvideoad">Add New</a> 
        </h2>
<?php /** Display video ads status */
        echo displayStatusMeassage ( $displayMsg );
        /** Get order direction,order fields for video ads page */
        $orderField         = filter_input ( INPUT_GET, 'order' ); 
        $direction          = isset ( $orderField ) ? $orderField : ''; 
        $reverse_direction  = ($direction == 'DESC' ? 'ASC' : 'DESC');
        /** Check search action is done in vidoe ads page */ 
        if (isset ( $searchBtn )) { 
        /** Display video ads search results */ ?> 
        <div class="updated below-h2"> <?php $url = get_site_url () . '/wp-admin/admin.php?page=videoads'; 
            if (count ( $gridVideoad )) { 
                echo balanceTags ( count ( $gridVideoad ) ) . '    Search Result( s ) for "' . $searchMsg . '".&nbsp&nbsp&nbsp<a href="' . $url . '" >Back to Video Ads List</a>'; 
            } else { 
                echo 'No Search Result( s ) for "' . $searchMsg . '".&nbsp&nbsp&nbsp<a href="' . $url . '" >Back to Video Ads List</a>'; 
            } ?> 
        </div> 
  <?php } 
        /** Display video ads search form starts */ ?> 
        <form name="videoads" action="" method="post" class="admin_video_search alignright" onsubmit="return prodttagsearch();"> 
            <p class="search-box"> <input type="text" name="videoadssearchQuery" id="videoadssearchQuery" value="<?php echo $searchMsg; ?>"> 
            <?php echo '<script>document.getElementById( "videoadssearchQuery" ).value="' . $searchMsg . '"</script>'; ?> 
            <input type="hidden" name="page" value="videoads"> 
            <input type="submit" name="videoadsearchbtn" class="button" value="Search Ads"> 
            </p> 
        </form> 
        <?php /** Display video ads search form ends */  
        /** Form to display video ads details */ ?>
        <form name="videoadsfrm" action="" method="post" onsubmit="return VideoaddeleteIds()"> 
            <div class="alignleft actions"> 
            <?php /**
                   * Call function 
                   * to display filter option 
                   * at top of the google adsense grid sction   
                   */
                echo adminFilterDisplay ( 'videoad',  'up' ); ?>
            </div> 
            <?php /** Get page num, video ads count */ ?>
            <?php $limit  = 20; 
            $pagenum      = isset ( $_GET ['pagenum'] ) ? absint ( $_GET ['pagenum'] ) : 1; 
            $total        = $videoad_count;
            /** Get pagination from helper for video ads grid view */
            echo paginateLinks ( $total, $limit, $pagenum, 'admin', '' );
            
            /** Set URL based on ads id to order the video ad details in grid section */
            $AdsIdURL = get_site_url () . '/wp-admin/admin.php?page=videoads&orderby=id&order= ' . $reverse_direction;
            /** Set URL based on ads title to order the video ad details in grid section */
            $AdsTitleURL = get_site_url () . '/wp-admin/admin.php?page=videoads&orderby=title&order=' . $reverse_direction;
            /** Set URL based on ads path to order the video ad details in grid section */
            $AdsPathURL = get_site_url () . '/wp-admin/admin.php?page=videoads&orderby=path&order=' . $reverse_direction;
            /** Set URL based on ads status to order the video ad details in grid section */
            $AdsStatusURL = get_site_url () . '/wp-admin/admin.php?page=videoads&orderby=publish&order=' . $reverse_direction;  ?> 
            <div style="clear: both;"></div> 
                <table class="wp-list-table widefat fixed tags" cellspacing="0">
                    <?php /** Display header video ads title section starts */ ?> 
                    <thead> 
                        <tr> 
                            <?php /** Display checkbox for video ads */ ?>
                            <th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" name="" id="manage-column-video-1"></th> 
                            <?php /** Display ad id for video ads */ ?>
                            <th scope="col" class="manage-column column-id sortable desc" style=""><a href="<?php echo $AdsIdURL; ?>"> 
                                <span><?php esc_attr_e( 'Ad ID', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span> </a></th>
                            <?php /** Display video ads title column */ ?> 
                            <th style="" scope="col" class="manage-column column-name sortable desc"><a href="<?php echo $AdsTitleURL; ?>"> 
                                <span> <?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?></span> 
                                 <span class="sorting-indicator"></span> </a></th> 
                            <?php /** Display video ads url column */ ?>
                            <th class="manage-column column-path sortable desc" scope="col" style="">
                                  <a href="<?php echo $AdsPathURL ; ?>">
                                  <span><?php esc_attr_e( 'Path', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> </a></th>
                            <?php /** Display video ads type column */ ?> 
                            <th scope="col" style="" class="manage-column column-type sortable desc"><a><span><?php esc_attr_e( 'Ad Type', APPTHA_VGALLERY ); ?></span></a> </th> 
                            <?php /** Display video ads method column */ ?>
                            <th scope="col" class="manage-column column-admethod sortable desc" style=""><a><span><?php esc_attr_e( 'Ad Method', APPTHA_VGALLERY ); ?></span></a> </th>
                            <?php /** Display video ads status column */ ?> 
                            <th scope="col" style="" class="manage-column column-publish sortable desc"><a href="<?php echo  $AdsStatusURL; ?>"> 
                                  <span><?php esc_attr_e( 'Publish', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> </a></th> 
                        </tr>
                    </thead> 
                    <?php /** Display header video ads title section ends */
                    /** Display body of the video ads pages */  ?>
                    <tbody id="the-list" class="list:tag"> 
             <?php /** Looping througn video ad details */
                    foreach ( $gridVideoad as $videoAdview ) { 
                        /** Get ads id edit url */
                        $adIDURL = get_site_url() .'/wp-admin/admin.php?page=newvideoad&videoadId='. $videoAdview->ads_id; ?>
                        <?php /** Display video ads checkbox */ ?>
                        <tr> <th scope="row" class="check-column"><label class="screen-reader-text" for="cb-select-<?php echo $videoAdview->ads_id ; ?>">Select 
                              <?php echo  ucfirst( $videoAdview->title); ?></label> <input type="checkbox" name="videoad_id[]" 
                              value="<?php echo $videoAdview->ads_id; ?>"></th>
                          <?php /** Display video ads id column value */ ?>     
                          <td class="column-id"><a title="Edit <?php echo ucfirst( $videoAdview->title ); ?>" 
                              href="<?php echo $adIDURL; ?>">
                              <?php echo $videoAdview->ads_id; ?></a> <div class="row-actions"></td> 
                          <?php /** Display video ads title column value */ ?> 
                          <td class="column-title"><a title="Edit <?php echo ucfirst( $videoAdview->title  ); ?>" class="row-title" 
                              href="<?php echo $adIDURL; ?>">
                              <?php echo $videoAdview->title; ?></a> 
                          </td>
                          <?php /** Display video ads url column value */ ?>  
                          <td class="column-path"> <?php /** Check video url is exceeds 40 character */ 
                          
                                    /** If video ad is ima ad,  display ima ad details */
                                    if ($videoAdview->admethod == 'imaad') { 
                                        if (strlen ( $videoAdview->imaadpath ) > 40) { 
                                            $imaadpath = substr ( $videoAdview->imaadpath, 0, 40 ) . '&hellip;'; 
                                        } else { 
                                            $imaadpath = $videoAdview->imaadpath; 
                                        }
                                        echo $imaadpath; 
                                    } else {
if (strlen ( $videoAdview->file_path ) > 40) {
  $videoAdFile = substr ( $videoAdview->file_path, 0, 40 )  . '&hellip;';
} else {
  $videoAdFile =  $videoAdview->file_path ;
}
echo $videoAdFile; 
}
?> </td> 
                                 <?php /** Set image based on status value */ 
                                 $status = 1; 
                                       $image = 'deactivate.jpg'; 
                                       $publish = 'Publish'; 
                                       if ($videoAdview->publish == 1) { 
                                          $status = 0; 
                                          $image = 'activate.jpg';
                                          $publish = 'Unpublish';
                                        } 
                                        /** Display ads type */
                                        ?> 
                            <td class="column-type videoadmethod"><?php  if( $videoAdview->admethod =='prepost') { 
                              echo 'Pre/Post-roll Ad'; 
                            } else if( $videoAdview->admethod =='midroll' ) { 
                              echo 'Mid-roll Ad';  
                            } else if($videoAdview->admethod =='imaad' ) { 
                              echo 'IMA Ad '; 
                            }  else {
                               echo '';
                            } ?> 
                            </td> 
                            <?php /** Display adstype */ ?>
                            <td class="column-admethod"> <?php if ( $videoAdview->admethod != 'midroll' ) { 
                              echo $videoAdview->adtype ; 
                            } ?> </td> 
                            <?php /** Display video ads status column */  ?>
                            <td class="column-publish" id="videoad-publish-icon"><a href="<?php 
                                $publishURL = get_site_url() .'/wp-admin/admin.php?page=videoads&videoadId=' . $videoAdview->ads_id . '&status=' . $status;
                                echo $publishURL; ?>"> 
                                <img src="<?php echo getImagesDirURL() . $image ?>" 
                                title="<?php echo $publish; ?>" /> </a></td> 
                      </tr> <?php 
                      /** For each lopping ends for video ads */
                      } 
                      if (count ( $gridVideoad ) == 0) { 
                      /** If count is 0, then display no video found message */?> 
                      <tr class="no-items">  <td class="colspanchange" colspan="5">No video ad found.</td> </tr> 
                      <?php } ?> 
                  </tbody> 
                  <?php /** Display video ads body section ends */ 
                  /** Display video ads footer section starts */ 
                  /** Display footer checkbox column */ ?> 
                  <tfoot> <tr> <th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" name="" id="manage-column-video-1"></th>
                          <?php /** Display footer video ads id column */ ?>  
                          <th scope="col" class="manage-column column-id sortable desc" style=""><a href="<?php echo $AdsIdURL; ?>"> 
                              <span><?php esc_attr_e( 'Ad ID', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> </a></th> 
                          <?php /** Display footer video ads title column */ ?>
                          <th scope="col" class="manage-column column-name sortable desc" style="">
                              <a href="<?php echo $AdsTitleURL; ?>">
                              <span><?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?></span> 
                              <span class="sorting-indicator"></span> </a></th>
                          <?php /** Display footer video ads path column */ ?>
                          <th scope="col"  style="" class="manage-column column-path sortable desc"><a href="<?php echo $AdsPathURL;?>"> 
                              <span><?php esc_attr_e( 'Path', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> </a></th>
                          <?php /** Display footer video ads type column */ ?> 
                          <th scope="col" class="manage-column column-adtype sortable desc" style=""><a><span><?php esc_attr_e( 'Ad Type', APPTHA_VGALLERY ); ?></span></a> </th>
                          <?php /** Display footer video ads method column */ ?> 
                          <th scope="col" class="manage-column column-admethod sortable desc" style=""><a><span><?php esc_attr_e( 'Ad Method', APPTHA_VGALLERY ); ?></span></a> </th>
                          <?php /** Display footer video ads status column */ ?> 
                          <th scope="col" class="manage-column column-publish sortable desc" style=""> <a href="<?php echo $AdsStatusURL; ?>"> 
                              <span><?php esc_attr_e( 'Publish', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> </a></th> 
                          </tr 
                 </tfoot> 
                 <?php /** Display video ads footer section starts */ ?>
            </table>
            <div style="clear: both;"></div> 
            <div class="alignleft actions" style="margin-top: 10px;"> 
            <?php /**
                   * Call function to display
                   * filter option at top of the 
                   * google adsense grid sction   
                   */
                  echo adminFilterDisplay ( 'videoad',  'down' ); ?> 
            </div> 
      <?php /** pagination dropdown at end of the gird */
            echo paginateLinks ( $total, $limit, $pagenum, 'admin', '' ); ?> 
       </form> 
    </div> 
<?php /** Display video ads id section ends */ ?>
</div>