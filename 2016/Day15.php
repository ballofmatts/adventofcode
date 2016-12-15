<?php
include('../includes/common.php');

$commandString = file_get_contents('./15.dat', true);
/*$commandString = 'Disc #1 has 5 positions; at time=0, it is at position 4.
Disc #2 has 2 positions; at time=0, it is at position 1.';*/

function getTreat($commandString) {
    $commands = array_filter(explode("\n", $commandString));
    foreach($commands as $command) {
        preg_match('/Disc #\d has (\d+) positions; at time=0, it is at position (\d)./', $command, $matches);
        $discs[$matches[1]] = $matches[2];
    }

    $t = 0;
    $solutionFound = false;
    while(!$solutionFound) {
        $i = $t+1;
        $solutionFound = true;
        foreach($discs as $sides=>$pos) {
            if(($pos + $i++) % $sides != 0) {
                $solutionFound = false;
            }
        }
        $t++;
    }
    $t--;
    return $t;
}

dbg('Treat #1 after '.getTreat($commandString).' seconds','lightgreen');
$commandString .= "\n".'Disc #7 has 11 positions; at time=0, it is at position 0.';
dbg('Treat #2 after '.getTreat($commandString).' seconds','lightpink');
