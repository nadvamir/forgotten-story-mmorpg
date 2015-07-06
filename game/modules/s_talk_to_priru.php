<?php
  // razgovarivatq s priruchennym
  $npc = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['npc']);
  if (!$npc) put_error ('where is animal taklk to');
  if (isset($_GET['part'])) $part = preg_replace ('/[^a-z0-9_]/i', '', $_GET['part']);
  else $part = '';
  $nid = is_npc ($npc);
  $nn = do_mysql ("SELECT * FROM npc WHERE id_npc = '".$nid."';");
  $nn = mysql_fetch_assoc ($nn);
  if ($nn['belongs'] != $LOGIN) put_error ('это не ваш нпц');
  if ($nn['location'] != $p['location']) put_g_error ('рядом с вами нету этого нпц');
  $f = gen_header ($nn['name']);
  $f .= '<div class="y" href="aof"><b>'.$nn['name'].'</b></div><p>';
  if (!$part)
  {
    $f .= '» <a class="blue" href="game.php?sid='.$sid.'&action=talk_to_priru&part=har&npc='.$npc.'">';
    $f .= 'просмотреть информацию</a><br/>';
    $f .= '» <a class="blue" href="game.php?sid='.$sid.'&action=talk_to_priru&part=name1&npc='.$npc.'">';
    $f .= 'дать кличку</a><br/>';
    if ($nn['move'] != 0) $f .= '» <a class="blue" href="game.php?sid='.$sid.'&action=talk_to_priru&part=stay&npc='.$npc.'">стой тут!</a><br/>';
    else $f .= '» <a class="blue" href="game.php?sid='.$sid.'&action=talk_to_priru&part=stay&npc='.$npc.'">иди за мной!</a><br/>';
    $f .= '» <a class="blue" href="game.php?sid='.$sid.'&action=talk_to_priru&part=sit&npc='.$npc.'">';
    $f .= 'сидеть!</a><br/>';
    $f .= '» <a class="blue" href="game.php?sid='.$sid.'&action=talk_to_priru&part=lay&npc='.$npc.'">';
    $f .= 'лежать!</a><br/>';
    $f .= '» <a class="blue" href="game.php?sid='.$sid.'&action=talk_to_priru&part=give_hand&npc='.$npc.'">';
    $f .= 'дай лапу!</a><br/>';
    $f .= '» <a class="blue" href="game.php?sid='.$sid.'&action=talk_to_priru&part=go_away&npc='.$npc.'">';
    $f .= 'пшел вон с глаз моих!</a>';
  }
  if ($part == 'name1')
  {
    $f .= '<form action="game.php" method="get">';
    $f .= 'кличка (латынь):<br/>';
    $f .= '<input type="text" name="name"/>';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="npc" value="'.$npc.'"/>';
    $f .= '<input type="hidden" name="action" value="talk_to_priru"/>';
    $f .= '<input type="hidden" name="part" value="name2"/><br/>';
    $f .= '<input type="submit" value="назвать"/></form>';
  }
  if ($part == 'name2')
  {
    $name = preg_replace ('/[^a-z]/i', '', $_GET['name']);
    if (!$name) put_g_error ('как там назвать??');
    $nn['name'] = preg_replace ('/[a-z]/i', '', $nn['name']);
    $nn['name'] .= ' '.$name;
    do_mysql ("UPDATE npc SET name = '".$nn['name']."' WHERE id_npc = '".$nid."';");
    $f .= 'вы назвали своего питомца '.$name.'<br/>';
  }
  else if ($part == 'stay')
  {
    if ($nn['move'] != 0)
    {
      $nn['move'] = 0;
      $f .= $nn['name'].' будет стоять на этом месте';
    }
    else
    {
      $nn['move'] = 30;
      $f .= $nn['name'].' сного пойдет за вами!';
    }
    do_mysql ("UPDATE npc SET move = '".$nn['move']."' WHERE id_npc = '".$nid."';");
  }
  else if ($part == 'sit')
  {
    $f .= $nn['name'].' сел';
    add_journal ('<p>'.$nn['name'].' сел</p>', 'l.'.$p['location'], 0);
  }
  else if ($part == 'lay')
  {
    $f .= $nn['name'].' лег';
    add_journal ('<p>'.$nn['name'].' лег</p>', 'l.'.$p['location'], 0);
  }
  else if ($part == 'give_hand')
  {
    $f .= $nn['name'].' дал вам лапу';
    add_journal ('<p>'.$nn['name'].' дал '.$LOGIN.' лапу</p>', 'l.'.$p['location'], 0);
  }
  else if ($part == 'go_away')
  {
    if (substr ($npc, (strlen($npc) - strlen($LOGIN))) == $LOGIN)
    {
      // prizvannyj
      do_mysql ("DELETE FROM npc WHERE id_npc = '".$nid."';");
      $f .= $nn['name'].' изчез.';
    }
    else
    {
      $nn['name'] = preg_replace ('/[a-z]/', '', $nn['name']);
      do_mysql ("UPDATE npc SET name = '".$nn['name']."', belongs = '0', in_battle = '0' WHERE id_npc = '".$nid."';");
      $f .= $nn['name'].' обиделся и ушел.';
    }
  }
  else if ($part == 'har')
  {
    $f .= '<b>характеристика:</b><br/>';
    $f .= 'сила: '.$nn['str'].'<br/>';
    $f .= 'ловкость: '.$nn['dex'].'<br/>';
    $f .= 'интеллект: '.$nn['int'].'<br/>';
    $f .= 'реакция: '.$nn['rea'].'<br/>';
    $f .= 'навыки: '.$nn['other'].'<br/>';
    $exphas = round ((600 * $nn['lvl'] * $nn['lvl'] + 1000 * $nn['lvl']) / 7);
    $expto = 600 * $nn['lvl'] * $nn['lvl'] + 1000 * $nn['lvl'];
    $f .= 'опыт: '.$nn['exphas'].'/'.$exphas.'<br/>';
    $f .= 'опыт уровня: '.$nn['expto'].'/'.$expto.'<br/>';
    $f .= '<b>уровень:</b> '.$nn['lvl'].'<br/>';
    $f .= 'рейтинг забивания монстров: '.$nn['monsterkill'].'<br/>';
    $f .= 'рейтинг забивания игроков: '.$nn['playerkill'].'<br/>';
    $f .= '<b>урон:</b><br/>';
    $nn['dmg'] = explode ('~', $nn['dmg']);
    $f .= 'рез: '.$nn['dmg'][0].'<br/>';
    $f .= 'кол: '.$nn['dmg'][1].'<br/>';
    $f .= 'дроб: '.$nn['dmg'][2].'<br/>';
    $f .= 'руб: '.$nn['dmg'][3].'<br/>';
    $f .= 'маг: '.$nn['dmg'][4].'<br/>';
    $f .= '<b>броня:</b><br/>';
    $nn['armor'] = explode ('~', $nn['armor']);
    $f .= 'рез: '.$nn['armor'][0].'<br/>';
    $f .= 'кол: '.$nn['armor'][1].'<br/>';
    $f .= 'дроб: '.$nn['armor'][2].'<br/>';
    $f .= 'руб: '.$nn['armor'][3].'<br/>';
    $f .= 'маг: '.$nn['armor'][4].'<br/>';
    
  }
  $f .= '<br/><a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
  $f .= gen_footer();
  exit($f);
?>