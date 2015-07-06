<?php
  // funkcija, kotoraja lechit ot imeni lekarja
  function healer_stop_b ($healer, $patient, $cost)
  {
    //$healer = preg_replace ('/[^a-z0-9_\.]/i', '', $healer);
    //$patient = preg_replace ('/[^a-z0-9_]/i', '', $patient);
    $cost = preg_replace ('/[^0-9]/', '', $cost);

    $id = is_player ($patient);
    $nid = is_npc ($healer);

    $q = do_mysql ("SELECT location, money, status1 FROM players WHERE id_player = '".$id."';");
    $p = mysql_fetch_assoc ($q);
    $q = do_mysql ("SELECT location FROM npc WHERE id_npc = '".$nid."';");
    $loc = mysql_result ($q, 0);
    if ($p['location'] != $loc) return 0;
    if (!$p['status1'][2] && !$p['status1'][3] && !$p['status1'][4]) exit_msg ('целительство', 'вы итак полностью здоровы!');
    $price = $cost;
    if ($p['money'] < $price) exit_msg ('целительство', 'у вас нехватает денег, надо '.$price.' серебра!');

    $p['money'] -= $price;
    $p['status1'][2] = 0;
    $p['status1'][3] = 0;
    $p['status1'][4] = 0;
    do_mysql ("UPDATE players SET money = '".$p['money']."', status1 = '".$p['status1']."' WHERE id_player = '".$id."';");
    exit_msg ('целительство', 'вaши раны залечены! цена: '.$price.' серебра.');
  }
?>