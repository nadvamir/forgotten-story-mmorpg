﻿<?php
  $locmap = 'adsh';
  /*$w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;*/
  $temperature = -1;
  global $UND;
  $UND = 1;
  $l['1x1'] = 'adsh|1x1~зал камней~зал камней~'.$temperature.'~25~0~1~';
  $l['1x2'] = 'adsh|1x2~зал камней~зал камней~'.$temperature.'~27~0~1~';
  $l['1x3'] = 'adsh|1x3~зал камней~зал камней~'.$temperature.'~57~0~1~';
  $l['2x1'] = 'adsh|2x1~зал камней~зал камней~'.$temperature.'~45~0~1~';
  $l['2x3'] = 'adsh|2x3~зал камней~зал камней~'.$temperature.'~45~0~1~';
  $l['3x1'] = 'adsh|3x1~зал камней~зал камней~'.$temperature.'~245~0~1~';
  $l['3x2'] = 'adsh|3x2~зал камней~зал камней~'.$temperature.'~27~0~1~';
  $l['3x3'] = 'adsh|3x3~зал камней~зал камней~'.$temperature.'~457~0~1~nvsh|3x1:2';
  $l['4x1'] = 'adsh|4x1~зал камней~зал камней~'.$temperature.'~45~0~1~';
  $l['4x3'] = 'adsh|4x3~зал камней~зал камней~'.$temperature.'~45~0~1~';
  $l['5x1'] = 'adsh|5x1~зал камней~зал камней~'.$temperature.'~24~0~1~';
  $l['5x2'] = 'adsh|5x2~зал камней~зал камней~'.$temperature.'~27~0~1~';
  $l['5x3'] = 'adsh|5x3~зал камней~зал камней~'.$temperature.'~47~0~1~';
?>