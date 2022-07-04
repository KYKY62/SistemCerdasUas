<?php
$ERROR = array();
$VALIDATION = array();

function set_rules($field, $label='', $rules = array()){
    global $VALIDATION;
    $VALIDATION[] = array($field, $label, $rules);
}

function run_validation($echo = true){
    global $VALIDATION, $_POST, $ERROR, $db;
    
    $success = true;
    
    foreach($VALIDATION as $key => $val){
        $field = $val[0];
        $arr_rules = explode('|', $val[2]);
        foreach($arr_rules as $rule_name){
            if($rule_name=='required'){
                if(trim($_POST[$field])==''){
                    $ERROR[] = "Field <strong>$val[1]</strong> harus diisi!"; 
                    $success = false;
                    break;
                }                    
            } else if(strpos($rule_name, 'min_length')!==false){
                 preg_match('/\[(.*?)\]/', $rule_name, $matches);                 
                 if(strlen($_POST[$field]) < $matches[1]){
                    $ERROR[] = "Field <strong>$val[1]</strong> minimal <strong>$matches[1]</strong> karakter!"; 
                    $success = false;
                    break;
                 }
            } else if(strpos($rule_name, 'max_length')!==false){
                 preg_match('/\[(.*?)\]/', $rule_name, $matches);                 
                 if(strlen($_POST[$field]) > $matches[1]){
                    $ERROR[] = "Field <strong>$val[1]</strong> maksimal <strong>$matches[1]</strong> karakter!"; 
                    $success = false;
                    break;
                 }
            } else if($rule_name=='alpha'){                
                 if(!ctype_alpha($_POST[$field])){
                    $ERROR[] = "Field <strong>$val[1]</strong> harus karakter (alpha)!"; 
                    $success = false;
                    break;
                 }
            } else if($rule_name=='alpha_numeric'){                
                 if(!ctype_alnum($_POST[$field])){
                    $ERROR[] = "Field <strong>$val[1]</strong> harus karakter dan angka saja (alpha numeric)!"; 
                    $success = false;
                    break;
                 }
            } else if($rule_name=='numeric'){                
                 if(!preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $_POST[$field])){
                    $ERROR[] = "Field <strong>$val[1]</strong> harus angka!"; 
                    $success = false;
                    break;
                 }
            } else if($rule_name=='alpha_numeric_spaces'){                
                 if(!preg_match('/^[A-Z0-9 ]+$/i', $_POST[$field])){
                    $ERROR[] = "Field <strong>$val[1]</strong> harus angka, karakter atau spasi!"; 
                    $success = false;
                    break;
                 }
            } else if($rule_name=='alpha_spaces'){                
                 if(!preg_match('/^[A-Z ]+$/i', $_POST[$field])){
                    $ERROR[] = "Field <strong>$val[1]</strong> harus karakter atau spasi!"; 
                    $success = false;
                    break;
                 }
            } else if($rule_name=='is_natural'){                
                 if(!ctype_digit($_POST[$field])){
                    $ERROR[] = "Field <strong>$val[1]</strong> harus angka 0-9!"; 
                    $success = false;
                    break;
                 }
            } else if($rule_name=='is_natural_no_zero'){                
                 if($_POST[$field]==0 && !ctype_digit($_POST[$field])){
                    $ERROR[] = "Field <strong>$val[1]</strong> harus angka dan bukan 0!"; 
                    $success = false;                    
                    break;
                 }
            } else if(strpos($rule_name, 'is_unique')!==false){
                 preg_match('/\[(.*?)\]/', $rule_name, $matches); 
                 $x = explode('.', $matches[1]);
                 $row = $db->get_row("SELECT * FROM $x[0] WHERE $x[1]='$_POST[$field]'");                                 
                 if($row){
                    $ERROR[] = "Field <strong>$val[1]</strong> harus unik!"; 
                    $success = false;
                    break;
                 }
            } 
        }
    }
    if($success)
        return true;
    else {
        if($echo) error_validation();
    }         
}

function error_validation(){
    global $ERROR;
    foreach($ERROR as $key => $val){
        print_msg($val);
    }
}

function set_value($key = null, $default = null){
    global $_POST;
    if(isset($_POST[$key]))
        return $_POST[$key];

    if(isset($_GET[$key]))
        return $_GET[$key];

    return $default;
}

function kode_oto($field, $table, $prefix, $length){
    global $db;
    $var = $db->get_var("SELECT $field FROM $table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");
    if($var){
        return $prefix . substr( str_repeat('0', $length) . (substr($var, - $length) + 1), - $length );
    } else {
        return $prefix . str_repeat('0', $length - 1) . 1;
    }
}

function esc_field($str){
    if (!get_magic_quotes_gpc())
        return addslashes($str);
    else
        return $str;
}

function get_option($option_name){
    global $db;
    return $db->get_var("SELECT option_value FROM tb_options WHERE option_name='$option_name'");
}

function update_option($option_name, $option_value){
    global $db;
    return $db->query("UPDATE tb_options SET option_value='$option_value' WHERE option_name='$option_name'");
}

function redirect_js($url){
    echo '<script type="text/javascript">window.location.replace("'.$url.'");</script>';
}

function alert($url){
    echo '<script type="text/javascript">alert("'.$url.'");</script>';
}

function set_msg($msg, $type = 'success'){

}

function show_msg(){
    if($_SESSION['message'])
        print_msg($_SESSION['message']['msg'], $_SESSION['message']['type']);
    unset($_SESSION['message']);
}

function print_msg($msg, $type='danger'){
    echo('<div class="alert alert-'.$type.' alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$msg.'</div>');
}

function get_jk_radio($selected){
    $array = array('Laki-laki', 'Perempuan');
    foreach($array as $arr){
        if($arr==$selected)
            $a.="<label class='radio-inline'>
                  <input type='radio' name='jk' value='$arr' checked> $arr
                </label>";
        else
            $a.="<label class='radio-inline'>
                  <input type='radio' name='jk' value='$arr'> $arr
                </label>";
    }
    return '<div class="radio">'.$a.'</div>';
}

function terbilang($x)
{
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return terbilang($x - 10) . "belas";
  elseif ($x < 100)
    return terbilang($x / 10) . " puluh" . terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . terbilang($x - 100);
  elseif ($x < 1000)
    return terbilang($x / 100) . " ratus" . terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . terbilang($x - 1000);
  elseif ($x < 1000000)
    return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
  elseif ($x < 1000000000)
    return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
}