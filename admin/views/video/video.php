<?php
/**
 * Video gallery admin video view file
 * All Video manage admin page  
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Creating object for VideosSubController class */
$videoOBJ         = new VideosSubController ();
/** Call function to add videos data  */
$videoOBJ->add_newvideo ();
/** Assign class variables into local variables */
$videoId          = $videoOBJ->_videoId;
$videosearchQuery = $videoOBJ->_videosearchQuery;
$searchBtn        = $videoOBJ->_searchBtn;
$searchMsg        = $videoOBJ->_videosearchQuery;
$settingsGrid     = $videoOBJ->_settingsData;
/** Call function to get message for the corresponding action */
$displayMsg = $videoOBJ->get_message ();
/** Call function to delete videos data */
$videoOBJ->get_delete ();
/** Call function to display videos data in grid section */
$gridVideo    = $videoOBJ->video_data ();
/** Call function to count videos data */
$Video_count  = $videoOBJ->video_count ( $videosearchQuery, $searchBtn );
/** Get video publish option */
$player_colors = unserialize ( $settingsGrid->player_colors );
/** Initialize variables for videos page */
$page       = $ordervalue = '';
/** Get current user role for videos page */
$userid       =  wp_get_current_user ();
$userDetails  = get_user_by( 'id',  $userid->ID ); 
if(isset($userDetails->roles)) {
  $user_role    = $userDetails->roles[0];
}
 
/** Get page number from request */
$pagenum  = absint ( filter_input ( INPUT_GET, 'pagenum' ) );
if ($pagenum) {
  $page   = '&pagenum=' . $_GET ['pagenum'];
}
/** Get videos page URL */
$url      = get_site_url () . '/wp-admin/admin.php?page=video';
/** get videos page url with current page number */
$selfurl  = get_site_url () . '/wp-admin/admin.php?page=video' . $page;
/** Get sort order URL 
 * to perform drg and drop for ordering in videos
 * and assign to script variable
 */
$sortOrderURL = get_site_url() . '/wp-admin/admin-ajax.php?action=vg_sortorder&type=1'. $page;
/** Include css file and script to show /hide video page information*/ ?>
<link rel="stylesheet" href="<?php echo APPTHA_VGALLERY_BASEURL . 'admin/css/jquery.ui.all.css'; ?>">
<script type="text/javascript">
        var sortorderURL = '<?php echo $sortOrderURL; ?>'; 
        var dragdr = jQuery.noConflict();
        dragdr( document ).ready( function() {
            dragdr( ".ui-icon-minusthick" ).hide();
            dragdr( ".portlet-content" ).hide();
            dragdr( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" ) 
            .find( ".portlet-header" ) 
            .addClass( "ui-widget-header ui-corner-all" ) 
            .prepend( "<span class='ui-icon ui-icon-plusthick'></span>" ) 
            .end()
            .find( ".portlet-content" ); 
            dragdr( ".portlet-header .ui-icon" ).click( function() { 
                dragdr( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" ); 
                dragdr( this ).parents( ".portlet" ).find( ".portlet-content" ).toggle(); 
            } );
        });
</script>
<?php /** Display videos page starts */ ?>
<div class="apptha_gallery">
<?php /** Call function to display admin tabs in videos page 
		* Show only is admin logs in
		*/
	if($user_role == 'administrator') {
		echo displayAdminTabs ( 'videos' ) ;
		}
      ?>    
      <div class="wrap">
      <?php /** Display page title and icon in all videos page starts */ ?>
          <h2 class="option_title"> <?php echo '<img src="' . getImagesDirURL() .'manage_video.png" alt="move" width="30"/>'; ?>
              <?php esc_attr_e( 'Manage Videos', APPTHA_VGALLERY ); ?>
              <a class="button-primary" href="<?php echo get_site_url() ; ?>/wp-admin/admin.php?page=newvideo" style="margin-left: 10px;">
              <?php esc_attr_e( 'Add New', APPTHA_VGALLERY ); ?></a>
              <?php if($user_role != 'administrator') { ?>(This grid shows the videos based on add method selected by admin)<?php }?>
          </h2> 
          <?php /** Display page title and icon in all videos page ends */
          /** Check current user is admin */  ?>
          <?php if ($user_role != 'subscriber') { ?>
          <div class="show-hide-intro-shortcode">
              <div class="portlet">
              <?php /** Display how to use information starts */ ?>
                  <div class="portlet-header"><?php esc_attr_e( 'How To Use?', APPTHA_VGALLERY ); ?></div>
                  <div class="portlet-content admin_short_video_info">
                      <p> Once you installed <strong>"Wordpress Video Gallery"</strong> plugin, the page <strong>"Videos"</strong> will be created automatically. If you would like to display the video gallery home page on any other page/post, you can use the following shortcode <strong>[videohome]</strong>.</p> 
                      <p>To display the single video player on any page/post use <strong> [hdvideo id=10]</strong>. This shortcode will have the following parameters. </p>
                      <table class="info_videoshartcode" cellpadding="0" cellspacing="0"> 
                          <thead> 
                              <tr>  <th> <p> Parameters </p> </th> 
                                    <th> <p>  Description	</p> </th> 
                              </tr>
                          </thead> 
                          <tbody> 
                              <tr > <td>id</td> 
                                    <td> <p>Video ID where you can find in <strong>&ldquo;All Videos &rdquo;</strong> tab </p> </td> 
                              </tr> 
                              <tr > <td> playlistid </td> 
                                    <td> <p> Category ID where you can find in <strong>&ldquo;Categories&rdquo;</strong> tab </p> </td> 
                              </tr> 
                              <tr > <td>  width </td> 
                                    <td> <p> Specify	the width of the player </p> </td> 
                              </tr> 
                              <tr > <td> height </td> 
                                    <td> <p> Specify	the height of the player </p> </td> 
                              </tr> 
                              <tr > <td> relatedvideos </td> 
                                    <td> <p> You	can enable/disable the related videos slider under the player by on/off this parameter <strong>(eg: relatedvideos=on)</strong>. 
                                    If you didn't mention this parameter then it will be in <strong>&ldquo;off&rdquo;</strong> status. </p> 
                                    </td> 
                              </tr> 
                              <tr > <td> ratingscontrol </td> 
                              <td> <p> Enable/disable the ratings below the player in any post/page by using the value <strong>on/off</strong>. </p> </td> 
                              </tr> 
                              <tr > <td> title </td> 
                                    <td> <p> Enable/disable the title below the player in any post/page by using the value <strong>on/off</strong>. </p> </td> 
                              </tr> 
                              <tr > <td> Views </td> 
                                    <td> <p> Enable/disable the views below the player in any post/page by using the value <strong>on/off</strong>. </p> </td> 
                              </tr> 
                            </tbody> 
                        </table> 
                      
                        <p> You can also control the player settings for a specific video by including <strong>&ldquo; flashvars&rdquo;</strong> parameter in the shortcode. Flashvars parameter will include the following options.</p> 
                        <table class="info_videoshartcode" cellpadding="0" cellspacing="0"> 
                            <thead> 
                                <tr> <th> <p> Parameters </p> </th> <th> <p>  Description	</p> </th> </tr> 
                            </thead> 
                            <tbody> 
                                <tr > <td> autoplay </td> 
                                      <td> <p>This will play the video automatically if you specify with value <strong>&ldquo;true&rdquo;</strong>. </p> </td> 
                                </tr> 
                                <tr > <td> ZoomIcon </td> 
                                      <td> <p> This will enable zoom icon on the player if you specify with value &ldquo;true&rdquo; <strong>(eg :[hdvideo id=4 
                                      flashvars=autoplay=true&amp;zoomIcon=false]</strong>. which will enable autoplay and disable zoom icon). </p> </td> 
                                </tr> 
                                <tr > <td>email </td> 
                                      <td> <p> This will enable email option on the player when you click share icon if you specify with value <strong>&ldquo;true&rdquo;</strong> </p> </td> 
                                </tr> 
                                <tr > <td> shareIcon </td> 
                                      <td> <p> This will enable share icon on the player if you specify with value <strong>&ldquo;true&rdquo;</strong> </p> </td> 
                                </tr> 
                                <tr > <td> fullscreen </td> 
                                      <td> <p> This will enable fullscreen option on the player if you specify with value  <strong>&ldquo;true&rdquo;</strong> </p> </td> 
                                </tr> 
                                <tr > <td> volumecontrol </td> 
                                      <td> <p> Hide/show the volume control on the player with the value <strong>false/true</strong> </p> </td> 
                                </tr> 
                                <tr > <td> playlist_auto </td> 
                                      <td> <p> Autoplay the videos from playlist using <strong>false/true</strong> value. </p> </td> 
                                </tr> 
                                <tr > <td> progressControl </td> 
                                      <td> <p> Hide/show the progress bar by specifying the value <strong>false/true</strong>  </p> </td> 
                                </tr> 
                                <tr > <td> skinVisible </td> 
                                      <td> <p> Hide/show the entire skin by specifying the value <strong>false/true</strong>  </p> </td> 
                                </tr>
                                <tr > <td> timer </td> 
                                      <td> <p> Hide/show timer by specifying the value <strong>false/true</strong> </p> </td> 
                                </tr>
                                <tr > <td> Download </td> 
                                      <td> <p> Hide/show download button by specifying the value <strong>false/true</strong> </p> </td> 
                                </tr> 
                            </tbody> 
                        </table> 
                        <p> You	can also get more parameters from <strong><?php  echo admin_url('admin-ajax.php?action=configXML'); ?></strong>. </p>
                        <p> To display a particular category videos thumb images in any post/page you can use the following shortcode <strong>[categoryvideothumb type=category id=2]</strong> - which will fetch thumb images from category ID 2. To mention row/column you can use shortcode like this <strong>[categoryvideothumb type=category id=2 rows=1 cols=2]</strong>. </p> 
                        <p> To display popular videos thumb images in any post/page you can use the shortcode <strong>[popularvideo]</strong> </p> 
                        <p> To display recent videos thumb images in any post/page you can use the shortcode <strong>[recentvideo]</strong> </p> 
                        <p> To display featured videos thumb images in any post/page you can use the shortcode <strong>[featuredvideo]</strong> </p>
                        <p> To display watch history videos in any post/page you can use the shortcode <strong>[watch_history]</strong> </p>
                        <p> To display watch later videos in any post/page you can use the shortcode <strong>[watch_later]</strong> </p>
                        <p> To display the list of playlist in any post/page you can use the shortcode <strong>[showplaylist]</strong> </p>
                        <p> To display channel in any post/page you can use the shortcode <strong>[videochannel]</strong> </p>                       
                    </div>
                </div> 
                <?php /** Display how to use information ends */ 
                /** Display rss feed URL and its information starts */ ?>
                <div class="portlet"> 
                    <div class="portlet-header"><?php esc_attr_e('How to use RSS Feeds?',APPTHA_VGALLERY); ?></div>
                    <div class="portlet-content admin_short_video_info"> <?php esc_attr_e('Mentioned below are the appropriate URLs to get RSS Feeds for:',APPTHA_VGALLERY);?><br> <br> 
                        <?php esc_attr_e('Popular Videos',APPTHA_VGALLERY); ?> - 
                        <strong><?php esc_attr_e(get_site_url().'/wp-admin/admin-ajax.php?action=rss&task=popular',APPTHA_VGALLERY);?></strong><br> <br> 
                        <?php esc_attr_e('Featured Videos',APPTHA_VGALLERY); ?> - 
                        <strong><?php esc_attr_e(get_site_url().'/wp-admin/admin-ajax.php?action=rss&task=featured',APPTHA_VGALLERY);?></strong><br> <br> 
                        <?php esc_attr_e('Recent Videos',APPTHA_VGALLERY); ?> - 
                        <strong><?php esc_attr_e(get_site_url().'/wp-admin/admin-ajax.php?action=rss&task=recent',APPTHA_VGALLERY);?></strong><br> <br> 
                        <?php esc_attr_e('Any particular playlist',APPTHA_VGALLERY);?> - 
                        <strong><?php esc_attr_e(get_site_url().'/wp-admin/admin-ajax.php?action=rss&task=category&playid=1',APPTHA_VGALLERY);?></strong><br>
                        <?php esc_attr_e('( Here replace the URL with your Playlist ID )', APPTHA_VGALLERY);?><br> <br> 
                        <?php esc_attr_e('Any particular video',APPTHA_VGALLERY);?> - 
                        <strong><?php esc_attr_e(get_site_url().'/wp-admin/admin-ajax.php?action=rss&task=video&vid=1',APPTHA_VGALLERY);?></strong><br>
                         <?php esc_attr_e('( Here replace the URL with your Video ID )', APPTHA_VGALLERY);?><br> <br>
                    </div>
                </div> 
            </div>
            <?php /** Display rss feed URL and its information ends */ 
            }
            /** Display status for the performed action */
            echo displayStatusMeassage ( $displayMsg );
            /** Get params to order the videos based on the fields */ 
            $orderFilterlimit = filter_input ( INPUT_GET, 'filter' ); 
            $orderField       = filter_input ( INPUT_GET, 'order' ); 
            $orderby          = filter_input ( INPUT_GET, 'orderby' ); 
            $direction        = isset ( $orderField ) ? $orderField : ''; 
            if (! empty ( $orderby ) && ! empty ( $orderField )) { 
                $ordervalue   = '&orderby=' . $orderby . '&order=' . $orderField; 
            }
            $reverse_direction = ($direction == 'DESC' ? 'ASC' : 'DESC'); 
            /** Display search results message starts */
            if (isset ( $_REQUEST ['videosearchbtn'] )) { ?> 
            <div class="updated below-h2"> 
                <?php $searchmsg = filter_input ( INPUT_POST, 'videosearchQuery' ); 
                /** Check more than one video search result is exists */
                if (count ( $gridVideo )) { 
                    echo  count ( $gridVideo )  . '   Search Result( s ) for "' . $searchmsg . '".&nbsp&nbsp&nbsp<a href="' . $url . '" >Back to Videos List</a>'; 
                } else { 
                    echo ' No Search Result( s ) for "' . $searchmsg . '".&nbsp&nbsp&nbsp<a href="' . $url . '" >Back to Videos List</a>'; 
                } ?> 
            </div> 
            <?php } ?> 
            <?php /** Display search results message ends
            /** Display video search button starts */ ?>
            <form class="admin_video_search alignright" name="videos" action="<?php echo $url . '&#videofrm'; ?>" method="post" onsubmit="return videosearch();"> 
                <p class="search-box"> 
                <?php /** Display textbox to get video search text */ ?>
                    <input type="text" name="videosearchQuery" id="VideosearchQuery" 
                    value="<?php if ( isset( $searchmsg ) ) { 
                      echo $searchmsg ; 
                    } ?>">
                    <?php /** Display video search button */ ?> 
                    <input type="hidden" name="page" value="videos"> 
                    <input type="submit" name="videosearchbtn" class="button" value="<?php esc_attr_e( 'Search Videos', APPTHA_VGALLERY ); ?>"> 
                </p> 
            </form> 
            <?php /** Display video search button ends */
            /** Display grid form to show videos starts */ ?>
            <form class="admin_video_action" name="videofrm" id="videofrm" action="" method="post" onsubmit="return VideodeleteIds()"> 
                <?php /** Display multi option to delete / feture / publish videos in head section */ ?>
                <div class="alignleft actions" style="margin-bottom: 10px;"> 
                    <select name="videoactionup" id="videoactionup"> 
                        <option value="-1" selected="selected"><?php esc_attr_e( 'Bulk Actions', APPTHA_VGALLERY ); ?></option> 
                        <option value="videodelete"><?php esc_attr_e( 'Delete', APPTHA_VGALLERY ); ?></option> 
                        <option value="videopublish"><?php esc_attr_e('Publish',APPTHA_VGALLERY); ?></option> 
                        <option value="videounpublish"><?php esc_attr_e('Unpublish',APPTHA_VGALLERY); ?></option> 
                        <option value="videofeatured"><?php esc_attr_e('Add to Featured',APPTHA_VGALLERY); ?></option> 
                        <option value="videounfeatured"><?php esc_attr_e('Remove from Feature',APPTHA_VGALLERY); ?></option> 
                    </select> 
                    <input type="submit" name="videoapply" class="button-secondary action" value="<?php esc_attr_e( 'Apply', APPTHA_VGALLERY ); ?> "> 
                </div> 
                <?php /** Display filter option to filter videos starts */ ?>
                <div class="alignleft actions responsive" style="margin-bottom: 10px;"> 
                    <select name="videofilteraction" id="videofilteraction" onchange="window.location.href = this.value"> 
                        <option value="" selected="selected">Select Limit</option> 
                        <option <?php if ($orderFilterlimit == 5) { 
                          echo 'selected';  
                        } ?> value="<?php echo $url . $ordervalue; ?>&filter=5#videofrm">5</option> 
                        <option value="<?php echo $url . $ordervalue; ?>&filter=10#videofrm" 
                        <?php if ($orderFilterlimit == 10) {  
                          echo 'selected'; 
                        } ?> >10</option> 
                        <option <?php  if ($orderFilterlimit == 20) { 
                          echo 'selected'; 
                        } ?> value="<?php echo $url . $ordervalue; ?>&filter=20#videofrm">20</option> 
                        <option <?php if ($orderFilterlimit == 50) { 
                          echo 'selected'; 
                        } ?> value=" <?php echo $url . $ordervalue; ?>&filter=50#videofrm">50</option> 
                        <option value="<?php echo $url . $ordervalue; ?>&filter=100#videofrm" 
                        <?php if ($orderFilterlimit == 100) { 
                          echo 'selected'; 
                        } ?> >100</option> 
                        <option <?php if ($orderFilterlimit == 'all') { 
                          echo 'selected'; 
                        } ?> value="<?php echo $url . $ordervalue; ?>&filter=all#videofrm">All</option> 
                    </select> 
                </div>
            <?php  /** Display filter option to filter videos ends */ 
            /** Get order limit, direction for videos page */
            if (! empty ( $orderFilterlimit ) && $orderFilterlimit !== 'all') { 
                          $limit = $orderFilterlimit; 
                        } else if ($orderFilterlimit === 'all') { 
                          $limit = $Video_count; 
                        } else { 
                          $limit = 20; 
                        } 
                  $pagenum = absint ( filter_input ( INPUT_GET, 'pagenum' ) ); 
                  if (empty ( $pagenum )) { 
                      $pagenum = 1; 
                  } 
                  $total = $Video_count; 
                  /** Set pagination arguments */
                  $arr_params = array ( 'pagenum' => '%#%', '#videofrm' => '' ); 
                  /** Display pagination for all videos page */
                  echo paginateLinks ( $total, $limit, $pagenum, 'admin', $arr_params ); 
                  /** Get orderby URL based on videos id for videos page titles */
                  $videoIDURL = get_site_url() .'/wp-admin/admin.php?page=video&orderby=id&order='. $reverse_direction ;
                  /** Get orderby URL based on videos title for videos page titles */
                  $videoTitleURL = get_site_url() .'/wp-admin/admin.php?page=video&orderby=title&order='. $reverse_direction;
                  /** Get orderby URL based on videos author for videos page titles */
                  $videoAuthorURL = get_site_url() .'/wp-admin/admin.php?page=video&orderby=author&order='. $reverse_direction;
                  /** Get orderby URL based on videos category for videos page titles */
                  $videoCatURL = get_site_url() .'/wp-admin/admin.php?page=video&orderby=category&order='.$reverse_direction;
                  /** Get orderby URL based on featured videos for videos page titles */
                  $videoFeaURL = get_site_url() .'/wp-admin/admin.php?page=video&orderby=fea&order='. $reverse_direction;
                  /** Get orderby URL based on videos date for videos page titles */
                  $videoDateURL = get_site_url() .'/wp-admin/admin.php?page=video&orderby=date&order='. $reverse_direction; 
                  /** Get orderby URL based on videos status for videos page titles */
                  $videoStatusURL = get_site_url() .'/wp-admin/admin.php?page=video&orderby=publish&order='. $reverse_direction; 
                  /** Get orderby URL based on videos ordering for videos page titles */
                  $videoOrderURL = get_site_url() .'/wp-admin/admin.php?page=video&orderby=ordering&order='.$reverse_direction ?> 
                  <br /> <br />
                  <div style="float: right; font-weight: bold;"><?php if ( isset( $pagelist ) ) { 
                    echo $pagelist; 
                  } ?></div> 
                  <div style="clear: both;"></div> 
                  <?php /** Display videos titles in grid section */ ?>
            <table class="wp-list-table widefat fixed posts" cellspacing="0" width="100%"> 
            <?php /** Display header section in videos page starts */ ?>
               <thead> 
                     <?php /** Display header section checkbox */ ?>
                    <tr> <th width="3%" scope="col" style=""  class="manage-column column-cb check-column"> <input type="checkbox" name="" id="manage-column-video-1"></th>
                    <?php /** Display header section drag and drop option  */ ?> 
                        <th width="3%" scope="col" class="manage-column column-ordering"> <span> <?php esc_attr_e( '', APPTHA_VGALLERY ); ?> </span><span class="sorting-indicator"></span> </th>
                        <?php /** Display header section video id column */ ?> 
                        <th width="4%" scope="col" class="manage-column column-id sortable desc" style=""> <a href="<?php echo $videoIDURL; ?>"><span>
                        <?php esc_attr_e( 'ID', APPTHA_VGALLERY ); ?> </span><span class="sorting-indicator"></span></a></th> 
                        <?php /** Display header section video title column */ ?>
                        <th width="6%" scope="col" class="manage-column column-image"><span class="sorting-indicator"></span></th>
                       <?php if ($user_role != 'subscriber') { ?>
                        <th width="28%" scope="col" class="manage-column column-name sortable desc" style=""><a href="<?php echo $videoTitleURL ; ?>"><span>
                        <?php /** Display header section video author column */ ?>  
                        <?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?> </span><span class="sorting-indicator"></span></a></th> 
                         <th width="12%" scope="col" class="manage-column column-name sortable desc" style=""><a href="<?php echo $videoTitleURL ; ?>"><span>
                        <?php /** Display header section video author column */ ?>  
                        <?php esc_attr_e( 'Videolink', APPTHA_VGALLERY ); ?> </span><span class="sorting-indicator"></span></a></th> 
                        <?php } else { ?>
                         <th width="30%" scope="col" class="manage-column column-name sortable desc" style=""><a href="<?php echo $videoTitleURL ; ?>"><span>
                        <?php /** Display header section video author column */ ?>  
                        <?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?> </span><span class="sorting-indicator"></span></a></th> 
                        <?php } ?>
                        <th width="14%" scope="col" class="manage-column column-author sortable desc" style=""><a href="<?php echo $videoAuthorURL; ?>"><span>
                        <?php esc_attr_e( 'Author', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span></a></th> 
                        <th width="14%" scope="col" class="manage-column column-playlistname sortable desc" style=""> <a href="<?php echo $videoCatURL ; ?>"><span>
                        <?php /** Display header section video category column */ ?>  
                        <?php esc_attr_e( 'Categories', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span></a> </th> 
                        <th width="8%" scope="col" class="manage-column column-feature sortable desc text_center" style=""><a href="<?php echo $videoFeaURL; ?>"><span>
                        <?php /** Display header section video featured column */ ?>   
                        <?php esc_attr_e( 'Featured', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span></a></th> 
                        <th width="4%" scope="col" class="manage-column column-createddate sortable desc" style="width: 10%"><a href="<?php echo $videoDateURL; ?>">
                        <?php /** Display header section video date column */ ?>  
                        <span><?php esc_attr_e( 'Date', 'digi' ); ?></span><span class="sorting-indicator"></span></a></th> 
                        <?php /** Display header section video status column */ ?>  
                        <th width="7%" scope="col" class="text_center manage-column column-publish sortable desc" style=""><a href="<?php echo $videoStatusURL; ?>">
                        <span> <?php esc_attr_e( 'Publish', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span></a></th>
                        <?php /** Display header section video ordering column */ ?>   
                        <th width="7%" scope="col" class="manage-column column-ordering sortable desc" style=""><a href="<?php echo $videoOrderURL; ?>"> 
                        <span><?php esc_attr_e( 'Order', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span> 
                        </a></th> 
                    </tr> 
                </thead> 
                <?php /** Display header section in videos page ends */
                /** Display videos page body section starts */  ?>
                <tbody id="test-list" class="list:tag"> 
        <?php  /** Looping through video details for videos page */
                $i = 0; 
                /** Display videos in grid section */
                foreach ( $gridVideo as $videoView ) {
                    $videoidURL = get_site_url() .'/wp-admin/admin.php?page=newvideo&videoId='. $videoView->vid ; 
                    $i ++; ?> 
                    <tr id="listItem_<?php echo $videoView->vid; ?>"> 
                    <?php /** Display checkbox to select */ ?>
                    <th scope="row" class="check-column"><input type="checkbox" name="video_id[]"  value="<?php echo $videoView->vid ; ?>"></th>
                    <?php /** Display drag and drop option */ ?>
                    <td class="column-id"> <?php if ( $user_role != 'subscriber' ) { ?> <span class="hasTip content" 
                        title="<?php esc_attr_e( 'Click and Drag', APPTHA_VGALLERY ); ?>" style="padding: 6px;"> 
                        <img src="<?php echo getImagesDirURL() . 'arrow.png'; ?>" alt="move" width="16" height="16" class="handle" /> </span> 
                        <?php } ?> 
                    </td> 
                    <?php /** Display videos id */ ?>
                    <td class="image column-ordering"><a title="Edit <?php echo $videoView->name ; ?>" 
                        href="<?php echo $videoidURL; ?>">
                        <?php echo $videoView->vid ; ?></a> 
                    </td> 
                    <?php /** Display videos thumb image */ ?>
                    <td class="image column-image"> 
                        <?php  $thumb_image = getImagesValue ( $videoView->image, $videoView->file_type, $videoView->amazon_buckets, ''); ?> 
                        <a title="Edit <?php echo $videoView->name; ?>" 
                        href="<?php echo $videoidURL ; ?>">
                        <img width="60" height="60" src="<?php echo $thumb_image ; ?>" class="attachment-80x60" alt="Hydrangeas"> </a> 
                    </td> 
                    <?php /** Display videos title */ ?>
                    <td class="column-name"><a title="Edit <?php echo $videoView->name ; ?>" class="row-title" 
                    href="<?php echo $videoidURL ; ?>">
                    <?php echo  $videoView->name; ?></a> 
                    </td> 
                    <?php /** Display videos link */ ?>
                    <?php if ($user_role != 'subscriber') { ?> 
                    <td class="column-name"><a title="Play <?php echo $videoView->name ; ?>" class="row-title" 
                    href="javascript:void(0)" onclick="window.open('<?php echo get_site_url() ."/?post_type=videogallery&p=".$videoView->slug."&admin=1'";?>)">
                    <?php echo 'Play video'; ?></a> 
                    </td>
                    <?php } ?>
                    <?php /** Display videos user name */ ?>
                    <td class="description column-author"><?php echo $videoView->display_name; ?></td> 
                    <?php /** Display videos category name */ ?>
                    <td class="description column-playlistname"> 
                    <?php $videoOBJ = new VideoController (); 
                    /** Get playlist details for particular video */
                        $playlistData = $videoOBJ->get_playlist_detail ( $videoView->vid ); 
                        $incre = 0; 
                        $playlistname = ''; 
                        /** Looping to get more than one playlist for video */
                        foreach ( $playlistData as $playlist ) { 
                            if ($incre > 0) { 
                              /** Concatinate if more than one playlist exists */
                                $playlistname .= ', ' . $playlist->playlist_name; 
                            } else { 
                                $playlistname .= $playlist->playlist_name; 
                            } 
                            $incre ++; 
                        }
                        echo  $playlistname ; ?> 
                    </td> 
                    <?php /** Display videos featured option */ ?>
                    <td class="description column-featured" style="text-align: center"> 
                        <?php $feaStatus = 1; 
                        $feaImage = 'deactivate.jpg';
                        if ($videoView->featured == 1) { 
                            $feaStatus = 0; 
                            $feaImage = 'activate.jpg'; 
                        } 
                        $feaURL = $selfurl .'&videoId='. $videoView->vid .'&featured='. $feaStatus;
                        ?><a title="<?php if ( $feaStatus == 0 ) { 
                        esc_attr_e( 'Remove from featured' ); 
                        } else { 
                          esc_attr_e( 'Add to Feature' ); 
                        } ?>" href="<?php echo $feaURL; ?>">
                        <img src="<?php echo getImagesDirURL() . $feaImage ?>" />  </a> 
                    </td> 
                    <?php /** Display videos posted date */ ?> 
                    <td class="description column-createddate"><?php echo date_i18n( get_option('date_format') , strtotime( $videoView->post_date ) ); ?></td> 
                    <?php /** Display videos publish / unpublish section */ ?>
                    <td class="description column-publish column-publish" style="text-align: center"><?php $status = 1; 
                        $image = 'deactivate.jpg'; 
                        if ($videoView->publish == 1) { 
                            $status = 0;
                            $image = 'activate.jpg';
                        } 
                        $statURL = $selfurl .'&videoId='. $videoView->vid .'&status='. $status;
                         if (($user_role != 'subscriber')||($player_colors ['member_publish_enable']==1)) { ?> 
                        <a title="<?php if ( $status == 0 ) { 
                            esc_attr_e( 'Unpublish' ); 
                        } else { 
                            esc_attr_e( 'publish' ); 
                        }  
                       ?>" href="<?php echo $statURL; ?>"> 
                        <img src="<?php echo getImagesDirURL() . $image ?>" /> </a>
						<?php }else{ ?>
						<a title="<?php if ( $status == 0 ) { 
                            esc_attr_e( 'Unpublish' ); ?>"
                            href="<?php echo $statURL; ?> 
                       <?php } else { 
                            esc_attr_e( 'publish' ); ?>"
                            href="#" onclick="return alert('Publish option was disabled by admin')";   
                       <?php  }  
                       ?>" > 
                        <img src="<?php echo getImagesDirURL() . $image ?>" /> </a>
						<?php } ?>
						</td> 
                        <?php /** Display videos ordering */ ?>
                        <td class="column-ordering"> <?php echo $videoView->ordering ; ?> </td> 
                    </tr> 
                    <?php } 
                    /** If no video is found then display message */
                    if (count ( $gridVideo ) == 0) { ?>
                        <tr class="no-items"> <td class="colspanchange" colspan="5"><?php esc_attr_e( 'No videos found.', APPTHA_VGALLERY ); ?></td> </tr> 
                    <?php } ?> 
                </tbody> 
                <?php /** Display all videos page body esction ends */ 
                /** Display footer title in all videos page */ ?>
                <tfoot> 
                <?php /** Display footer section video checkbox column */ ?>  
                <tr> <th width="3%" scope="col" style="" class="manage-column column-cb check-column"><input type="checkbox" name="" id="manage-column-video-1"></th> 
                <?php /** Display footer section video drag and drop column */ ?>
                <th width="3%" scope="col" class="manage-column column-ordering"> <span> <?php esc_attr_e( '', APPTHA_VGALLERY ); ?> </span><span class="sorting-indicator"></span> </th> 
                <?php /** Display footer section video id column */ ?>
                <th width="4%" scope="col" style="" class="manage-column column-id sortable desc" ><a href="<?php echo $videoIDURL; ?>"> 
                    <span> <?php esc_attr_e( 'ID', APPTHA_VGALLERY ); ?> </span><span class="sorting-indicator"></span></a></th> 
                <?php /** Display footer section video title column */ ?>
                <th width="6%" scope="col" class="manage-column column-image"><span class="sorting-indicator"></span></th>
                <?php if ($user_role != 'subscriber') { ?>
                <th width="28%" class="manage-column column-name sortable desc" scope="col" style=""><a href="<?php echo $videoTitleURL; ?>"> 
                    <span> <?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?> </span><span class="sorting-indicator"></span></a></th> 
                <?php /** Display footer section video author column */ ?>
                 <th width="12%" class="manage-column column-name sortable desc" scope="col" style=""><a href="<?php echo $videoTitleURL ; ?>"> 
                    <span> <?php esc_attr_e( 'Videolink', APPTHA_VGALLERY ); ?> </span><span class="sorting-indicator"></span></a></th> 
               <?php } else { ?>
               	<th width="30%" class="manage-column column-name sortable desc" scope="col" style=""><a href="<?php echo $videoTitleURL; ?>"> 
                    <span> <?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?> </span><span class="sorting-indicator"></span></a></th> 
                <?php /** Display footer section video author column */ ?>
            <?php   } ?>
               
                <?php /** Display footer section video author column */ ?>
                <th scope="col"  width="14%" class="manage-column column-author sortable desc" style=""><a href="<?php echo $videoAuthorURL; ?>"> 
                    <span> <?php esc_attr_e( 'Author', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span></a></th> 
                <?php /** Display footer section video category column */ ?>
                <th width="14%" style="" scope="col" class="manage-column column-playlistname sortable desc" > <a href="<?php echo $videoCatURL; ?>"> 
                    <span> <?php esc_attr_e( 'Categories', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span></a> </th> 
                <?php /** Display footer section video featured column */ ?>
                <th scope="col" class="manage-column column-feature sortable desc text_center" width: 10%  style=""><a href="<?php echo $videoFeaURL; ?>"> 
                    <span> <?php esc_attr_e( 'Featured', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span></a></th> 
                <?php /** Display footer section video date column */ ?>
                <th scope="col" class="manage-column column-createddate sortable desc" style="" width="4%"><a href="<?php echo $videoDateURL; ?>"> 
                    <span><?php esc_attr_e( 'Date', 'digi' ); ?></span><span class="sorting-indicator"></span></a></th> 
                <?php /** Display footer section video publish column */ ?>
                <th width="7%"  class="text_center manage-column column-publish sortable desc" style="" scope="col"><a href="<?php echo $videoStatusURL; ?>"> 
                    <span> <?php esc_attr_e( 'Publish', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span></a></th> 
                <?php /** Display footer section video ordering column */ ?>
                <th class="manage-column column-ordering sortable desc" width="7%" scope="col"  style=""><a href="<?php echo $videoOrderURL; ?>"> 
                    <span><?php esc_attr_e( 'Order', APPTHA_VGALLERY ); ?></span><span class="sorting-indicator"></span> </a></th> 
                </tr> 
              </tfoot> 
              <?php /** Display footer videos page ends  */ ?>
          </table> 
          <?php /** Display footer multi option starts */ ?>
          <div class="alignleft actions" style="margin-top: 10px;"> 
              <select name="videoactiondown" id="videoactiondown"> 
                  <option value="-1" selected="selected"><?php esc_attr_e( 'Bulk Actions', APPTHA_VGALLERY ); ?></option> 
                  <option value="videodelete"><?php esc_attr_e( 'Delete', APPTHA_VGALLERY ); ?></option> 
                  <option value="videopublish"><?php esc_attr_e('Publish',APPTHA_VGALLERY); ?></option> 
                  <option value="videounpublish"><?php esc_attr_e('Unpublish',APPTHA_VGALLERY); ?></option> 
                  <option value="videofeatured"><?php esc_attr_e('Add to  Feature',APPTHA_VGALLERY); ?></option> 
                  <option value="videounfeatured"><?php esc_attr_e('Remove from Featured',APPTHA_VGALLERY); ?></option> 
              </select> 
              <input type="submit" name="videoapply" class="button-secondary action" value="<?php esc_attr_e( 'Apply', APPTHA_VGALLERY ); ?>"> 
          </div>
<?php  /**
        * Display footer multi option ends
        * Footer pagination drop down for all videos page
        */
      echo paginateLinks ( $total, $limit, $pagenum, 'admin', $arr_params  );?>
      </div>
    </form>
<?php /** Display videos page ends */ ?>
</div>
