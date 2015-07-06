<?php
  // prosmotr magii kotoruju imeem:
  $q = do_mysql ("SELECT magic FROM players WHERE id_player = '".$p['id_player']."';");
  $magic = mysql_result ($q, 0);
  $f = gen_header ('магия');
  $f .= '<div class="y" id="mag"><b>магия</b></div><p>';
  $show = 10;

  // esli magija imeetsja
  if ($magic)
  {
    $magic = explode ('|', $magic);
    $c = count ($magic);

    // start
    if (!isset ($_GET['start'])) $start = 0;
    else $start = $_GET['start'];
    if ($start >= $c) $start = $c - $show;
    if ($start < 0) $start = 0;
    for ($i = $start; $i < $start + $show; $i++)
    {
      if (!isset ($magic[$i]) || !$magic[$i]) continue;
      $q = do_mysql ("SELECT name, type FROM magic WHERE fullname = '".$magic[$i]."';");
      $name = mysql_fetch_assoc ($q);
      if ($name['type'] == 'war' || $name['type'] == 'hea') $f .= ($i + 1).'. <a class="blue" href="game.php?sid='.$sid.'&action=target_magic&spell='.$magic[$i].'">'.$name['name'].'</a>';
      else $f .= ($i + 1).'. <a class="blue" href="game.php?sid='.$sid.'&action=cast_from_head&spell='.$magic[$i].'&to='.$LOGIN.'">'.$name['name'].'</a>';
      $f .= ' <a class="blue" href="game.php?sid='.$sid.'&action=show_magic_info&spell='.$magic[$i].'">?</a>';
      $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=forget_magic&spell='.$magic[$i].'">x</a><br/>';
    }
    // teperq md'shnye ssylki dlja prosmotra
    $nw = floor ($c / $show);
    for ($i = 0; $i <= $nw; $i++)
    {
      if ($i * $show == $start) $f .= ($i + 1).' : ';
      elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=show_magic&start='.($i * $show).'">'.($i + 1).'</a> : ';
    }
    $f .= '<span class="gray">('.$c.')</span>';
    $f .= '</p>';
  }
  else
  {
    $f .= 'вы неумеете ниодного заклинания!</p>';
  }

  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>