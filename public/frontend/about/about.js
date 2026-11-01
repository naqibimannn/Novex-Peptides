function updateAboutHeroBanner(){
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;

  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const targetUrl = isPortraitOrSmall
    ? (heroImg.getAttribute('data-phone') || (window.NVX_ABOUT && window.NVX_ABOUT.heroPhone))
    : (heroImg.getAttribute('data-desktop') || (window.NVX_ABOUT && window.NVX_ABOUT.heroDesktop));

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
  heroMediaQuery.addEventListener('change', updateAboutHeroBanner);
} else if (heroMediaQuery.addListener) {
  heroMediaQuery.addListener(updateAboutHeroBanner);
}
window.addEventListener('resize', updateAboutHeroBanner);
document.addEventListener('DOMContentLoaded', updateAboutHeroBanner);
updateAboutHeroBanner();