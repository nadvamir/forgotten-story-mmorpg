<?php
  // svaritq otvar:
  // imejushjajasq voda zamenjaetsja  otvarom
  if (!$p['skills'][6]) put_g_error ('Вы неумеете пользоватся столиком!');
  if (!isset ($_GET['part']))
  {
    // vyberim pervuju travu:
    $f = 'Для того чтобы сварить траву, вы должны иметь бутылку наполненую водой, а также травы двух разных сортов<br/>';
    include_once ('modules/f_list_inventory.php');
    $f .= list_inventory ($LOGIN, 'i.f.tra', 'make_otv&part=2');
    exit_msg ('травник', $f);
  }
  if ($_GET['part'] == 2)
  {
    $f = 'теперь выберите вторую траву<br/>';
    include_once ('modules/f_list_inventory.php');
    $f .= list_inventory ($LOGIN, 'i.f.tra', 'make_otv&part=3&tra1='.$_GET['to']);
    exit_msg ('травник', $f);
  }
  // nu a dalee varim
  $tra1 = mysql_real_escape_string ($_GET['tra1']);
  $tra2 = mysql_real_escape_string ($_GET['to']);
  if ($tra1 == $tra2) put_g_error ('ну я же говорил, что две разные травы нужны');

  // proverim imeem li my butylku:
  $q = do_mysql ("SELECT id_item, fullname, on_take FROM items WHERE realname LIKE 'i.f.dri.nor.water%';");
  if (!mysql_num_rows ($q)) put_g_error ('а это, элексир ты в руках хранить будешь? бутылка с водой мастхев.');
  $wat = mysql_fetch_assoc ($q);

  // nu a dalee idet spisok spec rezeptov:
  // tut nado ne tolqko popastq v travy, a eshe i ocheredq ugodatq
  $rec['i.f.tra.podorozhnik.i.f.tra.mjata'] = 'i.f.dri.nor.tin_pm';
  $rec['i.f.tra.ezhevika.i.f.tra.chernika'] = 'i.f.dri.nor.mors_jc';
  $rec['i.f.tra.bessmertnik.i.f.tra.hmelq'] = 'i.f.dri.alc.pivo_undead';
  $rec['i.f.tra.jachmenq.i.f.tra.hmelq'] = 'i.f.dri.alc.pivo_jach';
  $rec['i.f.tra.anis.i.f.tra.zajcegub_opqjanjajushij'] = 'i.f.dri.alc.otv_pqjan';
  $rec['i.f.tra.dymjanka.i.f.tra.ukrop'] = 'i.f.dri.nor.otv_du';
  $rec['i.f.tra.chistotel.i.f.tra.chistec'] = 'i.f.dri.nor.kok_mojd';
  $rec['i.f.tra.mak_opiumnyj.i.f.tra.len'] = 'i.f.dri.alc.opiuml';
  $rec['i.f.tra.anis.i.f.tra.akonit_protivojadnyj'] = 'i.f.dri.nor.protivojadie';
  $rec['i.f.tra.nezabudka_lesnaja.i.f.tra.mjata'] = 'i.f.dri.nor.unfsvezh';
  $rec['i.f.tra.djavesil.i.f.tra.shipovnik_sobachij'] = 'i.f.dri.nor.tea_terap';
  $rec['i.f.tra.goroshek_myshinyj.i.f.tra.ogurec_posevnoj'] = 'i.f.dri.nor.goblinskoe_zelqe';
  $rec['i.f.tra.mak_opiumnyj.i.f.tra.jachmenq'] = 'i.f.dri.alc.pivo_lsd';
  $rec['i.f.tra.len.i.f.tra.klever_lugovoj'] = 'i.f.dri.nor.tin_burn';
  $rec['i.f.tra.gorec_vqjuwijsja.i.f.tra.jesparcet_peschanyj'] = 'i.f.dri.nor.tea_wisdom';
  $rec['i.f.tra.ukrop.i.f.tra.cikorij'] = 'i.f.dri.nor.mix';
  $rec['i.f.tra.zaraziha_belaja.i.f.tra.zhivuchka_polzuchaja'] = 'i.f.dri.nor.tea_hren';
  $rec['i.f.tra.valeriana.i.f.tra.mak_opiumnyj'] = 'i.f.dri.nor.otv_moon';

  // teperq vyberaem, kak varitq budem - po receptu, ili himija
  include_once ('modules/f_real_name.php');
  $rtra1 = real_name ($tra1);
  $rtra2 = real_name ($tra2);
  
  // imeetsja li trava v nuizhnom kolichestve dlja takoj butyli.
  $c = $wat['on_take'];
  include_once ('modules/f_has_count.php');
  if (!has_count ($rtra1, $c, $LOGIN) || !has_count ($rtra2, $c, $LOGIN)) put_g_error ('нехватает трав для получения отвара используя столько много воды. На одну порцию надо две травы (по одной разной)');
  
  // berem harakteristiku travy
  $q = do_mysql ("SELECT on_use FROM items WHERE fullname = '".$tra1."';");
  $tra1_i = mysql_result ($q, 0);
  $tra1_i = explode ('~', $tra1_i);
  $q = do_mysql ("SELECT on_use FROM items WHERE fullname = '".$tra2."';");
  $tra2_i = mysql_result ($q, 0);
  $tra2_i = explode ('~', $tra2_i);
    
  $tn = $rtra1.'.'.$rtra2;
  $mult;
  if (isset ($rec[$tn]))
  {
    // znachit, berem osnovnoe polozhenie del po spec napistku.
    // otsjuda berem tolqko imja i mnozhitelq 2. ostralqnoe vse obshe po formulam rasc hityvaem
    include 'modules/items/items_f/items_f_dri.php';
    $i = explode ('|', $it[$rec[$tn]]);
    $name = $i[0].' ['.$p['name'].']';
    $mult = 2; // maksimalqnyj mnozhitelq
  }
  else
  {
    include_once ('modules/f_get_it_name.php');
    $name = 'отвар из '.(get_it_name ($tra1)).' и '.(get_it_name ($tra2)).' ['.$p['name'].']';
    $mult = rand (50, 200) / 100;
  }
  // udaljaem starye travy
  include_once ('modules/f_delete_count.php');
  delete_count ($rtra1, $c, $LOGIN);
  delete_count ($rtra2, $c, $LOGIN);
  
  $fullname = $tn;
  $on_use = array (0, 0, 0, 0, 0);
  $on_use[0] = round (($tra1_i[0] + $tra2_i[0]) * $mult * ( ceil ($p['skills'][6] / 3) + 1 )); 
  $on_use[1] = round (($tra1_i[1] + $tra2_i[1]) * $mult * ( ceil ($p['skills'][6] / 3) + 1 )); 
  if ($tra1_i[2] || $tra2_i[2]) $on_use[2] = 1;
  if ($tra1_i[3] || $tra2_i[3]) $on_use[3] = 1;
  if ($tra1_i[4] || $tra2_i[4]) $on_use[4] = 1;
  $price = round (($on_use[0] + $on_use[1]) / 10);
  $on_use = implode ('~', $on_use);
  $realname = $fullname;
  $fullname = $wat['fullname'].'.'.$fullname;
  // obnovljaem i sozdaem: esli udastsja
  if (rand (1, 10) <= $p['skills'][6])
  {
    do_mysql ("UPDATE items SET fullname = '".$fullname."',  name = '".$name."', on_use = '".$on_use."', price = '".$price."', realname = '".$realname."', belongs = '".$LOGIN."' WHERE id_item = '".$wat['id_item']."';");
    // i soobshaem v zhurbal:
    add_journal ('вы сварили '.$name.'!', $LOGIN);
  }
  else
  {
    add_journal ('вы переварили '.$name.' и трава как-то растворилась в воде...', $LOGIN);
  }
?>