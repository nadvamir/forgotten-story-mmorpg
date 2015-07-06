<?php
  // ispolqzovanie zolota, vsja informacija
  $f = '';
  $f .= 'ваш акаунт : <b>';
  switch ($p['account'])
  {
    case 0:  $f .= 'игрок'; break;
    case 1:  $f .= 'охотник'; break;
    case 2:  $f .= 'послушатель'; break;
    case 3:  $f .= 'мастер'; break;
    case 4:  $f .= 'герой'; break;
  }
  $f .= '</b><br/>';
  $f .= 'золотo '.$p['gold'].'<br/>-<br/>';

  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=gold&sa=acc">акаунты</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=gold&sa=sil">конвертировать</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=gold&sa=mall">item mall</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=gold&sa=buy">как получить золото?</a><br/>-<br/>';

  if (!isset ($_GET['sa'])) $_GET['sa'] = '';
  if ($_GET['sa'] == 'acc')
  {
    if (isset ($_GET['set']))
    {
      if ($p['account']) put_g_error ('старый акаунт все еще действует');
      $acc[1] = 1;
      $acc[2] = 1;
      $acc[3] = 1;
      $acc[4] = 3;
      $set = $_GET['set'];
      $days = preg_replace ('/[^0-9]/', '', $_GET['days']);
      if (!isset ($acc[$set])) put_g_error ('нема такого');
      if ($acc[$set] * $days > $p['gold']) put_g_error ('нехватает золота');
      $p['gold'] -= $acc[$set] * $days;
      $p['account'] = $set;
      $p['account_to'] = time() + $days * 60 * 60 * 24;
      do_mysql ("UPDATE players SET gold = '".$p['gold']."', account = '".$p['account']."', account_to = '".$p['account_to']."' WHERE id_player = '".$p['id_player']."';");
      exit_msg ('акаунт установлен', '<a class="blue" href="game.php?sid='.$sid.'&action=gold">вернутся</a>'); 
    }
    $f .= 'акаунты устанавливаются на определеное время, до истекания которого их сменить нелзя<br/>';
    $f .= '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="gold"/>';
    $f .= '<input type="hidden" name="sa" value="acc"/>';

    $f .= '<input type="radio" name="set" value="1"/>';
    $f .= '<b>Охотник</b>:<br/>';
    $f .= 'инвентарь +20мест.<br/>';
    $f .= 'серебро от монстров x2<br/>';
    $f .= 'цена: 1золотoй в день<br/>';
    $f .= '<input type="radio" name="set" value="2"/>';
    $f .= '<b>Послушатель</b>:<br/>';
    $f .= 'невозможно получить никаких эффектов<br/>';
    $f .= 'exp +35%<br/>';
    $f .= 'инвентарь +5мест.<br/>';
    $f .= 'цена: 1золотoй в день<br/>';
    $f .= '<input type="radio" name="set" value="3"/>';
    $f .= '<b>Мастер</b>:<br/>';
    $f .= 'качество созданой вещи от улучшеной<br/>';
    $f .= 'инвентарь +20мест.<br/>';
    $f .= 'цена: 1золотoй в день<br/>';
    $f .= '<input type="radio" name="set" value="4"/>';
    $f .= '<b>Герой</b>:<br/>';
    $f .= 'инвентарь +20мест.<br/>';
    $f .= 'серебро от монстров x2<br/>';
    $f .= 'exp +35%<br/>';
    $f .= 'невозможно получить никаких эффектов<br/>';
    $f .= 'качество созданой вещи от улучшеной<br/>';
    $f .= 'цена: 3золотыx в день<br/>';

    $f .= 'дни:<input type="text" name="days" value="1"/><br/>';
    $f .= '<input type="submit" value="установить"/><br/>';
  }
  else if ($_GET['sa'] == 'sil')
  {
    if (isset ($_GET['g']))
    {
      $g = preg_replace ('/[^0-9]/', '', $_GET['g']);
      if ($g > $p['gold']) put_g_error ('нехватает золота');
      $p['gold'] -= $g;
      $p['money'] += $g * 1000;
      do_mysql ("UPDATE players SET gold = '".$p['gold']."', money = '".$p['money']."' WHERE id_player = '".$p['id_player']."';");
      exit_msg ('обмен совершен', '<a class="blue" href="game.php?sid='.$sid.'&action=gold">вернутся</a>'); 
    }
    $f .= 'текущий курс, установленный черным рынком, 1g = 1000s<br/>';
    $f .= '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="gold"/>';
    $f .= '<input type="hidden" name="sa" value="sil"/>';
    $f .= 'золото:<input type="text" name="g" value="1"/><br/>';
    $f .= '<input type="submit" value="поменять"/><br/>';
  }
  else if ($_GET['sa'] == 'mall')
  {
    // veshi
    $mi['i.f.dri.nor.s17'] = '1|зелье левитации - 1золотой - при использовании вам дается возмоность летать - передвижение через 2 локации, достигаемость только магией и стрелковым оружием';
    $mi['i.q.que.exp_orb'] = '3|сфера опыта - 3золотых - при использовании вас обливают с ног до головы опытом. для получения уровня надо использовать уровень * 2 сфер.';
    $mi['i.q.que.inv2'] = '3|заплечный мешок - 3золотых - устонавливает количество мест до 35 (одноразовый эффект на всегда)';
    $mi['i.q.que.inv3'] = '6|заплечный мешок - 6золотых - устонавливает количество мест до 40 (одноразовый эффект на всегда)';
    $mi['i.q.que.inv4'] = '9|заплечный мешок - 9золотых - устонавливает количество мест до 35, положеные вещи весят на 25% меньше (одноразовый эффект на всегда)';
    $mi['i.q.que.inv5'] = '12|заплечный мешок - 12золотых - устонавливает количество мест до 40, положеные вещи весят на 50% меньше (одноразовый эффект на всегда)';
    $mi['i.q.que.flow_stone'] = '100|цветущий камень - 100золотых - позволяет женится';
    if (isset ($_GET['item']))
    {
      $item = $_GET['item'];
      if (!isset ($mi[$item])) put_g_error ('нет такой вещи в продаже');
      $mi[$item] = explode ('|', $mi[$item]);
      if ($mi[$item][0] > $p['gold']) put_g_error ('нехватает золота');
      $p['gold'] -= $mi[$item][0];
      do_mysql ("UPDATE players SET gold = '".$p['gold']."' WHERE id_player = '".$p['id_player']."';");
      include_once ('modules/f_gain_item.php');
      gain_item ($item, 1, $LOGIN);
      exit_msg ('купля состоялась', '<a class="blue" href="game.php?sid='.$sid.'&action=gold">вернутся</a>'); 
    }
    foreach ($mi as $key => $val)
    {
      $val = explode ('|', $val);
      $f .= $val[1];
      $f .= '<br/><a class="blue" href="game.php?sid='.$sid.'&action=gold&sa=mall&item='.$key.'">купить</a><br/>';
    }
  }
  else if ($_GET['sa'] == 'buy')
  {
    $f .= 'пока — никак. скоро будет';
    //$f .= 'для получения золота надо перевести определеное количество wmz на счет администрации:<br/>';
    //$f .= '<b>Z318250669664</b><br/>';
    //$f .= 'сумма - обезательно целое число. 1wmz - 10золотых. в коментарий ОБЕЗАТЕЛЬНО запишите слово gold и ваш логин, например <b>gold maxx</b>. в течении рабочего дня ваш золотой счет должен пополнится.<br/>';
  }

  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a>';
  exit_msg ('золото', $f);
?>