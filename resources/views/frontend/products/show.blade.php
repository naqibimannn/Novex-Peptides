@extends('frontend.home.index')

@section('content')
@php
$resolveImageUrl = function($path) {
    if (empty($path)) return asset('reta1.webp');
    if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
    
    $clean = ltrim($path, '/');
    $checkPaths = [
        $clean,
        'uploads/products/' . basename($clean),
        'storage/' . $clean,
    ];

    foreach ($checkPaths as $p) {
        $realPath = public_path($p);
        if (file_exists($realPath)) {
            return asset($p) . '?v=' . filemtime($realPath);
        }
    }
    return asset($clean) . '?v=' . time();
};

$allProducts = [
    'retatrutide' => [
        'id'            => 'retatrutide',
        'db_id'         => null,
        'name'          => 'Retatrutide',
        'title'         => 'Advanced Weight Management',
        'spec'          => '10mg - 100mg',
        'val'           => 280,
        'price'         => 'RM280.00 - RM980.00',
        'category'      => 'Weight Management',
        'page_type'     => 'products',
        'imgs'          => ['reta1.webp', 'reta2.webp', 'reta3.webp', 'reta4.webp', 'reta5.webp'],
        'stock'         => 63,
        'variant_title' => 'Select Vial Concentration / Dosage:',
        'variants'      => [
            ['label' => '10mg', 'val' => 280, 'p' => 'RM280.00', 'stock' => 25],
            ['label' => '30mg', 'val' => 480, 'p' => 'RM480.00', 'stock' => 18],
            ['label' => '60mg', 'val' => 780, 'p' => 'RM780.00', 'stock' => 12],
            ['label' => '100mg', 'val' => 980, 'p' => 'RM980.00', 'stock' => 8],
        ],
        'sizes'         => [],
        'desc'          => 'High-purity lyophilised triple-receptor agonist peptide synthesized for metabolic pathway investigations and weight management receptor studies. Select your preferred vial concentration above to view exact pricing.',
    ],
    'jersey-01' => [
        'id'            => 'jersey-01',
        'db_id'         => null,
        'name'          => 'Premium Athletic Jersey',
        'title'         => 'Performance. Style. Everyday.',
        'spec'          => 'Adult Size',
        'val'           => 40,
        'price'         => 'RM40.00',
        'category'      => 'Apparel',
        'page_type'     => 'products',
        'imgs'          => ['jry1.webp', 'jry2.webp'],
        'stock'         => 50,
        'variant_title' => 'Select Vial Concentration / Dosage:',
        'variants'      => [],
        'sizes'         => ['S', 'M', 'L', 'XL'],
        'desc'          => 'Official Novex Peptides merchandise. Crafted with lightweight, breathable, and moisture-wicking hexagonal weave fabric. Features premium V-neck design and durable finish.',
    ]
];

try {
    $dbRows = \Illuminate\Support\Facades\DB::select("SELECT * FROM products");
    foreach ($dbRows as $row) {
        $imgs = [];
        if (!empty($row->image)) {
            $decodedImg = json_decode($row->image, true);
            $rawList = (json_last_error() === JSON_ERROR_NONE && is_array($decodedImg) && count($decodedImg) > 0)
                ? $decodedImg
                : [$row->image];
            $imgs = $rawList;
        }
        if (empty($imgs)) {
            $imgs = ['reta1.webp'];
        }

        $variants = [];
        if (!empty($row->has_variants) && !empty($row->variants)) {
            $decodedVar = is_string($row->variants) ? json_decode($row->variants, true) : $row->variants;
            if (is_array($decodedVar)) {
                foreach ($decodedVar as $v) {
                    $vVal = (float)($v['val'] ?? 0);
                    if ($vVal <= 0 && preg_match('/([0-9]+(?:\.[0-9]+)?)/', $v['price'] ?? '', $vm)) {
                        $vVal = (float)$vm[1];
                    }
                    $variants[] = [
                        'label' => $v['label'] ?? '',
                        'val'   => $vVal,
                        'p'     => !empty($v['price']) ? $v['price'] : ('RM' . number_format($vVal, 2)),
                        'stock' => (int)($v['stock'] ?? 0),
                    ];
                }
            }
        }

        $sizes = [];
        if (!empty($row->sizes)) {
            $decodedSizes = is_string($row->sizes) ? json_decode($row->sizes, true) : $row->sizes;
            if (is_array($decodedSizes)) {
                $sizes = array_values(array_filter(array_map('trim', $decodedSizes)));
            } elseif (is_string($row->sizes)) {
                $sizes = array_values(array_filter(array_map('trim', explode(',', $row->sizes))));
            }
        }

        $numericVal = (float)($row->price_val ?? 0);
        if ($numericVal <= 0 && preg_match('/([0-9]+(?:\.[0-9]+)?)/', $row->price ?? '', $m)) {
            $numericVal = (float)$m[1];
        }

        $rawSlug = property_exists($row, 'slug') && !empty($row->slug) ? $row->slug : '';
        $key = $rawSlug ?: \Illuminate\Support\Str::slug($row->title ?? ('product-' . $row->id));

        $itemData = [
            'id'            => $key,
            'db_id'         => $row->id,
            'name'          => $row->title ?? 'Untitled Product',
            'title'         => $row->subtitle ?? '',
            'spec'          => !empty($row->dosage_spec) ? $row->dosage_spec : '',
            'val'           => $numericVal,
            'price'         => !empty($row->price) ? $row->price : ('RM' . number_format($numericVal, 2)),
            'category'      => !empty($row->category) ? $row->category : 'Weight Management',
            'page_type'     => $row->page_type ?? 'products',
            'imgs'          => $imgs,
            'stock'         => (int)($row->stock ?? 0),
            'variant_title' => !empty($row->variant_title) ? $row->variant_title : 'Select Vial Concentration / Dosage:',
            'variants'      => $variants,
            'sizes'         => $sizes,
            'desc'          => !empty($row->description) ? $row->description : ($allProducts[$key]['desc'] ?? 'High-purity laboratory formulation verified with third-party quality control.'),
        ];

        $allProducts[$key] = $itemData;
        $allProducts[\Illuminate\Support\Str::slug($row->title ?? '')] = $itemData;
        $allProducts[strtolower(trim($row->title ?? ''))] = $itemData;
        $allProducts[(string)$row->id] = $itemData;
    }
} catch (\Throwable $e) {}

$reqKey = $id ?? request()->route('id') ?? request()->route('product') ?? request()->segment(2) ?? 'retatrutide';
if (is_object($reqKey)) {
    $reqKey = $reqKey->slug ?? $reqKey->id ?? 'retatrutide';
}
$reqKey = urldecode((string)$reqKey);

$currProd = $allProducts[$reqKey]
    ?? $allProducts[strtolower($reqKey)]
    ?? $allProducts[\Illuminate\Support\Str::slug($reqKey)]
    ?? reset($allProducts);

$hasVariants = !empty($currProd['variants']) && count($currProd['variants']) > 0;
$isApparel   = ($currProd['category'] === 'Apparel') || (!empty($currProd['sizes']) && count($currProd['sizes']) > 0);

$firstSegment = request()->segment(1);

$isPremium = ($firstSegment === 'premium') 
    || request()->is('premium*') 
    || (($currProd['page_type'] ?? '') === 'premium') 
    || in_array($currProd['category'] ?? '', ['Premium Supplements', 'Supplements']);

$isPerformance = ($firstSegment === 'performance') 
    || request()->is('performance*') 
    || (($currProd['page_type'] ?? '') === 'performance') 
    || in_array($currProd['category'] ?? '', ['Performance', 'Performance Apparel']);

$isAccessory = ($firstSegment === 'accessory') 
    || request()->is('accessory*') 
    || (($currProd['page_type'] ?? '') === 'accessory') 
    || in_array($currProd['category'] ?? '', ['Accessory', 'Injection Kit', 'Syringes']);
@endphp

<section class="sec block pt-10 pb-[60px] min-[901px]:pt-[60px] min-[901px]:pb-20 bg-transparent" id="productDetailSec">
  <div class="wrap max-w-[1200px] mx-auto px-4 sm:px-6">
    <div class="mb-6">
      @if($isPremium)
        <a href="{{ url('/premium') }}" class="text-[13px] font-semibold text-[#2F6F9F] dark:text-[#327BB3] hover:underline">← Back to Premium Supplements</a>
      @elseif($isPerformance)
        <a href="{{ url('/performance') }}" class="text-[13px] font-semibold text-[#2F6F9F] dark:text-[#327BB3] hover:underline">← Back to Performance Division</a>
      @elseif($isAccessory)
        <a href="{{ route('accessory') }}" class="text-[13px] font-semibold text-[#2F6F9F] dark:text-[#327BB3] hover:underline">← Back to Accessories</a>
      @else
        <a href="{{ route('products.index') }}" class="text-[13px] font-semibold text-[#2F6F9F] dark:text-[#327BB3] hover:underline">← Back to Catalog</a>
      @endif
    </div>

    <div class="detail-grid grid grid-cols-1 min-[901px]:grid-cols-[1.15fr_1fr] gap-8 min-[901px]:gap-12 items-start">
      <div class="detail-media-wrap w-full max-w-[480px] min-[901px]:max-w-[580px] mx-auto min-[901px]:mx-0 flex flex-col">
        <div class="detail-img-wrap prod-slider relative aspect-square w-full rounded-[28px] overflow-hidden bg-transparent border-0">
          <div class="prod-slides relative w-full h-full rounded-[28px] overflow-hidden bg-transparent">
            @foreach($currProd['imgs'] as $idx => $imgFile)
              <div class="prod-slide contain-slide absolute inset-0 w-full h-full opacity-0 transition-opacity duration-700 ease-in-out pointer-events-none rounded-[28px] overflow-hidden bg-transparent flex items-center justify-center p-0 {{ $idx === 0 ? 'active !opacity-100 !pointer-events-auto' : '' }}">
                <img src="{{ $resolveImageUrl($imgFile) }}" 
                     alt="{{ $currProd['name'] }} Slide {{ $idx + 1 }}" 
                     onload="fitRoundedImg(this)"
                     onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=1000'"
                     class="w-auto h-auto max-w-full max-h-full object-contain rounded-[28px] bg-transparent shadow-none shrink-0 block">
              </div>
            @endforeach
          </div>
        </div>

        @if(count($currProd['imgs']) > 1)
          <div class="ps-dots relative flex justify-center items-center gap-1.5 mt-3.5 mb-0.5 z-[5]">
            @foreach($currProd['imgs'] as $idx => $imgFile)
              <span class="ps-dot w-2 h-2 rounded-full bg-[#D2E2EF] dark:bg-[#1C2D3E] cursor-pointer transition-all duration-250 hover:bg-[#5A6F82] {{ $idx === 0 ? 'active !bg-[#2F6F9F] dark:!bg-[#327BB3] !w-[22px]' : '' }}" onclick="setImgSlide(this, {{ $idx }})"></span>
            @endforeach
          </div>
        @endif
      </div>

      <div class="detail-info flex flex-col gap-4 text-left">
        <span class="detail-badge inline-block bg-[#E9F2FA] dark:bg-[#101B27] text-[#2F6F9F] dark:text-[#327BB3] py-1.5 px-3.5 rounded-full text-xs font-semibold tracking-[0.04em] self-start border border-[#D2E2EF] dark:border-[#1C2D3E]">{{ $currProd['category'] }}</span>
        <h1 class="font-serif font-medium leading-[1.15] text-[clamp(28px,4vw,44px)] text-[#1E2D3B] dark:text-[#F0F6FC]">{{ $currProd['name'] }}</h1>
        <p id="detailSubDisplay" class="text-base text-[#5A6F82] dark:text-[#8EA4B8]">
          {{ $currProd['title'] }}{{ !empty($currProd['spec']) ? ' (' . $currProd['spec'] . ')' : '' }}
        </p>
        <div id="detailPriceDisplay" class="detail-price font-serif text-[clamp(26px,3vw,34px)] font-bold text-[#2F6F9F] dark:text-[#327BB3]">{{ $currProd['price'] }}</div>
        
        <div id="detailStockDisplay" class="stock-badge inline-flex items-center text-[13px] font-semibold text-[#1ebe5a] bg-[#25D366]/[0.12] py-1 px-3.5 rounded-full self-start">In Stock ({{ $currProd['stock'] }} units available)</div>

        @if($hasVariants)
        <div class="mt-1.5 bg-[#F6FAFD] dark:bg-[#0E1824] p-4 rounded-[18px] border border-[#D2E2EF] dark:border-[#1C2D3E]">
          <label class="text-xs font-bold uppercase text-[#1E2D3B] dark:text-[#F0F6FC] block mb-1.5">
            {{ $currProd['variant_title'] }}
          </label>
          <div class="size-picker flex gap-2 flex-wrap my-2" id="variantPickerGroup">
            @foreach($currProd['variants'] as $vIdx => $v)
              <button type="button" class="size-btn var-btn border border-[#D2E2EF] dark:border-[#1C2D3E] bg-white dark:bg-[#132232] py-2 px-4 text-[13px] font-semibold rounded-[10px] cursor-pointer transition-all duration-200 text-[#1E2D3B] dark:text-[#F0F6FC] hover:border-[#2F6F9F] dark:hover:border-[#327BB3] [&.active]:!bg-[#2F6F9F] dark:[&.active]:!bg-[#327BB3] [&.active]:!text-white [&.active]:!border-[#2F6F9F] dark:[&.active]:!border-[#327BB3] {{ $vIdx === 0 ? 'active' : '' }}" onclick="selectProductVariant({{ $vIdx }}, this)">
                {{ $v['label'] }}
              </button>
            @endforeach
          </div>
          <small id="varHint" class="text-xs text-[#5A6F82] dark:text-[#8EA4B8] block mt-1">
            Select a dosage above to display the exact price.
          </small>
        </div>
        @endif

        @if($isApparel)
        <div class="mt-2.5">
          <div class="flex justify-between items-center">
            <label class="text-xs font-semibold uppercase text-[#5A6F82] dark:text-[#8EA4B8]">Select Size:</label>
            <a class="chart-link text-xs text-[#3F84B5] dark:text-[#5CA5DA] underline cursor-pointer font-medium inline-block" onclick="openSizeModal()">View Size Chart</a>
          </div>
          <div class="size-picker flex gap-2 flex-wrap my-2" id="sizePickerGroup">
            @foreach($currProd['sizes'] as $sIdx => $sz)
              <button type="button" class="size-btn border border-[#D2E2EF] dark:border-[#1C2D3E] bg-white dark:bg-[#132232] py-2 px-4 text-[13px] font-semibold rounded-[10px] cursor-pointer transition-all duration-200 text-[#1E2D3B] dark:text-[#F0F6FC] hover:border-[#2F6F9F] dark:hover:border-[#327BB3] [&.active]:!bg-[#2F6F9F] dark:[&.active]:!bg-[#327BB3] [&.active]:!text-white [&.active]:!border-[#2F6F9F] dark:[&.active]:!border-[#327BB3] {{ $sIdx === 0 ? 'active' : '' }}" onclick="selectProductSize('{{ $sz }}', this)">
                {{ $sz }}
              </button>
            @endforeach
          </div>
        </div>
        @endif

        <div class="detail-desc text-sm leading-[1.7] text-[#3A4D5E] dark:text-[#8EA4B8] border-y border-[#D2E2EF] dark:border-[#1C2D3E] py-5">
          <h4 class="font-serif text-[20px] font-medium mb-2 text-[#1E2D3B] dark:text-[#F0F6FC]">Product Overview</h4>
          <p>{{ $currProd['desc'] }}</p>
        </div>

        <div class="qty-row flex items-center gap-4 mt-2 flex-wrap">
          <div class="qty-box inline-flex items-center border border-[#D2E2EF] dark:border-[#1C2D3E] rounded-full bg-[#F6FAFD] dark:bg-[#0E1824] overflow-hidden">
            <button type="button" class="w-10 h-10 bg-transparent text-[17px] font-semibold flex items-center justify-center cursor-pointer border-0 text-[#1E2D3B] dark:text-[#F0F6FC] hover:bg-[#E9F2FA] dark:hover:bg-[#101B27]" onclick="changeDetailQty(-1, {{ (int)$currProd['stock'] }})">-</button>
            <input type="text" id="detailQtyInput" readonly value="1" class="w-[46px] text-center border-0 bg-transparent font-semibold text-sm text-[#1E2D3B] dark:text-[#F0F6FC] outline-none">
            <button type="button" class="w-10 h-10 bg-transparent text-[17px] font-semibold flex items-center justify-center cursor-pointer border-0 text-[#1E2D3B] dark:text-[#F0F6FC] hover:bg-[#E9F2FA] dark:hover:bg-[#101B27]" onclick="changeDetailQty(1, {{ (int)$currProd['stock'] }})">+</button>
          </div>
          <button class="btn-add-cart bg-[#2F6F9F] dark:bg-[#327BB3] hover:bg-[#245a82] dark:hover:bg-[#286391] active:scale-[0.98] text-white py-3.5 px-7 font-semibold text-sm rounded-full flex-1 min-w-[160px] text-center border-0 cursor-pointer transition-all duration-200" onclick="triggerAddToCart()">Add to Cart</button>
        </div>

        <div class="mt-[18px] text-xs text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.6] border-t border-[#D2E2EF] dark:border-[#1C2D3E] pt-3.5 space-y-1">
          <p>• High purity formulation verified with third-party quality control.</p>
          <p>• Secure thermal-insulated packaging for all temperature-sensitive items.</p>
          <p>• Direct WhatsApp support available for wholesale or technical inquiries.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal-overlay fixed inset-0 bg-black/60 z-[999] hidden [&.open]:flex items-center justify-center p-4 backdrop-blur-[4px]" id="sizeModal" onclick="if(event.target===this)closeSizeModal()">
  <div class="modal-content bg-white dark:bg-[#132232] rounded-[20px] max-w-[540px] w-full p-7 relative shadow-[0_20px_40px_rgba(0,0,0,0.2)] max-h-[90vh] overflow-y-auto border border-[#D2E2EF] dark:border-[#1C2D3E]">
    <button class="modal-close absolute top-4 right-4 bg-transparent border-0 text-[22px] text-[#5A6F82] dark:text-[#8EA4B8] hover:text-red-500 cursor-pointer" onclick="closeSizeModal()">&times;</button>
    <h3 class="font-serif text-2xl font-medium mb-1.5 text-[#1E2D3B] dark:text-[#F0F6FC]">Size Chart (Adult)</h3>
    <p class="text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] mb-3">Novex Premium Athletic Jersey — All measurements in inches.</p>
    <div class="table-scroll w-full overflow-x-auto my-4">
      <table class="size-table w-full border-collapse text-[13px] text-center min-w-[440px]">
        <thead>
          <tr>
            <th class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2 bg-[#E9F2FA] dark:bg-[#101B27] text-[#2F6F9F] dark:text-[#327BB3] font-semibold">Size</th>
            <th class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2 bg-[#E9F2FA] dark:bg-[#101B27] text-[#2F6F9F] dark:text-[#327BB3] font-semibold">Length (A)</th>
            <th class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2 bg-[#E9F2FA] dark:bg-[#101B27] text-[#2F6F9F] dark:text-[#327BB3] font-semibold">Chest (B)</th>
            <th class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2 bg-[#E9F2FA] dark:bg-[#101B27] text-[#2F6F9F] dark:text-[#327BB3] font-semibold">Shoulder</th>
            <th class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2 bg-[#E9F2FA] dark:bg-[#101B27] text-[#2F6F9F] dark:text-[#327BB3] font-semibold">Short Sleeve</th>
            <th class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2 bg-[#E9F2FA] dark:bg-[#101B27] text-[#2F6F9F] dark:text-[#327BB3] font-semibold">Long Sleeve</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2"><b>S</b></td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">26</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">38</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">16</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">8.5</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">22.5</td>
          </tr>
          <tr>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2"><b>M</b></td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">27</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">40</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">17</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">9</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">23</td>
          </tr>
          <tr>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2"><b>L</b></td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">28</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">42</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">18</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">9.5</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">23.5</td>
          </tr>
          <tr>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2"><b>XL</b></td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">29</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">44</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">19</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">10</td>
            <td class="border border-[#D2E2EF] dark:border-[#1C2D3E] py-2.5 px-2">24</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="text-xs text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.6] bg-[#E9F2FA] dark:bg-[#101B27] p-3.5 rounded-xl border border-[#D2E2EF] dark:border-[#1C2D3E]">
      <b class="text-[#1E2D3B] dark:text-[#F0F6FC]">How to Measure:</b><br>
      • <b>Length (A):</b> Measure from the highest point of the shoulder to the bottom of the shirt.<br>
      • <b>Chest (B):</b> Measure around the fullest part of the chest, keeping the tape horizontal.
    </div>
  </div>
</div>

<script>
  let currentDetailProduct = @json($currProd);
  let currentDetailQty = 1;
  let currentDetailSize = (currentDetailProduct.sizes && currentDetailProduct.sizes.length > 0) ? currentDetailProduct.sizes[0] : 'S';
  let currentSelectedVariant = (currentDetailProduct.variants && currentDetailProduct.variants.length > 0) ? currentDetailProduct.variants[0] : null;

  function fitRoundedImg(el){
    if(!el || !el.naturalWidth || !el.naturalHeight) return;
    const r = el.naturalWidth / el.naturalHeight;
    el.style.aspectRatio = el.naturalWidth + ' / ' + el.naturalHeight;
    if(r >= 1){
      el.style.width = '100%';
      el.style.height = 'auto';
    } else {
      el.style.height = '100%';
      el.style.width = 'auto';
    }
  }

  function setImgSlide(dot, targetIdx){
    if(window.event){
      window.event.preventDefault();
      window.event.stopPropagation();
    }
    const wrap = dot.closest('.detail-media-wrap') || document.getElementById('productDetailSec');
    if(!wrap) return;
    const box = wrap.querySelector('.prod-slider');
    if(!box) return;
    const slides = box.querySelectorAll('.prod-slide');
    const dots = wrap.querySelectorAll('.ps-dot');
    slides.forEach((s, idx)=>s.classList.toggle('active', idx === targetIdx));
    dots.forEach((d, idx)=>d.classList.toggle('active', idx === targetIdx));
  }

  function changeDetailQty(delta, maxStock){
    const limit = currentSelectedVariant ? currentSelectedVariant.stock : maxStock;
    currentDetailQty = Math.max(1, Math.min(limit > 0 ? limit : 99, currentDetailQty + delta));
    const el = document.getElementById('detailQtyInput');
    if(el) el.value = currentDetailQty;
  }

  function selectProductSize(size, btnEl){
    currentDetailSize = size;
    const group = document.getElementById('sizePickerGroup');
    if(group) {
      group.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    }
    if(btnEl) btnEl.classList.add('active');
  }

  function selectProductVariant(idx, btnEl){
    if(!currentDetailProduct.variants || !currentDetailProduct.variants[idx]) return;
    const v = currentDetailProduct.variants[idx];
    currentSelectedVariant = v;

    const group = document.getElementById('variantPickerGroup');
    if(group) {
      group.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    }
    if(btnEl) btnEl.classList.add('active');

    const priceEl = document.getElementById('detailPriceDisplay');
    const subEl = document.getElementById('detailSubDisplay');
    const stockEl = document.getElementById('detailStockDisplay');
    const hintEl = document.getElementById('varHint');

    if(priceEl) priceEl.innerText = v.p;
    if(subEl) subEl.innerText = `${currentDetailProduct.title} (${v.label})`;
    if(stockEl) stockEl.innerText = `In Stock (${v.stock} units available)`;
    if(hintEl) hintEl.style.display = 'none';

    if(currentDetailQty > v.stock && v.stock > 0){
      currentDetailQty = 1;
      const qEl = document.getElementById('detailQtyInput');
      if(qEl) qEl.value = 1;
    }
  }

  function openSizeModal(){
    const m = document.getElementById('sizeModal');
    if(m) m.classList.add('open');
  }
  function closeSizeModal(){
    const m = document.getElementById('sizeModal');
    if(m) m.classList.remove('open');
  }

  function triggerFlyAnimation(sourceImgEl){
    const cartBtn = document.getElementById('headerCartBtn') || document.querySelector('.cart-trigger-btn');
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
    flyer.style.zIndex = '99999';
    flyer.style.pointerEvents = 'none';
    flyer.style.objectFit = 'contain';

    document.body.appendChild(flyer);
    flyer.getBoundingClientRect();

    const destX = destRect.left + (destRect.width / 2) - 15;
    const destY = destRect.top + (destRect.height / 2) - 15;

    requestAnimationFrame(()=>{
      flyer.style.top = destY + 'px';
      flyer.style.left = destX + 'px';
      flyer.style.width = '30px';
      flyer.style.height = '30px';
      flyer.style.borderRadius = '50%';
      flyer.style.opacity = '0.3';
      flyer.style.transform = 'scale(0.4)';
    });

    setTimeout(()=>{
      flyer.remove();
      cartBtn.classList.add('cart-bump');
      setTimeout(()=>cartBtn.classList.remove('cart-bump'), 350);
    }, 760);
  }

  function triggerAddToCart(){
    let cart = [];
    try {
      cart = JSON.parse(localStorage.getItem('nvx_cart') || '[]');
    } catch(e) {
      cart = [];
    }

    let itemSpec = currentDetailProduct.spec || '';
    let itemVal = parseFloat(currentDetailProduct.val) || 0;
    let itemLabel = currentDetailProduct.name || '';

    if(currentSelectedVariant){
      itemSpec = currentSelectedVariant.label;
      itemVal = parseFloat(currentSelectedVariant.val) || itemVal;
    } else if(currentDetailProduct.sizes && currentDetailProduct.sizes.length > 0){
      itemSpec = 'Size: ' + currentDetailSize;
    }

    const firstImg = (currentDetailProduct.imgs && currentDetailProduct.imgs.length > 0) ? currentDetailProduct.imgs[0] : 'reta1.webp';
    const existing = cart.find(x => x.id === currentDetailProduct.id && (x.s === itemSpec || x.size === itemSpec));

    if(existing){
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
      if(badge){
        badge.innerText = cart.reduce((acc, item) => acc + (parseInt(item.qty, 10) || 1), 0);
      }
    }

    const mainImgEl = document.querySelector('.detail-img-wrap .prod-slide.active img') || document.querySelector('.detail-img-wrap img');
    triggerFlyAnimation(mainImgEl);

    if (typeof showToast === 'function') {
      showToast('✓ Added to cart');
    }
  }

  document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.contain-slide img').forEach(el => {
      if(el.complete) fitRoundedImg(el);
    });

    if (@json($isPremium)) {
      const catalogBtn = document.querySelector('#ddCatalog .dd-trigger');
      if (catalogBtn) catalogBtn.classList.remove('on');

      const storeBtn = document.querySelector('#ddStore .dd-trigger');
      if (storeBtn) storeBtn.classList.add('on');

      document.querySelectorAll('nav.mnav a').forEach(a => {
        const href = a.getAttribute('href') || '';
        if (href.includes('premium')) a.classList.add('on');
        if (href.includes('products')) a.classList.remove('on');
      });
    } else if (@json($isPerformance)) {
      const catalogBtn = document.querySelector('#ddCatalog .dd-trigger');
      if (catalogBtn) catalogBtn.classList.remove('on');

      const storeBtn = document.querySelector('#ddStore .dd-trigger');
      if (storeBtn) storeBtn.classList.add('on');

      document.querySelectorAll('nav.mnav a').forEach(a => {
        const href = a.getAttribute('href') || '';
        if (href.includes('performance')) a.classList.add('on');
        if (href.includes('products')) a.classList.remove('on');
      });
    } else if (@json($isAccessory)) {
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
    if(detailSec && footerEl && footerEl.parentNode) {
      footerEl.parentNode.insertBefore(detailSec, footerEl);
    }
  });
</script>
@endsection