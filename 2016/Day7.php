<?php
include('../includes/common.php');
$IPFile = file_get_contents('./7.dat', true);

$IPs = explode("\n", $IPFile);

//$IPs = array('abba[mnop]qrst','abcd[bddb]xyyx','aaaa[qwer]tyui','ioxxoj[asdfgh]zxcvbn');

$p1total = 0;
$p2total = 0;
foreach($IPs as $IP) {
    if(preg_match('/(.)((?!\1).)(\2)(\1)/', $IP) && !preg_match('/\[[^\]]*?(.)((?!\1).)(\2)(\1)[^\]]*?\]/', $IP)) {
        $p1total ++;
    }
    if(preg_match('/(?![^\[]*])(.)((?!\1).)(\1).*\[[^\]]*?\2\1\2[^\]]*?\]/', $IP) || preg_match('/\[[^\]]*?(.)((?!\1).)(\1)[^\]]*?\].*(?![^\[]*])\2\1\2/', $IP)) {
        $p2total ++;
    }
}

dbg('Total P1 TLS IPs: '.$p1total,'lightgreen');
dbg('Total P2 SSL IPs: '.$p2total,'lightpink');
