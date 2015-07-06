<?php
  // sluchajnyj zakl:
  $types = array ('sum', 'war', 'cre', 'hea');
  $num = array_rand ($types);
  include ('modules/items/items_s/items_s_'.$types[$num].'.php');
  $npc['drop2'] = array_rand ($it);
?>