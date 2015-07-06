<?php
  // prodatq melkuju veshq
  $item = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['item']);
  $npc = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['npc']);
  $count = preg_replace ('/[^0-9]/i', '', $_GET['count']);
  if (!$count) $count = 1;

  ////////////////////////////////
  // infa veshi
  if (substr ($item, 2, 1) != 'm') put_error ('это не мелкая вещь');
  $iin = do_mysql ("SELECT name, on_take, price FROM items WHERE fullname = '".$item."' AND belongs = '".$LOGIN."' AND is_in <> 'ban';");
  if (!mysql_num_rows ($iin)) put_g_error ('нету такой вещи');
  $iin = mysql_fetch_assoc ($iin);
  $nid = is_npc ($npc);
  $tr = do_mysql ("SELECT drop2 FROM npc WHERE id_npc = '".$nid."';");
  $tr = mysql_result ($tr, 0);
  $tr = explode ('|', $tr);
  if (strpos ($tr[0], (substr ($item, 2, 1))) === false && $tr[0] != '*') put_error ('торговец не покупает эти виды вещей');

  if ($count > $iin['on_take']) $count = $iin['on_take'];
  // cena
  $cost = round($iin['price'] * $count * $tr[2]);
  $p['money'] += $cost;
  do_mysql ("UPDATE players SET money = '".$p['money']."' WHERE id_player = '".$p['id_player']."';");
  if ($count == $iin['on_take'])
  {
    // beretsja vsja veshq
    // udaljaem veshq von
    include_once ('modules/f_delete_item.php');
    delete_item ($item);
  }
  else
  {
    include_once ('modules/f_decrease_misc.php');
    decrease_misc ($item, $count);
  }
  // vse, veshq prodali, teperq vyvodim stranicu
  $f = gen_header ('торг');
  $f .= '<div class="y" id="oaidy"><b>продажа:</b></div><p>';
  $f .= 'вы продали '.$count.' '.$iin['name'].' за '.$cost.' серебра!<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$npc.'&start='.$_GET['start'].'&start2='.$_GET['start2'].'">торг</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer ();
  exit ($f);
?>