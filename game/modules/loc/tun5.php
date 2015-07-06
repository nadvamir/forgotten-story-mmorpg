<?php
  $locmap = 'tun5';
  /*$w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;*/
  global $UND;
  $UND = 1;
  $temperature = -1;
  $l['1x4'] = 'tun5|1x4~тоннель~тоннель~'.$temperature.'~38~0~1~tun6|8x3:6';
  $l['2x3'] = 'tun5|2x3~тоннель~тоннель~'.$temperature.'~18~0~1~';
  $l['2x5'] = 'tun5|2x5~тоннель~тоннель~'.$temperature.'~356~0~1~';
  $l['2x7'] = 'tun5|2x7~тупик~тоннель~'.$temperature.'~8~0~1~';
  $l['3x2'] = 'tun5|3x2~тоннель~тоннель~'.$temperature.'~138~0~1~';
  $l['3x5'] = 'tun5|3x5~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['3x6'] = 'tun5|3x6~тоннель~тоннель~'.$temperature.'~16~0~1~';
  $l['4x1'] = 'tun5|4x1~тупик~тоннель~'.$temperature.'~1~0~1~';
  $l['4x3'] = 'tun5|4x3~тоннель~тоннель~'.$temperature.'~356~0~1~';
  $l['4x5'] = 'tun5|4x5~тупик~тоннель~'.$temperature.'~4~0~1~';
  $l['4x6'] = 'tun5|4x6~тупик~тоннель~'.$temperature.'~5~0~1~';
  $l['5x3'] = 'tun5|5x3~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['5x4'] = 'tun5|5x4~тоннель~тоннель~'.$temperature.'~26~0~1~';
  $l['5x5'] = 'tun5|5x5~тоннель~тоннель~'.$temperature.'~257~0~1~';
  $l['5x6'] = 'tun5|5x6~тоннель~тоннель~'.$temperature.'~47~0~1~';
  $l['6x3'] = 'tun5|6x3~тоннель~тоннель~'.$temperature.'~24~0~1~';
  $l['6x4'] = 'tun5|6x4~тупик~тоннель~'.$temperature.'~7~0~1~';
  $l['6x5'] = 'tun5|6x5~тоннель~тоннель~'.$temperature.'~48~0~1~';
  $l['7x4'] = 'tun5|7x4~тупик~тоннель~'.$temperature.'~1~0~1~';
?>