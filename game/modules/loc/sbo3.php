﻿<?php
  // juzhnnyj les 4
  $locmap = 'sbo3';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x3'] = 'sbo3|1x3~Южное болото~Южное болото~'.$temperature.'~28~0~0~pr12|6x4:1';
  $l['1x4'] = 'sbo3|1x4~болотный лес~болотный лес~'.$temperature.'~37~0~0~';
  $l['2x2'] = 'sbo3|2x2~у реки~берег реки~'.$temperature.'~15~0~0~';
  $l['2x5'] = 'sbo3|2x5~болотный лес~болотный лес~'.$temperature.'~56~0~0~';
  $l['3x1'] = 'sbo3|3x1~у реки~берег реки~'.$temperature.'~235~0~0~';
  $l['3x2'] = 'sbo3|3x2~болото~болото~'.$temperature.'~47~0~0~';
  $l['3x4'] = 'sbo3|3x4~болотный лес~болотный лес~'.$temperature.'~28~0~0~';
  $l['3x5'] = 'sbo3|3x5~болотный лес~болотный лес~'.$temperature.'~457~0~0~';
  $l['4x1'] = 'sbo3|4x1~у реки~берег реки~'.$temperature.'~45~0~0~';
  $l['4x2'] = 'sbo3|4x2~болото~болото~'.$temperature.'~26~0~0~';
  $l['4x3'] = 'sbo3|4x3~болото~болото~'.$temperature.'~157~0~0~';
  $l['4x5'] = 'sbo3|4x5~болото~болото~'.$temperature.'~34~0~0~';
  $l['5x1'] = 'sbo3|5x1~у реки~берег реки~'.$temperature.'~45~0~0~';
  $l['5x3'] = 'sbo3|5x3~болото~болото~'.$temperature.'~34~0~0~';
  $l['5x5'] = 'sbo3|5x5~болото~болото~'.$temperature.'~28~0~0~';
  $l['5x6'] = 'sbo3|5x6~болото~болото~'.$temperature.'~67~0~0~';
  $l['6x1'] = 'sbo3|6x1~у реки~берег реки~'.$temperature.'~34~0~0~';
  $l['6x2'] = 'sbo3|6x2~у самой трясины~болото~'.$temperature.'~3~0~0~';
  $l['6x4'] = 'sbo3|6x4~болото~болото~'.$temperature.'~1368~0~0~';
  $l['7x2'] = 'sbo3|7x2~у реки~берег реки~'.$temperature.'~6~0~0~';
  $l['7x3'] = 'sbo3|7x3~болото~болото~'.$temperature.'~16~0~0~';
  $l['7x5'] = 'sbo3|7x5~болото~болото~'.$temperature.'~256~0~0~';
  $l['7x6'] = 'sbo3|7x6~Южное болото~Южное болото~'.$temperature.'~7~0~0~sbo2|8x1:2';
  $l['8x3'] = 'sbo3|8x3~болото~болото~'.$temperature.'~25~0~0~';
  $l['8x4'] = 'sbo3|8x4~у самой трясины~болото~'.$temperature.'~7~0~0~';
  $l['8x5'] = 'sbo3|8x5~болото~болото~'.$temperature.'~348~0~0~';
  $l['9x1'] = 'sbo3|9x1~у реки~берег реки~'.$temperature.'~2~0~0~';
  $l['9x2'] = 'sbo3|9x2~болото~болото~'.$temperature.'~27~0~0~';
  $l['9x3'] = 'sbo3|9x3~болото~болото~'.$temperature.'~247~0~0~';
  $l['9x4'] = 'sbo3|9x4~болото~болото~'.$temperature.'~17~0~0~';
  $l['9x6'] = 'sbo3|9x6~болото~болото~'.$temperature.'~6~0~0~';
?>