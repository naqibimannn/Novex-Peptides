@extends('frontend.home.index')

@section('content')
<style>
.cart-page-card{
  background:#fff;
  border:1px solid var(--line);
  border-radius:24px;
  padding:32px;
  box-shadow:0 10px 30px rgba(14,40,66,.04);
}
.cart-item-row{
  display:grid;
  grid-template-columns:70px 1fr auto auto;
  gap:16px;
  align-items:center;
  border-bottom:1px solid var(--line);
  padding:16px 0;
}
.cart-item-row:first-child{padding-top:0}
.cart-item-img{
  aspect-ratio:1;
  border-radius:14px;
  overflow:hidden;
  background:#fff;
  border:1px solid var(--line);
  display:flex;
  align-items:center;
  justify-content:center;
}
.cart-item-img img{
  width:100%;
  height:100%;
  object-fit:cover;
}
.qty-box{
  display:inline-flex;
  align-items:center;
  border:1px solid var(--line);
  border-radius:999px;
  background:var(--card);
  overflow:hidden;
}
.qty-box button{
  width:36px;
  height:36px;
  background:none;
  border:none;
  font-size:16px;
  font-weight:600;
  cursor:pointer;
  display:flex;
  align-items:center;
  justify-content:center;
  color:var(--ink);
  transition:background .2s ease;
}
.qty-box button:hover{background:var(--bg2)}
.qty-box input{
  width:40px;
  text-align:center;
  border:0;
  background:none;
  font-weight:600;
  font-size:13px;
  color:var(--ink);
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
  transition:background .2s ease, color .2s ease;
}
.cart-del-btn:hover{
  background:#ffe4e6;
  color:#be123c;
}
.cart-summary{
  margin-top:24px;
  padding-top:20px;
  border-top:1px solid var(--line);
}
.cart-total-bar{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px;
  font-size:17px;
}
.cart-total-val{
  font-size:28px;
  font-weight:700;
  color:var(--green);
  font-family:var(--serif);
}
.btn-wa-checkout{
  background:#25D366;
  color:#fff;
  padding:15px 36px;
  font-weight:700;
  border-radius:999px;
  font-size:15px;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:10px;
  width:100%;
  transition:background .2s ease, transform .1s ease;
  border:none;
  cursor:pointer;
  text-decoration:none;
}
.btn-wa-checkout:hover{background:#1ebe5a}
.btn-wa-checkout:active{transform:scale(0.98)}

@media(max-width:640px){
  .cart-page-card{padding:20px 16px}
  .cart-item-row{grid-template-columns:56px 1fr auto auto;gap:10px}
  .cart-total-bar{font-size:15px}
  .cart-total-val{font-size:24px}
}
</style>

<section class="sec">
  <div class="wrap" style="max-width:800px">
    <!-- Header Sedia Ada -->
    <div class="head">
      <div>
        <h1 style="font-size:38px">Your Research Cart</h1>
        <p>Review your selected compounds and items before proceeding to WhatsApp checkout.</p>
      </div>
    </div>

    <div class="cart-page-card">
      <p style="color:var(--mut);font-size:15px;margin-bottom:20px;text-align:center">
        Your items are synced directly with our WhatsApp ordering system.
      </p>

      <div id="cartItemsList"></div>

      <div class="cart-summary" id="cartSummarySection">
        <div class="cart-total-bar">
          <span style="font-weight:600">Total Order:</span>
          <span class="cart-total-val" id="pageCartTotal">RM 0.00</span>
        </div>
        
        <a id="btnWaCheckout" class="btn-wa-checkout" href="https://wa.me/601112085054?text=Hello%20Novex%20Peptides%20I%20want%20to%20order" target="_blank">
          <svg viewBox="0 0 32 32" width="20" height="20" fill="#fff" aria-hidden="true"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 0 0 16 29c7.2 0 13-5.8 13-13S23.2 3 16 3zm0 23.8c-2 0-3.9-.6-5.6-1.6l-.4-.2-4 1 1.1-3.9-.3-.4A10.7 10.7 0 1 1 16 26.8zm5.9-8c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2l-1 1.2c-.2.2-.4.2-.7.1-1.900-.9-3.100-1.700-4.300-3.800-.3-.6.3-.5.9-1.700.1-.2 0-.4 0-.5l-1-2.300c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.200 1.100-1.200 2.800s1.200 3.300 1.400 3.500c.2.2 2.400 3.700 5.900 5.200 2.200.9 3 1 4.100.8.700-.1 1.900-.8 2.200-1.500.3-.7.3-1.400.2-1.500-.1-.2-.3-.2-.6-.4z"/></svg>
          <span>Proceed via WhatsApp Checkout</span>
        </a>
      </div>
    </div>
  </div>
</section>

<script>
const WA_PHONE = '601112085054';

function loadCartItems(){
  return JSON.parse(localStorage.getItem('nvx_cart') || '[]');
}

function saveCartItems(cart){
  localStorage.setItem('nvx_cart', JSON.stringify(cart));
  if(typeof updateCartBadge === 'function') updateCartBadge();
}

function renderCartPage(){
  const cart = loadCartItems();
  const listEl = document.getElementById('cartItemsList');
  const summaryEl = document.getElementById('cartSummarySection');
  const totalEl = document.getElementById('pageCartTotal');
  const checkoutBtn = document.getElementById('btnWaCheckout');

  if(!listEl) return;

  if(cart.length === 0){
    listEl.innerHTML = `
      <div style="text-align:center;padding:48px 0;color:var(--mut)">
        <p style="font-size:16px;margin-bottom:12px">Your research cart is currently empty.</p>
        <a href="{{ route('products.index') }}" class="btn" style="padding:10px 24px;font-size:13px">Browse Products</a>
      </div>
    `;
    if(summaryEl) summaryEl.style.display = 'none';
    return;
  }

  if(summaryEl) summaryEl.style.display = 'block';

  let grandTotal = 0;
  listEl.innerHTML = cart.map((item, idx) => {
    const subtotal = item.val * item.qty;
    grandTotal += subtotal;
    const detailLabel = item.size ? item.size : item.s;
    const imgSrc = item.i ? (item.i.startsWith('http') || item.i.endsWith('.webp') || item.i.endsWith('.png') ? item.i : `https://images.unsplash.com/photo-${item.i}?auto=format&fit=crop&w=150&q=80`) : '{{ asset("reta1.webp") }}';

    return `
      <div class="cart-item-row">
        <div class="cart-item-img">
          <img src="${imgSrc}" alt="${item.n}" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=150'">
        </div>
        <div>
          <h4 style="font-size:15px;line-height:1.25;margin-bottom:3px;color:var(--ink)">${item.n}</h4>
          <span style="font-size:12px;color:var(--mut)">${detailLabel} • RM ${item.val.toFixed(2)}</span>
          <div style="font-size:14px;font-weight:700;color:var(--green);margin-top:4px">RM ${subtotal.toFixed(2)}</div>
        </div>
        <div>
          <div class="qty-box">
            <button type="button" onclick="updateQty(${idx}, -1)" aria-label="Decrease quantity">-</button>
            <input type="text" readonly value="${item.qty}">
            <button type="button" onclick="updateQty(${idx}, 1)" aria-label="Increase quantity">+</button>
          </div>
        </div>
        <div>
          <button type="button" class="cart-del-btn" onclick="removeItem(${idx})" aria-label="Remove item" title="Remove item">
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

  if(totalEl) totalEl.innerText = `RM ${grandTotal.toFixed(2)}`;

  let itemsText = '';
  cart.forEach((item, index) => {
    const subtotal = item.val * item.qty;
    const detail = item.size ? `(${item.size})` : `(${item.s})`;
    itemsText += `${index + 1}. *${item.n}* ${detail}\n   • Quantity: ${item.qty} unit/vial\n   • Price: RM${item.val.toFixed(2)} x ${item.qty} = RM${subtotal.toFixed(2)}\n\n`;
  });

  const message = `Hello Novex Peptides, I would like to place an order for the following items:\n\n${itemsText}*Total Order: RM ${grandTotal.toFixed(2)}*\n\nPlease confirm stock availability and payment / shipping details. Thank you!`;
  
  if(checkoutBtn){
    checkoutBtn.setAttribute('href', `https://wa.me/${WA_PHONE}?text=${encodeURIComponent(message)}`);
  }
}

function updateQty(index, delta){
  const cart = loadCartItems();
  if(!cart[index]) return;
  cart[index].qty += delta;
  if(cart[index].qty <= 0) cart.splice(index, 1);
  saveCartItems(cart);
  renderCartPage();
}

function removeItem(index){
  const cart = loadCartItems();
  if(!cart[index]) return;
  cart.splice(index, 1);
  saveCartItems(cart);
  renderCartPage();
}

document.addEventListener('DOMContentLoaded', renderCartPage);
</script>
@endsection