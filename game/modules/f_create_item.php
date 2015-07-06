<?php
  // funkcija sozdaet veshq
  // sozdaet ee voobshe, i nepridaet ee nikomu
  // dlja dobavlenija funkcii kudanitq v drugoe mesto (vozvrashjaetsja
  // ispolqzuetsja  add_item_to_loc i add_item_to_player i add_tem_to_npc
  function create_item ($fullname, $dmg = 0, $armor = 0)
  {
    global $I_P_P;
    $loc = '';
    //$fullname = preg_replace ('/[^a-z0-9_\.\|]/i', '', $fullname);
    // v princype v etu funkciju iz faila vvodjatsja vse dannye
    // klass:
    $cl = substr ($fullname, 2, 1);
    //if ($cl == 'm') put_error ('wrong file to create misc');
    // tip
    $tp = substr ($fullname, 4, 3);
    if ($cl == 'a' || $cl == 'w' || $cl == 'x')
    {
      // prefiks
      $pref = substr ($fullname, 8, 3);
      // ostalqnoe
      $else = substr ($fullname, 12);
      // bazovoe nazvanie
      $fullname2 = $fullname;
      $fullname = 'i.'.$cl.'.'.$tp.'.'.$else;
    }
    if (substr ($fullname, 0, 14) == 'i.o.sta.portal')
    {
      $rn = $fullname;
      $fn = explode ('~', $fullname);
      $fullname = $fn[0];
      $locto = $fn[1];
      $loc = $fn[2];
      $time = $fn[3];
    }
    // podkljuchim
    if (!file_exists ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php')) put_error ('<p>cre i -нету такого файла для создания веши: modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php</p>');
    include ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php');
    if (!isset($it[$fullname])) put_error ('<p>такой веши нету в файлах: '.$fullname.'</p>');
    $it[$fullname] = explode('|', $it[$fullname]);
    // edinstvennoe chto nado sdelatq - eto izmenitq fullname
    // poetomu, zapolnim za dva raza, pervyj raz ukazhem lozhnyj fullname
    $name = mysql_real_escape_string ($it[$fullname][0]);
    $fullname = mysql_real_escape_string ($it[$fullname][1]);
    $type = mysql_real_escape_string ($it[$fullname][2]);
    $on_take = mysql_real_escape_string ($it[$fullname][3]);
    $on_use = mysql_real_escape_string ($it[$fullname][4]);
    $on_drop = mysql_real_escape_string ($it[$fullname][5]);
    $str = 1000;
    if (isset ($locto))
    {
      // delaem portal 
      $on_take = $locto;
      $on_drop = time() + $time;
      include_once ('modules/f_loc.php');
      $locinf = loc ($locto, 'locinfo');
      $name2 = $name;
      $name .= ' '.$locinf[1];
      $locinf = loc ($loc, 'locinfo');
      $name2 .= ' '.$locinf[1];
    }
    $price = mysql_real_escape_string ($it[$fullname][6]);
    if ($cl == 'a' || $cl == 'w' || $cl == 'x')
    {
      switch ($pref)
      {
        case 'bet': $price *= 1.25; break;
        case 'rar': $price *= 1.5; break;
        case 'eli': $price *= 2.0; break;
        case 'epi': $price *= 2.5; break;
        case 'leg': $price *= 3.0; break;
      }
      $str = $I_P_P[$pref];
    }
    if ($dmg) $dmg = mysql_real_escape_string ($dmg);
    else $dmg = mysql_real_escape_string ($it[$fullname][7]);
    if ($cl == 'w')
    {
      // teperq izmenim svojstva po prefiksu
      $a = explode ('~', $dmg);
      for ($i = 0; $i < 5; $i++)
        $a[$i] = explode ('-', $a[$i]);
      switch ($pref)
      {
        case 'bas':
          $a[0] = (round ($a[0][0] * 1)).'-'.(round ($a[0][1] * 1));
          $a[1] = (round ($a[1][0] * 1)).'-'.(round ($a[1][1] * 1));
          $a[2] = (round ($a[2][0] * 1)).'-'.(round ($a[2][1] * 1));
          $a[3] = (round ($a[3][0] * 1)).'-'.(round ($a[3][1] * 1));
          $a[4] = (round ($a[4][0] * 1)).'-'.(round ($a[4][1] * 1));
          break;
        case 'nor':
          $a[0] = (round ($a[0][0] * 1)).'-'.(round ($a[0][1] * 1));
          $a[1] = (round ($a[1][0] * 1)).'-'.(round ($a[1][1] * 1));
          $a[2] = (round ($a[2][0] * 1)).'-'.(round ($a[2][1] * 1));
          $a[3] = (round ($a[3][0] * 1)).'-'.(round ($a[3][1] * 1));
          $a[4] = (round ($a[4][0] * 1)).'-'.(round ($a[4][1] * 1));
          break;
        case 'bet':
          $name = $name.' (Улучшенное)';
          $a[0] = (round ($a[0][0] * 1.05)).'-'.(round ($a[0][1] * 1.05));
          $a[1] = (round ($a[1][0] * 1.05)).'-'.(round ($a[1][1] * 1.05));
          $a[2] = (round ($a[2][0] * 1.05)).'-'.(round ($a[2][1] * 1.05));
          $a[3] = (round ($a[3][0] * 1.05)).'-'.(round ($a[3][1] * 1.05));
          $a[4] = (round ($a[4][0] * 1.05)).'-'.(round ($a[4][1] * 1.05));
          break;
        case 'rar':
          $name = $name.' (Редкое)';
          $a[0] = (round ($a[0][0] * 1.1)).'-'.(round ($a[0][1] * 1.1));
          $a[1] = (round ($a[1][0] * 1.1)).'-'.(round ($a[1][1] * 1.1));
          $a[2] = (round ($a[2][0] * 1.1)).'-'.(round ($a[2][1] * 1.1));
          $a[3] = (round ($a[3][0] * 1.1)).'-'.(round ($a[3][1] * 1.1));
          $a[4] = (round ($a[4][0] * 1.1)).'-'.(round ($a[4][1] * 1.1));
          break;
        case 'eli':
          $name = $name.' (Элитное)';
          $a[0] = (round ($a[0][0] * 1.15)).'-'.(round ($a[0][1] * 1.15));
          $a[1] = (round ($a[1][0] * 1.15)).'-'.(round ($a[1][1] * 1.15));
          $a[2] = (round ($a[2][0] * 1.15)).'-'.(round ($a[2][1] * 1.15));
          $a[3] = (round ($a[3][0] * 1.15)).'-'.(round ($a[3][1] * 1.15));
          $a[4] = (round ($a[4][0] * 1.15)).'-'.(round ($a[4][1] * 1.15));
          break;
        case 'epi':
          $name = $name.' (Эпическое)';
          $a[0] = (round ($a[0][0] * 1.2)).'-'.(round ($a[0][1] * 1.2));
          $a[1] = (round ($a[1][0] * 1.2)).'-'.(round ($a[1][1] * 1.2));
          $a[2] = (round ($a[2][0] * 1.2)).'-'.(round ($a[2][1] * 1.2));
          $a[3] = (round ($a[3][0] * 1.2)).'-'.(round ($a[3][1] * 1.2));
          $a[4] = (round ($a[4][0] * 1.2)).'-'.(round ($a[4][1] * 1.2));
          break;
        case 'leg':
          $name = $name.' (Легендарное)';
          $a[0] = (round ($a[0][0] * 1.25)).'-'.(round ($a[0][1] * 1.25));
          $a[1] = (round ($a[1][0] * 1.25)).'-'.(round ($a[1][1] * 1.25));
          $a[2] = (round ($a[2][0] * 1.25)).'-'.(round ($a[2][1] * 1.25));
          $a[3] = (round ($a[3][0] * 1.25)).'-'.(round ($a[3][1] * 1.25));
          $a[4] = (round ($a[4][0] * 1.25)).'-'.(round ($a[4][1] * 1.25));
          break;
      }
      $dmg = $a[0].'~'.$a[1].'~'.$a[2].'~'.$a[3].'~'.$a[4];
    }
    if ($armor) $armor = mysql_real_escape_string ($armor);
    else $armor = mysql_real_escape_string ($it[$fullname][8]);
    if ($cl == 'a' || $cl == 'x')
    {
      // teperq izmenim svojstva po prefiksu
      $a = explode ('~', $armor);
	  if (!isset ($a[4])) $a[4] = 0;
      switch ($pref)
      {
        case 'fur':
          $name .= ' (мех)';
          break;
        case 'tun':
          $name .= ' (хлопок)';
          break;
        case 'bas': break;
        case 'nor': break;
        case 'bet':
          $name = $name.' (Улучшенное)';
          $a[0] = (round ($a[0] * 1.05));
          $a[1] = (round ($a[1] * 1.05));
          $a[2] = (round ($a[2] * 1.05));
          $a[3] = (round ($a[3] * 1.05));
          $a[4] = (round ($a[4] * 1.05));
          break;
        case 'rar':
          $name = $name.' (Редкое)';
          $a[0] = (round ($a[0] * 1.1));
          $a[1] = (round ($a[1] * 1.1));
          $a[2] = (round ($a[2] * 1.1));
          $a[3] = (round ($a[3] * 1.1));
          $a[4] = (round ($a[4] * 1.1));
          break;
        case 'eli':
          $name = $name.' (Элитное)';
          $a[0] = (round ($a[0] * 1.15));
          $a[1] = (round ($a[1] * 1.15));
          $a[2] = (round ($a[2] * 1.15));
          $a[3] = (round ($a[3] * 1.15));
          $a[4] = (round ($a[4] * 1.15));
          break;
        case 'epi':
          $name = $name.' (Эпическое)';
          $a[0] = (round ($a[0] * 1.2));
          $a[1] = (round ($a[1] * 1.2));
          $a[2] = (round ($a[2] * 1.2));
          $a[3] = (round ($a[3] * 1.2));
          $a[4] = (round ($a[4] * 1.2));
          break;
        case 'leg':
          $name = $name.' (Легендарное)';
          $a[0] = (round ($a[0] * 1.25));
          $a[1] = (round ($a[1] * 1.25));
          $a[2] = (round ($a[2] * 1.25));
          $a[3] = (round ($a[3] * 1.25));
          $a[4] = (round ($a[4] * 1.25));
          break;
      }
      $armor = $a[0].'~'.$a[1].'~'.$a[2].'~'.$a[3].'~'.$a[4];
    }
    $belongs = mysql_real_escape_string ($it[$fullname][9]);
    $location = mysql_real_escape_string ($it[$fullname][10]);
    if (isset ($locto)) $location = $locto;
    $weight = mysql_real_escape_string ($it[$fullname][11]);

    // effekt napitkam zapisyvaetsja v location po nachalu, a tut esli nado pereisyvaetsja v jewel
    $jewel = '';
    if ($cl == 'f')
      $jewel = $location;

    $realname = $fullname;
    if (isset ($rn)) $realname = $rn;
    if ($cl == 'a' || $cl == 'w' || $cl == 'x') {$realname = $fullname2; $fullname = $fullname2;}
    do_mysql ("INSERT INTO items VALUES (0, '".$name."', '".$fullname.".i', '".$type."', '".$on_take."', '".$on_use."', '".$on_drop."', '".$price."', '".$dmg."', '".$armor."', '".$belongs."', '".$loc."', '".$weight."', '', '".$realname."', '', '".$jewel."', '0', '".$str."', '0');");
    if (isset ($locto))
    {
      // obratnyj portal:
      do_mysql ("INSERT INTO items VALUES (0, '".$name2."', '".$fullname.".i2', '".$type."', '".$loc."', '".$on_use."', '".$on_drop."', '".$price."', '".$dmg."', '".$armor."', '".$belongs."', '".$locto."', '".$weight."', '".(substr ($locto, 0, 4))."', '".$realname."', '', '".$jewel."', '0', '0', '0');"); 
    }
    // teperq vozqmem id_item i pripishem ego k fullname
    $a = do_mysql ("SELECT id_item FROM items WHERE fullname = '".$fullname.".i';");
    $id_item = mysql_result ($a, 0);
    // obnovim 
    do_mysql ("UPDATE items SET fullname = '".$fullname.".".$id_item."' WHERE fullname = '".$fullname.".i';");
    if (isset ($locto))
    {
      // tozhe samoe dlja obratnogo portala
      $a = do_mysql ("SELECT id_item FROM items WHERE fullname = '".$fullname.".i2';");
      $id_item2 = mysql_result ($a, 0);
      // obnovim 
      do_mysql ("UPDATE items SET fullname = '".$fullname.".".$id_item2."' WHERE fullname = '".$fullname.".i2';");
    }
    return $fullname.'.'.$id_item;
  }
?>