<?php
  // prigotovlenie pishi
  // vyzyvaetsja iz failov receptov

  $c_ins = count ($ins);
  if (!$ins[0]) $c_ins = 0;
  $c_ing = count ($ing);

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
    if (strpos ($item, '|'))
    {
      $has = 0;
      $item = explode ('|', $item);
      $c = count ($item);
      for ($i = 0; $i < $c; $i++) if (has_count ($item[$i], 1, $LOGIN)) $has = 1;
      if (!$has) put_g_error ('нехватает ингридиентов');
    }
    else
      if (!has_count ($item, 1, $LOGIN)) put_g_error ('нехватает ингридиентов');
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
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_item&item='.$item.'&cook=1">приготовить</a>';
    exit_msg ('рецепт', $f);
  }
  else
  {
    // prigotavlivaem
    $q = do_mysql ("SELECT on_take FROM items WHERE (realname = 'i.o.sta.fireplace' OR realname = 'i.o.sta.fireplace2' OR realname = 'i.o.sta.fireplace3' OR realname = 'i.o.sta.fireplace4') AND location = '".$p['location']."';");
    if (!mysql_num_rows ($q)) put_g_error ('разведите костер!');
    $on = mysql_result ($q, 0);
    if ($on == 'on')
    {
      // mozhno pristupitq
      for ($i = 0; $i < $c_ins; $i++) check_in_has ($ins[$i]);
      for ($i = 0; $i < $c_ing; $i++) check_in_has ($ing[$i]);
      include_once ('modules/f_delete_count.php');
      for ($i = 0; $i < $c_ing; $i++) use_in_has ($ing[$i]);
      include_once ('modules/f_delete_item.php');
      delete_item ($item);
      include_once ('modules/f_gain_item.php');
      if ($p['skills'][37] && rand (0, 100) <= (50 - $c_ing * 10 + $p['skills'][37] * 10))
      {
        $it = gain_item ($what, 1, $LOGIN);
        do_mysql ("UPDATE items SET name = CONCAT(name, ' [".$p['name']."]') WHERE fullname = '".$it."';");
      }
    }
    else
    {
      add_journal ('разведите костер!', $LOGIN);
    }
  }

?>