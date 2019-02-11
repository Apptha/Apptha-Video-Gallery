<?php
/**  
 * Channel Template file.
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/**
 * This page is used to display the required user channel page.
 * Provided option to subscribe other user channel.
 * Added functionality for site administrator to edit subscriber channel page.
 * Added functionality to restrict user except site administrator to edit subscriber channel page.
 * Provided option for site administrator to edit subscriber profile images.
 * Provided option for site administrator to edit subscriber cover images.
 * Provided option for site administrator to edit subscriber channel name and descrition.
 * Provided option for site administrator to delete user subscribed on this user.
 * Provided option for site administrator to delete subscriber notification.
 * Provided option for user to edit profile/cover images.
 * Provided option to search required subscriber channel.Provided notification option.
 * Provided option to view subscriber channel videos.
 * Provided option to view subscriber channel description.
 * Provided option to view subscriber channel profile images.
 * Provided option to view subscriber channel cover images.
 * Provided drag and drop functionality to upload profile and cover images.
 * Provided image cropping functionality to crop profile and cover images.
 */
$profileImage = $description = $coverImage = $userId = $user = $profileImageUrl = $coverImageUrl = $subscribeDetails = '';
define('PROFILE_IMAGE','profileImage');
define('SUBCID','sub_id');
$channel_subscribe = 'channel_subscribe';
define('SUBSCRIBER_LINK','index.php?option=com_contushdvideoshare&task=subscribe&ukey=');
$notification_image = 'subs.png';
$profile_path = 'images/channel/banner/profile/';
$profileImage    = $this->userContent[PROFILE_IMAGE];
$coverImage      = $this->userContent['coverImage'];
$description     = $this->userContent['description'];
$channelUserName = $this->channelContent->user_name;
$profileImageUrl = APPTHA_VGALLERY_BASEURL. $profile_path.$profileImage;
$coverImageUrl   = APPTHA_VGALLERY_BASEURL. "images/channel/banner/cover/".$coverImage;
$mysubscriberCount = count(json_decode($this->mysubscriberCount,true));
$notificationDetails = $this->notificationDetails;
$userAgent = $_SERVER['HTTP_USER_AGENT'];
preg_match('/MSIE/i',$userAgent,$ieBrowser);
$subscriberID = json_decode($this->mysubscriberCount,true);
$notCloseButton = APPTHA_VGALLERY_BASEURL. "images/channel/playerclose.png";
define('ALLHTTP','ALL_HTTP');
$mobileDevices = vgallery_detect_mobile();
?>
<div class="Channelcontainer">
<div class="loadingBar"></div>
<div class="bannerContainer">
<div class="coverContainer">
<?php if(empty($coverImage) || !file_exists(APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/cover/".$coverImage)) {
?>	
<img src="<?php echo APPTHA_VGALLERY_BASEURL. "images/channel/normalCover.jpg"; ?>" class="coverImages" style="height:250px; width:100% !important;max-width:100%" />
<?php } 
else {
?>
<img src="<?php echo $coverImageUrl; ?>" class="coverImages" style="height:250px;width:100% !important;max-width:100%"/>
<?php } 
?>
<?php 
if(!($mobileDevices) && $this->admin == true ) {
?>
<div class="coverEditor">
<img src="<?php echo APPTHA_VGALLERY_BASEURL. "images/channel/edit.gif"; ?>" style="height:37px;width:37px;" />
</div>
<?php 
}
?>
</div>
<div class="profileContainer">
<?php if(empty($profileImage) || !file_exists(APPTHA_VGALLERY_BASEDIR. "/".$profile_path.$profileImage) ) {
?>
<img src="<?php echo APPTHA_VGALLERY_BASEURL. "images/channel/".$notification_image; ?>"  class="profileImages" style="width:160px;height:160px;" />
<?php } 
else { 
?>
<img src="<?php echo $profileImageUrl; ?>"  class="profileImages" style="width:inherit;height:inherit;" />
<?php } 
?>
<?php 
if(!($mobileDevices) && $this->admin == true ) {
?>
<div class="profileEditor">
<img src="<?php echo APPTHA_VGALLERY_BASEURL. "images/channel/edit.gif"; ?>" style="height:37px;width:37px;" />
</div>
<?php 
}
?>
</div>
<div class="dragContainer" id="dragContainer">
<div class="dragRow">
<p class="closeButton"><span>X</span></p>
<?php 
if(empty($ieBrowser)) {
?>
<h3 class="dropHeading" id="dropHeading" style="margin:0 !important"><?php echo __( 'Drop image to upload', APPTHA_VGALLERY ); ?></h3>
<p class="orText" style="margin:0 !important">or</p>
<div class="fileContainer">
<p class="imageButtonRow"><span class="imageButton"><?php echo __( 'Select Image', APPTHA_VGALLERY ); ?></span></p>
<?php 
}
if(!empty($ieBrowser)) {
?>
<form action="<?php echo admin_url().'admin-ajax.php?action=channelimageupload'; ?>" method="POST" enctype="multipart/form-data" class="uploadSubmitButton" name="uploadSubmitButton">
<input type="file" name="images" class="fileContent browseieonly">
<input type="hidden"  name="ui" class="ui" value="<?php echo $this->userID; ?>">
<input type="hidden"  name="uploadType" class="uploadTypeValue" >
</form>
<?php 
}
else {
?>
<input type="file" name="images" class="fileContent" style="display:none">
<?php 
}
?>
</div>
<p class="pixelCondition"></p>
</div>
</div>
<div class="cropContainer" id="cropContainer" style="background-image:url('<?php echo $coverImageUrl; ?>');">
</div>
<div class="profileDragContainer" id="profileCropContainer" style="display:none;">
</div>
<div class="dragBox">
<div class="rotate">
<div class="line"><i></i></div>
<div class="line"><i></i></div>
<div class="line"><i></i></div>
<div class="line"><i></i></div>
<p class="channel_profile_text"><?php echo __( 'Drag reposition', APPTHA_VGALLERY ); ?></p>
</div>
</div>
<div class="channel_dragreposition"><p><?php echo __( 'Drag image to select area to crop', APPTHA_VGALLERY ); ?></p></div>
</div>
<input type="hidden" class="ui" value="<?php echo $this->userID; ?>">
<div class="saveButtonContainer">
<p class="saveButtonRow"> <br> <span class="saveButton"><?php echo __( 'Crop Image', APPTHA_VGALLERY ); ?></span><span class="cancelButton"><?php echo __( 'Cancel', APPTHA_VGALLERY ); ?></span></p>
</div>
<div class="dragButtonContainer">
<p class="dragButtonRow"><span class="saveProfileImage"><?php echo __( 'Crop Image', APPTHA_VGALLERY ); ?></span><span class="cancelButton"><?php echo __( 'Cancel', APPTHA_VGALLERY ); ?></span></p>
</div>
<div class="user_profile_name">
<h3 class="authorHeading"><?php echo $this->channelContent->user_name; ?></h3>
<?php 
if(!empty($notificationDetails) && $this->admin == true ) {
?>
<div class="notifi notificationsection" style="float:left";>
<img src="<?php echo APPTHA_VGALLERY_BASEURL. "images/channel/notification.png"; ?>" title="Notification" class="notificationLink">
<span class="ncount"><span class="countno"><?php echo count($notificationDetails)?></span></span>
<div class="notificationContainers">
<div class="notificationRows">
<ul class="notificationParent">
<?php 
$notificationCount = '';
$notificationCount = count($notificationDetails);
$channelPageLink = channelPageLink();
foreach($notificationDetails as $notification) {
$jsonDetails = json_decode($notification->user_content,true);
$notificationImage = ($jsonDetails[PROFILE_IMAGE] != '' && file_exists(APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/profile/".$jsonDetails[PROFILE_IMAGE])) ? APPTHA_VGALLERY_BASEURL. $profile_path.$jsonDetails[PROFILE_IMAGE] : APPTHA_VGALLERY_BASEURL. "images/channel/".$notification_image;
$userUrl = add_query_arg(array('ukey'=>$notification->user_key),$channelPageLink);
?>
<li class="notificationLis" id="<?php echo 'n'.$notification->user_id; ?>">
<a href="<?php echo $userUrl;?>" target="_blank">
<img src="<?php echo $notificationImage; ?>" class="subImage" style="width:50px;height:50px;">
</a><a href="<?php echo $userUrl;?>" target="_blank">
<span class="notificationText"><?php echo (strlen($notification->user_name) > 20 ) ? substr($notification->user_name,0,20).'... ' : $notification->user_name ; ?></span></a>
<p style="margin:0 !important" class="notButtonRow">
<?php 
if(empty($subscriberID)) {
$subscriberID = array();
}
if(!in_array($notification->user_id,$subscriberID)) {
?>
<span class="subButton"><?php echo __( 'Subscribe', APPTHA_VGALLERY ); ?></span>
<?php 
}
?>
<img src="<?php echo $notCloseButton; ?>" class="subDeleteButton" title="Remove notification" style="display:inline-block;cursor:pointer;position:relative;top:2px;"><input type="hidden" class="subscriperId" value="<?php echo $notification->user_id; ?>"></p>
</li>
<?php 
}
?>
</ul>
</div>
<?php 
if($notificationCount > 3) {
?>
<div class="seeMoreLink"><?php echo __( 'See More', APPTHA_VGALLERY ); ?></div>
<?php 
}
?>
</div>
</div>
<?php 
}
?>
<div style="clear:both"></div>
</div>
<?php 
if($this->admin == true && $this->subscriberChannel == false ) {
?>
<div class="videoTopContainer">
<div class="videoTop" style="float:left;">
<input type="text" placeholder="Search Channel" name="search" class="search channelsearch plcholdercls" id="dynamicplacholder"><span class="searchChannelButton">Search Channel</span><!--<span class="searchButton">Search</span>--><span class="browseChannelButton">Browse Channel</span>
<?php 
$videoUpload = get_permalink().'index.php?option=com_contushdvideoshare&task=videoupload';
?>
<a href="<?php echo admin_url().'admin.php?page=newvideo'; ?>" target="_blank"><span class="uploadButton">Upload Videos</span></a>
</div>
</div>
<?php 
}
?>
<div class="channelContentContainer">
<div class="channelMenuContainer">
<?php 
if($this->subscriberChannel == false ) {
?>
<p class="myVideosButton" id="myVideosButton"><a href="<?php echo admin_url().'admin.php?page=video'; ?>"><?php echo __( 'My Videos', APPTHA_VGALLERY ); ?></a></p>
<?php 
}
else {
?>    
<p class="myVideosButton subscriberVideosButton" id="myVideosButton"><?php echo __( 'Videos', APPTHA_VGALLERY ); ?></p>
<?php 
}
if($this->admin == true && $this->subscriberChannel == false ) {
?>    
<p class="mySubscriptionButton"><?php echo __( 'My Subscription', APPTHA_VGALLERY ); ?> &nbsp;&nbsp;(<span class="subscriptionCount"><?php echo ($mysubscriberCount != 0) ? $mysubscriberCount : '0'; ?></span>)</p>
<?php 
}
if($this->admin == true && $this->subscriberChannel == true ) {
?>
<p class="mySubscriptionButton"><?php echo __( 'Subscriber', APPTHA_VGALLERY ); ?> &nbsp;&nbsp;(<span class="subscriptionCount"><?php echo ($mysubscriberCount != 0) ? $mysubscriberCount : '0'; ?></span>)</p>
<?php
} 
?>
<p class="aboutButton"><?php echo __( 'About', APPTHA_VGALLERY ); ?></p>
</div>
<div class="videoContainer">
<div class="videoContent">
</div>
</div>
<div class="aboutContainer">
<?php 
if($this->admin == true ) {
?>
<h3 class="descriptionHeading"><?php echo __( 'Channel Name', APPTHA_VGALLERY ); ?></h3>
<input type="field" name="userName" class="userName" value="<?php echo $channelUserName; ?>"><br>
<?php 
}
?>
<h3 class="descriptionHeading"><?php echo __( 'Channel Description', APPTHA_VGALLERY ); ?></h3>
<textarea placeholder="Enter Channel Description" class="channelDescription" <?php echo ($this->admin == true) ? "" : "disabled" ; ?>>
<?php echo $description; ?></textarea>
<?php 
if($this->admin == true ) {
?>
<p class="descriptionButtonRow"><span class="saveDescription"><?php echo __( 'Save', APPTHA_VGALLERY ); ?></span></p>
<?php 
}
?>
</div>
<div class="mysubscriptionContainer">
<div class="mysubscriptionRow">
</div>
<div style="clear:both"></div>
</div>
<div class="subscripeContainer">
</div>
<?php 
if(!empty($notificationDetails) && $this->admin == true ) {
?>
<div class="notificationContainer">
<div class="notificationRow">
<ul>
<?php 
$notificationCount = '';
$notificationCount = count($notificationDetails);
$channelPageLink = channelPageLink();
foreach($notificationDetails as $notification) {
$jsonDetails = json_decode($notification->user_content,true);
$notificationImage = ($jsonDetails[PROFILE_IMAGE] != '') ? APPTHA_VGALLERY_BASEURL. $profile_path.$jsonDetails[PROFILE_IMAGE] : APPTHA_VGALLERY_BASEURL. "images/channel/".$notification_image;
$userUrl = add_query_arg(array('ukey'=>$notification->user_key),$channelPageLink);
?>
<li class="notificationLi" id="<?php echo 'n'.$notification->user_id; ?>">
<a href="<?php echo $userUrl;?>" target="_blank" >
<img src="<?php echo $notificationImage; ?>" title="<?php echo $notification->user_name; ?>" class="subImage" style="width:50px;height:50px;"></a>
<a href="<?php echo $userUrl;?>" target="_blank">
<span class="notificationText"><?php echo (strlen($notification->user_name) > 20 ) ? substr($notification->user_name,0,20).'... ' : $notification->user_name ; ?></span></a>
<p style="margin:0 !important" class="notButtonRow">
<?php 
if(!in_array($notification->user_id,$subscriberID)) {
?>
<span class="subButton" id="subButton">Subscribe</span>
<?php 
}
?>
<img src="<?php echo $notCloseButton; ?>" class="subDeleteButton" title="Remove notification" style="display:inline-block;cursor:pointer;position:relative;top:-1px;"><input type="hidden" class="subscriperId" value="<?php echo $notification->user_id; ?>"></p>
</li>
<?php 
}
?>
</ul>
</div>
<p class="descriptionButtonRow"><span class="deleteNotification"><?php echo __( 'Remove all', APPTHA_VGALLERY ); ?></span><span class="cancelNotification"><?php echo __( 'Cancel', APPTHA_VGALLERY ); ?></span></p>
</div>
<?php 
}
?>
<div style="clear:both"></div>
</div>
<div class="playerContainer">
<div class="player" id="player">
</div>
</div>
</div>