<?php
  // pokaz bystryh dejstvij
//ALTER TABLE players ADD `bd` TEXT NULL;
//UPDATE players SET bd = '|||||||||';
  $f = '';
  for ($i = 0; $i < 10; $i++)
  {
    $bd = explode ('~', $p['bd'][$i]);
    if (!$bd[0]) $f .= ($i + 1).': <a class="blue" href="game.php?sid='.$sid.'&action=new_bd&num='.$i.'">пусто</a><br/>';
    else
    {
      $f .= ($i + 1).': ';
      if ($bd[0] == 5 || $bd[0] == 6)
      {
        // dostaem nazvanie magii
        $q = do_mysql ("SELECT name FROM magic WHERE fullname = '".$bd[1]."';");
        $name = mysql_result ($q, 0);
        $f .= $name;
      }
      if ($bd[0] == 7)
      {
        // dostaem nazvanie kombo
        include_once 'modules/sp/sp_kombonames.php'; // nazvanija
        $f .= $kn[$bd[1]];
      }
      if ($bd[0] == 8)
      {
        // nazvanie veshi... esli takoj net, to luchshe udalim eto kombo nafig
        $q = do_mysql ("SELECT name FROM items WHERE realname = '".$bd[1]."' AND belongs = '".$LOGIN."';");
        if (!mysql_num_rows ($q))
        {
          $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=new_bd&num='.$i.'">пусто</a><br/>';
          $p['bd'][$i] = '';
          $nbd = implode ('|', $p['bd']);
          do_mysql ("UPDATE players SET bd = '".$nbd."' WHERE id_player = '".$p['id_player']."';");
          $no = 1;
        }
        else
          $f .= mysql_result ($q, 0);
      }
      if ($bd[0] == 9)
      {
        // dostaem nazvanie kombo
        include_once 'modules/sp/sp_skillnames.php'; // nazvanija
        $f .= $skn[$bd[1]];
      }
      if (!isset ($no)) $f .= ' (<a class="red" href="game.php?sid='.$sid.'&action=del_bd&num='.$i.'">X</a>)<br/>';
    }
  }
  $f .= '<a class="blue" href = "game.php?sid='.$sid.'&action=showinventory">инвентарь</a>';
  exit_msg ('бд', $f);
?>