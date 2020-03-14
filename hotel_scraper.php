<?php
$site_beginning = "https://www.expedia.co.uk/Hotel-Search?adults=2&destination=Aberdeen%2C%20Scotland%2C%20United%20Kingdom&endDate=";
$range1 = array("2020-06-02","2020-06-01");
$range2 = array("2020-06-19","2020-06-16");
$range3 = array("2020-06-30","2020-06-25");
$site_mid = "&latLong=57.123834%2C-2.156496&localDateFormat=d%2FM%2Fyyyy&regionId=278&searchPriorityOverride=213&selected=18926256&semdtl=&sort=PRICE_LOW_TO_HIGH&startDate=";
$site_end = "&theme=&useRewards=true&userIntent";

$file = __DIR__ ."/scraped.csv";
$current = "";

$url1 = $site_beginning . $range1[0] . $site_mid . $range1[1] . $site_end;
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');
curl_setopt($curl, CURLOPT_URL, $url1);
curl_setopt($curl, CURLOPT_REFERER, $url1);

$html = curl_exec($curl);
curl_close($curl);
echo "Scrape complete for 01 Jun - 02 Jun";
echo "<br>";
preg_match("/data-stid=\"content-hotel-lead-price\" aria-hidden=\"true\">(.*?\d)<\/span>/", $html, $match1);
echo ($match1[1]);
echo "<br>";

$url2 = $site_beginning . $range2[0] . $site_mid . $range2[1] . $site_end;
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');
curl_setopt($curl, CURLOPT_URL, $url2);
curl_setopt($curl, CURLOPT_REFERER, $url2);

$html = curl_exec($curl);
curl_close($curl);
echo "Scrape complete for 16 Jun - 19 Jun";
echo "<br>";
preg_match("/data-stid=\"content-hotel-lead-price\" aria-hidden=\"true\">(.*?\d)<\/span>/", $html, $match2);
echo ($match2[1]);
echo "<br>";

$url3 = $site_beginning . $range3[0] . $site_mid . $range3[1] . $site_end;
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');
curl_setopt($curl, CURLOPT_URL, $url3);
curl_setopt($curl, CURLOPT_REFERER, $url3);

$html = curl_exec($curl);
curl_close($curl);
echo "Scrape complete for 25 Jun - 30 Jun";
echo "<br>";
preg_match("/data-stid=\"content-hotel-lead-price\" aria-hidden=\"true\">(.*?\d)<\/span>/", $html, $match3);
echo ($match3[1]);
echo "<br>";
?>

<?php
if(isset($_POST['button1'])){
  if(!file_exists($file)){
    $current .= "\"Hotel Name\",\"Period\",\"Price\"\n";
    $current .= "\"Marcliffe Hotel and Spa\",\"1 Jun - 2 Jun\",\"{$match1[1]}\"\n";
    $current .= "\"Marcliffe Hotel and Spa\",\"16 Jun - 19 Jun\",\"{$match2[1]}\"\n";
    $current .= "\"Marcliffe Hotel and Spa\",\"25 Jun - 30 Jun\",\"{$match3[1]}\"\n";
    file_put_contents($file, $current);
    $current = "";}
  //else{
  //  $current = file_get_contents($file);
  //  $current .=
  //  file_put_contents($file, $current);
  //  $current = "";}
}
?>
<form method="post">
<input type="submit" name="button1" class="button" value="Save results to csv" />
