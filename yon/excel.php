<?php
include_once "fonk/yonfok.php";
$yokclas = new yonetim();


function excelal($filename='ExportExcel',$columns=array(),$columns2=array(),$data=array(),$data2=array(),$virgulnerede=array(),$veri1,$veri2) {

    header('Content-Encoding');
    header('Content-Type: text/plain; charset-utf-8');
    header('Content-disposition: attachment;filename='.$filename.'.xls');
    echo "\xEF\xBB\xBF";

    @$tarih1=$_GET['tar1'];
    @$tarih2=$_GET['tar2'];


    $sayim=count($columns);

    echo '<table border="1"><th style="background-color: #000000" colspan="3"><font color="#FDFDFD">'.$tarih1.'-'.$tarih2.'</font>
</th><tr>';

    foreach ($columns as $v) {
        echo '<th style="background-color: #FFA500">'.trim($v).'</th>';
    }
    echo '</tr>';

    foreach ($data as $val) {
        echo '<tr>';

        for ($i=0; $i < $sayim; $i++) {
            if (in_array($i,$virgulnerede)) {
                echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
            } else {
                echo '<td>'.$val[$i].'</td>';
            }
        }
        echo '</tr>';

    }

    echo '<tr style="background-color: #56d2ec">
            <td>Toplam</td>
            <td>'.$veri1.'</td>
            <td>'.$veri2.'</td>
          </tr>
';
    //---------------------------------------------------------------------------------------------------------------------

    $sayim2=count($columns2);

    echo '<tr>';

    foreach ($columns2 as $v2) {
        echo '<th style="background-color: #FFA500">'.trim($v2).'</th>';
    }
    echo '</tr>';

    foreach ($data2 as $val2) {
        echo '<tr>';

        for ($i=0; $i < $sayim2; $i++) {
            if (in_array($i,$virgulnerede)) {
                echo '<td>'.str_replace('.',',',$val2[$i]).'</td>';
            } else {
                echo '<td>'.$val2[$i].'</td>';
            }
        }
        echo '</tr>';

    }

}

$masadizi=array();
$masadata=array();

$urundizi=array();
$urundata=array();

$urundizi=array(
    'Ürün Ad',
    'Adet',
    'Hasılat'
);

$masadizi=array(
    'Masa Ad',
    'Adet',
    'Hasılat'
);


$virgulnerede=array(2);

$son = $yokclas->ciktiicinSorgu($vt,"select * from gecicimasa order by hasilat desc;");

$Masatoplamadet=0;
$Masatoplamhasilat=0;

while($listele = $son->fetch_assoc()) {

    @$masadata[]=array(
        $listele ['masaad'],
        $listele ['adet'],
        $listele ['hasilat']

    );


    $Masatoplamadet += $listele ['adet'];
    $Masatoplamhasilat += $listele['hasilat'];

 }

    $son2 = $yokclas->ciktiicinSorgu($vt,"select * from geciciurun order by hasilat desc;");

    while($listele2 = $son2->fetch_assoc()) {

        @$urundata[]=array(
            $listele2 ['urunad'],
            $listele2 ['adet'],
            $listele2 ['hasilat']

        );
  }

  excelal(date("d.m.Y"),$masadizi,$urundizi,$masadata,$urundata,$virgulnerede,$Masatoplamadet,$Masatoplamhasilat);


