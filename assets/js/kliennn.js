(function($) {
    $(document).ready(function(e) {
        var main = "ref/klien.data.php";
        $("#data-klien").load(main);

        $('input:text[name=pencarian]').on('input', function(e) {
            var v_cari = $(this).val();
            if (v_cari != "") {
                $.post(main, { cari: v_cari }, function(data) {
                    $("#data-klien").html(data).show();
                });
            } else {
                $("#data-klien").load(main);
            }
        });

        $(document).on("click", ".ubah, .tambah", function() {
            var url = "ref/klien.form.php";
            var id_klien = $(this).attr('id');
            var modalLabel = id_klien != 0 ? "Ubah Data Klien" : "Tambah Data Klien";
            $("#myModalLabel").html(modalLabel);

            $.post(url, { id: id_klien }, function(data) {
                $(".modal-body").html(data).show();
            });
        });

        $(document).on("click", ".hapus", function() {
            var url = "ref/klien.input.php";
            var id_klien = $(this).attr('id');
            var answer = confirm("Apakah anda ingin menghapus data ini?");
            if (answer) {
                $.post(url, { hapus1: id_klien }, function() {
                    $("#data-klien").load(main);
                });
            }
        });

        $(document).on("click", ".halaman", function(event) {
            var kd_hal = $(this).attr('id');
            $.post(main, { halaman: kd_hal }, function(data) {
                $("#data-klien").html(data).show();
            });
        });
        
//         $("#simpan-klien").bind("click", function(event) {
// 			var url = "ref/klien.input.php";


// 			var vid_klien = $('input:text[name=id_klien]').val();
//             var vn_klien = $('input:text[name=n_klien]').val();
//             var vn_cabang = $('input:text[name=n_cabang]').val();
//             var vkoor_klien = $('input:text[name=koor_klien]').val();
//             var vradius_absen = $('input:text[name=radius_absen]').val();
//             var vkd_klien = $('input:text[name=kd_klien]').val();
           


// $.post(url, {id_klien: vid_klien, n_klien: vn_klien,n_cabang: vn_cabang,koor_klien: vkoor_klien,radius_absen: vradius_absen, kd_klien: vkd_klien, id: id_klien} ,function() {
			
			
// 				$("#data-klien").load(main);

//                 alert("Berhasil");

// 				$('#dialog-klien').modal('hide');

// 				$("#myModalLabel").html("Tambah Data klien");
// 			});
// 		});

        $("#simpan-klien").on("click", function(event) {
            var url = "ref/klien.input.php";
            var dataForm = {
                id_klien: $('input:text[name=id_klien]').val(),
                n_klien: $('input:text[name=n_klien]').val(),
                n_cabang: $('input:text[name=n_cabang]').val(),
                koor_klien: $('input:text[name=koor_klien]').val(),
                radius_absen: $('input:text[name=radius_absen]').val(),
                kd_klien: $('input:text[name=kd_klien]').val(),
                id: $('input:hidden[name=id_klien]').val() // Asumsi ada input hidden untuk id_klien
            };

            $.post(url, dataForm, function() {
                $("#data-klien").load(main);
                alert("Berhasil");
                $('#dialog-klien').modal('hide');
                $("#myModalLabel").html("Tambah Data Klien");
            });
        });
    });
})(jQuery);
