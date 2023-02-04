{{ extends ('./layout-2') }}
{{ setBlock ('foo') }}
{{ parentBlock () }}
Foo 3 Layout
{{ endBlock () }}
Layout 3 Content should NOT show.
