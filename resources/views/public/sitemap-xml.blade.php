{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ url('/') }}</loc><changefreq>daily</changefreq><priority>1.0</priority></url>
    <url><loc>{{ route('topics.index') }}</loc><changefreq>daily</changefreq><priority>0.9</priority></url>
    <url><loc>{{ route('figures.index') }}</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
    @foreach($topics as $topic)
    <url>
        <loc>{{ $topic->routeUrl() }}</loc>
        <lastmod>{{ $topic->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @foreach($figures as $figure)
    <url>
        <loc>{{ $figure->routeUrl() }}</loc>
        <lastmod>{{ $figure->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
</urlset>
