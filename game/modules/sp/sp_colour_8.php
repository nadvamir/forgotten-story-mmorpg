<?php
  // cveta avgusta:
  $colour[0] = '#DDDD00';
  $colour[1] = '#FFFF00';
  $colour[2] = '#C9CC00';
  if ($hour > 21 || $hour < 6) $NIGHT = 1;
  elseif ($hour > 5 && $hour < 8) $MORNING = 1;
  elseif ($hour > 7 && $hour < 20) $DAY = 1;
  else $EVENING = 1;
?>