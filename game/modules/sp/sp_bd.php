<?php
  // b ystrye dejstvija
  $f .= '<div class="y" id="bd">';
  $f .= '<a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=bd&set=0">-</a>';
  $f .= '<b>действия</b></div><div class="n" id="oey5">';
  $f .= '<form action="game.php" method="get">';
  $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
  $f .= '<input type="hidden" name="action" value="bd"/>';
  $f .= '<select name="bd">';
  // tipy urona:
  include_once ('modules/f_get_dmg.php');
  $pl_dmg = get_dmg($LOGIN);
  if ($pl_dmg[0][1]) $f .= '<option value="0">></option>';
  if ($pl_dmg[1][1]) $f .= '<option value="1">x</option>';
  if ($pl_dmg[2][1]) $f .= '<option value="2">o</option>';
  if ($pl_dmg[3][1]) $f .= '<option value="3">^</option>';
  // bd.
  for ($i = 0; $i < 10; $i++)
  {
    $bd = explode ('~', $p['bd'][$i]);
    if (!$bd[0]) continue;
    else
    {
      $f .= '<option value="'.($i + 4).'">';
      $f .= ($i + 1);
      $f .= '</option>';
    }
  }
  $f .= '</select>';
  // celq:
  $f .= '<select name="to">';
  // sam:
  $f .= '<option value="'.$LOGIN.'">'.$p['name'].'</option>';
  // igroki:
  $cc = count ($INL_P);
  $cc--;
  for ($i = 0; $i < $cc; $i++)
    $f .= '<option value="'.$INL_P[$i]['login'].'">'.$INL_P[$i]['name'].'</option>';
  // npc:
  $cc = count ($INL_N);
  $cc--;
  for ($i = 0; $i < $cc; $i++)
    $f .= '<option value="'.$INL_N[$i]['fullname'].'">'.$INL_N[$i]['name'].'</option>';
  $f .= '</select>';
  // BUTTON:
  $f .= '<input type="submit" value="&#187;"/></form>';
  $f .= '</div>';
?>