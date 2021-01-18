<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h2>Rekap Kelengkapan Data Sekolah</h2>
<hr>
<?=form_open('report', 'class="form-inline hp" id="report"')?>
    <div class="form-group">
        <select name="s_instansi" class="form-control" id="s_instansi">
             <option>Pilih Instansi</option>
            <option value="KB">KB</option>
                <option value="SPS">SPS</option>
                <option value="TPA">TPA</option>
                <option value="RA">RA</option>
                <option value="PAUD">PAUD</option>
                <option value="TK">TK</option>
                <option value="SD">SD</option>
                <option value="MI">MI</option>
                <option value="MTS">MTS</option>
                <option value="SMP">SMP</option>
            <!-- <option value="X">KB</option>
            <option value="XI">SPS</option>
            <option value="XII">TPA</option>
            <option value="XIII">RA</option>
            <option value="XIV">PAUD</option>
            <option value="XV">TK</option>
            <option value="XVI">SD</option>
            <option value="XVII">MI</option>
            <option value="XVIII">MTS</option>
            <option value="XIX">SMP</option> -->
        </select>
        <?=form_error('s_instansi')?>

        <select name="m_initial" class="form-control" id="m_id">
            <option>Pilih Kecamatan</option>
            <?php foreach ($majors as $data) { ?>
                <option value="<?=$data->m_id?>"><?=$data->m_name?></option>
            <?php } ?>
        </select>

        <select name="s_status" class="form-control" id="s_status">
            <option>Pilih Status Kelengkapan Data</option>
            <option value="Belum Ada Data">Belum Ada Data</option>
            <option value="Kurang">Kurang</option>
            <option value="Lengkap">Lengkap</option>
        </select>
    </div>
    <div class="form-group">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary hp" name="tampilkan" id="tampilkan"><span id="tampil">Tampilkan</span></button>
        </div>
    </div>
<?=form_close()?>
<div id="result"></div>
