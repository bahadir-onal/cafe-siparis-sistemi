<?php
session_start();
include ("fonksiyon/fonksiyon.php");
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
                    window.location.reload();
                    },
                })
            })

            $('#yakala a').click(function () {
            var sectionId = $(this).attr('sectionId');
            $.post("islemler.php?islem=sil",{"urunid":sectionId,"masaid":sectionId2},function(post_veri) {
                window.location.reload();
            })
            })

        });

        var popupWindow=null;

        function ortasayfa(url,winName,w,h,scroll) {
            LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
            TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
            settings='height='+h+', width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
            popupWindow=window.open(url,winName,settings)
        }




    </script>
    <title>Restaurant Sipariş Sistemi</title>
</head>
<body>

<?php

function benimsorum2($vt,$sorgu,$tercih){

    $a = $sorgu;
    $b=$vt->prepare($a);
    $b->execute();
    if ($tercih==1) {
        return $c=$b->get_result();
    }
}

function uyari($mesaj,$renk) { ?>

        <div class="alert alert-<?php echo $renk ?> mt-4 text-center"><?php echo $mesaj ?></div>

    <?php
}


@$islem=$_GET['islem'];

switch ($islem){

    case "hesap":
                                if (!$_POST) {
                                    echo "POST'tan Gelmiyorsun";
                                } else {

                                $masaid=htmlspecialchars($_POST['masaid']);
                                $sorgu="select * from anliksiparis where masaid=$masaid";
                                $verilericek=benimsorum2($db,$sorgu,1);

                                while ($don=$verilericek->fetch_assoc()){

                                $a=$don['masaid'];
                                $b=$don['urunid'];
                                $c=$don['urunad'];
                                $d=$don['urunfiyat'];
                                $e=$don['adet'];
                                $garsonid=$don['garsonid'];
                                $bugun=date("Y-m-d");

                                $raporekle="insert into rapor(masaid,garsonid,urunid,urunad,urunfiyat,adet,tarih) VALUES ($a,$garsonid,$b,'$c',$d,$e,'$bugun')";
                                $raporekle=$db->prepare($raporekle);
                                $raporekle->execute();

                                }

                                $sorgu="delete from anliksiparis where masaid=$masaid";
                                $silme=$db->prepare($sorgu);
                                $silme->execute();
                            }
        break; //HESAP ALMA İŞLEMİ YAPILDI

    case "sil":
                            if (!$_POST) {

                                 echo "POST'dan gelmiyorsun";

                            } else {

                                $gelenid=htmlspecialchars($_POST['urunid']);
                                $sorgu="delete from anliksiparis where urunid=$gelenid";
                                $silme=$db->prepare($sorgu);
                                $silme->execute();
                                echo "Silme İşlemi Başarılı";

                            }
        break; //ÜRÜN SİLME İŞLEMİ YAPIDI

    case "goster":

                            $id=htmlspecialchars($_GET['id']);
                            $a = "select * from anliksiparis where masaid=$id";
                            $d=benimsorum2($db,$a,1);

                            if ($d->num_rows==0) {
                            uyari("Henüz Sipariş Yok","danger");
                            } else { ?>

                           <table class="table table-bordered table-striped text-center">
                              <thead>
                                 <tr class="bg-dark text-white">
                                     <th scope="col">Ürün Adı</th>
                                     <th scope="col">Adet</th>
                                     <th scope="col">Tutar</th>
                                     <th scope="col">İşlem</th>
                                 </tr>
                              </thead>
                           <tbody>

                           <?php
                           $adet=0;
                           $sontutar=0;

                           while ($gelenson=$d->fetch_assoc()){

                           $tutar = $gelenson['adet'] * $gelenson['urunfiyat'];
                           $adet += $gelenson['adet'];
                           $sontutar += $tutar;
                           $masaid=$gelenson['masaid'];

                           ?>

                           <tr>
                             <td><?php echo $gelenson['urunad'] ?></td>
                             <td><?php echo $gelenson['adet'] ?></td>
                             <td><?php echo number_format($tutar,2,'.',',') ?> TL</td>
                             <td id="yakala"><a class="btn btn-danger mt-2 text-white" sectionId="<?php echo $gelenson['urunid'] ?>">Sil</a></td>
                           </tr>

                           <?php } ?>

                           <tr class="bg-dark text-white text-center">
                              <td class="font-weight-bold">TOPLAM</td>
                              <td class="font-weight-bold"><?php echo $adet ?></td>
                              <td colspan="2" class="font-weight-bold text-warning"><?php echo number_format($sontutar,2,'.',',') ?> TL</td>
                           </tr>
                           </tbody></table>

                           <div class="row">
                              <div class="col-md-12">
                                 <form id="hesapform">
                                    <input type="hidden" name="masaid" value="<?php echo $masaid ?>">
                                    <input type="button" id="btnn" value="Hesabı Al" class="btn btn-danger btn-block mt-4">
                                 </form>
                                  <p><a href="fisbastir.php?masaid=<?php echo $masaid ?>" onclick="ortasayfa(this.href,'\mywindow\',\'350\',\'400\',\'yes\');return false" class="btn btn-warning btn-block mt-4">Çıktı Al</a></p>
                              </div>
                           </div>

                           <?php

                           }

    break; //EKLENEN , GÜNCELLENEN ÜRÜNLERİN GÖSTERİLME İŞLEMİ

    case "ekle":

                        if ($_POST) {

                        @$masaid=htmlspecialchars($_POST['masaid']);
                        @$urunid=htmlspecialchars($_POST['urunid']);
                        @$adet=htmlspecialchars($_POST['urunadet']);

                        if ($masaid=="" || $urunid=="" || $adet=="") {

                            uyari("Boş Alan Bırakılamaz","danger");

                        } else {

                        $varmi="select * from anliksiparis where urunid=$urunid and masaid=$masaid";
                        $var=benimsorum2($db,$varmi,1);

                        if ($var->num_rows!=0) {

                                $urundizi=$var->fetch_assoc();
                                $sonadet = $adet + $urundizi['adet'];
                                $islemid = $urundizi['id'];

                                $guncel="UPDATE anliksiparis set adet=$sonadet where id=$islemid";
                                $guncelson=$db->prepare($guncel);
                                $guncelson->execute();

                                uyari("ADET GÜNCELLENDI","success");

                        } else {

                                $a = "select * from urunler where id=$urunid";
                                $d=benimsorum2($db,$a,1);
                                $son=$d->fetch_assoc();

                                $urunad=$son["ad"];
                                $urunfiyat=$son["fiyat"];

                                // GARSON İD ÇEKİYORUZ

                                $gelen=benimsorum2($db,"select * from garson where durum=1",1)->fetch_assoc();
                                $garsonidyaz=$gelen['id'];

                                $ekle="insert into anliksiparis (masaid,garsonid,urunid,urunad,urunfiyat,adet) VALUES ($masaid,$garsonidyaz,$urunid,'$urunad',$urunfiyat,$adet)";
                                $ekleson=$db->prepare($ekle);
                                $ekleson->execute();

                                uyari("EKEME YAPILDI","success");

                                }

                            }

                            } else {

                            uyari("HATA VAR","danger");

                            }

    break; //ÜRÜN EKLEME İŞLEMİ YAPIDI

    case "urun":

                        $katid=htmlspecialchars($_GET['katid']);
                        $a = "select * from urunler where katid=$katid";
                        $d=benimsorum2($db,$a,1);

                        while ($sonuc=$d->fetch_assoc()) { ?>

                            <label class="btn btn-dark m-2">
                                  <input name="urunid" type="radio" value="<?php echo $sonuc['id'] ?>"> <?php echo $sonuc['ad'] ?>
                            </label>

                        <?php  }

     break;

    case "kontrol":

        $ad=htmlspecialchars($_POST['ad']);
        $sifre=htmlspecialchars($_POST['sifre']);

        if (@$ad!="" && @$sifre!="") {

            $var=benimsorum2($db,"select * from garson where ad='$ad' and sifre='$sifre'",1);

            if ($var->num_rows==0) { ?>

                <div class="alert alert-danger text-center">Bilgiler Uyuşmuyor</div>

            <?php  } else {

                $garson=$var->fetch_assoc();
                $garsonid=$garson['id'];
                benimsorum2($db,"update garson set durum=1 where id=$garsonid",1);
                ?>
                <script>
                    window.location.reload();
                </script>
                <?php

            }

        } else { ?>

            <div class="alert alert-danger text-center">Boş Bölüm Bırakma</div>

      <?php  }

    break;

    case "cikis":

        benimsorum2($db,"update garson set durum=0",1);
        header("Location:index.php");

    break;

}

?>
</body>
</html>
