<div class="page-header">
    <h1>Nilai Bobot Kriteria</h1>
</div>
<?php
if($_POST) include'aksi.php';

$rows = $db->get_results("SELECT k.nama_kriteria, rk.ID1, rk.ID2, nilai 
    FROM tb_rel_kriteria rk INNER JOIN tb_kriteria k ON k.kode_kriteria=rk.ID1 
    ORDER BY ID1, ID2");
$criterias = array();
$data = array();
foreach($rows as $row){    
    $criterias[$row->ID1] = $row->nama_kriteria;
    $data[$row->ID1][$row->ID2] = $row->nilai;
}
?>
<div class="panel panel-default">
<div class="panel-heading">
<form class="form-inline" action="?m=rel_kriteria" method="post">
    <div class="form-group">
        <select class="form-control" name="ID1">
        <?=AHP_get_kriteria_option($_POST['ID1'])?>
        </select>
    </div>
    <div class="form-group">
        <select class="form-control" name="nilai">
        <?=AHP_get_nilai_option($_POST['nilai'])?>
        </select>
    </div>
    <div class="form-group">
        <select class="form-control" name="ID2">
        <?=AHP_get_kriteria_option($_POST['ID2'])?>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
    </div>
</form>
</div>

<table class="table table-bordered table-hover table-striped">
<thead>
    <tr>
        <th>Kode</th>
        <?php 
        foreach($data as $key=>$value){
            echo "<th>$key</th>";
        }         
        ?>
    </tr>
</thead>
<tbody>
<?php

$no=1;

foreach($data as $key => $value):?>
<tr>
    <th><?=$key?></th>
    <?php  
        foreach($value as $dt){
            echo "<td>".round($dt, 3)."</td>";               
        } 
        $no++;       
    ?>
</tr>
<?php endforeach;
?>
</tbody>
</table>
</div>