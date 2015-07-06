<?php
  // skript zagruzki karty
  // sozdaet nuzhnyh npc ili veshi v lokacii
  // esli te ukazany v actions dlja aktivnyh kart
  // a dlja neaktivnyh bolee 10 min
  // udaljaet vse von
  //////////////////////////////
  // sozdanie nuzhnyh veshej v lokacii
  // esli karta na kotoruju zashel igrok neaktivnaja
  // to zagruzim
  $pl_map = substr ($p['location'], 0, 4);
  $qplm = do_mysql ("SELECT * FROM maps WHERE map = '".$pl_map."';");
  if (!mysql_num_rows ($qplm))
  {
    // zanesem kartu esli ja zabyl zanesti
    do_mysql ("INSERT INTO maps VALUES ('".$pl_map."', 'no', '', '');");
    $qplm = do_mysql ("SELECT * FROM maps WHERE map = '".$pl_map."';");
  }
  $plm = mysql_fetch_assoc ($qplm);
  if ($plm['active'] == 'no') $NEWMAP = 1;
//etime('ladmaps1');
//stime();
  include_once ('modules/mapinfo/load_'.$pl_map.'.php');
//etime ('loadmaps incl');
//stime();
  // celesoobrazno proverjatq action raz v 30 sec, kak i life regen
  $mon = get_month();
  $time = time();
  $all = do_mysql ("SELECT * FROM gamesys WHERE month = '".$mon."';");
  $all = mysql_fetch_assoc ($all);

$TESTALL = $all;

//etime('loadmaps gamesys');
//stime();

  if ($time - $p['last'][2] >= 30 || $NEWMAP)
  {
    include 'modules/sp/sp_loadmaps.php';
  }
?>