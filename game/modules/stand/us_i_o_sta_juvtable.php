<?php
  if (!$p['skills'][39]) put_g_error ('Ювелирных навыков нет, так может нестоeт соватся?');

  // esli uzhe vybrali камень
  if (isset ($_GET['to']))
  {
    $to = preg_replace ('/[^a-z-0-9\._]/i', '', $_GET['to']);
    if (!$to) put_g_error ('а камень то какой?');
    if (!isset ($_GET['it']))
    {
      $f = '';
      $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in <> 'ban' AND is_in <> 'mar' AND (type = 'w' OR type = 'a' OR type = 'x') AND (jewel = '' OR jewel = '0');");
      while ($i = mysql_fetch_assoc ($q))
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&to='.$to.'&it='.$i['fullname'].'">'.$i['name'].'</a><br/>';
      exit_msg ('выберите вешь', $f);
    }
    // v inom sluchae berem etu veshq:
    $it = preg_replace ('/[^a-z-0-9\._]/i', '', $_GET['it']);
    if (!$it) put_g_error ('а вешь та какая?');
    // proverjaem, estq li kamenq i veshq:
    $q = do_mysql ("SELECT fullname, name, on_use, realname FROM items WHERE fullname = '".$to."' AND belongs = '".$LOGIN."' AND is_in <> 'ban';");
    if (!mysql_num_rows ($q)) put_error ('нема камня');
    $j = mysql_fetch_assoc ($q);
    $jewel = substr ($j['realname'], 12);

    $q = do_mysql ("SELECT fullname, name, dmg, armor, type FROM items WHERE fullname = '".$it."' AND belongs = '".$LOGIN."' AND is_in <> 'ban' AND (type = 'w' OR type = 'a' OR type = 'x') AND (jewel = '' OR jewel = '0');");
    if (!mysql_num_rows ($q)) put_error ('нема вещи');
    $i = mysql_fetch_assoc ($q);
    $i['name'] .= '*';

    include_once ('modules/f_delete_item.php');
    delete_item ($to);

    // dalee v zavisimosti ot kamnja i kuda vstavljaem (kamni opredeljajutsja po on_use)
    // esli voobshe chtoto vyshlo
    $pts = $p['skills'][39] * 5 + $p['skills'][1] * ($MIN_BET + 1);
    $pts = $pts * 100 / $j['on_use'];
    if (rand (0, 100) > $pts)
    {
      exit_msg ('ювелир', 'вам неудалось вставить камень. камень испорчен');
    }
    if ($j['on_use'] < 20)
    {
      // kamni povyshajushie prochnostq
      // hvataet prosto zapisatq ih imja v jewel
      do_mysql ("UPDATE items SET name = '".$i['name']."', jewel = '".$jewel."' WHERE fullname = '".$it."';");
    }
    else
    {
      global $I_J;
      // inache zavisit ot veshi v kotoruju inkrustirujut - 
      if ($i['type'] == 'w')
      {
        // uvelichim dmg
        $i['dmg'] = explode ('~', $i['dmg']);
        for ($a = 0; $a < 5; $a++)
        {
          $i['dmg'][$a] = explode ('-', $i['dmg'][$a]);
          $i['dmg'][$a][0] = round ($i['dmg'][$a][0] * $I_J[$jewel]['dmg']);
          $i['dmg'][$a][1] = round ($i['dmg'][$a][1] * $I_J[$jewel]['dmg']);
          $i['dmg'][$a] = $i['dmg'][$a][0].'-'.$i['dmg'][$a][1];
        }
        $i['dmg'] = implode ('~', $i['dmg']);
        do_mysql ("UPDATE items SET dmg = '".$i['dmg']."', jewel = '".$jewel."', name = '".$i['name']."' WHERE fullname = '".$it."';");
      }
      if ($i['type'] == 'a')
      {
        // uvelichim bronju
        $i['armor'] = explode ('~', $i['armor']);
        for ($a = 0; $a < 5; $a++)
        {
          $i['armor'][$a] = round ($i['armor'][$a] * $I_J[$jewel]['arm']);
        }
        $i['armor'] = implode ('~', $i['armor']);
        do_mysql ("UPDATE items SET armor = '".$i['armor']."', jewel = '".$jewel."', name = '".$i['name']."' WHERE fullname = '".$it."';");
      }
      else
        do_mysql ("UPDATE items SET name = '".$i['name']."', jewel = '".$jewel."' WHERE fullname = '".$it."';");
    }
    exit_msg ('ювелир', 'вы вставили '.$j['name'].' в '.$i['name'].'!');
  }
  else
  {
    include_once ('modules/f_list_inventory.php');
    $f = list_inventory ($LOGIN, 'i.q.que.jew', 'use_stand&item='.$item);
    exit_msg ('выберите камень', $f);
  }
?>