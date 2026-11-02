function updateScienceHeroBanner() {
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;

  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const targetUrl = isPortraitOrSmall
    ? (heroImg.getAttribute('data-phone') || (window.NVX_SCIENCE && window.NVX_SCIENCE.heroPhone))
    : (heroImg.getAttribute('data-desktop') || (window.NVX_SCIENCE && window.NVX_SCIENCE.heroDesktop));

  if (targetUrl) {
    if (heroImg.getAttribute('src') !== targetUrl) {
      heroImg.setAttribute('src', targetUrl);
    }
    if (heroImg.getAttribute('href') !== targetUrl) {
      heroImg.setAttribute('href', targetUrl);
    }
  }
}

const heroMediaQuery = window.matchMedia('(orientation: portrait), (max-width: 768px)');
if (heroMediaQuery.addEventListener) {
  heroMediaQuery.addEventListener('change', updateScienceHeroBanner);
} else if (heroMediaQuery.addListener) {
  heroMediaQuery.addListener(updateScienceHeroBanner);
}

window.addEventListener('resize', updateScienceHeroBanner);
document.addEventListener('DOMContentLoaded', updateScienceHeroBanner);
updateScienceHeroBanner();