<?php
  $locmap = 'epf3';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x1'] = 'epf3|1x1~лесок~по леску~'.$temperature.'~25~0~0~';
  $l['1x2'] = 'epf3|1x2~лесок~по леску~'.$temperature.'~257~0~0~';
  $l['1x3'] = 'epf3|1x3~лесок~по леску~'.$temperature.'~257~0~0~';
  $l['1x4'] = 'epf3|1x4~лесок~по леску~'.$temperature.'~7~0~0~';
  $l['2x1'] = 'epf3|2x1~лесок~по леску~'.$temperature.'~245~0~0~';
  $l['2x2'] = 'epf3|2x2~лесок~по леску~'.$temperature.'~2457~0~0~';
  $l['2x3'] = 'epf3|2x3~лесок~по леску~'.$temperature.'~47~0~0~';
  $l['3x1'] = 'epf3|3x1~лесок~по леску~'.$temperature.'~245~0~0~';
  $l['3x2'] = 'epf3|3x2~лесок~по леску~'.$temperature.'~47~0~0~';
  $l['4x1'] = 'epf3|4x1~лесок~по леску~'.$temperature.'~4~0~0~elfc|5x2:3';
?>