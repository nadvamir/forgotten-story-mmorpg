﻿<?php
  // fail razgovora npc relenskogo lekarja
  $app = '';
  if ($p['smq'][3] == 0)
  {
    $app = '|help~очень нужна! Подскажи что делать с кровотечением';
    if ($part == 'help')
    {
      include_once ('modules/f_gain_item.php');
      gain_item ('i.a.bel.bas.lvl1', 1, $LOGIN);
      gain_item ('i.f.dri.nor.milk', 10, $LOGIN);
      $p['smq'][3] = 1;
      do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
    }
    $spf['help'] = 'Лечить. Вообще я всегда тебе готов помочь, но если вдруг ко мне не сможешь обратится - тебе поможет подорожник. Также можешь попросить охотника обучить тебя регенерации. А еще есть волшебное молоко. Повесь его на пояс, и ты сможешь прекратить кровотечение даже во время битвы. Держи, мне не жалко ;)';
  }
  $spf['start'] = 'Приветствую тебя! Я городской лекарь. Врачеванием занимаюсь, так-сказать. Может тебе нужна помощь?|heal_me~залечи мои раны!|can_i_heal~а не научил бы ты меня своему мастерству?|krovotech~останови мое кровотечение...'.$app;
  if ($part == 'heal_me')
  {
    if ($p['life'][0] == $p['life'][1]) $spf['heal_me'] = 'Да ведь ты здоров!|start~да пока тебя найдешь все само собой заживает...';
    else $spf['heal_me'] = 'Я могу тебе помочь, но за дарма сейчас никто ничего неделает. Я если хочешь, я тебя полностью излечу, но по цене 10 серебреных за 100 жизней. Также избавлю от кровотечения, отравления и ожогов как бонус.|heal~лечи, здоровье важней денег...|no_heal~да за такие деньги! Лучше сдохну!';
  }
  $spf['can_i_heal'] = 'А я на что тогда жить буду? Mаксимум, чему я тебя объучу, это распознование различных трав. Что с ними делать - твое дело. Ну, скидку сделаю, 500 серебреных с тебя.|learn_healer~нифигасе... Ну ладно, я при деньгах, а еще и на продаже трав шанс наварится светится.. Вообщем, валяй!|no_learn~да пошел ты с такими ценами!';
  $spf['no_learn'] = 'Все, иди вон из домика, вежлевей разговаривать поучись!';
  if ($part == 'learn_healer')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (6, 500);
  }
  if ($part == 'heal')
  {
    include_once ('modules/f_heal.php');
    heal ($npc, $LOGIN, 10);
  }
  $spf['no_heal'] = 'Ну тогда пока!';
  if ($part == 'krovotech')
  {
    if ($p['status1'][2] == 0) $spf['krovotech'] = 'у тебя нет ран!';
    else $spf['krovotech'] = 'Я перевяжу твои раны за 3 серебрянных. Согласен?|perevjaz~вяжи|start~нет, сам как-нить';
  }
  if ($part == 'perevjaz')
  {
    include_once ('modules/f_healer_stop_b.php');
    healer_stop_b ($npc, $LOGIN, 3);
  }
?>