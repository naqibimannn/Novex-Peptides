{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('about') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('products.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('science') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('resources') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('contact') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    @foreach($products as $prod)
        @php
            $pSlug = !empty($prod->slug) ? $prod->slug : Str::slug($prod->title ?? ('product-' . $prod->id));
            $pDate = !empty($prod->updated_at) ? \Carbon\Carbon::parse($prod->updated_at)->toAtomString() : now()->toAtomString();
        @endphp
        <url>
            <loc>{{ url('/products/' . $pSlug) }}</loc>
            <lastmod>{{ $pDate }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    @foreach($articles as $art)
        @php
            $aSlug = !empty($art->slug) ? $art->slug : Str::slug($art->title ?? ('article-' . $art->id));
            $aDate = !empty($art->updated_at) ? \Carbon\Carbon::parse($art->updated_at)->toAtomString() : now()->toAtomString();
        @endphp
        <url>
            <loc>{{ url('/resources/' . $aSlug) }}</loc>
            <lastmod>{{ $aDate }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>