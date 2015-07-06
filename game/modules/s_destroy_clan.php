<?php
  // raspustitq klan
  if ($p['clan'][0] && $p['clan'][1] > 6)
  {
    $f = '';
    if (isset ($_GET['to']))
    {
      // udaljaem vse i vsja
      $to = preg_replace ('/[^a-z_0-9]/i', '', $_GET['to']);
      do_mysql ("UPDATE players SET clan = '' WHERE clan LIKE '".$p['clan'][0]."%';");
      do_mysql ("DELETE FROM clans WHERE clanname = '".$p['clan'][0]."';");
      exit_msg ('роспуск', 'вы только что распустили свой клан!');
    }
    $f .= 'Вы уверены, сто Вы хотите '; 
    $f .= '<span class="red">удалить</span> свой клан?<br/>';
    $f .= '&#187;<a class="red" href="game.php?sid='.$sid.'&action=destroy_clan&to=1">Да</a><br/>';
    exit_msg ('распустить клан:', $f);
  }
?>