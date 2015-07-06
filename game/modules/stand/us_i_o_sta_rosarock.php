<?php
  // voda->rosa
  include_once ('modules/f_has_count.php');
  if (has_count ('i.f.dri.nor.water', 1, $LOGIN) && is_in ('fresh', $p['magic']))
  {
    // udaljaem syrqe
    include_once ('modules/f_delete_count.php');
    delete_count ('i.f.dri.nor.water', 1, $LOGIN);

    include_once ('modules/f_gain_item.php');
    gain_item ('i.q.que.rosa', 1, $LOGIN);
  }
  // takzhe polnoe vosstanovlenie manny
  $p['mana'][0] = $p['mana'][1];
  $mana = $p['mana'][1].'|'.$p['mana'][1];
  do_mysql ("UPDATE players SET mana = '".$mana."' WHERE id_player = '".$p['id_player']."';");

?>