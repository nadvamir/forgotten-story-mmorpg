<?php
  // infa kvestovoj veshi
  $f = gen_header ('инфо');
  $f .= '<div class="y" id="oaiyt">';
  $qitf = do_mysql ("SELECT * FROM items WHERE fullname = '".$to."';");
  $itf = mysql_fetch_assoc ($qitf);
  $f .= '<b>'.$itf['name'].'</b></div><p>';
  $f .= '<small>свиток</small><br/>';
  $f .= '<b>заклинание:</b><br/>';

  $q = do_mysql ("SELECT name FROM magic WHERE fullname = '".$itf['on_take']."';");
  $name = mysql_result ($q, 0);
  if (!$name) put_error ('netu zaklinanija takogo');
  if (!isset ($_GET['npc'])) $f .= '-<small>'.$name.' <a class="blue" href="game.php?sid='.$sid.'&action=show_magic_info&spell='.$itf['on_take'].'">?</a></small><br/>';
  else  $f .= '-<small>'.$name.' <a class="blue" href="game.php?sid='.$sid.'&action=show_magic_info&spell='.$itf['on_take'].'&npc='.$_GET['npc'].'&start='.$_GET['start'].'&start2='.$_GET['start2'].'">?</a></small><br/>';
  $f .= 'вес: '.$itf['weight'].'<br/>';
  $f .= 'цена: '.$itf['price'].'<br/>';
  $if = str_replace ('.', '_', $itf['realname']); 
  if (file_exists ('modules/info/items/i_'.$if.'.txt'))
  {
    $f .= file_get_contents ('modules/info/items/i_'.$if.'.txt');
    $f .= '<br/>';
  }
  $f .= '<a class="y" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a><br/>';
  if (isset ($_GET['npc']))
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$_GET['npc'].'&start2='.$_GET['start2'].'&start='.$_GET['start'].'">торг</a><br/>';
  }
  if (isset ($_GET['type']))
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=market&type='.$_GET['type'].'&start='.$_GET['start'].'">назад</a><br/>';
  }
  $f .= '<a class="y" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>