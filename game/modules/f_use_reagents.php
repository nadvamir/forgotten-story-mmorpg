<?php
  // ispolqzovatq reagenty:
  function use_reagents ($spell, $login)
  {
    //$spell = preg_replace ('/[^a-z0-9_]/i', '', $spell);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);
    if (!is_player ($login)) return 0;

    // spisok reagentov:
    $q = do_mysql ("SELECT reagents FROM magic WHERE fullname = '".$spell."';");
    if (!mysql_num_rows ($q)) return 0;
    $rea = mysql_result ($q, 0);
    if (!$rea) return 1;
    $rea = explode ('|', $rea);
    // funkcija kotoroj udalim:
    include_once ('modules/f_decr_abstr_misc.php');
    $c = count ($rea);

    for ($i = 0; $i < $c; $i++)
    {
      $rea[$i] = explode(':', $rea[$i]);
      decr_abstr_misc ($rea[$i][0], $login, $rea[$i][1]);
    }

    return 1;
  }
?>