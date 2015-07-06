<?php
  if (!isset ($f))
    $f = '';
  if (substr ($item, 4, 3) == 'mag')
  {
    // ispolqzovatq knigu magii
    // znachit vyvedem spisok zaklinanij
    $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$item."';");
    if (!mysql_num_rows ($q)) put_error ('netu etoj knigi');
    $spells = mysql_result ($q, 0);
    $spells = explode ('~', $spells);

    $f .= 'заклинания: <br/>';
    $c = count ($spells);
    for ($i = 0; $i < $c; $i++)
    {
      if (!$spells[$i]) continue;
      $q = do_mysql ("SELECT name FROM magic WHERE fullname = '".$spells[$i]."';");
      if (!mysql_num_rows ($q)) put_error ('netu takogo zakla');
      $name = mysql_result ($q, 0);
      $f .= ''.($i + 1).'. <a class="blue" href="game.php?sid='.$sid.'&action=cast_from_book&spell='.$spells[$i].'&book='.$item.'">';
      $f .= $name.'</a> <a class="blue" href="game.php?sid='.$sid.'&action=show_magic_info&spell='.$spells[$i].'">?</a><br/>';
    }

    $f .= '<br/>';
  }
  else
  {
    include_once ('modules/f_real_name.php');
    $rn = real_name ($item);
    $add = str_replace ('.', '_', $rn);
    include 'modules/books/b_'.$add.'.php';
    $f .= $book.'<br/>';
  }
?>