@extends('frontend.home.index')

@section('content')
<style>
.cart-page-wrap{
  max-width:680px;
  margin:0 auto;
}
.cart-card{
  background:var(--card-surface);
  border:1px solid var(--line);
  border-radius:26px;
  padding:32px;
  box-shadow:0 12px 36px rgba(14,40,66,.05);
  transition:background-color .25s ease, border-color .25s ease;
}
.cart-items{
  display:flex;
  flex-direction:column;
  gap:14px;
}
.cart-item{
  display:grid;
  grid-template-columns:64px 1fr auto auto;
  gap:14px;
  align-items:center;
  border-bottom:1px solid var(--line);
  padding-bottom:14px;
  transition:border-color .25s ease;
}
.cart-item:last-child{
  border-bottom:none;
  padding-bottom:0;
}
.cart-item-img{
  aspect-ratio:1;
  border-radius:12px;
  overflow:hidden;
  background:var(--card-surface);
  border:1px solid var(--line);
  display:flex;
  align-items:center;
  justify-content:center;
  padding:4px;
}
.cart-item-img img{
  max-width:100%;
  max-height:100%;
  width:auto;
  height:auto;
  object-fit:contain;
  border-radius:8px;
}
.qty-box{
  display:inline-flex;
  align-items:center;
  border:1px solid var(--line);
  border-radius:999px;
  background:var(--card);
  overflow:hidden;
  transform:scale(0.88);
  transform-origin:center;
  transition:background-color .25s ease, border-color .25s ease;
}
.qty-box button{
  width:38px;
  height:38px;
  background:none;
  border:none;
  font-size:16px;
  font-weight:600;
  display:flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
  color:var(--ink);
  transition:background .2s ease;
}
.qty-box button:hover{background:var(--bg2)}
.qty-box input{
  width:42px;
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
  background:rgba(225,29,72,.12);
  color:var(--red);
}
.cart-footer{
  margin-top:24px;
  padding-top:22px;
  border-top:1px solid var(--line);
}
.cart-total-row{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:18px;
  font-size:16px;
  color:var(--ink);
}
.cart-total-price{
  font-size:26px;
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
  text-decoration:none;
  transition:background .2s ease, transform .1s ease;
}
.btn-wa-proceed:hover{background:#1ebe5a}
.btn-wa-proceed:active{transform:scale(0.98)}
.btn-wa-proceed svg{width:20px;height:20px;fill:#fff}

@media(max-width:640px){
  .cart-card{padding:20px 16px}
  .cart-item{grid-template-columns:54px 1fr auto auto;gap:10px}
  .cart-total-price{font-size:22px}
}
</style>

<section class="sec">
  <div class="wrap cart-page-wrap">
    <div class="head" style="margin-bottom:28px">
      <div>
        <h1 style="font-size:clamp(32px,4vw,42px)">Your Research Cart</h1>
        <p>Review your selected compounds and items before proceeding to WhatsApp checkout.</p>
      </div>
    </div>

    <div class="cart-card">
      <div class="cart-items" id="cartItemsList"></div>

      <div class="cart-footer" id="cartFooterSection">
        <div class="cart-total-row">
          <span style="font-weight:600">Total Order:</span>
          <span class="cart-total-price" id="cartTotal">RM 0.00</span>
        </div>
        
        <button type="button" class="btn-wa-proceed" onclick="proceedToWhatsApp()">
          <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 0 0 16 29c7.2 0 13-5.8 13-13S23.2 3 16 3zm0 23.8c-2 0-3.9-.6-5.6-1.6l-.4-.2-4 1 1.1-3.9-.3-.4A10.7 10.7 0 1 1 16 26.8zm5.9-8c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2l-1 1.2c-.2.2-.4.2-.7.1-1.900-.9-3.100-1.700-4.300-3.800-.3-.6.3-.5.9-1.700.1-.2 0-.4 0-.5l-1-2.300c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.200 1.100-1.200 2.800s1.200 3.300 1.400 3.500c.2.2 2.400 3.700 5.900 5.200 2.200.9 3 1 4.100.8.700-.1 1.900-.8 2.200-1.500.3-.7.3-1.400.2-1.500-.1-.2-.3-.2-.6-.4z"/></svg>
          <span>Click To Proceed</span>
        </button>
      </div>
    </div>
  </div>
</section>

<script>
const WA = '601112085054';

let CART = JSON.parse(localStorage.getItem('nvx_cart') || '[]');

function saveCart(){
  localStorage.setItem('nvx_cart', JSON.stringify(CART));
  if(typeof updateCartBadge === 'function') updateCartBadge();
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
  if(typeof showToast === 'function') showToast('Item removed from cart');
}

function renderCart(){
  const listEl = document.getElementById('cartItemsList');
  const footerEl = document.getElementById('cartFooterSection');
  const totalEl = document.getElementById('cartTotal');
  if(!listEl) return;

  if(CART.length === 0){
    listEl.innerHTML = `
      <div style="text-align:center;padding:48px 0;color:var(--mut)">
        <p style="font-size:16px;margin-bottom:12px">Your cart is empty.</p>
        <a href="{{ route('products.index') }}" class="btn" style="padding:10px 24px;font-size:13px">Explore Products</a>
      </div>
    `;
    if(footerEl) footerEl.style.display = 'none';
    if(totalEl) totalEl.innerText = 'RM 0.00';
    return;
  }

  if(footerEl) footerEl.style.display = 'block';

  let total = 0;
  listEl.innerHTML = CART.map((item, idx) => {
    const subtotal = item.val * item.qty;
    total += subtotal;
    const detailLabel = item.size ? item.size : item.s;
    const imgSrc = item.i.startsWith('http') ? item.i : `{{ asset('') }}/${item.i}`.replace(/([^:]\/)\/+/g, "$1");

    return `
      <div class="cart-item">
        <div class="cart-item-img">
          <img src="${imgSrc}" alt="${item.n}" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=150'">
        </div>
        <div>
          <h4 style="font-size:14px;line-height:1.25;margin-bottom:3px;color:var(--ink)">${item.n}</h4>
          <span style="font-size:12px;color:var(--mut)">${detailLabel} • RM ${item.val.toFixed(2)}</span>
          <div style="font-size:13px;font-weight:700;color:var(--green);margin-top:4px">RM ${subtotal.toFixed(2)}</div>
        </div>
        <div>
          <div class="qty-box">
            <button type="button" onclick="changeCartQty(${idx}, -1)" aria-label="Decrease quantity">-</button>
            <input type="text" readonly value="${item.qty}">
            <button type="button" onclick="changeCartQty(${idx}, 1)" aria-label="Increase quantity">+</button>
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

  if(totalEl) totalEl.innerText = `RM ${total.toFixed(2)}`;
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

document.addEventListener('DOMContentLoaded', () => {
  renderCart();
});
</script>
@endsection