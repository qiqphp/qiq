{{ /** @var Qiq\Engine&Qiq\Helper\Html\HtmlHelpers $this */ }}
<!DOCTYPE html>
<html lang="en">
<head>
{{ setBlock ('head_title') }}{{= getBlock () ~}}
{{ setBlock ('head_meta') }}{{= getBlock () ~}}
{{ setBlock ('head_links') }}{{= getBlock () ~}}
{{ setBlock ('head_styles') }}
    <link rel="stylesheet" href="/theme/basic.css" type="text/css" media="screen" />
{{= getBlock () ~}}
{{ setBlock ('head_scripts') }}{{= getBlock () ~}}
</head>
<body>
{{ setBlock ('body_header') }}{{= getBlock () ~}}
{{ setBlock ('body_content') }}{{= getBlock () ~}}
{{ setBlock ('body_footer') }}{{= getBlock () ~}}
</body>
</html>
