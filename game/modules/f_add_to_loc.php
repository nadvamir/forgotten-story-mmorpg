<?php
  // zapishet igroka ili npc v dannju lokaciju
  function add_to_loc ($loc, $who)
  {
    // proverka dannyh
    //$who = preg_replace ('/[^a-z\._0-9]/i', '', $who);
    //$loc = preg_replace ('/[^a-z0-9\|]/i', '', $loc);
    if (is_npc ($who))
    {
      // vpishem npc
      $map = substr ($loc, 0, 4);
      do_mysql ("UPDATE npc SET location = '".$loc."', map = '".$map."' WHERE fullname = '".$who."';");
    }
    else
    {
      $log = substr ($who, 0, 2);
      // vpishem igroka 
      do_mysql ("UPDATE players SET location = '".$loc."' WHERE login = '".$log."';");
    }
    return 1;
  }
?>