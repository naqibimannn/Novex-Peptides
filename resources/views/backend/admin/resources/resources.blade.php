@php
  $rawResources = $resources ?? \Illuminate\Support\Facades\DB::select("SELECT * FROM resources ORDER BY id DESC");
  $secretKey = $secret ?? request()->segment(2) ?? config('admin.secret_key', env('ADMIN_SECRET_KEY'));
  $secretPrefix = 'admin/' . $secretKey;

  $resolveResourceImg = function ($path) {
    if (empty($path))
      return asset('assets/website/science/s1.webp');
    if (filter_var($path, FILTER_VALIDATE_URL))
      return $path;
    $clean = ltrim($path, '/');
    if (file_exists(public_path($clean)))
      return asset($clean) . '?v=' . filemtime(public_path($clean));
    if (file_exists(public_path('uploads/resources/' . basename($clean)))) {
      return asset('uploads/resources/' . basename($clean)) . '?v=' . time();
    }
    return asset($clean);
  };
@endphp

<style>
  .img-sort-item {
    cursor: default;
    user-select: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  @keyframes subtleWiggle {
    0%, 100% {
      transform: rotate(0deg);
    }
    20% {
      transform: rotate(-1.5deg);
    }
    40% {
      transform: rotate(1.5deg);
    }
    60% {
      transform: rotate(-1deg);
    }
    80% {
      transform: rotate(1deg);
    }
  }

  .new-asset-wiggling {
    animation: subtleWiggle 3.2s infinite ease-in-out;
    border: 1.5px dashed #0071E3 !important;
    background-color: #F0F6FE !important;
  }
</style>

<div class="flex flex-col gap-8">

  <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-2 border-b border-slate-200/60">
    <div class="flex flex-col gap-1">
      <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Educational Resources &amp; Articles
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 font-medium">
        CentraDesk Publishing &middot; Manage laboratory scientific reviews, compound monographs, and education literature.
      </p>
    </div>

    <div class="flex flex-wrap items-center gap-2.5 shrink-0">
      <button type="button" onclick="openCreateArticleModal()"
        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white font-bold text-xs shadow-xs transition-all active:scale-[0.98] cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        <span>Add New Article</span>
      </button>

      <div class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-white border border-slate-200/80 text-slate-700 font-bold text-xs shadow-xs select-none">
        <span>Total Articles: <strong class="text-slate-900 font-extrabold">{{ count($rawResources) }}</strong></span>
      </div>
    </div>
  </div>

  <div class="relative z-30 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl p-4 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">
      Published Monograph Library
    </div>
    <div class="relative w-full sm:w-80">
      <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <input type="text" id="articleSearchInput" onkeyup="onSearchArticleInput()"
        placeholder="Search article title or compound..."
        class="w-full bg-slate-100/90 focus:bg-white border border-slate-200 hover:border-brand/40 rounded-xl py-2 pl-9 pr-4 text-xs font-semibold text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand shadow-2xs transition-all">
    </div>
  </div>

  <div id="articlesGridContainer" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse($rawResources as $art)
      @php
        $imgUrl = $resolveResourceImg($art->image);
      @endphp

      <div
        class="article-vault-card group bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl overflow-hidden shadow-xs hover:shadow-md hover:border-brand/40 transition-all duration-200 flex flex-col justify-between"
        data-title="{{ strtolower($art->title) }}" data-sub="{{ strtolower($art->subtitle ?? '') }}"
        data-author="{{ strtolower($art->author ?? '') }}">

        <div>
          <div class="relative w-full h-48 bg-slate-100 border-b border-slate-100 overflow-hidden">
            <img src="{{ $imgUrl }}" alt="{{ $art->title }}"
              class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
            <div
              class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 text-brand backdrop-blur-md border border-slate-200/60 shadow-2xs">
              {{ $art->classification ?: 'Research Literature' }}
            </div>
          </div>

          <div class="p-4 sm:p-5 flex flex-col gap-2.5">
            <div class="flex items-center justify-between text-[11px] text-slate-400 font-medium">
              <span class="truncate max-w-[200px]">{{ $art->read_time ?: '4 min read' }}</span>
              <span>{{ \Carbon\Carbon::parse($art->created_at)->format('d M Y') }}</span>
            </div>

            <h3 class="font-bold text-base text-slate-900 leading-snug truncate" title="{{ $art->title }}">
              {{ $art->title }}
            </h3>

            <p class="text-xs text-slate-500 font-medium line-clamp-2 min-h-[2rem]">
              {{ $art->subtitle ?: 'Standard scientific review monograph.' }}
            </p>

            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
              <span>Author: <strong class="text-slate-800 font-bold">{{ $art->author ?: 'Research Team' }}</strong></span>
            </div>
          </div>
        </div>

        <div class="px-4 sm:px-5 py-3.5 bg-slate-50/50 border-t border-slate-200/60 flex items-center justify-between gap-2">
          <a href="{{ url('/resources/' . $art->slug) }}" target="_blank"
            class="p-2 rounded-xl bg-white border border-slate-200/80 hover:border-brand/40 text-slate-500 hover:text-brand shadow-2xs transition-all"
            title="View Published Article">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
            </svg>
          </a>

          <button type="button" onclick='openEditArticleModal(@json($art), @json($imgUrl))'
            class="flex-1 inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200/80 hover:border-brand/40 text-slate-700 hover:text-brand font-bold text-xs shadow-2xs transition-all cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            <span>Edit Article</span>
          </button>

          <form action="{{ route('admin.resources.destroy', $art->id) }}" method="POST"
            onsubmit="return confirm('Are you sure you want to permanently delete this article?');" class="m-0">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="inline-flex items-center justify-center p-2 rounded-xl bg-white border border-slate-200/80 hover:border-rose-300 text-slate-400 hover:text-rose-600 hover:bg-rose-50 shadow-2xs transition-all cursor-pointer"
              title="Delete Article">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
              </svg>
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="col-span-full p-12 text-center bg-white/90 backdrop-blur-md rounded-2xl border border-slate-200/80 text-slate-400 text-xs font-semibold shadow-xs">
        No educational articles currently available. Click "Add New Article" to publish your first monograph.
      </div>
    @endforelse
  </div>

  <div id="articlePaginationWrapper" class="pt-4 border-t border-slate-200/60 hidden">
    <div class="flex items-center justify-between bg-white rounded-full px-5 sm:px-7 py-3 border border-slate-200 shadow-2xs">
      <div class="flex items-center gap-3 sm:gap-6" id="articlePaginationControls">
      </div>

      <div class="text-xs font-medium text-slate-500 whitespace-nowrap hidden md:block" id="articlePaginationResultText">
        Showing 0 of 0 results
      </div>
    </div>
  </div>

</div>

<div id="createArticleModal"
  class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
  <div
    class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-2xl border border-slate-100 flex flex-col gap-5 max-h-[92vh] overflow-y-auto">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
      <div class="flex flex-col">
        <h3 class="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">Add New Educational Article</h3>
        <p class="text-xs text-slate-400 font-medium">Configure article metadata, author details, content paragraphs, and banner visual.</p>
      </div>
      <button type="button" onclick="closeCreateArticleModal()"
        class="text-slate-400 hover:text-slate-700 text-lg cursor-pointer">✕</button>
    </div>

    <form id="createArticleForm" action="{{ route('admin.resources.store') }}" method="POST"
      enctype="multipart/form-data" class="space-y-4">
      @csrf

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Article Title *</label>
          <input type="text" name="title" required placeholder="e.g. Understanding Retatrutide"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:border-brand">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Subtitle / Lead Summary</label>
          <input type="text" name="subtitle" placeholder="e.g. An investigational triple-receptor agonist..."
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:border-brand">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Author Name</label>
          <input type="text" name="author" placeholder="e.g. Dr. Aris Thorne, Ph.D."
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:border-brand">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Read Time</label>
          <input type="text" name="read_time" placeholder="e.g. 4 min read"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:border-brand">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Classification</label>
          <input type="text" name="classification" placeholder="e.g. Monograph Review"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:border-brand">
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Article Paragraphs &amp; Monograph Content *</label>
        <textarea name="content" rows="6" required placeholder="Write or paste your article content here..."
          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 focus:outline-none focus:border-brand leading-relaxed"></textarea>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Featured Banner Visual</label>
        <div
          class="border-2 border-dashed border-slate-200 hover:border-brand/50 rounded-2xl p-4 bg-slate-50/50 flex flex-col items-center justify-center text-center cursor-pointer relative group">
          <input type="file" name="image" accept="image/jpeg,image/png,image/webp" onchange="previewUploadImage(event, 'createArtImgPreview')"
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
          <div class="flex items-center gap-2 text-xs font-bold text-brand group-hover:underline pointer-events-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Click or drag image to upload banner</span>
          </div>
          <span class="text-[11px] text-slate-400 mt-0.5 pointer-events-none">WEBP, PNG, or JPG up to 5MB</span>
        </div>
        <div id="createArtImgPreview"
          class="hidden mt-3 p-2 rounded-2xl bg-slate-50 border border-slate-200/80 w-32 h-20 overflow-hidden">
          <img src="" class="w-full h-full object-cover rounded-xl">
        </div>
      </div>

      <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-100">
        <button type="button" onclick="closeCreateArticleModal()"
          class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 cursor-pointer">Cancel</button>
        <button type="submit"
          class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand hover:bg-brand-hover shadow-xs cursor-pointer">Publish Article</button>
      </div>
    </form>
  </div>
</div>

<div id="editArticleModal"
  class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
  <div
    class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-2xl border border-slate-100 flex flex-col gap-5 max-h-[92vh] overflow-y-auto">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
      <div class="flex flex-col">
        <h3 class="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">Edit Educational Article</h3>
        <p class="text-xs text-slate-400 font-medium">Update article metadata, content paragraphs, and replace banner visual.</p>
      </div>
      <button type="button" onclick="closeEditArticleModal()"
        class="text-slate-400 hover:text-slate-700 text-lg cursor-pointer">✕</button>
    </div>

    <form id="editArticleForm" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Article Title *</label>
          <input type="text" id="edit_art_title" name="title" required
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Subtitle / Lead Summary</label>
          <input type="text" id="edit_art_subtitle" name="subtitle"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800">
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Author Name</label>
          <input type="text" id="edit_art_author" name="author" placeholder="e.g. Dr. Aris Thorne, Ph.D."
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Read Time</label>
          <input type="text" id="edit_art_read_time" name="read_time" placeholder="e.g. 4 min read"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Classification</label>
          <input type="text" id="edit_art_classification" name="classification" placeholder="e.g. Monograph Review"
            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-800">
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Article Paragraphs &amp; Monograph Content *</label>
        <textarea id="edit_art_content" name="content" rows="6" required
          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-medium text-slate-800 leading-relaxed"></textarea>
      </div>

      <div class="space-y-2">
        <label class="block text-xs font-bold text-slate-700">Current &amp; New Visual Asset</label>
        <div class="flex items-center gap-3">
          <div id="editExistingImgBox"
            class="w-28 h-20 rounded-xl border border-slate-200 overflow-hidden bg-white p-1">
            <img id="editExistingImgSrc" src="" class="w-full h-full object-cover rounded-lg">
          </div>
          <div id="editNewImgBox"
            class="hidden img-sort-item new-asset-wiggling w-28 h-20 rounded-xl p-1 overflow-hidden">
            <img id="editNewImgSrc" src="" class="w-full h-full object-cover rounded-lg">
          </div>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1.5">Upload New Banner (Replaces Current)</label>
        <div
          class="border-2 border-dashed border-slate-200 hover:border-brand/50 rounded-2xl p-4 bg-slate-50/50 flex flex-col items-center justify-center text-center cursor-pointer relative group">
          <input type="file" name="image" accept="image/jpeg,image/png,image/webp" onchange="previewEditNewImage(event)"
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
          <div class="flex items-center gap-2 text-xs font-bold text-brand group-hover:underline pointer-events-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Click to upload replacement visual</span>
          </div>
          <span class="text-[11px] text-slate-400 mt-0.5 pointer-events-none">Leave blank to retain current visual</span>
        </div>
      </div>

      <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-100">
        <button type="button" onclick="closeEditArticleModal()"
          class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 cursor-pointer">Cancel</button>
        <button type="submit"
          class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand hover:bg-brand-hover shadow-xs cursor-pointer">Save Modifications</button>
      </div>
    </form>
  </div>
</div>

<script>
  const updateResourceRouteTemplate = "{{ route('admin.resources.update', ':id') }}";

  let currentArticlePage = 1;
  const articlesPerPage = 6;
  let filteredArticleCards = [];

  function onSearchArticleInput() {
    currentArticlePage = 1;
    filterArticles();
  }

  function filterArticles() {
    const q = (document.getElementById('articleSearchInput')?.value || '').toLowerCase().trim();
    const cards = Array.from(document.querySelectorAll('.article-vault-card'));
    filteredArticleCards = [];

    cards.forEach(card => {
      const title = card.dataset.title || '';
      const sub = card.dataset.sub || '';
      const author = card.dataset.author || '';
      if (!q || title.includes(q) || sub.includes(q) || author.includes(q)) {
        filteredArticleCards.push(card);
      } else {
        card.style.display = 'none';
      }
    });

    renderArticlePaginationView();
  }

  function renderArticlePaginationView() {
    const totalItems = filteredArticleCards.length;
    const totalPages = Math.ceil(totalItems / articlesPerPage) || 1;

    if (currentArticlePage > totalPages) currentArticlePage = totalPages;
    if (currentArticlePage < 1) currentArticlePage = 1;

    const startIndex = (currentArticlePage - 1) * articlesPerPage;
    const endIndex = startIndex + articlesPerPage;

    filteredArticleCards.forEach((card, idx) => {
      card.style.display = (idx >= startIndex && idx < endIndex) ? '' : 'none';
    });

    const wrapper = document.getElementById('articlePaginationWrapper');
    const resultTextEl = document.getElementById('articlePaginationResultText');

    if (totalItems === 0) {
      if (wrapper) wrapper.classList.add('hidden');
      return;
    } else {
      if (wrapper) wrapper.classList.remove('hidden');
    }

    if (resultTextEl) {
      const toItem = Math.min(endIndex, totalItems);
      resultTextEl.innerHTML = `Showing ${toItem} of ${totalItems} results`;
    }

    renderArticlePaginationButtons(totalPages);
  }

  function renderArticlePaginationButtons(totalPages) {
    const controls = document.getElementById('articlePaginationControls');
    if (!controls) return;

    let html = '';

    if (currentArticlePage > 1) {
      html += `
        <button type="button" onclick="goToArticlePage(${currentArticlePage - 1})" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 hover:text-slate-900 transition-colors cursor-pointer select-none">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
          <span>Previous</span>
        </button>
      `;
    } else {
      html += `
        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-300 cursor-not-allowed select-none">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
          <span>Previous</span>
        </span>
      `;
    }

    html += `<div class="flex items-center gap-1 sm:gap-2">`;
    const pages = getArticlePaginationPageList(currentArticlePage, totalPages);
    pages.forEach(p => {
      if (p === '...') {
        html += `<span class="w-7 h-7 flex items-center justify-center text-xs font-bold text-slate-400 select-none">...</span>`;
      } else if (p === currentArticlePage) {
        html += `
          <span class="w-8 h-8 rounded-full bg-brand text-white font-bold text-xs flex items-center justify-center ring-4 ring-brand/20 shadow-xs select-none">
            ${p}
          </span>
        `;
      } else {
        html += `
          <button type="button" onclick="goToArticlePage(${p})" class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-medium text-slate-700 hover:text-slate-900 hover:bg-slate-100 transition-colors cursor-pointer">
            ${p}
          </button>
        `;
      }
    });
    html += `</div>`;

    if (currentArticlePage < totalPages) {
      html += `
        <button type="button" onclick="goToArticlePage(${currentArticlePage + 1})" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 hover:text-slate-900 transition-colors cursor-pointer select-none">
          <span>Next</span>
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
          </svg>
        </button>
      `;
    } else {
      html += `
        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-300 cursor-not-allowed select-none">
          <span>Next</span>
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
          </svg>
        </span>
      `;
    }

    controls.innerHTML = html;
  }

  function getArticlePaginationPageList(current, total) {
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

  function goToArticlePage(page) {
    currentArticlePage = page;
    renderArticlePaginationView();

    const grid = document.getElementById('articlesGridContainer');
    if (grid) {
      grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  function previewUploadImage(e, targetBoxId) {
    const file = e.target.files[0];
    const box = document.getElementById(targetBoxId);
    if (!file || !box) return;

    if (file.name.toLowerCase().endsWith('.svg') || file.type.toLowerCase().includes('svg')) {
      alert('Format SVG tidak dibenarkan atas faktor keselamatan.');
      e.target.value = '';
      box.classList.add('hidden');
      return;
    }

    box.querySelector('img').src = URL.createObjectURL(file);
    box.classList.remove('hidden');
  }

  function previewEditNewImage(e) {
    const file = e.target.files[0];
    const newBox = document.getElementById('editNewImgBox');
    const newImg = document.getElementById('editNewImgSrc');
    if (!file || !newBox || !newImg) return;

    if (file.name.toLowerCase().endsWith('.svg') || file.type.toLowerCase().includes('svg')) {
      alert('Format SVG tidak dibenarkan atas faktor keselamatan.');
      e.target.value = '';
      newBox.classList.add('hidden');
      return;
    }

    newImg.src = URL.createObjectURL(file);
    newBox.classList.remove('hidden');
  }

  function openCreateArticleModal() {
    const modal = document.getElementById('createArticleModal');
    if (modal) {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }
  }

  function closeCreateArticleModal() {
    const modal = document.getElementById('createArticleModal');
    if (modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  }

  function openEditArticleModal(art, resolvedImgUrl) {
    const modal = document.getElementById('editArticleModal');
    const form = document.getElementById('editArticleForm');

    if (modal && form) {
      form.action = updateResourceRouteTemplate.replace(':id', art.id);

      document.getElementById('edit_art_title').value = art.title || '';
      document.getElementById('edit_art_subtitle').value = art.subtitle || '';
      document.getElementById('edit_art_author').value = art.author || '';
      document.getElementById('edit_art_read_time').value = art.read_time || '';
      document.getElementById('edit_art_classification').value = art.classification || '';
      document.getElementById('edit_art_content').value = art.content || '';

      const existImg = document.getElementById('editExistingImgSrc');
      if (existImg) existImg.src = resolvedImgUrl;

      const newBox = document.getElementById('editNewImgBox');
      if (newBox) newBox.classList.add('hidden');

      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }
  }

  function closeEditArticleModal() {
    const modal = document.getElementById('editArticleModal');
    if (modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    filterArticles();
  });
</script>