<?php
  // funkcija proverki, estq li reagenty:
  function check_reagents ($spell, $login)
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
    // funkcija kotoroj proverim:
    include_once ('modules/f_has_misc_count.php');
    $c = count ($rea);
    $has = 1;

    for ($i = 0; $i < $c; $i++)
    {
      $rea[$i] = explode(':', $rea[$i]);
      // esli menqshe - 0
      if (has_misc_count ($rea[$i][0], $rea[$i][1], $login) < 1) $has = 0;
    }
    return $has;
  }
?>