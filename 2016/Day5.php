<?php
include('../includes/common.php');
ini_set('max_execution_time', 300);

$secret = 'ojvtpuvg';
//$secret = 'abc';

$problem = 2;   //change between 1 and 2 to get different problem behavior

$code = '';
$currentKey = 0;
for($i=0;$i<8;$i++) {
    $keyFound = false;
    while(!$keyFound) {
        $currentMD5 = md5($secret.$currentKey);
        if(substr($currentMD5,0,5) === '00000') {
            if($problem == 1) {
                $keyFound = true;
                dbg($currentKey.' - '.$currentMD5);
                $code .= substr($currentMD5,5,1);
            }
            elseif($problem == 2) {
                $charPos = substr($currentMD5,5,1);
                if(is_numeric($charPos) && intval($charPos) < 8 && $code[$charPos] == '') {
                    $keyFound = true;
                    dbg($currentKey.' - '.$currentMD5);
                    $code[$charPos] = substr($currentMD5,6,1);
                }
            }
        }
        $currentKey++;
    }
}
if($problem == 2) {
    ksort($code);
}
dbg('code: '.implode('',$code),'lightgreen');
