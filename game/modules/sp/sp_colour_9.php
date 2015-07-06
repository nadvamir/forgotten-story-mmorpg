<?php
  // cveta sentjabrja:
  $colour[0] = '#EEC900';
  $colour[1] = '#FFD700';
  $colour[2] = '#CDAD00';
  if ($hour > 21 || $hour < 6) $NIGHT = 1;
  elseif ($hour > 5 && $hour < 8) $MORNING = 1;
  elseif ($hour > 7 && $hour < 19) $DAY = 1;
  else $EVENING = 1;
?>