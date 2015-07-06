<?php
  // market (mesto gde ljudi torgujut mezh soboj)
  // esli ukazanno kupitq, bystro podkljuchim fajl pokupki
  $c = 0;
  if (isset ($_GET['buy'])) include 'modules/s_buy_from_market.php';
  // nado snachalo vybratq esli che chto pokazyvatq:
  if (!isset ($_GET['type']))
  {
    // oruzhie:
    $f = '<b>оружие</b><br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.w.arb%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.w.arb">арбалеты</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.w.axe%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.w.axe">топоры</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.w.bow%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.w.bow">луки</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.w.ham%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.w.ham">молоты</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.w.kli%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.w.kli">эгзотическое</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.w.kni%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.w.kni">ножи</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.w.spe%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.w.spe">копья</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.w.swo%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.w.swo">мечи</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.w.tre%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.w.tre">древковое</a> ('.$c.')<br/>';
    // bronja
    $f .= '<b>броня</b><br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.a.amu%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.a.amu">амулеты</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.a.bel%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.a.bel">пояса</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.a.bo1%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.a.bo1">броня</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.a.bo2%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.a.bo2">рубахи</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.a.bot%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.a.bot">ботинки</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.a.glo%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.a.glo">перчатки</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.a.hea%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.a.hea">шлема</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.a.leg%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.a.leg">штаны</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.a.pon%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.a.pon">поножи</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.a.rin%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.a.rin">кольца</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.a.sho%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.a.sho">наплечники</a> ('.$c.')<br/>';
    // magicheskie knigi
    $f .= '<b>книги</b><br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.b.mag%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.b.mag">магические</a> ('.$c.')<br/>';
    // celebnoe
    $f .= '<b>целебное</b><br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.f.foo%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.f.foo">еда</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.f.dri%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.f.dri">напитки</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.f.tra%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.f.tra">травы</a> ('.$c.')<br/>';
    // melkoe
    $f .= '<b>мелкое</b><br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.m.arr%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.m.arr">стрелы</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.m.rea%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.m.rea">реагенты</a> ('.$c.')<br/>';
    // raznoe
    $f .= '<b>разное</b><br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.q.hun%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.q.hun">трофеи</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.q.que%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.q.que">реально разное</a> ('.$c.')<br/>';
    // svitki
    $f .= '<b>свитки</b><br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.s.cre%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.s.cre">создания</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.s.hea%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.s.hea">целительные</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.s.sum%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.s.sum">призыва</a> ('.$c.')<br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.s.war%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.s.war">боевые</a> ('.$c.')<br/>';
    // wity
    $f .= '<b>щиты</b><br/>';
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE 'i.x.shi%';"); $c = mysql_result ($q, 0);
    $f .= '- <a class="blue" href="game.php?sid='.$sid.'&action=market&type=i.x.shi">щиты</a> ('.$c.')<br/>';
    $f .= '<b><a class="blue" href="game.php?sid='.$sid.'&action=put_to_market">выставить вещь на продажу</a></b><br/>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=reserve_place">забронировать место</a>';
    exit_msg ('прилавки', $f);
  }
  // dalee pri uzhe vybrannom varijante:
  $type = mysql_real_escape_string ($_GET['type']);
  // berem start - :
  $show = 10;
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE is_in = 'mar' AND realname LIKE '".$type."%';");
  if (!isset ($_GET['start'])) $start = 0;
  else $start = $_GET['start'];
  if ($start >= $c) $start = $c - $show;
  if ($start < 0) $start = 0;
  // zapros:
  $q = do_mysql ("SELECT fullname, name, belongs, pprice, on_take, on_drop FROM items WHERE is_in = 'mar' AND realname LIKE '".$type."%' ORDER BY pprice DESC LIMIT ".$start.", ".$show.";");
  $f = '';
  if (isset ($SYSMSG))
  {
    $f .= '<div class="n" id="kjg4">'.$SYSMSG.'</div>';
  }
  while ($i = mysql_fetch_assoc ($q))
  {
    // berem tip dlja razykrashivanija
    $qua = substr ($i['fullname'], 8, 3);
    $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
    if (strpos ($qlist, $qua) === false) $qua = 'blue';
    if (substr ($i['fullname'], 0, 7) == 'i.f.tra') $i['name'] = $i['on_drop'];
    $id = is_player ($i['belongs']);
    $q2 = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
    $name = mysql_result ($q2, 0);
    $f .= '- <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=market&buy='.$i['fullname'].'&type='.$type.'&start='.$start.'">'.$i['name'].'</a>: ['.$i['on_take'].'] : '.$i['pprice'].'c. : '.$name;
    $f .= ' : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$i['fullname'].'&type='.$type.'&start='.$start.'">?</a>';
    $f .= '<br/>';
  }
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=market">назад</a>';
  exit_msg ('прилавки', $f);
?>