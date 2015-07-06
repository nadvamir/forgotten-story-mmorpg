<?php
  // juzhnnyj les 5
  $locmap = 'sfr5';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x3'] = 'sfr5|1x3~Южный лес~Южный лес~'.$temperature.'~3~0~0~sfr4|9x3:4';
  $l['1x6'] = 'sfr5|1x6~лес~по лесу~'.$temperature.'~58~0~0~';
  $l['2x4'] = 'sfr5|2x4~лес~по лесу~'.$temperature.'~368~0~0~';
  $l['2x5'] = 'sfr5|2x5~Просека~просека~'.$temperature.'~1~0~0~';
  $l['2x6'] = 'sfr5|2x6~лес~по лесу~'.$temperature.'~45~0~0~';
  $l['3x2'] = 'sfr5|3x2~лес~по лесу~'.$temperature.'~25~0~0~';
  $l['3x3'] = 'sfr5|3x3~лес~по лесу~'.$temperature.'~137~0~0~';
  $l['3x5'] = 'sfr5|3x5~лес~по лесу~'.$temperature.'~256~0~0~';
  $l['3x6'] = 'sfr5|3x6~лес~по лесу~'.$temperature.'~47~0~0~';
  $l['4x2'] = 'sfr5|4x2~тропинка~тропинка~'.$temperature.'~34~0~0~';
  $l['4x4'] = 'sfr5|4x4~Руины~Руины~'.$temperature.'~6~0~0~';
  $l['4x5'] = 'sfr5|4x5~лес~по лесу~'.$temperature.'~248~0~0~';
  $l['4x6'] = 'sfr5|4x6~лес~по лесу~'.$temperature.'~57~0~0~';
  $l['5x1'] = 'sfr5|5x1~Южный лес~Южный лес~'.$temperature.'~5~0~0~sfr6|4x9:7';
  $l['5x3'] = 'sfr5|5x3~Развилка~на развилку~'.$temperature.'~268~0~0~';
  $l['5x4'] = 'sfr5|5x4~тропинка~тропинка~'.$temperature.'~137~0~0~';
  $l['5x6'] = 'sfr5|5x6~лес~по лесу~'.$temperature.'~48~0~0~';
  $l['6x1'] = 'sfr5|6x1~лес~по лесу~'.$temperature.'~45~0~0~';
  $l['6x2'] = 'sfr5|6x2~тропинка~тропинка~'.$temperature.'~13~0~0~';
  $l['6x3'] = 'sfr5|6x3~лес~по лесу~'.$temperature.'~25~0~0~';
  $l['6x4'] = 'sfr5|6x4~лес~по лесу~'.$temperature.'~7~0~0~';
  $l['6x5'] = 'sfr5|6x5~лес~по лесу~'.$temperature.'~156~0~0~';
  $l['7x1'] = 'sfr5|7x1~лес~по лесу~'.$temperature.'~34~0~0~';
  $l['7x3'] = 'sfr5|7x3~лес~по лесу~'.$temperature.'~456~0~0~';
  $l['7x4'] = 'sfr5|7x4~лес~по лесу~'.$temperature.'~25~0~0~';
  $l['7x5'] = 'sfr5|7x5~берег озерка~берег озерка~'.$temperature.'~47~0~0~';
  $l['8x2'] = 'sfr5|8x2~лес~по лесу~'.$temperature.'~26~0~0~';
  $l['8x3'] = 'sfr5|8x3~лес~по лесу~'.$temperature.'~247~0~0~';
  $l['8x4'] = 'sfr5|8x4~берег озерка~берег озерка~'.$temperature.'~47~0~0~';
?>