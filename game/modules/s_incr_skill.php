<?php
  // fail dlja povyshenija navyka
  $skill = preg_replace ('/[^0-9]/', '', $_GET['skill']);
  if ($skill === false) put_error ('неуказан навык');
  if (!$p['skills'][$skill]) put_error ('вы неумеете такого навыка!');

  // cena:
  // nomer navykov:
  $sum = array_sum ($p['skills']);
  if ($sum == 6) $price = 0;
  else $price = $sum * $sum * 1; 
  //else if ($skill < 4) $price = $sum * 100;
  //else $price = $p['skills'][$skill] * 1000;

  if ($p['money'] < $price) put_g_error ('у вас слишком мало серебра, чтобы поднять навык: боги просят '.$price.' серебренных!');
  if (!$p['stats'][6]) put_error ('у вас нету очков опыта');
  $stn = $skc = 0;
  $c = count ($p['skills']);
  for ($i = 0; $i < 4; $i++) $stn += $p['skills'][$i];
  for ($i = 4; $i < $c; $i++) $skc += $p['skills'][$i];
  // vychitaem pljusy kolec i amuletov
  $jew = do_mysql ("SELECT on_use FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a9';");
  if (mysql_num_rows ($jew))
  {
    $jew = mysql_result ($jew, 0);
    $jew = explode ('~', $jew);
    $stn -= $jew[0];
    $stn -= $jew[1];        
    $stn -= $jew[2];   
    $stn -= $jew[3]; 
  }
  $jew = do_mysql ("SELECT on_use FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a10';");
  if (mysql_num_rows ($jew))
  {
    $jew = mysql_result ($jew, 0);
    $jew = explode ('~', $jew);
    $stn -= $jew[0];
    $stn -= $jew[1];
    $stn -= $jew[2];
    $stn -= $jew[3];
  }
  //if ((($stn - ($p['stats'][0] * 2)) * 4 > ($skc * 5)) && $skill < 4 && $p['stats'][0] > 1) put_g_error ('недопустимое соотношение статов и навыков');
  $stn -= 4; // nachalqnye
  $stn -= $p['stats'][0] * 2; // urovnevye
  $skc += $p['stats'][6];
  if ($skill < 4 && $p['stats'][0] > 1 && ($stn / $skc) > (4/5)) put_g_error ('недопустимое соотношение статов и навыков');

  // esli vsju proverku proshli, podnimem i zabudem
  $p['skills'][$skill] += 1;
  $p['stats'][6] -= 1;
  $skills = implode ('|', $p['skills']);
  $stats = implode ('|', $p['stats']);
  $p['money'] -= $price;
  do_mysql ("UPDATE players SET skills = '".$skills."', stats = '".$stats."', money = '".$p['money']."' WHERE id_player = '".$p['id_player']."';");
  $f = gen_header ('навыки');
  $f .= '<div class="y" id="sodhg"><b>навыки:</b></div><p>';
  include 'modules/sp/sp_skillnames.php';
  $f .= 'вы подняли '.$skn[$skill].' до уровня '.$p['skills'][$skill].'!<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=show_skills">навыки</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer ();
  exit ($f);
?>