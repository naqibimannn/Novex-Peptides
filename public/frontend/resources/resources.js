function updateResourcesHeroBanner() {
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;

  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const targetUrl = isPortraitOrSmall
    ? (heroImg.getAttribute('data-phone') || (window.NVX_RESOURCES && window.NVX_RESOURCES.heroPhone))
    : (heroImg.getAttribute('data-desktop') || (window.NVX_RESOURCES && window.NVX_RESOURCES.heroDesktop));

  if (targetUrl) {
    if (heroImg.getAttribute('src') !== targetUrl) {
      heroImg.setAttribute('src', targetUrl);
    }
    if (heroImg.getAttribute('href') !== targetUrl) {
      heroImg.setAttribute('href', targetUrl);
    }
  }
}

const resourcesHeroMediaQuery = window.matchMedia('(orientation: portrait), (max-width: 768px)');
if (resourcesHeroMediaQuery.addEventListener) {
  resourcesHeroMediaQuery.addEventListener('change', updateResourcesHeroBanner);
} else if (resourcesHeroMediaQuery.addListener) {
  resourcesHeroMediaQuery.addListener(updateResourcesHeroBanner);
}

window.addEventListener('resize', updateResourcesHeroBanner);
document.addEventListener('DOMContentLoaded', updateResourcesHeroBanner);
updateResourcesHeroBanner();