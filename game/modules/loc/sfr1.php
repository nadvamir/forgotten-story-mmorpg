<?php
  // juzhnyj les
  $locmap = 'sfr1';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x1'] = 'sfr1|1x1~Лес~Лес~'.$temperature.'~25~0~0~';
  $l['1x2'] = 'sfr1|1x2~Лес~Лес~'.$temperature.'~37~0~0~';
  $l['2x1'] = 'sfr1|2x1~Лес~Лес~'.$temperature.'~34~0~0~';
  $l['2x3'] = 'sfr1|2x3~Лес~Лес~'.$temperature.'~368~0~0~';
  $l['3x2'] = 'sfr1|3x2~Развилка~На развилку~'.$temperature.'~1568~0~0~';
  $l['3x4'] = 'sfr1|3x4~Лес~Лес~'.$temperature.'~68~0~0~';
  $l['4x1'] = 'sfr1|4x1~Южный лес~Южный лес~'.$temperature.'~13~0~0~sfr3|3x8:8';
  $l['4x2'] = 'sfr1|4x2~У пня~к пню~'.$temperature.'~4~0~0~';
  $l['4x3'] = 'sfr1|4x3~Тропинка~Тропинка~'.$temperature.'~13~0~0~';
  $l['4x5'] = 'sfr1|4x5~Южный лес~Южный лес~'.$temperature.'~5~0~0~eway|4x1:2';
  $l['5x2'] = 'sfr1|5x2~Кустарники~Кустарники~'.$temperature.'~56~0~0~';
  $l['5x4'] = 'sfr1|5x4~Тропинка~Тропинка~'.$temperature.'~36~0~0~';
  $l['5x5'] = 'sfr1|5x5~Лес~Лес~'.$temperature.'~45~0~0~';
  $l['6x2'] = 'sfr1|6x2~Кустарники~Кустарники~'.$temperature.'~34~0~0~';
  $l['6x5'] = 'sfr1|6x5~Тропинка~Тропинка~'.$temperature.'~346~0~0~';
  $l['7x3'] = 'sfr1|7x3~Кустарники~Кустарники~'.$temperature.'~368~0~0~';
  $l['7x6'] = 'sfr1|7x6~Лес~Лес~'.$temperature.'~56~0~0~';
  $l['8x2'] = 'sfr1|8x2~Тропинка~Тропинка~'.$temperature.'~13~0~0~';
  $l['8x4'] = 'sfr1|8x4~Лес~Лес~'.$temperature.'~26~0~0~';
  $l['8x5'] = 'sfr1|8x5~Лес~Лес~'.$temperature.'~27~0~0~';
  $l['8x6'] = 'sfr1|8x6~Южный Лес~Южный Лес~'.$temperature.'~47~0~0~eway|8x2:2';
  $l['9x3'] = 'sfr1|9x3~Тропинка~Тропинка~'.$temperature.'~36~0~0~';
  $l['9x5'] = 'sfr1|9x5~Лес~Лес~'.$temperature.'~38~0~0~';
  $l['9x6'] = 'sfr1|9x6~Лес~Лес~'.$temperature.'~5~0~0~';
  $l['10x4'] = 'sfr1|10x4~Южный лес~Южный лес~'.$temperature.'~16~0~0~sfr2|1x4:5';
  $l['10x6'] = 'sfr1|10x6~Южный лес~Южный лес~'.$temperature.'~46~0~0~eway|9x2:1';
?>