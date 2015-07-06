<?php
  // pokazatqinformaciju kombo
  $kombo = preg_replace ('/[^a-z0-9_]/i', '', $_GET['kombo']);
  if (!$kombo) put_error ('а где комбо?');
  $f = gen_header ('приемы');
  $f .= '<div class="y" id="skli5"><b>приемы:</b></div><p>';
  include 'modules/sp/sp_kombo_info.php'; // nazvanija
  $f .= $ki[$kombo].'<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>