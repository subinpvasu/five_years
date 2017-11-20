jQuery(document).ready(function($) {
  
  /* for top navigation */
	$(" .navigation ul ").css({display: "none"}); // Opera Fixif(screen.width>959){	$(" .navigation li").hover(function(){	$(this).find('ul:first').css({visibility: "visible",display: "none"}).slideDown(400);	},function(){	$(this).find('ul:first').css({visibility: "hidden"});});}			
	
  /* Initialize Round Corner Elements */
  $('#slideshow,#slideshow,.slide-more,#slideshow-alt,.more-button,.map,.more-button, .left-head, .blog-box,.page-navigation a,.author,.pf-box-view').corner("8px");
  
   $('.ads-list').cycle({
      timeout: 5000,  // milliseconds between slide transitions (0 to disable auto advance)
      fx:      'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...                        
      pause:   0,	  // true to enable "pause on hover"
      pauseOnPagerHover: 0 // true to pause when hovering over pager link       
  });     
  
    /* initialize prettyphoto */
    $("a[rel^='prettyPhoto']").prettyPhoto({
  		theme: 'light_rounded'
    });
    
    /* Portfolio Display Switcher */
  	$("a.switch_thumb").toggle(function(){
  	  $(this).addClass("swap"); 
  	  $("ul.display").fadeOut("fast", function() {
  	  	$(this).fadeIn("fast").addClass("thumb_view"); 
  		 });
  	  }, function () {
        $(this).removeClass("swap");
  	  $("ul.display").fadeOut("fast", function() {
  	  	$(this).fadeIn("fast").removeClass("thumb_view");
  		});
  	}); 
  	
  /* Ajax Contact Form Processing */
  $('#buttonsend').click( function() {
	
		var name    = $('#name').val();
		var subject = $('#subject').val();
		var email   = $('#email').val();
		var message = $('#message').val();
		var siteurl = $('#siteurl').val();
		
		$('.loading').fadeIn('fast');
		
		if (name != "" && subject != "" && email != "" && message != "")
			{

				$.ajax(
					{
						url: siteurl+'/sendemail.php',
						type: 'POST',
						data: "name=" + name + "&subject=" + subject + "&email=" + email + "&message=" + message,
						success: function(result) 
						{
							$('.loading').fadeOut('fast');
							if(result == "email_error") {
								$('#email').css({"border":"2px solid #ff0000"}).next('.require').html('<small>invalid e-mail address</small> !');
							} else {
								$('#name, #subject, #email, #message').val("");
								$('#emailSuccess').show().fadeOut(6200, function(){ $(this).remove(); });
							}
						}
					}
				);
				return false;
				
			} 
		else 
			{
				$('.loading').fadeOut('fast');
				if( name == "") $('#name').css({"border":"2px solid #ff0000"}).next('.require').text(' !');
				if(subject == "") $('#subject').css({"border":"2px solid #ff0000"}).next('.require').text(' !');
				if(email == "" ) $('#email').css({"border":"2px solid #ff0000"}).next('.require').text(' !');
				if(message == "") $('#message').css({"border":"2px solid #ff0000"}).next('.require').text(' !');
				return false;
			}
	});
	
		$('#name, #subject, #email,#message').focus(function(){
			$(this).css({"border":"2px solid #dcdcdc"}).next('.require').text(' *');
		});
      	
});

(function($){
	function detectVideo(){
		var flash_object = '<object style="z-index:0;" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="620" height="345"><param name="wmode" value="transparent" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="{path}" /><embed src="{path}" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="620" height="345" wmode="transparent"></embed></object>';
		var quicktime_object = '<object classid="clsid:02bf25d5-8c17-4b23-bc80-d3488abddc6b" codebase="http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0" height="345" width="620"><param name="src" value="{path}"><param name="autoplay" value="false"><param name="scale" value="tofit"><param name="type" value="video/quicktime"><embed src="{path}" scale="tofit" height="345" width="620" autoplay="false" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/"></embed></object>';
		var toInject = "";
		
		var divWrapper = $('.movie_container');
		var ObjectP = divWrapper.find('a');
		
		switch(ObjectP.attr('rel')){
		  
					case 'youtube':
						movie = 'http://www.youtube.com/v/'+igrab_param('v', ObjectP.attr('href'));
						toInject = flash_object.replace(/{path}/g,movie);
					break;
					
					case 'vimeo':
						movie_id = ObjectP.attr('href');
						movie = "http://vimeo.com/moogaloop.swf?clip_id="+ movie_id.replace('http://vimeo.com/','');
					  toInject = flash_object.replace(/{path}/g,movie);
					break;
					
          case 'flash':
						movie = ObjectP.attr('href');
						toInject = flash_object.replace(/{path}/g,movie);
					break;
					
					case 'quicktime':
						movie = ObjectP.attr('href');
						toInject = quicktime_object.replace(/{path}/g,movie);
					break;
		}
		
		divWrapper.html(toInject);
		
	function igrab_param(name,url){
	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	  var regexS = "[\\?&]"+name+"=([^&#]*)";
	  var regex = new RegExp( regexS );
	  var results = regex.exec( url );
	  if( results == null )
	    return "";
	  else
	    return results[1];
	}	
	
  }
  $(document).ready(function(){detectVideo();});
	
})(jQuery); 

