<?php
  // pustoj svitok. pri prjamom ispolqzovanii ego mozhno pometitq pod portal, vtoroj raz portal sozdaetsja
  $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$item."';");
  $loc = mysql_result ($q, 0);
  if ($loc)
  {
    // sozdaem portal
    // maksimalqnyj navyk magii
    $max = -1;
    $sk = -1;
    for ($i = 22; $i < 30; $i++)
      if ($p['skills'][$i] > $max) { $sk = $i; $max = $p['skills'][$sk]; }
    if (rand (0, 100) <= ($p['skills'][2] * 5 + $p['skills'][$sk] * 4 + $p['skills'][4]) && $sk)
    {
      $t = ($p['skills'][2] + $p['skills'][$sk] + $p['skills'][4]) * 2;
      $itn = 'i.o.sta.portal~'.$loc.'~'.$p['location'].'~'.$t;
      include_once ('modules/f_create_item.php');
      $portal = create_item ($itn);
      include_once ('modules/f_add_item_to_loc.php');
      add_item_to_loc ($p['location'], $portal);
      add_journal ('Вы долго вглядывались в намалеванный пейзаж, пока тот четко не возник перед глазами.', $LOGIN);
      add_journal ('<b>Вдруг воздух расступился, и появилась пустота. Через какое-то мгновенье пустота привратилась в пейзаж, отличный от укружающей вас местности.</b>', 'l.'.$p['location']);
      add_journal ('<b>Вдруг воздух расступился, и появилась пустота. Через какое-то мгновенье пустота привратилась в пейзаж, отличный от укружающей вас местности.</b>', 'l.'.$loc);
    }
    else
    {
      include_once ('modules/f_delete_item.php');
      delete_item ($item);
      add_journal ('Вы долго любовались намалеванным пейзажом, и решили что ему самое место в фондах эрмитажа. Тут свиток изщез.', $LOGIN);
    }
  }
  else
  {
    // metim svitok
    // maksimalqnyj navyk magii
    $max = -1;
    $sk = -1;
    for ($i = 22; $i < 30; $i++)
      if ($p['skills'][$i] > $max) { $sk = $i; $max = $p['skills'][$sk]; }
    if (rand (0, 100) <= ($p['skills'][2] * 7 + $p['skills'][$sk] * 5 + $p['skills'][4]) && $sk)
    {
      // pometili uspeshno
      include_once ('modules/f_delete_item.php');
      delete_item ($item);
      include_once ('modules/f_gain_item.php');
      gain_item ('i.q.que.tscroll', 1, $LOGIN);
      $q = do_mysql ("SELECT fullname FROM items WHERE realname = 'i.q.que.tscroll' AND belongs = '".$LOGIN."' ORDER BY id_item DESC LIMIT 1;");
      $item = mysql_result ($q, 0);
      include_once ('modules/f_loc.php');
      $loc = loc ($p['location'], 'locinfo');
      $name = 'свиток портал '.$loc[1];
      $rn = 'i.q.que.tscroll.'.$p['location'];
      $rn = str_replace ('|', '.', $rn);
      do_mysql ("UPDATE items SET name = '".$name."', on_take = '".$p['location']."', realname = '".$rn."' WHERE fullname = '".$item."';");
      add_journal ('недолго думая вы мастерски нарисовали на свитке пейзаж окружающей вас местности. Возможно, когданибудь это поможет вам сюда вернутся...<br/>', $LOGIN);
    }
    else
    {
      include_once ('modules/f_delete_item.php');
      delete_item ($item);
      add_journal ('вы рисовали магические знаки на свитке до тех пор, пока он стал пригоден лишь для похода в кусты...<br/>', $LOGIN);
      include_once ('modules/f_gain_item.php');
      gain_item ('i.q.que.toiletpaper', 1, $LOGIN);
    }
  }
?>