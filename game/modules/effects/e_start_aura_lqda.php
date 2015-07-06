<?php
  // $name=login
  $id = is_player ($name);
  if ($id)
  {
    // esli igrok
    do_mysql ("UPDATE players SET aura = '3' WHERE id_player = '".$id."';");
  }
  // npc poka bez aury
?>