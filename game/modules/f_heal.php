<?php
  // funkcija, kotoraja lechit ot imeni lekarja
  function heal ($healer, $patient, $cost)
  {
    //$healer = preg_replace ('/[^a-z0-9_\.]/i', '', $healer);
    //$patient = preg_replace ('/[^a-z0-9_]/i', '', $patient);
    $cost = preg_replace ('/[^0-9]/', '', $cost);

    $id = is_player ($patient);
    $nid = is_npc ($healer);

    $q = do_mysql ("SELECT location, money, life, status1 FROM players WHERE id_player = '".$id."';");
    $p = mysql_fetch_assoc ($q);
    $q = do_mysql ("SELECT location FROM npc WHERE id_npc = '".$nid."';");
    $loc = mysql_result ($q, 0);
    if ($p['location'] != $loc) return 0;
    $p['life'] = explode ('|', $p['life']);
    if ($p['life'][0] == $p['life'][1]) exit_msg ('целительство', 'вы итак полностью здоровы!');
    $price = (ceil (($p['life'][1] - $p['life'][0]) / 100)) * $cost;
    if ($p['money'] < $price) exit_msg ('целительство', 'у вас нехватает денег, надо '.$price.' серебра!');

    $p['money'] -= $price;
    $nlife = $p['life'][1].'|'.$p['life'][1];
    $p['status1'][2] = 0;
    $p['status1'][3] = 0;
    $p['status1'][4] = 0;
    do_mysql ("UPDATE players SET money = '".$p['money']."', life = '".$nlife."', status1 = '".$p['status1']."' WHERE id_player = '".$id."';");
    exit_msg ('целительство', 'вы выздоровили! цена: '.$price.' серебра.');
  }
?>