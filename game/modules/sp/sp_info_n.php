<?php
  // informacija npc
  $f = gen_header ('инфо');
  $f .= '<div class="y" id="oaiyt">';
  $qitf = do_mysql ("SELECT * FROM npc WHERE fullname = '".$to."';");
  $npci = mysql_fetch_assoc ($qitf);
  $f .= '<b>'.$npci['name'].'</b></div><p>';
  // tip
  if ($npci['type'] == 'a') $f .= '<small>мирный нпц</small><br/>';
  if ($npci['type'] == 'x') $f .= '<small>агрессивный нпц</small><br/>';
  if ($npci['type'] == 's') $f .= '<small>говорящий нпц</small><br/>';
  if ($npci['type'] == 't') $f .= '<small>торговец</small><br/>';
  // prinadlezhit
  if ($npci['belongs'])
  {
    $q = do_mysql ("SELECT name FROM players WHERE login = '".$npci['belongs']."';");
    if (mysql_num_rows ($q))
    {
      $name = mysql_result ($q, 0);
      $f .= 'принадлежит <b>'.$name.'</b><br/>';
    }
  }
    $f .= '<b>характеристика:</b><br/>';
    $f .= 'сила: '.$npci['str'].'<br/>';
    $f .= 'ловкость: '.$npci['dex'].'<br/>';
    $f .= 'интеллект: '.$npci['int'].'<br/>';
    $f .= 'реакция: '.$npci['rea'].'<br/>';
    $f .= 'навыки: '.$npci['other'].'<br/>';
    $f .= '<b>уровень:</b> '.$npci['lvl'].'<br/>';
    $f .= 'рейтинг забивания монстров: '.$npci['monsterkill'].'<br/>';
    $f .= 'рейтинг забивания игроков: '.$npci['playerkill'].'<br/>';
    $f .= '<b>урон:</b><br/>';
    $npci['dmg'] = explode ('~', $npci['dmg']);
    $f .= 'рез: '.$npci['dmg'][0].'<br/>';
    $f .= 'кол: '.$npci['dmg'][1].'<br/>';
    $f .= 'дроб: '.$npci['dmg'][2].'<br/>';
    $f .= 'руб: '.$npci['dmg'][3].'<br/>';
    $f .= 'маг: '.$npci['dmg'][4].'<br/>';
    $f .= '<b>броня:</b><br/>';
    $npci['armor'] = explode ('~', $npci['armor']);
    $f .= 'рез: '.$npci['armor'][0].'<br/>';
    $f .= 'кол: '.$npci['armor'][1].'<br/>';
    $f .= 'дроб: '.$npci['armor'][2].'<br/>';
    $f .= 'руб: '.$npci['armor'][3].'<br/>';
    $f .= 'маг: '.$npci['armor'][4].'<br/>';
  $f .= '<a class="y" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>