<?php
  // fail perehoda na druguju loku
  // funkcija
  require_once 'modules/f_go_to_loc.php';
  // vse dannye vnutri funkcii proverjajutsja
  // esli imeetsja zverq, i ona rjadom v lokacii, on pojdet sledom
  // imja igroka s p. nado vpsatq
  go_to_loc ('p.'.$LOGIN, $_GET['loc_go'], $_GET['stor']);
  $p = get_pl_info ($LOGIN, 'all');
  // esli vse horosho to na druguju loku perekinem i glavnuju stranicu pokazhem
  $NO_CONTINUE = 1;
  $action = '';
  $NOACT = 1;
?>