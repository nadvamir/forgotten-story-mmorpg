<?php
  if ($plm['active'] == 'no')
  {
    // zagruzhaem pustuju katu
    include_once ('modules/f_create_item.php');  // checked
    include_once ('modules/f_add_item_to_loc.php'); // checked
    include_once ('modules/f_gen_rnd_loc.php'); // checked
    foreach ($items as $key => $val)
    {
      // sozdaem veshq
      $ni = explode (':', $items[$key]);
      // ESLI ETO MELKAJA VESHQ 
      if (substr ($ni[0], 2, 1) == 'm')
      {
        if (!$ni[1]) $iloc = gen_rnd_loc ($pl_map);
        else $iloc = gen_rnd_loc ($pl_map, $ni[1]);
        include_once ('modules/f_create_item_m.php');
        $nitem = create_item_m ($ni[0], $ni[2]);
        add_item_to_loc ($iloc, $nitem);
        continue;
      }
      // esli vtoraja chastq pusta, generiruem sluchajno iz vsej karty
      // esli net to iz ukazanyh
      // stolqko raz skolqko ukazano
      $q = do_mysql ("SELECT COUNT(*) FROM items WHERE realname = '".$ni[0]."' AND map = '".$pl_map."';");
      $count = mysql_result ($q, 0);
      $ni[2] -= $count;
      if (!$ni[2]) continue;
      for ($i = 0; $i < $ni[2]; $i++)
      {
        $nitem = create_item ($ni[0]);
        if (!$ni[1]) $iloc = gen_rnd_loc ($pl_map);
        else $iloc = gen_rnd_loc ($pl_map, $ni[1]);
        // dobavljaem veshq v lokaciju i vse
        add_item_to_loc ($iloc, $nitem);
      }
    }
    include_once ('modules/f_create_npc.php');  // checked
    include_once ('modules/f_add_to_loc.php'); // checked
    include_once ('modules/f_gen_rnd_loc.php'); // checked
    foreach ($npc as $key => $val)
    {
      // sozdaem npc
      $nn = explode (':', $npc[$key]);
      // esli vtoraja chastq pusta, generiruem sluchajno iz vsej karty
      // esli net to iz ukazanyh
      // stolqko raz skolqko ukazano
      // proverka na suwestvovanie:
      $q = do_mysql ("SELECT COUNT(*) FROM npc WHERE realname = '".$nn[0]."' AND map = '".$pl_map."';");
      $count = mysql_result ($q, 0);
      $nn[2] -= $count;
      if (!$nn[2]) continue;
      for ($i = 0; $i < $nn[2]; $i++)
      {
        if (!$nn[1]) $nloc = gen_rnd_loc ($pl_map);
        else $nloc = gen_rnd_loc ($pl_map, $nn[1]);
        $nnpc = create_npc ($nn[0], $pl_map, $nloc);
      }
    }
    $now = time(); // obnovim active karty
    do_mysql ("UPDATE maps SET active = '".$now."' WHERE map = '".$pl_map."';");
  }
  else
  {
    $now = time(); // obnovim active karty
    do_mysql ("UPDATE maps SET active = '".$now."' WHERE map = '".$pl_map."';");
    // nado proveritq actions, i vypolnitq te, kotorym podoshlo vremja
    $qa = do_mysql ("SELECT actions FROM maps WHERE map = '".$pl_map."';");
    $act = mysql_result ($qa, 0);
    $act = explode ('~', $act);
    $ca = count ($act);
    for ($i = 0; $i < $ca; $i++)
    {
      if (!$act[$i])
      {
        unset ($act[$i]);
        continue;
      }
      $a = explode ('|', $act[$i]);
      if ($a[0] == 'item' && $a[2] < $now)
      {
        // veshq
        include_once ('modules/f_create_item.php');
        include_once ('modules/f_add_item_to_loc.php');
        include_once ('modules/f_gen_rnd_loc.php');
        // sozdaem veshq
        if (!is_array($items[$a[1]]))
          $items[$a[1]] = explode (':', $items[$a[1]]);
        if (substr ($items[$a[1]][0], 2, 1) == 'm')
        {
          include_once ('modules/f_create_item_m.php');
          if (!$items[$a[1]][1]) $iloc = gen_rnd_loc ($pl_map);
          else $iloc = gen_rnd_loc ($pl_map, $items[$a[1]][1]);
          $nitem = create_item_m ($items[$a[1]][0], $items[$a[1]][2], $iloc, 0);
          add_item_to_loc ($iloc, $nitem);
          unset ($act[$i]);
        }
        else
        {
          $nitem = create_item ($items[$a[1]][0]);
          // esli vtoraja chastq pusta, generiruem sluchajno iz vsej karty
          // esli net to iz ukazanyh
          if (!$items[$a[1]][1]) $iloc = gen_rnd_loc ($pl_map);
          else $iloc = gen_rnd_loc ($pl_map, $items[$a[1]][1]);
          // dobavljaem veshq v lokaciju i vse
          add_item_to_loc ($iloc, $nitem);
          unset ($act[$i]);
        }
      }
      if ($a[0] == 'npc' && $a[2] < $now)
      {
        // npc
        include_once ('modules/f_create_npc.php');
        include_once ('modules/f_add_to_loc.php');
        include_once ('modules/f_gen_rnd_loc.php');
        // sozdaem npc
        if (!is_array($npc[$a[1]]))
          $npc[$a[1]] = explode (':', $npc[$a[1]]);
        // esli vtoraja chastq pusta, generiruem sluchajno iz vsej karty
        // esli net to iz ukazanyh
        if (!$npc[$a[1]][1]) $nloc = gen_rnd_loc ($pl_map);
        else $nloc = gen_rnd_loc ($pl_map, $npc[$a[1]][1]);
        $nnpc = create_npc ($npc[$a[1]][0], $pl_map, $nloc);
        // dobavljaem npc v lokaciju i vse
        unset ($act[$i]);
      }
    }
    $nact = implode ('~', $act);
    do_mysql ("UPDATE maps SET actions = '".$nact."' WHERE map = '".$pl_map."';");
  }

    // ochistim ot staryh trupov
    $qdd = do_mysql ("SELECT fullname FROM dead WHERE puttime < NOW() - INTERVAL '15' MINUTE");
    while ($de = mysql_fetch_assoc($qdd))
    {
      do_mysql ("DELETE FROM items WHERE belongs = '".$de['fullname']."';");
      do_mysql ("DELETE FROM dead WHERE fullname = '".$de['fullname']."';");
    }

  // teperq ochistim nenuzhnye karty
  include_once 'modules/f_erease_map.php';
  $qmd = do_mysql ("SELECT map, active FROM maps WHERE active != 'no';");
  $now = time();
  while ($md = mysql_fetch_assoc ($qmd))
  {
    if ($now - $md['active'] > 900) erease_map ($md['map']);
  }
?>