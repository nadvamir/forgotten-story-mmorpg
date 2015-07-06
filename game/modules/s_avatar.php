<?php
  // avatary
  $av['male'][] = 'male_valar_84.jpg';
  $av['male'][] = 'male_valar_101.jpg';
  $av['male'][] = 'male_valar_108.jpg';
  $av['male'][] = 'male_valar_256.jpg';
  $av['male'][] = 'male_valar_293.jpg';
  $av['male'][] = 'male_valar_339.jpg';
  $av['male'][] = 'male_valar_351.jpg';
  $av['male'][] = 'male_valar_373.jpg';
  $av['male'][] = 'male_valar_384.jpg';
  $av['male'][] = 'male_valar_512.jpg';
  $av['male'][] = 'male_valar_517.jpg';
  $av['male'][] = 'male_valar_544.jpg';
  $av['female'][] = 'female_valar_5.jpg';
  $av['female'][] = 'female_valar_28.jpg';
  $av['female'][] = 'female_valar_45.jpg';
  $av['female'][] = 'female_valar_62.jpg';
  $av['female'][] = 'female_valar_83.jpg';
  $av['female'][] = 'female_valar_153.jpg';
  $av['female'][] = 'female_valar_183.jpg';
  $av['female'][] = 'female_valar_203.jpg';
  $av['female'][] = 'female_valar_225.jpg';
  $av['female'][] = 'female_valar_247.jpg';
  $av['female'][] = 'female_valar_273.jpg';
  $av['female'][] = 'female_valar_298.jpg';

  //-----------------------------------------------
  if (!isset ($_GET['gender']))
  {
    $f = 'Выберите пол :<br/> <a class="blue" href="game.php?sid='.$sid.'&action=avatar&gender=male">M</a><br/>';
    $f .= ' <a class="blue" href="game.php?sid='.$sid.'&action=avatar&gender=female">Ж</a><br/>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a>';
    exit_msg ('сменить аватар', $f);
  }

  $f = '';
  if (isset ($_GET['start'])) $start = preg_replace ('/[^0-9]/', '', $_GET['start']);
  $start = 0;
  $show = 50;
  $g = preg_replace ('/[^a-z]/', '', $_GET['gender']);
  if ($g != 'male' && $g != 'female') put_error ('нэма такого пола');

  //-----------------------------------------------
  if (isset ($_GET['set']))
  {
    $set = preg_replace ('/[^0-9]/', '', $_GET['set']);
    if (!file_exists ('smile/avatar/a_'.$av[$g][$set])) put_g_error ('извините, но указаного аватара '.$av[$g][$set].' по-настоящему не существует. просьба сообщить администрации.');
    do_mysql ("UPDATE anketa SET avatar = '".$av[$g][$set]."' WHERE id_player = '".$p['id_player']."';");
    $f = 'вы выбрали аватар. <br/> <a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a>';
    exit_msg ('сменить аватар', $f);
  }
  //-----------------------------------------------

  $c = count ($av[$g]);
  if ($start > $c)
  {
    $start = floor ($c / $show);
    $start *= $show;
    if ($start == $c) $start -= $show;
  }
  if ($start < 0) $start = 0;

  for ($i = $start; $i < $start + $show; $i++)
  {
    if ($i == $c) break;
    $f .= $av[$g][$i].' - <a class="blue" href="game.php?sid='.$sid.'&action=avatar&gender='.$g.'&set='.$i.'">установить</a>, <a class="blue" href="smile/avatar/a_'.$av[$g][$i].'">просмотреть</a><br/>';
  }

  $nw = floor ($c / $show);
  for ($i = 0; $i <= $nw; $i++)
  {
    if ($i * $show == $start) $f .= ($i + 1).' : ';
    elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=avatar&gender='.$g.'&start='.($i * $show).'">'.($i + 1).'</a> : ';
  }
  $f .= '<span class="gray">('.$c.')</span>';
  $f .= '<br/>';

  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a>';
  exit_msg ('сменить аватар', $f);
?>