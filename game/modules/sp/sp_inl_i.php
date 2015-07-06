<?php
  $showed;
  for ($i = 0; $i < $cc; $i++)
  {
    if (isset ($showed[$INL_I[$i]['realname']])) continue;
    if ($INL_I[$i]['type'] == 'o' || $INL_I[$i]['type'] == 'l')
    {
      // nepodvizhnaja veshq
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$INL_I[$i]['fullname'].'">';
      $f .= $INL_I[$i]['name'].'</a> <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$INL_I[$i]['fullname'].'">?</a><br/>';
    }
    elseif ($INL_I[$i]['type'] == 'm') // melkaja
    {
      // melkaja veshq veshq
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=take_misc1&item='.$INL_I[$i]['fullname'].'">';
      $f .= $INL_I[$i]['name'].'</a> (<a class="blue" href="game.php?sid='.$sid.'&action=take_misc2&item='.$INL_I[$i]['fullname'].'&count=1000">'.$INL_I[$i]['on_take'].'</a>) <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$INL_I[$i]['fullname'].'">?</a><br/>';
    }
    elseif (substr ($INL_I[$i]['fullname'], 0, 7) == 'i.f.tra' && $p['skills'][6]) // trava
    {
      // mtrava glazami celitelja
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=take_item&item='.$INL_I[$i]['fullname'].'">';
      $f .= $INL_I[$i]['on_drop'].'</a> ('.$INL_I_C[$INL_I[$i]['realname']].') <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$INL_I[$i]['fullname'].'">?</a><br/>';
    }
    else
    {
      // znacit veshq mozhno podnjatq
      // tak i sdelaem etu ssylku
      $qua = substr ($INL_I[$i]['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= '<a class="'.$qua.'" href="game.php?sid='.$sid.'&action=take_item&item='.$INL_I[$i]['fullname'].'">';
      $f .= $INL_I[$i]['name'].'</a> (<a class="blue" href="game.php?sid='.$sid.'&action=take_item&item='.$INL_I[$i]['realname'].'&all=1">'.$INL_I_C[$INL_I[$i]['realname']].'</a>) <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$INL_I[$i]['fullname'].'">?</a><br/>';
    }
    $showed[$INL_I[$i]['realname']] = 1;
  }
?>