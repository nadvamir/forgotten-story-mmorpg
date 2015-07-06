<?php
  // sferovidnaja svechka, slozhno opisuemyj podarok na denq rozhdenija.
  // esli ee zazhechq, poluchishq sluchajnuju veshq.
  // chto by zazhechq svechku, nado ispolqzovatq volshebnoe ognivo
  // ognivo mozhno omenjatq na tabakerku u ochotnika na bolote
  
  include_once ('modules/f_has_count.php');
  if (!has_count ('i.q.que.staroe_ognivo', 1, $LOGIN))
    exit_msg ('сферовидная свечка', 'как бы вы ни вертели эту свечку, зажеч ее вам не удаётся.');
  
  // zamaskituem pod npc
  // chto by standartno
  $npc = array ();
  $npc['lvl'] = $p['stats'][0];
  $npc['drop2'] = '';
  $items = array ();
  
  $rnd = rand (0, 100);
  if ($rnd < 19)
  {
    // sluchajnoe oruzhie:
    $types = array ('arb', 'axe', 'bow', 'ham', 'kli', 'kni', 'spe', 'swo', 'tre');
    $arnd = array_rand ($types);
    include ('modules/sp/sp_rand_weapon.php');
  }
  else if ($rnd < 47)
  {
    // sluchajnaja bronja
    $types = array ('amu', 'bel', 'bo1', 'bo2', 'bot', 'glo', 'hea', 'leg', 'pon', 'rin', 'sho');
    $arnd = array_rand ($types);
    include ('modules/sp/sp_rand_armor.php');
  }
  else if ($rnd < 48)
    // kvestavaja veshq:
    include ('modules/sp/sp_rand_quest_item.php');
  else if ($rnd < 59)
    // wit
    include ('modules/sp/sp_rand_shield.php');
  else if ($rnd < 79)
    // eda
    include ('modules/sp/sp_rand_food.php');
  else if ($rnd < 89)
    // svitok:
    include ('modules/sp/sp_rand_scroll.php');
  else
    // reagenty
    include ('modules/sp/sp_rand_rea.php');
  
  
  add_journal ('Свечка ярко вспыхнула и расстворилась в воздухе, оставив за собой едкий болотный запах.', $LOGIN);
  include_once ('modules/f_delete_item.php');
  delete_item ($item);
  include_once ('modules/f_gain_item.php');
  gain_item ($npc['drop2'], 1, $LOGIN);
?>