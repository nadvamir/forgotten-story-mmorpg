<?php
  for ($i = 0; $i < $cc; $i++)
  {  
    if ($INL_N[$i]['in_battle'] && $p['in_battle'] && ($INL_N[$i]['in_battle'] != $p['in_battle'])) continue;
    $lvl = $INL_N[$i]['lvl'];
    $md = $lvl - $p['stats'][0];
    if ($md < -1) $clr = '#696969';
    else if ($md == -1) $clr = '#31F3F5';
    else if ($md == 0) $clr = '#006400';
    else if ($md == 1) $clr = '#ff8c00';
    else $clr = '#8b0000';
    // - 
    switch ($INL_N[$i]['type'])
    {
      case 'a':
        $f .= '<span class="green"><b>.</b></span>';
        //if (!$INL_N[$i]['belongs'])
        //  $f .= '<a style="color:'.$clr.'" href="game.php?sid='.$sid.'&action=priru&npc='.$INL_N[$i]['fullname'].'">'.$INL_N[$i]['name'].'</a>';
        if ($INL_N[$i]['belongs'] == $LOGIN)
          $f .= '<a style="color:'.$clr.'" href="game.php?sid='.$sid.'&action=talk_to_priru&npc='.$INL_N[$i]['fullname'].'">'.$INL_N[$i]['name'].'</a>';
        else
         $f .= '<a style="color:'.$clr.'" href="game.php?sid='.$sid.'&action=priru&npc='.$INL_N[$i]['fullname'].'">'.$INL_N[$i]['name'].'</a>';
        //$f .= '<span style="color:'.$clr.'">'.$INL_N[$i]['name'].'</span>';
        $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=attack&to='.$INL_N[$i]['fullname'].'">x</a>';
        break;
      case 'x':
        $f .= '<span class="red"><b>.</b></span>';
        $f .= '<span style="color:'.$clr.'">'.$INL_N[$i]['name'].'</span>';
        $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=attack&to='.$INL_N[$i]['fullname'].'">x</a>';
        break;
      case 's': case 't':
        $f .= '<b>.</b>';
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=speak_npc&npc='.$INL_N[$i]['fullname'].'">'.$INL_N[$i]['name'].'</a>';
        break;
    }
    // dalee
    if ($INL_N[$i]['quest']) $f .= '<b>[!]</b>';
    $f .= ' : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$INL_N[$i]['fullname'].'">?</a>';
    // esli estq poterja zhizni - ukazhem ee kolichestvo v procentah
    if ($INL_N[$i]['life'][0] < $INL_N[$i]['life'][1]) $f .= ' ['.(round ($INL_N[$i]['life'][0] / $INL_N[$i]['life'][1] * 100)).'%]';
    // proverka boja
    if ($INL_N[$i]['in_battle'] == 1) $f .= '<span class="red">[в бою]</span>';
    if ($INL_N[$i]['in_battle'] == 2) $f .= '<span class="green">[в бою]</span>';
    $aff = get_affected ($INL_N[$i]['fullname']);
    if (!$aff) $eff = '';
    else
    {
      $eff = '<small>';
      $aff = implode ('|', $aff);
      include_once ('modules/f_translit.php');
      $aff = translit ($aff);
      $eff .= $aff.'</small>';
    }
    $f .= $eff; 
    $f .= '<br/>';
  }
?>