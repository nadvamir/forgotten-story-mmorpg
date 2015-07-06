<?php
  // proverka opyta
  function check_pl_exp ($login)
  {
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);
    $id = is_player ($login);
    if (!$id) return 0;
    $q = do_mysql ("SELECT stats FROM players WHERE id_player = '".$id."';");
    $stats = mysql_result ($q, 0);
    $stats = explode ('|', $stats);
    if ($stats[1] >= $stats[2])
    {
      $q = do_mysql ("SELECT skills, rase FROM players WHERE id_player = '".$id."';");
      $sk = mysql_fetch_assoc ($q);
      $sk['skills'] = explode ('|', $sk['skills']);
      switch ($sk['rase'])
      {
        case 1: $sk['skills'][0] += 1; $sk['skills'][2] += 1; break;
        case 2: $sk['skills'][1] += 1; $sk['skills'][3] += 1; break;
        case 3: $sk['skills'][0] += 1; $sk['skills'][3] += 1; break;
      }
      $sk['skills'] = implode ('|', $sk['skills']);
      if (substr ($sk['skills'], 0, 1) == '|') $sk['skills'] = substr ($sk['skills'], 1);
      $stats[0] += 1;
      if ($stats[0] <= 12 || ($stats[0] % 10 == 0)) $stats[3] += 1;
      $stats[1] -= $stats[2];
      $stats[2] = 600 * $stats[0] * $stats[0] + 1000 * $stats[0];
      $nstats = $stats[0].'|'.$stats[1].'|'.$stats[2].'|'.$stats[3].'|'.$stats[4].'|'.$stats[5].'|'.$stats[6].'|'.$stats[7];
      do_mysql ("UPDATE players SET stats = '".$nstats."', skills = '".$sk['skills']."' WHERE id_player = '".$id."';");
      add_journal ('новый уровень: '.$stats[0].'!', $login);
      add_journal ('вы получили очко навыка!', $login);
    }
    if ($stats[4] >= $stats[5])
    {
      // poluchitq ochko opyta:
      $stats[6] += 1;
      $stats[4] -= $stats[5];
      $stats[7] += 1;
      $stats[5] = round ((600 * $stats[0] * $stats[0] + 1000 * $stats[0]) / 9);
      $nstats = $stats[0].'|'.$stats[1].'|'.$stats[2].'|'.$stats[3].'|'.$stats[4].'|'.$stats[5].'|'.$stats[6].'|'.$stats[7];
      do_mysql ("UPDATE players SET stats = '".$nstats."' WHERE id_player = '".$id."';");
      add_journal ('вы получили очко опыта!', $login);
    }
    return 1;
  }
?>