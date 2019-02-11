<?php
/**  
 * Channel View file.
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Including ChannelModel file to store or retrieve channel details. */
include_once ($frontModelPath . 'channel.php');
/** Check ChannelView class is exists */
if ( !class_exists ( 'ChannelView' ) ) {
/**
 * Class is used to display channel data
 * @author user
 */
class ChannelView extends ChannelModel {
/**
 * Function to display channel page.
 * This function is used to display the required user channel page.
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
 * @param   int  $userID   user id
 * @return  string
 */
	public function displayView($userID) {
		global $frontViewPath,$frontModelPath;
		$this->userID = $userID;
		$decodeContent = $mySubscriberID = $notificationDetails = '';
		$channel = getChannel($userID);
		$this->channelContent = $channel;
		$decodeContent = json_decode($channel->user_content,true);
		$this->userContent = $decodeContent;
		$this->name = $channel->channel_name;
		$mySubscriberID = getSubscriberId($userID);
		$notificationDetails = $this->getNotificationDetails($userID);
		$this->mysubscriberCount = $mySubscriberID;
		$this->notificationDetails = $notificationDetails;
        include_once ($frontViewPath . 'mychannel.php');
	}
/**
 * Function to display subscriber channel videos.
 * @param   int  $userID   user id
 * @return  string
 */
	public function videoTemplate() {
		$videoOutput='';
		$this->thumbPath = APPTHA_VGALLERY_BASEURL . 'images' . DS;
		$this->ratearray = array ( 'nopos1', 'onepos1', 'twopos1', 'threepos1', 'fourpos1', 'fivepos1' );
		foreach($this->channelMyVideosDetails as $videoDetail) {
			$channelVideoName = (strlen($videoDetail->name) > 15) ? substr($videoDetail->name,0,15).'...' : $videoDetail->name;
			$channelVideoRate = $videoDetail->rate;
			$channelVideoRateCount = $videoDetail->ratecount;
			$channelVideoUrl  = get_video_permalink ( $videoDetail->slug );
			$channelVideoHitcount = $videoDetail->hitcount;
			$channelVideoImage = $videoDetail->image;
			$channelFile_type  = $videoDetail->file_type;
			if($channelVideoRateCount != 0 ) {
				$channelVideoStar = round ( $channelVideoRate / $channelVideoRateCount );
			}
			else {
				$channelVideoStar = 0;
			}
			if ($channelVideoImage == '') {
				$thumbImage = $this->thumbPath . 'nothumbimage.jpg';
			}
			if (($channelFile_type == 2 || $channelFile_type == 5) && !empty($channelVideoImage)) {
				$sitePath = get_site_url().'/wp-content/uploads/videogallery/';
				$thumbImage = $sitePath . $channelVideoImage;
			}
			if ($channelFile_type == 1 ) {
				$thumbImage = $channelVideoImage;
			}
			$videoOutput .= '<div class="videoRow">
            <p class="thumbImage"><a href="'.$channelVideoUrl.'"><img src="'. $thumbImage .'" style="width:180px;height:100px;"></a></p>
            <h3 class="videoTitle"><a href="'.$channelVideoUrl.'">'.$channelVideoName.'</a></h3>
            <span class="ratethis1 '.$this->ratearray[$channelVideoStar].' watchContentRate"></span>
            <span class="videoCount">'.$channelVideoHitcount .' views</span>
            </div>';
		}
		if(!empty($this->channelMyVideosDetails)) {
			echo $videoOutput;
			exitAction('');
		}
		else {
			echo "<p class='novideostext'>".__( 'No Videos Found', APPTHA_VGALLERY )."</p><div style='clear:both'></div>";
			exitAction('');
		}
	}
/**
 * Function to get subscriber all details videos.
 * @return  string
 */
	public function subscriberDetailsView() {
		global $wpdb;
		$userID = get_current_user_id();
		$subscriberDetailsModel = $subscriberSearchDetailsModel = '';
		$channelSearchTitle = strip_tags((isset($_POST['videoSearch']) && $_POST['videoSearch'] !='') ? $_POST['videoSearch'] : '');
		if(empty($channelSearchTitle)) {
			$subscriberDetailsModel = subscriberDetailsModel($userID);
			$this->subscribeUserDetails = $subscriberDetailsModel;
		}
		else {
			$subscriberSearchDetailsModel = subscriberSearchDetailsModel($userID,$channelSearchTitle);
			$this->subscribeUserDetails = $subscriberSearchDetailsModel;
		}
		$this->subscriberTemplate();
	}
/**
 * Function to display all subscriber details to currently logged user
 * @return string
 */	
	public function subscriberTemplate() {				
		$result = $profileImage = $subDescription = '';
		$subscribeDetails = $this->subscribeUserDetails;
		$channelLink = channelPageLink();
		foreach($subscribeDetails as $subscribeDetail) {
			$jsonDetails = json_decode($subscribeDetail->user_content,true);
			$subDescription = (strlen($jsonDetails["description"]) > 150 ) ? substr($jsonDetails["description"],0,150)."..." : $jsonDetails["description"];
			$getProfileImage = $jsonDetails['profileImage'];
			$profileImage = ($getProfileImage != '' && file_exists(APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/profile/".$getProfileImage)) ? APPTHA_VGALLERY_BASEURL. "images/channel/banner/profile/".$getProfileImage : APPTHA_VGALLERY_BASEURL. "images/channel/".'subs.png';
			$subscriberLink = add_query_arg(array('ukey'=>$subscribeDetail->user_key),$channelLink);
			$subsName = (strlen($subscribeDetail->user_name) > 20 ) ? substr($subscribeDetail->user_name,0,20).".." : $subscribeDetail->user_name;
			$result .=' <div class="subscripRow">
            <div class="subscripeImage" ><img src="'.$profileImage.'" style="width:160px;height:160px;"></div>
            <div class="subscripeContent">
            <a href="'.$subscriberLink.'" style="text-decoration:none !important" target="_blank"><h3 class="mysubscripeTitle"><span style="cursor:pointer">'.$subsName.'</span></h3></a>
            <p class="subscripeDescription">'.$subDescription.'</p>
            </div>
            <div style="clear:both"></div>
            <div class="subscripeLink">
            <span class="subscripeLinkButton" onclick="saveSubscriper(this);">Subscribe</span><input type="hidden" class="subscriperId" value="'.$subscribeDetail->user_id.'">
            </div>
            </div>';
		}
		if(!empty($subscribeDetails)) {
			echo $result;
			exitAction('');
		}
		else {
			echo "<p class='novideostext'>".__( 'No video channel to subscribe', APPTHA_VGALLERY )."</p><div style='clear:both'></div>";
			exitAction('');
		}
	}
/**
 * Function to get my subscriber details.
 * @param   int  $userID   user id
 * @return  string
 */
	public function mySubscriberDetailsView($userID) {
		$mySubscriberDetailsModel = '';
		$mySubscriberDetailsModel = $this->mySubscriberDetailsModel($userID);
		$this->mySubscribeUserDetails = $mySubscriberDetailsModel;
		$this->mySubscriberTemplate();
	}
/**
 * Function to display my subscriber details.
 * @return  string
 */
	public function mySubscriberTemplate() {		
		$mySubscribeDetails = $this->mySubscribeUserDetails;
		$channelLink = channelPageLink();
		if(!empty($mySubscribeDetails)) {
			foreach($mySubscribeDetails as $mySubscribeDetail) {
				$jsonDetailsForSubscriber = json_decode($mySubscribeDetail->user_content,true);
				$getProfileImage = $jsonDetailsForSubscriber['profileImage'];
				$profileImage = ($getProfileImage != '' && file_exists(APPTHA_VGALLERY_BASEDIR. "/images/channel/banner/profile/".$getProfileImage)) ? APPTHA_VGALLERY_BASEURL. "images/channel/banner/profile/".$getProfileImage : APPTHA_VGALLERY_BASEURL. "images/channel/".'subs.png';
				$subscriberLink = add_query_arg(array('ukey'=>$mySubscribeDetail->user_key),$channelLink);
				$subsName = (strlen($mySubscribeDetail->user_name) > 20 ) ? substr($mySubscribeDetail->user_name,0,20).".." : $mySubscribeDetail->user_name;
				$result .= '<div class="mysubscription" style="position:relative">
                <a href="'.$subscriberLink.'" style="text-decoration:none !important" target="_blank"><img src="'.$profileImage.'" style="width:160px;height:160px;"></a>
                <a href="'.$subscriberLink.'" style="text-decoration:none !important;" target="_blank"><h3 class="subscripeTitle" style="padding-left:5px;">'.$subsName.'</h3></a>
                <div class="closeSubscripe" style="cursor:pointer" onclick="closemysubscripers(this)"><img src="'.APPTHA_VGALLERY_BASEURL.'images/channel/playerclose.png" title="Delete subscriber"></div>
                <input type="hidden" class="msid" value="'.$mySubscribeDetail->user_id.'">
		        </div>';
			}
			echo $result;
		}
		else {
			echo "<p class='novideostext'>".__( 'No subscription', APPTHA_VGALLERY )."</p><div style='clear:both'></div>";
		}
		exitAction('');
	}
/**
 * Function to delete subscriber details.
 * @param   int  $userID   user id
 * @return  void
 */
	public function closeSubscribeView($userID) {
		$closeSubscribeModel = '';
		$subscriberID = intval((isset($_POST['msid']) && $_POST['msid'] !='') ? $_POST['msid'] : '');
		$closeSubscribeModel = closeSubscribeModel($userID,$subscriberID,$this);
		$this->mySubscribeUserDetails = $closeSubscribeModel;
		$this->mySubscriberTemplate();
	}	
}
}
/**
 * Function to get subscriber channel videos.
 * @param   int  $userID   user id
 * @return  string
 */
function channelVideos($userID,$currentObj) {
	$channelVideoDetails = getChannelVideoDetails($userID);
	$currentObj->channelMyVideosDetails = $channelVideoDetails;
	$currentObj->videoTemplate();
}