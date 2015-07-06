<?php
  // funkcija sozdast npc ukazanogo
  // obezatelqnoproveritq chto klass zaklinanija sum
  function mag_summon ($spell, $login)
  {
    //$spell = preg_replace ('/[^a-z0-9_]/i', '', $spell);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);
    $id = is_player ($login);

    $q = do_mysql ("SELECT cname FROM magic WHERE fullname = '".$spell."';");
    if (!mysql_num_rows ($q)) return 0;
    $fullname = mysql_result ($q, 0);
    if (!$fullname) return 0;

    // zapros na lokaciju igroka i kolichestvo priruchennyh zhivotnyh
    $q = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
    if (!mysql_num_rows ($q)) return 0;
    $loc = mysql_result ($q, 0);

    $q = do_mysql ("SELECT COUNT(*) FROM npc WHERE belongs = '".$login."';");
    $c = mysql_result ($q, 0);
    if ($c > 0) put_g_error ('у вас уже есть нпц, принадлежащие вам');

    // sozdaem npc:
    include_once ('modules/f_create_npc.php');
    $npc = create_npc ($fullname, (substr($loc, 0, 4)), $loc);
    $nid = is_npc ($npc);

    // izmenim imja:
    $q = do_mysql ("SELECT name FROM npc WHERE id_npc = '".$nid."';");
    $name = mysql_result ($q, 0);
    $nname = 'призванный '.$name;
    $fullname = $npc.'.'.$login;

    // ataka:
    $q = do_mysql ("SELECT in_battle FROM players WHERE id_player = '".$id."';");
    $inb = mysql_result ($q, 0);

    do_mysql ("UPDATE npc SET fullname = '".$fullname."', name = '".$nname."', belongs = '".$login."', move = '30', in_battle = '".$inb."', type = 'a' WHERE id_npc = '".$nid."';");

    $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
    $pn = mysql_result ($q, 0);
    add_journal ($pn.': призвал '.$name.'!', 'l.'.$loc);

    return 1;
  }
?>