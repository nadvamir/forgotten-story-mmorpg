<?php
  // cveta aprelja:
  // div:
  $colour[0] = '#75D346';
  $colour[1] = '#BAF89B';
  $colour[2] = '#32CD32';
  if ($hour > 21 || $hour < 6) $NIGHT = 1;
  elseif ($hour > 5 && $hour < 8) $MORNING = 1;
  elseif ($hour > 7 && $hour < 19) $DAY = 1;
  else $EVENING = 1;
?>