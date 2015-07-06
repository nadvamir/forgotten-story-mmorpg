<?php
  // smena pogody
  // v zavisimosti ot mesjaca varianty
  if ($mon == 1 || $mon == 2)
  {
    $wa[] = 0;
    $wa[] = 1;
  }
  if ($mon == 3)
  {
    if (get_hour() > 20 && get_hour() < 9) $wa[] = 0.5;
    $wa[] = 2;
    $wa[] = 3;
    $wa[] = 4;
    $wa[] = 5;
  }
  if ($mon == 4 || $mon == 5)
  {
    $wa[] = 2;
    $wa[] = 4;
    $wa[] = 5;
  }
  if ($mon == 6)
  {
    if (get_hour() > 10 && get_hour() < 18) $wa[] = 6;
    $wa[] = 2;
    $wa[] = 4;
    $wa[] = 5;
  }
  if ($mon == 7 || $mon == 8)
  {
    if (get_hour() > 8 && get_hour() < 21) $wa[] = 6;
    $wa[] = 2;
    $wa[] = 4;
    $wa[] = 5;
  }
  if ($mon == 9 || $mon == 10)
  {
    $wa[] = 2;
    $wa[] = 4;
    $wa[] = 5;
  }
  if ($mon == 11)
  {
    if (get_hour() > 20 && get_hour() < 9) $wa[] = 0.5;
    $wa[] = 2;
    $wa[] = 3;
    $wa[] = 4;
    $wa[] = 5;
  }
  if ($mon == 12)
  {
    $wa[] = 0;
    $wa[] = 1;
  }
  $num = array_rand ($wa);
  $WEATHER = $wa[$num];
  do_mysql ("UPDATE maps SET weather = '".$WEATHER."';");
  do_mysql ("UPDATE gamesys SET weather_ch = '".$time."' WHERE month = '".$mon."';");

  // KARMA:
  //do_mysql ("UPDATE players SET karma = karma + 1 WHERE karma < 0;");
?>