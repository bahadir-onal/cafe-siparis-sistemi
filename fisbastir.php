<?php
session_start();
include ("fonksiyon/fonksiyon.php");
$masam = new sistem();
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
            $('#btnn').click(function () {
                $.ajax({
                    type: "POST",
                    url: 'islemler.php?islem=hesap',
                    data: $('#hesapform').serialize(),
                    success: function(donen_veri){
                        $('#hesapform').trigger("reset");
                        window.opener.location.reload(true);
                        window.close();
                    },
                })
            })

         });
    </script>

    <title>FİŞ BASTIR</title>
</head>
<body onload="window.print()">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 mx-auto">

            <?php

            if ($masaid!="") {
            $son=$masam->masagetir($db,$masaid);
            $dizi=$son->fetch_assoc();
            $dizi['ad'];

            $id=htmlspecialchars($_GET['masaid']);
            $a = "select * from anliksiparis where masaid=$id";
            $d=$masam->benimsorum2($db,$a,1);

            if ($d->num_rows==0) {
                echo "Henüz Sipariş Yok";
            } else { ?>

                <table class="table">
                    <tr>
                        <td colspan="3" class="border-top-0 text-center"><strong>MASA :</strong><?php echo $dizi['ad'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="border-top-0 text-left"><strong>Tarih :</strong><?php echo date("d.m.Y")?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="border-top-0 text-left"><strong>Saat :</strong><?php echo date("h:i:s")?></td>
                    </tr>
                    <?php

                    $sontutar=0;

                    while ($gelenson=$d->fetch_assoc()){

                        $tutar = $gelenson['adet'] * $gelenson['urunfiyat'];
                        $sontutar += $tutar;
                        $masaid=$gelenson['masaid'];

                        ?>

                        <tr>
                            <td colspan="1" class="border-top-0 text-center"><?php echo $gelenson['urunad'] ?></td>
                            <td colspan="1" class="border-top-0 text-center"><?php echo $gelenson['adet'] ?></td>
                            <td colspan="1" class="border-top-0 text-center"><?php echo number_format($tutar,2,'.',',') ?> TL</td>
                        </tr>

                    <?php } ?>

                    <tr>
                        <td colspan="2" class="border-top-0 font-weight-bold"><strong>GENEL TOPLAM :</strong></td>
                        <td colspan="2" class="border-top-0 text-center"><?php echo number_format($sontutar,2,'.',',') ?> TL</td>
                    </tr>
                    </tbody></table>

                        <form id="hesapform">
                            <input type="hidden" name="masaid" value="<?php echo $id ?>">
                            <input type="button" id="btnn" value="Hesabı Kapat" class="btn btn-danger btn-block mt-4">
                        </form>

                <?php

            }
            ?>

        </div>
    </div>


     <?php

    } else {
        echo "Hata Var";
        header("resfresh:1,url=index.php");
} ?>

</body>
</html>