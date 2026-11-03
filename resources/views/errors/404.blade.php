@extends('frontend.home.index')

@section('seo')
<x-seo 
    title="404 - Page Not Found | Novex Peptides"
    description="The requested laboratory page or formulation could not be found."
    :noindex="true"
/>
@endsection

@section('content')
<section class="sec" style="min-height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 80px 20px;">
  <div class="wrap" style="max-width: 600px; margin: 0 auto;">
    <span style="font-size: 12px; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: var(--brand, #0071E3);">Error 404</span>
    <h1 style="font-size: clamp(32px, 5vw, 48px); font-weight: 800; margin: 12px 0 16px; color: var(--text-main, #0F172A);">Formulation Not Found</h1>
    <p style="font-size: 15px; line-height: 1.6; color: var(--text-muted, #5A6F82); margin-bottom: 32px;">
      The URL or research monograph you requested does not exist, has been archived, or was moved to another section of the catalog.
    </p>
    <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
      <a href="{{ route('home') }}" class="btn-primary-pill" style="padding: 12px 28px; text-decoration: none;">Return to Home</a>
      <a href="{{ route('products.index') }}" class="btn-outline-pill" style="padding: 12px 28px; text-decoration: none;">Browse Catalog</a>
    </div>
  </div>
</section>
@endsection