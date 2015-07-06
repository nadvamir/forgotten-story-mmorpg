<?php
  function trade_param ($item)
  {
    $item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
    $cl = substr ($item, 2, 1);
    $tp = substr ($item, 4, 3);
    // podkljuchim
    if ($cl == 'a' || $cl == 'w' || $cl == 'x')
    {
      $else = substr ($item, 12);
      $item2 = 'i.'.$cl.'.'.$tp.'.'.$else;
    }
    else
      $item2 = $item;
    if (!file_exists ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php')) put_error ('<p>trade - нету такого файла для создания веши: modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php</p>');
    include ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php');
    if (!isset($it[$item2])) put_error ('<p>такой веши нету в файлах: '.$item2.'</p>');
    $it[$item2] = explode('|', $it[$item2]);
    if ($cl == 'w' || $cl == 'a' || $cl == 'x')
    {
      $pref = substr ($item, 8, 3);
      switch ($pref)
      {
        case 'fur':
          $it[$item2][6] *= 1.2;
          $it[$item2][11] *= 1.5;
          break;
        case 'tun':
          $it[$item2][6] *= 1.2;
          $it[$item2][11] *= 0.5;
          break;
        case 'bet':
          $it[$item2][6] *= 1.25;
          break;
        case 'rar':
          $it[$item2][6] *= 1.5;
          break;
        case 'eli':
          $it[$item2][6] *= 2.0;
          break;
        case 'epi':
          $it[$item2][6] *= 2.5;
          break;
        case 'leg':
          $it[$item2][6] *= 3.0;
          break;
      }
      $it[$item2][6] = round($it[$item2][6]);
      $it[$item2][11] = round($it[$item2][11]);
    }
    $name = $it[$item2][0];
    if ($cl == 'w')
    {
      // teperq izmenim svojstva po prefiksu
      $a = explode ('~', $it[$item2][7]);
      for ($i = 0; $i < 5; $i++)
      $a[$i] = explode ('-', $a[$i]);
#print_r ($a);
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
      $it[$item2][7] = $a[0].'~'.$a[1].'~'.$a[2].'~'.$a[3].'~'.$a[4];
    }
    if ($cl == 'a' || $cl == 'x')
    {
      // teperq izmenim svojstva po prefiksu
      $a = explode ('~', $it[$item2][8]);
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
      $it[$item2][8] = $a[0].'~'.$a[1].'~'.$a[2].'~'.$a[3].'~'.$a[4];
    }
    $it[$item2][0] = $name;
    return $it[$item2];
  }
?>