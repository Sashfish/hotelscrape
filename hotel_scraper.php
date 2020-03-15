<?php
$GLOBALS['site_beginning'] = "https://www.expedia.co.uk/Hotel-Search?adults=2&destination=Aberdeen%2C%20Scotland%2C%20United%20Kingdom&endDate=";
$GLOBALS['site_mid'] = "&latLong=57.123834%2C-2.156496&localDateFormat=d%2FM%2Fyyyy&regionId=278&searchPriorityOverride=213&selected=18926256&semdtl=&sort=PRICE_LOW_TO_HIGH&startDate=";
$GLOBALS['site_end'] = "&theme=&useRewards=true&userIntent";

$hotelname = "Marcliffe Hotel and Spa";//name tied to hotelid
$file = getcwd() . "\scraped.csv";
$current = "";

function scrape($in, $out){
  $url = $GLOBALS['site_beginning'] . $out . $GLOBALS['site_mid'] . $in . $GLOBALS['site_end'];
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_REFERER, $url);
  $html = curl_exec($curl);
  curl_close($curl);
  echo "Scrape complete for {$in} -- {$out}";
  echo "<br>";

  if(preg_match("/We are sold out/", $html)) {$match = ["","N/A"];}
  else {preg_match("/data-stid=\"content-hotel-lead-price\" aria-hidden=\"true\">(.*?\d)<\/span>/", $html, $match);}

  echo $match[1];
  echo "<br>";
  return array("in" => $in, "out" => $out, "price"=> $match[1]);
}

if(isset($_POST['button1'])){
  scrape($_POST['in1'], $_POST['out1']);
  scrape($_POST['in2'], $_POST['out2']);
  scrape($_POST['in3'], $_POST['out3']);
}

if(isset($_POST['button2'])){
  $result1 = scrape($_POST['in1'], $_POST['out1']);
  $result2 = scrape($_POST['in2'], $_POST['out2']);
  $result3 = scrape($_POST['in3'], $_POST['out3']);
  if(!file_exists($file)){
    $current .= "\"Hotel Name\",\"Period\",\"Price\"\n";
    $current .= "\"{$hotelname}\",\"{$result1['in']} - {$result1['out']}\",\"{$result1['price']}\"\n";
    $current .= "\"{$hotelname}\",\"{$result2['in']} - {$result2['out']}\",\"{$result2['price']}\"\n";
    $current .= "\"{$hotelname}\",\"{$result3['in']} - {$result3['out']}\",\"{$result3['price']}\"\n";
    file_put_contents($file, $current);
    $current = "";}
  else{
    $current = file_get_contents($file);
    $current .= "\"{$hotelname}\",\"{$result1['in']} - {$result1['out']}\",\"{$result1['price']}\"\n";
    $current .= "\"{$hotelname}\",\"{$result2['in']} - {$result2['out']}\",\"{$result2['price']}\"\n";
    $current .= "\"{$hotelname}\",\"{$result3['in']} - {$result3['out']}\",\"{$result3['price']}\"\n";
    file_put_contents($file, $current);
    $current = "";}
}
?>

<p>Input the desired date ranges (format: YYYY-MM-DD)</p>
<form method="post">
  <label for="in1">1st In:</label>
  <input type="text" id="in1" name="in1" required>
  <label for="out1">1st Out:</label>
  <input type="text" id="out1" name="out1" required><br>
  <label for="in2">2nd In:</label>
  <input type="text" id="in2" name="in2" required>
  <label for="out2">2nd Out:</label>
  <input type="text" id="out2" name="out2" required><br>
  <label for="in3">3rd In:</label>
  <input type="text" id="in3" name="in3" required>
  <label for="out3">3rd Out:</label>
  <input type="text" id="out3" name="out3" required><br>
  <input type="submit" name="button1" class ="button" value="Scrape">
  <input type="submit" name="button2" class="button" value="Save results to csv">
</form>
