<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($result)) {

if ($major == "BK") {
	$m_name = "Bugulkidul";
} else if ($major == "GR") {
	$m_name = "Gadingrejo";
} else if ($major == "PGR") {
	$m_name = "Panggungrejo";
} else {
	$m_name = "Purworejo";
}

$output = '';
$outputdata = '';
$outputtail ='';
$output .= '

<div class="pull-right">
	<button class="btn btn-info hp" onclick="window.print()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
</div>
<table class="table sekolah">
	<tr>
		<td width="220px"><span class="gt">Instansi</span></td>
		<td width="20px"><span class="gt">:</span></td>
		<td><span class="gt">'.$instansi.'</span></td>
	</tr>
	<tr>
		<td width="220px"><span class="gt">Kecamatan</span></td>
		<td width="20px"><span class="gt">:</span></td>
		<td><span class="gt">'.$m_name.'</span></td>
	</tr>
	<tr>
		<td width="220px"><span class="gt">Status Kelengkapan Data</span></td>
		<td width="20px"><span class="gt">:</span></td>
		<td><span class="gt">'.$status.'</span></td>
	</tr>
	<tr>
		<td width="220px"><span class="gt">Jumlah sekolah</span></td>
		<td width="20px"><span class="gt">:</span></td>
		<td><span class="gt">'.count($result).'</span></td>
	</tr>
</table>
<div class="left-text">
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th width="200px">NPSN</th>
					<th width="300px">Nama</th>
					<th width="60px">Surat Pengantar</th>
					<th width="60px">Surat Pernyataan</th>
					<th width="60px">Usulan Rekap</th>
					<th width="60px">Profil Sekolah</th>
					<th width="60px">Peserta Didik</th>
					<th width="60px">Rombongan Belajar</th>
					<th width="60px">Sarana & Prasarana</th>
					<th width="60px">Daftar Pendidik</th>
					<th width="60px">Jadwal Pembelajaran</th>
				</tr>
		   </thead>
		   <tbody>';

foreach ($result as $row) {

	if (!empty($row->s_sp)) {
		$sp = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
	} else {
		$sp = "&minus;";
	}

	if (!empty($row->s_spn)) {
		$spn = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
	} else {
		$spn = "&minus;";
	}

	if (!empty($row->s_li)) {
		$li = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
	} else {
		$li = "&minus;";
	}

	if (!empty($row->s_ps)) {
		$ps = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
	} else {
		$ps = "&minus;";
	}

	if (!empty($row->s_pd)) {
		$pd = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
	} else {
		$pd = "&minus;";
	}

	if (!empty($row->s_rb)) {
		$rb = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
	} else {
		$rb = "&minus;";
	}

	if (!empty($row->s_spr)) {
		$spr = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
	} else {
		$spr = "&minus;";
	}

	if (!empty($row->s_dp)) {
		$dp = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
	} else {
		$dp = "&minus;";
	}

	if (!empty($row->s_jp)) {
		$jp = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
	} else {
		$jp = "&minus;"; 
	}

	$outputdata .= '
	<tr>
		<td>'.$row->s_npsn.'</td>
		<td>'.$row->s_name.'</td>
		<td>'.$sp.'</td>
		<td>'.$spn.'</td>
		<td>'.$li.'</td>
		<td>'.$ps.'</td>
		<td>'.$pd.'</td>
		<td>'.$rb.'</td>
		<td>'.$spr.'</td>
		<td>'.$dp.'</td>
		<td>'.$jp.'</td>
	</tr>';
}

$outputtail .= '
			</tbody>
		</table>
	</div>
</div> ';

 	echo $output;
	echo $outputdata;
	echo $outputtail;
} else {
  	echo '<div class="err_notif"><h3 class="text-danger"><span><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Tidak ditemukan data</span></div>';
}
