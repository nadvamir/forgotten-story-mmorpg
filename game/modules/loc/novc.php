<?php
  // mezhdumirie
  $locmap = 'novc';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $temperature = 0;
  $l['1x1'] = 'novc|1x1~Заброшенная Крипта~Заброшенная Крипта~'.$temperature.'~5~0~1~';
  $l['2x1'] = 'novc|2x1~коридор~коридор~'.$temperature.'~34~0~1~';
  $l['3x2'] = 'novc|3x2~коридор~коридор~'.$temperature.'~268~0~1~';
  $l['3x3'] = 'novc|3x3~коридор~коридор~'.$temperature.'~257~0~1~';
  $l['3x4'] = 'novc|3x4~коридор~коридор~'.$temperature.'~27~0~1~';
  $l['3x5'] = 'novc|3x5~Усыпальня~Усыпальня~'.$temperature.'~7~0~1~';
  $l['4x1'] = 'novc|4x1~крипта~крипта~'.$temperature.'~1~0~1~';
  $l['4x3'] = 'novc|4x3~крипта~крипта~'.$temperature.'~4~0~1~';
?>