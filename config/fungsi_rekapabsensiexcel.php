<script type="text/javascript">
    jQuery(function($) {



        $('#idnama').removeAttr('checked').on('click', function() {
            $('#default-buttons .btn').toggleClass('no-border');
        });


        $('#penempatan').removeAttr('checked').on('click', function() {
            $('#default-buttons .btn').toggleClass('no-border');
        });

        $('#periode').removeAttr('checked').on('click', function() {
            $('#default-buttons .btn').toggleClass('no-border');
        });


        $("#btn_loading").click(function() {
            var vsubmit = $('input[name=submit]').val();
            var vidnama = $('input[name=idnama]:checked').val();
            var vperiode = $('input[name=periode]:checked').val();
            var vpenempatan = $('input[name=penempatan]:checked').val();
            var vawal = $('input[name=awal]').val();
            var vakhir = $('input[name=akhir]').val();

            $.post("hasil.php", {
                    submit: vsubmit,
                    idnama: vidnama,
                    name: vname,
                    penempatan: vpenempatan,
                    periode: vperiode,
                    awal: vawal,
                    akhir: vakhir
                },
                function(response, status) {
                    $("#hasilabsensi").html(response);

                });

        });

    });
</script>