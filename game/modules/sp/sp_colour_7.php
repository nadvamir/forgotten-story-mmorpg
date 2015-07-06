<?php
  // cveta ijulja:
  $colour[0] = '#ffe13a';
  $colour[1] = '#fdf274';
  $colour[2] = '#ffd33a';
  if ($hour > 22 || $hour < 6) $NIGHT = 1;
  elseif ($hour > 5 && $hour < 8) $MORNING = 1;
  elseif ($hour > 7 && $hour < 20) $DAY = 1;
  else $EVENING = 1;
?>