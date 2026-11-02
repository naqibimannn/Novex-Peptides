document.addEventListener('DOMContentLoaded', function () {
  const shopBtn = document.querySelector('.btn-hero-shop');
  if (shopBtn) {
    shopBtn.addEventListener('click', function (e) {
      const target = document.getElementById('sup-formulas');
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  }
});