<?php
include('../includes/common.php');

$coordData = array(0=>array('x'=>0,'y'=>-1,'r'=>'U'),1=>array('x'=>0,'y'=>1,'r'=>'D'),2=>array('x'=>-1,'y'=>0,'r'=>'L'),3=>array('x'=>1,'y'=>0,'r'=>'R'));
$goodPaths = array('lowest'=>'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa','highest'=>0);
function dfs($x,$y,$r,$key) {
    global $goodPaths,$coordData;
    if($x==3 && $y == 3) {
        $goodPaths['highest'] = max($goodPaths['highest'],strlen($r));
        if(strlen($r) < strlen($goodPaths['lowest'])) {
            $goodPaths['lowest'] = $r;
        }
        return;
    }
    $currentMD5 = md5($key.$r);
    for($i=0;$i<4;$i++) {
        if(in_array($currentMD5[$i],array('b','c','d','e','f')) && $x+$coordData[$i]['x'] >= 0 && $x+$coordData[$i]['x'] < 4 && $y+$coordData[$i]['y'] >= 0 && $y+$coordData[$i]['y'] < 4) {
            dfs($x+$coordData[$i]['x'],$y+$coordData[$i]['y'],$r.$coordData[$i]['r'],$key);
        }
    }
}

dfs(0,0,'','pvhmgsws');
dbg($goodPaths);
