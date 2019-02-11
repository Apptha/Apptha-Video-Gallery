<?php
/**
 * Video setting view file. 
 * 
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
/** Get player color settings data */
$player_colors = unserialize( $settingsGrid->player_colors );
/** Assign common div name, table name */
$portletDiv = '<div class="portlet"><div class="portlet-header">';
$portletContentDiv = '<div class="portlet-content"><table class="form-table">';
$gallerySeparatorDiv = '<tr class="gallery_separator">';
$checked = 'checked="checked"';
/** Display video settings page starts */
?>
<div class="apptha_gallery apptha_settings_label"> 
<?php /** Call function to display admin tabs in settings page */
      echo displayAdminTabs ( 'settings' ) ;?>
      <div id="trackcodeerror"></div> 
      <?php /** Display settings page status */ 
      if($displayMsg) {
        echo displayStatusMeassage ( $displayMsg ); 
      }?> 
     <?php /** Include css files, form actions */ ?>
      <div class="wrap"> 
         <link rel="stylesheet" href="<?php echo APPTHA_VGALLERY_BASEURL. 'admin/css/jquery.ui.all.css'; ?>"> 
         <form method="post" enctype="multipart/form-data" action="admin.php?page=hdflvvideosharesettings" >
         <?php /** Display settings page title and icon */ ?> 
         <h2 class="option_title"> <?php echo '<img src="' . getImagesDirURL() . 'setting.png" alt="move" width="30"/>'; ?> 
             <?php esc_attr_e( 'Settings', APPTHA_VGALLERY ); ?> 
             <input class='button-primary' id='videogallery_setting' style="float:right; "type='submit' name="updatebutton" value='<?php esc_attr_e( 'Update Options', APPTHA_VGALLERY ); ?>'> 
         </h2> 
         <?php /** Display settings page fields starts */ ?>
         <div class="admin_settings"> 
            <div class="column"> 
                <?php /**  License settings Starts
                		*  Show licence key if available
                		*  Buy now option in licence key section */ ?>
                <?php echo $portletDiv; ?><b>
                <?php esc_attr_e( 'License Configuration', APPTHA_VGALLERY ); ?></b> </div> 
                             <?php echo $portletContentDiv . $gallerySeparatorDiv; ?> 
                             <?php /** Display filed to get license */?> 
                                <th scope='row'> <?php esc_attr_e( 'License Key', APPTHA_VGALLERY ); ?> </th> 
                                <?php /** Display buy now button */?> 
                                <td valign="top"> <input type='text' name="license" value="<?php echo $settingsGrid->license ; ?>"  style="float: left;" size="45" /> 
                                    <?php if ( isset( $settingsGrid->license ) && ( !strpos( $settingsGrid->license ,'CONTUS' ) ) ) { ?>
                                        <?php echo '<a class="buynow-btn" target="_blank" href="http://www.apptha.com/checkout/cart/add/product/12"><img valign="top" src="' . getImagesDirURL(). 'buynow.gif" alt="Buy"/></a>'; 
                                    } ?>
                                </td>
                            </tr>
                        </table>
                    </div> 
                </div> 
                <?php
                /**
                 * License settings Ends
                 * and
                 * Logo settings Starts
                 * Display logo configuration 
                 */
                 ?>
                <?php echo $portletDiv; ?> 
                <b> <?php esc_attr_e( 'Logo Configuration', APPTHA_VGALLERY ); ?></b> </div> 
                        <?php echo $portletContentDiv. $gallerySeparatorDiv; ?> 
                        <?php /** Display filed to get logo path  */?> 
                                    <th scope='row'><?php esc_attr_e( 'Logo Path', APPTHA_VGALLERY ); ?></th> 
                                    <td> <input type='file' id="logopath" name="logopath" value="" size=40  /> 
                                        <input type='hidden' id="logopathvalue" name="logopathvalue" value="<?php echo $settingsGrid->logopath ; ?>" /> 
                                        <div class="videogallery_logo_cancel"> <span id="logoname" style="float: left;"><?php echo $settingsGrid->logopath; ?></span> 
                                            <span id="removepng"><?php if($settingsGrid->logopath) { 
                                              echo '<img src="' . getImagesDirURL() .'cancel.png" onclick="removeLogo();" alt="removelogo" />'; 
                                            } ?></span>
                                        </div>
                                    </td> 
                                </tr> 
                                <?php /** Display logo Target */ ?>
                                <?php echo $gallerySeparatorDiv; ?>  
                                <?php /** Display filed to get logo target */?> 
                                    <th scope='row'><?php esc_attr_e( 'Logo Target', APPTHA_VGALLERY ); ?></th> 
                                    <?php /** Set logo target page */?>
                                    <td><input type='text' name="logotarget" value="<?php if ( isset( $settingsGrid->logo_target ) ) { 
                                          echo $settingsGrid->logo_target ; 
                                        } ?>" size=45  /><br><br/>
                                        <?php esc_attr_e( '', APPTHA_VGALLERY ) ?></td> 
                                </tr> 
                                <?php /** Display logo align */ ?>
                                <?php echo $gallerySeparatorDiv; ?>  
                                <?php /** Display filed to get logo align 
                                		* Top-Left,Top-right,Bottom-Left,Bottom-right*/?> 
                                     <th scope='row'><?php esc_attr_e( 'Logo Align', APPTHA_VGALLERY ); ?></th> 
                                     <td> <select name="logoalign" style="width:150px;"> 
                                     <option <?php if ( $settingsGrid->logoalign == 'TL' ) { ?> selected="selected" <?php } ?> value="TL">
                                     <?php esc_attr_e( 'Top Left', APPTHA_VGALLERY ); ?></option> 
                                     <option <?php if ( $settingsGrid->logoalign == 'TR' ) { ?> selected="selected" <?php } ?> value="TR">
                                     <?php esc_attr_e( 'Top Right', APPTHA_VGALLERY ); ?></option> 
                                     <option <?php if ( $settingsGrid->logoalign == 'BL' ) { ?> selected="selected" <?php } ?> value="BL">
                                     <?php esc_attr_e( 'Left Bottom', APPTHA_VGALLERY ); ?></option> 
                                     <option <?php if ( $settingsGrid->logoalign == 'BR' ) { ?> selected="selected" <?php } ?> value="BR">
                                     <?php esc_attr_e( 'Right Bottom', APPTHA_VGALLERY ); ?></option> 
                                     </select> </td> 
                                </tr> 
                                <?php /** Display logo alpha */ ?>
                                <?php echo $gallerySeparatorDiv; ?>
                                <?php /** Display filed to get logo alpha */?>   
                                     <th scope='row'><?php esc_attr_e( 'Logo Alpha', APPTHA_VGALLERY ); ?></th> 
                                     <td><input type='text' name="logoalpha" value="<?php echo $settingsGrid->logoalpha ; ?>" size=45  /></td> 
                                </tr> 
                            </table> 
                        </div> 
                   </div> 
                   <?php /**  Logo settings Ends */ 
                   /**  Player configuration Starts */ ?>
                   <?php echo $portletDiv; ?> 
                   <b><?php esc_attr_e( 'Player Configuration', APPTHA_VGALLERY ); ?></b></div> 
                                   <?php echo $portletContentDiv . $gallerySeparatorDiv; ?>  
                                   <?php /** Display Auto Play */ ?><th scope='row'>
                                   <?php esc_attr_e( 'Auto Play', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' name="autoplay" <?php if ( $settingsGrid->autoplay == 1 ) { ?> checked <?php } ?> value="1" size=45  /></td> 
                                   </tr> 
                                   <?php /** Display Player Width */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'>
                                       <?php esc_attr_e( 'Player Width', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='text' name="width" value="<?php echo $settingsGrid->width ; ?>" size=45  /></td> 
                                   </tr> 
                                   <?php /** Display Player Height */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'>
                                       <?php esc_attr_e( 'Player Height', APPTHA_VGALLERY ); ?></th> <td>
                                       <input type='text' name="height" value="<?php echo $settingsGrid->height ; ?>" size=45  /></td> 
                                   </tr> 
                                   <?php /** Display Player Stage Color */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Stage Color', APPTHA_VGALLERY ); ?></th> 
                                       <td><input name="stagecolor" type='text'
                                       value="<?php echo $settingsGrid->stagecolor; ?>" size=45  /> <br />
                                       <?php esc_attr_e( 'Ex : 0xdddddd ', APPTHA_VGALLERY ) ?> </td> 
                                   </tr> 
                                   <?php /** Display Player Download */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                   <th scope='row'><?php esc_attr_e( 'Download', APPTHA_VGALLERY ); ?></th> <td><input type='checkbox' class='check' 
                                   name="download"  size=45 <?php if ( $settingsGrid->download == 1 ) { ?> checked <?php } ?> value="1"  /></td> 
                                   </tr> 
                                   <?php /** Display Buffer */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Buffer', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='text' value="<?php echo $settingsGrid->buffer ; ?>" name="buffer" size=45  /></td></tr> 
                                   <?php /** Display Volume */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  <th scope='row'>
                                   <?php esc_attr_e( 'Volume', APPTHA_VGALLERY ); ?></th> 
                                       <td><input name="volume" type='text' value="<?php echo  $settingsGrid->volume; ?>" size=45  /></td></tr> 
                                   <?php /** New feature  for enable /disable  social icon  posted by and related video  under  player */ ?>
                                   <?php /** Display Social Icon */ ?> 
                                   <?php echo $gallerySeparatorDiv; ?><th scope='row'>
                                   <?php esc_attr_e( 'Social Icon', APPTHA_VGALLERY ); ?></th><td><input type='checkbox' 
                                   class='check' name="showSocialIcon" <?php if ( $player_colors['show_social_icon']== 1 ) { ?> checked <?php } ?> value="1" size=45  /></td> 
                                   </tr>
                                   <?php /** Display Posted By */ ?> 
                                   <?php echo $gallerySeparatorDiv; ?> <th scope='row'>
                                   <?php esc_attr_e( 'Posted By', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' name="ShowPostBy" <?php if ( $player_colors['show_posted_by']== 1 ) { ?> checked <?php } ?> 
                                      size=45 value="1"   /></td> 
                                   </tr> 
                                   <?php /** Display related video */  echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Show related video', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' name="show_related_video" <?php if ( isset( $player_colors['show_related_video'] ) && $player_colors['show_related_video'] == 1 ) { ?> checked <?php } ?> value="1" size=45  /></td>
                                   </tr> 
                                   <?php /** Display Added On */  echo $gallerySeparatorDiv; ?> <th scope='row'>
                                   <?php esc_attr_e( 'Show Added On', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' name="show_added_on" <?php if ( $player_colors['show_added_on']== 1 ) { ?> checked <?php } ?> value="1" size=45  /></td> 
                                   </tr> 
                                   <?php /** Rss Disable / Enable option */  ?> 
                                   <?php echo $gallerySeparatorDiv; ?> <th scope='row'>
                                   <?php esc_attr_e( 'Show Rss Feed Icon', APPTHA_VGALLERY ); ?></th> <td>
                                   <input class='check' type='checkbox' name="show_rss_icon" <?php if ( $player_colors['show_rss_icon']== 1 ) { ?> checked <?php } ?> value="1" size=45  /></td> 
                                   </tr> 
                               </table>
                           </div> 
                       </div>
                       <?php /**  Player configuration Ends */ 
                       /**  General settings Starts 
                        * Settings displayed around player */ ?>
                       <?php echo $portletDiv; ?>
                       <b><?php esc_attr_e( 'General Settings', APPTHA_VGALLERY ); ?></b></div> 
                                   <?php /** Disaplay ffmpeg path */  ?>
                                   <?php echo $portletContentDiv . $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'FFMPEG Path', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='text' name="ffmpeg_path" value="<?php echo $settingsGrid->ffmpeg_path ; ?>" size=45  /></td> 
                                   </tr> 
                                   <?php /** Disaplay player normal scale
                                   		   * Drop Down options for display ratios */  ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Normal Scale', APPTHA_VGALLERY ); ?></th>
                                       <td> <select name="normalscale" style="width:150px;"> 
                                       <option value="0" <?php if ( $settingsGrid->normalscale == 0 ) { ?> selected="selected" <?php } ?> >
                                       <?php esc_attr_e( 'Aspect Ratio', APPTHA_VGALLERY ); ?></option> 
                                       <option value="1" <?php if ( $settingsGrid->normalscale == 1 ) { ?> selected="selected" <?php } ?>>
                                       <?php esc_attr_e( 'Original Screen', APPTHA_VGALLERY ); ?></option> 
                                       <option value="2" <?php if ( $settingsGrid->normalscale == 2 ) { ?> selected="selected" <?php } ?>>
                                       <?php esc_attr_e( 'Fit To Screen', APPTHA_VGALLERY ); ?></option> 
                                       </select> </td> 
                                   </tr>
                                   <?php /** Disaplay player full screen scale */  ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Full Screen Scale', APPTHA_VGALLERY ); ?></th> 
                                       <td> <select name="fullscreenscale" style="width:150px;"> 
                                       <option value="0" <?php if ( $settingsGrid->fullscreenscale == 0 ) { ?> selected="selected" <?php } ?>>
                                       <?php esc_attr_e( 'Aspect Ratio', APPTHA_VGALLERY ); ?></option> 
                                       <option value="1" <?php if ( $settingsGrid->fullscreenscale == 1 ) { ?> selected="selected" <?php } ?>>
                                       <?php esc_attr_e( 'Original Screen', APPTHA_VGALLERY ); ?></option> 
                                       <option value="2" <?php if ( $settingsGrid->fullscreenscale == 2 ) { ?> selected="selected" <?php } ?>>
                                       <?php esc_attr_e( 'Fit To Screen', APPTHA_VGALLERY ); ?></option> 
                                       </select> </td>
                                   </tr>
                                   <?php /** Disaplay player embed visible */  ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Embed Visible', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' <?php if ( $settingsGrid->embed_visible == 1 ) { ?> checked <?php } ?> name="embed_visible" value="1" size=45  /></td> 
                                   </tr> 
                                   <?php /** Iframe visible  */ ?> 
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Iframe Visible', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' <?php if (isset($player_colors['iframe_visible'])&&$player_colors['iframe_visible']==1 ) { ?> checked <?php } ?> name="iframe_visible" value="1" size=45  /></td> 
                                   </tr> 
                                   <?php /** Report video setting */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Enable Report', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' <?php if ( $player_colors['report_visible'] == 1 ) { ?> checked <?php } ?> name="report_visible" value="1" size=45  /></td> 
                                   </tr>
                                   <?php /** Display views setting */ ?>
                                   <?php echo $gallerySeparatorDiv; ?> 
                                       <th scope='row'><?php esc_attr_e( 'Enable Views', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' <?php if ( $settingsGrid->view_visible == 1 ) { ?> checked <?php } ?> name="view_visible" value="1" size=45  /></td> 
                                   </tr> 
                                   <?php /** Display ratings setting */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Enable Ratings', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' <?php if ( $settingsGrid->ratingscontrol == 1 ) { ?> checked <?php } ?> name="ratingscontrol" value="1" size=45  /></td> 
                                   </tr> 
                                   <?php /** Display Tags setting */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Enable Tags', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' <?php if ( $settingsGrid->tagdisplay == 1 ) { ?> checked <?php } ?> name="tagdisplay" value="1" size=45  /></td> 
                                   </tr>
                                   <?php /** Display Category setting */ ?>
                                   <?php echo $gallerySeparatorDiv; ?> 
                                       <th scope='row'><?php esc_attr_e( 'Enable Category', APPTHA_VGALLERY ); ?></th>
                                       <td><input type='checkbox' class='check' <?php if ( $settingsGrid->categorydisplay == 1 ) { ?> checked <?php } ?> name="categorydisplay" value="1" size=45  /></td>
                                   </tr>
                                   <?php /**  Display title on Home  , Category details page  */ ?> 
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Enable video title in Home page', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' <?php if (isset($player_colors['showTitle']) && $player_colors['showTitle'] == 1 ) { ?> checked <?php } ?> name="showTitle" value="1" size=45  /></td> 
                                   </tr> 
                                   <?php /**  Display Description on the player*/ ?> 
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Show Description', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' name="showTag" <?php if ( $settingsGrid->showTag == 1 ) { ?> checked <?php } ?> value="1" size=45  /></td> 
                                   </tr> 
                                   <?php /**  Display Default Image*/ ?> 
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Display Default Image', APPTHA_VGALLERY ); ?></th> 
                                       <td><input type='checkbox' class='check' name="imageDefault" <?php if ( $settingsGrid->imageDefault == 1 ) { ?> checked <?php } ?> value="1" size=45  /></td> 
                                   </tr> 
                                   <?php /**  Subtitle settings Starts */ ?>
                                   <?php echo $gallerySeparatorDiv; ?> 
                                       <th scope='row'>
                                       <?php esc_attr_e( 'Subtitle Text Color', APPTHA_VGALLERY ); ?></th>
                                       <td> <input name="subTitleColor" type='text' value="<?php if ( ! empty( $player_colors['subTitleColor'] ) ) { 
                                         echo $player_colors['subTitleColor'] ;  
                                       } ?>" size=45  /> </td>
                                   </tr> 
                                   <?php /** Display Subtitle Background Color setting */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Subtitle Background Color', APPTHA_VGALLERY ); ?></th> 
                                       <td> 
                                       <input type='text' name="subTitleBgColor" value="<?php if ( ! empty( $player_colors['subTitleBgColor'] ) ) { 
                                         echo $player_colors['subTitleBgColor'] ; 
                                       } ?>" size=45  /></td> </tr> 
                                   <?php /** Display Subtitle font family */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Subtitle Font Family', APPTHA_VGALLERY ); ?></th> 
                                       <td> <input type='text' value="<?php if ( ! empty( $player_colors['subTitleFontFamily'] ) ) { 
                                         echo $player_colors['subTitleFontFamily'] ; 
                                       } ?>" name="subTitleFontFamily" size=45  /></td></tr> 
                                   <?php /** Display Subtitle font size */ ?>
                                   <?php echo $gallerySeparatorDiv; ?>  
                                       <th scope='row'><?php esc_attr_e( 'Subtitle Font Size', APPTHA_VGALLERY ); ?></th> 
                                       <td> <input type='text' size=45  name="subTitleFontSize" value="<?php if ( ! empty( $player_colors['subTitleFontSize'] ) ) { 
                                         echo $player_colors['subTitleFontSize'] ; 
                                       } ?>"/> </td></tr> 
                                   <?php /**  Subtitle settings Ends */ ?>
                               </table> 
                           </div> 
                       </div>
                       <?php /**  General settings Ends */ 
                       /**  Player color settings Starts */ ?>
                       <?php echo $portletDiv; ?>
                       <?php esc_attr_e( 'Player Color Settings', APPTHA_VGALLERY ); ?> 
                          <?php esc_attr_e( 'Ex : 0xdddddd ', APPTHA_VGALLERY ) ?></b></div> 
                                  <?php /** Share Popup Header color */ ?>
                                      <?php echo $portletContentDiv . $gallerySeparatorDiv; ?>  
                                          <th scope='row'> <?php esc_attr_e( 'Share Popup Header Color', APPTHA_VGALLERY ); ?> </th>
                                          <td> <input type='text' name="sharepanel_up_BgColor" value="<?php echo $player_colors['sharepanel_up_BgColor']; ?>" size=45 /> </td> 
                                      </tr> 
                                      <?php /** Share Popup Background color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'> 
                                          <?php esc_attr_e( 'Share Popup Background Color', APPTHA_VGALLERY ); ?> 
                                          </th> 
                                          <td><input name="sharepanel_down_BgColor" type='text' value="<?php echo $player_colors['sharepanel_down_BgColor'] ; ?>" size=45  /> </td> 
                                      </tr>
                                      <?php /** Share Popup Text color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?> <th scope='row'>
                                      <?php esc_attr_e( 'Share Popup Text Color', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='text' value="<?php echo $player_colors['sharepaneltextColor'] ; ?>" name="sharepaneltextColor" size=45  /> </td> 
                                      </tr>  
                                      <?php /** Send Button Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  <th scope='row'>
                                      <?php esc_attr_e( 'Send Button Color', APPTHA_VGALLERY ); ?></th><td>
                                      <input type='text' name="sendButtonColor" size=45 value="<?php echo $player_colors['sendButtonColor'] ; ?>"   /> </td> 
                                      </tr> 
                                      <?php /** Send Button Text Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?> <th scope='row'>
                                      <?php esc_attr_e( 'Send Button Text Color', APPTHA_VGALLERY ); ?></th> <td><input type='text' 
                                          value="<?php echo $player_colors['sendButtonTextColor']; ?>" name="sendButtonTextColor"  size=45  /> </td> 
                                      </tr> 
                                      <?php /** Player Text Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Player Text Color', APPTHA_VGALLERY ); ?></th> 
                                          <td>
                                          <input type='text' name="textColor" value="<?php echo $player_colors['textColor']; ?>" size=45  /> 
                                          </td> 
                                      </tr> 
                                      <?php /** Skin Background Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Skin Background Color', APPTHA_VGALLERY ); ?></th> 
                                          <td> 
                                          <input type='text' name="skinBgColor" value="<?php echo $player_colors['skinBgColor'] ; ?>" size=45  /> </td> </tr> 
                                      <?php /** Seek Bar Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?> <th scope='row'>
                                      <?php esc_attr_e( 'Seek Bar Color', APPTHA_VGALLERY ); ?></th> 
                                          <td> <input type='text' name="seek_barColor" value="<?php echo $player_colors['seek_barColor'] ; ?>" size=45  /> </td> 
                                      </tr> 
                                      <?php /** Buffer Bar Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Buffer Bar Color', APPTHA_VGALLERY ); ?></th> 
                                          <td> <input name="buffer_barColor" type='text' value="<?php echo $player_colors['buffer_barColor'] ; ?>" size=45  /> </td> 
                                      </tr> 
                                      <?php /** Skin Icons Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Skin Icons Color', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='text' value="<?php echo $player_colors['skinIconColor']; ?>" name="skinIconColor" size=45  /> </td> 
                                      </tr> 
                                      <?php /** Progress Bar Background Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Progress Bar Background Color', APPTHA_VGALLERY ); ?></th> 
                                          <td><input size=45 type='text' name="pro_BgColor" value="<?php echo $player_colors['pro_BgColor']; ?>"   /> </td> 
                                      </tr> 
                                      <?php /** Play Button Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Play Button Color', APPTHA_VGALLERY ); ?></th> 
                                          <td><input name="playButtonColor" value="<?php echo $player_colors['playButtonColor']; ?>" type='text' size=45  /> </td>
                                      </tr> 
                                      <?php /** Play Button Background Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Play Button Background Color', APPTHA_VGALLERY ); ?></th> 
                                          <td><input name="playButtonBgColor" value="<?php echo $player_colors['playButtonBgColor']; ?>" size=45 type='text'  /> </td> 
                                      </tr> 
                                      <?php /** Player Buttons Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Player Buttons Color', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='text' name="playerButtonColor" 
                                          value="<?php echo $player_colors['playerButtonColor']; ?>" size=45  /> </td> 
                                      </tr> 
                                      <?php /** Player Buttons Background Color */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Player Buttons Background Color', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='text' id = "playerButtonBgColor" name="playerButtonBgColor" value="<?php echo $player_colors['playerButtonBgColor']; ?>" size=45  /> </td> 
                                      </tr> 
                                      <?php /** Related Videos Background Color */ ?> 
                                      <tr class="gallery_separator" id="related_bgColor" style="display:none;"> <th scope='row'><?php esc_attr_e( 'Related Videos Background Color', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='text' name="relatedVideoBgColor" value="<?php echo $player_colors['relatedVideoBgColor']; ?>" size=45  /> </td> 
                                      </tr> 
                                      <?php /** Related Videos Scroll Bar Color */ ?> <tr class="gallery_separator" id="related_scroll_barColor" style="display:none;"> 
                                          <th scope='row'><?php esc_attr_e( 'Related Videos Scroll Bar Color', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='text' name="scroll_barColor" value="<?php echo $player_colors['scroll_barColor']; ?>" size=45  /> </td> 
                                      </tr> 
                                      <?php /** Related Videos Scroll Bar Background Color */ ?> 
                                      <tr class="gallery_separator" id="related_scroll_barbgColor" style="display:none;"> 
                                          <th scope='row'><?php esc_attr_e( 'Related Videos Scroll Bar Background Color', APPTHA_VGALLERY ); ?></th> <td><input type='text' name="scroll_BgColor" 
                                          value="<?php echo $player_colors['scroll_BgColor']; ?>" size=45  /> </td>  </tr> 
                                  </table> 
                              </div> 
                          </div>
                      </div> 
                      <?php /**  Player color settings Ends */
                      /**  Player configuration Starts */ ?>
                      <div class="column">
                          <?php echo $portletDiv; ?>
                          <?php esc_attr_e( 'Playlist Configuration', APPTHA_VGALLERY ); ?></b></div>
                                      <?php /** Select Playlist*/ ?>
                                      <?php echo $portletContentDiv . $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Playlist', APPTHA_VGALLERY ); ?></th> 
                                          <td> <input type='checkbox' class='check' name="playlist" <?php if ( $settingsGrid->playlist == 1 ) { ?> checked <?php } ?> value="1"  /></td> 
                                      </tr> 
                                      <?php /** Select Playlist Open*/ ?>
                                      <tr class="gallery_separator" id="related_playlist_open" style="display:none;"> 
                                          <th scope='row'><?php esc_attr_e( 'Playlist Open', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='checkbox' class='check' name="playlist_open" <?php if ( $settingsGrid->playlist_open == 1 ) { ?> checked <?php } ?> value="1"  /></td>
                                      </tr> 
                                      <?php /** Select HD Default*/ ?>
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'HD Default', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='checkbox' class='check' name="HD_default" <?php if ( $settingsGrid->HD_default == 1 ) { ?> checked <?php } ?> value="1"  /></td> 
                                      </tr> 
                                      <?php /** Select Playlist Autoplay*/ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Playlist Autoplay', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='checkbox' class='check' <?php if ( $settingsGrid->playlistauto == 1 ) { ?> checked <?php } ?> name="playlistauto" value="1" /></td>
                                      </tr>
                                      <?php /** Select Related Video View*/ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Related Video View', APPTHA_VGALLERY ); ?></th> 
                                          <td> <select name="relatedVideoView" onchange="enablerelateditems( this.value )"> 
                                          <option value="side" <?php if ( $settingsGrid->relatedVideoView == 'side' ) { 
                                            echo 'selected=selected'; 
                                          } ?>>side</option> 
                                          <option value="center" <?php if ( $settingsGrid->relatedVideoView == 'center' ) { 
                                            echo 'selected=selected'; 
                                          } ?>>center</option> </select>
                                      </tr>
                                  </table> 
                              </div> 
                          </div>
                          <?php /** Select Ads settings*/ ?> 
                          <?php echo $portletDiv; ?> 
                              <b><?php esc_attr_e( 'Ads Settings', APPTHA_VGALLERY ); ?></b></div> 
                                      <?php /** Preroll */ ?> 
                                      <?php echo $portletContentDiv . $gallerySeparatorDiv; ?>
                                      <?php /** Display filed to enable / disable preroll ads */?>   
                                          <th scope='row'><?php esc_attr_e( 'Preroll Ads', APPTHA_VGALLERY ); ?></th> 
                                          <td> <input name="preroll" id="preroll" type='radio' value="0"  <?php if ( $settingsGrid->preroll == 0 ) { 
                                                  echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label> 
                                                <input name="preroll" id="preroll" type='radio' value="1"  <?php if ( $settingsGrid->preroll == 1 ) { 
                                                  echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label>
                                          </td> 
                                      </tr> 
                                      <?php /** Postroll */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                      <?php /** Display filed to enable / disable postroll ads */?>
                                          <th scope='row'><?php esc_attr_e( 'Postroll Ads', APPTHA_VGALLERY ); ?></th> 
                                          <td> <input name="postroll" id="postroll" type='radio' value="0"  <?php if ( $settingsGrid->postroll == 0 ) { 
                                                  echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label> 
                                                <input name="postroll" id="postroll" type='radio' value="1"  <?php if ( $settingsGrid->postroll == 1 ) { 
                                                  echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label>
                                          </td> 
                                      </tr> 
                                      <?php /** Midroll Ads */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>
                                      <?php /** Display filed to enable / disable midroll ads */?>  
                                          <th scope='row'><?php esc_attr_e( 'Midroll Ads', APPTHA_VGALLERY ); ?></th> 
                                          <td> <input name="midroll_ads" id="midroll_ads" type='radio' value="0"  <?php if ( $settingsGrid->midroll_ads == 0 ) { 
                                                  echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label> 
                                                <input name="midroll_ads" id="midroll_ads" type='radio' value="1"  <?php if ( $settingsGrid->midroll_ads == 1 ) { 
                                                  echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label> 
                                          </td> 
                                      </tr> 
                                      <?php /** IMA Ads */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                      <?php /** Display filed to enable / disable ima ads */?>
                                          <th scope='row'><?php esc_attr_e( 'IMA Ads', APPTHA_VGALLERY ); ?></th> 
                                          <td> <input name="imaAds" id="imaAds" type='radio' value="0" <?php if ( $settingsGrid->imaAds == 0 ) { 
                                                  echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label>
                                                <input name="imaAds" id="imaAds" type='radio' value="1" <?php if ( $settingsGrid->imaAds == 1 ) { 
                                                  echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label> 
                                          </td> 
                                      </tr> 
                                      <?php /** Google adsense option */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                      <?php /** Display filed to enable / disable google adsense */?>
                                          <th scope='row'><?php esc_attr_e( 'Google Ads', APPTHA_VGALLERY ); ?></th> 
                                          <td> <input name="googleadsense_visible" id="googleadsense_visible" type='radio' value="1"  <?php if ( isset($player_colors['googleadsense_visible']) && ($player_colors['googleadsense_visible'] == 1 ) ) { 
                                                  echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label>
                                                <input name="googleadsense_visible" id="googleadsense_visible" type='radio' value="0"  <?php if ( isset($player_colors['googleadsense_visible']) && ($player_colors['googleadsense_visible'] == 0 ) ) {
                                                  echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label> 
                                          </td> 
                                      </tr> 
                                      <?php /** Ad Skip */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                      <?php /** Display filed to enable / disable ads skip */?>
                                          <th scope='row'><?php esc_attr_e( 'Ad Skip', APPTHA_VGALLERY ); ?></th> 
                                          <td> <input name="adsSkip" id="adsSkip" type='radio' value="0"  <?php if ( $settingsGrid->adsSkip == 0 ) { 
                                                    echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label> 
                                                <input name="adsSkip" id="adsSkip" type='radio' value="1"  <?php if ( $settingsGrid->adsSkip == 1 ) { 
                                                    echo 'checked'; 
                                                } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label> 
                                          </td> 
                                      </tr> 
                                      <?php /** Ad Skip Duration */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?> 
                                      <?php /** Display filed to get ads skip duration */?> 
                                          <th scope='row'><?php esc_attr_e( 'Ad Skip Duration', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='text' name="adsSkipDuration" value="<?php echo $settingsGrid->adsSkipDuration ; ?>" size=45  />  
                                      </tr>
                                      <?php /** Track Code */ ?> 
                                      <?php echo $gallerySeparatorDiv; ?>  
                                      <?php /** Display filed to get track code */?>
                                          <th scope='row'><?php esc_attr_e( 'Track Code', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='text' id="trackcode" name="trackCode" value="<?php echo $settingsGrid->trackCode ; ?>" size=45  /> 
                                          <div id="trackcodeerror"></div> </td> 
                                      </tr> 
                                  </table> 
                              </div> 
                          </div> 
                          <?php /**  Player configuration Ends */ 
                           /**  Comment settings Starts */ ?>
                          <?php echo $portletDiv; ?> 
                              <b><?php esc_attr_e( 'Comment Settings', APPTHA_VGALLERY ); ?></b></div> 
                                      <?php echo $portletContentDiv . $gallerySeparatorDiv; ?>  
                                          <th scope='row'><?php esc_attr_e( 'Select Comment Type', APPTHA_VGALLERY ); ?></th> 
                                          <?php /** Display filed to select comment type */?>
                                          <td> <select name="comment_option" onchange="enablefbapi( this.value )"> 
                                                <option value="0" <?php if ( $settingsGrid->comment_option == 0 ) { 
                                                  echo 'selected=selected'; 
                                                } ?>>None</option>
                                                <option value="1" <?php if ( $settingsGrid->comment_option == 1 ) { 
                                                    echo 'selected=selected'; 
                                                } ?>>Default Comment</option>
                                                <option value="2" <?php if ( $settingsGrid->comment_option == 2 ) { 
                                                  echo 'selected=selected'; 
                                                } ?>>Facebook Comment</option>
                                                <option value="3" <?php if ( $settingsGrid->comment_option == 3 ) { 
                                                  echo 'selected=selected'; 
                                                } ?>>DisQus Comment</option> </select> </td> 
                                      </tr>
                                      <?php /** Get facebook api */ ?> 
                                      <tr class="gallery_separator" id="facebook_api"  > 
                                      <?php /** Display filed to get FB API to add videos  */?>
                                          <th scope='row'><?php esc_attr_e( 'App ID', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='text' name="keyApps" value="<?php echo $settingsGrid->keyApps; ?>" size=45  /></td> 
                                      </tr>
                                      <?php /** Disqus api Shot Name*/ ?> 
                                      <tr class="gallery_separator" id="disqus_api" style="display: none;" > 
                                      <?php /** Display filed to get disqus name */?>
                                          <th scope='row'><?php esc_attr_e( 'Shot Name', APPTHA_VGALLERY ); ?></th> 
                                          <td><input type='text' name="keydisqusApps" value="<?php echo $settingsGrid->keydisqusApps; ?>" size=45  /></td> 
                                      </tr> 
                                      <?php /** Facebook api key and link to create*/ ?>
                                      <tr class="gallery_separator" id="facebook_api_link"  ><th> <a href="http://developers.facebook.com/" target="_blank"><?php esc_attr_e( 'Create Facebook App ID', APPTHA_VGALLERY ); ?></a></th></tr> 
                                  </table>
                              </div> 
                          </div> 
                          <?php /**  Comment settings Ends */ 
                          /**  Skin configuration Starts */ ?>
                          <?php echo $portletDiv; ?> 
                          <b><?php esc_attr_e( 'Skin Configuration', APPTHA_VGALLERY ); ?></b></div> 
                              <?php echo $portletContentDiv . $gallerySeparatorDiv; ?>  
                              <?php /** Display filed to enable / disable timer */?>
                                  <th scope='row'><?php esc_attr_e( 'Display Timer', APPTHA_VGALLERY ); ?></th> 
                                  <td> <input type='checkbox' class='check'  name="timer" <?php if ( $settingsGrid->timer == 1 ) { ?> checked <?php } ?> value="1" /></td> 
                              </tr> 
                              <?php /**  Display Zoom Icon */ ?>
                              <?php echo $gallerySeparatorDiv; ?>  
                              <?php /** Display filed to enable / disable zoom */?>
                                  <th scope='row'><?php esc_attr_e( 'Display Zoom', APPTHA_VGALLERY ); ?> </th> 
                                  <td><input type='checkbox' class='check' <?php if ( $settingsGrid->zoom == 1 ) { ?> checked <?php } ?> name="zoom" value="1" />&nbsp;( Not supported for viddler videos )</td> 
                              </tr>
                              <?php /** Display Email Icon*/ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                              <?php /** Display filed to enable / disable email */?>
                                  <th scope='row'><?php esc_attr_e( 'Display Email', APPTHA_VGALLERY ); ?></th>
                                  <td><input type='checkbox' class='check'  name="email" <?php if ( $settingsGrid->email == 1 ) { ?> checked <?php } ?>value="1"   /></td>
                              </tr> 
                              <?php /** Display Share Icon*/ ?> 
                              <?php echo $gallerySeparatorDiv; ?>  
                              <?php /** Display filed to enable / disable share */?>
                                  <th scope='row'><?php esc_attr_e( 'Display Share', APPTHA_VGALLERY ); ?></th> 
                                  <td><input type='checkbox' class='check'  name="shareIcon" <?php if ( $settingsGrid->shareIcon == 1 ) { ?> checked <?php } ?>value="1"   /></td> 
                              </tr>
                              <?php /** Display Volume Icon*/ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                              <?php /** Display filed to enable / disable volume */?>
                                  <th scope='row'><?php esc_attr_e( 'Display Volume', APPTHA_VGALLERY ); ?></th>
                                  <td><input type='checkbox' class='check'  name="volumecontrol" <?php if ( $settingsGrid->volumecontrol == 1 ) { ?> checked <?php } ?>value="1"   /></td>
                              </tr>
                              <?php /** Display Progress Bar*/ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                              <?php /** Display filed to enable / disable progress bar */?>
                                  <th scope='row'><?php esc_attr_e( 'Display Progress Bar', APPTHA_VGALLERY ); ?></th>
                                  <td><input type='checkbox' class='check'  name="progressControl" <?php if ( $settingsGrid->progressControl == 1 ) { ?> checked <?php } ?>value="1"   /></td>
                              </tr>
                              <?php /** Display Full Screen */ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                              <?php /** Display filed to enable / disable full screen */?>
                                  <th scope='row'><?php esc_attr_e( 'Display Full Screen', APPTHA_VGALLERY ); ?></th>
                                  <td><input type='checkbox' class='check' <?php if ( $settingsGrid->fullscreen == 1 ) { ?> checked <?php 
                                  } ?> name="fullscreen" value="1" size=45  /></td>
                              </tr>
                              <?php /** Display Skin Autohide */ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                              <?php /** Display filed to enable / disable skin autohide */?>
                                  <th scope='row'><?php esc_attr_e( 'Skin Autohide', APPTHA_VGALLERY ); ?></th>
                                  <td><input type='checkbox' class='check' <?php if ( $settingsGrid->skin_autohide == 1 ) { ?> checked <?php 
                                  } ?> name="skin_autohide" value="1" size=45  /></td>
                              </tr>
                              <?php /** Display Skin Visible */ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                              <?php /** Display filed to enable / disable skin visible  */?>
                                  <th scope='row'><?php esc_attr_e( 'Skin Visible', APPTHA_VGALLERY ); ?></th>
                                  <td><input type='checkbox' class='check' <?php if ( isset( $player_colors['skinVisible'] ) && $player_colors['skinVisible'] == 1 ) { ?> checked <?php 
                                      } ?> name="skinVisible" value="1" size=45  /></td>
                              </tr>
                              <?php /** Display Skin Opacity */ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                              <?php /** Display filed to enable / disable skin opacity */?>
                                  <th scope='row'><?php esc_attr_e( 'Skin Opacity', APPTHA_VGALLERY ); ?></th>
                                  <td><input type='text' name="skin_opacity" value="<?php if ( isset( $player_colors['skin_opacity'] ) ) { 
                                    echo $player_colors['skin_opacity']; 
                                  } ?>" size=45  /><br/> ( Range from 0 to 1 ) </td>
                              </tr>
                          </table>
                      </div>
                  </div>
                  <?php /**  Skin configuration Ends */ 
                  /**  Videos Page settings Starts */ ?>
                  <?php echo $portletDiv; ?>
                      <b><?php esc_attr_e( 'Videos Page Settings', APPTHA_VGALLERY ); ?></b></div>
                              <?php /** Display Gutter Space */ ?>
                              <?php echo $portletContentDiv . $gallerySeparatorDiv; ?>  
                              <th> <?php /** Display filed to get gutter space */?>
                              <?php esc_attr_e( 'Gutter Space ( px )', APPTHA_VGALLERY ); ?></th>
                                  <td> <input type="text" name="gutterspace" id="gutterspace" size="20" value="<?php echo $settingsGrid->gutterspace; ?>"></td> 
                              </tr>
                              <?php /** Related video count setting */ ?>
                              <?php echo $gallerySeparatorDiv; ?> <th>
                              <?php esc_attr_e( 'Limit Related Videos count', APPTHA_VGALLERY ); ?></th> <td>
                              <input name="related_video_count" type="text" id="related_video_count" size="20" value="<?php echo $player_colors['related_video_count']; ?>"></td> 
                              </tr>
                              <?php /** Playlist Count */ ?>
                              <?php echo $gallerySeparatorDiv; ?> <th>
                              <?php esc_attr_e( 'Limit Playlist count', APPTHA_VGALLERY ); ?></th> <td>
                              <input name="playlist_count" type="text" id="related_video_count" size="20" value="<?php echo $player_colors['playlist_count']; ?>"></td> 
                              </tr>
                              <?php /** No Of Categories in Home page setting */ ?>
                              <?php echo $gallerySeparatorDiv; ?> <th>
                              <?php esc_attr_e( 'No Of Categories in Home page', APPTHA_VGALLERY ); ?></th> 
                              <td><input type="text" id="category_page" name="category_page"  size="20" 
                              value="<?php echo $settingsGrid->category_page; ?>"></td>
                              </tr>
                              <?php /** Order selected by the recent videos */ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                                  <th><?php esc_attr_e('Videos Order', APPTHA_VGALLERY ); ?></th>
                                  <td> <select name="recent_video_order" class="recent_video_order_setting"> 
                                        <option value="id" <?php if($player_colors['recentvideo_order'] =='id'){ 
                                          echo "selected='selected'";
                                        } ?>> <?php echo esc_attr('Recent',APPTHA_VGALLERY); ?> </option> 
                                        <option value="hitcount" <?php if($player_colors['recentvideo_order'] =='hitcount'){ 
                                          echo "selected='selected'";
                                        } ?>> <?php echo esc_attr('Most viewed',APPTHA_VGALLERY); ?> </option>
                                        <option value="default" <?php if($player_colors['recentvideo_order'] =='default'){ 
                                          echo "selected='selected'";
                                        } ?>> <?php echo esc_attr('Default ( Ordering)',APPTHA_VGALLERY); ?> </option> 
                                        </select>
                                        <div><?php echo esc_attr('Only Applicable for Featured and  Category Videos',APPTHA_VGALLERY);?></div> 
                                  </td> 
                              </tr> 
                              <?php /** Enable / disbale Popular Videos */ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                              <th><?php esc_attr_e( 'Popular Videos', APPTHA_VGALLERY ); ?></th> 
                              <td> <input  type='radio' name="popular"  value="1" <?php if ( $settingsGrid->popular == 1 ) { 
                                    echo 'checked'; 
                                    } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label>
                                    <input type='radio' name="popular"  value="0"  <?php if ( $settingsGrid->popular == 0 ) { 
                                      echo 'checked'; 
                                    } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label>
                              </td> </tr>
                              <?php /** Rows , columns for Popular Videos */ ?>
                              <tr class="gallery_separator_row"> <td>
                              <label><?php esc_attr_e( 'Rows', APPTHA_VGALLERY ); ?></label>
                                  <input id="rowsPop" name="rowsPop" size="10" type="text"   value="<?php echo $settingsGrid->rowsPop ; ?>"></td>
                                  <td><label><?php esc_attr_e( 'Columns', APPTHA_VGALLERY ); ?> </label>
                                  <input  name="colPop" type="text"  id="colPop" size="10" 
                                  value="<?php echo $settingsGrid->colPop; ?>"></td>
                              </tr> <?php /** Recent Videos*/ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                              <?php /** Enable / disbale Recent Videos */ ?>
                              <th><?php esc_attr_e( 'Recent Videos', APPTHA_VGALLERY ); ?></th>
                              <td> <input type='radio' name="recent"  value="1" <?php if ( $settingsGrid->recent == 1 ) { 
                                    echo 'checked'; 
                                    } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label>
                                    <input type='radio' name="recent"  value="0"  <?php if ( $settingsGrid->recent == 0 ) { 
                                    echo 'checked'; 
                                    } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label> </td>
                              </tr>
                              <?php /** Rows , columns for Recent Videos */ ?>
                              <tr class="gallery_separator_row"> <td><label><?php esc_attr_e( 'Rows', APPTHA_VGALLERY ); ?></label>
                                  <input type="text" name="rowsRec" size="10" id="rowsRec" value="<?php echo $settingsGrid->rowsRec ; ?>"></td>
                                  <td><label><?php esc_attr_e( 'Columns', APPTHA_VGALLERY ); ?> </label>
                                  <input name="colRec" type="text"  id="colRec" size="10" value="<?php echo $settingsGrid->colRec; ?>"> </td>
                              </tr>
                              <?php /** Featured Videos  */ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                                  <th><?php esc_attr_e( 'Featured Videos', APPTHA_VGALLERY ); ?></th>
                                  <td> <input type='radio' name="feature"  value="1" <?php if ( $settingsGrid->feature == 1 ) {
                                    echo 'checked'; 
                                  } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label> 
                                  <input  type='radio' name="feature" value="0" <?php if ( $settingsGrid->feature == 0 ) { 
                                    echo 'checked'; 
                                  } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label> 
                                  </td> 
                              </tr> 
                              <?php /** Rows , columns for Featured Videos */ ?>
                              <tr class="gallery_separator_row">
                                  <td><label><?php esc_attr_e( 'Rows', APPTHA_VGALLERY ); ?></label>
                                  <input  id="rowsFea" name="rowsFea" type="text" size="10" value="<?php echo $settingsGrid->rowsFea ; ?>"></td> 
                                  <td><label><?php esc_attr_e( 'Columns', APPTHA_VGALLERY ); ?></label>
                                  <input type="text" name="colFea" id="colFea"  size="10" value="<?php echo $settingsGrid->colFea; ?>"> </td> 
                              </tr>
                              <?php /** Enable / disbale Category Videos */ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                                  <th><?php esc_attr_e( 'Category Videos', APPTHA_VGALLERY ); ?></th>
                                  <td> <input type='radio' name="homecategory"  value="1" <?php if ( $settingsGrid->homecategory == 1 ) { 
                                    echo 'checked'; 
                                  } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label>
                                  <input type='radio' name="homecategory"  value="0" <?php if ( $settingsGrid->homecategory == 0 ) { 
                                    echo 'checked'; 
                                  } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label> </td> 
                              </tr>
                              <?php /** Rows , columns for Category Videos */ ?>
                              <tr class="gallery_separator_row">
                                  <td><label><?php esc_attr_e( 'Rows', APPTHA_VGALLERY ); ?></label>
                                  <input type="text" size="10" name="rowCat" id="rowCat" value="<?php echo $settingsGrid->rowCat; ?>"></td>
                                  <td><label><?php esc_attr_e( 'Columns', APPTHA_VGALLERY ); ?></label>
                                  <input type="text" id="colCat" size="10" name="colCat" value="<?php echo $settingsGrid->colCat; ?>"> </td>
                              </tr>
                              <?php /** Rows , columns for More Videos */ ?>
                              <?php echo $gallerySeparatorDiv; ?>
                              <th><?php esc_attr_e( 'More Page', APPTHA_VGALLERY ); ?></th>  </tr>
                              <tr class="gallery_separator_row">
                                  <td><label><?php esc_attr_e( 'Rows', APPTHA_VGALLERY ); ?></label>
                                  <input type="text" id="rowMore" size="10" name="rowMore" value="<?php echo $settingsGrid->rowMore; ?>"></td>
                                  <td><label><?php esc_attr_e( 'Columns', APPTHA_VGALLERY ); ?></label>
                                  <input type="text" name="colMore" size="10" id="colMore" value="<?php echo $settingsGrid->colMore; ?>"> </td> 
                              </tr> 
                          </table> 
                      </div> 
                  </div>
                  <?php /**  Videos Page settings Ends */ 
                  /** Amazon S3 Bucket settings Starts */ ?>
                  <?php echo $portletDiv; ?> 
                      <b><?php esc_attr_e( 'Amazon S3 Bucket Setting', APPTHA_VGALLERY ); ?></b></div> 
                              <?php echo $portletContentDiv . $gallerySeparatorDiv; ?> 
                                  <?php /** Enable / disbale Amazon S3 Bucket settings Starts */ ?>
                                  <th><?php esc_attr_e( 'Store Videos in Amazon S3 Bucket', APPTHA_VGALLERY ); ?></th>
                                  <td> <input  type='radio' name="amazonbuckets_enable" id="amazonbuckets_enable" <?php echo $checked;?>
                                   value="1" <?php if ( isset($player_colors['amazonbuckets_enable']) && $player_colors['amazonbuckets_enable'] == 1 ) { 
                                    echo 'checked'; 
                                  } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label> 
                                  <input  type='radio' id="amazonbuckets_enable"  name="amazonbuckets_enable" value="0" <?php if ( isset($player_colors['amazonbuckets_enable']) && $player_colors['amazonbuckets_enable'] == 0 ) { 
                                    echo 'checked'; 
                                  } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label> </td> 
                              </tr> 
                              <?php /** Amazon S3 Bucket name Starts */ ?>
                              <?php echo $gallerySeparatorDiv; ?>  
                                  <th><?php esc_attr_e( 'Enter Amazon S3 Bucket name', APPTHA_VGALLERY ); ?></th> 
                                  <td><input type="text" name="amazonbuckets_name" size="20" id="amazonbuckets_name" value="<?php if(isset( $player_colors['amazonbuckets_name'])){ 
                                    echo $player_colors['amazonbuckets_name'] ;
                                  } ?>"></td> 
                              </tr> 
                              <?php /** Amazon S3 Bucket link Starts */ ?>
                              <?php echo $gallerySeparatorDiv; ?>  
                                  <th><?php esc_attr_e( 'Enter Amazon S3 Bucket link', APPTHA_VGALLERY ); ?></th> 
                                  <td><input id="amazonbuckets_link" type="text" name="amazonbuckets_link" size="20" value="<?php if(isset( $player_colors['amazonbuckets_link'])){ 
                                    echo $player_colors['amazonbuckets_link'];
                                  } ?>"></td> 
                              </tr> 
                              <?php /** Amazon S3 Bucket Access Key Starts */ ?>
                              <?php echo $gallerySeparatorDiv; ?>  
                                  <th><?php esc_attr_e( 'Enter Amazon S3 Bucket Access Key', APPTHA_VGALLERY ); ?></th> 
                                  <td><input type="text" size="20" name="amazon_bucket_access_key" id="amazon_bucket_access_key"  value="<?php if(isset( $player_colors['amazon_bucket_access_key'])){ 
                                    echo $player_colors['amazon_bucket_access_key']; 
                                  } ?>"></td> 
                              </tr>
                              <?php /** Amazon S3 Bucket Access Secret Key Starts */ ?>
                              <?php echo $gallerySeparatorDiv; ?> 
                                  <th><?php esc_attr_e( 'Enter Amazon S3 Bucket Access Secret Key', APPTHA_VGALLERY ); ?></th> 
                                  <td><input type="text" name="amazon_bucket_access_secretkey" id="amazon_bucket_access_secretkey"  value="<?php if(isset( $player_colors['amazon_bucket_access_secretkey'])) { 
                                    echo $player_colors['amazon_bucket_access_secretkey']; 
                                  } ?>" size="20"></td> 
                              </tr>
                          </table>
                      </div> 
                  </div>
                  <?php /** Amazon S3 Bucket settings Ends */ 
                   /** User Video settings Starts */ ?>
                  <?php echo $portletDiv; ?> 
                      <b> <?php esc_attr_e( 'User Video Setting', APPTHA_VGALLERY ); ?> </b></div> 
                              <?php /** Display Youtube API Key */ ?>
                              <?php echo $portletContentDiv . $gallerySeparatorDiv; ?> 
                                  <th><?php esc_attr_e( 'Enter Youtube API Key', APPTHA_VGALLERY ); ?></th>
                                  <td><input type="text" name="youtube_key" id="youtube_key" size="20" value="<?php if(isset( $player_colors['youtube_key'])){ 
                                    echo $player_colors['youtube_key'] ;
                                  } ?>"></td>
                              </tr>
                              <?php /** Enable / disable User Video added option Starts */ ?>
                              <?php echo $gallerySeparatorDiv; ?>  
                                  <th> <?php esc_attr_e( 'Video Upload Option to Members', APPTHA_VGALLERY ); ?></th> 
                                  <td> <input  type='radio' id="member_upload_enable" name="member_upload_enable" <?php echo $checked; ?> value="1" 
                                  <?php if ( isset($player_colors['member_upload_enable']) && $player_colors['member_upload_enable'] == 1 ) { 
                                    echo 'checked'; 
                                  } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label> 
                                  <input  type='radio' id="member_upload_enable" name="member_upload_enable" value="0" <?php if ( isset($player_colors['member_upload_enable']) && $player_colors['member_upload_enable'] == 0 ) { 
                                    echo 'checked'; 
                                  } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label> </td> 
                              </tr> 
                              <?php /** Enable / disable User Publish video */ ?>
                              <?php echo $gallerySeparatorDiv; ?>  
                                  <th> <?php esc_attr_e( 'Video Publish Option for Members', APPTHA_VGALLERY ); ?></th> 
                                  <td> <input  type='radio' name="member_publish_enable" id="member_publish_enable" <?php echo $checked; ?> value="1" 
                                  <?php if ( isset($player_colors['member_publish_enable']) && $player_colors['member_publish_enable'] == 1 ) { 
                                    echo 'checked'; 
                                  } ?> /> <label><?php esc_attr_e( 'Enable', APPTHA_VGALLERY ); ?></label> 
                                  <input  type='radio' name="member_publish_enable" id="member_publish_enable" value="0" <?php if ( isset($player_colors['member_publish_enable']) && $player_colors['member_publish_enable'] == 0 ) { 
                                    echo 'checked'; 
                                  } ?> /> <label><?php esc_attr_e( 'Disable', APPTHA_VGALLERY ); ?></label> </td> 
                              </tr> 
                               <?php /** User Video added option Starts */ ?>
                              <tr class="gallery_separator" > 
                                  <th> <?php esc_attr_e( 'Select upload method(s) for users', APPTHA_VGALLERY ); ?> </th> 
                                  <td> <?php echo esc_attr_e('( Press ctrl button and Choose Multiple Option)',APPTHA_VGALLERY);?>
                                    <?php /** Show selected upload methods */ ?>
                                       <?php $allowed_method = explode(',',$player_colors['user_allowed_method']); ?> 
                                        <span> <select name="user_allowed_method[]" size="5" multiple="multiple" >
                                         <?php /** Show YouTube URL / Viddler / Dailymotion is selected */ ?>
                                            <option <?php if(in_array('c',$allowed_method)) { 
                                              echo 'selected'; 
                                            } ?> value="c" > <?php esc_attr_e( 'YouTube URL / Viddler / Dailymotion', APPTHA_VGALLERY ); ?></option>
                                         <?php /** Show Upload file is selected */ ?>
                                            <option value="y" <?php if(in_array('y',$allowed_method)) {  
                                              echo 'selected'; 
                                            } ?>><?php esc_attr_e( 'Upload file', APPTHA_VGALLERY ); ?>
                                            </option> <?php /** Show Custom URL is selected */ ?>
                                            <option value="url" <?php if(in_array('url',$allowed_method)) { 
                                              echo 'selected';  
                                            } ?>> <?php esc_attr_e( 'Custom URL', APPTHA_VGALLERY ); ?></option>
                                            <?php /** Show RTMP is selected */ ?> <option value="rmtp" 
                                            <?php if(in_array('rmtp',$allowed_method)) { 
                                              echo 'selected'; 
                                            } ?>> <?php esc_attr_e( 'RTMP', APPTHA_VGALLERY ); ?></option>
                                            <?php if ( isset( $settingsGrid->license ) && ( strpos( $settingsGrid->license ,'CONTUS' ) ) ) { ?>
                                            <option value="embed" <?php if(in_array('embed',$allowed_method)){ 
                                              echo 'selected'; 
                                            } ?>> 
                                            <?php esc_attr_e( 'Embed Video', APPTHA_VGALLERY ); ?></option>
                                            <?php }  ?>
                                        </select>
                                  </span>
                                  </td>
                              </tr>
                          </table>
                      </div>
                  </div>
                  <?php /** User Video settings Ends */ ?>
                  <div class="bottom_btn">
                      <input class='button-primary' id='videogallery_setting' style="float:right; " name="updatebutton"  type='submit' value='<?php esc_attr_e( 'Update Options', APPTHA_VGALLERY ); ?>'/>
                  </div> 
              </div> 
            </div> 
        <div class="clear"></div> 
    </form> 
  </div>
</div>

<script type="text/javascript">
<?php /** Check if fb comments is enabled */
if ( isset( $settingsGrid->comment_option ) && $settingsGrid->comment_option == 2 ) { 
/** Enable field to enter app id */ 
  ?>
        enablefbapi( '2' ); 
<?php } else { 
  /** Check disqus comment is enabled*/
  if ( isset( $settingsGrid->comment_option ) && $settingsGrid->comment_option == 3 ) { 
  /** Enable field to enter disqus name */
    ?> 
        enablefbapi( '3' ); 
<?php } 
}
if ( isset( $settingsGrid->relatedVideoView ) && $settingsGrid->relatedVideoView == 'side' ) { 
/** Enable related videos view in side position */
?> 
        enablerelateditems( 'side' ); 
<?php } else {
  /** Enable related videos view in center position  */
  if ( isset( $settingsGrid->relatedVideoView ) && $settingsGrid->relatedVideoView == 'center' ) { ?> 
        enablerelateditems( 'center' ); 
<?php } 
}?>
</script>