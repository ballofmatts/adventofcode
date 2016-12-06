<?php
include('../includes/common.php');

$instString = file_get_contents('./6.dat', true);

$instructions = explode("\n", $instString);

foreach($instructions as $line) {
    for($i=0;$i<8;$i++) {
        $grid[$i][$line[$i]]++;
    }
}
for($i=0;$i<8;$i++) {
    arsort($grid[$i]);
    $keys = array_keys($grid[$i]);
    $p1Code .= $keys[0];
    $p2Code .= $keys[count($keys)-1];
}

dbg('Code for part 1: '.$p1Code,'lightgreen');
dbg('Code for part 2: '.$p2Code,'lightpink');
