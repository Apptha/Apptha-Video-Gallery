/** 
 * Function used to get offset top value from body element
 * @return int  offsetTop Value
 */
function getElementOffsetTopValue(element){
var actualTop = element.offsetTop;
var current = element.offsetParent;
while (current !== null){
actualTop += current.offsetTop;
current = current.offsetParent;
}
return actualTop;
}
var parentElement = document.getElementsByClassName('playlistTemplateOuterBox');
var displayHeight = window.innerHeight;
var parentElementTopHeight = getElementOffsetTopValue(parentElement[0]);

window.addEventListener("scroll",function(event) {
	var parentElementClientHeight = parentElement[0].offsetHeight;
	var parentElementHeightTotal = parentElementTopHeight + parentElementClientHeight;
	var parentElementScrollTopValue = parentElementHeightTotal - displayHeight - 300;
    var scrollTopValue = pageYOffset;
	var watchContainerElement = document.getElementsByClassName('watchVideoContainer');
	var playlistTemplateContainer = document.getElementsByClassName('playlistScrollData');	
	if(document.body.dataset !== undefined ) {
		var totalVideoCount = playlistTemplateContainer[0].dataset.totalvideocount;	
	}
	else {
		var totalVideoCount = playlistTemplateContainer[0].getAttribute('data-totalvideocount');
	}	
	if(document.body.dataset !== undefined ) {
		var getAction = playlistTemplateContainer[0].dataset.setaction;	
	}
	else {
		var getAction = playlistTemplateContainer[0].getAttribute('data-setaction');
	}
	if(getAction == 'playlistvideos') {
		var startOffset = document.getElementsByClassName('watchVideo').length;
		var setAction = 'getplaylistvideos';		
		if(document.body.dataset !== undefined ) {
			var plid = playlistTemplateContainer[0].dataset.plid;	
		}
		else {
			var plid = playlistTemplateContainer[0].getAttribute('data-plid');
		}
		ajaxAction = "&action="+setAction+"&startoffset="+startOffset+"&pid="+plid;
	}
	if(getAction == 'playlist') {
		var setAction = 'getplaylistbyoffset';
		var startOffset = document.getElementsByClassName('playlistTemplateBox').length;
		ajaxAction = "&action="+setAction+"&startOffset="+startOffset;
	}
    if(startOffset == 0 ) {
        return false;
    }
	if(startOffset >= totalVideoCount ) {
		return false;
	}
	
    if(scrollTopValue >= parentElementScrollTopValue ) {
		if(parentElement[0].querySelector('.watchloading')) {
		return false;
	}
	else {
		var newNode = document.createElement('span');
		newNode.className = 'watchloading';
		parentElement[0].appendChild(newNode);
	}
		if(!(playlistTemplateContainer[0].querySelector('.watchLoadingBar')) && startOffset <= totalVideoCount ) {
			   var loadingBarThumb = document.createElement('div');
			   loadingBarThumb.className = 'watchLoadingBar';
			   var loadingBackground = document.createAttribute('style');			   
			   if(document.body.dataset !== undefined ) {
				   loadingBackground.value = 'clear:both;background-color:transparent;background-image:url('+playlistTemplateContainer[0].dataset.loaderthumb +'loader.gif)';	
				}
				else {
					loadingBackground.value = 'clear:both;background-color:transparent;background-image:url('+playlistTemplateContainer[0].getAttribute('data-loaderthumb') +'loader.gif)';
				}
			   loadingBarThumb.setAttributeNode(loadingBackground);
			   playlistTemplateContainer[0].appendChild(loadingBarThumb);
		}
 	   jQuery.ajax({
    url: url,
    type: "POST",
    data: ajaxAction,
    success: function (msg) {
        var parentElement = document.getElementsByClassName('playlistScrollData');
		if(getAction == 'playlistvideos') {
  		    var watchElement  = document.getElementsByClassName('watchVideo');			
	    }
	    if(getAction == 'playlist') {
			var watchElement  = document.getElementsByClassName('playlistTemplateBox');
	    }
		var newCloneElement;
   		var videoResults = jQuery.parseJSON( msg );   		
   		if(document.body.dataset !== undefined ) {
   			parentElement[0].dataset.totalvideocount = videoResults[videoResults.length - 1];
   		}
   		else {
   			parentElement[0].setAttribute('data-totalvideocount',videoResults[videoResults.length - 1]);
   		}
   		videoResults = videoResults.splice(0,videoResults.length - 1 )
   		if(parentElement[0].querySelector('.watchLoadingBar')) {
   			parentElement[0].removeChild(parentElement[0].querySelector('.watchLoadingBar'));
   		}
	if(getAction == 'playlistvideos') {	
		for(var i = 0; i < videoResults.length; i++) {
			newCloneElement = watchElement[0].cloneNode(true);
			newCloneElement.querySelector('a').href = videoResults[i].url;
			newCloneElement.querySelector('a img').src = videoResults[i].thumb;
			newCloneElement.querySelector('a img').setAttribute('title',videoResults[i].name);
			newCloneElement.querySelector('.watchContentCount').innerHTML = videoResults[i].hitcount + ' views';
			newCloneElement.querySelector('.watchContentRate').className = 'ratethis1 '+videoResults[i].rate + ' watchContentRate';
			newCloneElement.querySelector('.watchContentTitle a').href = videoResults[i].url;
            newCloneElement.querySelector('.watchContentTitle a').innerHTML = videoResults[i].name;
            newCloneElement.querySelector('.watchContentTitle a').setAttribute('title',videoResults[i].name);
			newCloneElement.querySelector('.watchContentDescription').innerHTML = videoResults[i].description;
			newCloneElement.querySelector('.watchVideoCloseButton').setAttribute("onclick","clearPlaylistVideo(this,"+videoResults[i].vid+")");			
			parentElement[0].appendChild(newCloneElement);
			}
	}
	
	if(getAction == 'playlist' ) {
		for(var i = 0; i < videoResults.length; i++) {
			newCloneElement = watchElement[0].cloneNode(true);			
			if(document.body.dataset !== undefined ) {
				newCloneElement.dataset.pid = videoResults[i].playlistId;
			}
			else {
				newCloneElement.setAttribute('data-pid',videoResults[i].playlistId);
			}
			var linkElement = newCloneElement.querySelectorAll('a');
			for(var linkIndex=0;linkIndex < linkElement.length;linkIndex++) {
				if(location.href.indexOf('?') != -1 ) {
					linkElement[linkIndex].href=location.href+'&pid='+videoResults[i].playlistId;
				}
				else {
					linkElement[linkIndex].href=location.href+'?pid='+videoResults[i].playlistId;
				}
				
			}
			newCloneElement.querySelector('a img').src = videoResults[i].thumb;
			newCloneElement.querySelector('a img').setAttribute('title',videoResults[i].playlistName);
			newCloneElement.querySelector('.playlistVideoCountBox').innerHTML = videoResults[i].count + ' videos';
            newCloneElement.querySelector('.playlistNameBox').innerHTML = videoResults[i].playlistName;
            newCloneElement.querySelector('.playlistNameBox').setAttribute('title',videoResults[i].playlistName);
    		//newCloneElement.querySelector('.watchContentRate').className = 'ratethis1 '+videoResults[i].rate + ' watchContentRate';
			//newCloneElement.querySelector('.watchContentTitle a').href = videoResults[i].url;
        	//newCloneElement.querySelector('.watchContentDescription').innerHTML = videoResults[i].description;
			//newCloneElement.querySelector('.watchVideoCloseButton').setAttribute("onclick","clearPlaylistVideo(this,"+videoResults[i].vid+")");		
			parentElement[0].appendChild(newCloneElement);
			}
		
	}
	
			document.getElementsByClassName('playlistTemplateOuterBox')[0].removeChild(document.getElementsByClassName('watchloading')[0]);
        return false;       
    	}
});
    }
});


function hideWatchVideoElement(parentElement,currentWidth,topParentElement,watchSlide) {
	var parentWidth = parentElement.offsetWidth;
		var watchClearText = 'Playlist cleared';
	currentWidth = Math.abs(currentWidth);
	if(currentWidth != parentWidth) {
		currentWidth = currentWidth + (parentWidth/5);
		if(watchSlide == 'right') {
			parentElement.style.left = currentWidth+'px';
		}
		if(watchSlide == 'left') {
			parentElement.style.left = '-'+currentWidth+'px';
		}
		setTimeout(function() {hideWatchVideoElement(parentElement,currentWidth,topParentElement,watchSlide)},30);
	}
	else {
		topParentElement[0].removeChild(parentElement);
		var watchVideoLength = document.getElementsByClassName('watchVideo').length;
		if(!(watchVideoLength > 0)) {
			
			var clearTextNode = document.createElement('p');
	        var clearText = document.createTextNode(watchClearText);
	        clearTextNode.appendChild(clearText);
	        clearTextNode.className = 'noWatchVideoFound';
	        topParentElement[0].appendChild(clearTextNode);
	        jQuery("#clearButton").remove();
		}
		return false;
	}
}

var watchSlide = 'right';
function clearPlaylistVideo(closeButton,vid) {
	var confirmResult = confirm("Are you sure do you want to delete?");
	if (confirmResult != true) {
	    return  false;
	}	
	if(document.body.dataset !== undefined ) {
		var pid = document.getElementsByClassName('playlistScrollData')[0].dataset.plid;
	}
	else {
		var pid = document.getElementsByClassName('playlistScrollData')[0].getAttribute('data-plid');
	}
		jQuery.ajax({
    url: url,
    type: "POST",
    data: "&action=clearplaylistvideo&vid="+vid+"&pid="+pid,
    success: function (msg) {
        var topParentElement = document.getElementsByClassName('playlistScrollData');
        var parentElement    = closeButton.parentNode;
   		var obj = jQuery.parseJSON( msg );
      	checkResult    = obj.checkResult;
    	if(checkResult == true) {
     		setTimeout(function() {hideWatchVideoElement(parentElement,0,topParentElement,watchSlide)},00);
    		return false;
        }
    	}
});

}

        var playlistScroll = document.getElementsByClassName('playlistScrollData')[0];
var playlistDeleteButton = document.getElementsByClassName('deletePlaylistButton')[0];
var playlistDeleteButtonHandle = function() {
	var confirmResult = confirm("Are you sure do you want to playlist?");
	if (confirmResult != true) {
	    return  false;
	}	
	if(document.body.dataset !== undefined ) {
		var pid = playlistDeleteButton.dataset.plid;
	}
	else {
		var pid = playlistDeleteButton.getAttribute('data-plid');
	}
	jQuery.ajax({
    url: url,
    type: "POST",
    data: "&action=clearplaylist&pid="+pid,
    success: function (msg) {
        var playlistScroll = document.getElementsByClassName('playlistScrollData')[0];
		var topParent      = document.getElementsByClassName('playlistContainerBox')[0];
   		var obj = jQuery.parseJSON( msg );
      	checkResult    = obj.checkResult;
    	if(checkResult == true) {
			topParent.parentNode.removeChild(topParent);
			childCount = playlistScroll.childElementCount;
			for(var cindex = 0; cindex < childCount ; cindex++ ) {
				playlistScroll.removeChild(playlistScroll.firstElementChild);
			}
			
			var newElement = document.createElement('div');
			newElement.className = 'noWatchVideoFound';
            newElement.innerHTML = 'Playlist Cleared';
			playlistScroll.appendChild(newElement);
		    return false;
        }
    	}
});

};
playlistDeleteButton.addEventListener('click',playlistDeleteButtonHandle,false);



var playlistClearButton = document.getElementsByClassName('clearPlaylistButton')[0];
var playlistClearButtonHandle = function() {
	var confirmResult = confirm("Are you sure do you want to all videos?");
	if (confirmResult != true) {
	    return  false;
	}	
	if(document.body.dataset !== undefined ) {
		var pid = playlistClearButton.dataset.plid;
	}
	else {
		var pid = playlistClearButton.getAttribute('data-plid');
	}
	var currentNode = this;
	jQuery.ajax({
    url: url,
    type: "POST",
    data: "&action=clearplaylistvideos&pid="+pid,
    success: function (msg) {
        var playlistScroll = document.getElementsByClassName('playlistScrollData')[0];
   		var obj = jQuery.parseJSON( msg );
      	checkResult    = obj.checkResult;
    	if(checkResult == true) {
			currentNode.parentNode.removeChild(currentNode);
			videoElement = playlistScroll.querySelectorAll('.watchVideo');
			childCount = playlistScroll.childElementCount;
			for(var cindex = 0; cindex < childCount ; cindex++ ) {
				playlistScroll.removeChild(playlistScroll.firstElementChild);
			}
			
			var newElement = document.createElement('div');
			newElement.className = 'noWatchVideoFound';
			newTextNode = document.createTextNode('Playlist Videos Cleared')
            newElement.appendChild(newTextNode);
			playlistScroll.appendChild(newElement);
		    return false;
        }
    	}
});

};
if(playlistClearButton) {
	playlistClearButton.addEventListener('click',playlistClearButtonHandle,false);
}


var playlistNameElement = document.getElementsByClassName('playlistNameElement')[0];
var editNameElement = document.getElementsByClassName('spanForEditName')[0];
var editPlaylistNameElementHandle = function(event) {
	var playlist_name = this.value;
	var keyPressed = event.keyCode; 
	var playlist_parent = this.parentNode;
	var currentElement = this;playlistNameElement
	var parentName_element = document.getElementsByClassName('playlistNameElement')[0];	
	if(document.body.dataset !== undefined ) {
		var ename = parentName_element.dataset.playlistname;
	}
	else {
		var ename = parentName_element.getAttribute('data-playlistname');
	}
	if(keyPressed == 13 ) {
	/*var playlistLoadingElement = document.createElement('p');
	var playlistLoadingImg = document.createElement('img');
	playlistLoadingImg.src = pluginUrl+'images/loader.gif';
	playlistLoadingImg.className = 'playlistLoading';
	playlistLoadingImg.style.cssText = 'width:20px !important;height:20px !important';
	playlistLoadingElement.className='playlistLoadinElement';
	playlistLoadingElement.appendChild(playlistLoadingImg);
	searchParent.appendChild(playlistLoadingElement);*/
		jQuery.ajax({
		    url: url,
		    type: "POST",
		    data: "&action=updateplaylistname&pname="+playlist_name+"&ename="+ename,
		    success: function (msg) {
				//searchParent.removeChild(playlistLoadingElement);
		   		var obj = jQuery.parseJSON( msg );
		   		checkstatus = obj.status;
		      	checkResult    = obj.checkResult;
				if(checkResult == 'exists') {
					alert('Playlist name already exists');
					return false;
				}
		    	if(checkResult == true) {
					if(document.body.dataset !== undefined ) {
						parentName_element.dataset.playlistname = playlist_name;
					}
					else {
						parentName_element.setAttribute('data-playlistname',playlist_name);
					}
					var nameElement = playlist_parent.querySelector('.spanForPlaylist');
					nameElement.innerHTML = playlist_name;
					playlist_parent.removeChild(currentElement);
					playlistNameElement.firstElementChild.style.display = 'block';
                return false;
		    	}
			}
		});
}
};

playlistNameElementHandle = function() {
	var checkEditPlaylistNameElement = document.getElementsByClassName('editPlaylistName');
	if(checkEditPlaylistNameElement.length > 0 ) {
		return false;
	}
	var newInputElement = document.createElement('input');
	newInputElement.className = 'editPlaylistName';	
	if(document.body.dataset !== undefined ) {
		newInputElement.value = playlistNameElement.dataset.playlistname;
	}
	else {
		newInputElement.value = playlistNameElement.getAttribute('data-playlistname');
	}
	playlistNameElement.firstElementChild.style.display = 'none';
	playlistNameElement.appendChild(newInputElement);
	newInputElement.focus();
newInputElement.addEventListener('keyup',editPlaylistNameElementHandle,false);
};
editNameElement.addEventListener('click',playlistNameElementHandle,false);

