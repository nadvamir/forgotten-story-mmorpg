<?php
  $locmap = 'rybo';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x2'] = 'rybo|1x2~остров Рыбы~остров Рыбы~'.$temperature.'~25~0~0~ffo4|3x10:6';
  $l['1x3'] = 'rybo|1x3~сад~сад~'.$temperature.'~57~0~0~';
  $l['2x1'] = 'rybo|2x1~берег озера~берег озера~'.$temperature.'~2~0~0~';
  $l['2x2'] = 'rybo|2x2~у дома рыбака~к дому~'.$temperature.'~2457~0~0~';
  $l['2x3'] = 'rybo|2x3~огород~огород~'.$temperature.'~47~0~0~';
  $l['3x2'] = 'rybo|3x2~дом рыбака~в дом~'.$temperature.'~4~0~0~';
?>