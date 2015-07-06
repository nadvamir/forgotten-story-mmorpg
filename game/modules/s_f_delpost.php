<?php
  // udalenie posta:
  $id_post = preg_replace ('/[^0-9]/', '', $_GET['id_post']);
  $qpost = "SELECT * FROM posts WHERE id_post = '".$id_post."'";
  $apost = do_mysql($qpost);
  $post = mysql_fetch_assoc ($apost);
  if ($post['author'] == $LOGIN || $p['admin'] > 0)
  {
    if (do_mysql ("DELETE FROM posts WHERE id_post = '".$id_post."'")) unlink ('modules/posts/post_'.$id_post.'.txt');
  }
  $_GET['sub_action'] = 'showposts';
?>