<?php
$row = $db->get_row("SELECT * FROM tb_rel_alternatif WHERE kode_alternatif='$_GET[ID]'"); 
?>
<div class="page-header">
    <h1>Input Nilai &raquo; <small><?=$row->kode_alternatif?></small></h1>
</div>

<div class="row">
    <div class="col-sm-1">
    <table class="table table-bordered table-hover table-striped">
       <thead>
    <tr>
        <th>Kode</th>
     
		<th>Nilai C1</th>
		<th>Nilai C2</th>
		<th>Nilai C3</th>
		<th>Nilai C4</th>
        <th>Aksi</th>
    </tr>
</thead>
        <tbody>
        <?php

        $rows = $db->get_results("SELECT
                	a.kode_alternatif, a.kode_alternatif	        	           
                FROM tb_rel_alternatif a         
                WHERE kode_alternatif LIKE '%".esc_field($_GET['q'])."%'
                ORDER BY kode_alternatif");

        $data = get_relasi();

        foreach($rows as $row):?>
		
        <tr>
            <td><?=$row->kode_alternatif?></td>
			<?php foreach($data[$row->kode_alternatif] as $k => $v):?>
            <td><?=$v?></td>
            <?php endforeach?>
            <td>
                <a class="btn btn-xs btn-warning" href="?m=rel_alternatif_ubah&ID=<?=$row->kode_alternatif?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>        
            </td>
        </tr>
		
        <?php endforeach;?>
		
		
		
        </tbody>
    </table>
</div>
       
    </div>
</div>