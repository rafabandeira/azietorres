/**
 * Theme Specific Script Initialization
 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    // 1. Team Swiper Initialization
    if (document.querySelector('.mySwiper')) {
      new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 30,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        loop: true,
        autoplay: {
          delay: 2500,
          disableOnInteraction: false,
        },
        breakpoints: {
          320: { slidesPerView: 1 },
          768: { slidesPerView: 2 },
          1024: { slidesPerView: 4 }
        }
      });
    }

    // 2. Newsletter Form Submission
    const nlForm = document.getElementById('newsletter-form');
    if (nlForm && typeof themeData !== 'undefined') {
      nlForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const email = document.getElementById('newsletter-email').value;
        const responseDiv = document.getElementById('newsletter-response');
        
        responseDiv.style.display = 'block';
        responseDiv.innerHTML = 'Enviando...';
        responseDiv.style.color = '#fff';

        const formData = new FormData();
        formData.append('action', 'subscribe_newsletter');
        formData.append('email', email);
        formData.append('security', themeData.newsletter_nonce);

        fetch(themeData.ajax_url, {
          method: 'POST',
          body: formData
        })
          .then(res => res.json())
          .then(data => {
            responseDiv.innerHTML = data.data.message;
            if (data.success) {
              nlForm.reset();
            } else {
              responseDiv.style.color = '#ff9999';
            }
          })
          .catch(err => {
            responseDiv.innerHTML = 'Erro ao enviar. Tente novamente.';
            responseDiv.style.color = '#ff9999';
          });
      });
    }
  });
})();
