<?php
  // funkcija sozdaet melkuju veshq
  // potom nado samomu v inventarq ili v lokaciju kidatq
  function create_item_m ($fullname, $count)
  {
    //$fullname = preg_replace ('/[^a-z0-9_\.]/i', '', $fullname);
    //$count = preg_replace ('/[^0-9]/', '', $count);
    // v princype v etu funkciju iz faila vvodjatsja vse dannye
    // klass:
    $cl = substr ($fullname, 2, 1);
    // tip
    $tp = substr ($fullname, 4, 3);
    // podkljuchim
    //echo $fullname;
    if (!file_exists ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php')) put_error ('<p>нету такого файла для создания веши: modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php</p>');
    include ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php');
    if (!isset($it[$fullname])) put_error ('<p>такой веши нету в файлах: '.$fullname.'</p>');
    $it[$fullname] = explode('|', $it[$fullname]);
    // edinstvennoe chto nado sdelatq - eto izmenitq fullname
    // poetomu, zapolnim za dva raza, pervyj raz ukazhem lozhnyj fullname
    $name = mysql_real_escape_string ($it[$fullname][0]);
    $fullname = mysql_real_escape_string ($it[$fullname][1]);
    $type = mysql_real_escape_string ($it[$fullname][2]);
    $on_take = mysql_real_escape_string ($count);
    $on_use = mysql_real_escape_string ($it[$fullname][4]);
    $on_drop = mysql_real_escape_string ($it[$fullname][5]);
    $price = mysql_real_escape_string ($it[$fullname][6]);
    $dmg = mysql_real_escape_string ($it[$fullname][7]);
    $armor = mysql_real_escape_string ($it[$fullname][8]);
    $weight = mysql_real_escape_string ($it[$fullname][11]);
    do_mysql ("INSERT INTO items VALUES (0, '".$name."', '".$fullname.".i', '".$type."', '".$on_take."', '".$on_use."', '".$on_drop."', '".$price."', '".$dmg."', '".$armor."', '', '', '".$weight."', '', '".$fullname."', '', '', '0', '0', '0');");
    // teperq vozqmem id_item i pripishem ego k fullname
    $a = do_mysql ("SELECT id_item FROM items WHERE fullname = '".$fullname.".i';");
    $id_item = mysql_result ($a, 0);
    // obnovim 
    do_mysql ("UPDATE items SET fullname = '".$fullname.".".$id_item."' WHERE fullname = '".$fullname.".i';");
    return $fullname.'.'.$id_item;
  }
?>