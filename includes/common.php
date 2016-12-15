<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 1);

function dbg($value,$color = 'yellow')
{
    echo '<div style="border:1px solid black; background-color:'.$color.'; padding:5px;"><pre>';
    print_r($value);
    echo '</pre></div>';
    flush();
    ob_flush();
}
