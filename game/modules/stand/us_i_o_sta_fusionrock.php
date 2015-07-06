<?php
  // sera+voda->vitriol
  include_once ('modules/f_has_count.php');
  if (has_count ('i.q.que.alch.sera', 1, $LOGIN) && has_count ('i.f.dri.nor.water', 1, $LOGIN))
  {
    // udaljaem syrqe
    include_once ('modules/f_delete_count.php');
    delete_count ('i.q.que.alch.sera', 1, $LOGIN);
    delete_count ('i.f.dri.nor.water', 1, $LOGIN);

    include_once ('modules/f_gain_item.php');
    gain_item ('i.q.que.alch.vitriol', 1, $LOGIN);
  }
?>