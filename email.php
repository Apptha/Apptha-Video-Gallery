<?php
/**
 * Email File for video player
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Get to parameter from request */
$to               = filter_input ( INPUT_POST, 'to', FILTER_VALIDATE_EMAIL );
/** Get from parameter from request */
$from             = filter_input ( INPUT_POST, 'from', FILTER_VALIDATE_EMAIL );
/** Get url parameter from request */
$url              = filter_input ( INPUT_POST, 'url', FILTER_VALIDATE_URL );
/** Get Note parameter from request for subject */
$subject          = filter_input ( INPUT_POST, 'Note', FILTER_SANITIZE_STRING );
/** Get Note parameter from request for content */
$message_content  = filter_input ( INPUT_POST, 'Note', FILTER_SANITIZE_STRING );
/** Get title parameter from request */
$title            = filter_input ( INPUT_POST, 'title', FILTER_SANITIZE_STRING );
/** Get referer URL */
$referrer         = parse_url ( $_SERVER ['HTTP_REFERER'] );
$referrer_host    = $referrer ['scheme'] . '://' . $referrer ['host'];
/** Set http into $pageURL */
$pageURL          = 'http';
/** Check whether the referer URL is https or http */
if (isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on') {
  /** If https then add 's' for $pageUTL */
  $pageURL .= 's';
}
$pageURL .= '://';

/** Check the server port is not https */
if ($_SERVER ['SERVER_PORT'] != '80') {
  /**  Get server name and server port number */
  $pageURL .= $_SERVER ['SERVER_NAME'] . ':' . $_SERVER ['SERVER_PORT'];
} else {
  /** Get server name alone */
  $pageURL .= $_SERVER ['SERVER_NAME'];
}
/** Check page url and referer url is equal */
if ($referrer_host === $pageURL) {  
    /** Set headers (mime, contnet type) for mail */
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    /** Set headers (from) for mail */
    $headers .= "From: " . "<" . $from . ">\r\n";
    /** Set headers (to) for mail */
    $headers .= "Reply-To: " . $from . "\r\n";
    /** Set headers (return path) for mail */
    $headers .= "Return-path: " . $from;
    /** Get user name from from mail */
    $username = explode ( '@', $from );
    $username = ucfirst ( $username ['0'] );
    /** Set subject for email */
    $subject = $username . ' has shared a video with you.';
    /** Get email template file path */
    $emailtemplate_path = plugin_dir_url ( __FILE__ ) . 'front/emailtemplate/Emailtemplate.html';
    /** Get file contents from email template */
    $message = file_get_contents ( $emailtemplate_path );
    /** Replace the email template with the mail information */
    $message = str_replace ( '{subject}', $subject, $message );
    $message = str_replace ( '{message}', $message_content, $message );
    $message = str_replace ( '{videourl}', $url, $message );
    $message = str_replace ( '{username}', $username, $message );    
    /** Call mail function to send mail
     * If mail is not send then display error */
    if (@mail ( $to, $title, $message, $headers )) {
      echo 'success=sent';
    } else {
      echo 'success=error';
    }
} else {
    echo 'success=error';
}
?>