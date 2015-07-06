<?php
  // cveta nojabrja:
  $colour[0] = '#AB7355';
  $colour[1] = '#BB7355';
  $colour[2] = '#8B4513';
  if ($hour > 21 || $hour < 8) $NIGHT = 1;
  elseif ($hour > 7 && $hour < 10) $MORNING = 1;
  elseif ($hour > 9 && $hour < 17) $DAY = 1;
  else $EVENING = 1;
?>