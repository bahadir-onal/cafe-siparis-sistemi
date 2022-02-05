<?php
include ("fonksiyon/fonksiyon.php");
$sistem = new sistem();
$veri=$sistem->benimsorum2($db,"select * from garson where durum=1",1)->num_rows;
?>
<!DOCTYPE html>
<html>
<head>
    <script src="dosya/jqu.js"></script>
    <link rel="stylesheet" href="dosya/boost.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <title>Restaurant Sipariş Sistemi</title>

    <style>
        #rows {
            height: 32px;
        }

        #masa{
            height: 80px;
            margin: 12px;
            font-size: 30px;
            border-radius: 10px;
        }

        #mas a:link, #mas a:visited {
            text-decoration: none;
        }
    </style>

    <script>
        $(document).ready(function (){

            var deger = "<?php echo $veri ?>";

            if (deger==0) {

                $('#girismodal').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $('body').on('hidden.bs.modal','.modal',function () {

                    $(this).removeData('bs.modal');

                });

            } else {

                $('#girismodal').modal('hide');
            }

            $('#girisbak').click(function () {
                $.ajax({
                    type: "POST",
                    url: 'islemler.php?islem=kontrol',
                    data: $('#garsonform').serialize(),
                    success: function(donen_veri){
                        $('#garsonform').trigger("reset");

                        $('.modalcevap').html(donen_veri);

                    },
                })
            })

        });

    </script>

</head>
<body>

<div class="container-fluid">

    <div class="row table-dark" id="rows">
        <div class="col-md-2 border-right">Toplam Sipariş : <a class="text-warning"><?php $sistem->siparistoplam($db); ?></a></div>
        <div class="col-md-2 border-right">Doluluk Oranı : <a class="text-warning"><?php $sistem->doluluk($db); ?></a></div>
        <div class="col-md-3 border-right">Toplam Masa : <a class="text-warning"><?php $sistem->masatoplam($db); ?></a></div>
        <div class="col-md-3 border-right">Aktif Garson : <a class="text-warning"><?php $sistem->garsonbak($db); ?></a></div>
        <div class="col-md-2 border-right">Tarih : <a class="text-warning"><?php echo date("d.m.y"); ?></a></div>
    </div>

    <div class="row">
        <?php $sistem->masacek($db); ?>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="girismodal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h4 class="modal-title">Garson Girişi</h4>

                </div>

                <!-- Modal body -->
                        <div class="modal-body">
                            <form id="garsonform">
                                <div class="row mx-auto text-center">
                                    <div class="col-md-12">Garson Ad</div>
                                    <div class="col-md-12">
                                    <select name="ad" class="form-control mt-2">
                                     <option value="0">Seç</option>
                                        <?php

                                        $b=$sistem->benimsorum2($db,"select * from garson",1);

                                        while ($garsonlar=$b->fetch_assoc()) { ?>

                                            <option value="<?php echo $garsonlar['ad'] ?>"><?php echo $garsonlar['ad'] ?></option>

                                     <?php }

                                        ?>
                                     </select></div>

                                    <div class="col-md-12">Şifre </div>
                                    <div class="col-md-12">
                                        <input name="sifre" type="password" class="form-control  mt-2" />
                                    </div>

                                    <div class="col-md-12">
                                        <input type="button" id="girisbak" value="GİR" class="btn btn-info mt-4"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                   <div class="modalcevap">
                </div>
            </div>
        </div>
    </div>



</div>



</body>
</html>