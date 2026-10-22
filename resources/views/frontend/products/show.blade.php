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
.btn-wa-order{
  background:#25D366;
  color:#fff;
  padding:14px 28px;
  font-weight:600;
  font-size:14px;
  border-radius:999px;
  flex:1;
  min-width:180px;
  text-align:center;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:8px;
  transition:background .2s ease, transform .1s ease;
}
.btn-wa-order:hover{background:#1ebe5a}
.btn-wa-order:active{transform:scale(0.98)}

@media(max-width:900px){
  .detail-grid{grid-template-columns:1fr}
  .detail-img-wrap{max-width:480px;margin:0 auto;width:100%}
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

        <div class="qty-row">
          <div class="qty-box">
            <button type="button" onclick="changeDetailQty(-1)" aria-label="Decrease quantity">-</button>
            <input type="text" id="detailQtyInput" readonly value="1">
            <button type="button" onclick="changeDetailQty(1)" aria-label="Increase quantity">+</button>
          </div>
          
          <a id="waOrderBtn" class="btn-wa-order" href="https://wa.me/601112085054?text=Hello%20Novex%20Peptides%2C%20I%20would%20like%20to%20order%20Retatrutide%20(10mg)%20x1" target="_blank">
            <svg viewBox="0 0 32 32" width="18" height="18" fill="#fff" aria-hidden="true"><path d="M16 3C8.8 3 3 8.8 3 16c0 2.3.6 4.5 1.7 6.4L3 29l6.8-1.8A13 13 0 0 0 16 29c7.2 0 13-5.8 13-13S23.2 3 16 3zm0 23.8c-2 0-3.9-.6-5.6-1.6l-.4-.2-4 1 1.1-3.9-.3-.4A10.7 10.7 0 1 1 16 26.8zm5.9-8c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2l-1 1.2c-.2.2-.4.2-.7.1-1.900-.9-3.100-1.700-4.300-3.800-.3-.6.3-.5.9-1.700.1-.2 0-.4 0-.5l-1-2.300c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.200 1.100-1.200 2.800s1.200 3.300 1.400 3.500c.2.2 2.400 3.700 5.900 5.200 2.200.9 3 1 4.100.8.700-.1 1.900-.8 2.200-1.500.3-.7.3-1.400.2-1.500-.1-.2-.3-.2-.6-.4z"/></svg>
            <span>Order via WhatsApp</span>
          </a>
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

<script>
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

  updateWhatsAppLink();
}

function changeDetailQty(delta){
  currentQty = Math.max(1, Math.min(currentMaxStock, currentQty + delta));
  document.getElementById('detailQtyInput').value = currentQty;
  updateWhatsAppLink();
}

function updateWhatsAppLink(){
  const total = (currentUnitVal * currentQty).toFixed(2);
  const text = `Hello Novex Peptides, I would like to place an order for:
• Retatrutide (${currentSelectedDosage})
• Quantity: ${currentQty} vial(s)
• Total: RM ${total}

Please confirm availability and dispatch schedule. Thank you!`;

  const waUrl = `https://wa.me/601112085054?text=${encodeURIComponent(text)}`;
  document.getElementById('waOrderBtn').setAttribute('href', waUrl);
}
</script>
@endsection