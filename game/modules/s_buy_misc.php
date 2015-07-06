<?php
  // ukazatq chislo dlja pokupki melkoj veshi
  $item = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['item']);
  $npc = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['npc']);
  if (substr ($item, 2, 1) != 'm') put_error ('это не мелкая вещь');
  function trade_param ($item)
  {
    $item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
    $cl = substr ($item, 2, 1);
    $tp = substr ($item, 4, 3);
    // podkljuchim
    if ($cl == 'a' || $cl == 'w' || $cl == 'x')
    {
      $else = substr ($item, 12);
      $item2 = 'i.'.$cl.'.'.$tp.'.'.$else;
    }
    else
      $item2 = $item;
    if (!file_exists ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php')) put_error ('<p>trade - нету такого файла для создания веши: modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php</p>');
    include ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php');
    if (!isset($it[$item2])) put_error ('<p>такой веши нету в файлах: '.$item2.'</p>');
    $it[$item2] = explode('|', $it[$item2]);
    return $it[$item2][0];
  }
  $name = trade_param ($item);
  $f = gen_header ('Купить');
  $f .= '<div class="y" id="oaisy"><b>';
  $f .= $name.'</b> (от 0 до '.$MAX_MISC.')</div><div class="n" id="algfadg">';
  $f .= '<form action="game.php" method="get">';
  $f .= 'количество: <br/>';
  $f .= '<input type="text" name="count"/><br/>';
  $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
  $f .= '<input type="hidden" name="action" value="buy_misc2"/>';
  $f .= '<input type="hidden" name="start" value="'.$_GET['start'].'"/>';
  $f .= '<input type="hidden" name="start2" value="'.$_GET['start2'].'"/>';
  $f .= '<input type="hidden" name="item" value="'.$item.'"/>';
  $f .= '<input type="hidden" name="npc" value="'.$npc.'"/>';
  $f .= '<input type="submit" value="купить"/></form>';
  $f .= '<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$npc.'&start='.$_GET['start'].'&start2='.$_GET['start2'].'">торг</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
  $f .= '</div>';
  $f .= gen_footer();
  exit ($f);
?>