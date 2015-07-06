<?php
  // $name=login
  $id = is_player ($name);
  if ($id)
  {
    // esli igrok
    do_mysql ("UPDATE players SET walking = '0' WHERE id_player = '".$id."';");
  }
  // npc poka ne prygajut
?>