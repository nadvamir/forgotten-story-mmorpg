<?php
  // funkcija proverjaet, umeet li etu magiju chel (vyuchena li)
  function has_magic ($spell, $login)
  {
    //$spell = preg_replace ('/[^a-z0-9_]/i', '', $spell);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);

    $id = is_player ($login);
    $q = do_mysql ("SELECT magic FROM players WHERE id_player = '".$id."';");
    if (!mysql_num_rows ($q)) return 0;
    $magic = mysql_result ($q, 0);

    if (strpos ($magic, $spell) === false) return 0;
    return 1;
  }
?>