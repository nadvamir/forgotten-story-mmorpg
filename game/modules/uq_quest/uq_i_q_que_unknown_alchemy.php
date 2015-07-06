<?php
  // neopoznanaja formula
  
  $rnd = rand (0, 1000);
  if ($rnd < 600)
  {
  $for['i.q.que.formula_ba1'] = 0;
  $for['i.q.que.formula_bb1'] = 0;
  $for['i.q.que.formula_bc1'] = 0;
  $for['i.q.que.formula_bd1'] = 0;
  $for['i.q.que.formula_jaa1'] = 0;
  $for['i.q.que.formula_jab1'] = 0;
  $for['i.q.que.formula_jac1'] = 0;
  $for['i.q.que.formula_jad1'] = 0;
  $for['i.q.que.formula_jae1'] = 0;
  $for['i.q.que.formula_jaf1'] = 0;
  $for['i.q.que.formula_hp1'] = 0;
  $for['i.q.que.formula_mp1'] = 0;
  $for['i.q.que.formula_anti'] = 0;
  $for['i.q.que.formula_cure'] = 0;
  }
  else if ($rnd < 800)
  {
  $for['i.q.que.formula_ba2'] = 0;
  $for['i.q.que.formula_bb2'] = 0;
  $for['i.q.que.formula_bc2'] = 0;
  $for['i.q.que.formula_bd2'] = 0;
  $for['i.q.que.formula_jaa2'] = 0;
  $for['i.q.que.formula_jab2'] = 0;
  $for['i.q.que.formula_jac2'] = 0;
  $for['i.q.que.formula_jad2'] = 0;
  $for['i.q.que.formula_jae2'] = 0;
  $for['i.q.que.formula_jaf2'] = 0;
  $for['i.q.que.formula_hp2'] = 0;
  $for['i.q.que.formula_mp2'] = 0;
  }
  else if ($rnd < 900)
  {
  $for['i.q.que.formula_ba3'] = 0;
  $for['i.q.que.formula_bb3'] = 0;
  $for['i.q.que.formula_bc3'] = 0;
  $for['i.q.que.formula_bd3'] = 0;
  $for['i.q.que.formula_jaa3'] = 0;
  $for['i.q.que.formula_jab3'] = 0;
  $for['i.q.que.formula_jac3'] = 0;
  $for['i.q.que.formula_jad3'] = 0;
  $for['i.q.que.formula_jae3'] = 0;
  $for['i.q.que.formula_jaf3'] = 0;
  $for['i.q.que.formula_hp3'] = 0;
  $for['i.q.que.formula_mp3'] = 0;
  }
  else if ($rnd < 950)
  {
  $for['i.q.que.formula_ba4'] = 0;
  $for['i.q.que.formula_bb4'] = 0;
  $for['i.q.que.formula_bc4'] = 0;
  $for['i.q.que.formula_bd4'] = 0;
  $for['i.q.que.formula_jaa4'] = 0;
  $for['i.q.que.formula_jab4'] = 0;
  $for['i.q.que.formula_jac4'] = 0;
  $for['i.q.que.formula_jad4'] = 0;
  $for['i.q.que.formula_jae4'] = 0;
  $for['i.q.que.formula_jaf4'] = 0;
  $for['i.q.que.formula_hp4'] = 0;
  $for['i.q.que.formula_mp4'] = 0;
  $for['i.q.que.formula_mp5'] = 0;
  }
  else
  {
  $for['i.q.que.formula_ba5'] = 0;
  $for['i.q.que.formula_bb5'] = 0;
  $for['i.q.que.formula_bc5'] = 0;
  $for['i.q.que.formula_bd5'] = 0;
  $for['i.q.que.formula_jaa5'] = 0;
  $for['i.q.que.formula_jab5'] = 0;
  $for['i.q.que.formula_jac5'] = 0;
  $for['i.q.que.formula_jad5'] = 0;
  $for['i.q.que.formula_jae5'] = 0;
  $for['i.q.que.formula_jaf5'] = 0;
  $for['i.q.que.formula_s1'] = 0;
  $for['i.q.que.formula_s2'] = 0;
  $for['i.q.que.formula_s3'] = 0;
  $for['i.q.que.formula_s4'] = 0;
  $for['i.q.que.formula_s5'] = 0;
  $for['i.q.que.formula_s6'] = 0;
  $for['i.q.que.formula_s7'] = 0;
  $for['i.q.que.formula_s8'] = 0;
  $for['i.q.que.formula_s9'] = 0;
  $for['i.q.que.formula_s10'] = 0;
  $for['i.q.que.formula_s11'] = 0;
  $for['i.q.que.formula_s12'] = 0;
  $for['i.q.que.formula_s13'] = 0;
  $for['i.q.que.formula_s14'] = 0;
  $for['i.q.que.formula_s15'] = 0;
  $for['i.q.que.formula_s16'] = 0;
  $for['i.q.que.formula_s17'] = 0;
  $for['i.q.que.formula_s18'] = 0;
  $for['i.q.que.formula_hp5'] = 0;
  }

  $ri = array_rand ($for);
  include_once ('modules/f_delete_item.php');
  delete_item ($item);
  include_once ('modules/f_gain_item.php');
  gain_item ($ri, 1, $LOGIN);
?>