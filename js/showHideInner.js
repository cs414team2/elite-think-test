// http://papermashup.com/jquery-show-hide-plugin/

$(document).ready(function(){
		   $('.show_hide_inner').showHideInner({			 
				speed: 1000,  // speed you want the toggle to happen	
				easing: 'swing',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
				changeText: 0 // if you dont want the button text to change, set this to 0					 
			});
			$(".show_hide_inner").addClass("button special big");
		});


(function ($) {
    $.fn.showHideInner = function (options) {		
		//default vars for the plugin
        var defaults = {
            speed: 1000,
			easing: 'swing',
			changeText: 0	
        };
        var options = $.extend(defaults, options);

        $(this).click(function () {	
			$('.toggleInnerDiv').hide();
		   
             $('.toggleInnerDiv').slideUp(options.speed, options.easing);	
			 // this var stores which button you've clicked
             var toggleClick = $(this);
		     // this reads the rel attribute of the button to determine which div id to toggle
		     var toggleInnerDiv = $(this).attr('rel');
		     // here we toggle show/hide the correct div at the right speed and using which easing effect
		     $(toggleInnerDiv).slideToggle(options.speed, options.easing, function() {
		     // this only fires once the animation is completed
			 if(options.changeText==1){
		     $(toggleInnerDiv).is(":visible") ? toggleClick.html(options.hideText) : toggleClick.html(options.showText);
			 }
              });
		   
		  return false;
		   	   
        });

    };
})(jQuery);