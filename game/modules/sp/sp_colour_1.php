<?php
  // cveta janvarja:
  // div:
  $colour[0] = '#CAE1FF'; // osnovnoj cvet poloski
  $colour[1] = '#C6E2FF'; // svetlaja storona
  $colour[2] = '#BCD2EE'; // temnaja storona
  if ($hour > 19 || $hour < 8) $NIGHT = 1;
  elseif ($hour > 7 && $hour < 10) $MORNING = 1;
  elseif ($hour > 9 && $hour < 17) $DAY = 1;
  else $EVENING = 1;
?>