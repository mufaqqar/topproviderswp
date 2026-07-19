jQuery(document).ready(function ($) {
    if ($.fn.slick) {
        $('.providers_slides').slick({
            slidesToShow: 5,
            slidesToScroll: 2,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
            dots: false,
            responsive: [
                { breakpoint: 1024, settings: { slidesToShow: 3, slidesToScroll: 1 } },
                { breakpoint: 640, settings: { slidesToShow: 2, slidesToScroll: 1 } }
            ]
        });
    }
});