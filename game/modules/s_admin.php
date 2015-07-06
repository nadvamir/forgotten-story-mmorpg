<?php
  // adminskaja:
  if ($p['admin'] > 1)
  {
    $f = gen_header ('админская');
    $f .= '<div class="y" id="admin"><b>ад<u>МИНСК</u>ая:</b></div><p>';

    // funkcii igry
    $f .= '<b>ИГРА:</b><br/>';
    // ochistitq kartu
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=a_add_gold">добавить золота</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=clear_map">очистить карту</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=open_game">открыть доступ</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=close_game_m">закрыть доступ</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=close_game_a">закрыть доступ всем</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=a_gain_item">получить вешь</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=a_gain_silver">получить серебра</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=a_create_clan">создать клан</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=a_letter">сменить букву</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=a_teleport">телепорт</a><br/>';

    // rabota s forumom
    $f .= '<b>ФОРУМ:</b><br/>';
    // sozdatq novyj forum:
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=add_forum1">новый форум</a><br/>';

    // rabota s novostjami
    $f .= '<b>НОВОСТИ:</b><br/>';
    // sozdatq novuju novostq:
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=add_new1">новая новость</a><br/>';

    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
    $f .= '</p>';
    $f .= gen_footer();
    exit ($f);
  }
?>