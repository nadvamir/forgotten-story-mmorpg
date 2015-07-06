<?php
  // izmenjaet sobstvennye nastrojki
  // $_GET['change']:
  // maininfo - osnovnaja infa
  // pgmode - tip stranica, loka ili chat
  //------------------------
  $set = preg_replace ('/[^01]/i', '', $_GET['set']);
  if (!$_GET['change'] || $set === false) put_error ('<p>all settings required for settings..</p>');
  if ($_GET['change'] == 'maininfo') $p['settings'][0] = $set;
  if ($_GET['change'] == 'pgmode') $p['settings'][1] = $set;
  if ($_GET['change'] == 'locmode') $p['settings'][2] = $set;
  if ($_GET['change'] == 'journal') $p['settings'][3] = $set;
  if ($_GET['change'] == 'mapinfo') $p['settings'][4] = $set;
  if ($_GET['change'] == 'daynight') $p['settings'][6] = $set;
  if ($_GET['change'] == 'journal2') $p['settings'][7] = $set;
  //-------------------------
  do_mysql ("UPDATE players SET settings = '".$p['settings']."' WHERE id_player = '".$p['id_player']."';");
  //-------------------------
  $f = gen_header ('настройки');
  $f .= '<div class="y" id="tpewriter">';
  $f .= '<b>настройки<b></div>';
  $f .= '<p>ваши настройки успешно установлены!<br/><a class="blue" href="game.php?sid='.$sid.'">в игру</a><p>';
  $f .= gen_footer();
  exit ($f);
?>