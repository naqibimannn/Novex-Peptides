@php
    $rawProducts = $products ?? \Illuminate\Support\Facades\DB::select("SELECT * FROM products ORDER BY id DESC");
    $secretKey = $secret ?? config('admin.secret_key', env('ADMIN_SECRET_KEY', 'portal-admin-hyut746dhy74-novev-malaysia'));
    $secretPrefix = 'admin/' . $secretKey;

    $categories = [
        'Weight Management',
        'Skincare Peptides',
        'Skincare Collection',
        'Performance',
        'Apparel',
        'Accessory',
        'Injection Kit',
        'Syringes'
    ];
@endphp

<style>
  .admin-prod-slider {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
    border-radius: 14px;
    background: transparent;
  }
  .admin-prod-slides {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: inherit;
    overflow: hidden;
  }
  .admin-prod-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.65s ease-in-out;
    padding: 0.75rem;
    margin: 0;
    border-radius: inherit;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
  }
  .admin-prod-slide.active {
    opacity: 1;
    pointer-events: auto;
  }
  .admin-prod-slide img {
    max-width: 100% !important;
    max-height: 100% !important;
    width: auto !important;
    height: auto !important;
    object-fit: contain !important;
    object-position: center !important;
    border-radius: 12px !important;
    display: block;
    background: transparent;
  }
  .admin-ps-dots {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 25;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 8px;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(4px);
    border: 1px solid rgba(226, 232, 240, 0.8);
  }
  .admin-ps-dot {
    width: 6px;
    height: 6px;
    border-radius: 9999px;
    background: #cbd5e1;
    cursor: pointer;
    transition: all 0.25s ease;
  }
  .admin-ps-dot.active {
    width: 16px;
    background: #0f172a;
  }
</style>

<div class="m-0 flex flex-col gap-6">

  <!-- TOP HEADER -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-200">
    <div>
      <div class="flex items-center gap-2.5">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
          Product &amp; Accessory Vault
        </h1>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-tight bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs">
          {{ count($rawProducts) }} Total {{ count($rawProducts) === 1 ? 'Item' : 'Items' }}
        </span>
      </div>
      <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
        CentraDesk Catalog &middot; Manage laboratory formulations, multi-price variants, stock inventory, and page placement.
      </p>
    </div>

    <div class="flex items-center gap-2.5 shrink-0">
      <button type="button" onclick="openCreateProductModal()"
        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white font-bold text-xs shadow-sm transition-all active:scale-[0.98] cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        <span>Add New Product</span>
      </button>
    </div>
  </div>

  <!-- FILTER & SEARCH TOOLBAR -->
  <div class="relative z-30 bg-white border border-slate-200 rounded-xl p-3 shadow-2xs flex flex-col lg:flex-row lg:items-center justify-between gap-3">
    
    <div class="flex flex-wrap items-center gap-2.5 w-full lg:w-auto">
      <!-- Segmented Page Filter -->
      <div class="inline-flex p-1 rounded-xl bg-slate-100 border border-slate-200/80">
        <button type="button" onclick="switchPageTypeFilter('all', this)" class="page-type-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-white text-slate-900 shadow-2xs transition-all cursor-pointer">
          All Pages
        </button>
        <button type="button" onclick="switchPageTypeFilter('products', this)" class="page-type-btn px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 hover:text-slate-900 transition-all cursor-pointer">
          Products Page
        </button>
        <button type="button" onclick="switchPageTypeFilter('accessory', this)" class="page-type-btn px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 hover:text-slate-900 transition-all cursor-pointer">
          Accessory Page
        </button>
      </div>

      <!-- Category Dropdown -->
      <div class="relative w-full sm:w-56" id="customCategoryDropdownWrapper">
        <button type="button" onclick="toggleCategoryDropdown()" id="selectedCategoryBtn"
          class="w-full bg-slate-100/90 border border-slate-200 hover:border-brand/50 rounded-xl px-4 py-2 flex items-center justify-between gap-2 text-xs font-bold text-slate-800 shadow-2xs transition-all cursor-pointer">
          <span id="selectedCategoryText" class="truncate">All Categories</span>
          <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0" id="dropdownArrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </button>

        <div id="categoryDropdownMenu" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-slate-200/90 rounded-2xl shadow-2xl z-50 p-1.5 flex flex-col gap-1 max-h-64 overflow-y-auto">
          <button type="button" onclick="switchCategoryFilter('all', 'All Categories')"
            class="category-option-btn w-full text-left px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors cursor-pointer">
            <span>All Categories</span>
            <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded-md font-semibold text-slate-500">{{ count($rawProducts) }}</span>
          </button>

          @foreach($categories as $cat)
            @php
              $catCount = collect($rawProducts)->where('category', $cat)->count();
            @endphp
            <button type="button" onclick="switchCategoryFilter('{{ strtolower($cat) }}', '{{ $cat }}')"
              class="category-option-btn w-full text-left px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors cursor-pointer">
              <span class="truncate pr-2">{{ $cat }}</span>
              <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded-md font-semibold text-slate-500">{{ $catCount }}</span>
            </button>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Search & Count -->
    <div class="flex items-center gap-3 w-full lg:w-auto">
      <div class="relative flex-1 sm:w-64">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input type="text" id="productSearchInput" onkeyup="onSearchInput()" placeholder="Search formulation or keyword..."
          class="w-full bg-slate-50/70 focus:bg-white border border-slate-200 rounded-xl py-2 pl-9 pr-4 text-xs font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
      </div>

      <span class="text-xs font-semibold text-slate-400 whitespace-nowrap shrink-0" id="productCountText">
        Total {{ count($rawProducts) }} {{ count($rawProducts) === 1 ? 'item' : 'items' }}
      </span>
    </div>

  </div>

  <!-- PRODUCT GRID -->
  <div id="productGridContainer" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse($rawProducts as $product)
      @php
        $imgList = [];
        if (!empty($product->image)) {
            $decoded = json_decode($product->image, true);
            $imgList = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) 
                ? $decoded 
                : [$product->image];
        }
        $validImages = array_values(array_filter($imgList, fn($p) => !empty($p) && (file_exists(public_path($p)) || file_exists(public_path('uploads/products/' . basename($p))))));

        $decodedVariants = [];
        if (!empty($product->variants)) {
            $tmpVar = json_decode($product->variants, true);
            if (is_array($tmpVar)) $decodedVariants = $tmpVar;
        }
        $pagePlacement = strtolower($product->page_type ?? (($product->category ?? '') === 'Accessory' ? 'accessory' : 'products'));
        $stockCount = (int) ($product->stock ?? 0);
      @endphp

      <div class="product-vault-card group bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-2xs hover:shadow-md hover:border-brand/40 transition-all duration-200 flex flex-col justify-between"
        data-title="{{ strtolower($product->title) }}"
        data-subtitle="{{ strtolower($product->subtitle ?? '') }}"
        data-category="{{ strtolower($product->category ?? 'weight management') }}"
        data-pagetype="{{ $pagePlacement }}"
        data-dosage="{{ strtolower($product->dosage_spec ?? '') }}"
        data-keywords="{{ strtolower($product->keywords ?? '') }}">
        
        <div>
          <!-- MEDIA HEADER -->
          <div class="relative w-full h-52 p-3 bg-slate-50/70 border-b border-slate-100 flex items-center justify-center overflow-hidden">
            
            <!-- Top Floating Meta Badges -->
            <div class="absolute top-3 left-3 right-3 z-20 flex items-center justify-between gap-2 pointer-events-none">
              <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider {{ $pagePlacement === 'accessory' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-sky-100 text-sky-800 border border-sky-200' }} shadow-2xs">
                {{ $pagePlacement === 'accessory' ? 'Accessory Page' : 'Products Page' }}
              </span>

              <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[10px] font-bold border shadow-2xs {{ $stockCount > 10 ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : ($stockCount > 0 ? 'bg-amber-50 border-amber-200 text-amber-700' : 'bg-rose-50 border-rose-200 text-rose-700') }}">
                Stock: {{ $stockCount }}
              </span>
            </div>

            @if(count($validImages) > 1)
              <div class="admin-prod-slider">
                <div class="admin-prod-slides">
                  @foreach($validImages as $idx => $img)
                    <div class="admin-prod-slide {{ $idx === 0 ? 'active' : '' }}">
                      <img src="{{ asset($img) }}?v={{ time() }}" alt="{{ $product->title }} - Slide {{ $idx + 1 }}" loading="lazy">
                    </div>
                  @endforeach
                </div>
                <div class="admin-ps-dots">
                  @foreach($validImages as $idx => $img)
                    <span class="admin-ps-dot {{ $idx === 0 ? 'active' : '' }}" onclick="setAdminCardSlide(this, {{ $idx }})"></span>
                  @endforeach
                </div>
              </div>

              <span class="absolute bottom-2.5 right-3 px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-tight bg-slate-900/80 text-white z-20 pointer-events-none shadow-sm">
                {{ count($validImages) }} Slides
              </span>

            @elseif(count($validImages) === 1)
              <div class="w-full h-full flex items-center justify-center p-2 overflow-hidden rounded-xl">
                <img src="{{ asset($validImages[0]) }}?v={{ time() }}" alt="{{ $product->title }}" 
                  class="max-w-full max-h-full object-contain rounded-xl transition-transform duration-300 group-hover:scale-105">
              </div>
            @else
              <div class="flex flex-col items-center justify-center gap-2 pointer-events-none select-none">
                <div class="w-14 h-14 rounded-2xl bg-white border border-slate-200/90 shadow-2xs flex items-center justify-center text-slate-400 font-serif font-bold text-2xl group-hover:scale-105 group-hover:border-brand/30 group-hover:text-brand transition-all">
                  N
                </div>
                <p class="font-bold text-xs text-slate-700 tracking-tight">No image uploaded</p>
              </div>
            @endif
          </div>

          <!-- CARD BODY -->
          <div class="p-4 sm:p-5 flex flex-col gap-4">
            <div>
              <div class="flex items-center justify-between gap-2 mb-1">
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider truncate">
                  {{ $product->category ?? 'Laboratory' }}
                </span>
                @if(!empty($product->badge_category))
                  <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200/80">
                    {{ $product->badge_category }}
                  </span>
                @endif
              </div>

              <h3 class="font-bold text-sm sm:text-base text-slate-900 truncate" title="{{ $product->title }}">
                {{ $product->title }}
              </h3>

              <p class="text-xs text-slate-500 font-medium truncate mt-0.5 min-h-[1rem]" title="{{ $product->subtitle ?? '' }}">
                {{ !empty($product->subtitle) ? $product->subtitle : 'Standard formulation entry' }}
              </p>
            </div>

            <div class="grid grid-cols-2 gap-2.5 p-3 rounded-xl bg-slate-50 border border-slate-200/60">
              <div>
                <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Unit Pricing</span>
                <span class="font-extrabold text-sm text-emerald-600 tracking-tight mt-0.5 block truncate" title="{{ $product->price }}">
                  {{ $product->price }}
                </span>
              </div>
              <div class="border-l border-slate-200/70 pl-3">
                <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Dosage / Spec</span>
                <span class="font-semibold text-xs text-slate-700 mt-0.5 block truncate" title="{{ $product->dosage_spec ?? 'N/A' }}">
                  {{ !empty($product->dosage_spec) ? $product->dosage_spec : 'N/A' }}
                </span>
              </div>
            </div>

            @if(!empty($product->has_variants) && count($decodedVariants) > 0)
              <div class="flex flex-col gap-1.5">
                <div class="flex items-center justify-between">
                  <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 truncate">
                    {{ $product->variant_title ?: 'Multi-Price Options:' }}
                  </span>
                  <span class="text-[10px] font-semibold text-slate-400">{{ count($decodedVariants) }} options</span>
                </div>
                <div class="flex flex-wrap gap-1.5 max-h-20 overflow-y-auto pr-1">
                  @foreach($decodedVariants as $v)
                    <span class="px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200 text-[11px] font-semibold text-slate-700">
                      {{ $v['label'] ?? '' }}: <b class="text-emerald-600">{{ $v['price'] ?? '' }}</b> ({{ $v['stock'] ?? 0 }})
                    </span>
                  @endforeach
                </div>
              </div>
            @else
              <div class="flex items-center justify-between py-1.5 px-2.5 rounded-xl border border-dashed border-slate-200 text-[11px] font-medium text-slate-400">
                <span>Single pricing configuration</span>
                <span>No variants</span>
              </div>
            @endif

          </div>
        </div>

        <!-- CARD FOOTER ACTIONS -->
        <div class="px-4 sm:px-5 py-3.5 bg-slate-50/50 border-t border-slate-200/60 flex items-center justify-between gap-2">
          <button type="button" onclick='openEditProductModal(@json($product), @json($validImages))'
            class="flex-1 inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:border-brand/40 text-slate-700 hover:text-brand font-bold text-xs shadow-2xs transition-all cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            <span>Edit Details &amp; Variants</span>
          </button>

          <form action="{{ url($secretPrefix . '/products/' . $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this formulation?');" class="m-0">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="inline-flex items-center justify-center p-2 rounded-xl bg-white border border-slate-200 hover:border-rose-300 text-slate-400 hover:text-rose-600 hover:bg-rose-50 shadow-2xs transition-all cursor-pointer" title="Delete Product">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
              </svg>
            </button>
          </form>
        </div>

      </div>
    @empty
      <div class="col-span-full p-12 text-center bg-white/80 rounded-2xl border border-slate-200 text-slate-400 text-xs font-medium">
        No formulations currently available in the database. Click "Add New Product" to initialize.
      </div>
    @endforelse
  </div>

  <!-- PAGINATION SECTION (Centered Modern Pill Container) -->
  <div id="paginationWrapper" class="mt-4 pt-6 border-t border-slate-200/80 flex flex-col items-center justify-center gap-3">
    
    <!-- Kapsul Pagination -->
    <nav aria-label="Pagination" class="inline-flex items-center gap-1 sm:gap-1.5 p-1.5 sm:px-2.5 sm:py-1.5 bg-white border border-slate-200/90 rounded-2xl shadow-2xs" id="paginationNav">
      <!-- Dijana secara dinamik oleh JavaScript -->
    </nav>

    <!-- Status Ringkas di Bawah Kapsul -->
    <div class="text-xs font-semibold text-slate-400" id="paginationResultText">
      Showing 0 &ndash; 0 of 0 products
    </div>

  </div>

</div>

<!-- CREATE PRODUCT MODAL -->
<div id="createProductModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-100 flex flex-col max-h-[92vh] overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0 bg-white">
      <div class="flex flex-col">
        <h3 class="font-extrabold text-base sm:text-lg text-slate-900">Add New Formulation / Accessory</h3>
        <p class="text-xs text-slate-400 font-medium">Configure product details, stock count, multi-price options, and target storefront page.</p>
      </div>
      <button type="button" onclick="closeCreateProductModal()" class="text-slate-400 hover:text-slate-700 text-lg cursor-pointer">✕</button>
    </div>

    <form action="{{ url($secretPrefix . '/products') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
      @csrf
      <div class="p-6 overflow-y-auto space-y-4 flex-1">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-slate-50 p-3.5 rounded-2xl border border-slate-200/80">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Target Display Page *</label>
            <select name="page_type" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand">
              <option value="products">Products Catalog Page (/products)</option>
              <option value="accessory">Accessory Page (/accessory)</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catalog Category *</label>
            <select name="category" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand">
              @foreach($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Product Title *</label>
            <input type="text" name="title" required placeholder="e.g. Retatrutide"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:outline-none focus:border-brand">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Subtitle / Tagline</label>
            <input type="text" name="subtitle" placeholder="e.g. Advanced Weight Management"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:outline-none focus:border-brand">
          </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          <div class="col-span-2 sm:col-span-1">
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Display Price *</label>
            <input type="text" name="price" required placeholder="RM280.00 - RM980.00"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium text-slate-800 focus:outline-none focus:border-brand">
          </div>
          <div class="col-span-2 sm:col-span-1">
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Base Price (RM)</label>
            <input type="number" step="0.01" name="price_val" placeholder="280.00"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium text-slate-800 focus:outline-none focus:border-brand">
          </div>
          <div class="col-span-1">
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Dosage / Spec</label>
            <input type="text" name="dosage_spec" placeholder="10mg - 100mg / 100ml"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium text-slate-800 focus:outline-none focus:border-brand">
          </div>
          <div class="col-span-1">
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Total Stock *</label>
            <input type="number" name="stock" value="25" min="0" required
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-emerald-700 focus:outline-none focus:border-brand">
          </div>
        </div>

        <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 space-y-3">
          <div class="flex items-center justify-between gap-4">
            <div>
              <label class="text-xs font-extrabold text-slate-800 uppercase tracking-wider block">Multi-Option Pricing &amp; Dosage / Volume Variants</label>
              <p class="text-[11px] text-slate-500">Enable if this product has multiple sizes/volumes with different prices (e.g. 100ml vs 200ml, 10mg vs 30mg).</p>
            </div>
            <label class="inline-flex items-center gap-2 cursor-pointer shrink-0">
              <input type="checkbox" name="has_variants" value="1" id="create_has_variants" onchange="toggleVariantSection('create')" class="w-4 h-4 rounded text-brand focus:ring-brand">
              <span class="text-xs font-bold text-slate-700">Enable Options</span>
            </label>
          </div>

          <div id="create_variant_section" class="hidden space-y-3 pt-2 border-t border-slate-200/80">
            <div>
              <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Option Section Title (Tajuk Pilihan)</label>
              <input type="text" name="variant_title" value="Select Vial Concentration / Volume:" placeholder="e.g. Select Volume (100ml / 200ml) or Dosage:"
                class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-semibold text-slate-800">
            </div>

            <div class="space-y-2" id="create_variants_rows"></div>

            <button type="button" onclick="addVariantRow('create_variants_rows')"
              class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:border-brand text-brand font-bold text-xs shadow-2xs cursor-pointer">
              <span>+ Add Price / Volume Option (e.g. 100ml, 200ml)</span>
            </button>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Product Overview Description (Show Page)</label>
          <textarea name="description" rows="3" placeholder="Enter detailed scientific description or product overview..."
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:outline-none focus:border-brand"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Badge Label</label>
            <input type="text" name="badge_category" placeholder="e.g. Research grade"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-800">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Apparel Sizes (Optional)</label>
            <input type="text" name="sizes" placeholder="e.g. S, M, L, XL"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-800">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Search Keywords</label>
            <input type="text" name="keywords" placeholder="e.g. retatrutide 10mg"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-800">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Product Visual Assets (Multiple Allowed)</label>
          <div class="border-2 border-dashed border-slate-200 hover:border-brand/50 rounded-2xl p-4 bg-slate-50/50 flex flex-col items-center justify-center text-center cursor-pointer relative group">
            <input type="file" name="images[]" multiple accept="image/*"
              onchange="previewMultiImages(event, 'createImagesPreviewGrid')"
              class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
            <div id="createImagesPreviewGrid" class="hidden flex-wrap gap-2 mb-2 justify-center"></div>
            <div class="flex items-center gap-2 text-xs font-bold text-brand group-hover:underline">
              <span>Click or drag multiple files to create slider</span>
            </div>
            <span class="text-[11px] text-slate-400 mt-0.5">PNG, JPG, or WEBP up to 3MB each</span>
          </div>
        </div>
      </div>

      <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2 shrink-0">
        <button type="button" onclick="closeCreateProductModal()"
          class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 cursor-pointer">Cancel</button>
        <button type="submit"
          class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand hover:bg-brand-hover shadow-sm cursor-pointer">Publish Formulation</button>
      </div>
    </form>
  </div>
</div>

<!-- EDIT PRODUCT MODAL -->
<div id="editProductModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-100 flex flex-col max-h-[92vh] overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0 bg-white">
      <div class="flex flex-col">
        <h3 class="font-extrabold text-base sm:text-lg text-slate-900">Edit Formulation / Accessory</h3>
        <p class="text-xs text-slate-400 font-medium">Update stock, multi-price options, description, and page display target.</p>
      </div>
      <button type="button" onclick="closeEditProductModal()" class="text-slate-400 hover:text-slate-700 text-lg cursor-pointer">✕</button>
    </div>

    <form id="editProductForm" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
      @csrf
      @method('PUT')

      <div class="p-6 overflow-y-auto space-y-4 flex-1">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-slate-50 p-3.5 rounded-2xl border border-slate-200/80">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Target Display Page *</label>
            <select id="edit_page_type" name="page_type" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-slate-800">
              <option value="products">Products Catalog Page (/products)</option>
              <option value="accessory">Accessory Page (/accessory)</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catalog Category *</label>
            <select id="edit_category" name="category" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium text-slate-800">
              @foreach($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Product Title *</label>
            <input type="text" id="edit_title" name="title" required
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Subtitle / Tagline</label>
            <input type="text" id="edit_subtitle" name="subtitle"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800">
          </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          <div class="col-span-2 sm:col-span-1">
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Display Price *</label>
            <input type="text" id="edit_price" name="price" required
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium text-slate-800">
          </div>
          <div class="col-span-2 sm:col-span-1">
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Base Price (RM)</label>
            <input type="number" step="0.01" id="edit_price_val" name="price_val"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium text-slate-800">
          </div>
          <div class="col-span-1">
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Dosage / Spec</label>
            <input type="text" id="edit_dosage_spec" name="dosage_spec"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-medium text-slate-800">
          </div>
          <div class="col-span-1">
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Total Stock *</label>
            <input type="number" id="edit_stock" name="stock" min="0" required
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-emerald-700">
          </div>
        </div>

        <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 space-y-3">
          <div class="flex items-center justify-between gap-4">
            <div>
              <label class="text-xs font-extrabold text-slate-800 uppercase tracking-wider block">Multi-Option Pricing &amp; Dosage / Volume Variants</label>
              <p class="text-[11px] text-slate-500">Toggle whether customers can choose between different sizes/volumes with custom prices.</p>
            </div>
            <label class="inline-flex items-center gap-2 cursor-pointer shrink-0">
              <input type="checkbox" name="has_variants" value="1" id="edit_has_variants" onchange="toggleVariantSection('edit')" class="w-4 h-4 rounded text-brand focus:ring-brand">
              <span class="text-xs font-bold text-slate-700">Enable Options</span>
            </label>
          </div>

          <div id="edit_variant_section" class="hidden space-y-3 pt-2 border-t border-slate-200/80">
            <div>
              <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Option Section Title (Tajuk Pilihan)</label>
              <input type="text" id="edit_variant_title" name="variant_title" placeholder="e.g. Select Vial Concentration / Volume:"
                class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-semibold text-slate-800">
            </div>

            <div class="space-y-2" id="edit_variants_rows"></div>

            <button type="button" onclick="addVariantRow('edit_variants_rows')"
              class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:border-brand text-brand font-bold text-xs shadow-2xs cursor-pointer">
              <span>+ Add Price / Volume Option</span>
            </button>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Product Overview Description</label>
          <textarea id="edit_description" name="description" rows="3"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Badge Label</label>
            <input type="text" id="edit_badge_category" name="badge_category"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-800">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Apparel Sizes (CSV)</label>
            <input type="text" id="edit_sizes" name="sizes" placeholder="S, M, L, XL"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-800">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Search Keywords</label>
            <input type="text" id="edit_keywords" name="keywords"
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-medium text-slate-800">
          </div>
        </div>

        <div id="existingImagesWrapper" class="space-y-1.5">
          <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Current Slides in Catalog</label>
          <div id="editExistingImagesGrid" class="flex flex-wrap gap-2 p-3 bg-slate-50 rounded-2xl border border-slate-200/80"></div>
        </div>

        <div class="space-y-1.5">
          <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Upload Action Mode</label>
          <div class="grid grid-cols-2 gap-2">
            <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer text-xs font-semibold text-slate-700">
              <input type="radio" name="image_mode" value="replace" checked class="text-brand focus:ring-brand">
              <span>Replace Existing</span>
            </label>
            <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer text-xs font-semibold text-slate-700">
              <input type="radio" name="image_mode" value="append" class="text-brand focus:ring-brand">
              <span>Add to Slider</span>
            </label>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Choose New Visual Asset(s)</label>
          <div class="border-2 border-dashed border-slate-200 hover:border-brand/50 rounded-2xl p-4 bg-slate-50/50 flex flex-col items-center justify-center text-center cursor-pointer relative group">
            <input type="file" name="images[]" multiple accept="image/*"
              onchange="previewMultiImages(event, 'editNewImagesPreviewGrid')"
              class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
            <div id="editNewImagesPreviewGrid" class="hidden flex-wrap gap-2 mb-2 justify-center"></div>
            <div class="flex items-center gap-2 text-xs font-bold text-brand group-hover:underline">
              <span>Click to upload new visual(s)</span>
            </div>
            <span class="text-[11px] text-slate-400 mt-0.5">Leave blank to retain current catalog visual assets</span>
          </div>
        </div>
      </div>

      <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2 shrink-0">
        <button type="button" onclick="closeEditProductModal()"
          class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 cursor-pointer">Cancel</button>
        <button type="submit"
          class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand hover:bg-brand-hover shadow-sm cursor-pointer">Save Modifications</button>
      </div>
    </form>
  </div>
</div>

<script>
  let activeCategoryFilter = 'all';
  let activePageTypeFilter = 'all';
  
  // Konfigurasi Pagination (6 Produk Per Halaman)
  let currentPage = 1;
  const itemsPerPage = 6;
  let filteredCards = [];

  function toggleCategoryDropdown() {
    const menu = document.getElementById('categoryDropdownMenu');
    const arrow = document.getElementById('dropdownArrow');
    if (menu && arrow) {
      menu.classList.toggle('hidden');
      arrow.classList.toggle('rotate-180');
    }
  }

  function switchPageTypeFilter(pageType, btnEl) {
    activePageTypeFilter = pageType;
    document.querySelectorAll('.page-type-btn').forEach(b => {
      b.classList.remove('bg-white', 'text-slate-900', 'shadow-2xs');
      b.classList.add('text-slate-600');
    });
    btnEl.classList.add('bg-white', 'text-slate-900', 'shadow-2xs');
    btnEl.classList.remove('text-slate-600');
    currentPage = 1;
    filterProducts();
  }

  function switchCategoryFilter(categoryKey, categoryLabel) {
    activeCategoryFilter = categoryKey;
    const labelEl = document.getElementById('selectedCategoryText');
    if (labelEl) labelEl.innerText = categoryLabel;

    const menu = document.getElementById('categoryDropdownMenu');
    const arrow = document.getElementById('dropdownArrow');
    if (menu) menu.classList.add('hidden');
    if (arrow) arrow.classList.remove('rotate-180');

    currentPage = 1;
    filterProducts();
  }

  function onSearchInput() {
    currentPage = 1;
    filterProducts();
  }

  function filterProducts() {
    const input = document.getElementById('productSearchInput');
    const q = input ? input.value.toLowerCase().trim() : '';

    const cards = Array.from(document.querySelectorAll('.product-vault-card'));
    filteredCards = [];

    cards.forEach(card => {
      const title = card.dataset.title || '';
      const subtitle = card.dataset.subtitle || '';
      const category = card.dataset.category || '';
      const pageType = card.dataset.pagetype || 'products';
      const dosage = card.dataset.dosage || '';
      const keywords = card.dataset.keywords || '';

      const matchesSearch = !q || title.includes(q) || subtitle.includes(q) || category.includes(q) || dosage.includes(q) || keywords.includes(q);
      const matchesCategory = (activeCategoryFilter === 'all') || (category === activeCategoryFilter);
      const matchesPageType = (activePageTypeFilter === 'all') || (pageType === activePageTypeFilter);

      if (matchesSearch && matchesCategory && matchesPageType) {
        filteredCards.push(card);
      } else {
        card.style.display = 'none';
      }
    });

    const countText = document.getElementById('productCountText');
    if (countText) {
      countText.innerText = `Total ${filteredCards.length} ${filteredCards.length === 1 ? 'item' : 'items'}`;
    }

    renderPaginationView();
  }

  function renderPaginationView() {
    const totalItems = filteredCards.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage) || 1;

    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;

    filteredCards.forEach((card, idx) => {
      card.style.display = (idx >= startIndex && idx < endIndex) ? '' : 'none';
    });

    const wrapper = document.getElementById('paginationWrapper');
    const resultTextEl = document.getElementById('paginationResultText');

    if (totalItems === 0) {
      if (wrapper) wrapper.classList.add('hidden');
      return;
    } else {
      if (wrapper) wrapper.classList.remove('hidden');
    }

    if (resultTextEl) {
      const fromItem = startIndex + 1;
      const toItem = Math.min(endIndex, totalItems);
      resultTextEl.innerHTML = `Showing <span class="font-bold text-slate-700">${fromItem}&ndash;${toItem}</span> of <span class="font-bold text-slate-700">${totalItems}</span> products`;
    }

    renderPaginationButtons(totalPages);
  }

  function renderPaginationButtons(totalPages) {
    const nav = document.getElementById('paginationNav');
    if (!nav) return;

    let html = '';

    const baseItem = "min-w-[36px] h-9 px-2.5 rounded-xl text-xs sm:text-sm flex items-center justify-center select-none transition-all duration-150";
    const activeBtn = `${baseItem} bg-[#18181b] text-white font-bold shadow-2xs pointer-events-none`;
    const inactiveBtn = `${baseItem} bg-transparent text-slate-700 hover:bg-slate-100 hover:text-slate-900 font-semibold cursor-pointer`;
    const ellipsisSpan = `min-w-[32px] h-9 px-1 flex items-center justify-center text-slate-400 font-bold text-xs sm:text-sm select-none`;
    const arrowEnabled = `w-9 h-9 rounded-xl flex items-center justify-center text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors cursor-pointer`;
    const arrowDisabled = `w-9 h-9 rounded-xl flex items-center justify-center text-slate-300 cursor-not-allowed pointer-events-none`;

    // 1. Tombol Previous (<)
    if (currentPage > 1) {
      html += `<button type="button" onclick="goToPage(${currentPage - 1})" class="${arrowEnabled}" aria-label="Previous page">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
      </button>`;
    } else {
      html += `<button type="button" disabled class="${arrowDisabled}" aria-label="Previous page">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
      </button>`;
    }

    // 2. Deretan Nombor Halaman & Ellipsis (...)
    const pages = getPaginationPageList(currentPage, totalPages);
    pages.forEach(p => {
      if (p === '...') {
        html += `<span class="${ellipsisSpan}">&hellip;</span>`;
      } else if (p === currentPage) {
        html += `<button type="button" aria-current="page" class="${activeBtn}">${p}</button>`;
      } else {
        html += `<button type="button" onclick="goToPage(${p})" class="${inactiveBtn}">${p}</button>`;
      }
    });

    // 3. Tombol Next (>)
    if (currentPage < totalPages) {
      html += `<button type="button" onclick="goToPage(${currentPage + 1})" class="${arrowEnabled}" aria-label="Next page">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
      </button>`;
    } else {
      html += `<button type="button" disabled class="${arrowDisabled}" aria-label="Next page">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
      </button>`;
    }

    nav.innerHTML = html;
  }

  function getPaginationPageList(current, total) {
    if (total <= 7) {
      return Array.from({ length: total }, (_, i) => i + 1);
    }

    if (current <= 3) {
      return [1, 2, 3, '...', total - 2, total - 1, total];
    }

    if (current >= total - 2) {
      return [1, 2, '...', total - 2, total - 1, total];
    }

    return [1, '...', current - 1, current, current + 1, '...', total];
  }

  function goToPage(page) {
    currentPage = page;
    renderPaginationView();

    const grid = document.getElementById('productGridContainer');
    if (grid) {
      grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  function toggleVariantSection(prefix) {
    const chk = document.getElementById(`${prefix}_has_variants`);
    const sec = document.getElementById(`${prefix}_variant_section`);
    const rowsContainer = document.getElementById(`${prefix}_variants_rows`);
    if (!chk || !sec) return;

    if (chk.checked) {
      sec.classList.remove('hidden');
      if (rowsContainer && rowsContainer.children.length === 0) {
        addVariantRow(`${prefix}_variants_rows`, { label: '100ml', price: 'RM150.00', val: 150, stock: 20 });
      }
    } else {
      sec.classList.add('hidden');
    }
  }

  function addVariantRow(containerId, data = {}) {
    const container = document.getElementById(containerId);
    if (!container) return;

    const row = document.createElement('div');
    row.className = 'grid grid-cols-12 gap-2 items-center bg-white p-2 rounded-xl border border-slate-200';
    row.innerHTML = `
      <div class="col-span-4">
        <input type="text" name="variant_label[]" value="${data.label || ''}" placeholder="Option (e.g. 100ml / 10mg)"
          class="w-full bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-slate-800">
      </div>
      <div class="col-span-3">
        <input type="text" name="variant_price[]" value="${data.price || ''}" placeholder="Display (RM150.00)"
          class="w-full bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-800">
      </div>
      <div class="col-span-2">
        <input type="number" step="0.01" name="variant_val[]" value="${data.val !== undefined ? data.val : ''}" placeholder="Num (150)"
          class="w-full bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-800">
      </div>
      <div class="col-span-2">
        <input type="number" name="variant_stock[]" value="${data.stock !== undefined ? data.stock : 10}" placeholder="Stock"
          class="w-full bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-bold text-emerald-700">
      </div>
      <div class="col-span-1 text-right">
        <button type="button" onclick="this.closest('.grid').remove()" class="text-rose-500 hover:text-rose-700 font-bold text-sm px-1.5 cursor-pointer" title="Remove option">✕</button>
      </div>
    `;
    container.appendChild(row);
  }

  function openCreateProductModal() {
    const modal = document.getElementById('createProductModal');
    if (modal) {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }
  }

  function closeCreateProductModal() {
    const modal = document.getElementById('createProductModal');
    if (modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  }

  function openEditProductModal(product, existingImages = []) {
    const modal = document.getElementById('editProductModal');
    const form = document.getElementById('editProductForm');
    const secretPrefix = "{{ $secretPrefix }}";

    if (modal && form) {
      form.action = `{{ url('') }}/${secretPrefix}/products/${product.id}`;
      document.getElementById('edit_title').value = product.title || '';
      document.getElementById('edit_subtitle').value = product.subtitle || '';
      document.getElementById('edit_price').value = product.price || '';
      document.getElementById('edit_price_val').value = product.price_val || '';
      document.getElementById('edit_dosage_spec').value = product.dosage_spec || '';
      document.getElementById('edit_stock').value = product.stock !== null && product.stock !== undefined ? product.stock : 25;
      document.getElementById('edit_badge_category').value = product.badge_category || '';
      document.getElementById('edit_category').value = product.category || 'Weight Management';
      document.getElementById('edit_page_type').value = product.page_type || (product.category === 'Accessory' ? 'accessory' : 'products');
      document.getElementById('edit_keywords').value = product.keywords || '';
      document.getElementById('edit_description').value = product.description || '';

      let sizesText = '';
      if (product.sizes) {
        try {
          const parsedSizes = JSON.parse(product.sizes);
          if (Array.isArray(parsedSizes)) sizesText = parsedSizes.join(', ');
        } catch (e) {
          sizesText = product.sizes;
        }
      }
      document.getElementById('edit_sizes').value = sizesText;

      const hasVarChk = document.getElementById('edit_has_variants');
      const varSection = document.getElementById('edit_variant_section');
      const varRows = document.getElementById('edit_variants_rows');
      varRows.innerHTML = '';

      let parsedVariants = [];
      if (product.variants) {
        try {
          parsedVariants = typeof product.variants === 'string' ? JSON.parse(product.variants) : product.variants;
        } catch (e) {
          parsedVariants = [];
        }
      }

      document.getElementById('edit_variant_title').value = product.variant_title || 'Select Vial Concentration / Dosage:';

      if (Number(product.has_variants) === 1 && Array.isArray(parsedVariants) && parsedVariants.length > 0) {
        hasVarChk.checked = true;
        varSection.classList.remove('hidden');
        parsedVariants.forEach(v => addVariantRow('edit_variants_rows', v));
      } else {
        hasVarChk.checked = false;
        varSection.classList.add('hidden');
      }

      const existingGrid = document.getElementById('editExistingImagesGrid');
      const wrapper = document.getElementById('existingImagesWrapper');
      existingGrid.innerHTML = '';

      if (existingImages && existingImages.length > 0) {
        wrapper.classList.remove('hidden');
        existingImages.forEach(img => {
          const div = document.createElement('div');
          div.className = 'w-16 h-16 rounded-xl border border-slate-200 bg-white p-1 overflow-hidden shrink-0 flex items-center justify-center';
          div.innerHTML = `<img src="{{ asset('') }}${img}" class="w-full h-full object-contain rounded-lg">`;
          existingGrid.appendChild(div);
        });
      } else {
        wrapper.classList.add('hidden');
      }

      document.getElementById('editNewImagesPreviewGrid').innerHTML = '';
      document.getElementById('editNewImagesPreviewGrid').classList.add('hidden');

      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }
  }

  function closeEditProductModal() {
    const modal = document.getElementById('editProductModal');
    if (modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  }

  function previewMultiImages(event, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    container.innerHTML = '';
    const files = event.target.files;

    if (files && files.length > 0) {
      container.classList.remove('hidden');
      container.classList.add('flex');

      Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
          const div = document.createElement('div');
          div.className = 'w-16 h-16 rounded-xl border border-slate-200 bg-white p-1 overflow-hidden shrink-0 flex items-center justify-center shadow-2xs';
          div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-contain rounded-lg">`;
          container.appendChild(div);
        };
        reader.readAsDataURL(file);
      });
    } else {
      container.classList.add('hidden');
    }
  }

  function setAdminCardSlide(dot, idx) {
    if (window.event) {
      window.event.preventDefault();
      window.event.stopPropagation();
    }
    const slider = dot.closest('.admin-prod-slider');
    if (!slider) return;

    const slides = slider.querySelectorAll('.admin-prod-slide');
    const dots = slider.querySelectorAll('.admin-ps-dot');

    slides.forEach((s, i) => s.classList.toggle('active', i === idx));
    dots.forEach((d, i) => d.classList.toggle('active', i === idx));
  }

  var adminProdSlideTimer = null;
  function startAdminProdAutoSlide() {
    clearInterval(adminProdSlideTimer);
    if (matchMedia('(prefers-reduced-motion:reduce)').matches) return;

    adminProdSlideTimer = setInterval(() => {
      document.querySelectorAll('.admin-prod-slider').forEach(slider => {
        const slides = slider.querySelectorAll('.admin-prod-slide');
        const dots = slider.querySelectorAll('.admin-ps-dot');
        if (slides.length < 2) return;

        let cur = 0;
        slides.forEach((s, idx) => {
          if (s.classList.contains('active')) cur = idx;
        });

        let next = (cur + 1) % slides.length;
        slides.forEach((s, idx) => s.classList.toggle('active', idx === next));
        dots.forEach((d, idx) => d.classList.toggle('active', idx === next));
      });
    }, 4500);
  }

  document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('customCategoryDropdownWrapper');
    const menu = document.getElementById('categoryDropdownMenu');
    const arrow = document.getElementById('dropdownArrow');
    if (wrapper && !wrapper.contains(e.target) && menu && !menu.classList.contains('hidden')) {
      menu.classList.add('hidden');
      if (arrow) arrow.classList.remove('rotate-180');
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    startAdminProdAutoSlide();
    filterProducts();
  });
</script>