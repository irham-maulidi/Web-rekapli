<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h2>Arsip Data Sekolah</h2>
<p>Data sekolah yang sudah mengumpulkan.</p>
<div class="table-responsive">
    <table id="school-archived" class="display table table-bordered table-hover table-responsive">
        <thead>
            <tr>
               <th width="5%">No</th>
                <th width="15%">NPSN</th>
                <th width="25%">Nama</th>  
                <th width="10%">Status Sekolah</th>
                <th width="5%">Instansi</th>
                <th width="10%">Kecamatan</th>
               <!--<th width="7%">Tahun Masuk</th>
                <th width="7%">Tahun Keluar</th> -->
                <th width="7%">Status</th>
                <th width="32%">Tindakan</th>
            </tr>
        </thead>
    </table>
    <script>
        function confirmDialog() {
            return confirm("Apakah Anda yakin mengembalikan Data?")
        }
    </script>
</div>
