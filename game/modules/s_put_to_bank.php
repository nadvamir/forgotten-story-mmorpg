<?php
  // polozhitq v bank veshq iz inventarja
  // veshq
  $item = preg_replace ('/[^a-z-0-9\._]/i', '', $_GET['item']);
  $bank = preg_replace ('/[^a-z-0-9\._]/i', '', $_GET['bank']);
  // esli ona imeetsja v inventare

  $q = do_mysql ("SELECT name FROM items WHERE fullname = '".$item."' AND is_in = 'inv' AND belongs = '".$LOGIN."' AND type <> 'm';");
  if (!mysql_num_rows ($q)) put_g_error ('у вас нету этой вещи');
  $name = mysql_result ($q, 0);

  // estq li rjadom bank:
  $q = do_mysql ("SELECT name FROM items WHERE location = '".$p['location']."' AND fullname = '".$bank."';");
  if (!mysql_num_rows ($q)) put_g_error ('нету куда ложить');
  $bname = mysql_result ($q, 0);

  // hvataet li v banke mesta:
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'ban' AND weight > 0;");
  $c = mysql_result ($q, 0);
  if ($c > 49) put_g_error ('нехватает места');

  // a teperq lozhim:
  if (!isset ($_GET['all'])) $q = do_mysql ("UPDATE items SET is_in = 'ban' WHERE fullname = '".$item."';");
  else
  {
    include_once ('modules/f_real_name.php');
    $rn = real_name ($item);
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE realname = '".$rn."' AND is_in = 'inv' AND belongs = '".$LOGIN."' AND weight > 0;");
    $c += mysql_result ($q, 0);
    if ($c > 49) put_g_error ('нехватает места');
    do_mysql ("UPDATE items SET is_in = 'ban' WHERE realname = '".$rn."' AND is_in = 'inv' AND belongs = '".$LOGIN."';");
  }

  //$f = gen_header ($bname);
  //$f .= '<div class="y" id="f"><b>'.$bname.':</b></div><p>';
  $f = 'вы положили ';
  $f .= $name.' в '.$bname.'!<br/>';
  //$f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$bank.'">'.$bname.'</a><br/>';
  //$f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  //$f .= gen_footer();
  //exit($f)
  $SYSMSG = $f;
  $_GET['item'] = $bank;
  include ('modules/s_use_stand.php');
?>