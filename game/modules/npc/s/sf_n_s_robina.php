﻿<?php
  if ($p['classof'] == 0 && !$p['smq'][0] && !$p['smq'][2])
  {
    if ($p['smq'][1] == 0) $bec = '|become~а как мне стать лучником?';
    include_once ('modules/f_has_count.php');
    $c_feather = has_count ('i.q.hun.feather', 1, $LOGIN);
    $c_stick = has_count ('i.q.que.vetka', 1, $LOGIN);
    if ($p['smq'][1] == 0 && $c_feather)
    {
      $bec .= '|feather~я принес то перо, что ты просила.';
      $spf['feather'] = 'Прекрастно! Идем далее. Основа стрелы - ветка. Теперь принеси мне ее. Достань как хочешь. Возможно, найдутся люди которые тебе помогут.';
      if ($part == 'feather')
      {
        $p['smq'][1] = 1;
        do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
        include_once ('modules/f_gain_peace_exp.php');
        gain_peace_exp (20, $LOGIN);
        include_once ('modules/f_delete_count.php');
        delete_count ('i.q.hun.feather', 1, $LOGIN);
      }
    }
    if (($p['smq'][1] == 1 || $p['smq'][1] == 2) && $c_stick)
    {
      $bec .= '|stick~ветка при мне. Что далее?';
      $spf['stick'] = 'Держи стрелу. В награду ;) Вообщем, со стрелами почти разобрались. Теперь осталося просветить тебя по другим вопросам. Ай, сходи ка к деду, охотнику, ему всеровно там в избе делать нефиг...';
      if ($part == 'stick')
      {
        $p['smq'][1] = 3;
        do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
        include_once ('modules/f_gain_peace_exp.php');
        gain_peace_exp (50, $LOGIN);
        include_once ('modules/f_delete_count.php');
        delete_count ('i.q.hun.feather', 1, $LOGIN);
        include_once ('modules/f_gain_item.php');
        gain_item ('i.m.arr.arr', 1, $LOGIN);
      }
    }
    if ($p['smq'][1] == 4)
    {
      $bec .= '|end~Прослушал я туториал. Все?';
      $spf['end'] = 'Все. Держи серебра, это тебе на объучение. Иди теперь во дворец, к Лорду. Должны тебя уже впустить, и грамоту выдать. Служи верно!';
      if ($part == 'end')
      {
        $p['smq'][1] = 5;
        $p['classof'] = 1;
        do_mysql ("UPDATE players SET smq = '".$p['smq']."', classof = '2' WHERE login = '".$LOGIN."';");
        include_once ('modules/f_gain_peace_exp.php');
        gain_peace_exp (50, $LOGIN);
        include_once ('modules/f_gain_silver.php');
        gain_silver (700, $LOGIN);
      }
    }
  }
  else $bec= '';
  $spf['start'] = 'Здравствуй) Как поживаешь?|gut~Привет, хорошо|who~Жить можно. Кто ты?';
  $spf['gut'] = 'Рада за тебя. Чем я могу тебе помочь?|learn~я хотел бы узнать что-то новое.'.$bec;
  $spf['who'] = 'Я Робина - воительница лучница. Чем могу помочь?|learn~немогла бы ты меня обучить чему либо?';
  $spf['learn'] = 'Я и сама не прочь что нибудь новое, да ты наверняка не об этом. Так, новичков разных за деньги объучаю, тем и живу... Не взяли меня За Мост... Так что тебе? Только учти что оружием лучника я тебя пользоватся объучть небуду, если ты не лучник по классу.|learn_ukl1~покажи мне, как уклонятся от вражеских ударов|learn_bow1~Научи меня пользоватся луком|learn_arb1~а арбалетом ты владеешь?'.$bec;
  $spf['learn_ukl1'] = 'Уклонятся - это просто. Надо только гибкое тело иметь. Дай 500монет и я тебе пару примеров, ну а дальше, думаю, ты сам разберешся.|learn_ukl~держи|learn~а что-нибудь другое?';
  $spf['learn_bow1'] = 'Небуду хвастатся, но луком я владею мастерски! И в салаты добавляю, и в супа... А, ты не про этот лук? Ну чтож, с боевым потяжелее будет. Но за серебра эдак 700, я постораюсь чтоб тебе все стало понятно, что с луком связанно. И даже больше, я покажу, как я стреляю.|learn_bow~учи, сенсейка)|learn~Да я какраз пищевой и имел ввиду. Но раз такому не учишь, давай какойнибудь другой навык?';
  $spf['learn_arb1'] = 'Я? Конечно владею. Но нелюблю, громоздкий он. 600 серебряных будет тебе стоить объучение у меня. У гномов может быть и дешевле, да плестись до туда, сам понимаешь...|learn_arb~я на все согласен. Учи!|learn~Да, он точно громоздкий и неудобный. Я передумал, что-нибудь другое умеешь?';
  if ($part == 'learn_ukl')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (17, 500);
  }
  if ($part == 'learn_arb')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (12, 600);
  }
  if ($part == 'learn_bow')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (11, 700);
  }
  if ($part == 'become' && $p['classof'] > 0)
  {
    $spf['become'] = 'Тебе уже никак, ты ведь выбрал свой путь.';
    if ($p['classof'] == 2) $spf['become'] .= ' И вообще, что за тупые вопросы? Ты ведь лучник.';
  }
  else if ($part == 'become' && !$p['smq'][0] && !$p['smq'][2])
  {
    $spf['become'] = 'В таком случае тебе надо задания выполнять, что дам. Скорей всего я дам тебе пару задний практического характера. Так вот, что главное для лучника? Всегда иметь стрелы. Ну, возможно, это и не самое главное, да полезно. Чтобы стрела летела по такой траектории, как хочишь ты, на конце у нее перья. Ну, еще стрелять надо уметь. Вообщем, принеси мне перо. Достанешь ты еге из крыльев птици. Ну а как это сделать пояснит мой деда, Дон, если сам не догадаешся. Вообщем, иди!';
  }
?>