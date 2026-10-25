@php
    $productList = $products ?? DB::select("SELECT * FROM products ORDER BY id DESC");
    $secret = $secret ?? config('admin.secret_key', env('ADMIN_SECRET_KEY'));
@endphp

<div class="flex flex-col gap-6">

  <!-- TAJUK & BUTANG TAMBAH -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
    <div>
      <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Katalog Produk</h2>
      <p class="text-xs text-slate-500 mt-1">Urus senarai formulasi, spesifikasi harga, serta paparan produk langsung di halaman utama.</p>
    </div>
    <div>
      <button type="button" onclick="openCreateProductModal()"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand hover:bg-brand-hover text-white text-xs font-bold transition-all shadow-sm cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        <span>Tambah Produk Baru</span>
      </button>
    </div>
  </div>

  <!-- JADUAL SENARAI PRODUK -->
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs text-slate-600">
        <thead class="bg-slate-50/80 text-slate-500 font-bold border-b border-slate-200 uppercase tracking-wider text-[11px]">
          <tr>
            <th class="py-3.5 px-4">Imej</th>
            <th class="py-3.5 px-4">Nama Produk</th>
            <th class="py-3.5 px-4">Harga (RM)</th>
            <th class="py-3.5 px-4">Spesifikasi / Dos</th>
            <th class="py-3.5 px-4">Kategori / Badge</th>
            <th class="py-3.5 px-4 text-right">Tindakan</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 font-medium">
          @forelse($productList as $prod)
            <tr class="hover:bg-slate-50/60 transition-colors">
              <td class="py-3 px-4">
                <div class="w-12 h-14 rounded-xl overflow-hidden border border-slate-200 flex items-center justify-center bg-slate-100 shrink-0">
                  @if(!empty($prod->image) && file_exists(public_path($prod->image)))
                    <img src="{{ asset($prod->image) }}" alt="{{ $prod->title }}" class="w-full h-full object-cover">
                  @else
                    <span class="font-serif font-bold text-lg text-slate-400 select-none">N</span>
                  @endif
                </div>
              </td>
              <td class="py-3 px-4">
                <div class="font-bold text-slate-800 text-sm">{{ $prod->title }}</div>
                <div class="text-[11px] text-slate-400 font-mono mt-0.5">/products/{{ $prod->slug }}</div>
              </td>
              <td class="py-3 px-4 text-emerald-600 font-bold">
                {{ $prod->price }}
              </td>
              <td class="py-3 px-4">
                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-[11px] font-semibold">
                  {{ $prod->dosage_spec ?? 'N/A' }}
                </span>
              </td>
              <td class="py-3 px-4">
                <span class="px-2.5 py-1 rounded-full bg-brand/10 text-brand text-[11px] font-semibold">
                  {{ $prod->badge_category ?? 'Research grade' }}
                </span>
              </td>
              <td class="py-3 px-4 text-right">
                <div class="inline-flex items-center gap-1.5 justify-end">
                  <button type="button" 
                    onclick='openEditProductModal(@json($prod))'
                    class="p-2 rounded-lg text-slate-500 hover:text-brand hover:bg-brand-tint transition-all cursor-pointer" title="Edit Produk">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>

                  <form action="{{ url('admin/' . $secret . '/products/' . $prod->id) }}" method="POST" onsubmit="return confirm('Adakah anda pasti untuk memadam produk ini?');" class="inline m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all cursor-pointer" title="Padam Produk">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-12 text-center text-slate-400">
                Tiada produk dalam pangkalan data. Sila klik butang di atas untuk menambah produk baru.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL: TAMBAH PRODUK BARU -->
<div id="createProductModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 flex flex-col gap-5">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
      <h3 class="font-extrabold text-base text-slate-900">Tambah Produk Baru</h3>
      <button type="button" onclick="closeCreateProductModal()" class="text-slate-400 hover:text-slate-700 text-lg cursor-pointer">✕</button>
    </div>

    <form action="{{ url('admin/' . $secret . '/products') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Produk *</label>
        <input type="text" name="title" required placeholder="Contoh: Retatrutide" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20">
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga *</label>
          <input type="text" name="price" required placeholder="RM280.00" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Dos / Saiz</label>
          <input type="text" name="dosage_spec" placeholder="10mg - 100mg" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20">
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori / Badge Label</label>
        <input type="text" name="badge_category" placeholder="Research grade" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20">
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Imej Produk (Pilihan)</label>
        <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
        <p class="text-[11px] text-slate-400 mt-1">Jika tiada imej dimuat naik, sistem memaparkan simbol "N".</p>
      </div>

      <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-100">
        <button type="button" onclick="closeCreateProductModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100">Batal</button>
        <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand hover:bg-brand-hover shadow-sm">Simpan Produk</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: KEMASKINI PRODUK -->
<div id="editProductModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 flex flex-col gap-5">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
      <h3 class="font-extrabold text-base text-slate-900">Kemaskini Produk</h3>
      <button type="button" onclick="closeEditProductModal()" class="text-slate-400 hover:text-slate-700 text-lg cursor-pointer">✕</button>
    </div>

    <form id="editProductForm" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      @method('PUT')
      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Produk *</label>
        <input type="text" id="edit_title" name="title" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20">
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga *</label>
          <input type="text" id="edit_price" name="price" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Dos / Saiz</label>
          <input type="text" id="edit_dosage_spec" name="dosage_spec" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20">
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori / Badge Label</label>
        <input type="text" id="edit_badge_category" name="badge_category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand/20">
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tukar Imej (Pilihan)</label>
        <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
      </div>

      <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-100">
        <button type="button" onclick="closeEditProductModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100">Batal</button>
        <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand hover:bg-brand-hover shadow-sm">Kemaskini Perubahan</button>
      </div>
    </form>
  </div>
</div>

<script>
  function openCreateProductModal() {
    const modal = document.getElementById('createProductModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeCreateProductModal() {
    const modal = document.getElementById('createProductModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  function openEditProductModal(product) {
    const modal = document.getElementById('editProductModal');
    const form = document.getElementById('editProductForm');
    const secret = "{{ $secret }}";

    form.action = `{{ url('admin') }}/${secret}/products/${product.id}`;
    document.getElementById('edit_title').value = product.title || '';
    document.getElementById('edit_price').value = product.price || '';
    document.getElementById('edit_dosage_spec').value = product.dosage_spec || '';
    document.getElementById('edit_badge_category').value = product.badge_category || '';

    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeEditProductModal() {
    const modal = document.getElementById('editProductModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>