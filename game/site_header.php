<?php
  // header dlja saita
  //-----------------------------
  function gen_sheader($title)
  {
    ######## bez funkcij #############
    // sozdaet zagolovok
    $header = '<?xml version="1.0" encoding="UTF-8"?>';
    $header .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">';
    $header .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">';
    $header .= '<head><title>'.$title.'</title>';
    $header .= "<meta http-equiv='Content-Type' content='application/xhtml+xml; charset=utf-8' />";
    $header .= '<meta name="verify-v1" content="WYU52LQMeGE90SGhlyABDtOm4Acxep20XoCyk+UWzwU=" />';
    $header .= '<meta http-equiv="cache-control" content="no-cache" />';
    $header .= '<meta http-equiv="pragma" content="no-cache" />';
    $header  .= '<meta name="copyright" content="&copy; 2008 Maksim Solovjov" />';
    //--
    $header .= '<style type="text/css">';
    $header .= 'body{}';
    $header .= 'a.black{color:#000000}';
    $header .= 'a.red{color:#ff0000}';
    $header .= 'a.blue{color:#0000ff}';
    #$header .= 'body{background-color:#ffff00;}';
    $header .= 'input{background-color:#ffffff;}';
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $wdt = '';
    //if (strpos ($agent, 'MSIE') || strpos ($agent, 'Opera') || strpos ($agent, 'Firefox')) $wdt = ' width: 240px;';
// ice

//    $header .= 'div.y{background-color:#CAE1FF; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #C6E2FF; border-top:1px solid #C6E2FF; border-right:2px solid #BCD2EE; border-bottom:2px solid #BCD2EE;}';
    $header .= 'div.y{background-color:#ffe13a; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #fdf274; border-top:1px solid #fdf274; border-right:2px solid #ffd33a; border-bottom:2px solid #ffd33a; font-size:small}';
    $header .= 'div.p{text-align:left;'.$wdt.' background-color: #FFFACD}';
    $header .= 'div.n{text-align:left;'.$wdt.' background-color:#f9fcfc; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #f9fcfc; border-top:1px solid #f9fcfc; border-right:2px solid #f1fdfd; border-bottom:2px solid #f1fdfd; font-size:small}';
    $header .= 'div.c{text-align:center}';
    $header .= 'div.t{font-size:smaller; margin-left:2%; margin-right:2%}';
    $header .= 'p{text-align:left;'.$wdt.' background-color:#f9fcfc; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #f9fcfc; border-top:1px solid #f9fcfc; border-right:2px solid #f1fdfd; border-bottom:2px solid #f1fdfd; font-size:small}';

// khaki
/*
    $header .= 'div.y{background-color:#EEE685; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #FFF68F; border-top:1px solid #FFF68F; border-right:2px solid #CDC673; border-bottom:2px solid #CDC673;}';
    $header .= 'div.p{background-color: #FFFACD}';
    $header .= 'div.n{background-color:#FDF5E6; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #FFFFF0; border-top:1px solid #FFFFF0; border-right:2px solid #FAEBD7; border-bottom:2px solid #FAEBD7;}';
    $header .= 'div.c{text-align:center}';
    $header .= 'div.t{font-size:smaller; margin-left:2%; margin-right:2%}';
    $header .= 'p{background-color:#FAFAD2; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #FFD700; border-top:1px solid #FFD700; border-right:2px solid #FFD700; border-bottom:2px solid #FFD700;}';
*/
// yellow
/*
    $header .= 'div.y{background-color:#ffe13a; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #fdf274; border-top:1px solid #fdf274; border-right:2px solid #ffd33a; border-bottom:2px solid #ffd33a;}';
    $header .= 'div.p{background-color: #FFFACD}';
    $header .= 'div.n{background-color:#FAFAD2; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #FFFFE0; border-top:1px solid #FFFFE0; border-right:2px solid #EEE8AA; border-bottom:2px solid #EEE8AA;}';
    $header .= 'div.c{text-align:center}';
    $header .= 'div.t{font-size:smaller; margin-left:2%; margin-right:2%}';
    $header .= 'p{background-color:#FAFAD2; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #FFD700; border-top:1px solid #FFD700; border-right:2px solid #FFD700; border-bottom:2px solid #FFD700;}';
*/
// green
/*    $header .= 'div.y{text-align:left; width: 240px; background-color:#228B22; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #9ACD32; border-top:1px solid #9ACD32; border-right:2px solid #006400; border-bottom:2px solid #006400;}';
    $header .= 'div.p{text-align:left; width: 240px; background-color: #FFFACD}';
    $header .= 'div.n{text-align:left; width: 240px; background-color:#E0EEE0; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #F0FFF0; border-top:1px solid #F0FFF0; border-right:2px solid #C1CDC1; border-bottom:2px solid #C1CDC1;}';
    $header .= 'div.c{text-align:center}';
    $header .= 'div.t{font-size:smaller; margin-left:2%; margin-right:2%}';
    $header .= 'p{text-align:left; width: 240px; background-color:#FAFAD2; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #FFD700; border-top:1px solid #FFD700; border-right:2px solid #FFD700; border-bottom:2px solid #FFD700;}';*/
    $header .= '</style>';
    //--
    $header .= '</head><body>';
    return $header;
  }
?>