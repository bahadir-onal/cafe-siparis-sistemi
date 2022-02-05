<?php
session_start();
include ("fonksiyon/fonksiyon.php");
$masam = new sistem();


$veri=$masam->benimsorum2($db,"select * from garson where durum=1",1)->num_rows;
if ($veri==0) {
    header("Location:index.php");
}

@$masaid=$_GET['masaid'];
?>
<!DOCTYPE html>
<html>
<head>
    <script src="dosya/jqu.js"></script>
    <link rel="stylesheet" href="dosya/boost.css">
    <link rel="stylesheet" href="dosya/stil.css">

    <script>
        $(document).ready(function () {
            var id="<?php echo $masaid; ?>";
            $("#veri").load("islemler.php?islem=goster&id="+id);
            $('#btn').click(function () {
                $.ajax({

                    type: "POST",
                    url: 'islemler.php?islem=ekle',
                    data: $('#formum').serialize(),

                    success: function(donen_veri) {
                        $("#veri").load("islemler.php?islem=goster&id="+id);
                        $('#formum').trigger("reset");
                        $("#cevap").html(donen_veri).slideUp(1400);
                    },
                })
            })
            $('#urunler a').click(function (){
                var sectionId=$(this).attr('sectionId');
                $("#sonuc").load("islemler.php?islem=urun&katid=" + sectionId).fadeIn();
            })
         });
    </script>

    <title>Restaurant Sipariş Sistemi</title>
</head>
<body>

<div class="container-fluid">
    <?php

    if ($masaid!="") {
     $son=$masam->masagetir($db,$masaid);
     $dizi=$son->fetch_assoc();
     ?>

    <div class="row">
        <div class="col-md-3" id="div2">
            <div class="row">
                <div class="col-md-12 border-bottom border-info bg-success text-white mx-auto p-4 text-center" id="div3">
                    <a href="index.php" class="btn btn-warning">Ana Sayfa</a><br><?php echo $dizi['ad'] ?></div>
                <!--ANLIK SİPARİŞLER BURDA-->
                <div class="col-md-12" id="veri"></div>
                <!--ANLIK SİPARİŞLER BURDA-->
                <div id="cevap"></div>
            </div>
         </div>

        <div class="col-md-7" style="background-color: #f9f9f9">
            <div class="row"><form id="formum">
                <div class="col-md-12" id="sonuc" style="min-height: 600px"></div>
            </div>

            <div class="row" id="div4">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="masaid" value="<?php echo $dizi['id']; ?>">
                            <input type="button" id="btn" value="EKLE" class="btn btn-success btn-block mt-4">
                        </div>
                        <div class="col-md-6">
                            <?php
                            for ($i=1; $i<=13; $i++) {
                                echo '<label class="btn btn-success m-2"><input name="urunadet" type="radio" value="'.$i.'">'.$i.'</label>';
                            }
                            ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

           <!--     <form id="formum">
                <input type="text" name="urunid">
                <input type="text" name="urunadet">
                <input type="hidden" name="masaid" value="">
                <input type="button" id="btn" value="EKLE">
             -->
        </div>

        <!--KATEGORİLER-->
        <div class="col-md-2" id="urunler">
            <?php $masam->urungrup($db); ?>
        </div>
        <!--KATEGORİLER-->
    </div>
</div>
<?php } else {
        echo "Hata Var";
} ?>

</body>
</html>