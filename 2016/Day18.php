<?php
include('../includes/common.php');

$input = '.^^^.^.^^^.^.......^^.^^^^.^^^^..^^^^^.^.^^^..^^.^.^^..^.^..^^...^.^^.^^^...^^.^.^^^..^^^^.....^....';

function mapGrid($input,$numLines) {
    $grid[0] = $input;
    for($i=1;$i<$numLines;$i++) {
        foreach(str_split($grid[$i-1]) as $index=>$letter) {
            if($index == 0) {
                $test = '.'.$letter.$grid[$i-1][$index+1];
            }
            elseif($index == strlen($grid[$i-1])-1) {
                $test = $grid[$i-1][$index-1].$letter.'.';
            }
            else {
                $test = $grid[$i-1][$index-1].$letter.$grid[$i-1][$index+1];
            }
            if($test == '^^.' || $test == '.^^' || $test == '^..' || $test == '..^') {
                $grid[$i] .= '^';
            }
            else {
                $grid[$i] .= '.';
            }
        }
    }
    return $grid;
}

function safeTiles($grid) {
    $total = 0;
    foreach($grid as $line) {
        $total += substr_count($line, '.');
    }
    return $total;
}

//dbg(mapGrid('..^^.',3));
//dbg(mapGrid('.^^.^.^^^^',10));
//dbg(mapGrid($input,40));
dbg(safeTiles(mapGrid($input,40)));
dbg(safeTiles(mapGrid($input,400000)));
