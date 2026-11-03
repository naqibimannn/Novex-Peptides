@extends('frontend.home.index')

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

    $artImgUrl = $resolveImageUrl($resource->image ?? '');
    
    $cleanDescription = !empty($resource->subtitle) 
        ? \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($resource->subtitle))), 155)
        : \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($resource->content ?? ''))), 155);

    if (empty($cleanDescription)) {
        $cleanDescription = $resource->title . ' - Scientific monograph and laboratory literature review published by Novex Peptides.';
    }

    $artSlug = !empty($resource->slug) ? $resource->slug : \Illuminate\Support\Str::slug($resource->title ?? ('article-' . $resource->id));
    $canonicalUrl = url('/resources/' . $artSlug);

    $publishedDate = !empty($resource->created_at) ? \Carbon\Carbon::parse($resource->created_at)->toIso8601String() : now()->toIso8601String();
    $modifiedDate = !empty($resource->updated_at) ? \Carbon\Carbon::parse($resource->updated_at)->toIso8601String() : $publishedDate;

    $articleSchema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => 'Home',
                        'item' => url('/')
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => 'Educational Resources',
                        'item' => route('resources')
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 3,
                        'name' => $resource->title,
                        'item' => $canonicalUrl
                    ]
                ]
            ],
            [
                '@type' => 'Article',
                'headline' => $resource->title,
                'description' => $cleanDescription,
                'image' => [$artImgUrl],
                'datePublished' => $publishedDate,
                'dateModified' => $modifiedDate,
                'author' => [
                    '@type' => 'Person',
                    'name' => $resource->author ?: 'Novex Research Desk'
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'Novex Peptides',
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('logo.png')
                    ]
                ],
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => $canonicalUrl
                ]
            ]
        ]
    ];

    $artShowCssPath = 'frontend/resources/show.css';
    $artShowCssVer = file_exists(public_path($artShowCssPath)) ? filemtime(public_path($artShowCssPath)) : time();

    $artShowJsPath = 'frontend/resources/show.js';
    $artShowJsVer = file_exists(public_path($artShowJsPath)) ? filemtime(public_path($artShowJsPath)) : time();
@endphp

@section('seo')
<x-seo 
    :title="$resource->title . ' | Novex Peptides Research'"
    :description="$cleanDescription"
    :og-image="$artImgUrl"
    :canonical="$canonicalUrl"
    :type="'article'"
    :schema="$articleSchema"
/>
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset($artShowCssPath) }}?v={{ $artShowCssVer }}">

<section class="article-show-sec" id="articleShowSec">
  <div class="art-container">
    <a href="{{ route('resources') }}" class="art-back-btn">
      &larr; Back to Educational Resources
    </a>

    <div class="art-meta-header">
      <span class="art-pill">{{ $resource->classification ?: 'Research Literature' }}</span>
      <span class="art-time">{{ $resource->read_time }} &bull; {{ $resource->author }}</span>
    </div>

    <h1 class="art-heading">{{ $resource->title }}</h1>
    
    @if(!empty($resource->subtitle))
      <p class="art-lead">{{ $resource->subtitle }}</p>
    @endif

    <div class="art-main-img-box">
      <img src="{{ $artImgUrl }}" alt="{{ $resource->title }}" width="900" height="500" loading="lazy">
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