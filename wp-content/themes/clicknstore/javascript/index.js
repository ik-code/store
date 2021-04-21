"use strict";

jQuery(document).ready(function ($) {
  var bookingPage = document.querySelector('.booking-page');

  if (bookingPage) {
    var bookingTabNavs = document.querySelectorAll('.booking__nav-tabs-button');
    bookingTabNavs.forEach(function (item) {
      item.addEventListener('click', function (event) {
        event.preventDefault();
        var activeTabButton = document.querySelector('.booking__nav-tabs-button.booking__nav-tabs-button--active');
        activeTabButton.classList.remove('booking__nav-tabs-button--active');
        event.target.classList.add('booking__nav-tabs-button--active');
        var tabNumber = event.target.getAttribute('data-tab-button');
        var activeTabForm = document.querySelector('.booking__form.booking__form--show');
        activeTabForm.classList.remove('booking__form--show');
        document.querySelector("[data-tab-form='".concat(tabNumber, "']")).classList.add('booking__form--show');
      });
    }); // masks

    $('.bank-id').each(function (index, element) {
      $(element).mask('999999999999').attr('minlength', '12');
    });
  }

  function startTimer(duration, display) {
    setTimeout(function() {
      var timer = duration - $('.booking-final__timer').data('timer');
      var minutes,
          seconds;

      let timerInterval = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        display.textContent = minutes + ' : ' + seconds;

        if (--timer < 0) {
          ajax_clear_checkout();
          window.location.href = '/hyra-forrad';
          clearInterval(timerInterval);
        }
      }, 1000);
    }, 500);
  }

  function ajax_clear_checkout() {
    $.ajax({
      url: '/wp-admin/admin-ajax.php',
      type: 'POST',
      data: {
        action: 'ajax_clear_cart'
      },
    })
        .done(function () {
          console.log("cart is clear");
        })
        .fail(function () {
          console.log("cart error");
        })
        .always(function () {
          console.log("cart complete");
        });
  }

  var bookingFinalPage = document.querySelector('.booking-final-page');

  if (bookingFinalPage) {
    var setValueResult = function setValueResult(value) {
      if (!value.id) {
        return value.text;
      }

      var $value = $("\n      <div class=\"option__item\">\n        <span class=\"option__size\">".concat(value.element.dataset.value, "</span>\n        <span class=\"option__price\">").concat(value.element.dataset.price, "</span>\n    </div>"));
      return $value;
    };

    var thirtyMinutes = 60 * 30;
    var timerElement = document.querySelector('.booking-final__time');
    startTimer(thirtyMinutes, timerElement);
    var userInfoDropdowns = document.querySelectorAll('.booking-final__info-title, .booking-final__rent-info-title');
    userInfoDropdowns.forEach(function (item) {
      item.addEventListener('click', function () {
        this.parentNode.classList.toggle('open');
        var panel = this.parentNode;

        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + 'px';
        }
      });
    });

    $('.booking-final__select-insurance').select2({
      placeholder: 'Välj värde i förråd',
      tags: true,
      minimumResultsForSearch: -1,
      width: '100%',
      templateResult: setValueResult,
      templateSelection: function(data) {
        return data.element.dataset.value + ' | ' + data.element.dataset.price;
      }
    }).on('select2:open', function (e) {
      document.querySelector('.select2-dropdown').style.cssText = "max-width: 600px";
    });

    var discontForm = document.querySelector('.booking-final__discont');
    var discontInput =''; // discontForm.querySelector('.booking-final__discont-input');
    var discontButton = document.querySelector('.booking-final__discont-button');
    var discontValue = document.querySelector('.booking-final__rent-info-block.booking-final__rent-info-block--discont');

  }
});
"use strict";

var cabinetPage = document.querySelector('.cabinet-page');

if (cabinetPage) {
  var cabinetDropdown = document.querySelector('.cabinet__tabs-title');
  var cabinetTabtButton = document.querySelectorAll('.cabinet__tabs-item');
  var dropdownTitleText = document.querySelector('.cabinet__tabs-title-text');
  cabinetDropdown.addEventListener('click', function (event) {
    event.target.parentNode.classList.toggle('open');
  });
  cabinetTabtButton.forEach(function (item) {
    item.addEventListener('click', function () {
      document.querySelector('.cabinet__tabs-item.cabinet__tabs-item--active').classList.remove('cabinet__tabs-item--active');
      document.querySelector('.data-tab.show').classList.remove('show');
      item.classList.add('cabinet__tabs-item--active');
      var index = item.getAttribute('data-cabinet-link');
      document.querySelector('[data-cabinet-tab="' + index + '"]').classList.add('show');
      var text = item.textContent;
      dropdownTitleText.textContent = text;
      item.parentNode.parentNode.classList.remove('open');
    });
  }); // phone mask

  jQuery('.postcode').mask('99999');
}


function _toConsumableArray(arr) {
  return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread();
}

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance");
}

function _iterableToArray(iter) {
  if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter);
}

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) {
    for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) {
      arr2[i] = arr[i];
    }
    return arr2;
  }
}

jQuery(document).ready(function ($) {
  var homePage = document.querySelector('.home-page');

  if (homePage) {
    var setValueResult = function setValueResult(value) {
      if (!value.id) {
        return value.text;
      }

      var $value = $("\n      <div class=\"option__item\">\n        <span class=\"option__size\">".concat(value.element.dataset.size, "</span>\n        <span class=\"option__price\">").concat(value.element.dataset.price, "</span>\n    </div>"));
      return $value;
    };

    var initSwiper = function initSwiper() {
      var screenWidth = $(window).width();

      if (screenWidth < 1100 && mySwiper === null) {
        mySwiper = new Swiper('.how-it-works__swiper', {
          slidesPerView: 3,
          loop: true,
          pagination: {
            el: '.swiper-pagination',
            clickable: true
          },
          breakpoints: {
            600: {
              slidesPerView: "auto",
              spaceBetween: 10
            },
            900: {
              slidesPerView: 2,
              spaceBetween: 30
            }
          }
        });
      } else if (screenWidth >= 1100 && mySwiper !== null) {
        mySwiper.destroy();
        mySwiper = null;
        $('.swiper-wrapper').removeAttr('style');
        $('.swiper-slide').removeAttr('style');
      }
    };

    var renderCardList = function renderCardList(minValue, maxValue) {
      var cardList = document.querySelectorAll('.card');
      cardList.forEach(function (item) {
        var itemSqure = item.getAttribute('data-squre');

        if (itemSqure > maxValue || itemSqure < minValue) {
          item.classList.add('card--last');

          item.classList.remove('card--active');

        } else {
          if (item.getAttribute('data-variations-status') === 'disabled') {
            item.classList.add('card--last');

            item.classList.remove('card--active');

          } else {
            item.classList.remove('card--last');

            item.classList.add('card--active');

          }
        }
      });

      var activeCard = _toConsumableArray(document.querySelectorAll('.card--active')).sort(compareSqure);

      var disabledCard = _toConsumableArray(document.querySelectorAll('.card--last')).sort(compareSqure);

      var filteredCardList = [].concat(_toConsumableArray(activeCard), _toConsumableArray(disabledCard));
      var slidesWrapper = document.querySelectorAll('.choose-unit__card-wrapper .swiper-slide');
      filteredCardList.forEach(function (item, index) {
        slidesWrapper[index].appendChild(item);
      });
    };

    var compareSqure = function compareSqure(firstItem, secondItem) {
      return Number(firstItem.dataset.squre) - Number(secondItem.dataset.squre);
    }; //init card slider if card more then 4 or mobile version


    var initSwiperCard = function initSwiperCard() {
      var screenWidth = $(window).width();

      if (screenWidth < desktopWidth && mySwiperCard === null || mySwiperCard === null && cardItems.length > maxCard) {
        mySwiperCard = new Swiper('.choose-unit__card-wrapper', {
          slidesPerView: 4,
          spaceBetween: 20,
          pagination: {
            el: '.swiper-pagination-card',
            clickable: true
          },
          navigation: {
            nextEl: '.swiper-next',
            prevEl: '.swiper-prev'
          },
          breakpoints: {
            600: {
              slidesPerView: 'auto',
              spaceBetween: 10
            },
            850: {
              slidesPerView: 2,
              spaceBetween: 10
            },
            1150: {
              slidesPerView: 3,
              spaceBetween: 20
            }
          }
        });
        $('.swiper-pagination-card').show();
      } else if (screenWidth >= desktopWidth && mySwiperCard !== null && cardItems.length <= maxCard) {
        mySwiperCard.destroy();
        mySwiperCard = null;
        $('.swiper-wrapper').removeAttr('style');
        $('.swiper-slide').removeClass('.swiper-slide');
        $('.swiper-pagination-card').hide();
        $('.swiper-prev').hide();
      }

      if (screenWidth >= desktopWidth && cardItems.length <= maxCard) {
        $('.swiper-prev').hide();
        $('.swiper-next').hide();
      }
    };


    $('.js-select').select2({
      placeholder: 'Storlek',
      minimumResultsForSearch: -1,
      width: '100%',
      templateResult: setValueResult,
      templateSelection: setValueResult
    });
    var mySwiper = null;
    initSwiper();
    $(window).on('resize', function () {
      initSwiper();
    }); //range slider

    var slider_min_square = parseFloat($('#slider').data('min_square'));
    var slider_max_square = parseFloat($('#slider').data('max_square'));

    $('#slider').slider({
      range: "max",
      min: slider_min_square,
      max: slider_max_square,
      step: 1,
      value: slider_min_square,
      slide: function slide(event, ui) {
        $('.ui-slider-handle:eq(0) .range-square-min').html(ui.value + ' m' + '<sup>2</sup>');
      },
      change: function change(event, ui) {
        minSliderValue = ui.value;
        maxSliderValue = slider_max_square;
        renderCardList(minSliderValue, maxSliderValue);
      }
    }); // add to slider square value

    $('.ui-slider-handle:eq(0)').append('<span class="range-square-min value">' + $('#slider').slider('values', 0) + ' m<sup>2</sup></span>');
    var minSliderValue = $('#slider').slider('values', 1);
    var maxSliderValue = slider_max_square;
    renderCardList(minSliderValue, maxSliderValue);
    var mySwiperCard = null;
    var desktopWidth = 1200; // desktopWidth when init slider

    var maxCard = 4;
    var cardItems = document.querySelectorAll('.card');
    initSwiperCard();
    $(window).on('resize', function () {
      initSwiperCard();
    }); // init slider for feature section if mobile version

  }
});
"use strict";

jQuery(document).ready(function ($) {
// desktopWidth when init slider
  if($('section').hasClass('features')){

    var initSwiperFeature = function initSwiperFeature() {
      var screenWidth = $(window).width();

      if (screenWidth < desktopWidthFeatureSection && mySwiperCardFeature === null) {
        mySwiperCardFeature = new Swiper('.features', {
          slidesPerView: 3,
          spaceBetween: 20,
          autoplay: {
            delay: 3000
          },
          loop: true,
          breakpoints: {
            365: {
              slidesPerView: 1,
              spaceBetween: 20
            },
            600: {
              slidesPerView: 2,
              spaceBetween: 20
            }
          }
        });
      } else if (screenWidth >= desktopWidthFeatureSection && mySwiperCardFeature) {
        mySwiperCardFeature.destroy();
        mySwiperCardFeature = null;
      }
    };
    var mySwiperCardFeature = null;
    var desktopWidthFeatureSection = 720;
    initSwiperFeature();
    $(window).on('resize', function () {
      initSwiperFeature();
    });
  }

});
jQuery(document).ready(function ($) {
  function validateNumber(inputValue, maxValue) {
    var phoneNumber = inputValue.split('').filter(function (item) {
      return Number(item);
    });

    if (phoneNumber.length < maxValue) {
      return false;
    } else {
      return true;
    }
  }

  function addErrorMassage(inputElement, maxValue) {
    var isValid = validateNumber(inputElement.value, maxValue);

    if (inputElement.parentElement.classList.contains('error')) {
      inputElement.parentElement.classList.remove('error');
    }

    if (!isValid) {
      inputElement.parentElement.classList.add('error');
      inputElement.addEventListener('input', function () {
        isValid = validateNumber(inputElement.value, maxValue);

        if (inputElement.parentElement.classList.contains('error') && isValid) {
          inputElement.parentElement.classList.remove('error');
        }
      });
    }
  }

  var mobileMenuButton = document.querySelector('.header__mobile-menu');
  var bodyElement = document.querySelector('body');

  if (mobileMenuButton) {
    mobileMenuButton.addEventListener('click', function (event) {
      bodyElement.classList.toggle('mobile-menu-open');
    });
  } //modal window


  var loginButton = document.querySelectorAll('.login');
  var modalWindow = document.querySelector('.modal');
  var closeModalButton = document.querySelector('.modal__close');
  var modalWindowForm = document.querySelector('.modal form');
  var modalInput = document.querySelector('.modal__input');
  var maxDigitsBankId = 12;

  if (modalWindow) {
    loginButton.forEach(function (item) {
      item.addEventListener('click', function (event) {
        event.preventDefault();
        modalWindow.classList.add('open');

        if (bodyElement.classList.contains('mobile-menu-open')) {
          bodyElement.classList.remove('mobile-menu-open');
        }
      });
    });
    var escKey = 27;
    window.addEventListener('keydown', function (evt) {
      if (evt.keyCode === escKey) {
        evt.preventDefault;

        if (modalWindow.classList.contains('open')) {
          modalWindow.classList.remove('open');
        }
      }
    });
    closeModalButton.addEventListener('click', function () {
      modalWindow.classList.remove('open');
    });
    modalWindow.addEventListener('click', function (event) {
      if (event.target === modalWindow) {
        modalWindow.classList.remove('open');
      }
    });
    $('.modal__input').mask('999999999999').attr('minlength', '12');
  } // phone number mask 


  var phoneNumberInput = document.querySelector('.input-phone');
  var maxDigitsPhoneNumber = 11;

  if (phoneNumberInput) {
    document.querySelector('.call-request form').addEventListener('submit', function (event) {
      event.preventDefault();
      addErrorMassage(phoneNumberInput, maxDigitsPhoneNumber);
    });
  }
});
"use strict";

jQuery(document).ready(function ($) {
  var storagePage = document.querySelector('.our-storages');

  if (storagePage) {
    var desktopWidth = 1133; // desktopWidth when init slider

    var renderProductList = function renderProductList(minValue, maxValue) {
      var cardList = document.querySelectorAll('.card');
      console.log(minValue, maxValue);
      cardList.forEach(function (item) {
        var itemSqure = item.getAttribute('data-squre');
        if (itemSqure > maxValue || itemSqure < minValue) {
          item.classList.add('card--last');
          // item.classList.add('card--disabled');
          item.parentElement.classList.add('move_down');

          item.classList.remove('card--active');

        } else {
          item.classList.remove('card--last');
          // item.classList.remove('card--disabled');
          item.parentElement.classList.remove('move_down');
          item.classList.add('card--active');

        }
      });
    };

    var slider_min_square = parseFloat($('#slider').data('min_square'));
    var slider_max_square = parseFloat($('#slider').data('max_square'));
    $('#slider').slider({
      range: "max",
      min: slider_min_square,
      max: slider_max_square,
      step: 1,
      value: slider_min_square,
      slide: function slide(event, ui) {
        console.log(ui);
        $('.ui-slider-handle:eq(0) .range-square-min').html(ui.value + ' m' + '<sup>2</sup>');
      },
      change: function change(event, ui) {
        minSliderValue = ui.value;
        maxSliderValue = slider_max_square;
        renderProductList(minSliderValue, maxSliderValue);
      }
    }); // add to slider square value

    $('.ui-slider-handle:eq(0)').append('<span class="range-square-min value">' + $('#slider').slider('values', 0) + ' m<sup>2</sup></span>');

    var minSliderValue = $('#slider').slider('values', 1);
    var maxSliderValue = slider_max_square;
    renderProductList(minSliderValue, maxSliderValue);

    let mySwiperStorageCard = null;

    // desktopWidth when init slider
    function initSwiperStorageCard() {
      var screenWidth = $(window).width();
      if (screenWidth < desktopWidth && mySwiperStorageCard === null) {
        mySwiperStorageCard = new Swiper('.storage__card-list', {
          slidesPerView: 3,
          spaceBetween: 20,
          pagination: {
            el: '.storage__swiper-pagination',
            clickable: true
          },
          breakpoints: {
            900: {
              slidesPerView: 2,
            },
            600: {
              slidesPerView: 'auto'
            }
          }
        });
      } else if (screenWidth >= desktopWidth && mySwiperStorageCard !== null) {
        mySwiperStorageCard.destroy();
        mySwiperStorageCard = null;
        $('.swiper-wrapper').removeAttr('style');
        $('.swiper-slide').removeClass('.swiper-slide');
      }
    };

    var galleryTop = new Swiper('.storage__main-image', {
      spaceBetween: 10,
      slidesPerView: 1,

      autoplay: {
        delay: 1500,
        disableOnInteraction: false,
      },

      loop: true,
      
      navigation: {
        nextEl: '.swiper-next',
        prevEl: '.swiper-prev',
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true
      },
      breakpoints: {
        767: {
          slidesPerView: 2,
        }
      }
    });

    initSwiperStorageCard();

    $(window).on('resize', function () {
      initSwiperStorageCard();
    });

    galleryTop.on('slideChange', function () {
      $('.swiper-pagination-bullet').removeClass('videoProgress')
      setTimeout(function(){
        if($('.storage__main-image .swiper-slide-active video').length > 0) {
        $('.swiper-pagination-bullet-active').addClass('videoProgress');
        $('.storage__main-image .swiper-slide-active').attr('data-swiper-autoplay','3000');
        }
      },5)
    });
    
  }
});
"use strict";

// support page
jQuery(document).ready(function ($) {
  function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

    if (filter.test(sEmail)) {
      return true;
    } else {
      return false;
    }
  }

  var supportPage = document.querySelector('.support-page');

  if (supportPage) {
    var dropdown = document.querySelector('.faq__category-title');
    var dropdownTitleText = document.querySelector('.faq__category-text');
    var categoriItem = document.querySelectorAll('.faq__category-item');
    var tabItems = document.querySelectorAll('.faq__answer-wrapper');
    dropdown.addEventListener('click', function () {
      this.classList.toggle('faq__category-title--open');
    });
    categoriItem.forEach(function (item) {
      item.addEventListener('click', function () {
        categoriItem.forEach(function (elem) {
          elem.classList.remove('faq__category-item--active');
        });
        tabItems.forEach(function (item) {
          item.classList.remove('show');
        });
        var index = item.getAttribute('data-category');
        document.querySelector('[data-tab="' + index + '"]').classList.add('show');
        item.classList.add('faq__category-item--active');
        var text = item.textContent;
        dropdownTitleText.textContent = text;
      });
    });
    var faqPanels = document.querySelectorAll('.faq__item');
    var prevItem;

    if (faqPanels) {
      faqPanels.forEach(function (item, index) {
        item.addEventListener('click', function (event) {
          var faqPanelsItemOpen = document.querySelector('.faq__item.faq__item--open');

          if (faqPanelsItemOpen && prevItem !== index) {
            faqPanelsItemOpen.classList.remove('faq__item--open');
            faqPanelsItemOpen.querySelector('.faq__description').style.maxHeight = null;
          }

          this.classList.toggle('faq__item--open');
          var panel = this.querySelector('.faq__description');

          if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
          } else {
            panel.style.maxHeight = panel.scrollHeight + 'px';
          }

          prevItem = index;
        });
      });
    } // contact form


    var contactForm = document.querySelector('.contact-us__form');
    var contactEmail = document.querySelector("[name='contact-us-email']");
    contactForm.addEventListener('submit', function (event) {
      event.preventDefault();
      var emailValid = validateEmail(contactEmail.value);

      if (contactEmail.parentNode.classList.contains('error')) {
        contactEmail.parentNode.classList.remove('error');
      }

      if (!emailValid) {
        contactEmail.parentNode.classList.add('error');
      }
    });
  }
});

var landingPage = document.querySelector('.landing');
if (landingPage) {

  var videoPlayButton = document.querySelector('.landing-hero__video-button');
  var video = document.querySelector('.landing-hero__video');
  var videoWrapper = document.querySelector('.landing-hero__video-container');

  videoPlayButton.addEventListener('click', function (e) {
    video.play();
    videoWrapper.classList.add('play');
  })

  video.addEventListener('click', function (e) {
    e.preventDefault();

    if (video.paused !== true) {
      video.pause();
      videoWrapper.classList.remove('play');
      return
    }
  })

  video.addEventListener('ended', function () {
    videoWrapper.classList.remove('play');
  })

  jQuery(document).ready(function ($) {
    var stickyOffset = $('.landing-header').offset().top;
    if ($(window).width() > 992) {
      $(window).scroll(function () {
        var sticky = $('.landing-header'),
            scroll = $(window).scrollTop();

        if (scroll >= 90) $('body').addClass('fixed');
        else $('body').removeClass('fixed');
      });
    }

    $('.landing-header__btn').on('click', function () {
      $("html").animate({
        scrollTop: $('.landing-call').offset().top - 200
      }, 1000);
    });

    $('.landing-call__btn').on('click', function () {
      $(this).parent().addClass('hidden');
      $('.landing-call__message').removeClass('hidden');
    })
  })

} else {
  jQuery(document).ready(function ($) {
    $('.input-phone, .phone-number, .booking__input.number').blur(function(event) {
      var regular_phone = /^(07)(\d{8})$/,
          validate_phone = regular_phone.test($(this).val());
      if(!validate_phone && $(this).val().length > 0){
        $(this).parent().addClass('error_input_number');
        if(!$(this).next().hasClass('error-message')){
          $(this).parent().append('<span class="error-message">TELEFONNUMMER SKA ANGES I FORMATET 07XXXXXXXX</span>');
          $(this).closest('form').find('.btn').attr('disabled', 'disabled');
        }
      }else{
        $(this).parent().removeClass('error_input_number').find('.error-message').remove();
        $(this).closest('form').find('.btn').removeAttr('disabled');
      }
    });
  });
}

jQuery(document).ready(function ($) {
  $('#landing_call_btn').on('click', function (e) {
    e.preventDefault();
    var data = {
      action: 'landing-phone',
      phone: $('.phone-number-not-validation').val()
    };

    $.ajax({
      url: '/wp-admin/admin-ajax.php',
      type: 'POST',
      data: data,
      success: function (responce) {
        console.log('success');
      }
    });
  });


  $(".booking-final__button").on('click', function(event) {
    $("#billing_phone").val($("#billing_phone").val().replace(/[\ ,-]+/g, "").replace("+46", "0"));
    $.ajax({
      type: 'POST',
      url: kco_params.update_cart_url,
      data: {
        checkout: $( 'form.checkout' ).serialize(),
        nonce: kco_params.update_cart_nonce
      },
      dataType: 'json',
      success: function( data ) {
      },
      error: function( data ) {
      },
      complete: function( data ) {
        $( 'body' ).trigger( 'update_checkout' );
      }
    });
  });

  $(".card__block-more").click(function(event) {
    $(this).closest('.card').toggleClass('show_info');
  });
  $('.js-select-category').select2({
    minimumResultsForSearch: -1,
    width: '100%',
  });
  $(".info_about_plant-header").click(function(event) {
    $(this).closest('.info_about_plant').toggleClass('show_info_about_plant');
  });

});
