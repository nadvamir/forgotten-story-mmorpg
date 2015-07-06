<?php
  // fail pokazyvaet harakteristiki veshi
  $npc = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['npc']);
  $item = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['item']);
  include_once ('modules/f_trade_param.php');
  $param = trade_param ($item);
  $f = gen_header ('Инфо');
  $f .= '<div class="y" id="odita"><b>'.$param[0].'</b></div><p>';
  if (substr ($item, 2, 1) == 'f')
  {
    if (substr ($item, 4, 3) == 'foo') $f .= 'еда<br/>';
    if (substr ($item, 4, 3) == 'dri') $f .= 'напиток<br/>';
    $param[4] = explode ('~', $param[4]);
    $f .= '+'.$param[4][0].' к жизни<br/>';
    $f .= '+'.$param[4][1].' к мане<br/>';
    if ($param[4][2]) $f .= 'останавлевает кровотечение<br/>';
    if ($param[4][3]) $f .= 'противоядие<br/>';
    if ($param[4][4]) $f .= 'останавливает горение<br/>';
  }
  if (substr ($item, 2, 1) == 'w')
  {
    if (substr ($item, 4, 3) == 'swo') $f .= 'меч<br/>';
    if (substr ($item, 4, 3) == 'axe') $f .= 'топор<br/>';
    if (substr ($item, 4, 3) == 'ham') $f .= 'молот<br/>';
    if (substr ($item, 4, 3) == 'spe') $f .= 'копье<br/>';
    if (substr ($item, 4, 3) == 'bow') $f .= 'лук<br/>';
    if (substr ($item, 4, 3) == 'arb') $f .= 'арболет<br/>';
    if (substr ($item, 4, 3) == 'kni') $f .= 'нож<br/>';
    if (substr ($item, 4, 3) == 'kli') $f .= 'клинок<br/>';
    if (substr ($item, 4, 3) == 'tre') $f .= 'древковое<br/>';
    $pos = strpos ($item, '.2h.');
    if ($pos === false) $f .= 'одноручное<br/>';
    else $f .= 'двуручное<br/>';
    ///////
    $f .= 'оружие<br/>';
    $dmg = explode ('~', $param[7]);
    $f .= '<b>базовый урон:</b> <br/>';
    $f .= 'режущий: '.$dmg[0].'<br/>';
    $f .= 'колющий: '.$dmg[1].'<br/>';
    $f .= 'дробящий: '.$dmg[2].'<br/>';
    $f .= 'рубящий: '.$dmg[3].'<br/>';
    $f .= 'магический: '.$dmg[4].'<br/>';
    $f .= 'c~л~и~р~навык: '.$param[3].'<br/>';

    if (substr ($param[1], 4, 3) == 'tre')
    {
      $pl = $param[4];
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
  }
  if (substr ($item, 2, 1) == 'a')
  {
    if (substr ($item, 4, 3) == 'hea') $f .= 'шлем<br/>';
    if (substr ($item, 4, 3) == 'bo1') $f .= 'броня<br/>';
    if (substr ($item, 4, 3) == 'bo2') $f .= 'рубаха<br/>';
    if (substr ($item, 4, 3) == 'sho') $f .= 'наплечники<br/>';
    if (substr ($item, 4, 3) == 'glo') $f .= 'перчатки<br/>';
    if (substr ($item, 4, 3) == 'bel') $f .= 'пояс<br/>';
    if (substr ($item, 4, 3) == 'leg') $f .= 'штаны<br/>';
    if (substr ($item, 4, 3) == 'pon') $f .= 'поножи<br/>';
    if (substr ($item, 4, 3) == 'bot') $f .= 'ботинки<br/>';
    if (substr ($item, 4, 3) == 'amu') $f .= 'амулет<br/>';
    if (substr ($item, 4, 3) == 'rin') $f .= 'кольцо<br/>';
    ///////
    $f .= 'броня<br/>';
    $arm = explode ('~', $param[8]);
    $f .= '<b>защита:</b> <br/>';
    $f .= 'режущий: '.$arm[0].'<br/>';
    $f .= 'дробяший: '.$arm[1].'<br/>';
    $f .= 'колющий: '.$arm[2].'<br/>';
    $f .= 'рубящий: '.$arm[3].'<br/>';
    $f .= 'магический: '.$arm[4].'<br/>';
    $f .= 'c~л~и~р: '.$param[3].'<br/>';
    if (substr ($item, 4, 3) == 'rin' || substr ($item, 4, 3) == 'amu') $f .= '+(с~л~и~р): '.$param[4].'<br/>';
    if (substr ($item, 4, 3) == 'bel') $f .= 'слоты: '.$param[5].'<br/>';
  }
  if (substr ($item, 2, 1) == 'b')
  {
    $f .= '<small>книга</small><br/>';
    $f .= '<b>заклинания:</b><br/>';
    $param[3] = explode ('~', $param[3]);
    $c = count ($param[3]);
    for ($i = 0; $i < $c; $i++)
    {
      $q = do_mysql ("SELECT name FROM magic WHERE fullname = '".$param[3][$i]."';");
      $name = mysql_result ($q, 0);
      if (!$name) put_error ('netu zaklinanija takogo');
      $f .= '-<small>'.$name.' <a class="blue" href="game.php?sid='.$sid.'&action=show_magic_info&spell='.$param[3][$i].'">?</a></small><br/>';
    }
  }
  if (substr ($item, 2, 1) == 'm') $f .= 'мелкая вешь<br/>';
  if (substr ($item, 2, 1) == 'q') $f .= 'квестовая вешь<br/>';
  if (substr ($item, 2, 1) == 's')
  {
    $f .= '<small>свиток</small><br/>';
    $f .= '<b>заклинания:</b><br/>';
    $q = do_mysql ("SELECT name FROM magic WHERE fullname = '".$param[3]."';");
    $name = mysql_result ($q, 0);
    if (!$name) put_error ('netu zaklinanija takogo');
    $f .= '-<small>'.$name.' <a class="blue" href="game.php?sid='.$sid.'&action=show_magic_info&spell='.$param[3].'&npc='.$_GET['npc'].'&start='.$_GET['start'].'&start2='.$_GET['start2'].'">?</a></small><br/>';
  }
  if (substr ($item, 2, 1) == 'x')
  {
    $f .= 'щит<br/>';
    $arm = explode ('~', $param[8]);
    $f .= '<b>защита:</b> <br/>';
    $f .= 'режущий: '.$arm[0].'<br/>';
    $f .= 'колющий: '.$arm[1].'<br/>';
    $f .= 'дробящий: '.$arm[2].'<br/>';
    $f .= 'рубящий: '.$arm[3].'<br/>';
    $f .= 'c~л~и~р: '.$param[3].'<br/>';
  }
  $f .= 'вес: '.$param[11].'<br/>';
  $f .= 'цена: '.$param[6].'<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$npc.'&start='.$_GET['start'].'&start2='.$_GET['start2'].'">торг</a><br/>';
  $f .= '<a class="y" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>