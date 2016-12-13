<?php
include('../includes/common.php');

$start = array(1,1);
$favNum = 1352;
$target = array(31,39);
$p2MaxSteps = 50;

//$favNum = 10;
//$target = array(7,4);

$maxDimensions = array(1,1);

function getH($current,$target) {
    return abs($current[0] - $target[0]) + abs($current[1] - $target[1]);
}

function disabledNode($x,$y) {
    global $favNum;
    $total = array_sum(str_split(decbin($x*$x + 3*$x + 2*$x*$y + $y + $y*$y + $favNum)));
    return ($total%2 == 1);
}

function aStarSearch($start,$target,$isP2) {
    global $maxDimensions,$p2MaxSteps;
    $p1Steps = 0;
    $p2Steps = 0;
    $route = array();
    $point[0] = $start[0];
    $point[1] = $start[1];
    $point['i'] = $point[0].'.'.$point[1];
    $gScore[$point['i']] = 0;
    $fScore[$point['i']] = $gScore[$point['i']] + getH($start,$target);
    $parent[$point['i']] = null;

    $open[$point['i']] = $close[$point['i']] = $point;

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
        if(!$isP2) {
            if ($current[0] == $target[0] && $current[1] == $target[1]) {   //if we found target
                //dbg('found target','red');
                while ($parent[$current['i']] !== null) {                            //go backwards to start
                    $tmp = $close[$parent[$current['i']]];
                    array_unshift($route, array($tmp[0], $tmp[1]));
                    $current = $close[$parent[$current['i']]];
                }
                array_push($route, $target);
                $p1Steps = count($route) - 1;
                return array($p1Steps,$route,$open,$close,$gScore);
            }
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
                if(!array_key_exists($tempNode[0].'.'.$tempNode[1],$open) && (($isP2 && $tentative_gScore <= $p2MaxSteps) || !$isP2)) {
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
    if($isP2) {
        $p2Steps = count($gScore);
        return array($p2Steps,$open,$close,$gScore);
    }
    else {
        return array('No solution',$route,$open,$close,$gScore);
    }
}

list($p1Steps,$route,$open,$close,$gScore) = aStarSearch($start,$target,false);
list($p2Steps,$open2,$close2,$gScore2) = aStarSearch($start,array(-1,-1),true);

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

