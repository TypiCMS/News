<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ url($model->uri()) }}"
    },
    "headline": "{{ $model->title }}",
    "image": [
        "{{ $model->present()->image() }}"
    ],
    "datePublished": "{{ $model->date }}",
    "dateModified": "{{ $model->updated_at }}",
    "author": {
        "@type": "Organization",
        "name": "microStart"
    },
    "publisher": {
        "@type": "Organization",
        "name": "microStart",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ Storage::url('settings/' . config('typicms.image')) }}"
        }
    },
    "description": "{{ preg_replace( "/\r|\n/", " ", $model->summary) }}"
}
</script>
