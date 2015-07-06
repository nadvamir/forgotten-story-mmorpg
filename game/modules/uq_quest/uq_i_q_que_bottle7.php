<?php
  // butylka:
  // esli rjadom estq bereg reki ili bereg ozera, to ona prevratitsja v vodu
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE (realname = 'i.o.sta.seashore' OR realname = 'i.o.sta.riverbank' OR realname = 'i.o.sta.lake') AND location = '".$p['location']."';");
  $c = mysql_result ($q, 0);
  if ($c)
  {
    // naberem vody:
    include_once ('modules/f_delete_item.php');
    include_once ('modules/f_gain_item.php');
    delete_item ($item);
    gain_item ('i.f.dri.nor.water7', 1, $LOGIN);
  }
  else
  {
    add_journal ('никакого эффекта', $LOGIN);
  }
  $action = '';
?>