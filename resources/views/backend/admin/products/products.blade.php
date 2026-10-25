@php
    $rawProducts = $products ?? \Illuminate\Support\Facades\DB::select("SELECT * FROM products ORDER BY id DESC");
    $secretKey = $secret ?? config('admin.secret_key', env('ADMIN_SECRET_KEY', 'portal-admin-hyut746dhy74-novev-malaysia'));
    $secretPrefix = 'admin/' . $secretKey;

    $categories = collect($rawProducts)->pluck('badge_category')->filter()->unique()->values();
@endphp

<style>
  /* Slider Engine Scoped to Product Cards */
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
    padding: 0;
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
    bottom: 8px;
    left: 0;
    right: 0;
    z-index: 25;
    display: flex;
    justify-content: center;
    gap: 6px;
  }
  .admin-ps-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: rgba(148, 163, 184, 0.6);
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
  }
  .admin-ps-dot.active {
    background: #0071E3;
    transform: scale(1.3);
  }
</style>

<div class="m-0 flex flex-col gap-8">

  <!-- HEADER & PRIMARY ACTION BUTTON -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200/60">
    <div class="flex flex-col gap-1">
      <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Product Vault
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 font-medium">
        CentraDesk Catalog &middot; Manage laboratory formulations, inventory specifications, and storefront display assets.
      </p>
    </div>

    <div class="flex items-center gap-3 shrink-0">
      <div class="hidden sm:inline-flex items-center justify-center px-3.5 py-1.5 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold tracking-tight shadow-2xs">
        <span>{{ count($rawProducts) }} Total {{ count($rawProducts) === 1 ? 'Item' : 'Items' }}</span>
      </div>

      <button type="button" onclick="openCreateProductModal()"
        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white font-bold text-xs shadow-sm transition-all active:scale-[0.98] cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        <span>Add New Product</span>
      </button>
    </div>
  </div>

  <!-- TOOLBAR: CATEGORY DROPDOWN & LIVE SEARCH -->
  <div class="relative z-30 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl p-4 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
    
    <div class="flex items-center gap-3 w-full md:w-auto">
      <label class="text-xs font-bold text-slate-500 uppercase tracking-wider shrink-0">Filter Category:</label>
      
      <div class="relative w-full sm:w-64" id="customCategoryDropdownWrapper">
        <button type="button" onclick="toggleCategoryDropdown()" id="selectedCategoryBtn"
          class="w-full bg-slate-100/90 border border-slate-200 hover:border-brand/50 rounded-xl px-4 py-2.5 flex items-center justify-between gap-2 text-xs font-bold text-slate-800 shadow-2xs transition-all cursor-pointer">
          <span id="selectedCategoryText">All Formulations</span>
          <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" id="dropdownArrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </button>

        <div id="categoryDropdownMenu" class="hidden absolute left-0 right-0 top-full mt-2 bg-white border border-slate-200/90 rounded-2xl shadow-2xl z-50 p-1.5 flex flex-col gap-1">
          <button type="button" onclick="switchCategoryFilter('all', 'All Formulations')"
            class="category-option-btn w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors">
            <span>All Formulations</span>
            <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded-md font-semibold text-slate-500">{{ count($rawProducts) }}</span>
          </button>

          @foreach($categories as $cat)
            @php
              $catCount = collect($rawProducts)->where('badge_category', $cat)->count();
            @endphp
            <button type="button" onclick="switchCategoryFilter('{{ strtolower($cat) }}', '{{ $cat }}')"
              class="category-option-btn w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 hover:text-brand flex items-center justify-between transition-colors">
              <span>{{ $cat }}</span>
              <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded-md font-semibold text-slate-500">{{ $catCount }}</span>
            </button>
          @endforeach
        </div>
      </div>
    </div>

    <div class="flex items-center gap-3 w-full md:w-auto">
      <div class="relative w-full sm:w-64">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input type="text" id="productSearchInput" onkeyup="filterProducts()" placeholder="Search formulation..."
          class="w-full bg-slate-50/70 border border-slate-200 rounded-xl py-2 pl-9 pr-4 text-xs font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
      </div>

      <span class="text-xs font-semibold text-slate-400 whitespace-nowrap shrink-0" id="productCountText">
        Showing {{ count($rawProducts) }} {{ count($rawProducts) === 1 ? 'item' : 'items' }}
      </span>
    </div>

  </div>

  <!-- PRODUCT VAULT CARDS GRID WITH REAL-TIME SLIDER -->
  <div id="productGridContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($rawProducts as $product)
      @php
        $imgList = [];
        if (!empty($product->image)) {
            $decoded = json_decode($product->image, true);
            $imgList = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) 
                ? $decoded 
                : [$product->image];
        }
        $validImages = array_values(array_filter($imgList, fn($p) => !empty($p) && file_exists(public_path($p))));
        $hasImage = count($validImages) > 0;
      @endphp

      <div class="product-vault-card bg-slate-50/60 border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-2xs flex flex-col justify-between hover:border-brand/40 hover:shadow-xs transition-all duration-200"
        data-title="{{ strtolower($product->title) }}"
        data-category="{{ strtolower($product->badge_category ?? 'general') }}"
        data-dosage="{{ strtolower($product->dosage_spec ?? '') }}">
        
        <div class="flex flex-col gap-4">
          <!-- CARD HEADER (NO URL /products/... TEXT) -->
          <div class="flex items-center justify-between gap-3">
            <div class="truncate">
              <h3 class="font-bold text-sm sm:text-base text-slate-900 truncate" title="{{ $product->title }}">
                {{ $product->title }}
              </h3>
            </div>
            <span class="px-2.5 py-1 rounded-lg bg-white/90 border border-slate-200/80 text-slate-600 font-semibold text-[11px] uppercase tracking-wider shrink-0 shadow-2xs">
              {{ $product->badge_category ?? 'Laboratory' }}
            </span>
          </div>

          <!-- IMAGE VAULT BOX: SLIDER CONTAINER -->
          <div class="relative w-full border border-slate-200/90 hover:border-brand/60 rounded-2xl p-3 bg-white/80 backdrop-blur-xs flex flex-col items-center justify-center text-center transition-all duration-200 group overflow-hidden h-52">
            @if(count($validImages) > 1)
              <!-- MULTI-IMAGE AUTO SLIDER WITH DOTS -->
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

              <span class="absolute top-2.5 left-2.5 px-2.5 py-1 rounded-full bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-bold tracking-tight shadow-sm z-20 pointer-events-none">
                {{ count($validImages) }} Slides
              </span>

              <!-- HOVER ACTION OVERLAY -->
              <div class="absolute inset-0 bg-slate-900/35 backdrop-blur-2xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-2xl flex items-center justify-center z-15 pointer-events-none">
                <button type="button" onclick='openEditProductModal(@json($product), @json($validImages))'
                  class="pointer-events-auto px-3.5 py-2 rounded-xl bg-white/95 text-slate-900 font-extrabold text-xs shadow-md flex items-center gap-1.5 transform translate-y-1 group-hover:translate-y-0 transition-transform cursor-pointer">
                  <span>Manage Slides</span>
                </button>
              </div>

            @elseif(count($validImages) === 1)
              <!-- SINGLE IMAGE DISPLAY -->
              <div class="w-full h-full flex items-center justify-center p-1 relative">
                <img src="{{ asset($validImages[0]) }}?v={{ time() }}" alt="{{ $product->title }}" 
                  class="max-w-full max-h-full object-contain rounded-xl opacity-90 group-hover:opacity-100 transition-opacity duration-200">
                
                <div class="absolute inset-0 bg-slate-900/35 backdrop-blur-2xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-xl flex items-center justify-center z-15">
                  <button type="button" onclick='openEditProductModal(@json($product), @json($validImages))'
                    class="px-3.5 py-2 rounded-xl bg-white/95 text-slate-900 font-extrabold text-xs shadow-md flex items-center gap-1.5 transform translate-y-1 group-hover:translate-y-0 transition-transform cursor-pointer">
                    <span>Replace Visual Asset</span>
                  </button>
                </div>
              </div>
            @else
              <!-- DEFAULT PLACEHOLDER WITH LETTER N -->
              <div class="flex flex-col items-center justify-center gap-2 pointer-events-none select-none">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-200/90 shadow-2xs flex items-center justify-center text-slate-400 font-serif font-bold text-2xl group-hover:scale-105 group-hover:border-brand/30 group-hover:text-brand transition-all">
                  N
                </div>
                <p class="font-bold text-xs text-slate-700 tracking-tight">No image uploaded</p>
                <span class="text-[11px] text-slate-400">Default placeholder active</span>
              </div>
            @endif
          </div>

          <!-- METRICS SPECIFICATIONS -->
          <div class="flex items-center justify-between pt-2 border-t border-slate-200/60 text-xs">
            <div class="flex flex-col">
              <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Unit Pricing</span>
              <span class="font-extrabold text-emerald-600 text-sm tracking-tight">{{ $product->price }}</span>
            </div>
            <div class="flex flex-col text-right">
              <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Dosage Spec</span>
              <span class="font-semibold text-slate-700 text-xs">{{ $product->dosage_spec ?? 'N/A' }}</span>
            </div>
          </div>
        </div>

        <!-- CARD FOOTER ACTIONS -->
        <div class="pt-4 mt-4 border-t border-slate-200/60 flex items-center justify-between gap-2">
          <button type="button" onclick='openEditProductModal(@json($product), @json($validImages))'
            class="flex-1 inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:border-brand/40 text-slate-700 hover:text-brand font-bold text-xs shadow-2xs transition-all cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            <span>Edit Details</span>
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

</div>

<!-- MODAL: ADD PRODUCT FORM -->
<div id="createProductModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-100 flex flex-col gap-6 max-h-[90vh] overflow-y-auto">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
      <div class="flex flex-col">
        <h3 class="font-extrabold text-base sm:text-lg text-slate-900">Add New Formulation</h3>
        <p class="text-xs text-slate-400 font-medium">Create a new compound and publish directly to the catalog.</p>
      </div>
      <button type="button" onclick="closeCreateProductModal()" class="text-slate-400 hover:text-slate-700 text-lg cursor-pointer">✕</button>
    </div>

    <form action="{{ url($secretPrefix . '/products') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      <div>
        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Product Title *</label>
        <input type="text" name="title" required placeholder="e.g. Retatrutide"
          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Pricing Range *</label>
          <input type="text" name="price" required placeholder="e.g. RM280.00 - RM980.00"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Dosage / Unit Spec</label>
          <input type="text" name="dosage_spec" placeholder="e.g. 10mg - 100mg"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Badge Category</label>
        <input type="text" name="badge_category" placeholder="e.g. Research grade"
          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Product Visual Assets (Multiple Allowed)</label>
        <div class="border-2 border-dashed border-slate-200 hover:border-brand/50 rounded-2xl p-4 bg-slate-50/50 flex flex-col items-center justify-center text-center cursor-pointer relative group">
          <input type="file" name="images[]" multiple accept="image/*"
            onchange="previewMultiImages(event, 'createImagesPreviewGrid')"
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
          
          <div id="createImagesPreviewGrid" class="hidden flex-wrap gap-2 mb-2 justify-center"></div>

          <div class="flex items-center gap-2 text-xs font-bold text-brand group-hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.75 3.75 0 0118 19.5H6.75z" />
            </svg>
            <span>Click or drag multiple files to create slider</span>
          </div>
          <span class="text-[11px] text-slate-400 mt-0.5">PNG, JPG, or WEBP up to 3MB each (Optional)</span>
        </div>
      </div>

      <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-100">
        <button type="button" onclick="closeCreateProductModal()"
          class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors">Cancel</button>
        <button type="submit"
          class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand hover:bg-brand-hover shadow-sm transition-all cursor-pointer">Publish Formulation</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: EDIT PRODUCT FORM -->
<div id="editProductModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-100 flex flex-col gap-6 max-h-[90vh] overflow-y-auto">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
      <div class="flex flex-col">
        <h3 class="font-extrabold text-base sm:text-lg text-slate-900">Edit Formulation</h3>
        <p class="text-xs text-slate-400 font-medium">Update pricing, dosage units, and molecular asset slider.</p>
      </div>
      <button type="button" onclick="closeEditProductModal()" class="text-slate-400 hover:text-slate-700 text-lg cursor-pointer">✕</button>
    </div>

    <form id="editProductForm" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      @method('PUT')
      <div>
        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Product Title *</label>
        <input type="text" id="edit_title" name="title" required
          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Pricing Range *</label>
          <input type="text" id="edit_price" name="price" required
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Dosage / Unit Spec</label>
          <input type="text" id="edit_dosage_spec" name="dosage_spec"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Badge Category</label>
        <input type="text" id="edit_badge_category" name="badge_category"
          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all">
      </div>

      <!-- CURRENT SLIDES LIST -->
      <div id="existingImagesWrapper" class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Current Slides in Catalog</label>
        <div id="editExistingImagesGrid" class="flex flex-wrap gap-2 p-3 bg-slate-50 rounded-2xl border border-slate-200/80"></div>
      </div>

      <!-- UPLOAD ACTION MODE -->
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Upload Action Mode</label>
        <div class="grid grid-cols-2 gap-2">
          <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer text-xs font-semibold text-slate-700 hover:bg-white has-[:checked]:border-brand has-[:checked]:bg-brand-tint has-[:checked]:text-brand transition-all">
            <input type="radio" name="image_mode" value="replace" checked class="text-brand focus:ring-brand">
            <span>Replace Existing</span>
          </label>
          <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer text-xs font-semibold text-slate-700 hover:bg-white has-[:checked]:border-brand has-[:checked]:bg-brand-tint has-[:checked]:text-brand transition-all">
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
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            <span>Click to upload new visual(s)</span>
          </div>
          <span class="text-[11px] text-slate-400 mt-0.5">Leave blank to retain current catalog visual assets</span>
        </div>
      </div>

      <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-100">
        <button type="button" onclick="closeEditProductModal()"
          class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors">Cancel</button>
        <button type="submit"
          class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand hover:bg-brand-hover shadow-sm transition-all cursor-pointer">Save Modifications</button>
      </div>
    </form>
  </div>
</div>

<script>
  let activeCategoryFilter = 'all';

  function toggleCategoryDropdown() {
    const menu = document.getElementById('categoryDropdownMenu');
    const arrow = document.getElementById('dropdownArrow');
    if (menu && arrow) {
      menu.classList.toggle('hidden');
      arrow.classList.toggle('rotate-180');
    }
  }

  function switchCategoryFilter(categoryKey, categoryLabel) {
    activeCategoryFilter = categoryKey;

    const labelEl = document.getElementById('selectedCategoryText');
    if (labelEl) labelEl.innerText = categoryLabel;

    const menu = document.getElementById('categoryDropdownMenu');
    const arrow = document.getElementById('dropdownArrow');
    if (menu) menu.classList.add('hidden');
    if (arrow) arrow.classList.remove('rotate-180');

    filterProducts();
  }

  function filterProducts() {
    const input = document.getElementById('productSearchInput');
    const q = input ? input.value.toLowerCase().trim() : '';

    const cards = document.querySelectorAll('.product-vault-card');
    let visibleCount = 0;

    cards.forEach(card => {
      const title = card.dataset.title || '';
      const category = card.dataset.category || '';
      const dosage = card.dataset.dosage || '';

      const matchesSearch = title.includes(q) || category.includes(q) || dosage.includes(q);
      const matchesCategory = (activeCategoryFilter === 'all') || (category === activeCategoryFilter);

      if (matchesSearch && matchesCategory) {
        card.style.display = '';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    const countText = document.getElementById('productCountText');
    if (countText) {
      countText.innerText = `Showing ${visibleCount} ${visibleCount === 1 ? 'item' : 'items'}`;
    }
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
      document.getElementById('edit_price').value = product.price || '';
      document.getElementById('edit_dosage_spec').value = product.dosage_spec || '';
      document.getElementById('edit_badge_category').value = product.badge_category || '';

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

  /* Slider Engine Controller for Admin Cards */
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
  });
</script>