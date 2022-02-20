<?php
$ch = curl_init('https://www.unesa.ac.id/page/akademik'); //iniliasisasi url untuk diteruskan curl_setopt
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //untuk mmeberikap options
$page = curl_exec($ch); //eksekusi curl

//DOM START
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($page);
libxml_clear_errors();
$xpath = new DOMXPath($dom);

$data = array();
// get all table rows and rows which are not headers //td[@class='name']/a
$table_rows = $xpath->query('//ul[@class="check"]/li/a');
print_r($table_rows);
foreach ($table_rows as $key) {
    $crutz[] = $key->nodeValue;
}
$crutz_new = array();
for ($i=0; $i <= 7 ; $i++) { //using 7 cuz total of count faculty and deleting school
    array_push($crutz_new, array("0"=>$crutz[$i])); 
}//convert crutz indexed array to multidimensional 
print_r($crutz_new);
?>