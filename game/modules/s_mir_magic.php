<?php
  // spisok magii
  $f = gen_header ('магия');
  $f .= '<div class="y" id="aeifa5f"><b>кланы:</b></div>';
  if (isset ($_GET['classof']))
  {
    $classof = preg_replace ('/[^0-9]/i', '', $_GET['classof']);
    $type = preg_replace ('/[^a-z]/i', '', $_GET['type']);
    $f .= '<div class="n" id="aclanf">';
    $q = do_mysql ("SELECT name, fullname FROM magic WHERE classof = '".$classof."' AND type = '".$type."' ORDER BY difficulty;");
    while ($mag = mysql_fetch_assoc ($q))
    {
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_magic_info&classof='.$classof.'&type='.$type.'&spell='.$mag['fullname'].'">'.$mag['name'].'</a><br/>';
    }
    $f .= '<b>&#171;</b><a class="blue" href="game.php?sid='.$sid.'&action=mir_magic">к выборy</a>';
    $f .= '</div>';
  }
  else
  {
    $f .= '<div class="n" id="aclanf">';
    $f .= '<form action="game.php" method="get">';
    $f .= 'выберите магию и тип:<br/>';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="mir_magic"/>';
    $f .= '<select name="classof">';
    $f .= '<option value="0">общая</option>';
    $f .= '<option value="1">огня</option>';
    $f .= '<option value="2">воды</option>';
    $f .= '<option value="3">земли</option>';
    $f .= '<option value="4">воздуха</option>';
    $f .= '<option value="5">иллюзии</option>';
    $f .= '<option value="6">подземная</option>';
    $f .= '<option value="7">эльфийская природы</option>';
    $f .= '<option value="8">древнеэльфийская могущественных</option>';
    $f .= '</select><br/>';
    $f .= '<select name="type">';
    $f .= '<option value="war">боевая</option>';
    $f .= '<option value="hea">целебная</option>';
    $f .= '<option value="sum">призыва</option>';
    $f .= '<option value="cre">создания</option>';
    $f .= '</select><br/>';
    $f .= '<input type="submit" value="смотреть"/>';
    $f .= '</form>';
    $f .= '</div>';
  }
  $f .= '<div class="n" id="adi45f">';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a><br />';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a><br />';
  $f .= '</div>';
  $f .= gen_footer ();
  exit ($f);
?>