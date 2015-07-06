<?php
  // funkcija delaet vse, chto mozhet oruzhie sdelatq (effekty)
  // vse, krome krovotechenija
  function set_w_effects ($weapon, $dmg_type, $name)
  {
    //$weapon = preg_replace ('/[^a-z0-9_\.]/', '', $weapon);
    //$name = preg_replace ('/[^a-z0-9_\.]/', '', $name);

    if (!$weapon) return 0;
    $q = do_mysql ("SELECT on_drop FROM items WHERE fullname = '".$weapon."';");
    if (!mysql_num_rows ($q)) put_error ('ner to weapo');
    $effs = mysql_result ($q, 0);
    $effs = explode ('|', $effs);

    $c = count ($effs);
    for ($i = 0; $i < $c; $i++)
    {
      if (rand (0, 100) <= 30)
      {
        include_once ('modules/f_set_affected.php');
        set_affected ($name, $effs[$i]);
      }
    }

    // otdelqnyj razgovor s oglusheniem
    if ($dmg_type == 'drob')
    {
      if (rand (0, 100) <= 30)
      {
        include_once ('modules/f_set_affected.php');
        set_affected ($name, 'oglushen');
      }
    }
    return 1;
  }
?>