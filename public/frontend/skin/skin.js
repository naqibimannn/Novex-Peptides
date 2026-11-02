function updateSkinHeroBanner() {
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;

  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const targetUrl = isPortraitOrSmall
    ? (heroImg.getAttribute('data-phone') || (window.NVX_SKIN && window.NVX_SKIN.heroPhone))
    : (heroImg.getAttribute('data-desktop') || (window.NVX_SKIN && window.NVX_SKIN.heroDesktop));

  if (targetUrl) {
    if (heroImg.getAttribute('src') !== targetUrl) {
      heroImg.setAttribute('src', targetUrl);
    }
    if (heroImg.getAttribute('href') !== targetUrl) {
      heroImg.setAttribute('href', targetUrl);
    }
  }
}

const skinHeroMediaQuery = window.matchMedia('(orientation: portrait), (max-width: 768px)');
if (skinHeroMediaQuery.addEventListener) {
  skinHeroMediaQuery.addEventListener('change', updateSkinHeroBanner);
} else if (skinHeroMediaQuery.addListener) {
  skinHeroMediaQuery.addListener(updateSkinHeroBanner);
}

window.addEventListener('resize', updateSkinHeroBanner);
document.addEventListener('DOMContentLoaded', updateSkinHeroBanner);
updateSkinHeroBanner();