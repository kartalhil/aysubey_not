<?php

  @session_start();
  require("_ayarlar.php");

  if(isset($_POST["kullanici"])) {

    if($_POST["kullanici"] == $kullanici and $_POST["parola"] == "$parola") {
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
