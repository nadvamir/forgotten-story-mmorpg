﻿<?php
  $wtd = '';
  if ($p['smq'][2] == 1 || $p['smq'][2] == 2)
  {
    include_once ('modules/f_has_count.php');
    $c = has_count ('i.q.que.zagogulina', 1, $LOGIN);
    if (!$c)
    {
      $wtd .= '|silir~Мне Силир говорил, что ты второе задание мне дашь.';
      $spf['silir'] = 'Так ты от него? Не завидую... И что сделать надо было? Перо принести? Хех, значит он трезвый был, ато однажды какая-то девушка к нему просить задания пришла, так он ее на 9 месяцев озадачил, но о чем я тут... Вообшем должен ты уметь с природой общатся и доставать все, что тебе надо. Я вообше слыхал что Лешие носят с собой какие-то загогулины. Так мне интерестно стало, и ты тут) Принеси одну мне. Что? Доставай как хочешь и откуда хочешь.';
    }
    if ($c)
    {
      $wtd .= '|zagogulina~я тебе ту загагулину принес. Странная вешь, если честно';
      if ($part == 'zagogulina')
      {
        $p['smq'][2] = 3;
        do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
        include_once ('modules/f_gain_peace_exp.php');
        gain_peace_exp (50, $LOGIN);
        include_once ('modules/f_delete_count.php');
        delete_count ('i.q.que.zagogulina', 1, $LOGIN);
      }
      $spf['zagogulina'] = 'Какую? Ааа, ЭТУ загогулину... А я просил? Ааа, вспомнил, это задание, да? Говоришь лешие такие веши носят? Ничего себе, незнал, спасибо. Иди к Фьюярну или как там его, поспрашивай про задания. (Надо же, загогулина...)';
    }
  }
  if ($p['smq'][2] == 4)
  {
    include_once ('modules/f_has_count.php');
    $c = has_count ('i.f.dri.nor.water', 1, $LOGIN);
    if (!$c)
    {
      $wtd .= '|was~Был я у Фьюярна.';
      $spf['was'] = 'Да? Ой, наверно забыл тебе напомнить, он безумец, хоть и ужастно мошьный маг. А может быть и сошел с ума от своей силы.Почему надо его задание выполнить? Просто традиция такая. А, кстати, какое задание тебе дали?|ros~утреней росы принести';
      $spf['ros'] = 'Даа, mon ami, кранты тебе. Он еще не настолько крышей съехал чтоб воду за росу принять. А роса росой является пока на траве. Донести с травой тебе тоже невыйдет. Оба, одно заклинание вспомнил! Что, если его на воду наложить? Давай попробуем, самому интерестно стало, вдрук выйдет? Принеси мне воду. Купи бутылку у Неретора, подойди к озеру, что в лесу Красной птици, и используй. Потом неси ко мне. Вроде все сказал...';
    }
    else
    {
      $wtd .= '|water~вот вода';
      $spf['water'] = 'Какая? Нет, что из озера вижу, пить страшно, грязная такая, а мне то она зачем?  Тебе помочь? Как? А, говоришь росу из нее сделать? Как я тебе ее сделаю, ведь роса это... А! Вспомнил, извини старика..|skleroz~ничего, склероз хорошая болезнь, ничего неболит, а каждый день что-то новое узнаешь...';
      $spf['skleroz'] = 'Точно. Дай-ка... Fljur! Ба! Чистейшая роса! А была тина болотная... Держи, неси ему, побыстрей бы избавится от него тебе )';
      if ($part == 'skleroz')
      {
        $p['smq'][2] = 5;
        do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
        include_once ('modules/f_gain_item.php');
        include_once ('modules/f_delete_count.php');
        delete_count ('i.f.dri.nor.water', 1, $LOGIN);
        gain_item ('i.q.que.rosa', 1, $LOGIN);
      }
    }
  }

  if ($p['smq'][8] == 2)
  {
    $wtd .= '|sun~расскажи мне про ритуал солнца.';
    $spf['sun'] = 'Зачем тебе?|greg~Грег просил разузнать|ilike~да Велдир упомянул такой, но отмахнулся нехваткой времени что бы пояснить. Я думаю, это очень интерестный ритуал?';
    $spf['ilike'] = 'У меня тоже его нет...';
    if ($part == 'ilike') set_smq (8, 3);
    $spf['greg'] = 'Он то откуда знает?|dont~я то почем знаю...';
    $spf['dont'] = 'Это все очень странно... Доложи Велдиру что Грег интересуется ритуалом...';
    if ($part == 'dont') set_smq (8, 4);
  }

  $spf['start'] = 'Приветствую тебя! Я Левоний, маг земли. Чем тебе помочь?|magic~я хочу про магию подробней разузнать'.$wtd;
  $spf['magic'] = 'Эх пришел бы ты ко мне раньше, пока я все не забыл... Были времена, я землю сотресал и вся нечисть вокруг дохли как мухи! Ну а сейчас я разве что принцыпам магии земли могу объучить, или так про магов историй порасказывать...|learn~объучи меня этой магии|how_cast~а как вообше заклинания кастовать?|how_learn~как новое заклинание выучить?|learn2~какие еще есть полезные магические навыки?';
  $spf['learn'] = 'Ну, впринципе могу. Только незабудь, что все хотят поесть, а адептов как-то маловато... Дай мне серебра эдак 700 и я тебе все расскажу...|learn_earth~для хороших людей ничего нежалко! Держи|magic~Ну не, рассказывай про чтонибудь другое.';
  $spf['how_cast'] = 'Да как хочешь вообше-то. Ну выучи заклинание наизусть и с помошью реагентов кастуй. Или просто со свитков читай, правда одноразовый вариянт. Идиальнее всего с книги магии, но никто за тебя ее не создаст, а сам только выучив архимагию можешь. Вообшем это к Велдиру. Кстати, с книг кастуя кроме маны ты ничего не расходуешь. Выгодно ведь?|how_learn~да, а как наизусть учить?';
  $spf['how_learn'] = 'Методом зубрежки. Шутка конечно, по началу ты даже не поймешь ни слова что там написано. Ах да, учатся со свитков, если незнал. Впринцuпе тебя этому научить может каждый человек что в этой школе, но советую идти к Велдиру, он хотябы здравый разум сохранил. Не, это не потому что меньше знает. Меньше пользовался. И с умом. Знаешь, магия свое забирает, в старости почувствуешь, у меня память шатается, Силир соовсем ветренный стал, Фью... как там его, он помешался ища заветные заклинания, которые доказали бы, что магия огня слабее магии воды. Фергис вообше палладин. А Велдир как-то держится. Вот к нему и иди, с собой свиток только возьми. Заболтался я что-то...';
  $spf['learn2'] = 'Если хочешь, я научу тебя сопротивлятся магии, уклонятся от магии и парировать магию. Разница у этих навыков в том, что в случае уклона магия вреда не принесет, а в случае остальных двух это зависит от навыков. Блокировать можно и на 100%, а сопротивление только на 70%. Поэтому и цена на объучение - 900, 800, 700 серебра соответственно.|learn_ukl~научи меня уклонятся|learn_par~научи меня блокировать магию|learn_sop~найчи меня сопротивлятся магии';
  if ($part == 'learn_earth')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (24, 700);
  }
  if ($part == 'learn_ukl')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (19, 900);
  }
  if ($part == 'learn_par')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (20, 800);
  }
  if ($part == 'learn_sop')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (21, 700);
  }
?>