<?php
  // funkcija povyshaet glavnyj kvest
  function next_q ()
  {
    global $p;
    do_mysql ("UPDATE players SET qlvl = qlvl + 1 WHERE id_player = '".$p['id_player']."';");
    $q = do_mysql ("SELECT qlvl FROM players WHERE id_player = '".$p['id_player']."';");
    $qlvl = mysql_result ($q, 0);
    // podkljuchaem fail novogo kvesta : 
    include 'modules/mainq/q_'.$qlvl.'.php';
  }
?>