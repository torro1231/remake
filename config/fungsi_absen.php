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



            $('#timepicker1').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false
            });

            $('#timepicker2').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false
            });


        });

        $(function() {
            $(".search_keyword").keyup(function() {
                var search_keyword_value = $(this).val();
                var dataString = 'search_keyword=' + search_keyword_value;
                if (search_keyword_value != '') {
                    $.ajax({
                        type: "POST",
                        url: "searchnip.php",
                        data: dataString,
                        cache: false,
                        success: function(html) {
                            $("#result").html(html).show();

                        }
                    });
                }
                return false;
            });

            $("#result").live("click", function(e) {
                var $clicked = $(e.target);
                var $nip = $clicked.find('.nip').html();
                var decoded = $("<span/>").html($nip).text();
                $('#search_keyword_id').val(decoded);

                var $nama = $clicked.find('.nama').html();
                var decoded = $("<span/>").html($nama).text();
                $('#search_keyword_name').val(decoded);

                var $penempatan = $clicked.find('.penempatan').html();
                var decoded = $("<span/>").html($penempatan).text();
                $('#search_keyword_penempatan').val(decoded);

            });

            $(document).live("click", function(e) {
                var $clicked = $(e.target);
                if (!$clicked.hasClass("search_keyword")) {
                    $("#result").fadeOut();
                }
            });

            $('#search_keyword_id').click(function() {
                $("#result").fadeIn();
            });


        });

    });
</script>

<script>
    $(document).ready(function() {
        // Fungsi untuk memperbarui dropdown shift
        function getKlien(penempatan) {
            $.ajax({
                type: "POST",
                url: "searchPenempatan.php", // Ganti dengan URL yang benar
                data: {
                    penempatan: penempatan
                },
                success: function(data) {
                    $("#shift-dropdown").html(data);
                }
            });
        }

        // Event saat penempatan diperbarui
        $("#search_keyword_penempatan").live('click', function() {
            var penempatanValue = $(this).val();
            if (penempatanValue) {
                getKlien(penempatanValue);
            } else {
                $("#shift-dropdown").html('<option>-- Pilih Shift --</option>');
            }
        });
    });
</script>