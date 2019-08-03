<?php

  @session_start();

  if(isset($_POST["kullanici"])) {

    if($_POST["kullanici"] == "KULLANICIADINIZ" and $_POST["parola"] == "PAROLANIZ") { // DEĞİŞECEKYER
      $_SESSION["GirisYapti"] = 1;
      $_SESSION['goster']     = '';
      $_SESSION['gizle']      = 'd-none';
      header("Location:index.php");
      die();
    } else {
      echo "<h1>HATALI GİRİŞ!</h1>";
      header("Location:index.php");
    }
  }
