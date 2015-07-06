<?php
  // bereg reki
  // proverim, estq li udochka v rukah
  if (!strpos ($p['weapon'], 'udochka')) put_g_error ('возьмите удочку в руки!');
  // esli estq, mozhno lovitq...
  // spisok ryby -
  // $fish[ chislo, do kotorogo eta ryba, ili chislo pustogo mesta] = 'ryba| ee ves'
  $fish[15] = 'i.f.foo.fish_r_ersh|1';
  $fish[20] = 'i.f.foo.fish_r_plotva|1';
  $fish[30] = 0;
  $fish[35] = 'i.f.foo.fish_r_rybec|3';
  $fish[40] = 'i.f.foo.fish_r_okunq|5';
  $fish[50] = 0;
  $fish[55] = 'i.f.foo.fish_r_farelq|7';
  $fish[60] = 'i.f.foo.fish_r_sudak|8';
  $fish[70] = 0;
  $fish[75] = 'i.f.foo.fish_r_wuka|11';
  $fish[80] = 'i.f.foo.fish_r_som|100';

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