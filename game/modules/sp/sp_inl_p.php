<?php
  // PLAYER /////////////////////////////////////////////////////
  for ($i = 0; $i < $cc; $i++)
  {  
    if ($INL_P[$i]['in_battle'] && $p['in_battle'] && ($INL_P[$i]['in_battle'] != $p['in_battle'])) continue;
    // nachnem s presta
    if ($INL_P[$i]['status1'][0] == 0) $f .= '';
    if ($INL_P[$i]['status1'][0] == 1) $f .= '<span class="red"><b>#</b></span>';
    if ($INL_P[$i]['status1'][0] == 2) $f .= '#';
    // raskraska po statusu
    $span1 = $span2 = $span1e = $span2e = '';
    if ($INL_P[$i]['status1'][1] != 1)
    {
      $span1 = '<span class="';
      if ($INL_P[$i]['status1'][1] == 0) $span1 .= 'blue">';
      if ($INL_P[$i]['status1'][1] == 2) $span1 .= 'yellow">';
      $span1e = '</span>';
    }
    if ($INL_P[$i]['status1'][2] != 0)
    {
      $span2 = '<span class="';
      if ($INL_P[$i]['status1'][2] == 1) $span2 .= 'red">';
      elseif ($INL_P[$i]['status1'][3] == 1) $span2 .= 'green">';
      elseif ($INL_P[$i]['status1'][4] == 1) $span2 .= 'orange">';
      $span2e = '</span>';
    }
    // rassa
    switch ($INL_P[$i]['rase'])
    {
      case 1: $rase = 'ч'; break;
      case 2: $rase = 'э'; break;
      case 3: $rase = 'г'; break;
    }
    $q = do_mysql ("SELECT letter FROM anketa WHERE id_player = '".$INL_P[$i]['id_player']."';");
    $letter = mysql_result ($q, 0);
    if ($letter) $f .= '<b>'.$letter.'</b> ';
    if ($INL_P[$i]['admin'] == 2) $f .= '<b>@</b>';
    if ($INL_P[$i]['admin'] == 1) $f .= '<b>m</b>';
    $f .= '['.$rase.']';
    /*if (!isset($span1)) $span1 = '';
    if (!isset($span1e)) $span1e = '';
    if (!isset($span2)) $span2 = '';
    if (!isset($span2e)) $span2e = '';*/
    // effecty
    $aff = get_affected ($INL_P[$i]['login']);
    if (!$aff) $eff = '';
    else
    {
      $eff = '<small>';
      $aff = implode ('|', $aff);
      include_once ('modules/f_translit.php');
      $aff = translit ($aff);
      $eff .= $aff.'</small>';
    } 
    // urovenq
    $f .= $INL_P[$i]['stats'][0];
    // login -- ssylka napisatq emu soobshenie
    $f .= '<a class="'.$INL_P[$i]['nc'].'" href="game.php?sid='.$sid.'&action=wmsg&to='.$INL_P[$i]['login'].'">';
    $f .= $INL_P[$i]['name'].'</a>';        
    // esli estq poterja zhizni - ukazhem ee kolichestvo v procentah
    if ($INL_P[$i]['life'][0] < $INL_P[$i]['life'][1]) $f .= '['.(round ($INL_P[$i]['life'][0] / $INL_P[$i]['life'][1] * 100)).'%]';
    // esli zho estq klan, ukazhem i ego (*klan*status*)
    if (strlen($INL_P[$i]['clan'][0]) > 0) $f .= ' *'.$INL_P[$i]['clan'][0].'*'.$INL_P[$i]['clan'][1].'*';
    // atakovatq
    $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=attack&to='.$INL_P[$i]['login'].'">x</a> '.$span1.'<b>:</b>'.$span1e.' ';
    // infa
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$INL_P[$i]['login'].'">?</a> '.$span2.'<b>:</b>'.$span2e.' ';
    // dobavitq v druzqja
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=addcontacts&to='.$INL_P[$i]['login'].'">^</a>';
    // proverka boja
    if ($INL_P[$i]['in_battle'] == 1) $f .= '<span class="red">[в бою]</span>';
    if ($INL_P[$i]['in_battle'] == 2) $f .= '<span class="green">[в бою]</span>';

    //if ($INL_P[$i]['walking'] == 2) $f .= '<span class="bet">[летит]</span>';

    $f .= $eff;
    // vse :)
    $f .= '<br/>';
  }
?>