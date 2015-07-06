<?php
  // pokazyvaet kvest log
  //////////////////////////////////
  // osnovnye kvesty ///////////////
  //////////////////////////////////
  if ($p['rase'] == '1')
  {
    $MQ[0] = 'ПРОЛОГ: По разбитой дороге';
    $MQ[1] = 'ГЛАВА I: Ночьной странник';
    $MQ[2] = 'ГЛАВА II: Наследие Прошлого';
    $MQ[3] = 'ГЛАВА III: Ясней не стало';
    $MQ[4] = 'ГЛАВА IV: Культ Солнца в нашей крови...';
  }
  
  //////////////////////////////////
  // chasti: ///////////////////////
  // kogda okonchen -
  $SMQ[0] = 7;
  $SMQ[1] = 5;
  $SMQ[2] = 8;
  $SMQ[3] = 1;
  $SMQ[4] = 4;
  if ($p['qlvl']) $SMQ[5] = 2;
  else $SMQ[5] = 3;
  $SMQ[6] = 7;
  $SMQ[7] = 5;
  $SMQ[8] = 7;
  $SMQ[9] = 2;
  $SMQ[10] = 9;
  $T = array();
  //////////////////////////////////
  // kogda nado pokazyvatq s nulja -
  $NUL[1000] = 0;
  if ($p['rase'] == 1)
  {
    if (!$p['classof'])
    {
      $NUL[0] = 1; $NUL[1] = 1; $NUL[2] = 1;
      $NUL[3] = 1;
    }
    else
    {
      $SMQ[0] = 0;
      $SMQ[1] = 0;
      $SMQ[2] = 0;
    }
  }
  if ($p['qlvl'] && $p['gender'] == 'male') $NUL[6] = 1;
  $NUL[4] = 0;
  // esli nashli svechku, pokazatq kvest
  include_once ('modules/f_has_count.php');
  if (has_count ('i.q.que.sferovidnaja_svechka', 1, $LOGIN))
    $NUL[9] = 0;
  //////////////////////////////////
  //$f = '<div class="y" id="afadfg"><b>Активные Квесты</b></div>';
  //$f .= '<div class="n" id="aoeyg">';
  $f = '';
  //////////////////////////////////
  // pokazyvaem esli chtoto zaproshenno
  if (!isset ($_GET['q'])) $qn = 0;
  else $qn = preg_replace ('/[^0-9]/', '', $_GET['q']);
  if (!$qn) $qn = 0; // esli pusto ili nolq - nolq
  if (isset ($_GET['w']) && $_GET['w'] == 'mq')
  {
    include 'modules/mainq/'.$p['rase'].'_'.$qn.'.php';
    $f .= '<div class="y" id="aiv1"><b>'.$CH.'</b></div>';
    $f .= '<div class="y" id="aiv2"><b>'.$H.'</b></div>';
    $f .= '<div class="n" id="aiv3">'.$QT.'</div>';
  }
  if (isset ($_GET['w']) && $_GET['w'] == 'smq' && ($p['smq'][$qn] || isset ($NUL[$qn])) && $p['smq'][$qn] < $SMQ[$qn])
  {
    include 'modules/mainq/s_'.$qn.'.php';
    $f .= '<div class="y" id="aiv2"><b>'.$H.'</b></div>';
    $f .= '<div class="n" id="aiv3">'.$T[$p['smq'][$qn]].'</div>';
  }

  // glavnyj
  include 'modules/mainq/'.$p['rase'].'_'.$p['qlvl'].'.php';
  $f .= '<b>'.$CH.'</b><br/>';
  $f .= '<a class="rar" href="game.php?sid='.$sid.'&action=show_quest_log&w=mq&q='.$p['qlvl'].'">'.$H.'</a><br/>';
  // drugie
  $f .= '<b>Активные</b><br/>';
  for ($i = 0; $i < 50; $i++)
  {
    if (($p['smq'][$i] || isset ($NUL[$i])) && $p['smq'][$i] < $SMQ[$i])
    {
      include 'modules/mainq/s_'.$i.'.php';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=show_quest_log&w=smq&q='.$i.'">'.$H.'</a><br/>';
    }
  }

  exit_msg ('Квесты', $f);
?>