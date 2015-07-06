<?php
  // fail razgovora oborotnja v pogonah:
  $spf['start'] = 'Че стоишь! Иди камни ломать и неси их Фергу. Пока не сдохнешь!|with~чем?|abgold~я слыхал в граните золото попадается...';
  $spf['with'] = 'Да хоть наручниками! Сдохнешь быстрей.';
  $spf['abgold'] = 'Хм, это интересно. Найдешь, принеси, я тебе пару грехов, так уж и быть, спишу. Ну а там посмотрим, авось и на свободу отпущу, если много принесешь...|take~держи';
  if ($part == 'take')
  {
    // tipa prines, proverim
    include_once ('modules/f_has_count.php');
    $c_q = has_count ('i.q.que.goldpiece', 1, $LOGIN);
    if ($c_q < 0) $spf['take'] = 'где золото?!';
    elseif ($c_q == 0) $spf['take'] = 'где золото!?';
    else
    {
      // prineseny vse shkury:
      include_once ('modules/f_delete_count.php');
      delete_count ('i.q.que.goldpiece', 1, $LOGIN);
      include_once ('modules/f_increase_karma.php');
      if ($p['karma'] < -70) increase_karma ($LOGIN, 2);
      $spf['take'] = 'зачет!';
    }
  }
?>