<?php
  // moderatorskaja:
  if ($p['admin'] > 0)
  {
    $f = gen_header ('модераторская');
    $f .= '<div class="y" id="yrk"><b>МОдераТОРская</b></div><p>';

    // funkcii foruma
    // ban
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=ban">покарать</a><br/>';
    // v bane
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=show_ban">баня</a><br/>';
    // v bloke
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=show_block">блок</a><br/>';
    // v polnom bloke
    if ($p['admin'] > 1) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=show_a_block">полный блок</a><br/>';

    // sozdatq magiju
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=generate_magic">генератор магии</a><br/>';
    // prosmotretq sozdannoe
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=show_new_magic">просмотреть новосозданную магию</a><br/>';
    

    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=forum">форум</a><br/>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a><br/>';
    $f .= '</p>';
    $f .= gen_footer();
    exit ($f);
  }
?>