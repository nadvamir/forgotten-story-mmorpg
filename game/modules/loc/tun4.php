﻿<?php
  $locmap = 'tun4';
  /*$w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;*/
  global $UND;
  $UND = 1;
  $temperature = -1;
  $l['1x2'] = 'tun4|1x2~тоннель~тоннель~'.$temperature.'~8~0~1~unf2|9x2:4';
  $l['1x4'] = 'tun4|1x4~тоннель~тоннель~'.$temperature.'~5~0~1~unf2|9x4:4';
  $l['1x7'] = 'tun4|1x7~тоннель~тоннель~'.$temperature.'~38~0~1~';
  $l['2x1'] = 'tun4|2x1~тоннель~тоннель~'.$temperature.'~135~0~1~';
  $l['2x4'] = 'tun4|2x4~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['2x6'] = 'tun4|2x6~тоннель~тоннель~'.$temperature.'~135~0~1~';
  $l['2x8'] = 'tun4|2x8~тупик~тоннель~'.$temperature.'~6~0~1~';
  $l['3x1'] = 'tun4|3x1~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['3x2'] = 'tun4|3x2~тоннель~тоннель~'.$temperature.'~56~0~1~';
  $l['3x3'] = 'tun4|3x3~тоннель~тоннель~'.$temperature.'~25~0~1~';
  $l['3x4'] = 'tun4|3x4~тоннель~тоннель~'.$temperature.'~247~0~1~';
  $l['3x5'] = 'tun4|3x5~тоннель~тоннель~'.$temperature.'~257~0~1~';
  $l['3x6'] = 'tun4|3x6~тоннель~тоннель~'.$temperature.'~347~0~1~';
  $l['3x7'] = 'tun4|3x7~тупик~тоннель~'.$temperature.'~6~0~1~';
  $l['3x8'] = 'tun4|3x8~тупик~тоннель~'.$temperature.'~5~0~1~';
  $l['4x1'] = 'tun4|4x1~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['4x2'] = 'tun4|4x2~тоннель~тоннель~'.$temperature.'~245~0~1~';
  $l['4x3'] = 'tun4|4x3~тоннель~тоннель~'.$temperature.'~247~0~1~';
  $l['4x4'] = 'tun4|4x4~тоннель~тоннель~'.$temperature.'~57~0~1~';
  $l['4x5'] = 'tun4|4x5~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['4x7'] = 'tun4|4x7~тоннель~тоннель~'.$temperature.'~36~0~1~';
  $l['4x8'] = 'tun4|4x8~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['5x1'] = 'tun4|5x1~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['5x2'] = 'tun4|5x2~тоннель~тоннель~'.$temperature.'~24~0~1~';
  $l['5x3'] = 'tun4|5x3~тоннель~тоннель~'.$temperature.'~27~0~1~';
  $l['5x4'] = 'tun4|5x4~тоннель~тоннель~'.$temperature.'~457~0~1~';
  $l['5x5'] = 'tun4|5x5~тоннель~тоннель~'.$temperature.'~24~0~1~';
  $l['5x6'] = 'tun4|5x6~тоннель~тоннель~'.$temperature.'~57~0~1~';
  $l['5x8'] = 'tun4|5x8~тоннель~тоннель~'.$temperature.'~46~0~1~';
  $l['6x1'] = 'tun4|6x1~тоннель~тоннель~'.$temperature.'~24~0~1~';
  $l['6x2'] = 'tun4|6x2~тоннель~тоннель~'.$temperature.'~27~0~1~';
  $l['6x3'] = 'tun4|6x3~тоннель~тоннель~'.$temperature.'~27~0~1~';
  $l['6x4'] = 'tun4|6x4~тоннель~тоннель~'.$temperature.'~47~0~1~';
  $l['6x5'] = 'tun4|6x5~тупик~тоннель~'.$temperature.'~2~0~1~';
  $l['6x6'] = 'tun4|6x6~тоннель~тоннель~'.$temperature.'~247~0~1~';
  $l['6x7'] = 'tun4|6x7~тупик~тоннель~'.$temperature.'~7~0~1~';
?>