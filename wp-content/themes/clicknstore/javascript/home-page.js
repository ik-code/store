jQuery(document).ready(function ($) {
  const homePage = document.querySelector('.home-page');

  if (homePage) {
    function setValueResult(value) {
      if (!value.id) {
        return value.text;
      }
      var $value = $(`
      <div class="option__item">
        <span class="option__size">${value.element.dataset.size}</span>
        <span class="option__price">${value.element.dataset.price}</span>
    </div>`);
      return $value;
    }

    $('.js-select').select2({
      placeholder: 'Storlek',
      minimumResultsForSearch: -1,
      width: '100%',
      templateResult: setValueResult,
      templateSelection: setValueResult
    });

    let mySwiper = null;

    function initSwiper() {
      let screenWidth = $(window).width();
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
    }

    initSwiper();

    $(window).on('resize', function () {
      initSwiper();
    });

    //range slider

    $('#slider').slider({
      range: true,
      min: 9,
      max: 52,
      values: [9, 30],
      slide: function (event, ui) {
        $('.ui-slider-handle:eq(0) .range-square-min').html(ui.values[0] + ' m' + '<sup>2</sup>');
        $('.ui-slider-handle:eq(1) .range-square-max').html(ui.values[1] + ' m' + '<sup>2</sup>');
      },
      change: function (event, ui) {
        minSliderValue = ui.values[0];
        maxSliderValue = ui.values[1];

        renderCardList(minSliderValue, maxSliderValue);
      }
    });

    // add to slider square value
    $('.ui-slider-handle:eq(0)').append('<span class="range-square-min value">' + $('#slider').slider('values', 0) + ' m<sup>2</sup></span>');
    $('.ui-slider-handle:eq(1)').append('<span class="range-square-max value">' + $('#slider').slider('values', 1) + ' m<sup>2</sup></span>');

    function renderCardList(minValue, maxValue) {
      const cardList = document.querySelectorAll('.card');

      cardList.forEach(function (item) {
        const itemSqure = item.getAttribute('data-squre');

        if (itemSqure > maxValue || itemSqure < minValue) {
          item.classList.add('card--disabled');
          item.classList.remove('card--active');
        } else {
          item.classList.remove('card--disabled');
          item.classList.add('card--active');
        }
      });

      const activeCard = [...document.querySelectorAll('.card--active')].sort(compareSqure);

      const disabledCard = [...document.querySelectorAll('.card--disabled')].sort(compareSqure);

      let filteredCardList = [...activeCard, ...disabledCard];

      const slidesWrapper = document.querySelectorAll('.choose-unit__card-wrapper .swiper-slide');

      filteredCardList.forEach((item, index) => {
        slidesWrapper[index].appendChild(item);
      });
    }

    let minSliderValue = $('#slider').slider('values', 0);
    let maxSliderValue = $('#slider').slider('values', 1);

    renderCardList(minSliderValue, maxSliderValue);

    function compareSqure(firstItem, secondItem) {
      return Number(firstItem.dataset.squre) - Number(secondItem.dataset.squre);
    }

    //init card slider if card more then 4 or mobile version

    let mySwiperCard = null;
    let desktopWidth = 1200; // desktopWidth when init slider
    let maxCard = 4;
    const cardItems = document.querySelectorAll('.card');

    function initSwiperCard() {
      let screenWidth = $(window).width();
      if ((screenWidth < desktopWidth && mySwiperCard === null) || (mySwiperCard === null && cardItems.length > maxCard)) {
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

    }
    initSwiperCard();

    $(window).on('resize', function () {
      initSwiperCard();
    });

    // init slider for feature section if mobile version

    let mySwiperCardFeature = null;
    let desktopWidthFeatureSection = 720; // desktopWidth when init slider

    function initSwiperFeature() {
      let screenWidth = $(window).width();
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
    }
    initSwiperFeature();
    $(window).on('resize', function () {
      initSwiperFeature();
    });
  }
});