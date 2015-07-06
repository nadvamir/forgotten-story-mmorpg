<?php
  // funkcija uvelichivaet kolichestvo melkih veshej
  function decrease_misc ($item, $count)
  {
    //$item = preg_replace ('/[^a-z0-9_\.]/i', '', $item);
    $count = preg_replace ('/[^0-9]/', '', $count);
    // vozmem nachalqnoe kolichestvo
    $sc = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$item."';");
    $sc = mysql_result ($sc, 0);
    // esli count menqshe nulja, tupaja oshibka
    if ($count <= 0) //put_error ('уменьшить на минусовое число нелзя, надо использовать увеличить');
      return 0;
    // esli otnjav poluchitsja menqshe 0 tozhe nelzja, ob etom pozabotitsja nado v skriptah
    if ($sc - $count < 0) //put_error ('как ты считал балбес, ведь меньше 0 получается');
      return 0;
    // esli vse prodolzhaetsja, uvelichim i obnovim
    $nc = $sc - $count;
    if ($nc < 1)
    {
      include_once ('modules/f_delete.php');
      delete_item ($item);
    }
    do_mysql ("UPDATE items SET on_take = '".$nc."' WHERE fullname = '".$item."';");
    return 1;
  }
?>