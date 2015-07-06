<?php
  // spisok klanov
  $show = 20;
  $f = gen_header ('замки');
  $f .= '<div class="y" id="aeifa5f"><b>замки:</b></div>';

  $f .= '<div class="y" id="aeifa5f"><b>Телир</b></div>';
  $f .= '<div class="n" id="ssad5f">';
  $q = do_mysql ("SELECT belongs FROM castle WHERE name = 'telir';");
  $bel = mysql_result ($q, 0);
  $f .= 'принадлежит <a class="blue" href="game.php?sid='.$sid.'&action=clanlist&clan='.$bel.'">'.$bel.'</a>!';

  $f .= '</div>';
  $f .= '<div class="n" id="adi45f">';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a><br />';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a><br />';
  $f .= '</div>';
  $f .= gen_footer ();
  exit ($f);
?>