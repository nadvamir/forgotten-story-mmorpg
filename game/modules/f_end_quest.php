<?php
  // funkcijja okanchivaet kvest:
  function end_quest ($quest)
  {
    //$quest = preg_replace ('/[^a-z0-9_]/i', '', $quest);
    $q = do_mysql ("SELECT npc FROM quests WHERE questname = '".$quest."' AND npc <> '';");
    if (!mysql_num_rows ($q)) return 0;
    $npc = mysql_result ($q, 0);
    do_mysql ("UPDATE quests SET npc = '' WHERE questname = '".$quest."';");

    do_mysql ("UPDATE npc SET quest = '' WHERE realname = '".$npc."';");
    return 1;
  }
?>