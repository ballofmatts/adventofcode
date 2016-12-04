<?php
include('../includes/common.php');

$instString = file_get_contents('./3.dat', true);

$instructions = explode("\n", $instString);

//dbg($grid);
$problem = 2;   //change to switch between problems

function addRow($grid) {
    global $row, $col;
    $row++;
    if($grid[$row][$col] == null) {
        $row = 0;
        $col++;
    }
}

$totalPossibleP1 = 0;
foreach($instructions as $inst) {
    preg_match('/(\d+) +(\d+) +(\d+)/', $inst, $sides);
    //dbg($sides);
    if((($sides[1]+$sides[2])>$sides[3]) && (($sides[1]+$sides[3])>$sides[2]) && (($sides[2]+$sides[3])>$sides[1])) {
        $totalPossibleP1++;
    }
}

$totalPossibleP2 = 0;
foreach($instructions as $inst) {
    preg_match('/(\d+) +(\d+) +(\d+)/', $inst, $line);
    $grid[] = array($line[1],$line[2],$line[3]);
}
//dbg($grid);
$col=$row=0;
while($grid[$row][$col] != null) {
    $sides[1] = $grid[$row][$col];
    addRow($grid);
    $sides[2] = $grid[$row][$col];
    addRow($grid);
    $sides[3] = $grid[$row][$col];
    addRow($grid);
    //dbg($sides);
    if((($sides[1]+$sides[2])>$sides[3]) && (($sides[1]+$sides[3])>$sides[2]) && (($sides[2]+$sides[3])>$sides[1])) {
        $totalPossibleP2++;
    }
}


dbg('Total possible for part 1: '.$totalPossibleP1,'lightgreen');
dbg('Total possible for part 1: '.$totalPossibleP2,'lightpink');
