﻿<?php
  $locmap = 'ffo8';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x2'] = 'ffo8|1x2~лес~лес~'.$temperature.'~2~0~0~ffo7|10x2:4';
  $l['1x3'] = 'ffo8|1x3~лес~лес~'.$temperature.'~37~0~0~';
  $l['1x4'] = 'ffo8|1x4~лес~лес~'.$temperature.'~2~0~0~ffo7|10x4:4';
  $l['1x5'] = 'ffo8|1x5~лес~лес~'.$temperature.'~57~0~0~';
  $l['1x7'] = 'ffo8|1x7~лес~лес~'.$temperature.'~3~0~0~ffo7|10x6:6';
  $l['2x4'] = 'ffo8|2x4~лес~лес~'.$temperature.'~56~0~0~';
  $l['2x5'] = 'ffo8|2x5~лес~лес~'.$temperature.'~34~0~0~';
  $l['2x8'] = 'ffo8|2x8~лес~лес~'.$temperature.'~368~0~0~';
  $l['3x4'] = 'ffo8|3x4~лес~лес~'.$temperature.'~45~0~0~';
  $l['3x6'] = 'ffo8|3x6~лес~лес~'.$temperature.'~56~0~0~';
  $l['3x7'] = 'ffo8|3x7~лес~лес~'.$temperature.'~15~0~0~';
  $l['3x9'] = 'ffo8|3x9~лес~лес~'.$temperature.'~56~0~0~';
  $l['4x4'] = 'ffo8|4x4~лес~лес~'.$temperature.'~345~0~0~';
  $l['4x6'] = 'ffo8|4x6~лес~лес~'.$temperature.'~248~0~0~';
  $l['4x7'] = 'ffo8|4x7~лес~лес~'.$temperature.'~47~0~0~';
  $l['4x8'] = 'ffo8|4x8~лес~лес~'.$temperature.'~27~0~0~';
  $l['4x9'] = 'ffo8|4x9~лес~лес~'.$temperature.'~457~0~0~';
  $l['5x4'] = 'ffo8|5x4~лес~лес~'.$temperature.'~248~0~0~';
  $l['5x5'] = 'ffo8|5x5~лес~лес~'.$temperature.'~1367~0~0~';
  $l['5x7'] = 'ffo8|5x7~лес~лес~'.$temperature.'~38~0~0~';
  $l['5x9'] = 'ffo8|5x9~лес~лес~'.$temperature.'~45~0~0~';
  $l['6x3'] = 'ffo8|6x3~лес~лес~'.$temperature.'~13~0~0~';
  $l['6x6'] = 'ffo8|6x6~лес~лес~'.$temperature.'~16~0~0~';
  $l['6x8'] = 'ffo8|6x8~лес~лес~'.$temperature.'~56~0~0~';
  $l['6x9'] = 'ffo8|6x9~лес~лес~'.$temperature.'~48~0~0~';
  $l['7x4'] = 'ffo8|7x4~лес~лес~'.$temperature.'~26~0~0~ffo2|7x4:5';
  $l['7x5'] = 'ffo8|7x5~лес~лес~'.$temperature.'~27~0~0~';
  $l['7x6'] = 'ffo8|7x6~лес~лес~'.$temperature.'~27~0~0~';
  $l['7x7'] = 'ffo8|7x7~лес~лес~'.$temperature.'~27~0~0~';
  $l['7x8'] = 'ffo8|7x8~лес~лес~'.$temperature.'~147~0~0~';
?>