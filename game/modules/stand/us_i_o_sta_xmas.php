<?php
  // igrushka na jolku
  include_once ('modules/f_has_count.php');
  if (has_count ('i.q.que.xmas', 1, $LOGIN))
  {
    // udaljaem syrqe
    include_once ('modules/f_delete_count.php');
    delete_count ('i.q.que.xmas', 1, $LOGIN);

    include_once ('modules/f_gain_item.php');
    gain_item ('i.f.dri.alc.elf_vine', 1, $LOGIN);
    include_once ('modules/f_gain_peace_exp.php');
    gain_peace_exp (1000, $LOGIN);
  }
?>