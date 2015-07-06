<?php
  // lopata
  // lokacija => nomer klada
  $kl['rele|4x11'] = 0; // kljuch ot podvalov
  $kl['rbfo|8x6'] = 1; // nasledie drakona
  $kl['eway|21x2'] = 2; // klad invalidov
  $kl['rele|2x9'] = 3; // klad lekarja
  $kl['ffo4|8x7'] = 4; // klad trolja
  $kl['sfr4|4x2'] = 5; // klad ryzhego
  $kl['cway|1x5'] = 6; // klad mosta
  $kl['ffo7|7x5'] = 7; // klad ruin dalqnego
  $kl['ffo6|1x1'] = 8; // klad piratov
  $kl['mva1|7x3'] = 9; // klad tjurqmy
  $kl['rele|2x11'] = 10; // klad niutona
  $kl['rogl|2x2'] = 11; // klad Rogla

  // postojannye iskopaemye
  $pi['prf4|2x5'] = 'i.q.que.alch.sera';

  include_once ('modules/f_gain_item.php');

  $shoron = 0; // klanovye shorony
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$p['location']."';");
  if (mysql_num_rows ($q))
  {
    include_once ('modules/f_add_item_to_pl.php');
    $shoron = 1;
    while ($it = mysql_fetch_assoc ($q))
    {
      add_item_to_pl ($LOGIN, $it['fullname']);
      add_journal ('вы получили '.$it['name'].'!', $LOGIN);
    }
  }

  if (isset ($pi[$p['location']]))
  {
    gain_item ($pi[$p['location']], 1, $LOGIN);
    include 'modules/s_main.php';
  }
  if (!isset ($kl[$p['location']]) && !$shoron) exit_msg ('клад', 'тут клада нет...');
  else if (!isset ($kl[$p['location']])) include 'modules/s_main.php';
  // teperq esli lokacija takova, i klad ne vykopan, podkljuchaem fajl
  if (!$p['treasures'][$kl[$p['location']]])
    include 'modules/treasures/klad_'.($kl[$p['location']]).'.php';
  else exit_msg ('клад', 'тут клада нет...');

  if (isset ($kl_slv))
  {
    include_once ('modules/f_gain_silver.php');
    gain_silver ($kl_slv, $LOGIN);
  }
  if (isset ($kl_exp))
  {
    include_once ('modules/f_gain_peace_exp.php');
    gain_peace_exp ($kl_exp, $LOGIN);
  }
  if (isset ($kl_it))
  {
    foreach ($kl_it as $key => $val)
    {
      gain_item ($key, $val, $LOGIN);
    }
  }

  $p['treasures'][$kl[$p['location']]] = 1;
  do_mysql ("UPDATE players SET treasures = '".$p['treasures']."' WHERE id_player = '".$p['id_player']."';");
?>