<?php
  // lib:
  $show = 5;
  $lib[] = array ('stats', 'немогу прокачать статы (нет знака +) (test)');
  $f = gen_header ('библиотека');
  $f .= '<div class="y" id="aeifa5f"><b>библиотека:</b></div>';
  if (isset ($_GET['lib']))
  {
    $num = preg_replace ('/[^0-9]/', '', $_GET['lib']);
    if ($num === false) put_error ('O_o');
    if (!isset ($lib[$num])) put_error ('X_x');
    $f .= '<div class="y" id="aeifa5f"><b>'.$lib[$num][1].'</b></div>';
    $f .= '<div class="n" id="ssad5f">';
    if (file_exists ('modules/library/lib_'.$lib[$num][0].'.txt')) $f .= file_get_contents ('modules/library/lib_'.$lib[$num][0].'.txt');
    $f .= '</div>';
  }
    $c = count ($lib);
    if (!isset ($_GET['start'])) $start = 0;
    else $start = preg_replace ('/[^0-9]/', '', $_GET['start']);
    if ($start > $c)
    {
      $start = floor ($c / $show);
      $start *= $show;
      if ($start == $c) $start -= $show;
    }
    $to = $start + $show;
    if ($to > $c) $to = $c;
    if ($start < 0) $start = 0;
    $f .= '<div class="n" id="ad5f">';
    for ($i = 0; $i < $to; $i++)
    {
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=library&start='.$start.'&lib='.$i.'">'.$lib[$i][1].'</a><br/>';
    }
    // teperq md'shnye ssylki dlja prosmotra
    $nw = floor ($c / $show);
    for ($i = 0; $i <= $nw; $i++)
    {
      if ($i * $show == $start) $f .= ($i + 1).' : ';
      else if ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=library&start='.($i * $show).'">'.($i + 1).'</a> : ';
    }
    $f .= '<span class="gray">('.$c.')</span></div>';

  $f .= '<div class="n" id="adi45f">';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a><br />';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a><br />';
  $f .= '</div>';
  $f .= gen_footer ();
  exit ($f);
?>