﻿<?php
  $locmap = 'prf5';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x1'] = 'prf5|1x1~редколесье~редколесье~'.$temperature.'~23~0~0~prf7|3x7:6';
  $l['1x2'] = 'prf5|1x2~камыши~камыши~'.$temperature.'~27~0~0~';
  $l['1x3'] = 'prf5|1x3~камыши~камыши~'.$temperature.'~37~0~0~';
  $l['2x2'] = 'prf5|2x2~редколесье~редколесье~'.$temperature.'~368~0~0~';
  $l['2x4'] = 'prf5|2x4~лесная гуща~лесная гуща~'.$temperature.'~26~0~0~';
  $l['2x5'] = 'prf5|2x5~лесная гуща~лесная гуща~'.$temperature.'~37~0~0~';
  $l['3x1'] = 'prf5|3x1~редколесье~редколесье~'.$temperature.'~13~0~0~';
  $l['3x3'] = 'prf5|3x3~лес~лес~'.$temperature.'~68~0~0~';
  $l['3x4'] = 'prf5|3x4~чаща~чаща~'.$temperature.'~25~0~0~';
  $l['3x5'] = 'prf5|3x5~чаща~чаща~'.$temperature.'~7~0~0~';
  $l['3x6'] = 'prf5|3x6~лесная гуща~лесная гуща~'.$temperature.'~68~0~0~';
  $l['4x2'] = 'prf5|4x2~редколесье~редколесье~'.$temperature.'~1368~0~0~';
  $l['4x4'] = 'prf5|4x4~чаща~чаща~'.$temperature.'~45~0~0~';
  $l['4x5'] = 'prf5|4x5~лесная гуща~лесная гуща~'.$temperature.'~15~0~0~';
  $l['5x1'] = 'prf5|5x1~редколесье~редколесье~'.$temperature.'~13~0~0~prf8|3x7:8';
  $l['5x3'] = 'prf5|5x3~редколесье~редколесье~'.$temperature.'~68~0~0~';
  $l['5x4'] = 'prf5|5x4~чаща~чаща~'.$temperature.'~34~0~0~';
  $l['5x5'] = 'prf5|5x5~лес~лес~'.$temperature.'~45~0~0~';
  $l['6x2'] = 'prf5|6x2~редколесье~редколесье~'.$temperature.'~1368~0~0~';
  $l['6x4'] = 'prf5|6x4~лес~лес~'.$temperature.'~38~0~0~';
  $l['6x5'] = 'prf5|6x5~чаща~чаща~'.$temperature.'~46~0~0~';
  $l['6x6'] = 'prf5|6x6~лесная гуща~лесная гуща~'.$temperature.'~5~0~0~';
  $l['7x1'] = 'prf5|7x1~редколесье~редколесье~'.$temperature.'~13~0~0~';
  $l['7x3'] = 'prf5|7x3~редколесье~редколесье~'.$temperature.'~1368~0~0~';
  $l['7x5'] = 'prf5|7x5~лес~лес~'.$temperature.'~56~0~0~';
  $l['7x6'] = 'prf5|7x6~лесная гуща~лесная гуща~'.$temperature.'~45~0~0~';
  $l['8x2'] = 'prf5|8x2~редколесье~редколесье~'.$temperature.'~1368~0~0~';
  $l['8x4'] = 'prf5|8x4~лес~лес~'.$temperature.'~36~0~0~';
  $l['8x5'] = 'prf5|8x5~лес~лес~'.$temperature.'~24~0~0~';
  $l['8x6'] = 'prf5|8x6~лес~лес~'.$temperature.'~47~0~0~';
  $l['9x1'] = 'prf5|9x1~лес~лес~'.$temperature.'~13~0~0~prf8|5x7:6';
  $l['9x3'] = 'prf5|9x3~лес~лес~'.$temperature.'~68~0~0~';
  $l['9x4'] = 'prf5|9x4~лес~лес~'.$temperature.'~5~0~0~';
  $l['9x5'] = 'prf5|9x5~лес~лес~'.$temperature.'~356~0~0~';
  $l['10x2'] = 'prf5|10x2~лесная гуща~лесная гуща~'.$temperature.'~16~0~0~';
  $l['10x4'] = 'prf5|10x4~лес~лес~'.$temperature.'~24~0~0~';
  $l['10x5'] = 'prf5|10x5~лес~лес~'.$temperature.'~47~0~0~';
  $l['10x6'] = 'prf5|10x6~лес~лес~'.$temperature.'~6~0~0~prf4|1x6:5';
?>