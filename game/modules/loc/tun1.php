<?php
  $locmap = 'tun1';
  /*$w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;*/
  global $UND;
  $UND = 1;
  $temperature = -1;
  $l['1x5'] = 'tun1|1x5~тоннель~тоннель~'.$temperature.'~38~0~1~';
  $l['1x9'] = 'tun1|1x9~тоннель~тоннель~'.$temperature.'~58~0~1~';
  $l['2x1'] = 'tun1|2x1~тоннель~тоннель~'.$temperature.'~35~0~1~unf1|9x3:6';
  $l['2x4'] = 'tun1|2x4~тоннель~тоннель~'.$temperature.'~18~0~1~';
  $l['2x6'] = 'tun1|2x6~тоннель~тоннель~'.$temperature.'~36~0~1~';
  $l['2x8'] = 'tun1|2x8~тоннель~тоннель~'.$temperature.'~18~0~1~';
  $l['2x9'] = 'tun1|2x9~тупик~тоннель~'.$temperature.'~4~0~1~';
  $l['3x1'] = 'tun1|3x1~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['3x2'] = 'tun1|3x2~тоннель~тоннель~'.$temperature.'~36~0~1~';
  $l['3x3'] = 'tun1|3x3~тоннель~тоннель~'.$temperature.'~15~0~1~';
  $l['3x6'] = 'tun1|3x6~тоннель~тоннель~'.$temperature.'~38~0~1~';
  $l['3x7'] = 'tun1|3x7~тоннель~тоннель~'.$temperature.'~156~0~1~';
  $l['4x1'] = 'tun1|4x1~тоннель~тоннель~'.$temperature.'~34~0~1~';
  $l['4x3'] = 'tun1|4x3~тоннель~тоннель~'.$temperature.'~346~0~1~';
  $l['4x5'] = 'tun1|4x5~тоннель~тоннель~'.$temperature.'~18~0~1~';
  $l['4x7'] = 'tun1|4x7~тоннель~тоннель~'.$temperature.'~346~0~1~';
  $l['5x2'] = 'tun1|5x2~тоннель~тоннель~'.$temperature.'~56~0~1~';
  $l['5x3'] = 'tun1|5x3~тоннель~тоннель~'.$temperature.'~58~0~1~';
  $l['5x4'] = 'tun1|5x4~тоннель~тоннель~'.$temperature.'~156~0~1~';
  $l['5x6'] = 'tun1|5x6~тупик~тоннель~'.$temperature.'~3~0~1~';
  $l['5x8'] = 'tun1|5x8~тоннель~тоннель~'.$temperature.'~68~0~1~';
  $l['6x2'] = 'tun1|6x2~тоннель~тоннель~'.$temperature.'~145~0~1~';
  $l['6x3'] = 'tun1|6x3~тоннель~тоннель~'.$temperature.'~24~0~1~';
  $l['6x4'] = 'tun1|6x4~тоннель~тоннель~'.$temperature.'~247~0~1~';
  $l['6x5'] = 'tun1|6x5~тупик~тоннель~'.$temperature.'~7~0~1~';
  $l['6x7'] = 'tun1|6x7~тоннель~тоннель~'.$temperature.'~16~0~1~';
  $l['7x2'] = 'tun1|7x2~тупик~тоннель~'.$temperature.'~4~0~1~';
?>