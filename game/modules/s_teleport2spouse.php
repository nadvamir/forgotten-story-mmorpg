<?php
  if ($p['marry'])
  {
    $id = is_player ($p['marry']);
    $q = do_mysql ("SELECT location FROM players WHERe id_player = '".$id."' AND active = 1;");
    if (!mysql_num_rows ($q)) put_g_error ('вторая половинка не в сети');
    $loc = mysql_result ($q, 0);
    include_once ('modules/f_teleport.php');
    teleport ($LOGIN, $loc);
  }
  else put_g_error ('холостые вон отсюда!!!');
?>