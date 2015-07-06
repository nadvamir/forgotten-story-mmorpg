<?php
  // skript ispolqzovanija meditacii:
  $mp = rand (0, $p['skills'][4]) * $p['skills'][2];
  $p['mana'][0] += $mp;
  if ($p['mana'][0] > $p['mana'][1]) $p['mana'][0] = $p['mana'][1];
  $nmana = $p['mana'][0].'|'.$p['mana'][1];
  add_journal ('мана +'.$mp.'!', $LOGIN);
  do_mysql ("UPDATE players SET mana = '".$nmana."' WHERE id_player = '".$p['id_player']."';");
?>