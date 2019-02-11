<?php
/**
 * AdsXML file for player.
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Used to import plugin configuration */
require_once (dirname ( __FILE__ ) . '/hdflv-config.php');
/** Select published midroll ads from db */
$themediafiles  = getVideoAdDetails ( 'midroll', '' );
/** Set XML header for midroll ads */
xmlHeader ();
/** Set xml version and encoding for Midroll */
echo '<?xml version="1.0" encoding="utf-8"?>';
/** Midroll XML data starts */
echo '<midrollad begin="5" adinterval="6" adrotate="false" random="false">';
    /**
     * Check whether the ad details are exist 
     * If yes, display midroll ad details
     * Else display sample midroll ad details
     */
    if (count ( $themediafiles ) > 0) {
      /** Looping midroll details */
      foreach ( $themediafiles as $rows ) {  
          /** Display midroll details as XML */
          echo ' <midroll targeturl="' . $rows->targeturl . '" clickurl="' . $rows->clickurl . '" impressionurl="' . $rows->impressionurl . '">
              <![CDATA[' . $rows->title . '<br>' . $rows->description . '<br>' . $rows->targeturl . ']]>
               </midroll> ';        
      }
    } else {
      /** Dsiplay sample midroll details as XML */
      echo ' <midroll targeturl="http://grouponclone.contussupport.com/" clickurl="http://grouponclone.contussupport.com/" impressionurl="http://grouponclone.contussupport.com/"> 
              <![CDATA[<b><u><font class="heading"  size="15" color="#FF3300">Best Groupon Clone Script</font></u></b><br><font class="midroll" color="#FFFF00">Start your own group buying site like <b> Groupon or Living Social.</b></font><br><font class="webaddress" color="#FFFFFF">http://grouponclone.contussupport.com/</font>]]>
            </midroll> ';
    }
/** Midroll XML ends here */
echo '</midrollad>';
?>