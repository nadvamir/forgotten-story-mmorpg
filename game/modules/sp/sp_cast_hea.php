<?php
  // chastq skripta, iscelenie ljuboe:
  // proverim, estq li celq rjadom:
  include_once ('modules/f_is_inloc.php');
  if (!is_inloc ($LOGIN, $to)) put_g_error ('цель недоступна');

  // vylechim:
  include_once ('modules/f_magic_heal.php');
  // dannye iz verhnih failov
  magic_heal ($spell, $LOGIN, $to);

  // nanosim effekty:
  include_once ('modules/f_mag_add_effects.php');
  mag_add_effects ($spell, $to);

  // vse
?>