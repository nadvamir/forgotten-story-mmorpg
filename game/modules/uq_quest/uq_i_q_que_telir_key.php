<?php
  // butylka:
  // esli rjadom estq golemy, nepustitq
  $q = do_mysql ("SELECT name FROM npc WHERE realname = 'n.x.golem';");
  if (mysql_num_rows ($q)) put_g_error ('стражу надо замочить');
  if (!$p['clan'][0] || $p['clan'][1] < 7) put_g_error ('вы неимеете права замок прихватить');
  // inache mozhno zahvatitq
  $q = do_mysql ("SELECT belongs FROM castle WHERE name = 'telir'");
  $clan = mysql_result ($q, 0);
  do_mysql ("UPDATE castle SET belongs = '".$p['clan'][0]."' WHERE name = 'telir';");
  include_once ('modules/f_delete_item.php');
  delete_item ($item);
  // soobshim 
  $q = do_mysql ("SELECT login FROM players WHERE clan LIKE '".$clan."%' OR clan LIKE '".$p['clan'][0]."%';");
  $to = '';
  while ($tmp = mysql_fetch_assoc ($q)) $to .= $tmp['login'].'|';
  add_journal ('[green][clan]'.$p['clan'][0].' отобрал Телир у '.$clan.'!!![/end]', $to);

  $action = '';
?>