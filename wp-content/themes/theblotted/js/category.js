function syncSpacer() {
  document.getElementById('header-spacer').style.height =
    document.getElementById('site-header').offsetHeight + 'px';
}
syncSpacer();
window.addEventListener('resize', syncSpacer);
let lastY = 0;
window.addEventListener('scroll', () => {
  const y = window.scrollY, h = document.getElementById('site-header');
  if (y > lastY + 4) h.classList.add('hidden');
  else if (y < lastY - 4) h.classList.remove('hidden');
  h.classList.toggle('scrolled', y > 10);
  lastY = y;
}, { passive: true });
function toggleNav() {
  document.getElementById('mobile-nav').classList.toggle('open');
  syncSpacer();
}
window.addEventListener('scroll', () => {
  if (window.scrollY > 40) { document.getElementById('mobile-nav').classList.remove('open'); syncSpacer(); }
}, { passive: true });
