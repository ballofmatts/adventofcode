<?php
include('../includes/common.php');

$instString = file_get_contents('./4.dat', true);

$roomIDs = explode("\n", $instString);

//dbg($grid);
$problem = 1;   //change to switch between problems

function parseRoomString($roomID) {
    preg_match('/([a-z|\-]+)(\d+)\[(.*)\]/', $roomID, $info);
    foreach (range('a', 'z') as $letter) {
        $charHist[$letter] = 0;
    }
    $characters = str_replace('-','',$info[1]);
    for($i=0;$i<strlen($characters);$i++) {
        $charHist[$characters[$i]]++;
    }
    array_multisort(array_values($charHist), SORT_DESC, array_keys($charHist), SORT_ASC, $charHist);
    $i = 0;
    foreach($charHist as $letter=>$count) {
        $correctCode .= $letter;
        if(++$i > 4) {
            break;
        }
    }

    if($info[3] == $correctCode) {
        return $info[2];
    }
    else {
        return 0;
    }
}

function cipherRoomString($roomID,$compareString) {
    preg_match('/([a-z|\-]+)(\d+)\[(.*)\]/', $roomID, $info);
    $charMap = range('a', 'z');

    $characters = str_replace('-','',$info[1]);
    $newString = '';
    for($i=0;$i<strlen($characters);$i++) {
        $key = array_search ($characters[$i], $charMap);
        $key += ($info[2]%26);
        if($key > 25) {
            $key -= 26;
        }
        $newString.= $charMap[$key];
    }
    if($newString == $compareString) {
        //dbg($newString.' '.$info[2]);
        return $info[2];
    }
}

$sumIDs = 0;
foreach($roomIDs as $ID) {
    $sumIDs += parseRoomString($ID);
    $cipherID += cipherRoomString($ID,'northpoleobjectstorage');
}


dbg('Sum of IDs: '.$sumIDs,'lightgreen');
dbg('ID of north pole objects: '.$cipherID,'lightpink');
