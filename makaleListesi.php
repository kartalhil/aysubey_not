<?php
  $arrMakaleler = glob("database/M*.md");               // Başı M ile başlayan md uzantılı dosyaları çektim.

  foreach ($arrMakaleler as $key => $value) {

    $Makale   = $value;
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

    echo "<div class='card mb-3 ozet'>
            <div class='row clearfix'>
              <div class='col-md-4 ozet_img' title='Makalenin Devamı...'>
                <a href='index.php?sayfa=icerik&makele=$Baslik&id=$MakaleID'><img src='$ResimAdi' alt='$Baslik' /></a>
              </div>
              <div class='col-md-8'>
                <div class='card-body'>
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
                      $KategorileriLinkleri
                      </span>&nbsp;&nbsp;&nbsp;
                      <a class='btn btn-sm btn-outline-success' href='index.php?sayfa=icerik&makele=$Baslik&id=$MakaleID'>
                          Devamı &nbsp;<i class='fas fa-angle-double-right'></i><i class='fas fa-angle-double-right'></i>
                      </a>
                   </p>
                </div>
              </div>
            </div>
          </div>";
  } // for
?>
