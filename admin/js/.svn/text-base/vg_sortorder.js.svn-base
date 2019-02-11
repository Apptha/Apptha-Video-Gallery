/**  
 * Video / Playlist sortorder js file.
 *
 * @category   Apptha
 * @package    Contus video Gallery
 * @version    3.0
 * @author     Apptha Team <developers@contus.in>
 * @copyright  Copyright (C) 2015 Apptha. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html 
 */
 // When the document is ready set up our sortable with it's inherant function(s)
  var dragdr = jQuery.noConflict();
  var videoid = new Array();
  dragdr( document ).ready( function() {
      dragdr( "#test-list" ).sortable( { 
          handle: '.handle', 
          update: function() { 
              var order = dragdr( '#test-list' ).sortable( 'serialize' ); 
              orderid = order.split( "listItem[]=" ); 
              for ( i = 1; i < orderid.length; i++ ) { 
                  videoid[i] = orderid[i].replace( '&', "" ); 
                  oid = "ordertd_" + videoid[i]; 
              }
              dragdr.post( sortorderURL, order );
          }
      } );
  } );

//if(screen.width > 480 ) {
  dragdr( function() { 
	  dragdr( ".column" ).sortable( { 
          connectWith: ".column" 
      }); 
	  dragdr( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" ) 
            .find( ".portlet-header" ) 
            .addClass( "ui-widget-header ui-corner-all" ) 
            .prepend( "<span class='ui-icon ui-icon-minusthick'></span>" ) 
            .end() 
            .find( ".portlet-content" );
	  dragdr( ".portlet-header .ui-icon" ).click( function() { 
		  dragdr( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" ); 
		  dragdr( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle(); 
      } ); 
	  dragdr('#videogallery_setting').click(function(){ 
          var trackcode = sortdr('#trackcode').val(); 
          var trackcodepattern = /^ua-\d{4,9}-\d{1,4}$/i; 
          if( ( !trackcodepattern.test(trackcode) )  && trackcode!='' ) { 
        	  dragdr('#trackcodeerror').html('Enter valid Google Analytics Tracking Code'); 
        	  dragdr('#trackcodeerror').addClass('updated below-h2'); 
              return false; 
          }
          return true; 
      } ); 
  } ); 
//}