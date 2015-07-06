<?php
  // nora rogla
  $locmap = 'rogl';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x1'] = 'rogl|1x1~нора~нора~'.$temperature.'~25~0~0~';
  $l['1x2'] = 'rogl|1x2~нора~нора~'.$temperature.'~27~0~0~';
  $l['1x3'] = 'rogl|1x3~нора~нора~'.$temperature.'~37~0~0~';
  $l['2x1'] = 'rogl|2x1~нора~нора~'.$temperature.'~45~0~0~';
  $l['2x2'] = 'rogl|2x2~тупик~нора~'.$temperature.'~2~0~0~';
  $l['2x3'] = 'rogl|2x3~нора~нора~'.$temperature.'~57~0~0~';
  $l['2x4'] = 'rogl|2x4~нора~нора~'.$temperature.'~56~0~0~';
  $l['3x1'] = 'rogl|3x1~нора~нора~'.$temperature.'~24~0~0~';
  $l['3x2'] = 'rogl|3x2~нора~нора~'.$temperature.'~27~0~0~';
  $l['3x3'] = 'rogl|3x3~нора~нора~'.$temperature.'~47~0~0~';
  $l['3x4'] = 'rogl|3x4~нора~нора~'.$temperature.'~248~0~0~';
  $l['3x5'] = 'rogl|3x5~нора~нора~'.$temperature.'~57~0~0~';
  $l['4x2'] = 'rogl|4x2~нора~нора~'.$temperature.'~28~0~0~';
  $l['4x3'] = 'rogl|4x3~нора~нора~'.$temperature.'~17~0~0~';
  $l['4x5'] = 'rogl|4x5~нора~нора~'.$temperature.'~48~0~0~';
  $l['5x1'] = 'rogl|5x1~нора~нора~'.$temperature.'~13~0~0~';
  $l['5x4'] = 'rogl|5x4~нора~нора~'.$temperature.'~15~0~0~';
  $l['6x2'] = 'rogl|6x2~нора~нора~'.$temperature.'~36~0~0~';
  $l['6x4'] = 'rogl|6x4~тупик~нора~'.$temperature.'~4~0~0~';
  $l['7x1'] = 'rogl|7x1~нора~нора~'.$temperature.'~25~0~0~';
  $l['7x2'] = 'rogl|7x2~тупик~нора~'.$temperature.'~7~0~0~';
  $l['7x3'] = 'rogl|7x3~нора~нора~'.$temperature.'~268~0~0~';
  $l['7x4'] = 'rogl|7x4~нора~нора~'.$temperature.'~27~0~0~';
  $l['7x5'] = 'rogl|7x5~нора~нора~'.$temperature.'~7~0~0~sfr6|2x1:3';
  $l['8x1'] = 'rogl|8x1~нора~нора~'.$temperature.'~45~0~0~';
  $l['8x2'] = 'rogl|8x2~нора~нора~'.$temperature.'~12~0~0~';
  $l['8x3'] = 'rogl|8x3~нора~нора~'.$temperature.'~37~0~0~';
  $l['9x1'] = 'rogl|9x1~нора~нора~'.$temperature.'~24~0~0~';
  $l['9x2'] = 'rogl|9x2~нора~нора~'.$temperature.'~27~0~0~';
  $l['9x3'] = 'rogl|9x3~нора~нора~'.$temperature.'~27~0~0~';
  $l['9x4'] = 'rogl|9x4~нора~нора~'.$temperature.'~67~0~0~';

  //------------------------------
  // cvet -
  global $COLOR;
  $COLOR['rogl'][3] = '#B5B5B5'; // main
  $COLOR['rogl'][4] = '#CFCFCF'; // light
  $COLOR['rogl'][5] = '#9C9C9C'; // dark
?>