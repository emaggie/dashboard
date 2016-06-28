<?php 
function app()
{
    return $GLOBALS['app'];
}

function base_url($uri='')
{
    $base_url = app()->getContainer()->request->getUri()->getBaseUrl();

    return $base_url.'/'.ltrim($uri, '/');
}

function dd()
{
    dump(func_get_args());
    die();
}

function view_render($file, $args=array(), $response=null)
{
    if (is_null($response))
        $response = app()->getContainer()->response;

    return app()->getContainer()->renderer->render($response, $file.'.php', $args);
}

include('helpers/template.php');