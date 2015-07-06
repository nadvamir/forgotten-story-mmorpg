<?php
  // cveta janvarja:
  $colour[0] = '#FFA500';
  $colour[1] = '#EEC900';
  $colour[2] = '#FF8C00';
  if ($hour > 20 || $hour < 7) $NIGHT = 1;
  elseif ($hour > 6 && $hour < 9) $MORNING = 1;
  elseif ($hour > 8 && $hour < 18) $DAY = 1;
  else $EVENING = 1;
?>