<?php
$db = new mysqli("localhost","root","123456789","siparis") or die("Bağlanamadı");
$db->set_charset("utf-8");


class sistem {


    private function benimsorum($vt,$sorgu,$tercih){

         $a = $sorgu;
         $b=$vt->prepare($a);
         $b->execute();
         if ($tercih==1) {
         return $c=$b->get_result();
         }
     }

    function benimsorum2($vt,$sorgu,$tercih){

        $a = $sorgu;
        $b=$vt->prepare($a);
        $b->execute();
        if ($tercih==1) {
            return $c=$b->get_result();
        }
    }

    function masacek($dv){

            $masalar = "select * from masalar";
            $sonuc=$this->benimsorum($dv,$masalar,1);
            $bos=0;
            $dolu=0;

            while ($masason=$sonuc->fetch_assoc()) {
            $siparisler = 'select * from anliksiparis where masaid='.$masason ['id'].'';
            $this->benimsorum($dv,$siparisler,1)->num_rows==0 ? $renk="danger" : $renk="success" ;
            $this->benimsorum($dv,$siparisler,1)->num_rows==0 ? $bos++ : $dolu++ ;

                ?>

                <div id="mas" class="col-md-2 col-sm-6 mr-2 mx-auto p-2 text-center text-white">
                    <a href="masadetay.php?masaid=<?php echo $masason["id"] ?>">
                        <div class="bg-<?php echo $renk ?> text-white" id="masa"><?php echo $masason["ad"] ?></div>
                    </a>
                </div>

                <?php
            }

                $dol="update doluluk set bos=$bos, dolu=$dolu where id=1";
                $dolson=$dv->prepare($dol);
                $dolson->execute();
    }

    function doluluk($dv) {

         $son=$this->benimsorum($dv,"select * from doluluk",1);
         $veriler=$son->fetch_assoc();
         $toplam = $veriler['bos'] + $veriler['dolu'];
         $oran = ($veriler['dolu'] / $toplam) * 100;
         echo $oran=substr($oran,0,5). " %";

    }

    function masatoplam($dv) {

        echo $sonuc=$this->benimsorum($dv,"select * from masalar",1)->num_rows;
    }

    function siparistoplam($dv) {

        echo $sonuc=$this->benimsorum($dv,"select * from anliksiparis",1)->num_rows;
    }

    //MASA DETAY FONKSİYON

    function masagetir($vt,$id) {

         $get="select * from masalar where id=$id";
         return $this->benimsorum($vt,$get,1);

    }

    function urungrup($db) {

         $se="select * from kategori";
         $gelen=$this->benimsorum($db,$se,1);

         while ($son=$gelen->fetch_assoc()) {

             echo '<a class="btn btn-dark mt-2 text-white" sectionId="'.$son["id"].'">'.$son["ad"].'</a><br><br>';

         }

    }

    function garsonbak($db) {

        $gelen=$this->benimsorum2($db,"select * from garson where durum=1",1)->fetch_assoc();

        if ($gelen['ad']!="") {

            echo $gelen['ad']; ?>

            <a href="islemler.php?islem=cikis" class="m-3"><kbd class="bg-info">Çık</kbd></a>

            <?php

        } else {
            echo "Giriş yapan garson yok";
        }

    }

}









?>