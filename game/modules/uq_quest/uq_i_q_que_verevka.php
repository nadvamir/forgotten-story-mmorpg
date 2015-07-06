<?php
  // verevka
  // esli nahodimsja u dodze, zalezem
  if ($p['location'] == 'mva2|1x2')
  {
    if ($p['smq'][4] < 2) put_g_error ('кто-то сбросил веревку пока она ка дело не привязалась.');
    include_once ('modules/f_teleport.php');
    teleport ($LOGIN, 'dojo|6x1');
  }
?>