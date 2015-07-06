<?php
  $locmap = 'epf2';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x1'] = 'epf2|1x1~лесок~по леску~'.$temperature.'~2~0~0~elfc|2x5:8';
  $l['1x2'] = 'epf2|1x2~лесок~по леску~'.$temperature.'~257~0~0~';
  $l['1x3'] = 'epf2|1x3~лесок~по леску~'.$temperature.'~257~0~0~';
  $l['1x4'] = 'epf2|1x4~лесок~по леску~'.$temperature.'~57~0~0~';
  $l['2x2'] = 'epf2|2x2~лесок~по леску~'.$temperature.'~24~0~0~';
  $l['2x3'] = 'epf2|2x3~лесок~по леску~'.$temperature.'~2457~0~0~';
  $l['2x4'] = 'epf2|2x4~лесок~по леску~'.$temperature.'~457~0~0~';
  $l['3x3'] = 'epf2|3x3~лесок~по леску~'.$temperature.'~24~0~0~';
  $l['3x4'] = 'epf2|3x4~лесок~по леску~'.$temperature.'~457~0~0~';
  $l['4x4'] = 'epf2|4x4~лесок~по леску~'.$temperature.'~4~0~0~';
?>