<?php
  // kupitq veshq
  $item = preg_replace ('/[^a-z0-9:\._]/i', '', $_GET['item']);
  $count = preg_replace ('/[^0-9]/', '', $_GET['count']);
  $it = $item;
  $pos = strpos ($item, ':');
  if ($pos !== false)
  {
    $numb = substr ($item, 0, $pos);
    $item = substr ($item, ($pos + 1));
  }
  $npc = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['npc']);
    include_once ('modules/f_real_name.php');
    $rn = real_name ($npc);
    $file_name = str_replace ('.', '_', $rn);
    if (!file_exists ('modules/npc/t/t_'.$file_name.'.php')) put_g_error ('no trade file');
    include ('modules/npc/t/t_'.$file_name.'.php');
    if (!is_in ($it, $torg)) put_error ('there is no such item with the trader');
  // funkcija eta ponadobitsjam esli pridetsja cenu ustanovitq i td

  include_once ('modules/f_trade_param.php');

  // teperq proverim, estq li takaja veshq u prodovca
  $nid = is_npc ($npc);
  $tr = do_mysql ("SELECT drop2 FROM npc WHERE id_npc = '".$nid."';");
  $tr = mysql_result ($tr, 0);
  $param = trade_param ($item);
  // teperq proverim, hvataet li deneg

  $tr = explode ('|', $tr);
  $param[6] *= $tr[1];
  $param[6] = round ($param[6]);
  $param[6] *= $count;
  if (isset ($numb)) $param[6] *= $numb;
  if ($p['money'] - $param[6] < 0) put_g_error ('у вас недостаточно денег, надо '.$param[6].' серебра');
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
  $c = mysql_result ($q, 0);
  if ($param[6] > 0 && $c + $count - 1 > $I_SEP_C)  put_g_error('<p>в рюгзаке нехватает места</p>');
  // esli vse horosho, udalim veshq iz spiska tovarov prodovca, zamenim ee novoj
  // sozdadim takuju v inventare igroka

  //-
  $p['money'] -= $param[6];
  do_mysql ("UPDATE players SET money = '".$p['money']."' WHERE id_player = '".$p['id_player']."';");
  include_once 'modules/f_create_item.php';
  include_once 'modules/f_add_item_to_pl.php';
  for ($i = 0; $i < $count; $i++)
  {
    $nitem = create_item ($item);
    add_item_to_pl ($LOGIN, $nitem);
    if (isset ($numb)) do_mysql ("UPDATE items SET on_take = '".$numb."' WHERE fullname = '".$nitem."';");
  }
  $f = gen_header ('торг');
  $f .= '<div class="y" id="oaidy"><b>купля:</b></div><p>';
  $f .= 'вы купили '.$count.' '.$param[0].' за '.$param[6].' серебра!<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$npc.'&start='.$_GET['start'].'&start2='.$_GET['start2'].'">торг</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer ();
  exit ($f);
?>