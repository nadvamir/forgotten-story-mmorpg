<?php
  // funkcija udaljaet kolichestvo veshej, pered ispolqzovaniem sleduet proveritq estq li stolqko
  // int delete_count (string $item, int $count, string $login);
  function delete_count ($item, $count, $login)
  {
    //$item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
    $count = preg_replace ('/[^0-9]/', '', $count);
    //$login = preg_replace ('/[^a-z0-9_]/', '', $login);
    if (!$item || !$count || !$login) put_error ('заполните усе данные (это к админу): '.$item.', '.$count.', '.$login);

    $i = 1;
    $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$login."' AND is_in <> 'ban' AND type <> 'm' AND realname LIKE '".$item."%';");
    while ($it = mysql_fetch_assoc ($q))
    {
      if ($i > $count) break;
      do_mysql ("DELETE FROM items WHERE fullname = '".$it['fullname']."';");
      $i++;
    }
    return ($i - 1);
  }
?>