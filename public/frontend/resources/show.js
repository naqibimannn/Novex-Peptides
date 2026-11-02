document.addEventListener('DOMContentLoaded', function () {
  const artSec = document.getElementById('articleShowSec');
  const footerEl = document.querySelector('footer');
  if (artSec && footerEl && footerEl.parentNode) {
    footerEl.parentNode.insertBefore(artSec, footerEl);
  }
});