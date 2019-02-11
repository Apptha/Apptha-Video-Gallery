/**
 *  VIdeo Gallery plugin script for related video scroll file.
 * 
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    2.8
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
function mycarousel_initCallback(carousel){
        // Disable autoscrolling if the user clicks the prev or next button.
        carousel.buttonNext.bind("click", function() {
        carousel.startAuto(0);
        });

        carousel.buttonPrev.bind("click", function() {
        carousel.startAuto(0);
        });

        // Pause autoscrolling if the user moves with the cursor over the clip.
        carousel.clip.hover(function() {
        carousel.stopAuto();
        }, function() {
        carousel.startAuto();
        });carousel.buttonPrev.bind("click", function() {
        carousel.startAuto(0);
        });
};
jQuery(document).ready(function() {
			jQuery(".jcarousel-skin-tango").jcarousel({
			auto: 0,
			wrap: "last",
			scroll:1,
			initCallback: mycarousel_initCallback
			});
});
jQuery( function (){	
 jQuery('.reportvideotype').tooltip();
});