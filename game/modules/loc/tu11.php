<?php
  $locmap = 'tu11';
  /*$w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;*/
  global $UND;
  $UND = 1;
  $temperature = -1;
  $l['1x3'] = 'tu11|1x3~тоннель~тоннель~'.$temperature.'~38~0~1~tu10|6x3:4';
  $l['2x2'] = 'tu11|2x2~тоннель~тоннель~'.$temperature.'~18~0~1~';
  $l['2x4'] = 'tu11|2x4~тоннель~тоннель~'.$temperature.'~36~0~1~';
  $l['3x1'] = 'tu11|3x1~тоннель~тоннель~'.$temperature.'~13~0~1~';
  $l['3x5'] = 'tu11|3x5~тупик~тоннель~'.$temperature.'~6~0~1~';
  $l['4x2'] = 'tu11|4x2~тоннель~тоннель~'.$temperature.'~36~0~1~';
  $l['5x3'] = 'tu11|5x3~тоннель~тоннель~'.$temperature.'~256~0~1~';
  $l['5x4'] = 'tu11|5x4~тоннель~тоннель~'.$temperature.'~27~0~1~';
  $l['5x5'] = 'tu11|5x5~тупик~тоннель~'.$temperature.'~7~0~1~';
  $l['6x3'] = 'tu11|6x3~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['7x3'] = 'tu11|7x3~тупик~тоннель~'.$temperature.'~4~0~1~';
?>