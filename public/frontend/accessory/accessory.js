let activeCategory = 'All';
let currentPage = 1;
const ITEMS_PER_PAGE = 8;

function setCategoryFilter(cat, btn) {
  activeCategory = cat;
  currentPage = 1;
  document.querySelectorAll('#flt button').forEach(b => b.classList.remove('on'));
  btn.classList.add('on');
  filterProducts();
}

function setCardSlideCatalog(dot, idx) {
  if (window.event) {
    window.event.preventDefault();
    window.event.stopPropagation();
  }
  const card = dot.closest('.catalog-card') || dot.closest('.card') || dot.closest('.pc');
  if (!card) return;
  const slider = card.querySelector('.prod-slider');
  if (!slider) return;
  const slides = slider.querySelectorAll('.prod-slide');
  const dots = card.querySelectorAll('.ps-dot');
  slides.forEach((s, i) => s.classList.toggle('active', i === idx));
  dots.forEach((d, i) => d.classList.toggle('active', i === idx));
}

function filterProducts(resetPage = false) {
  if (resetPage) currentPage = 1;

  const query = (document.getElementById('q')?.value || '').trim().toLowerCase();
  const cards = Array.from(document.querySelectorAll('#pg .catalog-card'));

  const matchingCards = cards.filter(card => {
    const cardCat = card.getAttribute('data-category') || '';
    const cardKeywords = card.getAttribute('data-keywords') || '';
    const textContent = card.innerText.toLowerCase();

    const matchesCategory = (activeCategory === 'All') || (cardCat === activeCategory);
    const matchesSearch = !query || cardKeywords.includes(query) || textContent.includes(query);

    return matchesCategory && matchesSearch;
  });

  const totalPages = Math.ceil(matchingCards.length / ITEMS_PER_PAGE) || 1;
  if (currentPage > totalPages) currentPage = 1;

  const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
  const endIndex = startIndex + ITEMS_PER_PAGE;

  cards.forEach(card => {
    card.style.display = 'none';
  });

  matchingCards.forEach((card, index) => {
    if (index >= startIndex && index < endIndex) {
      card.style.display = 'flex';
    }
  });

  const noMatch = document.getElementById('noMatchMsg');
  if (noMatch) {
    noMatch.style.display = matchingCards.length === 0 ? 'block' : 'none';
  }

  renderPagination(totalPages, matchingCards.length);
}

function renderPagination(totalPages, totalItems) {
  const container = document.getElementById('pagination');
  if (!container) return;

  if (totalPages <= 1 || totalItems === 0) {
    container.innerHTML = '';
    return;
  }

  let html = '';

  html += `<button type="button" class="page-btn" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})" aria-label="Previous Page">&larr;</button>`;

  const maxButtons = 5;
  let start = Math.max(1, currentPage - 2);
  let end = Math.min(totalPages, start + maxButtons - 1);

  if (end - start < maxButtons - 1) {
    start = Math.max(1, end - maxButtons + 1);
  }

  if (start > 1) {
    html += `<button type="button" class="page-btn ${currentPage === 1 ? 'active' : ''}" onclick="goToPage(1)">1</button>`;
    if (start > 2) {
      html += `<span class="page-dots">...</span>`;
    }
  }

  for (let i = start; i <= end; i++) {
    html += `<button type="button" class="page-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage(${i})">${i}</button>`;
  }

  if (end < totalPages) {
    if (end < totalPages - 1) {
      html += `<span class="page-dots">...</span>`;
    }
    html += `<button type="button" class="page-btn ${currentPage === totalPages ? 'active' : ''}" onclick="goToPage(${totalPages})">${totalPages}</button>`;
  }

  html += `<button type="button" class="page-btn" ${currentPage === totalPages ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})" aria-label="Next Page">&rarr;</button>`;

  container.innerHTML = html;
}

function goToPage(page) {
  currentPage = page;
  filterProducts(false);
  const anchor = document.getElementById('cat');
  if (anchor) {
    anchor.scrollIntoView({ behavior: 'smooth' });
  }
}

document.addEventListener('DOMContentLoaded', function () {
  filterProducts(true);

  const catSec = document.getElementById('cat');
  const footerEl = document.querySelector('footer');
  if (catSec && footerEl && footerEl.parentNode) {
    footerEl.parentNode.insertBefore(catSec, footerEl);
  }
});