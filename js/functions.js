// Responsive Navigation
var navigation = responsiveNav("responsive-navigation", {customToggle: ".nav-toggle"});

// Responsive Video
// $(".media-video").fitVids();

// Functionality

// Navigation Variables
var navItems = $('.main-nav');
var navIntro = $('#navIntro');
var navWho = $('#navWho');
var navPayment = $('#navPayment');
var navPromotions = $('#navPromotions');
var navFAQ = $('#navFAQ');

//Responsive Navigation Variables
var resNavItems = $('.res-nav');
var resIntro = $('#responsiveIntro');
var resWho = $('#responsiveWho');
var resPayment = $('#responsivePayment');
var resPromotions = $('#responsivePromotions');
var resFAQ = $('#responsiveFAQ');

// Section Variables
var sectionIntro = $('#adxIntro');
var sectionWho = $('#who');
var sectionPayment = $('#payment');
var sectionPromotions = $('#promotions');
var sectionFAQ = $('#faq');

// Box Centering
var headerHeight = $('.main-navigation').height();
var offsetTop = headerHeight;
var box = $('.box');

var tolerance = 200;

var scrollInit = function() {
    var scrollTop = $(this).scrollTop();
    navItems.removeClass('selected');
    resNavItems.removeClass('selected');

    if (scrollTop >= sectionFAQ.position().top - tolerance) {
        navFAQ.addClass('selected');
        resFAQ.addClass('selected');
    } else if (scrollTop >= sectionPromotions.position().top - tolerance) {
        navPromotions.addClass('selected');
        resPromotions.addClass('selected');
    } else if (scrollTop >= sectionPayment.position().top - tolerance) {
        navPayment.addClass('selected');
        resPayment.addClass('selected');
    } else if (scrollTop >= sectionWho.position().top - tolerance) {
        navWho.addClass('selected');
        resWho.addClass('selected');
    } else if (scrollTop >= sectionIntro.position().top - tolerance) {
        navIntro.addClass('selected');
        resIntro.addClass('selected');
    } else {

    }

    // Centering
    box.each(function() {
        $(this).css("padding-top", (($(window).height()-$(this).height()-offsetTop)/2) + "px");
        $(this).css("padding-bottom", "50px");
    });
}

$(window).scroll(scrollInit);
$(window).resize(scrollInit);
scrollInit();

// Initiate the Smooth Scroll
smoothScroll.init({
	speed: 500,
	easing: 'easeInOutQuad',
	offset: 0,
	updateURL: false,
	callbackBefore: function ( toggle, anchor ) {},
	callbackAfter: function ( toggle, anchor ) {}
});

// FAQ Toggles

$('.faq-section').click(function(){
    $(this).toggleClass('selected');
});