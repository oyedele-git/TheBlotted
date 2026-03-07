/* ── Header spacer ── */
function syncSpacer() {
  document.getElementById('header-spacer').style.height =
    document.getElementById('site-header').offsetHeight + 'px';
}
syncSpacer();
window.addEventListener('resize', syncSpacer);

/* ── Scroll hide / show + shadow ── */
let lastY = 0;
window.addEventListener('scroll', () => {
  const y = window.scrollY;
  const header = document.getElementById('site-header');
  if (y > lastY + 4)      header.classList.add('hidden');
  else if (y < lastY - 4) header.classList.remove('hidden');
  header.classList.toggle('scrolled', y > 10);
  lastY = y;
}, { passive: true });

/* ── Mobile nav toggle ── */
function toggleNav() {
  const nav = document.getElementById('mobile-nav');
  nav.classList.toggle('open');
  syncSpacer();
}
window.addEventListener('scroll', () => {
  if (window.scrollY > 40) {
    document.getElementById('mobile-nav').classList.remove('open');
    syncSpacer();
  }
}, { passive: true });

/* ── Copy link ── */
function copyLink(e) {
  e.preventDefault();
  navigator.clipboard.writeText(window.location.href).then(() => {
    const btn = e.currentTarget;
    const original = btn.innerHTML;
    btn.innerHTML = btn.tagName === 'BUTTON'
      ? btn.innerHTML.replace(/Copy Link/, 'Copied!')
      : '✓';
    setTimeout(() => { btn.innerHTML = original; }, 2000);
  });
}
