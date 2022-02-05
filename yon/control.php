<?php include_once "fonk/yonfok.php"; $yokclas = new yonetim();
$yokclas->cookcon($vt,false);

?>
<!DOCTYPE html>
<html>
<head>
    <script src="../dosya/jqu.js"></script>
    <link rel="stylesheet" href="../dosya/boost.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <title>Restaurant Kontrol Sistemi</title>

    <style>
        body{
            height: 100%;
            width: 100%;
            position: absolute;
        }
        .container-fluid,
        .row-fluid {
            height: inherit;
        }

        #lk:link, #lk:visited {
            color: #888;
            text-decoration: none;
        }
        #lk:hover {
            color: #000;
        }

        #div2 {
            min-height: 100%; background-color: #dccece
        }

        #div1 {
            background-color: #ffffff;
            border: 1px solid #e6d4d4;
            border-radius: 5px;
        }

    </style>

    <script language="javascript">

        var popupWindow=null;
        function ortasayfa(url,winName,w,scroll) {

            LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
            TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
            settings='height='+h+', width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'

            popupWindow=window.open(url,winName,settings)

        }

        $(document).ready(function () {

            $('a[data-confirm]').click(function (ev){

                var href=$(this).attr('href');

                if (!$('#dataConfirmModal').length){
                    $('body').append('<div class="modal fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">ONAY</h5></div><div class="modal-body"></div>   <div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">VAZGEÇ</button><a class="btn btn-primary" id="dataConfirmOK">SİL</a></div></div></div></div></div>');

                        $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
                        $('#dataConfirmOK').attr('href',href);
                        $('#dataConfirmModal').modal({show:true});
                        return false;
                }

            })

        });

    </script>
</head>
<body>

<div class="container-fluid bg-light">
    <div class="row row-fluid">
        <div class="col-md-2 border-right bg-info">

                <div class="row">
                    <div class="col-md-12 bg-light p-4 mx-auto text-center font-weight-bold" style="color:#000;">
                        <h3><?php echo $yokclas->kulad($vt); ?></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 bg-light p-2 pl-3 border-bottom border-top text-white">
                        <a href="control.php?islem=masayon" id="lk">Masa Yönetimi</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
                        <a href="control.php?islem=urunyon" id="lk">Ürün Yönetimi</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
                        <a href="control.php?islem=katyon" id="lk">Kategori Yönetimi</a>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
                    <a href="control.php?islem=garsonyon" id="lk">Garson Yönetimi</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
                    <a href="control.php?islem=garsonper" id="lk">Garson Performans</a>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
                        <a href="control.php?islem=raporyon" id="lk">Rapor Yönetimi</a>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
                    <a href="control.php?islem=yonayar" id="lk">Yönetici Ayarları</a>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
                        <a href="control.php?islem=sifdeg" id="lk">Şifre Değiştir</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 bg-light p-2 pl-3 border-bottom text-white">
                        <a href="control.php?islem=cikis" id="lk" data-confirm="Çıkış yapmak istediğinizden emin misiniz ?">Çıkış</a>
                    </div>

                <table class="table text-center table-dark table-bordered mt-2 table-striped">
                    <thead>
                    <tr class="table-dark">
                        <th scope="col" style="color: #1b1e21" colspan="4">Anlık Durum</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <th scope="col" colspan="3">Toplam Garson</th>
                        <th scope="col" colspan="1" class="text-danger"><?php $yokclas->toplamgarson($vt); ?></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="3">Toplam Sipariş</th>
                        <th scope="col" colspan="1" class="text-danger"><?php $yokclas->topurunadet($vt); ?></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="3">Doluluk Oranı</th>
                        <th scope="col" colspan="1" class="text-danger"><?php $yokclas->doluluk($vt); ?></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="3">Toplam Masa</th>
                        <th scope="col" colspan="1" class="text-danger"><?php $yokclas->toplammasa($vt); ?></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="3">Toplam Kategori</th>
                        <th scope="col" colspan="1" class="text-danger"><?php $yokclas->toplamkat($vt); ?></th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="3">Toplam Ürün</th>
                        <th scope="col" colspan="1" class="text-danger"><?php $yokclas->toplamurun($vt); ?></th>
                    </tr>
                    </tbody>
                </table>

            </div>



        </div>
            <div class="col-md-10">
                 <div class="row bg-light" id="div2">
                    <div class="col-md-12 mt-4" id="div1">

                        <?php

                        @$islem=$_GET['islem'];

                        switch ($islem) {
//----------------------------------------------------------------------------------------------------------------
                            case "masayon":
                               $yokclas->masayon($vt);
                            break;

                            case "masasil":
                                $yokclas->masasil($vt);
                            break;

                            case "masaguncel":
                                $yokclas->masaguncel($vt);
                            break;

                            case "masaekle":
                                $yokclas->masaekle($vt);
                                break;
//----------------------------------------------------------------------------------------------------------------
                            case "urunyon":
                                $yokclas->urunyon($vt,0);
                            break;

                            case "urunsil":
                                $yokclas->urunsil($vt);
                            break;

                            case "urunguncel":
                                $yokclas->urunguncel($vt);
                            break;

                            case "urunekle":
                                $yokclas->urunekle($vt);
                            break;

                            case "katgore":
                                $yokclas->urunyon($vt,2);
                            break;

                            case "aramasonuc":
                                $yokclas->urunyon($vt,1);
                            break;
//----------------------------------------------------------------------------------------------------------------
                            case "katyon":
                                $yokclas->kategoriyon($vt);
                            break;

                            case "katekle":
                                $yokclas->katekle($vt);
                            break;

                            case "katsil":
                                $yokclas->katsil($vt);
                            break;

                            case "katguncel":
                                $yokclas->katguncel($vt);
                            break;
//----------------------------------------------------------------------------------------------------------------
                            case "raporyon":
                                $yokclas->rapor($vt);
                            break;

                            case "sifdeg":
                                $yokclas->sifredegis($vt);
                            break;

                            case "cikis":
                                $yokclas->cikis($yokclas->kulad($vt));
                            break;

                            default;
//----------------------------------------------------------------------------------------------------------------

                            case "garsonyon":
                                $yokclas->garsonyon($vt);
                                break;

                            case "garsonekle":
                                $yokclas->garsonekle($vt);
                                break;

                            case "garsonsil":
                                $yokclas->garsonsil($vt);
                                break;

                            case "garsonguncel":
                                $yokclas->garsonguncel($vt);
                                break;
                            case "garsonper":
                                $yokclas->garsonper($vt);
                                break;
//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------
                            case "yonayar":
                                $yokclas->yoneticiayar($vt);
                                break;

                            case "yonekle":
                                $yokclas->yonekle($vt);
                                break;

                            case "yonsil":
                                $yokclas->yonsil($vt);
                                break;

                            case "yonguncel":
                                $yokclas->yonguncel($vt);
                                break;
//----------------------------------------------------------------------------------------------------------------

                        }



                        ?>
                    </div>
                </div>


            </div>
    </div>
</div>


</body>
</html>