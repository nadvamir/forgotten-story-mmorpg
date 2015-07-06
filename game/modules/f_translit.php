<?php
  // funkcija translita:
  function translit ($msg)
  {
    $temp = $msg;
    $temp = str_replace('JE', 'Э', $temp);
    $temp = str_replace('JU', 'Ю', $temp);
    $temp = str_replace('JA', 'Я', $temp);
    $temp = str_replace('zh', 'ж', $temp);
    $temp = str_replace('ch', 'ч', $temp);
    $temp = str_replace('sh', 'ш', $temp);
    $temp = str_replace('w', 'щ', $temp);
    $temp = str_replace('je', 'э', $temp);
    $temp = str_replace('ju', 'ю', $temp);
    $temp = str_replace('ja', 'я', $temp);
    $temp = str_replace('ZH', 'Ж', $temp);
    $temp = str_replace('CH', 'Ч', $temp);
    $temp = str_replace('SH', 'Ш', $temp);
    $temp = str_replace('W', 'Щ', $temp);
    $temp = str_replace('b', 'б', $temp);
    $temp = str_replace('v', 'в', $temp);
    $temp = str_replace('g', 'г', $temp);
    $temp = str_replace('d', 'д', $temp);
    $temp = str_replace('z', 'з', $temp);
    $temp = str_replace('j', 'й', $temp);
    $temp = str_replace('k', 'к', $temp);
    $temp = str_replace('l', 'л', $temp);
    $temp = str_replace('m', 'м', $temp);
    $temp = str_replace('n', 'н', $temp);
    $temp = str_replace('p', 'п', $temp);
    $temp = str_replace('r', 'p', $temp);
    $temp = str_replace('t', 'т', $temp);
    $temp = str_replace('f', 'ф', $temp);
    $temp = str_replace('c', 'ц', $temp);
    $temp = str_replace('x', 'ъ', $temp);
    $temp = str_replace('y', 'ы', $temp);
    $temp = str_replace('q', 'ь', $temp);
    $temp = str_replace('B', 'Б', $temp);
    $temp = str_replace('V', 'B', $temp);
    $temp = str_replace('G', 'Г', $temp);
    $temp = str_replace('D', 'Д', $temp);
    $temp = str_replace('Z', '3', $temp);
    $temp = str_replace('I', 'И', $temp);
    $temp = str_replace('J', 'Й', $temp);
    $temp = str_replace('L', 'Л', $temp);
    $temp = str_replace('P', 'П', $temp);
    $temp = str_replace('R', 'P', $temp);
    $temp = str_replace('F', 'Ф', $temp);
    $temp = str_replace('C', 'Ц', $temp);
    $temp = str_replace('X', 'Ъ', $temp);
    $temp = str_replace('Y', 'Ы', $temp);
    $temp = str_replace('Q', 'b', $temp);
    $temp = str_replace('u', 'y', $temp);
    $temp = str_replace('i', 'и', $temp);
    $temp = str_replace('s', 'c', $temp);
    $temp = str_replace('h', 'x', $temp);
    $temp = str_replace('U', 'Y', $temp);
    $temp = str_replace('S', 'C', $temp);
    $temp = str_replace('H', 'X', $temp);
    $temp = str_replace('N', 'H', $temp);
    $msg = $temp;
    return $msg;
  }
?>