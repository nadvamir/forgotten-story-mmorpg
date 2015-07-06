<?php
  // priruchenie zhivotnyh :)
  $npc = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['npc']);
  // priruchajutsja tolqko dobrye zhivotnye
  $qb = do_mysql ("SELECT name, chanse, belongs FROM npc WHERE fullname = '".$npc."' AND type = 'a' AND location = '".$p['location']."';");
  if (!mysql_num_rows ($qb)) put_g_error ('с вами рядом этого животного нет!');
  $bel = mysql_fetch_assoc ($qb);
  if ($bel['belongs']) put_g_error ('это животное уже кому-то принадлежит');
  $qc = do_mysql ("SELECT COUNT(*) FROM npc WHERE belongs = '".$LOGIN."';");
  $count = mysql_result ($qc, 0);
  if ($count > 0) put_g_error ('у вас уже есть один питомец!');
  // berem u npc ego boevuju harakteristiku:
  $har = explode ('~', $bel['chanse']);
  $k = $har[1] / 5;
  $pc = $p['karma'] * 100 / ($p['karma'] + $k);
  if (rand (0, 100) <= $pc)
  {
    // poluchilosq priruchitq
    $belongs = $LOGIN;
    do_mysql ("UPDATE npc SET belongs = '".$belongs."' WHERE fullname = '".$npc."';");
    $msg = 'вы приручили '.$bel['name'].'!';
  }
  else
    $msg = 'вам не удалось приручить '.$bel['name'].'!';
  exit_msg ('приручение', $msg);
?>