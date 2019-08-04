# AYSUBEY NOTLARIM v1.0.0

Denemeden önce mutlaka okuyun.

## KLONLADIKTAN SONRA YAPILACAKLAR!

- Klonladıktan sonra mutlaka ilk yapmanız gereken terminal ekranında dizin içerisine geçerek, "composer update" komutunu göndermek olmalıdır.
- ayarlar.php sayfasından kullanıcı adınız ve parolanızı değiştirin.
- Yönetici olarak girebilmek için; adres çubuğunda index.php den sonra ?giris yazarak sol menüde "login" ekranının görünür olmasını sağlayın.

(Yani: aysubey/index.php?giris)

### Renk Ayarı

img/ klasörününü altında renklendirme işlemi sırasında fikir vermesi açısından yer alan üç adet dosya bulunmaktadır. Yanlış bilgi veriyorsan düzeltirseniz sevinirim;

Örnek;
```php
  //Anlatım kolaylığı için bu şekilde yazdım.
  $renk9      = "hsla(1.parametre, 2.parametre, 3.parametre, 4.parametre)";
  $renk9      = "hsla(25, 80%, 50%, 0.9)";
```

Not: Aşağıdaki konu başlıkları seçim yapabileceğiniz dosyalardır!

- *a_renk_h : 1.parametre renk tonu değerini temsil eder. 0 ile 360 arası değer alır. Resimde ana ve ara renkler verilmiş olsada siz ara derece değerleri ile istediğiniz rengi yakalayabilirsiniz.*
- *a_renk_s : 2.parametre yüzde olarak ifade edilip, renkle karıştırılacak beyazın miktarını temsil eder.*
- *a_renk_l : 3.parametre yüzde olarak ifade edilip, renkle karıştırılacak siyahının miktarını temsil eder.*
- *a_renk_a : 4.parametre değerini bu renk çemberinden seçiyoruz. Saydamlık katmanı ayarlanır. Bu resimde "lightness" okuna dikkat edin. Okun uç bölümü 0.1, tersi ise 0.9 dur. Bu parametreye 0 - 1 arası değer verilir. 0.5 şeffaf hale getirir, ancak renk efekti yine de görünür.*

Site renklerinde belirli bir ahengi yakalamak için ben 4.parametre değerinde verilebilecek tüm değerleri verdim. Burayı değiştirmenize gerek yok. Aslında 1.parametre değerini değiştirip sayfanıza baktığınızda ne demek istediğimi daha iyi anlarsınız. Benim burada amacım sayfa ana başlıklarının koyu, diğer renklerin ise aynı rengin tonlarından oluşmasını bir yere ($hue değişkenine) girerek oluşturmak.

Umarım yanlış tarif etmemişimdir. Deneyerek internet sayfalarından bulabileceğinizden fazla renk elde edebilirsiniz.

# KURALLAR

Blogu ilk kullanmaya başlayacağınız zaman;

- "database" klassörünün altındaki dosyaları silin (Otomatik oluşacaktır).
- Kategorilerin altındaki dosyaları silin (Otomatik oluşacaktır).
- Listeler klasöründe yer alan dosyaların içerisini temizleyin (Otomatik dolacaktır).
- hakkimda.php sayfasını kendinize göre doldurun.
- iletisim.php sayfasını kendinize göre doldurun.

BİTTİ....
Şimdi kullanmaya başlıyabilirsiniz.

## Amaç

Veritabanı kullanmadan yönetilebilir basit bir makale(blog) sitesi yapmak.

TAMAMEN ÜCRETSİZ, KENDİNİZ GELİŞTİREBİLİR, ÇOĞALTABİLİR VE DAĞITABİLİRSİNİZ.

## Proje Adımları ve İş Takibi

***Not: (X) olan yerler bitmiş, (-) olan yerlerde yapılması düşünülmektedir.***

- (X) Material Design Bootstrap (MDB) kullanılacak,
- (X) Herhangi bir veritabanı kullanılmıyacak,
- (X) Sadece her makale için ayrı bir dosya oluşturulacak,
- (X) Oluşturulan dosyalar "MarkDown" olacak,
- (X) Markdown olarak yazılan makaleler html formatına çevrilecek,
- (X) Makalelerin okunma takibi, text dosyası ile yapılacak,
- (X) Anasayfada istediğimiz kadar makaleden özet gösterilebilecek,
- (X) Makale eklemek için yönetici girişi olacak,
- (X) Kullanıcı menüsü olacak,
- (X) Ziyaretçiler giriş ve kullanıcı menüsünü göremeyecek,
- (X) Makale başlıklarından istediğimiz kadarı sol menüde görülebilecek,
- (X) Anasayfa için, her makaleye özgü bir resmi olacak,
- (-) Merkezi olarak renklendirilmesi sağlanacak,
- (-) Makalelere resim eklerken konumlama olayı araştırılacak,
- (-) Projede tekrar eden kodlar "function" olarak kullanılacak.

# EMEĞİ GEÇENLER

- Hasan Çiçek
- Nuri Akman
