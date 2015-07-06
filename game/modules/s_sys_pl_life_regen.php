<?php
  // regeneracija zhizni igroka
  // avtomaticheskaja
  // vyzyvaetsja tolqko kogda nado, proverjatq ne nado
  $lp = floor (($time - $p['last'][2]) / 5);
  if ($p['skills'][5]) $lrp = round ($lp * $p['skills'][5] * $p['skills'][0] / 4);
  else $lrp = $lp;
  $p['last'][2] += $lp * 5;
  $minus = 0;
  if ($p['status1'][2] == 1)
  {
    $lpk = $lp * 5;
    if ($p['life'][0] - $lpk <= 0)
    {
      $death = 1;
    }
    else $p['life'][0] -= $lpk;
    $minus = 1;
  }
  if ($p['status1'][3] == 1)
  {
   // $lpp = $lp * (round ($p['life'][1] / 100));
    $lpp = $lp * 7;
    if ($p['life'][0] - $lpp <= 0)
    {
      $death = 1;
    }
    else $p['life'][0] -= $lpp;
    $minus = 1;
  }
  if ($p['status1'][4] == 1)
  {
    //$lpb = $lp * (round ($p['life'][1] / 20));
    $lpb = $lp * 20;
    if ($p['life'][0] - $lpb <= 0)
    {
      $death = 1;
    }
    else $p['life'][0] -= $lpb;
    $minus = 1;
  }
  if (!$minus && $p['life'][0] < $p['life'][1] && !is_in ('prokljat', $AFF) && !is_in ('zarazhen', $AFF))
  {
    if ($p['life'][0] + $lrp > $p['life'][1]) $p['life'][0] = $p['life'][1];
    else $p['life'][0] += $lrp;
  }
  $lf = $p['life'][0].'|'.$p['life'][1];
  /////////////////////////////////////////
  if ($p['skills'][4]) $lrp = $lp * $p['skills'][4] * 2;
  else $lrp = $lp;
  if ($p['status1'][3] == 1)
  {
    if ($p['mana'][0] - $lp < 0) $p['mana'][0] = 0;
    else $p['mana'][0] -= $lp;
  }
  if ($p['status1'][3] == 0 && $p['mana'][0] < $p['mana'][1])
  {
    if ($p['mana'][0] + $lrp > $p['mana'][1]) $p['mana'][0] = $p['mana'][1];
    else $p['mana'][0] += $lrp;
  }
  $mn = $p['mana'][0].'|'.$p['mana'][1];
  mysql_query ("UPDATE players SET life = '".$lf."', mana = '".$mn."' WHERE id_player = '".$p['id_player']."';", $dbcnx);

  if (isset ($death))
  {
    include_once ('modules/f_make_die.php');
    make_die ($LOGIN);
  }

?>