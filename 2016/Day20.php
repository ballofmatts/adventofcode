<?php
include('../includes/common.php');
ini_set('memory_limit', '-1');

$IPFile = file_get_contents('./20.dat', true);
/*$IPFile = '5-8
0-2
4-7';*/

$IPs = explode("\n", $IPFile);
foreach($IPs as $IP) {
    preg_match('/(\d+)-(\d+)/', $IP, $matches);
    $arrIPs[$matches[1]] = $matches[2];
}
ksort($arrIPs);

$lowIP = 0;
$ip=0;
$total = 0;
while($ip <= 4294967295) {
    $blockFound = false;
    foreach($arrIPs as $start=>$end) {
        if($start <= $ip && $ip <= $end) {
            $ip = $end+1;
            $blockFound = true;
            break;
        }
    }
    if(!$blockFound) {
        if($lowIP == 0) {
            $lowIP = $ip;
        }
        $total++;
        $ip++;
    }
}


dbg('Lowest IP unblocked: '.$lowIP,'lightgreen');
dbg('Total unblocked IPs: '.$total,'lightpink');
