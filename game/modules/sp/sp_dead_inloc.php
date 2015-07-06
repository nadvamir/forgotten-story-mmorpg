<?php
  // trup v lokacii
  // otobrazitq imja (ssylku podnjatq to chto v has) i esli estq chto osvezhitq to ssylku na eto
  include_once ('modules/f_get_dead_info.php');
  $d = get_dead_info ($inloc[$i]);
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=take_dead&dead='.$inloc[$i].'">';
  $f .= $d['name'].'</a>';
  if ($d['l_hunt']) $f .= ' <a class="blue" href="game.php?sid='.$sid.'&action=osvezh&dead='.$inloc[$i].'">></a>';
  $f .= '<br/>';
?>