jQuery(document).ready(function(){
jQuery('.playerContainer').hide();
jQuery('.subscripeContainer').hide();
jQuery('.mysubscriptionContainer').hide();
jQuery('.aboutContainer').hide();
var totalChild = jQuery('.notificationParent').children().length;
var totalChildHeight = 0;
if(totalChild >= 4) {
jQuery('.notificationParent').children().each(function(c){
    if(c==3) {
        return false;
    }
totalChildHeight += this.offsetHeight;
}); 
notificationContainerHeight = totalChildHeight + 31;
notificationRowHeight       = totalChildHeight;
//jQuery('.notificationContainers').css('height',notificationContainerHeight+'px');
jQuery('.notificationRows').css('max-height',notificationRowHeight+'px');
}
/*else if( totalChild > 0 && totalChild < 4) {
jQuery('.notificationParent').children().each(function(c){
totalChildHeight += this.offsetHeight;
}); 
notificationContainerHeight = totalChildHeight;
notificationRowHeight       = totalChildHeight;

}
else {
    notificationContainerHeight = 0;
    notificationRowHeight       = 0;

}
jQuery('.notificationContainers').css('height',notificationContainerHeight+'px');
jQuery('.notificationRows').css('height',notificationRowHeight+'px');*/
jQuery('.notificationContainers').mouseleave(function(){
	jQuery(this).hide();
});
jQuery('body').click(function(e){
	if(e.target.className != 'notificationLink' && e.target.className != 'notificationLis' ) {
		jQuery('.notificationContainers').hide();

	}
	});
jQuery('.notificationContainers').hide();
jQuery('.notificationContainer').hide();
jQuery('.searchChannelButton').show();
jQuery('.thumbImage').click(function(){
	var vid,cid;
	vid = jQuery(this).parent().find('.vid').val();
	cid = jQuery(this).parent().find('.pid').val();
	videoPlayer(vid,cid);
	
});
jQuery('.subscriberVideosButton').click(function(){
	/*jQuery('.searchButton').show();*/
	jQuery('.searchChannelButton').show();

	 jQuery('.loadingBar').css('width','0%');
	 jQuery('.search').val('');
	 jQuery('.aboutContainer').hide();
	 jQuery('.subscripeContainer').hide();
	 jQuery('.mysubscriptionContainer').hide();
	 jQuery('.notificationContainer').hide();
	 jQuery('.videoContainer').show();
     jQuery('.channelMenuContainer p').css('left','0px');
     jQuery('.channelMenuContainer p').css('color','rgb(89, 85, 85)');
     jQuery('.channelMenuContainer p').css('background','rgb(252, 193, 179)');
     jQuery(this).css('color','white');
	 channelMyVideos('subscriberVideosButton','','');
});
if(jQuery('.subscriberVideosButton').length > 0 ) {
	jQuery('.subscriberVideosButton').trigger('click');
}

jQuery('.searchButton').click(function(){
	var searchName;
	 jQuery('.aboutContainer').hide();
	 jQuery('.subscripeContainer').hide();
	 jQuery('.mysubscriptionContainer').hide();
	 jQuery('.notificationContainer').hide();
	 jQuery('.videoContainer').show();
	searchName = jQuery('.search').val();
    jQuery('.channelMenuContainer p').css('left','0px');
    jQuery('.channelMenuContainer p').css('color','rgb(89, 85, 85)');
    jQuery('.channelMenuContainer p').css('background','rgb(252, 193, 179)');	
	channelMyVideos(jQuery(this).attr('class'),'','');
});



jQuery('.aboutButton').click(function(){
	jQuery('.searchButton').show();
	jQuery('.searchChannelButton').show();
	jQuery('.search').val('');
	jQuery('.videoContainer').hide();
	jQuery('.subscripeContainer').hide();
	jQuery('.notificationContainer').hide();
	jQuery('.mysubscriptionContainer').hide();
	jQuery('.aboutContainer').show();
    jQuery('.channelMenuContainer p').css('left','0px');
    jQuery('.channelMenuContainer p').css('color','rgb(89, 85, 85)');
	jQuery('.channelMenuContainer p').css('background','rgb(252, 193, 179)');
	jQuery(this).css('left','10px');
	jQuery(this).css('color','white');
	jQuery(this).css('background','rgb(250, 118, 87)');

});

jQuery('.saveDescription').click(function(){
	channelMyVideos(jQuery(this).attr('class'),'','');
	});

jQuery('.browseChannelButton').click(function(){
	jQuery('.search').val('');
	jQuery('.searchButton').hide();
	jQuery('.searchChannelButton').show();
	jQuery('.videoContainer').hide();
	jQuery('.aboutContainer').hide();
	jQuery('.mysubscriptionContainer').hide();
    jQuery('.channelMenuContainer p').css('left','0px');
    jQuery('.channelMenuContainer p').css('color','rgb(89, 85, 85)');
	jQuery('.channelMenuContainer p').css('background','rgb(252, 193, 179)');
	jQuery('.notificationContainer').hide();
	jQuery('.subscripeContainer').show();
});

jQuery('.searchChannelButton').click(function(){
	var currentElement = document.getElementsByClassName('searchChannelButton')[0];
	if(document.body.dataset !== undefined ) {
		currentElement.dataset.setaction = 'searched';
	}
	else {
		currentElement.setAttribute('data-setaction','searched');
	}
	jQuery('.videoContainer').hide();
	jQuery('.aboutContainer').hide();
	jQuery('.mysubscriptionContainer').hide();
	jQuery('.notificationContainer').hide();
    jQuery('.channelMenuContainer p').css('left','0px');
    jQuery('.channelMenuContainer p').css('color','rgb(89, 85, 85)');
	jQuery('.channelMenuContainer p').css('background','rgb(252, 193, 179)');
	jQuery('.subscripeContainer').show();	
	channelMyVideos(jQuery(this).attr('class'),'','');
});

jQuery('.browseChannelButton').click(function(){
	var currentElement = document.getElementsByClassName('searchChannelButton')[0];
	if(document.body.dataset !== undefined ) {
		currentElement.dataset.setaction = '';
	}
	else {
		currentElement.setAttribute('data-setaction','');
	}
	channelMyVideos(jQuery(this).attr('class'),'','');
	});
jQuery('.mySubscriptionButton').click(function(){
	jQuery('.searchButton').show();
	jQuery('.searchChannelButton').show();
	jQuery('.notificationContainer').hide();
	jQuery('.search').val('');
	jQuery('.videoContainer').hide();
	jQuery('.aboutContainer').hide();
	jQuery('.subscripeContainer').hide();
    jQuery('.channelMenuContainer p').css('left','0px');
    jQuery('.channelMenuContainer p').css('color','rgb(89, 85, 85)');
	jQuery('.channelMenuContainer p').css('background','rgb(252, 193, 179)');
	jQuery(this).css('left','10px');
	jQuery(this).css('color','white');
	jQuery(this).css('background','rgb(250, 118, 87)');
	channelMyVideos(jQuery(this).attr('class'),'','');
});

   /* jQuery('.notifi').click(function(){
    	jQuery('.searchButton').show();
    	jQuery('.searchChannelButton').hide();

    	jQuery('.notificationContainer').show();
    });*/
//temporary script

jQuery('.notificationLink').click(function(){
	jQuery('.searchButton').show();
	jQuery('.searchChannelButton').show();

	jQuery('.notificationContainers').show();
});

jQuery('.subButton').click(function(){
	
	notificationId = jQuery(this).parent().find('.subscriperId').val();
	channelMyVideos(jQuery(this).attr('class'),notificationId,jQuery(this));
});

jQuery('.subDeleteButton').click(function(){
	
	notificationId = jQuery(this).parent().find('.subscriperId').val();
	channelMyVideos(jQuery(this).attr('class'),notificationId,jQuery(this));
});

jQuery('.seeMoreLink').click(function(){
	jQuery('.notificationContainer').show();
	jQuery('.searchChannelButton').show();
	jQuery('.search').val('');
	jQuery('.videoContainer').hide();
	jQuery('.aboutContainer').hide();
	jQuery('.subscripeContainer').hide();
	jQuery('.mysubscriptionContainer').hide();
    jQuery('.channelMenuContainer p').css('left','0px');
    jQuery('.channelMenuContainer p').css('color','rgb(89, 85, 85)');
	jQuery('.channelMenuContainer p').css('background','rgb(252, 193, 179)');
	
});
//temporary scrip end

    jQuery('.cancelNotification').click(function(){
    	jQuery('.notificationContainer').hide();
    	jQuery('.myVideosButton').click();
    });
 
    jQuery('.deleteNotification').click(function(){
    	channelMyVideos(jQuery(this).attr('class'),'','');
    });
    
    jQuery('.uploadButton').click(function(){
    	
    });
});

function closePlayer() {
	jQuery('.player').html('');
	jQuery('.playerContainer').hide();
}

function saveSubscriper(e) {
	subscriperId = jQuery(e).parent().find('.subscriperId').val();
	channelMyVideos(jQuery(e).attr('class'),subscriperId,'');
}

function flashPlayer(ele) {
	var vid,cid;
	vid = jQuery(ele).parent().find('.vid').val();
	cid = jQuery(ele).parent().find('.pid').val();
	videoPlayer(vid,cid);	
}


function closemysubscripers(e) {
	if(confirm('Are you sure want to delete?')) {
	msid = jQuery(e).parent().find('.msid').val();
	channelMyVideos(jQuery(e).attr('class'),msid,'');
	}
}
 function playerHeight() {
	jQuery('.player').css('height','448px');
 }