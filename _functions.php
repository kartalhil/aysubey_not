<?php
  require("_ayarlar.php");

  // DİZİLERİ EKRANDA GÖREREK KONTROL ETMEK İÇİN KULLANILIR.
  function DD($degisken) {
    echo "<pre>";
    print_r($degisken);
    echo "</pre>";
  }

  function MakaleOku($ID){
    global $Parsedown;
    $ID       = intval($ID);
    $DosyaID  = sprintf("%04d", $ID);         // Gelen id başına 0 eklenerek 4 dijitli hale getiriliyor.
    $DosyaAdi = "M$DosyaID.md";               // 4 dijit olan id nin Başına M, sonuna .md eklenerek dosya adı oluşturuluyor.
    $DosyaAdi = "database/".$DosyaAdi;        // Dosya yolu tanımlanıyor.
    $SayacDosyaAdi = "database/S$DosyaID.txt";// Aynı dosya adında ziyaret sayacı takibi için text dosyası oluşturuluyor.

    if(!file_exists($SayacDosyaAdi)) {                     // Eğer sayaç dosyası yoksa!
      file_put_contents($SayacDosyaAdi, "1");              // İlk değer olarak 1 veriliyor.
    } else {
      $Sayac  = trim(file_get_contents($SayacDosyaAdi));   // Sayaç dosyası dizge olarak bir değişkene alınıyor.
      $Sayac  = intval($Sayac) + 1;
      file_put_contents($SayacDosyaAdi, $Sayac);           // Artırılan tam sayıyı SayaçDosyaAdi.txt dosyasına yazıyor.
    }

    $arrDosya = file($DosyaAdi);                // Dosya içeriğini dizge olarak değişkene verdik.
    $Baslik = $arrDosya[0];                     // Değişkenin 1. elemanını (Başlık olacak.) alıyoruz.
    $Baslik = trim(substr($Baslik, 2));         // Başındaki bir adet # işaretini ve boşluğu (İki karakteri) kırpıyoruz.

    foreach($arrDosya as $SatirNo => $Satir) {
      if(substr($Satir, 0, 2) == "::") {
        $YazarSatiri = str_replace("::", "", $Satir);
        unset($arrDosya[$SatirNo]);
      }
    }



    list($YazarAdi, $YayinTarihi, $Kategoriler, $Durum) = explode("|", $YazarSatiri);

    $arrKategoriler = explode(";", $Kategoriler);

    $KategoriLinkleri = array();
    foreach ($arrKategoriler as $KategoriAdi) {
      $KategoriAdi = trim($KategoriAdi);
      if( $KategoriAdi <> "") {
        $KategoriLinkleri[] = "<a href='index.php?sayfa=kategori&kategoriadi=$KategoriAdi'>$KategoriAdi</a>";
      }
    }
    $KategoriLinkleri = implode(" | ", $KategoriLinkleri);

    $Icerik = implode("", $arrDosya);

    $Baslik = ($Baslik == "") ? "ASB-BPS" : $Baslik;

    $IcerikOzeti = mb_substr($Icerik, 0, 250);
    $IcerikOzeti = $Parsedown->text($IcerikOzeti);

    $Icerik = $Parsedown->text($Icerik);  // Makale içeriği html olarak çevriliyor.

    $KontrolResmi = sprintf("img/ozetResim/%04d.jpg", $ID);
    $ResimAdi  = (file_exists($KontrolResmi)) ? $KontrolResmi : "img/makaleResim/aysubey.jpg";

    $Cevap[0] = $DosyaAdi;
    $Cevap[1] = $Baslik;
    $Cevap[2] = $Icerik;
    $Cevap[3] = $Sayac;
    $Cevap[4] = $YazarAdi;
    $Cevap[5] = $YayinTarihi;
    $Cevap[6] = $KategoriLinkleri;
    $Cevap[7] = $Kategoriler;
    $Cevap[8] = $IcerikOzeti;
    $Cevap[9] = $ResimAdi;
    $Cevap[10] = $Durum; // Aktif-Pasif (1-0)

    return $Cevap;                             // Elemanları dışarı çıkartıyoruz.
  }


  function MakalelerdeAra($BUL, $a = 'database/M*.md') {
    $SONUC = "";
    $Dosyalar   = glob($a);             // Klasör içindeki belirtilen dosyaları çekerek Dosyalar değişkenine alır.
    foreach ($Dosyalar as $Dosya) {     // $Dosyalar dizgesindeki her bir dosya adı için bir defa dönerek $Dosya değişkenine aldık.
      $MakaleID   = intval(substr($Dosya, 10, 4)); // 10 karakterden sonraki 4 karakteri alır. Örneğin; 0001 gb.

      $Cevap = MakaleOku($MakaleID);

      $DosyaAdi  = $Cevap[0];
      $Baslik    = $Cevap[1];
      $Icerik    = $Cevap[2];
      $Sayac     = $Cevap[3];
      $YazarAdi  = $Cevap[4];
      $YayinTarihi      = $Cevap[5];
      $KategoriLinkleri = $Cevap[6];
      $Kategoriler      = $Cevap[7];

      $konum = strpos($Icerik, $BUL);
      // echo "$BUL -- $MakaleID -- $konum<br>";
      if(! stripos($Icerik, $BUL) === false) {
        // Aranılan kelime bu makalede var :)
        $SONUC .= "<li><a href='index.php?sayfa=icerik&makele=$Baslik&id=$MakaleID'>$Baslik</a></li>";
      }

    }

    if($SONUC <> "") {
      echo "<h1>Arama Sonucu:</h1>
            <ul>
              $SONUC
            </ul>
            ";
    } else {
       echo "<h1 style='color:red;'>Aranılan ifade bulunamadı...</h1>";
    }

  }

  function MakaleListesiHazirla($a = 'database/M*.md'){

    // Kategoriler klasörünü temizle
    $KategoriDosyalari = glob("kategoriler/*.txt");
    foreach ($KategoriDosyalari as $Dosya) {
      unlink("$Dosya"); // Dosyayı SİL
    }

    $ICERIK = "";
    $ICERIKYONETIM = "";

    $arrKAT_Linki = array();
    $arrKAT_ID = array();

    $c = 0;
    $Dosyalar   = glob($a);             // Klasör içindeki belirtilen dosyaları çekerek Dosyalar değişkenine alır.
    foreach ($Dosyalar as $Dosya) {     // $Dosyalar dizgesindeki her bir dosya adı için bir defa dönerek $Dosya değişkenine aldık.
      $MakaleID   = intval(substr($Dosya, 10, 4)); // 10 karakterden sonraki 4 karakteri alır. Örneğin; 0001 gb.

      $Cevap = MakaleOku($MakaleID);

      $DosyaAdi  = $Cevap[0];
      $Baslik    = $Cevap[1];
      $Icerik    = $Cevap[2];
      $Sayac     = $Cevap[3];
      $YazarAdi  = $Cevap[4];
      $YayinTarihi      = $Cevap[5];
      $KategoriLinkleri = $Cevap[6];
      $Kategoriler      = $Cevap[7]; // Örnek: PHP;CSS;HTML
      $Durum            = $Cevap[10];

      $arrKATs = explode(";", $Kategoriler);
      foreach ($arrKATs as $key => $value) {
        $value = trim($value);
        if($value <> "") {
          $arrKAT_ID["$value"][] = $MakaleID;
          $arrKAT_Linki["$value"][] = "<a href='index.php?sayfa=icerik&makele=$Baslik&id=$MakaleID'>$Baslik</a>";
        }
      }


      $ICERIK  .= "
        <li>
          <a href='?sayfa=icerik&makale=$Baslik&id=$MakaleID'>$Baslik</a>
        </li>";

        if ($Durum == 0) {
          $aktif  = "red";
        } else {
          $aktif  = "green";
        }

      $c++;
      $ICERIKYONETIM .= "<tr>
              <td class='text-center'>$c</td>
              <td>$Baslik</td>
              <td class='text-right'>
                <a >  <i class='fa fa-check-circle' style='color: $aktif !important;'></i></a>&nbsp;&nbsp;
                <a href='index.php?sayfa=icerik&makale=$Baslik&id=$MakaleID' alt='GÖRÜNTÜLE'>  <i class='fa fa-eye'>   </i></a>&nbsp;&nbsp;
                <a href='index.php?sayfa=makaleDuzenle&makale=$Baslik&id=$MakaleID' alt='DÜZENLE'>    <i class='fa fa-edit'>  </i></a>&nbsp;&nbsp;
                <a href='#' alt='SİL'>        <i class='fa fa-trash'> </i></a>&nbsp;&nbsp;&nbsp;</td>
            </tr>";
    } // foreach
    file_put_contents("listeler/makalelistesi.txt", $ICERIK);
    file_put_contents("listeler/makalelistesi.yonetim.txt", $ICERIKYONETIM);

    // Kategori sayfalarının hazırlanması
    foreach ($arrKAT_Linki as $KATEGORI_ADI => $value) {
      $Linkler = implode("</li>\n  <li>", $arrKAT_Linki["$KATEGORI_ADI"]);
      $Linkler = "<ul>\n  <li>$Linkler</li>\n</ul>\n";
      file_put_contents("kategoriler/$KATEGORI_ADI.txt", $Linkler);

      $MakaleAdedi = count($arrKAT_Linki["$KATEGORI_ADI"]);

      $KATEGORI_LISTESI .= "
      <li>
        <a href='index.php?sayfa=kategori&kategoriadi=$KATEGORI_ADI'>
           $KATEGORI_ADI
           <span class='badge badge-success'>$MakaleAdedi</span>
        </a>
      </li>";
    }
    file_put_contents("listeler/kategorilistesi.txt", $KATEGORI_LISTESI);

    foreach ($arrKAT_ID as $KATEGORI_ADI => $value1) {

      $ResimliLinkler = "";
      foreach ($arrKAT_ID[$KATEGORI_ADI] as $key => $MakaleID) {


        $KontrolResmi = sprintf("img/ozetResim/%04d.jpg", $MakaleID);
        $ResimAdi  = (file_exists($KontrolResmi)) ? $KontrolResmi : "img/makaleResim/aysubey.jpg";



        $Cevap = MakaleOku($MakaleID);

        $DosyaAdi         = $Cevap[0];
        $Baslik           = $Cevap[1];
        $Icerik           = $Cevap[2];
        $Sayac            = $Cevap[3];
        $YazarAdi         = $Cevap[4];
        $YayinTarihi      = $Cevap[5];
        $KategoriLinkleri = $Cevap[6];
        $Kategoriler      = $Cevap[7];
        $IcerikOzeti      = $Cevap[8];
        $ResimAdi         = $Cevap[9];
        $Durum            = $Cevap[10];

        $ResimliLinkler .= "<div class='card mb-3 ozet'>
                              <div class='row clearfix'>
                                <div class='col-md-4 ozet_img' title='Makalenin Devamı...'>
                                  <a href='index.php?sayfa=icerik&makele=$Baslik&id=$MakaleID'><img src='$ResimAdi' alt='$Baslik' /></a>
                                </div>
                                <div class='col-md-8'>
                                  <div class='card-body' style='background-color: <?php echo $renk1 ?> !important;'>
                                     $IcerikOzeti
                                     <p align='right'>
                                         <a href='index.php?sayfa=hakkimda'><i class='fas fa-address-card text-success'></i></a>
                                         <span style='font-size:70%;'>
                                         $YazarAdi
                                         </span>&nbsp;&nbsp;&nbsp;
                                         <a href='#'><i class='fas fa-clock text-success'></i></a>
                                         <span style='font-size:70%;'>
                                         $YayinTarihi
                                         </span>&nbsp;&nbsp;&nbsp;
                                         <a href='#'><i class='fas fa-align-justify text-success'></i></a>
                                         <span style='font-size:70%;'>
                                         $KATEGORI_ADI
                                         </span>&nbsp;&nbsp;&nbsp;
                                         <a href='#'><i class='fas fa-align-justify text-success'></i></a>
                                         <span style='font-size:70%;'>
                                         $Durum
                                         </span>&nbsp;&nbsp;&nbsp;
                                         <a class='btn btn-sm btn-outline-success' href='index.php?sayfa=icerik&makele=$Baslik&id=$MakaleID'>
                                             Devamı &nbsp;<i class='fas fa-angle-double-right'></i><i class='fas fa-angle-double-right'></i>
                                         </a>
                                      </p>
                                  </div>
                                </div>
                              </div>
                            </div>";
      } // foreach
      file_put_contents("kategoriler/$KATEGORI_ADI.txt", $ResimliLinkler);
    } // foreach



  } // MakaleListesiHazirla


  function MakaleleriListeleYonetim() {
    if(!file_exists("listeler/makalelistesi.yonetim.txt")) MakaleListesiHazirla();
    echo file_get_contents("listeler/makalelistesi.yonetim.txt");
  }

  function MakaleleriListele() {
    if(!file_exists("listeler/makalelistesi.txt")) MakaleListesiHazirla();
    echo file_get_contents("listeler/makalelistesi.txt");
  }

  function KategorileriListele() {
    if(!file_exists("listeler/kategorilistesi.txt")) MakaleListesiHazirla();
    echo file_get_contents("listeler/kategorilistesi.txt");
  }


?>
