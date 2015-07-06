<?php
  $spf['start'] = 'Привет! Неоткажешся в кости перекинутся? Правда, хотя бы 1 серебрянный при себе ты иметь должен... Bыберай ставку|one~1|ten~10|hundred~100|no~неа, денег жалко|player~а с другими игроками перекинутся можно?';
  $spf['no'] = 'Ай ну тебя!';
  $spf['player'] = 'Конечно! Вот стоит стол для костей - ложишь на него ставку, выбераешь игрока, приглашешь - если он согласится, тогда тоже положит ставку и вы кинете кости.';
  if ($part == 'one')
  {
    if ($p['money'] < 1) $spf['one'] = 'У тебя нет 1 серебрянного';
	else
	{
	  $trevor = rand (2, 12);
	  $you = rand (2, 12);
	  if ($you > $trevor) $plus = 1;
          elseif ($trevor > $you) $plus = -1;
          else $plus = 0;
	  include_once ('modules/f_gain_silver.php');
	  gain_silver ($plus, $LOGIN);
	  $spf['one'] = 'Тревор кинул '.$trevor.'<br/>Вы кинули '.$you.'<br/>Выйгрыш '.$plus.' серебра!|one~еще раз!';
	}
  }
  if ($part == 'ten')
  {
    if ($p['money'] < 10) $spf['ten'] = 'У тебя нет 10 серебрянных';
	else
	{
	  $trevor = rand (2, 12);
	  $you = rand (2, 12);
	  if ($you > $trevor) $plus = 10;
          elseif ($trevor > $you) $plus = -10;
          else $plus = 0;
	  include_once ('modules/f_gain_silver.php');
	  gain_silver ($plus, $LOGIN);
	  $spf['ten'] = 'Тревор кинул '.$trevor.'<br/>Вы кинули '.$you.'<br/>Выйгрыш '.$plus.' серебра!|ten~еще раз!';
	}
  }
  if ($part == 'hundred')
  {
    if ($p['money'] < 100) $spf['hundred'] = 'У тебя нет 100 серебрянных';
	else
	{
	  $trevor = rand (2, 12);
	  $you = rand (2, 12);
	  if ($you > $trevor) $plus = 100;
          elseif ($trevor > $you) $plus = -100;
          else $plus = 0;
	  include_once ('modules/f_gain_silver.php');
	  gain_silver ($plus, $LOGIN);
	  $spf['hundred'] = 'Тревор кинул '.$trevor.'<br/>Вы кинули '.$you.'<br/>Выйгрыш '.$plus.' серебра!|hundred~еще раз!';
	}
  }
?>