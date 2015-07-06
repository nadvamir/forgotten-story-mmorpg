<?php
	// sluchajnyj vybor broni:
	include ('modules/items/items_a/items_a_'.$types[$arnd].'.php');
	// perebiraem vse bronju i vyberaem to u kotorogo lvl raven urovnju monstra:
  if (!isset ($npc['lvl'])) $npc['lvl'] = 1;
  if ($npc['lvl'] < 12)
    if (rand (0, 100) <= 30) $npc['lvl']++;
    else if (rand (0, 100) <= 30) $npc['lvl']--;
  if (rand (0, 100) == 3) $npc['lvl'] = rand (1, 12);
  foreach ($it as $key => $val)
    if (say_level ($key) == $npc['lvl'])
      $items[] = $key;
  if (isset($items))
  {
    $itemn = array_rand ($items);
    $t = $items[$itemn];
    // teperq vyberaem kachestvo
    $rnd = rand (0, 1000);
    if ($rnd < 800) $pr = '.nor.';
    else if ($rnd < 951) $pr = '.bet.';
    else if ($rnd < 987) $pr = '.rar.';
    else if ($rnd < 997) $pr = '.eli.';
    else if ($rnd < 1000) $pr = '.epi.';
    else $pr = '.leg.';
    if ($types[$arnd] == 'bo2' || $types[$arnd] == 'leg')
    {
      if ($rnd < 333) $pr = '.fur.';
      else if ($rnd < 665) $pr = '.tun.';
      else $pr = '.bas.';
    }
    $item = (substr ($t, 0, 7)).$pr.(substr ($t, 8));
    $npc['drop2'] = $item;
    //$let = substr ($item, (strlen ($item) - 1));
    //if (($let == 'A' || $let == 'B' || $let == 'C') && $npc['lvl'] < 13) $npc['drop2'] = '';
  }
  else
  {
    $it = '';
    //echo '<br/>bbb<br/>';
    include ('modules/sp/sp_rand_food.php');
  }
?>