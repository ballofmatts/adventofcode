<?php
include('../includes/common.php');
ini_set('max_execution_time', 300);

$commandString = file_get_contents('./12.dat', true);
/*$commandString = 'cpy 41 a
inc a
inc a
dec a
jnz a 2
dec a';*/
//dbg($commandString);

$commands = array_filter(explode("\n", $commandString));
$registersP1 = array('a'=>0,'b'=>0,'c'=>0,'d'=>0);
$registersP2 = array('a'=>0,'b'=>0,'c'=>1,'d'=>0);

function assembunny($commands,$registers) {
    for($i=0;$i<count($commands);$i++) {
        preg_match('/(cpy|inc|dec|jnz) (\d+|[a-d]) *(-?\d+|[a-d])*/', $commands[$i], $matches);
        switch($matches[1]) {
            case 'cpy':
                $registers[$matches[3]] = (is_numeric($matches[2])?$matches[2]:$registers[$matches[2]]);
                break;
            case 'inc':
                $registers[$matches[2]]++;
                break;
            case 'dec':
                $registers[$matches[2]]--;
                break;
            case 'jnz':
                if((is_numeric($matches[2])?$matches[2]:$registers[$matches[2]]) != 0) {
                    $i += $matches[3]-1;
                }
                break;
            default:
                break;
        }
    }
    return $registers['a'];
}

dbg('Register \'a\' after problem 1: '.assembunny($commands,$registersP1),'lightgreen');
dbg('Register \'a\' after problem 2: '.assembunny($commands,$registersP2),'lightpink');
