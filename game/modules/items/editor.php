<?php
  include 'a.php';
  $fw = fopen ('c.php', 'w');
  fwrite ($fw, "<?php\r\n");
  foreach ($it as $key => $val)
  {
    $val = explode ('|', $val);
    $val[8] = explode ('~', $val[8]);
    $val[8][0] *= 5;
    $val[8][1] *= 5;
    $val[8][2] *= 5;
    $val[8][3] *= 5;
    $val[8] = implode ('~', $val[8]);
    $val = implode ('|', $val);
    $it[$key] = $val;
    fwrite ($fw, "  \$it['".$key."'] = '".$val."';\r\n");
  }
  fwrite ($fw, "?>");
  fclose ($fw);
?>