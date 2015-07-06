<?php
  // bereg reki
  // proverim, estq li udochka v rukah
  if (!strpos ($p['weapon'], 'udochka')) put_g_error ('возьмите удочку в руки!');
  // esli estq, mozhno lovitq...
  // spisok ryby -
  // $fish[ chislo, do kotorogo eta ryba, ili chislo pustogo mesta] = 'ryba| ee ves'
  $fish[15] = 'i.f.foo.fish_s_ersh|1';
  $fish[20] = 'i.f.foo.fish_s_bychok|2';
  $fish[30] = 0;
  $fish[35] = 'i.f.foo.fish_s_seledka|6';
  $fish[40] = 'i.f.foo.fish_s_kambala|6';
  $fish[50] = 0;
  $fish[55] = 'i.f.foo.fish_s_leshq|10';
  $fish[60] = 'i.f.foo.fish_s_sudak|10';
  $fish[70] = 0;
  $fish[75] = 'i.f.foo.fish_s_treska|14';
  $fish[80] = 'i.f.foo.fish_s_kalqmar|15';
  $fish[85] = 'i.f.foo.fish_s_kreken|1000';

  // maksimalqnoe chislo
  $maxp = $p['skills'][31] * 10;
  $pts = rand (1, $maxp);
  $fs = 0;
  foreach ($fish as $key => $value)
  {
    if ($pts < $key)
    {
      $pts = $key;
      $fs = $value;
      break;
    }
  }

  // esli pojmali rybu
  if ($fs)
  {
    $fs = explode ('|', $fs);
    // proverka na to chto vytashishq
    $maxcatch = $p['skills'][31] * 5 + $p['skills'][0] * 3 + $p['skills'][1] * 2;
	if (rand (0, $maxcatch) <= rand (0, $pts))
 	{
 	  add_journal ('Пусто как в колодце :/', $LOGIN);
 	}
    else if (rand (0, $fs[1]) <= rand (0, $maxcatch))
    {
      // lovim
      include_once ('modules/f_gain_item.php');
      gain_item ($fs[0], 1, $LOGIN);
    }
    else
    {
      // lomaem udochku
      include_once ('modules/f_delete_item.php');
      delete_item ($p['weapon']);
      add_journal ('Ваша удочка не выдержала такой нагрузки. Рыба ее сломала!', $LOGIN);
    }
  }
  else
  {
    add_journal ('Пусто как в колодце :/', $LOGIN);
  }
  
?>