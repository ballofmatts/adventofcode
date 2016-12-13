<?php
include('../includes/common.php');

$start = array(1,1);
$favNum = 1352;
$target = array(31,39);

//$favNum = 10;
//$target = array(7,4);

$p1Steps = 0;
$p2Steps = 0;

function getH($current,$target) {
    return abs($current[0] - $target[0]) + abs($current[1] - $target[1]);
}

function disabledNode($x,$y) {
    global $favNum;
    $total = array_sum(str_split(decbin($x*$x + 3*$x + 2*$x*$y + $y + $y*$y + $favNum)));
    return ($total%2 == 1);
}

############## PART 1 ##############
$route = array();
$maxDimensions = array(1,1);
$point[0] = $start[0];
$point[1] = $start[1];
$point['i'] = $point[0].'.'.$point[1];
$gScore[$point['i']] = 0;
$fScore[$point['i']] = $gScore[$point['i']] + getH($start,$target);
$parent[$point['i']] = null;

$open[$point['i']] = $close[$point['i']] = $point;

//dbg($open);
//dbg($gScore);
//dbg($fScore);
//dbg($parent);

while (count($open) > 0) {
    $f = INF;
    foreach ($open as $key=>$data) {
        if($fScore[$key] < $f) {
            $currentKey = $key;
            $f = $fScore[$key];
        }
    }
    //dbg('chosen key '.$currentKey,'orange');

    $current = $open[$currentKey];
    unset($open[$currentKey]);
    $close[$currentKey] = $current;

    //dbg('current open:');
    //dbg($open);
    //dbg('current close:');
    //dbg($close);

    if ($current[0] == $target[0] && $current[1] == $target[1]) {   //if we found target
        //dbg('found target','red');
        while ($parent[$current['i']] !== null) {                            //go backwards to start
            $tmp = $close[$parent[$current['i']]];
            array_unshift($route, array($tmp[0], $tmp[1]));
            $current = $close[$parent[$current['i']]];
        }
        array_push($route, $target);
        $p1Steps = count($route) - 1;
        break;
    }

    //lookin at neighbors
    foreach(array(-1,0,1) as $x) {
        foreach(array(-1,0,1) as $y) {
            if(abs($x)==1 && abs($y)==1) {  //no diagonals
                continue;
            }
            $tempNode[0] = $current[0]+$x;
            $tempNode[1] = $current[1]+$y;
            $maxDimensions[0] = max($maxDimensions[0],$tempNode[0]);    //for drawing grid later
            $maxDimensions[1] = max($maxDimensions[1],$tempNode[1]);
            //dbg('checkin neighbor: '.$tempNode[0].'.'.$tempNode[1]);
            if($tempNode[0] < 0 || $tempNode[1] < 0 || array_key_exists($tempNode[0].'.'.$tempNode[1],$close)) {
                //dbg('no, either negative coordinates or already closed');
                continue;
            }
            if(disabledNode($tempNode[0],$tempNode[1])) {  //checking if disabled
                //dbg('no, disabled');
                continue;
            }
            $tempNode['i'] = $tempNode[0].'.'.$tempNode[1];
            $tentative_gScore = $gScore[$current['i']] + 1;
            if(!array_key_exists($tempNode[0].'.'.$tempNode[1],$open)) {
                //dbg('good. adding to open.','lightgreen');
                $open[$tempNode['i']] = $tempNode;
            }
            elseif($tentative_gScore > $gScore[$tempNode['i']]) {
                continue;
            }
            $parent[$tempNode['i']] = $current['i'];
            $gScore[$tempNode['i']] = $tentative_gScore;
            $fScore[$tempNode['i']] = $gScore[$tempNode['i']] + getH($tempNode,$target);

        }
    }
}
############## PART 1 ##############

############## PART 2 ##############
$point[0] = $start[0];
$point[1] = $start[1];
$point['i'] = $point[0].'.'.$point[1];
$gScore2[$point['i']] = 0;
$fScore2[$point['i']] = $gScore[$point['i']] + getH($start,$target);
$parent2[$point['i']] = null;

$open2[$point['i']] = $close2[$point['i']] = $point;

while (count($open2) > 0) {
    $f = INF;
    foreach ($open2 as $key=>$data) {
        if($fScore2[$key] < $f) {
            $currentKey = $key;
            $f = $fScore2[$key];
        }
    }
    //dbg('chosen key '.$currentKey,'orange');

    $current = $open2[$currentKey];
    unset($open2[$currentKey]);
    $close2[$currentKey] = $current;

    //dbg('current open:');
    //dbg($open2);
    //dbg('current close:');
    //dbg($close2);

    //lookin at neighbors
    foreach(array(-1,0,1) as $x) {
        foreach(array(-1,0,1) as $y) {
            if(abs($x)==1 && abs($y)==1) {  //no diagonals
                continue;
            }
            $tempNode[0] = $current[0]+$x;
            $tempNode[1] = $current[1]+$y;
            $maxDimensions[0] = max($maxDimensions[0],$tempNode[0]);    //for drawing grid later
            $maxDimensions[1] = max($maxDimensions[1],$tempNode[1]);
            //dbg('checkin neighbor: '.$tempNode[0].'.'.$tempNode[1]);
            if($tempNode[0] < 0 || $tempNode[1] < 0 || array_key_exists($tempNode[0].'.'.$tempNode[1],$close2)) {
                //dbg('no, either negative coordinates or already closed');
                continue;
            }
            if(disabledNode($tempNode[0],$tempNode[1])) {  //checking if disabled
                //dbg('no, disabled');
                continue;
            }
            $tempNode['i'] = $tempNode[0].'.'.$tempNode[1];
            $tentative_gScore = $gScore2[$current['i']] + 1;
            if(!array_key_exists($tempNode[0].'.'.$tempNode[1],$open2) && $tentative_gScore <= 50) {
                //dbg('good. adding to open.','lightgreen');
                $open2[$tempNode['i']] = $tempNode;
            }
            elseif($tentative_gScore > $gScore2[$tempNode['i']]) {
                continue;
            }
            $parent2[$tempNode['i']] = $current['i'];
            $gScore2[$tempNode['i']] = $tentative_gScore;
            $fScore2[$tempNode['i']] = $gScore2[$tempNode['i']] + getH($tempNode,$target);
        }
    }
}
$p2Steps = count($gScore2);
############## PART 2 ##############



$step = count($route)-1;
dbg('p1 steps: '.$p1Steps,'lightgreen');
dbg('p2 steps: '.$p2Steps,'lightpink');
echo '<style>table{border-collapse:collapse;font-size:9pt;font-family:arial;text-align:center;} table tr{height:15px;} table tr td{border:1px solid black; width:15px;}</style>
<br><table>';
for ($y = 0; $y <= $maxDimensions[1]; $y++) {
    echo '<tr>';
    for ($x = 0; $x <= $maxDimensions[0]; $x++) {
        $current = array($x, $y);
        $currentI = array($x, $y, 'i'=>$x.'.'.$y);

        if (disabledNode($x,$y))
            $bg = 'bgcolor="black"';
        elseif (in_array($current, $route))
            $bg = 'bgcolor="lightgreen"';
        elseif(in_array($currentI,$open))
            $bg = 'bgcolor="lightpink"';
        elseif(in_array($currentI,$close))
            $bg = 'bgcolor="orange"';
        else
            $bg = '';

        if ($current == $start)
            $content = 'S';
        elseif ($current == $target)
            $content = 'F';
        elseif(array_key_exists($x.'.'.$y,$gScore2))
            $content = '<strong>'.$gScore2[$x.'.'.$y].'</strong>';
        elseif(array_key_exists($x.'.'.$y,$gScore))
            $content = $gScore[$x.'.'.$y];
        else
            $content = '&nbsp;';

        echo '<td ' . $bg . '>' . $content . '</td>';
    }
    echo '</tr>';
}
echo '</table>';

