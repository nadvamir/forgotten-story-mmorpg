<?php
  // fail dlja ponizhenija navyka
  $skill = preg_replace ('/[^0-9]/', '', $_GET['skill']);
  if ($skill === false) put_error ('неуказан навык');
  if (!$p['skills'][$skill]) put_error ('вы неумеете такого навыка!');

  include 'modules/sp/sp_skillnames.php';
  if (!isset ($_GET['yes']))
    exit_msg ('Понизить навык', 'Понизить навык '.$skn[$skill].'. Bы уверены?<br/><a class="red" href="game.php?sid='.$sid.'&action=decr_skill&skill='.$_GET['skill'].'&yes=1">да</a><br/><a class="blue" href="game.php?sid='.$sid.'&action=show_skills">нет</a>');


  // cena:
  // nomer navykov:
  $sum = array_sum ($p['skills']);
  if ($sum == 6) $price = 0;
  else $price = $sum * $sum * 1; 
  //else if ($skill < 4) $price = $sum * 100;
  //else $price = $p['skills'][$skill] * 1000;

  if ($p['money'] < $price) put_g_error ('у вас слишком мало серебра, чтобы понизить навык: боги просят '.$price.' серебренных!');
  if ($p['skills'][$skill] < 2) put_error ('навык за мал');

  $p['skills'][$skill] -= 1;
  $p['stats'][6] += 1;
  $skills = implode ('|', $p['skills']);
  $stats = implode ('|', $p['stats']);
  $p['money'] -= $price;
  do_mysql ("UPDATE players SET skills = '".$skills."', stats = '".$stats."', money = '".$p['money']."' WHERE id_player = '".$p['id_player']."';");
  $f = gen_header ('навыки');
  $f .= '<div class="y" id="sodhg"><b>навыки:</b></div><p>';
  $f .= 'вы понизили '.$skn[$skill].' до уровня '.$p['skills'][$skill].'!<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=show_skills">навыки</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer ();
  exit ($f);
?>