<?php
  // ispolqzuem jad
  // podkljuchaetsja iz sp_use_food, ispolqzuet ego peremennye

  $toloc = $p['location'];
  if (substr ($toloc, 0, 4) == 'rele' || substr ($toloc, 0, 4) == 'elfc' || substr ($toloc, 0, 4) == 'verg') put_g_error ('на этой локации атаковать нелзя');
  if (!isset ($_GET['to']))
  {
    // pokazyvaem vybor igroka
    // ili npc
    include_once ('modules/f_list_inloc.php');
    $f = list_inloc ($LOGIN, 'use_item&item='.$item);
    exit_msg ('выберите цель:', $f);
  }

  // esli vypolnjaetsja, znachet to vybran
  $to = preg_replace ('/[^a-z0-9_\.-]/i', '', $_GET['to']);

  // napadaem:
  include_once ('modules/f_attack.php');
  attack ($LOGIN, $to);

  // udalim
  if ($ii['on_take'] > 1)
  {
    // umenqshim kolichestvo
    $ii['on_take']--;
    do_mysql ("UPDATE items SET on_take = '".$ii['on_take']."' WHERE id_item = '".$ii['id_item']."';");
  }
  else
  {
    include_once ('modules/f_delete_item.php');
    delete_item ($item);
  }

  $id = is_player ($to);
  if ($id)
  {
    $q = do_mysql ("SELECT life, mana, name FROM players WHERE id_player = '".$id."';");
    $t = mysql_fetch_assoc ($q);
    $t['life'] = explode ('|', $t['life']);
    $t['mana'] = explode ('|', $t['mana']);
    $t['life'][0] += $do[0];
    $t['mana'][0] += $do[1];
    if ($t['life'][0] < 1)
    {
      // make die
      include_once ('modules/f_make_die.php');
      make_die ($to);
      include 'modules/s_main.php';
    }
    $tl = $t['life'][0].'|'.$t['life'][1];
    $tm = $t['mana'][0].'|'.$t['mana'][1];
    do_mysql ("UPDATE players SET life = '".$tl."', mana = '".$tm."' WHERE id_player = '".$id."';");
  }
  else
  {
    $id = is_npc ($to);
    if (!$id) include 'modules/s_main.php';
    // npc
    $q = do_mysql ("SELECT life, name FROM npc WHERE id_npc = '".$id."';");
    $t = mysql_fetch_assoc ($q);
    $t['life'] = explode ('|', $t['life']);
    $t['life'][0] += $do[0];
    if ($t['life'][0] < 1)
    {
      // make die
      include_once ('modules/f_make_die.php');
      make_die ($to);
      include 'modules/s_main.php';
    }
    $tl = $t['life'][0].'|'.$t['life'][1];
    do_mysql ("UPDATE npc SET life = '".$tl."' WHERE id_npc = '".$id."';");
  }

  // esli estq effekt
  if ($ii['jewel'])
  {
    include_once ('modules/f_set_affected.php');
    set_affected ($to, $ii['jewel']);
  }

  add_journal ($p['name'].' прыснул ядом в '.$t['name'].'. Жизнь '.$do[0].', мана '.$do[1].'!', 'l.'.$p['location']);

  include 'modules/s_main.php';
?>