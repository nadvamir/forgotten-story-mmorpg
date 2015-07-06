<?php
  // kostq
  // esli v rukah drevkovoe ili molot, drobim
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE ( realname LIKE 'i.w.tre%' OR realname LIKE 'i.w.ham%' ) AND belongs = '".$LOGIN."' AND is_in = 'wea';");
  $c = mysql_result ($q, 0);
  if ($c)
  {
    // naberem vody:
    include_once ('modules/f_delete_item.php');
    include_once ('modules/f_gain_item.php');
    delete_item ($item);
    gain_item ('i.m.rea.kostq', 25, $LOGIN);
  }
  else
  {
    add_journal ('никакого эффекта', $LOGIN);
  }
  $action = '';
?>