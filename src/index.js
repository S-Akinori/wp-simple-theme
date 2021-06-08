import "./style.scss";
import "bootstrap";
// import '@fortawesome/fontawesome-free/js/fontawesome';
// import '@fortawesome/fontawesome-free/js/solid';
// import '@fortawesome/fontawesome-free/js/regular';
import "./prism-js/prism.js";
import "./js/navigation.js";

import Swiper from "./swiperjs/swiper-bundle.min.js";

Prism.plugins.NormalizeWhitespace.setDefaults({
	'remove-trailing': true,
	'remove-indent': true,
	'left-trim': true,
	'right-trim': true,
    // 'break-lines': 80,
	// 'indent': 2,
	// 'remove-initial-line-feed': false,
	// 'tabs-to-spaces': 4,
	// 'spaces-to-tabs': 4
});

const swiper = new Swiper('.swiper-container', {
    // Optional parameters
    direction: 'horizontal',
    slidesPerView: 3,
    spaceBetween: 30,
    freeMode: true,
    loop: true,
    loopFillGroupWithBlank: true,


    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },

    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
});