<?php
include('../includes/common.php');

$problem = 2;   //change between 1 and 2 to get different problem behavior

$instructions = file_get_contents('./3.dat', true);

$dirMod = array('^'=>array(-1,0),'>'=>array(0,1),'v'=>array(1,0),'<'=>array(0,-1));

$pos = array('X'=>0,'Y'=>0);
$roboPos = array('X'=>0,'Y'=>0);
$luckyHouses = 1;

$visitedMap['0.0'] = 1;

function checkHouse($pos) {
    global $visitedMap, $luckyHouses;
    if($visitedMap[$pos['X'].'.'.$pos['Y']] == null) {
        $luckyHouses++;
        $visitedMap[$pos['X'].'.'.$pos['Y']] = 0;
    }
    $visitedMap[$pos['X'].'.'.$pos['Y']]++;
}

for($i=0;$i<strlen($instructions);$i++) {
    $pos['X'] += $dirMod[$instructions[$i]][1];
    $pos['Y'] += $dirMod[$instructions[$i]][0];
    checkHouse($pos);

    if($problem == 2) {
        $i++;
        $roboPos['X'] += $dirMod[$instructions[$i]][1];
        $roboPos['Y'] += $dirMod[$instructions[$i]][0];
        checkHouse($roboPos);
    }
}

dbg('lucky houses: '.$luckyHouses,'lightblue');
dbg($visitedMap);
