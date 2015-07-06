<?php
  // funkcija proverjaet uspeshnostq zaklinanija
  function check_cast ($spell, $login)
  {
    //$spell = preg_replace ('/[^a-z0-9_]/i', '', $spell);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);
    $id = is_player ($login);
    if (!$id) put_error ('only players can cast');
    // berem infu zakla : shans vypolnenija
    $q = do_mysql ("SELECT difficulty, classof, minskill FROM magic WHERE fullname = '".$spell."';");
    if (!mysql_num_rows ($q)) put_error ('there is no such spell');
    $diff = mysql_fetch_assoc ($q);
    $q = do_mysql ("SELECT skills FROM players WHERE id_player = '".$id."';");
    $skill = mysql_result ($q, 0);
    $skill = explode ('|', $skill);
    // teperq berem shans igroka boevoi (na sotvorenie magii):
    include_once ('modules/f_get_pl_battle_har.php');
    $har = get_pl_battle_har ($login);
    // har[4] eto shans bez navyka magii. dobavim ego:
    if ($diff['classof'] == 0)
    {
      $max = -1;
      $sk = 0;
      for ($i = 22; $i < 30; $i++)
        if ($skill[$i] > $max) { $sk = $i; $max = $skill[$sk]; }
    }
    else $sk = 21 + $diff['classof']; // nomer navyka

    if (!$skill[$sk]) return 0;

    $har[4] += $skill[$sk] * 9 + $skill[30] * 9;

    // teperq poluchenuju cyfru i diff - iz nih procenty delaem:
    $h = $har[4];
    $pr = $h / ($har[4] + $diff['difficulty']) * 100;
    $pr = round ($pr);
    if ($diff['minskill'] > $skill[$sk] + $skill[30]) $pr = 0;
    //echo 'pr = '.$pr;

    // esli odet zhezl, to uluchshaetsja shans, proverim
    $q = do_mysql ("SELECT fullname, on_use FROM items WHERE belongs = '".$login."' AND is_in = 'wea';");
    if (mysql_num_rows ($q))
    {
      $w = mysql_fetch_assoc ($q);
      if (substr ($w['fullname'], 4, 3) == 'tre')
      {
        // proverim:
        $pl = $w['on_use'];
        if ($pl)
        {
          $pl = explode (':', $pl);
          $c = count ($pl);
          for ($i = 0; $i < $c; $i++)
          {
            $pl[$i] = explode ('~', $pl[$i]);
            if ($pl[$i][0] == 0 || $pl[$i][0] == $diff['classof']) $pr += $pl[$i][1];
          }
        }
      }
    }

    // proverka na shans:
    if (rand (0, 100) <= $pr) return 1;
    return 0;
  }
?>