<?php
  // juzhnnyj les 4
  $locmap = 'ffo3';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x1'] = 'ffo3|1x1~лес~лес~'.$temperature.'~5~0~0~ffo4|10x6:4';
  $l['1x3'] = 'ffo3|1x3~лес~лес~'.$temperature.'~38~0~0~';
  $l['1x4'] = 'ffo3|1x4~чаща~чаща~'.$temperature.'~2~0~0~';
  $l['1x5'] = 'ffo3|1x5~лес~лес~'.$temperature.'~57~0~0~';
  $l['1x6'] = 'ffo3|1x6~берег озера~берег озера~'.$temperature.'~25~0~0~ffo4|10x10:6';
  $l['1x7'] = 'ffo3|1x7~берег озера~берег озера~'.$temperature.'~27~0~0~';
  $l['1x8'] = 'ffo3|1x8~берег озера~берег озера~'.$temperature.'~57~0~0~';
  $l['2x1'] = 'ffo3|2x1~лес~лес~'.$temperature.'~24~0~0~';
  $l['2x2'] = 'ffo3|2x2~лес~лес~'.$temperature.'~17~0~0~';
  $l['2x4'] = 'ffo3|2x4~лес~лес~'.$temperature.'~26~0~0~';
  $l['2x5'] = 'ffo3|2x5~лес~лес~'.$temperature.'~2457~0~0~';
  $l['2x6'] = 'ffo3|2x6~лес~лес~'.$temperature.'~347~0~0~';
  $l['2x8'] = 'ffo3|2x8~лес~лес~'.$temperature.'~48~0~0~';
  $l['3x5'] = 'ffo3|3x5~лес~лес~'.$temperature.'~34~0~0~';
  $l['3x6'] = 'ffo3|3x6~чаща~чаща~'.$temperature.'~5~0~0~';
  $l['3x7'] = 'ffo3|3x7~лес~лес~'.$temperature.'~136~0~0~';
  $l['4x6'] = 'ffo3|4x6~лес~лес~'.$temperature.'~46~0~0~';
  $l['4x8'] = 'ffo3|4x8~лес~лес~'.$temperature.'~6~0~0~ffo2|7x1:3';
?>