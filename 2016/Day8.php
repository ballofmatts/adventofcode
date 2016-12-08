<?php
include('../includes/common.php');
$CommandFile = file_get_contents('./8.dat', true);

$commands = explode("\n", $CommandFile);

//$commands = array('rect 3x2','rotate column x=1 by 1','rotate row y=0 by 4','rotate column x=1 by 1');

//$grid = array_fill(0, 3, array_fill(0, 7, 0));
function dispGrid($grid) {
    echo '<pre>';
    foreach($grid as $row) {
        foreach($row as $col) {
            echo ($col==1?'#':' ').' ';
        }
        echo "\n";
    }
    echo "\n";
    echo '</pre>';
}

$grid = array_fill(0, 6, array_fill(0, 50, 0));

foreach($commands as $command) {
    if(substr($IP,0,4) == 'rect') {
        preg_match('/(\d+)x(\d+)/', $command, $matches);
        for($i=0;$i<$matches[1];$i++) {
            for($j=0;$j<$matches[2];$j++) {
                $grid[$j][$i] = 1;
            }
        }
    }
    else {  //y
        preg_match('/([xy])=(\d+) by (\d+)/', $command, $matches);
        if($matches[1] == 'y') {
            for($i=0;$i<$matches[3];$i++) {
                array_unshift($grid[$matches[2]], array_pop($grid[$matches[2]]));
            }
        }
        else {  //x
            $tempGrid = array_map(function($element){global $matches;return $element[$matches[2]];}, $grid);
            for($i=0;$i<$matches[3];$i++) {
                array_unshift($tempGrid, array_pop($tempGrid));
            }
            foreach($tempGrid as $key=>$val) {
                $grid[$key][$matches[2]] = $val;
            }
        }
    }
}

foreach($grid as $row) {
    $totalPixels += array_sum($row);
}

dbg('Total P1 TLS IPs: '.$totalPixels,'lightgreen');
dispGrid($grid);
