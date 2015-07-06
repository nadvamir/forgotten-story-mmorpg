<?php
  // udalenie temy:
  $id_theme = preg_replace ('/[^0-9]/', '', $_GET['id_theme']);
  $qpost = "SELECT * FROM themes WHERE id_theme = '".$id_theme."'";
  $apost = do_mysql($qpost);
  $theme = mysql_fetch_assoc ($apost);
  if ($theme['author'] == $LOGIN || $p['admin'] > 0)
  {
    if (do_mysql ("DELETE FROM themes WHERE id_theme = '".$id_theme."'"))
    {
      $q = do_mysql ("SELECT * FROM posts WHERE id_theme = '".$id_theme."';");
      while ($post = mysql_fetch_assoc ($q))
      {
        // udalenie posta:
        if (do_mysql ("DELETE FROM posts WHERE id_post = '".$post['id_post']."';")) unlink ('modules/posts/post_'.$post['id_post'].'.txt');
      }
    }
  }
  $_GET['sub_action'] = 'showthemes';
?>