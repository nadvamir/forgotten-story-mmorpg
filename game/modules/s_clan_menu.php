<?php
  // ispolqzovatq kamenq klana (tolqko zamy da lordy:
  // a bvezklanovye podajut tut zajavki
  $f = '';
  if (!$p['clan'][0])
  {
    // podatq zajavku:
    $f = '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="apply_for_a_clan"/>';
    $f .= 'Подать заявку на вступление в Клан:<br/><input type="text" name="clan_name"/>';
    $f .= '<input type="submit" value="Вступить!"/>';
    $f .= '</form>';
    exit_msg ('Подать заявку', $f);
  }

  $q = do_mysql ("SELECT belongs FROM castle WHERE name = 'telir';");
  $bel = mysql_result ($q, 0);
  $HASTELIR = 0;
  if ($bel == $p['clan'][0]) $HASTELIR = 1;

  if ($p['clan'][1] > 5)
  {
    // funkcii glavy i zama:
   
    if ($p['clan'][1] == 7)
    {
      // ekstra glavy:
      // politika:
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=change_clan_politics">изменить политику</a><br/>';
      // izmenitq sutq klana
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=change_clan_task">изменить суть клана</a><br/>';
      // izmenitq sajt klana
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=change_clan_site">изменить сайт клана</a><br/>';
      // povysitq
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=raise_in_clan">повысить в клане</a><br/>';
      // ponizitq
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=lower_in_clan">понизить в клане</a><br/>';
      // izgnatq iz klana
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=seek_from_clan">изгнать из клана</a><br/>';
      // raspustitq klan
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=destroy_clan">распустить клан</a><br/>';
      // izmenitq zvanija
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=change_c_titles">изменить звания</a><br/>';
      // usilitq dveri
       $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=buy_telir_gate_hp">укрепить ворота Телира</a><br/>';
    }
    // prinjatq zajavku
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=take_to_clan">принять заявку</a><br/>';
    
  }
  // vsemu klanu teleport v zamok -
  if ($HASTELIR)
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=teleport_to_telir">телепортироватся в Телир</a><br/>';

  // vsemu klanu mozhno zhertvovatq na nuzhdy klana
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=clan_donate">пожертвовать на нужды клана</a><br/>';
  exit_msg ('управление кланом', $f);
?>