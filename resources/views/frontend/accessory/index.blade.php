@extends('frontend.home.index')

@section('content')
@php
    $accessories = \Illuminate\Support\Facades\DB::select(
        "SELECT * FROM products WHERE page_type = 'accessory' OR category IN ('Accessory', 'Injection Kit', 'Syringes') ORDER BY id DESC"
    );
@endphp

<section class="sec" id="cat">
  <div class="wrap">
    <div class="head">
      <div>
        <h1 style="font-size:clamp(36px,5vw,60px)">Accessories</h1>
        <p>Laboratory-grade reconstitution kits, administration sets, and precision needles formulated for accurate laboratory measurement.</p>
      </div>
    </div>

    <input id="q" class="sq" type="search" placeholder="Search accessories, needles or kits..." oninput="filterAccessories()">

    <div class="filter" id="flt">
      <button type="button" class="on" onclick="setCategoryFilter('All', this)">All</button>
      <button type="button" onclick="setCategoryFilter('Injection Kit', this)">Reconstitution Sets</button>
      <button type="button" onclick="setCategoryFilter('Syringes', this)">Precision Syringes</button>
      <button type="button" onclick="setCategoryFilter('Accessory', this)">General Accessories</button>
    </div>
    
    <div class="g4" id="pg">
      @forelse($accessories as $acc)
        @php
          $imgs = ['ik1.webp'];
          if (!empty($acc->image)) {
              $decoded = json_decode($acc->image, true);
              $imgs = (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && count($decoded) > 0)
                  ? $decoded
                  : [$acc->image];
          }
        @endphp
        <div class="card pc" data-category="{{ $acc->category }}" data-keywords="{{ strtolower($acc->keywords ?? $acc->title) }}">
          <div class="ph">
            <div class="prod-slider">
              <div class="prod-slides">
                @foreach($imgs as $idx => $img)
                  <div class="prod-slide {{ $idx === 0 ? 'active' : '' }}">
                    <img src="{{ asset($img) }}" alt="{{ $acc->title }} {{ $idx + 1 }}" onerror="this.src='https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=600'">
                  </div>
                @endforeach
              </div>
              @if(count($imgs) > 1)
                <div class="ps-dots">
                  @foreach($imgs as $idx => $img)
                    <span class="ps-dot {{ $idx === 0 ? 'active' : '' }}" onclick="setCardSlideCatalog(this, {{ $idx }})"></span>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
          <div class="b">
            <h3>{{ $acc->title }}</h3>
            <p class="s">{{ $acc->subtitle }}</p>
            <div style="font-size:17px;font-weight:700;color:var(--green);margin-top:4px">{{ $acc->price }}</div>
            <div class="meta">
              <span style="font-weight:600">{{ $acc->dosage_spec ?? 'Standard' }}</span>
              <span>{{ $acc->badge_category ?? 'Laboratory Item' }} ({{ $acc->stock ?? 0 }} in stock)</span>
            </div>
            <a class="btn-details" href="{{ route('accessory.show', $acc->slug) }}">See Details</a>
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align:center; padding:48px 0; color:var(--mut)">
          <p>No accessories available right now.</p>
        </div>
      @endforelse
    </div>

    <div id="noMatchMsg" style="display:none;text-align:center;padding:48px 0;color:var(--mut)">
      <p style="font-size:16px">No accessories match your search or filter.</p>
    </div>

    <p style="font-size:12px;color:var(--mut);border-top:1px solid var(--line);margin-top:36px;padding-top:16px">
      All accessories are individually sealed, sterile, and intended strictly for laboratory and peptide preparation assays.
    </p>
  </div>
</section>