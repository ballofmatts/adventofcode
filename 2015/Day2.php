<?php
include('../includes/common.php');

$instString = file_get_contents('./2.dat', true);

$instructions = explode("\n", $instString);

$totalWrapping = 0;
$totalRibbon = 0;
foreach($instructions as $dimensions) {
    $c = explode('x',$dimensions);
    sort($c,SORT_NUMERIC);
    $totalWrapping += (2*$c[0]*$c[1] + 2*$c[1]*$c[2] + 2*$c[0]*$c[2] + $c[0]*$c[1]);
    $totalRibbon += (2*$c[0] + 2*$c[1] + $c[0]*$c[1]*$c[2]);
}

dbg('total paper needed: '.$totalWrapping,'lightgreen');
dbg('total ribbon needed: '.$totalRibbon,'lightpink');
