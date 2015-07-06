<?php
  $locmap = 'tu10';
  /*$w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;*/
  global $UND;
  $UND = 1;
  $temperature = -1;
  $l['2x1'] = 'tu10|2x1~тоннель~тоннель~'.$temperature.'~25~0~1~';
  $l['2x2'] = 'tu10|2x2~тупик~тоннель~'.$temperature.'~7~0~1~';
  $l['2x4'] = 'tu10|2x4~тупик~тоннель~'.$temperature.'~3~0~1~';
  $l['3x1'] = 'tu10|3x1~тоннель~тоннель~'.$temperature.'~34~0~1~tun9|2x9:6';
  $l['3x5'] = 'tu10|3x5~тоннель~тоннель~'.$temperature.'~68~0~1~tu12|1x1:3';
  $l['4x2'] = 'tu10|4x2~тоннель~тоннель~'.$temperature.'~26~0~1~';
  $l['4x3'] = 'tu10|4x3~тоннель~тоннель~'.$temperature.'~257~0~1~';
  $l['4x4'] = 'tu10|4x4~тоннель~тоннель~'.$temperature.'~17~0~1~';
  $l['5x3'] = 'tu10|5x3~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['6x3'] = 'tu10|6x3~тоннель~тоннель~'.$temperature.'~4~0~1~tu11|1x3:5';
?>