<?php
  // funkcija proverjaet, mertv li etot kto dan :)
  // esli mertv vozvratit 1. zhiv 0;
  function check_dead ($who)
  {
    //$who = preg_replace ('/[^a-z\._0-9]/i', '', $who);
    $id = is_player($who);
    if ($id)
      $q = do_mysql ("SELECT life FROM players WHERE id_player = '".$id."';");
    else
      $q = do_mysql ("SELECT life FROM npc WHERE id_npc = '".(is_npc ($who))."';");

    if (!mysql_num_rows ($q)) return 0;
    $life = mysql_result ($q, 0);
    $life = explode ('|', $life);
    if (!$life[0]) return 1;
    else return 0;
  }
?>