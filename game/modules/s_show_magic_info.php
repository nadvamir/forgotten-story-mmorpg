<?php
  // pokazatq informaciju o magii.
  $spell = mysql_real_escape_string ($_GET['spell']);
  $q = do_mysql ("SELECT * FROM magic WHERE fullname = '".$spell."';");
  if (!mysql_num_rows ($q)) put_error ('такой магии нет');
  $magic = mysql_fetch_assoc ($q);
  $f = gen_header ('магия');
  $f .= '<div class="y" id="erye"><b>'.$magic['name'].'</b></div><p>';
  switch ($magic['classof'])
  {
    case 1: $f .= 'магия огня'; break;
    case 2: $f .= 'магия воды'; break;
    case 3: $f .= 'магия земли'; break;
    case 4: $f .= 'магия воздуха'; break;
    case 5: $f .= 'магия иллюзии'; break;
    case 6: $f .= 'подземная магия'; break;
    case 7: $f .= 'эльфийская магия природы'; break;
    case 8: $f .= 'древнеэльфийская магия могущественных'; break;
    default: $f .= 'непринадлежит к какому либо классу'; break;
  }
  $f .= '<br/><small>';
  switch ($magic['type'])
  {
    case 'war': $f .= 'боевая магия'; break;
    case 'hea': $f .= 'целебная магия'; break;
    case 'cre': $f .= 'магия создания'; break;
    case 'sum': $f .= 'магия призыва'; break;
  }
  $f .= '</small><br/>';
  if ($magic['dmgmin'] && $magic['dmgmax'])
  {
    $f .= 'мин. урон: '.$magic['dmgmin'].'<br/>';
    $f .= 'макс. урон: '.$magic['dmgmax'].'<br/>';
  }
  if ($magic['lplus'])
  {
    $f .= 'исцеление: '.$magic['lplus'].'<br/>';
  }
  if ($magic['effect'])
  {
    include_once ('modules/f_translit.php');
    $eff = translit ($magic['effect']);
    $f .= 'эффект: '.$eff.'<br/>';
  }
  if ($magic['blood'])
  {
    if ($magic['type'] == 'war') $f .= 'добавляет ';
    else $f .= 'снимает ';
    $f .= 'кровотечение<br/>';
  }
  if ($magic['fire'])
  {
    if ($magic['type'] == 'war') $f .= 'добавляет ';
    else $f .= 'снимает ';
    $f .= 'горение<br/>';
  }
  if ($magic['poison'])
  {
    if ($magic['type'] == 'war') $f .= 'добавляет ';
    else $f .= 'снимает ';
    $f .= 'отравление<br/>';
  }
  $f .= 'слова: <b>'.$magic['words'].'</b><br/>';
  $f .= 'мана -'.$magic['mana'].'<br/>';
  $f .= 'минимальный навык магии: <b>'.$magic['minskill'].'</b><br/>';
  $f .= 'сложность: '.$magic['difficulty'].'<br/>';

  ////////////////// shans igroka v procentah ////////////////
  include_once ('modules/f_get_pl_battle_har.php');
  $har = get_pl_battle_har ($LOGIN);
  if ($magic['classof'] == 0)
  {
    $max = -1;
    $sk = 0;
    for ($i = 22; $i < 30; $i++)
      if ($p['skills'][$i] > $max) { $sk = $i; $max = $p['skills'][$sk]; }
  }
  else $sk = 21 + $magic['classof']; // nomer navyka
  $har[4] += $p['skills'][$sk] * 9;
  $h = $har[4];
  $pr = $h / ($har[4] + $magic['difficulty']) * 100;
  $pr = round ($pr);
  if (!$p['skills'][$sk]) $pr = 0;
  if ($magic['minskill'] > $p['skills'][$sk]) $pr = 0;
  $f .= '<small>ваш шанс: <b>'.$pr.'%</b></small><br/>';

  // reagenty:
  if (!$magic['reagents']) $f .= 'реагентов не требует<br/>';
  else
  {
    // dostavatq iz faila bum:
    $rea = explode ('|', $magic['reagents']);
    $c = count ($rea);
    $f .= 'реагенты: <br/><small>';
    for ($i = 0; $i < $c; $i++)
    {
      if (!$rea[$i]) continue;
      $f .= '-';
      $rea[$i] = explode (':', $rea[$i]);
      $fullname = $rea[$i][0];
      // klass:
      $cl = substr ($fullname, 2, 1);
      // tip
      $tp = substr ($fullname, 4, 3);
      // podkljuchim
      if (!file_exists ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php')) put_error ('<p>cre i -нету такого файла для создания веши: modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php</p>');
      include ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php');
      if (!isset($it[$fullname])) put_error ('<p>такой веши нету в файлах (rea)</p>');
      $it[$fullname] = explode('|', $it[$fullname]);
      $f .= $it[$fullname][0].' : '.$rea[$i][1].'<br/>';
    }
    $f .= '</small>';
  }
  $f .= 'отдых '.$magic['timewait'].'сек<br/>';

  if (isset ($_GET['classof']))
  {
    $f .= '<b>&#171;</b><a class="blue" href="game.php?sid='.$sid.'&action=mir_magic&classof='.$_GET['classof'].'&type='.$_GET['type'].'">назад</a><br/>';
  }
  if (isset ($_GET['npc']))
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$_GET['npc'].'&start2='.$_GET['start2'].'&start='.$_GET['start'].'">торг</a><br/>';
  }
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=show_magic">магия</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>