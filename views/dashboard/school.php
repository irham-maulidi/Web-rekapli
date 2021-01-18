<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h2>Data Sekolah <a class="btn btn-success btn-sm add" href="<?=site_url('school/add')?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Data</a></h2>
<div class="table-responsive">
    <table id="school" class="display table table-bordered table-hover table-responsive">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NPSN</th>
                <th width="25%">Nama</th>
                <th width="10%">SK Izin Operasional</th>
                <th width="10%">Status Sekolah</th>
                <th width="5%">Instansi</th>
                <th width="10%">Kecamatan</th>
                <th width="10%">Kelengkapan Data</th>
                <th width="10%">Tindakan</th>
            </tr>
        </thead>
    </table>
    <script>
        function confirmDialog() {
            return confirm("Apakah Anda yakin akan menghapus data ini?")
        }

        function confirmDialogStatus() {
            <?php if ($this->session->userdata['u_level'] == "Administrator") { ?>
                return confirm("Apakah Anda yakin datanya udah benar?")
            <?php } else { ?>
                window.alert("Hanya Administrator yang boleh mengubah status data!")
            <?php } ?>
        }
    </script>
</div>
