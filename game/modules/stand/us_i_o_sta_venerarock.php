<?php
  // kamenq venery, ruda->MEDQ
  include_once ('modules/f_has_count.php');
  if (has_count ('i.q.que.ore', 1, $LOGIN))
  {
    // udaljaem syrqe
    include_once ('modules/f_delete_count.php');
    delete_count ('i.q.que.ore', 1, $LOGIN);

    include_once ('modules/f_gain_item.php');
    gain_item ('i.q.que.alch.medq', 1, $LOGIN);
  }
?>