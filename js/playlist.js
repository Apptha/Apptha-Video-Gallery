url = adminurl+'admin-ajax.php';
var playlistButton = document.getElementsByClassName("playlistIcon");
if(playlistButton.length != 0 ) {

var tickImage = pluginUrl+'images/tick.png';
var playlistElement = document.createElement('div');
playlistElement.className = 'playlistOuterBox';
var playlistInnerBox = document.createElement('div');
playlistInnerBox.className = 'playlistInnerBox';
var playlistSearchBox = document.createElement('div');
playlistSearchBox.className = 'playlistSearchBox';
var playlistCreateSpan = document.createElement('span');
playlistCreateSpan.className = 'playlistSearchImage';
if(document.body.dataset !== undefined ) {
	playlistCreateSpan.dataset.showfield = 'create';
}
else {
	playlistCreateSpan.setAttribute('data-showfield','create');
}
var playlistCreateImg = document.createElement('img');
playlistCreateImg.src = pluginUrl+'images/playlist_create.png';
playlistCreateImg.title = 'Create new playlist';
playlistCreateImg.className = 'createImageIcon';
var playlistSearchSpan = document.createElement('span');
playlistSearchSpan.className = 'playlistSearchImage';
if(document.body.dataset !== undefined ) {
	playlistSearchSpan.dataset.showfield = 'search';
}
else {
	playlistSearchSpan.setAttribute('data-showfield','search');
}
var playlistSearchImg = document.createElement('img');
playlistSearchImg.src = pluginUrl+'images/playlist_search.png';
playlistSearchImg.title = 'Search playlist';
playlistSearchImg.className = 'searchImageIcon';
var playlistSearchField = document.createElement('input');
playlistSearchField.type="text";
playlistSearchField.className = 'playlistTextField';
if(document.body.dataset !== undefined ) {
	playlistSearchField.dataset.action = '';
}
else {
	playlistSearchField.setAttribute('data-action','');
}
var playlistContainer = document.createElement('div');
playlistContainer.className = 'playlistContainer';

playlistCreateSpan.appendChild(playlistCreateImg);
playlistSearchSpan.appendChild(playlistSearchImg);
playlistSearchBox.appendChild(playlistCreateSpan);
playlistSearchBox.appendChild(playlistSearchSpan);
playlistSearchBox.appendChild(playlistSearchField);
playlistInnerBox.appendChild(playlistSearchBox);
playlistInnerBox.appendChild(playlistContainer);
playlistElement.appendChild(playlistInnerBox);
var vid;
var clearAlertMsg;
var playlistActionButton = document.getElementsByClassName("playlistSearchImage");
var playlistSearchField =  document.getElementsByClassName("playlistTextField");

function removeAlertMsg(alertMsgElement) {
	if(alertMsgElement.querySelector('.playlistAlertMsg') != null ) {
		alertMsgElement.removeChild(alertMsgElement.querySelector('.playlistAlertMsg'));
		clearInterval(clearAlertMsg);
	}
}
function clearPlaylistContainer(element) {
	while(element.firstElementChild !== null) {
		element.removeChild(element.firstElementChild);
	}
}

var checkBoxHandle = function() {
	if(document.body.dataset !== undefined ) {
		var aid = this.dataset.aid;
	}
	else {
		var aid = this.getAttribute('data-aid');
	}
	if(document.body.dataset !== undefined ) {
		var pid = this.dataset.pid;
	}
	else {
		var pid = this.getAttribute('data-pid');
	}
	var playlistSearchBoxElement = document.getElementsByClassName('playlistSearchBox')[0];
	var playlistLoadingElement = document.createElement('p');
	var playlistLoadingImg = document.createElement('img');
	playlistLoadingImg.src = pluginUrl+'images/loader.gif';
	playlistLoadingImg.className = 'playlistLoading';
	playlistLoadingImg.style.cssText = 'width:20px !important;height:20px !important';
	playlistLoadingElement.className='playlistLoadinElement';
	playlistLoadingElement.appendChild(playlistLoadingImg);
	playlistSearchBoxElement.appendChild(playlistLoadingElement);
	//var clearAlertMsg;
	if( aid == 1 ) {
		if(document.body.dataset !== undefined ) {
			this.dataset.aid = -2;
		}
		else {
			this.setAttribute('data-aid',-2);
		}
		this.style.cssText = 'background-image:url('+tickImage+')';
		jQuery.ajax({
		    url: url,
		    type: "POST",
		    data: "&action=insertplaylistvideo&vid="+vid+"&pid="+pid,
		    success: function (msg) {
				playlistSearchBoxElement.removeChild(playlistLoadingElement);
		   		var obj = jQuery.parseJSON( msg );
		      	checkResult    = obj.checkResult;
		    	if(checkResult == true) {
		    		if(playlistSearchBoxElement.querySelector('.playlistAlertMsg') != null ) {
		    			playlistSearchBoxElement.removeChild(playlistSearchBoxElement.querySelector('.playlistAlertMsg'));
		    		}
		    		var playlistAlertElement = document.createElement('p');
		    		playlistAlertElement.className = 'playlistAlertMsg';
		    		var playlistAlertElementText = document.createTextNode('Added to playlist');
		    		playlistAlertElement.appendChild(playlistAlertElementText);
		    		playlistSearchBoxElement.appendChild(playlistAlertElement);
		    		clearInterval(clearAlertMsg);
		    		clearAlertMsg = setInterval(function(){removeAlertMsg(playlistSearchBoxElement)},1000);
		    		return false;
		        }
		    	if(checkResult == false ) {
		    		return false;
		    	}
		    	}
		});
	}
	if( aid == -2 ) {
		if(document.body.dataset !== undefined ) {
			this.dataset.aid = 1;
		}
		else {
			this.setAttribute('data-aid',1);
		}
		this.style.cssText = '';
		jQuery.ajax({
		    url: url,
		    type: "POST",
		    data: "&action=removeplaylist&vid="+vid+"&pid="+pid,
		    success: function (msg) {
				playlistSearchBoxElement.removeChild(playlistLoadingElement);
		   		var obj = jQuery.parseJSON( msg );
		      	checkResult    = obj.checkResult;
		    	if(checkResult == true) {
		    		if(playlistSearchBoxElement.querySelector('.playlistAlertMsg') != null ) {
		    			playlistSearchBoxElement.removeChild(playlistSearchBoxElement.querySelector('.playlistAlertMsg'));
		    		}
		    		var playlistAlertElement = document.createElement('p');
		    		playlistAlertElement.className = 'playlistAlertMsg';
		    		var playlistAlertElementText = document.createTextNode('Removed from playlist');
		    		playlistAlertElement.appendChild(playlistAlertElementText);
		    		playlistSearchBoxElement.appendChild(playlistAlertElement);
		    		clearInterval(clearAlertMsg);
		    		clearAlertMsg = setInterval(function(){removeAlertMsg(playlistSearchBoxElement)},1000);
		    		return false;
		        }
		    	if(checkResult == false ) {
		    		return false;
		    	}
		    	}
		});
	}
}
function searchFieldValue(searchValue,parentElement) {
	var totalChildren = parentElement.childElementCount;
	for(var childIndex = 0 ; childIndex < totalChildren ; childIndex++) {
		var currentElement = parentElement.children[childIndex].querySelector('.playlistNameElement');
		if(document.body.dataset !== undefined ) {
			currentElementValue = parentElement.children[childIndex].querySelector('.playlistCheckbox').dataset.pname;
		}
		else {
			currentElementValue = parentElement.children[childIndex].querySelector('.playlistCheckbox').getAttribute('data-pname');
		}
		currentElementValue = currentElementValue.toLowerCase();
		currentElementValue = currentElementValue.charAt(0).toUpperCase() + currentElementValue.slice(1);
		searchValue = searchValue.toLowerCase();
		searchValue = searchValue.charAt(0).toUpperCase() + searchValue.slice(1);
		currentElementValue = (currentElementValue.length > 16 ) ? currentElementValue.slice(0,16) + '...' : currentElementValue;
		if(currentElementValue.indexOf(searchValue) == 0 && searchValue.length > 0 ) {
			currentElement.innerHTML= currentElementValue.replace(searchValue,'<span style="color:blue;font-weight:bold">'+searchValue+'</span>');
			parentElement.insertBefore(parentElement.children[childIndex],parentElement.firstElementChild);
		}
		else {
			currentElement.innerHTML= currentElementValue;
		}
		/*if(searchValue == null) {
			currentElement.innerHTML= currentElementValue;
		}*/
		
	}
} 
var playlistContainerBox;
var keyPressHandle = function(event) {
	var searchValue = this.value;
	var keyPressed = event.keyCode; 
	if(document.body.dataset !== undefined ) {
		var ajaxAction = this.dataset.action;
	}
	else {
		var ajaxAction = this.getAttribute('data-action');
	}
	var pname = this.value;
	var searchParent = this.parentNode;
	var checkstatus;
	if(keyPressed == 13 && ajaxAction == 'create' ) {
	var playlistLoadingElement = document.createElement('p');
	var playlistLoadingImg = document.createElement('img');
	playlistLoadingImg.src = pluginUrl+'images/loader.gif';
	playlistLoadingImg.className = 'playlistLoading';
	playlistLoadingImg.style.cssText = 'width:20px !important;height:20px !important';
	playlistLoadingElement.className='playlistLoadinElement';
	playlistLoadingElement.appendChild(playlistLoadingImg);
	searchParent.appendChild(playlistLoadingElement);
		jQuery.ajax({
		    url: url,
		    type: "POST",
		    data: "&action=storeplaylist&vid="+vid+"&pname="+pname,
		    success: function (msg) {
				searchParent.removeChild(playlistLoadingElement);
		   		var obj = jQuery.parseJSON( msg );
		   		checkstatus = obj.status;
		      	checkResult    = obj.checkResult;
		    	if(checkResult == true) {
		    		var playlistBoxElement = document.createElement('div');
	    			playlistBoxElement.className = 'playlistBox';
	    			var checkBox = document.createElement('span');
	    			var PlaylistNameElement = document.createElement('span');
	    			PlaylistNameElement.className = 'playlistNameElement';
	    			checkBox.className = 'playlistCheckbox';	    			
	    			if(document.body.dataset !== undefined ) {
	    				checkBox.dataset.pname = pname;
	    			}
	    			else {
	    				checkBox.setAttribute('data-pname',pname);
	    			}
	    			var labelTextNode = document.createTextNode((pname.length > 16 ) ? pname.slice(0,16) + '...' : pname);
	    			PlaylistNameElement.appendChild(labelTextNode);
	    			checkBox.style.cssText = 'background-image:url('+tickImage+')';   				
    				if(document.body.dataset !== undefined ) {
    					checkBox.dataset.aid = -2;
	    			}
	    			else {
	    				checkBox.setAttribute('data-aid',-2);
	    			}
	    			playlistBoxElement.appendChild(checkBox);
	    			playlistBoxElement.appendChild(PlaylistNameElement);
		    		if(playlistContainerBox.firstElementChild.className == 'playlistBox') {
		    			playlistContainerBox.insertBefore(playlistBoxElement,playlistContainerBox.firstElementChild);
		    		}
		    		else {
		    			clearPlaylistContainer(playlistContainerBox);
		    			playlistContainerBox.appendChild(playlistBoxElement);
		    		}
		    		if(playlistContainerBox.childElementCount > 5) {
		    			var playlistContainerElementHeight = playlistContainerBox.firstElementChild.offsetHeight * 5;
		    			playlistContainerBox.style.cssText = 'height:'+playlistContainerElementHeight+'px;overflow:auto';
		    		}
		    		else {
		    			playlistContainerBox.style.cssText = 'height:auto';
		    		}
		    		checkBox.addEventListener('click',checkBoxHandle,false);
		    		return false;
		        }
		    	if(checkResult == false && checkstatus == 'limit' ) {
		    		var playlistSearchElement = document.getElementsByClassName('playlistSearchBox')[0];
		    		if(playlistSearchElement.querySelector('.playlistAlertMsg') != null) {
		    			playlistSearchElement.removeChild(playlistSearchElement.querySelector('.playlistAlertMsg'));
		    		}
		    		var playlistAlertElement = document.createElement('p');
		    		playlistAlertElement.className = 'playlistAlertMsg';
		    		var playlistAlertElementText = document.createTextNode('Exceeded playlist count');
		    		playlistAlertElement.appendChild(playlistAlertElementText);
		    		playlistSearchElement.appendChild(playlistAlertElement);
		    		clearInterval(clearAlertMsg);
		    		clearAlertMsg = setInterval(function(){removeAlertMsg(playlistSearchElement)},1000);
		    		return false;
		    	}
		    	if(checkResult == false && checkstatus == 'exist' ) {
		    		var playlistSearchElement = document.getElementsByClassName('playlistSearchBox')[0];
		    		if(playlistSearchElement.querySelector('.playlistAlertMsg') != null) {
		    			playlistSearchElement.removeChild(playlistSearchElement.querySelector('.playlistAlertMsg'));
		    		}
		    		var playlistAlertElement = document.createElement('p');
		    		playlistAlertElement.className = 'playlistAlertMsg';
		    		var playlistAlertElementText = document.createTextNode('Already exist');
		    		playlistAlertElement.appendChild(playlistAlertElementText);
		    		playlistSearchElement.appendChild(playlistAlertElement);
		    		clearInterval(clearAlertMsg);
		    		clearAlertMsg = setInterval(function(){removeAlertMsg(playlistSearchElement)},1000);
		    		return false;
		    	}
                return false;
		    	}
		});
	}
	if(ajaxAction == 'search' || ajaxAction == 'create' ) {
	if(playlistContainerBox.firstElementChild.className == 'playlistBox') {
		searchFieldValue(this.value,playlistContainerBox);
	}
	}
};
var playlistActionHandle = function() {
	if(document.body.dataset !== undefined ) {
		var fieldAction = this.dataset.showfield;
	}
	else {
		var fieldAction = this.getAttribute('data-showfield');
	}
	
	if(document.body.dataset !== undefined ) {
		playlistSearchField[0].dataset.action = fieldAction;
	}
	else {
		playlistSearchField[0].setAttribute('data-action',fieldAction);
	}
	playlistSearchField[0].removeAttribute('value');
	if(fieldAction == 'create') {
		playlistSearchField[0].value = '';
		playlistSearchField[0].placeholder = 'Create new playlist';
	}
	if(fieldAction == 'search') {
		playlistSearchField[0].value = '';
		playlistSearchField[0].placeholder = 'Search playlist';
	}
	playlistSearchField[0].style.display = 'block';
};

var playlistButtonHandle = function(event) {
	if(document.body.dataset !== undefined ) {
		vid = this.dataset.vid;
	}
	else {
		vid = this.getAttribute('data-vid');
	}
	var playlistTextFieldElement = playlistElement.querySelector('.playlistTextField');
	playlistTextFieldElement.value='';
	playlistTextFieldElement.placeholder='';
	playlistTextFieldElement.style.display= 'none';
	var playlistButtonParent = this.parentNode;
	var playlistContainerElement = playlistElement.querySelector('.playlistContainer');
	playlistContainerElement.style.cssText = 'height:auto';
	if(playlistContainerElement.firstElementChild) {
		clearPlaylistContainer(playlistContainerElement);
	}
	var playlistNotFound = document.createElement('p');
	var playlistLoadingImg = document.createElement('img');
	playlistLoadingImg.src = pluginUrl+'images/loader.gif';
	playlistLoadingImg.className = 'playlistLoading';
	playlistLoadingImg.style.cssText = 'width:20px !important;height:20px !important';
	//playlistNotFound.innerHTML = 'No playlist found';
	playlistNotFound.className='noPlaylistText';
	playlistNotFound.appendChild(playlistLoadingImg);
	playlistContainerElement.appendChild(playlistNotFound);
	jQuery.ajax({
	    url: url,
	    type: "POST",
	    data: "&action=getplaylist&vid="+vid,
	    success: function (msg) {
	   		var obj = jQuery.parseJSON( msg );	   		
	      	checkResult    = obj.checkResult;
	      	if((obj.redirectURL) && obj.redirectURL !='') {
	      		window.location = obj.redirectURL;
	      		return false;
	      	}
	      	if(checkResult == true) {
	      		var playlistLength = obj.playlist.length
		      	var playlistArray = obj.playlist;
	      		var currentPlaylistArray = obj.currentPlaylist;
	      	}
	      	if(checkResult == true && playlistLength > 0 ) {
	      		clearPlaylistContainer(playlistContainerElement);
	    		for(var playlistIndex = 0 ; playlistIndex < playlistLength; playlistIndex++) {
	    			var playlistBoxElement = document.createElement('div');
		    		playlistBoxElement.className = 'playlistBox';
	    			var checkBox = document.createElement('span');
	    			var PlaylistNameElement = document.createElement('span');
	    			PlaylistNameElement.className = 'playlistNameElement';
	    			checkBox.className = 'playlistCheckbox';  			
	    			if(document.body.dataset !== undefined ) {
	    				checkBox.dataset.pname = playlistArray[playlistIndex].playlist_name;
	    			}
	    			else {
	    				checkBox.setAttribute('data-pname',playlistArray[playlistIndex].playlist_name);
	    				
	    			}	    	
	    			if(document.body.dataset !== undefined ) {
	    				checkBox.dataset.pid   = playlistArray[playlistIndex].id;
	    			}
	    			else {
	    				checkBox.setAttribute('data-pid',playlistArray[playlistIndex].id);
	    				
	    			}	    			
	    			if(document.body.dataset !== undefined ) {
	    				checkBox.dataset.aid = 1;
	    			}
	    			else {
	    				checkBox.setAttribute('data-aid',1);
	    				
	    			}
	    			var labelTextNode = document.createTextNode((playlistArray[playlistIndex].playlist_name.length > 16 ) ? playlistArray[playlistIndex].playlist_name.slice(0,16) + '...' : playlistArray[playlistIndex].playlist_name);
	    			PlaylistNameElement.appendChild(labelTextNode);
	    			if(currentPlaylistArray.indexOf(playlistArray[playlistIndex].id) > -1 ) {
	    				checkBox.style.cssText = 'background-image:url('+tickImage+')';
	    				if(document.body.dataset !== undefined ) {
		    				checkBox.dataset.aid = -2;
		    			}
		    			else {
		    				checkBox.setAttribute('data-aid',-2);
		    				
		    			}
		    			playlistBoxElement.appendChild(checkBox);
		    			playlistBoxElement.appendChild(PlaylistNameElement);
		    			if(playlistContainerElement.firstElementChild) {
		    				playlistContainerElement.insertBefore(playlistBoxElement,playlistContainerElement.firstElementChild);
		    			}
		    			else {
		    				playlistContainerElement.appendChild(playlistBoxElement);
		    			}
		    			
		    			checkBox.addEventListener('click',checkBoxHandle,false);
	    			}
	    			else {
	    				checkBox.value = playlistArray[playlistIndex].playlist_name;
		    			playlistBoxElement.appendChild(checkBox);
		    			playlistBoxElement.appendChild(PlaylistNameElement);
		    			playlistContainerElement.appendChild(playlistBoxElement);
		    			checkBox.addEventListener('click',checkBoxHandle,false);
	    			}
	    			
	    		}
	    		if(playlistContainerElement.childElementCount > 5) {
	    			var playlistContainerElementHeight = playlistContainerElement.firstElementChild.offsetHeight * 5;
	    			playlistContainerElement.style.cssText = 'height:'+playlistContainerElementHeight+'px;overflow:auto';
	    		}
	    		else {
	    			playlistContainerElement.style.cssText = 'height:auto';
	    		}
	        }
	    	if(checkResult == false ) {
	    		playlistContainerElement.removeChild(playlistContainerElement.firstElementChild);
	    		var playlistNotFound = document.createElement('p');
	    		playlistNotFound.innerHTML = 'No playlist found';
	    		playlistNotFound.className='noPlaylistText';
	    		playlistContainerElement.appendChild(playlistNotFound);
	    	}
    		var viewportHeight = window.innerHeight;
    		var playlistOuterBoxTopValue  = playlistElement.getBoundingClientRect().top + playlistElement.offsetHeight;
    		if(playlistOuterBoxTopValue > viewportHeight) {
    			hiddenBottomHeight = playlistOuterBoxTopValue - viewportHeight;
    			if(document.body.scrollTop) {
    				heightToScroll = document.body.scrollTop + hiddenBottomHeight + 30;
    			}
    			else {
    				heightToScroll = document.documentElement.scrollTop + hiddenBottomHeight + 30;
    			}
    			window.scrollTo(0,heightToScroll);
    		}
	    	return false;
	    	}
	});
	
	playlistButtonParent.appendChild(playlistElement);
	for(var i=0;i<playlistActionButton.length;i++) {
		playlistActionButton[i].addEventListener("click",playlistActionHandle,false);
		}
	playlistContainerBox = 	playlistContainerElement;
playlistSearchField[0].addEventListener('keyup',keyPressHandle,false);
	var viewportHeight = window.innerHeight;
	var playlistIconTopValue  = this.getBoundingClientRect().top + playlistElement.offsetHeight;
	if(playlistIconTopValue > viewportHeight) {
		hiddenBottomHeight = playlistIconTopValue - viewportHeight;
		if(document.body.scrollTop) {
			heightToScroll = document.body.scrollTop + hiddenBottomHeight + 30;
		}
		else {
			heightToScroll = document.documentElement.scrollTop + hiddenBottomHeight + 30;
		}
		window.scrollTo(0,heightToScroll);
	}
	
	};

for(var i=0;i<playlistButton.length;i++) {
	playlistButton[i].addEventListener("click",playlistButtonHandle,false);
	}

var closePlaylistHandle = function(event) {
	var playlistElement = document.getElementsByClassName('playlistOuterBox')[0];
if(playlistElement != undefined ) {
	var currentClassName = event.target.className;
	var currentTargetElement = event.target;
		var checkClassName = playlistElement.querySelectorAll('.'+currentClassName);
		
	if(currentTargetElement.className == 'playlistIcon' || currentTargetElement.className == 'playlistIconImg') {
		return false;
	}
	if(checkClassName.length == 0 ) {
		var elementToRemove = document.getElementsByClassName('playlistOuterBox');
		if(elementToRemove.length > 0 ) {
		    var playlistParentElement = elementToRemove[0].parentNode;
			playlistParentElement.removeChild(elementToRemove[0]);
		}
	}
}
};
document.body.addEventListener('click',closePlaylistHandle,false);

var playlistImgBox = document.getElementsByClassName('playlistImgBox');
var playlistImgBoxHandle = function() {
	var playlistParentElement  = this.parentNode;	
	if(document.body.dataset !== undefined ) {
		var pid = playlistParentElement.dataset.pid;
	}
	else {
		var pid = playlistParentElement.getAttribute('data-pid');
		
	}
	var playlistTemplateBox = document.getElementsByClassName('playlistTemplateBox');
	for(var pindex=0;pindex < playlistTemplateBox.length ;pindex++ ) {
		setTimeout(function(){
			console.log(pindex);	
			},0);
		if(playlistTemplateBox[pindex] != this.parentNode) {
			
		}
	}
};
for(var index=0;index < playlistImgBox.length ;index++ ) {
	playlistImgBox[index].addEventListener('click',playlistImgBoxHandle,false);
}
}