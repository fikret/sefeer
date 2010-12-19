<?php
/* 
 * İETT'deki tüm durakların adlarını ve durak kodlarını
 * duraklar dosyasına yazdırır.
 */
/*durakları kaydedeceğimiz dosya açılıyor*/
$fp=fopen("/opt/lampp/htdocs/sefeer/raw/duraklar", 'w+') or die("I could not open ");
/*Harf ile başlayan duraklar için harf listesi*/
$letters=array('A');
/*Tek tek her harf için sayfa açılıp o sayfadaki durak adı ve kodu bulunuyor.*/
foreach ($letters as $letter){
    
    $url = "http://www.iett.gov.tr/saat/orer.php?hid=durak&Letter=".$letter;
    $h=file_get_contents($url);
    $regex = '#<a href=orer.php\?hid=durakhat\&durak=(?<durakcode>.*?)\&durakname=(?<durakname>.*?)>#';   //Duzenli deyimimiz. pattern
    preg_match_all($regex, $h, $matches);
    $count=0;
    foreach($matches[0] as $match){

        fwrite($fp,$matches['durakcode'][$count].":".$matches['durakname'][$count]."\n");
        $count++;
    }    
}
fclose($fp);
?>
