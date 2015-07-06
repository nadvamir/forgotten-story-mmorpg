<?php
  $spf['start'] = 'Да сойдет на тебя снизхождение Расильфа!|what~чего, простите?|marry~свадьбу пора устраивать. Непоможешь?';
  $spf['marry'] = 'Рано тебе еще.|please~ну пожалуйсто...';
  $no = 0;
  if ($p['gender'] == 'male')
  {
    $spf['please'] = 'зачем?';
    if ($p['smq'][6] == 0)
    {
      if ($part == 'please') set_smq (6, 1);
      $spf['please'] = 'Ну ладно, помогу. Тебе надо принести цветущий камень. Это южные камни, по легенде они росли в пустынях Кантана. Но лорд Валитор принес такой на каменистое поле. По традиции для женитьбы ты должен иметь цветущий камень. Доставай как хочешь, но, думаю, библиотекарь сможет тебе что-нибудь да подсказать.';
    }
    else if ($p['smq'][6] < 5)
    {
      $spf['please'] = 'Неси цветущий камень.';
    }
    include_once ('modules/f_has_count.php');
    if (has_count ('i.q.que.flow_stone', 1, $LOGIN))
    {
      $spf['please'] = 'Вижу, камень при тебе. Я напишу на нем твое имя, дай его своей возлюбленной. И поговори со мной. Та девушка которая будет находится в храме и будет иметь камень, будет считатся твоей женой. '; 
      if ($part == 'please' && $p['smq'][6] < 6)
      {
        do_mysql ("UPDATE items SET name = 'Цветущий Камень (".$p['name'].")', on_take = '".$LOGIN."' WHERE realname = 'i.q.que.flow_stone' AND belongs = '".$LOGIN."' AND is_in = 'inv';");
        set_smq (6, 6);
        $no = 1;
      }
    }
    if ($p['smq'][6] == 6 && !$no)
    {
      $spf['please'] = 'Ты уверен в своем решении? Если ответишь да, ты обвенчаешся с той, у которой камень.|yes~Да.';
      $spf['yes'] = 'Обьявляю вас мужем и женой!';
      if ($part == 'yes')
      {
        $q = do_mysql ("SELECT belongs FROM items WHERE realname = 'i.q.que.flow_stone' AND on_take = '".$LOGIN."' AND belongs != '".$LOGIN."';");
        if (!mysql_num_rows ($q)) put_g_error ('и у кого камень?');
        $log = mysql_result ($q, 0);
        $q = do_mysql ("SELECT name FROM players WHERE login = '".$log."' AND location = 'rele|1x4' AND gender = 'female';");
        if (!mysql_num_rows ($q)) put_g_error ('и у кого камень?');
        $name = mysql_result ($q, 0);
        do_mysql ("UPDATE players SET marry = '".$log."' WHERE login = '".$LOGIN."';");
        do_mysql ("UPDATE players SET marry = '".$LOGIN."' WHERE login = '".$log."';");
        set_smq (6, 7);
      }
    }
  }
  else
  {
    $spf['please'] = 'Ну ладно, помогу. Пришли избранника, все обьясню ему.';
  }
  $spf['what'] = '[Посмотрел с ужасом ] Э-это Бог главный нашь...';
?>