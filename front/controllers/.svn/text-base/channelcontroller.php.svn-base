<?php
/**  
 * Channel Controller file.
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Including ChannelView view file to display channel videos. */
include_once ($frontViewPath . 'channel.php');
/** Check ChannelController class is exists */
if ( !class_exists ( 'ChannelController' ) ) {
/**
 * Class is used to manage view and model
 * @author user
 */
class ChannelController extends ChannelView {
/**
 * Function to call displayView method to display channel page.
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
 * @param   boolean  $subscriber  to check user or subscriber
 * @return  void
 */
	public function displayController($userID,$subscriber) {
		if($subscriber == true) {
			$currentUserID = get_current_user_id();			
			$userObj = get_user_by('id',$currentUserID);
			$checkAdmin = in_array('administrator',$userObj->roles);
			$this->subscriberChannel = true;
			$this->admin = ($checkAdmin) ? true : false;
		}
		else {
			$this->subscriberChannel = false;
			$this->admin = true;
		}
		$this->displayView($userID);
	}
/**
 * Function to get subscriber channel videos.
 * It allow the user to view other user channel videos.
 * @param   int  $userID   subscriber id
 * @return  void
 */
	public function channelMyVideos($userID) {
		channelVideos($userID,$this);
	}
/**
 * Function to store channel details.
 * This function is used to store current user channel name
 * This function is used to store current user channel description
 * This function is used to store subscriber user channel name
 * This function is used to store subscriber user channel description
 * Once updated we show the updated details on channel page.
 * @param   int  $userID   user id
 * @param   string  $description   description
 * @param   string  $userName   channel name
 * @return  void
 */
	public function channelDescriptionController($userID,$description,$userName) {
		channelDescriptionModel($userID,$description,$userName);
	}
/**
 * Function to get all subscriber details.
 * This function is used to show all available user channel link
 * It display subscribe link button to allow current user to subscribe user channel.
 * It display subscribe thumb image
 * Current user can view subscriber channel page by clicking thumb image or subscriber name 
 * @return  void
 */
	public function subscriberDetails() {
		$this->subscriberDetailsView();
	}
/**
 * Function to get my subscriber details.
 * This function is used to display subscribed user of current user.
 * Current user can view his/her channel page by clicking thumb image or subscribed user channel name
 * This function allow current user to delete required subscribed user by clicking close icon on top right corner
 * of thumb image.
 * @param   int  $userID   user id
 * @return  void
 */
	public function mySubscriberDetails($userID) {
		$this->mySubscriberDetailsView($userID);
	}
/**
 * Function to delete a subscriber details.
 * This function is allow current user to delete subscribed user by clicking close icon on the top right corner 
 * of thumb image.
 * This function require subscribe id to delete remove this user from my subscribtion page.
 * @param   int  $userID   user id
 * @return  void
 */
	public function closeSubscribe($userID) {
		$this->closeSubscribeView($userID);
	}
/**
 * Function to save subscriber details.
 * This function is used to save subscriber and list this user on my subscribtion page
 * This function require subscriber id to store
 * This function send notification mail to subscribed user
 * @param   int  $userID   user id
 * @return  void
 */
	public function saveSubscriber($userID) {
		$model = $this;
		$subscriberID = (isset($_POST['sid']) && $_POST['sid'] != '') ? intVal($_POST['sid']) : '';
		saveSubscriberId($subscriberID,$userID);
		saveNotification($subscriberID,$userID);
		notificationMail($subscriberID,$userID);
		$view = $this;
		$view->subscriberDetailsView($userID);
	}
/**
 * Function to delete notification details.
 * This function is used to remove required user notification details.
 * @param   int  $userID   user id
 * @return  void
 */
	public function deleteNotification($userID) {
		$notificationID = (isset($_POST['delId']) && $_POST['delId'] != '') ? intVal($_POST['delId']) : '';
		if(empty($notificationID)) {
			deleteNotificationModel($userID);
		}
		else {
			updateNotificationModel($notificationID,$userID);
		}
	}
/**
 * Function to call imageUpload method to upload images.
 * This function upload current user profile image
 * This function upload current user cover image
 * @param   int  $userID   user id
 * @return  void
 */
	public function imageUploadController($userID) {
		imageUpload($userID);
	}
/**
 * Function to call croppingCoverImage method to crop profile or cover images.
 * This function crop profile images with user required width and height.
 * This function crop cover images with user required width and height.
 * @param   int  $userID   user id
 * @return  void
 */
	public function croppingCoverImageController($userID) {	
		croppingCoverImage($userID);
	}
}
}