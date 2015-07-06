<?php
  $locmap = 'nvsh';
  /*$w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;*/
  $temperature = -1;
  global $UND;
  $UND = 1;
  $l['1x1'] = 'nvsh|1x1~зал камней~зал камней~'.$temperature.'~2~0~1~';
  $l['1x2'] = 'nvsh|1x2~зал камней~зал камней~'.$temperature.'~257~0~1~';
  $l['1x3'] = 'nvsh|1x3~зал камней~зал камней~'.$temperature.'~27~0~1~';
  $l['1x4'] = 'nvsh|1x4~зал камней~зал камней~'.$temperature.'~257~0~1~verg|7x7:4';
  $l['1x5'] = 'nvsh|1x5~зал камней~зал камней~'.$temperature.'~7~0~1~';
  $l['2x2'] = 'nvsh|2x2~зал камней~зал камней~'.$temperature.'~45~0~1~';
  $l['2x4'] = 'nvsh|2x4~зал камней~зал камней~'.$temperature.'~45~0~1~';
  $l['3x1'] = 'nvsh|3x1~зал камней~зал камней~'.$temperature.'~2~0~1~adsh|3x3:7';
  $l['3x2'] = 'nvsh|3x2~зал камней~зал камней~'.$temperature.'~2457~0~1~';
  $l['3x3'] = 'nvsh|3x3~зал камней~зал камней~'.$temperature.'~27~0~1~';
  $l['3x4'] = 'nvsh|3x4~зал камней~зал камней~'.$temperature.'~2457~0~1~';
  $l['3x5'] = 'nvsh|3x5~зал камней~зал камней~'.$temperature.'~7~0~1~';
  $l['4x2'] = 'nvsh|4x2~зал камней~зал камней~'.$temperature.'~45~0~1~';
  $l['4x4'] = 'nvsh|4x4~зал камней~зал камней~'.$temperature.'~45~0~1~';
  $l['5x1'] = 'nvsh|5x1~зал камней~зал камней~'.$temperature.'~2~0~1~';
  $l['5x2'] = 'nvsh|5x2~зал камней~зал камней~'.$temperature.'~247~0~1~';
  $l['5x3'] = 'nvsh|5x3~зал камней~зал камней~'.$temperature.'~27~0~1~';
  $l['5x4'] = 'nvsh|5x4~зал камней~зал камней~'.$temperature.'~247~0~1~';
  $l['5x5'] = 'nvsh|5x5~зал камней~зал камней~'.$temperature.'~7~0~1~';
?>