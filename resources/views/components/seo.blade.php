@props([
    'title' => 'Novex Peptides | Precision in Every Molecule',
    'description' => 'Advanced peptide research and high-purity compounds. Precision micro-pipetting, HPLC chromatographic testing, and cold-chain shipping worldwide.',
    'canonical' => null,
    'ogImage' => null,
    'type' => 'website',
    'noindex' => false,
    'schema' => null,
    'geo' => true,
    'latitude' => '3.139003',
    'longitude' => '101.686855',
    'placename' => 'Kuala Lumpur',
    'region' => 'MY-14'
])

@php
    $canonicalUrl = $canonical ?? url()->current();
    $defaultImage = asset('assets/website/home/hero1.webp');
    $shareImage = $ogImage ? (filter_var($ogImage, FILTER_VALIDATE_URL) ? $ogImage : asset($ogImage)) : $defaultImage;
    $cleanDescription = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($description))), 160);
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $cleanDescription }}">
<meta name="robots" content="{{ $noindex ? 'noindex, nofollow' : 'index, follow, max-image-preview:large' }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

@if($geo)
<meta name="geo.region" content="{{ $region }}">
<meta name="geo.placename" content="{{ $placename }}">
<meta name="geo.position" content="{{ $latitude }};{{ $longitude }}">
<meta name="ICBM" content="{{ $latitude }}, {{ $longitude }}">
@endif

<meta property="og:site_name" content="Novex Peptides">
<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $cleanDescription }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:image" content="{{ $shareImage }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $cleanDescription }}">
<meta name="twitter:image" content="{{ $shareImage }}">

@if(!empty($schema))
<script type="application/ld+json">
{!! is_array($schema) ? json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) : $schema !!}
</script>
@endif