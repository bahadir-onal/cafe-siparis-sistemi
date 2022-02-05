<?php
include_once "fonk/yonfok.php"; $clas= new yonetim();
$clas->cookcon($vt,true);

?>
<!DOCTYPE html>
<html>
<head>
    <script src="../dosya/jqu.js"></script>
    <link rel="stylesheet" href="../dosya/boost.css">
    <title>Giriş</title>
    <style>
        #log {
            margin-top: 20%;
            min-height: 250px;
            background-color: #fefefe;
            border-radius: 10px;
            border:1px solid #b7b7b7;
        }
    </style>

</head>
<body style="background-color: rgba(235,219,219,0.93);">
<div class="container text-center">
    <div class="row mx-auto">
        <div class="col-md-4"></div>




        <div class="col-md-4 mx-auto text-center" id="log">





            <?php

            //echo md5(sha1(md5("123")));

            @$buton=$_POST['buton'];
            if (!$buton) { ?>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="col-md-12 border-bottom p-2"><h3>Yönetici Giriş</h3></div>
                    <div class="col-md-12"><input type="text" name="kulad" class="form-control mt-2" required="required" placeholder="Yönetici Adınız" autofocus="autofocus"></div>
                    <div class="col-md-12"><input type="password" name="sifre" class="form-control mt-2" required="required" placeholder="Şifreniz"></div>
                    <div class="col-md-12"><input type="submit" name="buton" class="btn btn-success mt-2" value="GİRİŞ"></div>
                </form>

            <?php } else {
                @$sifre=htmlspecialchars(strip_tags($_POST['sifre']));
                @$kulad=htmlspecialchars(strip_tags($_POST['kulad']));

                if ($sifre=="" || $kulad=="") {

                    echo "Bilgiler boş olamaz";
                    header("refresh:2,url=index.php");

                } else {
                    $clas->giriskont($vt,$kulad,$sifre);
                }

            } ?>






        </div>




        <div class="col-md-4"></div>
    </div>
</div>

</body>
</html>