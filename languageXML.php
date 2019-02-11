<?php
/** 
 * LanguageXML file for player.
 * 
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */

/** Include plugin configuration file for language xml */
require_once (dirname ( __FILE__ ) . '/hdflv-config.php');
/** Set XML header for language XML */
xmlHeader ();
/** Set xml version 
 * and encoding for language XML */
echo '<?xml version="1.0" encoding="utf-8"?>';
/** Language XML content starts */
/** Display language xml content */
echo '<language>';
echo '<Play> <![CDATA[Play]]> </Play>
    <Pause> <![CDATA[Pause]]> </Pause>
    <Replay> <![CDATA[Replay]]> </Replay>
    <Changequality> <![CDATA[Change Quality]]> </Changequality>
    <zoomIn> <![CDATA[Zoom In]]> </zoomIn>
    <zoomOut> <![CDATA[Zoom Out]]> </zoomOut>
    <zoom> <![CDATA[Zoom]]> </zoom>
    <share> <![CDATA[Share]]> </share>
    <FullScreen> <![CDATA[Full Screen]]> </FullScreen>
    <ExitFullScreen> <![CDATA[Exit Full Screen]]> </ExitFullScreen>
    <PlayListHide> <![CDATA[Hide Related Videos]]> </PlayListHide>
    <PlayListView> <![CDATA[Show Related Videos]]> </PlayListView>
    <sharetheword> <![CDATA[Share This Video]]> </sharetheword>
    <sendanemail> <![CDATA[Send an Email]]> </sendanemail>
    <Mail> <![CDATA[Email]]> </Mail>
    <to> <![CDATA[To Email]]> </to>
    <from> <![CDATA[From Email]]> </from>
    <note> <![CDATA[Message]]> </note>
    <send> <![CDATA[Send]]> </send>
    <copy> <![CDATA[Copy]]> </copy>
    <link> <![CDATA[Link]]> </link>
    <social> <![CDATA[Social]]> </social>
    <embed> <![CDATA[Embed]]> </embed>
    <Quality> <![CDATA[Quality]]> </Quality>
    <facebook> <![CDATA[Share on Facebook]]> </facebook>
    <tweet> <![CDATA[Share on Twitter]]> </tweet>
    <tumblr> <![CDATA[Share on Tumblr]]> </tumblr>
    <google+> <![CDATA[Share on Google+]]> </google+>
    <autoplayOff> <![CDATA[Turn Off Playlist Autoplay]]> </autoplayOff>
    <autoplayOn> <![CDATA[Turn On Playlist Autoplay]]> </autoplayOn>
    <adindicator> <![CDATA[Your selection will follow this sponsors message in - seconds]]> </adindicator>
    <skip> <![CDATA[Skip this ad now >>]]> </skip>
    <skipvideo> <![CDATA[You can skip to video in]]> </skipvideo>
    <download> <![CDATA[Download]]> </download>
    <Volume> <![CDATA[Volume]]> </Volume>
    <ads> <![CDATA[mid]]> </ads>
    <nothumbnail> <![CDATA[No Thumbnail Available]]> </nothumbnail>
    <live> <![CDATA[LIVE]]> </live>
    <fill_required_fields> <![CDATA[Please fill in all required fields.]]> </fill_required_fields>
    <wrong_email> <![CDATA[Missing field Or Invalid email]]> </wrong_email>
    <mail_wait> <![CDATA[Wait..]]> </mail_wait>
    <email_sent> <![CDATA[Thank you! Video has been sent.]]> </email_sent>
    <video_not_allow_embed_player> <![CDATA[The requested video does not allow playback in the embedded players.]]> </video_not_allow_embed_player>
    <youtube_ID_Invalid> <![CDATA[The video ID that does not have 11 characters, or if the video ID contains invalid characters.]]> </youtube_ID_Invalid>
    <video_Removed_or_private> <![CDATA[The requested video is not found. This occurs when a video has been removed (for any reason), or it has been marked as private.]]> </video_Removed_or_private>
    <streaming_connection_failed> <![CDATA[Requested streaming provider connection failed]]></streaming_connection_failed>
    <audio_not_found> <![CDATA[The requested audio is not found or access denied]]> </audio_not_found>
    <video_access_denied> <![CDATA[The requested video is not found or access denied]]> </video_access_denied>
    <FileStructureInvalid> <![CDATA[Flash Player detects an invalid file structure and will not try to play this type of file. Supported by Flash Player 9 Update 3 and later.]]> </FileStructureInvalid>
    <NoSupportedTrackFound> <![CDATA[Flash Player does not detect any supported tracks (video, audio or data) and will not try to play the file. Supported by Flash Player 9 Update 3 and later.]]> </NoSupportedTrackFound>';
/** Language XML ends here */
echo '</language>';
/** Call function to perform exit action */
exitAction ( '' );
?>