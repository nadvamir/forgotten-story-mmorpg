<?php
  // pokaz informacii
  // po to opredelitq npc vshq ili igrok i opisatq
  $to = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['to']);
  if (substr($to, 0, 2) == 'n.') include 'modules/sp/sp_info_n.php';
  elseif (substr($to, 0, 2) == 'i.')
  {
    // veshi klasificirujutsja
    if (substr ($to, 2, 1) == 'f') include 'modules/sp/sp_info_i_f.php';
    if (substr ($to, 2, 1) == 'w') include 'modules/sp/sp_info_i_w.php';
    if (substr ($to, 2, 1) == 'a') include 'modules/sp/sp_info_i_a.php';
    if (substr ($to, 2, 1) == 'b') include 'modules/sp/sp_info_i_b.php';
    if (substr ($to, 2, 1) == 'm') include 'modules/sp/sp_info_i_m.php';
    if (substr ($to, 2, 1) == 'o' || substr ($to, 2, 1) == 'l') include 'modules/sp/sp_info_i_o.php';
    if (substr ($to, 2, 1) == 'q') include 'modules/sp/sp_info_i_q.php';
    if (substr ($to, 2, 1) == 's') include 'modules/sp/sp_info_i_s.php';
    if (substr ($to, 2, 1) == 'x') include 'modules/sp/sp_info_i_x.php';
  }
  else
  {
    if ($to == $LOGIN)
    {
      $log = $LOGIN;
      $tp['id_player'] = $p['id_player'];
      $tp['stats'] = $p['stats'];
      $tp['skills'] = $p['skills'];
      $tp['classof'] = $p['classof'];
      $tp['rase'] = $p['rase'];
      $tp['clan'] = $p['clan'];
      $tp['status1'] = $p['status1'];
      $tp['gender'] = $p['gender'];
      $tp['age'] = $p['age'];
      $tp['regtime'] = $p['regtime'];
      $tp['monsterkill'] = $p['monsterkill'];
      $tp['playerkill'] = $p['playerkill'];
      $tp['kbmonster'] = $p['kbmonster'];
      $tp['kbplayer'] = $p['kbplayer'];
      $tp['name'] = $p['name'];
      $tp['marry'] = $p['marry'];
    }
    else
    {
      $log = $to;
      $tp = get_pl_info ($log, 'main');
      if (!$tp) put_error ('нету такого игрока');
    }

    // bibliografija
    $q = do_mysql ("SELECT * FROM anketa WHERE id_player = '".$tp['id_player']."';");
    $an = mysql_fetch_assoc ($q);

    $f = gen_header ('инфо');
    $f .= '<div class="y" id="sgfdal"><b>'.$an['letter'].' '.$tp['name'].'</b>:</div><p>';

    if ($an['avatar']) $f .= '<img src="smile/avatar/a_'.$an['avatar'].'" alt="Av"/><br/>';

    switch ($tp['gender'])
    {
      case 'male': $f .= 'муж. '; break;
      case 'female': $f .= 'жен. '; break;
    }
    $f .= $tp['age'].' лет<br/>';
    $f .= 'расса: ';
    switch ($tp['rase'])
    {
      case 1: $f .= 'человек<br/>'; break;
      case 2: $f .= 'элф<br/>'; break;
      case 3: $f .= 'гном<br/>'; break;
    }
    $f .= 'класс: ';
    if ($tp['classof'] == '0') $f .= 'неопределен';
    else if ($tp['classof'] == '1') $f .= 'воин';
    else if ($tp['classof'] == '1a') $f .= 'рыцарь';
    else if ($tp['classof'] == '1b') $f .= 'палладин';
    else if ($tp['classof'] == '2') $f .= 'лучник';
    else if ($tp['classof'] == '2a') $f .= 'стрелок';
    else if ($tp['classof'] == '2b') $f .= 'охотник';
    else if ($tp['classof'] == '3') $f .= 'маг';
    else if ($tp['classof'] == '3a') $f .= 'архимаг';
    else if ($tp['classof'] == '3b') $f .= 'монах';

    if (substr ($tp['classof'], 0, 1) == '3')
    {
      if ($tp['skills'][22]) $f .= ' огненной';
      if ($tp['skills'][23]) $f .= ' водянной';
      if ($tp['skills'][24]) $f .= ' земной';
      if ($tp['skills'][25]) $f .= ' воздушной';
      if ($tp['skills'][26]) $f .= ' иллюзионной';
      if ($tp['skills'][27]) $f .= ' подземной';
      if ($tp['skills'][28]) $f .= ' эльфийской';
      if ($tp['skills'][29]) $f .= ' древнеэльфийской';
      $f .= ' магии';
    }

    $f .= '<br/>';

    if ($tp['marry'])
    {
      $mid = is_player ($tp['marry']);
      $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$mid."';");
      $marry = mysql_result ($q, 0);
      if ($tp['gender'] == 'male') $f .= 'муж ';
      else $f .= 'жена ';
      $f .= $marry.'<br/>';
    }

    $f .= 'уровень: '.$tp['stats'][0].'<br/>';
    if (!empty($tp['clan'][0]))
    {
      $q = do_mysql ("SELECT rank1, rank2, rank3, rank4, rank5, rank6, rank7 FROM clans WHERE clanname = '".$tp['clan'][0]."';");
      $ranks = mysql_fetch_assoc ($q);
      $key = 'rank'.$tp['clan'][1];
      if (!$ranks[$key])
        switch ($tp['clan'][1])
        {
          case 1: $f .= 'новичек '; break;
          case 2: $f .= 'рядовой '; break;
          case 3: $f .= 'звеневой '; break;
          case 4: $f .= 'почетный воин '; break;
          case 5: $f .= 'командир '; break;
          case 6: $f .= 'Капитан '; break;
          case 7: $f .= 'Лорд '; break;
        }
       else $f .= $ranks[$key].' ';
      $f .= 'клана '.$tp['clan'][0].'<br/>';
    }
    // v igre:
    $gt = ceil ((time() - $tp['regtime']) / 86400);
    $f .= 'в игре '.$gt.' дней<br/>';
    $f .= 'реитинг побед (м/и) : '.$tp['monsterkill'].'/'.$tp['playerkill'].'</p>';

    $f .= '<p>';
    $f .= 'страна: '.$an['country'].'<br/>';
    $f .= 'город: '.$an['city'].'<br/>';
    $f .= 'о себе: '.$an['about'];
    $f .= '</p>';

    // oruzhie:
    $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$to."' AND is_in = 'wea';");
    if (mysql_num_rows ($q))
    {
      $f .= '<div class="y" id="inv5">';
      $f .= '<b>в правой руке:</b></div><p>';
      $a = mysql_fetch_assoc ($q);
        $qua = substr ($a['fullname'], 8, 3);
        $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
        if (strpos ($qlist, $qua) === false) $qua = 'black';
        $f .= '<span class="'.$qua.'">'.$a['name'].'</span><br/>';
    }
    // shit:
    $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$to."' AND is_in = 'shi';");
    if (mysql_num_rows ($q))
    {
      $f .= '<div class="y" id="invsfh">';
      $f .= '<b>в левой руке:</b></div><p>';
      $a = mysql_fetch_assoc ($q);
        $qua = substr ($a['fullname'], 8, 3);
        $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
        if (strpos ($qlist, $qua) === false) $qua = 'black';
        $f .= '<span class="'.$qua.'">'.$a['name'].'</span><br/>';
    }
      
    // bronja:
    $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$to."' AND is_in LIKE 'a%';");
    if (mysql_num_rows ($q))
    {
      $f .= '<div class="y" id="oaitf"><b>броня:</b></div><p>';
      while ($a = mysql_fetch_assoc ($q))
      {
        $qua = substr ($a['fullname'], 8, 3);
        $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
        if (strpos ($qlist, $qua) === false) $qua = 'black';
        $f .= '<span class="'.$qua.'">'.$a['name'].'</span><br/>';
      }
      $f .= '</p>';
    }

    $f .= '<p><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
    $f .= gen_footer();
    exit($f);
  }
?>