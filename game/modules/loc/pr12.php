<?php
  $locmap = 'pr12';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x3'] = 'pr12|1x3~берег реки~берег реки~'.$temperature.'~5~0~0~pr11|8x3:4';
  $l['1x5'] = 'pr12|1x5~лесная гуща~лесная гуща~'.$temperature.'~5~0~0~';
  $l['2x3'] = 'pr12|2x3~берег реки~берег реки~'.$temperature.'~34~0~0~';
  $l['2x4'] = 'pr12|2x4~лесная гуща~лесная гуща~'.$temperature.'~2~0~0~';
  $l['2x5'] = 'pr12|2x5~лес~лес~'.$temperature.'~247~0~0~';
  $l['2x6'] = 'pr12|2x6~лес~лес~'.$temperature.'~78~0~0~prf9|4x1:2';
  $l['3x4'] = 'pr12|3x4~берег реки~берег реки~'.$temperature.'~256~0~0~';
  $l['3x5'] = 'pr12|3x5~лес~лес~'.$temperature.'~157~0~0~';
  $l['4x4'] = 'pr12|4x4~берег реки~берег реки~'.$temperature.'~45~0~0~';
  $l['4x5'] = 'pr12|4x5~лес~лес~'.$temperature.'~34~0~0~';
  $l['5x4'] = 'pr12|5x4~берег реки~берег реки~'.$temperature.'~45~0~0~';
  $l['5x6'] = 'pr12|5x6~лес~лес~'.$temperature.'~6~0~0~';
  $l['6x4'] = 'pr12|6x4~Пригородный лес~Пригородный лес~'.$temperature.'~4~0~0~sbo3|1x3:8';
?>