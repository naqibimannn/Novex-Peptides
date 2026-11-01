const WA = (window.NVX && window.NVX.waPhone) ? window.NVX.waPhone : '601112085054';

function applyTheme(mode) {
  const theme = (mode === 'dark') ? 'dark' : 'light';
  document.documentElement.setAttribute('data-theme', theme);
  const btn = document.getElementById('themeToggleBtn');
  if (btn) {
    const label = 'Switch to ' + (theme === 'dark' ? 'light' : 'dark') + ' theme';
    btn.setAttribute('aria-label', label);
    btn.setAttribute('title', label);
  }
}

function toggleTheme() {
  const cur = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
  const next = cur === 'dark' ? 'light' : 'dark';
  try { localStorage.setItem('nvx_theme', next); } catch (e) {}
  applyTheme(next);
}

function toggleDD(e, id) {
  if (e) { e.preventDefault(); e.stopPropagation(); }
  if (window.matchMedia('(hover:hover)').matches) return;
  const el = document.getElementById(id);
  document.querySelectorAll('.dd.open').forEach(d => { if (d !== el) d.classList.remove('open'); });
  if (el) el.classList.toggle('open');
}

function closeDD() {
  document.querySelectorAll('.dd.open').forEach(d => d.classList.remove('open'));
}

function toggleMobileNav(e) {
  if (e) {
    e.preventDefault();
    e.stopPropagation();
  }
  const navM = document.getElementById('navM');
  const btn = document.getElementById('mobileBurgerBtn');
  if (navM) {
    const isOpen = navM.classList.toggle('open');
    if (btn) btn.classList.toggle('open', isOpen);
  }
}

function closeMobileNav() {
  const navM = document.getElementById('navM');
  const btn = document.getElementById('mobileBurgerBtn');
  if (navM) navM.classList.remove('open');
  if (btn) btn.classList.remove('open');
}

document.addEventListener('keydown', (e) => { 
  if (e.key === 'Escape') {
    closeDD();
    closeCartDrawer();
  }
});

document.addEventListener('click', (e) => {
  if (!e.target.closest('.dd')) closeDD();
  const navM = document.getElementById('navM');
  const burgerBtn = document.getElementById('mobileBurgerBtn');
  if (navM && navM.classList.contains('open')) {
    if (!navM.contains(e.target) && burgerBtn && !burgerBtn.contains(e.target)) {
      closeMobileNav();
    }
  }
});

let hi = 0, ht;
function go(n){
  const slides = document.querySelectorAll('.hero.sl .slide');
  const dots = document.querySelectorAll('.hero.sl .dot');
  if(!slides.length) return;
  hi = (n + slides.length) % slides.length;
  slides.forEach((x, i) => x.classList.toggle('on', i === hi));
  dots.forEach((d, i) => d.classList.toggle('on', i === hi));
}

function updateHomeHeroBanners(){
  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const s1 = document.getElementById('heroSlide1');
  const s2 = document.getElementById('heroSlide2');

  if (s1 && window.NVX) {
    const url1 = isPortraitOrSmall ? window.NVX.hero1Phone : window.NVX.hero1Desktop;
    if (s1.getAttribute('src') !== url1) s1.setAttribute('src', url1);
    if (s1.getAttribute('href') !== url1) s1.setAttribute('href', url1);
  }

  if (s2 && window.NVX) {
    const url2 = isPortraitOrSmall ? window.NVX.hero2Phone : window.NVX.hero2Desktop;
    if (s2.getAttribute('src') !== url2) s2.setAttribute('src', url2);
    if (s2.getAttribute('href') !== url2) s2.setAttribute('href', url2);
  }
}

const homeHeroMediaQuery = window.matchMedia('(orientation: portrait), (max-width: 768px)');
if (homeHeroMediaQuery.addEventListener) {
  homeHeroMediaQuery.addEventListener('change', updateHomeHeroBanners);
} else if (homeHeroMediaQuery.addListener) {
  homeHeroMediaQuery.addListener(updateHomeHeroBanners);
}
window.addEventListener('resize', updateHomeHeroBanners);

function setCardSlide(dot, idx){
  if(window.event){
    window.event.preventDefault();
    window.event.stopPropagation();
  }
  const card = dot.closest('.card') || dot.closest('.pc');
  if(!card) return;
  const slider = card.querySelector('.prod-slider');
  if(!slider) return;
  const slides = slider.querySelectorAll('.prod-slide');
  const dots = card.querySelectorAll('.ps-dot');
  slides.forEach((s, i) => s.classList.toggle('active', i === idx));
  dots.forEach((d, i) => d.classList.toggle('active', i === idx));
}

var prodSlideTimer = null;
function startProdAutoSlide(){
  clearInterval(prodSlideTimer);
  if(matchMedia('(prefers-reduced-motion:reduce)').matches) return;
  prodSlideTimer = setInterval(() => {
    document.querySelectorAll('.card.pc').forEach(box => {
      const slides = box.querySelectorAll('.prod-slide');
      const dots = box.querySelectorAll('.ps-dot');
      if(slides.length < 2) return;
      let cur = 0;
      slides.forEach((s, idx) => { if(s.classList.contains('active')) cur = idx; });
      let next = (cur + 1) % slides.length;
      slides.forEach((s, idx) => s.classList.toggle('active', idx === next));
      dots.forEach((d, idx) => d.classList.toggle('active', idx === next));
    });
  }, 4500);
}

let tSlideIndex = 0;
const totalTSlides = 7;
let tSlideTimer = null;

function setTransformSlide(idx, e){
  if(e){
    e.preventDefault();
    e.stopPropagation();
  }
  tSlideIndex = (idx + totalTSlides) % totalTSlides;
  document.querySelectorAll('.t-slide').forEach((s, i) => {
    s.classList.toggle('active', i === tSlideIndex);
  });
  document.querySelectorAll('.t-dot').forEach((d, i) => {
    d.classList.toggle('active', i === tSlideIndex);
  });
}

function startTransformTimer(){
  clearInterval(tSlideTimer);
  if(matchMedia('(prefers-reduced-motion:reduce)').matches) return;
  tSlideTimer = setInterval(() => {
    setTransformSlide(tSlideIndex + 1);
  }, 4500);
}

function openLightboxModal(src, title=''){
  const m = document.getElementById('tLightbox');
  const im = document.getElementById('tLightboxImg');
  const t = document.getElementById('tLightboxTitle');
  if(m && im){
    im.src = src;
    if(t) t.innerText = title;
    m.classList.add('open');
  }
}

function closeLightboxModal(){
  const m = document.getElementById('tLightbox');
  if(m) m.classList.remove('open');
}

window.CART = [];
try {
  window.CART = JSON.parse(localStorage.getItem('nvx_cart') || '[]');
} catch(e) {
  window.CART = [];
}

function syncCartFromStorage(){
  try {
    window.CART = JSON.parse(localStorage.getItem('nvx_cart') || '[]');
  } catch(e) {
    window.CART = [];
  }
}

function saveCart(){
  localStorage.setItem('nvx_cart', JSON.stringify(window.CART));
  updateCartBadge();
}

function updateCartBadge(){
  syncCartFromStorage();
  const count = window.CART.reduce((acc,item)=>acc + (parseInt(item.qty, 10) || 1), 0);
  const badge = document.getElementById('cartCount');
  if(badge) badge.innerText = count;
}

function openCartDrawer(){
  syncCartFromStorage();
  renderCart();
  document.getElementById('cartOverlay').classList.add('open');
  document.getElementById('cartDrawer').classList.add('open');
}

function closeCartDrawer(){
  document.getElementById('cartOverlay').classList.remove('open');
  document.getElementById('cartDrawer').classList.remove('open');
}

function changeCartQty(index, delta){
  syncCartFromStorage();
  if(!window.CART[index]) return;
  window.CART[index].qty += delta;
  if(window.CART[index].qty <= 0){
    window.CART.splice(index, 1);
  }
  saveCart();
  renderCart();
}

function removeCartItem(index){
  syncCartFromStorage();
  if(!window.CART[index]) return;
  window.CART.splice(index, 1);
  saveCart();
  renderCart();
  showToast('Item removed from cart');
}

function resolveCartImg(src) {
  const fallback = (window.NVX && window.NVX.defaultImg) ? window.NVX.defaultImg : 'reta1.webp';
  if (!src) return fallback;
  if (src.startsWith('http://') || src.startsWith('https://')) return src;
  if (src.startsWith('/')) return src;
  const base = (window.NVX && window.NVX.assetBase) ? window.NVX.assetBase : '';
  return base + src.replace(/^\/+/, '');
}

function renderCart(){
  const listEl = document.getElementById('cartItemsList');
  const totalEl = document.getElementById('cartTotal');
  if(!listEl) return;

  const fallback = (window.NVX && window.NVX.defaultImg) ? window.NVX.defaultImg : 'reta1.webp';
  const prodUrl = (window.NVX && window.NVX.productsUrl) ? window.NVX.productsUrl : '/products';

  if(window.CART.length === 0){
    listEl.innerHTML = `<div style="text-align: center; padding: 48px 0; color: var(--text-muted);"><p style="font-size: 16px; margin-bottom: 8px;">Your cart is empty.</p><a href="${prodUrl}" onclick="closeCartDrawer()" style="display: inline-block; background-color: var(--primary); color: #ffffff; padding: 8px 20px; font-size: 12px; border-radius: 9999px;">Explore Products</a></div>`;
    totalEl.innerText = 'RM 0.00';
    return;
  }

  let total = 0;
  listEl.innerHTML = window.CART.map((item, idx)=>{
    const itemVal = parseFloat(item.val || item.price || 0);
    const itemQty = parseInt(item.qty, 10) || 1;
    const subtotal = itemVal * itemQty;
    total += subtotal;
    const detailLabel = item.size ? item.size : (item.s || '');
    const name = item.n || item.name || 'Product';
    const imgSrc = resolveCartImg(item.i || item.img || '');

    return `
      <div class="cart-item">
        <div class="cart-item-img">
          <img src="${imgSrc}" alt="${name}" loading="lazy" onerror="this.src='${fallback}'">
        </div>
        <div class="cart-item-info">
          <h4>${name}</h4>
          <span>${detailLabel ? detailLabel + ' • ' : ''}RM ${itemVal.toFixed(2)}</span>
          <div class="cart-subtotal">RM ${subtotal.toFixed(2)}</div>
        </div>
        <div>
          <div class="qty-box">
            <button onclick="changeCartQty(${idx}, -1)" aria-label="Decrease quantity">-</button>
            <input type="text" readonly value="${itemQty}">
            <button onclick="changeCartQty(${idx}, 1)" aria-label="Increase quantity">+</button>
          </div>
        </div>
        <div>
          <button type="button" class="cart-del-btn" onclick="removeCartItem(${idx})" aria-label="Delete ${name}" title="Delete item">
            <svg viewBox="0 0 24 24">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
              <line x1="10" y1="11" x2="10" y2="17"></line>
              <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
          </button>
        </div>
      </div>
    `;
  }).join('');

  totalEl.innerText = `RM ${total.toFixed(2)}`;
}

function proceedToWhatsApp(){
  if(window.CART.length === 0){
    alert('Please add products to your cart first.');
    return;
  }

  let total = 0;
  let itemsText = '';
  window.CART.forEach((item, index)=>{
    const itemVal = parseFloat(item.val || item.price || 0);
    const itemQty = parseInt(item.qty, 10) || 1;
    const subtotal = itemVal * itemQty;
    total += subtotal;
    const detail = item.size ? `(${item.size})` : (item.s ? `(${item.s})` : '');
    const name = item.n || item.name || 'Product';
    itemsText += `${index + 1}. *${name}* ${detail}\n   • Quantity: ${itemQty} unit/vial\n   • Price: RM${itemVal.toFixed(2)} x ${itemQty} = RM${subtotal.toFixed(2)}\n\n`;
  });

  const message = 
`Hello Novex Peptides, I would like to place an order for the following items:

${itemsText}*Total Order: RM ${total.toFixed(2)}*

Please confirm stock availability and payment / shipping details. Thank you!`;

  const url = `https://wa.me/${WA}?text=${encodeURIComponent(message)}`;
  window.open(url, '_blank');
}

function showToast(msg){
  const t = document.getElementById('toastMsg');
  if(!t) return;
  t.innerText = msg;
  t.classList.add('show');
  setTimeout(()=>t.classList.remove('show'), 2200);
}

const setOff = () => {
  const topEl = document.querySelector('.top');
  const hdrEl = document.querySelector('header');
  const h = (topEl ? topEl.offsetHeight : 0) + (hdrEl ? hdrEl.offsetHeight : 0);
  document.documentElement.style.setProperty('--off', h + 'px');
};

window.addEventListener('resize', setOff);
document.addEventListener('DOMContentLoaded', () => {
  setOff();
  applyTheme(document.documentElement.getAttribute('data-theme'));
  updateCartBadge();
  updateHomeHeroBanners();

  if(document.querySelector('.hero.sl .slide')){
    ht = setInterval(() => go(hi + 1), 7000);
  }
  startProdAutoSlide();
  startTransformTimer();

  const transformBox = document.getElementById('transformSlider');
  if(transformBox){
    transformBox.addEventListener('mouseenter', () => clearInterval(tSlideTimer));
    transformBox.addEventListener('mouseleave', () => startTransformTimer());
  }
});