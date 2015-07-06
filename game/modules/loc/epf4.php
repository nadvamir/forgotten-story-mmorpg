<?php
  $locmap = 'epf4';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x1'] = 'epf4|1x1~лесок~по леску~'.$temperature.'~5~0~0~';
  $l['2x1'] = 'epf4|2x1~лесок~по леску~'.$temperature.'~245~0~0~';
  $l['2x2'] = 'epf4|2x2~лесок~по леску~'.$temperature.'~57~0~0~';
  $l['3x1'] = 'epf4|3x1~лесок~по леску~'.$temperature.'~245~0~0~';
  $l['3x2'] = 'epf4|3x2~лесок~по леску~'.$temperature.'~2457~0~0~';
  $l['3x3'] = 'epf4|3x3~лесок~по леску~'.$temperature.'~57~0~0~';
  $l['4x1'] = 'epf4|4x1~лесок~по леску~'.$temperature.'~24~0~0~';
  $l['4x2'] = 'epf4|4x2~лесок~по леску~'.$temperature.'~247~0~0~';
  $l['4x3'] = 'epf4|4x3~лесок~по леску~'.$temperature.'~247~0~0~';
  $l['4x4'] = 'epf4|4x4~лесок~по леску~'.$temperature.'~7~0~0~elfc|9x5:1';
?>