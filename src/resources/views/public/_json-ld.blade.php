<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ url($news->uri()) }}"
    },
    "headline": "{{ $news->title }}",
    "image": [
        "{{ $news->present()->image() }}"
    ],
    "datePublished": "{{ $news->date }}",
    "dateModified": "{{ $news->updated_at }}",
    "author": {
        "@type": "Organization",
        "name": "{{ config('app.name') }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ config('app.name') }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ Storage::url('settings/' . config('typicms.image')) }}"
        }
    },
    "description": "{{ preg_replace( "/\r|\n/", " ", $news->summary) }}"
}
</script>
