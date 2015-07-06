<?php
  // podatq zajavku v klan:
  if ($p['admin'] > 0)
  {
    $f = '';
    if (isset ($_GET['fullname']))
    {
      // dannye slali
      $name = mysql_real_escape_string (strip_tags ($_GET['name']));
      $fullname = mysql_real_escape_string (strip_tags ($_GET['fullname']));
      $class = mysql_real_escape_string (strip_tags ($_GET['class']));
      $type = mysql_real_escape_string (strip_tags ($_GET['type']));
      $creates = mysql_real_escape_string (strip_tags ($_GET['creates']));
      $effect = mysql_real_escape_string (strip_tags ($_GET['effect']));
      $blood = mysql_real_escape_string (strip_tags ($_GET['blood']));
      $fire = mysql_real_escape_string (strip_tags ($_GET['fire']));
      $poison = mysql_real_escape_string (strip_tags ($_GET['poison']));
      $words = mysql_real_escape_string (strip_tags ($_GET['words']));
      $lvl = mysql_real_escape_string (strip_tags ($_GET['lvl']));
      $diff = mysql_real_escape_string (strip_tags ($_GET['diff']));
      $rea = mysql_real_escape_string (strip_tags ($_GET['rea']));
      $relax = mysql_real_escape_string (strip_tags ($_GET['relax']));
      $cost = mysql_real_escape_string (strip_tags ($_GET['cost']));
      if ($type == 'war')
      {
        $mindmg = (27 + $diff) * $lvl;
        $maxdmg = (29 + $diff) * $lvl;
      }
      else $mindmg = $maxdmg = 0;
      if ($type == 'hea') $lplus = (50 + $diff) * $lvl;
      else $lplus = 0;
      $skill = $lvl;
      if ($diff > 1) $skill++;
      $mana = $lvl * (9 + $diff * 2);
      $difficulty = (14 + ($diff * 2)) * $lvl;
      $m = "INSERT INTO magic VALUES ('".$fullname."', '".$name."', '".$class."', '".$type."', '".$mindmg."', '".$maxdmg."', '".$lplus."', '".$creates."', '".$effect."', '".$blood."', '".$fire."', '".$poison."', '".$words."', '".$mana."', '".$skill."', '".$difficulty."', '".$rea."', '".$relax."');\n";
      $s = "  \$it['i.s.".$type.".".$fullname."']  = 'свиток ".$name."|i.s.".$type.".".$fullname."|s|".$fullname."|||".$cost."|||||0';\n";
      if (!file_exists ('modules/posts/newmagic.txt')) $fw1 = fopen ('modules/posts/newmagic.txt', 'w');
      else $fw1 = fopen ('modules/posts/newmagic.txt', 'a');
      fwrite ($fw1, $m);
      fclose ($fw1);
      if (!file_exists ('modules/posts/newscrolls.txt')) $fw2 = fopen ('modules/posts/newscrolls.txt', 'w');
      else $fw2 = fopen ('modules/posts/newscrolls.txt', 'a');
      fwrite ($fw2, $s);
      fclose ($fw2);
      exit_msg ('ok!', '<a class="blue" href="game.php?sid='.$sid.'&action=generate_magic">назад</a>');
    }
    else
    {
      // forma
      $f = '<form action="game.php" method="get">';
      $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
      $f .= '<input type="hidden" name="action" value="generate_magic"/>';
      $f .= 'название:<br/><input type="text" name="name"/>';
      $f .= '<br/>кодовое названия (без пробелов, латиница, без спецзнаков (magicarrow):<br/><input type="text" name="fullname"/>';
      $f .= '<br/>класс (0 все, 1 огонь, 2вода, 3 земля, 4 воздух):<br/><input type="text" name="class"/>';
      $f .= '<br/>тип (war боевая, hea лечение, sum призыв, cre создания вещей):<br/><input type="text" name="type"/>';
      $f .= '<br/>что создает (для создания и призыва, пишите что хотите, вставлю сам):<br/><input type="text" name="creates"/>';
      $f .= '<br/>эффект, который наносит (oglushen) (сами если придумаете опишите на форуме эффект):<br/><input type="text" name="effect"/>';
      $f .= '<br/>кровотечение (боевое наносит, целебное лечит) (0 или 1):<br/><input type="text" name="blood"/>';
      $f .= '<br/>огонь (так же):<br/><input type="text" name="fire"/>';
      $f .= '<br/>яд (так же):<br/><input type="text" name="poison"/>';
      $f .= '<br/>слова:<br/><input type="text" name="words"/>';
      $f .= '<br/>уровень игрока, в среднем чтоб этот закл использовал:<br/><input type="text" name="lvl"/>';
      $f .= '<br/>сложность (0 легко, 1 нормально, 2 тежелей, 3 тежелое заклинание, язык вывихнишь...):<br/><input type="text" name="diff"/>';
      $f .= '<br/>реагенты ( название:количество|название:количество и так далее <a class="blue" href="game.php?sid='.$sid.'&action=show_rea_list">список</a>):<br/><input type="text" name="rea"/>';
      $f .= '<br/>время отдыха после него, секундами):<br/><input type="text" name="relax"/>';
      $f .= '<br/>цена свитка серебром:):<br/><input type="text" name="cost"/>';
      $f .= '<br/><input type="submit" value="генерировать!"/>';
      $f .= '</form>';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=moder"/>модераторская</a><br/>';
      exit_msg ('генерация магии', $f);
    }
  }
?>