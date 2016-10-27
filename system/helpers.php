<?php 

function dump($what)
{
    echo '<pre>';
    var_dump($what);
    echo '</pre>';
}

function dd($what)
{
    dump($what);
    die();
}