<div class="page-header">
    <h1>Nilai Bobot</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline">
            <input type="hidden" name="m" value="rel_alternatif" />
            <div class="form-group">
                <input class="form-control" type="text" name="q" value="<?=$_GET['q']?>" placeholder="Pencarian..." />
            </div>
            <div class="form-group">
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama </th>
                <?php foreach($ATRIBUT[0] as $key => $val):?>
                <th><?=$key?></th>
                <?php endforeach?>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php

        $rows = $db->get_results("SELECT
                	a.kode_alternatif, a.nama_alternatif	        	           
                FROM tb_alternatif a         
                WHERE nama_alternatif LIKE '%".esc_field($_GET['q'])."%'
                ORDER BY kode_alternatif");

        $data = get_relasi();

        foreach($rows as $row):?>
        <tr>
            <td><?=$row->kode_alternatif?></td>
            <td><?=$row->nama_alternatif?></td>
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