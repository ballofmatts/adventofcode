<?php
include('../includes/common.php');

$instString = file_get_contents('./2.dat', true);

$keycodes = explode("\n", $instString);

/*
$keycodes[] = 'ULL';
$keycodes[] = 'RRDDD';
$keycodes[] = 'LURDL';
$keycodes[] = 'UUUUD';
*/

$problem = 2;   //change this to switch keypads
/*
1 2 3
4 5 6
7 8 9
*/

if($problem == 1)
{
  $keypad = array(
              array(1,2,3),
              array(4,5,6),
              array(7,8,9)
            );

  $currentKeyIndex = array(1,1);
}
/*
      1
   2  3  4
5  6  7  8  9
   A  B  C
      D
*/

if($problem == 2)
{
  $keypad = array(
              array(-1,-1,1,-1,-1),
              array(-1,2,3,4,-1),
              array(5,6,7,8,9),
              array(-1,'A','B','C',-1),
              array(-1,-1,'D',-1,-1)
            );

  $currentKeyIndex = array(2,0);
}

$dirMod = array('U'=>array(-1,0),'R'=>array(0,1),'D'=>array(1,0),'L'=>array(0,-1));

$finalKeys = '';

foreach($keycodes as $keycode) {
  for($i=0;$i<strlen($keycode);$i++) {
    $potentialDirection = array(max(0,min(count($keypad)-1,($currentKeyIndex[0]+$dirMod[$keycode[$i]][0]))),max(0,min(count($keypad[$currentKeyIndex[0]])-1,($currentKeyIndex[1]+$dirMod[$keycode[$i]][1]))));  //max and min keep it within the bounds of the array
    //dbg('trying to move '.$keycode[$i].' to '.$keypad[$potentialDirection[0]][$potentialDirection[1]]);
    if($keypad[$potentialDirection[0]][$potentialDirection[1]] != -1) {
      //dbg('path found. moving '.$keycode[$i].' to '.$keypad[$potentialDirection[0]][$potentialDirection[1]],'green');
      $currentKeyIndex = $potentialDirection;
    }
    else {
      //dbg('nope','red');
    }
  }
  dbg('end of line. adding key: '.$keypad[$currentKeyIndex[0]][$currentKeyIndex[1]],'lightblue');
  $finalKeys .= $keypad[$currentKeyIndex[0]][$currentKeyIndex[1]];
}

dbg('final key combo: '.$finalKeys,'lightgreen');
