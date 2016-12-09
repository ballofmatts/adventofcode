<?php
include('../includes/common.php');

$commandString = file_get_contents('./9.dat', true);
//$commandString = 'ADVENTA(1x5)BC(3x3)XYZA(2x2)BCD(2x2)EFG(6x1)(1x3)AX(8x2)(3x3)ABCY';
//dbg($commandString);

function decompress($string, $isProb2) {
    //dbg($string,'red');
    $returnString = '';
    $returnSum = 0;
    while(true) {
        $pos = strpos($string, '(');
        if($pos===false) {
            $returnSum += strlen($string);
            return $returnSum;
        }
        $returnSum += strlen(substr($string,0,$pos));

        if(preg_match('/\((\d+)x(\d+)\)(.+)/', $string, $matches)) {
            if($isProb2) {
                $returnSum += ($matches[2]*decompress(substr($matches[3],0,$matches[1]),true));
            }
            else {
                $returnSum += ($matches[2]*strlen(substr($matches[3],0,$matches[1])));
            }
        }
        $string = substr($matches[3],$matches[1]);
    }
}

dbg('Decompressed: '.decompress($commandString,false),'lightgreen');
dbg('Decompressed2: '.decompress($commandString,true),'lightpink');

