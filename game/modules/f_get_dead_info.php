<?php
  // funkcija vozvrashjaet infu trupa i rjadom s nei l_has (spisok veshej) l_hunt (spisok osvezhitq);
  function get_dead_info ($dead)
  {
    //$dead = preg_replace ('/[^a-z0-9\.]/i', '', $dead);
    if (substr ($dead, 0, 2) != 'd.') put_error ('это не труп');
    $q = do_mysql ("SELECT * FROM dead WHERE fullname = '".$dead."';");
    $d = mysql_fetch_assoc ($q);
    $d['l_hunt'] = $d['hunt'];
    $d['hunt'] = explode ('|', $d['hunt']);
    return $d;
  }
?>