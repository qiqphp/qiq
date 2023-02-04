{{ extends ('./view-1') }}
{{ setBlock ('foo') }}
{{ parentBlock () }}
Foo 2 View
{{ endBlock () }}
View 2 Content should NOT show.
