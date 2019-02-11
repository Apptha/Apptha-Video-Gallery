<?php
/**  
 * Video player config xml file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Include configuration file */
require_once (dirname ( __FILE__ ) . '/hdflv-config.php');
/** Variable initialization for config xml */
$downloadPath = $subTitleFontFamily = '';
/** Get WordPress Site(admin) URL */
global $site_url;
$site_url = get_site_url ();
/** Clear previous data */
ob_clean ();
/** Set header for config xml file */
header ( 'cache-control: private' );
header ( 'Pragma: public' );
header ( 'Content-type: application/xml' );
header ( 'content-type:text/xml;charset=utf-8' );
/** Get "uploads / videogallery" directory path */
$logoPath     = getUploadDirURL();
/** Generate player XML path to load playlist */
$playXml    = $site_url . '/wp-admin/admin-ajax.php?action=myextractXML';
/** Generate language XML path to load language text for player icons */
$langXML    = $site_url . '/wp-admin/admin-ajax.php?action=languageXML';
/** Generate ads XML path to load pre / post roll ads */
$adsXml     = $site_url . '/wp-admin/admin-ajax.php?action=myadsXML';
/** Generate midroll XML path to load midroll ads */
$midrollXml = $site_url . '/wp-admin/admin-ajax.php?action=mymidrollXML';
/** Generate imaads XML path to load ima ads */
$imaAdsXML  = $site_url . '/wp-admin/admin-ajax.php?action=myimaadsXML';
/** Generate email file path to perform email action within player */
$emailPath  = $site_url . '/wp-admin/admin-ajax.php?action=email';
/** Generated Skin path */ 
$skinPath = APPTHA_VGALLERY_BASEURL . 'hdflvplayer' . DS . 'skin/skin_hdflv_white.swf';
/** Create object for ContusVideoView class */
$contusOBJ    = new ContusVideoView ();
/** Get settings value from database */
$settingsData = $contusOBJ->_settingsData;
/** Generate Config XML value starts */ 
/** Get player time */
$playerTimer      = $settingsData->timer == 1 ? 'true' : 'false';
/** Get adskip duration */
$adsSkip          = $settingsData->adsSkip == 0 ? 'true' : 'false';
/** Get enable / disable option for tag */
$showTag          = $settingsData->showTag == 1 ? 'true' : 'false';
/** Get enable / disable option for default image */
$imageDefault     = $settingsData->imageDefault == 1 ? 'true' : 'false';
/** Get enable / disable option for progress control */
$progressControl  = $settingsData->progressControl == 1 ? 'true' : 'false';
/** Get enable / disable option for volume control */
$volumecontrol    = $settingsData->volumecontrol == 1 ? 'true' : 'false';
/** Get enable / disable option for sahre icons */
$shareIcon        = $settingsData->shareIcon == 1 ? 'true' : 'false';
/** Get enable / disable option for ima ads */
$imaAds           = $settingsData->imaAds == 0 ? 'true' : 'false';
/** Get enable / disable option for zoom icon */
$playerZoom       = $settingsData->zoom == 1 ? 'true' : 'false';
/** Get enable / disable option for email icon */
$playerEmail      = $settingsData->email ? 'true' : 'false';
/** Get enable / disable option for fullscreen icon */
$playerFullscreen = $settingsData->fullscreen == 1 ? 'true' : 'false';
/** Get enable / disable option for autoplay videos */
$playerAutoplay   = ($settingsData->autoplay == 1) ? 'true' : 'false';
/** Get enable / disable option for playlist autoplay */
$playlistAuto     = ($settingsData->playlistauto == 1) ? 'true' : 'false';
/** Get enable / disable option for HD default */
$hdDefault        = ($settingsData->HD_default == 1) ? 'true' : 'false';
/** Get enable / disable option for download */
$playerDownload   = ($settingsData->download == 1) ? 'true' : 'false';
/** Get enable / disable option for skin auto hide */
$skinAutohide     = ($settingsData->skin_autohide == 1) ? 'true' : 'false';
/** Get enable / disable option for embed visible */
$embedVisible     = ($settingsData->embed_visible == 1) ? 'true' : 'false';
/** Get enable / disable option to show playlist */
$showPlaylist     = ($settingsData->playlist == 1) ? 'true' : 'false';
/** Get enable / disable option for playlist */
$playlist_open    = ($settingsData->playlist_open == 1) ? 'true' : 'false';
/** Get enable / disable option for debug */
$playerDebug      = ($settingsData->debug == 1) ? 'true' : 'false';
/** Get enable / disable option for preroll ads */
$prerollAds       = ($settingsData->preroll == 0) ? 'true' : 'false';
/** Get enable / disable option for postroll ads */
$postrollAds      = ($settingsData->postroll == 0) ? 'true' : 'false';
/** Get enable / disable option for midroll ads */
$midroll_ads      = ($settingsData->midroll_ads == 0) ? 'true' : 'false';
/** Get track code value */
$trackCode        = ($settingsData->trackCode) ? $settingsData->trackCode : '';
/** 
 * Get player colors data 
 * Then unserailzed player colors value */
$player_colors    = unserialize ( $settingsData->player_colors );
/** Get enable / disable option for skin visible */
$skinVisible      = ($player_colors ['skinVisible'] == 1) ? 'true' : 'false';
/** Get skin opacity value */
$skin_opacity     = $player_colors ['skin_opacity'];
/** Get subtitle color value */
$subTitleColor    = ($player_colors ['subTitleColor']) ? $player_colors ['subTitleColor'] : '';
/** Get subtitile background color value  */
$subTitleBgColor  = ($player_colors ['subTitleBgColor']) ? $player_colors ['subTitleBgColor'] : '';
/** Get subtitle font size value */
$subTitleFontSize = ($player_colors ['subTitleFontSize'] == 0) ? '' : $player_colors ['subTitleFontSize'];
/** Get subtitle font family if it is exists */
if (isset ( $player_colors ['subTitleFontFamily'] )) {
  $subTitleFontFamily = $player_colors ['subTitleFontFamily'];
}
/** Skin hide start to play video */ 
if ($skinVisible == 'false') {
  $progressControl  = 'false';
  $volumecontrol    = 'false';
  $shareIcon        = 'false';
  $playerTimer      = 'false';
  $playerDownload   = 'false';
  $playerEmail      = 'false';
  $playerFullscreen = 'false';
  $hdDefault        = 'false';
  $playerZoom       = 'false';
}
/** Add http in URL if not exist in logo path */ 
$logotarget         = $settingsData->logo_target;
if (! preg_match ( '~^(?:f|ht)tps?://~i', $logotarget )) {
    $logotarget       = 'http://' . $logotarget;
}
/** Set xml version , encoding for config XML */
echo '<?xml version="1.0" encoding="utf-8"?>';
/** Configuration XML start */
echo '<config>
<stagecolor>' . $settingsData->stagecolor . '</stagecolor>
<autoplay>' . $playerAutoplay . '</autoplay>
<buffer>' . $settingsData->buffer . '</buffer>
<volume>' . $settingsData->volume . '</volume>
<normalscale>' . $settingsData->normalscale . '</normalscale>
<fullscreenscale>' . $settingsData->fullscreenscale . '</fullscreenscale>
<license>' . $settingsData->license . '</license>
<logopath>' . $logoPath . $settingsData->logopath . '</logopath>
<logoalpha>' . $settingsData->logoalpha . '</logoalpha>
<logoalign>' . $settingsData->logoalign . '</logoalign>
<logo_target>' . $logotarget . '</logo_target>
<sharepanel_up_BgColor>' . $player_colors ['sharepanel_up_BgColor'] . '</sharepanel_up_BgColor>
<sharepanel_down_BgColor>' . $player_colors ['sharepanel_down_BgColor'] . '</sharepanel_down_BgColor>
<sharepaneltextColor>' . $player_colors ['sharepaneltextColor'] . '</sharepaneltextColor>
<sendButtonColor>' . $player_colors ['sendButtonColor'] . '</sendButtonColor>
<sendButtonTextColor>' . $player_colors ['sendButtonTextColor'] . '</sendButtonTextColor>
<textColor>' . $player_colors ['textColor'] . '</textColor>
<skinBgColor>' . $player_colors ['skinBgColor'] . '</skinBgColor>
<seek_barColor>' . $player_colors ['seek_barColor'] . '</seek_barColor>
<buffer_barColor>' . $player_colors ['buffer_barColor'] . '</buffer_barColor>
<skinIconColor>' . $player_colors ['skinIconColor'] . '</skinIconColor>
<pro_BgColor>' . $player_colors ['pro_BgColor'] . '</pro_BgColor>
<playButtonColor>' . $player_colors ['playButtonColor'] . '</playButtonColor>
<playButtonBgColor>' . $player_colors ['playButtonBgColor'] . '</playButtonBgColor>
<playerButtonColor>' . $player_colors ['playerButtonColor'] . '</playerButtonColor>
<playerButtonBgColor>' . $player_colors ['playerButtonBgColor'] . '</playerButtonBgColor>
<relatedVideoBgColor>' . $player_colors ['relatedVideoBgColor'] . '</relatedVideoBgColor>
<scroll_barColor>' . $player_colors ['scroll_barColor'] . '</scroll_barColor>
<scroll_BgColor>' . $player_colors ['scroll_BgColor'] . '</scroll_BgColor>
<skin>' . $skinPath . '</skin>
<skin_autohide>' . $skinAutohide . '</skin_autohide>
<languageXML>' . $langXML . '</languageXML>
<playlistXML>' . $playXml . '</playlistXML>
<playlist_open>' . $playlist_open . '</playlist_open>
<showPlaylist>' . $showPlaylist . '</showPlaylist>
<HD_default>' . $hdDefault . '</HD_default>
<adXML>' . $adsXml . '</adXML>
<preroll_ads>' . $prerollAds . '</preroll_ads>
<postroll_ads>' . $postrollAds . '</postroll_ads>
<midrollXML>' . $midrollXml . '</midrollXML>
<midroll_ads>' . $midroll_ads . '</midroll_ads>
<shareURL>' . $emailPath . '</shareURL>
<embed_visible>' . $embedVisible . '</embed_visible>
<Download>' . $playerDownload . '</Download>
<downloadUrl>' . $downloadPath . '</downloadUrl>
<adsSkip>' . $adsSkip . '</adsSkip>
<adsSkipDuration>' . $settingsData->adsSkipDuration . '</adsSkipDuration>
<relatedVideoView>' . $settingsData->relatedVideoView . '</relatedVideoView>
<imaAds>' . $imaAds . '</imaAds>
<imaAdsXML>' . $imaAdsXML . '</imaAdsXML>
<trackCode>' . $trackCode . '</trackCode>
<showTag>' . $showTag . '</showTag>
<timer>' . $playerTimer . '</timer>
<zoomIcon>' . $playerZoom . '</zoomIcon>
<email>' . $playerEmail . '</email>
<shareIcon>' . $shareIcon . '</shareIcon>
<fullscreen>' . $playerFullscreen . '</fullscreen>
<volumecontrol>' . $volumecontrol . '</volumecontrol>
<playlist_auto>' . $playlistAuto . '</playlist_auto>
<progressControl>' . $progressControl . '</progressControl>
<imageDefault>' . $imageDefault . '</imageDefault>
<skinVisible>' . $skinVisible . '</skinVisible>
<skin_opacity>' . $skin_opacity . '</skin_opacity>
<subTitleColor>' . $subTitleColor . '</subTitleColor>
<subTitleBgColor>' . $subTitleBgColor . '</subTitleBgColor>
<subTitleFontFamily>' . $subTitleFontFamily . '</subTitleFontFamily>
<subTitleFontSize>' . $subTitleFontSize . '</subTitleFontSize>
</config>';
/** Configuration XML ends */ 
?>