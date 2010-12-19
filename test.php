<?php
/********************/
/* www.phpregex.net dsdenenmekjehfkjhe */
/********************/

/* Geçerli şehir adları */
$sehirler = array('Adana' => 'Adana','Adiyaman' => 'Adıyaman','Afyonkarahisar' => 'Afyonkarahisar','Agri' => 'Ağrı','Aksaray' => 'Aksaray','Amasya' => 'Amasya','Ankara' => 'Ankara','Antalya' => 'Antalya','Ardahan' => 'Ardahan','Artvin' => 'Artvin','Aydin' => 'Aydın','Balikesir' => 'Balıkesir','Bartin' => 'Bartın','Batman' => 'Batman','Bayburt' => 'Bayburt','Bilecik' => 'Bilecik','Bingol' => 'Bingöl','Bitlis' => 'Bitlis','Bolu' => 'Bolu','Burdur' => 'Burdur','Bursa' => 'Bursa','Canakkale' => 'Çanakkale','Cankiri' => 'Çankırı','Corum' => 'Çorum','Denizli' => 'Denizli','Diyarbakir' => 'Diyarbakır','Duzce' => 'Düzce','Edirne' => 'Edirne','Elazig' => 'Elazığ','Erzincan' => 'Erzincan','Erzurum' => 'Erzurum','Eskisehir' => 'Eskişehir','Gaziantep' => 'Gaziantep','Giresun' => 'Giresun','Gumushane' => 'Gümüşhane','Hakkari' => 'Hakkari','Hatay' => 'Hatay','Igdir' => 'Iğdır','Isparta' => 'Isparta','Istanbul' => 'İstanbul','Izmir' => 'İzmir','Kahramanmaras' => 'Kahramanmaraş','Karabuk' => 'Karabük','Karaman' => 'Karaman','Kars' => 'Kars','Kastamonu' => 'Kastamonu','Kayseri' => 'Kayseri','Kirikkale' => 'Kırıkkale','Kirklareli' => 'Kırklareli','Kirsehir' => 'Kırşehir','Kilis' => 'Kilis','Kocaeli' => 'Kocaeli','Konya' => 'Konya','Kutahya' => 'Kütahya','Malatya' => 'Malatya','Manisa' => 'Manisa','Mardin' => 'Mardin','Mersin' => 'Mersin','Mugla' => 'Muğla', 'Mus' => 'Muş', 'Nevsehir' => 'Nevşehir', 'Nigde' => 'Niğde', 'Ordu' => 'Ordu', 'Osmaniye' => 'Osmaniye', 'Rize' => 'Rize', 'Sakarya' => 'Sakarya', 'Samsun' => 'Samsun', 'Siirt' => 'Siirt', 'Sinop' => 'Sinop', 'Sivas' => 'Sivas', 'Sanliurfa' => 'Şanlıurfa', 'Sirnak' => 'Şırnak', 'Tekirdag' => 'Tekirdağ', 'Tokat' => 'Tokat', 'Trabzon' => 'Trabzon', 'Tunceli' => 'Tunceli', 'Usak' => 'Uşak', 'Van' => 'Van', 'Yalova' => 'Yalova', 'Yozgat' => 'Yozgat', 'Zonguldak' => 'Zonguldak');

/* Geçersiz bir şehir girilirse ne yapılacak */
if(!isset($sehirler[$_GET['sehir']]))
	$_GET['sehir'] = 'Bursa';

/* Bilgilerin olduğu sayfayı çekiyoruz ve çektiğimiz veri UTF-8 ama bizim sitemiz :) iso-8859-9 karakter kodlamasını ceviriyoruz */
$icerik = iconv('UTF-8','iso-8859-9',file_get_contents("http://www.meteor.gov.tr/tahmin/il-ve-ilceler.aspx?m={$_GET['sehir']}"));

/* Hava durumu bilgilerini yakalayacak deyimimiz */
$deyim ='#Trh">(?<tarih>.+?)</th>.*?minS">(?<enaz>[0-9\-]{1,3}).*?maxS">(?<encok>[0-9\-]{1,3}).*?title="(?<durum>.+?)" src="(?<resim>.+?)".*?minN">(?<Nenaz>[0-9\-]{1,3}).*?maxN">(?<Nencok>[0-9\-]{1,3})#s';

/* Preg_match_all eşleşmeleri $hdurum dizisi olarak verecek */
preg_match_all($deyim,$icerik,$hdurum,PREG_SET_ORDER);
print_r ($hdurum);

/* Çıktımızı Alıyoruz */
echo '<form action="" method="get">
<select name="sehir">';
  foreach($sehirler as $anahtar => $deger)
  echo '<option value="'.$anahtar.'"'.($_GET['sehir'] == $anahtar ? ' selected="selected"':'').'>'.$deger."</option>\n";
  echo '</select>
<input name="" type="submit" value="Sorgula" />
</form>';
echo '<table border="1" cellpadding="5" cellspacing="0">
<tr>
	<td colspan="6">'.$sehirler[$_GET['sehir']].' için 5 günlük hava tahmini</td>
</tr>
<tr>
	<td>Tarih</td>
	<td>En Düşük</td>
	<td>En Yüksek</td>
	<td>Durum</td>
	<td>Nem En Düşük</td>
	<td>Nem En Yüksek</td>
</tr>';
foreach($hdurum as $hava)
{
	echo '<tr>
	<td>'.$hava['tarih'].'</td>
	<td align="center">'.$hava['enaz'].'</td>
	<td align="center">'.$hava['encok'].'</td>
	<td align="center"><img alt="'.$hava['durum'].'" title="'.$hava['durum'].'" src="http://www.meteor.gov.tr/'.$hava['resim'].'"></td>
	<td align="center">'.$hava['Nencok'].'</td>
	<td align="center">'.$hava['Nenaz'].'</td>
</tr>';
}
echo '</table>';
?>
