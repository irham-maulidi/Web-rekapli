<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h2>Data Sekolah Terhapus</h2>
<div class="table-responsive">
    <table id="school-deleted" class="display table table-bordered table-hover table-responsive">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">NPSN</th>
                <th width="25%">Nama</th>
                <th width="9%">Sk Izin Operasional</th>
                <th width="9%">Status Sekolah</th>
                <th width="9%">Instansi</th>
                <th width="9%">Kecamatan</th>
                <th width="15%">Dihapus Pada</th>
                <th width="9%">Tindakan</th>
            </tr>
        </thead>
    </table>
    <script>
        function confirmDialog() {
            return confirm("Apakah Anda yakin akan menghapus data ini?")
        }
    </script>
</div>
