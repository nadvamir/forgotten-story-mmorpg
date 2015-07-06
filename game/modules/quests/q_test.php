<?php
  // prostoj kvest testovyj pro zajcev: 
  $spf['quest'] = 'Я тут задумал шапку зайчью пошить. Но для этого мне понадобятся две шкуры зайца. Не поможешь?|q_ok~OK :)|q_has~две шкуры зайца, говоришь? Да они же при мне!';
  $spf['q_ok'] = 'ну и гут! жду';
  if ($part == 'q_has')
  {
    // tipa prines, proverim
    include_once ('modules/f_has_count.php');
    $c_q = has_count ('i.q.hun.rabbit_fur', 2, $LOGIN);
    if ($c_q < 0) $spf['q_has'] = 'ты принес слишком мало шкур, надо 2';
    elseif ($c_q == 0) $spf['q_has'] = 'принеси мне 2 шкуры...';
    else
    {
      // prineseny vse shkury:
      include_once ('modules/f_delete_count.php');
      delete_count ('i.q.hun.rabbit_fur', 2, $LOGIN);
      include_once ('modules/f_gain_peace_exp.php');
      gain_peace_exp (50, $LOGIN);
      include_once ('modules/f_gain_silver.php');
      gain_silver (30, $LOGIN);
      include_once ('modules/f_gain_item.php');
      gain_item ('i.f.foo.fry_fish_l_okunq', 2, $LOGIN);
      include_once ('modules/f_increase_karma.php');
      increase_karma ($LOGIN, 1);
      $spf['q_has'] = 'Спасибо, выручил! От окушка не откажишся?';
      include_once ('modules/f_end_quest.php');
      end_quest ('test');
    }
  }
?>