jQuery(document).ready(function(){
	 var pixelText,imageEditor,uploadType,bannerContainerWidth;
	 //adaptProfileContainer();
	 jQuery('.saveButtonContainer').hide();
	 jQuery('.channel_dragreposition').hide();
	 jQuery('.dragContainer').hide();
	 jQuery('.cropContainer').hide();
	 jQuery('.profileDragContainer').hide();
	 jQuery('.pixelCondition').text('');
	 jQuery('.dragButtonContainer').hide();
	 jQuery('.loadingBar').hide();
	 jQuery('.dragBox').hide();
	 bannerContainerWidth = jQuery('.bannerContainer')[0].offsetWidth;
	 //jQuery('.coverImages').css('max-width',bannerContainerWidth);
	 
	 /** profileEditor click function **/
	 jQuery('.profileEditor,.coverEditor').click(function() {
		 jQuery('.bannerContainer').css('height','190px');
		 jQuery('.dragButtonContainer').hide();
		 jQuery('.bannerContainer').css('background','transparent');
		 jQuery('.saveButtonContainer').hide();
		    jQuery('.fileContent').val('');
		    imageEditor = this.className;
		    if(imageEditor == 'profileEditor') {
		    	pixelText  = 'Image must be 1024x700 pixels';
		    	jQuery('.uploadTypeValue').val('profile');
		    	uploadType = 'profile';
		    }
		    if(imageEditor == 'coverEditor') {
		    	pixelText  = 'Image must be greater than or equal to 1024x700 pixels';
		    	jQuery('.uploadTypeValue').val('cover');
		    	uploadType = 'cover';
		    }
	    	jQuery('.profileContainer').hide();
	    	jQuery('.coverContainer').hide();
	    	jQuery('.pixelCondition').text(pixelText);
	    	jQuery('.dragContainer').show(200);
	 		});
	 
	 jQuery('.closeButton').click(function(){
		   jQuery('.bannerContainer').css('height','250px');
	       jQuery('.fileContent').val('');
		   jQuery('.dragContainer').hide();
		   jQuery('.pixelCondition').text('');
           jQuery('.profileContainer').show();
	       jQuery('.coverContainer').show();
	 });

	 jQuery('.imageButton').click(function(){
		  jQuery('.fileContent').click();
	 });
	 
	 jQuery('.fileContent').change(function(){
		    var ua = window.navigator.userAgent;
			var msie = ua.indexOf("MSIE ");
		    if(msie > 0) {
		    	jQuery('.uploadSubmitButton').submit();
                   return;
		    }
		    else {
			var file, img, imageWidth, imageHeight, type,validType, regPattern, _URL, siteURL, validUrl, ui ;
			ui = parseInt(jQuery('.ui').val());
			var file = this.files[0];
			var _URL = window.URL || window.webkitURL;
			img = new Image();
			type = file.type;
			regPattern = new RegExp(/^image\/(jpeg|png|gif)$/);
			validType = regPattern.test(type);
			if(!validType) {
				alert('Invalid type');
				return;
			}
			  img.onload = function() {
		      imageHeight = this.height;
		      imageWidth  = this.width;
		   };

			  if(uploadType == 'cover') {

                  if(imageWidth > 1000 || imageHeight > 700 ) {
                	  alert('Image pixel should be greater than 1024X700');
                	  return;
                  }				  
			  }		   
		   img.src = _URL.createObjectURL(file);
		   
		   if(validType) {
		       var formData = new FormData();
		       formData.append("images", this.files[0]);
		       uploadImage(formData,uploadType,ui);
		   }
	 }
		 });
	   
	 var dropArea = document.getElementById('dragContainer');
	 
		dropArea.addEventListener("dragover", function (evt) {
			jQuery('.dragContainer').css('background','honeydew');
			evt.preventDefault();
			evt.stopPropagation();
		}, false);
		
		dropArea.addEventListener("dragleave", function (evt) {
			jQuery('.dragContainer').css('background','rgb(249, 249, 249)');
			evt.preventDefault();
			evt.stopPropagation();
		}, false);	
		
		dropArea.addEventListener("drop", function (evt) {
			dragFile = evt.dataTransfer.files;
			ui = parseInt(jQuery('.ui').val());
	        file = dragFile[0];
	        jQuery('.dragContainer').css('background','rgb(249, 249, 249)');
			var _URL = window.URL || window.webkitURL;
			img = new Image();
			type = file.type;
			regPattern = new RegExp(/^image\/(jpeg|png|gif)/);
			validType = regPattern.test(type);

			if(!validType) {
				evt.preventDefault();
				evt.stopPropagation();
				alert('Invalid type');
				return;
			}
			  img.onload = function() {
		      imageHeight = this.height;
		      imageWidth  = this.width;
		   };
		   img.src = _URL.createObjectURL(file);
		   if(validType) {
		       var formData = new FormData();
		       formData.append("images", file);
		       uploadImage(formData,uploadType,ui);
		   }

			evt.preventDefault();
			evt.stopPropagation();
		}, false);
		
		jQuery('.cropContainer').draggable({

			stop:function(){
				var bannerContainerWidth,cropConatinerWidth,widthDifference;
				bannerContainerWidth = jQuery('.bannerContainer')[0].offsetWidth;
				cropContainerWidth   = jQuery('.cropContainer')[0].offsetWidth;
				bannerContainerHeight = jQuery('.bannerContainer')[0].offsetHeight;
				cropContainerHeight   = jQuery('.cropContainer')[0].offsetHeight;
				
				
			    var y = jQuery('.cropContainer')[0].offsetTop;
			    var x = jQuery('.cropContainer')[0].offsetLeft;

			    
			    if(x > 0 ) {
			    	jQuery('.cropContainer').css('left','0px');
			    }

	            

			    if(y > 0 ) {
			    	jQuery('.cropContainer').css('top','0px');
			    }
			    
			    
	            if(cropContainerWidth > bannerContainerWidth) {
					
					leftOffsetValue = cropContainerWidth - bannerContainerWidth;
				}
				
	            if(cropContainerHeight > bannerContainerHeight) {
					
					topOffsetValue = cropContainerHeight - bannerContainerHeight;
				}

	            
	            currentLeftOffsetPosition = jQuery('.cropContainer')[0].offsetLeft;
	            if(currentLeftOffsetPosition < 0) {

	    			leftValue = Math.abs(currentLeftOffsetPosition);
	            }
	            else {
	            	leftValue = '';
	            }
	            currentTopOffsetPosition = jQuery('.cropContainer')[0].offsetTop;
	            if(currentTopOffsetPosition < 0) {

	            	topValue = Math.abs(currentTopOffsetPosition);
	            }
	            else {
	            	topValue = '';
	            }

				if(leftValue > leftOffsetValue && leftValue != '') {
					jQuery('.cropContainer').css('left','-'+leftOffsetValue+'px');
				}
				
				if(topValue > topOffsetValue && topValue != '') {
					jQuery('.cropContainer').css('top','-'+topOffsetValue+'px');
				}			}
		});
		
		//profile image crop section start
		
		jQuery('.profileDragContainer').draggable({

			stop:function(){
				var bannerContainerWidth,cropConatinerWidth,widthDifference;
				bannerContainerWidth = jQuery('.bannerContainer')[0].offsetWidth;
				cropContainerWidth   = jQuery('.profileDragContainer')[0].offsetWidth;
				bannerContainerHeight = jQuery('.bannerContainer')[0].offsetHeight;
				cropContainerHeight   = jQuery('.profileDragContainer')[0].offsetHeight;
				
				
			    var y = jQuery('.profileDragContainer')[0].offsetTop;
			    var x = jQuery('.profileDragContainer')[0].offsetLeft;

			    
			    if(x > 0 ) {
			    	jQuery('.profileDragContainer').css('left','0px');
			    }

	            

			    if(y > 0 ) {
			    	jQuery('.profileDragContainer').css('top','0px');
			    }
			    
			    
	            if(cropContainerWidth > bannerContainerWidth) {
					
					leftOffsetValue = cropContainerWidth - bannerContainerWidth;
				}
				
	            if(cropContainerHeight > bannerContainerHeight) {
					
					topOffsetValue = cropContainerHeight - bannerContainerHeight;
				}

	            
	            currentLeftOffsetPosition = jQuery('.profileDragContainer')[0].offsetLeft;
	            if(currentLeftOffsetPosition < 0) {

	    			leftValue = Math.abs(currentLeftOffsetPosition);
	            }
	            else {
	            	leftValue = '';
	            }
	            currentTopOffsetPosition = jQuery('.profileDragContainer')[0].offsetTop;
	            if(currentTopOffsetPosition < 0) {

	            	topValue = Math.abs(currentTopOffsetPosition);
	            }
	            else {
	            	topValue = '';
	            }

				if(leftValue > leftOffsetValue && leftValue != '') {
					jQuery('.profileDragContainer').css('left','-'+leftOffsetValue+'px');
				}
				
				if(topValue > topOffsetValue && topValue != '') {
					jQuery('.profileDragContainer').css('top','-'+topOffsetValue+'px');
				}			}
		});
		
		
		
		//profle image crop section end
		
		
		jQuery('.saveButton').click(function(){
			var cw,ch,cx,cy;
			cx = Math.abs(jQuery('.cropContainer')[0].offsetLeft);
			cy = Math.abs(jQuery('.cropContainer')[0].offsetTop);
			cw = Math.abs(jQuery('.bannerContainer')[0].offsetWidth);
			ch = Math.abs(jQuery('.bannerContainer')[0].offsetHeight);
			cropImage(cx,cy,cw,ch);
		});
 
		jQuery('.profileDragBox').draggable({containment : "parent"});

//new dragbox start

		jQuery('.saveProfileImage').click(function(){
			var cw,ch,cx,cy;
			cx  = Math.abs(jQuery('.profileDragContainer')[0].offsetLeft) + Math.abs(jQuery('.dragBox')[0].offsetLeft);
			cy  = Math.abs(jQuery('.profileDragContainer')[0].offsetTop) + Math.abs(jQuery('.dragBox')[0].offsetTop);
			cw = 160;
			ch = 160;
			jQuery('.dragButtonContainer').hide();
			cropImage(cx,cy,cw,ch);
			
		});


//new dragbox end
		
		jQuery('.cancelButton').click(function(){
	        jQuery('.fileContent').val('');
            jQuery('.dragBox').css('top','0px');
 			jQuery('.dragBox').css('left','0px');
			jQuery('.cropContainer').css('top','0px');
			jQuery('.cropContainer').css('left','0px');
			jQuery('.profileDragContainer').css('top','0px');
			jQuery('.profileDragContainer').css('left','0px');
	    	jQuery('.profileUpload').hide();
	    	jQuery('.channel_dragreposition').hide();
	    	jQuery('.dragButtonContainer').hide();
	    	jQuery('.coverUpload').hide();
	    	jQuery('.cropContainer').hide();
	    	jQuery('.dragContainer').hide();
	    	jQuery('.profileDragContainer').hide();
	    	jQuery('.saveButtonContainer').hide();
	    	jQuery('.coverContainer').show();
	    	jQuery('.profileContainer').show();
			jQuery('.dragBox').hide();
	    	jQuery('.fileContent').val('');		
			
		});
		
		jQuery(window).resize(function() {
		 	//adaptProfileContainer();
		});
		
		/*function adaptProfileContainer() {
			var profileContainerWidth,coverContainerWidth,profileContainerheight;
			 coverContainerWidth = jQuery('.coverContainer').outerWidth();
			 if(coverContainerWidth < 401 ) {
				 profileContainerWidth = 100+'px';
				 profileContainerheight = 100+'px';
				 jQuery('.profileContainer').css('width',profileContainerWidth);
				 jQuery('.profileContainer').css('height',profileContainerheight);
			 }
			 else {
				 profileContainerWidth = 160+'px';
				 profileContainerheight = 160+'px';
				 jQuery('.profileContainer').css('width',profileContainerWidth);
				 jQuery('.profileContainer').css('height',profileContainerheight);

			 }
		}*/
		
		jQuery('.dragBox').draggable({
			containment:".bannerContainer"
		});

});
