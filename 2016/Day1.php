<?php
include('../includes/common.php');

$pathString = file_get_contents('./1.dat', true);
//$pathString = "R8, R4, R4, R8";

$pathData = explode(', ',$pathString);

//dbg($pathData);

/*
 * 1 = N
 * 2 = E
 * 3 = S
 * 4 = W
*/

$dir = 1;
$position = array('X'=>0,'Y'=>0);

$newDir[1] = array('L'=>4,'R'=>2);
$newDir[2] = array('L'=>1,'R'=>3);
$newDir[3] = array('L'=>2,'R'=>4);
$newDir[4] = array('L'=>3,'R'=>1);

$dirMod = array(1=>array(0,1),2=>array(1,0),3=>array(0,-1),4=>array(-1,0));
$visitedLocations = null;
$foundOverlap = false;

foreach($pathData as $instruction)
{
    $turn = substr($instruction,0,1);
    $steps = substr($instruction,1);


    $dir = $newDir[$dir][$turn];
    for($i=0;$i<$steps;$i++)
    {
        $position['X'] += $dirMod[$dir][0];
        $position['Y'] += $dirMod[$dir][1];
        if($visitedLocations['x'.$position['X'].'.y'.$position['Y']] != 1  || $foundOverlap)
        {
            $visitedLocations['x'.$position['X'].'.y'.$position['Y']] = 1;
        }
        else
        {
            $foundOverlap = true;
            $overlapPosition = $position;
        }
    }
}
//dbg($visitedLocations);
//dbg($position);
dbg('Number of blocks: '.(abs($position['X']) + abs($position['Y'])),'lightgreen');
dbg('Number to first intersection: '.(abs($overlapPosition['X']) + abs($overlapPosition['Y'])),'lightpink');
