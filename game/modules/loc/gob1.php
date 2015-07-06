<?php
  $locmap = 'gob1';
  /*$w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;*/
  global $UND;
  $UND = 1;
  $temperature = -1;
  $l['1x1'] = 'gob1|1x1~тоннель~тоннель~'.$temperature.'~3~0~1~gobu|7x8:1';
  $l['1x5'] = 'gob1|1x5~пещера~пещера~'.$temperature.'~8~0~1~';
  $l['2x2'] = 'gob1|2x2~тоннель~тоннель~'.$temperature.'~36~0~1~';
  $l['2x4'] = 'gob1|2x4~тоннель~тоннель~'.$temperature.'~13~0~1~';
  $l['3x3'] = 'gob1|3x3~тоннель~тоннель~'.$temperature.'~368~0~1~';
  $l['3x5'] = 'gob1|3x5~тоннель~тоннель~'.$temperature.'~68~0~1~';
  $l['4x2'] = 'gob1|4x2~тоннель~тоннель~'.$temperature.'~18~0~1~';
  $l['4x4'] = 'gob1|4x4~тоннель~тоннель~'.$temperature.'~168~0~1~';
  $l['5x1'] = 'gob1|5x1~тоннель~тоннель~'.$temperature.'~13~0~1~gob2|5x7:7';
  $l['5x3'] = 'gob1|5x3~тоннель~тоннель~'.$temperature.'~13~0~1~';
  $l['5x5'] = 'gob1|5x5~пещера~пещера~'.$temperature.'~8~0~1~';
  $l['6x2'] = 'gob1|6x2~тоннель~тоннель~'.$temperature.'~36~0~1~';
  $l['6x4'] = 'gob1|6x4~тоннель~тоннель~'.$temperature.'~136~0~1~';
  $l['7x3'] = 'gob1|7x3~пещера~пещера~'.$temperature.'~6~0~1~';
  $l['7x5'] = 'gob1|7x5~пещера~пещера~'.$temperature.'~6~0~1~';
?>