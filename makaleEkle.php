<?php

  if(isset($_POST["Editor"])) {
    // Formun Kaydedilmesi istenmiş...

    // Dosya sayısını bulalım
    $Adet = 0;
    $arrDosyalar = glob("database/D*.md");
    $Adet += count($arrDosyalar); // Dosya ismine atamak için dosyaları saydık.

    $arrDosyalar = glob("database/M*.md");
    $Adet += count($arrDosyalar); // Dosya ismine atamak için dosyaları saydık.

    $Adet++; // Yeni dosyanın numarası bulundu :)
    $DosyaAdi = sprintf("%04d", $Adet); // Oluşturulan sayı 4 rakam yapıldı.
    $DosyaAdi = "database/M$DosyaAdi.md"; // 4 rakamın başına M sınunada dosya uzantısı eklendi.
    $DosyaIcerigi = $_POST["Editor"]; // Posttan gelen makale metnini değişkene yüklüyoruz.

    file_put_contents($DosyaAdi, $DosyaIcerigi);

    MakaleListesiHazirla();


    echo "
      <div class='alert alert-success' role='alert'>
        <h1>Kayıt Başarılı!</h1>
      </div>
      <script>
        setTimeout(function(){ window.location='index.php' }, 3000);
      </script>
    ";
    header("Location:index.php?sayfa=makaleler");
    die();
  }

?>

<!--  Form tagına nasıl eklenecek?
      enctype="multipart/form-data"
-->

        <div class="card p-3 mb-2 font-weight-bold warning-color">YENİ MAKALE EKLE</div>
        <div class="card card-body" style="background:#fff9c4;">
          <form method="post">
            <input class="mb-2" type="text" name="YeniAd" value="" placeholder="Yeni Resim Adı...">
            <input class="mb-2" type="file" name="Dosya">
            <input class="mb-2" type="submit" value="Makale Ekle">
            <textarea class="p-3" name="Editor" id="SME"></textarea>
          </form>
        </div>
