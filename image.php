<?php
include 'functions.php';

header ('Content-Type: image/png');
$img = imagecreatetruecolor (1210, 410);
imagefilledrectangle($img, 0, 0, 1210, 410, imagecolorallocate ( $img, 255, 255, 255 ));
$c_black = imagecolorallocate($img, 0, 0, 0);
$c_green = imagecolorallocate($img, 0, 255, 0);
$c_blue = imagecolorallocate($img, 0, 0, 255);
$c_red = imagecolorallocate($img, 255, 0, 0);
imageline ( $img , 0 , 400 , 1200 , 400 , $c_black );
imageline ( $img , 100 , 0 , 100 , 410 , $c_black );

$kriteria = $db->get_row("SELECT * FROM tb_kriteria WHERE kode_kriteria='$_GET[kode_kriteria]'");
$rows = $db->get_results("SELECT * FROM tb_himpunan WHERE kode_kriteria='$_GET[kode_kriteria]' ORDER BY n1");

addAxis($img, 0, $kriteria->batas_atas);
addAxis($img, $kriteria->batas_bawah, $kriteria->batas_atas);
addAxis($img, $kriteria->batas_atas, $kriteria->batas_atas);

$arr = array();
foreach($rows as $row){
    addHimpunan($img, $row->n1, $row->n2, $row->n3, $row->n4, $kriteria->batas_bawah, $kriteria->batas_atas);
}

function addHimpunan($img, $n1, $n2, $n3, $n4, $batas_bawah, $batas_atas){
    global $c_red;
    $x1 = 1000 / $batas_atas * $n1 + 100;
    $x2 = 1000 / $batas_atas * $n2 + 100;
    $x3 = 1000 / $batas_atas * $n3 + 100;
    $x4 = 1000 / $batas_atas * $n4 + 100;
    
    //$bb = 1000 /$batas_atas * $batas_bawah + 100;
    //$ba = 1000 /$batas_atas * $batas_bawah + 100;
    
    // if($n1 <= $batas_bawah)
    //     imageline ( $img , $x1, 0 , $x2 , 0 , $c_red );
    // else
        imageline ( $img , $x1, 400 , $x2 , 0 , $c_red );
    
        imageline ( $img , $x2, 0 , $x3 , 0 , $c_red );
    
    // if($n4 >= $batas_atas)
    //     imageline ( $img , $x3, 400 , $x4 , 400 , $c_red );
    // else
        imageline ( $img , $x3, 0 , $x4 , 400 , $c_red );
    
    addAxis($img, $n1, $batas_atas);
    addAxis($img, $n2, $batas_atas);
    addAxis($img, $n3, $batas_atas);
    
    addAxis($img, $n4, $batas_atas);
}

function addAxis($img, $n, $batas_atas){
    global $c_black, $c_green;
    $x = (1000 / $batas_atas) * $n + 100;
    imageline ( $img , $x, 400 , $x , 410 , $c_black );
    $a = dirname(__FILE__);    
    imagettftext($img, 8, 0, $x + 5, 410, $c_black, $a.'\verdana.ttf', $n);
    
    if($n!=0)
        imagedashedline ( $img , $x, 0 , $x , 400 , $c_green );
}

imagepng($img);