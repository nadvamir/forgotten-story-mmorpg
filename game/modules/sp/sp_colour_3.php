<?php
  // cveta marta:
  // div:
  $colour[0] = '#57E964';
  $colour[1] = '#5EFB6E';
  $colour[2] = '#4CC552';
  if ($hour > 21 || $hour < 6) $NIGHT = 1;
  elseif ($hour > 5 && $hour < 8) $MORNING = 1;
  elseif ($hour > 7 && $hour < 19) $DAY = 1;
  else $EVENING = 1;
?>