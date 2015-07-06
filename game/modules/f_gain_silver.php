<?php
  // funkcija s neba daet serebro
  function gain_silver ($silver, $login)
  {
    $silver = preg_replace('/[^-0-9]/', '', $silver);
    //$login = preg_replace ('/[^a-z0-9_]/', '', $login);
    $id = is_player ($login);
    if (!$id) return 0;

    do_mysql ("UPDATE players SET money = money + '".$silver."' WHERE id_player = '".$id."';");
    if ($silver > -1) add_journal ('серебро +'.$silver, $login);
    else add_journal ('серебро '.$silver, $login);
    //add_journal ('[green]'.$login.' +'.$silver.'[/end]', 'maxx');
    return 1;
  }
?>