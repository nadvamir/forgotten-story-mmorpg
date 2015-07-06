<?php
  // igrok v lokacii
        $pl = get_pl_info ($inloc[$i], 'main');
        // nachnem s presta
        if ($pl['status1'][0] == 0) $f .= '';
        if ($pl['status1'][0] == 1) $f .= '!';
        if ($pl['status1'][0] == 2) $f .= '#';
        // raskraska po statusu
        if ($pl['status1'][1] != 1)
        {
          $span1 = '<span class="';
          if ($pl['status1'][1] == 0) $span1 .= 'blue">';
          if ($pl['status1'][1] == 2) $span1 .= 'yellow">';
          $span1e = '</span>';
        }
        if ($pl['status1'][2] != 0)
        {
          $span2 = '<span class="';
          if ($pl['status1'][2] == 1) $span2 .= 'red">';
          elseif ($pl['status1'][3] == 1) $span2 .= 'green">';
          elseif ($pl['status1'][4] == 1) $span2 .= 'orange">';
          $span2e = '</span>';
        }
        // rassa
        switch ($pl['rase'])
        {
          case 1: $rase = 'ч'; break;
          case 2: $rase = 'э'; break;
          case 3: $rase = 'г'; break;
        }
        if (!isset($span1)) $span1 = '';
        if (!isset($span1e)) $span1e = '';
        if (!isset($span2)) $span2 = '';
        if (!isset($span2e)) $span2e = '';
        $f .= '('.$rase.')';
        // urovenq
        $f .= $pl['stats'][0];
        // login -- ssylka napisatq emu soobshenie
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=wmsg&to='.$inloc[$i].'">';
        $f .= $inloc[$i].'</a>';        
        // esli estq poterja zhizni - ukazhem ee kolichestvo v procentah
        if ($pl['life'][0] < $pl['life'][1]) $f .= '['.(round ($pl['life'][0] / $pl['life'][1] * 100)).'%]';
        // esli zho estq klan, ukazhem i ego (*klan*status*)
        if (strlen($pl['clan'][0]) > 0) $f .= ' *'.$pl['clan'][0].'*'.$pl['clan'][1].'*';
        // atakovatq
        $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=attack&to='.$inloc[$i].'">x</a> '.$span1.':'.$span1e.' ';
        // infa
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$inloc[$i].'">?</a> '.$span2.':'.$span2e.' ';
        // dobavitq v druzqja
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=addcontacts&to='.$inloc[$i].'">^</a>';
        // proverka boja
        $qb = do_mysql ("SELECT in_battle FROM players WHERE login = '".$inloc[$i]."';");
        $pb = mysql_result ($qb, 0);
        if ($pb) $f .= '<в бою>';
        // vse :)
        $f .= '<br/>';
        continue;
?>