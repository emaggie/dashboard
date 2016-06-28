<?php 
function get_template($file, $data=array())
{
    if (file_exists($f = TEMPLATE_PATH.'/'.ltrim($file, '/'))) {
        extract($data);
        include($f);
    }
}

function get_header($data=array())
{
    get_template('header.php');
}

function get_footer($data=array())
{
    get_template('footer.php');
}

function get_template_url($uri='')
{
    return base_url(TEMPLATE_URI).ltrim($uri, '/');
}

function template_url($uri='')
{
    echo get_template_url($uri);
}