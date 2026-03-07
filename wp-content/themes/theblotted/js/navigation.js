/* ── Spacer height ── */
function syncSpacer() {
  document.getElementById('header-spacer').style.height =
    document.getElementById('site-header').offsetHeight + 'px';
}
syncSpacer();
window.addEventListener('resize', syncSpacer);

/* ── Scroll hide / show header ── */
let lastScrollY = window.scrollY;
const header = document.getElementById('site-header');

window.addEventListener('scroll', function () {
  const currentScrollY = window.scrollY;

  if (currentScrollY <= 0) {
    // At the very top — always show
    header.classList.remove('hidden');
    header.classList.remove('scrolled');
  } else if (currentScrollY > lastScrollY + 4) {
    // Scrolling DOWN — hide
    header.classList.add('hidden');
    header.classList.add('scrolled');
    // Also close mobile menu if open
    document.getElementById('mobile-nav').classList.remove('open');
  } else if (currentScrollY < lastScrollY - 4) {
    // Scrolling UP — show
    header.classList.remove('hidden');
    header.classList.add('scrolled');
  }

  lastScrollY = currentScrollY;
});

/* ── Close mobile nav on scroll past threshold ── */
window.addEventListener('scroll', function () {
  if (window.scrollY > 40) {
    document.getElementById('mobile-nav').classList.remove('open');
    syncSpacer();
  }
}, { passive: true });

/* ── Hamburger toggle ── */
document.getElementById('hamburger-btn').addEventListener('click', function () {
  const nav = document.getElementById('mobile-nav');
  nav.classList.toggle('open');
  syncSpacer();
});
