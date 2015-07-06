<?php
  // znak vetra:
  // teleportiruet (stoimostq 100 many)
  $wloc['rele|5x8'] = 'Релен';
  $wloc['verg|4x5'] = 'Верголк';
  $wloc['elfc|5x4'] = 'Город Эльфов';
  $wloc['prf2|4x5'] = 'Пригородный лес';
  $wloc['sfr1|4x5'] = 'Южный Лес';
  $wloc['ffo1|6x9'] = 'Дальний Лес';
  $wloc['novi|2x1'] = 'Разбитая дорога';
  $wloc['ffo6|1x1'] = 'мыс Приключений';
  $wloc['pr12|1x5'] = 'лесок гоблинов';
  $wloc['rele|2x10'] = 'лекарь';
    if (isset ($_GET['loc']))
    {
      $_GET['loc'] = preg_replace ('/[^a-z0-9\|]/i', '', $_GET['loc']);
      if (substr ($_GET['loc'], 0, 4) == 'telc') put_g_error ('исчо чё?!');
      if (!isset ($wloc[$_GET['loc']])) put_g_error ('исчо чё?!');
      if ($p['mana'][0] < 100) put_g_error ('нехватает маны');
      $p['mana'][0] -= 100;
      do_mysql ("UPDATE players SET mana = '".$p['mana'][0]."|".$p['mana'][1]."' WHERE login = '".$LOGIN."';");
      include_once ('modules/f_teleport.php');
      teleport ($LOGIN, $_GET['loc']);
    }
    else
    {
      $f = 'стоимость телепортации 100 маны. шанс 100%.<br/>';

      foreach ($wloc as $key=>$val)
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_item&item='.$item.'&loc='.$key.'">'.$val.'</a><br/>';
      exit_msg ('teleport', $f);
    }
?>