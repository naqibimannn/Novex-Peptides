let activeCategory = 'All';
let currentPage = 1;
const ITEMS_PER_PAGE = 8;

function setCategoryFilter(cat, btn) {
  activeCategory = cat;
  currentPage = 1;
  document.querySelectorAll('#flt button').forEach(b => b.classList.remove('on'));
  if (btn) btn.classList.add('on');
  filterProducts(true);
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
    const cardCat = (card.getAttribute('data-category') || '').trim();
    const cardKeywords = (card.getAttribute('data-keywords') || '').trim().toLowerCase();
    const textContent = card.innerText.toLowerCase();

    const matchesCategory = (activeCategory === 'All') || (cardCat.toLowerCase() === activeCategory.toLowerCase());
    const matchesSearch = !query || cardKeywords.includes(query) || textContent.includes(query);

    return matchesCategory && matchesSearch;
  });

  const totalPages = Math.ceil(matchingCards.length / ITEMS_PER_PAGE) || 1;
  if (currentPage > totalPages) currentPage = totalPages;
  if (currentPage < 1) currentPage = 1;

  const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
  const endIndex = startIndex + ITEMS_PER_PAGE;

  cards.forEach(card => {
    card.style.display = 'none';
  });

  matchingCards.forEach((card, index) => {
    if (index >= startIndex && index < endIndex) {
      card.style.display = '';
    }
  });

  const noMatch = document.getElementById('noMatchMsg');
  if (noMatch) {
    noMatch.style.display = matchingCards.length === 0 ? 'block' : 'none';
  }

  renderPagination(totalPages, matchingCards.length);
}

function getPaginationList(current, total) {
  if (total <= 7) {
    return Array.from({ length: total }, (_, i) => i + 1);
  }
  if (current <= 3) {
    return [1, 2, 3, '...', total - 1, total];
  }
  if (current >= total - 2) {
    return [1, 2, '...', total - 2, total - 1, total];
  }
  return [1, '...', current - 1, current, current + 1, '...', total];
}

function renderPagination(totalPages, totalItems) {
  const container = document.getElementById('pagination');
  if (!container) return;

  if (totalPages <= 1 || totalItems === 0) {
    container.innerHTML = '';
    container.style.display = 'none';
    return;
  }

  container.style.display = 'flex';
  let html = '';

  html += `
    <button type="button" class="page-btn page-btn-nav" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})" aria-label="Previous Page">
      &larr; <span>Prev</span>
    </button>
  `;

  const pages = getPaginationList(currentPage, totalPages);
  pages.forEach(p => {
    if (p === '...') {
      html += `<span class="page-dots">...</span>`;
    } else if (p === currentPage) {
      html += `<button type="button" class="page-btn active">${p}</button>`;
    } else {
      html += `<button type="button" class="page-btn" onclick="goToPage(${p})">${p}</button>`;
    }
  });

  html += `
    <button type="button" class="page-btn page-btn-nav" ${currentPage === totalPages ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})" aria-label="Next Page">
      <span>Next</span> &rarr;
    </button>
  `;

  container.innerHTML = html;
}

function goToPage(page) {
  currentPage = page;
  filterProducts(false);
  const anchor = document.getElementById('cat') || document.getElementById('pg');
  if (anchor) {
    anchor.scrollIntoView({ behavior: 'smooth', block: 'start' });
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