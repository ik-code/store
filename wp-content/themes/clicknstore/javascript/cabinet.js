const cabinetPage = document.querySelector('.cabinet-page');

if (cabinetPage) {
  const cabinetDropdown = document.querySelector('.cabinet__tabs-title');
  const cabinetTabtButton = document.querySelectorAll('.cabinet__tabs-item');
  const dropdownTitleText = document.querySelector('.cabinet__tabs-title-text');
  cabinetDropdown.addEventListener('click', function (event) {
    event.target.parentNode.classList.toggle('open');
  });


  cabinetTabtButton.forEach(function (item) {
    item.addEventListener('click', function () {
      document.querySelector('.cabinet__tabs-item.cabinet__tabs-item--active').classList.remove('cabinet__tabs-item--active');
      document.querySelector('.data-tab.show').classList.remove('show');
      item.classList.add('cabinet__tabs-item--active');

      let index = item.getAttribute('data-cabinet-link');
      document.querySelector('[data-cabinet-tab="' + index + '"]').classList.add('show');

      let text = item.textContent;
      dropdownTitleText.textContent = text;
      item.parentNode.parentNode.classList.remove('open');
    });
  });

  // phone mask

  $('.phone-number').mask('+46 000 000 000');

  //postcode mask

  $('.postcode').mask('00000');
}