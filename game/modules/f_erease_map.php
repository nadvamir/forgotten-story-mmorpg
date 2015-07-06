<?php
  // funkcija onuljaet kartu
  function erease_map ($map)
  {
    //$map = preg_replace ('/[^a-z0-9]/i', '', $map);
    if (!$map) return 0;
    do_mysql ("UPDATE maps SET active = 'no', actions = '' WHERE map = '".$map."';");
    // UDALENIE VESHEJ
    do_mysql ("DELETE FROM items WHERE (map <> 'telc' AND map = '".$map."' AND (belongs = '' OR belongs = '0') AND realname NOT LIKE 'i.o.sta.portal%') OR ( map = '".$map."' AND realname LIKE 'i.o.sta.portal%' AND on_take < '".(time())."');");
    // UDALENIE NPC
    do_mysql ("DELETE FROM npc WHERE map = '".$map."' AND quest = '' AND (belongs = '' OR belongs = '0') AND monsterkill < '1' AND playerkill < '1';");
    // UDALENIE LOKACIJ
    do_mysql ("DELETE FROM locations WHERE region = '".$map."';");
  }
?>