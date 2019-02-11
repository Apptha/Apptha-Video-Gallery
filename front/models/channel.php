<?php
/**  
 * Channel Model file.
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Check ChannelModel class is exists */
if ( !class_exists ( 'ChannelModel' ) ) {
/**
 * Class is used to manage channel data
 * @author user
 */
class ChannelModel {
/**
 * Function mySubscriberDetailsModel is used to get my subscribed user channel details
 * @param int $userID user id
 * @return array
 */
	public function mySubscriberDetailsModel($userID) {
		global $wpdb;
		$mySubscriberID = json_decode(getSubscriberId($userID),true);
		if(!empty($userID) && !empty($mySubscriberID)) {
			return $wpdb->get_results('SELECT * FROM '.WVG_CHANNEL.' WHERE user_id IN('.implode(',',$mySubscriberID).')');
		}
		else {
			return '';			
		}
		exitAction('');
	}
/**
 * Funciton getNotificationDetails is retrieve all notification details for the currently logged in user
 * @param int $userID user id
 * @return array
 */
	public function getNotificationDetails($userID) {
		global $wpdb;
		$notificationID = $myNotificationDetails = '';
		$myNotificationDetails = getMyNotificationId($userID);
		if(!empty($myNotificationDetails)) {
			$notificationID =  json_decode($myNotificationDetails->sub_id,true);
		}
		if(!empty($notificationID)) {
			return $wpdb->get_results('SELECT * FROM '.WVG_CHANNEL.' WHERE user_id IN('.implode(',',$notificationID).')');
		}
	}
}
}
/**
 * Function to update user name
 * @param string $userName user name
 * @param int $userID user id
 * @return int
 */
function updateUserName($userName,$userID) {
	global $wpdb;
	/** data hold query details */
	$data = array('user_name'=>$userName);
	/** where hold query condition */
	$where = array('user_id'=>$userID);
	/** format hold data format */
	$format = array('%s');
	/** format hold where data format */
	$whereFormat = array('%d');
	return $wpdb->update(WVG_CHANNEL,$data,$where,$format,$whereFormat);
}
/**
 * Function to get subscriber id
 * @param  int     $userID       user id
 * @return int
 */
function getSubscriberId($userID) {
	global $wpdb;
	if(is_user_logged_in()) {
		return $wpdb->get_var($wpdb->prepare('SELECT sub_id FROM '.WVG_CHANNEL_SUBSCRIBER.' WHERE user_id=%d',$userID));
	}
	else {
		echo json_encode(array('errormsg'=>'true','errmsg'=>'404'));
		exitAction('');
	}
}
/**
 * Function getChannel is used to retrieve Channel details for particular user using user id
 * @param int $userID user id
 * @return array
 */
function getChannel($userID) {
	global $wpdb;
	if(!empty($userID)) {
		return $wpdb->get_row($wpdb->prepare('SELECT * FROM '.WVG_CHANNEL.' WHERE user_id=%d',$userID));
	}
}
/**
 * Function getChannelVideoDetails is used to retrieve channel video details
 * @param int $userID user id
 * @return array
 */
function getChannelVideoDetails($userID) {
	global $wpdb;
	return $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'hdflvvideoshare WHERE member_id=%d',$userID));
}
/**
 * Function to check user name whether user name exists or not
 * @param  string $userName  user name
 * @param  int    $userID  user id
 * @return int
 */
function checkUserName($userName,$userID) {
	global $wpdb;
	return $wpdb->get_var($wpdb->prepare('SELECT id FROM '.WVG_CHANNEL.' WHERE user_id=%d AND user_name=%s',$userID,$userName));
}
/**
 * Function to get user name
 * @param  int    $userID  user id
 * @return string
 */
function getUserName($userID) {
	global $wpdb;
	return $wpdb->get_var($wpdb->prepare('SELECT user_name FROM '.WVG_CHANNEL.' WHERE user_id=%d',$userID));
}
/**
 * Function to get channel page link
 * @return string
 */
function channelPageLink() {
	global $wpdb;
	$channel_page = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."posts WHERE post_content=%s AND post_status=%s","[videochannel]","publish"));
	if ( get_option('permalink_structure') ) {
		$link = get_site_url() . '/' .$channel_page[0]->post_name;
	}
	else {
		$link = $channel_page[0]->guid;
	}
	return $link;
}
/**
 * Function bannerImageDetails is used to retrieve banner image details for particular user
 * @param int $userID user id
 * @return array
 */
function bannerImageDetails($userID) {
	global $wpdb;
	return $wpdb->get_var($wpdb->prepare('SELECT user_content FROM '.WVG_CHANNEL.' WHERE user_id=%d',$userID));
}
/**
 * Function updateImageDetails is used to update user image details
 * @param string $jsonDetails image details
 * @param int $userID user id
 * @return array
 */
function updateImageDetails($jsonDetails,$userID) {
	global $wpdb;
	/** data hold query details */
	$data = array('user_content'=>$jsonDetails);
	/** where hold query condition */
	$where = array('user_id'=>$userID);
	/** format hold data format */
	$format = array('%s');
	/** where format hold where data format */
	$whereFormat = array('%d');
	return $wpdb->update(WVG_CHANNEL,$data,$where,$format,$whereFormat);
}
/**
 * Function to upload profile or cover images.
 * @param   int  $userID   user id
 * @return  void
 */
function imageUpload($userID) {
	$imageType = $typeMatch = $extensionMatch = $validType = $isAdmin = $invalidUser =  '';
	$userAgent = $_SERVER['HTTP_USER_AGENT'];
	preg_match('/MSIE/i',$userAgent,$ieBrowser);
	$userDetails = get_user_by('id',$userID);
	checkImageUploadSession();
	$requestUserID = $userID;
	$uploadType  = strip_tags($_REQUEST['uploadType']);
	$imageType = $_FILES['images']['type'];
	preg_match('/^image\/(jpeg|png|gif)$/',$imageType,$typeMatch);
	preg_match('/(png|jpeg|gif)$/',$imageType,$extensionMatch);
	preg_match('/^(profile|cover)$/',$uploadType,$uploadTypeMatch);
	if(empty($uploadTypeMatch)) {
		echo json_encode(array('errormsg'=>'true','errmsg'=>'404'));
		exitAction('');
	}
	if(!empty($typeMatch)) {
		$validType = true;
	}
	else {
		$validType = false;
		echo json_encode(array('errormsg'=>'true','errmsg'=>'Invalid type'));
		exitAction('');
	}
	if($userID) {
		$isAdmin = in_array('administrator',$userDetails->roles);
	}
	else {
		$isAdmin = false;
	}
	if($isAdmin === false) {
		$invalidUser = ($requestUserID != $userID ) ? true : false;
	}
	else {
		$invalidUser = false;
	}
	if($invalidUser === true) {
		echo json_encode(array('errormsg'=>'true','errmsg'=>'404'));
		exitAction('');
	}
	$imageUploadHelperParam = array('userID'=>$userID,'ieBrowser'=>$ieBrowser,'requestUserID'=>$requestUserID,'uploadType'=>$uploadType,'imageType'=>$imageType);
	imageUploadHelper($imageUploadHelperParam);
}
/**
 * Function to check session data to upload profile or cover images
 * @return void
 */
function checkImageUploadSession() {
	if(isset($_SESSION['imageName']) && $_SESSION['imageName'] != null) {
		if(file_exists(APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/".$_SESSION['imageName'])) {
			unlink(APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/".$_SESSION['imageName']);
		}
		unset($_SESSION['imageName']);
	}
	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null) {
		unset($_SESSION['user_id']);
	}
	if(isset($_SESSION['imageExtension']) && $_SESSION['imageExtension'] != null) {
		unset($_SESSION['imageExtension']);
	}
	if(isset($_SESSION['imageUploadType']) && $_SESSION['imageUploadType'] != null) {
		unset($_SESSION['imageUploadType']);
	}
}
/**
 * Function to upload profile or cover images
 * @param array $imageParam
 * @return void
 */
function imageUploadHelper($imageParam) {
	$userID = $imageParam['userID'];
	$ieBrowser = $imageParam['ieBrowser'];
	$requestUserID = $imageParam['requestUserID'];
	$uploadType = $imageParam['uploadType'];
	$imageType = $imageParam['imageType'];
	if($imageType == 'image/jpeg') {
		$extension = 'jpeg';
	}
	elseif($imageType == 'image/png') {
		$extension = 'png';
	}
	elseif($imageType == 'image/gif') {
		$extension = 'gif';
	}
	else {
		$extension = '';
		echo json_encode(array('errormsg'=>'true','errmsg'=>'Invalid type'));
		exitAction('');
	}
	$imageName  = $uploadType.$userID.time().'.'.$extension;
	$targetPath = APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/".$imageName;
	$imageDetails = getimagesize($_FILES['images']['tmp_name']);
	$imageWidth = $imageDetails[0];
	$imageHeight = $imageDetails[1];
	if($imageWidth < 1000 || $imageHeight < 700 ) {
		if(empty($ieBrowser)) {
			echo json_encode(array('errormsg'=>'true','errmsg'=>'Image must be greater than or equal to 1024x700 pixels'));
			exitAction('');
		}
		else {
			echo json_encode(array('errormsg'=>'true','errmsg'=>'Image must be greater than or equal to 1024x700 pixels'));
			exitAction('');
		}
	}
	if(move_uploaded_file($_FILES['images']["tmp_name"],$targetPath)) {
		$_SESSION['imageName'] = $imageName;
		$_SESSION['user_id']   = $requestUserID;
		$_SESSION['imageUploadType'] = $uploadType;
		$_SESSION['imageExtension']  = $extension;
		$result = json_encode(array('imageName'=>$imageName,'imageWidth'=>$imageWidth,'imageHeight'=>$imageHeight,'errormsg'=>'false','uploadType'=>$uploadType));		
	}
	else {
		echo __( 'Not Moved', APPTHA_VGALLERY );
		exitAction('');
	}
	if(!empty($ieBrowser)) {
		croppingCoverImage($userID);
	}
	else {
		echo $result;
		exitAction('');
	}
}
/**
 * Function to crop profile or cover images.
 * @param   int  $userID   user id
 * @return  void
 */
function croppingCoverImage($userID) {
	$userAgent = $_SERVER['HTTP_USER_AGENT'];
	preg_match('/MSIE/i',$userAgent,$ieBrowser);
	$imageName = (isset($_SESSION['imageName']) && $_SESSION['imageName'] !='') ? strip_tags($_SESSION['imageName']) : '';
	$uploadType = (isset($_SESSION['imageUploadType']) && $_SESSION['imageUploadType'] !='') ? strip_tags($_SESSION['imageUploadType']) : '';
	$imgExtension = (isset($_SESSION['imageExtension']) && $_SESSION['imageExtension'] !='') ? strip_tags($_SESSION['imageExtension']) : '';
	$requestUserID = $userID;
	if( empty($imageName) || empty($uploadType) || empty($imgExtension) ) {
		exitAction('');
	}
	$updateImageDetailsParam = array('uploadType'=>$uploadType,'imageName'=>$imageName,'imgExtension'=>$imgExtension,'requestUserID'=>$requestUserID);
	storeImageDetails($updateImageDetailsParam);
}
/**
 * Function to store image details on database
 * @param array $imageDetailsParam image details
 * @return string
 */
function storeImageDetails($imageDetailsParam) {
	$userAgent = $_SERVER['HTTP_USER_AGENT'];
	preg_match('/MSIE/i',$userAgent,$ieBrowser);
	$uploadType = $imageDetailsParam['uploadType'];
	$imageName = $imageDetailsParam['imageName'];
	$imgExtension = $imageDetailsParam['imgExtension'];
	$requestUserID = $imageDetailsParam['requestUserID'];
	if($uploadType == 'cover') {
		cropCoverImage($imageName,$imgExtension);
	}
	if($uploadType == 'profile') {
		cropProfileImage($imageName,$imgExtension);
	}
	$coverImagePath = APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/".$imageName;
	if(file_exists($coverImagePath)) {
		unlink($coverImagePath);
	}
	$imageDetails = json_decode(bannerImageDetails($requestUserID),true);
	if($uploadType == 'profile') {
		$imageDetails['profileImage'] = $imageName;
	}
	if($uploadType == 'cover') {
		$imageDetails['coverImage'] = $imageName;
	}
	$jsonDetails = json_encode($imageDetails);
	$updateResult = updateImageDetails($jsonDetails,$requestUserID,$uploadType);
	if($updateResult) {
		$result = json_encode(array("uploadType"=>$uploadType,"image"=>$imageName));
		if(!empty($ieBrowser)) {
			header('location:'.$_SERVER['HTTP_REFERER']);
		}
		else {
			echo $result;
			exitAction('');
		}
	}
	else {
		echo __( 'Not Updated', APPTHA_VGALLERY );
		exitAction('');
	}
}

/**
 * Function to crop cover images
 * @param string $imageName image name
 * @param string $imgExtension image extension
 * @return void
 */
function cropCoverImage($imageName,$imgExtension) {
	$cropX  = (isset($_REQUEST['cx'])) ? intVal($_REQUEST['cx']) : 0;
	$cropY = (isset($_REQUEST['cy'])) ? intVal($_REQUEST['cy']) : 0;
	$cropWidth  = 630;
	$cropHeight = 250;
	$coverImagePath = APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/".$imageName;
	$coverImageDetails = getimagesize($coverImagePath);
	$orignalImageWidth = $coverImageDetails[0];
	$offsetXdifference = $orignalImageWidth - $cropWidth;
	if($cropX > $offsetXdifference) {
		$cropX = $offsetXdifference;
	}
	$destImagePath = APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/cover/".$imageName;
	if($imgExtension == 'jpeg') {
		$imageSrc = imagecreatefromjpeg($coverImagePath);
		$imageDest = ImageCreateTrueColor($cropWidth, $cropHeight);
		imagecopyresampled($imageDest, $imageSrc, 0, 0, $cropX, $cropY, $cropWidth, $cropHeight,$cropWidth,$cropHeight);
		imagejpeg($imageDest,$destImagePath,100);
	}
	if($imgExtension == 'png') {
		$imageSrcs = imagecreatefrompng($coverImagePath);
		$imageDests = ImageCreateTrueColor($cropWidth, $cropHeight);
		imagecopyresampled($imageDests, $imageSrcs, 0, 0, $cropX, $cropY, $cropWidth, $cropHeight,$cropWidth,$cropHeight);
		imagepng($imageDests,$destImagePath);
	}
	if($imgExtension == 'gif') {
		$imageSrc = imagecreatefromgif($coverImagePath);
		$imageDest = ImageCreateTrueColor($cropWidth, $cropHeight);
		imagecopyresampled($imageDest, $imageSrc, 0, 0, $cropX, $cropY, $cropWidth, $cropHeight,$cropWidth,$cropHeight);
		imagegif($imageDest,$destImagePath,100);
	}
}
/**
 * Function to crop profile images
 * @param string $imageName image name
 * @param string $imgExtension image extension
 * @return void
 */
function cropProfileImage($imageName,$imgExtension) {
	$cropX  = (isset($_REQUEST['cx'])) ? intVal($_REQUEST['cx']) : 0;
	$cropY = (isset($_REQUEST['cy'])) ? intVal($_REQUEST['cy']) : 0;
	$cropWidth  = 160;
	$cropHeight = 160;
	$coverImagePath = APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/".$imageName;
	$destImagePath = APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/profile/".$imageName;
	if($imgExtension == 'jpeg') {
		$imageSrc = imagecreatefromjpeg($coverImagePath);
		$imageDest = ImageCreateTrueColor($cropWidth, $cropHeight);
		imagecopyresampled($imageDest, $imageSrc, 0, 0, $cropX, $cropY, $cropWidth, $cropHeight,$cropWidth,$cropHeight);
		imagejpeg($imageDest,$destImagePath,100);
	}
	if($imgExtension == 'png') {
		$imageSrc = imagecreatefrompng($coverImagePath);
		$imageDest = ImageCreateTrueColor($cropWidth, $cropHeight);
		imagecopyresampled($imageDest, $imageSrc, 0, 0, $cropX, $cropY, $cropWidth, $cropHeight,$cropWidth,$cropHeight);
		imagepng($imageDest,$destImagePath);
	}
	if($imgExtension == 'gif') {
		$imageSrc = imagecreatefromgif($coverImagePath);
		$imageDest = ImageCreateTrueColor($cropWidth, $cropHeight);
		imagecopyresampled($imageDest, $imageSrc, 0, 0, $cropX, $cropY, $cropWidth, $cropHeight,$cropWidth,$cropHeight);
		imagegif($imageDest,$destImagePath,100);
	}
}
/**
 * Function channelDescriptionModel is used to insert channel description and channel name
 * @param int $userID user id
 * @param string $description channel description
 * @param string $userName channel name
 * @return array
 */
function channelDescriptionModel($userID,$description,$userName) {
	global $tablePrefix,$db,$query,$user;
	$decodedDescription = json_decode(bannerImageDetails($userID),true);
	$getDescription = $decodedDescription['description'];
	$decodedDescription['description'] = $description;
	$encodeDescription = json_encode($decodedDescription);
	$getName = getUserName($userID);
	if(empty($userName)) {
		echo json_encode(array('errormsg'=>'true','errmsg'=>'Channel name should not be empty'));
		exitAction('');
	}
	if($getName == $userName && $getDescription == $description) {
		echo json_encode(array('errormsg'=>'false','errmsg'=>''));
		exitAction('');
	}
	if(!empty($description) && $getDescription != $description) {
		updateImageDetails($encodeDescription,$userID);
	}
	if(!empty($userName) && $getName != $userName) {
		$nameChecking = checkUserName($userName,$userID);
		if(empty($nameChecking)) {
			updateUserName($userName,$userID);
		}
		else {
			echo json_encode(array('errormsg'=>'true','errmsg'=>'User Name Already Exist'));
			exitAction('');
		}
	}
	echo json_encode(array('errormsg'=>'false','errmsg'=>'Content Saved'));
	exitAction('');
}
/**
 * Function to update subscriber details
 * @param  int    $userID  user id
 * @param  array  $jsonDetails  notification details
 * @return boolean
 */
function updateSubscriberDetails($jsonDetails,$userID) {
	if(!empty($userID)) {
		global $wpdb;
		/** data hold query details */
		$data = array('sub_id'=>$jsonDetails);
		/** where hold query condition */
		$where = array('user_id'=>$userID);
		/** format hold data format */
		$format = array('%s');
		/** where format hold data format */
		$whereFormat = array('%d');
		return $wpdb->update(WVG_CHANNEL_SUBSCRIBER,$data,$where,$format,$whereFormat);
	}
	else {
		echo json_encode(array('errormsg'=>'true','errmsg'=>'user id null'));
		exitAction('');
	}
}
/**
 * Function to insert subscriber details
 * @param  array  $jsonDetails  notification details
 * @param  int    $userID  user id
 * @return boolean
 */
function insertSubscriber($jsonDetails,$userID) {
	if(!empty($userID)) {
		global $wpdb;
		/** data hold query details */
		$data   = array('user_id'=>$userID,'sub_id'=>$jsonDetails);
		/** format hold data format */
		$format = array('%d','%s');
		/** result hold boolean value */
		$result = $wpdb->insert(WVG_CHANNEL_SUBSCRIBER,$data,$format);
		if($result) {
			return true;
		}
		else {
			return false;
		}
	}
	else {
		echo json_encode(array('errormsg'=>'true','errmsg'=>'insert error'));
		exitAction('');
	}
}
/**
 * Funciton to save subscriber details
 * @param int $subID subscriber id
 * @param int $userID user id
 * @return array
 */
function saveSubscriberId($subID,$userID) {
	global $wpdb;
	$subscriberID = getSubscriberId($userID);
	if(!empty($subscriberID)) {
		$usersID = json_decode($subscriberID,true);
		if(in_array($subID,$usersID)) {
			echo __( 'Subsciber ID Exists', APPTHA_VGALLERY );
			exitAction('');
		}
		else {
			$usersID[] = $subID;
			updateSubscriberDetails(json_encode($usersID),$userID);
		}
	}
	else {
		$usersID[] = $subID;
		insertSubscriber(json_encode($usersID),$userID);
	}
}
/**
 * Function to update notification details
 * @param  int    $userID  user id
 * @param  array  $jsonDetails  notification details
 * @return boolean
 */
function updateNotificationId($userID,$jsonDetails) {
	global $wpdb;
	/** data hold query details */
	$data = array('sub_id'=>$jsonDetails);
	/** where hold query condition */
	$where = array('user_id'=>$userID);
	/** format hold data format */
	$format = array('%s');
	/** format hold where data format */
	$whereFormat = array('%d');
	return $wpdb->update(WVG_CHANNEL_NOTIFICATION,$data,$where,$format,$whereFormat);
}
/**
 * Function to insert notification details
 * @param  int    $userID  user id
 * @param  array  $jsonDetails  notification details
 * @return void
 */
function insertNotificationId($userID,$jsonDetails) {
	global $wpdb;
	/** data hold query details */
	$data   = array('user_id'=>$userID,'sub_id'=>$jsonDetails);
	/** format hold data format */
	$format = array('%d','%s');
	$wpdb->insert(WVG_CHANNEL_NOTIFICATION,$data,$format);
}
/**
 * Funciton to save notification details
 * @param int $subID subscriber id
 * @param int $userID user id
 * @return array
 */
function saveNotification($subscriberID,$userID) {
	$notificationDetail = getMyNotificationId($subscriberID);
	if(isset($notificationDetail->sub_id) && !empty($notificationDetail->sub_id)) {
		$subID = json_decode($notificationDetail->sub_id,true);
	}
	else {
		$subID = '';
	}
	if(!empty($subID)) {
		if(in_array($userID,$subID)) {
			return;
		}
		else {
			$subID[] = $userID;
			updateNotificationId($subscriberID,json_encode($subID));
		}
	}
	else {
		insertNotificationId($subscriberID,json_encode(array($userID)));
	}
}
/**
 * Funciton to to notification mail
 * @param int $subID subscriber id
 * @param int $userID user id
 * @return array
 */
function notificationMail($subscriberID,$userID) {
	global $wpdb;
	$user = get_user_by('id',$userID);
	if($userID) {
		$to = $wpdb->get_var($wpdb->prepare('SELECT user_email FROM '.$wpdb->prefix.'users WHERE user_id=%d',$subscriberID));
		$ukey = $wpdb->get_var($wpdb->prepare('SELECT user_key FROM '.WVG_CHANNEL.' WHERE user_id=%d',$subscriberID));
		$userDetails = getChannel($userID);
		$userName        = $userDetails->user_name;
		$jsonDetails = json_decode($userDetails->user_content,true);
     	$userDescription = $jsonDetails['description'];
	 	$decodedProfileImage = $jsonDetails['profileImage'];
		if(!empty($decodedProfileImage) && file_exists(APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/profile/".$decodedProfileImage)) {
			$userProfileImage = APPTHA_VGALLERY_BASEURL. "images/channel/banner/profile/".$decodedProfileImage;
		}
		else {
			$userProfileImage = APPTHA_VGALLERY_BASEURL. "images/channel/subs.png";
		}
		$channel_page = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."posts WHERE post_content=%s AND post_status=%s","[videochannel]","publish"));
		if ( get_option('permalink_structure') ) {
			$link = get_site_url() . '/' .$channel_page[0]->post_name;
		}
		else {
			$link = $channel_page[0]->guid;
		}
		$link = add_query_arg(array('ukey'=>$ukey),$link);
		$from = $user->user_email;
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "Reply-To: " . $from . "\r\n";
		$headers .= "Return-path: " . $from;
		$subject ='Subscribed user';
		$content = '<div class="mailContainer">
<div class="mailRow" style="background:ghostwhite;padding:5px;height:160px;">
<a href="'.$link.'" target="_blank"><img src="'.$userProfileImage.'" class="eimg" style="float:left;"></a>
<p class="ep" style="float:left;margin-left:5px;font-family:sans-serif;">
<a href="'.$link.'" target="_blank"><span style="font-size:15px;font-weight:bold;">'.$userName.'</span></a><br><br>
'.$userDescription.'
</p>
</div>
</div>';
		mail( $to, $subject, $content,$headers );
	}
	else {
		echo json_encode(array('errormsg'=>'true','errmsg'=>'email error'));
		exitAction('');
	}
}
/**
 * Function subscriberDetailsModel is used to retrieve full subsciber details
 * @param int $userID user id
 * @return array
 */
function subscriberDetailsModel($userID) {
	global $wpdb;
	$subscriberID = getSubscriberId($userID);
	if(!empty($subscriberID)) {
		$usersID = json_decode($subscriberID,true);
		$usersID[] = $userID;
	}
	else {
		$usersID[] = $userID;
	}
	if($userID) {
		return $wpdb->get_results('SELECT * FROM '.WVG_CHANNEL.' WHERE user_id NOT IN( '.implode(',',$usersID).' )');
	}
	else {
		echo json_encode(array('errormsg'=>'true','errmsg'=>'404'));
		exitAction('');
	}
}
/**
 * Function subscriberSearchDetailsModel is used to retrieve searched subscriber details using channel title
 * @param  int     $userID       user id
 * @param  string  $searchTitle  channel name
 * @return array
 */
function subscriberSearchDetailsModel($userID,$searchTitle) {
	global $wpdb;
	$subscriberID = getSubscriberId($userID);
	if(!empty($subscriberID)) {
		$usersID = json_decode($subscriberID,true);
		$usersID[] = $userID;
	}
	else {
		$usersID[] = $userID;
	}
	if($userID) {
		return $wpdb->get_results('SELECT * FROM '.WVG_CHANNEL.' WHERE user_id NOT IN( '.implode(',',$usersID).' ) AND user_name LIKE '."'%".$searchTitle."%'");
	}
	else {
		echo json_encode(array('errormsg'=>'true','errmsg'=>'search subscriber error'));
		exitAction('');
	}
}
/**
 * Function updateNofiticatoinModel is used to update or delete notification details
 * @param  int  $delId  notification id to delete
 * @param  int  $userID  user id
 * @return void
 */
function updateNotificationModel($notificationID,$userID) {
	global $wpdb;
	$getSubscriberID = $wpdb->get_var($wpdb->prepare('SELECT sub_id FROM '.WVG_CHANNEL_NOTIFICATION.' WHERE user_id=%d',$userID));
	$subscriberId = json_decode($getSubscriberID,true);
	if(in_array($notificationID,$subscriberId)) {
		$delkey = array_search($notificationID,$subscriberId);
		unset($subscriberId[$delkey]);
		if(!empty($subscriberId)) {
			$updatedId = json_encode($subscriberId);
			/** data hold query details */
			$data = array('sub_id'=>$updatedId);
			/** where hold query condition */
			$where = array('user_id'=>$userID);
			/** format hold data format */
			$format = array('%s');
			/** where format hold where data format */
			$whereFormat = array('%d');
			$wpdb->update(WVG_CHANNEL_NOTIFICATION,$data,$where,$format,$whereFormat);
		}
		else {
			deleteNotificationModel($userID);
		}
	}
	else {
		echo __( 'Unknown Error Occured', APPTHA_VGALLERY );
		exitAction('');
	}
}
/**
 * Function closeSubscribeModel is used to remove a subcriber details
 * @param   int  $userID   user id
 * @param   int  $mySubscriberID  subscriber id to remove
 * @return  int
 */
function closeSubscribeModel($userID,$mySubscriberID,$currentObj) {
	global $tablePrefix,$db,$query,$user;
	$subscriberID = getSubscriberId($userID);
	if(!empty($subscriberID)) {
		$usersID = json_decode($subscriberID,true);
	}
	else {
		$usersID = array();
	}
	if(in_array($mySubscriberID,$usersID)) {
		$key = array_search($mySubscriberID,$usersID);
		unset($usersID[$key]);
		if(count($usersID) > 0 ) {
			updateSubscriberDetails(json_encode($usersID),$userID);
		}
		else {
			deleteSubscriberDetails($userID);
		}
		return $currentObj->mySubscriberDetailsModel($userID);
	}
	else {
		echo __( 'Close Subsciber', APPTHA_VGALLERY );
		exitAction('');
	}
}
/**
 * Function to get my notification id
 * @param  int    $userID  user id
 * @return array
 */
function getMyNotificationId($userID) {
	global $wpdb;
	if(is_user_logged_in()) {
		return $wpdb->get_row($wpdb->prepare('SELECT * FROM '.WVG_CHANNEL_NOTIFICATION.' WHERE user_id=%d',$userID));
	}
}
/**
 * Function deleteNotificationModel is used to delete all notification details
 * @param int $userID user id
 * @return void
 */
function deleteNotificationModel($userID) {
	global $wpdb;
	/** where hold query condition */
	$where  = array('user_id'=>$userID);
	/** format hold data format */
	$format = array('%d');
	$wpdb->delete( WVG_CHANNEL_NOTIFICATION, $where, $format );
	exitAction('');
}
/**
 * Function to delete all subscriber details of current user
 * @param  int  $userID  user id
 * @return void
 */
function deleteSubscriberDetails($userID) {
	global $wpdb;
	/** where hold query condition */
	$where  = array('user_id'=>$userID);
	/** format hold data format */
	$format = array('%d');
	$wpdb->delete( WVG_CHANNEL_SUBSCRIBER, $where, $format );
}