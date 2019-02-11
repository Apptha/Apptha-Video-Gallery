<?php
/**
  Name: Wordpress Video Gallery
  Plugin URI: http://www.apptha.com/category/extension/Wordpress/Video-Gallery
  Description: playlist model file.
  Version: 2.9
  Author: Apptha
  Author URI: http://www.apptha.com
  License: GPL2
 */
/** Get page values for playlist page */
define('VIDEOGALLERY_USER_PLAYLIST','videogalleryUserplaylist');
$playlistClass = '';

?>

<div id="<?php echo VIDEOGALLERY_USER_PLAYLIST;?>" class="apptha_gallery hi"> 
<?php /** Playlist admin page Starts
       * Call function to display admin tabs in playlist page */
      echo displayAdminTabs ( 'userplaylist' ) ;
      
      /**  Playlist add/ grid section Starts */ ?>
    <div id="<?php echo VIDEOGALLERY_USER_PLAYLIST;?>" class="wrap"> 
      <h2 id="<?php echo VIDEOGALLERY_USER_PLAYLIST;?>" class="option_title"> 
        <?php /** Display page title and icon image */  
        echo "<img src='" . getImagesDirURL() ."manage_list.png' id='userplaylistImg' alt='move' width='30'/>"; ?> 
        <?php esc_attr_e( 'Playlist', APPTHA_VGALLERY ); ?> 
      </h2> 
      
      <?php  /** Playlist add page starts */ ?>
      <div id="<?php echo VIDEOGALLERY_USER_PLAYLIST;?>" class="floatleft category_addpages">  
          <div id="<?php echo VIDEOGALLERY_USER_PLAYLIST;?>" class="apptha_gallery"> 
        <?php /** Check action whether it is add / update
              
              /** Gets status message from controller 
               * Then display the message for the coresponding action   */
              if ( $displayMsg && $displayMsg[1] == 'addcategory' ) {  
                  echo displayStatusMeassage ( $displayMsg [0] );
              } 
              
              /** Playlist add page form Starts  */ ?>
               <div id="post-body" class="has-sidebar" data-userplaylist="<?php echo VIDEOGALLERY_USER_PLAYLIST;?>"> 
                  <div id="post-body-content" class="has-sidebar-content  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"> 
                      <div class="stuffbox"> 
                          <div class="inside  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" style="margin:15px;"> 
                              <form name="adsform" class=" <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" method="post" enctype="multipart/form-data" >
                              <?php /** Display playlist form to add playlist */?> 
                                  <table class="form-table  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"> 
                                      <tr> <?php /** Display fields to enter title */ ?> 
                                          <th scope="row"> <?php esc_attr_e( 'Select User', APPTHA_VGALLERY ) ?> </th>
                                          <td> <select name="uid" class=" <?php echo VIDEOGALLERY_USER_PLAYLIST;?>">
                                          <option value="">Select User</option>
                                                   <?php 
                                                    if(!empty($userDetails)) {
                                                       foreach($userDetails as $userDetail) {
                                                    ?>
                                                        <option value="<?php echo $userDetail->ID; ?>" <?php 
                                                        if(!empty($userId)) { 
                                                                echo ($userDetail->ID == $userId) ? "selected" : ""; 
                                                         }
                                                        ?>
                                                        ><?php echo $userDetail->user_nicename; ?></option>
                                                    <?php  }
                                                     }
                                                    ?>
                                                    </select>
                                          </td>
                                      </tr>
                                  </table>
                                        <input type="submit" name="playlistadd" class="button-primary  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"  value="<?php esc_attr_e( 'Show Playlist', APPTHA_VGALLERY ); ?>" class="button" />
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
      
      <div class="floatleft category_addpages  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>">
<?php /** Code to display playlist status */
      if ( $displayMsg && $displayMsg[1] == 'category' ) { 
          echo displayStatusMeassage ( $displayMsg [0] );  
      }
      /** Get playlist order direction */
      $playlistOrderField         = filter_input( INPUT_GET, 'order' );
      $playlistDirection          = isset( $playlistOrderField ) ? $playlistOrderField : '';
      $reverse_direction  = ( $playlistDirection == 'DESC' ? 'ASC' : 'DESC' );
      /** Playlist search message display starts */
      if ( isset( $_REQUEST['playlistsearchbtn'] ) ) { ?>
          <div  class="updated below-h2  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>">
              <?php $url = get_site_url() . '/wp-admin/admin.php?page=playlist';
              $searchmsg = filter_input( INPUT_POST, 'PlaylistssearchQuery' );
              /** Check more than one seasrch result is exists */
              if ( !empty( $playlistDetails ) ) {
                  echo esc_attr_e( 'Search Results for', APPTHA_VGALLERY ) . ' "' . $searchMsg . '"';
              } else {
                  echo esc_attr_e( 'No Search Results for', APPTHA_VGALLERY ) . ' "' . $searchMsg . '"';
              } ?> 
          </div> 
<?php /** Playlist search message display starts */  
       } 
       
       /** Playlist search form starts */
       ?>
       <form name="Playlists" class="admin_video_search alignright  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" id="searchbox-playlist" action="" method="post" onsubmit="return Playlistsearch();">
           <p class="search-box  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"> 
           <?php /** Display text box to get search text */ ?>
           <input type="text"  name="PlaylistssearchQuery" id="PlaylistssearchQuery" class=" <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"
           value="<?php if ( isset( $searchmsg ) ) { 
             echo $searchmsg ; 
           }?>"> 
           <?php /** Duisplay search button */ ?>
           <input type="hidden" class=" <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" name="uid" value="<?php echo $userId; ?>"> 
           <input type="submit" class=" <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" name="playlistsearchbtn" id="playlistsearchButton"  class="button" value="<?php esc_attr_e( 'Search Categories', APPTHA_VGALLERY ); ?>"></p> 
       </form>
       <?php /** Playlist search form ends  */?>
       
       <?php /** Playlist grid form Starts */ ?>
       <form  name="Playlistsfrm" class="<?php echo VIDEOGALLERY_USER_PLAYLIST;?>" action="" method="post" onsubmit="return PlaylistdeleteIds()">
          <div class="alignleft actions bulk-actions  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"> 
             <?php /** Call function to display filter option in top  */
             ?>
           </div>
    <?php /** Get page number, total count and set default limit per page as 20 */ 
           $playlistLimit   = 20; 
           $playlistPagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1; 
           $total   = $playlist_count; 
           
           /** Get pagination from helper 
            * Display top pagintion drop down */
           echo paginateLinks ( $total, $playlistLimit, $playlistPagenum, 'admin', '' ); 
           ?>
           <div style="float:right ; font-weight: bold;" >
           <?php if ( isset( $pagelist ) ) { 
             echo $pagelist; 
           } ?>
           </div>
           <div style="clear: both;"></div>
           <table class="wp-list-table widefat fixed tags hai  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" cellspacing="0">
                <?php /** Top heading Starts  */ ?> 
                <thead> 
                    <tr> 
                        <!-- <th scope="col" style="visibility:hidden" class="manage-column column-cb check-column" style=""> <input type="checkbox" name="" id="manage-column-category-1" > </th>--> 
                        <th scope="col" style="padding:5px;" class="manage-column column-id sortable desc  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" > 
                            
                            <span><?php esc_attr_e( 'ID', APPTHA_VGALLERY ); ?></span> 
                            </th>
                        <th class="manage-column column-name sortable desc  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" style="padding:5px;" scope="col"> 
                            <span><?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?></span>  
                        </th> 
                        <th scope="col" class="manage-column column-Expiry sortable desc  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" style="padding:5px;"> 
                           
                            <span class="apptha_category_publish  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"> <?php esc_attr_e( 'Shortcode', APPTHA_VGALLERY ); ?> </span> 
                             </th> 
                    </tr> 
                </thead> 
               <?php /** Top heading Ends */ ?> 
                
                <?php /** Display playlist data section Starts */ ?> 
                <tbody id="test-list" class="list:post  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"> 
                    <input type=hidden id=playlistid2 name=playlistid2 value="1" /> 
                    <div name="txtHint" class=" <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"></div> 
              <?php /** Looping to diplay playlist data */
$index = 1;
if(isset($playlistDetails) && empty($playlistDetails)) {
$playlistDetails = array();
}
                     foreach ( $playlistDetails as $playlistDetail ) { 

                        $playlistClass = ( $playlistClass == 'class="alternate"' ) ? '' : 'class="alternate"'; 
                     /** Display check box */ ?> 
                    <tr id="listItem_<?php echo $playlistView->pid ; ?>" 
                        <?php echo $playlistClass; ?> > 
                        <!-- <th scope="row" class="check-column"> <input type="checkbox" name="pid[]" value="<?php echo $playlistDetail->id ; ?>"> </th>-->
<td class="id-column column-id"> <span class="playlistTitleElement  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"><?php echo $index; ?></span> 
                        </td>
                         <?php /** Display playlist idcolumn  */ ?>
                        <td class="id-column column-id  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"> <span class="playlistTitleElement"><?php echo $playlistDetail->playlist_name; ?></span> 
                        </td> 
                         <?php /** Display playlist name column  */ ?>
                        <td class="title-column  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"><span class="playlistShortcodeElement">[categoryvideothumb type=playlist id=<?php echo $playlistDetail->id; ?> rows=3 cols=3]</span>
                        </td> 
                         <?php /** Display playlist ordering column */ ?>
                    </tr>
              <?php /** For each to diplay playlist data ends */
              $index++;
                     }
                     
                    /** Check count of playlist is empty, to display not found message */
                    if ( empty($playlistDetails ) ) { ?> 
                    <tr class="no-items  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>"><td class="colspanchange" colspan="3"> No Playlist found. </td> </tr> 
                    <?php } 
                    /** Display playlist data section Ends
                     * Footer heading Starts */ ?> 
                </tbody>
                <tfoot> 
                    <tr> 
                        <!-- <th scope="col" style="visibility:hidden" class="manage-column column-cb check-column" style=""> <input type="checkbox" name="" id="manage-column-category-1" > </th>--> 
                        <th scope="col"  style="padding:5px;" class="manage-column column-id sortable desc  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" >  
                            <span><?php esc_attr_e( 'ID', APPTHA_VGALLERY ); ?></span> 
                             </th> 
                        <th class="manage-column column-name sortable desc  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" scope="col" style="padding:5px;"> 
                          
                            <span><?php esc_attr_e( 'Title', APPTHA_VGALLERY ); ?></span> </th> 
                        <th scope="col" class="manage-column column-sortorder sortable desc  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" style="padding:5px;"> 
                           
                            <span><?php esc_attr_e( 'Shortcode', APPTHA_VGALLERY ); ?></span>  
                        
                        </th> 
                    </tr> 
                </tfoot> 
                <?php /** Footer heading Ends */ ?>
             </table>
                   
             <div style="clear: both;"></div>
             <!-- Footer filter options Starts -->
             <div class="alignleft actions  <?php echo VIDEOGALLERY_USER_PLAYLIST;?>" style="margin-top:10px;">
                 <?php /** Call function to display filter option in bottom   */
                 ?>
             </div>
       <?php /** Footer pagination drop down  */
             echo paginateLinks ( $total, $playlistLimit, $playlistPagenum, 'admin', '' );
             /** Footer filter options Ends */ ?>
          </form> 
          <?php /** Playlist grid form Ends */ ?>
        </div> 
    </div>
    <?php /**  Playlist add/ grid section Starts */ ?> 
</div>
<?php  /** Playlist admin page Ends */ ?>