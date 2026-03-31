/* ── Slider ── */
let current = 0;
const slides = document.querySelectorAll('.slide');
const dots   = document.querySelectorAll('.dot');

function goToSlide(n) {
  slides[current].classList.remove('active');
  dots[current] && dots[current].classList.remove('active');
  current = (n + slides.length) % slides.length;
  slides[current].classList.add('active');
  dots[current] && dots[current].classList.add('active');
  updateMobileText();
}

function changeSlide(dir) { goToSlide(current + dir); }

function updateMobileText() {
  const s = slides[current];
  const title = s.dataset.title;
  const desc  = s.dataset.desc;
  const url   = s.dataset.url;
  // above slider
  document.getElementById('mob-title').textContent = title;
  document.getElementById('mob-desc').textContent  = desc;
  // below slider
  document.getElementById('mob-footer-title').textContent = title;
  document.getElementById('mob-footer-desc').textContent  = desc;
  const link = document.getElementById('mob-footer-link');
  if (link) link.href = url;
  syncSpacer();
}

setInterval(() => changeSlide(1), 5500);
