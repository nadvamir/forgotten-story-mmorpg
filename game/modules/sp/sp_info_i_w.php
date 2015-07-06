<?php
  // infa oruzhija
  $f = gen_header ('инфо');
  $f .= '<div class="y" id="oaiyt">';
  $qitf = do_mysql ("SELECT * FROM items WHERE fullname = '".$to."';");
  $itf = mysql_fetch_assoc ($qitf);
  $qua = substr ($to, 8, 3);
  $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
  if (strpos ($qlist, $qua) === false) $qua = 'black';
  $f .= '<b><span class="'.$qua.'">'.$itf['name'].'</span></b></div><p>';
  if (substr ($to, 4, 3) == 'swo') $f .= 'меч<br/>';
  if (substr ($to, 4, 3) == 'axe') $f .= 'топор<br/>';
  if (substr ($to, 4, 3) == 'ham') $f .= 'молот<br/>';
  if (substr ($to, 4, 3) == 'spe') $f .= 'копье<br/>';
  if (substr ($to, 4, 3) == 'bow') $f .= 'лук<br/>';
  if (substr ($to, 4, 3) == 'arb') $f .= 'арболет<br/>';
  if (substr ($to, 4, 3) == 'kni') $f .= 'нож<br/>';
  if (substr ($to, 4, 3) == 'kli') $f .= 'клинок<br/>';
  if (substr ($to, 4, 3) == 'tre') $f .= 'древковое<br/>';

  $pos = strpos ($itf['fullname'], '.2h.');
  if ($pos === false) $f .= 'одноручное<br/>';
  else $f .= 'двуручное<br/>';
  ///////
  $f .= 'оружие<br/>';
  $dmg = explode ('~', $itf['dmg']);
  $f .= '<b>базовый урон:</b> <br/>';
  $f .= 'режущий: '.$dmg[0].'<br/>';
  $f .= 'колюший: '.$dmg[1].'<br/>';
  $f .= 'дробяший: '.$dmg[2].'<br/>';
  $f .= 'рубящий: '.$dmg[3].'<br/>';
  $f .= 'магический: '.$dmg[4].'<br/>';
  $f .= 'c~л~и~р~навык: '.$itf['on_take'].'<br/>';
  // esli estq effekt - 
  if ($itf['on_drop'])
  {
    include_once ('modules/f_translit.php');
    $f .= 'наложен эффект: <b>'.(translit ($itf['on_drop'])).'</b><br/>';
  }
  if (substr ($itf['fullname'], 4, 3) == 'tre')
  {
    $pl = $itf['on_use'];
    if ($pl)
    {
      $pl = explode (':', $pl);
      $c = count ($pl);
      for ($i = 0; $i < $c; $i++)
      {
        $pl[$i] = explode ('~', $pl[$i]);
        $f .= '+'.$pl[$i][1].'% ';
        switch ($pl[$i][0])
        {
          case 0: $f .= 'всем магиям<br/>'; break;
          case 1: $f .= 'магии Огня<br/>'; break;
          case 2: $f .= 'магии Воды<br/>'; break;
          case 3: $f .= 'магии Земли<br/>'; break;
          case 4: $f .= 'магии Воздуха<br/>'; break;
          case 5: $f .= 'магии Иллюзии<br/>'; break;
          case 6: $f .= 'Подземной магии<br/>'; break;
          case 7: $f .= 'Элфийской магии Природы<br/>'; break;
          case 8: $f .= 'Древнеэльфийской магии Могущественных<br/>'; break;
        }
      }
    }
  }
  $f .= 'вес: '.$itf['weight'].'<br/>';
  $f .= 'цена: '.$itf['price'].'<br/>';
  $f .= 'целостность: '.$itf['str'].'<br/>';
  if ($itf['jewel'])
  {
    include_once ('modules/f_translit.php');
    $f .= 'инкрустирован '.(translit ($itf['jewel'])).'<br/>';
  }
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