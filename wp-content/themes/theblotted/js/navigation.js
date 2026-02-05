// document.addEventListener('DOMContentLoaded', () => {
//     const mainMenu = document.querySelector("#open1");
//     const openMenu = document.querySelector("#openMenu");
//     const closeMenu = document.querySelector("#closeMenu");

//     openMenu.addEventListener('click', show);
//     closeMenu.addEventListener('click', hide);

//     function show() {
//         mainMenu.classList.add('menu-visible'); // Show menu
//         openMenu.style.display = 'none';
//         closeMenu.style.display = 'block';
//     }

//     function hide() {
//         mainMenu.classList.remove('menu-visible'); // Hide menu
//         openMenu.style.display = 'block';
//         closeMenu.style.display = 'none';
//     }

//     // Scroll event for logo swap (optional if you use logos)
//     window.addEventListener('scroll', function () {
//         const scrollY = window.scrollY;
//         const firstIcon = document.getElementById('first-icon');
//         const secondIcon = document.getElementById('second-icon');

//         if (!firstIcon || !secondIcon) return;

//         if (scrollY > 100) {
//             firstIcon.style.display = 'none';
//             secondIcon.style.display = 'inline-block';
//         } else {
//             firstIcon.style.display = 'inline-block';
//             secondIcon.style.display = 'none';
//         }
//     });
// });

document.addEventListener('DOMContentLoaded', () => {
    const mainMenu = document.querySelector("#open1");
    const openMenu = document.querySelector("#openMenu");
    const closeMenu = document.querySelector("#closeMenu");
    const header = document.querySelector("header"); // 👈 add this

    openMenu.addEventListener('click', show);
    closeMenu.addEventListener('click', hide);

    function show() {
        mainMenu.classList.add('menu-visible');
        header.classList.add('menu-open'); // 👈 add background
        openMenu.style.display = 'none';
        closeMenu.style.display = 'block';
    }

    function hide() {
        mainMenu.classList.remove('menu-visible');
        header.classList.remove('menu-open'); // 👈 remove background
        openMenu.style.display = 'block';
        closeMenu.style.display = 'none';
    }

    // Scroll event (unchanged)
    window.addEventListener('scroll', function () {
        const scrollY = window.scrollY;
        const firstIcon = document.getElementById('first-icon');
        const secondIcon = document.getElementById('second-icon');

        if (!firstIcon || !secondIcon) return;

        if (scrollY > 100) {
            firstIcon.style.display = 'none';
            secondIcon.style.display = 'inline-block';
        } else {
            firstIcon.style.display = 'inline-block';
            secondIcon.style.display = 'none';
        }
    });
});
