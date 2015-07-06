<?php
  // rudnaja zhila
  // proverim, estq li udochka v rukah i navyk
  if (!strpos ($p['weapon'], 'kirqka')) put_g_error ('возьмите кирьку в руки!');
  // hotja, esli net navyka, nikogda nichego ne vykopaete
  $f = '';
  if (isset ($_GET['u']))
  {
    // kopaem
    $u = base64_decode ($_GET['u']);
    $u = base64_decode ($u);
    $u = explode ('|', $u);
    $u = $u[1];
    if ($u == '1')
    {
      if (rand (1, 100) <= 95)
          $what = 'i.q.que.ore';
      else
      {
        $n = rand (1, 28);
        if ($n < 2) $what = 'i.q.que.jew.almaz';
        else if ($n < 4) $what = 'i.q.que.jew.rubin';
        else if ($n < 7) $what = 'i.q.que.jew.sapfir';
        else if ($n < 11) $what = 'i.q.que.jew.izumrud';
        else if ($n < 16) $what = 'i.q.que.jew.ametist';
        else if ($n < 22) $what = 'i.q.que.jew.malahit';
        else $what = 'i.q.que.jew.agat';
      }
      include_once ('modules/f_gain_item.php');
      $nitem = gain_item ($what, 1, $LOGIN);
      include_once ('modules/f_get_it_name.php');
      $name = get_it_name ($nitem);
      $f .= 'вы нашли '.$name.'!<br/>';
    }
    else
    {
      $f .= 'а там ничего нет...<br/>';
    }
  }

  // vsegda pokazyvaem vybor chto kopatq
  for ($i = 0; $i < 10; $i++) $arr[$i] = '0';
  $max = $p['skills'][33];
  if ($max > 8) $max = 8;
  for ($i = 0; $i < $max; $i++) $arr[$i] = '1';
  // peremeshivaem znachenija -
  shuffle ($arr);
  // pishem na ekran:
  $f .= '<b>выберите жилу</b><br/>';
  for ($i = 0; $i < 10; $i++)
  {
    $u = (rand (0, 100)).'|'.$arr[$i].'|'.(rand (0,100));
    $u = base64_encode ($u);
    $u = base64_encode ($u);
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&u='.$u.'">*</a> ';
  }
  exit_msg ('рудная жила', $f);
?>