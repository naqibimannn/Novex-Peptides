document.addEventListener('DOMContentLoaded', function () {
  const exploreBtn = document.querySelector('.btn-hero-explore');
  if (exploreBtn) {
    exploreBtn.addEventListener('click', function (e) {
      const target = document.getElementById('perf-info');
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  }
});