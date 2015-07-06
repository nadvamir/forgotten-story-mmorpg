<?php
  // estq li takaja kombo u igroka
  // vozvrashjaet vsju infu komboi (3) ee nomer v spiske
  function search_kombo ($login, $kombo)
  {
    $id = is_player ($login);
    $q = do_mysql ("SELECT kombo FROM players WHERE id_player = '".$id."';");
    $k = mysql_result ($q, 0);
    $k = explode ('|', $k);
    $c = count ($k);
    for ($i = 0; $i < $c; $i++)
    {
      if (strpos($k[$i], $kombo) !== false)
      {
        $k[$i] = explode (':', $k[$i]);
        $k[$i][3] = $i;
        return $k[$i];
      }
    }
    return 0;
  }
?>