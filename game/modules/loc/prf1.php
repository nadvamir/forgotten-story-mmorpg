﻿<?php
  $locmap = 'prf1';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x2'] = 'prf1|1x2~Пригородный лес~Пригородный лес~'.$temperature.'~35~0~0~prf2|7x2:4';
  $l['1x4'] = 'prf1|1x4~Пригородный лес~Пригородный лес~'.$temperature.'~8~0~0~cway|14x1:4';
  $l['2x1'] = 'prf1|2x1~Лес~Лес~'.$temperature.'~25~0~0~';
  $l['2x2'] = 'prf1|2x2~Лес~Лес~'.$temperature.'~47~0~0~';
  $l['2x3'] = 'prf1|2x3~Лес~Лес~'.$temperature.'~156~0~0~';
  $l['3x1'] = 'prf1|3x1~Лес~Лес~'.$temperature.'~45~0~0~';
  $l['3x2'] = 'prf1|3x2~Поляна~поляна~'.$temperature.'~25~0~0~';
  $l['3x3'] = 'prf1|3x3~Поляна~поляна~'.$temperature.'~2457~0~0~';
  $l['3x4'] = 'prf1|3x4~Поляна~поляна~'.$temperature.'~57~0~0~';
  $l['4x1'] = 'prf1|4x1~Лес~Лес~'.$temperature.'~245~0~0~';
  $l['4x2'] = 'prf1|4x2~Поляна~поляна~'.$temperature.'~2457~0~0~';
  $l['4x3'] = 'prf1|4x3~Поляна~поляна~'.$temperature.'~2457~0~0~';
  $l['4x4'] = 'prf1|4x4~Поляна~поляна~'.$temperature.'~3457~0~0~';
  $l['4x5'] = 'prf1|4x5~Пригородный лес~Пригородный лес~'.$temperature.'~3~0~0~cway|17x3:1';
  $l['5x1'] = 'prf1|5x1~Лес~Лес~'.$temperature.'~34~0~0~';
  $l['5x2'] = 'prf1|5x2~Поляна~поляна~'.$temperature.'~234~0~0~';
  $l['5x3'] = 'prf1|5x3~Поляна~поляна~'.$temperature.'~247~0~0~';
  $l['5x4'] = 'prf1|5x4~Поляна~поляна~'.$temperature.'~47~0~0~';
  $l['5x5'] = 'prf1|5x5~Лес~Лес~'.$temperature.'~26~0~0~';
  $l['5x6'] = 'prf1|5x6~Лес~Лес~'.$temperature.'~567~0~0~';
  $l['6x1'] = 'prf1|6x1~Лес~Лес~'.$temperature.'~23~0~0~';
  $l['6x2'] = 'prf1|6x2~Лес~Лес~'.$temperature.'~67~0~0~';
  $l['6x3'] = 'prf1|6x3~Лес~Лес~'.$temperature.'~368~0~0~';
  $l['6x5'] = 'prf1|6x5~Лес~Лес~'.$temperature.'~58~0~0~';
  $l['6x6'] = 'prf1|6x6~Лес~Лес~'.$temperature.'~48~0~0~';
  $l['7x2'] = 'prf1|7x2~Лес~Лес~'.$temperature.'~16~0~0~';
  $l['7x4'] = 'prf1|7x4~Лес~Лес~'.$temperature.'~16~0~0~';
  $l['7x5'] = 'prf1|7x5~Лес~Лес~'.$temperature.'~14~0~0~';
?>