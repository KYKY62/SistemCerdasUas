<h1>Kriteria</h1>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Kriteria</th>
            <th>Batas Bawah</th>
            <th>Batas Tengah</th>
            <th>Batas Atas</th>
            <th>Nama Bawah</th>
            <th>Nama Tengah</th>
            <th>Nama Atas</th>
        </tr>
    </thead>
    <?php
    $q = esc_field($_GET['q']);
    $rows = $db->get_results("SELECT * FROM tb_kriteria WHERE nama_kriteria LIKE '%$q%' ORDER BY kode_kriteria");
    $no=0;
    foreach($rows as $row):?>
    <tr>
        <td><?=++$no ?></td>
        <td><?=$row->kode_kriteria?></td>
        <td><?=$row->nama_kriteria?></td>
        <td><?=$row->batas_bawah?></td>
        <td><?=$row->batas_tengah?></td>
        <td><?=$row->batas_atas?></td>
        <td><?=$row->nama_bawah?></td>
        <td><?=$row->nama_tengah?></td>
        <td><?=$row->nama_atas?></td>
    </tr>
    <?php endforeach;?>
</table>