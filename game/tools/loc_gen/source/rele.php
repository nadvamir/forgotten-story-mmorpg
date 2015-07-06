<?php
  // RELEN
  $locmap = 'rele';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature1 = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature1 = 0;
  if ($w == 6) $temperature1 = 1;
  $temperature2 = 0; // dom
  // lokacii
  $l['1x4'] = 'rele|1x4~Храм~в Храм~'.$temperature2.'~5~1~1~';
  $l['1x5'] = 'rele|1x5~дом~в дом~'.$temperature2.'~5~0~1~';
  $l['1x6'] = 'rele|1x6~дом~в дом~'.$temperature2.'~5~0~1~';
  $l['1x7'] = 'rele|1x7~дом~в дом~'.$temperature2.'~5~0~1~';
  $l['1x8'] = 'rele|1x8~западные ворота~к воротам~'.$temperature1.'~5~0~0~cway|21x4:4';
  $l['1x9'] = 'rele|1x9~роща~роща~'.$temperature1.'~25~0~0~';
  $l['1x10'] = 'rele|1x10~роща~роща~'.$temperature1.'~237~0~0~';
  $l['1x11'] = 'rele|1x11~роща~роща~'.$temperature1.'~37~0~0~';
  global $p;
  $q = do_mysql ("SELECT qlvl FROM players WHERE id_player = '".$p['id_player']."';");
  $qlvl = mysql_result ($q, 0);
  if ($qlvl < 2) $nm = '';
  else $nm = 'mano|2x2:7';
  $l['2x4'] = 'rele|2x4~аллея~аллея~'.$temperature1.'~245~0~0~'.$nm;
  $l['2x5'] = 'rele|2x5~аллея~аллея~'.$temperature1.'~247~0~0~';
  $l['2x6'] = 'rele|2x6~аллея~аллея~'.$temperature1.'~247~0~0~';
  $l['2x7'] = 'rele|2x7~аллея~аллея~'.$temperature1.'~247~0~0~';
  $l['2x8'] = 'rele|2x8~гл. улица~гл. улица~'.$temperature1.'~2457~0~0~';
  $l['2x9'] = 'rele|2x9~тропинка~тропинка~'.$temperature1.'~2457~0~0~';
  $l['2x10'] = 'rele|2x10~дом лекаря~дом лекаря~'.$temperature2.'~7~0~1~';
  $l['2x11'] = 'rele|2x11~за домом~за дом~'.$temperature1.'~26~0~0~';
  $l['2x12'] = 'rele|2x12~роща~роща~'.$temperature1.'~678~0~0~';
  $l['3x4'] = 'rele|3x4~улочка~по улочке~'.$temperature1.'~45~0~0~';
  $l['3x5'] = 'rele|3x5~магазин одежды~в магазин одежды~'.$temperature2.'~3~0~1~';
  $l['3x6'] = 'rele|3x6~магазин оружия~в магазин оружия~'.$temperature2.'~5~0~1~';
  $l['3x7'] = 'rele|3x7~магазин брони~в магазин брони~'.$temperature2.'~8~0~1~';
  $l['3x8'] = 'rele|3x8~гл. улица~гл. улица~'.$temperature1.'~45~0~0~';
  $l['3x9'] = 'rele|3x9~роща~роща~'.$temperature1.'~245~0~0~';
  $l['3x10'] = 'rele|3x10~роща~роща~'.$temperature1.'~57~0~0~';
  $l['3x11'] = 'rele|3x11~роща~роща~'.$temperature1.'~15~0~0~';
  $l['4x4'] = 'rele|4x4~улочка~по улочке~'.$temperature1.'~45~0~0~';
  $l['4x5'] = 'rele|4x5~магазин припасов~в магазин припасов~'.$temperature2.'~2~0~1~';
  $l['4x6'] = 'rele|4x6~торговая площадь~на торговую площадь~'.$temperature1.'~124567~0~0~';
  $l['4x7'] = 'rele|4x7~магазин стрелков~в магазин стрелков~'.$temperature2.'~7~0~1~';
  $l['4x8'] = 'rele|4x8~гл. улица~гл. улица~'.$temperature1.'~45~0~0~';
  $l['4x9'] = 'rele|4x9~роща~роща~'.$temperature1.'~24~0~0~';
  $l['4x10'] = 'rele|4x10~роща~роща~'.$temperature1.'~47~0~0~';
  $l['4x11'] = 'rele|4x11~роща~роща~'.$temperature1.'~4~0~0~';
  $l['5x4'] = 'rele|5x4~южная улица~юж. улица~'.$temperature1.'~245~0~0~rbfo|5x6:7';
  $l['5x5'] = 'rele|5x5~южная улица~юж. улица~'.$temperature1.'~27~0~0~';
  $l['5x6'] = 'rele|5x6~перекресток~перекресток~'.$temperature1.'~2457~0~0~';
  $l['5x7'] = 'rele|5x7~южная улица~юж. улица~'.$temperature1.'~27~0~0~';
  $l['5x8'] = 'rele|5x8~главная площадь~главная площадь~'.$temperature1.'~2457~1~0~';
  $l['5x9'] = 'rele|5x9~северная улица~сев. улица~'.$temperature1.'~27~0~0~';
  $l['5x10'] = 'rele|5x10~северная улица~сев. улица~'.$temperature1.'~257~0~0~';
  $l['5x11'] = 'rele|5x11~таверна~таверна~'.$temperature2.'~27~0~1~';
  $l['5x12'] = 'rele|5x12~у камина~к камину~'.$temperature2.'~57~0~1~';
  $l['6x4'] = 'rele|6x4~дом~дом~'.$temperature2.'~4~0~1~';
  $l['6x5'] = 'rele|6x5~ювелир~здание~'.$temperature2.'~2~0~1~';
  $l['6x6'] = 'rele|6x6~кузнечная площадь~на кузнечную площадь~'.$temperature1.'~24578~0~0~';
  $l['6x7'] = 'rele|6x7~алхимня~алхимня~'.$temperature2.'~7~0~1~';
  $l['6x8'] = 'rele|6x8~гл. улица~гл.улица~'.$temperature1.'~45~0~0~';
  $l['6x9'] = 'rele|6x9~дворец лучников~дворец лучников~'.$temperature2.'~2~0~1~';
  $l['6x10'] = 'rele|6x10~парадная площадь~парадная площадь~'.$temperature1.'~23478~0~0~aca1|1x2:5';
  $l['6x11'] = 'rele|6x11~конюшня~конюшня~'.$temperature1.'~7~0~0~';
  $l['6x12'] = 'rele|6x12~погреб~в погреб~'.$temperature1.'~45~0~1~';
  $l['7x5'] = 'rele|7x5~плотник~дом плотника~'.$temperature2.'~1~0~1~';
  $l['7x6'] = 'rele|7x6~кузница~в кузницу~1~4~0~0~';
  $l['7x8'] = 'rele|7x8~гл. улица~гл. улица~'.$temperature1.'~45~0~0~';
  $l['7x9'] = 'rele|7x9~дворец рыцарей~дворец рыцарей~'.$temperature2.'~1~0~1~';
  $l['7x11'] = 'rele|7x11~магические товары~волшебный магазин~'.$temperature2.'~6~0~1~';
  $l['7x12'] = 'rele|7x12~подземелье~подземелье~-1~45~0~1~';
  $l['8x8'] = 'rele|8x8~восточные ворота~к воротам~'.$temperature1.'~24~0~0~eway|1x1:5';
  $l['8x9'] = 'rele|8x9~двор охотника~к охотнику~'.$temperature1.'~27~0~0~';
  $l['8x10'] = 'rele|8x10~дом охотника~в дом~'.$temperature2.'~27~0~1~';
  $l['8x11'] = 'rele|8x11~погреб~в погреб~'.$temperature1.'~27~0~1~';
  $l['8x12'] = 'rele|8x12~подземелье~подземелье~-1~47~0~1~';

  //------------------------------
  // cvet -
  // kuznica-
  global $COLOR;
  $COLOR['rele|7x6'][3] = '#F3A02A'; // main
  $COLOR['rele|7x6'][4] = '#F9C272'; // light
  $COLOR['rele|7x6'][5] = '#DF8B14'; // dark
  // taverna
  $COLOR['rele|5x11'][3] = '#F8D545'; // main
  $COLOR['rele|5x11'][4] = '#F9DE72'; // light
  $COLOR['rele|5x11'][5] = '#E3BF27'; // dark
  $COLOR['rele|5x12'][3] = '#F8D545'; // main
  $COLOR['rele|5x12'][4] = '#F9DE72'; // light
  $COLOR['rele|5x12'][5] = '#E3BF27'; // dark
  // pogreb
  $COLOR['rele|6x12'][3] = '#B5B5B5'; // main
  $COLOR['rele|6x12'][4] = '#CFCFCF'; // light
  $COLOR['rele|6x12'][5] = '#9C9C9C'; // dark
  $COLOR['rele|7x12'][3] = '#B5B5B5'; // main
  $COLOR['rele|7x12'][4] = '#CFCFCF'; // light
  $COLOR['rele|7x12'][5] = '#9C9C9C'; // dark
  $COLOR['rele|8x12'][3] = '#B5B5B5'; // main
  $COLOR['rele|8x12'][4] = '#CFCFCF'; // light
  $COLOR['rele|8x12'][5] = '#9C9C9C'; // dark
  $COLOR['rele|8x11'][3] = '#B5B5B5'; // main
  $COLOR['rele|8x11'][4] = '#CFCFCF'; // light
  $COLOR['rele|8x11'][5] = '#9C9C9C'; // dark

?>