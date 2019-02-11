<?php
/**
 * AdsXML file for player.
 * 
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Include plugin configuration */ 
require_once (dirname ( __FILE__ ) . '/hdflv-config.php');
/** Get published imaads from db */
$themediafiles  = getVideoAdDetails ( 'imaad', '1' );
/** Get player height, width from settings */
$settings       = getPluginSettings ();
/** Set XML header for IMA ADs */
xmlHeader ();
/** Set xml version and encoding for IMA ADs */
echo '<?xml version="1.0" encoding="utf-8"?>';
/** IMA ADS XML starts */
echo '<ima>';
/**
 * Check if ima ad details are exist
 * If exist, then display ima ad details
 * Otherwise display sample ima ad details    
 */
if (count ( $themediafiles ) > 0) {
  /** Loop through IMA Ad details */
  foreach ( $themediafiles as $rows ) { 
      $imaadType = '';
      /**
       * Get IMA AD's width from AD
       * If value is empty then get player width from plugin settings 
       */        
      $imaadwidth     = $rows->imaadwidth;
      if (empty ( $imaadwidth )) {
        $imaadwidth   = $settings->width - 30;
      }      
      /**
       * Get IMA AD's height
       * If value is empty then get player height from settings
       */
      $imaadheight    = $rows->imaadheight;
      if (empty ( $imaadheight )) {
        $imaadheight  = $settings->height - 60;
      }
      /**
       * Check imaad type 
       * If it is 1 then set type as 'text'
       */
      if ($rows->imaadType == 1) {
        $imaadType    = 'Text';
      }      
      /** Display IMA video ad as XML */ 
      echo ' <adSlotWidth>' . $imaadwidth . '</adSlotWidth>
              <adSlotHeight>' . $imaadheight . '</adSlotHeight>
              <adTagUrl>' . $rows->imaadpath . '</adTagUrl>';
      /** IMA text ad size( 468,60 ) */ 
      echo ' <publisherId>' . $rows->publisherId . '</publisherId>
              <contentId>' . $rows->contentId . '</contentId>';
      /** IMA Text or Overlay */ 
      echo '<adType>' . $imaadType . '</adType>
          <channels>' . $rows->channels . '</channels>';
  }
} else {
        /** Sample video ad */
  echo '<adSlotWidth> 400 </adSlotWidth>
        <adSlotHeight> 250 </adSlotHeight>
        <adTagUrl> http://ad.doubleclick.net/pfadx/N270.126913.6102203221521/B3876671.22;dcadv=2215309;sz=0x0;ord=%5btimestamp%5d;dcmt=text/xml </adTagUrl>';
        /** Sample text ad size(468,60 ) */ 
        echo '<publisherId></publisherId>
            <contentId>1</contentId>';
        /** Text or Overlay */
         echo '<adType>Text</adType> 
             <channels>poker</channels>';
}
/** IMA AD XML ends here */
echo '</ima>';
?>