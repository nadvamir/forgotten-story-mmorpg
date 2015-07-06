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
?>