<?php
  // zheltyj kamenq, prevrashjaet rybu v fosfor
  if (!isset ($_GET['part']))
  {
    // vyberaem chto prevratitq v fosfor, ato somov vsjakih zhalko budet
   include_once ('modules/f_list_inventory.php');
    $f .= '<b>выберите рыбу, какую не жалко:</b><br/>';
    $f .= list_inventory ($LOGIN, 'i.f.foo.fish_', 'use_stand&item='.$item.'&part=2');
    exit_msg ('желтый камень', $f);
  }
  else
  {
    $to = mysql_real_escape_string (strip_tags ($_GET['to']));
    if (substr ($to, 0, 12) != 'i.f.foo.fish')
      put_g_error ('ты та что суешь?');

    include_once ('modules/f_has_item.php');
    if (!has_item ($to, $LOGIN)) put_g_error ('а где рыба?');

    // udaljaem syrqe
    include_once ('modules/f_delete_item.php');
    delete_item ($to);

    include_once ('modules/f_gain_item.php');
    gain_item ('i.q.que.alch.fosfor', 1, $LOGIN);
  }
?>