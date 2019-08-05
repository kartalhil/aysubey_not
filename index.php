<?php
  @session_start();
  require("_ayarlar.php");
  require("_functions.php");
  // Markdon to HTML Starts
  require_once("vendor/autoload.php");
  $Parsedown = new Parsedown();

  $Baslik="";

  if( isset($_GET["id"]) ) {
    $MakaleID = intval($_GET["id"]);
    $Cevap = MakaleOku($MakaleID);

    $DosyaAdi  = $Cevap[0];
    $Baslik    = $Cevap[1];
    $Icerik    = $Cevap[2];
    $Sayac     = $Cevap[3];
    $YazarAdi  = $Cevap[4];
    $YayinTarihi  = $Cevap[5];
    $KategorileriLinkleri = $Cevap[6];
    $Durum = $Cevap[10];

  }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $SITE_TAB_ADI; ?></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">  <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/css/mdb.min.css">        <!-- Material Design Bootstrap MDB-->
    <link rel="stylesheet" href="bootstrap/css/style.css">          <!-- Özel CSS -->
    <link rel="stylesheet" href="bootstrap/css/sidebar.css">
    <link rel="stylesheet" href='prism/prism.css'>
    <link rel="stylesheet" href="simplemde/simplemde.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- background-color: red !important; -->

  <style media="screen">
    body{background-color: <?php echo $body; ?> !important;}
    ul {border-bottom: <?php echo $renk10; ?> !important;}
    ul li.active > a, a[aria-expanded="true"]{ background-color: <?php echo $renk8; ?> !important; color: <?php echo $koyu ?> !important; }
    ul li a:hover{ background-color: <?php echo $renk6; ?> !important; color: <?php echo $koyu ?> !important; }
    ul li a:focus{ background-color: <?php echo $renk8; ?> !important; color: <?php echo $renk1 ?> !important; }
    ul ul a { background-color: <?php echo $renk1; ?> !important; color: <?php echo $koyu ?> !important; }
    ul ul a:hover{ background-color: <?php echo $renk6; ?> !important; color: <?php echo $koyu ?> !important; }
  </style>

</head>
<body>
    <div class="wrapper display-hidden">
        <!-- SİDEBAR  -->
        <nav id="sidebar" class="warning-color" style="background-color: <?php echo $renk6; ?> !important">
            <div class="sidebar-header warning-color-dark" style="background-color: <?php echo $renk10; ?> !important">
              <a href="index.php"><h5 class="font-weight-bold"><?php echo $SITE_ADI; ?></h5></a>
            </div>
            <ul class="list-unstyled components">
                <!-- MAKALE LİSTESİ -->
                <li>
                    <a href="index.php?sayfa=makaleListesi">Notlarım</a>
                </li>
                <!-- /MAKALE LİSTESİ -->
                <!-- TOP-10 -->
                <li>
                    <a href="#makalelerTop10" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Top-10</a>
                    <ul class="collapse list-unstyled" id="makalelerTop10">
                        <?php MakaleleriListele(); ?>
                    </ul>
                </li>
                <!-- /TOP-10 -->
                <!-- KATEGORİ LİSTESİ -->
                <li>
                    <a href="#kategoriler" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Not Kategorileri</a>
                    <ul class="collapse list-unstyled" id="kategoriler">
                        <?php KategorileriListele(); ?>
                    </ul>
                </li>
                <!-- /KATEGORİ LİSTESİ -->
                <li>
                    <a href="index.php?sayfa=hakkimda">Hakkımda</a>
                </li>
                <li>
                    <a href="index.php?sayfa=iletisim">İletişim</a>
                </li>

                <?php if( isset($_GET['giris']) ) { ?>

                <!-- KULLANICI GİRİŞİ -->
                <div class="card mb-2 kapi">
                  <h6 class="card-header warning-color-dark white-text text-center py-2"><strong>Kullanıcı Girişi</strong></h6>
                  <div class="card-body px-lg-2" style='background-color: <?php echo $renk1 ?> !important;'>
                    <form class="text-center" style="color: #757575;" action="giris.yap.php" method="POST">
                      <div class="md-form">
                        <input type="text" class="form-control" name="kullanici" placeholder="E-Posta" autocomplete="off">
                      </div>
                      <div class="md-form">
                        <input type="password" name="parola" class="form-control" placeholder="Parola" autocomplete="off">
                      </div>
                      <button class="btn btn-outline-warning btn-rounded btn-sm btn-block waves-effect z-depth-0" type="submit"><b>GÖNDER</b></button>
                    </form>
                  </div>
                </div>
                <!-- /KULLANICI GİRİŞİ -->

                <?php }
                  if($_SESSION["GirisYapti"] == 1) { ?>

                <!-- KULLANICI MENÜSÜ -->
                <li>
                    <a href="#kullaniciMenusu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle warning-color-dark" style="background-color: <?php echo $renk7; ?> !important">Yönetim</a>
                    <ul class="collapse list-unstyled" id="kullaniciMenusu">
                        <li>
                            <a href="index.php?sayfa=icerikListele">İçerik Listele</a>
                        </li>
                        <li>
                            <a href="index.php?sayfa=icerikEkle">İçerik Ekle</a>
                        </li>
                        <li>
                            <a href="oturumuKapat.php">Oturumu Kapat</a>
                        </li>
                    </ul>
                </li>
                <!-- /KULLANICI MENÜSÜ -->

                <?php } ?>

            </ul>
        </nav>
        <!-- /SİDEBAR  -->
        <!-- İCERİK  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-dark warning-color-dark" style="background-color: <?php echo $renk10; ?> !important">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-outline-warning waves-effect" style="border: 1px solid <?php echo $renkoutline; ?> !important">
                        <i class="white-text fas fa-align-left"></i>
                        <span class="white-text">Menü</span>
                    </button>

                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav mr-auto">
                          <li class="nav-item font-weight-bold ml-5">
                              <a class="nav-link" href="index.php">Anasayfa</a>
                          </li>
                        </ul>
                        <form class="form-inline" id='form1' method="get">
                          <div class="md-form my-0">
                            <input type='hidden' name='sayfa' value='arama' onclick='form1.submit();'>
                            <input class="form-control mr-sm-2" type="text" placeholder="Site içi ara..." name='bul' aria-label="Search">
                            <a class="text-white" type='button' value='Bul!' onclick='form1.submit();'><i class='fa fa-search ' aria-hidden='true'></i></a>
                          </div>
                        </form>
                    </div>
                </div>
            </nav>

            <?php
              $ID    = $_GET["id"];
              $sayfa = $_GET["sayfa"];

              switch ($sayfa) {
                case 'icerikListele':
                  echo "<h6 class='card-header warning-color white-text py-2' style='background-color: $renk7 !important'>$SITE_ADI Listesi</h6>";
                  echo "<table class='table table-hover table-sm'>
                          <thead>
                            <th class='text-center'>Sıra</th>
                            <th>Makale Başlık</th>
                            <th></th>
                          </thead>
                          <tbody>";
                            MakaleleriListeleYonetim();
                  echo "  </tbody>
                        </table>";
                  break;

                case 'makaleListesi':
                  require('makaleListesi.php');
                  break;

                case 'makaleDuzenle':
                  require('makaleDuzenle.php');
                  break;

                case 'icerikEkle':
                  require('makaleEkle.php');
                  break;

                case 'arama':
                  $BUL = substr(trim($_GET["bul"]), 0, 10); // Aranacak ifadenin sadece ilk 10 karakterini kullan.
                  MakalelerdeAra($BUL);
                  break;

                case 'iletisim':
                  require('iletisim.php');
                  break;

                case 'hakkimda':
                  require('hakkimda.php');
                  break;

                case 'kategori':
                  $KATEGORI_ADI = $_GET["kategoriadi"];
                  if(file_exists("kategoriler/$KATEGORI_ADI.txt")) {
                    echo "<div class='card card-header warning-color mb-2' style='background-color: $renk7 !important'><b>$KATEGORI_ADI Kategorisindeki Makaleler</b></div>";
                    include("kategoriler/$KATEGORI_ADI.txt");
                  } else {
                    echo "<h2 style='color:red;'>$KATEGORI_ADI Kategorisinde yazı bulunmamaktadır...</h2>";
                  }
                  break;

                case 'icerik':
                  $EDIT_LINK = "
                  <div align='right'>
                    <a href='index.php?sayfa=makaleDuzenle&makale=$Baslik&id=$MakaleID'>
                    <button type='button' class='btn btn-outline-warning waves-effect'>
                      <span class='red-text font-weight-bold text-monospace'>Makaleyi Düzenle</span>
                    </button></a>
                  </div>";
                  if($_SESSION["GirisYapti"] != 1) $EDIT_LINK = "";
                  echo "<div class='card'>
                          <div class='card-body icerik' style='background-color: <?php echo $renk1 ?> !important;'>
                            $EDIT_LINK
                            $Icerik
                            <hr>
                            <p><i>Bu sayfa $Sayac defa gösterilmiştir.</i></p>
                            <p>";
                  if(trim($YazarAdi) <> "") echo "<div class='row'><div><span style='margin-right: 20px;'><b>YAZAR:</b> $YazarAdi</span></div>";
                  if(trim($YayinTarihi) <> "") echo "<div><span style='margin-right: 20px;'><b>TARİH:</b> $YayinTarihi</span></div>";
                  if(trim($KategorileriLinkleri) <> "") echo "<div><span style='margin-right: 20px;'><b>KATEGORİ:</b> $KategorileriLinkleri</span></div>";
                  if(trim($Durum) <> "") echo "<div><span style='margin-right: 20px;'><b>DURUM:</b>";
                  echo $Durum == 1 ? " Yayında" : " Yayında değil!";

                  echo      "</span></div></div>
                              </p>
                          </div>
                        </div>";
                  break;

                default:
                  $arrMakaleler = glob("database/M*.md"); // Başı M ile başlayan md uzantılı dosyaları çektim.
                  shuffle($arrMakaleler); // Gelen dosya yollarını rastgele karıştırdı.

                  for ($i=0; $i <3 ; $i++) {
                    $Makale   = $arrMakaleler [$i]; // Dizinin sıradaki elemanını aldık.
                    $MakaleID = intval(mb_substr($Makale,10,4)); // İlk on karakterden itibaren dört karakteri tam sayı olarak aldık.

                    $Cevap = MakaleOku($MakaleID);

                    $DosyaAdi             = $Cevap[0];
                    $Baslik               = $Cevap[1];
                    $Icerik               = $Cevap[2];
                    $Sayac                = $Cevap[3];
                    $YazarAdi             = $Cevap[4];
                    $YayinTarihi          = $Cevap[5];
                    $KategorileriLinkleri = $Cevap[6];
                    $IcerikOzeti          = $Cevap[8];
                    $ResimAdi             = $Cevap[9];
                    $Durum                = $Cevap[10];

                    if ($Durum == 0) {
                      $aktifx = "red";
                      $aktify = "danger";
                      $arkaplan = "#FFCCFF";
                    } else {
                      $aktifx = "green";
                      $aktify = "success";
                      $arkaplan = "";
                    }

                    echo "<div class='card mb-3 ozet' style='background-color: $arkaplan !important;'>
                            <div class='row clearfix'>
                              <div class='col-md-4 ozet_img' title='Makalenin Devamı...'>
                                <a href='index.php?sayfa=icerik&makele=$Baslik&id=$MakaleID'><img src='$ResimAdi' alt='$Baslik' /></a>
                              </div>
                              <div class='col-md-8'>
                                <div class='card-body'>
                                   $IcerikOzeti
                                  <p align='right'>
                                      <a href='index.php?sayfa=hakkimda'><i class='fas fa-address-card text-success' style='color:$aktifx !important;'></i></a>
                                      <span style='font-size:70%;'>
                                      $YazarAdi
                                      </span>&nbsp;&nbsp;&nbsp;
                                      <a href='#'><i class='fas fa-clock text-success' style='color:$aktifx !important;'></i></a>
                                      <span style='font-size:70%;'>
                                      $YayinTarihi
                                      </span>&nbsp;&nbsp;&nbsp;
                                      <a href='#'><i class='fas fa-align-justify text-success' style='color:$aktifx !important;'></i></a>
                                      <span style='font-size:70%;'>
                                      $KategorileriLinkleri
                                      </span>&nbsp;&nbsp;&nbsp;
                                      <a href='#'><i class='fas fa-check-circle text-success' style='color:$aktifx !important;'></i></a>
                                      <span style='font-size:70%;'>
                                      </span>&nbsp;&nbsp;&nbsp;
                                      <a class='btn btn-sm btn-outline-$aktify' href='index.php?sayfa=icerik&makele=$Baslik&id=$MakaleID' style='color:$aktifx !important;'>
                                          Devamı &nbsp;<i class='fas fa-angle-double-right' style='color:$aktifx !important;'></i><i class='fas fa-angle-double-right' style='color:$aktifx !important;'></i>
                                      </a>
                                   </p>
                                </div>
                              </div>
                            </div>
                          </div>";
                  } // for

              } // switch
            ?>
        </div>
        <!-- /İCERİK  -->
    </div>
    <!-- FOOTER -->
    <footer class="page-footer font-small mt-3 warning-color" style="background-color: <?php echo $renk10; ?> !important">
      <div class="footer-copyright text-center py-3">2018 © <a href="https://aysubey.com"> aysubey.com</a>
      </div>
    </footer>
    <!-- /FOOTER -->
    <!-- SCRIPTS -->
    <script type="text/javascript" src="bootstrap/js/jquery-3.3.1.min.js"></script> <!-- JQuery -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="bootstrap/js/popper.min.js"></script>       <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="bootstrap/js/mdb.min.js"></script>          <!-- MDB core JavaScript -->
    <script src='prism/prism.js'></script>
    <script src="simplemde/simplemde.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="bootstrap/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <script>
    	new SimpleMDE({
    		element: document.getElementById("SME"),
    		spellChecker: false,
        toolbar: ["bold", "italic", "|", "strikethrough", "heading", "heading-smaller", "heading-bigger", "heading-1", "heading-2", "heading-3", "code", "quote", "unordered-list", "ordered-list", "clean-block", "link", "image", "table", "horizontal-rule", "preview", "side-by-side", "fullscreen", "guide"],
    	});
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>
</html>
