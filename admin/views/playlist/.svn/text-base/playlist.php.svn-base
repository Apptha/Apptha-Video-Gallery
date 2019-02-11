<?php
/**
  Name: Wordpress Video Gallery
  Plugin URI: http://www.apptha.com/category/extension/Wordpress/Video-Gallery
  Description: category model file.
  Version: 2.9
  Author: Apptha
  Author URI: http://www.apptha.com
  License: GPL2
 */
/** Get page values for playlist page */
$page = $class = '';
if (isset ( $_GET ['pagenum'] )) {
  $page = '&pagenum=' . $_GET ['pagenum'];
}
/** Get sort order URL to perform drg and drop for ordering  */
$sortOrderURL = get_site_url() . '/wp-admin/admin-ajax.php?action=vg_sortorder&type=2'. $page;
/** Assign sortorder url, plugin path in script */
?>
<script type="text/javascript">
    var sortorderURL = '<?php echo $sortOrderURL; ?>';
    var	videogallery_plugin_folder =  '<?php echo getImagesDirURL() ; ?>' ;
</script>

<div class="apptha_gallery hi"> 
<?php /** Playlist admin page Starts
       * Call function to display admin tabs in playlist page */
      echo displayAdminTabs ( 'playlist' ) ;
      
      /**  Playlist add/ grid section Starts */ ?>
    <div class="wrap"> 
      <h2 class="option_title"> 
        <?php /** Display page title and icon image */  
        echo "<img src='" . getImagesDirURL() ."manage_list.png' alt='move' width='30'/>"; ?> 
        <?php esc_attr_e( 'Categories', APPTHA_VGALLERY ); ?> 
      </h2> 
      
      <?php  /** Playlist add page starts */ ?>
      <div class="floatleft category_addpages">  
          <div class="apptha_gallery hi"> 
        <?php /** Check action whether it is add / update
               * Then Display page title */
              if ( $playListId  ) { ?> 
              <h3> <?php esc_attr_e( 'Update Category', APPTHA_VGALLERY ); ?> </h3> 
              <?php } else { ?> 
              <h3> <?php esc_attr_e( 'Add a New Category', APPTHA_VGALLERY ); ?> </h3> 
              <?php } ?>
              
        <?php /** Gets status message from controller 
               * Then display the message for the coresponding action   */
              if ( $displayMsg && $displayMsg[1] == 'addcategory' ) {  
                  echo displayStatusMeassage ( $displayMsg [0] );
              } 
              
              /** Playlist add page form Starts  */ ?>
               <div id="post-body" class="has-sidebar"> 
                  <div id="post-body-content" class="has-sidebar-content"> 
                      <div class="stuffbox"> 
                          <div class="inside" style="margin:15px;"> 
                              <form name="adsform" method="post" enctype="multipart/form-data" >
                              <?php /** Display playlist form to add playlist */?> 
                                  <table class="form-table"> 
                                      <tr> <?php /** Display fields to enter title */ ?> 
                                          <th scope="row"> <?php esc_attr_e( 'Title / Name', APPTHA_VGALLERY ) ?> </th>
                                          <td> <?php if ( isset( $playlistEdit->playlist_name ) ) { 
                                                        $playlist_name = $playlistEdit->playlist_name; 
                                                     } else { 
                                                        $playlist_name = ''; 
                                                     } ?>
                                                <input type="text" maxlength="200" id="playlistname" name="playlistname" value="<?php echo htmlentities( $playlist_name ); ?>"  />
                                                <span id="playlistnameerrormessage" style="display: block;color:red; "></span> 
                                          </td>
                                      </tr>
                                      
                                      <tr> <?php /** Display publish option */ ?>
                                          <th scope="row"> <?php esc_attr_e( 'Publish', APPTHA_VGALLERY ); ?> </th>
                                          <td> <input type="radio" name="ispublish" id="published" value="1" checked="checked" 
                                                    <?php if ( isset( $playlistEdit->is_publish ) && $playlistEdit->is_publish == 1 ) {
                                                      echo 'checked="checked"';
                                                    } ?> /> 
                                                <label><?php esc_attr_e( 'Yes', APPTHA_VGALLERY ); ?></label>
                                                <input type="radio" name="ispublish" id="published" 
                                                    <?php if ( isset( $playlistEdit->is_publish ) && $playlistEdit->is_publish == 0 ) { 
                                                      echo 'checked="checked"';
                                                    } ?> value="0" />
                                                <label> <?php esc_attr_e( 'No', APPTHA_VGALLERY ); ?></label>
                                          </td>
                                      </tr>
                                  </table>
                                  
                            <?php /** Check whether the playlist id is exist.
                                   * If exist then display button to update playlist details 
                                   * Else display button to add playlist details */
                                  if ( $playListId ) { ?>
                                        <input type="submit" name="playlistadd" onclick="return validateplyalistInput();" class="button-primary"  value="<?php esc_attr_e( 'Update', APPTHA_VGALLERY ); ?>" class="button" />
                                        <input type="button" onclick="window.location.href = 'admin.php?page=playlist'" class="button-secondary" name="cancel" value="<?php esc_attr_e( 'Cancel' ); ?>" class="button" />
                                  <?php } else { ?>
                                        <input type="submit" name="playlistadd" onclick="return validateplyalistInput();" class="button-primary"  value="<?php esc_attr_e( 'Save', APPTHA_VGALLERY ); ?>" class="button" /> 
                                  <?php } ?>
                              </form>
                          </div>
                      </div>
                  </div>
                  <p>
              </div>
             <?php /** Playlist add page form Ends */ ?>
          </div>
      </div>
      <?php /** Playlist add page Ends  */ ?>
      
      <div class="floatleft category_addpages">
<?php /** Code to display playlist status */
      if ( $displayMsg && $displayMsg[1] == 'category' ) { 
          echo displayStatusMeassage ( $displayMsg [0] );  
      }
      /** Get playlist order direction */
      $orderField         = filter_input( INPUT_GET, 'order' );
      $direction          = isset( $orderField ) ? $orderField : '';
      $reverse_direction  = ( $direction == 'DESC' ? 'ASC' : 'DESC' );
      /** Playlist search message display starts */
      if ( isset( $_REQUEST['playlistsearchbtn'] ) ) { ?>
          <div  class="updated below-h2">
              <?php $url = get_site_url() . '/wp-admin/admin.php?page=playlist';
              $searchmsg = filter_input( INPUT_POST, 'PlaylistssearchQuery' );
              /** Check more than one seasrch result is exists */
              if ( count( $gridPlaylist ) ) {
                  echo esc_attr_e( 'Search Results for', APPTHA_VGALLERY ) . ' "' . $searchMsg . '"';
              } else {
                  echo esc_attr_e( 'No Search Results for', APPTHA_VGALLERY ) . ' "' . $searchMsg . '"';
              } ?> 
          </div> 
<?php /** Playlist search message display starts */  
       } 
       
       /** Playlist search form starts */
       ?>
       <form name="Playlists" class="admin_video_search alignright" id="searchbox-playlist" action="" method="post" onsubmit="return Playlistsearch();">
           <p class="search-box"> 
           <?php /** Display text box to get search text */ ?>
           <input type="text"  name="PlaylistssearchQuery" id="PlaylistssearchQuery" 
           value="<?php if ( isset( $searchmsg ) ) { 
             echo $searchmsg ; 
           }?>"> 
           <?php /** Duisplay search button */ ?>
           <input type="hidden"  name="page" value="Playlists"> 
           <input type="submit" name="playlistsearchbtn" id="playlistsearchButton"  class="button" value="<?php esc_attr_e( 'Search Categories', APPTHA_VGALLERY ); ?>"></p> 
       </form>
       
       <?php /** Playlist search form ends  */?>
       
       <?php /** Playlist grid form Starts */ ?>
       <form  name="Playlistsfrm" action="" method="post" onsubmit="return PlaylistdeleteIds()">
          <div class="alignleft actions bulk-actions"> 
             <?php /** Call function to display filter option in top  */
                   echo adminFilterDisplay ( 'playlist', 'up' ); ?>
           </div>
    <?php /** Get page number, total count and set default limit per page as 20 */ 
           $limit   = 20; 
           $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1; 
           $total   = $playlist_count; 
           
           /** Get pagination from helper 
            * Display top pagintion drop down */
           echo paginateLinks ( $total, $limit, $pagenum, 'admin', '' ); 
           
           /** Set URL to sort playlist based on the titles  */
           /** Set playid URL to sort playlist based on the ID  */
           $playIDURL         = get_site_url() . '/wp-admin/admin.php?page=playlist&orderby=id&order=' . $reverse_direction;
           /** Set playlistname URL to sort playlist based on the playlistname  */
           $playlistNameURL   = get_site_url() .'/wp-admin/admin.php?page=playlist&orderby=title&order=' . $reverse_direction;
           /** Set playliststatus URL to sort playlist based on the status  */
           $playlistStatusURL = get_site_url() .'/wp-admin/admin.php?page=playlist&orderby=publish&order='. $reverse_direction; 
           /** Set playlist order URL to sort playlist based on the ordering */
           $playlistOrderURL  = get_site_url() .'/wp-admin/admin.php?page=playlist&orderby=sorder&order=' . $reverse_direction;
           ?>
           <div style="float:right ; font-weight: bold;" >
           <?php if ( isset( $pagelist ) ) { 
             echo $pagelist; 
           } ?>
           </div>
           <div style="clear: both;"></div>
           <table class="wp-list-table widefat fixed tags hai" cellspacing="0">
                <?php /** Top heading Starts  */ ?> 
                <thead> 
                    <tr> 
                        <th scope="col"  class="manage-column column-cb check-column" style=""> <input type="checkbox" name="" id="manage-column-category-1" > </th> 
                        <th scope="col" style=""> <span> <?php esc_attr_e( '', APPTHA_VGALLERY ); ?> </span> <span class="sorting-indicator"></span> </th> 
                        <th scope="col" style="" class="manage-column column-id sortable desc" > 
                            <a href="<?php echo $playIDURL; ?>"> 
                            <span><?php esc_attr_e( 'ID', APPTHA_VGALLERY ); ?></span> 
                            <span class="sorting-indicator"></span> </a></th>
                        <th class="manage-column column-name sortable desc" style="" scope="col"> <a href="<?php echo $playlistNameURL; ?>">
                            <span><?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> </a> 
                        </th> 
                        <th scope="col" class="manage-column column-Expiry sortable desc" style=""> 
                            <a href="<?php echo $playlistStatusURL; ?>">
                            <span class="apptha_category_publish"> <?php esc_attr_e( 'Publish', APPTHA_VGALLERY ); ?> </span> 
                            <span class="sorting-indicator"></span> </a> </th> 
                        <th class="manage-column column-sortorder sortable desc" scope="col" style=""> 
                            <a href="<?php echo $playlistOrderURL; ?>">
                            <span> <?php esc_attr_e( 'Order', APPTHA_VGALLERY ); ?> </span>  <span class="sorting-indicator"></span></a></th>
                    </tr> 
                </thead> 
               <?php /** Top heading Ends */ ?> 
                
                <?php /** Display playlist data section Starts */ ?> 
                <tbody id="test-list" class="list:post"> 
                    <input type=hidden id=playlistid2 name=playlistid2 value="1" /> 
                    <div name=txtHint></div> 
              <?php /** Looping to diplay playlist data */
                     foreach ( $gridPlaylist as $playlistView ) { 
                        $class = ( $class == 'class="alternate"' ) ? '' : 'class="alternate"'; 
                     /** Display check box */ ?> 
                    <tr id="listItem_<?php echo $playlistView->pid ; ?>" 
                        <?php echo $class; ?> > 
                        <th scope="row" class="check-column"> <input type="checkbox" name="pid[]" value="<?php echo $playlistView->pid ; ?>"> </th>
                        
                        <td> <?php /** Display drag and drop option  */ ?> 
                            <span class="hasTip content" title="<?php esc_attr_e( 'Click and Drag', APPTHA_VGALLERY ); ?>" style="padding: 6px;">
                              <img src="<?php echo getImagesDirURL() .'arrow.png'; ?>" alt="move" width="16" height="16" class="handle" /> 
                            </span>
                        </td>
                         <?php /** Display playlist idcolumn  */ ?>
                        <td class="id-column column-id"> <a title="Edit <?php echo $playlistView->playlist_name ; ?>" 
                                    href="<?php echo get_site_url(); ?>/wp-admin/admin.php?
                                    page=newplaylist&playlistId=<?php echo $playlistView->pid ; ?>" >
                                    <?php echo $playlistView->pid ; ?> </a> 
                                    <div class="row-actions"> 
                        </td> 
                         <?php /** Display playlist name column  */ ?>
                        <td class="title-column"> <a title="Edit <?php echo $playlistView->playlist_name ; ?>" class="row-title" 
                            href="<?php echo get_site_url(); ?>/wp-admin/admin.php?
                            page=newplaylist&playlistId=<?php echo $playlistView->pid ; ?>" >
                            <?php echo $playlistView->playlist_name ; ?></a> 
                        </td> 
                            
                        <td class="pub-column Expiry column-Expiry"  align="center"> 
                        <?php /** Set image based 
                               * on publish / unpublish status 
                               * to display in grid section */
                            $status  = 1; 
                            $image   = 'deactivate.jpg'; 
                            $publish = __( 'Publish', APPTHA_VGALLERY ); 
                            if ( $playlistView->is_publish == 1 ) { 
                                $status  = 0; 
                                $image   = 'activate.jpg'; 
                                $publish = __( 'Unpublish', APPTHA_VGALLERY ); 
                            }
                            /** Get status url when publish / unpublish action is done */
                            $statusURL = get_site_url() .'/wp-admin/admin.php?page=playlist&pagenum=' .$pagenum .'&playlistId='.$playlistView->pid .'&status='. $status; 
                            ?>
                            <a href="<?php echo $statusURL; ?>">   
                                <img src="<?php echo getImagesDirURL() . $image ?>" 
                                title="<?php echo $publish ; ?>"   /> 
                            </a>
                        </td>
                         <?php /** Display playlist ordering column */ ?>
                        <td class="order-column Expiry column-ordering column-Expiry"> <?php echo $playlistView->playlist_order ; ?> </td> 
                    </tr>
              <?php /** For each to diplay playlist data ends */
                     }
                     
                    /** If playlist not found, then display not found message */
                    if ( isset( $_REQUEST['searchplaylistsbtn'] ) ) { ?> 
                    <tr class="no-items"> <td class="colspanchange" colspan="5"> No Category found. </td> </tr> 
                    <?php }
                    /** Check count of playlist is empty, to display not found message */
                    if ( count( $gridPlaylist ) == 0 ) { ?> 
                    <tr class="no-items"><td class="colspanchange" colspan="5"> No Category found. </td> </tr> 
                    <?php } 
                    /** Display playlist data section Ends
                     * Footer heading Starts */ ?> 
                </tbody>
                <tfoot> 
                    <tr> 
                        <th scope="col"  class="manage-column column-cb check-column" style=""> <input type="checkbox" name="" id="manage-column-category-1" > </th> 
                        <th width="3%" scope="col"  style=""> <span><?php esc_attr_e( '', APPTHA_VGALLERY ); ?> </span> <span class="sorting-indicator"></span> </th> 
                        <th scope="col"  style="" class="manage-column column-id sortable desc" > <a href="<?php echo $playIDURL; ?>"> 
                            <span><?php esc_attr_e( 'ID', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> 
                            </a> </th> 
                        <th class="manage-column column-name sortable desc" scope="col" style=""> 
                            <a href="<?php $playlistNameURL ; ?>"> 
                            <span><?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> </a> </th> 
                        <th class="manage-column column-Expiry sortable desc" style=""  scope="col"> <a href="<?php echo $playlistStatusURL; ?>">
                            <span><?php esc_attr_e( 'Publish', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> 
                            </a>
                        </th> 
                        <th scope="col" class="manage-column column-sortorder sortable desc" style=""> 
                            <a href="<?php echo $playlistOrderURL ; ?>">
                            <span><?php esc_attr_e( 'Order', APPTHA_VGALLERY ); ?></span> <span class="sorting-indicator"></span> 
                            </a>
                        </th> 
                    </tr> 
                </tfoot> 
                <?php /** Footer heading Ends */ ?>
             </table>
                   
             <div style="clear: both;"></div>
             <!-- Footer filter options Starts -->
             <div class="alignleft actions" style="margin-top:10px;">
                 <?php /** Call function to display filter option in bottom   */
                       echo adminFilterDisplay ( 'playlist', 'down' ); ?>
             </div>
       <?php /** Footer pagination drop down  */
             echo paginateLinks ( $total, $limit, $pagenum, 'admin', '' );
             /** Footer filter options Ends */ ?>
          </form> 
          <?php /** Playlist grid form Ends */ ?>
        </div> 
    </div>
    <?php /**  Playlist add/ grid section Starts */ ?> 
</div>
<?php  /** Playlist admin page Ends */ ?>