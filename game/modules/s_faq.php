<?php
  // FAQ:
  $show = 5;
  $faq[] = array ('prilavki', 'что такое прилавки?');
  $faq[] = array ('clan', 'как создать свой клан?');
  $faq[] = array ('stats', 'немогу прокачать статы (нет знака +)');
  $faq[] = array ('stats2', 'как и на что влияют основные параметры?');
  $faq[] = array ('jewels', 'на что влияют украшения?');
  $f = gen_header ('FAQ');
  $f .= '<div class="y" id="aeifa5f"><b>FAQ:</b></div>';
  if (isset ($_GET['faq']))
  {
    $num = preg_replace ('/[^0-9]/', '', $_GET['faq']);
    if ($num === false) put_error ('O_o');
    if (!isset ($faq[$num])) put_error ('X_x');
    $f .= '<div class="y" id="aeifa5f"><b>'.$faq[$num][1].'</b></div>';
    $f .= '<div class="n" id="ssad5f">';
    if (file_exists ('modules/library/faq_'.$faq[$num][0].'.txt')) $f .= file_get_contents ('modules/library/faq_'.$faq[$num][0].'.txt');
    $f .= '</div>';
  }
    $c = count ($faq);
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
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=faq&start='.$start.'&faq='.$i.'">'.$faq[$i][1].'</a><br/>';
    }
    // teperq md'shnye ssylki dlja prosmotra
    $nw = floor ($c / $show);
    for ($i = 0; $i <= $nw; $i++)
    {
      if ($i * $show == $start) $f .= ($i + 1).' : ';
      else if ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=faq&start='.($i * $show).'">'.($i + 1).'</a> : ';
    }
    $f .= '<span class="gray">('.$c.')</span></div>';

  $f .= '<div class="n" id="adi45f">';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a><br />';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a><br />';
  $f .= '</div>';
  $f .= gen_footer ();
  exit ($f);
?>