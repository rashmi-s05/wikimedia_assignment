<?php

use App\App;

require_once __DIR__ . '/vendor/autoload.php';

$app = new App();

echo "<head>
<link rel='stylesheet' href='http://design.wikimedia.org/style-guide/css/build/wmui-style-guide.min.css'>
<link rel='stylesheet' href='styles.css'>
<script src='main.js'></script>
</head>";

$title = '';
$body = '';
if ( isset( $_GET['title'] ) ) {
	$title = htmlentities( $_GET['title'] );
	$body = $app->fetch( $_GET );
	$body = file_get_contents( sprintf( 'articles/%s', $title ) );
}

$wordCount = wfGetWc();
echo "<body>";
echo "<div id=header class=header>
<a href='/'>Article editor</a><div>$wordCount</div>
</div>";
echo "<div class='page'>";
echo "<div class='main'>";
echo "<h2>Create/Edit Article</h2>
<p>Create a new article by filling out the fields below. Edit an article by typing the beginning of the title in the title field, selecting the title from the auto-complete list, and changing the text in the textfield.</p>
<form action='index.php' method='post'>
<input name='title' type='text' placeholder='Article title...' value=$title>
<br />
<textarea name='body' placeholder='Article body...' >$body</textarea>
<br />
<a class='submit-button' href='#' />Submit</a>
<br />
<h2>Preview</h2>
$title\n\n
$body
<h2>Articles</h2>
<ul>
<li><a href='index.php?title=Foo'>Foo</a></li>
</ul>
</form>";

if ( $_POST ) {
	$app->save( sprintf( "articles/%s", $_POST['title'] ), $_POST['body'] );
}
echo "</div>";
echo "</div>";
echo "</body";

function wfGetWc() {
	global $wgBaseArticlePath;
	$wgBaseArticlePath = 'articles/';
	$wc = 0;
	$dir = new DirectoryIterator( $wgBaseArticlePath );
	foreach ( $dir as $fileinfo ) {
		if ( $fileinfo->isDot() ) {
			continue;
		}
		$c = file_get_contents( $wgBaseArticlePath . $fileinfo->getFilename() );
		$ch = explode( " ", $c );
		$wc += count( $ch );
	}
	return "$wc words written";
}
