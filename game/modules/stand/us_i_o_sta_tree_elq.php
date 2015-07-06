<?php
  // derevo elq
  // proverim, estq li topor v rukah i navyk
  if (!strpos ($p['weapon'], 'tree')) put_g_error ('возьмите топор лесоруба в руки!');
  if (!$p['skills'][35]) put_g_error ('нема навыка - нема дров }=[');
  $f = '';

  $q = do_mysql ("SELECT on_use FROM items WHERE fullname = '".$item."';");;
  $time = mysql_result ($q, 0);
  if ($time > 0 && $time > time())
    add_journal ('Нету гринписа на вас! Глянь во что дерево превратили!!!', $LOGIN);
  else
  {
    $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$item."';");;
    $count = mysql_result ($q, 0);
    if ($time > 0)
    {
      do_mysql ("UPDATE items SET on_use = '' WHERE fullname = '".$item."';");
      $count = 3;
    }
    if ($p['skills'][35] * 10 >= rand (0, 100))
    {
      // рубим ветви -
      $count--;
      include_once ('modules/f_gain_item.php');
      gain_item ('i.q.que.vetka', 1, $LOGIN);
    }
    else
    {
      add_journal ('Вам неудалось срубить ветки!', $LOGIN);
      $count--;
    }
    // obnovim kolichestvo
    do_mysql ("UPDATE items SET on_take = '".$count."' WHERE fullname = '".$item."';");
    if ($count == 0)
      do_mysql ("UPDATE items SET on_use = '".(time() + 300)."' WHERE fullname = '".$item."';");
  }
?>