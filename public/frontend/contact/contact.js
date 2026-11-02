function updateContactHeroBanner() {
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;

  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const targetUrl = isPortraitOrSmall
    ? (heroImg.getAttribute('data-phone') || (window.NVX_CONTACT && window.NVX_CONTACT.heroPhone))
    : (heroImg.getAttribute('data-desktop') || (window.NVX_CONTACT && window.NVX_CONTACT.heroDesktop));

  if (targetUrl) {
    if (heroImg.getAttribute('src') !== targetUrl) {
      heroImg.setAttribute('src', targetUrl);
    }
    if (heroImg.getAttribute('href') !== targetUrl) {
      heroImg.setAttribute('href', targetUrl);
    }
  }
}

function handleEnquirySubmit(formEl) {
  const companyName = (window.NVX_CONTACT && window.NVX_CONTACT.companyName) ? window.NVX_CONTACT.companyName : 'Novex Peptides';
  formEl.innerHTML = `
    <div class="enquiry-success-box">
      <h3>Enquiry Received</h3>
      <p>Thank you for contacting ${companyName}. We will respond within one business day.</p>
    </div>
  `;
}

const contactHeroMediaQuery = window.matchMedia('(orientation: portrait), (max-width: 768px)');
if (contactHeroMediaQuery.addEventListener) {
  contactHeroMediaQuery.addEventListener('change', updateContactHeroBanner);
} else if (contactHeroMediaQuery.addListener) {
  contactHeroMediaQuery.addListener(updateContactHeroBanner);
}

window.addEventListener('resize', updateContactHeroBanner);
document.addEventListener('DOMContentLoaded', updateContactHeroBanner);
updateContactHeroBanner();