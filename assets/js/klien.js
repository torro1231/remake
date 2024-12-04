(function($) {
    $(document).ready(function(e) {
        var id_klien = 0;
        var main = "ref/klien.data.php";

        $("#data-klien").load(main);

        $('input:text[name=pencarian]').on('input', function(e) {
            var v_cari = $('input:text[name=pencarian]').val();

            if (v_cari != "") {
                $.post(main, {
                    cari: v_cari
                }, function(data) {
                    $("#data-klien").html(data).show();
                });
            } else {
                $("#data-klien").load(main);
            }
        });

        $(document).on("click", '.ubah,.tambah', function() {
            var url = "ref/klien.form.php";
            id_klien = this.id;
            if (id_klien != 0) {
                $("#myModalLabel").html("Ubah Data klien");
            } else {
                $("#myModalLabel").html("Tambah Data klien");
            }
            $.post(url, {
                id: id_klien
            }, function(data) {
                $(".modal-body").html(data).show();
            });
        });

        $(document).on("click", '.hapus', function() {
            var url = "ref/klien.input.php";
            id_klien = this.id;
            var answer = confirm("Apakah anda ingin menghapus data ini?");
            if (answer) {
                $.post(url, {
                    hapus1: id_klien
                }, function() {
                    $("#data-klien").load(main);
                });
            }
        });

        $(document).on("click", '.halaman', function(event) {
            kd_hal = this.id;
            $.post(main, {
                halaman: kd_hal
            }, function(data) {
                $("#data-klien").html(data).show();
            });
        });

        $(document).on("click", "#simpan-klien", function(event) {
            var url = "ref/klien.input.php";
            var vid_klien = $('input:text[name=id_klien]').val();
            var vn_klien = $('input:text[name=n_klien]').val();
            var vn_cabang = $('input:text[name=n_cabang]').val();
            var vkoor_klien = $('input:text[name=koor_klien]').val();
            var vradius_absen = $('input:text[name=radius_absen]').val();
            var vkd_klien = $('input:text[name=kd_klien]').val();
            var id_klien = vid_klien; // Asumsi id_klien diambil dari input id_klien

            $.post(url, {
                id_klien: vid_klien,
                n_klien: vn_klien,
                n_cabang: vn_cabang,
                koor_klien: vkoor_klien,
                radius_absen: vradius_absen,
                kd_klien: vkd_klien,
                id: id_klien
            }, function() {
                $("#data-klien").load(main);
                alert("Berhasil");
                $('#dialog-klien').modal('hide');
                $("#myModalLabel").html("Tambah Data klien");
            });
        });
    });
})(jQuery);
