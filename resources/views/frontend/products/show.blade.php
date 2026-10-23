@extends('frontend.home.index')

@section('content')
<style>
.detail-grid{display:grid;grid-template-columns:1.15fr 1fr;gap:48px;align-items:start}
.detail-img-wrap{
  aspect-ratio:1;
  max-width:580px;
  border-radius:28px;
  overflow:hidden;
  border:1px solid var(--line);
  background:#ffffff;
  position:relative;
}
.detail-img-wrap .prod-slide{
  position:absolute;
  inset:0;
  width:100%;
  height:100%;
  opacity:0;
  transition:opacity .4s ease-in-out;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:20px;
  background:#fff;
}
.detail-img-wrap .prod-slide.active{opacity:1;pointer-events:auto}
.detail-img-wrap .prod-slide img{
  max-height:100%;
  max-width:100%;
  object-fit:contain;
  border-radius:18px;
}
.detail-img-wrap .ps-dots{
  position:absolute;
  bottom:16px;
  left:0;
  right:0;
  z-index:5;
  display:flex;
  justify-content:center;
  gap:8px;
}
.detail-img-wrap .ps-dot{
  width:9px;
  height:9px;
  border-radius:50%;
  background:rgba(30,45,59,.25);
  cursor:pointer;
  transition:all .3s ease;
}
.detail-img-wrap .ps-dot.active{
  background:var(--green);
  transform:scale(1.25);
}

.detail-info{display:flex;flex-direction:column;gap:16px}
.detail-badge{
  display:inline-block;
  background:var(--bg2);
  color:var(--green);
  padding:6px 14px;
  border-radius:999px;
  font-size:12px;
  font-weight:600;
  letter-spacing:.04em;
  align-self:flex-start;
}
.detail-price{
  font-size:clamp(26px,3vw,34px);
  font-weight:700;
  color:var(--green);
  font-family:var(--serif);
}
.stock-badge{
  display:inline-flex;
  align-items:center;
  font-size:13px;
  font-weight:600;
  color:#1ebe5a;
  background:rgba(37,211,102,.12);
  padding:5px 14px;
  border-radius:999px;
  align-self:flex-start;
}
.detail-desc{
  font-size:14px;
  line-height:1.7;
  color:#3A4D5E;
  border-top:1px solid var(--line);
  border-bottom:1px solid var(--line);
  padding:20px 0;
}
.size-picker{display:flex;gap:8px;flex-wrap:wrap;margin:8px 0}
.size-btn{
  border:1px solid var(--line);
  background:#fff;
  padding:8px 16px;
  font-size:13px;
  font-weight:600;
  border-radius:10px;
  cursor:pointer;
  transition:all .2s ease;
}
.size-btn:hover{border-color:var(--green)}
.size-btn.active{background:var(--green);color:#fff;border-color:var(--green)}

.qty-row{display:flex;align-items:center;gap:16px;margin-top:8px;flex-wrap:wrap}
.qty-box{display:inline-flex;align-items:center;border:1px solid var(--line);border-radius:999px;background:var(--card);overflow:hidden}
.qty-box button{width:40px;height:40px;background:none;border:none;font-size:17px;font-weight:600;display:flex;align-items:center;justify-content:center;cursor:pointer}
.qty-box button:hover{background:var(--bg2)}
.qty-box input{width:46px;text-align:center;border:0;background:none;font-weight:600;font-size:14px}

.btn-add-cart{
  background:var(--green);
  color:#fff;
  padding:14px 28px;
  font-weight:600;
  font-size:14px;
  border-radius:999px;
  flex:1;
  min-width:180px;
  text-align:center;
  cursor:pointer;
  border:none;
  transition:background .2s ease, transform .1s ease;
}
.btn-add-cart:hover{background:#245a82}
.btn-add-cart:active{transform:scale(0.98)}

.cart-overlay{
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.5);
  z-index:999;
  display:none;
  backdrop-filter:blur(3px);
}
.cart-overlay.open{display:block}
.cart-drawer{
  position:fixed;
  right:0;
  top:0;
  bottom:0;
  width:100%;
  max-width:460px;
  background:#fff;
  z-index:1000;
  transform:translateX(100%);
  transition:transform .3s ease;
  display:flex;
  flex-direction:column;
  box-shadow:-10px 0 30px rgba(0,0,0,.15);
}
.cart-drawer.open{transform:translateX(0)}
.cart-header{
  padding:20px 22px;
  border-bottom:1px solid var(--line);
  display:flex;
  justify-content:space-between;
  align-items:center;
}
.cart-items{
  padding:18px 22px;
  overflow-y:auto;
  flex:1;
  display:flex;
  flex-direction:column;
  gap:14px;
}
.cart-item{
  display:grid;
  grid-template-columns:60px 1fr auto auto;
  gap:12px;
  align-items:center;
  border-bottom:1px solid var(--line);
  padding-bottom:14px;
}
.cart-item-img{
  aspect-ratio:1;
  border-radius:12px;
  overflow:hidden;
  background:#ffffff;
  border:1px solid var(--line);
}
.cart-item-img img{
  width:100%;
  height:100%;
  object-fit:cover;
}
.cart-del-btn{
  background:none;
  border:none;
  color:var(--red);
  padding:8px;
  cursor:pointer;
  border-radius:8px;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  transition:background .2s,color .2s;
}
.cart-del-btn:hover{background:#ffe4e6;color:#be123c}
.cart-footer{
  padding:20px 22px;
  border-top:1px solid var(--line);
  background:var(--card);
}
.cart-total-row{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:16px;
  font-size:16px;
}
.cart-total-price{
  font-size:24px;
  font-weight:700;
  color:var(--green);
  font-family:var(--serif);
}
.btn-wa-proceed{
  width:100%;
  background:#25D366;
  color:#fff;
  padding:15px;
  border-radius:999px;
  font-weight:700;
  font-size:14px;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:10px;
  border:none;
  cursor:pointer;
  transition:background .2s;
}
.btn-wa-proceed:hover{background:#1ebe5a}
.btn-wa-proceed svg{width:20px;height:20px;fill:#fff}

.toast{
  position:fixed;
  bottom:24px;
  left:50%;
  transform:translateX(-50%) translateY(100px);
  background:var(--ink);
  color:#fff;
  padding:12px 24px;
  border-radius:999px;
  font-size:13px;
  font-weight:500;
  box-shadow:0 10px 25px rgba(0,0,0,.2);
  z-index:9999;
  opacity:0;
  transition:all .3s ease;
  pointer-events:none;
}
.toast.show{transform:translateX(-50%) translateY(0);opacity:1}
.flying-img{
  position:fixed;
  z-index:99999;
  pointer-events:none;
  object-fit:cover;
  box-shadow:0 14px 32px rgba(47,111,159,.4);
  will-change:transform,top,left,width,height,opacity;
}

@media(max-width:900px){
  .detail-grid{grid-template-columns:1fr}
  .detail-img-wrap{max-width:480px;margin:0 auto;width:100%}
}
@media(max-width:640px){
  .cart-drawer{max-width:100%}
  .cart-item{grid-template-columns:52px 1fr auto auto;gap:8px}
}
</style>

<section class="sec">
  <div class="wrap">
    <div style="margin-bottom:24px">
      <a href="{{ route('products.index') }}" style="font-size:13px;font-weight:600;color:var(--green)">← Back to Catalog</a>
    </div>

    <div class="detail-grid">
      <div class="detail-img-wrap">
        <div class="prod-slide active" id="slide0">
          <img src="{{ asset('reta1.webp') }}" alt="Retatrutide Main" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800'">
        </div>
        <div class="prod-slide" id="slide1">
          <img src="{{ asset('reta2.webp') }}" alt="Retatrutide Packaging" onerror="this.src='https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800'">
        </div>
        <div class="prod-slide" id="slide2">
          <img src="{{ asset('reta3.webp') }}" alt="Retatrutide Vial" onerror="this.src='https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=800'">
        </div>

        <div class="ps-dots">
          <span class="ps-dot active" onclick="showProductSlide(0, this)"></span>
          <span class="ps-dot" onclick="showProductSlide(1, this)"></span>
          <span class="ps-dot" onclick="showProductSlide(2, this)"></span>
        </div>
      </div>

      <div class="detail-info">
        <span class="detail-badge">Research Grade</span>
        <h1 style="font-size:clamp(28px, 4vw, 42px);margin:4px 0">Retatrutide</h1>
        <p id="detailSubDisplay" style="color:var(--mut);font-size:16px">Advanced Weight Management (10mg)</p>
        
        <div id="detailPriceDisplay" class="detail-price">RM280.00</div>
        
        <div id="detailStockDisplay" class="stock-badge">In Stock (25 units available)</div>

        <div style="background:var(--card);padding:16px;border-radius:18px;border:1px solid var(--line);margin-top:6px">
          <label style="font-size:12px;font-weight:700;text-transform:uppercase;color:var(--ink);display:block;margin-bottom:6px">
            Select Vial Concentration / Dosage:
          </label>
          <div class="size-picker">
            <button type="button" class="size-btn active" onclick="selectVariant('10mg', 280, 'RM280.00', 25, this)">10mg</button>
            <button type="button" class="size-btn" onclick="selectVariant('30mg', 480, 'RM480.00', 18, this)">30mg</button>
            <button type="button" class="size-btn" onclick="selectVariant('60mg', 780, 'RM780.00', 12, this)">60mg</button>
            <button type="button" class="size-btn" onclick="selectVariant('100mg', 980, 'RM980.00', 8, this)">100mg</button>
          </div>
          <small id="varHint" style="font-size:12px;color:var(--mut);display:block;margin-top:4px">
            Select a dosage above to view exact pricing and available laboratory stock.
          </small>
        </div>

        <div class="detail-desc">
          <h4 style="font-family:var(--serif);font-size:20px;margin-bottom:8px">Product Overview</h4>
          <p>
            High-purity lyophilised triple-receptor agonist peptide synthesized for metabolic pathway investigations and weight management receptor studies. Batch verification and full chemical documentation available upon order.
          </p>
        </div>

        <!-- Stepper Kuantitas & Tombol Add to Cart -->
        <div class="qty-row">
          <div class="qty-box">
            <button type="button" onclick="changeDetailQty(-1)" aria-label="Decrease quantity">-</button>
            <input type="text" id="detailQtyInput" readonly value="1">
            <button type="button" onclick="changeDetailQty(1)" aria-label="Increase quantity">+</button>
          </div>
          
          <button type="button" class="btn-add-cart" onclick="addToCartFromDetail()">Add to Cart</button>
        </div>

        <div style="margin-top:12px;font-size:12px;color:var(--mut);line-height:1.6;border-top:1px solid var(--line);padding-top:14px">
          • High purity formulation verified with third-party quality control.<br>
          • Secure thermal-insulated packaging for all temperature-sensitive items.<br>
          • Direct WhatsApp support available for wholesale or technical inquiries.
        </div>
      </div>
    </div>
  </div>
</section>

<div class="toast" id="toastMsg">✓ Added to cart</div>

<div class="cart-overlay" id="cartOverlay" onclick="closeCartDrawer()"></div>
<div class="cart-drawer" id="cartDrawer">
  <div class="cart-header">
    <h3 style="font-size:22px">Your Research Cart</h3>
    <button onclick="closeCartDrawer()" style="background:none;border:none;font-size:24px;color:var(--mut);cursor:pointer">&times;</button>
  </div>
  <div class="cart-items" id="cartItemsList"></div>
  <div class="cart-footer">
    <div class="cart-total-row">
      <span style="font-weight:600">Total Order:</span>
      <span class="cart-total-price" id="cartTotal">RM 0.00</span>
    </div>
    <button class="btn-wa-proceed" onclick="proceedToWhatsApp()">
      <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 0 0 16 29c7.2 0 13-5.8 13-13S23.2 3 16 3zm0 23.8c-2 0-3.9-.6-5.6-1.6l-.4-.2-4 1 1.1-3.9-.3-.4A10.7 10.7 0 1 1 16 26.8zm5.9-8c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2l-1 1.2c-.2.2-.4.2-.7.1-1.900-.9-3.100-1.700-4.300-3.800-.3-.6.3-.5.9-1.700.1-.2 0-.4 0-.5l-1-2.300c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.200 1.100-1.200 2.800s1.200 3.300 1.400 3.500c.2.2 2.400 3.700 5.900 5.200 2.200.9 3 1 4.100.8.700-.1 1.900-.8 2.200-1.500.3-.7.3-1.400.2-1.500-.1-.2-.3-.2-.6-.4z"/></svg>
      Click To Proceed
    </button>
  </div>
</div>

<script>
const WA = '601112085054';

let currentSelectedDosage = '10mg';
let currentUnitVal = 280;
let currentMaxStock = 25;
let currentQty = 1;

function showProductSlide(idx, dotEl){
  document.querySelectorAll('.detail-img-wrap .prod-slide').forEach((s, i) => {
    s.classList.toggle('active', i === idx);
  });
  document.querySelectorAll('.detail-img-wrap .ps-dot').forEach((d, i) => {
    d.classList.toggle('active', i === idx);
  });
}

function selectVariant(dosage, priceNum, priceFormatted, stock, btnEl){
  currentSelectedDosage = dosage;
  currentUnitVal = priceNum;
  currentMaxStock = stock;
  if(currentQty > stock) currentQty = 1;

  document.querySelectorAll('.size-picker .size-btn').forEach(b => b.classList.remove('active'));
  btnEl.classList.add('active');

  document.getElementById('detailPriceDisplay').innerText = priceFormatted;
  document.getElementById('detailSubDisplay').innerText = `Advanced Weight Management (${dosage})`;
  document.getElementById('detailStockDisplay').innerText = `In Stock (${stock} units available)`;
  document.getElementById('detailQtyInput').value = currentQty;
}

function changeDetailQty(delta){
  currentQty = Math.max(1, Math.min(currentMaxStock, currentQty + delta));
  document.getElementById('detailQtyInput').value = currentQty;
}

let CART = JSON.parse(localStorage.getItem('nvx_cart') || '[]');

function saveCart(){
  localStorage.setItem('nvx_cart', JSON.stringify(CART));
  updateCartBadge();
}

function updateCartBadge(){
  const count = CART.reduce((acc, item) => acc + item.qty, 0);
  const badge = document.getElementById('cartCount');
  if(badge) badge.innerText = count;
}

function showToast(msg){
  const t = document.getElementById('toastMsg');
  if(!t) return;
  t.innerText = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 2200);
}

function addToCartFromDetail(){
  const prodId = 'retatrutide';
  const prodName = 'Retatrutide';
  const itemSize = `Dosage: ${currentSelectedDosage}`;
  const itemVal = currentUnitVal;
  const itemSpec = currentSelectedDosage;
  const itemImg = '{{ asset("reta1.webp") }}';

  const existing = CART.find(x => x.id === prodId && x.size === itemSize);

  if(existing){
    existing.qty += currentQty;
  } else {
    CART.push({
      id: prodId,
      n: prodName,
      s: itemSpec,
      val: itemVal,
      i: itemImg,
      size: itemSize,
      qty: currentQty
    });
  }

  saveCart();

  const mainImgEl = document.querySelector('.detail-img-wrap .prod-slide.active img') || document.querySelector('.detail-img-wrap img');
  triggerFlyAnimation(mainImgEl);

  showToast('✓ Added to cart');

  setTimeout(() => {
    openCartDrawer();
  }, 450);
}

function openCartDrawer(){
  renderCart();
  document.getElementById('cartOverlay').classList.add('open');
  document.getElementById('cartDrawer').classList.add('open');
}

function closeCartDrawer(){
  document.getElementById('cartOverlay').classList.remove('open');
  document.getElementById('cartDrawer').classList.remove('open');
}

function changeCartQty(index, delta){
  if(!CART[index]) return;
  CART[index].qty += delta;
  if(CART[index].qty <= 0){
    CART.splice(index, 1);
  }
  saveCart();
  renderCart();
}

function removeCartItem(index){
  if(!CART[index]) return;
  CART.splice(index, 1);
  saveCart();
  renderCart();
  showToast('Item removed from cart');
}

function renderCart(){
  const listEl = document.getElementById('cartItemsList');
  const totalEl = document.getElementById('cartTotal');
  if(!listEl) return;

  if(CART.length === 0){
    listEl.innerHTML = `
      <div style="text-align:center;padding:48px 0;color:var(--mut)">
        <p style="font-size:16px;margin-bottom:8px">Your cart is empty.</p>
        <a href="{{ route('products.index') }}" onclick="closeCartDrawer()" class="btn" style="padding:8px 20px;font-size:12px">Explore Products</a>
      </div>
    `;
    totalEl.innerText = 'RM 0.00';
    return;
  }

  let total = 0;
  listEl.innerHTML = CART.map((item, idx) => {
    const subtotal = item.val * item.qty;
    total += subtotal;
    const detailLabel = item.size ? item.size : item.s;
    const imgSrc = item.i ? (item.i.startsWith('http') || item.i.endsWith('.webp') || item.i.endsWith('.png') ? item.i : `https://images.unsplash.com/photo-${item.i}?auto=format&fit=crop&w=150&q=80`) : '{{ asset("reta1.webp") }}';

    return `
      <div class="cart-item">
        <div class="cart-item-img">
          <img src="${imgSrc}" alt="${item.n}" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=150'">
        </div>
        <div>
          <h4 style="font-size:14px;line-height:1.25;margin-bottom:3px">${item.n}</h4>
          <span style="font-size:12px;color:var(--mut)">${detailLabel} • RM ${item.val.toFixed(2)}</span>
          <div style="font-size:13px;font-weight:700;color:var(--green);margin-top:4px">RM ${subtotal.toFixed(2)}</div>
        </div>
        <div>
          <div class="qty-box" style="transform:scale(0.85);transform-origin:center">
            <button onclick="changeCartQty(${idx}, -1)" aria-label="Decrease quantity">-</button>
            <input type="text" readonly value="${item.qty}">
            <button onclick="changeCartQty(${idx}, 1)" aria-label="Increase quantity">+</button>
          </div>
        </div>
        <div>
          <button type="button" class="cart-del-btn" onclick="removeCartItem(${idx})" aria-label="Delete ${item.n}" title="Delete item">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
  if(CART.length === 0){
    alert('Please add products to your cart first.');
    return;
  }

  let total = 0;
  let itemsText = '';
  CART.forEach((item, index) => {
    const subtotal = item.val * item.qty;
    total += subtotal;
    const detail = item.size ? `(${item.size})` : `(${item.s})`;
    itemsText += `${index + 1}. *${item.n}* ${detail}\n   • Quantity: ${item.qty} unit/vial\n   • Price: RM${item.val.toFixed(2)} x ${item.qty} = RM${subtotal.toFixed(2)}\n\n`;
  });

  const message = 
`Hello Novex Peptides, I would like to place an order for the following items:

${itemsText}*Total Order: RM ${total.toFixed(2)}*

Please confirm stock availability and payment / shipping details. Thank you!`;

  const url = `https://wa.me/${WA}?text=${encodeURIComponent(message)}`;
  window.open(url, '_blank');
}

function triggerFlyAnimation(sourceImgEl){
  const cartBtn = document.querySelector('.cart-trigger-btn') || document.getElementById('headerCartBtn');
  if(!sourceImgEl || !cartBtn) return;

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

document.addEventListener('DOMContentLoaded', () => {
  updateCartBadge();
  const headerCartBtn = document.querySelector('.cart-trigger-btn');
  if(headerCartBtn){
    headerCartBtn.addEventListener('click', (e) => {
      e.preventDefault();
      openCartDrawer();
    });
  }
});
</script>
@endsection