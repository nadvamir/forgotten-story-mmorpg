<?php
  // mezhdumirie
  $locmap = 'novi';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x4'] = 'novi|1x4~дубовая роща~дубовая роща~'.$temperature.'~25~0~0~';
  $l['1x5'] = 'novi|1x5~дубовая роща~дубовая роща~'.$temperature.'~57~0~0~';
  $l['1x6'] = 'novi|1x6~Междумирие~на лужайку~'.$temperature.'~5~0~0~';
  $l['2x1'] = 'novi|2x1~разбитая дорога~по дороге~'.$temperature.'~2~0~0~';
  $l['2x2'] = 'novi|2x2~разбитая дорога~по дороге~'.$temperature.'~37~0~0~';
  $l['2x4'] = 'novi|2x4~дубовая роща~дубовая роща~'.$temperature.'~45~0~0~';
  $l['2x5'] = 'novi|2x5~дубовая роща~дубовая роща~'.$temperature.'~4~0~0~';
  $l['2x6'] = 'novi|2x6~разбитая дорога~по дороге~'.$temperature.'~48~0~0~';
  $l['3x3'] = 'novi|3x3~разбитая дорога~по дороге~'.$temperature.'~26~0~0~';
  $l['3x4'] = 'novi|3x4~разбитая дорога~по дороге~'.$temperature.'~2457~0~0~';
  $l['3x5'] = 'novi|3x5~разбитая дорога~по дороге~'.$temperature.'~17~0~0~';
  $l['4x4'] = 'novi|4x4~тропинка~тропинка~'.$temperature.'~345~0~0~';
  $l['4x6'] = 'novi|4x6~дубовая роща~дубовая роща~'.$temperature.'~8~0~0~';
  $crypt = '';
  global $p;
  if ($p['smq'][5] == '1') $crypt = 'novc|1x1:5';
  $l['5x4'] = 'novi|5x4~тропинка~тропинка~'.$temperature.'~4~0~0~'.$crypt;
  $l['5x5'] = 'novi|5x5~дубовая роща~дубовая роща~'.$temperature.'~16~0~0~';
?>