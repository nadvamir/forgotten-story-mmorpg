<?php
  // ushelqe goblinov
  $locmap = 'gobu';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x8'] = 'gobu|1x8~ушелье гоблинов~ушелье гоблинов~'.$temperature.'~8~0~0~eway|21x2:1';
  $l['2x3'] = 'gobu|2x3~у горы~к горе~'.$temperature.'~5~0~0~';
  $l['2x7'] = 'gobu|2x7~ушелье~ушелье~'.$temperature.'~18~0~0~';
  $l['3x3'] = 'gobu|3x3~ушелье~ушелье~'.$temperature.'~34~0~0~';
  $l['3x5'] = 'gobu|3x5~ушелье~ушелье~'.$temperature.'~28~0~0~';
  $l['3x6'] = 'gobu|3x6~ушелье~ушелье~'.$temperature.'~17~0~0~';
  $l['4x4'] = 'gobu|4x4~развилка~развилка~'.$temperature.'~1368~0~0~';
  $l['5x3'] = 'gobu|5x3~ушелье~ушелье~'.$temperature.'~15~0~0~';
  $l['5x5'] = 'gobu|5x5~ушелье~ушелье~'.$temperature.'~26~0~0~';
  $l['5x6'] = 'gobu|5x6~ушелье~ушелье~'.$temperature.'~57~0~0~';
  $l['6x2'] = 'gobu|6x2~ушелье~ушелье~'.$temperature.'~28~0~0~';
  $l['6x3'] = 'gobu|6x3~ушелье~ушелье~'.$temperature.'~47~0~0~';
  $l['6x6'] = 'gobu|6x6~развилка~развилка~'.$temperature.'~248~0~0~';
  $l['6x7'] = 'gobu|6x7~ушелье~ушелье~'.$temperature.'~37~0~0~';
  $l['7x1'] = 'gobu|7x1~у горы~к входу в нору~'.$temperature.'~1~0~0~gob2|1x2:5';
  $l['7x4'] = 'gobu|7x4~у горы~к входу в гору~'.$temperature.'~2~0~0~gob2|1x5:5';
  $l['7x5'] = 'gobu|7x5~у горы~к горе~'.$temperature.'~17~0~0~';
  $l['7x8'] = 'gobu|7x8~у горы~к входу в нору~'.$temperature.'~6~0~0~gob1|1x1:8';
?>
