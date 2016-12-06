<?php
include('../includes/common.php');

$instString = file_get_contents('./6.dat', true);

$instructions = explode("\n", $instString);


$code = '';
foreach($instructions as $line) {
    for($i=0;$i<8;$i++) {
        $grid[$i][$line[$i]]++;
    }
}
$p2Grid = $grid;
foreach($grid as $col) {
    for($i=0;$i<8;$i++) {
        arsort($grid[$i]);
        asort($p2Grid[$i]);
    }
}

for($i=0;$i<8;$i++) {
    $p1Code .= array_keys($grid[$i])[0];
    $p2Code .= array_keys($p2Grid[$i])[0];
}

dbg('Code for part 1: '.$p1Code,'lightgreen');
dbg('Code for part 2: '.$p2Code,'lightpink');
