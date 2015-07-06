<?php
  // funkcija sravnivaet ukazanye ei parametry i vozvroshjaet ih dlja kazhdogo igroka (npc) v procentah
  function get_chanses ($first, $first_l, $second, $second_l)
  {
    /*echo '<pre>';
    print_r ($first);
    print_r ($first_l);
    print_r ($second);
    print_r ($second_l);
    echo '</pre>';*/
    // poterja zhizni:
    $flm = $first_l[0] / $first_l[1];
    $slm = $second_l[0] / $second_l[1];
    // magiju podavatq uzhe proschitanuju
    //                  what     * 100 /   vs      + what
    if ($first[0]) $ch[0][0] = round($first[0] * $flm * 100 / ($second[1] * $slm + $first[0] * $flm));
    else $ch[0][0] = 0;
    if ($second[0]) $ch[1][0] = round($second[0] * $slm * 100 / ($first[1] * $flm + $second[0] * $slm));
    else $ch[1][0] = 0;
    if ($first[1]) $ch[0][1] = round($first[1] * $flm * 100 / ($second[0] * $slm + $first[1] * $flm));
    else $ch[0][1] = 0;
    if ($second[1]) $ch[1][1] = round($second[1] * $slm * 100 / ($first[0] * $flm + $second[1] * $slm));
    else $ch[1][1] = 0;
    if ($first[2]) $ch[0][2] = round($first[2] * $flm * 100 / ($second[0] * $slm + $first[2] * $flm));
    else $ch[0][2] = 0;
    if ($second[2]) $ch[1][2] = round($second[2] * $slm * 100 / ($first[0] * $flm + $second[2] * $slm));
    else $ch[1][2] = 0;
    if ($first[3]) $ch[0][3] = round($first[3] * $flm * 100 / ($second[0] * $slm + $first[3] * $flm));
    else $ch[0][3] = 0;
    if ($second[3]) $ch[1][3] = round($second[3] * $slm * 100 / ($first[0] * $flm + $second[3] * $slm));
    else $ch[1][3] = 0;
    if ($first[4]) $ch[0][4] = round($first[4] * $flm * 100 / ($second[4] * $slm + $first[4] * $flm));
    else $ch[0][4] = 0;
    if ($second[4]) $ch[1][4] = round($second[4] * $slm * 100 / ($first[4] * $flm + $second[4] * $slm));
    else $ch[1][4] = 0;
    if ($first[5]) $ch[0][5] = round($first[5] * $flm * 100 / ($second[4] * $slm + $first[5] * $flm));
    else $ch[0][5] = 0;
    if ($second[5]) $ch[1][5] = round($second[5] * $slm * 100 / ($first[4] * $flm + $second[5] * $slm));
    else $ch[1][5] = 0;
    if ($first[6]) $ch[0][6] = round($first[5] * $flm * 100 / ($second[4] * $slm + $first[6] * $flm));
    else $ch[0][6] = 0;
    if ($second[6]) $ch[1][6] = round($second[5] * $slm * 100 / ($first[4] * $flm + $second[6] * $slm));
    else $ch[1][6] = 0;
    if ($first[7]) $ch[0][7] = round($first[5] * $flm * 100 / ($second[4] * $slm + $first[7] * $flm));
    else $ch[0][7] = 0;
    if ($second[7]) $ch[1][7] = round($second[5] * $slm * 100 / ($first[4] * $flm + $second[7] * $slm));
    else $ch[1][7] = 0;
    if ($first[8]) $ch[0][8] = round($first[8] * $flm * 100 / ($second[0] * $slm + $first[8] * $flm));
    else $ch[0][8] = 0;
    if ($second[8]) $ch[1][8] = round($second[8] * $slm * 100 / ($first[0] * $flm + $second[8] * $slm));
    else $ch[1][8] = 0;
    if ($first[9]) $ch[0][9] = round($first[9] * $flm * 100 / ($second[0] * $slm + $first[9] * $flm));
    else $ch[0][9] = 0;
    if ($second[9]) $ch[1][9] = round($second[9] * $slm * 100 / ($first[0] * $flm + $second[9] * $slm));
    else $ch[1][9] = 0;
    return $ch;
  }
?>