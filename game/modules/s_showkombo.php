<?php
  // pokaz kombo:
  $f = gen_header ('приемы');
  $f .= '<div class="y" id="skli5"><b>приемы:</b></div><p>';
  include 'modules/sp/sp_kombonames.php'; // nazvanija
  $c = count ($p['kombo']);
  for ($i = 0; $i < $c; $i++)
  {
    if (!$p['kombo'][$i]) continue;
    $p['kombo'][$i] = explode (':', $p['kombo'][$i]);
    $f .= ($i + 1).': <a class="blue" href="game.php?sid='.$sid.'&action=showkombo_i&kombo='.$p['kombo'][$i][0].'">'.$kn[$p['kombo'][$i][0]].'</a>';
    $f .= ': <b>'.$p['kombo'][$i][1].'</b> ('.$p['kombo'][$i][2].'/';
    $tok = 20;
    for ($a = 1; $a < $p['kombo'][$i][1]; $a++) $tok *= 2;
    $f .= $tok.')';
    $f .= ' <a class="blue" href="game.php?sid='.$sid.'&action=use_kombo&kombo='.$p['kombo'][$i][0].'">&#187;</a><br/>';
  }
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>