// JavaScript Document
function contact() { 
      // Call the scroll function
    $('html,body').animate({
        scrollTop: $("#quick-contact").offset().top},
        'slow');
		$('#contact-email').focus();
		return false;
}