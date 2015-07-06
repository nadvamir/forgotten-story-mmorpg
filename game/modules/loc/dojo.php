<?php
  // mezhdumirie
  $locmap = 'dojo';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x6'] = 'dojo|1x6~горная додзе~комната сенсея~0~8~1~0~';
  $l['2x4'] = 'dojo|2x4~горная додзе~западный зал~0~5~1~0~';
  $l['2x5'] = 'dojo|2x5~горная додзе~додзе~0~18~1~0~';
  $l['3x4'] = 'dojo|3x4~горная додзе~додзе~0~1248~1~0~';
  $l['3x5'] = 'dojo|3x5~горная додзе~северный зал~0~7~1~0~';
  $l['4x2'] = 'dojo|4x2~горная додзе~площадка~'.$temperature.'~25~0~0~';
  $l['4x3'] = 'dojo|4x3~горная додзе~площадка~'.$temperature.'~1578~0~0~';
  $l['5x2'] = 'dojo|5x2~горная додзе~площадка~'.$temperature.'~1248~0~0~';
  $l['5x3'] = 'dojo|5x3~горная додзе~площадка~'.$temperature.'~47~0~0~';
  $l['6x1'] = 'dojo|6x1~горная додзе~тропинка~'.$temperature.'~1~0~0~mva2|1x2:8';
?>