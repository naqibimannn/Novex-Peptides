@extends('frontend.home.index')

@section('content')
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
@endphp

<style>
.res-card{
  background:var(--card-surface);
  border:1px solid var(--line);
  border-radius:24px;
  overflow:hidden;
  display:flex;
  flex-direction:column;
  transition:transform .3s ease, box-shadow .3s ease, border-color .3s ease, background-color .25s ease;
  text-decoration:none;
}
.res-card:hover{
  transform:translateY(-6px);
  box-shadow:0 24px 44px -20px rgba(47,111,159,.35);
  border-color:var(--gold);
}
.res-thumb{
  width:100%;
  aspect-ratio:16/10;
  overflow:hidden;
  background:var(--card-surface);
}
.res-thumb img{
  width:100%;
  height:100%;
  object-fit:cover;
  transition:transform .5s ease;
}
.res-card:hover .res-thumb img{
  transform:scale(1.04);
}
.res-body{
  padding:22px;
  display:flex;
  flex-direction:column;
  flex:1;
}
.res-body h3{
  color:var(--ink);
  transition:color .25s ease;
}
</style>

<section class="hero">
  <img id="heroImage" src="{{ asset('assets/website/resources/hero.webp') }}" href="{{ asset('assets/website/resources/hero.webp') }}" alt="Educational Resources" onerror="this.src='https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1800&q=85'">
  <div class="wrap">
    <div class="in">
      <span style="font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;margin-bottom:12px;display:block">Resources &amp; Literature</span>
      <h1>Read before you research</h1>
      <p>Short, careful articles on the compounds in our catalogue, written to explain rather than to sell.</p>
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    <div class="head">
      <div>
        <h1 style="font-size:42px">Educational Resources</h1>
        <p>Short, careful articles on the compounds in our catalogue, written to explain rather than to sell.</p>
      </div>
    </div>
    
    <div class="g4">
      @forelse($articles as $art)
        <a class="res-card" href="{{ url('/resources/' . $art->slug) }}">
          <div class="res-thumb">
            <img src="{{ $resolveImageUrl($art->image) }}" alt="{{ $art->title }}" loading="lazy">
          </div>
          <div class="res-body">
            <h3 style="font-size:20px;line-height:1.25">{{ $art->title }}</h3>
            <p style="font-size:13px;color:var(--mut);margin:10px 0 16px;line-height:1.55">
              {{ $art->subtitle }}
            </p>
            <span style="font-size:12px;font-weight:600;color:var(--green);margin-top:auto">Read Article &rarr;</span>
          </div>
        </a>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 48px 0; color: var(--mut);">
          No educational resources currently published.
        </div>
      @endforelse
    </div>

    <div style="font-size:12px;color:var(--mut);border-top:1px solid var(--line);margin-top:40px;padding-top:16px">
      Educational content for research context only. It is not medical advice, diagnosis, or clinical recommendation.
    </div>
  </div>
</section>

<script>
function updateHeroBanner(){
  const heroImg = document.getElementById('heroImage');
  if (!heroImg) return;

  const isPortraitOrSmall = window.matchMedia('(orientation: portrait), (max-width: 768px)').matches;
  const targetUrl = isPortraitOrSmall
    ? "{{ asset('assets/website/resources/hero-phone.webp') }}"
    : "{{ asset('assets/website/resources/hero.webp') }}";

  if (heroImg.getAttribute('src') !== targetUrl) {
    heroImg.setAttribute('src', targetUrl);
  }
  if (heroImg.getAttribute('href') !== targetUrl) {
    heroImg.setAttribute('href', targetUrl);
  }
}

const heroMediaQuery = window.matchMedia('(orientation: portrait), (max-width: 768px)');
if (heroMediaQuery.addEventListener) {
  heroMediaQuery.addEventListener('change', updateHeroBanner);
} else if (heroMediaQuery.addListener) {
  heroMediaQuery.addListener(updateHeroBanner);
}
window.addEventListener('resize', updateHeroBanner);
document.addEventListener('DOMContentLoaded', updateHeroBanner);
updateHeroBanner();
</script>
@endsection