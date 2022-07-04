<div class="page-header">
	<h1>Aturan Fuzzy</h1>
</div>
<?php
if($_POST){	
	$dicari = get_dicari();
	$no_aturan = $_POST['no_aturan'];
	$operator = $_POST['operator'];
	$nilai = (array)$_POST['nilai'];

	if(count($nilai)<2){
		print_msg('Pilih minimal 2 nilai dari kriteria!');
	} else if(!$nilai[$dicari]){
		print_msg('Pilih nilai output!');
	} else {
		$db->query("DELETE FROM tb_aturan WHERE no_aturan='$no_aturan'");
		foreach($nilai as $key => $val){
			$db->query("INSERT INTO tb_aturan (no_aturan, operator, kode_kriteria, kode_himpunan)
				VALUES ('$no_aturan', '$operator', '$key', '$val')");			
		}		
		print_msg('Aturan berhasil disimpan!', 'success');
	}
}

$aturan = get_aturan();
?>
<form method="post">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Tambah Aturan</h3>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered">
				<tr>
					<td>No Aturan</td>
					<td>Operator</td>
					<?php foreach($KRITERIA as $key => $val):?>
					<td><?=$val->nama_kriteria?></td>
					<?php endforeach?>
				</tr>
				<tr>
					<td><input class="form-control" type="number" name="no_aturan" value="<?=$db->get_var("SELECT MAX(no_aturan) + 1 FROM tb_aturan")?>"></td>
					<td>
						<select class="form-control" name="operator">
							<?=get_operator_option($_POST['operator'])?>
						</select>
					</td>
					<?php foreach($KRITERIA as $key => $val):?>
					<td>
						<select class="form-control" name="nilai[<?=$key?>]" size="<?=count($KRITERIA_HIMPUNAN[$key])?>">
							<?=get_himpunan_option($key, $_POST['nilai'][$key])?>
						</select>
					</td>
					<?php endforeach?>
				</tr>
			</table>
		</div>
		<div class="panel-body">
			<button class="btn btn-primary">Simpan Aturan</button>
			<a class="btn btn-success" href="?m=aturan">Reset</a>
		</div>
	</div>
</form>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Aturan</h3>
	</div>
	<div class="table-responsive">
		<table class="table table-bordered">
			<tr>
				<td>No Aturan</td>
				<td>Aturan</td>
				<td>Aksi</td>
			</tr>
			<?php foreach($aturan as $key => $val):?>
			<tr>					
				<td><?=$key?></td>
				<td><?=$val->to_string()?></td>
				<td><a class="btn btn-xs btn-danger" onclick="return confirm('Hapus data?')" href="aksi.php?act=aturan_hapus&ID=<?=$key?>"><span class="glyphicon glyphicon-trash"></span> Hapus</a></td>
			</tr>
			<?php endforeach?>
		</table>
	</div>
</div>