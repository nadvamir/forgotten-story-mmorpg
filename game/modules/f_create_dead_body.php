<?php
  // sozdaet trup 
  function create_dead_body ($who)
  {
    //$who = preg_replace ('/[^a-z\._0-9]/i', '', $who);
    $id = is_player ($who);
    if ($id)
    {
      // veshi:
      $q = do_mysql ("SELECT id_player, status1, location, karma, name FROM players WHERE id_player = '".$id."';");
      $p = mysql_fetch_assoc ($q);
      // imja trupa:
      $d_name = $p['name'].' (труп)';
      $d_map = substr ($p['location'], 0, 4);
      // polnoenimja
      $time = time();
      $tmp = 'n';
      if ($p['status1'][0] > 0) $tmp = 'p';
      $d_fullname = 'd.'.$tmp.'.'.$p['id_player'].'.'.$time;

      // veshi
      $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'inv' AND belongs = '".$who."';");
      $c = mysql_result ($q, 0);
      if ($p['status1'][0] == 0) $c = round ($c / 3);
      do_mysql ("UPDATE items SET belongs = '".$d_fullname."', is_in = '' WHERE belongs = '".$who."' AND is_in = 'inv' AND realname <> 'i.q.que.wind_sign' LIMIT ".$c.";");
      if ($p['status1'][0] > 0) do_mysql ("UPDATE items SET belongs = '".$d_fullname."', is_in = '' WHERE belongs = '".$who."' AND is_in = 'wea';");

      if ($p['karma'] < 300)
      {
        $num = rand (0, 10);
        $q = do_mysql ("SELECT fullname, on_use FROM items WHERE belongs = '".$who."' AND is_in = 'a".$num."';");
        if (mysql_num_rows ($q))
        {
          $a = mysql_fetch_assoc ($q);
          $prt = substr ($a['fullname'], 4, 3);
          if ($prt == 'amu' || $prt == 'rin')
          {
            $q = do_mysql ("SELECT skills FROM players WHERE id_player = '".$id."';");
            $p2 = mysql_fetch_assoc ($q);
            $p2['skills'] = explode ('|', $p2['skills']);
            $jew = explode ('~', $a['on_use']);
            $p2['skills'][0] -= $jew[0];
            $p2['skills'][1] -= $jew[1];
            $p2['skills'][2] -= $jew[2];
            $p2['skills'][3] -= $jew[3];
            $sk = implode ('|', $p2['skills']);
            do_mysql ("UPDATE players SET skills = '".$sk."' WHERE id_player = '".$id."';");
          }
        }
        do_mysql ("UPDATE items SET belongs = '".$d_fullname."', is_in = '' WHERE belongs = '".$who."' AND is_in = 'a".$num."';");
      }

      // trofei - 
      $d_hunt = '';
      // lokacija
      $d_location = $p['location'];
    }
    else
    {
      $id = is_npc ($who);
      // tozh samoe dlja npc
      // veshi:
      $q = do_mysql ("SELECT id_npc, name, drop2, hunt, location FROM npc WHERE id_npc = '".$id."';");
      $n = mysql_fetch_assoc ($q);
      // imja trupa:
      $d_name = $n['name'].' (труп)';
      // polnoe imja
      $time = time();
      $d_fullname = 'd.p.'.$n['id_npc'].$time;

      // sozdaem veshi
      if ($n['drop2'])
      {
        if (substr ($n['drop2'], 2, 1) == 'm')
        {
          include_once ('modules/f_create_item_m.php');
          $itc = create_item_m ($n['drop2'], 1);
        }
        else
        {
          include_once ('modules/f_create_item.php');
          $itc = create_item ($n['drop2']);
        }
        do_mysql ("UPDATE items SET belongs = '".$d_fullname."', map = '' WHERE fullname = '".$itc."';");
      }
      $d_hunt = $n['hunt'];
      // lokacija
      $d_location = $n['location'];
      $d_map = substr ($d_location, 0, 4);
    }
    // sozdaem:
    do_mysql ("INSERT INTO dead VALUES ('".$d_name."', '".$d_fullname."', '".$d_hunt."', '".$d_location."', '".$d_map."', NOW());");
    return 1;
  }
?>