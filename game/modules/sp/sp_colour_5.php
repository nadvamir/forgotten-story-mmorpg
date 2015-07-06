<?php
  // cveta maja:
  $colour[0] = '#228B22';
  $colour[1] = '#44AB44';
  $colour[2] = '#006400';
  if ($hour > 22 || $hour < 6) $NIGHT = 1;
  elseif ($hour > 5 && $hour < 8) $MORNING = 1;
  elseif ($hour > 7 && $hour < 19) $DAY = 1;
  else $EVENING = 1;
?>