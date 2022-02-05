<?php include_once "fonk/yonfok.php"; $yokclas = new yonetim();
$yokclas->cookcon($vt,false);

?>
<!DOCTYPE html>
<html>
<head>
    <script src="../dosya/jqu.js"></script>
    <link rel="stylesheet" href="../dosya/boost.css">
    <title>Restaurant Kontrol Sistemi</title>

    <script>
        function cikart() {
            window.print();
            window.close();
        }
    </script>

</head>
<body onload="window.print()">

<div class="container-fluid bg-light">
    <div class="row row-fluid">

<?php

    @$islem=$_GET['islem'];

    switch ($islem) {

        case "ciktial":

                                @$tarih1=$_GET['tar1'];
                                @$tarih2=$_GET['tar2'];
                                $veri = $yokclas->ciktiicinSorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
                                $veri2 = $yokclas->ciktiicinSorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'"); ?>

                                 <table class="table text-center table-light table-bordered mt-4 mx-auto col-md-8" style="margin-bottom: 0.2rem;">
                            <thead>
                                <tr>
                                    <th colspan="7">
                                        <div class="alert alert-info text-center mx-auto mt-4">
                                        Tarih Seçimi : <?php echo $tarih1 ?>  - <?php echo $tarih2 ?>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                        <tbody>
                            <tr>
                                <th colspan="4">
                                    <table class="table text-center table-bordered col-md-12 table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="4" class="table-dark">Masa adet ve hasılat</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr class="table-info">
                                                <th colspan="2">Ad</th>
                                                <th colspan="1">Adet</th>
                                                <th colspan="1">Hasılat</th>
                                            </tr>
                                        </thead> <tbody>
                                        <?php
                                        $kilit = $yokclas->ciktiicinSorgu($vt,"select * from gecicimasa");
                                            if($kilit ->num_rows == 0)
                                            {
                                                while($gel = $veri->fetch_assoc())
                                                {
                                                    //masa adını çekiyoruz
                                                    $id = $gel["masaid"];
                                                    $masaveri = $yokclas->ciktiicinSorgu($vt, "select * from masalar where id=$id")->fetch_assoc();
                                                    $masaad=$masaveri["ad"];
                                                    //masa adını çekiyoruz

                                                    $raporbak = $yokclas->ciktiicinSorgu($vt, "select * from gecicimasa where masaid = $id");
                                                    if($raporbak->num_rows == 0)
                                                    {
                                                        //ekleme
                                                        $has = $gel["adet"] * $gel["urunfiyat"];
                                                        $adet = $gel["adet"];
                                                        $yokclas->ciktiicinSorgu($vt,"insert into gecicimasa (masaid,masaad,hasilat,adet) values ($id,'$masaad',$has,$adet)");
                                                    }
                                                    else
                                                    {
                                                        //güncelleme
                                                        $raporson = $raporbak->fetch_assoc();
                                                        $gelenadet= $raporson["adet"];
                                                        $gelenhas = $raporson["hasilat"];

                                                        $sonhasilat = $gelenhas + ($gel["adet"] * $gel["urunfiyat"]);
                                                        $sonadet = $gelenadet + $gel["adet"];

                                                        $yokclas->ciktiicinSorgu($vt,"update gecicimasa set hasilat = $sonhasilat, adet = $sonadet where masaid =$id");
                                                    }
                                                }
                                            }
                                            $son = $yokclas->ciktiicinSorgu($vt,"select * from gecicimasa order by hasilat desc;");

                                            $toplamadet=0;
                                            $toplamhasilat=0;

                                            while($listele = $son->fetch_assoc()) {?>
                                                    <tr>
                                                        <td colspan="2"><?php echo $listele["masaad"] ?></td>
                                                        <td colspan="1"><?php echo $listele["adet"] ?></td>
                                                        <td colspan="1"><?php echo substr($listele["hasilat"],0,5); ?> TL</td>
                                                    </tr>

                                                    <?php
                                                     $toplamadet += $listele ['adet'];
                                                     $toplamhasilat += $listele['hasilat'];
                                                     ?>
                                        <?php  } ?>
                                                    <tr class="table-info">
                                                        <td colspan="2">TOPLAM</td>
                                                        <td colspan="1"><?php echo $toplamadet ?></td>
                                                        <td colspan="1"><?php echo substr($toplamhasilat,0,5); ?> TL</td>
                                                    </tr>
                                        </tbody></table>
                                </th>

                                <th scope="col" colspan="4">
                                    <table class="table text-center table-bordered col-md-12 table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="4" class="table-dark">Ürün adet ve hasılat</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr class="table-info">
                                                <th colspan="2">Ad</th>
                                                <th colspan="1">Adet</th>
                                                <th colspan="1">Hasılat</th>
                                            </tr>
                                        </thead><tbody>
                                        <?php
                                        $kilit2 = $yokclas->ciktiicinSorgu($vt,"select * from geciciurun");
                                            if($kilit2 ->num_rows == 0)
                                            {
                                                while($gel2 = $veri2->fetch_assoc())
                                                {
                                                    $id = $gel2["urunid"];
                                                    $urunad = $gel2["urunad"];

                                                    $raporbak = $yokclas->ciktiicinSorgu($vt, "select * from geciciurun where urunid=$id");
                                                    if($raporbak->num_rows == 0)
                                                    {
                                                        //ekleme
                                                        $has = $gel2["adet"] * $gel2["urunfiyat"];
                                                        $adet = $gel2["adet"];
                                                        $yokclas->ciktiicinSorgu($vt,"insert into geciciurun (urunid,urunad,hasilat,adet) values ($id,'$urunad',$has,$adet)");
                                                    }
                                                    else
                                                    {
                                                        //güncelleme
                                                        $raporson = $raporbak->fetch_assoc();
                                                        $gelenadet= $raporson["adet"];
                                                        $gelenhas = $raporson["hasilat"];

                                                        $sonhasilat = $gelenhas + ($gel2["adet"] * $gel2["urunfiyat"]);
                                                        $sonadet = $gelenadet + $gel2["adet"];

                                                        $yokclas->ciktiicinSorgu($vt,"update geciciurun set hasilat = $sonhasilat, adet = $sonadet where urunid =$id");
                                                    }
                                                }
                                            }
                                            $son2 = $yokclas->ciktiicinSorgu($vt,"select * from geciciurun order by hasilat desc;");

                                            while($listele2 = $son2->fetch_assoc()) {?>
                                                    <tr>
                                                        <td colspan="2"><?php echo $listele2["urunad"] ?></td>
                                                        <td colspan="1"><?php echo $listele2["adet"] ?></td>
                                                        <td colspan="1"><?php echo substr($listele2["hasilat"],0,5); ?> TL</td>
                                                    </tr>
                                        <?php  } ?>
                                </tbody></table>
                            </th>
                        </tr>
                    </tbody>
               </table>

        <?php
        break;




        case "garsoncikti":

             @$tarih1=$_GET['tar1'];
             @$tarih2=$_GET['tar2'];
             $veri = $yokclas->ciktiicinSorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
             $veri2 = $yokclas->ciktiicinSorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");

             ?>

            <table class="table text-center table-light table-bordered mt-4 mx-auto col-md-8" style="margin-bottom: 0.2rem;">
                <thead>
                <tr>
                    <th colspan="7">
                        <div class="alert alert-info text-center mx-auto mt-4">
                            Tarih Seçimi : <?php echo $tarih1 ?>  - <?php echo $tarih2 ?>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>

                    <th colspan="4">
                        <table class="table text-center table-bordered table-dark text-white col-md-12 table-striped">
                            <thead>
                            <tr>
                                <th colspan="4" class="table-dark">Garson Performans</th>
                            </tr>
                            </thead>
                            <thead>
                            <tr class="table-dark text-dark">
                                <th colspan="2">Garson Ad</th>
                                <th colspan="1">Adet</th>
                            </tr>
                            </thead> <tbody>
                            <?php
                            $kilit = $yokclas->ciktiicinSorgu($vt,"select * from gecicigarson");
                            if($kilit ->num_rows == 0)
                            {
                                while($gel = $veri->fetch_assoc())
                                {
                                    //garson adını çekiyoruz
                                    $garsonid = $gel["garsonid"];
                                    $masaveri = $yokclas->ciktiicinSorgu($vt, "select * from garson where id=$garsonid")->fetch_assoc();
                                    $garsonad=$masaveri["ad"];
                                    //garson adını çekiyoruz

                                    $raporbak = $yokclas->ciktiicinSorgu($vt, "select * from gecicigarson where garsonid = $garsonid");
                                    if($raporbak->num_rows == 0)
                                    {
                                        //ekleme
                                        $adet = $gel["adet"];
                                        $yokclas->ciktiicinSorgu($vt,"insert into gecicigarson (garsonid,garsonad,adet) values ($garsonid,'$garsonad',$adet)");
                                    }
                                    else
                                    {
                                        //güncelleme
                                        $raporson = $raporbak->fetch_assoc();
                                        $gelenadet= $raporson["adet"];

                                        $sonadet = $gelenadet + $gel["adet"];

                                        $yokclas->ciktiicinSorgu($vt,"update gecicigarson set adet = $sonadet where garsonid =$garsonid");
                                    }
                                }
                            }
                            $son = $yokclas->ciktiicinSorgu($vt,"select * from gecicigarson order by adet desc;");

                            $toplamadet=0;


                            while($listele = $son->fetch_assoc()) {?>
                                <tr>
                                    <td colspan="2"><?php echo $listele["garsonad"] ?></td>
                                    <td colspan="2"><?php echo $listele["adet"] ?></td>
                                </tr>

                                <?php
                                $toplamadet += $listele ['adet'];
                                ?>
                            <?php  } ?>
                            <tr class="table-dark text-dark">
                                <td colspan="2">TOPLAM</td>
                                <td colspan="2"><?php echo $toplamadet ?></td>
                            </tr>
                            </tbody></table>
                    </th>
                </tr>
                </tbody>
            </table>

            <?php


        break;







    }
?>


    </div>
</div>

</body>
</html>