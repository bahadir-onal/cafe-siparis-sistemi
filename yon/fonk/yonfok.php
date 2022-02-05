<?php

$vt = new mysqli("localhost","root","123456789","siparis") or die("Bağlanamadı");
$vt->set_charset("utf-8");
ob_start();

class yonetim {

    private function uyarı ($tip,$metin,$sayfa) { ?>

        <div class="alert alert-<?php echo $tip ?>"><?php echo $metin ?></div> <?php
        header("refresh:2,url='$sayfa'");

    }

    private function genelsorgu ($dv,$sorgu) {

        $sorgum=$dv->prepare($sorgu);
        $sorgum->execute();
        return $sorguson=$sorgum->get_result();

    }

    function ciktiicinSorgu ($dv,$sorgu) {

        $sorgum=$dv->prepare($sorgu);
        $sorgum->execute();
        return $sorguson=$sorgum->get_result();

    }

    function kulad($db) {

        $sorgu="select * from yonetim";
        $gelensonuc=$this->genelsorgu($db,$sorgu);
        $b=$gelensonuc->fetch_assoc();
        return $b['kulad'];
    }

    function cikis($deger) {
        $deger=md5(sha1(md5($deger)));
        setcookie("kul",$deger,time() - 10);
        $this->uyarı("success","Çıkış Yapılıyor","index.php");

    }


//----------------------------------------
            //MASA YÖNETİM

//----------------------------------------
    //İSTATİSTİKLER BAŞLANGIÇ
    function toplamgarson($vt) {
        echo $this->genelsorgu($vt,"select * from garson")->num_rows;
    }

    function topurunadet($vt) {
        $geldi=$this->genelsorgu($vt,"select SUM(adet) from anliksiparis")->fetch_assoc();
        echo $geldi['SUM(adet)'];
    }

    function toplammasa($vt) {
        echo $geldi=$this->genelsorgu($vt,"select * from masalar")->num_rows;

    }

    function toplamkat($vt) {
        echo $geldi=$this->genelsorgu($vt,"select * from kategori")->num_rows;

    }

    function toplamurun($vt) {
        echo $geldi=$this->genelsorgu($vt,"select * from urunler")->num_rows;

    }

    function doluluk($dv) {

        $veriler=$this->genelsorgu($dv,"select * from doluluk")->fetch_assoc();
        $toplam = $veriler['bos'] + $veriler['dolu'];
        $oran = ($veriler['dolu'] / $toplam) * 100;
        echo $oran=substr($oran,0,5). " %";

    }
    //İSTATİSTİKLER BİTİŞ
//----------------------------------------

            //MASA YÖNETİM
//----------------------------------------
    function masayon($vt) {

        $so=$this->genelsorgu($vt,"select * from masalar"); ?>

        <table class="table text-center table-striped table-bordered mx-auto col-md-7 mt-4">
        <thead>
        <tr>
            <th scope="col"><a href="control.php?islem=masaekle" class="btn btn-success">+</a> Masa Adı</th>
            <th scope="col">Güncelle</th>
            <th scope="col">Sil</th>
        </tr>
        </thead>
        <tbody>

        <?php

        while ($sonuc=$so->fetch_assoc()) { ?>

        <tr>
          <td><?php echo $sonuc['ad'] ?></td>
          <td><a href="control.php?islem=masaguncel&masaid=<?php echo $sonuc['id'] ?>" class="btn btn-warning">Güncelle</a></td>
          <td><a href="control.php?islem=masasil&masaid=<?php echo $sonuc['id'] ?>" class="btn btn-danger" data-confirm="Masayı silmek istediğinizden emin misiniz ?">Sil</a></td>
        </tr>

       <?php } ?>

        </tbody>
        </table>
       <?php


    }

    function masasil($vt) {

        $masaid=$_GET['masaid'];

        if ($masaid!="" && is_numeric($masaid)) {

            $this->genelsorgu($vt,"delete from masalar where id=$masaid");
            $this->uyarı("success","Masa Başarıyla Silindi","control.php?islem=masayon");

        } else {
            $this->uyarı("danger","Hata Oluştu","control.php?islem=masayon");
        }

    }

    function masaguncel($vt) {

        @$buton=$_POST['buton'];

        ?>

        <div class="col-md-3 bg-light text-center mx-auto mt-5 table-bordered">

        <?php


        if ($buton) {

            @$masaad=htmlspecialchars($_POST['masaad']);
            @$masaid=htmlspecialchars($_POST['masaid']);

                    if ($masaad=="" || $masaid=="") {
                        $this->uyarı("danger","Bilgiler Boş Olamaz","control.php?islem=masayon");

                    } else {

                        $this->genelsorgu($vt,"update masalar set ad='$masaad' where id=$masaid");
                        $this->uyarı("success","Masa Güncellendi","control.php?islem=masayon");

                    }

            } else {
                $masaid=$_GET['masaid'];
                $aktar=$this->genelsorgu($vt,"select * from masalar where id=$masaid")->fetch_assoc();

                ?>

                    <form action="" method="post">
                        <div class="col-md-12 bg-warning border-bottom"><h4>MASA GÜNCELLE</h4></div>
                        <div class="col-md-12 bg-light"><input type="text" name="masaad" class="form-control mt-3" value="<?php echo $aktar['ad'] ?>"></div>
                        <div class="col-md-12 bg-light"><input type="submit" name="buton" class="btn btn-success mt-3 mb-3"></div>
                        <input type="hidden" name="masaid" value="<?php echo $aktar['id'] ?>">
                    </form>


                <?php } ?>

       </div>

        <?php }

    function masaekle($vt) {

        @$buton=$_POST['buton'];

        ?>

        <div class="col-md-3 bg-light text-center mx-auto mt-5 table-bordered">

            <?php


            if ($buton) {

                @$masaad=htmlspecialchars($_POST['masaad']);


                if ($masaad=="") {
                    $this->uyarı("danger","Bilgiler Boş Olamaz","control.php?islem=masayon");

                } else {

                    $this->genelsorgu($vt,"insert into masalar (ad) VALUES ('$masaad')");
                    $this->uyarı("success","Masa Eklendi","control.php?islem=masayon");

                }

            } else {


                ?>

                <form action="" method="post">
                    <div class="col-md-12 bg-warning border-bottom"><h4>MASA EKLE</h4></div>
                    <div class="col-md-12 bg-light"><input type="text" name="masaad" class="form-control mt-3" required ></div>
                    <div class="col-md-12 bg-light"><input type="submit" name="buton" class="btn btn-success mt-3 mb-3"></div>
                </form>


            <?php } ?>

        </div>

    <?php }
            //MASA YÖNETİM
//----------------------------------------

//----------------------------------------
            //ÜRÜN YÖNETİM
    function urunyon($vt,$tercih) {

                if ($tercih==1) {

                    @$aramabuton=$_POST['aramabuton'];
                    $urun=$_POST['urun'];

                    if ($aramabuton) {
                        $so=$this->genelsorgu($vt,"select * from urunler where ad LIKE '%$urun%'");
                    }

                }elseif ($tercih==2) {

                    $arama=$_POST['arama'];
                    $katid=$_POST['katid'];

                    if ($arama) {

                        $so=$this->genelsorgu($vt,"select * from urunler where katid=$katid");

                    }

                } elseif ($tercih==0) {

                     $so=$this->genelsorgu($vt,"select * from urunler");

                } ?>
                        <table class="table text-center table-striped table-bordered mx-auto col-md-7 mt-4 table-dark">
                            <thead>
                                <tr>
                                    <th>
                                    <form action="control.php?islem=aramasonuc" method="post">
                                    <input type="search" placeholder="Aranacak Ürün" name="urun" class="form-control"></th>
                                    <th><input type="submit" name="aramabuton" value="ARA" class="btn btn-warning"></form></th>
                                    <th>
                                    <form action="control.php?islem=katgore" method="post">
                                    <select name="katid" class="form-control">

                                    <?php
                                    $d=$this->genelsorgu($vt,"select * from kategori");
                                    while ($katson=$d->fetch_assoc()) { ?>
                                    <option value="<?php echo $katson['id'] ?>"><?php echo $katson['ad'] ?></option>

                                    <?php }

                                    ?>
                                    </select>
                                    </th>
                                    <th><input type="submit" name="arama" value="GETİR" class="btn btn-warning"></form></th>
                                </tr>
                            </thead>
                        </table>

                <table class="table text-center table-striped table-bordered mx-auto col-md-7 mt-4">
                    <thead>
                        <tr>
                            <th scope="col"><a href="control.php?islem=urunekle" class="btn btn-success">+</a> Ürün Adı</th>
                            <th scope="col">Ürün Fiyat</th>
                            <th scope="col">Güncelle</th>
                            <th scope="col">Sil</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php

                    while ($sonuc=$so->fetch_assoc()) { ?>

                        <tr>
                            <td><?php echo $sonuc['ad'] ?></td>
                            <td><?php echo $sonuc['fiyat'] ?></td>
                            <td><a href="control.php?islem=urunguncel&urunid=<?php echo $sonuc['id'] ?>" class="btn btn-warning">Güncelle</a></td>
                            <td><a href="control.php?islem=urunsil&urunid=<?php echo $sonuc['id'] ?>" class="btn btn-danger" data-confirm="Ürünü silmek istediğinizden emin misiniz ?">Sil</a></td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
                <?php
    }

    function urunsil($vt) {

        @$urunid=$_GET['urunid'];

        if ($urunid!="" && is_numeric($urunid)) {

            $satir=$this->genelsorgu($vt,"select * from anliksiparis where urunid=$urunid");

            if ($satir->num_rows!=0) { ?>

                <div class="alert alert-info mt-5"> Bu Ürün Aşağıdaki Masalarda Mevcut <br>

                <?php

                while ($masabilgi=$satir->fetch_assoc()) {
                    $masaid=$masabilgi['masaid'];
                    $masasonuc=$this->genelsorgu($vt,"select * from masalar where id=$masaid")->fetch_assoc();

                    echo "- ".$masasonuc['ad']."<br>";

                }

                echo '</div>';

            } else {

                $this->genelsorgu($vt,"delete from urunler where id=$urunid");
                @$this->uyarı("success","Ürün Başarıyla Silindi","control.php?islem=urunyon");
            }

        } else {
            $this->uyarı("danger","Hata Oluştu","control.php?islem=urunyon");
        }
    }

    function urunguncel($vt) {

        @$buton=$_POST['buton'];

        ?>

        <div class="col-md-3 bg-light text-center mx-auto mt-5 table-bordered">

            <?php


            if ($buton) {

                @$urunad=htmlspecialchars($_POST['urunad']);
                @$urunid=htmlspecialchars($_POST['urunid']);
                @$fiyat=htmlspecialchars($_POST['fiyat']);
                @$katid=htmlspecialchars($_POST['katid']);

                if ($urunad=="" || $urunid=="" || $katid=="" || $fiyat=="") {
                    $this->uyarı("danger","Bilgiler Boş Olamaz","control.php?islem=urunyon");

                } else {

                    $this->genelsorgu($vt,"update urunler set ad='$urunad',fiyat=$fiyat,katid=$katid where id=$urunid");
                    $this->uyarı("success","Ürün Güncellendi","control.php?islem=urunyon");

                }

            } else {
                $urunid=$_GET['urunid'];
                $aktar=$this->genelsorgu($vt,"select * from urunler where id=$urunid")->fetch_assoc();

                ?>

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="col-md-12 bg-warning border-bottom"><h4>ÜRÜN GÜNCELLE</h4></div>
                    <div class="col-md-12 bg-light">Ürün Ad<input type="text" name="urunad" class="form-control mt-3" value="<?php echo $aktar['ad'] ?>"></div>
                    <div class="col-md-12 bg-light">Ürün Fiyat<input type="text" name="fiyat" class="form-control mt-3" value="<?php echo $aktar['fiyat'] ?>"></div>
                    <div class="col-md-12 bg-light">
                        <?php
                        $katid=$aktar['katid'];
                        $katcek=$this->genelsorgu($vt,"select * from kategori");
                        ?>

                        <select name="katid" class="mt-3">

                        <?php while ($katson=$katcek->fetch_assoc()) {

                            if ($katson['id']==$katid) { ?>
                                <option value="<?php echo $katson['id'] ?>" selected="selected"><?php echo $katson['ad'] ?></option>

                           <?php } else { ?>
                                <option value="<?php echo $katson['id'] ?>"><?php echo $katson['ad'] ?></option>

                           <?php } ?>

                       <?php } ?>

                        </select>

                    </div>
                    <div class="col-md-12 bg-light"><input type="submit" name="buton" class="btn btn-success mt-3 mb-3"></div>
                    <input type="hidden" name="urunid" value="<?php echo $urunid ?>">
                </form>


            <?php } ?>

        </div>

    <?php }

    function urunekle($vt) {

        @$buton=$_POST['buton'];

        ?>

        <div class="col-md-3 bg-light text-center mx-auto mt-5 table-bordered">

            <?php


            if ($buton) {

                @$urunad=htmlspecialchars($_POST['urunad']);
                @$fiyat=htmlspecialchars($_POST['fiyat']);
                @$katid=htmlspecialchars($_POST['katid']);

                if ($urunad=="" || $katid=="" || $fiyat=="") {
                    $this->uyarı("danger","Bilgiler Boş Olamaz","control.php?islem=urunyon");

                } else {

                    $this->genelsorgu($vt,"insert into urunler (katid,ad,fiyat) VALUES ($katid,'$urunad',$fiyat)");
                    $this->uyarı("success","Ürün Eklendi","control.php?islem=urunyon");

                }

            } else {

                ?>

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="col-md-12 bg-warning border-bottom"><h4>ÜRÜN EKLE</h4></div>
                    <div class="col-md-12 bg-light">Ürün Ad<input type="text" name="urunad" class="form-control mt-3"></div>
                    <div class="col-md-12 bg-light">Ürün Fiyat<input type="text" name="fiyat" class="form-control mt-3"></div>
                    <div class="col-md-12 bg-light">
                        <?php
                        $katcek=$this->genelsorgu($vt,"select * from kategori");
                        ?>

                        <select name="katid" class="mt-3">

                            <?php while ($katson=$katcek->fetch_assoc()) { ?>

                                <option value="<?php echo $katson['id'] ?>"><?php echo $katson['ad'] ?></option>

                               <?php  }  ?>


                        </select>

                    </div>
                    <div class="col-md-12 bg-light"><input type="submit" name="buton" value="EKLE" class="btn btn-success mt-3 mb-3"></div>
                </form>


            <?php } ?>

        </div>

    <?php }
            //ÜRÜN YÖNETİM
//----------------------------------------

//----------------------------------------
            //KATEGORİ YÖNETİM
    function kategoriyon($vt) {

        $so=$this->genelsorgu($vt,"select * from kategori"); ?>

        <table class="table text-center table-striped table-bordered mx-auto col-md-7 mt-4">
        <thead>
        <tr>
            <th scope="col"><a href="control.php?islem=katekle" class="btn btn-success">+</a> Kategori Adı</th>
            <th scope="col">Güncelle</th>
            <th scope="col">Sil</th>
        </tr>
        </thead>
        <tbody>

        <?php

        while ($sonuc=$so->fetch_assoc()) { ?>

        <tr>
          <td><?php echo $sonuc['ad'] ?></td>
          <td><a href="control.php?islem=katguncel&katid=<?php echo $sonuc['id'] ?>" class="btn btn-warning">Güncelle</a></td>
          <td><a href="control.php?islem=katsil&katid=<?php echo $sonuc['id'] ?>" class="btn btn-danger" data-confirm="Kategoriyi silmek istediğinizden emin misiniz ?">Sil</a></td>
        </tr>

       <?php } ?>

        </tbody>
        </table>
       <?php


    }

    function katsil($vt) {

        $katid=$_GET['katid'];

        if ($katid!="" && is_numeric($katid)) {

            $this->genelsorgu($vt,"delete from kategori where id=$katid");
            @$this->uyarı("success","Kategori Başarıyla Silindi","control.php?islem=katyon");

        } else {
            @$this->uyarı("danger","Hata Oluştu","control.php?islem=katyon");
        }
    }

    function katekle($vt) {

        @$buton=$_POST['buton'];

        ?>
        <div class="col-md-3 bg-light text-center mx-auto mt-5 table-bordered">

            <?php
            if ($buton) {

                @$katad=htmlspecialchars($_POST['katad']);

                if ($katad=="") {
                    $this->uyarı("danger","Bilgiler Boş Olamaz","control.php?islem=katyon");

                } else {

                    $this->genelsorgu($vt,"insert into kategori (ad) VALUES ('$katad')");
                    $this->uyarı("success","Kategori Eklendi","control.php?islem=katyon");

                }

            } else {


                ?>

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="col-md-12 bg-warning border-bottom"><h4>KATEGORİ EKLE</h4></div>
                    <div class="col-md-12 bg-light"><input type="text" name="katad" class="form-control mt-3" required ></div>
                    <div class="col-md-12 bg-light"><input type="submit" name="buton" class="btn btn-success mt-3 mb-3"></div>
                </form>


            <?php } ?>

        </div>

    <?php }

    function katguncel($vt) {
        @$buton=$_POST['buton']; ?>

        <div class="col-md-3 bg-light text-center mx-auto mt-5 table-bordered">

            <?php
            if ($buton) {
                @$katad=htmlspecialchars($_POST['katad']);
                @$katid=htmlspecialchars($_POST['katid']);

                if ($katad=="" ||  $katid=="") {
                    $this->uyarı("danger","Bilgiler Boş Olamaz","control.php?islem=katyon");
                } else {
                    $this->genelsorgu($vt,"update kategori set ad='$katad' where id=$katid");
                    $this->uyarı("success","Kategori Güncellendi","control.php?islem=katyon");
                }
            } else {
                $katid=$_GET['katid'];
                $aktar=$this->genelsorgu($vt,"select * from kategori where id=$katid")->fetch_assoc();

                ?>

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="col-md-12 bg-warning border-bottom"><h4>KATEGORİ GÜNCELLE</h4></div>
                    <div class="col-md-12 bg-light">Kategori Ad<input type="text" name="katad" class="form-control mt-3" value="<?php echo $aktar['ad'] ?>"></div>
                    <div class="col-md-12 bg-light"><input type="submit" name="buton" value="GÜNCELLE" class="btn btn-success mt-3 mb-3"></div>
                    <input type="hidden" name="katid" value="<?php echo $katid ?>">
                </form>

            <?php } ?>
        </div>
    <?php }
            //KATEGORİ YÖNETİM
//----------------------------------------
    function sifredegis($vt) {

            @$buton=$_POST['buton'];

            ?>
            <div class="col-md-3 bg-light text-center mx-auto mt-5 table-bordered">

                <?php
                if ($buton) {

                    @$eskisif=htmlspecialchars($_POST['eskisif']);
                    @$yen1=htmlspecialchars($_POST['yen1']);
                    @$yen2=htmlspecialchars($_POST['yen2']);

                    if ($eskisif=="" || $yen1=="" || $yen2=="") {

                        $this->uyarı("danger","Bilgiler Boş Olamaz","control.php?islem=sifdeg");

                    } else {
                        $eskisifson=md5(sha1(md5($eskisif)));

                        if ($this->genelsorgu($vt,"select * from yonetim where sifre='$eskisifson'")->num_rows==0) {

                            $this->uyarı("danger","Eski Şifre Hatalı","control.php?islem=sifdeg");

                        } elseif ($yen1!=$yen2) {

                            $this->uyarı("danger","Yeni Şifreler Uyumsuz","control.php?islem=sifdeg");

                        } else {

                        $yenisifre=md5(sha1(md5($yen1)));
                        $this->genelsorgu($vt,"update yonetim set sifre='$yenisifre'");
                        $this->uyarı("success","Şifre Değiştirildi","control.php");

                        }
                    }
                } else {
                    ?>

                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="col-md-12 bg-warning border-bottom"><h4>Şifre Değiştir</h4></div>

                        <div class="col-md-12 bg-light"><input type="text" name="eskisif" class="form-control mt-3" required placeholder="Eski Şifrenizi Giriniz" ></div><br>
                        <div class="col-md-12 bg-light"><input type="text" name="yen1" class="form-control mt-3" required placeholder="Yeni Şifrenizi Giriniz" ></div><br>
                        <div class="col-md-12 bg-light"><input type="text" name="yen2" class="form-control mt-3" required placeholder="Yeni Şifre Tekrar" ></div>
                        <div class="col-md-12 bg-light"><input type="submit" name="buton" value="DEĞİŞTİR" class="btn btn-success mt-3 mb-3"></div>
                    </form>

                <?php } ?>

            </div>

        <?php } //ŞİFRE DEĞİŞTİRME

    function rapor($vt){

            @$tercih=$_GET['tar'];

            switch ($tercih) {

                case "bugun":
                    $this->genelsorgu($vt,"Truncate gecicimasa");
                    $this->genelsorgu($vt,"Truncate geciciurun");
                    $veri = $this->genelsorgu($vt,"select * from rapor where tarih=CURDATE()");
                    $veri2 = $this->genelsorgu($vt,"select * from rapor where tarih=CURDATE()");
                break;

                case "dun":
                    $this->genelsorgu($vt,"Truncate gecicimasa");
                    $this->genelsorgu($vt,"Truncate geciciurun");
                    $veri = $this->genelsorgu($vt,"select * from rapor where tarih=DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
                    $veri2 = $this->genelsorgu($vt,"select * from rapor where tarih=DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
                break;

                case "hafta":
                    $this->genelsorgu($vt,"Truncate gecicimasa");
                    $this->genelsorgu($vt,"Truncate geciciurun");
                    $veri = $this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
                    $veri2 = $this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
                break;

                case "ay":
                    $this->genelsorgu($vt,"Truncate gecicimasa");
                    $this->genelsorgu($vt,"Truncate geciciurun");
                    $veri = $this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                    $veri2 = $this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                break;

                case "tum":
                    $this->genelsorgu($vt,"Truncate gecicimasa");
                    $this->genelsorgu($vt,"Truncate geciciurun");
                    $veri = $this->genelsorgu($vt,"select * from rapor");
                    $veri2 = $this->genelsorgu($vt,"select * from rapor");
                break;

                case "tarih":
                    $this->genelsorgu($vt,"Truncate gecicimasa");
                    $this->genelsorgu($vt,"Truncate geciciurun");
                    $tarih1=$_POST['tarih1'];
                    $tarih2=$_POST['tarih2'];
                    ?>
                    <div class="alert alert-info text-center mx-auto mt-4">
                    <?php echo $tarih1 ?>  - <?php echo $tarih2 ?>
                    </div>
                    <?php
                    $veri = $this->genelsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
                    $veri2 = $this->genelsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");


                break;

                default;
                $this->genelsorgu($vt,"Truncate gecicimasa");
                $this->genelsorgu($vt,"Truncate geciciurun");
                $veri = $this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
                $veri2 = $this->genelsorgu($vt,"select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");

            } ?>
                                <table class="table text-center table-light table-bordered mt-4 mx-auto col-md-8" style="margin-bottom: 0.2rem;">
                                <thead>
                                    <tr>
                                       <th colspan="8"><?php
                                       if (@$tarih1!="" || @$tarih2!="") {
                                       echo '<p><a href="cikti.php?islem=ciktial&tar1='.$tarih1.'&tar2='.$tarih2.'" onclick="ortasayfa(this.href,\'mywindow\',\'900\',\'800\',\'yes\'); return false" class="btn btn-warning">ÇIKTI</a></p>';
                                       echo '<a href="excel.php?tar1='.$tarih1.'&tar2='.$tarih2.'" class="btn btn-info">EXCEL AKTAR</a>';
                                       }
                                       ?>
                                       </th>
                                    </tr>
                                <thead>
                                    <tr>
                                        <th><a href="control.php?islem=raporyon&tar=bugun">Bugün</a></th>
                                        <th><a href="control.php?islem=raporyon&tar=dun">Dün</a></th>
                                        <th><a href="control.php?islem=raporyon&tar=hafta">Bu Hafta</a></th>
                                        <th><a href="control.php?islem=raporyon&tar=ay">Bu Ay</a></th>
                                        <th><a href="control.php?islem=raporyon&tar=tum">Tüm Zamanlar</a></th>
                                        <th colspan="2"><form action="control.php?islem=raporyon&tar=tarih" method="post">
                                        <input type="date" name="tarih1" class="form-control col-md-10">
                                        <input type="date" name="tarih2" class="form-control col-md-10">
                                        </th>
                                        <th>
                                        <input name="buton" type="submit" class="btn btn-danger" value="GETİR">
                                        </form></th>
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
                                            $kilit = $this->genelsorgu($vt,"select * from gecicimasa");
                                                if($kilit ->num_rows == 0)
                                                {
                                                    while($gel = $veri->fetch_assoc())
                                                    {
                                                        //masa adını çekiyoruz
                                                        $id = $gel["masaid"];
                                                        $masaveri = $this->genelsorgu($vt, "select * from masalar where id=$id")->fetch_assoc();
                                                        $masaad=$masaveri["ad"];
                                                        //masa adını çekiyoruz

                                                        $raporbak = $this->genelsorgu($vt, "select * from gecicimasa where masaid = $id");
                                                        if($raporbak->num_rows == 0)
                                                        {
                                                            //ekleme
                                                            $has = $gel["adet"] * $gel["urunfiyat"];
                                                            $adet = $gel["adet"];
                                                            $this->genelsorgu($vt,"insert into gecicimasa (masaid,masaad,hasilat,adet) values ($id,'$masaad',$has,$adet)");
                                                        }
                                                        else
                                                        {
                                                            //güncelleme
                                                            $raporson = $raporbak->fetch_assoc();
                                                            $gelenadet= $raporson["adet"];
                                                            $gelenhas = $raporson["hasilat"];

                                                            $sonhasilat = $gelenhas + ($gel["adet"] * $gel["urunfiyat"]);
                                                            $sonadet = $gelenadet + $gel["adet"];

                                                            $this->genelsorgu($vt,"update gecicimasa set hasilat = $sonhasilat, adet = $sonadet where masaid =$id");
                                                        }
                                                    }
                                                }
                                                $son = $this->genelsorgu($vt,"select * from gecicimasa order by hasilat desc;");

                                                $toplamadet=0;
                                                $toplamhasilat=0;

                                                while($listele = $son->fetch_assoc()) {?>
                                                        <tr>
                                                            <td colspan="2"><?php echo $listele["masaad"] ?></td>
                                                            <td colspan="1"><?php echo $listele["adet"] ?></td>
                                                            <td colspan="1"><?php echo number_format($listele["hasilat"],2,".","."); ?> TL</td>
                                                        </tr>

                                                        <?php
                                                         $toplamadet += $listele ['adet'];
                                                         $toplamhasilat += $listele['hasilat'];
                                                         ?>
                                            <?php  } ?>
                                                        <tr class="table-info">
                                                            <td colspan="2">TOPLAM</td>
                                                            <td colspan="1"><?php echo $toplamadet ?></td>
                                                            <td colspan="1"><?php echo number_format($toplamhasilat,2,".","."); ?> TL</td>
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
                                            $kilit2 = $this->genelsorgu($vt,"select * from geciciurun");
                                                if($kilit2 ->num_rows == 0)
                                                {
                                                    while($gel2 = $veri2->fetch_assoc())
                                                    {
                                                        $id = $gel2["urunid"];
                                                        $urunad = $gel2["urunad"];

                                                        $raporbak = $this->genelsorgu($vt, "select * from geciciurun where urunid=$id");
                                                        if($raporbak->num_rows == 0)
                                                        {
                                                            //ekleme
                                                            $has = $gel2["adet"] * $gel2["urunfiyat"];
                                                            $adet = $gel2["adet"];
                                                            $this->genelsorgu($vt,"insert into geciciurun (urunid,urunad,hasilat,adet) values ($id,'$urunad',$has,$adet)");
                                                        }
                                                        else
                                                        {
                                                            //güncelleme
                                                            $raporson = $raporbak->fetch_assoc();
                                                            $gelenadet= $raporson["adet"];
                                                            $gelenhas = $raporson["hasilat"];

                                                            $sonhasilat = $gelenhas + ($gel2["adet"] * $gel2["urunfiyat"]);
                                                            $sonadet = $gelenadet + $gel2["adet"];

                                                            $this->genelsorgu($vt,"update geciciurun set hasilat = $sonhasilat, adet = $sonadet where urunid =$id");
                                                        }
                                                    }
                                                }
                                                $son2 = $this->genelsorgu($vt,"select * from geciciurun order by hasilat desc;");

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

        }// GÜNLÜK,HAFTALIK HASILAT RAPORLARI
//----------------------------------------

//----------------------------------------
            //GARSON YÖNETİM
    function garsonyon($vt) {

        $so=$this->genelsorgu($vt,"select * from garson"); ?>

        <table class="table text-center table-striped table-bordered mx-auto col-md-7 mt-4">
        <thead>
        <tr>
            <th scope="col"><a href="control.php?islem=garsonekle" class="btn btn-success">+</a> Garson Adı</th>
            <th scope="col">Güncelle</th>
            <th scope="col">Sil</th>
        </tr>
        </thead>
        <tbody>

        <?php

        while ($sonuc=$so->fetch_assoc()) { ?>

        <tr>
          <td><?php echo $sonuc['ad'] ?></td>
          <td><a href="control.php?islem=garsonguncel&garsonid=<?php echo $sonuc['id'] ?>" class="btn btn-warning">Güncelle</a></td>
          <td><a href="control.php?islem=garsonsil&garsonid=<?php echo $sonuc['id'] ?>" class="btn btn-danger" data-confirm="Garsonu silmek istediğinizden emin misiniz ?">Sil</a></td>
        </tr>

       <?php } ?>

        </tbody>
        </table>
       <?php


    }

    function garsonsil($vt) {

        $garsonid=$_GET['garsonid'];

        if ($garsonid!="" && is_numeric($garsonid)) {

            $this->genelsorgu($vt,"delete from garson where id=$garsonid");
            @$this->uyarı("success","Garson Başarıyla Silindi","control.php?islem=garsonyon");

        } else {
            @$this->uyarı("danger","Hata Oluştu","control.php?islem=garsonyon");
        }
    }

    function garsonekle($vt) {

        @$buton=$_POST['buton'];

        ?>
        <div class="col-md-3 bg-light text-center mx-auto mt-5 table-bordered">

            <?php
            if ($buton) {

                @$garsonad=htmlspecialchars($_POST['garsonad']);
                @$garsonsifre=htmlspecialchars($_POST['garsonsifre']);

                if ($garsonad=="" || $garsonsifre=="") {
                    $this->uyarı("danger","Bilgiler Boş Olamaz","control.php?islem=garsonyon");

                } else {

                    $this->genelsorgu($vt,"insert into garson (ad,sifre) VALUES ('$garsonad','$garsonsifre')");
                    $this->uyarı("success","Garson Eklendi","control.php?islem=garsonyon");
                }

            } else {

                ?>

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="col-md-12 bg-warning border-bottom"><h4>GARSON EKLE</h4></div>
                    <div class="col-md-12 bg-light">Garson Ad<input type="text" name="garsonad" class="form-control mt-3" required ></div>
                    <div class="col-md-12 bg-light">Garson Şifre<input type="text" name="garsonsifre" class="form-control mt-3" required ></div>
                    <div class="col-md-12 bg-light"><input type="submit" name="buton" class="btn btn-success mt-3 mb-3"></div>
                </form>


            <?php } ?>

        </div>

    <?php }

    function garsonguncel($vt) {
        @$buton=$_POST['buton']; ?>

        <div class="col-md-3 bg-light text-center mx-auto mt-5 table-bordered">

            <?php
            if ($buton) {
                @$garsonad=htmlspecialchars($_POST['garsonad']);
                @$garsonsifre=htmlspecialchars($_POST['garsonsifre']);
                @$garsonid=htmlspecialchars($_POST['garsonid']);

                if ($garsonad=="" || $garsonsifre=="") {
                    $this->uyarı("danger","Bilgiler Boş Olamaz","control.php?islem=garsonyon");
                } else {
                    $this->genelsorgu($vt,"update garson set ad='$garsonad', sifre='$garsonsifre' where id=$garsonid");
                    $this->uyarı("success","Garson Bilgileri Güncellendi","control.php?islem=garsonyon");
                }
            } else {
                $garsonid=$_GET['garsonid'];
                $aktar=$this->genelsorgu($vt,"select * from garson where id=$garsonid")->fetch_assoc();

                ?>

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="col-md-12 bg-warning border-bottom"><h4>GARSON GÜNCELLE</h4></div>
                    <div class="col-md-12 bg-light">Garson Ad<input type="text" name="garsonad" class="form-control mt-3" value="<?php echo $aktar['ad'] ?>"></div>
                    <div class="col-md-12 bg-light">Garson Şifre<input type="text" name="garsonsifre" class="form-control mt-3" value="<?php echo $aktar['sifre'] ?>"></div>
                    <div class="col-md-12 bg-light"><input type="submit" name="buton" value="GÜNCELLE" class="btn btn-success mt-3 mb-3"></div>
                    <input type="hidden" name="garsonid" value="<?php echo $garsonid ?>">
                </form>

            <?php } ?>
        </div>
    <?php }

    function garsonper($vt){

            @$tercih=$_GET['tar'];

            switch ($tercih) {

                case "ay":
                    $this->genelsorgu($vt,"Truncate gecicigarson");
                    $veri = $this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                    $veri2 = $this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                break;

                case "tarih":
                    $this->genelsorgu($vt,"Truncate gecicigarson");
                    $tarih1=$_POST['tarih1'];
                    $tarih2=$_POST['tarih2'];
                    ?>
                    <div class="alert alert-info text-center mx-auto mt-4">
                    <?php echo $tarih1 ?>  - <?php echo $tarih2 ?>
                    </div>
                    <?php
                    $veri = $this->genelsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
                    $veri2 = $this->genelsorgu($vt,"select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");


                break;

                default;
                $this->genelsorgu($vt,"Truncate gecicigarson");
                $veri = $this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                $veri2 = $this->genelsorgu($vt,"select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");

            } ?>
                                <table class="table text-center table-light table-bordered mt-4 mx-auto col-md-8" style="margin-bottom: 0.2rem;">
                                <thead>
                                    <tr>
                                       <th colspan="4"><?php
                                       if (@$tarih1!="" || @$tarih2!="") {
                                       echo '<p><a href="cikti.php?islem=garsoncikti&tar1='.$tarih1.'&tar2='.$tarih2.'" onclick="ortasayfa(this.href,\'mywindow\',\'900\',\'800\',\'yes\'); return false" class="btn btn-warning">ÇIKTI</a></p>';
                                       echo '<a href="garsonexcel.php?tar1='.$tarih1.'&tar2='.$tarih2.'" class="btn btn-info">EXCEL AKTAR</a>';
                                       }
                                       ?>
                                       </th>
                                    </tr>
                                <thead>
                                    <tr>
                                        <th><a href="control.php?islem=garsonper&tar=ay">Bu Ay</a></th>
                                        <form action="control.php?islem=garsonper&tar=tarih" method="post">
                                        <th><input type="date" name="tarih1" class="form-control col-md-10"></th>
                                        <th><input type="date" name="tarih2" class="form-control col-md-10"></th>
                                        <th><input name="buton" type="submit" class="btn btn-danger" value="GETİR"></form></th>
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
                                            $kilit = $this->genelsorgu($vt,"select * from gecicigarson");
                                                if($kilit ->num_rows == 0)
                                                {
                                                    while($gel = $veri->fetch_assoc())
                                                    {
                                                        //garson adını çekiyoruz
                                                        $garsonid = $gel["garsonid"];
                                                        $masaveri = $this->genelsorgu($vt, "select * from garson where id=$garsonid")->fetch_assoc();
                                                        $garsonad=$masaveri["ad"];
                                                        //garson adını çekiyoruz

                                                        $raporbak = $this->genelsorgu($vt, "select * from gecicigarson where garsonid = $garsonid");
                                                        if($raporbak->num_rows == 0)
                                                        {
                                                            //ekleme
                                                            $adet = $gel["adet"];
                                                            $this->genelsorgu($vt,"insert into gecicigarson (garsonid,garsonad,adet) values ($garsonid,'$garsonad',$adet)");
                                                        }
                                                        else
                                                        {
                                                            //güncelleme
                                                            $raporson = $raporbak->fetch_assoc();
                                                            $gelenadet= $raporson["adet"];

                                                            $sonadet = $gelenadet + $gel["adet"];

                                                            $this->genelsorgu($vt,"update gecicigarson set adet = $sonadet where garsonid =$garsonid");
                                                        }
                                                    }
                                                }
                                                $son = $this->genelsorgu($vt,"select * from gecicigarson order by adet desc;");

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

        }// AYLIK GARSON PERFORMANS RAPORLARI
            //GARSON YÖNETİM
//----------------------------------------


//----------------------------------------
            //YÖNETİCİ KODLARI
    function yoneticiayar($vt) {

        $so=$this->genelsorgu($vt,"select * from yonetim"); ?>

        <table class="table text-center table-striped table-bordered mx-auto col-md-7 mt-4">
        <thead>
        <tr>
            <th scope="col"><a href="control.php?islem=yonekle" class="btn btn-success">+</a> Yönetici Adı</th>
            <th scope="col">Güncelle</th>
            <th scope="col">Sil</th>
        </tr>
        </thead>
        <tbody>

        <?php

        while ($sonuc=$so->fetch_assoc()) { ?>

        <tr>
          <td><?php echo $sonuc['kulad'] ?></td>
          <td><a href="control.php?islem=yonguncel&yonid=<?php echo $sonuc['id'] ?>" class="btn btn-warning">Güncelle</a></td>
             <?php
             $sonuc['yetki']==1 ? $durum="disabled" : $durum="";
             ?>
          <td><a href="control.php?islem=yonsil&yonid=<?php echo $sonuc['id'] ?>" class="btn btn-danger <?php echo $durum ?>" data-confirm="Yöneticiyi silmek istediğinizden emin misiniz ?">Sil</a></td>
        </tr>

       <?php } ?>

        </tbody>
        </table>
       <?php


    }

    function yonsil($vt) {

        @$yonid=$_GET['yonid'];

        if ($yonid!="" && is_numeric($yonid)) {

            $this->genelsorgu($vt,"delete from yonetim where id=$yonid");
            @$this->uyarı("success","Yönetici Başarıyla Silindi","control.php?islem=yonayar");

        } else {
            @$this->uyarı("danger","Hata Oluştu","control.php?islem=yonayar");
        }
    }

    function yonekle($vt) {

        @$buton=$_POST['buton'];

        ?>
        <div class="col-md-3 bg-light text-center mx-auto mt-5 table-bordered">

            <?php
            if ($buton) {

                @$yonad=htmlspecialchars($_POST['yonad']);
                @$yonsifre=htmlspecialchars($_POST['yonsifre']);

                $yonsifre=md5(sha1(md5($yonsifre)));

                if ($yonad=="" || $yonsifre=="") {
                    $this->uyarı("danger","Bilgiler Boş Olamaz","control.php?islem=yonayar");

                } else {

                    $this->genelsorgu($vt,"insert into yonetim (kulad,sifre) VALUES ('$yonad','$yonsifre')");
                    $this->uyarı("success","Yönetici Eklendi","control.php?islem=yonayar");

                }

            } else {


                ?>

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="col-md-12 bg-warning border-bottom"><h4>YÖNETİCİ EKLE</h4></div>
                    <div class="col-md-12 bg-light"><input type="text" name="yonad" class="form-control mt-3" required placeholder="Yönetici Adı" ></div>
                    <div class="col-md-12 bg-light"><input type="text" name="yonsifre" class="form-control mt-3" required placeholder="Yönetici Şifre" ></div>
                    <div class="col-md-12 bg-light"><input type="submit" name="buton" class="btn btn-success mt-3 mb-3"></div>
                </form>


            <?php } ?>

        </div>

    <?php }

    function yonguncel($vt) {
        @$buton=$_POST['buton']; ?>

        <div class="col-md-3 bg-light text-center mx-auto mt-5 table-bordered">

            <?php
            if ($buton) {
                @$yonad=htmlspecialchars($_POST['yonad']);
                @$yonid=htmlspecialchars($_POST['yonid']);


                if ($yonad=="" ||  $yonid=="") {
                    $this->uyarı("danger","Bilgiler Boş Olamaz","control.php?islem=katyon");
                } else {
                    $this->genelsorgu($vt,"update yonetim set kulad='$yonad' where id=$yonid");
                    $this->uyarı("success","Yönetici Güncellendi","control.php?islem=yonayar");
                }
            } else {
                $yonid=$_GET['yonid'];
                $aktar=$this->genelsorgu($vt,"select * from yonetim where id=$yonid")->fetch_assoc();

                ?>

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="col-md-12 bg-warning border-bottom"><h4>YÖNETİCİ GÜNCELLE</h4></div>
                    <div class="col-md-12 bg-light">Yönetici Ad<input type="text" name="yonad" class="form-control mt-3" value="<?php echo $aktar['kulad'] ?>"></div>
                    <div class="col-md-12 bg-light"><input type="submit" name="buton" value="GÜNCELLE" class="btn btn-success mt-3 mb-3"></div>
                    <input type="hidden" name="yonid" value="<?php echo $yonid ?>">
                </form>

            <?php } ?>
        </div>
    <?php }
            //YÖNETİCİ KODLARI
//----------------------------------------


    public function giriskont($r,$k,$s) {

         $sonhal=md5(sha1(md5($s)));

         $sorgu="select * from yonetim where kulad='$k' and sifre='$sonhal'";
         $sor=$r->prepare($sorgu);
         $sor->execute();
         $sonbilgi=$sor->get_result();
         $veri=$sonbilgi->fetch_assoc();

         if ($sonbilgi->num_rows==0) {
             $this->uyarı("danger","Bilgiler Hatalı","index.php");

         } else {
             $this->uyarı("success","Giriş Yapılıyor","control.php");

             $kulson=md5(sha1(md5($k)));

             setcookie("kul",$kulson,time() + 31556926);
         }
    }
    //ÇEREZ KONTROL
    public function cookcon($d,$durum=false) {

        if (isset($_COOKIE['kul'])) {

            $deger=$_COOKIE['kul'];

            $sorgu="select * from yonetim";
            $sor=$d->prepare($sorgu);
            $sor->execute();
            $sonbilgi=$sor->get_result();
            $veri=$sonbilgi->fetch_assoc();

            $sonhal=md5(sha1(md5($veri['kulad'])));

            if ($sonhal!=$_COOKIE['kul']) {
                setcookie("kul",$deger, time() - 10);
                header("Location:index.php");
            } else {

                if ($durum==true) { header("Location:control.php"); }
            }

        } else {
            if ($durum==false) { header("Location:index.php"); }
        }
    }
}



?>