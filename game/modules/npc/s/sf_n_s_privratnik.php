﻿<?php
  if ($p['smq'][5] < 2)
  {
    $spf['start'] = '.[молчит. с чего начнете разговор?]|soviet~Товаришь черный! Кемъ будете, налоги государству платите?|normal~Приветствую.|blevyzgos~Кости Икариона! Кого я вижу!?';
    $spf['soviet'] = '..[молчитъ. неплатитъ, видимо...]';
    $spf['normal'] = '...[молчит]';
    $spf['blevyzgos'] = '![резко встал, переложил посох через плече] Где?... Слушай. Иди обратно по дороге, там на восток ведет тропа, иди туда. Увидешь здание. Неоглядывайся, лезь туда. Там в конце коридора усыпальница, в усыпальнице урна, в урне порошек, хватай его, и возвращайся.|no~а если я не пойду?';
    if ($part == 'blevyzgos')
    {
      $p['smq'][5] = 1;
      do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
    }
    $spf['no'] = '![молниеностно посох рушится на близ лежащий камень. Осколки камня разлетаются во все стороны, самый большой, чудом минув вашей головы, глубоко врезается в дуб.] Вопросы есть? Иди.';
  }
  else
  {
    $spf['start'] = 'Принес?|ya~да. Что это?';
    $spf['ya'] = 'Пепел Икариона, если тебе так интерестно. Что тебе о нем известно?|fairytale~да так, детей его костями пугают, сказка такая есть, будто жил такой человек, который так гордился собой, что отважился один пойти в гору орков. Ну и со всеми последствиями.';
    $spf['fairytale'] = '[ледяной хохот] да, славный был дурак, один в Нил\'А\'Дроктос попер. А вообще, древняя кровь, между прочим. Кстате, что про Налит слышно?|wtf~O_o?';
    $spf['wtf'] = 'Чуется мне, ничего. Давно ничего неслышно. Веками ничего не слышно... За порошек я тебя отблагодарю. Держи одежду, я незнаю как сейчас, но когда-то было принято ходить одетым. Правдо, одежда весьма стара, но если не рассыпется, сойдет. Держи нож, он весьма старый, но режет. Сам у халфлинга отобрал, вещица казенная, он им курицу расделывал. Вроде бы все, более тебе в скором времени непонадобится. Я перенесу тебя туда, куда тебе надо. И еще... Моли богов чтоб наши пути больше не перекрестились.|ofcourse~[шагнуть в портал]'; 
    if ($part == 'ofcourse')
    {
      include_once ('modules/f_next_q.php');
      include_once ('modules/f_gain_item.php');
      gain_item ('i.a.bo2.bas.simple.lvl1', 1, $LOGIN);
      gain_item ('i.a.bo2.tun.simple.lvl1', 1, $LOGIN);
      gain_item ('i.a.bo2.fur.simple.lvl1', 1, $LOGIN);
      gain_item ('i.a.leg.bas.old', 1, $LOGIN);
      gain_item ('i.a.leg.tun.old', 1, $LOGIN);
      gain_item ('i.a.leg.fur.old', 1, $LOGIN);
      gain_item ('i.w.kni.bas.1h.lvl1', 1, $LOGIN);
      next_q();
    }
  }
?>