<?php
// Routes
/*$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});*/
$app->get('/', function ($request, $response, $args) {
    // Sample log message
    //$this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'dashboard.php', $args);
});

$app->get('/news[/{channel}]', Maggie\Dashboard\Controllers\NewsController::class.':index')->setName('news_index');
$app->get('/news/preview/{channel}', Maggie\Dashboard\Controllers\NewsController::class.':preview')->setName('news_preview');
$app->get('/news/{channel}/page/{page}', Maggie\Dashboard\Controllers\NewsController::class.':index')->setName('news_preview');