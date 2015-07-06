<?php
  // funkcija proverjaet imeetsja li v inventare ukazanoe kolichestvo veshej
  // int has_count (string $item, int $count, string $login);
  // vozvrashjaet 1 esli vse horosho, 0 esli net voobshe, -1 esli za malo
  function has_count ($item, $count, $login)
  {
    //$item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
    $count = preg_replace ('/[^0-9]/', '', $count);
    //$login = preg_replace ('/[^a-z0-9_]/', '', $login);
    if (!$item || !$count || !$login) put_error ('заполните усе данные (это к админу)');

    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE realname LIKE '".$item."%' AND belongs = '".$login."' AND is_in <> 'ban';");
    $has = mysql_result ($q, 0);

    if ($has == 0) return 0;
    if ($has < $count) return -1;
    if ($has >= $count) return 1;
  }
?>