{{ extends ('./layout-1') }}
{{ setBlock ('foo') }}
{{ parentBlock () }}
Foo 2 Layout
{{ endBlock () }}
Layout 2 Content should NOT show.
