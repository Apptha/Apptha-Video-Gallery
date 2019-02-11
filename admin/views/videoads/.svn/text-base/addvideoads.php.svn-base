<?php
/**  
 * Multi type Video added and  update details form 
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Get upload directory url */
$image_path = getUploadDirURL();
$checked = 'checked="checked"';
/** Script to assign upload directory url */
?>
<script type="text/javascript">
var	videogallery_plugin_folder =  '<?php echo getImagesDirURL() ; ?>' ;
var upload_nonce = '<?php  echo wp_create_nonce( 'upload-video');?>'; 
</script>
 <?php /** Display add video ads page */ ?>
<div class="apptha_gallery">
<?php /** Check video ad id is exist */ 
if (  $videoadId  ) { 
/** Display page title based on the video id */
?>
<h2 class="option_title"><?php echo '<img src="' . getImagesDirURL() .'vid_ad.png" alt="move" width="30"/>'; ?>
<?php esc_attr_e( 'Update Video Ad', APPTHA_VGALLERY ); ?></h2> 
<?php } else {
?> <h2  class="option_title"><?php echo '<img src="' . getImagesDirURL() .'vid_ad.png" alt="move" width="30"/>'; ?>
<?php esc_attr_e( 'Add new Video Ad', APPTHA_VGALLERY ); ?></h2> 
<?php } ?>
<?php /** Check whether the status is exists */ 
if ( isset( $displayMsg ) ) { ?>
		<div class="updated below-h2">
			<p>
				<?php /** Display video ads status */
				echo $displayMsg ;
				/** Get video ads page URL and set back link */
				$url = get_site_url() . '/wp-admin/admin.php?page=videoads';
				echo '<a href="'.$url.'" >Back to VideoAds</a>';
				?>
			</p>
		</div>
	<?php } ?>
<?php
/**  Check video */
$videoadEdit == NULL ;
/** Check video file type and whether the file path have text uploads */
if ( isset( $videoadEdit->file_path ) && ! strstr( $videoadEdit->file_path, '/uploads' ) ) {
	$uploaded_video = 0;
} else {
	$uploaded_video = 1;
}
?>
<?php /** Display common option for add video ads page */ ?>
	<div id="post-body" class="has-sidebar">
		<div id="post-body-content" class="has-sidebar-content">
			<div class="stuffbox videoform">
				<h3 class="hndle videoform_title">
				   <?php if($videoadEdit) { ?>
				   <?php /** Display Pre-roll/Post-roll Ad option for edit page */ ?>
					<span>
						<input type="radio" name="videoadtype" id="prepostroll" value="1" <?php if ( isset( $videoadEdit ) && $videoadEdit->admethod == 'prepost' ) { 
						  echo $checked; 
						} ?> onClick="Videoadtype( 'prepostroll' )"/> Pre-roll/Post-roll Ad
					</span>
					<?php /** Display Mid-roll Ad option for edit page */ ?>
					<span>
						<input type="radio" name="videoadtype" id="midroll" value="2" <?php if ( isset( $videoadEdit ) && $videoadEdit->admethod == 'midroll' ) { 
						  echo $checked; 
						} ?> onClick="Videoadtype( 'midroll' )" />  Mid-roll Ad
					</span>
					<?php /** Display IMA Ad option for edit page */ ?>
					<span>
						<input type="radio" name="videoadtype" id="imaad" value="3" <?php if ( isset( $videoadEdit ) && $videoadEdit->admethod == 'imaad' ) { 
						  echo $checked; 
						} ?> onClick="Videoadtype( 'imaad' )" />  IMA Ad
					</span>
					<?php } else { ?>
					<span>
					<?php /** Display Pre-roll/Post-roll Ad option for add page */ ?>
						<input type="radio" name="videoadtype" id="prepostroll" value="1" onClick="Videoadtype( 'prepostroll' )"/> Pre-roll/Post-roll Ad
					</span>
					<span>
					<?php /** Display Mid-roll Ad option for add page */ ?>
						<input type="radio" name="videoadtype" id="midroll" value="2" onClick="Videoadtype( 'midroll' )" />  Mid-roll Ad
					</span>
					<span>
					<?php /** Display IMA Ad option for add page */ ?>
						<input type="radio" name="videoadtype" id="imaad" value="3"  onClick="Videoadtype( 'imaad' )" />  IMA Ad
					</span>
					<?php } ?>
				</h3>
				<?php /** Display option to select file type */ ?>
				<table class="form-table videoadmethod">
					<tr id="videoadmethod" name="videoadmethod">
						<td  width="150"><?php esc_attr_e( 'Select file type', APPTHA_VGALLERY ) ?></td>
						<td>
							<input type="radio" name="videoad" id="filebtn" value="1" onClick="Videoadtypemethod( 'fileuplo' );" /> File
							<input type="radio" name="videoad" id="urlbtn" value="2" onClick="Videoadtypemethod( 'urlad' );" />  URL
						</td>
					</tr>
				</table>
				<?php /** Display option to select file type ends */ 
				/** Display upload option to upload video ad starts */ ?>
				<div id="upload2" class="form-table">
<?php /** Display upload video ad form */ ?>
					<table class="form-table videoadmethod">
						<tr id="ffmpeg_disable_new1" name="ffmpeg_disable_new1">
							<td  width="150"><?php esc_attr_e( 'Upload Video', APPTHA_VGALLERY ) ?></td>
							<td>
								<div id="f1-upload-form" >
									<form name="normalvideoform" method="post" enctype="multipart/form-data" >
										<input type="file" name="myfile" onchange="enableUpload( this.form.name );" />
										<input type="button" class="button" name="uploadBtn" value="<?php esc_attr_e( 'Upload Video', APPTHA_VGALLERY ) ?>" disabled="disabled" onclick="return addQueue( this.form.name, this.form.myfile.value );" />
										<input type="hidden" name="mode" value="video" />
										<label id="lbl_normal"><?php 
if ( isset( $videoadEdit->file_path ) && $uploaded_video == 1 ) {
	$file_path = str_replace( $image_path, '', $videoadEdit->file_path );
} else  {
		$file_path = '';
}
	echo  $file_path; ?>
										</label>
									</form>
									<?php /** Display upload video ad supported format */ ?>
									<b><?php esc_attr_e( 'Supported video formats:', APPTHA_VGALLERY ) ?></b>
									<?php esc_attr_e( '(  MP4, M4V, M4A, MOV, Mp4v or F4V )', APPTHA_VGALLERY ) ?>
								</div>
								<?php /** Display upload video message */ ?>
								<span id="uploadmessage" style="display: block; margin-top:10px;margin-left:300px;color:red;font-size:12px;font-weight:bold;"></span>
								<div id="f1-upload-progress" style="display:none">
									<div style="float:left"><img id="f1-upload-image" src="<?php echo getImagesDirURL() .'empty.gif' ?>" alt="Uploading"  style="padding-top:2px"/>
										<label style="padding-top:0px;padding-left:4px;font-size:14px;font-weight:bold;vertical-align:top"  id="f1-upload-filename">PostRoll.flv</label></div>
									<div class="apptha_add_new_video_ad"> <span id="f1-upload-cancel">
											<a style="float:right;padding-right:10px;" href="javascript:cancelUpload( 'normalvideoform' );" name="submitcancel">Cancel</a>
										</span>
										<label id="f1-upload-status" style="float:left;padding-right:40px;padding-left:20px;">Uploading</label>
										<span id="f1-upload-message" style="float:left;font-size:10px;background:#FFAFAE;padding:8px;">
											<b><?php esc_attr_e( 'Upload Failed:', APPTHA_VGALLERY ) ?></b> 
											<?php esc_attr_e( USERCANCELUPLOAD, APPTHA_VGALLERY ) ?>
										</span></div>
								</div>
								<div id="nor"><iframe id="uploadvideo_target" name="uploadvideo_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe></div>
								<span id="filepathuploaderrormessage" style="display: block;color:red; "></span>
							</td></tr>
					</table>
				</div>
				<?php /** Display upload option to upload video ad ends */ 
				/** Display video ad url field starts */ ?>
				<form action="" name="videoadsform" class="videoform" method="post" enctype="multipart/form-data"  >
					<div id="videoadurl" style="display: none;" >
						<table class="form-table form-videoad-table">
							<tr>
								<td scope="row"  width="150" class="videoaddurl"><?php esc_attr_e( 'Video Ad URL', APPTHA_VGALLERY ) ?></td>
								<td> 
								<?php /** Check file path is exist */ 
                                if ( isset( $videoadEdit->file_path ) ) {
                                     /** If exist the assign file path */ 
                                    $file_path_url = $videoadEdit->file_path; 
                                } else {
                                    /** Else assign empty for filepath */ 
                                    $file_path_url = ''; 
                                } ?>
									<input type="text" size="50" onchange="clear_upload();" onkeyup="validateerrormsg();" name="videoadfilepath" id="videoadfilepath"  value="<?php echo balanceTags( $file_path_url );?>" />
									<div class="videoad_url_info_content">
									<?php esc_attr_e( 'Here you need to enter the video ad URL', APPTHA_VGALLERY ) ?>
									<br /><?php esc_attr_e( 'It accept also a Youtube link : http://www.youtube.com/watch?v=tTGHCRUdlBs', APPTHA_VGALLERY ) ?>
									</div>
									<span id="filepatherrormessage" style="display: block;color:red; "></span>
								</td>
							</tr>
						</table>
					</div>
					<?php /** Display video ad url field ends */ 
					/** Display IMA Ad type */ ?>
					<table id="videoimaaddetails" style="display: none;" class="form-table">
						<tr>
							<td scope="row"  width="150"><?php esc_attr_e( 'IMA Ad Type', APPTHA_VGALLERY ) ?></td>
							<?php /** Display text overlay option */ ?>
							<td> <input name="imaadType" type="radio" id="imaadTypetext" onclick="changeimaadtype( 'textad' );" value="1" <?php if ( isset( $videoadEdit->imaadType ) && $videoadEdit->imaadType == 1 ) {
							  echo 'checked'; 
							} ?>><label>Text/Overlay</label>
							<?php /** Display video option  */ ?>
								<input name="imaadType" type="radio" id="imaadTypevideo" onclick="changeimaadtype( 'videoad' );" value="0"  <?php if ( isset( $videoadEdit->imaadType ) && $videoadEdit->imaadType == 0 ) { 
								  echo 'checked'; 
								} ?>><label>Video</label>
						</tr>
						<?php /** Display IMA Ad path starts */ ?>
						<tr id="adimapath" style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'IMA Ad Path', APPTHA_VGALLERY ) ?></td>
							<td> <input type="text" size="50" onkeyup="validateerrormsg();" name="imaadpath" id="imaadpath" value="<?php if ( isset( $videoadEdit->imaadpath ) ) { 
							  echo balanceTags( $videoadEdit->imaadpath ); 
							} else { 
                              echo ''; 
                            } ?>" /> <span id="imaadpatherrormessage" style="display: block;color:red; "></span> </td>
						</tr>
						<?php /** Display IMA Ad path ends */ 
						 /** Display Ad slot width starts */ ?>
						<tr id="adimawidth" style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Ad Slot Width', APPTHA_VGALLERY ) ?></td>
							<td> <input type="text" name="videoimaadwidth" id="adwidth" size="50" value="<?php  if ( isset( $videoadEdit->imaadwidth ) ) {
                              	$imaadwidth = $videoadEdit->imaadwidth;
                              } else {
                              	$imaadwidth = '';
                              }
								echo $imaadwidth; ?>"  /> </td>
						</tr>
						<?php /** Display Ad slot width ends */ 
						/** Display Ad slot height starts */ ?>
						<tr id="adimaheight" style="display: none;">
							<td width="150" scope="row"><?php esc_attr_e( 'Ad Slot Height', APPTHA_VGALLERY ) ?></td>
							<td> <input type="text" id="adheight" size="50" name="videoimaadheight"  value="<?php  if ( isset( $videoadEdit->imaadheight ) ) {
	$imaadheight = $videoadEdit->imaadheight; 
} else {
	$imaadheight = '';
}
									echo $imaadheight; ?>"  /> </td>
						</tr>
						<?php /** Display Ad slot height ends*/
						/** Display publisher id starts */ ?>
						<tr id="adimapublisher" style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Publisher ID', APPTHA_VGALLERY ) ?></td>
							<td><input type="text" size="50" name="publisherId" id="publisherId" onkeyup="validateerrormsg();" 
							value="<?php if ( isset( $videoadEdit->publisherId ) ) {
                            	$publisherId = $videoadEdit->publisherId; 
                            } else {
                            	$publisherId = '';
                            }
							echo $publisherId ;
							?>" /> <span id="imapublisherIderrormessage" style="display: block;color:red; "></span>
							</td>
						</tr>
						<?php /** Display publisher id ends */ 
						/** Display content id starts */ ?>
						<tr id="adimacontentid" style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Content ID', APPTHA_VGALLERY ) ?></td>
							<td><input type="text" name="contentId" size="50" onkeyup="validateerrormsg();" id="contentId" 
							value="<?php  if ( isset( $videoadEdit->contentId ) ) {
                            	$contentId = $videoadEdit->contentId; 
                            } else {
                            	$contentId = '';
                            }
							echo $contentId ;
							?>" />
								<span id="imacontentIderrormessage" style="display: block;color:red; "></span> </td>
						</tr>
						<?php /** Display content id ends 
						/** Display channel field starts */ ?>
						<tr id="adimachannels" style="display: none;">
							<td width="150" scope="row"><?php esc_attr_e( 'Channels', APPTHA_VGALLERY ) ?></td>
							<td><input type="text" id="channels" size="50" onkeyup="validateerrormsg();" name="channels"  
							value="<?php  if ( isset( $videoadEdit->channels ) ) {
                            	$channels = $videoadEdit->channels; 
                            } else {
                            	$channels = '';
                            }
							echo $channels ;
							?>" />
								<span id="imachannelserrormessage" style="display: block;color:red;"></span> </td>
						</tr>
					</table>
					<?php /** Display channel field ends */ 
					/** Display Ad title field starts */ ?>
					<table id="videoaddetails" style="display: none;" class="form-table">
						<tr id="adtitle"  style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Title / Name', APPTHA_VGALLERY ) ?></td>
							<td>
							     <?php if ( isset( $videoadEdit->title ) ) {
										$title = $videoadEdit->title; 
									} else {
										$title = '';
									} ?>
								<input type="text" size="50" onkeyup="validateerrormsg();" maxlength="200" name="videoadname" id="name" value="<?php echo balanceTags( $title );?>"  />
								<span id="nameerrormessage" style="display: block;color:red; "></span>
							</td>
						</tr>
						<?php /** Display Ad title field ends
						/** Display ad description field starts */ ?>
						<tr id="addescription"  style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Description', APPTHA_VGALLERY ) ?></td>
							<td>
							<textarea name="description" id="description" rows="3" cols="50" ><?php 
if ( isset( $videoadEdit->description ) ) {
	$description = $videoadEdit->description;
} else {
	$description = '';
}
								echo htmlentities( $description );
								?></textarea>
							</td>
						</tr>
						<?php /** Display ad description field ends */ 
						/** Display target url field starts*/ ?>
						<tr id="adtargeturl"  style="display: none;">
							<td scope="row"  width="150"><?php esc_attr_e( 'Target URL', APPTHA_VGALLERY ) ?></td>
							<td>
								<input type="text" size="50" name="targeturl" id="targeturl" value="<?php 
if ( isset( $videoadEdit->targeturl ) ) {
	$targeturl = $videoadEdit->targeturl; 
} else {
	$targeturl = '';
}
								echo $targeturl;
								?>" />
								<span id="targeterrormessage" style="display: block;color:red; "></span>
							</td>
						</tr>
					</table>
<?php /** Display target url field ends */ 
/** Display publish  option starts */ ?>
					<table class="form-table add_video_publish">
						<tr>
							<td scope="row" width="150"><?php esc_attr_e( 'Publish', APPTHA_VGALLERY ) ?></td>
							<?php $checked = ''; 
							if(!isset($videoadEdit->publish) ) {
								 $checked = 'checked';
							}?>
							<td class="checkbox">
								<input type="radio" name="videoadpublish"  value="1" <?php if ( isset( $videoadEdit->publish ) ) { 
								  echo 'checked'; 
								} echo $checked; ?>><label>Yes</label>
								<input type="radio" name="videoadpublish" value="0"  <?php if ( isset( $videoadEdit->publish ) && $videoadEdit->publish == 0 ) { 
								  echo 'checked'; 
								} ?>><label>No</label>
							</td>
						</tr>
					</table>
<?php /** Display publish  option ends */ 
/**  Form hidden values section starts */ ?>
<?php if ( $videoadId  ) { ?>
						<input type="submit" name="videoadsadd" class="button-primary" onclick="return validateadInput();"  value="<?php esc_attr_e( 'Update', APPTHA_VGALLERY ); ?>" class="button" /> 
						<?php } else { ?> 
						<input type="submit" name="videoadsadd" class="button-primary" onclick="return validateadInput();" value="<?php esc_attr_e( 'Save', APPTHA_VGALLERY ); ?>" class="button" /> 
						<?php } ?>
					<input type="button" onclick="window.location.href = 'admin.php?page=videoads'" class="button-secondary" name="cancel" value="<?php esc_attr_e( 'Cancel' ); ?>" class="button" />
					<input type="hidden" name="normalvideoform-value" id="normalvideoform-value" value="<?php if ( isset( $videoadEdit->file_path ) && $uploaded_video == 1 ) { 
					  echo str_replace( $image_path, '', $videoadEdit->file_path ); 
					} else { echo ''; } ?>"  />
					<input type="hidden" name="admethod" id="admethod" value="<?php 
if ( isset( $videoadEdit->admethod ) ) {
	$admethod = $videoadEdit->admethod; 
} else {
	$admethod = '';
}
					echo $admethod ;
					?>"  />
					<input type="hidden" name="adtype" id="adtype" value="<?php 
if ( isset( $videoadEdit->adtype ) ) {
	$adtype = $videoadEdit->adtype; 
} else {
	$adtype = '';
} 
					echo $adtype ;
					?>"  />
					<?php /**  Form hidden values section ends */ ?>
				</form>
			</div>
		</div>
	</div>
	<?php /** Script to select video ad adding option starts */ ?>
	<script type="text/javascript">
<?php 
if ( isset( $videoadEdit->file_path ) && $uploaded_video == 1 ) { ?>
			document.getElementById( "filebtn" ).checked = true;
			Videoadtypemethod( 'fileuplo' );
<?php } else { ?>
			document.getElementById( "urlbtn" ).checked = true;
			Videoadtypemethod( 'urlad' );
<?php }
if ( isset( $videoadEdit->admethod ) && $videoadEdit->admethod == 'midroll' ) {
	?>
			document.getElementById( "midroll" ).checked = true;
			Videoadtype( 'midroll' );
	<?php
} else if ( isset( $videoadEdit->admethod ) && $videoadEdit->admethod == 'imaad' ) {
	?>
			document.getElementById( "imaad" ).checked = true;
			Videoadtype( 'imaad' );
	<?php
} else {
	?>	document.getElementById( "prepostroll" ).checked = true;
			Videoadtype( 'prepostroll' );
	<?php
}
if (  empty( $videoadEdit->imaadpath ) ) {
	?> changeimaadtype( 'textad' );<?php
} else {
	?> changeimaadtype( 'videoad' ); <?php
}
?>
	</script>
	<?php /** Script to select video ad adding option ends */ ?>
</div>