<?php
/**  
 * Video Image, Video, Subtitle srt file uploads.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
/** Get wp token for file upload */
$nonce         = $_REQUEST['_wpnonce'];
/** Verify form token */
if ( ! wp_verify_nonce( $nonce, 'upload-video' ) ) {
    exitAction( 'Security block' );
} else {
      /** Variable decalration and initialization */
    global $errorcode, $allowedExtensions, $file, $errorcode, $file_name;
    $file_name = $error = '';
    $errorcode = 12;
    $pro = 1;
    /** Initializing error messages while uploading files */
    $errormsg [0] = '<b>' . __ ('Upload Success', APPTHA_VGALLERY) .':</b>' . __('File Uploaded Successfully', APPTHA_VGALLERY);
    $errormsg [1] = '<b>' . __ ('Upload Cancelled', APPTHA_VGALLERY) .':</b>' . __('Cancelled by user', APPTHA_VGALLERY);
    $errormsg [2] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('Invalid File type specified', APPTHA_VGALLERY);
    $errormsg [3] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('Your File Exceeds Server Limit size', APPTHA_VGALLERY);
    $errormsg [4] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('Unknown Error Occured', APPTHA_VGALLERY);
    $errormsg [5] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('The uploaded file exceeds the upload_max_filesize directive in php.ini', APPTHA_VGALLERY);
    $errormsg [6] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', APPTHA_VGALLERY);
    $errormsg [7] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('The uploaded file was only partially uploaded', APPTHA_VGALLERY);
    $errormsg [8] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('No file was uploaded', APPTHA_VGALLERY);
    $errormsg [9] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('Missing a temporary folder', APPTHA_VGALLERY);
    $errormsg [10] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('Failed to write file to disk', APPTHA_VGALLERY);
    $errormsg [11] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('File upload stopped by extension', APPTHA_VGALLERY);
    $errormsg [12] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('Unknown upload error', APPTHA_VGALLERY);
    $errormsg [13] = '<b>' . __ ('Upload Failed', APPTHA_VGALLERY) .':</b>' . __('Please check post_max_size in php.ini settings', APPTHA_VGALLERY);
    
    /** Check error param is exist */
    if (isset ( $_GET ['error'] )) {
      /** Get error parameters from request URL */
      $error = $_GET ['error'];
    }
    /** Check processing param is exist */
    if (isset ( $_GET ['processing'] )) {
        /** Get processing parameters from request URL */
        $pro = $_GET ['processing'];
    }
    /** Fetch file type while file uploading */
    if (isset ( $_POST ['mode'] )) {
      $exttype = $_POST ['mode'];
      /** If file type is video, 
       * then set allowed file types in an array  */
      if ($exttype == 'video') {
        $allowedExtensions = array ('flv', 'FLV', 'mp4', 'MP4', 'm4v', 'M4V', 'M4A', 'm4a', 'MOV', 'mov', 'mp4v', 'Mp4v', 'F4V', 'f4v', 'mp3', 'MP3' 
        );
      } else if ($exttype == 'image') {
        /** If file type is image, then set allowed file types in an array */
        $allowedExtensions = array ('jpg', 'JPG','jpeg', 'JPEG', 'png', 'PNG' );
      } else if ($exttype == 'srt') {
        /** If file type is srt,  then set allowed file types in an array */
        $allowedExtensions = array ( 'srt', 'SRT' );
      } else {
        /** Set allowed extension as empty */
        $allowedExtensions = array ( );
      }
    }
    
    /**
     * Check the error occur in the upload the files or not
     * 
     * @return boolean
     */
    function iserror() {
      global $error;
      global $errorcode;
      /** Check upload action is cancelled  */
      if ($error == 'cancel') {
        /** Set error message and return true*/
        $errorcode = 1;
        return true;
      } else {
        /** Else return false */
        return false;
      }
    }
    /** Function to set error code to display error message */
    function setErrorCode($error_code) {
      switch ($error_code) {
        case 1 :
        case 2 :
          $errorcode = 5;
          break;
        case 3 :
          $errorcode = 7;
          break;
        case 4 :
          $errorcode = 8;
          break;
        case 6 :
          $errorcode = 9;
          break;
        case 7 :
          $errorcode = 10;
          break;
        case 8 :
          $errorcode = 11;
          break;
        default :
          $errorcode = 12;
          break;
      }
      return $errorcode;
    }
    /** 
     * Fucntion to set error message based on error code
     * 
     * @param unknown $file          
     * @return boolean
     */
    function no_file_upload_error($file) {
      global $errorcode;
      /** Get error code */
      $error_code = $file ['error'];
      /** If file is upload then return true */
      if($error_code == 0) {
        return true;
      } else {
        /** Call function to get error code
         * Else set error message based on the error codes */
        setErrorCode($error_code);
        return false;
      }
    }
    
    /**
     * Fucntion to check the upload file extension is allowed format or Not
     * 
     * @param unknown $file          
     * @return boolean
     */
    function is_allowed_extension($file) {
      global $allowedExtensions;
      global $errorcode;  
      /** Fetch file name and its extension  */
      $filename   = $file ['name'];
      $extension  = explode ( '.', $filename );
      $extension  = end ( $extension );  
      /** Check if the upload file type is in the given extension array */
      $output = in_array ( $extension, $allowedExtensions );  
      /**
       * If both extension is equal, then return true 
       * otherwise set error message 
       */
      if (! $output) {
        $errorcode = 2;
        return false;
      } else {
        return true;
      }
    }
    /**
     * Fucntion to check file upload size
     * 
     * @param unknown $file          
     * @return boolean
     */
    function filesizeexceeds( ) {
      global $errorcode;  
      /** Get post max size from php configuration */
      $POST_MAX_SIZE = ini_get ( 'post_max_size' );
      $post_max_size = substr ( $POST_MAX_SIZE, - 1 );
      $post_max_size_value = ($post_max_size == 'M' ? 1048576 : ($post_max_size == 'K' ? 1024 : ($post_max_size == 'G' ? 1073741824 : 1)));
      /** Check whether the uploaded file size exceeds the server limit
       * If exceeds the set error message */
      if ($_SERVER ['CONTENT_LENGTH'] > $post_max_size_value * ( int ) $POST_MAX_SIZE && $POST_MAX_SIZE) {    
        $errorcode = 3;
        return true;
      } else {
        return false;
      }
    }
    
    /**
     * Fucntion to move the uploaded file 
     * to video gallery folder ( OR ) Amazon s3 bucket.
     * 
     * @param unknown $file          
     * @return string
     */
    function doupload($file) {
      global $file, $errorcode, $file_name, $wpdb; 
      /** Get last video id from database */
      $row = $wpdb->get_var('select MAX( vid ) from ' . $wpdb->prefix . 'hdflvvideoshare');
      /** Get uploaded directory path */
      $destination_path = getUploadDirPath ();
      $row1 = $row + 1;
      /** Get uploaded file extension */
      $extension = explode ( '.', $file ['name'] );
      /** Convert extension into lower case */
      $extension = strtolower (end ( $extension ));
      /** Check the uploaded file is image */
      if ($extension == 'jpeg') {
        $extension = 'jpg';
      }
      /**
       * Check the uploaded file is srt (subtitle files) 
       * or image or video. 
       * Based on that renmae the original file name
       */
      switch ( $extension ) {
        case 'srt':
          $file_name = $row1 . '_subtitle' . rand () .'.'. $extension;
          break;
        case 'jpg':
        case 'png':
        case 'gif':
          $file_name = $row1 . '_thumb' . rand () . '.' . $extension;
          break;
        default:
          $file_name = $row1 . '_video' . rand () . '.' . $extension;
          break;
      }
      /** Get destination path 
       * Move file from temporary path */
      $target_path = $destination_path . '' . $file_name;
      /** If  file is moved then set error code as 0 */
      if (@move_uploaded_file ( $file ['tmp_name'], $target_path )) {
        $errorcode = 0;
      } else {
        /** Else file is moved then set error code as 4 */
        $errorcode = 4;
      }  
      /** Sleep 1ms */
      sleep ( 1 );
    }
    
    if (! iserror ()) {
      /** Set error message, if the upload and post max size is less than the upload file size */
      if (($pro == 1) && (empty ( $_FILES ['myfile'] ))) {
        $errorcode = 13;
      } else {
        /** Get upload file information */
        $file = $_FILES ['myfile'];
        /** Check whether the upload file type is in the given extension and checks its limit */
        if (no_file_upload_error ( $file ) && is_allowed_extension ( $file ) && ! filesizeexceeds ( )) {
          /** Call function to perform upload action */
          doupload ( $file );
        }
      }
    }
    /** Script to display error message while uploading */
    ?>
    <script language='javascript' type='text/javascript'>
        window.top.window.updateQueue( <?php echo balanceTags ( $errorcode );?>,
        '<?php echo balanceTags( $errormsg[$errorcode] ); ?>',
        '<?php echo balanceTags( $file_name ); ?>' );
    </script>
<?php } ?>