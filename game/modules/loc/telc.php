<?php
  $locmap = 'telc';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature2 = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature2 = 0;
  if ($w == 6) $temperature2 = 1;
  $temperature = 0;
  $l['1x1'] = 'telc|1x1~плотничная мастерская~плотничная мастерская~'.$temperature.'~3~telir~1~';
  $l['1x2'] = 'telc|1x2~Алхимня~алхимня~'.$temperature.'~5~telir~1~';
  $l['1x3'] = 'telc|1x3~Кузница~кузница~'.$temperature.'~8~telir~1~';
  $l['2x1'] = 'telc|2x1~сторожевая башня~сторожевая башня~'.$temperature.'~3~telir~1~';
  $l['2x2'] = 'telc|2x2~мастерская~мастерская~'.$temperature.'~1456~telir~1~';
  $l['2x3'] = 'telc|2x3~сторожевая башня~сторожевая башня~'.$temperature.'~8~telir~1~';
  $l['2x4'] = 'telc|2x4~хранилище~хранилище~'.$temperature.'~5~telir~1~';
  $l['3x1'] = 'telc|3x1~ворота~ворота замка Телир~'.$temperature2.'~2~telir~0~pr11|4x2:7';
  $l['3x2'] = 'telc|3x2~двор замка Телир~двор~'.$temperature2.'~12345678~telir~0~';
  $l['3x3'] = 'telc|3x3~главное здание~главное здание~'.$temperature.'~27~telir~1~';
  $l['3x4'] = 'telc|3x4~Тронный Зал~Тронный зал~'.$temperature.'~457~telir~1~';
  $l['4x1'] = 'telc|4x1~сторожевая башня~сторожевая башня~'.$temperature.'~1~telir~1~';
  $l['4x2'] = 'telc|4x2~конюшня~конюшня~'.$temperature.'~4~telir~1~';
  $l['4x3'] = 'telc|4x3~сторожевая башня~сторожевая башня~'.$temperature.'~6~telir~1~';
  $l['4x4'] = 'telc|4x4~Княжеские покои~Княжеские покои~'.$temperature.'~4~telir~1~';
?>