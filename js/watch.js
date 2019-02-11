url = adminurl+'admin-ajax.php';
function changeWatchHistoryStatus(status) {
	jQuery.ajax({
    url: url,
    type: "POST",
    data: "&action=changehistorystatus&status="+status,
    success: function (msg) {
        var parentElement = document.getElementsByClassName('watchButtonContainer');
   		var obj = jQuery.parseJSON( msg );
      	checkResult    = obj.checkResult;
    	if(checkResult == true) {
        	var statusButton = document.getElementsByClassName(obj.status+'Button');
        }
        if(statusButton) {
            parentElement[0].removeChild(statusButton[0]);
            var newButton = document.createElement('button');
            var newTextNode = document.createTextNode(obj.buttonName);
            newButton.appendChild(newTextNode);
            var classAttribute = document.createAttribute("class"); 
            classAttribute.value = obj.buttonClassName + ' watchButton'; 
            newButton.setAttributeNode(classAttribute);
            var titleAttribute = document.createAttribute('title');
            titleAttribute.value = obj.buttonName;
            newButton.setAttributeNode(titleAttribute);
            var idAttribute = document.createAttribute("id"); 
            idAttribute.value = obj.buttonClassName; 
            newButton.setAttributeNode(idAttribute); 
            var callback = document.createAttribute("onclick"); 
            callback.value = "changeWatchHistoryStatus('"+obj.buttonCallBack+"')"; 
            newButton.setAttributeNode(callback); 
            parentElement[0].insertBefore(newButton,parentElement[0].firstChild);        
    	}
    	}
});
}

function clearWatchVideoElement(parentElement,currentWidth,topParentElement,startIndex,lastIndex) {
        if(startIndex >= lastIndex) {       	
        	if(document.body.dataset !== undefined ) {
        		var getAction = topParentElement[0].dataset.setaction;
        	}
        	else {
        		var getAction = topParentElement[0].getAttribute('data-setaction');
        	}
        	if(getAction == 'later') {
        		var clearText = 'Watch later videos cleared';
        	}
        	if(getAction == 'history') {
        		var clearText = 'Watch History cleared';
        	}
        	var clearTextNode = document.createElement('p');
        	var parentElement = document.getElementsByClassName('watchVideoContainer');
            var clearText = document.createTextNode(clearText);
            clearTextNode.appendChild(clearText);
            clearTextNode.className = 'noWatchFound'; 
            topParentElement[0].appendChild(clearTextNode);
        	jQuery(".watchVideo").remove();
        	if(getAction == 'later') {
        	jQuery(".watchButtonContainer").remove();
        	}
        	else {
        		jQuery(".clearButton").remove();
        	}
        	       	
            return false;
        }
        var totalWidth = parentElement[0].offsetWidth;
		currentWidth = currentWidth + (totalWidth/5);
		if(currentWidth <= totalWidth) {
			parentElement[0].style.left = '-' + currentWidth + 'px';
			setTimeout(function() {clearWatchVideoElement(parentElement,currentWidth,topParentElement,startIndex,lastIndex)},40);
		}
		else {
			topParentElement[0].removeChild(topParentElement[0].firstChild);
			startIndex = startIndex + 1;
			currentWidth = 0;
			setTimeout(function() {clearWatchVideoElement(parentElement,currentWidth,topParentElement,startIndex,lastIndex)},00);
		}
}
var clearButtonElement = document.getElementsByClassName('clearButton');
clearButtonElement[0].addEventListener('click',function() {
	clearHistory();
},false);
function clearHistory() {
	var confirmResult = confirm("Are you sure do you want to delete all videos?");
	if (confirmResult != true) {
	    return  false;
	}
	var parentElement = document.getElementsByClassName('watchVideoContainer');	
	if(document.body.dataset !== undefined ) {
		var getAction = parentElement[0].dataset.setaction;
	}
	else {
		var getAction = parentElement[0].getAttribute('data-setaction');
	}
	if(getAction == 'history') {
		var setAction = 'clearhistory';
		var clearText = 'Watch history cleared';
	}
	if(getAction == 'later') {
		var setAction = 'clearwatchlater';
		var clearText = 'Watch later videos cleared';
	}
	jQuery.ajax({
    url: url,
    type: "POST",
    data: "&action="+setAction,
    success: function (msg) {
   		var obj = jQuery.parseJSON( msg );
      	checkResult    = obj.checkResult;
    	if(checkResult == true) {
    		var watchVideoElement = document.getElementsByClassName('watchVideo');
    		setTimeout(function() {clearWatchVideoElement(watchVideoElement,0,parentElement,0,watchVideoElement.length)},00);
        }
    	}
});
}
var watchSlide = 'right';
function clearSingleVideo(closeButton,vid) {
	var confirmResult = confirm("Are you sure do you want to delete?");
	if (confirmResult != true) {
	    return  false;
	}
	var topParentElement = document.getElementsByClassName('watchVideoContainer');    
    if(document.body.dataset !== undefined ) {
    	var getAction = topParentElement[0].dataset.setaction;
	}
	else {
		var getAction = topParentElement[0].getAttribute('data-setaction');
	}
	if(getAction == 'history') {
		var setAction = 'clearhistorybyid';
	}
	if(getAction == 'later') {
		var setAction = 'clearwatchlaterbyid';
	}
	jQuery.ajax({
    url: url,
    type: "POST",
    data: "&action="+setAction+"&vid="+vid,
    success: function (msg) {
        var topParentElement = document.getElementsByClassName('watchVideoContainer');
        var parentElement    = closeButton.parentNode;
   		var obj = jQuery.parseJSON( msg );
      	checkResult    = obj.checkResult;
    	if(checkResult == true) {
     		setTimeout(function() {hideWatchVideoElement(parentElement,0,topParentElement,watchSlide,getAction)},00);
    		return false;
        }
    	}
});
}
function hideWatchVideoElement(parentElement,currentWidth,topParentElement,watchSlide,getAction) {
	var parentWidth = parentElement.offsetWidth;
	if(getAction == 'history') {
		var watchClearText = 'Watch History cleared';
	}
	if(getAction == 'later') {
		var watchClearText = 'Watch later videos cleared';
	}
	currentWidth = Math.abs(currentWidth);
	if(currentWidth != parentWidth) {
		currentWidth = currentWidth + (parentWidth/5);
		if(watchSlide == 'right') {
			parentElement.style.left = currentWidth+'px';
		}
		if(watchSlide == 'left') {
			parentElement.style.left = '-'+currentWidth+'px';
		}
		setTimeout(function() {hideWatchVideoElement(parentElement,currentWidth,topParentElement,watchSlide,getAction)},30);
	}
	else {
		topParentElement[0].removeChild(parentElement);
		var watchVideoLength = document.getElementsByClassName('watchVideo').length;
		if(!(watchVideoLength > 0)) {
			
			var clearTextNode = document.createElement('p');
	        var clearText = document.createTextNode(watchClearText);
	        clearTextNode.appendChild(clearText);
	        clearTextNode.className = 'noWatchFound';
	        topParentElement[0].appendChild(clearTextNode);
	        jQuery("#clearButton").remove();
	        if(getAction == 'later') {
	        	jQuery(".watchButtonContainer").remove();
	    	}
		}
		return false;
	}
}
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
var parentElement = document.getElementsByClassName('watchOuterBox');
var displayHeight = window.innerHeight;
var parentElementTopHeight = getElementOffsetTopValue(parentElement[0]);

window.addEventListener("scroll",function(event){
	var parentElementClientHeight = parentElement[0].offsetHeight;
	var parentElementHeightTotal = parentElementTopHeight + parentElementClientHeight;
	var parentElementScrollTopValue = parentElementHeightTotal - displayHeight - 300;
    var scrollTopValue = pageYOffset;
	var watchContainerElement = document.getElementsByClassName('watchVideoContainer');
	if(document.body.dataset !== undefined ) {
		var totalVideoCount = watchContainerElement[0].dataset.totalvideocount;
	}
	else {
		var totalVideoCount = watchContainerElement[0].getAttribute('data-totalvideocount');
	}
	var startOffset = document.getElementsByClassName('watchVideo').length;	
	if(document.body.dataset !== undefined ) {
		var getAction = watchContainerElement[0].dataset.setaction;
	}
	else {
		var getAction = watchContainerElement[0].getAttribute('data-setaction');
	}
	if(getAction == 'history') {
		var setAction = 'getHistoryVideo';
	}
	if(getAction == 'later') {
		var setAction = 'getwatchlatervideo';
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
		if(!(watchContainerElement[0].querySelector('.watchLoadingBar')) && startOffset <= totalVideoCount ) {
			   var loadingBarThumb = document.createElement('div');
			   loadingBarThumb.className = 'watchLoadingBar';
			   var loadingBackground = document.createAttribute('style');			   
			   if(document.body.dataset !== undefined ) {
				   loadingBackground.value = 'background-image:url('+watchContainerElement[0].dataset.loaderthumb +'loader.gif)';
				}
				else {
					loadingBackground.value = 'background-image:url('+watchContainerElement[0].getAttribute('data-loaderthumb')+'loader.gif)';
				}
			   loadingBarThumb.setAttributeNode(loadingBackground);
			   watchContainerElement[0].appendChild(loadingBarThumb);
		}
 	   jQuery.ajax({
    url: url,
    type: "POST",
    data: "&action="+setAction+"&startoffset="+startOffset,
    success: function (msg) {
        var parentElement = document.getElementsByClassName('watchVideoContainer');
		var watchElement  = document.getElementsByClassName('watchVideo');
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
		for(var i = 0; i < videoResults.length; i++) {
			newCloneElement = watchElement[0].cloneNode(true);
			if(newCloneElement.querySelector('.videoWatchedBox')) {
				watchedBoxElement = newCloneElement.querySelector('.videoWatchedBox');
				newCloneElement.appendChild(watchedBoxElement);
				newCloneElement.removeChild(watchedBoxElement);
			}
			if(videoResults[i].status == -2 ) {
				var videoWatchedBoxElement = document.createElement('span');
				videoWatchedBoxElement.className = 'videoWatchedBox';
				videoWatchedBoxTextNode = document.createTextNode('Watched');
				videoWatchedBoxElement.appendChild(videoWatchedBoxTextNode);
				newCloneElement.querySelector('.watchThumb a').appendChild(videoWatchedBoxElement);
			}
			newCloneElement.querySelector('a').href = videoResults[i].url;
			if((typeof videoResults[i].status !== 'undefined') && videoResults[i].status !='') {
				newCloneElement.querySelector('a').removeAttribute('onclick');
				if(videoResults[i].status == 1 ) {
					newCloneElement.querySelector('a').setAttribute('onclick','changeWatchLaterVideoStatus('+videoResults[i].vid+',this)');
					newCloneElement.querySelector('.watchContentTitle a').setAttribute('onclick','changeWatchLaterVideoStatus('+videoResults[i].vid+',this)');
				}
			}
			newCloneElement.querySelector('a img').src = videoResults[i].thumb;
			newCloneElement.querySelector('a img').setAttribute('title',videoResults[i].name);
			newCloneElement.querySelector('.watchContentCount').innerHTML = videoResults[i].hitcount + ' views';
			newCloneElement.querySelector('.watchContentRate').className = 'ratethis1 '+videoResults[i].rate + ' watchContentRate';
			newCloneElement.querySelector('.watchContentTitle a').href = videoResults[i].url;
            newCloneElement.querySelector('.watchContentTitle a').innerHTML = videoResults[i].name;
            newCloneElement.querySelector('.watchContentTitle a').setAttribute('title',videoResults[i].name);
			newCloneElement.querySelector('.watchContentDescription').innerHTML = videoResults[i].description;
			newCloneElement.querySelector('.watchVideoCloseButton').setAttribute("onclick","clearSingleVideo(this,"+videoResults[i].vid+")");
			parentElement[0].appendChild(newCloneElement);
			}
			document.getElementsByClassName('watchOuterBox')[0].removeChild(document.getElementsByClassName('watchloading')[0]);
        return false;       
    	}
});
    }
});