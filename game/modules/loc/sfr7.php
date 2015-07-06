<?php
  // juzhnnyj les 4
  $locmap = 'sfr7';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x1'] = 'sfr7|1x1~у ручья~лес у ручья~'.$temperature.'~23~0~0~sbo1|13x3:4';
  $l['1x2'] = 'sfr7|1x2~молодняк~молодняк~'.$temperature.'~257~0~0~';
  $l['1x3'] = 'sfr7|1x3~молодняк~молодняк~'.$temperature.'~257~0~0~';
  $l['1x4'] = 'sfr7|1x4~молодняк~молодняк~'.$temperature.'~57~0~0~';
  $l['2x2'] = 'sfr7|2x2~у ручья~ручей~'.$temperature.'~2346~0~0~';
  $l['2x3'] = 'sfr7|2x3~молодняк~молодняк~'.$temperature.'~2457~0~0~';
  $l['2x4'] = 'sfr7|2x4~молодняк~молодняк~'.$temperature.'~47~0~0~';
  $l['3x1'] = 'sfr7|3x1~у ручья~ручей~'.$temperature.'~35~0~0~';
  $l['3x3'] = 'sfr7|3x3~у ручья~ручей~'.$temperature.'~246~0~0~';
  $l['3x4'] = 'sfr7|3x4~молодняк~молодняк~'.$temperature.'~57~0~0~';
  $l['4x1'] = 'sfr7|4x1~старый лес~старый лес~'.$temperature.'~45~0~0~';
  $l['4x2'] = 'sfr7|4x2~у ручья~ручей~'.$temperature.'~68~0~0~';
  $l['4x4'] = 'sfr7|4x4~Странный Лес~Странный лес~'.$temperature.'~248~0~0~';
  $l['4x5'] = 'sfr7|4x5~Лес~Лес~'.$temperature.'~7~0~0~sfr4|4x1:2';
  $l['5x1'] = 'sfr7|5x1~старый лес~старый лес~'.$temperature.'~134~0~0~';
  $l['5x3'] = 'sfr7|5x3~старый лес~старый лес~'.$temperature.'~138~0~0~';
  $l['6x1'] = 'sfr7|6x1~старый лес~старый лес~'.$temperature.'~5~0~0~';
  $l['6x2'] = 'sfr7|6x2~старый лес~старый лес~'.$temperature.'~16~0~0~';
  $l['6x3'] = 'sfr7|6x3~старый лес~старый лес~'.$temperature.'~5~0~0~';
  $l['6x4'] = 'sfr7|6x4~старый лес~старый лес~'.$temperature.'~56~0~0~';
  $l['7x1'] = 'sfr7|7x1~старый лес~старый лес~'.$temperature.'~24~0~0~';
  $l['7x2'] = 'sfr7|7x2~старый лес~старый лес~'.$temperature.'~27~0~0~';
  $l['7x3'] = 'sfr7|7x3~старый лес~старый лес~'.$temperature.'~247~0~0~';
  $l['7x4'] = 'sfr7|7x4~старый лес~старый лес~'.$temperature.'~47~0~0~';
?>