function isValidSwedishSSN(ssn) {
    ssn = ssn
        .substring(2)
        .replace(/\D/g, "") // strip out all but digits
        .split("") // convert string to array
        .reverse() // reverse order for Luhn
        .slice(0, 10); // keep only 10 digits (i.e. 1977 becomes 77)

    // verify we got 10 digits, otherwise it is invalid
    if (ssn.length != 10) {
        return false;
    }

    var sum = ssn
        // convert to number
        .map(function (n) {
            return Number(n);
        })
        // perform arithmetic and return sum
        .reduce(function (previous, current, index) {
            // multiply every other number with two
            if (index % 2) current *= 2;
            // if larger than 10 get sum of individual digits (also n-9)
            if (current > 9) current -= 9;
            // sum it up
            return previous + current;
        });

    // sum must be divisible by 10
    return 0 === sum % 10;

};

jQuery(document).ready(function ($) {
    const errorMassage = 'Ange ett korrekt personnummer i formatet Г…Г…Г…Г…MMDD-XXXX',
        emptyMassage = 'Detta fГ¤lt krГ¤vs';

    $('#personal_number').on('input', function () {

        let inputParent = $(this).parent(),
            errorElem = inputParent.children('.error-message')

        if (isValidSwedishSSN($(this).val())) {
            $(this).css({
                "border": "1px solid green"
            })
            $(errorElem).remove()
            $('#kco-wrapper-disable').hide()
        } else {
            $(this).css({
                "border": "1px solid red"
            })
            $('#kco-wrapper-disable').show()
            if ($(this).val() == '') {
                if (!$(errorElem).length) {
                    inputParent.append('<p class="error-message">' + emptyMassage + '</p>')
                } else {
                    $(errorElem).text(emptyMassage)

                }
                return
            }

            if (!$(errorElem).length) {
                inputParent.append('<p class="error-message">' + errorMassage + '</p>')
            } else {
                $(errorElem).text(errorMassage)

            }
        }
    });

    $('#kco-wrapper-disable').on('click', function (){
        $('#personal_number').css({
            "border": "1px solid red"
        })
    });
});


jQuery(document).ready(function ($) {

    $.datepicker.regional['sv'] = {
        closeText: 'StГ¤ng',
        prevText: '< FГ¶regГҐende',
        nextText: 'NГ¤sta >',
        currentText: 'Nu',
        monthNames: ['Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli', 'Augusti', 'September', 'Oktober', 'November', 'December'],
        monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
        dayNamesShort: ['SГ¶n', 'MГҐn', 'Tis', 'Ons', 'Tor', 'Fre', 'LГ¶r'],
        dayNames: ['SГ¶ndag', 'MГҐndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'LГ¶rdag'],
        dayNamesMin: ['SГ¶', 'MГҐ', 'Ti', 'On', 'To', 'Fr', 'LГ¶']
    };

    $.datepicker.regional['en'] = {
        dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ],
    }

    var userLang = navigator.language || navigator.userLanguage;
    var todayDate = new Date().getDate();

    $("#checkout_datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: new Date(),
        maxDate: new Date(new Date().setDate(todayDate + 30))
    }).datepicker('setDate', new Date());;

    if (userLang.split('-')[0] == 'sv') {
        $.datepicker.setDefaults($.datepicker.regional["sv"]);
    } else {
        $.datepicker.setDefaults($.datepicker.regional["en"]);
    }
    let bookingSlider = '.booking-final-slider',
        bookingHeader = $('.booking-final__form-header');
    function movingBooking() {
        if ($(window).width() < 768 && bookingHeader.length >= 1) {
            bookingHeader.insertAfter('.booking-final__wrapper-order')
        }
    }
    movingBooking();

    var settings = {
        slidesPerView: 3,
        watchOverflow: true,
        allowTouchMove: false,
        loop: false,
        autoplay: {
            delay: 2000,
        },
        breakpoints: {
            992: {
                loop: true,
                slidesPerView: 1,
            }
        },
    }

    bookingFinalSwiper = new Swiper(bookingSlider, settings);

    $(window).resize(function () {
        if (bookingHeader.length >= 1 && $(window).width() < 768) {
            bookingHeader.insertAfter('.booking-final__wrapper-order')
            bookingFinalSwiper.destroy();
            bookingFinalSwiper = new Swiper(bookingSlider, settings);
        } else {

            bookingHeader.prependTo('.booking-final')
            bookingFinalSwiper.destroy();
            bookingFinalSwiper = new Swiper(bookingSlider , settings);

        }
    });
});