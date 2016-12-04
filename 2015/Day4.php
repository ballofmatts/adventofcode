<?php
include('../includes/common.php');

$secret = 'bgvyzdsv';

$problem = 1;   //change between 1 and 2 to get different problem behavior

if($problem == 1) {
    $sliceAmount = 5;
    $searchString = '00000';
}
if($problem == 2) {
    $sliceAmount = 6;
    $searchString = '000000';
}

$keyFound = false;

$currentKey = 0;
while(!$keyFound)
{
    if(substr(md5($secret.$currentKey),0,$sliceAmount) === $searchString) {
        $keyFound = true;
    }
    else {
        $currentKey++;
    }
}

dbg('key: '.$currentKey.'<br>md5: '.md5($secret.$currentKey));
