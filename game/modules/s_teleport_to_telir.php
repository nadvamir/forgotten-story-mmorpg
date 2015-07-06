<?php
  $q = do_mysql ("SELECT belongs FROM castle WHERE name = 'telir';");
  $bel = mysql_result ($q, 0);
  $HASTELIR = 0;
  if ($bel == $p['clan'][0]) $HASTELIR = 1;

  if ($HASTELIR)
  {
    include_once ('modules/f_teleport.php');
    teleport ($LOGIN, 'telc|3x2');
  }
  else put_g_error ('castleless вон отсюда!!!');
?>