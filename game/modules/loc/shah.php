<?php
  $locmap = 'shah';
  /*$w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;*/
  global $UND;
  $UND = 1;
  $temperature = -1;
  $l['1x2'] = 'shah|1x2~шахта~шахта~'.$temperature.'~5~0~1~eway|28x5:4';
  $l['1x3'] = 'shah|1x3~тупик~шахта~'.$temperature.'~5~0~1~';
  $l['1x4'] = 'shah|1x4~тупик~шахта~'.$temperature.'~5~0~1~';
  $l['2x1'] = 'shah|2x1~тупик~шахта~'.$temperature.'~5~0~1~';
  $l['2x2'] = 'shah|2x2~шахта~шахта~'.$temperature.'~45~0~1~';
  $l['2x3'] = 'shah|2x3~шахта~шахта~'.$temperature.'~245~0~1~';
  $l['2x4'] = 'shah|2x4~шахта~шахта~'.$temperature.'~457~0~1~';
  $l['3x1'] = 'shah|3x1~шахта~шахта~'.$temperature.'~45~0~1~';
  $l['3x2'] = 'shah|3x2~шахта~шахта~'.$temperature.'~34~0~1~';
  $l['3x3'] = 'shah|3x3~тупик~шахта~'.$temperature.'~4~0~1~';
  $l['3x4'] = 'shah|3x4~шахта~шахта~'.$temperature.'~45~0~1~';
  $l['4x1'] = 'shah|4x1~шахта~шахта~'.$temperature.'~45~0~1~';
  $l['4x2'] = 'shah|4x2~тупик~шахта~'.$temperature.'~5~0~1~';
  $l['4x3'] = 'shah|4x3~шахта~шахта~'.$temperature.'~256~0~1~';
  $l['4x4'] = 'shah|4x4~шахта~шахта~'.$temperature.'~47~0~1~';
  $l['5x1'] = 'shah|5x1~шахта~шахта~'.$temperature.'~245~0~1~';
  $l['5x2'] = 'shah|5x2~шахта~шахта~'.$temperature.'~457~0~1~';
  $l['5x3'] = 'shah|5x3~шахта~шахта~'.$temperature.'~348~0~1~';
  $l['6x1'] = 'shah|6x1~шахта~шахта~'.$temperature.'~45~0~1~';
  $l['6x2'] = 'shah|6x2~шахта~шахта~'.$temperature.'~145~0~1~';
  $l['6x3'] = 'shah|6x3~тупик~шахта~'.$temperature.'~5~0~1~';
  $l['6x4'] = 'shah|6x4~шахта~шахта~'.$temperature.'~68~0~1~';
  $l['7x1'] = 'shah|7x1~шахта~шахта~'.$temperature.'~24~0~1~';
  $l['7x2'] = 'shah|7x2~шахта~шахта~'.$temperature.'~47~0~1~';
  $l['7x3'] = 'shah|7x3~шахта~шахта~'.$temperature.'~124~0~1~';
  $l['7x4'] = 'shah|7x4~шахта~шахта~'.$temperature.'~7~0~1~verg|4x1:2';
  //$l['7x4'] = 'shah|7x4~шахта~шахта~'.$temperature.'~7~0~1~';
?>