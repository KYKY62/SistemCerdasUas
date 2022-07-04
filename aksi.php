<?php
require_once'functions.php';
 
if ($mod=='login'){
    $user = esc_field($_POST['user']);
    $pass = esc_field($_POST['pass']);
    
    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$user' AND pass='$pass'");
    if($row){
        $_SESSION['login'] = $row->user;
        redirect_js("index.php");
    } else{
        print_msg("Salah kombinasi username dan password.");
    }          
}else if ($mod=='password'){
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];
    
    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$_SESSION[login]' AND pass='$pass1'");        
    
    if($pass1=='' || $pass2=='' || $pass3=='')
        print_msg('Field bertanda * harus diisi.');
    elseif(!$row)
        print_msg('Password lama salah.');
    elseif( $pass2 != $pass3 )
        print_msg('Password baru dan konfirmasi password baru tidak sama.');
    else{        
        $db->query("UPDATE tb_admin SET pass='$pass2' WHERE user='$_SESSION[login]'");                    
        print_msg('Password berhasil diubah.', 'success');
    }
} elseif($act=='logout'){
    unset($_SESSION['login']);
    header("location:index.php?m=login");
}

/** ALTERNATIF **/
elseif($mod=='alternatif_tambah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    
    if($kode=='' || $nama=='' )
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_alternatif WHERE kode_alternatif='$kode'"))
        print_msg("Kode sudah ada!");
    else{        
        $db->query("INSERT INTO tb_alternatif(kode_alternatif, nama_alternatif, keterangan) VALUES ('$kode', '$nama', '$keterangan')");
        $db->query("INSERT INTO tb_rel_alternatif(kode_alternatif, kode_kriteria, nilai) SELECT '$kode', kode_kriteria, 0 FROM tb_kriteria");     
        redirect_js("index.php?m=alternatif");
    }
} elseif ($mod=='alternatif_ubah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    
    if($kode=='' || $nama=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_alternatif WHERE kode_alternatif='$kode' AND kode_alternatif<>'$_GET[ID]'"))
        print_msg("Kode sudah ada!");
    else{        
        $db->query("UPDATE tb_alternatif SET kode_alternatif='$kode', nama_alternatif='$nama', keterangan='$keterangan' WHERE kode_alternatif='$_GET[ID]'");
        redirect_js("index.php?m=alternatif");
    }
} elseif ($act=='alternatif_hapus'){    
    $db->query("DELETE FROM tb_alternatif WHERE kode_alternatif='$_GET[ID]'");
    $db->query("DELETE FROM tb_rel_alternatif WHERE kode_alternatif='$_GET[ID]'");
    header("location:index.php?m=alternatif");
} 

/** KRITERIA */    
if($mod=='kriteria_tambah'){
    $kode_kriteria = $_POST['kode_kriteria'];
    $nama_kriteria = $_POST['nama_kriteria'];
    $batas_bawah = $_POST['batas_bawah'];    
    $batas_atas = $_POST['batas_atas'];
    //print_r($_POST);
    if(!$kode_kriteria || !$nama_kriteria || $batas_bawah=='' || $batas_atas=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_kriteria WHERE kode_kriteria='$kode_kriteria'"))
        print_msg("Kode sudah ada!");
    elseif($batas_bawah <0 || $batas_atas <0)
        print_msg("Batas minimal 0!");
    elseif($batas_bawah >= $batas_atas)
        print_msg("Batas atas harus lebih besar dari batas bawah!");
    else{
        $db->query("INSERT INTO tb_kriteria (kode_kriteria, nama_kriteria, batas_bawah, batas_atas) 
            VALUES ('$kode_kriteria', '$nama_kriteria', '$batas_bawah', '$batas_atas')");
        $db->query("INSERT INTO tb_rel_alternatif (kode_alternatif, kode_kriteria, nilai) 
            SELECT kode_alternatif, '$kode_kriteria', 0 FROM tb_alternatif");        
        
        update_kriteria();
        redirect_js("index.php?m=kriteria");
    }    
} else if($mod=='kriteria_ubah'){
    $nama_kriteria = $_POST['nama_kriteria'];
    $batas_bawah = $_POST['batas_bawah'];    
    $batas_atas = $_POST['batas_atas'];
    
    if(!$nama_kriteria  || $batas_bawah=='' || $batas_atas=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($batas_bawah <0 || $batas_atas <0)
        print_msg("Batas bawah minimal 0!");
    elseif($batas_bawah >= $batas_atas)
        print_msg("Batas atas harus lebih besar dari batas bawah!");
    else{
        $db->query("UPDATE tb_kriteria 
            SET nama_kriteria='$nama_kriteria', batas_bawah='$batas_bawah', batas_atas='$batas_atas'
            WHERE kode_kriteria='$_GET[ID]'");
        
        update_kriteria();
        redirect_js("index.php?m=kriteria");
    }    
} else if ($act=='kriteria_hapus'){
    $db->query("DELETE FROM tb_kriteria WHERE kode_kriteria='$_GET[ID]'");   
    $db->query("DELETE FROM tb_rel_alternatif WHERE kode_kriteria='$_GET[ID]'"); 
    $db->query("DELETE FROM tb_aturan WHERE kode_kriteria='$_GET[ID]'");
    
    update_kriteria();
    header("location:index.php?m=kriteria");
} 

/** RELASI ALTERNATIF */ 
else if ($act=='rel_alternatif_ubah'){
    foreach($_POST as $key => $value){
        $ID = str_replace('ID-', '', $key);
        $db->query("UPDATE tb_rel_alternatif SET nilai='$value' WHERE ID='$ID'");
    }
    header("location:index.php?m=rel_alternatif");
} 

else if($mod=='kriteria_himpunan'){
    if($_POST['tambah_himpunan']){
        $kode_himpunan = $_POST['kode_himpunan'];
        $nama_himpunan = $_POST['nama_himpunan'];
        $n1 = $_POST['n1'];
        $n2 = $_POST['n2'];
        $n3 = $_POST['n3'];
        $n4 = $_POST['n4'];
        
        if($kode_himpunan=='' || $nama_himpunan=='' || $n1=='' || $n2=='' || $n3=='' || $n4==''){
            print_msg("Semua Field harus diisi!");            
        } else {
            $db->query("INSERT INTO tb_himpunan (kode_himpunan, kode_kriteria, nama_himpunan, n1, n2, n3, n4)
                VALUES ('$kode_himpunan', '$_GET[ID]', '$nama_himpunan', '$n1', '$n2', '$n3', '$n4' )");
            print_msg('Himpunan berhasil ditambah!', 'success');
        }
    } else if($_POST['simpan_himpunan']){
        $data = $_POST['data'];        
        foreach($data as $key => $val){
            $db->query("UPDATE tb_himpunan SET nama_himpunan='$val[nama_himpunan]', n1='$val[n1]', n2='$val[n2]', n3='$val[n3]', n4='$val[n4]' WHERE kode_himpunan='$key'");
        }
        print_msg('Himpunan berhasil disimpan!', 'success');
    }
} else if($mod=='himpunan_hapus'){    
    $db->query("DELETE FROM tb_himpunan WHERE kode_himpunan='$_GET[ID]'");
    header("location:index.php?m=kriteria_himpunan&ID=$_GET[kode_kriteria]");
} 

else if($act=='aturan_hapus'){    
    $db->query("DELETE FROM tb_aturan WHERE no_aturan='$_GET[ID]'");
    header("location:index.php?m=aturan");
}