<?php
  //fail ispolqzovanija veshi
  // EDA I PITQE ))
  // dlja edy nuzhen on_use
  // tam stroka : life+~mana+~krovotechenie-~jad-~ogonq-
  $qii = do_mysql ("SELECT id_item, name, on_take, on_use, jewel FROM items WHERE fullname = '".$item."';");
  $ii = mysql_fetch_assoc ($qii);
  // jewel - effekt
  $do = explode ('~', $ii['on_use']);

  if (substr ($item, 8, 3) == 'bom')
  {
    // eto bomba
    include_once ('modules/sp/sp_use_bomb.php');
  }
  if ($do[0] < 0)
  {
    // eto jad
    include_once ('modules/sp/sp_use_poison.php');
  }

   // esli estq effekt
   if ($ii['jewel'])
   {
     include_once ('modules/f_set_affected.php');
     set_affected ($LOGIN, $ii['jewel']);
   }

  /*// esli umenqshaet zhiznq, znachit jad, otravim
  if ($do[0] < 0)
  {
    include_once ('modules/f_start_poison.php');
    start_poison ($LOGIN);
    $q = do_mysql ("SELECT status1 FROM players WHERE id_player = '".$p['id_player']."';");
    $p['status1'] = mysql_result ($q, 0);
  }*/
  // a esli menqshe mana, to alkogolq
  if ($do[1] < 0)
  {
    include_once ('modules/f_set_affected.php');
    set_affected ($LOGIN, 'pqjan', $do[1]*(-1));
    $q = do_mysql ("SELECT affected FROM players WHERE id_player = '".$p['id_player']."';");
    $p['affected'] = mysql_result ($q, 0);
    $AFF = get_affected ($LOGIN);
  }

  $f = '';
  if (substr ($item, 0, 7) == 'i.f.dri') $f .= 'вы выпили '.$itname.'!<br/>';
  else $f .= 'вы съели '.$itname.'!<br/>';
  if (is_in ('prokljat', $AFF)) exit_msg ('проклятие', 'древнее проклятие не дает вам восстановить сил!<br/> ');
  // teperq proverim igroka
  if ($p['life'][0] + (int) $do[0] >= $p['life'][1] && $do[0] > 0)
  {
    $p['life'][0] = $p['life'][1];
    $f .= 'ваша жизнь полностью восстановленна!<br/>';
  }
  else
  {
    $p['life'][0] += $do[0];
    $f .= 'жизнь +'.$do[0].'<br/>';
  }
  if ($p['mana'][0] + $do[1] >= $p['mana'][1] && $do[1])
  {
    $p['mana'][0] = $p['mana'][1];
    $f .= 'ваша мана полностью восстановленна!<br/>';
  }
  else
  {
    $p['mana'][0] += $do[1];
    $f .= 'мана +'.$do[1].'<br/>';
  }
  if ($p['status1'][2] == 1 && $do[2] == 1)
  {
    $p['status1'][2] = 0;
    $f .= 'кровотечение остановленно!<br/>';
  }
  if ($p['status1'][3] == 1 && $do[3] == 1)
  {
    $p['status1'][3] = 0;
    $f .= 'отравление снято!<br/>';
  }
  if ($p['status1'][4] == 1 && $do[4] == 1)
  {
    $p['status1'][4] = 0;
    $f .= 'горение прекращенно!<br/>';
  }
  // teperq obnovim igroka
  do_mysql ("UPDATE players SET life = '".$p['life'][0]."|".$p['life'][1]."', mana = '".$p['mana'][0]."|".$p['mana'][1]."', status1 = '".$p['status1']."' WHERE id_player = '".$p['id_player']."';");
  // udalim edu
  include_once ('modules/f_delete_item.php');
  delete_item ($item);

  // dobavljaem soobshenie v zhurnal:
  add_journal ($f, $LOGIN);
  include 'modules/s_journal.php';
  if (isset ($_GET['battle'])) include 'modules/s_main.php';
  include 'modules/s_showinventory.php';

?>