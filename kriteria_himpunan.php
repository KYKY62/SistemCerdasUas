<?php
    $row = $db->get_row("SELECT * FROM tb_kriteria WHERE kode_kriteria='$_GET[ID]'"); 
?>
<div class="page-header">
    <h1>Himpunan </h1>
</div>
<div class="row">
    <div class="col-sm-12">
        <table class="table aw">
            <tr>
                <td>Kode</td>
                <td>: <?=$row->kode_kriteria?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>: <?=$row->nama_kriteria?></td>
            </tr>
            <tr>
                <td>Batas</td>
                <td>: <?=$row->batas_bawah?>-<?=$row->batas_atas?></td>
            </tr>
        </table>        
        <?php if($_POST) include'aksi.php'?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <form method="post" class="form-inline">
                    <div class="form-group">
                        <input class="form-control input-sm aw" type="text" name="kode_himpunan" value="<?=kode_oto('kode_himpunan', 'tb_himpunan', $_GET['ID'] . '-', 2)?>" placeholder="Kode" size="5"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control input-sm aw" type="text" name="nama_himpunan" value="<?=set_value('nama_himpunan')?>" placeholder="Nama himpunan"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control input-sm aw" type="text" name="n1" value="<?=set_value('n1')?>" placeholder="Batas 1" size="6"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control input-sm aw" type="text" name="n2" value="<?=set_value('n2')?>" placeholder="Batas 2" size="6"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control input-sm aw" type="text" name="n3" value="<?=set_value('n3')?>" placeholder="Batas 3" size="6"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control input-sm aw" type="text" name="n4" value="<?=set_value('n4')?>" placeholder="Batas 4" size="6"/>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" name="tambah_himpunan" value="1"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
                    </div>
                </form>
            </div>
            <form class="table-responsive" method="post">
                <table class="table">
                    <thead><tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Batas1</th>
                        <th>Batas2</th>
                        <th>Batas3</th>
                        <th>Batas4</th>
                        <th>#</th>
                    </tr></thead>
                    <?php 
                    $rows = $db->get_results("SELECT * FROM tb_himpunan WHERE kode_kriteria='$_GET[ID]' ORDER BY n1, n2, n3, n4");
                    foreach($rows as $row): ?>
                    <tr>
                        <td><?=$row->kode_himpunan?></td>
                        <td><input class="form-control input-sm aw" name="data[<?=$row->kode_himpunan?>][nama_himpunan]" value="<?=$row->nama_himpunan?>" /></td>
                        <td><input class="form-control input-sm aw" name="data[<?=$row->kode_himpunan?>][n1]" value="<?=$row->n1?>" size="4" /></td>
                        <td><input class="form-control input-sm aw" name="data[<?=$row->kode_himpunan?>][n2]" value="<?=$row->n2?>" size="4" /></td>
                        <td><input class="form-control input-sm aw" name="data[<?=$row->kode_himpunan?>][n3]" value="<?=$row->n3?>" size="4" /></td>
                        <td><input class="form-control input-sm aw" name="data[<?=$row->kode_himpunan?>][n4]" value="<?=$row->n4?>" size="4" /></td>
                        <td>
                            <a class="btn btn-xs btn-danger" href="aksi.php?m=himpunan_hapus&ID=<?=$row->kode_himpunan?>&kode_kriteria=<?=$row->kode_kriteria?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                    <?php endforeach?>
                    <tfoot><tr>
                        <td colspan="7">
                            <button class="btn btn-sm btn-primary pull-right" name="simpan_himpunan" value="1"><span class="glyphicon glyphicon-save"></span> Simpan Nilai</button>
                        </td>
                    </tr></tfoot>
                </table>
            </form>
            <div class="panel-body">
                <img src="image.php?kode_kriteria=<?=$_GET['ID']?>" class="img-responsive"/>
            </div>
        </div>           
        <div class="form-group">
            <a class="btn btn-danger" href="?m=kriteria"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
        </div>
    </div>
</div>