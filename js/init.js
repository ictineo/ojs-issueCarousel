/*	CarouFredSel: a circular, responsive jQuery carousel.
	Configuration created by the "Configuration Robot"
	at caroufredsel.dev7studios.com
  */
$(document).ready(function() {
$("#cWrapper").carouFredSel({
	width: 1024,
	height: 210,
	items: 4,
	scroll: 1,
	circular: true,
	infinite: false,
	auto: false,
	prev: {
		button: "#cArrowLeft",
	        easing: "easeInOutCubic",
		key: "left"
	},
	next: {
		button: "#cArrowRight",
	        easing: "easeInOutCubic",
		key: "right"
	}
});
});
