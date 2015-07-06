<?php
  // pokazatq informaciju o magii.
  $spell = mysql_real_escape_string ($_GET['spell']);
  $pos = strpos ($p['magic_l'], $spell);
  if ($pos === false) put_g_error ('вы неумеете этого заклинания');
  $pos2 = strrpos ($p['magic_l'], '|');
  if ($pos2 === false) $p['magic_l'] = '';
  else if ($pos2 < $pos) $p['magic_l'] = substr ($p['magic_l'], 0, $pos2);
  else if ($pos > 0) $p['magic_l'] = str_replace ('|'.$spell, '', $p['magic_l']);
  else $p['magic_l'] = substr ($p['magic_l'], strlen ($spell));
  
  //string_drop ($p['magic_l'], $spell);
  do_mysql ("UPDATE players SET magic = '".$p['magic_l']."' WHERE id_player = '".$p['id_player']."';");
  include ('modules/s_show_magic.php');
?>