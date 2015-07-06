<?php
  // FORUM: sednja 4 janvarja
  //if ($p['stats'][0] < 2 && $p['admin'] < 1) put_error ('Рано вам еще сюда. Без второго уровня никак...');
  if ($p['admin'] == -1) put_g_error ('вы в бане!');
  do_mysql ("DELETE FROM fonline WHERE puttime < NOW() - INTERVAL '5' MINUTE;");
  //do_mysql ("DELETE FROM fonline WHERE login = '".$LOGIN."';");
  if (!isset ($_GET['sub_action'])) include 'modules/s_f_main.php';
  if ($_GET['sub_action'] == 'add_theme') include 'modules/s_f_add_theme.php';
  if ($_GET['sub_action'] == 'add_post') include 'modules/s_f_add_post.php';
  if ($_GET['sub_action'] == 'edit_post') include 'modules/s_f_edit_post.php';
  if ($_GET['sub_action'] == 'delpost') include 'modules/s_f_delpost.php';
  if ($_GET['sub_action'] == 'deltheme') include 'modules/s_f_deltheme.php';
  if ($_GET['sub_action'] == 'showthemes') include 'modules/s_f_showthemes.php';
  if ($_GET['sub_action'] == 'showposts') include 'modules/s_f_showposts.php';
  if ($_GET['sub_action'] == 'create_theme') include 'modules/s_f_create_theme.php';
  if ($_GET['sub_action'] == 'reply') include 'modules/s_f_reply.php';
  if ($_GET['sub_action'] == 'move_topic1') include 'modules/s_f_move_topic1.php';
  if ($_GET['sub_action'] == 'move_topic2') include 'modules/s_f_move_topic2.php';
  if ($_GET['sub_action'] == 'showsmiles') include 'modules/s_f_showsmiles.php';
  if ($_GET['sub_action'] == 'showbbcode') include 'modules/s_f_showbbcode.php';
  if ($_GET['sub_action'] == 'showfonline') include 'modules/s_f_showfonline.php';
  if ($_GET['sub_action'] == 'showlast') include 'modules/s_f_showlast.php';
  include 'modules/s_f_main.php';
?>