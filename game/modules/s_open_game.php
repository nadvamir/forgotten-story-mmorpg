<?php
  if (file_exists ('modules/posts/closed.txt')) unlink ('modules/posts/closed.txt');
  exit_msg ('доступ', 'доступ к игре открыт');
?>