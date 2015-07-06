<?php
  // prinjatq v klan
  if ($p['clan'][0] && $p['clan'][1] > 5)
  {
    $f = '';
    if (isset ($_GET['to']))
    {
      $to = mysql_real_escape_string ($_GET['to']);
      $id = is_player ($to);
      if (!$id) put_error ('ne igrok');
      $q = do_mysql ("SELECT clan FROM players WHERE id_player = '".$id."';");
      $clan = mysql_result ($q, 0);
      if ($clan) $_GET['take'] = 0;
      // prinjatie libo vybrasyvanie:
      if ($_GET['take'])
      {
        // prinjatq
        do_mysql ("UPDATE players SET clan = '".$p['clan'][0]."|1' WHERE id_player = '".$id."';");
      }
      else
      {
        // vybrositq
        add_journal ('GAMESYS: ВАША ЗАЯВКА НА ВСТУПЛЕНИЕ В КЛАН ОТКЛОНЕНА', $to);
      }
      $q = do_mysql ("SELECT newcomers FROM clans WHERE clanname = '".$p['clan'][0]."';");
      $ncm = mysql_result ($q, 0);
      $ncm = string_drop ($ncm, $to);
      do_mysql ("UPDATE clans SET newcomers = '".$ncm."' WHERE clanname = '".$p['clan'][0]."';");
    }

    // prinjatie v klan
    $q = do_mysql ("SELECT newcomers FROM clans WHERE clanname = '".$p['clan'][0]."';");
    $ncm = mysql_result ($q, 0);
    $ncms = $ncm;
    $ncm = explode ('|', $ncm);
    $c = count ($ncm);
    for ($i = 0; $i < $c; $i++)
    {
      if (!$ncm[$i]) continue;
      $id = is_player ($ncm[$i]);
      $q = do_mysql ("SELECT clan FROM players WHERE id_player = '".$id."';");
      $clan = mysql_result ($q, 0);
      if ($clan)
      {
        // opozdali, igrok uzhe prinjat
        string_drop ($ncms, $ncm[$i]);
        continue;
      }
      // esli netu klana, pishem s vozmozhnostjami vzjatq -ne vzjatq
      $f .= '&#187;'.$ncm[$i].': <a class="red" href="game.php?sid='.$sid.'&action=take_to_clan&to='.$ncm[$i].'&take=1">+</a> / <a class="red" href="game.php?sid='.$sid.'&action=take_to_clan&to='.$ncm[$i].'&take=0">-</a><br/>';
    }
    exit_msg ('заявки', $f);
  }
?>