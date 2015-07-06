<?php
  $locmap = 'epf1';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x4'] = 'epf1|1x4~лесок~по леску~'.$temperature.'~5~0~0~elfc|5x8:6';
  $l['2x3'] = 'epf1|2x3~лесок~по леску~'.$temperature.'~25~0~0~';
  $l['2x4'] = 'epf1|2x4~лесок~по леску~'.$temperature.'~457~0~0~';
  $l['3x2'] = 'epf1|3x2~лесок~по леску~'.$temperature.'~25~0~0~';
  $l['3x3'] = 'epf1|3x3~лесок~по леску~'.$temperature.'~2457~0~0~';
  $l['3x4'] = 'epf1|3x4~лесок~по леску~'.$temperature.'~457~0~0~';
  $l['4x1'] = 'epf1|4x1~лесок~по леску~'.$temperature.'~2~0~0~';
  $l['4x2'] = 'epf1|4x2~лесок~по леску~'.$temperature.'~247~0~0~';
  $l['4x3'] = 'epf1|4x3~лесок~по леску~'.$temperature.'~247~0~0~';
  $l['4x4'] = 'epf1|4x4~лесок~по леску~'.$temperature.'~47~0~0~';
?>