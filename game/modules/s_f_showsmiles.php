<?php
  // pokaz vseh smajlov:
  // podkljuchim masiv smailov
  do_mysql ("INSERT INTO fonline VALUES ('".$LOGIN."', 'просмотр смайлов', NOW());");
  require ('smile/s_smile.php');
  // kolichestvo dlja pokaza
  $show = 5;
  // nachjalo
  if (!isset ($_GET['start']))
    $start = 0;
  else
    $start = htmlspecialchars($_GET['start']);

  // kolichestvo smailov
  $c = count($sa);
  // start nemozhet bytq bolqshe chem $c
  if ($start > $c)
  {
    $start = $c - $show;
  }
  // start nemozhet bytq menqshe 0
  if ($start < 0)
  {
    $start = 0;
  }
  $to = $start + $show;
  if ($to > $c) $to = $c;
  //--------------
  // nachjalo starnicy
  $f = gen_header ('смайлики:)');
  $f .= '<div class="y" id="ldsf"><b>смайлики</b> :) '.$start.' - '.$to.' из '.$c.'</div><p>';
  //-----------
  // pokaz smailov
  for ($i = $start; $i < $to; $i++)
  {
    $f .= $sb[$i].' -- '.$sa[$i].'<br/>';
  }

  $nw = floor ($c / $show);
  for ($i = 0; $i <= $nw; $i++)
  {
    if ($i * $show == $start) $f .= ($i + 1).' : ';
    elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showsmiles&start='.($i * $show).'">'.($i + 1).'</a> : ';
  }
  $f .= '<span class="gray">('.$c.')</span>';
  $f .= '<br/>';

  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum">форум</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer ();
  exit ($f);
?>