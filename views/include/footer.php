<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<footer class="footer">
    <div class="container">
        <p>&copy; <a href="www.instagram.com/datascience.id/" target="_blank">Sungram</a> &minus; <a href="www.instagram.com/datascience.id/" target="_blank" title="0000"></a></p>
    </div>
</footer>
<script src="<?=base_url('assets/js/jquery.min.js?ver=3.2.0')?>"></script>
<script src="<?=base_url('assets/js/bootstrap.min.js?ver=3.3.7')?>"></script>
<script src="<?=base_url('assets/js/jquery.dataTables.min.js?ver=1.10.13')?>"></script>
<script src="<?=base_url('assets/js/dataTables.bootstrap.min.js?ver=1.10.13')?>"></script>

<script type="text/javascript">
    $(document).ready(function() {

        // Notification alert
        $("#notif").delay(350).slideDown('slow');
        $("#notif").alert().delay(3000).slideUp('slow');

        // Live search
        $("#search").keyup(function() {
            var str =  $("#search").val();
            if (str == "") {
                $("#hint" ).html("<p class='help-block'>Masukkan NPSN / nama / dan hasil akan otomatis ditampilkan disini.<br></p>");
            } else {
                $.get("<?=site_url()?>home/result?keyword="+str, function(data) {
                    $("#hint").html(data);
                });
            }
        });

        // Report
        $("#tampilkan").click(function() {
            var action = $("#report").attr('action');
            var report = {
                s_instansi: $("#s_instansi").val(),
                m_id: $("#m_id").val(),
                s_status: $("#s_status").val()
            };

            $.ajax({
                type: "GET",
                url: action,
                data: report,
                beforeSend: function() {
                    $('#tampil').html('Sedang memuat.....');
                    $('.btn').addClass('disabled');
                },
                success: function(result) {
                    $("#result").html(result);
                    $('#tampil').html('Tampilkan');
                    $('.btn').removeClass('disabled');
                }
            });
            return false;
        });

        // Is data complete
        $('select#s_status').change(function() {
            if ($(this).val() != '') {
                $('.hint').hide('slow');
                $('#submit').removeClass('hide');
            } else {
                $('.hint').show('slow');
                $('#submit').addClass('hide');
            }
        });

        // Show hide password
        $('#pass').on('click', function() {
            if ($('#password').attr('pass-shown') == 'false') {
                $('#password').removeAttr('type');
                $('#password').attr('type', 'text');
                $('#password').removeAttr('pass-shown');
                $('#password').attr('pass-shown', 'true');
                $('#pass').html('<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>');
            } else {
                $('#password').removeAttr('type');
                $('#password').attr('type', 'password');
                $('#password').removeAttr('pass-shown');
                $('#password').attr('pass-shown', 'false');
                $('#pass').html('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>');
            }
        });

        // Ajax login
        $("#btn-login").click(function() {
            var formAction = $("#login").attr('action');
            var datalogin = {
                u_name: $("#username").val(),
                u_pass: $("#password").val(),
                csrf_token: $.cookie('csrf_cookie')
            };

            $.ajax({
                type: "POST",
                url: formAction,
                data: datalogin,
                beforeSend: function() {
                    $('#status').html('Sedang memproses.....');
                    $('.btn-block').addClass('disabled');
                },
                success: function(data) {
                    if (data == 1) {
                        $("#success").slideDown('slow');
                        $("#success").alert().delay(6000).slideUp('slow');
                        setTimeout(function() {
                            window.location = '<?=site_url('dashboard')?>';
                        }, 2000);
                    } else {
                        $('#status').html('Login');
                        $('.btn-block').removeClass('disabled');
                        $("#failed").slideDown('slow');
                        $("#failed").alert().delay(3000).slideUp('slow');
                        return false;
                    }
                }
            });
            return false;
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings)
        {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        // View data school
        var school = $('#school').DataTable({
            "processing": true,
            "language": {
                "processing": "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span> Sedang memuat....."
            },
            "serverSide": true,
            "ajax": "<?=site_url('school/get_data')?>",
            "columns": [
                {
                    "data": null,
                    "orderable": true
                },
                {"data": "s_npsn"},
                {"data": "s_name"},
                {"data": "s_dob"},
                {"data": "s_statussekolah"},
                {"data": "s_instansi"},
                {"data": "m_id"},
                {"data": "s_status"},
                {"data": "tindakan"}
            ],
            "order": [[1, 'asc']],
            "rowCallback": function (row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

        // View data major
        var major = $('#major').DataTable({
            "processing": true,
            "language": {
                "processing": "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span> Sedang memuat....."
            },
            "serverSide": true,
            "ajax": "<?=site_url('major/get_data')?>",
            "columns": [
                {
                    "data": null,
                    "orderable": true
                },
                {"data": "m_name"},
                {"data": "m_id"},
                {"data": "m_created_at"},
                {"data": "m_updated_at"},
                {"data": "tindakan"}
            ],
            "order": [[1, 'asc']],
            "rowCallback": function (row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

        // View data user
        var user = $('#user').DataTable({
            "processing": true,
            "language": {
                "processing": "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span> Sedang memuat....."
            },
            "serverSide": true,
            "ajax": "<?=site_url('user/get_data')?>",
            "columns": [
                {
                    "data": null,
                    "orderable": true
                },
                {"data": "u_name"},
                {"data": "u_fname"},
                {"data": "u_level"},
                {"data": "u_is_active"},
                {"data": "u_last_logged_in"},
                {"data": "tindakan"}
            ],
            "order": [[1, 'asc']],
            "rowCallback": function (row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

        // View data school_deleted
        var school_deleted = $('#school-deleted').DataTable({
            "processing": true,
            "language": {
                "processing": "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span> Sedang memuat....."
            },
            "serverSide": true,
            "ajax": "<?=site_url('school/get_deleted')?>",
            "columns": [
                {
                    "data": null,
                    "orderable": true
                },
                {"data": "s_npsn"},
                {"data": "s_name"},
                {"data": "s_dob"},
                {"data": "s_statussekolah"},
                {"data": "s_instansi"},
                {"data": "m_id"},
                {"data": "s_deleted_at"},
                {"data": "tindakan"}
            ],
            "order": [[1, 'asc']],
            "rowCallback": function (row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

        // View data school_archived
        var school_archived = $('#school-archived').DataTable({
            "processing": true,
            "language": {
                "processing": "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span> Sedang memuat....."
            },
            "serverSide": true,
            "ajax": "<?=site_url('school/get_archived')?>",
            "columns": [
                {
                    "data": null,
                    "orderable": true
                },
                {"data": "s_npsn"},
                {"data": "s_name"},
                {"data": "s_statussekolah"},
                {"data": "s_instansi"},
                {"data": "m_id"},
                //{"data": "s_yi"},
                //{"data": "s_yo"},
                {"data": "s_is_active"},
                {"data": "tindakan"}
            ],
            "order": [[1, 'asc']],
            "rowCallback": function (row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

        // View data major_deleted
        var major_deleted = $('#major-deleted').DataTable({
            "processing": true,
            "language": {
                "processing": "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span> Sedang memuat....."
            },
            "serverSide": true,
            "ajax": "<?=site_url('major/get_deleted')?>",
            "columns": [
                {
                    "data": null,
                    "orderable": true
                },
                {"data": "m_name"},
                {"data": "m_id"},
                {"data": "m_created_at"},
                {"data": "m_deleted_at"},
                {"data": "tindakan"}
            ],
            "order": [[1, 'asc']],
            "rowCallback": function (row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
    });
</script>
