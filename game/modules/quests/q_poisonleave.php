<?php
  // prinesti 10 listov jadovityh
  $spf['quest'] = 'Да! Неподалеку от города растут странные растения - ядовитые кусты. Из ихних листов лекарь умеет делать прекрасную отраву для мышей. У меня дома какраз завелись мыши, думал заказать, но, оказывается, лекарь ингридиентов неимеет. Принеси мне 10 ядовитых листов, и я шедро расплачусь с тобой!|q_ok~уже иду :)|q_has~держи!';
  $spf['q_ok'] = 'ну и гут! жду';
  if ($part == 'q_has')
  {
    // tipa prines, proverim
    include_once ('modules/f_has_count.php');
    $c_q = has_count ('i.q.hun.poison_leave', 10, $LOGIN);
    if ($c_q < 0) $spf['q_has'] = 'ты принес слишком листов, надо 10';
    elseif ($c_q == 0) $spf['q_has'] = 'принеси мне 10 ядовитых листов...';
    else
    {
      // prineseny vse shkury:
      include_once ('modules/f_delete_count.php');
      delete_count ('i.q.hun.poison_leave', 10, $LOGIN);
      include_once ('modules/f_gain_peace_exp.php');
      gain_peace_exp (500, $LOGIN);
      include_once ('modules/f_gain_silver.php');
      gain_silver (300, $LOGIN);
      include_once ('modules/f_gain_item.php');
      gain_item ('i.q.que.unknown_alchemy', 1, $LOGIN);
      include_once ('modules/f_increase_karma.php');
      increase_karma ($LOGIN, 1);
      $spf['q_has'] = 'Спасибо, выручил! Я на днях вот эту бумажку нашел, может понадобится?';
      include_once ('modules/f_end_quest.php');
      end_quest ('poisonleave');
    }
  }
?>