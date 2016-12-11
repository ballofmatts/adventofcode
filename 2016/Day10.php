<?php
include('../includes/common.php');

$commandString = file_get_contents('./10.dat', true);
/*$commandString = 'value 5 goes to bot 2
bot 2 gives low to bot 1 and high to bot 0
value 3 goes to bot 1
bot 1 gives low to output 1 and high to bot 0
bot 0 gives low to output 2 and high to output 0
value 2 goes to bot 2';*/
//dbg($commandString);

$commands = explode("\n", $commandString);
$botLogic = null;
$output = null;

function giveTo($botID,$value,$type,&$botLogic,&$output) {
    //dbg('giving '.$value.' to '.$type.' '.$botID);
    if($type == 'output') {
        $output[$botID][] = $value;
        //dbg('output '.$value,'red');
    }
    else {
        $botLogic[$botID]['holding'][] = $value;
        if($botLogic[$botID]['holding'][1] != null) {
            sort($botLogic[$botID]['holding'],SORT_NUMERIC);
            if($botLogic[$botID]['holding'][0] == 17 && $botLogic[$botID]['holding'][1] == 61) {
                dbg('Problem 1 answer is bot ID: '.$botID,'lightgreen');
            }
            //dbg($botLogic[$botID]);;
            $currentNum = array_shift($botLogic[$botID]['holding']);
            //dbg('bot '.$botID.' is giving '.$currentNum.' to '.$botLogic[$botID]['low']['type'].' '.$botLogic[$botID]['low']['id'],'lightpink');
            giveTo($botLogic[$botID]['low']['id'],$currentNum,$botLogic[$botID]['low']['type'],$botLogic,$output);
            $currentNum = array_shift($botLogic[$botID]['holding']);
            //dbg('bot '.$botID.' is giving '.$currentNum.' to '.$botLogic[$botID]['high']['type'].' '.$botLogic[$botID]['high']['id'],'lightpink');
            giveTo($botLogic[$botID]['high']['id'],$currentNum,$botLogic[$botID]['high']['type'],$botLogic,$output);
            $botLogic[$botID]['holding'] = null;
        }
    }
}

foreach($commands as $command) {
    if(preg_match('/value (\d+) goes to bot (\d+)/', $command, $matches)) {
        //giveTo($matches[2],$matches[1],'bot',$botLogic,$output);
        continue;
    }
    elseif(preg_match('/bot (\d+) gives low to (bot|output) (\d+) and high to (bot|output) (\d+)/', $command, $matches)) {
        $botLogic[$matches[1]]['low'] = array('type'=>$matches[2],'id'=>$matches[3]);
        $botLogic[$matches[1]]['high'] = array('type'=>$matches[4],'id'=>$matches[5]);
        //dbg($botLogic[$matches[1]]);
    }
}
foreach($commands as $command) {
    if(preg_match('/value (\d+) goes to bot (\d+)/', $command, $matches)) {
        giveTo($matches[2],$matches[1],'bot',$botLogic,$output);
    }
}

//dbg($botLogic);
dbg('Problem 2 answer: '.$output[0][0]*$output[1][0]*$output[2][0],'lightpink');


