<?php
  // funkcija dobovljaet ukazzanoe kolichestvo veshej
  // veshi obezatelqno dolzhny bytq normalqnye, ne misc, stand i tp
  function gain_item ($item, $count, $login)
  {
    global $I_SEP_C, $p;
    //$item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
    $count = preg_replace ('/[^0-9]/', '', $count);
    //$login = preg_replace ('/[^a-z0-9_]/', '', $login);
    if (!$item || !$count || !$login) put_error ('заполните усе данные (это к админу)');

    $id = is_player ($login);

    include_once ('modules/f_create_item.php');
    include_once ('modules/f_add_item_to_pl.php');
    include_once ('modules/f_add_item_to_loc.php');
    include_once ('modules/f_get_it_name.php');
    if (substr ($item, 2, 1) == 'm')
    {
      $nitem = create_item ($item);
      //add_item_to_pl ($login, $nitem);
      $name = get_it_name ($nitem);
      $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$login."' AND is_in = 'inv' AND weight > 0;");
      $c = mysql_result ($q, 0);
      if ($c > $I_SEP_C)
        add_item_to_loc ($p['location'], $nitem);
      else
      {
        $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$login."' AND is_in = 'inv' AND realname = '".$item."';");
        if (mysql_num_rows ($q))
        {
          $fn = mysql_result ($q, 0);
          do_mysql ("UPDATE items SET on_take = on_take + ".$count." WHERE fullname = '".$fn."';");
          do_mysql ("DELETE FROM items WHERE fullname = '".$nitem."';");
        }
        else
        {
          add_item_to_pl ($login, $nitem);
          do_mysql ("UPDATE items SET on_take = '".$count."' WHERE fullname = '".$nitem."';");
        }
      }
      add_journal ('вы получили '.$name.'!', $login);
    }
    else
    {
      for ($i = 0; $i < $count; $i++)
      {
        $nitem = create_item ($item);
        $name = get_it_name ($nitem);
        $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$login."' AND is_in = 'inv' AND weight > 0;");
        $c = mysql_result ($q, 0);
        if ($c > $I_SEP_C)
          add_item_to_loc ($p['location'], $nitem);
        else
          add_item_to_pl ($login, $nitem);
        add_journal ('вы получили '.$name.'!', $login);
      }
    }
    return $nitem;
  }
?>