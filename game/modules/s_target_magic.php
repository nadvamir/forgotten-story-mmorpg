<?php
  // celitsja kogda kastueshq s golovy:
  $spell = mysql_real_escape_string ($_GET['spell']);
  $f = gen_header ('магия');
  $f .= '<div class="y" id="hilaef"><b>магия</b></div><p>';
  $f .= 'выберите цель:<br/>';
  // spisok:
  include_once ('modules/f_list_inloc.php');
  $f .= list_inloc ($LOGIN, 'cast_from_head&spell='.$spell);
  $f .= '<hr/></p>';
  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>