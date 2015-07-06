<?php
  $locmap = 'mano';
  $temperature = 0;
  $l['1x2'] = 'mano|1x2~комната стражи~комната стражи~'.$temperature.'~5~0~1~';
  $l['2x1'] = 'mano|2x1~тронный зал~тронный зал~'.$temperature.'~2~0~1~';
  $l['2x2'] = 'mano|2x2~Дворец~Дворец~'.$temperature.'~457~0~1~rele|2x4:2';
  $l['3x2'] = 'mano|3x2~канцелярия~канцелярия~'.$temperature.'~4~0~1~';
  //------------------------------
  // cvet -
  global $COLOR;
  $COLOR['mano'][3] = '#FAF9DC'; // main
  $COLOR['mano'][4] = '#F8F8F5'; // light
  $COLOR['mano'][5] = '#FAF9AE'; // dark
?>