@extends('frontend.home.index')

@php
    $articles = \Illuminate\Support\Facades\DB::select("SELECT * FROM resources ORDER BY id DESC");
    
    $resolveImageUrl = function($path) {
        if (empty($path)) return asset('assets/website/science/s1.webp');
        if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
        $clean = ltrim($path, '/');
        if (file_exists(public_path($clean))) return asset($clean) . '?v=' . filemtime(public_path($clean));
        if (file_exists(public_path('uploads/resources/' . basename($clean)))) {
            return asset('uploads/resources/' . basename($clean)) . '?v=' . time();
        }
        return asset($clean);
    };

    $itemListElements = [];
    foreach ($articles as $index => $art) {
        $artSlug = !empty($art->slug) ? $art->slug : \Illuminate\Support\Str::slug($art->title ?? ('article-' . $art->id));
        $itemListElements[] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $art->title,
            'url' => url('/resources/' . $artSlug),
        ];
    }

    $canonicalUrl = \Illuminate\Support\Facades\Route::has('resources') ? route('resources') : url('/resources');

    $resCssPath = 'frontend/resources/resources.css';
    $resCssVer = file_exists(public_path($resCssPath)) ? filemtime(public_path($resCssPath)) : time();

    $resJsPath = 'frontend/resources/resources.js';
    $resJsVer = file_exists(public_path($resJsPath)) ? filemtime(public_path($resJsPath)) : time();
@endphp

@section('seo')
<x-seo 
    title="Educational Resources &amp; Peptide Research Literature | Novex Peptides"
    description="Explore peer-reviewed scientific reviews, chemical monographs, and compound mechanisms curated for laboratory reference and peptide research."
    :canonical="$canonicalUrl"
    :schema="[
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => 'Novex Peptides Educational Resources',
        'url' => $canonicalUrl,
        'description' => 'Explore peer-reviewed scientific reviews, chemical monographs, and compound mechanisms curated for laboratory reference and peptide research.',
        'mainEntity' => [
            '@type' => 'ItemList',
            'itemListElement' => $itemListElements
        ]
    ]"
/>
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset($resCssPath) }}?v={{ $resCssVer }}">

<section class="resources-hero">
  <img id="heroImage" 
       src="{{ asset('assets/website/resources/hero.webp') }}" 
       data-desktop="{{ asset('assets/website/resources/hero.webp') }}" 
       data-phone="{{ asset('assets/website/resources/hero-phone.webp') }}" 
       alt="Educational Resources &amp; Scientific Monograph" 
       width="1800"
       height="700"
       onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'">
  <div class="wrap">
    <div class="in">
      <span class="eyebrow">Resources &amp; Literature</span>
      <h1>Read before you research</h1>
      <p>Short, careful articles on the compounds in our catalogue, written to explain rather than to sell.</p>
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    <div class="head">
      <div>
        <h2 class="sec-title">Educational Resources</h2>
        <p class="sec-desc">Short, careful articles on the compounds in our catalogue, written to explain rather than to sell.</p>
      </div>
    </div>
    
    <div class="res-grid">
      @forelse($articles as $art)
        @php
            $artSlug = !empty($art->slug) ? $art->slug : \Illuminate\Support\Str::slug($art->title ?? ('article-' . $art->id));
        @endphp
        <a class="res-card" href="{{ url('/resources/' . $artSlug) }}">
          <div class="res-thumb">
            <img src="{{ $resolveImageUrl($art->image) }}" alt="{{ $art->title }}" width="400" height="260" loading="lazy">
          </div>
          <div class="res-body">
            <h3>{{ $art->title }}</h3>
            <p>{{ $art->subtitle }}</p>
            <span class="res-link-text">Read Article &rarr;</span>
          </div>
        </a>
      @empty
        <div class="res-empty">
          No educational resources currently published.
        </div>
      @endforelse
    </div>

    <div class="res-disclaimer">
      Educational content for research context only. It is not medical advice, diagnosis, or clinical recommendation.
    </div>
  </div>
</section>

<script>
window.NVX_RESOURCES = {
  heroPhone: '{{ asset("assets/website/resources/hero-phone.webp") }}',
  heroDesktop: '{{ asset("assets/website/resources/hero.webp") }}'
};
</script>
<script src="{{ asset($resJsPath) }}?v={{ $resJsVer }}"></script>
@endsection