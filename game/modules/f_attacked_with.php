<?php
  // funkcija vozvrashjaet nazbanie predmeta, katorym napadali (mechem, toporom...)
  function attacked_with ($weap)
  {
    if (!$weap) return '';
    $weap = substr ($weap, 4, 3);
    switch ($weap)
    {
      case 'swo': return 'мечем';
      case 'axe': return 'топором';
      case 'ham': return 'молотом';
      case 'spe': return 'копьем';
      case 'bow': return 'луком';
      case 'arb': return 'арбалетом';
      case 'kni': return 'ножем';
      case 'kli': return 'клинком';
      case 'tre': return 'посохом';
    }
    return '';
  }
?>