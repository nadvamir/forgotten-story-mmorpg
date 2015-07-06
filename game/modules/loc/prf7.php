<?php
  $locmap = 'prf7';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x1'] = 'prf7|1x1~берег реки~берег реки~'.$temperature.'~2~0~0~pr10|1x8:7';
  $l['1x2'] = 'prf7|1x2~берег реки~берег реки~'.$temperature.'~27~0~0~';
  $l['1x3'] = 'prf7|1x3~берег реки~берег реки~'.$temperature.'~27~0~0~';
  $l['1x4'] = 'prf7|1x4~берег реки~берег реки~'.$temperature.'~37~0~0~';
  $l['2x5'] = 'prf7|2x5~берег реки~берег реки~'.$temperature.'~268~0~0~';
  $l['2x6'] = 'prf7|2x6~берег реки~берег реки~'.$temperature.'~37~0~0~';
  $l['3x1'] = 'prf7|3x1~лес~лес~'.$temperature.'~35~0~0~';
  $l['3x3'] = 'prf7|3x3~чаща~чаща~'.$temperature.'~8~0~0~';
  $l['3x4'] = 'prf7|3x4~лес~лес~'.$temperature.'~15~0~0~';
  $l['3x7'] = 'prf7|3x7~берег реки~берег реки~'.$temperature.'~6~0~0~prf5|1x1:3';
  $l['4x1'] = 'prf7|4x1~чаща~чаща~'.$temperature.'~4~0~0~';
  $l['4x2'] = 'prf7|4x2~лес~лес~'.$temperature.'~156~0~0~';
  $l['4x4'] = 'prf7|4x4~лес~лес~'.$temperature.'~45~0~0~';
  $l['4x6'] = 'prf7|4x6~чаща~чаща~'.$temperature.'~5~0~0~';
  $l['5x2'] = 'prf7|5x2~лес~лес~'.$temperature.'~34~0~0~';
  $l['5x4'] = 'prf7|5x4~лес~лес~'.$temperature.'~248~0~0~';
  $l['5x5'] = 'prf7|5x5~лес~лес~'.$temperature.'~27~0~0~';
  $l['5x6'] = 'prf7|5x6~лес~лес~'.$temperature.'~457~0~0~';
  $l['6x3'] = 'prf7|6x3~лес~лес~'.$temperature.'~16~0~0~prf8|1x3:5';
  $l['6x6'] = 'prf7|6x6~лес~лес~'.$temperature.'~24~0~0~';
  $l['6x7'] = 'prf7|6x7~чаща~чаща~'.$temperature.'~7~0~0~';
?>