<?php
include('../includes/common.php');

$instructions = file_get_contents('./1.dat', true);

$floor = 0;
$enteredBasement = false;
for($i=0;$i<strlen($instructions);$i++) {
    $floor += ($instructions[$i]=='('?1:-1);
    if($floor < 0 && !$enteredBasement) {
        $enteredBasement = true;
        $basementInstruction = ($i + 1);
    }
}

dbg('ending floor: '.$floor,'lightblue');
dbg('entered basement on instruction: '.$basementInstruction,'lightgreen');
