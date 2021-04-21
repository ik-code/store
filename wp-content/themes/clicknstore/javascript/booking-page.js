jQuery(document).ready(function ($) {
  const bookingPage = document.querySelector('.booking-page');

  if (bookingPage) {
    const bookingTabNavs = document.querySelectorAll('.booking__nav-tabs-button');

    bookingTabNavs.forEach(function (item) {
      item.addEventListener('click', function (event) {
        event.preventDefault();
        const activeTabButton = document.querySelector('.booking__nav-tabs-button.booking__nav-tabs-button--active');
        activeTabButton.classList.remove('booking__nav-tabs-button--active');
        event.target.classList.add('booking__nav-tabs-button--active');

        const tabNumber = event.target.getAttribute('data-tab-button');

        const activeTabForm = document.querySelector('.booking__form.booking__form--show');
        activeTabForm.classList.remove('booking__form--show');

        document.querySelector(`[data-tab-form='${tabNumber}']`).classList.add('booking__form--show');
      });
    });

    // masks
    $('.bank-id').each(function (index, element) {
      console.log(element);
      $(element).mask('000000000000');
    })
    $('.phone-number').each(function (index, element) {
      $(element).mask('+46 000 000 000')
    })
  }

  function startTimer(duration, display) {
    let timer = duration,
      minutes,
      seconds;
    setInterval(function () {
      minutes = parseInt(timer / 60, 10);
      seconds = parseInt(timer % 60, 10);

      minutes = minutes < 10 ? '0' + minutes : minutes;
      seconds = seconds < 10 ? '0' + seconds : seconds;

      display.textContent = minutes + ' : ' + seconds;

      if (--timer < 0) {
        return false;
      }
    }, 1000);
  }

  const bookingFinalPage = document.querySelector('.booking-final-page');

  if (bookingFinalPage) {
    const thirtyMinutes = 60 * 30;
    const timerElement = document.querySelector('.booking-final__time');
    startTimer(thirtyMinutes, timerElement);

    const userInfoDropdowns = document.querySelectorAll('.booking-final__info-title, .booking-final__rent-info-title');

    userInfoDropdowns.forEach(function (item) {
      item.addEventListener('click', function () {
        this.parentNode.classList.toggle('open');

        const panel = this.parentNode;
        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + 'px';
        }
      });
    });

    function setValueResult(value) {
      if (!value.id) {
        return value.text;
      }
      var $value = $(`
      <div class="option__item">
        <span class="option__size">${value.element.dataset.value}</span>
        <span class="option__price">${value.element.dataset.price}</span>
    </div>`);
      return $value;
    }

    $('.booking-final__select-insurance').select2({
      placeholder: 'Välj värde i förråd',
      minimumResultsForSearch: -1,
      width: '100%',
      templateResult: setValueResult,
      templateSelection: setValueResult
    }).on('select2:open', function (e) {
      document.querySelector('.select2-dropdown').style.cssText = "max-width: 600px";
    });

    const discontForm = document.querySelector('.booking-final__discont');
    const discontInput = discontForm.querySelector('.booking-final__discont-input');
    const discontButton = document.querySelector('.booking-final__discont-button');
    const discontValue = document.querySelector('.booking-final__rent-info-block.booking-final__rent-info-block--discont');

    discontInput.addEventListener('input', function (event) {
      if (event.target.value && !discontButton.classList.contains('show')) {
        discontButton.classList.toggle('show');
      }
    });
    discontButton.addEventListener('click', function (event) {
      event.preventDefault();
      discontForm.classList.add('booking-final__discont--success');
      discontValue.classList.remove('booking-final__rent-info-block--discont');
    })
  }
});