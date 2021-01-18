<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h2><?=$form_title?></h2>
<hr>
<?=form_open_multipart($action, 'class="form-horizontal"')?>
<h3>Data Sekolah</h3>
<hr>
    <div class="form-group">
        <label class="col-sm-2 control-label">NPSN</label>
        <div class="col-sm-4">
            <input type="number" name="s_npsn" class="form-control" value="<?=isset($school['s_npsn']) ? $school['s_npsn'] : set_value('s_npsn')?>" placeholder="NPSN" required>
            <small class="text-danger"><?=form_error('s_npsn')?></small>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Nama</label>
        <div class="col-sm-6">
            <input type="text" name="s_name" class="form-control" value="<?=isset($school['s_name']) ? $school['s_name'] : set_value('s_name')?>" placeholder="Nama" required>
            <small class="text-danger"><?=form_error('s_name')?></small>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Sk Izin Operasional</label>
        <div class="col-sm-3">
            <input type="date" name="s_dob" class="form-control" value="<?=isset($school['s_dob']) ? $school['s_dob'] : set_value('s_dob')?>" placeholder="Sk Izin Operasional" required>
            <small class="text-danger"><?=form_error('s_dob')?></small>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Status Sekolah</label>
        <div class="col-sm-3">
            <select name="s_statussekolah" class="form-control" required>
                <option value="<?=isset($school['s_statussekolah']) ? $school['s_statussekolah'] : set_value('s_statussekolah')?>"><?=isset($school['s_statussekolah']) ? $school['s_statussekolah'] : set_value('s_statussekolah')?></option>
                <option value="Negeri">Negeri</option>
                <option value="Swasta">Swasta</option>
            </select>
            <small class="text-danger"><?=form_error('s_statussekolah')?></small>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Instansi</label>
        <div class="col-sm-2">
            <select required name="s_instansi" class="form-control">
                <option value="<?=isset($school['s_instansi']) ? $school['s_instansi'] : set_value('s_instansi')?>"><?=isset($school['s_instansi']) ? $school['s_instansi'] : set_value('s_instansi')?></option>
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
            </select>
            <small class="text-danger"><?=form_error('s_instansi')?></small>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Kecamatan</label>
        <div class="col-sm-3">
            <select name="s_kec" class="form-control" required>
                <option value="<?=isset($school['s_kec']) ? $school['s_kec'] : set_value('s_kec')?>"><?=isset($school['s_kec']) ? $school['s_kec'] : set_value('s_kec')?></option>
                <?php foreach (array_reverse($majors) as $row) {     ?>
                    <option value="<?=$row['m_id']?>"><?=$row['m_name']?></option>
                <?php } ?>
            </select>
            <small class="text-danger"><?=form_error('s_kec')?></small>
        </div>
    </div>
   <!--  <div class="form-group">
        <label class="col-sm-2 control-label">Tahun Masuk</label>
        <div class="col-sm-2">
            <select name="s_yi" class="form-control" required>
                <option value="<?=isset($school['s_yi']) ? $school['s_yi'] : set_value('s_yi')?>"><?=isset($school['s_yi']) ? $school['s_yi'] : set_value('s_yi')?></option>
                <?php for ($i = date('Y') - 2; $i <= date('Y') + 2; $i++) { ?>
                    <option value="<?=$i?>"><?=$i?></option>
                <?php } ?>
            </select>
            <small class="text-danger"><?=form_error('s_yi')?></small>
        </div>
    </div> -->
    <div class="form-group">
        <label class="col-sm-2 control-label">Foto</label>
        <div class="col-sm-10">
            <?php if ($this->uri->segment(2) == 'edit') { ?>
                <?php if (file_exists('./uploads/foto/' . $school['s_foto'])) { ?>
                    <a href="<?=site_url('uploads/foto/' . $school['s_foto'])?>" target="_blank" ><?=$school['s_foto']?></a>
                <?php } ?>
                <input type="file" name="s_foto">
                <small class="help-block">Format gambar yang diperbolehkan *.png, *.jpg dan ukuran maksimal 1 MB.</small>
                <small class="text-danger"><?=!empty($err_foto) ? $err_foto : "";?></small>
            <?php } else { ?>
                <input type="file" name="s_foto">
                <small class="help-block">Format gambar yang diperbolehkan *.png, *.jpg dan ukuran maksimal 1 MB.</small>
                <small class="text-danger"><?=!empty($err_foto) ? $err_foto : "";?></small>
            <?php } ?>
        </div>
    </div>
    <hr>
    <h3>Lampiran</h3>
    <p class="help-block">Format file yang diperbolehkan *.pdf dan ukuran maksimal 30 MB.</p>
    <hr>
    <div class="form-group">
        <label class="col-sm-2 control-label">Surat Pengantar</label>
        <div class="col-sm-10">
            <?php if ($this->uri->segment(2) == 'edit') { ?>
                <?php if (file_exists('./uploads/Surat_Pengantar/' . $school['s_sp'])) { ?>
                    <a href="<?=site_url('uploads/Surat_Pengantar/' . $school['s_sp'])?>" target="_blank" ><?=$school['s_sp']?></a>
                <?php } ?>
                <input type="file" name="s_sp">
                <small class="text-danger"><?=!empty($err_sp) ? $err_sp : "";?></small>
            <?php } else { ?>
                <input type="file" name="s_sp">
                <small class="text-danger"><?=!empty($err_sp) ? $err_sp : "";?></small>
            <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Surat Pernyataan</label>
        <div class="col-sm-10">
            <?php if ($this->uri->segment(2) == 'edit') { ?>
                <?php if (file_exists('./uploads/Surat_Pernyataan/' . $school['s_spn'])) { ?>
                    <a href="<?=site_url('uploads/Surat_Pernyataan/' . $school['s_spn'])?>" target="_blank" ><?=$school['s_spn']?></a>
                <?php } ?>
                <input type="file" name="s_spn">
                <small class="text-danger"><?=!empty($err_spn) ? $err_spn : "";?></small>
            <?php } else { ?>
                <input type="file" name="s_spn">
                <small class="text-danger"><?=!empty($err_spn) ? $err_spn : "";?></small>
            <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Usulan Program</label>
        <div class="col-sm-10">
            <?php if ($this->uri->segment(2) == 'edit') { ?>
                <?php if (file_exists('./uploads/Usulan_Program/' . $school['s_li'])) { ?>
                    <a href="<?=site_url('uploads/ktpi/' . $school['s_li'])?>" target="_blank" ><?=$school['s_li']?></a>
                <?php } ?>
                <input type="file" name="s_li">
                <small class="text-danger"><?=!empty($err_li) ? $err_li : "";?></small>
            <?php } else { ?>
                <input type="file" name="s_li">
                <small class="text-danger"><?=!empty($err_li) ? $err_li : "";?></small>
            <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Profil Sekolah</label>
        <div class="col-sm-10">
            <?php if ($this->uri->segment(2) == 'edit') { ?>
                <?php if (file_exists('./uploads/Profil_Sekolah/' . $school['s_ps'])) { ?>
                    <a href="<?=site_url('uploads/Profil_Sekolah/' . $school['s_ps'])?>" target="_blank" ><?=$school['s_ps']?></a>
                <?php } ?>
                <input type="file" name="s_ps">
                <small class="text-danger"><?=!empty($err_ps) ? $err_ps : "";?></small>
            <?php } else { ?>
                <input type="file" name="s_ps">
                <small class="text-danger"><?=!empty($err_ps) ? $err_ps : "";?></small>
            <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Peserta Didik</label>
        <div class="col-sm-10">
            <?php if ($this->uri->segment(2) == 'edit') { ?>
                <?php if (file_exists('./uploads/Peserta_Didik/' . $school['s_pd'])) { ?>
                    <a href="<?=site_url('uploads/Peserta_Didik/' . $school['s_pd'])?>" target="_blank" ><?=$school['s_pd']?></a>
                <?php } ?>
                <input type="file" name="s_pd">
                <small class="text-danger"><?=!empty($err_pd) ? $err_pd : "";?></small>
            <?php } else { ?>
                <input type="file" name="s_pd">
                <small class="text-danger"><?=!empty($err_pd) ? $err_pd : "";?></small>
            <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Rombongan Belajar</label>
        <div class="col-sm-10">
            <?php if ($this->uri->segment(2) == 'edit') { ?>
                <?php if (file_exists('./uploads/Rombongan_Belajar/' . $school['s_rb'])) { ?>
                    <a href="<?=site_url('uploads/Rombongan_Belajar/' . $school['s_rb'])?>" target="_blank" ><?=$school['s_rb']?></a>
                <?php } ?>
                <input type="file" name="s_rb">
                <small class="text-danger"><?=!empty($err_rb) ? $err_rb : "";?></small>
            <?php } else { ?>
                <input type="file" name="s_rb">
                <small class="text-danger"><?=!empty($err_rb) ? $err_rb : "";?></small>
            <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Sarana & Prasarana</label>
        <div class="col-sm-10">
            <?php if ($this->uri->segment(2) == 'edit') { ?>
                <?php if (file_exists('./uploads/Sarana&Prasarana/' . $school['s_spr'])) { ?>
                    <a href="<?=site_url('uploads/Sarana&Prasarana/' . $school['s_spr'])?>" target="_blank" ><?=$school['s_spr']?></a>
                <?php } ?>
                <input type="file" name="s_spr">
                <small class="text-danger"><?=!empty($err_spr) ? $err_spr : "";?></small>
            <?php } else { ?>
                <input type="file" name="s_spr">
                <small class="text-danger"><?=!empty($err_spr) ? $err_spr : "";?></small>
            <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Daftar Pendidik</label>
        <div class="col-sm-10">
            <?php if ($this->uri->segment(2) == 'edit') { ?>
                <?php if (file_exists('./uploads/Daftar_Pendidik/' . $school['s_dp'])) { ?>
                    <a href="<?=site_url('uploads/Daftar_Pendidik/' . $school['s_dp'])?>" target="_blank" ><?=$school['s_dp']?></a>
                <?php } ?>
                <input type="file" name="s_dp">
                <small class="text-danger"><?=!empty($err_dp) ? $err_dp : "";?></small>
            <?php } else { ?>
                <input type="file" name="s_dp">
                <small class="text-danger"><?=!empty($err_dp) ? $err_dp : "";?></small>
            <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Jadwal Pembelajaran</label>
        <div class="col-sm-10">
            <?php if ($this->uri->segment(2) == 'edit') { ?>
                <?php if (file_exists('./uploads/Jadwal_Pembelajaran/' . $school['s_jp'])) { ?>
                    <a href="<?=site_url('uploads/Jadwal_Pembelajaran/' . $school['s_jp'])?>" target="_blank" ><?=$school['s_jp']?></a>
                <?php } ?>
                <input type="file" name="s_jp">
                <small class="text-danger"><?=!empty($err_jp) ? $err_jp : "";?></small>
            <?php } else { ?>
                <input type="file" name="s_jp">
                <small class="text-danger"><?=!empty($err_jp) ? $err_jp : "";?></small>
            <?php } ?>
        </div>
    </div>
    <hr>
    <h3>Status Kelengkapan Data</h3>
    <p class="help-block">Pilih status kelengkapan data berdasarkan lampiran.</p>
    <hr>
    <div class="form-group">
        <label class="col-sm-2 control-label">Status Data</label>
        <div class="col-sm-3">
            <select id="s_status" name="s_status" class="form-control" required>
                <option></option>
                <option value="Belum Ada Data">Belum Ada Data</option>
                <option value="Kurang">Kurang</option>
                <option value="Lengkap">Lengkap</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <small class="help-block hint">Tombol simpan akan muncul setelah Anda memilih status kelengkapan data.</small>
            <br>
            <button type="submit" name="submit" class="btn btn-success hide" id="submit">Simpan</button>&nbsp;
            <a class="btn btn-default" href="<?=site_url('school')?>">Kembali</a>
        </div>
    </div>
<?=form_close()?>
