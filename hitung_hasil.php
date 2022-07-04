<?php
$data = get_relasi();
$nilai = get_nilai($data);
$aturan = get_rules();
$min = get_min($nilai, $aturan);

//$total = get_total($aturan, $min);

?>
<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">Input Nilai</h3></div>
    <div class="oxa">
        <table class="table table-bordered table-striped table-hover">
            <thead><tr>
                <th>Kode</th>
                <th>Nama</th>
                <?php foreach($ATRIBUT[0] as $key => $val):?>
                <th><?=$key?></th>
                <th><?=$key?></th>
                <th><?=$key?></th>
                <?php endforeach?>
            </tr></thead>        
            <?php foreach($data as $key => $val):?>
        </table>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">Nilai Fuzzy</h3></div>
    <div class="oxa">
        <table class="table table-bordered table-striped table-hover small">
            <thead><tr>
                <th rowspan="3"></th>
                <?php foreach($ATRIBUT[0] as $key => $val):?>
                <th colspan="<?=count($KRITERIA_HIMPUNAN[$key])?>" class="text-center"><?=$val->nama_kriteria?></th>
                <?php endforeach?>
            </tr>
            <tr>
                <?php foreach($ATRIBUT[0] as $key => $val):?>
                <?php foreach($KRITERIA_HIMPUNAN[$key] as $k => $v):?>
                <td><?=$HIMPUNAN[$k]->nama_himpunan?><br />[<?=$HIMPUNAN[$k]->n1?> <?=$HIMPUNAN[$k]->n2?> <?=$HIMPUNAN[$k]->n3?>
                  <?=$HIMPUNAN[$k]->n4?>                
                ]</td>
                <?php endforeach?>
                <?php endforeach?>
            </tr></thead>        
            <?php foreach($nilai as $key => $val):?>
            <tr>
                <th><?=$key?></th>
                <?php foreach($val as $k => $v):?>
                <?php foreach($v as $a => $b):?>
                <td><?=round($b, 3)?></td>
                <?php endforeach?>
                <?php endforeach?>
            </tr>
            <?php endforeach?>
        </table>
  </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">Aturan</div>
    <table class="table table-bordered">
        <thead><tr>
            <th>No</th>
            <?php foreach($KRITERIA as $key => $val):?>
            <th><?=($KRITERIA[$key]->nama_kriteria)?></th>
            <?php endforeach?>            
            <?php foreach($ALTERNATIF as $key => $val):?>            
            <th><?=$key?></th>
            <?php endforeach?>
        </tr></thead>
        <?php         
        foreach($aturan as $key => $val):?>
        <tr>
            <td><?=$key+1?></td>
            <?php foreach($val['item'] as $k => $v):?>
            <td><?=$HIMPUNAN[$v]->nama_himpunan?></td>
            <?php endforeach?>            
            <td class="text-primary"><?=$HIMPUNAN[$val['nilai']]->nama_himpunan?></td>
            <?php foreach($ALTERNATIF as $k => $v):?>            
            <td><?=round($min[$key][$k], 3)?></td>
            <?php endforeach?>
        </tr>
        <?php endforeach?>
    </table>
</div>

<!--<div class="panel panel-primary">
    <div class="panel-heading"><div class="panel-title">Hasil Akhir</div></div>
    <div class="oxa">
        <table class="table table-bordered table-striped table-hover">
            <thead><tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Total</th>                
            </tr></thead>        
            <?php foreach($total as $key => $val):?>
            <tr>
                <td><?=$key?></td>
                <td><?=$ALTERNATIF[$key]?></td>
                <td><?=round($total[$key], 3)?></td>
            </tr>
            <?php endforeach?>
        </table>
    </div>
</div>-->