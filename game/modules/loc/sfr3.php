﻿<?php
  // juzhnnyj les 3
  $locmap = 'sfr3';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x2'] = 'sfr3|1x2~лес~по лесу~'.$temperature.'~28~0~0~';
  $l['1x3'] = 'sfr3|1x3~лес~по лесу~'.$temperature.'~37~0~0~';
  $l['1x5'] = 'sfr3|1x5~лес~по лесу~'.$temperature.'~28~0~0~';
  $l['1x6'] = 'sfr3|1x6~лес~по лесу~'.$temperature.'~27~0~0~';
  $l['1x7'] = 'sfr3|1x7~лес~по лесу~'.$temperature.'~78~0~0~';
  $l['2x1'] = 'sfr3|2x1~лес~по лесу~'.$temperature.'~13~0~0~';
  $l['2x2'] = 'sfr3|2x2~лес~по лесу~'.$temperature.'~23~0~0~';
  $l['2x3'] = 'sfr3|2x3~чаща~в чащу~'.$temperature.'~7~0~0~';
  $l['2x4'] = 'sfr3|2x4~лес~по лесу~'.$temperature.'~16~0~0~';
  $l['2x6'] = 'sfr3|2x6~лес~по лесу~'.$temperature.'~13~0~0~';
  $l['3x1'] = 'sfr3|3x1~лес~по лесу~'.$temperature.'~25~0~0~';
  $l['3x2'] = 'sfr3|3x2~лес~по лесу~'.$temperature.'~67~0~0~';
  $l['3x3'] = 'sfr3|3x3~лес~по лесу~'.$temperature.'~26~0~0~';
  $l['3x4'] = 'sfr3|3x4~лес~по лесу~'.$temperature.'~37~0~0~';
  $l['3x7'] = 'sfr3|3x7~лес~по лесу~'.$temperature.'~56~0~0~';
  $l['3x8'] = 'sfr3|3x8~Южный лес~Южный лес~'.$temperature.'~8~0~0~sfr1|4x1:1';
  $l['4x1'] = 'sfr3|4x1~лес~по лесу~'.$temperature.'~34~0~0~';
  $l['4x2'] = 'sfr3|4x2~чаща~чаща~'.$temperature.'~23~0~0~';
  $l['4x3'] = 'sfr3|4x3~лес~по лесу~'.$temperature.'~37~0~0~';
  $l['4x5'] = 'sfr3|4x5~лес~по лесу~'.$temperature.'~56~0~0~';
  $l['4x7'] = 'sfr3|4x7~развилка~на развилку~'.$temperature.'~145~0~0~';
  $l['5x2'] = 'sfr3|5x2~развилка~на развилку~'.$temperature.'~256~0~0~';
  $l['5x3'] = 'sfr3|5x3~лес~по лесу~'.$temperature.'~67~0~0~';
  $l['5x4'] = 'sfr3|5x4~тропинка~тропинка~'.$temperature.'~36~0~0~';
  $l['5x5'] = 'sfr3|5x5~лес~по лесу~'.$temperature.'~24~0~0~';
  $l['5x6'] = 'sfr3|5x6~лес~по лесу~'.$temperature.'~27~0~0~';
  $l['5x7'] = 'sfr3|5x7~лес~по лесу~'.$temperature.'~47~0~0~';
  $l['6x2'] = 'sfr3|6x2~тропинка~тропинка~'.$temperature.'~34~0~0~';
  $l['6x5'] = 'sfr3|6x5~тропинка~тропинка~'.$temperature.'~56~0~0~';
  $l['6x8'] = 'sfr3|6x8~молодняк~молодняк~'.$temperature.'~58~0~0~';
  $l['7x3'] = 'sfr3|7x3~тропинка~тропинка~'.$temperature.'~68~0~0~';
  $l['7x5'] = 'sfr3|7x5~молодняк~молодняк~'.$temperature.'~245~0~0~';
  $l['7x6'] = 'sfr3|7x6~молодняк~молодняк~'.$temperature.'~257~0~0~';
  $l['7x7'] = 'sfr3|7x7~молодняк~молодняк~'.$temperature.'~1257~0~0~';
  $l['7x8'] = 'sfr3|7x8~молодняк~молодняк~'.$temperature.'~457~0~0~';
  $l['8x1'] = 'sfr3|8x1~Южный лес~Южный лес~'.$temperature.'~2~0~0~sfr4|1x2:5';
  $l['8x2'] = 'sfr3|8x2~тропинка~тропинка~'.$temperature.'~17~0~0~';
  $l['8x4'] = 'sfr3|8x4~Южный лес~Южный лес~'.$temperature.'~3~0~0~sfr4|1x4:8';
  $l['8x5'] = 'sfr3|8x5~молодняк~молодняк~'.$temperature.'~24~0~0~';
  $l['8x6'] = 'sfr3|8x6~молодняк~молодняк~'.$temperature.'~247~0~0~';
  $l['8x7'] = 'sfr3|8x7~молодняк~молодняк~'.$temperature.'~47~0~0~';
  $l['8x8'] = 'sfr3|8x8~молодняк~молодняк~'.$temperature.'~48~0~0~';
  $l['9x5'] = 'sfr3|9x5~лес~по лесу~'.$temperature.'~26~0~0~';
  $l['9x6'] = 'sfr3|9x6~лес~по лесу~'.$temperature.'~27~0~0~';
  $l['9x7'] = 'sfr3|9x7~лес~по лесу~'.$temperature.'~17~0~0~';
?>
