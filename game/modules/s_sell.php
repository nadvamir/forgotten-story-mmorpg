<?php
  // prodatq veshq
  $item = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['item']);
  $npc = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['npc']);
  // tak kak etot variant prednaznacchen dlja prodazhi normalqnyh veshej, to misc nedopustim
  if (substr ($item, 2, 1) == 'm') put_error ('этот файл не для мелких вещей');

  // proverjaem, estq li takaja veshq v inventare
  $inv = do_mysql ("SELECT name, price FROM items WHERE belongs = '".$LOGIN."' AND is_in <> 'ban' AND fullname = '".$item."';");
  if (!mysql_num_rows ($inv)) put_error ('нету такой вещи в инвентаре');

  // esli estq, berem koeficient prodavca, umnozhaem na nego cenu, platim denqgi i udaljaem veshq
  $nid = is_npc ($npc);
  $koe = do_mysql ("SELECT drop2 FROM npc WHERE id_npc = '".$nid."';");
  $koe = mysql_result ($koe, 0);
  $koe = explode ('|', $koe);

  // esli npc mozhet pokupatq takoj tovar-
  if (strpos ($koe[0], (substr ($item, 2, 1))) === false && $koe[0] != '*') put_error ('торговец не покупает эти виды вещей');
  // teperq berem cenu veshi
  $price = mysql_fetch_assoc($inv);
  // koe[2] - koeficient na prodazhu
  $cost = round ($price['price'] * $koe[2]);
  if (substr ($item, 2, 1) == 'f')
  {
    $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$item."';");
    $numb = mysql_result ($q, 0);
    if ($numb > 1) $cost *= $numb;
  }
  // dobavljaem etu sumu chelu
  $p['money'] += $cost;
  do_mysql ("UPDATE players SET money = '".$p['money']."' WHERE id_player = '".$p['id_player']."';");
  // udaljaem veshq
  include_once ('modules/f_delete_item.php');
  delete_item ($item);
  // vse, veshq prodali, teperq vyvodim stranicu
  $f = gen_header ('торг');
  $f .= '<div class="y" id="oaidy"><b>продажа:</b></div><p>';
  $f .= 'вы продали '.$price['name'].' за '.$cost.' серебра!<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$npc.'&start='.$_GET['start'].'&start2='.$_GET['start2'].'">торг</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer ();
  exit ($f);
?>