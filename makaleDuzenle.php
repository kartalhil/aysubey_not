<?php

  if(isset($_POST["Editor"])) {
    // Form gönderilmiş. Biz de kaydedelim...
    $DosyaIcerigi = $_POST["Editor"];
    $DosyaAdi = $_POST["dosya_adi"];
    file_put_contents($DosyaAdi, $DosyaIcerigi);

    if($_POST["silme_onayi"] == "SİL") {
      unlink($DosyaAdi); // Dosyayı sil
      $DosyaAdi = sprintf("%04d", $_POST["makale_id"]);
      $DosyaAdi = "database/D$DosyaAdi.md";
      file_put_contents($DosyaAdi, $DosyaIcerigi);
    }

    MakaleListesiHazirla();

    echo "
      <div class='alert alert-success' role='alert'>
        <h1>Güncelleme Başarılı!</h1>
      </div>
      <script>
        setTimeout(function(){ window.location='index.php' }, 3000);
      </script>
    ";
    header("Location:index.php?sayfa=makaleler");
    die();
  }

  $ID = $_GET["id"];
  $DosyaAdi = sprintf("%04d", $ID);
  $DosyaAdi = "database/M$DosyaAdi.md";
  $DosyaIcerigi = file_get_contents($DosyaAdi);
?>
    <div class="ml-3 mt-4">
      <form method="post">
        <label style="color:red; font-weight: bold; font-size:100%;" ><i><?= $DosyaAdi ?> dosyası güncellenecek!!!</i></label>
        <input class="btn btn-sm btn-outline-danger" type="submit" value="Güncellemeleri Kaydet!">
        <textarea class="p-3" name="Editor" id="SME" rows="10" cols="75"><?=$DosyaIcerigi?></textarea>
        <input type="hidden" name="dosya_adi" value="<?=$DosyaAdi?>">
        <input type="hidden" name="makale_id" value="<?=intval($ID)?>">
        <input class="mt-2" type="text" name="silme_onayi" value="" placeholder="Silmek için SİL yazınız...">
      </form>
    </div>
