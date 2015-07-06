<?php
  // Alhimija
  // vyzyvaetsja iz failov formul

  $c_ins = count ($ins);
  $c_ing = count ($ing);
  $qp = 0;

  // dlja get_in_name - 
  unset ($it);
  include ('modules/items/items_q/items_q_que.php');
  include ('modules/items/items_f/items_f_dri.php');
  include ('modules/items/items_f/items_f_foo.php');
  // funkcija vozvrashjaet nazvanie
  function get_in_name ($item)
  {
    global $it;
    if ($item == 'i.w.kni.bas.1h.kitchen.lvl1') return 'кухонный нож';
    if (strpos ($item, '|'))
    {
      $txt = '';
      $item = explode ('|', $item);
      $c = count ($item);
      for ($i = 0; $i < $c; $i++) $txt .= 'или '.(substr ($it[$item[$i]], 0, strpos ($it[$item[$i]], '|'))).' ';
      return $txt;
    }
    return (substr ($it[$item], 0, strpos ($it[$item], '|')));
  }
  // funkcija proverit, imeet li
  include_once ('modules/f_has_count.php');
  function check_in_has ($item)
  {
    global $LOGIN;
    global $p;
    if (strpos ($item, '|'))
    {
      $has = -1;
      $item = explode ('|', $item);
      $c = count ($item);
      for ($i = 0; $i < $c; $i++) if (has_count ($item[$i], 1, $LOGIN)) $has = $i;
      if ($has == -1) put_g_error ('нехватает ингридиентов');
      //for ($i = 0; $i < $c; $i++)
      //{
        $t = substr ($item[$has], 8, 1);
        if (($t == 1 && $p['skills'][32] < 1) || ($t == '2' && $p['skills'][32] < 5) || ($t == '3' && $p['skills'][32] < 10) || ($t == 4 && $p['skills'][32] < 15))
          put_g_error ('нехватает навыка пользоватся вешью');
        if ($t > 0 && $t < 5) $qp += $t;
      //}
    }
    else
    {
      $t = substr ($item, 8, 1);
      if (($t == 1 && $p['skills'][32] < 1) || ($t == '2' && $p['skills'][32] < 5) || ($t == '3' && $p['skills'][32] < 10) || ($t == 4 && $p['skills'][32] < 15))
        put_g_error ('нехватает навыка пользоватся вешью');
      if ($t > 0 && $t < 5) $qp += $t;
      if (!has_count ($item, 1, $LOGIN)) put_g_error ('нехватает ингридиентов');
    }
    return 1;
  }
  // funkcija ispolqzuet
  function use_in_has ($item)
  {
    global $LOGIN;
    if (strpos ($item, '|'))
    {
      $item = explode ('|', $item);
      $c = count ($item);
      for ($i = 0; $i < $c; $i++) if (delete_count ($item[$i], 1, $LOGIN)) break;
    }
    else
      delete_count ($item, 1, $LOGIN);
    return 1;
  }
  
  $f = '';
  if (!isset ($_GET['cook']))
  {
    // pokazyvaem recept
    $name = get_in_name ($what);
    $f .= 'чтоб приготовить <b>'.$name.'</b> нужны:<br/>';
    for ($i = 0; $i < $c_ins; $i++) $f .= get_in_name ($ins[$i]).'<br/>';
    $f .= 'и<br/>';
    for ($i = 0; $i < $c_ing; $i++) $f .= get_in_name ($ing[$i]).'<br/>';
    $f .= 'cложность приготовления '.(round($diff/5)).'<br/>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_item&item='.$item.'&cook=1">приготовить</a>';
    exit_msg ('формула', $f);
  }
  else
  {
    // prigotavlivaem
    $q = do_mysql ("SELECT on_take FROM items WHERE realname = 'i.o.sta.alchtable' AND location = '".$p['location']."';");
    if (!mysql_num_rows ($q)) put_g_error ('рядом нет стола!');
    // mozhno pristupitq
    for ($i = 0; $i < $c_ins; $i++) check_in_has ($ins[$i]);
    for ($i = 0; $i < $c_ing; $i++) check_in_has ($ing[$i]);
    include_once ('modules/f_delete_count.php');
    for ($i = 0; $i < $c_ing; $i++) use_in_has ($ing[$i]);
    include_once ('modules/f_delete_item.php');
    delete_item ($item);
    include_once ('modules/f_create_item.php');
    if ($p['skills'][32] && rand (0, 100) <= ($p['skills'][32] * 5 * 100) / $diff)
    {
      $it = create_item ($what);
      $qpp = 1;
      $n = '';
      $rnd = rand (0, $qp * 10 + $p['skills'][32] * 10);
      if ($rnd < 100) { $qpp = 1; $n = 'слабый';}
      else if ($rnd < 150) { $qpp = 2; $n = 'малый';}
      else if ($rnd < 200) { $qpp = 3; $n = '';}
      else if ($rnd < 250) { $qpp = 4; $n = 'улучшенный';}
      else { $qpp = 5; $n = 'мощный';}
      
      $q = do_mysql ("SELECT id_item, name, jewel, weight FROM items WHERE fullname = '".$it."';");
      $ii = mysql_fetch_assoc ($q);
      if ($ii['jewel']) $ii['jewel'] .= '|'.$qpp;
      $ii['name'] = $n . ' ' . $ii['name'].' ['.$p['name'].']';
      do_mysql ("UPDATE items SET name = '".$ii['name']."', jewel = '".$ii['jewel']."' WHERE id_item = '".$ii['id_item']."';");

      include_once ('modules/f_get_pl_weight.php');
      include_once ('modules/f_add_item_to_pl.php');
      include_once ('modules/f_add_item_to_loc.php');
      $pw = get_pl_weight ($login);
      $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
      $c = mysql_result ($q, 0);
      $p['carry'] = explode ('|', $pp['carry']);
      if ($pw + $ii['weight'] > $p['carry'] || $c > $I_SEP_C)
        add_item_to_loc ($p['location'], $it);
      else
        add_item_to_pl ($LOGIN, $it);
      $name = $ii['name'];
      add_journal ('вы получили '.$name.'!', $LOGIN);
    }
    else
    {
      add_journal ('невышло приготовить', $LOGIN);
    }
  }

?>