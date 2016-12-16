<?php
include('../includes/common.php');
ini_set('max_execution_time', 300);

$input = '10001110011110000';

function dCurve($input,$length) {
    if(strlen($input) >= $length) {
        return substr($input,0,$length);
    }
    $revFlip = '';
    for($i=strlen($input)-1;$i>=0;$i--) {
        $revFlip .= $input[$i]==0?1:0;
    }
    return dCurve($input.'0'.$revFlip,$length);
}

function checkSum($input) {
    if(strlen($input) % 2 != 0) {
        return $input;
    }
    $chkSum = '';
    for($i=0;$i<strlen($input);$i=$i+2) {
        $chkSum .= bindec(~(bindec($input[$i])^bindec($input[$i+1])));
    }
    return checkSum($chkSum);
}

function solve($input,$length) {
    return(checkSum(dCurve($input,$length)));
}

dbg('Test checksum: '.solve('10000',20));
dbg('Problem 1 checksum: '.solve($input,272),'lightgreen');
dbg('Problem 2 checksum: '.solve($input,35651584),'lightpink');
