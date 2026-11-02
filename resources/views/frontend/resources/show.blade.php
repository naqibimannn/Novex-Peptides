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

    $artShowCssPath = 'frontend/resources/show.css';
    $artShowCssVer = file_exists(public_path($artShowCssPath)) ? filemtime(public_path($artShowCssPath)) : time();

    $artShowJsPath = 'frontend/resources/show.js';
    $artShowJsVer = file_exists(public_path($artShowJsPath)) ? filemtime(public_path($artShowJsPath)) : time();
@endphp

<link rel="stylesheet" href="{{ asset($artShowCssPath) }}?v={{ $artShowCssVer }}">

<section class="article-show-sec" id="articleShowSec">
  <div class="art-container">
    <a href="{{ route('resources') }}" class="art-back-btn">
      &larr; Back to Educational Resources
    </a>

    <div class="art-meta-header">
      <span class="art-pill">Research Literature</span>
      <span class="art-time">{{ $resource->read_time }} &bull; {{ $resource->author }}</span>
    </div>

    <h1 class="art-heading">{{ $resource->title }}</h1>
    
    @if(!empty($resource->subtitle))
      <p class="art-lead">{{ $resource->subtitle }}</p>
    @endif

    <div class="art-main-img-box">
      <img src="{{ $resolveImageUrl($resource->image) }}" alt="{{ $resource->title }}" loading="lazy">
    </div>

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

<script src="{{ asset($artShowJsPath) }}?v={{ $artShowJsVer }}"></script>
@endsection