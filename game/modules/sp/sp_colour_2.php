<?php
  // cveta fevralja:
  // div:
  $colour[0] = '#6495ED';
  $colour[1] = '#80AAEE';
  $colour[2] = '#4682B4';
  if ($hour > 20 || $hour < 7) $NIGHT = 1;
  elseif ($hour > 6 && $hour < 9) $MORNING = 1;
  elseif ($hour > 8 && $hour < 18) $DAY = 1;
  else $EVENING = 1;
?>