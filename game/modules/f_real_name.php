<?php
  // funkcija vozvarashjaet nastojashee fullname npc ili veshi, bez id v konce
  function real_name ($to)
  {
    //$to = preg_replace ('/[^a-z0-9\._]/i', '', $to);
    $pos = strrpos ($to, '.');
    $fn = substr ($to, 0, $pos);
    return $fn;
  }
?>