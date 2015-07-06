<?php
  // vzjatq s trupa:
  $dead = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['dead']);
  if (!$dead) put_error ('а с какого трупа то брать!!?');
  $q = do_mysql ("SELECT COUNT(*) FROM dead WHERE location = '".$p['location']."' AND fullname = '".$dead."';");
  $c = mysql_result ($q, 0);
  if (!$c && !isset ($SYSMSG)) put_g_error ('нет такого trupa');
  // infa trupa
  include_once ('modules/f_get_dead_info.php');
  $di = get_dead_info ($dead);
  $f = gen_header ($di['name']);
  $f .= '<div class="y" id="dead"><b>'.$di['name'].'</b></div><p>';

  if (isset ($OSVEZH)) $f .= '<b>вы разделали труп!</b><br/>';
  if (isset ($SYSMSG)) $f .= '<b>'.$SYSMSG.'</b><br/>';

  // soobshenie o ne prestupnike
  if (substr ($dead, 0, 4) == 'd.n.') $f .= '<b>труп принадлежит допропорядочному граждану. три раза подумайте, прежде чем марадерствовать!</b><br/>';

  // esli estq veshi:
  $q = do_mysql ("SELECT fullname, name, on_take FROM items WHERE belongs = '".$dead."';");
  if (!mysql_num_rows ($q))
  {
    $txt = '';
    if (isset ($SYSMSG)) $txt = $SYSMSG.'<br/>';
    exit_msg ($di['name'], $txt.'ничего нет');
  }
  while ($it = mysql_fetch_assoc ($q))
  {
    // prostaja veshq:
    if (substr ($it['fullname'], 2, 1) == 'm') $mcmi = ': '.$it['on_take'];
    else $mcmi = '';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=take_from_dead&item='.$it['fullname'].'&dead='.$dead.'">';
    $f .= $it['name'].'</a>'.$mcmi.' <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$it['fullname'].'">?</a><br/>';
  }
  $f .= '<br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
  $f .= '</p>';
  $f .= gen_footer ();
  exit ($f);
?>