<?php
  class Sys
  {
    // database user
    var  $dbuser = 'root';
    // database passsword
    var $dbpass = '';
    // database server address
    var $dbserver = 'localhost';
    // database name
    var $dbname = 'waprpg_game';
    // database connection descripter
    var $dbcnx;
    // temporary variable
    var $a;
    // flag that shows if the game is in test mode
    var $test = 1;
    // variable that used for mysql returns
    var $ret;
    function Sys ()
    {
      $this->dbcnx = mysql_connect ($this->dbserver, $this->dbuser, $this->dbpass);
      if (!$this->dbcnx) die ('could not connect to mysql');
      if (!@mysql_select_db ($this->dbname, $this->dbcnx)) die ('could not select database specified');
    }
    function put_error ($error)
    {
      $error = strip_tags ($error);
      if ($this->test) die ($error);
      die ('during runtime of the game an error was occured');
    }
    function do_mysql ($query, $return = 0)
    {
      $query = mysql_real_escape_string ($query);
      $this->a = mysql_query ($query, $this->dbcnx);
      if (!$this->a) put_error ('error in mysql: the query was: "'.$query.'"');
      if ($return == 2)
      {
        // returning associative masive 
        while ($this->ret = mysql_fetch_assoc ($this->a))
          return $this->ret;
      }
      else if ($return == 1)
      {
        // returning one element, or empty
        if (!mysql_num_rows ($this->a)) return '';
        $this->ret = mysql_result ($this->a, 0);
        return $this->ret;
      }
      else
      {
        // simply returns connection descriptor:
        return $this->a;
      }
    }
  }
  $sys = new Sys();
  // Primery ispolqzovanija
  $login = $sys->do_mysql ('SELECT login FROM players WHERE id_player = 1;', 1);
  echo $login.'<br/>';
  $q = $sys->do_mysql ('SELECT email FROM players');
  while ($emails = mysql_fetch_Assoc ($q))
    echo $emails['email'].'<br/>';
?>
