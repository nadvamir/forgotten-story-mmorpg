<?php
$sod = fopen("http://ws.darkagesworld.com/info.asmx/GetUserInfo?nick=Cuban", "rb");
$userinfo = "";
while (1)
{
  $data = fread($sod, 4096);
  if (strlen($data) == 0)
  {
    break;
  }
  else
  {
    $userinfo .= $data;
  }
}
fclose($sod);
$p = xml_parser_create();
xml_parse_into_struct($p, $userinfo, $vals, $index);
xml_parser_free($p);
#echo "<pre>Index array\n";
#print_r($index);
#echo "\nVals array\n";
#print_r($vals);
echo '<br/> a vot eto primer odinochnogo dostavanija:<br/>';
$c = count ($vals);
for ($i = 0; $i < $c; $i++)
{
  if (!isset($vals[$i]['value']) || empty ($vals[$i]['value']) || $vals[$i]['tag'] == 'USERINFO' || $vals[$i]['tag'] == 'USERINFORESULT' || $vals[$i]['tag'] == 'STUFFLIST') continue;
  if ($vals[$i]['tag'] == $bla1)   echo $bla1.'   -------    <b><u>'.$vals[$i]['value'].'</u></b><br/>';
  if ($vals[$i]['tag'] == $bla2)   echo $bla2.'   -------    <b><u>'.$vals[$i]['value'].'</u></b><br/>';
}
?>
