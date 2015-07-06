<?php
  // funkcija proverki ne rano li kastovatq
  // vozvratit 1 esli nerano ili 0 esli rano
  function check_last_cast ($pl)
  {
    //$pl = preg_replace ('/[^a-z0-9_\.]/i', '', $pl);
    $now = time();
    $id = is_player ($pl);
    if (!$id)
    {
      // pokachtoo zhivotnye ne kastujut:
      put_error ('npc cant cast');
    }
    $q = do_mysql ("SELECT last FROM players WHERE id_player = '".$id."';");
    $a = mysql_fetch_assoc ($q);
    $last = $a['last'];
    $last = explode ('|', $last);
    // v magii pri obnovlenii ukazyvaetsja vremja, sejchas nado tolqko proveritq, nastupilo li
    if ($last[3] < $now) return 1;
    return 0;
  }
?>