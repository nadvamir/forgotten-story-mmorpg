﻿<?php
  $wtd = '';
  if ($p['classof'] == 0 && $p['smq'][1] == 1)
  {
    $wtd .= '|stick~откуда мне взять ветку для срелы?';
    $spf['stick'] = 'Срубить с дерева, конечно.|i_cant~а если я неумею?';
    $spf['i_cant'] = 'Ну я могу научить, за определенную плату.|please~получается, мне изза одной ветки учить навык? Ну пожалуйсто, подарите мне одну!';
    $spf['please'] = 'Ну, так уж и быть, держи. Но больше не проси.';
    if ($part == 'please')
    {
      $p['smq'][1] = 2;
      do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
      include_once ('modules/f_gain_item.php');
      gain_item ('i.q.que.vetka', 1, $LOGIN);
    }
  }
  if ($p['classof'] == 0 && $p['smq'][0] == 3)
  {
    $wtd .= '|i_ask~у меня просьба к тебе будет.';
    $spf['i_ask'] = 'Неужели наконец-то кому-то я нужен? И что за просьба?|tab~да так, видишь, мне надо табакерку для Роттена достать, древнюю, что у нечисти-кота в лесу. А мне говорили, что ты плотник неплохой... Может сделаешь?';
    $spf['tab'] = 'Даа, всегда все я! Да ведь ТЕБЕ ее достать надо, это, я так понял, испытание. Вот как оно, a ты все Серпент, Серпент!|please~ну пожалуйсто!|na~ай ну тебя, старый хрынч, и без тебя обойдусь!';
    if ($part == 'please')
    {
      $p['smq'][0] = 6;
      do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
      include_once ('modules/f_gain_item.php');
      gain_item ('i.q.que.tabakerka', 1, $LOGIN);
    }
    if ($part == 'na')
    {
      $p['smq'][0] = 4;
      do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
    }
    $spf['please'] = 'Так уж и быть, подожди маленько. [работаeт] Вот, держи. Но если что, я тебя невидел даже!|sps~спасибо';
    $spf['na'] = 'Ех, убирайся с моих глаз, и доставай табакерку как хочешь!';
  }
  elseif ($p['classof'] == 0 && $p['smq'][0] == 5)
  {
    include_once ('modules/f_has_count.php');
    $c = has_count ('i.q.que.leora_letter', 1, $LOGIN);
    if ($c)
    {
      $wtd .= '|leora~тут тебе Леора письмо прислала...';
      if ($part == 'leora')
      {
        include_once ('modules/f_gain_item.php');
        gain_item ('i.q.que.tabakerka', 1, $LOGIN);
        $p['smq'][0] = 6;
        do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
      }
      $spf['leora'] = 'Дай ка.. Ладно тебе повезло, так уже мог и не надеятся на табакерку. Держи, но в дальнейшем будь повежливей...';
    }
  }
  $spf['sps'] = 'Да незачто, заказы у меня редкие, иногда полезно вспомнить как что делать )|about_plot~расскажи ка про работу плотника';
  $spf['start'] = 'Добро пожаловать. Я тутошный плотник, причем неплохой.|about_plot~можно поподробней про работу плотника?'.$wtd;
  $spf['about_plot'] = 'Хм, ну что я тебе могу сказать... Умея работать с деревом, ты можешь создавать оружие из дерева, стрелы и все тому подобное. В паре с лесорубом очень приятный навык.|lesorub~а лес рубить меня научить неможешь?|lplot~и сколько ето удоволствие cтоит?';
  $spf['lesorub'] = 'Конечно могу. За 600 серебрянных. Тогда тебе останется одеть топор лесоруба, который довольно дешего можно купить у меня, и идти к ближайшему дереву.|learn_treecut~держи деньги|lplot~ну а плотником за сколько стать могу?';
  $spf['lplot'] = 'Я объучу тебя азам за 700 серебрянных. Все инструменты ты также можешь купить у меня.|learn_plot~ок, учи!|lesorub~так походу навык лесоруба тоже нужен. Можешь научить?';
  if ($part == 'learn_plot')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (36, 700);
  }
  if ($part == 'learn_treecut')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (35, 600);
  }
?>