<?php
  $f .= '<div class="y" id="auto53">';
  $f .= '<a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=locmode&set=0">-</a>';
  $f .= '<b>путь:</b></div><p>';
  // pereberem vse vozmozhnye
  $stl = strlen ($loc[0][4]);
  for ($i = 0; $i < $stl; $i++)
  {
    // storona perehoda
    switch ($loc[0][4][$i])
    {
      case 1: $st = 'сз'; break;
      case 2: $st = 'с'; break;
      case 3: $st = 'св'; break;
      case 4: $st = 'з'; break;
      case 5: $st = 'в'; break;
      case 6: $st = 'юз'; break;
      case 7: $st = 'ю'; break;
      case 8: $st = 'юв'; break;
    }
    // proverka, estq li tam ktoto
    $inloc = get_inloc ($loc[$loc[0][4][$i]][0]);
    if (!$inloc) $color = 'blue';
    else
    {
      $inloc = explode ('|', $inloc);
      $ci = count ($inloc)
      for ($b = 0; $b < $ci; $b++)
      {
        $sub = substr($inloc[$b], 0, 2);
        if ($sub == 'n.' || $sub != 'i.' && $sub != 'd.')
        {
          $color = 'red';
          break;
        }
      }
      if (!$color) $color = 'red';
    }
    $f .= '<a class="'.$color.'" href="game.php?sid='.$sid.'&action=go_to_loc&loc_go='.$loc[$loc[0][4][$i][0].'&stor='.$loc[0][4][$i].'">';
    $f .= $st.'</a>';
    $f .= ' - '.$loc[$loc[0][4][$i]][2].'<br/>';
  }
?>