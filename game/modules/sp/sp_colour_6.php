<?php
  // cveta ijunja:
  $colour[0] = '#EDE275';
  $colour[1] = '#FFF380';
  $colour[2] = '#C9BE62';
  if ($hour > 23 || $hour < 5) $NIGHT = 1;
  elseif ($hour > 4 && $hour < 7) $MORNING = 1;
  elseif ($hour > 6 && $hour < 21) $DAY = 1;
  else $EVENING = 1;
?>