<?php

use App\App;

require_once __DIR__ . '/vendor/autoload.php';

$app = new App();
// TODO A: Clean up the following code so that it's easier to see the different routes and handlers for the API, and simpler to add new ones.
// TODO B: Improve the readability of this file through better documentation.
// TODO C: Improve the performance and accuracy of the prefix search.
// TODO D: Identify and fix any potential security vulnerabilities in this code.

// Define API routes and their corresponding logic
$routes = [
	// Route: Get list of articles
    '' => function () use ($app) { 
        return $app->getListOfArticles();
    },
	// Route: Prefix search
    'prefixsearch' => function ($params) use ($app) { 
        $prefix = filter_var($params['prefix'] ?? '', FILTER_UNSAFE_RAW);
        $listOfArticles = $app->getListOfArticles();
		echo '=--===='; print_r($listOfArticles);
        $matchedArticles = [];

        foreach ($listOfArticles as $article) {
            if (stripos($article, $prefix) !== false) {
                $matchedArticles[] = $article;
            }
        }

        return $matchedArticles;
    },
	// Route: Fetch article by title
    'fetch' => function ($params) use ($app) { 
        $title = filter_var($params['title'] ?? '', FILTER_UNSAFE_RAW);
        return $app->fetch($title);
    },
	
];

// Handle route
$route = $_GET['route'] ?? '';
$action = $routes[$route] ?? null;

if ($action !== null) {
    header('Content-Security-Policy: default-src \'self\';');
    $content = $action($_GET);
    echo json_encode(['content' => $content]);
} else {
    header('Content-Security-Policy: default-src \'self\';');
    echo json_encode(['error' => 'Route not found']);
}

