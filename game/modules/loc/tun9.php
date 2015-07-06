<?php
  $locmap = 'tun9';
  /*$w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;*/
  global $UND;
  $UND = 1;
  $temperature = -1;
  $l['1x1'] = 'tun9|1x1~конец ручья~к свету~'.$temperature.'~3~0~1~';
  $l['2x2'] = 'tun9|2x2~подземный ручей~подземный ручей~'.$temperature.'~36~0~1~';
  $l['2x7'] = 'tun9|2x7~тоннель~тоннель~'.$temperature.'~28~0~1~';
  $l['2x8'] = 'tun9|2x8~тоннель~тоннель~'.$temperature.'~27~0~1~';
  $l['2x9'] = 'tun9|2x9~тоннель~тоннель~'.$temperature.'~7~0~1~tu10|3x1:3';
  $l['3x3'] = 'tun9|3x3~тоннель~тоннель~'.$temperature.'~236~0~1~';
  $l['3x4'] = 'tun9|3x4~тоннель~тоннель~'.$temperature.'~27~0~1~';
  $l['3x5'] = 'tun9|3x5~тоннель~тоннель~'.$temperature.'~27~0~1~';
  $l['3x6'] = 'tun9|3x6~тоннель~тоннель~'.$temperature.'~137~0~1~';
  $l['4x4'] = 'tun9|4x4~тоннель~тоннель~'.$temperature.'~368~0~1~';
  $l['4x7'] = 'tun9|4x7~тоннель~тоннель~'.$temperature.'~36~0~1~';
  $l['5x2'] = 'tun9|5x2~подземный ручей~подземный ручей~'.$temperature.'~2~0~1~';
  $l['5x3'] = 'tun9|5x3~тоннель~тоннель~'.$temperature.'~17~0~1~';
  $l['5x5'] = 'tun9|5x5~тоннель~тоннель~'.$temperature.'~36~0~1~';
  $l['5x8'] = 'tun9|5x8~тоннель~тоннель~'.$temperature.'~26~0~1~';
  $l['5x9'] = 'tun9|5x9~тоннель~тоннель~'.$temperature.'~57~0~1~';
  $l['6x6'] = 'tun9|6x6~тоннель~тоннель~'.$temperature.'~6~0~1~tun8|1x6:5';
  $l['6x9'] = 'tun9|6x9~тоннель~тоннель~'.$temperature.'~4~0~1~tun8|1x9:5';
?>