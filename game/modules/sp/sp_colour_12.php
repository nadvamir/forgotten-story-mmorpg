<?php
  // cveta dekabrja:
  $colour[0] = '#4F94CD';
  $colour[1] = '#6F9FDD';
  $colour[2] = '#4A84AD';
  if ($hour > 20 || $hour < 9) $NIGHT = 1;
  elseif ($hour > 8 && $hour < 10) $MORNING = 1;
  elseif ($hour > 9 && $hour < 17) $DAY = 1;
  else $EVENING = 1;
?>