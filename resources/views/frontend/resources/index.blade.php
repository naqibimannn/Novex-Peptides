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

<section class="sec block pt-[60px] pb-[90px] bg-white dark:bg-[#0A111A] min-h-[80vh] transition-colors duration-200" id="articleShowSec">
  <div class="art-container max-w-[860px] mx-auto px-6">
    <a href="{{ route('resources') }}" class="art-back-btn inline-flex items-center gap-2 bg-transparent border-0 p-0 text-[#2F6F9F] dark:text-[#327BB3] text-[13px] font-semibold cursor-pointer mb-6 no-underline transition-opacity duration-200 hover:opacity-80 hover:underline">
      &larr; Back to Educational Resources
    </a>

    <div class="art-meta-header flex items-center justify-between gap-3 mb-4 flex-wrap">
      <span class="art-pill text-[11px] font-bold uppercase tracking-[0.08em] text-[#2F6F9F] dark:text-[#327BB3] bg-[#E9F2FA] dark:bg-[#101B27] py-1 px-3.5 rounded-full border border-[#D2E2EF] dark:border-[#1C2D3E]">Research Literature</span>
      <span class="art-time text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] font-medium">{{ $resource->read_time }} &bull; {{ $resource->author }}</span>
    </div>

    <h1 class="art-heading font-serif text-[clamp(32px,4.5vw,48px)] font-semibold leading-[1.15] text-[#1E2D3B] dark:text-[#F0F6FC] mb-3">{{ $resource->title }}</h1>
    
    @if(!empty($resource->subtitle))
      <p class="art-lead text-[17px] text-[#5A6F82] dark:text-[#8EA4B8] leading-[1.6] mb-7">{{ $resource->subtitle }}</p>
    @endif

    <div class="art-main-img-box w-full aspect-video rounded-[26px] overflow-hidden border border-[#D2E2EF] dark:border-[#1C2D3E] mb-8 bg-white dark:bg-[#132232] shadow-[0_10px_30px_rgba(14,40,66,0.05)]">
      <img src="{{ $resolveImageUrl($resource->image) }}" alt="{{ $resource->title }}" class="w-full h-full object-cover block">
    </div>

    <div class="art-prose flex flex-col gap-5 text-base leading-[1.85] text-[#1E2D3B] dark:text-[#F0F6FC] border-t border-[#D2E2EF] dark:border-[#1C2D3E] pt-7">
      @foreach($paragraphs as $p)
        <p class="m-0">{{ $p }}</p>
      @endforeach
    </div>

    <div class="art-footer-disclaimer text-[13px] text-[#5A6F82] dark:text-[#8EA4B8] border-t border-[#D2E2EF] dark:border-[#1C2D3E] mt-10 pt-5 leading-[1.6]">
      <strong class="text-[#1E2D3B] dark:text-[#F0F6FC]">Educational Disclaimer:</strong> This monograph is compiled strictly for analytical context and in-vitro laboratory reference. It does not constitute medical advice or human clinical recommendations.
    </div>
  </div>
</section>
@endsection