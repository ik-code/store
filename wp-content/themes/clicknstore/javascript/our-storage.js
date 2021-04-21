jQuery(document).ready(function ($) {
  const storagePage = document.querySelector('.our-storages');

  if (storagePage) {
    const galleryImages = document.querySelectorAll('.storage__gallery-slide');
    const mainImage = document.querySelector('.storage__main-image img');

    galleryImages.forEach(function (image) {
      image.addEventListener('click', function () {
        const newImageUrl = this.querySelector('img').getAttribute('src');
        const previoslyImageUrl = mainImage.getAttribute('src');

        this.querySelector('img').setAttribute('src', `${previoslyImageUrl}`);
        mainImage.setAttribute('src', newImageUrl);
      });
    })

    let mySwiperStorage = null;
    let desktopWidth = 992; // desktopWidth when init slider

    function initSwiperCard() {
      let screenWidth = $(window).width();
      if (screenWidth < desktopWidth && mySwiperStorage === null) {
        mySwiperStorage = new Swiper('.storage__card-list', {
          slidesPerView: 2,
          spaceBetween: 20,
          pagination: {
            el: '.storage__swiper-pagination',
            clickable: true
          },
          breakpoints: {
            600: {
              slidesPerView: 'auto'
            }
          }
        });
      } else if (screenWidth >= desktopWidth && mySwiperStorage !== null) {
        mySwiperStorage.destroy();
        mySwiperStorage = null;
        $('.swiper-wrapper').removeAttr('style');
        $('.swiper-slide').removeClass('.swiper-slide');
      }

    }
    initSwiperCard();

    $(window).on('resize', function () {
      initSwiperCard();
    });

    const swiperGallety = new Swiper('.storage__gallery-thumbs', {
      slidesPerView: 'auto',
      navigation: {
        nextEl: '.swiper-next',
        prevEl: '.swiper-prev',
      },
    });

  }
});