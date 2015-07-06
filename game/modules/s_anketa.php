<?php
  if (isset ($_GET['about']))
  {
    $country = mysql_real_escape_string (strip_tags ($_GET['country']));
    $city = mysql_real_escape_string (strip_tags ($_GET['city']));
    $about = mysql_real_escape_string (strip_tags ($_GET['about']));

    $country = substr ($country, 0, 50);
    $city = substr ($city, 0, 50);
    $about = substr ($about, 0, 300);
    do_mysql ("UPDATE anketa SET country = '".$country."', city = '".$city."', about='".$about."' WHERE id_player = '".$p['id_player']."';");
    exit_msg ('Я ТЕБЯ ВИЖУ!', 'твои данные успешно переданы мне.');
  }
  else
  {
    $q = do_mysql ("SELECT * FROM anketa WHERE id_player = '".$p['id_player']."';");
    $an = mysql_fetch_assoc ($q);
    $f = '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="anketa"/>';
    $f .= 'страна:<br/><input type="text" name="country" value="'.$an['country'].'"/><br/>';
    $f .= 'город:<br/><input type="text" name="city" value="'.$an['city'].'"/><br/>';
    $f .= 'коротко о себе:<br/><input type="text" name="about" value="'.$an['about'].'" maxlength="300"/><br/>';
    $f .= '<input type="submit" value="вперед!"/>';
    $f .= '</form>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a>';
    exit_msg ('анкета', $f);
  }
?>