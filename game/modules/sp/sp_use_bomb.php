<?php
  // ispolqzuem bombu
  // podkljuchaetsja iz sp_use_food, ispolqzuet ego peremennye

  if (!isset ($_GET['to']))
  {
    // pokazyvaem vybor lokacii
    include_once ('modules/f_loc.php');
    $lc = loc ($p['location'], 'near');
    $f = '';

    foreach ($lc as $key => $val)
    {
      if (!$key) continue;
      switch ($key)
      {
        case 1: $st = 'сз'; break;
        case 2: $st = 'с'; break;
        case 3: $st = 'св'; break;
        case 4: $st = 'з'; break;
        case 5: $st = 'в'; break;
        case 6: $st = 'юз'; break;
        case 7: $st = 'ю'; break;
        case 8: $st = 'юв'; break;
      }
      $f .= '<a class="red" href="game.php?sid='.$sid.'&action=use_item&item='.$item.'&to='.$val[0].'&stor='.$key.'">'.$st.'</a> - '.$val[1].'<br/>';
    }
    exit_msg ('выберите локацию:', $f);
  }

  // esli vypolnjaetsja, znachet to vybran
  $to = preg_replace ('/[^a-z0-9\|]/i', '', $_GET['to']);
  $stor = preg_replace ('/[^1-8]/i', '', $_GET['stor']);
  $toloc = $to;
  if (substr ($toloc, 0, 4) == 'rele' || substr ($toloc, 0, 4) == 'elfc' || substr ($toloc, 0, 4) == 'verg') put_g_error ('на этой локации атаковать нелзя');

  // mozhno li dostatq do toj lokacii
  include_once ('modules/f_can_u_reach.php');
  if (!can_u_reach ($LOGIN, $to, $stor, 1))
  {
    $_GET['to'] = '';
    include 'modules/sp/sp_use_bomb.php';
  }

  // udalim
  include_once ('modules/f_delete_item.php');
  delete_item ($item);

  // berem vseh igrokov v toj lokacii
  include_once ('modules/f_set_affected.php');
  $q = do_mysql ("SELECT id_player, login, life, mana FROM players WHERE location = '".$to."';");
  while ($t = mysql_fetch_assoc ($q))
  {
    $t['life'] = explode ('|', $t['life']);
    $t['mana'] = explode ('|', $t['mana']);
    $t['life'][0] += $do[0];
    $t['mana'][0] += $do[1];
    if ($t['life'][0] < 1)
    {
      // make die
      include_once ('modules/f_make_die.php');
      make_die ($t['login']);
      continue;
    }
    $tl = $t['life'][0].'|'.$t['life'][1];
    $tm = $t['mana'][0].'|'.$t['mana'][1];
    do_mysql ("UPDATE players SET life = '".$tl."', mana = '".$tm."' WHERE id_player = '".$t['id_player']."';");
    // esli estq effekt
    if ($ii['jewel'])
      set_affected ($t['login'], $ii['jewel']);
  }
  // npc
  $q = do_mysql ("SELECT id_npc, fullname, life, in_battle, location FROM npc WHERE location = '".$to."';");
  while ($t = mysql_fetch_assoc ($q))
  {
    $t['life'] = explode ('|', $t['life']);
    $t['life'][0] += $do[0];
    if ($t['life'][0] < 1)
    {
      // make die
      include_once ('modules/f_make_die.php');
      make_die ($t['fullname']);
      continue;
    }
    $tl = $t['life'][0].'|'.$t['life'][1];
    //if (!$t['in_battle']) $t['location'] = $p['location'];
    $t['location'] = $p['location'];
    do_mysql ("UPDATE npc SET life = '".$tl."', location = '".$t['location']."' WHERE id_npc = '".$t['id_npc']."';");
    // esli estq effekt
    if ($ii['jewel'])
      set_affected ($t['fullname'], $ii['jewel']);
  }

  add_journal ($p['name'].' кинул сюда '.$ii['name'].'. Всем урон '.$do[0].', мана истощена на '.$do[1].'!', 'l.'.$to);
  add_journal ($p['name'].' кинул '.$ii['name'].' в даль. Там всем урон '.$do[0].', мана истощена на '.$do[1].'!', 'l.'.$p['location']);

  include 'modules/s_main.php';
?>