let currentDetailProduct = window.CURRENT_PROD || {};
let currentDetailQty = 1;
let currentDetailSize = (currentDetailProduct.sizes && currentDetailProduct.sizes.length > 0) ? currentDetailProduct.sizes[0] : 'S';
let currentSelectedVariant = (currentDetailProduct.variants && currentDetailProduct.variants.length > 0) ? currentDetailProduct.variants[0] : null;

function fitRoundedImg(el) {
  if (!el || !el.naturalWidth || !el.naturalHeight) return;
  const r = el.naturalWidth / el.naturalHeight;
  el.style.aspectRatio = el.naturalWidth + ' / ' + el.naturalHeight;
  if (r >= 1) {
    el.style.width = '100%';
    el.style.height = 'auto';
  } else {
    el.style.height = '100%';
    el.style.width = 'auto';
  }
}

function setImgSlide(dot, targetIdx) {
  if (window.event) {
    window.event.preventDefault();
    window.event.stopPropagation();
  }
  const wrap = dot.closest('.detail-media-wrap') || document.getElementById('productDetailSec');
  if (!wrap) return;
  const box = wrap.querySelector('.prod-slider');
  if (!box) return;
  const slides = box.querySelectorAll('.prod-slide');
  const dots = wrap.querySelectorAll('.ps-dot');
  slides.forEach((s, idx) => s.classList.toggle('active', idx === targetIdx));
  dots.forEach((d, idx) => d.classList.toggle('active', idx === targetIdx));
}

function changeDetailQty(delta, maxStock) {
  const limit = currentSelectedVariant ? currentSelectedVariant.stock : maxStock;
  currentDetailQty = Math.max(1, Math.min(limit > 0 ? limit : 99, currentDetailQty + delta));
  const el = document.getElementById('detailQtyInput');
  if (el) el.value = currentDetailQty;
}

function selectProductSize(size, btnEl) {
  currentDetailSize = size;
  const group = document.getElementById('sizePickerGroup');
  if (group) {
    group.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
  }
  if (btnEl) btnEl.classList.add('active');
}

function selectProductVariant(idx, btnEl) {
  if (!currentDetailProduct.variants || !currentDetailProduct.variants[idx]) return;
  const v = currentDetailProduct.variants[idx];
  currentSelectedVariant = v;

  const group = document.getElementById('variantPickerGroup');
  if (group) {
    group.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
  }
  if (btnEl) btnEl.classList.add('active');

  const priceEl = document.getElementById('detailPriceDisplay');
  const subEl = document.getElementById('detailSubDisplay');
  const stockEl = document.getElementById('detailStockDisplay');
  const hintEl = document.getElementById('varHint');

  if (priceEl) priceEl.innerText = v.p;
  if (subEl) subEl.innerText = `${currentDetailProduct.title} (${v.label})`;
  if (stockEl) stockEl.innerText = `In Stock (${v.stock} units available)`;
  if (hintEl) hintEl.style.display = 'none';

  if (currentDetailQty > v.stock && v.stock > 0) {
    currentDetailQty = 1;
    const qEl = document.getElementById('detailQtyInput');
    if (qEl) qEl.value = 1;
  }
}

function openSizeModal() {
  const m = document.getElementById('sizeModal');
  if (m) m.classList.add('open');
}

function closeSizeModal() {
  const m = document.getElementById('sizeModal');
  if (m) m.classList.remove('open');
}

function triggerFlyAnimation(sourceImgEl) {
  const cartBtn = document.getElementById('headerCartBtn') || document.querySelector('.cart-trigger-btn');
  if (!sourceImgEl || !cartBtn) return;

  const srcRect = sourceImgEl.getBoundingClientRect();
  const destRect = cartBtn.getBoundingClientRect();

  const imgSrc = sourceImgEl.currentSrc || sourceImgEl.src;
  const flyer = document.createElement('img');
  flyer.src = imgSrc;
  flyer.className = 'flying-img';

  flyer.style.position = 'fixed';
  flyer.style.top = srcRect.top + 'px';
  flyer.style.left = srcRect.left + 'px';
  flyer.style.width = srcRect.width + 'px';
  flyer.style.height = srcRect.height + 'px';
  flyer.style.borderRadius = '24px';
  flyer.style.opacity = '1';
  flyer.style.transition = 'all 0.75s cubic-bezier(0.2, 0.9, 0.3, 1)';
  flyer.style.zIndex = '99999';
  flyer.style.pointerEvents = 'none';
  flyer.style.objectFit = 'contain';

  document.body.appendChild(flyer);
  flyer.getBoundingClientRect();

  const destX = destRect.left + (destRect.width / 2) - 15;
  const destY = destRect.top + (destRect.height / 2) - 15;

  requestAnimationFrame(() => {
    flyer.style.top = destY + 'px';
    flyer.style.left = destX + 'px';
    flyer.style.width = '30px';
    flyer.style.height = '30px';
    flyer.style.borderRadius = '50%';
    flyer.style.opacity = '0.3';
    flyer.style.transform = 'scale(0.4)';
  });

  setTimeout(() => {
    flyer.remove();
    cartBtn.classList.add('cart-bump');
    setTimeout(() => cartBtn.classList.remove('cart-bump'), 350);
  }, 760);
}

function triggerAddToCart() {
  let cart = [];
  try {
    cart = JSON.parse(localStorage.getItem('nvx_cart') || '[]');
  } catch (e) {
    cart = [];
  }

  let itemSpec = currentDetailProduct.spec || '';
  let itemVal = parseFloat(currentDetailProduct.val) || 0;
  let itemLabel = currentDetailProduct.name || '';

  if (currentSelectedVariant) {
    itemSpec = currentSelectedVariant.label;
    itemVal = parseFloat(currentSelectedVariant.val) || itemVal;
  } else if (currentDetailProduct.sizes && currentDetailProduct.sizes.length > 0) {
    itemSpec = 'Size: ' + currentDetailSize;
  }

  const firstImg = (currentDetailProduct.imgs && currentDetailProduct.imgs.length > 0) ? currentDetailProduct.imgs[0] : 'reta1.webp';
  const existing = cart.find(x => x.id === currentDetailProduct.id && (x.s === itemSpec || x.size === itemSpec));

  if (existing) {
    existing.qty += currentDetailQty;
  } else {
    cart.push({
      id: currentDetailProduct.id,
      n: itemLabel,
      name: itemLabel,
      s: itemSpec,
      size: itemSpec,
      val: itemVal,
      price: itemVal,
      i: firstImg,
      img: firstImg,
      qty: currentDetailQty
    });
  }

  localStorage.setItem('nvx_cart', JSON.stringify(cart));

  if (typeof CART !== 'undefined') {
    CART = cart;
  } else {
    window.CART = cart;
  }

  if (typeof updateCartBadge === 'function') {
    updateCartBadge();
  } else {
    const badge = document.getElementById('cartCount');
    if (badge) {
      badge.innerText = cart.reduce((acc, item) => acc + (parseInt(item.qty, 10) || 1), 0);
    }
  }

  const mainImgEl = document.querySelector('.detail-img-wrap .prod-slide.active img') || document.querySelector('.detail-img-wrap img');
  triggerFlyAnimation(mainImgEl);

  if (typeof showToast === 'function') {
    showToast('✓ Added to cart');
  }
}

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.contain-slide img').forEach(el => {
    if (el.complete) fitRoundedImg(el);
  });

  const flags = window.PROD_FLAGS || {};

  if (flags.isPremium) {
    const catalogBtn = document.querySelector('#ddCatalog .dd-trigger');
    if (catalogBtn) catalogBtn.classList.remove('on');

    const storeBtn = document.querySelector('#ddStore .dd-trigger');
    if (storeBtn) storeBtn.classList.add('on');

    document.querySelectorAll('nav.mnav a').forEach(a => {
      const href = a.getAttribute('href') || '';
      if (href.includes('premium')) a.classList.add('on');
      if (href.includes('products')) a.classList.remove('on');
    });
  } else if (flags.isPerformance) {
    const catalogBtn = document.querySelector('#ddCatalog .dd-trigger');
    if (catalogBtn) catalogBtn.classList.remove('on');

    const storeBtn = document.querySelector('#ddStore .dd-trigger');
    if (storeBtn) storeBtn.classList.add('on');

    document.querySelectorAll('nav.mnav a').forEach(a => {
      const href = a.getAttribute('href') || '';
      if (href.includes('performance')) a.classList.add('on');
      if (href.includes('products')) a.classList.remove('on');
    });
  } else if (flags.isAccessory) {
    document.querySelectorAll('nav.dnav a, nav.mnav a').forEach(a => {
      const href = a.getAttribute('href') || '';
      const text = a.textContent.trim();
      if (href.includes('accessory') || text === 'Accessory') {
        a.classList.add('on');
      }
      if (href.includes('products') || text === 'Products') {
        a.classList.remove('on');
      }
    });
  }

  const detailSec = document.getElementById('productDetailSec');
  const footerEl = document.querySelector('footer');
  if (detailSec && footerEl && footerEl.parentNode) {
    footerEl.parentNode.insertBefore(detailSec, footerEl);
  }
});