﻿<?php
  $locmap = 'prf4';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x1'] = 'prf4|1x1~лесная гуща~лесная гуща~'.$temperature.'~235~0~0~';
  $l['1x2'] = 'prf4|1x2~чаща~чаща~'.$temperature.'~7~0~0~';
  $l['1x3'] = 'prf4|1x3~лес~лес~'.$temperature.'~28~0~0~';
  $l['1x4'] = 'prf4|1x4~лес~лес~'.$temperature.'~27~0~0~';
  $l['1x5'] = 'prf4|1x5~лес~лес~'.$temperature.'~57~0~0~';
  $l['1x6'] = 'prf4|1x6~лес~лес~'.$temperature.'~8~0~0~prf5|10x6:4';
  $l['2x1'] = 'prf4|2x1~лес~лес~'.$temperature.'~4~0~0~';
  $l['2x2'] = 'prf4|2x2~лесная гуща~лесная гуща~'.$temperature.'~126~0~0~';
  $l['2x3'] = 'prf4|2x3~лесная гуща~лесная гуща~'.$temperature.'~37~0~0~';
  $l['2x4'] = 'prf4|2x4~чаща~чаща~'.$temperature.'~5~0~0~';
  $l['2x5'] = 'prf4|2x5~холм~на холм~'.$temperature.'~1345~0~0~';
  $l['3x1'] = 'prf4|3x1~звериная тропа~звериная тропа~'.$temperature.'~3~0~0~prf9|3x7:7';
  $l['3x3'] = 'prf4|3x3~звериная тропа~звериная тропа~'.$temperature.'~38~0~0~';
  $l['3x4'] = 'prf4|3x4~лесная гуща~лесная гуща~'.$temperature.'~46~0~0~';
  $l['3x5'] = 'prf4|3x5~лес~лес~'.$temperature.'~45~0~0~';
  $l['3x6'] = 'prf4|3x6~лес~лес~'.$temperature.'~6~0~0~prf2|3x1:2';
  $l['4x1'] = 'prf4|4x1~лесная гуща~лесная гуща~'.$temperature.'~35~0~0~';
  $l['4x2'] = 'prf4|4x2~звериная тропа~звериная тропа~'.$temperature.'~16~0~0~';
  $l['4x3'] = 'prf4|4x3~лесная гуща~лесная гуща~'.$temperature.'~58~0~0~';
  $l['4x4'] = 'prf4|4x4~звериная тропа~звериная тропа~'.$temperature.'~26~0~0~';
  $l['4x5'] = 'prf4|4x5~лес~лес~'.$temperature.'~457~0~0~';
  $l['5x1'] = 'prf4|5x1~лесная гуща~лесная гуща~'.$temperature.'~45~0~0~';
  $l['5x2'] = 'prf4|5x2~лесная гуща~лесная гуща~'.$temperature.'~16~0~0~';
  $l['5x3'] = 'prf4|5x3~лесная гуща~лесная гуща~'.$temperature.'~45~0~0~';
  $l['5x4'] = 'prf4|5x4~чаща~чаща~'.$temperature.'~5~0~0~';
  $l['5x5'] = 'prf4|5x5~лес~лес~'.$temperature.'~34~0~0~';
  $l['6x1'] = 'prf4|6x1~лесная гуща~лесная гуща~'.$temperature.'~34~0~0~';
  $l['6x2'] = 'prf4|6x2~лесная гуща~лесная гуща~'.$temperature.'~23~0~0~';
  $l['6x3'] = 'prf4|6x3~лесная гуща~лесная гуща~'.$temperature.'~47~0~0~';
  $l['6x4'] = 'prf4|6x4~лесная гуща~лесная гуща~'.$temperature.'~2348~0~0~';
  $l['6x5'] = 'prf4|6x5~чаща~чаща~'.$temperature.'~7~0~0~';
  $l['6x6'] = 'prf4|6x6~лес~лес~'.$temperature.'~56~0~0~';
  $l['7x2'] = 'prf4|7x2~лесная гуща~лесная гуща~'.$temperature.'~26~0~0~';
  $l['7x3'] = 'prf4|7x3~лесная гуща~лесная гуща~'.$temperature.'~167~0~0~';
  $l['7x5'] = 'prf4|7x5~лес~лес~'.$temperature.'~26~0~0~prf6|1x5:5';
  $l['7x6'] = 'prf4|7x6~лес~лес~'.$temperature.'~47~0~0~';
?>