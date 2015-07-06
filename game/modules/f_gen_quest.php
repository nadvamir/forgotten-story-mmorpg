<?php
  // funkcija proverjaet sostojanie kqvestov. esli menqshe ukazanogo chisla, ona budet iskatq
  // svobodnogo npc, i emu dast etot kvest.
  function gen_quest ($location)
  {
    //echo 'starts';
    // kolichestvo kvestov v odnom regione max;
    $qcount = 1;
    // region
    $reg = substr ($location, 0, 4);
    // kolichestvo zanjatyh kvestov:
    $q = do_mysql ("SELECT COUNT(*) FROM quests WHERE npc <> '' AND region = '".$reg."';");
    $qc_on = mysql_result ($q, 0);
//echo '<br/>'.$qc_on.'<br/>';
    // esli dostatochno to dalqshe proverjatq nebudem:
    if ($qcount <= $qc_on) return 1;
    // dalee esli menqshe to berem kolichestvo svobodnyh:
    $q = do_mysql ("SELECT COUNT(*) FROM quests WHERE npc = '' AND region = '".$reg."';");
    $qc_off = mysql_result ($q, 0);
//echo '<br/>'.$qc_off.'<br/>';
    // esli takih net to bolqshe niche delatq nebudem
    if ($qc_off == 0) return 1;
    // zapros, estq li svobodnye npc v regione:
    $q = do_mysql ("SELECT COUNT(*) FROM npc WHERE quest = '' AND map = '".$reg."' AND type = 's';");
    $cnpc = mysql_result ($q, 0);
//echo '<br/>'.$cnpc.'<br/>';
    if ($cnpc == 0) return 1;

    // dalee u nas zapros na vse svobodnye kvesty - 
    $q = do_mysql ("SELECT * FROM quests WHERE npc = '' AND region = '".$reg."';");
    $qst = '';
    while ($qst1 = mysql_fetch_assoc ($q))
      $qst[] = $qst1;
    $rnd = array_rand ($qst);
    
    // zapros na svobodnogo npc
    $q = do_mysql ("SELECT realname FROM npc WHERE type = 's' AND quest = '' AND map = '".$reg."' AND realname <> 'n.s.relen_vernol';");
    $npc = '';
    while ($r = mysql_fetch_assoc ($q))
      $npc[] = $r;
    //print_r ($npc);
    $rnd_npc = array_rand ($npc);

    // opredelennomu kvestu opredelennyj npc:
    do_mysql ("UPDATE quests SET npc = '".$npc[$rnd_npc]['realname']."' WHERE id_quest = '".$qst[$rnd]['id_quest']."';");
    // opredelennomu npc opredelennyj kvest:
    do_mysql ("UPDATE npc SET quest = '".$qst[$rnd]['questname']."' WHERE realname = '".$npc[$rnd_npc]['realname']."';");
    // use, return 1;
    //echo 'ends';
    return 1;
  }
?>