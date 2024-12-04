<script type="text/javascript">
    $(document).ready(function(e) {


        $(function() {
            $('.date-picker').datepicker({
                    autoclose: true,
                    todayHighlight: true
                })
                //show datepicker when clicking on the icon
                .next().on(ace.click_event, function() {
                    $(this).prev().focus();
                });



            $("#file").change(function() {
                $("#message").empty(); // To remove the previous error message
                var file = this.files[0];
                var imagefile = file.type;
                var match = ["image/jpeg", "image/png", "image/jpg"];
                if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                    $('#previewing').attr('src', 'logo/noname.jpg');
                    $("#message").html("<p id='error'>Mohon Pilih File dengan benar</p>" + "<h4>Catatan</h4>" + "<span id='error_message'>Hanya gambar jpeg, jpg dan png yang di ijinkan</span>");
                    return false;
                } else {
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });

        function imageIsLoaded(e) {
            $("#file").css("color", "#FFFFFF");
            $('#image_preview').css("display", "block");
            $('#previewing').attr('src', e.target.result);
            $('#previewing').attr('width', '250px');
            $('#previewing').attr('height', '230px');
        };

        var htmlobjek;
        $(document).ready(function() {
            // Ketika nilai pada dropdown provinsi berubah
            $('#propinsi').change(function() {
                var idProvinsi = $(this).val(); // Mendapatkan nilai id provinsi yang dipilih

                // AJAX request ke file PHP untuk mendapatkan kota berdasarkan idProvinsi
                $.ajax({
                    url: 'pegawai/ambilkota.php',
                    type: 'GET',
                    data: {
                        propinsi: idProvinsi
                    },
                    success: function(response) {
                        // Mengisi dropdown kota dengan response yang diterima
                        $('#kota').html(response);

                        // Kosongkan dan disable dropdown kecamatan karena kota baru saja berubah
                        $('#kecamatan').html('<option>--Pilih Kecamatan--</option>').prop('disabled', true);
                    }
                });
            });

            // Ketika nilai pada dropdown kota berubah
            $('#kota').change(function() {
                var idKota = $(this).val(); // Mendapatkan nilai id kota yang dipilih

                // AJAX request ke file PHP untuk mendapatkan kecamatan berdasarkan idKota
                $.ajax({
                    url: 'pegawai/ambilkecamatan.php', // Pastikan Anda memiliki file ini untuk memproses request kecamatan
                    type: 'GET',
                    data: {
                        kota: idKota
                    },
                    success: function(response) {
                        // Mengisi dropdown kecamatan dengan response yang diterima
                        $('#kecamatan').html(response).prop('disabled', false); // Enable dropdown kecamatan
                    }
                });
            });


            $("#tgl_habis").change(function() {
                var tglmasuk = $('#tgl_masuk').val();
                var tglkeluar = $('#tgl_habis').val();
                if (tglmasuk >= tglkeluar) {
                    alert('Maaf Tanggal keluar tidak boleh lebih kecil dari tanggal masuk');
                }

            });


            $('#tgl_lahir').change(function() {
                var dob = new Date(this.value);
                var today = new Date();
                var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));


                if (age < 15) {
                    alert('Maaf Umur tidak boleh dibawah 15 tahun');
                } else {
                    $('#umur').val(age);
                };

            });







        });






    });
</script>