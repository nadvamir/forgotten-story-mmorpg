<?php
  // sluchajnaja eda (ljubogo tipa)
  $types = array ('foo', 'dri', 'tra');
  $num = array_rand ($types);
  $type = $types[$num];
  include ('modules/items/items_f/items_f_'.$type.'.php');
  $npc['drop2'] = array_rand ($it);
  if (($npc['drop2'] == 'i.f.foo.fish_s_kreken' || $npc['drop2'] == 'i.f.foo.fry_fish_s_kreken') && rand (0, 100) > 10)
    $npc['drop2'] = 'i.f.foo.fish_s_kalqmar';
?>