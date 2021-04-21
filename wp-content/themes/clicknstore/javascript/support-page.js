// support page
jQuery(document).ready(function($) {
  function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
      return true;
    } else {
      return false;
    }
  }
  const supportPage = document.querySelector('.support-page');

  if (supportPage) {
    const dropdown = document.querySelector('.faq__category-title');
    const dropdownTitleText = document.querySelector('.faq__category-text');
    const categoriItem = document.querySelectorAll('.faq__category-item');
    const tabItems = document.querySelectorAll('.faq__answer-wrapper');

    dropdown.addEventListener('click', function() {
      this.classList.toggle('faq__category-title--open');
    });

    categoriItem.forEach(function(item) {
      item.addEventListener('click', function() {
        categoriItem.forEach(function(elem) {
          elem.classList.remove('faq__category-item--active');
        });
        tabItems.forEach(function(item) {
          item.classList.remove('show');
        });
        let index = item.getAttribute('data-category');
        document.querySelector('[data-tab="' + index + '"]').classList.add('show');

        item.classList.add('faq__category-item--active');

        let text = item.textContent;
        dropdownTitleText.textContent = text;
      });
    });

    const faqPanels = document.querySelectorAll('.faq__item');
    let prevItem;
    if (faqPanels) {
      faqPanels.forEach(function(item, index) {
        item.addEventListener('click', function(event) {
          const faqPanelsItemOpen = document.querySelector('.faq__item.faq__item--open');
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
    }

    // contact form

    const contactForm = document.querySelector('.contact-us__form');
    const contactEmail = document.querySelector(`[name='contact-us-email']`);

    contactForm.addEventListener('submit', function(event) {
      event.preventDefault();
      let emailValid = validateEmail(contactEmail.value);

      if (contactEmail.parentNode.classList.contains('error')) {
        contactEmail.parentNode.classList.remove('error');
      }
      if (!emailValid) {
        contactEmail.parentNode.classList.add('error');
      }
    });
  }
});
