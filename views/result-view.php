<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row print">
    <div class="col-sm-3" id="foto">
        <?php if (!empty($school['s_foto'])) { ?>
            <img class="foto" src="<?=site_url('uploads/foto/'.$school['s_foto'])?>" alt="Foto">
        <?php } else { ?>
            <img class="foto" src="<?=site_url('assets/img/avatar.png')?>" alt="Foto">
        <?php } ?>
    </div>
    <div class="col-sm-7" id="data">
        <table class="table sekolah">
            <tbody>
                <tr>
                    <td width="150px">NPSN</td>
                    <td width="5px">:</td>
                    <td><?=$school['s_npsn']?></td>
                </tr>
                <tr>
                    <td width="150px">Nama</td>
                    <td width="5px">:</td>
                    <td><?=$school['s_name']?></td>
                </tr>
                <tr>
                    <td width="150px">Sk Izin Operasional</td>
                    <td width="5px">:</td>
                    <td><?=$school['s_dob']?></td>
                </tr>
                <tr>
                    <td width="150px">Status Sekolah</td>
                    <td width="5px">:</td>
                    <td><?=$school['s_statussekolah']?></td>
                </tr>
                <tr>
                    <td width="150px">Instansi</td>
                    <td width="5px">:</td>
                    <td><?=$school['s_instansi']?></td>
                </tr>
                <tr>
                    <td width="150px">Kecamatan</td>
                    <td width="5px">:</td>
                    <td><?=$school['m_name']?></td>
                </tr>

                <!-- <?php if ($school['s_is_active'] == "Aktif") { ?>
                    <tr>
                        <td width="150px">Tahun Masuk</td>
                        <td width="5px">:</td>
                        <td><?=$school['s_yi']?></td>
                    </tr>
                    <tr>
                        <td width="150px">Tahun Keluar</td>
                        <td width="5px">:</td>
                        <td>&minus;</td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td width="150px">Tahun Masuk</td>
                        <td width="5px">:</td>
                        <td><?=$school['s_yi']?></td>
                    </tr>
                    <tr>
                        <td width="150px">Tahun Keluar</td>
                        <td width="5px">:</td>
                        <td><?=$school['s_yo']?></td>
                    </tr>
                <?php } ?> -->

                <tr>
                    <td width="150px">Status</td>
                    <td width="5px">:</td>
                    <td><?=$school['s_is_active']?></td>
                </tr>
                <tr>
                    <td width="150px">Kelengkapan Data</td>
                    <td width="5px">:</td>
                    <td>
                        <?php if ($school['s_status'] == "Lengkap") { ?>
                            <span class="btn btn-success btn-sm">Lengkap</span>
                        <?php } else if ($school['s_status'] == "Kurang") { ?>
                            <span class="btn btn-warning btn-sm kurang">Kurang</span>
                        <?php } else { ?>
                            <span class="btn btn-danger btn-sm belum">Belum Ada Data</span>
                        <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-2">
        <a class="btn btn-success pull-right mb hp" href="<?=site_url()?>"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Kembali</a>
        <a class="btn btn-info pull-right mb hp" href="#" onclick="window.print()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</a>
    </div>
</div>
<div class="tc">
    <h3><?=$attachment?></h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="14.285%">Surat Pengantar</th>
                <th width="14.285%">Surat Pernyataan</th>
                <th width="14.285%">Usulan Rekap</th>
                <th width="14.285%">Profil Sekolah</th>
                <th width="14.285%">Peserta Didik</th>
                <th width="14.285%">Rombongan Belajar</th>
                <th width="14.285%">Sarana & Prasarana</th>
                <th width="14.285%">Daftar Pendidik</th>
                <th width="14.285%">Jadwal Pembelajaran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=(!empty($school['s_sp'])) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : "&minus;";?></td>
                <td><?=(!empty($school['s_spn'])) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : "&minus;";?></td>
                <td><?=(!empty($school['s_li'])) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : "&minus;";?></td>
                <td><?=(!empty($school['s_ps'])) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : "&minus;";?></td>
                <td><?=(!empty($school['s_pd'])) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : "&minus;";?></td>
                <td><?=(!empty($school['s_rb'])) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : "&minus;";?></td>
                <td><?=(!empty($school['s_spr'])) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : "&minus;";?></td>
                <td><?=(!empty($school['s_dp'])) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : "&minus;";?></td>
                <td><?=(!empty($school['s_jp'])) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : "&minus;";?></td>
            </tr>
            <tr class="hp">
                <td>
                    <?php if (!empty($school['s_sp'])) { ?>
                        <a class="btn btn-default btn-xs hp" href="<?=site_url('uploads/Surat_Pengantar/'.$school['s_sp'])?>" target="_blank">Lihat</a>
                    <?php } ?>
                </td>
                <td>
                    <?php if (!empty($school['s_spn'])) { ?>
                        <a class="btn btn-default btn-xs hp" href="<?=site_url('uploads/Surat_Pernyataan/'.$school['s_spn'])?>" target="_blank">Lihat</a>
                    <?php } ?>
                </td>
                <td>
                    <?php if (!empty($school['s_li'])) { ?>
                        <a class="btn btn-default btn-xs hp" href="<?=site_url('uploads/Usulan_Rekap/'.$school['s_li'])?>" target="_blank">Lihat</a>
                    <?php } ?>
                </td>
                <td>
                    <?php if (!empty($school['s_ps'])) { ?>
                        <a class="btn btn-default btn-xs hp" href="<?=site_url('uploads/Profil_Sekolah/'.$school['s_ps'])?>" target="_blank">Lihat</a>
                    <?php } ?>
                </td>
                <td>
                    <?php if (!empty($school['s_pd'])) { ?>
                        <a class="btn btn-default btn-xs hp" href="<?=site_url('uploads/Peserta_Didik/'.$school['s_pd'])?>" target="_blank">Lihat</a>
                    <?php } ?>
                </td>
                <td>
                    <?php if (!empty($school['s_rb'])) { ?>
                        <a class="btn btn-default btn-xs hp" href="<?=site_url('uploads/Rombongan_Belajar/'.$school['s_rb'])?>" target="_blank">Lihat</a>
                    <?php } ?>
                </td>
                <td>
                    <?php if (!empty($school['s_spr'])) { ?>
                        <a class="btn btn-default btn-xs hp" href="<?=site_url('uploads/Sarana&Prasarana/'.$school['s_spr'])?>" target="_blank">Lihat</a>
                    <?php } ?>
                </td>
                 <td>
                    <?php if (!empty($school['s_dp'])) { ?>
                        <a class="btn btn-default btn-xs hp" href="<?=site_url('uploads/Daftar_Pendidik/'.$school['s_dp'])?>" target="_blank">Lihat</a>
                    <?php } ?>
                </td>
                 <td>
                    <?php if (!empty($school['s_jp'])) { ?>
                        <a class="btn btn-default btn-xs hp" href="<?=site_url('uploads/Jadwal_Pembelajaran/'.$school['s_jp'])?>" target="_blank">Lihat</a>
                    <?php } ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
