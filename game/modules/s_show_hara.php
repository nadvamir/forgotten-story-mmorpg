<?php
  // pokaz harakteristik igroka
  $f = gen_header ('характеристика');
  $f .= '<div class="y" id="paurf"><b>характеристика:</b></div><p>';
  // uron
  include_once ('modules/f_get_dmg.php');
  $dmg = get_dmg($LOGIN);
  // bronja
  include_once ('modules/f_get_armor.php');
  $armor = get_armor($LOGIN);
  // oruzhie
  $f .= '><b><u>урон:</u></b><br/>';
  $f .= '<b>режущий</b>: '.$dmg[0][0].' - '.$dmg[0][1].'<br/>';
  $f .= '<b>колющий</b>: '.$dmg[1][0].' - '.$dmg[1][1].'<br/>';
  $f .= '<b>дробящий</b>: '.$dmg[2][0].' - '.$dmg[2][1].'<br/>';
  $f .= '<b>рубящий</b>: '.$dmg[3][0].' - '.$dmg[3][1].'<br/>';
  $f .= '<b>магический</b>: '.$dmg[4][0].' - '.$dmg[4][1].'<br/>';
  if (isset ($p['shield']))
  {
    $f .= '><b><u>щит, защита:</u></b><br/>';
    include_once ('modules/f_get_it_info.php');
    $shie = get_it_info ($p['shield']);
    $shie = explode ('~', $shie['armor']);
    $f .= '<b>от режущего</b>: '.$shie[0].'<br/>';
    $f .= '<b>от колющего</b>: '.$shie[1].'<br/>';
    $f .= '<b>от дробящего</b>: '.$shie[2].'<br/>';
    $f .= '<b>от рубящего</b>: '.$shie[3].'<br/>';
    $f .= '<b>от магическoгo</b>: '.$shie[4].'<br/>';
  }
  $f .= '><b><u>броня:</u></b><br/>';
  $f .= '<b>от режущего</b>: '.$armor[0].'<br/>';
  $f .= '<b>от колющего</b>: '.$armor[1].'<br/>';
  $f .= '<b>от дробящего</b>: '.$armor[2].'<br/>';
  $f .= '<b>от рубящего</b>: '.$armor[3].'<br/>';
  $f .= '<b>от магическoгo</b>: '.$armor[4].'<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>