// ajax-search.js
jQuery(document).ready(function ($) {
    $('.tp-search-form input[name="provider-types"]').on('change', function () {
        $(this).closest('form').find('input[name="customSelect"]').val(this.value);
    });

    $('.tp-search-form').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);
        var zipCode = form.find('input[name="zip_code"]').val();
        var typeValue = form.find('input[name="customSelect"]').val() || 'internet';
        var type = typeValue.replace(/ /g, '-').toLowerCase();

        if (!/^\d{5}$/.test(zipCode)) {
            form.find('input[name="zip_code"]').trigger('focus');
            return;
        }

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'search_providers',
                zip_code: zipCode,
                type: type
            },
            success: function (response) {
                if (response && response[0] && response[0].slug) {
                    window.location = response[0].slug;
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + ' - ' + error);
            }
        });
    });

    if ($.fn.slick && $('.providers_slides').length) {
        $('.providers_slides').slick({
            slidesToShow: 5,
            slidesToScroll: 2,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
            dots: false
        });
    }
});
