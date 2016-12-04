<?php
include('../includes/common.php');
ini_set('memory_limit', '1024M');
$instString = file_get_contents('./6.dat', true);

$instructions = explode("\n", $instString);
$grid = array_fill(0, 1000, array_fill(0, 1000, 0));
$brightGrid = array_fill(0, 1000, array_fill(0, 1000, 0));

foreach($instructions as $inst) {
    preg_match_all('/(\d+,\d+)/', $inst, $matches);
    $tempCoord[0] = explode(',',$matches[0][0]);
    $tempCoord[1] = explode(',',$matches[0][1]);
    $coord['B'] = array(min($tempCoord[0][0],$tempCoord[1][0]),min($tempCoord[0][1],$tempCoord[1][1]));
    $coord['E'] = array(max($tempCoord[0][0],$tempCoord[1][0]),max($tempCoord[0][1],$tempCoord[1][1]));
    if(substr($inst,0,7) == 'turn on') {    //turn on
        $lightState = 1;
        $brightAdd = 1;
    }
    elseif(substr($inst,0,7) == 'turn of') {    //turn off
        $lightState = 0;
        $brightAdd = -1;
    }
    elseif(substr($inst,0,7) == 'toggle ') {    //toggle
        $lightState = 'T';
        $brightAdd = 2;
    }
    for($i=$coord['B'][0];$i<=$coord['E'][0];$i++) {
        for($j=$coord['B'][1];$j<=$coord['E'][1];$j++) {
            if($lightState !== 'T') {
                $grid[$i][$j] = $lightState;
            }
            else {
                $grid[$i][$j] = abs($grid[$i][$j]-1);
            }
            $brightGrid[$i][$j] += $brightAdd;
            if($brightGrid[$i][$j] < 0) {
                $brightGrid[$i][$j] = 0;
            }
        }
    }
}

$totalLights = 0;
$totalBrightness = 0;
foreach($grid as $key=>$row) {
    $totalLights += array_sum($row);
    $totalBrightness += array_sum($brightGrid[$key]);
}

dbg('Total Lights: '.$totalLights,'lightgreen');
dbg('Total Brightness: '.$totalBrightness,'lightpink');
