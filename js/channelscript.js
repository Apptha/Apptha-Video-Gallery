var admin_url = adminurl+'admin-ajax.php';
function uploadImage(formData,uploadType,ui) {
	if(uploadType == 'cover') {
	   var url = admin_url+"?action=channelimageupload&uploadType="+uploadType+"&ui="+ui; 
	}
	else {
		   var bannerwidth = jQuery('.bannerContainer')[0].offsetWidth;
		   var url = admin_url+"?action=channelimageupload&uploadType="+uploadType+"&ui="+ui+"&bannerWidth="+bannerwidth; 
	}
	jQuery.ajax({
		xhr: function()
		  {
			 var ua = window.navigator.userAgent;
				var msie = ua.indexOf("MSIE ");
			    if(msie < 0) {
			    var xhr = new XMLHttpRequest();
			    }
			    else {
			    	var xhr = new window.XMLHttpRequest();
			    }
			    if(msie < 0) {
			    //Upload progress
			    xhr.upload.addEventListener("progress", function(evt){
			      if (evt.lengthComputable) {
			        var percentComplete = (evt.loaded / evt.total) * 100;
			        //Do something with upload progress
					jQuery('.loadingBar').show();
					jQuery('.loadingBar').focus();
			        jQuery('.loadingBar').css('width',percentComplete+'%');
			      }
			    }, false);
			    //Download progress
			    xhr.addEventListener("progress", function(evt){
			      if (evt.lengthComputable) {
			        var percentComplete = evt.loaded / evt.total;
			        //Do something with download progress
			        //console.log(percentComplete);
			      }
			    }, false);
			    }
			    return xhr;
		  },
    url: url,
    type: "POST",
    data: formData,
    //async: false,
    success: function (msg) {
    	jQuery('.loadingBar').show();
    	jQuery('.loadingBar').css('width','0%');
    	var obj = jQuery.parseJSON( msg );
        var imageUrl,imageWidth,imageHeight,errorMsg,uploadType;
        imageUrl = pluginUrl +  "images/channel/banner/" + obj.imageName; 
        imageHeight = obj.imageHeight;
        imageWidth  = obj.imageWidth;
        errorMsg    = obj.errormsg;
        uploadType  = obj.uploadType;
        if(obj.errmsg == '404' && errorMsg == 'true') {
            var redirectUrl;
            redirectUrl = url
            window.location =  redirectUrl;
            return;
        }  
            
        if(errorMsg == 'true') {
        	 jQuery('.fileContent').val('');
        	 alert(obj.errmsg);
        	 return;
        }
        if(uploadType == 'cover' && errorMsg == 'false') {
            jQuery('.cropContainer').css('width',imageWidth);
            jQuery('.cropContainer').css('height',imageHeight);
            jQuery('.cropContainer').css('background-image','url('+imageUrl+')');
            jQuery('.bannerContainer').css('background','ghostwhite');
            jQuery('.dragContainer').hide();
            jQuery('.profileDragContainer').hide();
            jQuery('.cropContainer').show();
            jQuery('.dragButtonContainer').hide();
            jQuery('.saveButtonContainer').show();
            jQuery('.channel_dragreposition').show();
            jQuery('.fileContent').val('');
            }
        if(uploadType == 'profile' && errorMsg == 'false') {
            jQuery('.profileDragContainer').css('width',imageWidth);
            jQuery('.profileDragContainer').css('height',imageHeight);
            jQuery('.profileDragContainer').css('background-image','url('+imageUrl+')');
            jQuery('.bannerContainer').css('background','ghostwhite');
      		jQuery('.dragContainer').hide();
        	jQuery('.cropContainer').hide();
        	jQuery('.saveButtonContainer').hide();
        	jQuery('.profileDragContainer').show();
        	jQuery('.dragButtonContainer').show();
			jQuery('.dragBox').show();
			jQuery('.channel_dragreposition').show();
        	jQuery('.fileContent').val('');
        }
		  jQuery('.bannerContainer').css('height','250px');
		  return false;
    },
    cache: false,
    contentType: false,
    processData: false
});	
}

function cropImage(cx,cy,cw,ch) {
	var url = admin_url+"?action=croppingcoverimage";
	jQuery.ajax({
		xhr: function()
		  {
					 var ua = window.navigator.userAgent;
						var msie = ua.indexOf("MSIE ");
					    if(msie < 0) {
					    var xhr = new XMLHttpRequest();
					    }
					    else {
					    	var xhr = new window.XMLHttpRequest();
					    }
					    if(msie < 0) {
					    //Upload progress
					    xhr.upload.addEventListener("progress", function(evt){
					      if (evt.lengthComputable) {
					        var percentComplete = (evt.loaded / evt.total) * 100;
					        //Do something with upload progress
							jQuery('.loadingBar').show();
							jQuery('.loadingBar').focus();
					        jQuery('.loadingBar').css('width',percentComplete+'%');
					      }
					    }, false);
					    //Download progress
					    xhr.addEventListener("progress", function(evt){
					      if (evt.lengthComputable) {
					        var percentComplete = evt.loaded / evt.total;
					        //Do something with download progress
					        //console.log(percentComplete);
					      }
					    }, false);
					    }
					    return xhr;
		  },
    url: url,
    type: "POST",
    data: '&cx='+cx+'&cy='+cy+'&cw='+cw+'&ch='+ch,
    success: function (msg) {
    	var obj = jQuery.parseJSON( msg );
    	errorMsg    = obj.errormsg;
    	try{
    	if(obj.errmsg == '404' && errorMsg == 'true') {
            var redirectUrl;
            redirectUrl = url
            window.location =  redirectUrl;
            return;
        }
    	}catch(e) {
    	}
        var cimageUrl;
        cimageUrl = pluginUrl +  "images/channel/banner/" + obj.uploadType+'/'+obj.image;
        if(obj.uploadType == 'profile') {
        jQuery('.profileImages').attr('src',cimageUrl);
        }
        if(obj.uploadType == 'cover') {
            jQuery('.coverImages').attr('src',cimageUrl);
            }
        jQuery('.fileContent').val('');    
        jQuery('.dragBox').css('top','0px');
 		jQuery('.dragBox').css('left','0px');
		jQuery('.cropContainer').css('top','0px');
		jQuery('.cropContainer').css('left','0px');
		jQuery('.profileDragContainer').css('top','0px');
		jQuery('.profileDragContainer').css('left','0px');
    	jQuery('.profileUpload').hide();
    	jQuery('.coverUpload').hide();
    	jQuery('.cropContainer').hide();
    	jQuery('.dragContainer').hide();
		jQuery('.dragBox').hide();
    	jQuery('.profileDragContainer').hide();
    	jQuery('.saveButtonContainer').hide();
    	jQuery('.channel_dragreposition').hide();
		jQuery('.loadingBar').hide();
		jQuery('.loadingBar').css('width','0%');
    	jQuery('.coverContainer').show();
    	jQuery('.profileContainer').show();
    	jQuery('.fileContent').val('');
    }
});	
}

function videoPlayer(vid,cid) {
	var url = url;
	jQuery.ajax({
		xhr: function()
		  {
					 var ua = window.navigator.userAgent;
						var msie = ua.indexOf("MSIE ");
					    if(msie < 0) {
					    var xhr = new XMLHttpRequest();
					    }
					    else {
					    	var xhr = new window.XMLHttpRequest();
					    }
					    if(msie < 0) {
					    //Upload progress
					    xhr.upload.addEventListener("progress", function(evt){
					      if (evt.lengthComputable) {
					        var percentComplete = (evt.loaded / evt.total) * 100;
					        //Do something with upload progress
							jQuery('.loadingBar').show();
							jQuery('.loadingBar').focus();
					        jQuery('.loadingBar').css('width',percentComplete+'%');
					      }
					    }, false);
					    //Download progress
					    xhr.addEventListener("progress", function(evt){
					      if (evt.lengthComputable) {
					        var percentComplete = evt.loaded / evt.total;
					        //Do something with download progress
					        //console.log(percentComplete);
					      }
					    }, false);
					    }
					    return xhr;
		  },
    url: url + "index.php?option=com_contushdvideoshare&task=videoPlayer&tmpl=component",
    type: "POST",
    data: '&vid='+vid+'&cid='+cid,
    success: function (msg) {
    	try {
    		var obj = jQuery.parseJSON( msg );
    		errorMsg    = obj.errormsg;
        	if(obj.errmsg == '404' && errorMsg == 'true') {
                var redirectUrl;
                redirectUrl = url;
                window.location =  redirectUrl;
                return;
            }
   
} catch(e) {
       //invalid
}
    	jQuery('.loadingBar').hide();
    	jQuery('.loadingBar').css('width','0%');
    	jQuery('.player').html(msg);
    	//jQuery('.player').css('width','800px');
    	//jQuery('.player').css('height','500px');
    	jQuery('.playerContainer').show();
    }
});	
}

function channelMyVideos(buttonClicked,current,currentElement) {
	var currentElements = currentElement;
	var a = 1;
	var url,searchName,postData,description;
	if(buttonClicked == 'subscriberVideosButton') {
		//url = url + "index.php?option=com_contushdvideoshare&task=channelMyVideos&tmpl=component";
		url = admin_url + "?action=mychannelvideos";
		postData='';
	}
	/* else if(buttonClicked == 'searchButton')*/
	else if(buttonClicked == 'searchButton') {
		searchName = jQuery('.search').val();
		url = url + "index.php?option=com_contushdvideoshare&task=channelMyVideos&tmpl=component";
		postData = '&videoSearch='+searchName;
	}
	else if(buttonClicked == 'saveDescription') {
		description = jQuery('.channelDescription').val();
		userName    = jQuery('.userName').val();
		//url = url + "index.php?option=com_contushdvideoshare&task=channelDescription&tmpl=component";
		url = admin_url + "?action=channeldescription";
		postData = '&channelDescription='+description+'&userName='+userName;
		
	}
	else if(buttonClicked == 'browseChannelButton') {
		url = admin_url +'?action=subscriberdetails';
		postData = '';
	}
	if(buttonClicked == 'searchChannelButton') {
		searchName = jQuery('.search').val(); 
		//url = url + "index.php?option=com_contushdvideoshare&task=subscriperDetails&tmpl=component"; 
		url = admin_url +'?action=subscriberdetails';
		postData = '&videoSearch='+searchName;
	}
	if(buttonClicked == 'subscripeLinkButton') {
		url = admin_url +'?action=savesubscriber';
		postData = '&sid='+current;
	}
	if(buttonClicked == 'subButton') {
		//url = url + "index.php?option=com_contushdvideoshare&task=saveSubscriper&tmpl=component"; 
		url = admin_url +'?action=savesubscriber';
		postData = '&sid='+current;
	}
	if(buttonClicked == 'mySubscriptionButton') {
		url = admin_url +'?action=mysubscriberdetails';
		postData = '&sid='+current;
	}
	if(buttonClicked == 'closeSubscripe') {
		//url = url + "index.php?option=com_contushdvideoshare&task=closeSubscripe&tmpl=component"; 
		url = admin_url +'?action=closesubscribe';
		postData = '&msid='+current;
	}
	
	if(buttonClicked == 'deleteNotification') {
		//url = url + "index.php?option=com_contushdvideoshare&task=deleteNotification&tmpl=component";
		url = admin_url +'?action=deletenotification';
		postData = '';
	}
	if(buttonClicked == 'subDeleteButton') {
		url = url + "index.php?option=com_contushdvideoshare&task=deleteNotification&tmpl=component";
		url = admin_url +'?action=deletenotification';
		postData = '&delId='+current;
	}
	var ua = window.navigator.userAgent;
	var msie = ua.indexOf("MSIE ");
	if(msie > 0 ) {
	jQuery('.loadingBar').css('width','0%');
	jQuery('.loadingBar').show();
	jQuery('.loadingBar').animate({width:"+=100%"},100);
	}
	jQuery.ajax({
		xhr: function()
		  {
		    if(msie < 0) {
		    var xhr = new XMLHttpRequest();
		    }
		    else {
		    	var xhr = new window.XMLHttpRequest();
		    }
		    if(msie < 0) {
		    //Upload progress
		    xhr.upload.addEventListener("progress", function(evt){
		      if (evt.lengthComputable) {
		        var percentComplete = (evt.loaded / evt.total) * 100;
		        //Do something with upload progress
				jQuery('.loadingBar').show();
				jQuery('.loadingBar').focus();
		        jQuery('.loadingBar').css('width',percentComplete+'%');
		      }
		    }, false);
		    //Download progress
		    xhr.addEventListener("progress", function(evt){
		      if (evt.lengthComputable) {
		        var percentComplete = evt.loaded / evt.total;
		        //Do something with download progress
		        //console.log(percentComplete);
		      }
		    }, false);
		    }
		    return xhr;
		  },
    url: url,
    type: "POST",
    data: postData,
    success: function (myvideos) {
    	if(msie > 0 ) {
    		jQuery('.loadingBar').css('width','0%');
    		jQuery('.loadingBar').show();
    		}
    	//var obj = jQuery.parseJSON( myvideos );
    	try {
    		var obj = jQuery.parseJSON( myvideos );
    		errorMsg    = obj.errormsg;
        	if(obj.errmsg == '404' && errorMsg == 'true') {
                var redirectUrl;
                redirectUrl = url;
                window.location =  redirectUrl;
                return;
            }
   
} catch(e) {
       //invalid
}
    	
         if(buttonClicked == 'saveDescription') {
        	 try {
         		errorMsg    = obj.errormsg;
             	if(errorMsg == 'true') {
                     alert(obj.errmsg);
                     jQuery('.userName').focus();
                     return;
                 }
             	else {
             		if(obj.errmsg !='') {
             			alert(obj.errmsg);
             		}
             	}
        
     } catch(e) {
            //invalid
     }
     	   jQuery('.aboutButton').css('left','10px');
     	   jQuery('.authorHeading').text(jQuery('.userName').val());
     	   //jQuery('.aboutButton').css('color','white !important');
     	   jQuery('.aboutButton').css('background','rgb(250, 118, 87) !important');
           jQuery('.loadingBar').hide();
           jQuery('.loadingBar').css('width','0%');    	   
           return;
        }
         if(buttonClicked == 'deleteNotification') {
                 jQuery('.notifi').hide();
                 jQuery('.notificationContainer').hide();
                 jQuery('.notificationContainers').hide();
                 //jQuery('.myVideosButton').click();
                 return;
         }
        if(buttonClicked == 'subscripeLinkButton') {
        	var currentElement = document.getElementsByClassName('searchChannelButton')[0];
        	if(document.body.dataset !== undefined ) {
        		getAction = currentElement.dataset.setaction;
        	}
        	else {
        		getAction = currentElement.setAttribute('data-setaction');
        	}
        	if(getAction == 'searched') {
        		scount = Number(jQuery('.subscriptionCount').text());
            	jQuery('.subscriptionCount').text(scount + 1);
            	jQuery('.subscripeContainer').hide();
            	jQuery('.subscripeContainer').html('');
            	alert('You have subscribed successfully');
        		document.getElementsByClassName('mySubscriptionButton')[0].click();
        		return false;
        	}
        	var scount;
        	if(myvideos == 'error') {
            	return;
        	}
        	else {
            jQuery('.subscripeContainer').html('');
            jQuery('.subscripeContainer').html(myvideos);
            jQuery('.subscripRow').length;
            jQuery('.loadingBar').hide();
            jQuery('.loadingBar').css('width','0%');
        	scount = Number(jQuery('.subscriptionCount').text());
        	jQuery('.subscriptionCount').text(scount + 1);
        	alert('You have subscribed successfully');
            return;
        	} 
        }
        if(buttonClicked == 'subDeleteButton') {
            if(myvideos == 'error') {
                jQuery('.loadingBar').hide();
                jQuery('.loadingBar').css('width','0%');
                return;
            }
            else {
                jQuery('.loadingBar').hide();
                jQuery('.loadingBar').css('width','0%');
            	scount = Number(jQuery('.ncount').text());
            	jQuery('.ncount').text(scount - 1);
				countValue = scount - 1;
				delIdValue = currentElements.parent().parent().attr('id');
				delClassValue = currentElements.parent().parent().attr('class');
				jQuery('.notificationLis#' + delIdValue).hide();
				jQuery('.notificationLi#' + delIdValue).hide();
            	if(scount < 5) {
                    jQuery('.seeMoreLink').hide();
                }
            	if(countValue != 0 ) {
					if(delClassValue == 'notificationLis') {
						jQuery('.notificationContainers').show();
					}
            		
            	}
            	else {
            		jQuery('.notificationContainers').hide();
					jQuery('.notificationContainer').hide();
            		jQuery('.notifi').hide();
            	}
            	
            	
                return;
            }
            
        }
        if(buttonClicked == 'subButton') {
        	var scount;
        	if(myvideos == 'error') {
        		jQuery('.loadingBar').hide();
        		jQuery('.loadingBar').css('width','0%');
        		
            	return;
        	}
        	else {
            	var mysubsDisplayValue,subsDisplayValue;
            	mysubsDisplayValue = jQuery('.mysubscriptionContainer').attr('style');
            	subsDisplayValue   = jQuery('.subscripeContainer').attr('style');
            	if(mysubsDisplayValue.indexOf('block') != -1) {
            		jQuery('.loadingBar').hide();
            		jQuery('.loadingBar').css('width','0%');
            	    scount = Number(jQuery('.subscriptionCount').text());
            	    jQuery('.subscriptionCount').text(scount + 1);
            	    currentElements.hide();	    
            	    jQuery('.mySubscriptionButton').click();
            	    notificationClassValue = currentElements.parent().parent().attr('class');
            	    if( notificationClassValue == 'notificationLis') {
    					jQuery('.notificationContainers').show();
    				}
            	    return;
                }
            	if(subsDisplayValue.indexOf('block') != -1) {
            		jQuery('.subscripeContainer').html('');
            		jQuery('.subscripeContainer').html(myvideos);
            		jQuery('.loadingBar').hide();
            		jQuery('.loadingBar').css('width','0%');
            	    scount = Number(jQuery('.subscriptionCount').text());
            	    jQuery('.subscriptionCount').text(scount + 1);
            	    currentElements.hide();
            	    return;
            	}
        		jQuery('.loadingBar').hide();
        		jQuery('.loadingBar').css('width','0%');
        	    scount = Number(jQuery('.subscriptionCount').text());
        	    jQuery('.subscriptionCount').text(scount + 1);
        	    console.log(currentElements);
                notificationIdValue = currentElements.parent().parent().attr('id');
			    notificationClassValue = currentElements.parent().parent().attr('class');
        	    jQuery('#' + notificationIdValue + ' .subButton').hide();
                if( notificationClassValue == 'notificationLis') {
					jQuery('.notificationContainers').show();
				}				
            	          
            return;
        	} 
        }
        if(buttonClicked == 'closeSubscripe') {
        	var scount;
        	if(myvideos == 'error') {
            	return;
        	}
        	else {
            jQuery('.mysubscriptionRow').html('');
            jQuery('.mysubscriptionRow').html(myvideos);
            jQuery('.loadingBar').hide();
            jQuery('.loadingBar').css('width','0%');
        	scount = Number(jQuery('.subscriptionCount').text());
        	jQuery('.subscriptionCount').text(scount - 1);
            return;
        	} 
        }        
        if(buttonClicked == 'browseChannelButton' || buttonClicked== 'searchChannelButton') {
        	jQuery('.search').val('');
            jQuery('.subscripeContainer').html('');
            jQuery('.subscripeContainer').html(myvideos);
            jQuery('.subscripRow').length;
            jQuery('.loadingBar').hide();
        	jQuery('.mysubscriptionContainer').hide();
            jQuery("#dynamicplacholder").attr("placeholder", "Search Channel");
            jQuery('.loadingBar').css('width','0%');
            return;            
        }
        if(buttonClicked == 'mySubscriptionButton') {
            jQuery('.mysubscriptionRow').html('');
            jQuery('.mysubscriptionRow').html(myvideos);
            jQuery('.mysubscriptionContainer').show();
            jQuery('.loadingBar').hide();
            jQuery('.loadingBar').css('width','0%');
            return;  
        }
        if(buttonClicked != 'searchButton')  {
    	   jQuery('.search').val('');
    	   jQuery('.'+buttonClicked).css('left','10px');
    	   //jQuery('.'+buttonClicked).css('color','white !important');
    	   jQuery('.'+buttonClicked).css('background','rgb(250, 118, 87)');
       }
       else {
    	   jQuery('.channelMenuContainer p').css('left','0px');
    	   //jQuery('.channelMenuContainer p').css('color','rgb(89, 85, 85) !important');
    	   jQuery('.channelMenuContainer p').css('background','rgb(252, 193, 179)');
       }   
       jQuery('.videoContent').html('');
       jQuery('.videoContent').html(myvideos);
       jQuery('.loadingBar').hide();
       jQuery("#dynamicplacholder").attr("placeholder", "Search");
       jQuery('.loadingBar').css('width','0%');
    }
});		
}
