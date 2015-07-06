<?php
  include 'modules/config.php';
  include 'modules/f_game.php';

  
  echo md5('aaaaaa');
 /* // OBNULENIE NAVYKOV I UDALENIE IZLISHNIH DENEG
  // berem vseh igrokov
  $q = do_mysql ("SELECT * FROM players;");
  while ($p = mysql_fetch_assoc ($q))
  {
    // proschitaem, skolqko navykov dolzhno bytq
    // nachislim stolqko ochkov opyta, i ochkov navyka.
    $p['stats'] = explode ('|', $p['stats']);  
    $p['skills'] = explode ('|', $p['skills']);
    // ustonavlivaem navyki po baze (sila/lovka/intellekt...
    $p['skills'][0] = $p['skills'][1] = 2;
    $p['skills'][2] = $p['skills'][3] = 1;
    $sum = array_sum ($p['skills']);
	$p['stats'][7] = ($p['stats'][0] - 1) * 9 + floor ($p['stats'][1] / $p['stats'][5]) + 1;
    // ustonavlivaem:
    $p['stats'][6] = $p['stats'][7] - $sum + 6 + (($p['stats'][0] > 12) ? (12 - $p['stats'][3]) : ($p['stats'][0] - $p['stats'][3]));
	// dopolnenie - navyki rassy
    switch ($p['rase'])
    {
      case 1: $p['skills'][0] += ($p['stats'][0] - 1); $p['skills'][2] += ($p['stats'][0] - 1); break;
      case 2: $p['skills'][1] += ($p['stats'][0] - 1); $p['skills'][3] += ($p['stats'][0] - 1); break;
      case 3: $p['skills'][0] += ($p['stats'][0] - 1); $p['skills'][3] += ($p['stats'][0] - 1); break;
    }
    // pereschityvaem denqgi dlja podnjatija
	$p['money'] = 0;
    for ($i = 0, $j = $sum + $p['stats'][0] * 2; $i <= $p['stats'][6]; $i++, $j++)
    {
      $p['money'] += $j * $j * 1;
    }
    // izmenjaem bazu dannyh
	//echo '-- '.($sum).' --';
	//print_r ($p['stats']);
    $p['stats'] = implode ('|', $p['stats']);
    $p['skills'] = implode ('|', $p['skills']);
    do_mysql ("UPDATE players SET money = '".$p['money']."', stats = '".$p['stats']."', skills = '".$p['skills']."' WHERE id_player = '".$p['id_player']."';");
    echo $p['login'].'<br/>';
  }*/
  
  // udalenie veshej
  //do_mysql ("DELETE FROM items;");
?>
