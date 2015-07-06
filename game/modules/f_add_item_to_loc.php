<?php
  // dobavljaet v lokaciju (no ne sozdaet!)
  function add_item_to_loc ($loc, $what)
  {
    // proverka dannyh
    //$what = preg_replace ('/[^a-z\._0-9]/i', '', $what);
    //$loc = preg_replace ('/[^a-z0-9\|]/i', '', $loc);
    $map = substr ($loc, 0, 4);
    if (!$loc)
    {
      global $p;
      $loc = $p['location'];
    }
    do_mysql ("UPDATE items SET location = '".$loc."', belongs = '0', map = '".$map."', is_in = '' WHERE fullname = '".$what."';");
    return 1;
  }
?>