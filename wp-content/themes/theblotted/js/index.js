const swiper = new Swiper(".home.swiper", {
    loop: true,
    autoplay: {
        delay: 30000,
        disableOnInteraction: false,
    },
    effect: "fade",
    fadeEffect: { crossFade: true },

    navigation: {
        nextEl: ".next-btn",
        prevEl: ".prev-btn",
    },

    pagination: {
        el: ".navigation",
        clickable: true,
    },
});
