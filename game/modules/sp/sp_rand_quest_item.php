<?php
  // sluchajnaja kvestovaja veshq:
  include ('modules/items/items_q/items_q_que.php');
  if (rand (0, 1000) == 777)
  {
    $rand = array_rand ($it);
    $npc['drop2'] = $rand;
  }
?>