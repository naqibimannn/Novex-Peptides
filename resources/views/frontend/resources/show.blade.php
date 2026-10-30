@extends('frontend.home.index')

@section('content')
@php
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

    $paragraphs = array_filter(array_map('trim', explode("\n", $resource->content ?? '')));
@endphp

<style>
  .hero, .hero.sl, .mq, #lab-reports, #testimonies, .camp, .steps, .art, .g6, .div2,
  section.sec:not(#articleShowSec) {
    display: none !important;
  }

  #articleShowSec {
    display: block !important;
    padding: 60px 0 90px !important;
    background: var(--bg);
    min-height: 80vh;
  }

  .art-container {
    max-width: 860px;
    margin: 0 auto;
    padding: 0 24px;
  }

  .art-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: none;
    padding: 0;
    color: var(--green);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    margin-bottom: 24px;
    text-decoration: none;
    transition: opacity .2s ease;
  }
  .art-back-btn:hover {
    opacity: 0.8;
    text-decoration: underline;
  }

  .art-meta-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
    flex-wrap: wrap;
  }

  .art-pill {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--green);
    background: var(--bg2);
    padding: 5px 14px;
    border-radius: 999px;
    border: 1px solid var(--line);
  }

  .art-time {
    font-size: 13px;
    color: var(--mut);
    font-weight: 500;
  }

  .art-heading {
    font-family: var(--serif);
    font-size: clamp(32px, 4.5vw, 48px);
    font-weight: 600;
    line-height: 1.15;
    color: var(--ink);
    margin-bottom: 12px;
  }

  .art-lead {
    font-size: 17px;
    color: var(--mut);
    line-height: 1.6;
    margin-bottom: 28px;
  }

  .art-main-img-box {
    width: 100%;
    aspect-ratio: 16/9;
    border-radius: 26px;
    overflow: hidden;
    border: 1px solid var(--line);
    margin-bottom: 32px;
    background: var(--card-surface);
    box-shadow: 0 10px 30px rgba(14,40,66,.05);
  }

  .art-main-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .art-prose {
    display: flex;
    flex-direction: column;
    gap: 20px;
    font-size: 16px;
    line-height: 1.85;
    color: var(--ink);
    border-top: 1px solid var(--line);
    padding-top: 28px;
  }

  .art-prose p {
    margin: 0;
  }

  .art-footer-disclaimer {
    font-size: 13px;
    color: var(--mut);
    border-top: 1px solid var(--line);
    margin-top: 40px;
    padding-top: 20px;
    line-height: 1.6;
  }
</style>

<section class="sec" id="articleShowSec">
  <div class="art-container">
    <a href="{{ route('resources') }}" class="art-back-btn">
      &larr; Back to Educational Resources
    </a>

    <div class="art-meta-header">
      <span class="art-pill">Research Literature</span>
      <!-- NAMA AUTHOR DILETAKKAN DI SEBELAH METADATA BACAAN -->
      <span class="art-time">{{ $resource->read_time }} &bull; {{ $resource->author }}</span>
    </div>

    <h1 class="art-heading">{{ $resource->title }}</h1>
    
    @if(!empty($resource->subtitle))
      <p class="art-lead">{{ $resource->subtitle }}</p>
    @endif

    <!-- GAMBAR BANNER PENUH DI BAWAH TAJUK -->
    <div class="art-main-img-box">
      <img src="{{ $resolveImageUrl($resource->image) }}" alt="{{ $resource->title }}">
    </div>

    <!-- AYAT KANDUNGAN ARTIKEL TERSUSUN MENEGAK DI BAWAH GAMBAR -->
    <div class="art-prose">
      @foreach($paragraphs as $p)
        <p>{{ $p }}</p>
      @endforeach
    </div>

    <div class="art-footer-disclaimer">
      <strong>Educational Disclaimer:</strong> This monograph is compiled strictly for analytical context and in-vitro laboratory reference. It does not constitute medical advice or human clinical recommendations.
    </div>
  </div>
</section>
@endsection