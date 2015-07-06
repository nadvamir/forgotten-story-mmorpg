<?php
  // funkcija poluchenija broni
  function get_armor ($login)
  {
    //$login = preg_replace ('/[^a-z-0-9_]/i', '', $login);
    $q = do_mysql ("SELECT armor FROM items WHERE belongs = '".$login."' AND is_in LIKE 'a%' AND str > '0';");
    $def[] = 0;
    $def[] = 0;
    $def[] = 0;
    $def[] = 0;
    $def[] = 0;
    while ($a = mysql_fetch_assoc ($q))
    {
      $a['armor'] = explode ('~', $a['armor']);
      for ($i = 0; $i < 5; $i++) $def[$i] += $a['armor'][$i];
    }
    return $def;
  }
?>