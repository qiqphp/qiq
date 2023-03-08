{{ extends ('./view-2') }}
{{ setBlock ('foo') }}
Foo 3a View
{{ parentBlock () }}
Foo 3b View
{{ endBlock () }}
View 3 Content should NOT show.
