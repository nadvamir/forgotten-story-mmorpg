<?php
  // mir igry
  $f = gen_header ('мир игры');
  // osnovnaja
  $f .= '<div class="y" id="osnovn1">';
  $f .= '<b>мир игры:</b></div><div class="n" id="a0376g">';
  $q = mysql_query ("SELECT puttime FROM news ORDER BY puttime DESC;", $dbcnx);
  if (mysql_num_rows ($q))
  {
    $pt = mysql_result ($q, 0);
    //$pt = substr ($pt, 0, 10);
    $f .= 'Hовости от <a class="black" href="game.php?sid='.$sid.'&action=news">'.$pt.'</a><br/>';
  }
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_rules">';
  $f .= 'правила</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings">';
  $f .= 'рейтинги</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=clanlist">';
  $f .= 'кланы</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=castlelist">';
  $f .= 'замки</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=mir_magic">';
  $f .= 'магия</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=handler_set">';
  $f .= 'настройки</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=anketa">';
  $f .= 'анкета</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=avatar">';
  $f .= 'выбрать аватар</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=faq">';
  $f .= 'FAQ</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=library">';
  $f .= 'библиотека</a><br/>';
  $f .= '</div>';
  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a></p>';
  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>