<?php
include('../includes/common.php');
ini_set('memory_limit', '1024M');
$wordsFile = file_get_contents('./5.dat', true);

$words = explode("\n", $wordsFile);

//$words = array('ugknbfddgicrmopn','aaa','jchzalrnumimnmhp','haegwjzuvuyypxyu','dvszwmarrgswjxmb');

$p1total = 0;
$p2total = 0;
foreach($words as $word) {
    if(preg_match('/([aeiou].*){3,}?/', $word) && preg_match('/(.)\1/', $word) && !preg_match('/(ab|cd|pq|xy)/', $word)) {
        $p1total ++;
    }
    if(preg_match('/(.).\1/', $word) && preg_match('/(.{2}).*\1/', $word)) {
        $p2total ++;
    }
}

dbg('Total P1 Good Words: '.$p1total,'lightgreen');
dbg('Total P2 Good Words: '.$p2total,'lightpink');
