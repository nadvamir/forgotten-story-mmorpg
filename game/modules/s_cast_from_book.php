<?php
  // kastovatq s knigi:
  $spell = preg_replace ('/[^a-z0-9_]/i', '', $_GET['spell']);
  $book = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['book']);

  // esli netu ukazano to, vyberem celq - :
  if (!isset ($_GET['to']))
  {
    $part = substr ($spell, 0, 3);
    if ($part == 'cre' || $part == 'sum') $_GET['to'] = $LOGIN;
    else
    {
      // vo teperq vyvedem spisok celei:
      include_once ('modules/f_list_inloc.php');
      $f = gen_header ('магия');
      $f .= '<div class="y" id="lagfi"><b>цель</b></div><p>';
      $f .= list_inloc ($LOGIN, 'cast_from_book&spell='.$spell.'&book='.$book);
      $f .= '<hr/>';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a><br/>';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
      $f .= gen_footer();
      exit ($f);
    }
  }
  else
    $to = preg_replace ('/[^a-z0-9_\.-]/i', '', $_GET['to']);
  
  // snachala proverim, estq li kniga:
  include_once ('modules/f_has_item.php');
  if (!has_item ($book, $LOGIN)) put_error ('у вас нету книги магии');

  // proverim estq li v knige zaklinanie:
  $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$book."' AND type = 'b';");
  $magic = mysql_result ($q, 0);
  if (strpos ($magic, $spell) === false) put_g_error ('в этой книге нету этого заклинания!');

  // proverka na poslednee kastovanie:
  include_once ('modules/f_check_last_cast.php');
  if (!check_last_cast ($LOGIN))
  {
    // formiruem blokirujusheju stranicu, no na nej pomestim ssylku prodolzhitq dejstvie:
    $str = $_SERVER['QUERY_STRING'];
    // iz $str nado vyreatq sid
    // nam pomozhet strpos
    $pos = strpos ($str, '&');
    // esli netu &, to eto ssylka na glavnuju, my ee i tak napishem
    if ($pos)
    {
      $str1 = substr ($str, ($pos + 1));
      $str2 = 'sid='.$sid.'&'.$str1;
    }
    else $str2 = 'sid='.$sid;

    $f = gen_header ('Забытая История');
    $f .= '<div class="y" id="udak"><b>Пауза</b>:</div>';
    $f .= '<p>';
    $f .= 'Вы еще не собрались силами после прошедшего заклинания!<br/>';

    $pl_eff = get_affected ($LOGIN);
    if ($pl_eff)
    {
      $f .= 'Эффекты:<br/>-';
      include_once ('modules/f_translit.php');
      $pl_eff = translit ($pl_eff);
      $pl_eff = str_replace ('|', '<br/>-', $pl_eff);
      $f .= $pl_eff;
    }

    $f .= '<a class="blue" href="game.php?'.$str2.'">продолжить</a> | ';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
    $f .= gen_footer ();
    exit ($f);
  }

  // potom ispolqzuem manu:
  include_once ('modules/f_use_mana.php');
  if (!use_mana ($spell, $LOGIN)) put_g_error ('у вас нехватает маны на это заклинание!');

  // teperq obnovim poslednee zaklinanie:
  include_once ('modules/f_upd_last_cast.php');
  upd_last_cast ($LOGIN, $spell);

  // skazhem slova:
  $q = do_mysql ("SELECT words FROM magic WHERE fullname = '".$spell."';");
  $words = mysql_result ($q, 0);
  add_journal ($p['name'].': '.$words.'!', 'l.'.$p['location']);

  // potom proverka, vyshlo li kastanutq zakl - 
  include_once ('modules/f_check_cast.php');
  if (check_cast ($spell, $LOGIN))
  {
    // magija udalasq:
    // zapros na tip:
    $q = do_mysql ("SELECT type FROM magic WHERE fullname = '".$spell."';");
    $type = mysql_result ($q, 0);
    if ($type == 'war') include 'modules/sp/sp_cast_war.php';
    else if ($type == 'cre') include 'modules/sp/sp_cast_cre.php';
    else if ($type == 'sum') include 'modules/sp/sp_cast_sum.php';
    else include 'modules/sp/sp_cast_hea.php';
  }
  else
  {
    add_journal ('заклинание сорвалось!', 'l.'.$p['location']);
  }
  include 'modules/s_main.php';
?>