<?php
  // chastq skripta  ispolqzovatq svitok:
  // vyberem celq:
  if (!isset ($f))
    $f = '';
  if ((substr ($item, 4, 3) == 'war' || substr ($item, 4, 3) == 'hea') && !isset ($_GET['to']))
  {
    $f .= 'выберите цель:<br/>';
    // spisok:
    include_once ('modules/f_list_inloc.php');
    $f .= list_inloc ($LOGIN, 'use_item&item='.$item);
    $f .= '<br/>';
  }
  else
  {
    // ostalqnym srazu ispolqzuem:
    $_GET['scroll'] = $item;
    if (!isset ($_GET['to'])) $_GET['to'] = $LOGIN;
    include 'modules/s_cast_from_scroll.php';
  }
?>