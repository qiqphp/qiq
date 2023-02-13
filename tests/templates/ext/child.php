{{ /** @var Qiq\Engine&Qiq\Helper\Html\HtmlHelpers $this */ }}
{{ extends ('./parent') }}

{{ setBlock ('head_title') }}
    <title>
        My Extended Page
    </title>
{{ endBlock () }}

{{ setBlock ('head_meta') }}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{{ endBlock () }}

{{ setBlock ('head_styles') }}
{{ parentBlock () }}
    <link rel="stylesheet" href="/theme/custom.css" type="text/css" media="screen" />
{{ endBlock () }}

{{ setBlock ('body_content') }}
    <p>The main content for my extended page.</p>
{{ endBlock () }}
