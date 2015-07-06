<?php
  // razgovornaja rechq Rycarja Rottera
  if ($p['classof'] == 0 && !$p['smq'][1] && !$p['smq'][2])
  {
    include_once ('modules/f_has_count.php');
    $c_rabbit = has_count ('i.q.hun.rabbit_fur', 1, $LOGIN);
    $c_pod = has_count ('i.f.tra.podorozhnik', 1, $LOGIN);
    $c_tab = has_count ('i.q.que.tabakerka', 1, $LOGIN);
    if (!$p['smq'][0] && !$c_rabbit)
    {
      $bec1 = '|became~в доблестные ряды рыцарей влится хочу!';
      $bec2 = '|became~а как мне воином стать тогда, если учить небудешь?';
      $spf['became'] = 'Так ты, стало быть, воин, но будущий? Чтож, я могу тебе помочь граммоту получить, да сначало ты мне доказать должен будешь, что достоен такого высокого звания.|how_i_can~как?';
      $spf['how_i_can'] = 'Ну, для начала, воин должен быть догадливым. Принеси мне шкуру зайца. Если незнаешь, она ножом либо кинжалом снимается. Но для этого надо зайца сначало поймать, хехе). Так что дерзай ;)';
    }
    elseif (!$p['smq'][0] && $c_rabbit || $p['smq'][0] == 1 && $c_rabbit)
    {
      $bec1 = '|fur~я вот шкуру принес, зайчью...';
      $bec2 = $bec1;
      if ($part == 'fur')
      {
        set_smq (0, 2);
        include_once ('modules/f_gain_peace_exp.php');
        gain_peace_exp (50, $LOGIN);
        include_once ('modules/f_delete_count.php');
        delete_count ('i.q.hun.rabbit_fur', 1, $LOGIN);
      }
      $spf['fur'] = 'А я думал уже и не придешь. Ладно, оставь шкуру при себе, изрезанная она какая-то, даже шапку делать из нее стыдно... Теперь ты можешь быть только воином, путь ты себе выбрал, яб даже сказал, на свою голову. Или еще похлеще как-нибудь). Вообщем слушай далее. Во время битвы почти всегда ты получишь ранения. А потеряв много крови человек умирает, по биологии наверно тебя учили этому? Так вот, нам этого соовсем ненадо. Кровотечение можно остановить разными способами. Но для тебя самый доступный - это приложить подорожник, так-сказать, секретное биологическое оружие ) Если ты не знаком с целительством, все травы будут выглядеть для тебя одинакого. Но подорожник всегда растет у тропинок, дорог. Так что принеси мне один, чтоб доказать, что умеешь его отличить.';
    }
    elseif ($p['smq'][0] == 2 && $c_pod)
    {
      $bec1 = '|pod~а я, кстати, подорожник принес';
      $bec2 = $bec1;
      if ($part == 'pod')
      {
        $p['smq'][0] = 3;
        do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
        include_once ('modules/f_gain_peace_exp.php');
        gain_peace_exp (50, $LOGIN);
        include_once ('modules/f_gain_silver.php');
        gain_silver (500, $LOGIN);
        include_once ('modules/f_delete_count.php');
        delete_count ('i.f.tra.podorozhnik', 1, $LOGIN);
      }
      $spf['pod'] = 'Вижу прогресс! Но все-таки, в следующий раз подорожник рви не по середине листа... Чтож, дам я тебе последнее испытание. Воин должен быть смелым! В лесу Красной птици нечисть завелась. Есть там такая избушка, в ней ведьма и кот черный. У того кота табакерка есть старинная, на трупе найдешь. Ведьму как хочешь, но наврятли она стоять и ждать пока ты кота распотрашишь будет. Принесешь табакерку - докажешь, что с табой хоть на урков идти можно. Вообщем, иди добывай )';
    }
    elseif ($p['smq'][0] > 2 && $c_tab)
    {
      $bec1 = '|tab~ну вот, и последнее задание я выполнил';
      $bec2 = $bec1;
      if ($part == 'tab')
      {
        $p['smq'][0] = 7;
        $p['classof'] = 1;
        do_mysql ("UPDATE players SET smq = '".$p['smq']."', classof = '1' WHERE login = '".$LOGIN."';");
        include_once ('modules/f_gain_peace_exp.php');
        gain_peace_exp (100, $LOGIN);
        include_once ('modules/f_delete_count.php');
        delete_count ('i.q.que.tabakerka', 1, $LOGIN);
      }
      $spf['tab'] = 'Даа, что-то больно новая эта табакерка. Ну да ладно, Воин, ты доказал, что смелый. Врать-то нехорошо, в таком то виде очень наврятли ты сам нечисть завалишь ) На смерть я тя не посылал, ненадо мне тут, придет время расскажут тебе про смерть в этом мире, не в моей это компетенции. В любом случае, иди прямо к Лорду, поговори со стражником, он двери откроет. Служи верно, и у Лорда мне позора не сделай )';
    }
    else
    {
      $bec1 = '';
      $bec2 = '';
    }
  }
  else
  {
    $bec1 = '';
    $bec2 = '';
  }
  $spf['start'] = 'Приветствую! С чем пожаловал, странник?|ask_to_learn~Я тут учится пришел'.$bec1;

  $spf['ask_to_learn'] = 'Очень хорошо! В наших окрестностях врят ли кто тебя объучит военному делу лучше чем я! Правда, учу я только воинов, всяким там магам в книжном магазине место! Что ты хочешь выучить?|learn_weap~мне не помешало бы владение каким-нить оружием...|learn_kombo~может каких-нибудь приемов знаешь?|master~может знаешь какие нибудь особые мастерства?'.$bec2;
  $spf['learn_weap'] = 'Каждый рыцарь обязан уметь владеть мечем. По моему скромному мнению, или тупо - ИМХО, это лучшее оружие. Легкое в управлении, довольно быстрое, приятно держать в руках, вообшем класс, не то, что молоты например. Тебе повезло, что встретил меня! Я тебя всего за 500 серебра объучу, всю жизнь спосибствовать будешь!|learn_sword~учи!|ask_to_learn~нее, еще ченить умеешь?';
  if ($part == 'learn_sword')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (7, 500);
  }
  $spf['learn_kombo'] = 'А какже? Это одна из основных состовляюших победы! Чему научить? Жадные вариянты приемов дают сразу лучшие резултаты. Правдо в далеков светлом будуюшем их перспективы не такие светлые.|kombo_rukojatka~глушаший удар (1000с., дроб)|kombo_rubok~рубок с плеча (1000с., руб., кров.)|kombo_prokol~проколоть насквозь (1000с., кол., кров.)|kombo_polosnutq~полоснуть пополам (1000с., рез., кров.)|kombo_zhrukojatka~жадный глушащий удар (2000с., дроб)|kombo_zhrubok~жадный рубок с плеча (2000с., руб., кров.)|kombo_zhprokol~жадный прокол насквозь (2000с., кол, кров)|kombo_zhpolosnutq~жадно полоснуть пополам (2000с., рез., кров.)|kombo_iscelenie~исцеление (5000с.)|kombo_zhiscelenie~жадное исцеление (10000с.)';
  if ($part == 'kombo_rukojatka')
  {
    include_once ('modules/f_teach_kombo.php');
    teach_kombo ($npc, $LOGIN, 'rukojatka', 1000);
  }
  if ($part == 'kombo_rubok')
  {
    include_once ('modules/f_teach_kombo.php');
    teach_kombo ($npc, $LOGIN, 'rubok', 1000);
  }
  if ($part == 'kombo_prokol')
  {
    include_once ('modules/f_teach_kombo.php');
    teach_kombo ($npc, $LOGIN, 'prokol', 1000);
  }
  if ($part == 'kombo_polosnutq')
  {
    include_once ('modules/f_teach_kombo.php');
    teach_kombo ($npc, $LOGIN, 'polosnutq', 1000);
  }
  if ($part == 'kombo_zhrukojatka')
  {
    include_once ('modules/f_teach_kombo.php');
    teach_kombo ($npc, $LOGIN, 'zhrukojatka', 2000);
  }
  if ($part == 'kombo_zhrubok')
  {
    include_once ('modules/f_teach_kombo.php');
    teach_kombo ($npc, $LOGIN, 'zhrubok', 2000);
  }
  if ($part == 'kombo_zhprokol')
  {
    include_once ('modules/f_teach_kombo.php');
    teach_kombo ($npc, $LOGIN, 'zhprokol', 2000);
  }
  if ($part == 'kombo_zhpolosnutq')
  {
    include_once ('modules/f_teach_kombo.php');
    teach_kombo ($npc, $LOGIN, 'zhpolosnutq', 2000);
  }
  if ($part == 'kombo_iscelenie')
  {
    include_once ('modules/f_teach_kombo.php');
    teach_kombo ($npc, $LOGIN, 'iscelenie', 5000);
  }
  if ($part == 'kombo_zhiscelenie')
  {
    include_once ('modules/f_teach_kombo.php');
    teach_kombo ($npc, $LOGIN, 'zhiscelenie', 10000);
  }
  $spf['master'] = 'Да я вообще джедай! Могу тебя научить лучше парировать щитом, использовать двуручное оружие или даже два оружия одновременно. Выберай чтонибудь одно.|par~парирование|two~двуручное|double~два оружия одновременно';
  $spf['par'] = 'Тоже можно. Щиты бывают разные, и защищают от разных типов удара. Но принцып пользования одинаков для каждого. Я поясню, но без 700 серебра никак.|learn_par~показывай!|ask_to_learn~что ты умеешь еще?';
  if ($part == 'learn_par')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (18, 700);
  }
  $spf['two'] = 'Двуручники - вешь клевая. Они намного мошьней обыкновенного оружия. Правда, они и тежелее его, поэтому медленней, но высокая сила, думаю все поправит. Что это за звери я поясню тебе за 1000 монет|learn_two~давай!|ask_to_learn~что ты умеешь еще?';
  if ($part == 'learn_two')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (40, 1000);
  }
  $spf['double'] = 'Это поистине великое мастерство! Навык очень сложный, но еси постараешся, станешь мастером этого дела. 1500 серебра. Пока ты еще не джедай, ты сможешь наносить однотипные удары, например два раза рубануть. Урон суммируется.|learn_double~согласен|ask_to_learn~что ты умеешь еще?';
  if ($part == 'learn_double')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (41, 1500);
  }
?>