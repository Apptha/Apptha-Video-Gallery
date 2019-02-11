<?php
/**
 * Video gallery admin addvideo form and update form for video added. 
 * 
 * Add video with multiple method 
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Varaible initialization for add videos */
$act_vid            = 0;
$video_description  = '';
$user_admin = 'administrator';
global $current_user;
$checked = 'checked="checked"';
/** Get empty image URL */
$emptyImage         = getImagesDirURL() .'empty.gif';
/** Get video id fom request */
if (isset ( $_GET ['videoId'] )) {
  $act_vid          = ( int ) $_GET ['videoId'];
}

/** Creating object for VideosSubController class */
$videoOBJ         = new VideosSubController ();
/** Call function to update videos data  */
$videoOBJ->add_newvideo ();
/** Assign class variables into local variables */
$videoId          = $videoOBJ->_videoId;
$settingsGrid     = $videoOBJ->_settingsData;
/** Call function to edit videos data */
$videoEdit   = '';
if (! empty ( $videoId )) {
  $videoEdit = $videoOBJ->video_edit ( $videoId );
}
/** Call function to get message for the corresponding action */
$displayMsg = $videoOBJ->get_message ();

/** Script to load image directory URL */
?>
<script type="text/javascript">
    var	videogallery_plugin_folder =  '<?php echo getImagesDirURL() ; ?>' ;
    var upload_nonce = '<?php  echo wp_create_nonce( 'upload-video');?>'; 
</script>
<?php 
/** Display status in header */
echo displayStatusMeassage ( $displayMsg );
/** Display add videos page starts */ 
?> 
<div class="apptha_gallery">
	<div class="wrap">
		<script type="text/javascript">
			function savePlaylist( playlistName, mediaId ) {
				var name = playlistName.value;
				name = name.trim();
				document.getElementById('jaxcat').innerHTML="";
				var playlistajax = jQuery.noConflict();
				if(name == '' ){
				  document.getElementById('jaxcat').innerHTML="<p>Enter the playlist name </p>";	
                  return false;
				}
				playlistajax.ajax( {
					type: "GET",
					url: "admin.php?page=ajaxplaylist",
					data: "name=" + name + "&media=" + mediaId,
					success: function( msg ) {
						var response = msg.split( '##' );
						document.getElementById( 'playlistchecklist' ).innerHTML = msg;
					}
				} );
			}
			function getyoutube_details(){
	               var youtube_url =  document.getElementById("filepath1").value;
	               if(youtube_url.indexOf('youtube') != -1) {
		               var video_id = youtube_url.split('v=')[1];
		               var ampersandPosition = video_id.indexOf('&');
		               if(ampersandPosition != -1) {
		                 video_id = video_id.substring(0, ampersandPosition);
		               }
	               } else if(youtube_url.indexOf('youtu.be') != -1) {
		               var video_id = youtube_url.split('/')[3];
	               }
	               var urlmatch = /(http:\/\/|https:\/\/)[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}|(http:\/\/|https:\/\/)/;
	               var errormsg = "<p>Enter Valid Video URL</p>";
	               if( !urlmatch.test(youtube_url) ){
	            	   document.getElementById('Youtubeurlmessage').innerHTML = errormsg;
	            	   document.getElementById('Youtubeurlmessage').style.display = "block";
	            	   return false;
		           }
	               var playlistajax = jQuery.noConflict();
	               document.getElementById('loading_image').style.display ="block";         
		           var requesturl = '<?php echo admin_url('admin-ajax.php?action=getyoutubedetails'); ?>'; 
		           playlistajax.ajax({
	                       url:requesturl,
	                       type:"GET",
	                       data:"filepath="+ video_id,
	                       success : function( msg ){
		                       if(msg==7){
			                       alert('Could not retrieve Youtube video information. API Key is missing');
		                       }
                         var resultdata =  playlistajax.parseJSON(msg);
                         document.getElementById( 'name' ).value = resultdata[0];
                     	   document.getElementById( 'filepath1' ).value = resultdata[4];
                     		var tag_name = resultdata[6];
                     	   if(resultdata[5] !== undefined){
                     		tinymce.activeEditor.setContent(resultdata[5]);
                     		tinymce.execCommand('mceAddControl',true,'description');
                     	   }
                     	   if( tag_name !== undefined ) {	   
                     	   	 document.getElementById( 'tags_name' ).value = resultdata[6];
                     	   }	                      
	                    	   document.getElementById( 'embedvideo').style.display = "none";
                         document.getElementById('loading_image').style.display ='none';
                      }  
	               } ); 
	           }
		</script>
<?php   /** Get page name */
        $adminPage = filter_input ( INPUT_GET, 'page' );
        /** Get video id if the page is edit page */
        $videoId = filter_input ( INPUT_GET, 'videoId' );
        $editbutton = 'Save';
        $page_title = 'Add a new video';
        /** Check whether the page is new videos page or edit video page */
        if ($adminPage == 'newvideo' && ! empty ( $videoId )) {
          /** Set page title and button name for edit page */
          $editbutton = 'Update';
          $page_title = 'Edit video';
        } 
        
        /** Call function to get user roles */
        $userid       =  wp_get_current_user ();
        $userDetails  = get_user_by( 'id',  $userid->ID ); 
        if(isset($userDetails->roles)) {
          $user_role    = $userDetails->roles[0];
        }
        /** Get player color values from settings */
        $player_colors = unserialize ( $settingsGrid->player_colors ); 
        /** Get user allowed method to add new videos  */
        $user_allowed_method = explode ( ',', $player_colors ['user_allowed_method'] );
        /** Display page title with icon */
        ?>
		<h2 class="option_title"> <?php echo '<img src="' . getImagesDirURL() .'manage_video.png" alt="move" width="30"/>'; ?>
		<?php echo esc_attr_e( $page_title, APPTHA_VGALLERY ); ?> </h2>
		<div id="poststuff" class="has-right-sidebar">
            <div class="stuffbox videoform" name="youtube">
				<h3 class="hndle videoform_title">
				    <?php /** Display video added option in admin  */
				    /** Display Youtube option in admin and select by defualt */ 
                    if(in_array('c', $user_allowed_method) || $user_admin) { ?> 
                        <span><input type="radio" name="agree" class="post-format" id="btn2" value="c" onClick="t1( this )" /> 
                        <label for="btn2" class="post-format-standard"><?php esc_attr_e( 'YouTube URL / Viddler / Dailymotion', APPTHA_VGALLERY ); ?></label></span> 
                    <?php } 
                    /** Display Upload option in admin and select if upload type is selected */ 
                    if(in_array('y', $user_allowed_method) || $user_admin){ ?> 
                        <span><input name="agree" type="radio" class="post-format" id="btn1" value="y" onClick="t1( this )" /> <label for="btn1" 
                        class="post-format-standard"><?php esc_attr_e( 'Upload file', APPTHA_VGALLERY ); ?></label></span> 
                    <?php } 
                    /** Display Custom URL option in admin and select if url method is selected */ 
                    if(in_array('url', $user_allowed_method) || $user_admin) { ?> 
                    <span><input type="radio" class="post-format" name="agree" value="url" id="btn3" onClick="t1( this )" /> <label for="btn3" 
                    class="post-format-standard"><?php esc_attr_e( 'Custom URL', APPTHA_VGALLERY ); ?></label></span> 
                    <?php }  
                    /** Display RTMP option in admin and select if rtmp method type is selected */
                    if(in_array('rmtp', $user_allowed_method) || $user_admin){ ?> 
                    <span><input type="radio" id="btn4" class="post-format" name="agree" value="rtmp" onClick="t1( this )" /> <label for="btn4" 
                    class="post-format-standard"><?php esc_attr_e( 'RTMP', APPTHA_VGALLERY ); ?></label></span> 
                    <?php } 
                    /** Check whether the license is applied in settings page to display embed option */
                    if ( isset( $settingsGrid->license ) && ( strpos( $settingsGrid->license ,'CONTUS' ) ) && (in_array('embed', $user_allowed_method) || $user_admin) ) {
                        /** Check whether the user is admin 
                         * Display embed code option if it is selected */?>
                        <span><input type="radio" class="post-format"  value="embed" name="agree" id="btn5" onClick="t1( this )" /> <label for="btn5" 
                        class="post-format-standard"><?php esc_attr_e( 'Embed Video', APPTHA_VGALLERY ); ?></label></span> 
                   <?php } ?>
				</h3>
				<?php /** Youtube section starts here */ ?>
				<form method=post>
					<div id="youtube" class="rtmp_inside inside">
						<table class="form-table">
							<tr>
							<?php /** Youtube video URL section */ ?>
								<th scope="row"><?php esc_attr_e( 'Video URL', APPTHA_VGALLERY ) ?></th>
								<td class="rtmp_td"><input type="text" class="youtubelinkinput"
									name="filepath" size="50" value="<?php
        if (isset ( $videoEdit->file_type ) && $videoEdit->file_type == 1) {
          echo $videoEdit->link ;
        }
        ?>" id="filepath1" onPaste="setTimeout(function(){generate12();}, 4);" />&nbsp;&nbsp;
        <?php /** Youtube video generate detail section starts */ ?>
                                    <input id="generate" type="button" name="youtube_media" class="button-primary" value="<?php esc_attr_e( 'Generate details', APPTHA_VGALLERY ); ?>" onClick="return getyoutube_details();" />
									<div id="loading_image" align="center" style="display: none;">
										<img src="<?php echo getImagesDirURL() .'ajax-loader.gif';?>" />
									</div> <span id="Youtubeurlmessage" style="display: block;"></span>
									<?php /** Display sample videos link and message for user */  ?>
									<div class="youtubelinkinfo">
									    <p><?php esc_attr_e( 'Here you need to enter the video URL', APPTHA_VGALLERY ) ?></p>
										<p><?php esc_attr_e( 'It accepts YouTube links like', APPTHA_VGALLERY ) . esc_attr_e(' : https://www.youtube.com/watch?v=K0PsYfEyvJY or http://youtu.be/0vrdgDdPApQ') ?></p>
										<p><strong><?php esc_attr_e( 'Note: You need to enter YouTube API in settings tab for Youtube videos', APPTHA_VGALLERY ) ?></strong></p> </br>
										<p><?php esc_attr_e( 'Viddler link like', APPTHA_VGALLERY ) . esc_attr_e(' : http://www.viddler.com/v/67b33b8f', APPTHA_VGALLERY ) ?></p>
										<p><?php esc_attr_e( 'Dailymotion link like', APPTHA_VGALLERY ) . esc_attr_e(' : http://www.dailymotion.com/video/x16787y_nature-catskills_news', APPTHA_VGALLERY ) ?></p>
									</div></td>
							</tr>
						</table>
					</div>
<?php /** Youtube video URL section ends */ 
/** Embed code section starts*/ ?>
					<div id="embedvideo" class="rtmp_inside inside"
						style="display: none;">
						<table class="form-table">
							<tr>
							<?php /** Display Embed Code field */  ?>
								<th scope="row"><?php esc_attr_e( 'Embed Code', APPTHA_VGALLERY ) ?></th>
								<td class="rtmp_td"><textarea id="embedcode" name="embedcode" rows="5" cols="60"><?php if ( isset( $videoEdit->embedcode ) ) {
										  echo stripslashes( $videoEdit->embedcode ) ; 
										}?></textarea>
									<span id="embedmessage"
									style="display: block; margin-top: 10px; color: red; font-size: 12px; font-weight: bold;"></span>
								</td>
							</tr>
						</table>
					</div>
<?php /** Embed code section ends*/ 
/** RTMP section starts*/ ?>
					<div id="customurl" class="rtmp_inside inside">
						<table class="form-table">
							<tr id="stream1">
							<?php /** Display Streamer Path field */  ?>
								<th scope="row"><?php esc_attr_e( 'Streamer Path', APPTHA_VGALLERY ) ?></th>
								<td class="rtmp_td"><input type="text" name="streamname"
									id="streamname" onkeyup="validatestreamurl();"
								<?php /** Check video edit is enabled
										* type is live stream 
										*/?>
									value="<?php
        if (isset ( $videoEdit->file_type ) && $videoEdit->file_type == 4) {
          echo $videoEdit->streamer_path;
        }
        ?>" /> <span id="streamermessage" style="display: block;"></span>
									<p><?php esc_attr_e( 'Here you need to enter the RTMP Streamer Path', APPTHA_VGALLERY ) ?></p>
								</td>

							</tr>
							<?php /** RTMP is live section */ ?>
							<tr id="islive_visible">
							<?php /** Display Is Live field */  ?>
								<th scope="row"><?php esc_attr_e( 'Is Live', APPTHA_VGALLERY ) ?></th>
								<td><input type="radio" style="float: none;" id="islive2" name="islive" 
									<?php if ( isset( $videoEdit->islive ) && $videoEdit->islive == '1' ) { 
									  echo $checked; 
									} ?> value="1" /> <label><?php esc_attr_e( 'Yes', APPTHA_VGALLERY ) ?></label>
									<input type="radio" name="islive" id="islive1" style="float: none;" 
									<?php if ( isset( $videoEdit->islive ) && ( $videoEdit->islive == '0' || $videoEdit == '' ) ) {
									  echo $checked; 
									} ?> value="0" /> <label><?php esc_attr_e( 'No', APPTHA_VGALLERY ) ?></label>
									<span id="rtmplivemessage" style="display: block;"></span>
									<p><?php esc_attr_e( 'Here you need to select whether your RTMP video is a live video or not', APPTHA_VGALLERY ) ?></p>
								</td>
							</tr>
							<?php /** Custom and RTMP video URL section */ ?>
							<tr> <?php /** Display Video URL field */  ?>
								<th scope="row"><?php esc_attr_e( 'Video URL', APPTHA_VGALLERY ) ?></th>
								<td class="rtmp_td"><input type="text" id="filepath2" size="50" name="filepath2" onkeyup="validatevideourl();"
									<?php /** Check video edit 
											* Type is file upload
											*/?>
									value="<?php if ( isset( $videoEdit->file_type ) && ( $videoEdit->file_type == 3 || $videoEdit->file_type == 4 ) ) { 
									  echo $videoEdit->file ; 
									} ?>" /> <span id="videourlmessage" style="display: block;"></span> <p><?php esc_attr_e( 'Here you need to enter the video URL', APPTHA_VGALLERY ) ?></p>
								</td>
							</tr>
							<?php /** Custom HD video URL section */ ?>
							<tr id="hdvideourl">
							<?php /** Display HD Video URL field */  ?>
								<th scope="row"><?php esc_attr_e( 'HD Video URL ( Optional )', APPTHA_VGALLERY ) ?></th>
								<td class="rtmp_td"><input type="text" name="filepath3" id="filepath3" size="50" 
									value="<?php if ( isset( $videoEdit->file_type ) && ( $videoEdit->file_type == 3 || $videoEdit->file_type == 4 ) ) { 
									  echo $videoEdit->hdfile ; 
									} ?>" /> <span id="videohdurlmessage" style="display: block;"></span>
									<p><?php esc_attr_e( 'Here you need to enter the HD video URL', APPTHA_VGALLERY ) ?></p>
								</td>
							</tr>
							<?php /** Custom thumb image URL section */ ?>
							<tr>
							<?php /** Display Thumb Image URL field */  ?>
								<th scope="row"><?php esc_attr_e( 'Thumb Image URL', APPTHA_VGALLERY ) ?></th>
								<td class="rtmp_td"><input type="text" name="filepath4" size="50" id="filepath4" onkeyup="validatethumburl();"
									value="<?php if ( isset( $videoEdit->file_type ) && ( $videoEdit->file_type == 3 || $videoEdit->file_type == 4 ) ) { 
									  echo $videoEdit->image ; 
									} ?>" />
									<span id="thumburlmessage" style="display: block;"></span> <p><?php esc_attr_e( 'Here you need to enter the URL of thumb image', APPTHA_VGALLERY ) ?></p>
								</td>
							</tr>
							<?php /** Custom preview image URL section */ ?>
							<tr><?php /** Display Preview Image URL field */  ?>
								<th scope="row"><?php esc_attr_e( 'Preview Image URL ( Optional )', APPTHA_VGALLERY ) ?></th>
								<td class="rtmp_td"><input type="text" id="filepath5" size="50" name="filepath5" 
									value="<?php if ( isset( $videoEdit->file_type ) && ( $videoEdit->file_type == 3 || $videoEdit->file_type == 4 ) ) { 
									  echo $videoEdit->opimage ; 
									} ?>" />
									<span id="previewurlmessage" style="display: block;"></span>
									<p><?php esc_attr_e( 'Here you need to enter the URL of preview image', APPTHA_VGALLERY ) ?></p>
								</td>
							</tr>
						</table>
					</div>
				</form>
<?php /** RTMP section ends */ 
/** Video upload section starts */ ?>
                <div id="upload2" class="inside"> 
                    <div id="supportformats"> <?php /** Display Supported video formats
                    								  *Formats may be MP4, M4V, M4A, MOV, Mp4v or F4V
                    								  * */  ?>
                        <b><?php esc_attr_e( 'Supported video formats:', APPTHA_VGALLERY ) ?></b> 
                        <?php esc_attr_e( '(  MP4, M4V, M4A, MOV, Mp4v or F4V )', APPTHA_VGALLERY ) ?>
                    </div> 
                    <table class="form-table"> 
                        <tr id="ffmpeg_disable_new1" name="ffmpeg_disable_new1"> <?php /** Display Upload Video field */  ?>
                            <th style="vertical-align: middle;"><?php esc_attr_e( 'Upload Video', APPTHA_VGALLERY ) ?></th> 
                            <td> <div id="f1-upload-form"> 
                                    <form name="normalvideoform" method="post" enctype="multipart/form-data"> 
                                        <input type="file" name="myfile" onchange="enableUpload( this.form.name );" /> 
                                        <input type="button" class="button" name="uploadBtn" value="<?php esc_attr_e( 'Upload Video', APPTHA_VGALLERY ) ?>" disabled="disabled" onclick="return addQueue( this.form.name, this.form.myfile.value );" /> 
                                        <input type="hidden" name="mode" value="video" /> 
                                        <label id="lbl_normal"><?php if (isset ( $videoEdit->file_type ) && $videoEdit->file_type == 2) { 
                                          echo $videoEdit->file; 
                                        } ?></label> 
                                    </form> </div>
                              <span id="uploadmessage" style="display: block; margin-top: 10px; color: red; font-size: 12px; font-weight: bold;"></span> 
                              <div id="f1-upload-progress" style="display: none"> 
                              <div style="float: left"> 
                                  <img id="f1-upload-image" src="<?php echo $emptyImage; ?>" alt="Uploading" style="padding-top: 2px" /> 
                                  <label style="padding-top: 0px; padding-left: 4px; font-size: 14px; font-weight: bold; vertical-align: top" id="f1-upload-filename">PostRoll.flv</label> 
                              </div> 
                              <div style="float: right"> 
                                  <span id="f1-upload-cancel"> <a style="padding-right: 10px;" href="javascript:cancelUpload( 'normalvideoform' );" name="submitcancel"><?php esc_attr_e( 'Cancel', APPTHA_VGALLERY ) ?></a> </span> 
                                  <label id="f1-upload-status" style="float: right; padding-right: 40px; padding-left: 20px;">Uploading</label> 
                                  <span id="f1-upload-message" style="font-size: 10px; background: #FFAFAE;"> <b><?php esc_attr_e( 'Upload Failed', APPTHA_VGALLERY ) ?>:</b> 
                                  <?php esc_attr_e( USERCANCELUPLOAD, APPTHA_VGALLERY )?> </span> 
                              </div> </div> </td> 
                        </tr> 
<?php  /** Video upload section ends */ 
/** HD video upload section starts */ ?>
                        <tr id="ffmpeg_disable_new2" name="ffmpeg_disable_new1"> 
                        <?php /** Display Upload HD Video field */  ?>
                            <th><?php esc_attr_e( 'Upload HD Video ( Optional )', APPTHA_VGALLERY ) ?></th> 
                            <td> <div id="f2-upload-form"> 
                                  <form name="hdvideoform" enctype="multipart/form-data"  method="post" > 
                                  <input type="file" onchange="enableUpload( this.form.name );" name="myfile" /> 
                                  <input type="button" name="uploadBtn" class="button" value="Upload Video" disabled="disabled" onclick="return addQueue( this.form.name, this.form.myfile.value );" /> 
                                  <input type="hidden" name="mode" value="video" /> 
                                   <?php /** Display Edit lable for HD Video field */  ?>
                                  <label id="lbl_normal"><?php  if (isset ( $videoEdit->file_type ) && $videoEdit->file_type == 2) {
                                                          echo $videoEdit->hdfile; 
                                                        } ?></label> 
                                  </form> </div> 
                                  <div id="f2-upload-progress" style="display: none"> 
                                      <div style="float: left"> 
                                      <img id="f2-upload-image" src="<?php echo $emptyImage ; ?>" style="padding-top: 2px" alt="Uploading" /> 
                                      <label id="f2-upload-filename" style="padding-top: 0px; padding-left: 4px; font-size: 14px; font-weight: bold; vertical-align: top" >PostRoll.flv</label> 
                                      </div> 
                                      <div style="float: right"> 
                                          <span id="f2-upload-cancel"> <a style="padding-right: 10px;" href="javascript:cancelUpload( 'hdvideoform' );" name="submitcancel"><?php esc_attr_e( 'Cancel', APPTHA_VGALLERY ) ?></a> </span> 
                                          <label id="f2-upload-status" style="float: right; padding-right: 40px; padding-left: 20px;"><?php esc_attr_e( 'Uploading', APPTHA_VGALLERY ) ?></label> 
                                          <span id="f2-upload-message" style="font-size: 10px; background: #FFAFAE;"> 
                                           <?php /** Display video upload error messages */  ?>
                                          <b><?php esc_attr_e( 'Upload Failed', APPTHA_VGALLERY ) ?>:</b>
                                           <?php esc_attr_e( USERCANCELUPLOAD , APPTHA_VGALLERY )?> </span> 
                                      </div> </div>
                            </td>
                        </tr>
<?php /** HD video upload section ends */ 
/** Thumb image upload section starts*/ ?>
                        <tr id="ffmpeg_disable_new3" name="ffmpeg_disable_new1"> 
                        <?php /** Display Upload Thumb Image field */  ?>
                        <th><?php esc_attr_e( 'Upload Thumb Image', APPTHA_VGALLERY ) ?></th> 
                            <td> <div id="f3-upload-form"> 
                                <form method="post" name="thumbimageform" enctype="multipart/form-data">
                                    <input name="myfile" type="file" onchange="enableUpload( this.form.name );" /> 
                                    <input type="button" name="uploadBtn" class="button" value="Upload Image" disabled="disabled" onclick="return addQueue( this.form.name, this.form.myfile.value );" /> 
                                    <input type="hidden" name="mode" value="image" /> <label id="lbl_normal"><?php if (isset ( $videoEdit->file_type ) && ($videoEdit->file_type == 2 || $videoEdit->file_type == 5)) {
                                      echo $videoEdit->image ; 
                                    } ?></label> </form> </div> 
                                <span id="uploadthumbmessage" style="display: block; margin-top: 10px; color: red; font-size: 12px; font-weight: bold;"></span> 
                                <div id="f3-upload-progress" style="display: none"> <div style="float: left"> 
                                    <img src="<?php echo $emptyImage; ?>" id="f3-upload-image" alt="Uploading" style="padding-top: 2px" /> 
                                    <label style="padding-top: 0px; padding-left: 4px; font-size: 14px; font-weight: bold; vertical-align: top" id="f3-upload-filename">PostRoll.flv</label> 
                                    </div>
                                    <div style="float: right"> <span id="f3-upload-cancel"> <a style="padding-right: 10px;" href="javascript:cancelUpload( 'thumbimageform' );" name="submitcancel"><?php esc_attr_e( 'Cancel', APPTHA_VGALLERY ) ?></a> </span> 
                                    <label id="f3-upload-status" style="float: right; padding-right: 40px; padding-left: 20px;"><?php esc_attr_e( 'Uploading', APPTHA_VGALLERY ) ?></label> 
                                    <span id="f3-upload-message" style="font-size: 10px; background: #FFAFAE;"> <b><?php esc_attr_e( 'Upload Failed', APPTHA_VGALLERY ) ?>:</b> 
                                    <?php /** Display cancel Upload status */  ?>
                                    <?php esc_attr_e( USERCANCELUPLOAD, APPTHA_VGALLERY )?> </span> 
                                    </div> </div>
                            </td>
	                        </tr> 
						<?php /** Preview image upload section */ ?>
						<?php /** Display Upload Preview Image field */  ?>
                        <tr name="ffmpeg_disable_new1" id="ffmpeg_disable_new4"> <th><?php esc_attr_e( 'Upload Preview Image ( Optional )', APPTHA_VGALLERY ) ?></th> 
                            <td> <div id="f4-upload-form"> <form name="previewimageform" method="post" enctype="multipart/form-data"> 
                                    <input type="file" name="myfile" onchange="enableUpload( this.form.name );" /> 
                                    <input type="button" class="button" name="uploadBtn" value="Upload Image" disabled="disabled" onclick="return addQueue( this.form.name, this.form.myfile.value );" /> 
                                    <input type="hidden" value="image"  name="mode" /> <label id="lbl_normal"><?php if (isset ( $videoEdit->file_type ) && $videoEdit->file_type == 2) {
                                        echo $videoEdit->opimage; 
                                    } ?></label> </form> </div> 
                                <div id="f4-upload-progress" style="display: none">
                                    <div style="float: left"> <img id="f4-upload-image" alt="Uploading" src="<?php echo $emptyImage; ?>"  style="padding-top: 2px" /> 
                                        <label style="padding-top: 0px; padding-left: 4px; font-size: 14px; font-weight: bold; vertical-align: top" id="f4-upload-filename">PostRoll.flv</label> 
                                    </div>
                                    <div style="float: right"> <span id="f4-upload-cancel"> <a style="padding-right: 10px;" href="javascript:cancelUpload( 'previewimageform' );" name="submitcancel"><?php esc_attr_e( 'Cancel', APPTHA_VGALLERY ) ?></a> </span> 
                                        <label id="f4-upload-status" style="float: right; padding-right: 40px; padding-left: 20px;"><?php esc_attr_e( 'Uploading', APPTHA_VGALLERY ) ?></label> 
                                        <span id="f4-upload-message" style="font-size: 10px; background: #FFAFAE;"> <b><?php esc_attr_e( 'Upload Failed', APPTHA_VGALLERY ) ?>:</b> 
                                       <?php /** Display cancel Upload */  ?>
                                        <?php esc_attr_e( USERCANCELUPLOAD, APPTHA_VGALLERY )?> </span> 
                                    </div> </div> 
                                <div id="nor"> <iframe id="uploadvideo_target" name="uploadvideo_target" src="#" style="width: 0; height: 0; border: 0px solid #fff;"></iframe> </div> 
                            </td> 
                        </tr>
<?php /** Subtitle1 starts here */ ?>
                        <tr id="ffmpeg_disable_new5" name="ffmpeg_disable_new5"> <th><?php /** Display Upload Subtitle1 field */  ?>
                        <?php esc_attr_e( 'Upload srt file for Subtitle1', APPTHA_VGALLERY ) ?></th> 
                            <td> <div id="f5-upload-form"> <form name="subtitle1form" method="post" enctype="multipart/form-data"> 
                                    <input type="file" name="myfile" onchange="enableUpload( this.form.name );" /> 
                                    <input type="button" class="button" value="Upload File" name="uploadBtn" disabled="disabled" onclick="return addQueue( this.form.name, this.form.myfile.value );" /> 
                                    <input type="hidden" name="mode" value="srt" /> <label id="lbl_normal"><?php if (isset ( $videoEdit->file_type ) && $videoEdit->file_type != 5) {
                                    echo $videoEdit->srtfile1 ; 
                                    } ?></label> </form> </div> 
                                
                                <div id="f5-upload-progress" style="display: none"> <div style="float: left"> 
                                    <img id="f5-upload-image" alt="Uploading" src="<?php echo $emptyImage; ?>" style="padding-top: 2px" /> 
                                    <label id="f5-upload-filename" style="padding-top: 0px; padding-left: 4px; font-size: 14px; font-weight: bold; vertical-align: top" >Subtitle.srt</label> 
                                    </div> 
                                    <div style="float: right"> <span id="f5-upload-cancel"> <a style="padding-right: 10px;" href="javascript:cancelUpload( 'subtitle1form' );" name="submitcancel"><?php esc_attr_e( 'Cancel', APPTHA_VGALLERY ) ?></a> </span> 
                                    <label id="f5-upload-status" style="float: right; padding-right: 40px; padding-left: 20px;"><?php esc_attr_e( 'Uploading', APPTHA_VGALLERY ) ?></label> 
                                    <span id="f5-upload-message" style="font-size: 10px; background: #FFAFAE;"> <b><?php esc_attr_e( 'Upload Failed', APPTHA_VGALLERY ) ?>:</b> 
                                    <?php esc_attr_e( USERCANCELUPLOAD, APPTHA_VGALLERY )?> </span> </div> </div> 
                            </td> 
                        </tr>
<?php /** Subtitle1 ends here */ 
/** Subtitle language name section */ ?>
                        <tr id="subtilelang1" style="display: none;"> <th width="17%"><?php /** Display Upload Subtitle lang1 field */  ?>
                        <?php echo esc_attr_e( 'Enter Subtitle1 language' ); ?></th> 
                        <td width="83%"><input id="subtile_lang1" type="text" name="subtile_lang1" style="width: 300px" maxlength="250" 
                            value="<?php if ( isset( $videoEdit->subtitle_lang1 ) ) {
                              echo htmlentities( $videoEdit->subtitle_lang1 ); 
                            } ?>" /><span id="uploadsrt1message" style="display: block; margin-top: 10px; color: red; font-size: 12px; font-weight: bold;"></span> 
                          </td>
                        </tr> 
<?php /** Subtitle2 section starts */ ?>
                        <tr id="ffmpeg_disable_new6" name="ffmpeg_disable_new6"> <th><?php /** Display Upload Subtitle2 field */  ?>
                        <?php esc_attr_e( 'Upload srt file for Subtitle2', APPTHA_VGALLERY ) ?></th> 
                            <td> <div id="f6-upload-form"> <form name="subtitle2form" method="post" enctype="multipart/form-data"> 
                                      <input type="file" name="myfile" onchange="enableUpload( this.form.name );" /> 
                                      <input type="button" class="button" name="uploadBtn" value="Upload File" disabled="disabled" 
                                      onclick="return addQueue( this.form.name, this.form.myfile.value );" /> 
                                      <input type="hidden" name="mode" value="srt" /> <label id="lbl_normal"><?php  if (isset ( $videoEdit->file_type ) && $videoEdit->file_type != 5) {
                                          echo $videoEdit->srtfile2 ; 
                                      } ?></label> </form> </div>
                                  <div id="f6-upload-progress" style="display: none"> <div style="float: left"> 
                                        <img src="<?php echo $emptyImage ; ?>" alt="Uploading" id="f6-upload-image" style="padding-top: 2px" /> 
                                        <label style="padding-top: 0px; padding-left: 4px; font-size: 14px; font-weight: bold; vertical-align: top" id="f6-upload-filename">SubTitle.srt</label> 
                                      </div> 
                                      <div style="float: right"> <span id="f6-upload-cancel"> <a style="padding-right: 10px;" href="javascript:cancelUpload( 'subtitle2form' );" name="submitcancel"><?php esc_attr_e( 'Cancel', APPTHA_VGALLERY ) ?></a> </span> 
                                          <label id="f6-upload-status" style="float: right; padding-right: 40px; padding-left: 20px;"><?php esc_attr_e( 'Uploading', APPTHA_VGALLERY ) ?></label> 
                                          <span id="f6-upload-message" style="font-size: 10px; background: #FFAFAE;"> <b><?php esc_attr_e( 'Upload Failed', APPTHA_VGALLERY ) ?>:</b> 
                                          <?php esc_attr_e( USERCANCELUPLOAD, APPTHA_VGALLERY )?> </span> </div> 
                                  </div> 
                            </td>
                        </tr> 
<?php /** Subtitle2 section starts */ 
/** Subtitle2 language name section */ ?>
                        <tr id="subtilelang2" style="display: none;"> <th width="17%"><?php /** Display Upload Subtitle lang2 field */  ?>
                        <?php echo esc_attr_e( 'Enter Subtitle2 language' ); ?></th> 
                        <td width="83%"><input type="text" name="subtile_lang2" id="subtile_lang2" style="width: 300px" maxlength="250" value="<?php if ( isset( $videoEdit->subtitle_lang2 ) ) { 
                          echo htmlentities( $videoEdit->subtitle_lang2 ); 
                        } ?>" /> <span id="uploadsrt2message" style="display: block; margin-top: 10px; color: red; font-size: 12px; font-weight: bold;"></span> 
                        </td> </tr> 
                    </table> 
                </div> 
            </div> 
        </div>
<?php /** Subtitle ends here */ 
/** Form hidden values */ ?>
        <form name="table_options" enctype="multipart/form-data" method="post" id="video_options" onsubmit="return chkbut()"> 
            <input type="hidden" name="normalvideoform-value" id="normalvideoform-value" 
                value="<?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type == 2 )  { 
                  echo $videoEdit->file; 
        } ?>" />  
        <input type="hidden" name="hdvideoform-value" id="hdvideoform-value" value="<?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type == 2 ) { 
            echo $videoEdit->hdfile ; 
        } ?>" /> 
        <input type="hidden" name="thumbimageform-value" id="thumbimageform-value" 
        value="<?php if ( isset( $videoEdit->file_type ) && ( $videoEdit->file_type == 2 || $videoEdit->file_type == 5 ) ) { 
          echo $videoEdit->image ; 
        } ?>" /> 
        <input type="hidden" name="previewimageform-value" id="previewimageform-value" 
        value="<?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type == 2 ) { 
          echo $videoEdit->opimage ; 
        } ?>" /> 
        <input type="hidden" name="subtitle1form-value" id="subtitle1form-value" 
        value="<?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type != 5 ) { 
          echo $videoEdit->srtfile1 ; 
        } ?>" /> 
        <input type="hidden" name="subtitle2form-value" id="subtitle2form-value" 
        value="<?php if ( isset( $videoEdit->file_type ) && $videoEdit->file_type != 5 ) { 
          echo $videoEdit->srtfile2; 
        } ?>" /> 
        <input type="hidden" name="subtitle_lang1" id="subtitle_lang1" value="" /> 
        <input type="hidden" name="subtitle_lang2" id="subtitle_lang2" value="" /> 
        <input type="hidden" name="youtube-value" id="youtube-value" value="" /> 
        <input type="hidden" name="streamerpath-value" id="streamerpath-value" value="" /> 
        <input type="hidden" name="embed_code" id="embed_code" value="" /> 
        <input type="hidden" name="islive-value" id="islive-value" value="0" /> 
        <input type="hidden" name="customurl" id="customurl1" value="" /> 
        <input type="hidden" name="customhd" id="customhd1" value="" /> 
        <input type="hidden" name="custompreimage" id="custompreimage" value="" />
        <input type="hidden" name="customimage" id="customimage" value="" />
        <input type="hidden" name="member_id" id="member_id" value="<?php if ( isset( $videoEdit->member_id ) )  { 
          echo $videoEdit->member_id ; 
        } ?>" />  
        <?php /** Check amazon S3 bucket enabled
        		* If enabled set valus as 1 
        		*/  ?>
        <?php if( $player_colors['amazonbuckets_enable'] && $player_colors['amazonbuckets_link'] && $player_colors['amazonbuckets_name'] ) { ?> 
            <input type="hidden" name="amazon_buckets" id="amazon_buckets" value="1" /> 
        <?php } else{ ?> 
            <input type="hidden" name="amazon_buckets" id="amazon_buckets" value="0">
        <?php } ?>
        
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="post-body-content">
<?php /** Form hidden fields ends here */ 
/** Video title section starts */ ?>
						<div class="stuffbox">
							<h3 class="hndle"><?php /** Display video title field */  ?>
								<span><?php esc_attr_e( 'Enter Title / Name', APPTHA_VGALLERY ); ?></span>
							</h3>
							<div class="inside">
								<table class="form-table">
									<tr>
										<th scope="row"><?php esc_attr_e( 'Title / Name', APPTHA_VGALLERY ) ?></th>
										<td><input
											value="<?php if ( isset( $videoEdit->name ) ) { 
											  echo htmlentities( $videoEdit->name ); 
											} ?>"
											type="text" size="50" maxlength="200" name="name"
											onkeyup="validatevideotitle();" id="name" /> <span
											id="titlemessage"
											style="display: block; margin-top: 10px; color: red; font-size: 12px; font-weight: bold;"></span>
										</td>
									</tr>
<?php /** Video title section ends */ 
/** Video description section starts */ ?>
									<tr><?php /** Display video description field */  ?>
										<th scope="row"><?php esc_attr_e( 'Description', APPTHA_VGALLERY ) ?></th>
										<td><?php if ( isset( $videoEdit->description ) ) { 
										  $video_description = $videoEdit->description; 
										} 
										/** Display WP editor for description
										 * Show description while editing  */  
										wp_editor( $video_description, 'description' ); ?> </td>
									</tr>
<?php /** Video description section ends */ 
/** Video tag section starts */ ?>
									<tr>
										<th scope="row"><?php /** Display video tags field */  ?>
										<?php esc_attr_e( 'Tags / Keywords', APPTHA_VGALLERY ) ?></th>
										<td><input value="<?php if ( isset( $videoEdit->tags_name ) ) { 
											  echo  $videoEdit->tags_name; 
											} ?>" type="text" size="50" maxlength="200" name="tags_name"
											id="tags_name" /></td>
									</tr>
<?php /** Video tag section ends */ 
/** Enable/disbale feature option starts*/ ?>
									<tr><?php /** Display Featured Video field */  ?>
										<th scope="row"><?php esc_attr_e( 'Featured Video', APPTHA_VGALLERY ) ?></th>
										<td>
<?php /** Get featured value and checked based on that value */  
if (isset ( $videoEdit->featured ) && $videoEdit->featured) {
            $feature_enable = "checked";
            $feature_disable = "";
          } else if (isset ( $videoEdit->featured ) && $videoEdit->featured == '0') {
            $feature_enable = "";
            $feature_disable = "checked";
          } else {
            $feature_enable = "";
            $feature_disable = "checked";
          }
          ?>
											<input type="radio" id="feature_on" name="feature"
											<?php echo $feature_enable ; ?> value="1"> <label>Yes</label>
											<input type="radio" name="feature"
											<?php echo $feature_disable; ?> value="0"> <label>No</label>

										</td>
									</tr>
<?php /** Enable/disbale feature option ends */ 
/** Enable/disbale download option starts */ ?>
									<tr><?php /** Display Download field */  ?>
										<th scope="row"><?php esc_attr_e( 'Download', APPTHA_VGALLERY ) ?></th>
										<td><input type="radio" id="" name="download" <?php if ( isset( $videoEdit->download ) && $videoEdit->download == '1' ) { 
											  echo $checked; 
											} ?> value="1"> <label>Yes</label> 
											<input type="radio" id="" name="download" <?php if (!isset( $videoEdit->download )){ 
											  echo $checked;
											} if ( isset( $videoEdit->download ) && ( $videoEdit->download == '' || $videoEdit->download == '0' ) ) { 
echo $checked; 
} ?> value="0"> <label>No</label> <br /><?php /** Display Download messge for user */  ?>
<?php esc_attr_e( 'Note : Supported Only For Uploaded videos', APPTHA_VGALLERY )?>
										</td>
									</tr>
<?php /** Enable/disbale download option ends */ 
/** Enable/disbale publish option starts */ ?>

<tr><?php /** Display Publish field */  ?>
										<th scope="row"><?php esc_attr_e( 'Publish', APPTHA_VGALLERY ) ?></th>
										<td><input type="radio" id="" name="publish" <?php if ( !isset( $videoEdit->publish ) ){ 
											  echo $checked; 
											} if ( isset( $videoEdit->publish ) && $videoEdit->publish == '1' ) { 
echo $checked; 
} ?> value="1"> <label>Yes</label> 
<input type="radio" id="" name="publish" <?php  if ( isset( $videoEdit->publish ) && $videoEdit->publish == '0' ) { 
											  echo $checked; 
											} ?> value="0"> <label>No</label></td>
									</tr>

								</table>
							</div>
						</div>
<?php /** Enable/disbale publish option ends */ 
/** To display the list of pre roll ads */ 
/** Check whether preroll ads are enable
 * Get pre and post roll ad details to display in drop down */ 
global $wpdb;
$tables = getVideoAdDetails ( 'prepost', '' ); 
/** Get plugin settings for ads */
$settings = getPluginSettings(); 
/** Get goolge adsense detials to display in drop down */
$key = '.*"publish";s:1:"1"*.';
$google_adsenses = $wpdb->get_results ( "SELECT * FROM " . $wpdb->prefix . "hdflvvideoshare_vgoogleadsense WHERE googleadsense_details REGEXP '$key'");
$flag = 0;
if($settings ->preroll == 0 || $settings ->postroll == 0) {
$flag = 1;
}
if ( $flag || $settings->midroll_ads == 0  || $settings ->imaAds == 0 || $player_colors ['googleadsense_visible'] == 1) { ?>
  <?php /** Enable/disbale preroll option */ ?>
                  <div class="stuffbox" id="adstypebox"> <h3 class="hndle"> <span><?php esc_attr_e( 'Select Ads', APPTHA_VGALLERY ); ?></span> </h3> 
                  <div class="inside"> <?php if ( $settings->preroll == 0 ) { ?> 
                  <table class="form-table"> 
                      <tr> <th scope="row"><?php esc_attr_e( 'Preroll ads', APPTHA_VGALLERY ) ?></th> 
                            <td><?php /** Display pre roll ads field */  ?>
                            <select name="prerollads" id="prerollads"> <option value="0">select</option> 
                                <?php foreach ( $tables as $table ) { ?>
                                <option id="6<?php echo $table->ads_id ; ?>" 
                                name="<?php echo $table->ads_id ; ?>" 
                                value="<?php echo  $table->ads_id ; ?>"> 
                                <?php echo $table->title ; ?></option> 
                                <?php } ?> </select> 
                                <?php if (isset ( $videoEdit->prerollads ) && ($videoEdit->prerollads)) { 
                                  echo '<script>document.getElementById( "6' . $videoEdit->prerollads . '" ).selected="selected"</script>'; 
                                } ?> 
                            </td>
                      </tr>
                  </table>
                  <?php } if ( $settings->postroll == 0 ) { ?> 
<?php /** Enable/disbale postroll option */ ?>
                  <table class="form-table"> 
                    <tr> <th scope="row"><?php esc_attr_e( 'Postroll ads', APPTHA_VGALLERY ) ?></th> 
                    <?php /** Display post roll ads field */  ?>
                        <td><select name="postrollads" id="postrollads"> <option value="0">select</option> 
                            <?php  foreach ( $tables as $table ) { ?> 
                            <option name="<?php echo $table->ads_id ; ?>"
                            id="5<?php echo $table->ads_id ; ?>" 
                            value="<?php echo $table->ads_id ; ?>"> 
                            <?php echo $table->title ; ?></option> 
                            <?php } ?> </select> 
                            <?php if (isset ( $videoEdit->postrollads ) && ($videoEdit->postrollads)) { 
                                echo '<script>document.getElementById( "5' . $videoEdit->postrollads . '" ).selected="selected"</script>'; 
                            } ?> 
                        </td> </tr> 
                  </table>
	<?php } ?>
	<?php if ( $settings->midroll_ads == 0 ) { ?>
<?php /** Enable/disbale midroll option */ ?>
	<table class="form-table">
                                            <?php  $videodisable = '';
    if (! isset ( $videoEdit->midrollads )) {
      $videodisable = 'checked';
    }
    ?>
											<tr><?php /** Display midroll ads field */  ?>
										<th scope="row"><?php esc_attr_e( 'Midroll Ad', APPTHA_VGALLERY ) ?></th>
										<td><input type="radio" id="midrollads_on" name="midrollads"
											<?php if ( isset( $videoEdit->midrollads ) && $videoEdit->midrollads == '1' ) { 
											  echo $checked; 
											} ?> value="1"> <label>Enable</label>
											 <input type="radio" id="midrollads_off" name="midrollads" <?php if ( isset( $videoEdit->midrollads ) && $videoEdit->midrollads == '0' ) { 
											  echo $checked; 
											}
											 echo $videodisable; ?> value="0"> <label>Disable</label></td>
									</tr>
								</table>
							<?php } ?>
							<?php if ( $settings->imaAds == 0 ) { ?>
	                                    <?php
    
$videodisable = '';
    if (! isset ( $videoEdit->imaAds )) {
      $videodisable = 'checked';
    } else {
      $videodisable = 'checked';
    }
    ?>
<?php /** Enable/disbale IMA ad option */ ?>
    <table class="form-table">
									<tr><?php /** Display ima ads field */  ?>
										<th scope="row"><?php esc_attr_e( 'IMA Ad', APPTHA_VGALLERY ) ?></th>
										<td><input type="radio" id="imaad" name="imaad" <?php if ( isset( $videoEdit->imaad ) && $videoEdit->imaad == '1' ) { 
											  echo $checked; 
											} ?> value="1"> <label>Enable</label> 
											<input type="radio" id="imaad" name="imaad" <?php if (!isset( $videoEdit->imaad)) { 
											  echo 'checked'; 
											}  if ( isset( $videoEdit->imaad ) && $videoEdit->imaad == '0' ) { 
echo $checked; 
} ?> value="0"> <label>Disable</label></td>
									</tr>
								</table>
									<?php } ?>  
									<?php  if( isset($player_colors['googleadsense_visible']) && $player_colors['googleadsense_visible'] == 1 ) { ?>                                                      
<?php /** Enable/disbale google adsense option */ ?>
									<table class="form-table">
									<tr>  <?php
    
$videodisable = '';
    if (! isset ( $videoEdit->google_adsense )) {
      $videodisable = 'checked';
    }
    ?><?php /** Display google adsense field */  ?>
	                                       <th scope="row"> <?php esc_attr_e('Google Adsense Show',APPTHA_VGALLERY);?></th>
										<td><input type="radio" id="googleadsense" name="googleadsense" <?php if ( isset( $videoEdit->google_adsense ) && $videoEdit->google_adsense == '1' ) { 
											  echo $checked; 
											} ?> value="1"> <label>Enable</label> 
											<input type="radio" id="googleadsense" name="googleadsense" <?php if ( isset( $videoEdit->google_adsense ) && $videoEdit->google_adsense == '0' ) { 
											  echo $checked; 
											} 
											echo $videodisable ; ?> value="0"> <label>Disable</label></td>
									</tr>
								</table>
<?php /** Google adsense select section */ ?>
								<table class="form-table">
									<tr>
										<th scope="row"> <?php esc_attr_e('Google Adsense',APPTHA_VGALLERY);?></th>
										<td><select name="google_adsense_value">
	                                         <?php if (isset ( $videoEdit->google_adsense_value )) {
      $editGoogleadsense = $videoEdit->google_adsense_value;
    } else {
      $editGoogleadsense = '0';
    }
    ?>
	                                         <option value="0"
													<?php if($editGoogleadsense == 0){ 
													  echo 'seleceted';
													} ?>><?php esc_attr_e('Select',APPTHA_VGALLERY);?></option> 
	                                         <?php
    
if ($google_adsenses) {
      foreach ( $google_adsenses as $google_adsense ) {
        $googleadsense_details = unserialize ( $google_adsense->googleadsense_details );
        $google_code = $googleadsense_details ['googleadsense_title'];
        ?>
	                                         	<option
													value="<?php echo $google_adsense->id;?>"
													<?php if($google_adsense->id ==$editGoogleadsense ){ 
													  echo "selected";
													} ?>><?php echo $google_code ;?></option>
	                                         <?php }
    }
    ?>
	                                         </select></td>
									</tr>
								</table>
	                                   <?php } ?>
								</div>
						</div>
	<?php }  ?>
					</div>
					<?php /** Start of sidebar */ ?>
					<div id="postbox-container-1" class="postbox-container">
						<div id="side-sortables"
							class="inner-sidebar meta-box-sortables ui-sortable">
<?php /** Video ads section ends */  
/** Video category option starts */ ?>
							<div id="categorydiv" class="postbox">
								<div class="handlediv" title="Click to toggle">
									<br>
								</div>
								<h3 class="hndle"><?php /** Display categories field */  ?>
									<span><?php esc_attr_e( 'Categories', APPTHA_VGALLERY ); ?></span>
								</h3>
								<div class="inside" style="">
									<div id="submitpost" class="submitbox">

										<div class="misc-pub-section">
										<?php /** Check whether the current user is admin */
          if ($user_role != 'subscriber') {
            ?>
<?php /** Create video category section */ ?>
            <h4><?php /** Display create new link in new videos page */?>
												<span> <a style="cursor: pointer"
													onclick="playlistdisplay()"><?php esc_attr_e( 'Create New', APPTHA_VGALLERY ) ?></a></span>
											</h4><?php /** Display catgories list to select */?>
											<div id="playlistcreate1"><?php esc_attr_e( 'Name', APPTHA_VGALLERY ); ?><input
													type="text" style="width: 100%;" name="p_name" id="p_name"
													value="" /> <input type="button"
													class="button-primary button button-highlighted"
													name="add_pl1" value="<?php esc_attr_e( 'Add' ); ?>"
													onclick="return savePlaylist( document.getElementById( 'p_name' ), <?php echo $act_vid; ?> );" />
												<a class="button cancelplaylist" onclick="playlistclose()"><b><?php esc_attr_e( 'Close' ); ?></b></a>
											</div>
											<?php } ?>
											<div id="jaxcat"></div>
											<div id="playlistchecklist"><?php $ajaxplaylistOBJ->get_playlist(); ?></div>
											<input type="hidden" name="filetypevalue" id="filetypevalue"
												value="1" />
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
<?php /** Video category option ends*/ 
/** End of sidebar */ ?>
					<p>
						<input type="submit" name="add_video" class="button-primary"
							onclick="return validateInput();"
							value="<?php echo esc_attr_e( $editbutton, APPTHA_VGALLERY ); ?>"
							class="button" /> <input type="button"
							onclick="window.location.href = 'admin.php?page=video'"
							class="button-secondary" name="cancel"
							value="<?php esc_attr_e( 'Cancel', APPTHA_VGALLERY ); ?>"
							class="button" />
					</p>
				</div>
<?php /** END Post body */ ?>
			</div>
<?php /** END Poststuff */ ?>
		</form>
		<script>
		if(document.getElementById( 'generate' ))
				document.getElementById( 'generate' ).style.visibility = "hidden";
		</script>
	</div>
<?php /** END wrap */ ?>
</div>
<?php /** END wrap */ ?>
<script type="text/javascript">
function checkValue(check_type,btn_name){
	t1(check_type);
	document.getElementById(btn_name).checked = true;
}
<?php 
/** 
 * Check file type is exist
 * If exist then select the video type option button based on that value
 */
if(isset($videoEdit->file_type)) {
    switch ($videoEdit->file_type) {
      case 1: ?>
      checkValue("c","btn2");
<?php break;
      case 2: ?>
        checkValue("y","btn1");
<?php break;
      case 3: ?>
        checkValue("url","btn3");
<?php break;
      case 4: ?>
        checkValue("rtmp","btn4");
<?php break;
      case 5: ?>
        checkValue("embed","btn5");
<?php break;
      default:
        break;
    }
  } else if( in_array('c', $user_allowed_method) || $user_admin) { ?>	
	checkValue("c","btn2");
<?php } else if( in_array('y', $user_allowed_method)) { ?>
    checkValue("y","btn1");
<?php } else if( in_array('url', $user_allowed_method)) { ?>
checkValue("url","btn3");
<?php } else if( in_array('rmtp', $user_allowed_method)) { ?>
checkValue("rtmp","btn4");
<?php } else if( in_array('embed', $user_allowed_method)) { ?>
checkValue("embed","btn5");
<?php } else { ?>
checkValue("c","btn2");	
<?php } ?>
</script>