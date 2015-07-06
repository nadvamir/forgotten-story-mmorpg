<?php
  // funkcija obxuchaet igroka opredelennomu navyku i potov pokazyvaet
  // v argumentah - navyk (nomer) i cena
  function learn_skill ($skill, $price)
  {
    global $p;
    global $sid;
    $skill = preg_replace ('/[^0-9]/', '', $skill);
    $price = preg_replace ('/[^0-9]/', '', $price);
    if ($skill === false) put_error ('неуказан навык');
    if ($price === false) put_error ('неуказанa цена');
    if (!isset($p['skills'][$skill])) put_error ('такого навыка нету');
    if ($p['skills'][$skill]) put_g_error ('вы уже имеете этот навык!');
	
    $mage = array (22, 23, 24, 25, 26, 27, 28, 29, 30);
    $warrior = array (7, 8, 9, 10, 41);
    $ranger = array (11, 12);
    // proverka na klassy:
    if ($p['classof'] != 3 && in_array ($skill, $mage)) put_g_error ('только для магов!');
    if ($p['classof'] != 1 && in_array ($skill, $warrior)) put_g_error ('только для воина!');
    if ($p['classof'] != 2 && in_array ($skill, $ranger)) put_g_error ('только для лучников!');
	
    if ($p['money'] < $price) put_g_error ('у вас нехватает серебра - надо '.$price.' монет!');
    if (!$p['stats'][3]) put_g_error ('у вас нету очка навыка!');

    // nelzja vychitq vtoroj navyk iz serii parirovanie - dvuruchnoe - dva
    if (($p['skills'][18] || $p['skills'][40] || $p['skills'][41]) && ($skill == 18 || $skill == 40 || $skill == 41)) put_g_error ('нелзя выучить два навыка из серии двуручное - два - парирование. Либо щит, либо двуручное, либо два.');

    // esli vsju proverku proshli, podnimem i zabudem
    $p['skills'][$skill] = 1;
    $p['stats'][3] -= 1;
    $skills = implode ('|', $p['skills']);
    $stats = implode ('|', $p['stats']);
    $p['money'] -= $price;
    do_mysql ("UPDATE players SET skills = '".$skills."', stats = '".$stats."', money = '".$p['money']."' WHERE id_player = '".$p['id_player']."';");
    $f = gen_header ('навыки');
    $f .= '<div class="y" id="sodhg"><b>навыки:</b></div><p>';
    include 'modules/sp/sp_skillnames.php';
    $f .= 'вы выучили '.$skn[$skill].'!<br/>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
    $f .= gen_footer ();
    exit ($f);
  }
?>