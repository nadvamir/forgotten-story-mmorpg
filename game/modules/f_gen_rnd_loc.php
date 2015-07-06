<?php
  // funkcija vozvrashjaet nazvanie sluchajnoj loki v zadannom regione
  // vozvrashjaet massiv
  function gen_rnd_loc ($region, $loc = 0)
  {
    // esli neukazan loc, to iz karty
    if (!$loc)
    {
      // zagruzim fail lokacij

      global $LOC;
      if (!isset ($LOC[$region]))
        if (!make_namespace ($region))
          return 0;

      $l = $LOC[$region];

      // sluchajnyj indeks
      $ind = array_rand ($l);
      $loc = explode ('~', $l[$ind]);
      return $loc[0];
    }
    // esli kazan to iz teh chto ukazany
    if ($loc)
    {
      $loc = explode ('~', $loc);
      $ind = array_rand ($loc);
      return $loc[$ind];
    }
  }
?>