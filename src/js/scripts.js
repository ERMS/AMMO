$(document).ready(function() {
	$("#slideshow").css("overflow", "hidden");


	$("#slideshow").hover(function() {
	$("ul#nav-style").fadeIn();
	},
		function() {
	$("ul#nav-style").fadeOut();
	});
});